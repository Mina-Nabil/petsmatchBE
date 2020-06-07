<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Breed;
use Illuminate\Http\Request;

class BreedsController extends Controller
{
    protected $data;
    protected $homeURL = 'breeds/show/all';

    private function initDataArr($id = -1)
    {
        if ($id != -1 && is_numeric($id))
            $this->data['items'] = Breed::where("BRED_ANML_ID", $id)->get();
        else
            $this->data['items'] = Breed::all();
        $this->data['animals'] = Animal::all();
        $this->data['title'] = "Animals & Breeds";
        $this->data['subTitle'] = "Manage All App Breeds";
        $this->data['cols'] = ['Animal', 'Breed', 'Edit'];
        $this->data['atts'] = [['foreignUrl' => ['animals/edit', 'BRED_ANML_ID', 'animal', 'ANML_NAME']], 'BRED_NAME', ['edit' => ['url' => 'breeds/edit/', 'att' => 'id']]];
        $this->data['homeURL'] = $this->homeURL;
    }

    public function __construct(){
        $this->middleware("auth");
    }

    public function home()
    {
        $this->initDataArr();
        $this->data['formTitle'] = "Add Breeds";
        $this->data['formURL'] = "breeds/insert";
        $this->data['isCancel'] = false;
        $this->data['form2Title'] = "Add Animals";
        $this->data['form2URL'] = "animals/insert";
        $this->data['isCancel2'] = false;
        return view('settings.breeds', $this->data);
    }
    public function editBreed($id)
    {
        $this->initDataArr();
        $this->data['breed'] = Breed::findOrFail($id);
        $this->data['formTitle'] = "Manage Breed (" . $this->data['breed']->BRED_NAME . ")";
        $this->data['formURL'] = "breeds/update";
        $this->data['isCancel'] = true;
        $this->data['form2Title'] = "Add Animals";
        $this->data['form2URL'] = "animals/insert";
        $this->data['isCancel2'] = false;
        return view('settings.breeds', $this->data);
    }

    public function editAnimal($id)
    {
        $this->initDataArr($id);
        $this->data['animal'] = Animal::findOrFail($id);
        $this->data['formTitle'] = "Add Breeds";
        $this->data['formURL'] = "breeds/insert";
        $this->data['isCancel'] = false;
        $this->data['form2Title'] = "Manage Animal (" . $this->data['animal']->ANML_NAME . ")";
        $this->data['form2URL'] = "animals/update";
        $this->data['isCancel2'] = true;
        return view('settings.breeds', $this->data);
    }

    public function insertAnimal(Request $request)
    {

        $request->validate([
            "name" => "required"
        ]);

        $animal = new Animal();
        $animal->ANML_NAME = $request->name;
        $animal->save();
        return redirect($this->homeURL);
    }
    public function insertBreed(Request $request)
    {

        $request->validate([
            "name" => "required",
            "animal" => "required"
        ]);

        $breed = new Breed();
        $breed->BRED_NAME = $request->name;
        $breed->BRED_ANML_ID = $request->animal;
        $breed->save();
        return redirect($this->homeURL);
    }



    public function updateBreed(Request $request)
    {
        $request->validate([
            "name" => "required",
            "animal" => "required",
            "id" => "required",
        ]);

        $breed = Breed::findOrFail($request->id);
        $breed->BRED_NAME = $request->name;
        $breed->BRED_ANML_ID = $request->animal;
        $breed->save();

        return redirect($this->homeURL);
    }


    public function updateAnimal(Request $request)
    {
        $request->validate([
            "name" => "required",
            "id" => "required",
        ]);

        $animal = Animal::findOrFail($request->id);
        $animal->ANML_NAME = $request->name;
        $animal->save();

        return redirect($this->homeURL);
    }
}
