<?php

use Illuminate\Support\Facades\Route;

Route::get('login', 'Auth\LoginController@index');

Route::view('/{path?}', 'Hse.dashboard.index')
     ->where('path', '.*')
     ->name('Hse.dashboard.index');

Route::get('','HomeController@index')->middleware('auth');
Route::get('home', 'HomeController@index')->name('tender.home.index')->middleware('auth');
Route::group(['prefix' => 'inspection'], function(){
  route::get('/', 'InspectionController@inspectionItems')->name('hse.inspection.item');
  route::get('/locations', 'InspectionController@locations')->name('hse.inspection.location');
  route::get('/equipment/categories', 'InspectionController@equipmentCategories')->name('hse.inspection.equipment.categories');
  route::get('/equipments', 'InspectionController@equipments')->name('hse.inspection.equipments');
  route::get('/operators', 'InspectionController@operators')->name('hse.inspection.operators');
  // route::get('/create', 'InspectionController@create')->name('hse.p2h.create');
});

// HSE - Safety Induction
Route::group(['prefix' => 'safetyInduction'], function(){

  route::get('/','safetyInductionController@index2')->name('hse.safetyinduction.index');
  // route::get('/','safetyInductionController@index')->name('hse.safetyinduction.index');
  // route::get('/create', 'safetyInductionController@create')->name('hse.safetyInduction.create');
  route::get('/quesioner', 'safetyInductionController@quesioner')->name('hse.safetyinduction.quesioner');
  route::get('/template', 'safetyInductionController@templateQuesioner')->name('hse.safetyinduction.template');

  // test react on sinduction
  route::get('/create', 'safetyInductionController@create')->name('hse.safetyInduction.create');


  // rest api
  route::get('/jobRoles/{deptId}', 'safetyInductionController@jobRoles');
  route::get('/employeesFromJobRoleId/{jobRoleId}', 'safetyInductionController@employeesFromJobRoleId');
  route::get('/inductions', 'safetyInductionController@inductions');
  route::post('/induction', 'safetyInductionController@create');

});
