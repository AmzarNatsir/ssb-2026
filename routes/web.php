<?php

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

Route::get('/', 'Auth\LoginController@showLoginForm')->name('auth.login');
Route::post('/', 'Auth\LoginController@login')->name('auth.do.login');
Route::post('/logout', 'Auth\LoginController@logout')->name('auth.logout');
// Route::get('/', function () {
//     return view('welcome');
// });


// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/home/set-default', 'HomeController@setDefault')->name('home.set-default')->middleware('auth');
