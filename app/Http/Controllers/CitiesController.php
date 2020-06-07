<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

use App\Models\Country;

class CitiesController extends Controller
{
    protected $data;
    protected $homeURL = 'cities/show/all';

    private function initDataArr()
    {
        $this->data['items'] = City::all();
        $this->data['countries'] = Country::all();
        $this->data['title'] = "Countries & Cities";
        $this->data['subTitle'] = "Manage All App Locations";
        $this->data['cols'] = ['Country', 'City', 'Edit'];
        $this->data['atts'] = [ ['foreignUrl' => ['countries/edit', 'CITY_CNTR_ID', 'country', 'CNTR_NAME']], 'CITY_NAME', ['edit' => ['url' => 'cities/edit/', 'att' => 'id']]];
        $this->data['homeURL'] = $this->homeURL;
    }

    public function __construct(){
        $this->middleware("auth");
    }

    public function home(){
        $this->initDataArr();
        $this->data['formTitle'] = "Add Cities";
        $this->data['formURL'] = "cities/insert";
        $this->data['isCancel'] = false;
        $this->data['form2Title'] = "Add Countries";
        $this->data['form2URL'] = "countries/insert";
        $this->data['isCancel2'] = false;
        return view('settings.cities', $this->data);
    }

    public function editCity($id){
        $this->initDataArr();
        $this->data['city'] = City::findOrFail($id);
        $this->data['formTitle'] = "Manage City (" . $this->data['city']->CITY_NAME . ")";
        $this->data['formURL'] = "cities/update";
        $this->data['isCancel'] = true;
        $this->data['form2Title'] = "Add Countries";
        $this->data['form2URL'] = "countries/insert";
        $this->data['isCancel2'] = false;
        return view('settings.cities', $this->data);
    }

    public function editCountry($id){
        $this->initDataArr();
        $this->data['country'] = Country::findOrFail($id);
        $this->data['formTitle'] = "Add Cities";
        $this->data['formURL'] = "cities/insert";
        $this->data['isCancel'] = false;
        $this->data['form2Title'] = "Manage Country (" . $this->data['country']->CNTR_NAME . ")";
        $this->data['form2URL'] = "countries/update";
        $this->data['isCancel2'] = true;
        return view('settings.cities', $this->data);
    }

    public function insertCountry(Request $request){

        $request->validate([
            "name" => "required"
        ]);

        $country = new Country();
        $country->CNTR_NAME = $request->name;
        $country->save();
        return redirect($this->homeURL);
    }
    public function insertCity(Request $request){

        $request->validate([
            "name" => "required",
            "country" => "required"
        ]);

        $city = new City();
        $city->CITY_NAME = $request->name;
        $city->CITY_CNTR_ID = $request->country;
        $city->save();
        return redirect($this->homeURL);
    }



    public function updateCity(Request $request){
        $request->validate([
            "name" => "required",
            "country" => "required",
            "id" => "required",
        ]);

        $city = City::findOrFail($request->id);
        $city->CITY_NAME = $request->name;
        $city->CITY_CNTR_ID = $request->country;
        $city->save();
        
        return redirect($this->homeURL);
    }


    public function updateCountry(Request $request){
        $request->validate([
            "name" => "required",
            "id" => "required",
        ]);

        $country = Country::findOrFail($request->id);
        $country->CNTR_NAME = $request->name;
        $country->save();

        return redirect($this->homeURL);
    }
}
