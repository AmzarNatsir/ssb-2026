<?php

use App\Http\Controllers\Hrd\BonusController;
use App\Http\Controllers\Hrd\SetupController;
use App\Http\Controllers\Hrd\ThrController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function(){
    if (Auth::check()) {
        return redirect('hrd/home');
    }

    Route::get('/','Hrd\Auth\LoginController@index');
    // return redirect('hrd/auth/login');
});

Route::group(['prefix' => 'auth'], function(){
    Route::get('login', 'Hrd\Auth\LoginController@showLoginForm');
    Route::post('login', 'Hrd\Auth\LoginController@login')->name('hrd.auth.login');
    Route::post('logout', 'Hrd\Auth\LoginController@logout')->name('hrd.auth.logout');

});

//Route::get('/','Hrd\Auth\LoginController@index');
//Route::get('/','Hrd\Auth\LoginController@index');

Route::group(['middleware' => 'auth'], function()
{
    Auth::routes();
    Route::get('', 'Hrd\HomeController@utama');
    Route::get('home', 'Hrd\HomeController@index');
    Route::get('home/getPelatihan/{filter}', 'Hrd\HomeController@getPelatihan');

    Route::get('dashboard', 'Hrd\DashboardController@index');
    Route::get('profil_user', 'Hrd\SetupController@profil_user');
    Route::put('profil_user_update', 'Hrd\SetupController@profil_user_update');
    //Jobdesc
    Route::get('jobdesc', 'Hrd\JobDescController@index');
    Route::get('jobdesc/data/{departemen}', 'Hrd\JobDescController@data');
    //KPI
    Route::group(['prefix' => 'kpi'], function() {
        Route::get('penyusunan', 'Hrd\KpiController@index');
        Route::get('getKPI/{departemen}/{tahun}/{bulan}', 'Hrd\KpiController@getKPI');
        Route::post('storeKPIDepartemen', 'Hrd\KpiController@storeKPIDepartemen');
        //Peniliaian
        Route::get('penilaian', 'Hrd\KpiController@penilaian');
        Route::get('formPenilaian/{id}', 'Hrd\KpiController@form_penilaian');
        Route::post('storePenilaianKPIDepartemen', 'Hrd\KpiController@storePenilaianKPIDepartemen');
        Route::get('formUploadLampiranKPI/{id}', 'Hrd\KpiController@formUploadLampiran');
        Route::post('storeUploadLampiranKPI', 'Hrd\KpiController@storeLampiran');
        Route::get('deleteLampiranKPI/{id}', 'Hrd\KpiController@deleteLampiranKPI');
        //Detail KPI
        Route::get('detailKPI/{id_kpi}', 'Hrd\KpiController@showDetail');
        Route::get('kpiPeriodik/{id}', 'Hrd\KpiController@kpiPeriodik');
        //download lampiran data pendukung
        Route::get('downloadLampiranKPI/{id}', 'Hrd\KpiController@downloadLampiranKPI');

    });
    Route::group(['prefix' => 'dataku'], function() {
        //cuti
        Route::get('cuti_izin', 'Hrd\DatakuController@cuti_izin');
        Route::get('getCutiIzin/{bulan}/{tahun}', 'Hrd\DatakuController@get_cuti_izin');
        Route::get('formPengajuanCuti', 'Hrd\DatakuController@form_cuti');
        Route::post('pengajuanCutiStore', 'Hrd\DatakuController@store_pengajuan_cuti');
        Route::get('formEditPengajuanCuti/{id}', 'Hrd\DatakuController@form_cuti_edit');
        Route::put('pengajuanCutiUpdate/{id}', 'Hrd\DatakuController@update_pengajuan_cuti');
        Route::get('formDetailPengajuanCuti/{id}', 'Hrd\DatakuController@detail_pengajuan_cuti');
        Route::put('pengajuanCutiCancel/{id}', 'Hrd\DatakuController@form_cuti_cancel');
        //izin
        Route::get('formPengajuanIzin', 'Hrd\DatakuController@form_izin');
        Route::get('getIzin/{bulan}/{tahun}', 'Hrd\DatakuController@get_izin');
        Route::post('pengajuanIzinStore', 'Hrd\DatakuController@store_pengajuan_izin');
        Route::get('formEditPengajuanIzin/{id}', 'Hrd\DatakuController@form_cuti_izin');
        Route::put('pengajuanIzinUpdate/{id}', 'Hrd\DatakuController@update_pengajuan_izin');
        Route::get('formDetailPengajuanIzin/{id}', 'Hrd\DatakuController@detail_pengajuan_izin');
        Route::put('pengajuanIzinCancel/{id}', 'Hrd\DatakuController@form_izin_cancel');
        //absensi
        Route::get('absensi', 'Hrd\DatakuController@absensi');
        Route::post('getAbsensi', 'Hrd\DatakuController@get_absensi');
        Route::get('loadAbsensi', 'Hrd\DatakuController@loadAbsensi');
        //perjalanan dinas
        Route::get('perjalananDinas', 'Hrd\DatakuController@perjalanan_dinas');
        Route::post('getDataPerjalananDinas', 'Hrd\DatakuController@get_perjalanan_dinas');
        Route::get('detailPerdis/{id}', 'Hrd\DatakuController@get_detail_perjalanan_dinas');
        Route::get('uploadDokumenPerdis/{id}', 'Hrd\DatakuController@upload_dokumen_perdis');
        Route::post('storeUploadDokumenPerdis', 'Hrd\DatakuController@upload_dokumen_perdis_store');
        Route::post('updateRealisasiBiayaPerdis', 'Hrd\DatakuController@update_realisasi_biaya_perdis');
        //lembur
        Route::get('lembur', 'Hrd\DatakuController@lembur');
        Route::get('getListLembur/{bulan}/{tahun}', 'Hrd\DatakuController@get_lembur');
        Route::get('formPengajuanLembur', 'Hrd\DatakuController@lembur_form');
        Route::post('pengajuanLemburStore', 'Hrd\DatakuController@lembur_form_store');
        //surat peringatan
        Route::get('suratPeringatan', 'Hrd\DatakuController@surat_peringatan');
        Route::get('getListSuratPeringatan/{bulan}/{tahun}', 'Hrd\DatakuController@get_surat_peringatan');
        Route::get('detailSP/{id}', 'Hrd\DatakuController@detail_sp');
        //pengajuan pinjaman
        Route::get('pinjamanKaryawan', 'Hrd\DatakuController@pinjamanKaryawan');
        Route::get('getListPengajuan', 'Hrd\DatakuController@getListPengajuan');
        Route::get('pengajuanPinjaman', 'Hrd\DatakuController@pengajuanPinjaman');
        Route::post('pengajuanPinjamanStore', 'Hrd\DatakuController@pengajuanPinjamanStore');
        Route::get('pinjamanKaryawan/mutasi/{id}', 'Hrd\DatakuController@mutasiPinjamanKaryawan');
        //payroll
        Route::get('payroll', 'Hrd\DatakuController@payroll');
        Route::get('getListPayroll/{tahun}', 'Hrd\DatakuController@getListPayroll');
        Route::get('detailPayroll/{id}', 'Hrd\DatakuController@detailPayroll');
        //pelatihan
        Route::get('pelatihan', 'Hrd\DatakuController@pelatihan');
        Route::get('getDataPelatihan/{bulan}/{tahun}', 'Hrd\DatakuController@data_pelatihan');
        Route::get('detailPelatihan/{id}', 'Hrd\DatakuController@detail_pelatihan');
        Route::get('editPelatihan/{id}', 'Hrd\DatakuController@edit_pelatihan');
        Route::post('updatePelatihan', 'Hrd\DatakuController@update_pelatihan');
        Route::get('detailPascaPelatihan/{id}', 'Hrd\DatakuController@detail_pasca_pelatihan');
        //resign
        Route::get('resign', 'Hrd\DatakuController@resign');
        Route::get('formPengajuanResign', 'Hrd\DatakuController@form_resign');
        Route::post('pengajuanResignStore', 'Hrd\DatakuController@store_pengajuan_resign');
        Route::get('formEditPengajuanResign/{id}', 'Hrd\DatakuController@form_edit_resign');
        Route::put('pengajuanResignUpdate/{id}', 'Hrd\DatakuController@update_pengajuan_resign');
        Route::get('formCancelPengajuanResign/{id}', 'Hrd\DatakuController@form_cancel_resign');
        Route::put('pengajuanResignCancel/{id}', 'Hrd\DatakuController@form_pengajuan_cancel_resign');
        Route::get('formDetailPengajuanResign/{id}', 'Hrd\DatakuController@form_detail_resign');
        Route::get('formExitInterviewsResign/{id}', 'Hrd\DatakuController@form_exit_interviews_resign');
        Route::post('pengajuanExitInterviewsStore', 'Hrd\DatakuController@store_pengajuan_exit_interviews');
        Route::get('formEditExitInterviewsResign/{id}', 'Hrd\DatakuController@form_edit_exit_interviews_resign');
        Route::put('pengajuanExitInterviewsUpdate/{id}', 'Hrd\DatakuController@update_exit_interviews_resign');

        Route::get('resign/showPdf/{id}', 'Hrd\DatakuController@showPdfSuratResign');
    });
    Route::group(['prefix'=>'masterdata'], function()
    {
        //master profil perusahaan
        route::get('profilperusahaan', 'Hrd\MasterDataController@profil_perusahaan');
        route::post('profilperusahaan/simpan', 'Hrd\MasterDataController@simpan_profil_perusahaan');
        //master level jabatan
        route::get('leveljabatan', 'Hrd\MasterDataController@level_jabatan');
        route::post('leveljabatan/simpan', 'Hrd\MasterDataController@simpan_level_jabatan');
        route::get('leveljabatan/edit/{id}', 'Hrd\MasterDataController@edit_level_jabatan');
        route::put('leveljabatan/update/{id}', 'Hrd\MasterDataController@update_level_jabatan');
        route::get('leveljabatan/hapus/{id}', 'Hrd\MasterDataController@hapus_level_jabatan');
        Route::get("leveljabatan/excel", 'Hrd\MasterDataController@excellLevel')->name("ExportLevelJabatan");
        //master departemen
        route::get('departemen', 'Hrd\MasterDataController@departemen');
        route::post('departemen/simpan', 'Hrd\MasterDataController@simpan_departemen');
        route::get('departemen/edit/{id}', 'Hrd\MasterDataController@edit_departemen');
        route::put('departemen/update/{id}', 'Hrd\MasterDataController@update_departemen');
        route::get('departemen/hapus/{id}', 'Hrd\MasterDataController@hapus_departemen');
        Route::get("departemen/excel", 'Hrd\MasterDataController@exceldepartemen')->name("ExportDepartemen");
        //master sub departemen
        route::get('subdepartemen', 'Hrd\MasterDataController@sub_departemen');
        route::get("subdepartemen/loaddepartement/{id}", "Hrd\MasterDataController@load_departement");
        route::post('subdepartemen/simpan', 'Hrd\MasterDataController@simpan_subdepartemen');
        route::get('subdepartemen/edit/{id}', 'Hrd\MasterDataController@edit_subdepartemen');
        route::put('subdepartemen/update/{id}', 'Hrd\MasterDataController@update_subdepartemen');
        route::get('subdepartemen/hapus/{id}', 'Hrd\MasterDataController@hapus_subdepartemen');
        Route::get("subdepartemen/excel", 'Hrd\MasterDataController@excelsubdepartemen')->name("ExportSubDepartemen");
        //master jabatan
        route::get('jabatan', 'Hrd\MasterDataController@jabatan');
        Route::get('jabatan/add', 'Hrd\MasterDataController@add_jabatan');
        route::post('jabatan/simpan', 'Hrd\MasterDataController@simpan_jabatan');
        route::get('jabatan/loadsubdepartement/{id}', 'Hrd\MasterDataController@load_subdepartement');
        route::get('jabatan/loadjabatangakom/{id}', 'Hrd\MasterDataController@load_jabatan_gakom');
        route::get('jabatan/edit/{id}', 'Hrd\MasterDataController@edit_jabatan');
        Route::get('jabatan/jobdesc/download/{id}', 'Hrd\MasterDataController@download_jobdesc');

        route::put('jabatan/update/{id}', 'Hrd\MasterDataController@update_jabatan');
        route::get('jabatan/hapus/{id}', 'Hrd\MasterDataController@hapus_jabatan');
        Route::get("jabatan/excel", 'Hrd\MasterDataController@exceljabatan')->name("ExportJabatan");
        Route::get('jabatan/editAll', 'Hrd\MasterDataController@edit_all_departemen');
        Route::get('jabatan/filter_jabatan/{id}', 'Hrd\MasterDataController@filter_jabatan');
        Route::post('jabatan/updateJabatanAll', 'Hrd\MasterDataController@update_jabatan_all_dept');
        //master Status Karyawan
        route::get('statuskaryawan', 'Hrd\MasterDataController@status_karyawan');
        route::post('statuskaryawan/simpan', 'Hrd\MasterDataController@simpan_status_karyawan');
        route::get('statuskaryawan/edit/{id}', 'Hrd\MasterDataController@edit_status_karyawan');
        route::put('statuskaryawan/update/{id}', 'Hrd\MasterDataController@update_status_karyawan');
        route::get('statuskaryawan/hapus/{id}', 'Hrd\MasterDataController@hapus_status_karyawan');
        //master jenis cuti izin
        route::get('jeniscutiizin', 'Hrd\MasterDataController@jenis_cuti_izin');
        route::post('jeniscutiizin/simpan', 'Hrd\MasterDataController@simpan_jenis_cuti_izin');
        route::get('jeniscutiizin/edit/{id}', 'Hrd\MasterDataController@edit_jenis_cuti_izin');
        route::put('jeniscutiizin/update/{id}', 'Hrd\MasterDataController@update_jenis_cuti_izn');
        route::get('jeniscutiizin/hapus/{id}', 'Hrd\MasterDataController@hapus_jenis_cuti_izin');
        //master divisi
        route::get('divisi', 'Hrd\MasterDataController@divisi');
        route::post('divisi/simpan', 'Hrd\MasterDataController@simpan_divisi');
        route::get('divisi/edit/{id}', 'Hrd\MasterDataController@edit_divisi');
        route::put('divisi/update/{id}', 'Hrd\MasterDataController@update_divisi');
        route::get('divisi/hapus/{id}', 'Hrd\MasterDataController@hapus_divisi');
        Route::get("divisi/excel", 'Hrd\MasterDataController@exceldivisi')->name("ExportDivisi");
        //master perdis fasilitas
        route::get('perdis/fasilitas', 'Hrd\MasterDataController@perdis_fasilitas');
        route::post('perdis/fasilitas/simpan', 'Hrd\MasterDataController@simpan_perdis_fasilitas');
        route::get('perdis/fasilitas/edit/{id}', 'Hrd\MasterDataController@edit_perdis_fasilitas');
        route::put('perdis/fasilitas/update/{id}', 'Hrd\MasterDataController@update_perdis_fasilitas');
        route::get('perdis/fasilitas/hapus/{id}', 'Hrd\MasterDataController@hapus_perdis_fasilitas');
        //master perdis uang saku
        route::get('perdis/uangsaku', 'Hrd\MasterDataController@perdis_uang_saku');
        route::post('perdis/uangsaku/simpan', 'Hrd\MasterDataController@simpan_perdis_uang_saku');
        route::get('perdis/uangsaku/edit/{id}', 'Hrd\MasterDataController@edit_perdis_uang_saku');
        route::put('perdis/uangsaku/update/{id}', 'Hrd\MasterDataController@update_perdis_uang_saku');
        route::get('perdis/uangsaku/hapus/{id}', 'Hrd\MasterDataController@hapus_perdis_uang_saku');
        //master jenis sp
        route::get('jenissp', 'Hrd\MasterDataController@jenis_sp');
        route::post('jenissp/simpan', 'Hrd\MasterDataController@simpan_jenis_sp');
        route::get('jenissp/edit/{id}', 'Hrd\MasterDataController@edit_jenis_sp');
        route::put('jenissp/update/{id}', 'Hrd\MasterDataController@update_jenis_sp');
        route::get('jenissp/hapus/{id}', 'Hrd\MasterDataController@hapus_jenis_sp');
        //master kategori penggajian
        route::get('kategoripenggajian', 'Hrd\MasterDataController@kategori_penggajian');
        route::post('kategoripenggajian/simpan', 'Hrd\MasterDataController@simpan_kategori_penggajian');
        route::get('kategoripenggajian/edit/{id}', 'Hrd\MasterDataController@edit_kategori_penggajian');
        route::put('kategoripenggajian/update/{id}', 'Hrd\MasterDataController@update_kategori_penggajian');
        route::get('kategoripenggajian/hapus/{id}', 'Hrd\MasterDataController@hapus_kategori_penggajian');
        //master Daftar Bank
        route::get('bankpenggajian', 'Hrd\MasterDataController@bank_penggajian');
        route::post('bankpenggajian/simpan', 'Hrd\MasterDataController@simpan_bank_penggajian');
        route::get('bankpenggajian/edit/{id}', 'Hrd\MasterDataController@edit_bank_penggajian');
        route::put('bankpenggajian/update/{id}', 'Hrd\MasterDataController@update_bank_penggajian');
        route::get('bankpenggajian/hapus/{id}', 'Hrd\MasterDataController@hapus_bank_penggajian');
        //master jenis dokumen karyawan
        route::get('dokumenkaryawan', 'Hrd\MasterDataController@dokumen_karyawan');
        route::post('dokumenkaryawan/simpan', 'Hrd\MasterDataController@simpan_dokumen_karyawan');
        route::get('dokumenkaryawan/edit/{id}', 'Hrd\MasterDataController@edit_dokumen_karyawan');
        route::put('dokumenkaryawan/update/{id}', 'Hrd\MasterDataController@update_dokumen_karyawan');
        route::get('dokumenkaryawan/hapus/{id}', 'Hrd\MasterDataController@hapus_dokumen_karyawan');
        //Master Lembaga Pelaksana Diklat
        route::get('pelaksana_diklat', 'Hrd\MasterDataController@pelaksana_diklat');
        route::post('pelaksana_diklat/simpan', 'Hrd\MasterDataController@simpan_pelaksana_diklat');
        route::get('pelaksana_diklat/edit/{id}', 'Hrd\MasterDataController@edit_pelaksana_diklat');
        route::put('pelaksana_diklat/update/{id}', 'Hrd\MasterDataController@update_pelaksana_diklat');
        route::get('pelaksana_diklat/hapus/{id}', 'Hrd\MasterDataController@hapus_pelaksana_diklat');
        //master potongan gaji
        route::get('potongan_gaji', 'Hrd\MasterDataController@potongan_gaji');
        route::post('potongan_gaji/simpan', 'Hrd\MasterDataController@simpan_potongan_gaji');
        route::get('potongan_gaji/edit/{id}', 'Hrd\MasterDataController@edit_potongan_gaji');
        route::put('potongan_gaji/update/{id}', 'Hrd\MasterDataController@update_potongan_gaji');
        route::get('potongan_gaji/hapus/{id}', 'Hrd\MasterDataController@hapus_potongan_gaji');

        //master pelatihan baru (2022-04-24)
        route::get('pelatihan', 'Hrd\MasterDataController@pelatihan');
        route::post('pelatihan/simpan', 'Hrd\MasterDataController@simpan_pelatihan');
        route::get('pelatihan/edit/{id}', 'Hrd\MasterDataController@edit_pelatihan');
        route::put('pelatihan/update/{id}', 'Hrd\MasterDataController@update_pelatihan');
        route::get('pelatihan/hapus/{id}', 'Hrd\MasterDataController@hapus_pelatihan');

         //master jenis pelanggaran baru (2023-12-12)
         route::get('jenisPelanggaran', 'Hrd\MasterDataController@jenis_pelanggaran');
         route::post('jenisPelanggaran/simpan', 'Hrd\MasterDataController@simpan_jenis_pelanggaran');
         route::get('jenisPelanggaran/edit/{id}', 'Hrd\MasterDataController@edit_jenis_pelanggaran');
         route::put('jenisPelanggaran/update/{id}', 'Hrd\MasterDataController@update_jenis_pelanggaran');
         route::get('jenisPelanggaran/hapus/{id}', 'Hrd\MasterDataController@hapus_jenis_pelanggaran');

         //Master KPI
         //Bobot
        Route::get('perspektifKPI', 'Hrd\MasterDataController@perspektifKPI');
        Route::post('perspektifKPI/simpan', 'Hrd\MasterDataController@perspektifKPISimpan');
        Route::get('perspektifKPI/edit/{id}', 'Hrd\MasterDataController@perspektifKPIEdit');
        Route::put('perspektifKPI/update/{id}', 'Hrd\MasterDataController@perspektifKPIUpdate');
        Route::get('perspektifKPI/hapus/{id}', 'Hrd\MasterDataController@perspektifKPIHapus');

        //Sasaran strategi
        Route::get('sasaranKPI', 'Hrd\MasterDataController@sasaranKPI');
        Route::post('sasaranKPI/simpan', 'Hrd\MasterDataController@sasaranKPISimpan');
        Route::get('sasaranKPI/edit/{id}', 'Hrd\MasterDataController@sasaranKPIEdit');
        Route::put('sasaranKPI/update/{id}', 'Hrd\MasterDataController@sasaranKPIUpdate');
        Route::get('sasaranKPI/hapus/{id}', 'Hrd\MasterDataController@sasaranKPIHapus');

        //Tipe
        Route::get('tipeKPI', 'Hrd\MasterDataController@tipeKPI');
        Route::post('tipeKPI/simpan', 'Hrd\MasterDataController@tipeKPISimpan');
        Route::get('tipeKPI/edit/{id}', 'Hrd\MasterDataController@tipeKPIEdit');
        Route::put('tipeKPI/update/{id}', 'Hrd\MasterDataController@tipeKPIUpdate');
        Route::get('tipeKPI/hapus/{id}', 'Hrd\MasterDataController@tipeKPIHapus');

        //Satuan
        Route::get('satuanKPI', 'Hrd\MasterDataController@satuanKPI');
        Route::post('satuanKPI/simpan', 'Hrd\MasterDataController@satuanKPISimpan');
        Route::get('satuanKPI/edit/{id}', 'Hrd\MasterDataController@satuanKPIEdit');
        Route::put('satuanKPI/update/{id}', 'Hrd\MasterDataController@satuanKPIUpdate');
        Route::get('satuanKPI/hapus/{id}', 'Hrd\MasterDataController@satuanKPIHapus');

        //status tanggungan
        Route::get('statusTanggungan', 'Hrd\MasterDataController@statusTanggungan');
        Route::post('statusTanggungan/simpan', 'Hrd\MasterDataController@statusTanggunganSimpan');
        Route::get('statusTanggungan/edit/{id}', 'Hrd\MasterDataController@statusTanggunganEdit');
        Route::put('statusTanggungan/update/{id}', 'Hrd\MasterDataController@statusTanggunganUpdate');
        Route::get('statusTanggungan/hapus/{id}', 'Hrd\MasterDataController@statusTanggunganHapus');
    });
    //Modul Setup
    Route::group(['prefix' => 'setup'], function()
    {
        //hari libur
        route::get('harilibur', 'Hrd\SetupController@hari_libur');
        route::post('harilibur/simpan', 'Hrd\SetupController@simpan_hari_libur');
        route::get('harilibur/edit/{id}', 'Hrd\SetupController@edit_hari_libur');
        route::put('harilibur/update/{id}', 'Hrd\SetupController@update_hari_libur');
        route::get('harilibur/hapus/{id}', 'Hrd\SetupController@hapus_hari_libur');
        //pengaturan persetujuan/approval pengajuan
        route::get('persetujuan', 'Hrd\SetupController@persetujuan');
        Route::get('persetujuan/form_pengaturan/{id}', 'Hrd\SetupController@persetujuan_form');
        route::post('simpanpengaturanpersetujuan', 'Hrd\SetupController@simpan_pengaturan_persetujuan');
        //manajemen user
        //menu/permission
        route::get("manajemenmenu/tambah", "Hrd\SetupController@tambah_menu");
        route::post("manajemenmenu/simpan", "Hrd\SetupController@simpan_menu");
        //group/role

        route::get('manajemengroup', 'Hrd\SetupController@manajemen_group_utama');
        Route::get('manajemengroup/add', 'Hrd\SetupController@manajemen_group_add');
        route::post('manajemengroup/simpan', 'Hrd\SetupController@simpan_group');
        route::get('manajemengroup/edit/{id}', 'Hrd\SetupController@edit_group');
        route::put('manajemengroup/update/{id}', 'Hrd\SetupController@update_group');
        route::get('manajemengroup/hapus/{id}', 'Hrd\SetupController@delete_group');
        //pengguna
        route::get('manajemenpengguna', 'Hrd\SetupController@manajemen_pengguna');
        Route::get('manajemenpengguna/add', 'Hrd\SetupController@add_roles_pengguna');
        Route::post('manajemenpengguna/simpan', 'Hrd\SetupController@simpan_roles_pengguna');
        route::get('manajemenpengguna/edit/{id}', 'Hrd\SetupController@edit_roles_pengguna');
        route::put('manajemenpengguna/update/{id}', 'Hrd\SetupController@update_roles_pengguna');
        route::get('manajemenpengguna/hapus/{id}', 'Hrd\SetupController@delete_roels_pengguna');
        //Memo Internal
        route::get('memointernal', 'Hrd\MemoInternalController@index');
        route::post('memointernal/simpan', 'Hrd\MemoInternalController@simpan');
        route::get('memointernal/edit/{id}', 'Hrd\MemoInternalController@edit');
        route::put('memointernal/update/{id}', 'Hrd\MemoInternalController@update');
        route::get('memointernal/hapus/{id}', 'Hrd\MemoInternalController@delete');
        //Pengaturan Gaji Pokok
        route::get('manajemengapok', 'Hrd\SetupController@manajemen_gapok');
        route::post('manajemengapok/tampilkangapok', 'Hrd\SetupController@tampilkan_karyawan_gapok');
        route::post('manajemengapok/simpangapok', 'Hrd\SetupController@manajemen_gapok_simpan');
        //import gapok
        Route::get('manajemengapok/import', 'Hrd\SetupController@manajemen_gapok_import');
        Route::get('manajemengapok/downloadtemplateGapok', 'Hrd\SetupController@manajemen_gapok_download_template');
        Route::post('manajemengapok/doImportGapok', 'Hrd\SetupController@manajemen_gapok_do_import');
        //pengaturan persentase bpjs ketenagakerjaan
        route::get('manajemenbpjs', 'Hrd\SetupController@manajemen_bpjs');
        route::post('manajemenbpjs/simpanbpjs', 'Hrd\SetupController@manajemen_bpjs_simpan');

        //manajemen potongan gaji karyawan
        route::get('manajemenpot', 'Hrd\SetupController@manajemen_potongan_gaji');
        route::post('manajemenpot/tampilkanpotongangaji', 'Hrd\SetupController@tampilkan_karyawan_potongan_gaji');
        route::get('manajemenpot/forminputpotonggaji/{id_karyawan}', 'Hrd\SetupController@form_karyawan_potongan_gaji');
        route::post('manajemenpot/simpanpotonggaji/{id_karyawan}', 'Hrd\SetupController@manajemen_potongan_simpan');
        route::put('manajemenpot/updatepotonggaji/{id_karyawan}', 'Hrd\SetupController@manajemen_potongan_update');

        //norma psikotest
        Route::get('norma_psikotest', 'Hrd\SetupController@norma_psikotest');
        Route::post('norma_psikotest/simpan', 'Hrd\SetupController@norma_psikotest_simpan');
        Route::get('norma_psikotest/edit/{id}', 'Hrd\SetupController@norma_psikotest_edit');
        Route::put('norma_psikotest/update/{id}', 'Hrd\SetupController@norma_psikotest_update');
        Route::get('norma_psikotest/hapus/{id}', 'Hrd\SetupController@norma_psikotest_hapus');
        Route::post('norma_psikotest/getHasil', 'Hrd\SetupController@get_hasil')->name('setup.norma_psikotest.getHasil');

        //matriks pkwt
        Route::get('matriks_pkwt', [SetupController::class, 'matriks_pkwt'])->name('matriks_pkwt');
        Route::post('get_matriks_pkwt', [SetupController::class, 'getDataMatriksPkwt']);
        Route::get('get_list_matriks_pkwt/{output}', [SetupController::class, 'getListMatriks']);
        Route::post('store_matriks_pkwt', [SetupController::class, 'store_matriks_pkwt']);

        //matriks persetujuan
        Route::get('matriks_persetujuan', [SetupController::class, 'matriks_persetujuan']);
        Route::get('matriks_persetujuan_setup/{id}', [SetupController::class, 'matriks_persetujuan_setup']);
        Route::get('matriks_persetujuan_setup_load_form/{group}/{dept}', [SetupController::class, 'getDataMatriks']);
        Route::post('matriks_persetujuan_setup_store', [SetupController::class, 'matriks_persetujuan_setup_store']);
        Route::get('matriks_persetujuan_setup_delete/{id}', [SetupController::class, 'matriks_persetujuan_setup_delete']);
        //pengaturan kpi departemen
        Route::get('kpi', [SetupController::class, 'kpi_list']); //'Hrd\KpiController@index');
        Route::get('kpi_list/{departemen}', [SetupController::class, 'kpi_departemen']); // 'Hrd\KpiController@data');
        Route::get('kpi_baru/{id}', [SetupController::class, 'kpi_departemen_baru']); // 'Hrd\KpiController@baru');
        Route::post('kpi_simpan', [SetupController::class, 'kpi_departemen_simpan']); // 'Hrd\KpiController@simpan');
        Route::get('kpi_edit/{id}', [SetupController::class, 'kpi_departemen_edit']); // 'Hrd\KpiController@edit');
        Route::put('kpi_update/{id}', [SetupController::class, 'kpi_departemen_update']); // 'Hrd\KpiController@update');
        Route::get('kpi_hapus/{id}', [SetupController::class, 'kpi_departemen_hapus']); // 'Hrd\KpiController@hapus');
    });
    //Modul recruitment
    Route::group(['prefix' => 'recruitment'], function()
    {
        //list pengajuan tk adm
        Route::get('daftar_pengajuan_tenaga_kerja', 'Hrd\RecruitmentController@pengajuan_tenaga_kerja_adm');
        Route::post('daftar_pengajuan_tenaga_kerja/data', 'Hrd\RecruitmentController@data_pengajuan_tenaga_kerja_adm');
        //new
        Route::get('list_pengajuan_tk_departemen/{id}', 'Hrd\RecruitmentController@list_pengajuan_tk_departemen');
        Route::get('detail_pengajuan_tenaga_kerja/{id}', 'Hrd\RecruitmentController@detail_pengajuan_tenaga_kerja_adm');
        Route::get('print_pengajuan_tenaga_kerja/{id}', 'Hrd\RecruitmentController@print_pengajuan_tenaga_kerja_adm');


        //pengajuan tenaga kerja
        Route::get('pengajuan_tenaga_kerja', 'Hrd\RecruitmentController@pengajuan_tenaga_kerja');
        Route::get('pengajuan_tenaga_kerja/baru', 'Hrd\RecruitmentController@pengajuan_tenaga_kerja_baru');
        Route::post('pengajuan_tenaga_kerja/store', 'Hrd\RecruitmentController@pengajuan_tenaga_kerja_store');
        Route::get('pengajuan_tenaga_kerja/edit/{id}', 'Hrd\RecruitmentController@pengajuan_tenaga_kerja_edit');
        Route::put('pengajuan_tenaga_kerja/update/{id}', 'Hrd\RecruitmentController@pengajuan_tenaga_kerja_update');
        Route::get('pengajuan_tenaga_kerja/delete/{id}', 'Hrd\RecruitmentController@pengajuan_tenaga_kerja_delete');

        //Detail
        Route::get('pengajuan_tenaga_kerja/persetujuan_detail/{id}', 'Hrd\RecruitmentController@persetujuan_pengajuan_tenaga_kerja_detail');

        //Aplikasi Pelamar
        Route::get('aplikasi_pelamar', 'Hrd\RecruitmentController@index');
        Route::post('aplikasi_pelamar/data', 'Hrd\RecruitmentController@data');

        //baru
        Route::get('aplikasi_pelamar/baru', 'Hrd\RecruitmentController@baru');
        Route::get('aplikasi_pelamar/list_kebutuhan_tk/{id_dept}', 'Hrd\RecruitmentController@list_kebutuhan_tk');
        Route::get('aplikasi_pelamar/rekap_hasil_tes_per_kebutuhan/{id}', 'Hrd\RecruitmentController@rekap_hasil_tes_per_kebutuhan');

        // Route::get('aplikasi_pelamar/profil', 'Hrd\RecruitmentController@pelamar_profil');
        Route::get('aplikasi_pelamar/profil/{id}', 'Hrd\RecruitmentController@pelamar_profil');
        Route::post('aplikasi_pelamar/profil/checkID', 'Hrd\RecruitmentController@checkID');
        Route::post('aplikasi_pelamar/profil/simpan', 'Hrd\RecruitmentController@pelamar_profil_simpan');
        Route::get('aplikasi_pelamar/data_lain/{id}', 'Hrd\RecruitmentController@pelamar_data_lain');
        //data latar belakang keluarga
        Route::get('aplikasi_pelamar/frm_lb_keluarga/{id}', 'Hrd\RecruitmentController@latar_belakang_keluarga');
        Route::post('aplikasi_pelamar/frm_lb_keluarga/simpan', 'Hrd\RecruitmentController@latar_belakang_keluarga_simpan');
        Route::get('aplikasi_pelamar/frm_lb_keluarga/edit/{id}', 'Hrd\RecruitmentController@latar_belakang_keluarga_edit')->name("editDataLBKeluarga");
        Route::put("aplikasi_pelamar/frm_lb_keluarga/update/{id}", 'Hrd\RecruitmentController@latar_belakang_keluarga_update')->name("updateDataLBKeluarga");
        Route::get("aplikasi_pelamar/latar_belakang_keluarga_delete/{id}", "Hrd\RecruitmentController@latar_belakang_keluarga_delete")->name("deleteDataLBKeluarga");
        //data keluarga jika sudah menikah
        Route::get('aplikasi_pelamar/frm_keluarga/{id}', 'Hrd\RecruitmentController@keluarga')->name("addKeluarga");
        Route::post('aplikasi_pelamar/frm_keluarga/simpan', 'Hrd\RecruitmentController@keluarga_simpan')->name("insertKeluarga");
        Route::get('aplikasi_pelamar/frm_keluarga/edit/{id}', 'Hrd\RecruitmentController@keluarga_edit')->name("editKeluarga");
        Route::put("aplikasi_pelamar/frm_keluarga/update/{id}", 'Hrd\RecruitmentController@keluarga_update')->name("updateKeluarga");
        Route::get("aplikasi_pelamar/frm_keluarga/delete/{id}", "Hrd\RecruitmentController@keluarga_delete")->name("deleteKeluarga");
        //Data Riwayat Pendidikan
        Route::get('aplikasi_pelamar/frm_pendidikan/{id}', 'Hrd\RecruitmentController@riwayat_pendidikan')->name("addPendidikan");
        Route::post('aplikasi_pelamar/frm_pendidikan/simpan', 'Hrd\RecruitmentController@riwayat_pendidikan_simpan')->name("insertPendidikan");
        Route::get('aplikasi_pelamar/frm_pendidikan/edit/{id}', 'Hrd\RecruitmentController@riwayat_pendidikan_edit')->name("editPendidikan");
        Route::put("aplikasi_pelamar/frm_pendidikan/update/{id}", 'Hrd\RecruitmentController@riwayat_pendidikan_update')->name("updatePendidikan");
        Route::get("aplikasi_pelamar/frm_pendidikan/delete/{id}", "Hrd\RecruitmentController@riwayat_pendidikan_delete")->name("deletePendidikan");
        //pengalaman organisasi
        Route::get('aplikasi_pelamar/frm_organisasi/{id}', 'Hrd\RecruitmentController@pengalaman_organisasi')->name("addOrganisasi");
        Route::post('aplikasi_pelamar/frm_organisasi/simpan', 'Hrd\RecruitmentController@pengalaman_organisasi_simpan')->name("insertOrganisasi");
        Route::get('aplikasi_pelamar/frm_organisasi/edit/{id}', 'Hrd\RecruitmentController@pengalaman_organisasi_edit')->name("editOrganisasi");
        Route::put("aplikasi_pelamar/frm_organisasi/update/{id}", 'Hrd\RecruitmentController@pengalaman_organisasi_update')->name("updateOrganisasi");
        Route::get("aplikasi_pelamar/frm_organisasi/delete/{id}", "Hrd\RecruitmentController@pengalaman_organisasi_delete")->name("deleteOrganisasi");
        //pengalaman kerja
        Route::get('aplikasi_pelamar/frm_pekerjaan/{id}', 'Hrd\RecruitmentController@pengalaman_kerja')->name("addPekerjaan");
        Route::post('aplikasi_pelamar/frm_pekerjaan/simpan', 'Hrd\RecruitmentController@pengalaman_kerja_simpan')->name("insertPekerjaan");
        Route::get('aplikasi_pelamar/frm_pekerjaan/edit/{id}', 'Hrd\RecruitmentController@pengalaman_kerja_edit')->name("editPekerjaan");
        Route::put("aplikasi_pelamar/frm_pekerjaan/update/{id}", 'Hrd\RecruitmentController@pengalaman_kerja_update')->name("updatePekerjaan");
        Route::get("aplikasi_pelamar/frm_pekerjaan/delete/{id}", "Hrd\RecruitmentController@pengalaman_kerja_delete")->name("deletePekerjaan");
        //dokumen pelamar
        Route::get('aplikasi_pelamar/frm_dokumen/{id}', 'Hrd\RecruitmentController@dokumen')->name("listDokumen");
        Route::get('aplikasi_pelamar/frm_dokumen_baru/{id_dok}/{id_pelamar}', 'Hrd\RecruitmentController@dokumen_tambah')->name('addDokumen');
        Route::post('aplikasi_pelamar/frm_dokumen_simpan', 'Hrd\RecruitmentController@dokumen_simpan')->name('insertDokumen');
        Route::get('aplikasi_pelamar/frm_dokumen_edit/{id_dok}/{id_pelamar}', 'Hrd\RecruitmentController@dokumen_edit')->name('editDokumen');
        Route::put('aplikasi_pelamar/frm_dokumen_update/{id_dok_pelamar}', 'Hrd\RecruitmentController@dokumen_update')->name('updateDokumen');
        Route::get('aplikasi_pelamar/frm_dokumen_delete/{id_dok_pelamar}', 'Hrd\RecruitmentController@dokumen_destroy')->name('deleteDokumen');

        //proses recr to employee
        Route::get('proses_menjadi_karyawan/{id_pelamar}', 'Hrd\RecruitmentController@recr_to_karyawan');
        Route::post('proses_menjadi_karyawan/store', 'Hrd\RecruitmentController@recr_to_karyawan_store')->name('simpanRecrtoEmployee');

        //Surat Pengantar Penempatan
        Route::get('surat_pkwt/{id}', 'Hrd\RecruitmentController@surat_pkwt');
        Route::get('surat_pengantar_penempatan/{id}', 'Hrd\RecruitmentController@surat_pengantar_penempatan');
        Route::get('surat_pengantar_safety_induction/{id}', 'Hrd\RecruitmentController@surat_pengantar_safety_induction');

        //rekap hasil tes
        Route::get('rekap_hasil_tes', 'Hrd\RecruitmentController@rekap_hasil_tes');
        Route::post('rekap_hasil_tes/data', 'Hrd\RecruitmentController@rekap_hasil_tes_data');
        Route::get('rekap_hasil_tes/print/{dep}/{jab}', 'Hrd\RecruitmentController@rekap_hasil_tes_print');
        Route::get('rekap_hasil_tes/excel/{dep}/{jab}', 'Hrd\RecruitmentController@rekap_hasil_tes_excel');

        //close/open
        Route::get('closeApp/{id}', 'Hrd\RecruitmentController@close_app');
        Route::get('openApp/{id}', 'Hrd\RecruitmentController@open_app');
        //submit app
        Route::get('aplikasi_pelamar/submit_app/{id}', 'Hrd\RecruitmentController@submit_app');
        Route::post('aplikasi_pelamar/submit_app_update', 'Hrd\RecruitmentController@submit_app_update');

    });
    Route::group(['prefix'=>'karyawan'], function()
    {
        route::get('daftar', 'Hrd\KaryawanController@index');
        Route::get('filter_all', 'Hrd\KaryawanController@filter_all');
        Route::get('filter/{id_status}', 'Hrd\KaryawanController@filter');
        Route::get('filter_departemen/{departemen}', 'Hrd\KaryawanController@filter_departemen');
        Route::get('filter_departemen_gender/{departemen}/{gender}', 'Hrd\KaryawanController@filter_departemen_gender');
        route::get('baru', 'Hrd\KaryawanController@baru');
        route::get('loaddepartement/{id}', 'Hrd\KaryawanController@load_departement');
        route::get('loadsubdept/{id}', 'Hrd\KaryawanController@load_subdept');
        route::get('loadjabatandefault', 'Hrd\KaryawanController@load_jabatan_default');
        route::get('loadjabatandivisi/{id}', 'Hrd\KaryawanController@load_jabatan_divisi');
        route::get('loadjabatandept/{id_dept}', 'Hrd\KaryawanController@load_jabatan_dept');
        route::get('loadjabatansubdept/{id_dept}', 'Hrd\KaryawanController@load_jabatan_subdept');
        route::post('buatnikbaru', 'Hrd\KaryawanController@buat_nik_baru');
        route::get('loadalljabatan/{id_dept}', 'Hrd\KaryawanController@load_all_jabatan_dept');

        route::post('simpan', 'Hrd\KaryawanController@simpan');
        route::get('profil/{id}', 'Hrd\KaryawanController@profil');
        route::post('getprofilkaryawan', 'Hrd\KaryawanController@profil_karyawan'); //untuk form lain

        route::get('editbiodata/{id}', 'Hrd\KaryawanController@edit_biodata');
        route::put('rubahbiodata/{id}', 'Hrd\KaryawanController@update_biodata');
        route::get('editpekerjaan/{id}', 'Hrd\KaryawanController@edit_pekerjaan');
        route::put('rubahpekerjaan/{id}', 'Hrd\KaryawanController@update_pekerjaan');
        //latar belakang keluarga
        route::get('tambahdatalbkeluarga/{id}', 'Hrd\KaryawanController@tambah_data_lbkeluarga');
        route::post('simpanlbkeluarga', 'Hrd\KaryawanController@simpan_lb_kelaurga');
        route::get('editlbkeluarga/{id}', 'Hrd\KaryawanController@edit_lb_keluarga');
        route::put('rubahlbkeluarga/{id}', 'Hrd\KaryawanController@update_lb_keluarga');
        route::get('hapuslbkeluarga/{id_lb}/{id_karyawan}', 'Hrd\KaryawanController@hapus_lb_keluarga');
        //Keluarga
        route::get('tambahdatakeluarga/{id}', 'Hrd\KaryawanController@tambah_data_keluarga');
        route::post('simpankeluarga', 'Hrd\KaryawanController@simpan_kelaurga');
        route::get('editkeluarga/{id}', 'Hrd\KaryawanController@edit_keluarga');
        route::put('rubahkeluarga/{id}', 'Hrd\KaryawanController@update_keluarga');
        route::get('hapuskeluarga/{id_lb}/{id_karyawan}', 'Hrd\KaryawanController@hapus_keluarga');
        //Riwayat Pendidikan
        route::get('tambahrwytpendidikan/{id}', 'Hrd\KaryawanController@tambah_rwyt_pendidikan');
        route::post('simpanrwytpendidikan', 'Hrd\KaryawanController@simpan_rwyt_pendidikan');
        route::get('editrwytpendidikan/{id}', 'Hrd\KaryawanController@edit_rwyt_pendidikan');
        route::put('rubahrwytpendidikan/{id}', 'Hrd\KaryawanController@update_rwyt_pendidikan');
        route::get('hapusrwytpendidikan/{id_lb}/{id_karyawan}', 'Hrd\KaryawanController@hapus_rwyt_pendidikan');
        //Pengalaman Kerja
        route::get('tambahpengalamankerja/{id}', 'Hrd\KaryawanController@tambah_pengalaman_kerja');
        route::post('simpanpengalamankerja', 'Hrd\KaryawanController@simpan_pengalaman_kerja');
        route::get('editpengalamankerja/{id}', 'Hrd\KaryawanController@edit_pengalaman_kerja');
        route::put('rubahpengalamankerja/{id}', 'Hrd\KaryawanController@update_pengalaman_kerja');
        route::get('hapuspengalamankerja/{id_lb}/{id_karyawan}', 'Hrd\KaryawanController@hapus_pengalaman_kerja');
        //Dokumen
        route::get('tambahdokumen/{id}', 'Hrd\KaryawanController@tambah_dokumen');
        route::post('simpandokumen', 'Hrd\KaryawanController@simpan_dokumen');
        //tools
        Route::get('importTools', 'Hrd\KaryawanController@importData')->name("importDBKaryawan");
        Route::get('downloadTemplateKaryawan', 'Hrd\KaryawanController@downloadTemplateKaryawan')->name('downloadTemplateKaryawan');
        Route::post('importDataKaryawan', 'Hrd\KaryawanController@previewImport')->name("doImportKaryawa");
        Route::post('processImportKaryawan', 'Hrd\KaryawanController@processImport')->name("processImportKaryawan");
        Route::get("hapusDataKaryawan", 'Hrd\KaryawanController@doHapusDBKaryawan')->name("hapusDBKaryawan");
        Route::get('importIDFingerKaryawan', 'Hrd\KaryawanController@importIDFinger');
        Route::get('downloadtemplateIDFinger', 'Hrd\KaryawanController@templateIDFingerKaryawan');
        Route::post('importIDFingerKaryawan', 'Hrd\KaryawanController@doImportFinger')->name("doImportIDFingerKaryawan");
        //absensi
        Route::get('downloadtemplateAbsensiKaryawan', 'Hrd\KaryawanController@templateAbsensiKaryawan');

        //karyawan bpjs
        Route::get("karyawan_bpjs", 'Hrd\KaryawanController@karyawan_bpjs');
        Route::get("karyawan_bpjs_filter_all", 'Hrd\KaryawanController@karyawan_bpjs_filter_all');
        Route::get('karyawan_bpjs_filter_departemen/{departemen}', 'Hrd\KaryawanController@karyawan_bpjs_filter_departemen');
        Route::get('karyawan_bpjs_filter_departemen_gender/{departemen}/{gender}', 'Hrd\KaryawanController@karyawan_bpjs_filter_departemen_gender');
        Route::get('karyawan_bpjs_setting/{id}', 'Hrd\KaryawanController@karyawan_bpjs_setting');
        Route::put('karyawan_bpjs_setting_simpan/{id}', 'Hrd\KaryawanController@karyawan_bpjs_setting_simpan');

    });
    //Perubahan Status
    Route::group(['prefix'=>'perubahanstatus'], function()
    {
        route::get('/', 'Hrd\PerubahanStatusController@index');
        route::get('baru', 'Hrd\PerubahanStatusController@baru');
        route::get('baru/{id}', "Hrd\PerubahanStatusController@baru_lain");
        route::post('getprofil', 'Hrd\PerubahanStatusController@get_profil');
        route::get('getriwayat/{id}', 'Hrd\PerubahanStatusController@get_riwayat_perubahan_status');
        route::post('simpan', 'Hrd\PerubahanStatusController@simpan');
        route::get('print/{id}', 'Hrd\PerubahanStatusController@print');
        route::post('filterdata', 'Hrd\PerubahanStatusController@filter_data');
        route::post('filterdata_perdept', 'Hrd\PerubahanStatusController@filter_data_perdept');
        Route::get('form_proses/{id}', 'Hrd\PerubahanStatusController@form_proses');
        Route::post('store_proses', 'Hrd\PerubahanStatusController@store_proses');

        //Pengajuan
        Route::get('list_pengajuan', 'Hrd\PerubahanStatusController@list_pengajuan');
        Route::get('form_pengajuan/{id}', 'Hrd\PerubahanStatusController@form_pengajuan');
        Route::post('store_pengajuan', 'Hrd\PerubahanStatusController@store_pengajuan');
        Route::get('detail_pengajuan/{id}', 'Hrd\PerubahanStatusController@detail_pengajuan');

        //persetujuan
        Route::get('list_persetujuan', 'Hrd\PerubahanStatusController@list_persetujuan');

        //persetujuan al
        Route::get('form_persetujuan_al/{id}', 'Hrd\PerubahanStatusController@form_persetujuan_al');
        Route::post('store_persetujuan_al', 'Hrd\PerubahanStatusController@store_persetujuan_al');
        //Persetujuan hrd
        Route::get('form_persetujuan/{id}', 'Hrd\PerubahanStatusController@form_persetujuan');
        Route::post('store_persetujuan', 'Hrd\PerubahanStatusController@store_persetujuan');

        Route::get('download/hasil_evaluasi/{id}', 'Hrd\PerubahanStatusController@download_hasil_evaluasi');
    });
    //Mutasi
    Route::group(['prefix' => 'mutasi'], function()
    {
        route::get('/', 'Hrd\MutasiController@index');
        route::get('baru', 'Hrd\MutasiController@baru');
        route::post('getprofil', 'Hrd\MutasiController@get_profil');
        route::get('getriwayatmutasi/{id}', 'Hrd\MutasiController@get_riwayat_mutasi');
        route::post('simpan', 'Hrd\MutasiController@simpan');
        route::get('print/{id}', 'Hrd\MutasiController@print');
        Route::get('formproses/{id}', 'Hrd\MutasiController@form_proses');
        Route::post('storeproses', 'Hrd\MutasiController@store_proses');

        //load
        route::get('load_jabatan_default_mutasi', 'Hrd\MutasiController@load_jabatan_default');
        route::get('load_jabatan_divisi_mutasi/{id_dept}', 'Hrd\MutasiController@load_jabatan_divisi');
        route::get('load_jabatan_dept_mutasi/{id_dept}', 'Hrd\MutasiController@load_jabatan_dept');
        route::get('load_jabatan_subdept_mutasi/{id_dept}', 'Hrd\MutasiController@load_jabatan_subdept');


        route::get('load_departement_mutasi/{id}', 'Hrd\MutasiController@load_departement');
        route::get('load_subdept_mutasi/{id}', 'Hrd\MutasiController@load_subdept');

        //Pengajuan
        Route::get('listpengajuan', "Hrd\MutasiController@list_pengajuan");
        Route::get('formpengajuan', 'Hrd\MutasiController@form_pengajuan');
        Route::post('storepengajuan', 'Hrd\MutasiController@store_pengajuan');
        Route::get('formpengajuanEdit/{id}', 'Hrd\MutasiController@form_pengajuan_edit');
        Route::put('formpengajuanUpdate/{id}', 'Hrd\MutasiController@form_pengajuan_update');
        Route::get('formpengajuanDetail/{id}', 'Hrd\MutasiController@form_pengajuan_detail');
        Route::put('formpengajuanDelete/{id}', 'Hrd\MutasiController@form_pengajuan_delete');
        //Persetujuan
        Route::get('listpersetujuan', "Hrd\MutasiController@list_persetujuan");
        //persetujuan al
        Route::get('form_persetujuan_al/{id}', 'Hrd\MutasiController@form_persetujuan_al');
        Route::post('store_persetujuan_al', 'Hrd\MutasiController@store_persetujuan_al');
         //Persetujuan hrd
        Route::get('formpersetujuan/{id}', 'Hrd\MutasiController@form_persetujuan');
        Route::post('storepersetujuan', 'Hrd\MutasiController@store_persetujuan');

        Route::post('mutasi_showPdf', 'Hrd\MutasiController@mutasi_showPdf');

    });
    Route::group(['prefix' => 'cutiizin'], function()
    {
        route::get('/', 'Hrd\CutiIzinController@index');
        route::post('getjumlahhari', 'Hrd\CutiIzinController@hitung_jumlah_hari');
        Route::get('listpengajuancuti', 'Hrd\CutiIzinController@all_pengajuan_cuti');
        //cuti
        route::get('formcuti', 'Hrd\CutiIzinController@form_cuti');
        route::get('getrekapcutikaryawan/{id}', 'Hrd\CutiIzinController@rekapitulasi_cuti_tahunan');
        route::get('getlistcutikaryawan/{id}', 'Hrd\CutiIzinController@list_cuti_karyawan');
        route::post('getsisaquotacuti', 'Hrd\CutiIzinController@get_sisa_quota_cuti');
        route::post('simpancuti', 'Hrd\CutiIzinController@simpan_cuti');
        //pengajuan cuti
        route::get('cuti', 'Hrd\CutiIzinController@list_cuti');
        route::get('formpengajuancuti', 'Hrd\CutiIzinController@form_pengajuan_cuti');
        route::post('simpanpengajuancuti', 'Hrd\CutiIzinController@simpan_pengajuan_cuti');
        route::get('detailpengajuancuti/{id}', 'Hrd\CutiIzinController@detai_pengajuan_cuti');
        //approval cuti
        route::get('daftarpengajuancuti', 'Hrd\CutiIzinController@daftar_pengajuan_cuti');
        route::get('formpersetujuan_al/{id}', 'Hrd\CutiIzinController@form_persetujuan_al');
        route::post('simpanpersetujuancuti_al', 'Hrd\CutiIzinController@simpan_persetujuan_al');
        route::get('formpersetujuan_hrd/{id}', 'Hrd\CutiIzinController@form_persetujuan_hrd');
        route::post('simpanpersetujuancuti_hrd', 'Hrd\CutiIzinController@simpan_persetujuan_hrd');
        //izin
        route::get('formizin', 'Hrd\CutiIzinController@form_izin');
        route::get('getlistizinkaryawan/{id}', 'Hrd\CutiIzinController@list_izin_karyawan');
        route::get('getrekapizinkaryawan/{id}', 'Hrd\CutiIzinController@rekapitulasi_izin_tahunan');
        route::post('simpanizin', 'Hrd\CutiIzinController@simpan_izin');
        //pengajuan izin
        route::get('izin', 'Hrd\CutiIzinController@list_izin');
        route::get('formpengajuanizin', 'Hrd\CutiIzinController@form_pengajuan_izin');
        route::post('simpanpengajuanizin', 'Hrd\CutiIzinController@simpan_pengajuan_izin');
        route::get('detailpengajuanizin/{id}', 'Hrd\CutiIzinController@detai_pengajuan_izin');
        //approval izin
        route::get('daftarpengajuanizin', 'Hrd\CutiIzinController@daftar_pengajuan_izin');
        route::get('formpersetujuan/{id}', 'Hrd\CutiIzinController@form_persetujuan_izin');
        route::post('simpanpersetujuanizin_al', 'Hrd\CutiIzinController@simpan_persetujuan_izin_al');
        //Persetujuan hrd
        Route::get('formpersetujuanizin_hrd/{id}', 'Hrd\CutiIzinController@form_persetujuan_izin_hrd');
        Route::post('simpanpersetujuanizin_hrd', 'Hrd\CutiIzinController@simpan_persetujuan_izin_hrd');

        //filter
        Route::get('ci_hari_ini/{status}', 'Hrd\CutiIzinController@cui_izin_hari_ini');
        //pengajuan perubahan masa cuti
        Route::get('form_perubahan/{id}', 'Hrd\CutiIzinController@form_perubahan');
        Route::post('form_perubahan/store', 'Hrd\CutiIzinController@store_perubahan_cuti');
    });
    Route::group(['prefix' => 'perjalanandinas'], function()
    {
        //Admin
        route::get('/', 'Hrd\PerdisController@index');
        Route::get('showData/{id}', 'Hrd\PerdisController@show_data');

        // Route::get('daftarPengajuan', 'Hrd\PerdisController@list_pengajuan_admin');
        route::get('formperdis', 'Hrd\PerdisController@form_input');
        route::post('get_profil_karyawan', 'Hrd\PerdisController@profil_karyawan');
        route::get('getlistperdiskaryawan/{id}', 'Hrd\PerdisController@list_perdis_karyawan');
        route::post('simpanperdis', 'Hrd\PerdisController@simpan_data');

        Route::get('pengaturanPerdis/{id}', 'Hrd\PerdisController@form_pengaturan');
        Route::post('pengaturanPerdisStore', 'Hrd\PerdisController@pengaturan_perdis_store');
        Route::post('pengaturanPerdisDeleteFasilitas', 'Hrd\PerdisController@pengaturan_perdis_delete_fasilitas');
        Route::get('detailPerdis/{id}', 'Hrd\PerdisController@detail_perdis');
        Route::get('printSuratPerdis/{id}', 'Hrd\PerdisController@print_surat_perdis');
        Route::get('printRincianBiaya/{id}', 'Hrd\PerdisController@print_rincian_biaya');

        Route::get('daftarPerjalananDinas', 'Hrd\PerdisController@list_perdis_admin');
        Route::get('daftarPerjalananDinasFilter/{bulan}/{tahun}/{departemen}', 'Hrd\PerdisController@list_perdis_filter_admin');
        Route::get('daftarPerjalananDinasDetail/{id}', 'Hrd\PerdisController@list_perdis_detail_admin');

        //Pengajuan Atasan Langsung
        Route::get('listpengajuan', 'Hrd\PerdisController@list_pengajuan');
        Route::get('formpengajuan', 'Hrd\PerdisController@form_pengajuan');
        Route::post('storepengajuan', 'Hrd\PerdisController@store_pengajuan');

        //persetujuan
        Route::get('persetujuan/listpengajuan', 'Hrd\PerdisController@persetujuan_list_pengajuan');
        //Persetujuan AL
        Route::get('persetujuan/formPersetujuan_al/{id}', 'Hrd\PerdisController@form_persetujuan_al');
        Route::post('persetujuan/persetujuanStore_al', 'Hrd\PerdisController@store_persetujuan_al');

        //Persetujuan HRD
        Route::get('persetujuan/formPersetujuan_hrd/{id}', 'Hrd\PerdisController@form_persetujuan_hrd');
        Route::post('persetujuan/persetujuanStore_hrd', 'Hrd\PerdisController@store_persetujuan_hrd');

    });
    Route::group(['prefix' => 'suratperingatan'], function()
    {
        route::get('/', 'Hrd\SuratPeringatanController@index');
        Route::get('showData/{filter}', 'Hrd\SuratPeringatanController@show_data');
        //admin entry
        route::get('formsp', 'Hrd\SuratPeringatanController@form_input');
        route::post('simpansp', 'Hrd\SuratPeringatanController@simpan_data');
        route::get('getlistspkaryawan/{id}', 'Hrd\SuratPeringatanController@list_sp_karyawan');
        route::get('printsp/{id}', 'Hrd\SuratPeringatanController@print_sp');
        Route::get('detailSP/{id}', 'Hrd\SuratPeringatanController@form_detail_sp');
        //pengajuan
        Route::get('listPengajuan', 'Hrd\SuratPeringatanController@list_pengajuan');
        Route::get('pengajuan/showData/{filter}', 'Hrd\SuratPeringatanController@show_pengajuan_data');
        //SP
        Route::get('formPengajuan', 'Hrd\SuratPeringatanController@form_pengajuan');
        Route::post('simpanPengajuanSP', 'Hrd\SuratPeringatanController@store_pengajuan_sp');
        Route::get('formEditPengajuanSP/{id}', 'Hrd\SuratPeringatanController@form_edit_pengajuan_sp');
        Route::put('updatePengajuanSP/{id}', 'Hrd\SuratPeringatanController@update_pengajuan_sp');
        Route::get('formDetailPengajuanSP/{id}', 'Hrd\SuratPeringatanController@form_detail_pengajuan_sp');
        Route::put('cancelPengajuanSP/{id}', 'Hrd\SuratPeringatanController@cancel_pengajuan_sp');
        //surat teguran
        Route::get('formPengajuanST', 'Hrd\SuratPeringatanController@form_pengajuan_st');
        Route::post('storePengajuanST', 'Hrd\SuratPeringatanController@store_pengajuan_st');
        Route::get('formEditPengajuanST/{id}', 'Hrd\SuratPeringatanController@form_edit_pengajuan_st');
        Route::put('updatePengajuanST/{id}', 'Hrd\SuratPeringatanController@update_pengajuan_st');
        Route::get('formDetailPengajuanST/{id}', 'Hrd\SuratPeringatanController@form_detail_pengajuan_st');
        Route::put('cancelPengajuanST/{id}', 'Hrd\SuratPeringatanController@cancel_pengajuan_st');
        route::get('printST/{id}', 'Hrd\SuratPeringatanController@print_st');
        //penonaktifan sp (Admin)
        Route::get('formNonAktifSP/{id}', 'Hrd\SuratPeringatanController@form_non_aktif_sp');
        Route::post('storeNonAktifSP', 'Hrd\SuratPeringatanController@store_non_aktif_sp');
    });
    //Pendidikan dan Pelatihan
    Route::group(['prefix' => 'pelatihan'], function()
    {
        //daftar pelatihan (admin)
        route::get('/', 'Hrd\DiklatController@index');
        Route::get('getAllPengajuan', 'Hrd\DiklatController@getAllPengajuan');
        Route::get('getAllPelatihan', 'Hrd\DiklatController@getAllPelatihan');
        Route::get('getAllSubmit', 'Hrd\DiklatController@getAllSubmit');
        //add
        route::get('formdiklat', 'Hrd\DiklatController@formAdd');
        Route::get('goFormInternal', 'Hrd\DiklatController@addPelatihanInternal');
        Route::get('goFormEksternal', 'Hrd\DiklatController@addPelatihanEksternal');
        route::post('simpandiklat', 'Hrd\DiklatController@simpan_data');
        route::get('historydiklat/{id}', 'Hrd\DiklatController@get_history');
        //edit pengajuan
        Route::get('edit_diklat/{id}', 'Hrd\DiklatController@form_edit');
        //add peserta
        Route::post('storePeserta', 'Hrd\DiklatController@storePeserta');
        Route::get('getListPeserta/{id}', 'Hrd\DiklatController@getListPeserta');
        Route::post('deletePeserta', 'Hrd\DiklatController@deletePeserta');
        //submit pelatihan
        Route::get('goFormSubmit', 'Hrd\DiklatController@goFormSubmit');
        Route::get('goFormDetail/{id}', 'Hrd\DiklatController@goFormDetail');
        Route::post('submitPengajuan', 'Hrd\DiklatController@submitPengajuan');
        //old
        Route::get('print_spp/{id}', 'Hrd\DiklatController@print_spp');
        Route::get('delete_spp/{id}', 'Hrd\DiklatController@delete_spp');
        route::put('update_diklat/{id}', 'Hrd\DiklatController@update_diklat');
        //daftar pengajuan (monitoring - admin)
        Route::get('prosespelatihan/{id}', 'Hrd\DiklatController@proses_pelatihan');
        Route::get('prosespelatihanstore/{id}', 'Hrd\DiklatController@store_proses_pelatihan');
        Route::get('prosespelatihanupdate/{id}/{kat}', 'Hrd\DiklatController@update_proses_pelatihan');

        //pasca pelatihan
        Route::get('goListLaporan', 'Hrd\DiklatController@list_laporan_pasca_pelatihan');
        Route::get('getDetailPelatihan/{id}', 'Hrd\DiklatController@getDetailPelatihan');
        Route::get('detailPascaPelatihan/{id}', 'Hrd\DiklatController@detail_pasca_pelatihan');

        //pengajuan
        Route::get('pengajuan', 'Hrd\DiklatController@pengajuan');
        // Route::get('formpengajuan', 'Hrd\DiklatController@form_pengajuan');
        Route::get('goPengajuanInternal/{id}', 'Hrd\DiklatController@addPengajuanInternal');
        Route::get('goPengajuanEksternal', 'Hrd\DiklatController@addPengajuanEksternal');
        Route::get('getFormAddPeserta/{id}', 'Hrd\DiklatController@getFormAddPeserta');
        Route::get('getRiwayatPelatihan/{id}', 'Hrd\DiklatController@getRiwayatPelatihan');
        Route::post('simpanPengajuanEksternal', 'Hrd\DiklatController@simpanPengajuanEksternal');

        // Route::post('storepengajuan', 'Hrd\DiklatController@store_pengajuan');
        // Route::get('editpengajuan/{id}', 'Hrd\DiklatController@edit_pengajuan');
        Route::put('updatepengajuan/{id}', 'Hrd\DiklatController@update_pengajuan');
        Route::get('deletepengajuan/{id}', 'Hrd\DiklatController@delete_pengajuan');
        // Route::get('detailpengajuan/{id}', 'Hrd\DiklatController@detail_pengajuan');

        //persetujuan pengajuan pelatihan
        Route::get('persetujuan/listpengajuan', 'Hrd\DiklatController@list_pengajuan_persetujuan');
        Route::get('persetujuan/formpersetujuan/{id}', 'Hrd\DiklatController@form_pengajuan_persetujuan');
        Route::put('persetujuan/storepersetujuan/{id}', 'Hrd\DiklatController@store_pengajuan_persetujuan');

        //detail pelatihan
        // Route::get('getDetailPelatihan/{id}', 'Hrd\DiklatController@getDetailPelatihan');
    });
    //penggajian
    Route::group(['prefix' => 'penggajian'], function(){
        route::get('/', 'Hrd\PenggajianController@index');
        //step 1
        //simpan periode penggajian
        Route::post('simpanPeriodePenggajian', 'Hrd\PenggajianController@simpanPeriodePenggajian');
        //step 2
        Route::get('detailPeriodePenggajian/{id}', 'Hrd\PenggajianController@detailPeriodePenggajian');
        Route::get('getDataPenggajian', 'Hrd\PenggajianController@getDataPenggajian');
        //detail tunjangan
        Route::get('detailTunjangan/{id}/{bulan}/{tahun}', 'Hrd\PenggajianController@detailTunjangan');
        //detail potongan
        Route::get('detailPotongan/{id}/{bulan}/{tahun}', 'Hrd\PenggajianController@detailPotongan');
        //step 3
        Route::get('pengaturanPenggajian/{id}/{bulan}/{tahun}', 'Hrd\PenggajianController@pengaturanPenggajian');
        //form tunjangan
        Route::get('formTunjangan/{id}/{bulan}/{tahun}', 'Hrd\PenggajianController@formTunjangan');
        //form potongan
        Route::get('formPotongan/{id}/{bulan}/{tahun}', 'Hrd\PenggajianController@formPotongan');

        //get all payroll - approval
        Route::get('getDataPenggajianAll', 'Hrd\PenggajianController@getDataPenggajianAll');


        route::post('filterdetailgaji','Hrd\PenggajianController@tampilkan_karyawan_detail_gaji');
        // route::post('simpanpenggajian', 'Hrd\PenggajianController@simpan_penggajian');
        Route::post('simpanPenggajianTunjangan', 'Hrd\PenggajianController@simpanPenggajianTunjangan');
        Route::post('simpanPenggajianPotongan', 'Hrd\PenggajianController@simpanPenggajianPotongan');

        Route::get('slipgaji', 'Hrd\PenggajianController@create_slipgaji');

        Route::get('slipgaji_view_karyawan/{key}', 'Hrd\PenggajianController@list_gaji_karyawan');
        Route::get('slipgaji_print_slip/{key}', 'Hrd\PenggajianController@print_gaji_karyawan');

        Route::get('persetujuan', 'Hrd\PenggajianController@persetujuan');
        Route::get('detail/{bulan}/{tahun}', 'Hrd\PenggajianController@detail_penggajian');
        Route::post('persetujuan_store', 'Hrd\PenggajianController@persetujuan_store');
        //tools
        Route::get('downloadtemplatePeriodePenggajian/{tahun}/{bulan}', 'Hrd\PenggajianController@templatePeriodePenggajian');
        Route::get('importPeriodePenggajian', 'Hrd\PenggajianController@formImportPeriodePenggajian')->name("importPeriodePenggajian");
        Route::post('doImportPeriodePenggajian', 'Hrd\PenggajianController@doImportPeriodePenggajian')->name("doImportPeriodePenggajian");
        Route::post('previewImportPeriodePenggajian', 'Hrd\PenggajianController@previewImportPeriodePenggajian')->name("previewImportPeriodePenggajian");
        Route::post('confirmImportPeriodePenggajian', 'Hrd\PenggajianController@confirmImportPeriodePenggajian')->name("confirmImportPeriodePenggajian");
        Route::post('cancelImportPreview', 'Hrd\PenggajianController@cancelImportPreview')->name("cancelImportPreview");
        //submit to approve
        Route::get('submitPenggajian/{bulan}/{tahun}/{uuid}', 'Hrd\PenggajianController@submitPenggajian');
        Route::post('storeSubmitPenggajian', 'Hrd\PenggajianController@storeSubmitPenggajian');
    });

    //bonus
    Route::group(['prefix' => 'bonus_karyawan'], function() {
        Route::get('/', [BonusController::class, 'index'])->name('bonus_karyawan.index');
        Route::post('simpanPeriodeBonus', [BonusController::class, 'simpanPeriodeBonus'])->name('bonus_karyawan.simpanPeriodeBonus');
        //tools
        Route::get('downloadtemplateBonus/{tahun}/{bulan}', [BonusController::class, 'downloadtemplateBonus'])->name('bonus_karyawan.downloadtemplateBonus');
        Route::get('formImportPeriodeBonus', [BonusController::class, 'formImportPeriodeBonus'])->name('bonus_karyawan.formImportPeriodeBonus');
        Route::post('doImportPeriodeBonus', [BonusController::class, 'doImportPeriodeBonus'])->name('bonus_karyawan.doImportPeriodeBonus');
    });
    //bonus
    Route::group(['prefix' => 'thr_karyawan'], function() {
        Route::get('/', [ThrController::class, 'index'])->name('thr_karyawan.index');
        Route::post('simpanPeriodeThr', [ThrController::class, 'simpanPeriodeThr'])->name('thr_karyawan.simpanPeriodeThr');

        Route::get('detailThr/{id}', [ThrController::class, 'detailThr'])->name('thr_karyawan.detailThr');
        Route::get('getDataThr', [ThrController::class, 'getDataThr'])->name('thr_karyawan.getDataThr');
        Route::get('detailPengaturan/{id}/{bulan}/{tahun}', [ThrController::class, 'detailPengaturan'])->name('thr_karyawan.detailPengaturan');
        Route::get('formPengaturan/{id}/{bulan}/{tahun}', [ThrController::class, 'formPengaturan'])->name('thr_karyawan.formPengaturan');
        Route::post('simpanPengaturan', [ThrController::class, 'simpanPengaturan'])->name('thr_karyawan.simpanPengaturan');

        Route::get('downloadtemplateThr/{tahun}/{bulan}', [ThrController::class, 'downloadtemplateThr'])->name('thr_karyawan.downloadtemplateThr');
        Route::get('formImportPeriodeThr/{id_head}', [ThrController::class, 'formImportPeriodeThr'])->name('thr_karyawan.formImportPeriodeThr');
        Route::post('doImportPeriodeThr', [ThrController::class, 'doImportPeriodeThr'])->name('thr_karyawan.doImportPeriodeThr');
        Route::get('submitThr/{bulan}/{tahun}/{uuid}', [ThrController::class, 'submitThr'])->name('thr_karyawan.submitThr');
        Route::post('storeSubmitThr', [ThrController::class, 'storeSubmitThr'])->name('thr_karyawan.storeSubmitThr');
    });

    //pinjaman karyawan
    Route::group(['prefix' => 'pinjaman_karyawan'], function() {
        Route::get('/', 'Hrd\PinjamanKaryawanController@index');
        //getData
        Route::get('getListPengajuan', 'Hrd\PinjamanKaryawanController@listPengajuan');
        Route::get('getListPinjamanKaryawan', 'Hrd\PinjamanKaryawanController@listPinjamanKaryawan');
        Route::get('getListPinjamanKaryawanLunas', 'Hrd\PinjamanKaryawanController@listPinjamanKaryawanLunas');
        Route::get('getFormProses/{id}', 'Hrd\PinjamanKaryawanController@getFormProses');
        Route::post('getDataPembayaran', 'Hrd\PinjamanKaryawanController@getDataPembayaran');
        Route::post('prosesPembayaranStore', 'Hrd\PinjamanKaryawanController@prosesPembayaranStore');
        Route::get('print_mutasi/{id}', 'Hrd\PinjamanKaryawanController@printMutasi');
    });
    //Pelaporan
    Route::group(['prefix' => 'pelaporan'], function()
    {
        //pelaporan data karyawan
        route::get('karyawan', 'Hrd\PelaporanController@karyawan');
        route::get('karyawan/filter/{id}', 'Hrd\PelaporanController@filter_karyawan');
        route::get('karyawan/print/{id}', 'Hrd\PelaporanController@print_karyawan');
        route::get('karyawan/excel/{id}', 'Hrd\PelaporanController@excel_karyawan');
        //perubahan status
        route::get('perubahanstatus', 'Hrd\PelaporanController@perubahan_status');
        route::get('perubahanstatus/filter/{bln}/{thn}/{departemen}', 'Hrd\PelaporanController@filter_perubahan_status');
        route::get('perubahanstatus/print/{bln}/{thn}/{departemen}', 'Hrd\PelaporanController@print_perubahan_status');
        route::get('perubahanstatus/excel/{bln}/{thn}/{departemen}', 'Hrd\PelaporanController@excel_perubahan_status');
        //mutasi
        route::get('mutasi', 'Hrd\PelaporanController@mutasi');
        route::get('mutasi/filter/{bln}/{thn}/{departemen}', 'Hrd\PelaporanController@filter_mutasi');
        route::get('mutasi/print/{bln}/{thn}/{departemen}', 'Hrd\PelaporanController@print_mutasi');
        route::get('mutasi/excel/{bln}/{thn}/{departemen}', 'Hrd\PelaporanController@excel_mutasi');
        //Cuti Izin
        route::get('cutiizin', 'Hrd\PelaporanController@cuti_izin');
        route::get('cutiizin/filter/{bln}/{thn}/{kategori}/{departemen}', 'Hrd\PelaporanController@filter_cuti_izin');
        route::get('cutiizin/print/{bln}/{thn}/{kategori}/{departemen}', 'Hrd\PelaporanController@print_cuti_izin');
        route::get('cutiizin/excel/{bln}/{thn}/{kategori}/{departemen}', 'Hrd\PelaporanController@excel_cuti_izin');
        Route::get('cuti_izin/print_form_cuti/{id}', 'Hrd\PelaporanController@print_form_cuti');
        Route::get('cuti_izin/print_surat_cuti/{id}', 'Hrd\PelaporanController@print_surat_cuti');
        //Perdis
        route::get('perdis', 'Hrd\PelaporanController@perdis');
        route::get('perdis/filter/{bln}/{thn}/{departemen}', 'Hrd\PelaporanController@filter_perdis');
        route::get('perdis/print/{bln}/{thn}/{departemen}', 'Hrd\PelaporanController@print_perdis');
        route::get('perdis/excel/{bln}/{thn}/{departemen}', 'Hrd\PelaporanController@excel_perdis');
        //Surat Peringatan
        route::get('sp', 'Hrd\PelaporanController@sp');
        route::get('sp/filter/{bln}/{thn}/{departemen}', 'Hrd\PelaporanController@filter_sp');
        route::get('sp/print/{bln}/{thn}/{departemen}', 'Hrd\PelaporanController@print_sp');
        route::get('sp/excel/{bln}/{thn}/{departemen}', 'Hrd\PelaporanController@excel_sp');
        //Penggajian
        route::get("penggajian", "Hrd\PelaporanController@penggajian");
        route::get("penggajian/filter/{bln}/{thn}/{departemen}", "Hrd\PelaporanController@filter_penggajian");
        Route::get('penggajian/print/{bln}/{thn}/{departemen}', "Hrd\PelaporanController@print_penggajian");
        Route::get('penggajian/excel/{bln}/{thn}/{departemen}', "Hrd\PelaporanController@excel_penggajian");
        //detail tunjangan
        Route::get('penggajian/detailTunjangan/{id}', 'Hrd\PelaporanController@detailTunjangan');
        //detail potongan
        Route::get('penggajian/detailPotongan/{id}', 'Hrd\PelaporanController@detailPotongan');
        //bpjs ketenagakerjaan
        route::get("bpjsketenagakerjaan", "Hrd\PelaporanController@bpjs_ketenagakerjaan");
        route::get("bpjsketenagakerjaan/filter/{bln}/{thn}/{departemen}", "Hrd\PelaporanController@filter_bpjs_ketenagakerjaan");
        //bpjs kesehatan
        route::get("bpjskesehatan", "Hrd\PelaporanController@bpjs_kesehatan");
        route::get("bpjskesehatan/filter/{bln}/{thn}/{departemen}", "Hrd\PelaporanController@filter_bpjs_kesehatan");

        //pinjaman karyawan
        Route::get('pinjamanKaryawan', 'Hrd\PelaporanController@pinjamanKaryawan');
        route::get("pinjamanKaryawan/filter/{bln}/{thn}/{departemen}", "Hrd\PelaporanController@filterPinjamanKaryawan");
    });
    Route::group(["prefix" => "tools"], function()
    {
        Route::get('hapusPerdis', 'Hrd\PerdisController@delete_all');
    });

    Route::group(["prefix" => "absensi"], function()
    {
        Route::get('/', 'Hrd\AbsensiController@index');
        Route::post('getAbsensi', 'Hrd\AbsensiController@list_data');
        Route::get('importdataabsensi', 'Hrd\AbsensiController@import_data_absensi');
        Route::post('storedataabsensi', 'Hrd\AbsensiController@doImportAbsensi');
    });

    Route::group(["prefix" => "persetujuan"], function(){
        Route::get("/", 'Hrd\PersetujuanController@index');
        Route::get('formApproval/{id}', 'Hrd\PersetujuanController@form_approval');
        Route::post('storeApproval', 'Hrd\PersetujuanController@store_approval');
    });

    Route::group(['prefix' => 'lembur'], function()
    {
        route::get('/', 'Hrd\LemburController@index');
        Route::get('showData/{filter}', 'Hrd\LemburController@show_data');
        Route::get('detailData/{id}', 'Hrd\LemburController@detail_data');

    });

    Route::group(['prefix' => 'resign'], function()
    {
        Route::get('/', 'Hrd\ResignController@index');
        Route::get('all_data', 'Hrd\ResignController@all_data');
        Route::get('all_pengajuan', 'Hrd\ResignController@all_pengajuan');
        Route::get('all_exit_form', 'Hrd\ResignController@all_exit_form');
        Route::get('detailFormExitInterviews/{id}', 'Hrd\ResignController@detail_form_exit_interiews');
        Route::get('pengaturanResign/{id}', 'Hrd\ResignController@pengaturan_resign');
        Route::put('pengaturanResignStore/{id}', 'Hrd\ResignController@pengaturan_resign_store');
        Route::get('printSKK/{id}', 'Hrd\ResignController@print_skk');
    });
});
