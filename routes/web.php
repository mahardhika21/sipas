<?php

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

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');


// Route::get('/home',[
// 	"uses"   => "HomeController@index",
// 	"as"     => "web.home"
// ]);

// Route::get('/companies', [
// 	"uses"   => "HomeController@companies",
// 	"as"	 => "web.companies",
// ]);

// Route::get('/employees', [
// 	"uses"   => "HomeController@employees",
// 	"as"     => "web.employees",
// ]);


Route::group(['middleware' => 'auth'], function(){
	Route::get('/home',[
		"uses"   => "HomeController@index",
		"as"     => "web.home"
	]);

	Route::get('/companies', [
		"uses"   => "CrudController@companies_view",
		"as"	 => "web.companies",
	]);

	Route::get('/employees', [
		"uses"   => "CrudController@employees_view",
		"as"     => "web.employees",
	]);

	// crud companies route

	Route::post('crudCompanies/{type}', [
		"uses"  => "CrudController@crudCompanies",
		"as"    => "web.crudCompanies",
	]);


	Route::get('crudCompanies/{type}', [
		"uses"  => "CrudController@crudCompanies",
		"as"    => "web.crudCompanies",
	]);

	Route::delete('crudCompanies/{type}', [
		"uses"  => "CrudController@crudCompanies",
		"as"    => "web.crudCompanies",
	]);





// crud employees route
	Route::post('crudEmployees/{type}', [
		"uses"  => "CrudController@crudEmployees",
		"as"    => "web.crudCompanies",
	]);


	Route::get('crudEmployees/{type}', [
		"uses"  => "CrudController@crudEmployees",
		"as"    => "web.crudCompanies",
	]);


	Route::delete('crudEmployees/{type}', [
		"uses"  => "CrudController@crudEmployees",
		"as"    => "web.crudCompanies",
	]);


 // preview image logo route

	Route::get('diplay_image/{filename}', [
		"uses" => "HomeController@diplay_image",
		"as"   => "web.diplay_image",
    ]);

});



