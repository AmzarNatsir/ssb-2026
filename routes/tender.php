<?php

use Illuminate\Support\Facades\Route;

Route::get('login','Auth\LoginController@showLoginForm');
Route::post('login', 'Auth\LoginController@login')->name('tender.auth.login');
Route::post('logout', 'Auth\LoginController@logout')->name('tender.auth.logout');

Route::get('','HomeController@index')->middleware('auth');
Route::get('home', 'HomeController@index')->name('tender.home.index')->middleware('auth');

Route::get('/projects/create', ['as' => 'project.create','uses' => 'ProjectController@create']);
Route::get('/project/{projectId}/edit', ['as' => 'project.edit', 'uses' => 'ProjectController@edit']);
Route::get('/project/loadDataTable', 'ProjectController@loadDataTable')->name('Project.loadDataTable');
Route::get('/project/{projectId}/view', ['as' => 'project.view', 'uses' => 'ProjectController@view']);

// aktivasi project & create nomor project
Route::get('/project/{projectId}/aktivasi', ['as' => 'project.aktivasi.form', 'uses' => 'ProjectController@showAktivasiForm']);
Route::post('/project/activation', ['as' => 'project.activation', 'uses' => 'ProjectController@activation' ]);
Route::post('/project/closed', ['as' => 'project.closed', 'uses' => 'ProjectController@closeProject' ]);

// Komite & approval
Route::get('/project/approval', 'ProjectController@approval')->name('Approval.index');
Route::get('/project/loadApprovalDataTable', 'ProjectController@loadApprovalDataTable')->name('Approval.loadApprovalDataTable');
Route::get('/project/cetakApproval/{projectId}', 'ProjectController@cetakApproval')->name('Approval.cetak');
Route::get('/project/load/approval/{projectId}', 'ProjectController@loadFormApproval')->name('Approval.form');
Route::post('/project/approval/save', 'ProjectController@saveApproval')->name('Approval.save');
Route::post('/project/komite/save', 'ProjectController@saveKomite')->name('Komite.save');

Route::get('/project/filter/jabatan/{id_dept?}', 'ProjectController@filterJabatan')->name('filter.jabatan');
Route::get('/project/filter/karyawan/{id_jabt}', 'ProjectController@filterKaryawan')->name('filter.karyawan');
Route::post('/project/komite/order', 'ProjectController@updateKomiteOrder')->name('Komite.update.order');

Route::get('/project/komite', 'KomiteController@index')->name('Komite.index');
Route::get('/project/komite/loadKomiteDataTable','KomiteController@loadDataTable')->name('Komite.loadKomiteDataTable');
Route::get('/project/komite/hapusMember/{memberId}', 'KomiteController@deleteMember')->name('Komite.hapusMember');

Route::get('/project/fulfillment', 'UnitFulfillmentController@index')->name('fulfillment.index');
Route::get('/project/fulfillment/create', 'UnitFulfillmentController@create')->name('fulfillment.create');
Route::get('/project/fulfillment/loadDataTable', 'UnitFulfillmentController@loadDataTable')->name('fulfillment.loadDataTable');
Route::get('/project/fulfillment/loadEquipmentCategoriesFromBoq/{project?}', 'UnitFulfillmentController@loadEquipmentCategoriesFromBoq')->name('fulfillment.loadEquipmentCategoriesFromBoq');
Route::post('/project/fulfillment/save', 'UnitFulfillmentController@save')->name('fulfillment.save');
route::get('/project/fulfillment/{fulfillmentId}/viewaspdf', ['as' => 'fulfillment.viewAsPDF', 'uses' => 'UnitFulfillmentController@viewAsPDF']);

// Form Pengajuan Mutasi
Route::get('/project/mutasi', 'ProjectMutasiController@index')->name('project.mutasi.index');
Route::get('/project/mutasi/form', 'ProjectMutasiController@create')->name('project.mutasi.create');
Route::get('/project/mutasi/loadDataTable', 'ProjectMutasiController@loadDataTable')->name('project.mutasi.loadDataTable');
Route::post('/project/mutasi/save', 'ProjectMutasiController@saveForm')->name('project.mutasi.save');
route::get('/project/mutasi/form/print/{idPengajuanMutasi}', ['as' => 'project.mutasi.cetak_form', 'uses' => 'ProjectMutasiController@printForm']);

// Approval sebelum survey
Route::get('/project/{projectId}/surveyRequestApproval', 'ProjectController@surveyRequestApproval')->name('presurvey.approval');


Route::group(['prefix' => 'komite'], function(){
  route::post('/reorderMember', 'KomiteController@reorderKomiteMember')->name('Komite.reorderMember');
});

// Bill of Quantity
Route::group(['prefix' => 'boq'], function(){
  route::get('/', 'BoqController@index')->name('boq.index');
  route::get('/loadDataTable', 'BoqController@loadDataTable')->name('boq.datatable');
  route::get('/create/{projectId?}', 'BoqController@create')->name('boq.create');
  route::get('/{projectId}/edit', ['as' => 'boq.edit', 'uses' => 'BoqController@edit']);
  route::post('/store', 'BoqController@store')->name('boq.store');
  route::post('/update', 'BoqController@update')->name('boq.update');
  route::post('/delete', 'BoqController@delete')->name('boq.delete');
  route::get('/print/{projectId}', 'BoqController@cetakPDF')->name('boq.print');
});

// Jaminan Pelaksanaan & Penyusunan Dokumen
Route::group(['prefix' => 'bond'], function(){
  route::get('/', 'JampelController@index')->name('bond.index');
  route::get('/loadDataTable', 'JampelController@loadDataTable')->name('bond.datatable');
  // route::get('/create', ['as' => 'bond.create','uses' => 'JampelController@create']);
  Route::get('/{projectId}/create', ['as' => 'bond.create', 'uses' => 'JampelController@create']);
  route::post('/store', ['as' => 'bond.store','uses' => 'JampelController@store']);
});

Route::group(['prefix' => 'auction'], function(){
  route::post('/store', ['as' => 'auction.store', 'uses' => 'JampelController@storeAuction']);
  route::patch('/update', ['as'=> 'auction.update', 'uses' => 'JampelController@updateAuction']);
});


// filterKaryawan
Route::post('/project/assignment/survey', 'ProjectController@approval');
Route::resource(
  '/project',
  'ProjectController'
);

Route::group(['prefix' => 'customer'], function()
{
  route::get('/{id}', 'CustomerController@customer');
  route::get('/', 'CustomerController@index')->name('Tender.project.customer');
  route::get('/list', 'CustomerController@list')->name('Tender.project.customer.list');
  route::post('/simpanCustomer', 'CustomerController@simpan_customer');
});

// Survey
Route::group(['prefix' => 'survey'], function()
{
  route::get('/', ['as'=> 'survey.index', 'uses' => 'SurveyController@index']);
  route::get('/loadDataTable', 'SurveyController@loadDataTable')->name('Survey.loadDataTable');
  route::post('/assignment', 'SurveyController@assignment')->name('Survey.assignment');
  route::post('/saveSurveyResult', 'SurveyController@saveSurveyResult')->name('Survey-result.save');
  route::get('/location/{id}', 'SurveyController@getSurveyLocation')->name('survey.result.location');
  route::post('/create', ['as' => 'survey.store','uses' => 'SurveyController@store']);
  route::patch('/update', ['as' => 'survey.update','uses' => 'SurveyController@update']);
  route::get('/create/{id}', 'SurveyController@create')->name('survey.create');
  route::get('/edit/{id}', 'SurveyController@edit')->name('Survey.edit');

});

Route::resource('/survey', 'SurveyController');

// Master Data
Route::group(['prefix' => 'master'], function()
{
  route::get('/dokumen', 'MasterDataController@dokumen')->name('MasterData.dokumen');
  route::get('/komite', 'MasterDataController@komite')->name('MasterData.komite');
});

// Pre-analyst
Route::group(['prefix' => 'preanalyst'], function()
{

  route::get('/', 'PreAnalystController@index')->name('preanalyst.index');
  route::get('/loadDataTable', 'PreAnalystController@loadDataTable')->name('Project.preanalyst.loadDataTable');
  route::get('/create/{id?}', 'PreAnalystController@create')->name('preanalyst.create');
  route::post('/create', ['as' => 'preanalyst.store','uses' => 'PreAnalystController@store']);
  route::patch('/update', ['as' => 'preanalyst.update','uses' => 'PreAnalystController@update']);
  route::get('/edit/{id}', 'PreAnalystController@edit')->name('preanalyst.edit');

});

// Dokumen
Route::group(['prefix' => 'dokumen'], function()
{
  route::get('/', 'DocumentController@index')->name('document.index');
  route::get('/loadDataTable', 'DocumentController@loadDataTable')->name('document.loadDataTable');
  route::get('/create', 'DocumentController@create')->name('document.create');
  route::get('/{documentId}/edit', 'DocumentController@edit')->name('document.edit');
  route::post('/store', 'DocumentController@store')->name('document.store');
  route::patch('/update', 'DocumentController@update')->name('document.update');
  route::get('/getfixedDocumentByType/{filetypeid?}','DocumentController@getfixedDocumentByType');

});

// HSE
Route::group(['prefix' => 'hse'], function()
{
  route::get('/', 'InspectionController@index')->name('hse.p2h');
  route::get('/loadDataTable', 'InspectionController@loadDataTable')->name('hse.p2h.loadDataTable');
  route::get('/create', 'InspectionController@create')->name('hse.p2h.create');
  route::get('/{inspectionId}/view', ['as' => 'hse.p2h.viewAsPDF', 'uses' => 'InspectionController@viewAsPDF']);
  route::post('/store', 'InspectionController@store')->name('hse.p2h.store');

  // JSON
  route::get('/items', 'InspectionController@inspectionItems')->name('hse.inspection.item');
  route::get('/locations', 'InspectionController@locations')->name('hse.inspection.location');
  route::get('/equipment/categories', 'InspectionController@equipmentCategories')->name('hse.inspection.equipment.categories');
  route::get('/equipments', 'InspectionController@equipments')->name('hse.inspection.equipments');
  route::get('/operators', 'InspectionController@operators')->name('hse.inspection.operators');
  // END JSON
});

// LHO
Route::group(['prefix'=> 'operasional'], function()
{
  route::get('/', 'WorkHourController@index')->name('lho.index');
  route::get('/create', 'WorkHourController@create')->name('lho.create');
  route::get('/{workHourId}/viewaspdf',
    [
      'as' => 'workhour.viewaspdf',
      'uses' => 'WorkHourController@viewAsPDF'
    ]);
  route::post('/save','WorkHourController@saveWorkHour')->name('lho.save');
  route::get('/loadLastHmByEquipment/{projectId?}/{equipmentId?}', 'WorkHourController@loadLastHmByEquipment')->name('lho.loadLastHmByEquipment');
  route::get('/loadOperatorDriver/{projectId?}', 'WorkHourController@loadOperatorDriver')->name('lho.loadOperatorDriver');
  route::get('/loadEquipmentCategory/{projectId?}', 'WorkHourController@loadEquipmentCategory')->name('lho.loadEquipmentCategory');
  route::get('/loadEquipments/{equipmentCategory?}', 'WorkHourController@loadEquipments')->name('lho.loadEquipments');
  route::get('/loadEmployees/{jabatan?}', 'WorkHourController@loadEmployees')->name('lho.loadEmployees');
  route::get('/loadDatatable', 'WorkHourController@loadDatatable')->name('lho.loadDatatable');

});
