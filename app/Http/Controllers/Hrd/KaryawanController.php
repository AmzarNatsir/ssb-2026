<?php

namespace App\Http\Controllers\Hrd;

use App\Exports\AbsensiTemplateExport;
use App\Exports\KaryawanIDFingerExport;
use App\Http\Controllers\Controller;
use App\Imports\IDFingerKaryawanImport;
use Illuminate\Http\Request;
use App\Models\HRD\KaryawanModel;
use App\Models\HRD\LevelJabatanModel;
use App\Models\HRD\DivisiModel;
use App\Models\HRD\DepartemenModel;
use App\Models\HRD\SubDepartemenModel;
use App\Models\HRD\JabatanModel;
use App\Models\HRD\StatusKaryawanModel;
use App\Models\HRD\LBKeluargaModel;
use App\Models\HRD\KeluargaModel;
use App\Models\HRD\RiwayatPendidikanModel;
use App\Models\HRD\PengalamanKerjaModel;
use App\Models\HRD\DokumenKaryawanjaModel;
use App\Models\HRD\JenisDokumenKaryawanModel;
use Illuminate\Support\Facades\DB;
//use Illuminate\Pagination\Paginator;

//tools import
use App\Imports\KaryawanImport;
use App\Models\HRD\PerdisModel;
use App\Models\HRD\StatusTanggunganModel;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\ImageManagerStatic as Image;
use Storage;
use Illuminate\Support\Facades\Config;
//use Image;
use File;

class KaryawanController extends Controller
{
    public function index()
    {
       // Paginator::useBootstrap;
        $all_sts_karyawan = Config::get("constants.status_karyawan");
        $all_departemen = DepartemenModel::with(['get_master_divisi'])->where('status', 1)->get()->map( function($row) {
            $arr = $row->toArray();
            $arr['total'] = KaryawanModel::where('id_departemen', $arr['id'])->where('nik', '<>', '999999999')->get()->count();
            $arr['total_aktif'] = KaryawanModel::where('id_departemen', $arr['id'])->where('nik', '<>', '999999999')->whereIn('id_status_karyawan', [1, 2, 3, 7])->get()->count();
            $arr['total_tidak_aktif'] = KaryawanModel::where('id_departemen', $arr['id'])->where('nik', '<>', '999999999')->whereIn('id_status_karyawan', [4, 5, 6])->get()->count();
            $arr['total_laki'] = KaryawanModel::where('jenkel', 1)->where('id_departemen', $arr['id'])->where('nik', '<>', '999999999')->get()->count();
            $arr['total_perempuan'] = KaryawanModel::where('jenkel', 2)->where('id_departemen', $arr['id'])->where('nik', '<>', '999999999')->get()->count();
            return $arr;
        });
        $all_non_departemen = array(

            'total_non' => KaryawanModel::whereNull('id_departemen')->where('nik', '<>', '999999999')->get()->count(),
            'total_aktif_non' => KaryawanModel::whereNull('id_departemen')->where('nik', '<>', '999999999')->whereIn('id_status_karyawan', [1, 2, 3, 7])->get()->count(),
            'total_tidak_aktif_non' => KaryawanModel::whereNull('id_departemen')->where('nik', '<>', '999999999')->whereIn('id_status_karyawan', [4, 5, 6])->get()->count(),
            'total_laki_non' => KaryawanModel::whereNull('id_departemen')->where('jenkel', 1)->where('nik', '<>', '999999999')->get()->count(),
            'total_perempuan_non' => KaryawanModel::whereNull('id_departemen')->where('jenkel', 2)->where('nik', '<>', '999999999')->get()->count()
        );
        $total_karyawan = KaryawanModel::where('nik', '<>', '999999999')->get()->count();
        $total_karyawan_aktif = KaryawanModel::where('nik', '<>', '999999999')->whereIn('id_status_karyawan', [1, 2, 3, 7])->get()->count();
        $total_karyawan_tidak_aktif = KaryawanModel::where('nik', '<>', '999999999')->whereIn('id_status_karyawan', [4, 5, 6])->get()->count();
        // dd($all_non_departemen);
        // dd($all_departemen);
        return view('HRD.karyawan.index', [
            'sts_karyawan'=>$all_sts_karyawan,
            'list_departemen' => $all_departemen,
            'total_karyawan' => $total_karyawan,
            'total_karyawan_aktif' => $total_karyawan_aktif,
            'total_karyawan_tidak_aktif' => $total_karyawan_tidak_aktif,
            'non_departemen' => $all_non_departemen
        ]);
    }

    public function filter_all()
    {
        $data['list_data'] = KaryawanModel::with('get_jabatan')->where('nik', '<>', '999999999')->get();
        return view('HRD.karyawan.result_main', $data);
    }

    public function filter($id_status)
    {
        $data['list_data'] = KaryawanModel::with('get_jabatan')->where('nik', '<>', '999999999')->where('id_status_karyawan', $id_status)->get();
        return view('HRD.karyawan.result_view', $data);
    }

    public function filter_departemen($departemen)
    {
        if($departemen=='non') {
            $data['list_data'] = KaryawanModel::with('get_jabatan')->where('nik', '<>', '999999999')->whereNull('id_departemen')->get();
        } else {
            $data['list_data'] = KaryawanModel::with('get_jabatan')->where('nik', '<>', '999999999')->where('id_departemen', $departemen)->get();
        }
        return view('HRD.karyawan.result_view', $data);
    }
    public function filter_departemen_gender($departemen, $gender)
    {
        if($departemen=='non') {
            $data['list_data'] = KaryawanModel::with('get_jabatan')->where('nik', '<>', '999999999')->whereNull('id_departemen')->where('jenkel', $gender)->get();
        } else {
            $data['list_data'] = KaryawanModel::with('get_jabatan')->where('nik', '<>', '999999999')->where('id_departemen', $departemen)->where('jenkel', $gender)->get();
        }

        return view('HRD.karyawan.result_view', $data);
    }
    public function baru()
    {
        $all_agama = Config::get("constants.agama");
        $all_jenjang = Config::get("constants.jenjang_pendidikan");
        $all_status_nikah = Config::get("constants.status_pernikahan");
        $all_sts_karyawan = Config::get("constants.status_karyawan");
        $all_divisi = DivisiModel::where('status', 1)->get();
        $all_status_tanggungan = StatusTanggunganModel::where('status', 1)->get();
        //$all_subdepartemen = SubDepartemenModel::all();
        $all_jabatan = JabatanModel::where('status', 1)
                    ->where('id_divisi', '=', '')
                    ->orWhere('id_divisi', 0)
                    ->orWhereNull('id_divisi')
                    ->orderby('id_level', 'asc')->get();
        return view('HRD.karyawan.baru', ['list_agama'=>$all_agama, 'list_jenjang'=>$all_jenjang, 'list_status_nikah'=>$all_status_nikah, 'list_divisi'=>$all_divisi, 'list_jabatan'=>$all_jabatan, 'list_sts_karyawan'=>$all_sts_karyawan, 'list_status_tanggungan' => $all_status_tanggungan]);
    }
    public function buat_nik_baru(Request $request)
    {
        $tgl_masuk = $request->tgl_masuk;
        $arr_tgl = explode("/", $tgl_masuk);
        $thn = substr($arr_tgl[2], 0, 4);
        $bln = $arr_tgl[1];
        $no_urut = 1;
        $nik_awal = $thn.$bln;
        $result = KaryawanModel::where('nik', '!=', '999999999')->orderBy('id', 'desc')->first();
        if(empty($result->nik))
        {
            $nik_baru = $nik_awal.sprintf('%03s', $no_urut);
        } else {
            $no_urut_baru = substr($result->nik, 6, 3)+1;
            $nik_baru = $nik_awal.sprintf('%03s', $no_urut_baru);
        }
        echo $nik_baru;
    }
    public function load_jabatan_default()
    {
        $res_jabatan = JabatanModel::where('status', 1)
                ->where('id_divisi', 0)
                ->orWhere('id_divisi', '=', '')
                ->orWhereNull('id_divisi')->get();
        //echo "<option value='0'>Non Sub Departemen</option>";
        foreach($res_jabatan as $list){
            echo "<option value=".$list->id.">".$list->nm_jabatan."</option>";
        }
    }
    public function load_jabatan_divisi($di_divisi)
    {
        $res_jabatan = JabatanModel::where('status', 1)
                        ->where('id_divisi', $di_divisi)
                        ->where('id_dept', NULL)
                        ->where(function($q){
                            $q->where('id_subdept', 0)->orwhereNull('id_subdept');
                        })->get();
        //echo "<option value='0'>Non Sub Departemen</option>";
        foreach($res_jabatan as $list){
            echo "<option value=".$list->id.">".$list->nm_jabatan."</option>";
        }
    }
    public function load_jabatan_dept($id_dept)
    {
        $res_jabatan = JabatanModel::where('status', 1)->where('id_dept', $id_dept)->whereNull('id_subdept')->get();
        //echo "<option value='0'>Non Sub Departemen</option>";
        foreach($res_jabatan as $list){
            echo "<option value=".$list->id.">".$list->nm_jabatan."</option>";
        }
    }
    public function load_jabatan_subdept($id_subdept)
    {
        $res_jabatan = JabatanModel::where('status', 1)->where('id_subdept', $id_subdept)->get();
        //echo "<option value='0'>Non Sub Departemen</option>";
        foreach($res_jabatan as $list){
            echo "<option value=".$list->id.">".$list->nm_jabatan."</option>";
        }
    }
    public function load_departement($id_divisi)
    {
        $res_departemen = DepartemenModel::where('status', 1)->where('id_divisi', $id_divisi)->get();
        echo "<option value='0'>Non Departemen</option>";
        foreach($res_departemen as $list_dept){
            echo "<option value=".$list_dept->id.">".$list_dept->nm_dept."</option>";
        }
    }
    public function load_subdept($id_dept)
    {
        $result_subdept = SubDepartemenModel::where('id_dept', $id_dept)->get();
        echo "<option value='0'>Non Sub Departemen</option>";
        foreach($result_subdept as $subdept)
        {
            echo "<option value=".$subdept->id.">".$subdept->nm_subdept."</option>";
        }
    }
    public function periksa_nik(Request $request)
    {
        $nik = $request->nik;
        $result = KaryawanModel::where('nik', $nik)->first();
        if(!empty($result->nik))
        {
            echo "1";
        } else {
            echo "2";
        }
    }

    public function load_all_jabatan_dept($id_dept)
    {
        $res_jabatan = JabatanModel::where('status', 1)->where('id_dept', $id_dept)->get();
        //echo "<option value='0'>Non Sub Departemen</option>";
        foreach($res_jabatan as $list){
            echo "<option value=".$list->id.">".$list->nm_jabatan."</option>";
        }
    }

    public function simpan(Request $request)
    {
        $allowedfileExtension=['jpg','png','jpeg'];
        Image::configure(array('driver' => 'gd'));
        $path = storage_path("app/public/hrd/photo");
        if($request->hasFile('file_photo'))
        {
            $image = $request->file('file_photo');
            $extension = $image->getClientOriginalExtension();
            $check=in_array($extension,$allowedfileExtension);
            if($check)
            {
                $filename = $request->inp_nik.".".$extension;
                //dd($path);
                if(!File::isDirectory($path)) {
                    $path = Storage::disk('public')->makeDirectory('hrd/photo');
                }
                //$path = Storage::disk('local')->makeDirectory('public/hrd/photo');
                $image_resize = Image::make($image->getRealPath());
                $image_resize->resize(150, null, function($construction){
                    $construction->aspectRatio();
                });

                $image_resize->save(storage_path("app/public/hrd/photo/".$filename));


                $arr_tgl_masuk = explode("/", $request->inp_tgl_masuk);
                $tgl_masuk = $arr_tgl_masuk[2]."-".$arr_tgl_masuk[1]."-".$arr_tgl_masuk[0];

                $arr_tgl_lahir = explode("/", $request->inp_tgl_lahir);
                $tgl_lahir = $arr_tgl_lahir[2]."-".$arr_tgl_lahir[1]."-".$arr_tgl_lahir[0];

                $arr_tgl_eff_jab = explode("/", $request->inp_tgl_eff_jabatan);
                $tgl_eff_jab = $arr_tgl_eff_jab[2]."-".$arr_tgl_eff_jab[1]."-".$arr_tgl_eff_jab[0];

                $arr_tgl_eff = explode("/", $request->inp_tgl_eff_mulai);
                $tgl_eff = $arr_tgl_eff[2]."-".$arr_tgl_eff[1]."-".$arr_tgl_eff[0];
                if(empty($request->inp_tgl_eff_akhir)) {
                    $tgl_akh = NULL;
                } else {
                    $arr_tgl_akh = explode("/", $request->inp_tgl_eff_akhir);
                    $tgl_akh = $arr_tgl_akh[2]."-".$arr_tgl_akh[1]."-".$arr_tgl_akh[0];
                }
                KaryawanModel::create([
                    'nik_auto' => 2, //manual
                    'nik' => $request->inp_nik,
                    'nm_lengkap' => $request->inp_nama,
                    'tmp_lahir' => $request->inp_tempat_lahir,
                    'tgl_lahir' => $tgl_lahir,
                    'jenkel' => $request->rdo_jenkel,
                    'no_ktp' => $request->inp_nomor_ktp,
                    'alamat' => $request->inp_alamat,
                    'notelp' => $request->inp_notelepon,
                    'nmemail' => $request->inp_email,
                    'suku' => $request->inp_suku,
                    'agama' => $request->pil_agama,
                    'pendidikan_akhir' => $request->pil_jenjang,
                    'status_nikah' => $request->pil_status_nikah,
                    'id_status_tanggungan' => $request->pil_status_tanggungan,
                    'no_npwp' => $request->inp_nomor_npwp,
                    'no_bpjstk' => $request->inp_nomor_bpjstk,
                    'no_bpjsks' => $request->inp_nomor_bpjsks,
                    'photo' => $filename,
                    'tgl_masuk' => $tgl_masuk,
                    'id_divisi' => $request->pil_divisi,
                    'id_departemen' => $request->pil_departemen,
                    'id_subdepartemen' => $request->pil_subdepartemen,
                    'id_jabatan' => $request->pil_jabatan,
                    'tmt_jabatan' => $tgl_eff_jab,
                    'id_status_karyawan' => $request->pil_sts_karyawan,
                    'tgl_sts_efektif_mulai' => $tgl_eff,
                    'tgl_sts_efektif_akhir' => $tgl_akh,
                    'jabatan_awal' => $request->pil_jabatan,
                ]);

                return redirect('hrd/karyawan/baru')->with('konfirm', 'Data karyawan berhasil disimpan.');
            }
            else {
                return redirect('hrd/karyawan/baru')->with('konfirm', 'Data gagal disimpan. File yang bisa diupload adalah jpg/jpeg, png. Periksa kembali data inputan anda.');
            }

        }
        else {
            return redirect('hrd/karyawan/baru')->with('konfirm', 'Data gagal disimpan. File photo tidak boleh kosong.');
        }
    }
    public function profil($id)
    {
        $prf = new KaryawanModel();
        $res_profil = KaryawanModel::with([
            'get_departemen',
            'get_divisi',
            'get_subdepartemen',
            'get_jabatan',
            'get_status_tanggungan'
        ])->find($id);
        $res_lb_keluarga = LBKeluargaModel::where('id_karyawan', $id)->get();
        $res_keluarga = KeluargaModel::where('id_karyawan', $id)->get();
        $res_rwyt_pendidikan = RiwayatPendidikanModel::where('id_karyawan', $id)->get();
        $res_pengalaman_kerja = PengalamanKerjaModel::where('id_karyawan', $id)->get();
        $res_dokumen = DokumenKaryawanjaModel::where('id_karyawan', $id)->get();
        $all_agama = Config::get("constants.agama");
        $all_jenjang = Config::get("constants.jenjang_pendidikan");
        $all_status_nikah = Config::get("constants.status_pernikahan");
        // dd($res_profil);
        return view('HRD.karyawan.profil', ['res'=>$res_profil, 'list_agama'=>$all_agama, 'list_jenjang'=>$all_jenjang, 'list_status_nikah'=>$all_status_nikah, 'list_lb_keluarga'=>$res_lb_keluarga, 'list_keluarga'=>$res_keluarga, 'list_rwyt_pendidikan'=>$res_rwyt_pendidikan, 'list_pengalaman_kerja'=>$res_pengalaman_kerja, 'list_dokumen'=>$res_dokumen]);
    }
    public function profil_karyawan(Request $request)
    {
        $id_karyawan = $request->id_karyawan;
        $prf = new KaryawanModel();
        $result = $prf->profil($id_karyawan);
        $nm_divisi = $result->nm_divisi;
        $nm_dept = $result->nm_dept;
        $nm_subdept = $result->nm_subdept;
        $nm_jabt = $result->nm_jabatan;
        $arr_result = array("nm_status"=>$this->get_status_karyawan($result->id_status_karyawan), "nm_divisi"=>$nm_divisi, "nm_dept"=>$nm_dept, "nm_subdept"=>$nm_subdept, "nm_jabt"=>$nm_jabt);
        echo json_encode($arr_result);
    }

    public function get_status_karyawan($id)
    {
        $list_status = Config::get('constants.status_karyawan');
        foreach($list_status as $key => $value)
        {
            if($key==$id)
            {
                return $value;
                break;
            }
        }
    }

    public function edit_biodata($id)
    {
        $res_profil = KaryawanModel::find($id);
        $all_agama = Config::get("constants.agama");
        $all_jenjang = Config::get("constants.jenjang_pendidikan");
        $all_status_nikah = Config::get("constants.status_pernikahan");
        $all_status_tanggungan = StatusTanggunganModel::where('status', 1)->get();
        return view('HRD.karyawan.edit_biodata', ['list_agama'=>$all_agama, 'list_jenjang'=>$all_jenjang, 'list_status_nikah'=>$all_status_nikah, 'res'=>$res_profil, 'list_status_tanggungan' => $all_status_tanggungan]);

    }
    public function update_biodata(Request $request, $id)
    {
        $allowedfileExtension=['jpg','png','jpeg'];
        Image::configure(array('driver' => 'gd'));

        if($request->hasFile('file_photo'))
        {
            $this->del_image_folder($id);
            $image = $request->file('file_photo');
            $extension = $image->getClientOriginalExtension();
            $check=in_array($extension,$allowedfileExtension);
            if($check)
            {
                $filename = $request->inp_nik.".".$extension;
                $path = storage_path("app/public/hrd/photo");
                //dd($path);
                if(!File::isDirectory($path)) {
                    $path = Storage::disk('public')->makeDirectory('hrd/photo');
                }
                //$path = Storage::disk('local')->makeDirectory('public/hrd/photo');
                $image_resize = Image::make($image->getRealPath());
                $image_resize->resize(150, null, function($construction){
                    $construction->aspectRatio();
                });
                //$image_resize->resize(128, 128);
                $image_resize->save(storage_path("app/public/hrd/photo/".$filename));
                $update = KaryawanModel::find($id);
                $update->nm_lengkap = $request->inp_nama;
                $update->tmp_lahir = $request->inp_tempat_lahir;
                $update->tgl_lahir = $request->inp_tgl_lahir;
                $update->jenkel = $request->rdo_jenkel;
                $update->no_ktp = $request->inp_nomor_ktp;
                $update->alamat = $request->inp_alamat;
                $update->notelp = $request->inp_notelepon;
                $update->nmemail = $request->inp_email;
                $update->suku = $request->inp_suku;
                $update->agama = $request->pil_agama;
                $update->pendidikan_akhir = $request->pil_jenjang;
                $update->status_nikah = $request->pil_status_nikah;
                $update->id_status_tanggungan = $request->pil_status_tanggungan;
                $update->no_npwp = $request->inp_nomor_npwp;
                $update->no_bpjstk = $request->inp_nomor_bpjstk;
                $update->no_bpjsks = $request->inp_nomor_bpjsks;
                $update->nik_lama = $request->inp_id_finger;
                $update->photo = $filename;
                $update->save();
                return redirect('hrd/karyawan/profil/'.$id)->with('konfirm', 'Biodata karyawan berhasil disimpan.');
            }
            else {
                return redirect('hrd/karyawan/profil/'.$id)->with('konfirm', 'Data gagal disimpan. File yang bisa diupload adalah jpg/jpeg, png. Periksa kembali data inputan anda.');
            }

        }
        else {
            $update = KaryawanModel::find($id);
            $update->nm_lengkap = $request->inp_nama;
            $update->tmp_lahir = $request->inp_tempat_lahir;
            $update->tgl_lahir = $request->inp_tgl_lahir;
            $update->jenkel = $request->rdo_jenkel;
            $update->no_ktp = $request->inp_nomor_ktp;
            $update->alamat = $request->inp_alamat;
            $update->notelp = $request->inp_notelepon;
            $update->nmemail = $request->inp_email;
            $update->suku = $request->inp_suku;
            $update->agama = $request->pil_agama;
            $update->pendidikan_akhir = $request->pil_jenjang;
            $update->status_nikah = $request->pil_status_nikah;
            $update->id_status_tanggungan = $request->pil_status_tanggungan;
            $update->no_npwp = $request->inp_nomor_npwp;
            $update->no_bpjstk = $request->inp_nomor_bpjstk;
            $update->no_bpjsks = $request->inp_nomor_bpjsks;
            $update->nik_lama = $request->inp_id_finger;
            $update->save();
            return redirect('hrd/karyawan/profil/'.$id)->with('konfirm', 'Biodata karyawan berhasil disimpan.');
        }
    }
    public function del_image_folder($id)
    {
        $resfile = KaryawanModel::where('id', $id)->first();
        $filename = $resfile->photo;
        $image_path = storage_path('app/public/hrd/photo/'.$filename);
        if(File::exists($image_path)) {
            File::delete($image_path);
        }
    }

    public function edit_pekerjaan($id)
    {
        $id_sub_dept = NULL;

        $res_profil = KaryawanModel::find($id);
        $all_divisi = DivisiModel::where('status', 1)->get();
        $all_departemen = DepartemenModel::where('status', 1)->where('id_divisi', $res_profil->id_divisi)->get();
        $all_subdepartemen = SubDepartemenModel::where('id_dept', $res_profil->id_departemen)->get();

        if($res_profil->id_subdepartemen != 0) {
            $id_sub_dept = $res_profil->id_subdepartemen;
        }

        $all_jabatan = JabatanModel::where('status', 1)
                ->where('id_divisi', $res_profil->id_divisi)
                ->where('id_dept', $res_profil->id_departemen)
                ->where('id_subdept', $id_sub_dept)
                ->orderby('id_level', 'asc')->get();
        $all_sts_karyawan = Config::get("constants.status_karyawan");
        // dd($all_jabatan);

        return view('HRD.karyawan.edit_pekerjaan', ['list_divisi'=>$all_divisi, 'list_departemen'=>$all_departemen, 'list_subdepartemen'=>$all_subdepartemen, 'list_jabatan'=>$all_jabatan, 'list_sts_karyawan'=>$all_sts_karyawan, 'res'=>$res_profil]);

    }
    public function update_pekerjaan(Request $request, $id)
    {
        $update = KaryawanModel::find($id);
        $update->tgl_masuk = $request->inp_tgl_masuk;
        $update->tmt_jabatan = $request->inp_tgl_eff_jabatan;
         $update->tgl_sts_efektif_mulai = $request->inp_tgl_eff_mulai;
        $update->tgl_sts_efektif_akhir = $request->inp_tgl_eff_akhir;
        // $update->id_divisi = $request->pil_divisi;
        // $update->id_departemen = $request->pil_departemen;
        // $update->id_subdepartemen = $request->pil_subdepartemen;
        // $update->id_jabatan = $request->pil_jabatan;
        // $update->id_status_karyawan = $request->pil_sts_karyawan;
        $update->save();
        return redirect('hrd/karyawan/profil/'.$id)->with('konfirm', 'Data Pekerjaan karyawan berhasil disimpan.');
    }
    //Latar Belakang Keluarga
    public function tambah_data_lbkeluarga($id)
    {
        $res_profil = KaryawanModel::find($id);
        $res_lb_keluarga = LBKeluargaModel::where('id_karyawan', $id)->get();
        $res_hubungan_lb_keluarga = Config::get('constants.hubungan_lbkeluarga');
        $res_hubungan_keluarga = Config::get('constants.hubungan_keluarga');
        $all_jenjang = Config::get("constants.jenjang_pendidikan");
        return view('HRD.karyawan.lb_keluarga.add_lbkeluarga', ['res'=>$res_profil, 'list_lbkeluarga' => $res_hubungan_lb_keluarga, 'list_keluarga' => $res_hubungan_keluarga, 'list_jenjang'=>$all_jenjang, 'list_lb_keluarga'=>$res_lb_keluarga]);
    }
    public function simpan_lb_kelaurga(Request $request)
    {
        $id_karyawan = $request->id_karyawan;
        LBKeluargaModel::create([
            "id_karyawan" => $id_karyawan,
            "id_hubungan" => $request->pil_hubungan,
            "nm_keluarga" => $request->inp_nama,
            "tmp_lahir" => $request->inp_tmp_lahir,
            "tgl_lahir" => $request->inp_tgl_lahir,
            "jenkel" => $request->rdo_jenkel,
            "id_jenjang" => $request->pil_jenjang,
            "pekerjaan" => $request->inp_pekerjaan
        ]);
        return redirect('hrd/karyawan/tambahdatalbkeluarga/'.$id_karyawan)->with('konfirm', 'Data Latar Belakang Keluarga karyawan berhasil disimpan.');
    }
    public function edit_lb_keluarga($id)
    {
        $res_lb = LBKeluargaModel::find($id);
        $res_hubungan_lb_keluarga = Config::get('constants.hubungan_lbkeluarga');
        $all_jenjang = Config::get("constants.jenjang_pendidikan");
        return view('HRD.karyawan.lb_keluarga.edt_lbkeluarga', ['res_lb'=>$res_lb, 'list_lbkeluarga' => $res_hubungan_lb_keluarga, 'list_jenjang'=>$all_jenjang]);
    }
    public function update_lb_keluarga(Request $request, $id)
    {
        $id_karyawan = $request->id_karyawan;
        $update = LBKeluargaModel::find($id);
        $update->id_hubungan = $request->pil_hubungan;
        $update->nm_keluarga = $request->inp_nama;
        $update->tmp_lahir = $request->inp_tmp_lahir;
        $update->tgl_lahir = $request->inp_tgl_lahir;
        $update->jenkel = $request->rdo_jenkel;
        $update->id_jenjang = $request->pil_jenjang;
        $update->pekerjaan = $request->inp_pekerjaan;
        $update->save();
        return redirect('hrd/karyawan/tambahdatalbkeluarga/'.$id_karyawan)->with('konfirm', 'Perubahan Data Latar Belakang Keluarga karyawan berhasil disimpan.');
    }
    public function hapus_lb_keluarga($id, $id_karyawan)
    {
        $del = LBKeluargaModel::find($id);
        $del->delete();
        return redirect('hrd/karyawan/tambahdatalbkeluarga/'.$id_karyawan)->with('konfirm', 'Data Latar Belakang Keluarga karyawan berhasil dihapus.');
    }
    //Latar Keluarga
    public function tambah_data_keluarga($id)
    {
        $res_profil = KaryawanModel::find($id);
        $res_keluarga = KeluargaModel::where('id_karyawan', $id)->get();
        $res_hubungan_keluarga = Config::get('constants.hubungan_keluarga');
        $all_jenjang = Config::get("constants.jenjang_pendidikan");
        return view('HRD.karyawan.keluarga.add_keluarga', ['res'=>$res_profil, 'list_status_keluarga' => $res_hubungan_keluarga, 'list_jenjang'=>$all_jenjang, 'list_keluarga'=>$res_keluarga]);
    }
    public function simpan_kelaurga(Request $request)
    {
        $id_karyawan = $request->id_karyawan;
        KeluargaModel::create([
            "id_karyawan" => $id_karyawan,
            "id_hubungan" => $request->pil_hubungan,
            "nm_keluarga" => $request->inp_nama,
            "tmp_lahir" => $request->inp_tmp_lahir,
            "tgl_lahir" => $request->inp_tgl_lahir,
            "jenkel" => $request->rdo_jenkel,
            "id_jenjang" => $request->pil_jenjang,
            "pekerjaan" => $request->inp_pekerjaan
        ]);
        return redirect('hrd/karyawan/tambahdatakeluarga/'.$id_karyawan)->with('konfirm', 'Data Keluarga karyawan berhasil disimpan.');
    }
    public function edit_keluarga($id)
    {
        $res_lb = KeluargaModel::find($id);
        $res_hubungan_keluarga = Config::get('constants.hubungan_keluarga');
        $all_jenjang = Config::get("constants.jenjang_pendidikan");
        return view('HRD.karyawan.keluarga.edt_keluarga', ['res_lb'=>$res_lb, 'list_keluarga' => $res_hubungan_keluarga, 'list_jenjang'=>$all_jenjang]);
    }
    public function update_keluarga(Request $request, $id)
    {
        $id_karyawan = $request->id_karyawan;
        $update = KeluargaModel::find($id);
        $update->id_hubungan = $request->pil_hubungan;
        $update->nm_keluarga = $request->inp_nama;
        $update->tmp_lahir = $request->inp_tmp_lahir;
        $update->tgl_lahir = $request->inp_tgl_lahir;
        $update->jenkel = $request->rdo_jenkel;
        $update->id_jenjang = $request->pil_jenjang;
        $update->pekerjaan = $request->inp_pekerjaan;
        $update->save();
        return redirect('hrd/karyawan/tambahdatakeluarga/'.$id_karyawan)->with('konfirm', 'Perubahan Data Keluarga karyawan berhasil disimpan.');
    }
    public function hapus_keluarga($id, $id_karyawan)
    {
        $del = KeluargaModel::find($id);
        $del->delete();
        return redirect('hrd/karyawan/tambahdatakeluarga/'.$id_karyawan)->with('konfirm', 'Data Keluarga karyawan berhasil dihapus.');
    }
    //Riwayat Pendidikan
    public function tambah_rwyt_pendidikan($id)
    {
        $res_profil = KaryawanModel::find($id);
        $res_rwyt_pendidikan = RiwayatPendidikanModel::where('id_karyawan', $id)->get();
        $all_jenjang = Config::get("constants.jenjang_pendidikan");
        return view('HRD.karyawan.rwyt_pendidikan.add_pendidikan', ['res'=>$res_profil, 'list_rwyt_pendidikan' => $res_rwyt_pendidikan, 'list_jenjang'=>$all_jenjang]);
    }
    public function simpan_rwyt_pendidikan(Request $request)
    {
        $id_karyawan = $request->id_karyawan;
        RiwayatPendidikanModel::create([
            "id_karyawan" => $id_karyawan,
            "id_jenjang" => $request->pil_jenjang,
            "nm_sekolaj_pt" => $request->inp_nama,
            "alamat" => $request->inp_alamat,
            "mulai_tahun" => $request->inp_tahun_mulai,
            "sampai_tahun" => $request->inp_tahun_akhir
        ]);
        return redirect('hrd/karyawan/tambahrwytpendidikan/'.$id_karyawan)->with('konfirm', 'Data Riwayat Pendidikan karyawan berhasil disimpan.');
    }
    public function edit_rwyt_pendidikan($id)
    {
        $res_rwyt_pendidikan = RiwayatPendidikanModel::find($id);
        $all_jenjang = Config::get("constants.jenjang_pendidikan");
        return view('HRD.karyawan.rwyt_pendidikan.edt_pendidikan', ['res_pendidikan'=>$res_rwyt_pendidikan, 'list_jenjang'=>$all_jenjang]);
    }
    public function update_rwyt_pendidikan(Request $request, $id)
    {
        $id_karyawan = $request->id_karyawan;
        $update = RiwayatPendidikanModel::find($id);
        $update->id_jenjang = $request->pil_jenjang;
        $update->nm_sekolaj_pt = $request->inp_nama;
        $update->alamat = $request->inp_alamat;
        $update->mulai_tahun = $request->inp_tahun_mulai;
        $update->sampai_tahun = $request->inp_tahun_akhir;
        $update->save();
        return redirect('hrd/karyawan/tambahrwytpendidikan/'.$id_karyawan)->with('konfirm', 'Perubahan Data Riwayat Pendidikan karyawan berhasil disimpan.');
    }
    public function hapus_rwyt_pendidikan($id, $id_karyawan)
    {
        $del = RiwayatPendidikanModel::find($id);
        $del->delete();
        return redirect('hrd/karyawan/tambahrwytpendidikan/'.$id_karyawan)->with('konfirm', 'Data Riwayat Pendidikan karyawan berhasil dihapus.');
    }
    //Pengalaman Kerja
    public function tambah_pengalaman_kerja($id)
    {
        $res_profil = KaryawanModel::find($id);
        $res_kerja = PengalamanKerjaModel::where('id_karyawan', $id)->get();
        return view('HRD.karyawan.pengalaman_kerja.add_data', ['res'=>$res_profil, 'list_pengalaman_kerja' => $res_kerja]);
    }
    public function simpan_pengalaman_kerja(Request $request)
    {
        $id_karyawan = $request->id_karyawan;
        PengalamanKerjaModel::create([
            "id_karyawan" => $id_karyawan,
            "nm_perusahaan" => $request->inp_nama,
            "posisi" => $request->inp_posisi,
            "alamat" => $request->inp_alamat,
            "mulai_tahun" => $request->inp_tahun_mulai,
            "sampai_tahun" => $request->inp_tahun_akhir
        ]);
        return redirect('hrd/karyawan/tambahpengalamankerja/'.$id_karyawan)->with('konfirm', 'Data Pengalaman Kerja karyawan berhasil disimpan.');
    }
    public function edit_pengalaman_kerja($id)
    {
        $res_kerja = PengalamanKerjaModel::find($id);
        return view('HRD.karyawan.pengalaman_kerja.edt_data', ['res_kerja'=>$res_kerja]);
    }
    public function update_pengalaman_kerja(Request $request, $id)
    {
        $id_karyawan = $request->id_karyawan;
        $update = PengalamanKerjaModel::find($id);
        $update->nm_perusahaan = $request->inp_nama;
        $update->posisi = $request->inp_posisi;
        $update->alamat = $request->inp_alamat;
        $update->mulai_tahun = $request->inp_tahun_mulai;
        $update->sampai_tahun = $request->inp_tahun_akhir;
        $update->save();
        return redirect('hrd/karyawan/tambahpengalamankerja/'.$id_karyawan)->with('konfirm', 'Perubahan Data Pengalaman Kerja karyawan berhasil disimpan.');
    }
    public function hapus_pengalaman_kerja($id, $id_karyawan)
    {
        $del = PengalamanKerjaModel::find($id);
        $del->delete();
        return redirect('hrd/karyawan/tambahpengalamankerja/'.$id_karyawan)->with('konfirm', 'Data Pengalaman Kerja karyawan berhasil dihapus.');
    }
    //Dokumen
    public function tambah_dokumen($id)
    {
        $res_profil = KaryawanModel::find($id);
        $res_dokumen = DokumenKaryawanjaModel::where('id_karyawan', $id)->get();
        $res_jenis_dok = JenisDokumenKaryawanModel::where('status', 1)->get();
        return view('HRD.karyawan.dokumen.add_data', ['res'=>$res_profil, 'list_dokumen' => $res_dokumen, 'list_jenis_dok'=>$res_jenis_dok]);
    }
    public function simpan_dokumen(Request $request)
    {
        $path = storage_path("app/public/hrd/dokumen/".$request->input('nik'));

        if(!File::isDirectory($path)) {
            $path = Storage::disk('public')->makeDirectory('hrd/dokumen/'.$request->input('nik'));
        }
        //dd(array($request));
        $sumsave=0;
        $sumupdate=0;
        $destinationPath = 'app/public/hrd/dokumen/'.$request->input('nik')."/"; // upload path

        $id_karyawan = $request->id_karyawan;
        $countitem = count($request->input('id_dokumen'));
        $allowedfileExtension=['jpg','png','jpeg', 'JPG'];

        foreach (array($request) as $key => $value)
        {
            for($i=0; $i < $countitem; $i++)
            {
                $id_dok = $value['id_dokumen'][$i];
                if(!empty($value->file('input-file')[$i]))
                {
                    $image = $value->file('input-file')[$i];
                    $extension = $image->getClientOriginalExtension();
                    $check=in_array($extension,$allowedfileExtension);
                    if($check)
                    {
                        $cek_data = $this->cek_data_dokumen($id_karyawan, $id_dok);
                        if(count($cek_data)==0)
                        {
                            $files = $value->file('input-file')[$i];
                            $filename = date('dmY').time()."-".$id_dok."-".$id_karyawan;
                            $file_sv = $filename.".".$extension;
                            $image_resize = Image::make($files->getRealPath());
                            //$image_resize->resize(420, 420);
                            //$image_resize->save(storage_path("app/public/hrd/photo/".$filename));


                            $image_resize->save(storage_path($destinationPath.$file_sv));
                            DokumenKaryawanjaModel::create([
                                'id_karyawan' => $id_karyawan,
                                'id_dokumen' => $id_dok,
                                'file_dokumen' => $file_sv
                            ]);
                            $sumsave++;
                        } else {
                            //hapus data lama
                            $this->del_image_in_folder_and_data($id_karyawan, $id_dok, $request->input('nik'));
                            //simpan data baru
                            $files = $value->file('input-file')[$i];
                            $filename = date('dmY').time()."-".$id_dok;
                            $file_sv = $filename.".".$extension;
                            $image_resize = Image::make($files->getRealPath());
                            //$image_resize->resize(420, 420);
                            //$image_resize->save(public_path().$destinationPath.$file_sv, 60);
                            $image_resize->save(storage_path($destinationPath.$file_sv));
                            DokumenKaryawanjaModel::create([
                                'id_karyawan' => $id_karyawan,
                                'id_dokumen' => $id_dok,
                                'file_dokumen' => $file_sv
                            ]);
                            $sumupdate++;
                        }
                    }
                }
            }
        }
        return redirect('hrd/karyawan/tambahdokumen/'.$id_karyawan)->with('konfirm', 'Data Dokumen karyawan berhasil disimpan.');
    }
    public function cek_data_dokumen($id_karyawan, $id_dokumen)
    {
        $result = DokumenKaryawanjaModel::where('id_karyawan', $id_karyawan)->where('id_dokumen', $id_dokumen)->get();
        return $result;
    }
    public function del_image_in_folder_and_data($id_karyawan, $id_dokumen, $nik)
    {
        $resfile = DokumenKaryawanjaModel::where('id_karyawan', $id_karyawan)->where('id_dokumen', $id_dokumen)->first();
        $id_data = $resfile->id;
        $filename = $resfile->file_dokumen;
        //$image_path = public_path().'/upload/dokumen/'.$filename;

        $image_path = storage_path('app/public/hrd/dokumen/'.$nik."/".$filename);

        if(File::exists($image_path)) {
            File::delete($image_path);
        }
        DokumenKaryawanjaModel::find($id_data)->delete($id_data);
    }
    //tools
    public function importData()
    {
        $all_level =  LevelJabatanModel::orderBy("level")->get();
        $all_divisi = DivisiModel::where('status', 1)->get();
        //$all_departemen = DepartemenModel::where('status', 1)->get();
        //$all_subdepartemen = SubDepartemenModel::all();
        $all_perdis = PerdisModel::all();
        $all_jabatan = JabatanModel::where('status', 1)->where('id_divisi', 0)->orderby('id_level', 'asc')->get();
        return view("HRD.karyawan.tools.import_data", compact(['all_level', 'all_divisi', 'all_jabatan', 'all_perdis']));
    }
    public function previewImport(Request $request)
    {
        $request->validate([
            'file_imp' => 'required|mimes:xlsx,csv,xls'
        ]);

        $file = $request->file('file_imp');
        $extension = strtolower($file->getClientOriginalExtension());
        
        $fileName = 'import_karyawan_' . time() . '.' . $extension;
        $tempPath = storage_path('app/temp');
        if (!file_exists($tempPath)) {
            mkdir($tempPath, 0755, true);
        }
        $file->move($tempPath, $fileName);
        $fullPath = $tempPath . DIRECTORY_SEPARATOR . $fileName;

        if (!file_exists($fullPath)) {
            return back()->with('error', 'Gagal Import: File gagal dipindahkan ke direktori sementara.');
        }

        $readerType = null;
        if ($extension === 'xlsx') {
            $readerType = \Maatwebsite\Excel\Excel::XLSX;
        } elseif ($extension === 'csv') {
            $readerType = \Maatwebsite\Excel\Excel::CSV;
        }

        $data = Excel::toArray(new KaryawanImport, $fullPath, null, $readerType)[0]; // get the first sheet

        $divisi_ids = DivisiModel::pluck('id')->toArray();
        $dept_ids = DepartemenModel::pluck('id')->toArray();
        $subdept_ids = SubDepartemenModel::pluck('id')->toArray();
        $jabatan_ids = JabatanModel::pluck('id')->toArray();
        $agama_keys = array_keys(Config::get("constants.agama") ?? []);
        $pendidikan_keys = array_keys(Config::get("constants.jenjang_pendidikan") ?? []);
        $status_nikah_keys = array_keys(Config::get("constants.status_pernikahan") ?? []);
        $status_karyawan_keys = array_keys(Config::get("constants.status_karyawan") ?? []);

        $preview_data = [];
        $hasValidData = false;

        foreach ($data as $row) {
            $isValid = true;
            $errors = [];

            // Skip empty rows (nik is required)
            if (empty($row['nik'])) continue;

            $tgl_masuk = $row['tanggal_masuk'] ?? null;
            $tgl_lahir = $row['tanggal_lahir'] ?? null;

            if (is_numeric($tgl_masuk)) {
                try {
                    $tgl_masuk = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tgl_masuk)->format('Y-m-d');
                    $row['tanggal_masuk'] = $tgl_masuk;
                } catch (\Exception $e) {}
            }
            if (is_numeric($tgl_lahir)) {
                try {
                    $tgl_lahir = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tgl_lahir)->format('Y-m-d');
                    $row['tanggal_lahir'] = $tgl_lahir;
                } catch (\Exception $e) {}
            }

            // Validate dates (YYYY-MM-DD)
            if (!empty($tgl_masuk) && !preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $tgl_masuk)) {
                $isValid = false;
                $errors[] = "Format tanggal masuk tidak valid (harus YYYY-MM-DD)";
            }
            if (!empty($tgl_lahir) && !preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $tgl_lahir)) {
                $isValid = false;
                $errors[] = "Format tanggal lahir tidak valid (harus YYYY-MM-DD)";
            }

            $jenkel = $row['jenis_kelamin_id'] ?? null;
            $agama = $row['agama_id'] ?? null;
            $pendidikan_akhir = $row['pendidikan_akhir_id'] ?? null;
            $status_nikah = $row['status_pernikahan_id'] ?? null;
            $id_status_karyawan = $row['status_akryawan_id'] ?? null;
            $id_divisi = $row['divisi_id'] ?? null;
            $id_departemen = $row['departemen_id'] ?? null;
            $id_subdepartemen = $row['sub_departemen_id'] ?? null;
            $id_jabatan = $row['jabatan_id'] ?? null;

            // Validate Jenkel
            if (!empty($jenkel) && !in_array($jenkel, [1, 2])) {
                $isValid = false;
                $errors[] = "Jenis Kelamin tidak valid (1/2)";
            }

            // Validate Agama
            if (!empty($agama) && !in_array($agama, $agama_keys)) {
                $isValid = false;
                $errors[] = "Agama ID tidak valid";
            }

            // Validate Pendidikan
            if (!empty($pendidikan_akhir) && !in_array($pendidikan_akhir, $pendidikan_keys)) {
                $isValid = false;
                $errors[] = "Pendidikan Akhir ID tidak valid";
            }

            // Validate Status Nikah
            if (!empty($status_nikah) && !in_array($status_nikah, $status_nikah_keys)) {
                $isValid = false;
                $errors[] = "Status Nikah ID tidak valid";
            }

            // Validate Status Karyawan
            if (!empty($id_status_karyawan) && !in_array($id_status_karyawan, $status_karyawan_keys)) {
                $isValid = false;
                $errors[] = "Status Karyawan ID tidak valid";
            }

            // Validate Divisi
            if (!empty($id_divisi) && $id_divisi != 0 && !in_array($id_divisi, $divisi_ids)) {
                $isValid = false;
                $errors[] = "Divisi ID tidak ditemukan di Master Divisi";
            }

            // Validate Departemen
            if (!empty($id_departemen) && $id_departemen != 0 && !in_array($id_departemen, $dept_ids)) {
                $isValid = false;
                $errors[] = "Departemen ID tidak ditemukan di Master Departemen";
            }

            // Validate Sub Departemen
            if (!empty($id_subdepartemen) && $id_subdepartemen != 0 && !in_array($id_subdepartemen, $subdept_ids)) {
                $isValid = false;
                $errors[] = "Sub Departemen ID tidak ditemukan di Master Sub Departemen";
            }

            // Validate Jabatan
            if (!empty($id_jabatan) && $id_jabatan != 0 && !in_array($id_jabatan, $jabatan_ids)) {
                $isValid = false;
                $errors[] = "Jabatan ID tidak ditemukan di Master Jabatan";
            }

            if ($isValid) {
                $hasValidData = true;
            }

            $preview_data[] = [
                'isValid' => $isValid,
                'errors' => $errors,
                'data' => $row
            ];
        }

        return view('HRD.karyawan.tools.preview_import', [
            'preview_data' => $preview_data,
            'file_path' => $fullPath,
            'hasValidData' => $hasValidData
        ]);
    }

    public function processImport(Request $request)
    {
        $file_path = $request->input('file_path');
        if (!file_exists($file_path)) {
            return redirect('hrd/karyawan/importTools')->with('konfirm', 'File import tidak ditemukan atau sudah kadaluarsa.');
        }

        Excel::import(new \App\Imports\KaryawanUpsertImport, $file_path);

        if (file_exists($file_path)) {
            unlink($file_path);
        }

        return redirect('hrd/karyawan/importTools')->with('konfirm', 'Proses Import Selesai. Data valid telah disimpan/diupdate.');
    }
    public function doHapusDBKaryawan()
    {
        $del = KaryawanModel::where('nik', '<>', '999999999');
        $del->delete();
        return redirect('hrd/karyawan/daftar')->with('konfirm', 'Data karyawan berhasil dihapus.');
    }
     //import ID Finger Karyawan
    public function importIDFinger()
    {
        $all_departemen = DepartemenModel::where('status', 1)->get();
        return view("HRD.karyawan.tools.import_id_finger", compact(['all_departemen']));
    }

    public function templateIDFingerKaryawan()
    {
        return Excel::download(new KaryawanIDFingerExport, 'templateIDFingerKaryawan.xlsx');
        // return (new KaryawanExport($id_departemen))->download('karyawanexport-'.$id_departemen.'.xlsx');
    }

    public function doImportFinger(Request $request)
    {
        try {
            // $file = $request->file('file_imp');
            Excel::import(new IDFingerKaryawanImport, request()->file_imp);
            return back()->withStatus('Excel file import succesfully');
        } catch (\Exception $ex) {
            return back()->withStatus($ex->getMessage());
        }

    }
    //Export/Import Absensi
    public function templateAbsensiKaryawan()
    {
        return Excel::download(new AbsensiTemplateExport, 'templateAbsensiKaryawan.xlsx');
    }

    //karyawan bpjs
    public function karyawan_bpjs()
    {
        $all_sts_karyawan = Config::get("constants.status_karyawan");
        $all_departemen = DepartemenModel::where('status', 1)->get()->map( function($row) {
            $arr = $row->toArray();
            $arr['total'] = KaryawanModel::where('id_departemen', $arr['id'])->where('nik', '<>', '999999999')->get()->count();
            $arr['total_laki'] = KaryawanModel::where('jenkel', 1)->where('id_departemen', $arr['id'])->where('nik', '<>', '999999999')->get()->count();
            $arr['total_perempuan'] = KaryawanModel::where('jenkel', 2)->where('id_departemen', $arr['id'])->where('nik', '<>', '999999999')->get()->count();
            return $arr;
        });
        $all_non_departemen = array(

            'total_non' => KaryawanModel::whereNull('id_departemen')->where('nik', '<>', '999999999')->get()->count(),
            'total_laki_non' => KaryawanModel::whereNull('id_departemen')->where('jenkel', 1)->where('nik', '<>', '999999999')->get()->count(),
            'total_perempuan_non' => KaryawanModel::whereNull('id_departemen')->where('jenkel', 2)->where('nik', '<>', '999999999')->get()->count()
        );
        $total_karyawan = KaryawanModel::where('nik', '<>', '999999999')->get()->count();
        // dd($all_non_departemen);
        // dd($all_departemen);
        return view('HRD.karyawan.bpjs.index', [
            'sts_karyawan'=>$all_sts_karyawan,
            'list_departemen' => $all_departemen,
            'total_karyawan' => $total_karyawan,
            'non_departemen' => $all_non_departemen
        ]);
    }

    public function karyawan_bpjs_filter_all()
    {
        $data['list_data'] = KaryawanModel::with([
                            'get_jabatan',
                            'get_departemen'
                        ])->where('nik', '<>', '999999999')->get();
        return view('HRD.karyawan.bpjs.result_filter', $data);
    }
    public function karyawan_bpjs_filter_departemen($departemen)
    {
        if($departemen=='non') {
            $data['list_data'] = KaryawanModel::with('get_jabatan')->where('nik', '<>', '999999999')->whereNull('id_departemen')->get();
        } else {
            $data['list_data'] = KaryawanModel::with('get_jabatan')->where('nik', '<>', '999999999')->where('id_departemen', $departemen)->get();
        }
        return view('HRD.karyawan.bpjs.result_filter', $data);
    }
    public function karyawan_bpjs_filter_departemen_gender($departemen, $gender)
    {
        if($departemen=='non') {
            $data['list_data'] = KaryawanModel::with('get_jabatan')->where('nik', '<>', '999999999')->whereNull('id_departemen')->where('jenkel', $gender)->get();
        } else {
            $data['list_data'] = KaryawanModel::with('get_jabatan')->where('nik', '<>', '999999999')->where('id_departemen', $departemen)->where('jenkel', $gender)->get();
        }

        return view('HRD.karyawan.bpjs.result_filter', $data);
    }
    public function karyawan_bpjs_setting($id)
    {
        $data = [
            'resProfil' => KaryawanModel::with([
                'get_jabatan',
                'get_departemen'
            ])->find($id)
        ];
        return view('HRD.karyawan.bpjs.form_setting', $data);
    }
    public function karyawan_bpjs_setting_simpan(Request $request, $id)
    {
        try {
            $data = [
                "bpjs_kesehatan" => (isset($request->check_bpjs_ks)) ? "y" : null,
                "bpjs_tk_jht" => (isset($request->check_jht)) ? "y" : null,
                "bpjs_tk_jkk" => (isset($request->check_jkk)) ? "y" : null,
                "bpjs_tk_jkm" => (isset($request->check_jkm)) ? "y" : null,
                "bpjs_tk_jp" => (isset($request->check_jp)) ? "y" : null,
            ];
            KaryawanModel::find($id)->update($data);
            return redirect('hrd/karyawan/karyawan_bpjs')->with('konfirm', 'Pengaturan BPJS Karyawan berhasil disimpan.');
        } catch (\Exception $ex) {
            return redirect('hrd/karyawan/karyawan_bpjs')->with('konfirm', $ex->getMessage());
            // return back()->withStatus($ex->getMessage());
        }
    }
}
