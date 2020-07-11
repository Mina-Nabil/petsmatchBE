<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Vets;
use Illuminate\Http\Request;

class VetsController extends Controller
{

    private $homeURL = "vets/show";

    private function initDataArr($vetID=-1)
    {
        $this->data['items'] = Vets::all();
        $this->data['cities'] = City::all();
        
        if($vetID != -1)
            $this->data['vet'] = Vets::findOrFail($vetID);
            
        $this->data['title'] = "Vets";
        $this->data['subTitle'] = "Manage All Registered Vets";
        $this->data['cols'] = ['UserName', 'Name', 'City', 'Phone' , 'Mail','Edit'];
        $this->data['atts'] = ['VETS_UNAME', 'VETS_NAME', ['foreign' => ['city', 'CITY_NAME']], 'VETS_PHNE', "VETS_MAIL", 
        ['edit' => ['url' => 'vets/edit/', 'att' => 'id']]];
        $this->data['formURL'] = ($vetID == -1) ? url('vets/insert') : url('vets/update');
        $this->data['formTitle'] = ($vetID == -1) ? "Add New Shop" : "Edit ( " . $this->data['vet']->VETS_NAME . " ) info";
        $this->data['isPassNeeded'] = ($vetID == -1) ? true : false;
        $this->data['isCancel'] = ($vetID == -1) ? true : false;
        $this->data['homeURL'] = $this->homeURL;
    }

    public function __construct(){
        $this->middleware("auth");
    }

    public function home($id=-1){
        $this->initDataArr($id);
        return view('vets.home', $this->data);
    }

    public function addPage($id=-1){
        $this->initDataArr($id);
        return view('vets.add', $this->data);
    }

    public function insert(Request $request){
        $request->validate([
            'vetName'  =>  'required',
            'username' =>  'required|unique:vets,VETS_UNAME',
            'password'  =>  'required|min:6',
            'city'  =>  'required|exists:cities,id',
            'mail'  =>  'required|email|unique:vets,VETS_MAIL',
            'phone' =>  'required',
            "uploadedImage" => "nullable|active_url",
            "long" => "nullable|numeric",
            "latt" => "nullable|numeric",
        ]);

        $vet = new Vets();
        $vet->VETS_NAME = $request->vetName;
        $vet->VETS_UNAME = $request->username;
        $vet->VETS_PASS = encrypt($request->pass);
        $vet->VETS_NTID = $request->ntid;
        $vet->VETS_ADRS = $request->address;
        $vet->VETS_MAIL = $request->mail;
        $vet->VETS_PHNE = $request->phone;
        $vet->VETS_CITY_ID = $request->city;
        $vet->VETS_LOCT_LATT = $request->latt;
        $vet->VETS_LOCT_LONG = $request->long;
        if (isset($request->uploadedImage))
        $vet->VETS_IMGE    = $request->uploadedImage;

        $vet->save();
        return redirect($this->homeURL);

    }

    public function update(Request $request){
        $request->validate([
            'id'    => 'required',
            'vetName'  =>  'required',
            'username' =>  'required|unique:vets,VETS_UNAME',
            'city'  =>  'required|exists:cities,id',
            'password'  =>  'nullable|min:6',
            'mail'  =>  'required|email|unique:vets,VETS_MAIL',
            'phone' =>  'required'   ,
            "uploadedImage" => "nullable|active_url",
            "long" => "nullable|numeric",
            "latt" => "nullable|numeric",
        ]);

        $vet = Vets::findOrFail($request->id);
        $vet->VETS_NAME = $request->vetName;
        $vet->VETS_UNAME = $request->username;
        if(isset($request->pass) && $request->pass != "")
        $vet->VETS_PASS = encrypt($request->pass);
        $vet->VETS_NTID = $request->ntid;
        $vet->VETS_ADRS = $request->address;
        $vet->VETS_MAIL = $request->mail;
        $vet->VETS_PHNE = $request->phone;
        $vet->VETS_CITY_ID = $request->city;
        $vet->VETS_LOCT_LATT = $request->latt;
        $vet->VETS_LOCT_LONG = $request->long;

        if (isset($request->uploadedImage))
        $vet->VETS_IMGE    = $request->uploadedImage;

        $vet->save();
        return redirect($this->homeURL);

    }

    
}
