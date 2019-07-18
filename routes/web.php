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
	if(session('isLogin')){
       return redirect('admin');
    }
    return view('pages/login');
});

Route::post('auth', 'LoginController@auth');
Route::get('logout', 'LoginController@logout');

// Route::get('asign', 'LoginController@asignRole');

Route::group(['middleware' => ['systemRules:admin']], function () {
    // Route::get('admin', 'AdminController@index');
    Route::resource('admin', 'AdminController');
});

Route::group(['middleware' => ['systemRules:kasir']], function () {
    Route::get('kasir', 'KasirController@index');
});
