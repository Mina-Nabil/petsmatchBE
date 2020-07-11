<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Shop
Route::get("shops/show", "ShopsController@home");
Route::get("shops/add", "ShopsController@addPage");
Route::get("shops/show/{id}", "ShopsController@addPage");
Route::get("shops/profile/{id}", "ShopsController@profile");
Route::post("shops/update/{id}", "ShopsController@update");
Route::post("shops/insert", "ShopsController@insert");

//Users
Route::get("users/show/all", "UsersController@home");
Route::get("users/show/{id}", "UsersController@home");
Route::get("users/profile/{id}", "UsersController@profile");
Route::get("users/add", "UsersController@add");
Route::get("users/edit/{id}", "UsersController@edit");
Route::post("users/update/{id}", "UsersController@update");
Route::post("users/insert", "UsersController@insert");

//Breeds
Route::get("breeds/show/all", 'BreedsController@home');
Route::post("animals/show/{id}", 'BreedsController@home');
Route::get("breeds/edit/{id}", 'BreedsController@editBreed');
Route::post("breeds/insert", 'BreedsController@insertBreed');
Route::post("breeds/update", 'BreedsController@updateBreed');
Route::get("animals/edit/{id}", 'BreedsController@editAnimal');
Route::post("animals/insert", 'BreedsController@insertAnimal');
Route::post("animals/update", 'BreedsController@updateAnimal');

//Cities
Route::get("cities/show/all", 'CitiesController@home');
Route::get("cities/edit/{id}", 'CitiesController@editCity');
Route::post("cities/insert", 'CitiesController@insertCity');
Route::post("cities/update", 'CitiesController@updateCity');
Route::get("countries/edit/{id}", 'CitiesController@editCountry');
Route::post("countries/insert", 'CitiesController@insertCountry');
Route::post("countries/update", 'CitiesController@updateCountry');

//Dashboard users
Route::get("dash/users/all", 'DashUsersController@index');
Route::post("dash/users/insert", 'DashUsersController@insert');
Route::get("dash/users/edit/{id}", 'DashUsersController@edit');
Route::post("dash/users/update", 'DashUsersController@update');


Route::get('logout', 'HomeController@logout')->name('logout');
Route::get('/login', 'HomeController@login')->name('login');
Route::post('/login', 'HomeController@authenticate')->name('login');
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/', 'HomeController@index')->name('home')->middleware('auth');
