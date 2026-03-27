<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', 'AuthController@login');


// Route::group(['middleware' => 'web'], function(){

    Route::post('/logout', 'AuthController@logout');

    // user & roles
    Route::group(['prefix' => 'user'], function(){
        Route::get('/{user_id}', 'Hse\UserController@user_role');
    });

    // Equipments
    Route::group(['prefix' => 'equipments'], function(){
        Route::get('category', 'Hse\InspectionController@equipmentCategories');
        Route::get('', 'Hse\InspectionController@equipments');
        Route::get('{equipmentCategoryId}', 'Hse\InspectionController@equipmentsByCategory');
    });

    // Inspections (P2H)
    // ini inspection yang lama. yang baru ada dibawah
    Route::group(['prefix'=>'inspection'], function(){
        Route::get('/', 'Hse\InspectionController@index');
        Route::get('items', 'Hse\InspectionController@inspectionItems');
        Route::post('store', 'Hse\InspectionController@store');
        Route::post('template', 'Hse\InspectionController@template');
        Route::get('/pdf/{p2hId}', 'Hse\InspectionController@viewPdf');
    });

    // Ini P2h yang baru
    Route::group(['prefix' => 'p2h'], function(){
        Route::get('/', 'Hse\P2hController@get_all');
        Route::get('/{id}/show', 'Hse\P2hController@show');
        Route::post('/', 'Hse\P2hController@store');
        Route::post('/{id}/update', 'Hse\P2hController@update');
        Route::delete('/{id}/delete', 'Hse\P2hController@delete');
        Route::get('/file/{filename}', 'Hse\P2hController@getFile');
    });

    // Operators
    Route::get('/operators', 'Hse\InspectionController@operators');
    // Karyawan
    Route::get('/karyawan', 'Hse\InspectionController@karyawan');
    // Lokasi project
    Route::get('/locations', 'Hse\InspectionController@locations');

    // Lokasi project (p2h)
    Route::get('/locationsP2h', 'Hse\InspectionController@locationsP2h');
    // Jabatan
    Route::get('/jabatan', 'Hse\InspectionController@jabatan');


    // options
    Route::group(['prefix'=>'opts'], function(){
        Route::get('/karyawan', 'Hse\InspectionController@karyawan');
        Route::get('/apd', 'Hse\ApdController@ApdOptions');
        Route::get('/project', 'Tender\ProjectController@getActiveProjectAsOptions');
        Route::get('/list/departemen', 'Hse\OpsiController@list_departemen');
        Route::get('/list/karyawan/{id_dept}', 'Hse\OpsiController@list_karyawan_by_departemen');
    });

    // safety induction
    Route::group(['prefix'=>'safety-induction'], function(){
        Route::get('/', 'Hse\SafetyInductionController@index');
        Route::get('/{id}', 'Hse\SafetyInductionController@show');
        Route::post('/{id}', 'Hse\SafetyInductionController@update');
        Route::post('store', 'Hse\SafetyInductionController@store');
        Route::get('/file/{filename}', 'Hse\SafetyInductionController@getFile');
        Route::delete('/{id}/delete', 'Hse\SafetyInductionController@delete_safety_induction');
        // Route::get('items', 'Hse\InspectionController@safetyInductionItems');
        // Route::post('template', 'Hse\InspectionController@safetyInductionTemplate');
    });

    // Safety patrol
    Route::group(['prefix'=>'safety-patrol'], function(){
        Route::post('/schedule/store', 'Hse\SafetyPatrolController@store_patrol_schedule');
        Route::get('/schedule/show', 'Hse\SafetyPatrolController@show_schedules');
        Route::get('/schedule/{id}/show', 'Hse\SafetyPatrolController@show');
        Route::post('/schedule/{id}/update', 'Hse\SafetyPatrolController@update');
    });

    // APD
    Route::group([ 'prefix' => 'apd' ], function(){
        Route::get('/index', 'Hse\ApdController@index');
        Route::get('/', 'Hse\ApdController@list_apd');
        Route::post('/insert', 'Hse\ApdController@insert_apd');
        Route::get('/{idApd}', 'Hse\ApdController@getApdById');
        Route::post('/{idApd}', 'Hse\ApdController@updateApd');
        Route::post('/order/store', 'Hse\ApdController@simpan_form_order');
        Route::get('/order/list', 'Hse\ApdController@list_form_order');
        Route::get('/order/{no_order}', 'Hse\ApdController@view_nota_order');
        Route::get('/order/{no_order}/pdf', 'Hse\ApdController@view_pdf_nota_order');
        Route::post('/submit/penilaian', 'Hse\ApdController@submit_penilaian');
        Route::get('/table/score', 'Hse\ApdController@table_score');


        // BAST
        Route::post('/bast/store', 'Hse\ApdController@simpan_bast');
        // TODO : get data bast group by no form registrasi
        Route::get('/bast/list', 'Hse\ApdController@index_apd_keluar');
        Route::get('/bast/{no_register}', 'Hse\ApdController@list_tanda_terima_apd');
        Route::get('/bast/{no_register}/pdf', 'Hse\ApdController@view_pdf_tanda_terima_apd');
        // Route::get('/pdf/{p2hId}', 'Hse\InspectionController@viewPdf');

        // Limbah
    });
    Route::group(['prefix' => 'limbah'], function(){
        Route::get('/', 'Hse\LimbahController@index');
        Route::post('/', 'Hse\LimbahController@tambah_master_limbah');
        Route::post('/update', 'Hse\LimbahController@update_master_limbah');
        Route::get('/unit', 'Hse\LimbahController@get_master_unit_limbah');
        Route::post('/unit', 'Hse\LimbahController@simpan_master_unit_limbah');
        Route::post('/unit/update', 'Hse\LimbahController@update_master_unit_limbah');
        Route::post('/plan', 'Hse\LimbahController@simpan_plan_limbah');
        Route::get('/plan', 'Hse\LimbahController@get_plan_limbah');
        Route::delete('/plan/{id}', 'Hse\limbahController@delete_plan_limbah');
        Route::post('/realisasi', 'Hse\LimbahController@simpan_realisasi_limbah');

        Route::get('/prsh', 'Hse\LimbahController@daftar_perusahaan_angkutan');
        Route::post('/prsh', 'Hse\LimbahController@create_perusahaan_angkutan');
        Route::post('/prsh/{id}', 'Hse\LimbahController@update_perusahaan_angkutan');

        Route::get('/pdf/berita_acara/{id}', 'Hse\LimbahController@view_berita_acara_pengangkutan');

        Route::get('/bap', 'Hse\LimbahController@get_bap_limbah');
        Route::post('/bap', 'Hse\LimbahController@create_bap_limbah');

    });

    Route::group(['prefix' => 'investigasi-kecelakaan'], function(){

        Route::get('/master/kategori/cidera', 'Hse\InvestigasiKecelakaanController@master_kategori_cidera');
        Route::post('/master/kategori/cidera', 'Hse\InvestigasiKecelakaanController@simpan_kategori_cidera');
        Route::patch('/master/kategori/cidera/{id}', 'Hse\InvestigasiKecelakaanController@update_kategori_cidera');

        Route::get('/master/cidera', 'Hse\InvestigasiKecelakaanController@master_cidera');
        Route::post('/master/cidera', 'Hse\InvestigasiKecelakaanController@simpan_master_cidera');
        Route::patch('/master/cidera/{id}', 'Hse\InvestigasiKecelakaanController@update_master_cidera');

        Route::get('/master/jenis/kejadian', 'Hse\InvestigasiKecelakaanController@master_jenis_kejadian');
        Route::post('/master/jenis/kejadian', 'Hse\InvestigasiKecelakaanController@simpan_jenis_kejadian');
        Route::patch('/master/jenis/kejadian/{id}', 'Hse\InvestigasiKecelakaanController@update_jenis_kejadian');

        Route::get('/', 'Hse\InvestigasiKecelakaanController@list_bak');
        Route::get('/{id}/detail', 'Hse\InvestigasiKecelakaanController@view_bak_detail');

        Route::post('/bak', 'Hse\InvestigasiKecelakaanController@simpan_bak');
        Route::patch('/bak/{id}', 'Hse\InvestigasiKecelakaanController@update_bak');
        Route::delete('/bak/delete/{id}', 'Hse\InvestigasiKecelakaanController@delete_bak');

        Route::post('/create', 'Hse\InvestigasiKecelakaanController@create_lap_investigasi');
        Route::get('/{id}/detail', 'Hse\InvestigasiKecelakaanController@detail_lap_investigasi');
        Route::patch('{id}/update', 'Hse\InvestigasiKecelakaanController@update_lap_investigasi');
    });

    Route::group(['prefix' => 'sla'], function(){
        Route::get('/opts/audit-categories', 'Hse\SlaController@show_audit_categories');
        Route::post('/store', 'Hse\SlaController@create_sla');
        Route::patch('/{id}/update', 'Hse\SlaController@update_sla');
        Route::get('/show', 'Hse\SlaController@show_slas');
        Route::get('/{id}/show', 'Hse\SlaController@show_sla_form');
        Route::delete('/{id}/delete', 'Hse\SlaController@delete_sla_form');
        Route::get('/{id}/pdf', 'Hse\SlaController@show_pdf');
    });

// });
