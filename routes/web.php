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
	Route::get('/location', 'Admin\LocationController@index')->name('location');
	Route::get('/load-location-data', 'Admin\LocationController@loadLocationData')->name('load-location-data');
	Route::resource('/location', 'Admin\LocationController');
});