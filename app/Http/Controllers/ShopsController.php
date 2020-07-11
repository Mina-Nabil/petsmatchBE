<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Shops;
use Illuminate\Http\Request;

class ShopsController extends Controller
{

    private $homeURL = "shops/show";

    private function initDataArr($shopID=-1)
    {
        $this->data['items'] = Shops::all();
        $this->data['cities'] = City::all();
        
        if($shopID != -1)
            $this->data['shop'] = Shops::findOrFail($shopID);
            
        $this->data['title'] = "Shops";
        $this->data['subTitle'] = "Manage All Registered Shops";
        $this->data['cols'] = ['UserName', 'Name', 'City', 'Phone' , 'Mail','Edit'];
        $this->data['atts'] = ['SHOP_UNAME', 'SHOP_NAME', ['foreign' => ['city', 'CITY_NAME']], 'SHOP_PHNE', "SHOP_MAIL", 
        ['edit' => ['url' => 'shops/edit/', 'att' => 'id']]];
        $this->data['formURL'] = ($shopID == -1) ? url('shops/insert') : url('shups/update');
        $this->data['formTitle'] = ($shopID == -1) ? "Add New Shop" : "Edit ( " . $this->data['shop']->SHOP_NAME . " ) info";
        $this->data['isPassNeeded'] = ($shopID == -1) ? true : false;
        $this->data['isCancel'] = ($shopID == -1) ? true : false;
        $this->data['homeURL'] = $this->homeURL;
    }

    public function __construct(){
        $this->middleware("auth");
    }

    public function home($id=-1){
        $this->initDataArr($id);
        return view('shops.home', $this->data);
    }

    public function addPage($id=-1){
        $this->initDataArr($id);
        return view('shops.add', $this->data);
    }

    public function insert(Request $request){
        $request->validate([
            'shopName'  =>  'required',
            'username' =>  'required|unique:shops,SHOP_UNAME',
            'password'  =>  'required|min:6',
            'city'  =>  'required|exists:cities,id',
            'mail'  =>  'required|email|unique:shops,SHOP_MAIL',
            'phone' =>  'required',
            "uploadedImage" => "nullable|active_url",
            "long" => "nullable|numeric",
            "latt" => "nullable|numeric",
        ]);

        $shop = new Shops();
        $shop->SHOP_NAME = $request->shopName;
        $shop->SHOP_UNAME = $request->username;
        $shop->SHOP_PASS = encrypt($request->pass);
        $shop->SHOP_NTID = $request->ntid;
        $shop->SHOP_ADRS = $request->address;
        $shop->SHOP_MAIL = $request->mail;
        $shop->SHOP_PHNE = $request->phone;
        $shop->SHOP_CITY_ID = $request->city;
        $shop->SHOP_LOCT_LATT = $request->latt;
        $shop->SHOP_LOCT_LONG = $request->long;
        if (isset($request->uploadedImage))
        $shop->SHOP_IMGE    = $request->uploadedImage;

        $shop->save();
        redirect($this->homeURL);

    }

    public function update(Request $request){
        $request->validate([
            'id'    => 'required',
            'shopName'  =>  'required',
            'username' =>  'required|unique:shops,SHOP_UNAME',
            'city'  =>  'required|exists:cities,id',
            'password'  =>  'nullable|min:6',
            'mail'  =>  'required|email|unique:shops,SHOP_MAIL',
            'phone' =>  'required'   ,
            "uploadedImage" => "nullable|active_url",
            "long" => "nullable|numeric",
            "latt" => "nullable|numeric",
        ]);

        $shop = Shops::findOrFail($request->id);
        $shop->SHOP_NAME = $request->shopName;
        $shop->SHOP_UNAME = $request->username;
        if(isset($request->pass) && $request->pass != "")
        $shop->SHOP_PASS = encrypt($request->pass);
        $shop->SHOP_NTID = $request->ntid;
        $shop->SHOP_ADRS = $request->address;
        $shop->SHOP_MAIL = $request->mail;
        $shop->SHOP_PHNE = $request->phone;
        $shop->SHOP_CITY_ID = $request->city;
        $shop->SHOP_LOCT_LATT = $request->latt;
        $shop->SHOP_LOCT_LONG = $request->long;

        if (isset($request->uploadedImage))
        $shop->SHOP_IMGE    = $request->uploadedImage;

        $shop->save();
        redirect($this->homeURL);

    }

    
}
