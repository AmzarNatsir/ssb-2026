<?php

use Illuminate\Support\Facades\Route;

Route::get('login', 'Auth\LoginController@showLoginForm');
Route::post('login', 'Auth\LoginController@login')->name('warehouse.auth.login');
Route::post('logout', 'Auth\LoginController@logout')->name('warehouse.auth.logout');

Route::get('', 'HomeController@index');
Route::get('home', 'HomeController@index')->name('warehouse.home.index');
Route::get('read', 'HomeController@readNotifications')->name('warehouse.home.read_notifications');
// Master data group route
Route::group(['prefix' => 'master-data', 'namespace' => 'MasterData', 'middleware' => 'auth'], function () {


});
//End Of Master data group route




