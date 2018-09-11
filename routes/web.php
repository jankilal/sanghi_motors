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


Auth::routes();

Route::get('/', 'Admin\DashboardController@index')->name('home');
Route::group(['prefix' => 'admin'], function()
{
	Route::get('/home', 'Admin\DashboardController@index')->name('home');

	//Location
	Route::get('/location', 'Admin\LocationController@index')->name('location');
	Route::get('/load-location-data', 'Admin\LocationController@loadLocationData')->name('load-location-data');
	Route::resource('location', 'Admin\LocationController');
	
	//Dealership
	Route::get('/dealership', 'Admin\DealershipController@index')->name('dealership');
	Route::get('/load-dealership-data', 'Admin\DealershipController@loadDealershipData')->name('load-dealership-data');
	Route::resource('dealership', 'Admin\DealershipController');

	//Employee
	Route::get('/employee', 'Admin\EmployeeController@index')->name('employee');
	Route::get('/load-employee-data', 'Admin\EmployeeController@loadEmployeeData')->name('load-employee-data');
	Route::resource('employee', 'Admin\EmployeeController');

	//LOBussiness
	Route::get('/lobusiness', 'Admin\LOBusinessController@index')->name('lobusiness');
	Route::get('/load-lobusiness-data', 'Admin\LOBusinessController@loadLOBusinessData')->name('load-lobusiness-data');
	Route::resource('lobusiness', 'Admin\LOBusinessController');


	//Designation
	Route::get('/designation', 'Admin\DesignationController@index')->name('designation');
	Route::get('/load-designation-data', 'Admin\DesignationController@loadDesignationData')->name('load-designation-data');
	Route::resource('designation', 'Admin\DesignationController');
});