<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Trainer;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    protected $data;
    protected $homeURL = "users/show/all";

    public function __construct()
    {
        $this->middleware("auth");
    }

    private function initHomeArr($type = -1)
    {
        if ($type == 1 || $type == 2) {
            $this->data['items'] = User::with('type')->where("USER_USTP_ID", $type)->get();
        } else {
            $this->data['items'] = User::with('type')->get();
        }
        if ($type == 1)
            $this->data['title'] = "Pet Owners Only";
        elseif ($type == 2)
            $this->data['title'] = "Pet Owners Only";
        else
            $this->data['title'] = "All Mobile App Users";

        $this->data['subTitle'] = "Manage Application Users";
        $this->data['cols'] = ['id', 'User', 'FullName', 'Email', 'Mob#', 'Birth Date', 'Role', 'Edit'];
        $this->data['atts'] = [
            'id',
            ['url' => ['user/profile/', "att" =>  "USER_NAME"]],
            'USER_FLNM',
            'USER_MAIL',
            'USER_MOBN',
            ['date' => ['format' => 'Y-m-d', 'att' => 'USER_BRDT']],
            [
                'state' => [
                    "classes" => [
                        "1" => "label-info",
                        "2" => "label-danger",
                    ],
                    "att" =>  "USER_USTP_ID",
                    "rel" => "type",
                    'foreignAtt' => "USTP_NAME",
                ]
            ],
            ['edit' => ['url' => 'users/edit/', 'att' => 'id']]
        ];
        $this->data['homeURL'] = $this->homeURL;
    }

    private function initAddArr($userID = -1)
    {
        if ($userID != -1) {
            $this->data['user'] = User::with("trainer")->findOrFail($userID);
            $this->data['formURL'] = "users/update/" . $userID;
        } else {
            $this->data['formURL'] = "users/insert/";
        }
        $this->data['cities'] = City::all();
        $this->data['types']  = UserType::all();
        $this->data['formTitle'] = "Add New User";
        $this->data['isCancel'] = true;
        $this->data['homeURL'] = $this->homeURL;
    }

    public function home($type = -1)
    {
        $this->initHomeArr($type);
        return view("users.home", $this->data);
    }

    public function add()
    {
        $this->initAddArr();
        return view("users.add", $this->data);
    }

    public function edit($id)
    {
        $this->initAddArr($id);
        return view("users.add", $this->data);
    }

    public function insert(Request $request)
    {
        $request->validate([
            "name"          => "required|unique:users,USER_NAME",
            "pass"          => "required|between:6,24",
            "fullName"      => "required",
            "bdate"         => "required|date",
            "mob"           => "required|numeric",
            "mail"          => "required|email|unique:users,USER_MAIL",
            "type"          => "required|exists:user_types,id",
            "city"          => "required|exists:cities,id",
            "uploadedImage" => "nullable|active_url"
        ]);
        DB::transaction(function () use ($request) {
            $user = new User();
            $user->USER_NAME = $request->name;
            $user->USER_PASS = $request->pass;
            $user->USER_MOBN = $request->mob;
            $user->USER_FLNM = $request->fullName;
            $user->USER_BRDT = $request->bdate;
            $user->USER_MAIL = $request->mail;
            $user->USER_USTP_ID = $request->type;
            $user->USER_CITY_ID = $request->city;
            $user->USER_IMGE    = $request->uploadedImage;

            $user->save();

            if (isset($user->id) && $user->USER_USTP_ID == 2) { //trainer
                $trainer = new Trainer();
                $trainer->TRNR_USER_ID = $user->id;
                $trainer->TRNR_XPYR = $request->trainerExp ?? 0;
                $trainer->TRNR_ORGN = $request->trainerOrgn;
                $trainer->TRNR_ABUT = $request->trainerAbout;
                $trainer->save();
            }
        });
        return redirect($this->homeURL);
    }

    public function update($id, Request $request)
    {
        $user = User::findOrFail($id);
        $request->validate([
            "name"          => ["required",  Rule::unique('users', "USER_NAME")->ignore($user->USER_NAME, "USER_NAME"),],
            "pass"          => "nullable|between:6,24",
            "fullName"      => "required",
            "bdate"         => "required|date",
            "mob"           => "required|numeric",
            "mail"          => ["required", "email",  Rule::unique('users', "USER_MAIL")->ignore($user->USER_MAIL, "USER_MAIL"),],
            "type"          => "required|exists:user_types,id",
            "city"          => "required|exists:cities,id",
            "uploadedImage" => "nullable|active_url"
        ]);
        DB::transaction(function () use ($request, $user, $id) {
            $user->USER_NAME = $request->name;
            if (isset($request->pass))
                $user->USER_PASS = $request->pass;
            $user->USER_MOBN = $request->mob;
            $user->USER_FLNM = $request->fullName;
            $user->USER_BRDT = $request->bdate;
            $user->USER_MAIL = $request->mail;
            $user->USER_USTP_ID = $request->type;
            $user->USER_CITY_ID = $request->city;
            if (isset($request->uploadedImage))
                $user->USER_IMGE    = $request->uploadedImage;

            $user->save();
            if (isset($user->id) && $user->USER_USTP_ID == 2) { //trainer
                $trainer = Trainer::firstWhere("TRNR_USER_ID", $id);
                $trainer->TRNR_XPYR = $request->trainerExp ?? 0;
                $trainer->TRNR_ORGN = $request->trainerOrgn;
                $trainer->TRNR_ABUT = $request->trainerAbout;
                $trainer->save();
            }
        });
        return redirect($this->homeURL);
    }
}
