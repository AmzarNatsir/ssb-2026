<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HRD\ProfilPerusahaanModel;
use App\Models\HRD\LevelJabatanModel;
use App\Models\HRD\DepartemenModel;
use App\Models\HRD\JabatanModel;
use App\Models\HRD\SubDepartemenModel;
use App\Models\HRD\StatusKaryawanModel;
use App\Models\HRD\JenisCutiIzinModel;
use App\Models\HRD\DivisiModel;
use App\Models\HRD\FasilitasPerdisModel;
use App\Models\HRD\JenisSPModel;
use App\Models\HRD\UangSakuPerdisModel;
use App\Models\HRD\BankPenggajianModel;
use App\Models\HRD\KategoriPenggajianModel;
use App\Models\HRD\JenisDokumenKaryawanModel;
use App\Models\HRD\PelaksanaDiklatModel;
use App\Exports\LevelJabatanExport;
use App\Exports\DivisiExport;
use App\Exports\DepartemenExport;
use App\Exports\SubDepartemenExport;
use App\Exports\JabatanExport;
use App\Models\HRD\JenisPelanggaranModel;
use App\Models\HRD\KaryawanModel;
use App\Models\HRD\KPIModel;
use App\Models\HRD\KPIPerspektifModel;
use App\Models\HRD\KPISasaranModel;
use App\Models\HRD\KPISatuanModel;
use App\Models\HRD\KPITipeModel;
use App\Models\HRD\PotonganGajiModel;
use App\Models\HRD\MasterPelatihanModel;
use App\Models\HRD\StatusTanggunganModel;
use Barryvdh\DomPDF\PDF;
use Dompdf\Dompdf;
//use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

// use File;

class MasterDataController extends Controller
{
    public function profil_perusahaan()
    {
        $profil_perusahaan = ProfilPerusahaanModel::first();
        return view('HRD.masterdata.profil_perusahaan.index', ['profil'=>$profil_perusahaan]);
    }
    public function simpan_profil_perusahaan(Request $request)
    {
        $id_perusahaan = $request->id_perusahaan;
        $path = storage_path("app/public/logo_perusahaan");
        if(!File::isDirectory($path)) {
            $path = Storage::disk('public')->makeDirectory('logo_perusahaan');
        }

        if(empty($id_perusahaan))
        {
            if($request->hasfile('inp_file'))
            {
                $file = $request->file('inp_file');
                $fl_name = time().date('dmY').".".$file->getClientOriginalExtension();
                $image_resize = Image::make($file->getRealPath());
                $image_resize->save(storage_path("app/public/logo_perusahaan/".$fl_name));
                //$file->move(public_path().'/upload/logo_perusahaan/', $fl_name);
            }
            $fields = ProfilPerusahaanModel::create([
                'nm_perusahaan' => $request->inp_nama,
                'alamat' => $request->inp_alamat,
                'kelurahan' => $request->inp_kelurahan,
                'kecamatan' => $request->inp_kecamatan,
                'kabupaten' => $request->inp_kabupaten,
                'provinsi' => $request->inp_provinsi,
                'no_telpon' => $request->inp_notelp,
                'no_fax' => $request->inp_nofax,
                'nm_emaili' => $request->inp_email,
                'nm_pimpinan' => $request->inp_nm_pimpinan,
                'logo_perusahaan' => $fl_name

            ]);
        } else {
            if($request->hasfile('inp_file'))
            {
                $this->del_image_folder($id_perusahaan);
                $file = $request->file('inp_file');
                $fl_name = time().date('dmY').".".$file->getClientOriginalExtension();
                $image_resize = Image::make($file->getRealPath());
                $image_resize->save(storage_path("app/public/logo_perusahaan/".$fl_name));
                //$file->move(public_path().'/upload/logo_perusahaan/', $fl_name);
                $field = ProfilPerusahaanModel::find($id_perusahaan);
                $field->nm_perusahaan = $request->inp_nama;
                $field->alamat = $request->inp_alamat;
                $field->kelurahan = $request->inp_kelurahan;
                $field->kecamatan = $request->inp_kecamatan;
                $field->kabupaten = $request->inp_kabupaten;
                $field->provinsi = $request->inp_provinsi;
                $field->no_telpon = $request->inp_notelp;
                $field->no_fax = $request->inp_nofax;
                $field->nm_emaili = $request->inp_email;
                $field->nm_pimpinan = $request->inp_nm_pimpinan;
                $field->logo_perusahaan = $fl_name;
            } else {
                $field = ProfilPerusahaanModel::find($id_perusahaan);
                $field->nm_perusahaan = $request->inp_nama;
                $field->alamat = $request->inp_alamat;
                $field->kelurahan = $request->inp_kelurahan;
                $field->kecamatan = $request->inp_kecamatan;
                $field->kabupaten = $request->inp_kabupaten;
                $field->provinsi = $request->inp_provinsi;
                $field->no_telpon = $request->inp_notelp;
                $field->no_fax = $request->inp_nofax;
                $field->nm_emaili = $request->inp_email;
                $field->nm_pimpinan = $request->inp_nm_pimpinan;
            }
            $field->save();
        }
        return redirect('hrd/masterdata/profilperusahaan')->with('konfirm', 'Data berhasil disimpan');
    }
    public function del_image_folder($id)
    {
        $resfile = ProfilPerusahaanModel::where('id', $id)->first();
        $filename = $resfile->logo_perusahaan;
        $image_path = storage_path('app/public/logo_perusahaan/'.$filename);
        if(File::exists($image_path)) {
            File::delete($image_path);
        }
    }
    //master level jabatan
    public function level_jabatan()
    {
        $all_level = LevelJabatanModel::orderBy("level")->get();
        return view("HRD.masterdata.level_jabatan.index", ["list_level"=>$all_level]);
    }
    public function simpan_level_jabatan(Request $request)
    {
        $simpan = LevelJabatanModel::create([
            'nm_level' => $request->inp_nama_lvl,
            'level' => $request->inp_level,
            'status' => 1
        ]);
        return redirect('hrd/masterdata/leveljabatan')->with('konfirm', 'Data berhasil disimpan');
    }
    public function edit_level_jabatan($id)
    {
        $result = LevelJabatanModel::find($id);
        return view("HRD.masterdata.level_jabatan.edit", ["res"=>$result]);
    }
    public function update_level_jabatan(Request $request, $id)
    {
        $update = LevelJabatanModel::find($id);
        $update->nm_level = $request->inp_nama_lvl;
        $update->level = $request->inp_level;
        $update->status = $request->rdo_status;
        $update->save();
        return redirect('hrd/masterdata/leveljabatan')->with('konfirm', 'Perubaha Data berhasil disimpan');
    }
    public function hapus_level_jabatan($id)
    {
        $del = LevelJabatanModel::find($id);
        $del->delete();
        return redirect('hrd/masterdata/leveljabatan')->with('konfirm', 'Data berhasil dihapus');
    }
    public function excellLevel()
    {
        return Excel::download(new LevelJabatanExport, 'masterleveljabatan.xlsx');
    }
    //Departemen
    public function departemen()
    {
        $result = \DB::table('mst_hrd_departemen')
            ->leftjoin('mst_hrd_divisi', 'mst_hrd_departemen.id_divisi', '=', 'mst_hrd_divisi.id')
            ->select('mst_hrd_departemen.*', 'mst_hrd_divisi.nm_divisi')->get();
        //dd($result);

        //DepartemenModel::with('get_master_divisi')->get();
        //dd($result);
        $res_divisi = DivisiModel::all();
        return view("HRD.masterdata.departemen.index", ['list_departemen'=>$result, 'list_divisi'=>$res_divisi]);
    }
    public function simpan_departemen(Request $request)
    {
        $simpan = DepartemenModel::create([
            'id_divisi' => $request->pil_divisi,
            'nm_dept' => $request->inp_nama,
            'status' => 1
        ]);
        return redirect('hrd/masterdata/departemen')->with('konfirm', 'Data berhasil disimpan');
    }
    public function edit_departemen($id)
    {
        $result = DepartemenModel::find($id);
        $res_divisi = DivisiModel::all();
        return view("HRD.masterdata.departemen.edit", ["res"=>$result, "list_divisi"=>$res_divisi]);
    }
    public function update_departemen(Request $request, $id)
    {
        $update = DepartemenModel::find($id);
        $update->nm_dept = $request->inp_nama;
        $update->id_divisi = $request->pil_divisi;
        $update->status = $request->rdo_status;
        $update->save();
        return redirect('hrd/masterdata/departemen')->with('konfirm', 'Perubaha Data berhasil disimpan');
    }
    public function hapus_departemen($id)
    {
        $del = DepartemenModel::find($id);
        $del->delete();
        return redirect('hrd/masterdata/departemen')->with('konfirm', 'Data berhasil dihapus');
    }
    public function exceldepartemen()
    {
        return Excel::download(new DepartemenExport, 'masterdepartemen.xlsx');
    }
    //Master Sub Departemen
    public function sub_departemen()
    {
        $result = SubDepartemenModel::all();
        $res_divisi = DivisiModel::all();
        $all_dept = DepartemenModel::all();
        return view("HRD.masterdata.sub_departemen.index", ['list_subdepartemen'=>$result, 'list_departemen'=>$all_dept, 'list_divisi'=>$res_divisi]);
    }
    public function load_departement($id_divisi)
    {
        $res_departemen = DepartemenModel::where('status', 1)->where('id_divisi', $id_divisi)->get();
        echo "<option value='0'>Non Departemen</option>";
        foreach($res_departemen as $list_dept){
            echo "<option value=".$list_dept->id.">".$list_dept->nm_dept."</option>";
        }
    }
    public function simpan_subdepartemen(Request $request)
    {
        $simpan = SubDepartemenModel::create([
            'nm_subdept' => $request->inp_nama,
            'id_dept' => $request->pil_departemen,
            'id_divisi' => $request->pil_divisi
        ]);
        return redirect('hrd/masterdata/subdepartemen')->with('konfirm', 'Data berhasil disimpan');
    }
    public function edit_subdepartemen($id)
    {
        $all_dept = DepartemenModel::all();
        $res_divisi = DivisiModel::all();
        $result = SubDepartemenModel::find($id);
        return view("HRD.masterdata.sub_departemen.edit", ["res"=>$result, 'list_departemen'=>$all_dept, 'list_divisi'=>$res_divisi]);
    }
    public function update_subdepartemen(Request $request, $id)
    {
        $update = SubDepartemenModel::find($id);
        $update->nm_subdept = $request->inp_nama;
        $update->id_dept = $request->pil_departemen;
        $update->id_divisi = $request->pil_divisi;
        $update->save();
        return redirect('hrd/masterdata/subdepartemen')->with('konfirm', 'Perubaha Data berhasil disimpan');
    }
    public function hapus_subdepartemen($id)
    {
        $del = SubDepartemenModel::find($id);
        $del->delete();
        return redirect('hrd/masterdata/subdepartemen')->with('konfirm', 'Data berhasil dihapus');
    }
    public function excelsubdepartemen()
    {
        return Excel::download(new SubDepartemenExport, 'mastersubdepartemen.xlsx');
    }
    //jabatan
    public function jabatan()
    {
        $res_divisi = DivisiModel::all();
        $data_lvl_jabatan = LevelJabatanModel::where('status', 1)->orderBy('level', 'asc')->get();
        $data_jabatan = \DB::table('mst_hrd_jabatan')
                ->leftjoin('mst_hrd_departemen', 'mst_hrd_jabatan.id_dept', '=', 'mst_hrd_departemen.id')
                ->leftjoin('mst_hrd_sub_departemen', 'mst_hrd_jabatan.id_subdept', '=', 'mst_hrd_sub_departemen.id')
                ->leftjoin('mst_hrd_divisi', 'mst_hrd_jabatan.id_divisi', '=', 'mst_hrd_divisi.id')
                ->leftjoin('mst_hrd_level_jabatan', 'mst_hrd_jabatan.id_level', '=', 'mst_hrd_level_jabatan.id')
                ->Select('mst_hrd_jabatan.*', 'mst_hrd_departemen.nm_dept', 'mst_hrd_sub_departemen.nm_subdept', 'mst_hrd_divisi.nm_divisi', 'mst_hrd_level_jabatan.nm_level', 'mst_hrd_level_jabatan.level')->orderby('mst_hrd_level_jabatan.level')->get();

        //JabatanModel::orderBy('id_level', 'asc')->get();
        return view("HRD.masterdata.jabatan.index", ['list_level_jabatan'=>$data_lvl_jabatan, 'list_jabatan'=>$data_jabatan, 'list_divisi'=>$res_divisi]);
    }
    public function add_jabatan()
    {
        $res_divisi = DivisiModel::all();
        $data_lvl_jabatan = LevelJabatanModel::where('status', 1)->orderBy('level', 'asc')->get();
        return view('HRD.masterdata.jabatan.add', ['list_level_jabatan' => $data_lvl_jabatan, 'list_divisi' => $res_divisi]);
    }
    public function load_subdepartement($id_departemen)
    {
        $res_subdept = SubDepartemenModel::where('id_dept', $id_departemen)->get();
        echo "<option value='0'>Non Sub Departemen</option>";
        foreach($res_subdept as $list){
            echo "<option value=".$list->id.">".$list->nm_subdept."</option>";
        }
    }
    public function load_jabatan_gakom($id_level)
    {
        $res_jabatan_gakom = JabatanModel::where('id_level', '<', $id_level)->get();
        echo "<option value='0'>Non Garis Komando</option>";
        foreach($res_jabatan_gakom as $list){
            echo "<option value=".$list->id.">".$list->nm_jabatan."</option>";
        }
    }
    public function simpan_jabatan(Request $request)
    {
        $simpan_divisi = ($request->pil_divisi==0) ? NULL : $request->pil_divisi;
        $simpan_departemen = ($request->pil_departemen==0) ? NULL : $request->pil_departemen;
        $simpan_subdept = ($request->pil_subdepartemen==0) ? NULL : $request->pil_subdepartemen;
        $simpan_gakom = ($request->pil_gakom==0) ? NULL : $request->pil_gakom;
        $simpan = JabatanModel::create([
            'id_level' => $request->pil_lvl_jabatan,
            'id_divisi' => $simpan_divisi,
            'id_dept' => $simpan_departemen,
            'id_subdept' => $simpan_subdept,
            'nm_jabatan' =>$request->inp_nama,
            'id_gakom' => $simpan_gakom,
            'status' => 1
        ]);
        return redirect('hrd/masterdata/jabatan')->with('konfirm', 'Data berhasil disimpan');
    }
    public function edit_jabatan($id)
    {
        $res_divisi = DivisiModel::all();
        $data_lvl_jabatan = LevelJabatanModel::where('status', 1)->orderBy('level', 'asc')->get();
        $result = JabatanModel::find($id);
        $res_dept = DepartemenModel::where('status', 1)->where('id_divisi', $result->id_divisi)->get();
        $res_subdept = SubDepartemenModel::where('id_dept', $result->id_dept)->get();
        $res_jabatan_gakom = JabatanModel::where('id_level', '<', $result->id_level)->get();
        return view("HRD.masterdata.jabatan.edit", ["res"=>$result, 'list_level_jabatan'=>$data_lvl_jabatan, 'list_divisi'=>$res_divisi, 'list_departemen'=>$res_dept, 'list_subdept'=>$res_subdept, 'res_jabatan_gakom' => $res_jabatan_gakom]);
    }
    public function update_jabatan(Request $request, $id)
    {
        $filenameupload=NULL;
        if($request->hasFile('inp_file_jobdesc'))
        {
            if($request->tmp_file)
            {
                $image_path = storage_path('app/public/'.$request->tmp_file);
                if(File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            $find = array(" ", "-", "(", ")");
            $replace = "_";
            $file = $request->file('inp_file_jobdesc');
            $extension = $file->getClientOriginalExtension();
            $new_filename = strtolower(str_replace($find, $replace, $request->inp_nama)).".".$extension;
            $foler_new = strtolower(str_replace($find, $replace, $request->inp_nama));
            $path = storage_path("app/public/hrd/jobdesc");
            if(!File::isDirectory($path)) {
                $path = Storage::disk('public')->makeDirectory('hrd/jobdesc');
            }
            $filenameupload = Storage::disk('public')->put('hrd/jobdesc/'.$foler_new, $file);
        }

        $simpan_divisi = ($request->pil_divisi==0) ? NULL : $request->pil_divisi;
        $simpan_departemen = ($request->pil_departemen==0) ? NULL : $request->pil_departemen;
        $simpan_subdept = ($request->pil_subdepartemen==0) ? NULL : $request->pil_subdepartemen;
        $simpan_gakom = ($request->pil_gakom==0) ? NULL : $request->pil_gakom;

        $update = JabatanModel::find($id);
        $update->nm_jabatan = $request->inp_nama;
        $update->id_level = $request->pil_lvl_jabatan;
        $update->id_divisi = $simpan_divisi;
        $update->id_dept = $simpan_departemen;
        $update->id_subdept = $simpan_subdept;
        $update->id_gakom = $simpan_gakom;
        $update->status = $request->rdo_status;
        $update->file_jobdesc = $filenameupload;
        $update->save();
        return redirect('hrd/masterdata/jabatan')->with('konfirm', 'Perubaha Data berhasil disimpan');
    }
    public function hapus_jabatan($id)
    {
        $checkUsed = KaryawanModel::where('id_jabatan', $id)->get()->count();
        if($checkUsed == 0) {
            $del = JabatanModel::find($id);
            $del->delete();
            return redirect('hrd/masterdata/jabatan')->with('konfirm', 'Data berhasil dihapus');
        } else {
            return redirect('hrd/masterdata/jabatan')->with('konfirm', 'Data tidak bisa dihapus. Data telah digunakan.');
        }


    }
    public function exceljabatan()
    {
        return Excel::download(new JabatanExport, 'masterjabatan.xlsx');
    }
    public function download_jobdesc($id)
    {
        $file = JabatanModel::find($id);
        $pathToFile = $file->file_jobdesc;
        $path = storage_path('app/public/'.$pathToFile);
        return Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$pathToFile.'"'
        ]);
    }

    public function edit_all_departemen()
    {
        $res_dept = DepartemenModel::where('status', 1)->get();

        return view('HRD.masterdata.jabatan.editAll', ['all_departemen' => $res_dept]);
    }
    public function filter_jabatan($id)
    {
        $res_jabatan = JabatanModel::where('id_dept', $id)->where('status', 1)->orderBy('id_level')->get();
        $res_jabatan_gakom = JabatanModel::where('id_level', '<=', 6)->orderBy('id_level')->get();

        return view('HRD.masterdata.jabatan.viewAllJabatan', ['all_jabatan' => $res_jabatan, 'all_gakom' => $res_jabatan_gakom]);
    }
    public function update_jabatan_all_dept(Request $request)
    {
        $jml_baris = count($request->id_jabatan);
        foreach (array($request) as $key => $value) {
            for ($i = 0; $i < $jml_baris; $i++) {
                if($value['pil_gakom'][$i]<>0)
                {
                    $update = JabatanModel::find($value['id_jabatan'][$i]);
                    $update->id_gakom = $value['pil_gakom'][$i];
                    $update->save();
                }
            }
        }
        return redirect('hrd/masterdata/jabatan')->with('konfirm', 'Pengaturan Atasan Langsung berhasil disimpan');
    }
    //Status Karyawan
    public function status_karyawan()
    {
        $data_status_karyawan = StatusKaryawanModel::all();
        return view("HRD.masterdata.status_karyawan.index", ['list_status_karyawan'=>$data_status_karyawan]);
    }
    public function simpan_status_karyawan(Request $request)
    {
        $simpan = StatusKaryawanModel::create([
            'nm_status' => $request->inp_nama,
            'keterangan' =>$request->inp_deskripsi,
            'status' => 1
        ]);
        return redirect('hrd/masterdata/statuskaryawan')->with('konfirm', 'Data berhasil disimpan');
    }
    public function edit_status_karyawan($id)
    {
        $result = StatusKaryawanModel::find($id);
        return view("HRD.masterdata.status_karyawan.edit", ["res"=>$result]);
    }
    public function update_status_karyawan(Request $request, $id)
    {
        $update = StatusKaryawanModel::find($id);
        $update->nm_status = $request->inp_nama;
        $update->keterangan = $request->inp_deskripsi;
        $update->status = $request->rdo_status;
        $update->save();
        return redirect('hrd/masterdata/statuskaryawan')->with('konfirm', 'Perubaha Data berhasil disimpan');
    }
    public function hapus_status_karyawan($id)
    {
        $del = StatusKaryawanModel::find($id);
        $del->delete();
        return redirect('hrd/masterdata/statuskaryawan')->with('konfirm', 'Data berhasil dihapus');
    }
    //Master Jenis Cuti Izin
    public function jenis_cuti_izin()
    {
        $data_jenis_ci = JenisCutiIzinModel::orderBy('jenis_ci','asc')->get();
        return view("HRD.masterdata.cuti_izin.index", ['list_jenis_ci'=>$data_jenis_ci]);
    }
    public function simpan_jenis_cuti_izin(Request $request)
    {
        $simpan = JenisCutiIzinModel::create([
            'jenis_ci' => $request->pil_jenis,
            'nm_jenis_ci' => $request->inp_nama,
            'lama_cuti' => $request->inp_lama,
            'keterangan' =>$request->inp_deskripsi,
            'status' => 1
        ]);
        return redirect('hrd/masterdata/jeniscutiizin')->with('konfirm', 'Data berhasil disimpan');
    }
    public function edit_jenis_cuti_izin($id)
    {
        $result = JenisCutiIzinModel::find($id);
        return view("HRD.masterdata.cuti_izin.edit", ["res"=>$result]);
    }
    public function update_jenis_cuti_izn(Request $request, $id)
    {
        $update = JenisCutiIzinModel::find($id);
        $update->jenis_ci = $request->pil_jenis;
        $update->nm_jenis_ci = $request->inp_nama;
        $update->lama_cuti = $request->inp_lama;
        $update->keterangan = $request->inp_deskripsi;
        $update->status = $request->rdo_status;
        $update->save();
        return redirect('hrd/masterdata/jeniscutiizin')->with('konfirm', 'Perubaha Data berhasil disimpan');
    }
    public function hapus_jenis_cuti_izin($id)
    {
        $del = JenisCutiIzinModel::find($id);
        $del->delete();
        return redirect('hrd/masterdata/jeniscutiizin')->with('konfirm', 'Data berhasil dihapus');
    }
    //Master Divisi
    public function divisi()
    {
        $data_divisi= DivisiModel::all();
        return view("HRD.masterdata.divisi.index", ['list_divisi'=>$data_divisi]);
    }
    public function simpan_divisi(Request $request)
    {
        $simpan = DivisiModel::create([
            'nm_divisi' => $request->inp_nama,
            'status' => 1
        ]);
        return redirect('hrd/masterdata/divisi')->with('konfirm', 'Data berhasil disimpan');
    }
    public function edit_divisi($id)
    {
        $result = DivisiModel::find($id);
        return view("HRD.masterdata.divisi.edit", ["res"=>$result]);
    }
    public function update_divisi(Request $request, $id)
    {
        $update = DivisiModel::find($id);
        $update->nm_divisi = $request->inp_nama;
        $update->status = $request->rdo_status;
        $update->save();
        return redirect('hrd/masterdata/divisi')->with('konfirm', 'Perubaha Data berhasil disimpan');
    }
    public function hapus_divisi($id)
    {
        $del = DivisiModel::find($id);
        $del->delete();
        return redirect('hrd/masterdata/divisi')->with('konfirm', 'Data berhasil dihapus');
    }
    public function exceldivisi()
    {
        return Excel::download(new DivisiExport, 'masterdivisi.xlsx');
    }
    //perdis - fasilitas
    public function perdis_fasilitas()
    {
        $data_fasilitas= FasilitasPerdisModel::all();
        return view("HRD.masterdata.perdis.fasilitas.index", ['list_fasilitas'=>$data_fasilitas]);
    }
    public function simpan_perdis_fasilitas(Request $request)
    {
        $simpan = FasilitasPerdisModel::create([
            'nm_fasilitas' => $request->inp_nama,
            'status' => 1
        ]);
        return redirect('hrd/masterdata/perdis/fasilitas')->with('konfirm', 'Data berhasil disimpan');
    }
    public function edit_perdis_fasilitas($id)
    {
        $result = FasilitasPerdisModel::find($id);
        return view("HRD.masterdata.perdis.fasilitas.edit", ["res"=>$result]);
    }
    public function update_perdis_fasilitas(Request $request, $id)
    {
        $update = FasilitasPerdisModel::find($id);
        $update->nm_fasilitas = $request->inp_nama;
        $update->status = $request->rdo_status;
        $update->save();
        return redirect('hrd/masterdata/perdis/fasilitas')->with('konfirm', 'Perubaha Data berhasil disimpan');
    }
    public function hapus_perdis_fasilitas($id)
    {
        $del = FasilitasPerdisModel::find($id);
        $del->delete();
        return redirect('hrd/masterdata/perdis/fasilitas')->with('konfirm', 'Data berhasil dihapus');
    }
    //perdis - uang saku
    public function perdis_uang_saku()
    {
        $data_uangsaku = UangSakuPerdisModel::all();
        return view("HRD.masterdata.perdis.uang_saku.index", ['list_uangsaku'=>$data_uangsaku]);
    }
    public function simpan_perdis_uang_saku(Request $request)
    {
        $simpan = UangSakuPerdisModel::create([
            'nominal' => str_replace(",", "", $request->inp_nominal),
            'status' => 1
        ]);
        return redirect('hrd/masterdata/perdis/uangsaku')->with('konfirm', 'Data berhasil disimpan');
    }
    public function edit_perdis_uang_saku($id)
    {
        $result = UangSakuPerdisModel::find($id);
        return view("HRD.masterdata.perdis.uang_saku.edit", ["res"=>$result]);
    }
    public function update_perdis_uang_saku(Request $request, $id)
    {
        $update = UangSakuPerdisModel::find($id);
        $update->nominal = str_replace(",", "", $request->inp_nominal);
        $update->status = $request->rdo_status;
        $update->save();
        return redirect('hrd/masterdata/perdis/uangsaku')->with('konfirm', 'Perubaha Data berhasil disimpan');
    }
    public function hapus_perdis_uang_saku($id)
    {
        $del = UangSakuPerdisModel::find($id);
        $del->delete();
        return redirect('hrd/masterdata/perdis/uangsaku')->with('konfirm', 'Data berhasil dihapus');
    }

     //jenis SP
     public function jenis_sp()
     {
         $list_result= JenisSPModel::all();
         return view("HRD.masterdata.jenis_sp.index", ['list_result'=>$list_result]);
     }
     public function simpan_jenis_sp(Request $request)
     {
         $simpan = JenisSPModel::create([
             'nm_jenis_sp' => $request->inp_nama,
             'lama_berlaku' => $request->inp_lama,
             'status' => 1
         ]);
         return redirect('hrd/masterdata/jenissp')->with('konfirm', 'Data berhasil disimpan');
     }
     public function edit_jenis_sp($id)
     {
         $result = JenisSPModel::find($id);
         return view("HRD.masterdata.jenis_sp.edit", ["res"=>$result]);
     }
     public function update_jenis_sp(Request $request, $id)
     {
         $update = JenisSPModel::find($id);
         $update->nm_jenis_sp = $request->inp_nama;
         $update->lama_berlaku = $request->inp_lama;
         $update->status = $request->rdo_status;
         $update->save();
         return redirect('hrd/masterdata/jenissp')->with('konfirm', 'Perubaha Data berhasil disimpan');
     }
     public function hapus_jenis_sp($id)
     {
         $del = JenisSPModel::find($id);
         $del->delete();
         return redirect('hrd/masterdata/jenissp')->with('konfirm', 'Data berhasil dihapus');
     }
     //kategori penggajian
     public function kategori_penggajian()
     {
         $list_result= KategoriPenggajianModel::all();
         return view("HRD.masterdata.kategori_penggajian.index", ['list_result'=>$list_result]);
     }
     public function simpan_kategori_penggajian(Request $request)
     {
         $simpan = KategoriPenggajianModel::create([
             'kat_penggajian' => $request->inp_nama,
             'status' => 1
         ]);
         return redirect('hrd/masterdata/kategoripenggajian')->with('konfirm', 'Data berhasil disimpan');
     }
     public function edit_kategori_penggajian($id)
     {
         $result = KategoriPenggajianModel::find($id);
         return view("HRD.masterdata.kategori_penggajian.edit", ["res"=>$result]);
     }
     public function update_kategori_penggajian(Request $request, $id)
     {
         $update = KategoriPenggajianModel::find($id);
         $update->kat_penggajian = $request->inp_nama;
         $update->status = $request->rdo_status;
         $update->save();
         return redirect('hrd/masterdata/kategoripenggajian')->with('konfirm', 'Perubaha Data berhasil disimpan');
     }
     public function hapus_kategori_penggajian($id)
     {
         $del = KategoriPenggajianModel::find($id);
         $del->delete();
         return redirect('hrd/masterdata/kategoripenggajian')->with('konfirm', 'Data berhasil dihapus');
     }
     //bank penggajian
     public function bank_penggajian()
     {
         $list_result= BankPenggajianModel::all();
         return view("HRD.masterdata.bank_penggajian.index", ['list_result'=>$list_result]);
     }
     public function simpan_bank_penggajian(Request $request)
     {
         $simpan = BankPenggajianModel::create([
             'nm_bank' => $request->inp_nama,
             'status' => 1
         ]);
         return redirect('hrd/masterdata/bankpenggajian')->with('konfirm', 'Data berhasil disimpan');
     }
     public function edit_bank_penggajian($id)
     {
         $result = BankPenggajianModel::find($id);
         return view("HRD.masterdata.bank_penggajian.edit", ["res"=>$result]);
     }
     public function update_bank_penggajian(Request $request, $id)
     {
         $update = BankPenggajianModel::find($id);
         $update->nm_bank = $request->inp_nama;
         $update->status = $request->rdo_status;
         $update->save();
         return redirect('hrd/masterdata/bankpenggajian')->with('konfirm', 'Perubaha Data berhasil disimpan');
     }
     public function hapus_bank_penggajian($id)
     {
         $del = BankPenggajianModel::find($id);
         $del->delete();
         return redirect('hrd/masterdata/bankpenggajian')->with('konfirm', 'Data berhasil dihapus');
     }
     //jenis dokumen karyawan
     public function dokumen_karyawan()
     {
         $list_result= JenisDokumenKaryawanModel::all();
         return view("HRD.masterdata.dokumen_karyawan.index", ['list_result'=>$list_result]);
     }
     public function simpan_dokumen_karyawan(Request $request)
     {
         //dd($request->karyawan);
         $val_karyawan = ($request->karyawan=="on") ? 1 : NULL;
         $val_pelamar = ($request->pelamar=="on") ? 1 : NULL;
         $simpan = JenisDokumenKaryawanModel::create([
             'nm_dokumen' => $request->inp_nama,
             'karyawan' => $val_karyawan,
             'pelamar' => $val_pelamar,
             'status' => 1
         ]);
         return redirect('hrd/masterdata/dokumenkaryawan')->with('konfirm', 'Data berhasil disimpan');
     }
     public function edit_dokumen_karyawan($id)
     {
         $result = JenisDokumenKaryawanModel::find($id);
         return view("HRD.masterdata.dokumen_karyawan.edit", ["res"=>$result]);
     }
     public function update_dokumen_karyawan(Request $request, $id)
     {
        $val_karyawan = ($request->karyawan=="on") ? 1 : NULL;
        $val_pelamar = ($request->pelamar=="on") ? 1 : NULL;
         $update = JenisDokumenKaryawanModel::find($id);
         $update->nm_dokumen = $request->inp_nama;
         $update->karyawan = $val_karyawan;
         $update->pelamar = $val_pelamar;
         $update->status = $request->rdo_status;
         $update->save();
         return redirect('hrd/masterdata/dokumenkaryawan')->with('konfirm', 'Perubaha Data berhasil disimpan');
     }
     public function hapus_dokumen_karyawan($id)
     {
         $del = JenisDokumenKaryawanModel::find($id);
         $del->delete();
         return redirect('hrd/masterdata/dokumenkaryawan')->with('konfirm', 'Data berhasil dihapus');
     }
     //master lembaga pelaksana diklat
     public function pelaksana_diklat()
     {
        $list_result= PelaksanaDiklatModel::all();
        return view("HRD.masterdata.pelaksana_diklat.index", ['list_result'=>$list_result]);
     }
     public function simpan_pelaksana_diklat(Request $request)
     {
        $simpan = PelaksanaDiklatModel::create([
            'nama_lembaga' => $request->inp_nama,
            'alamat' => $request->inp_alamat,
            'no_telepon' => $request->inp_notel,
            'nama_email' => $request->inp_email,
            'kontak_person' => $request->inp_kontak_person
        ]);
        return redirect('hrd/masterdata/pelaksana_diklat')->with('konfirm', 'Data berhasil disimpan');
     }
     public function edit_pelaksana_diklat($id)
     {
        $result = PelaksanaDiklatModel::find($id);
        return view("HRD.masterdata.pelaksana_diklat.edit", ["res"=>$result]);
     }
     public function update_pelaksana_diklat(Request $request, $id)
     {
         $update = PelaksanaDiklatModel::find($id);
         $update->nama_lembaga = $request->inp_nama;
         $update->alamat = $request->inp_alamat;
         $update->no_telepon = $request->inp_notel;
         $update->nama_email = $request->inp_email;
         $update->kontak_person = $request->inp_kontak_person;
         $update->save();
         return redirect('hrd/masterdata/pelaksana_diklat')->with('konfirm', 'Perubaha Data berhasil disimpan');
     }
     public function hapus_pelaksana_diklat($id)
     {
         $del = PelaksanaDiklatModel::find($id);
         $del->delete();
         return redirect('hrd/masterdata/pelaksana_diklat')->with('konfirm', 'Data berhasil dihapus');
     }

    //master potongan gaji
    public function potongan_gaji()
    {
        $list_result= PotonganGajiModel::all();
        return view("HRD.masterdata.potongan_gaji.index", ['list_result'=>$list_result]);
    }
    public function simpan_potongan_gaji(Request $request)
    {
        $simpan = PotonganGajiModel::create([
            'nama_potongan' => $request->inp_nama
        ]);
        return redirect('hrd/masterdata/potongan_gaji')->with('konfirm', 'Data berhasil disimpan');
    }
    public function edit_potongan_gaji($id)
    {
        $result = PotonganGajiModel::find($id);
        return view("HRD.masterdata.potongan_gaji.edit", ["res"=>$result]);
    }
    public function update_potongan_gaji(Request $request, $id)
     {
         $update = PotonganGajiModel::find($id);
         $update->nama_potongan = $request->inp_nama;
         $update->status = $request->rdo_status;
         $update->update();
         return redirect('hrd/masterdata/potongan_gaji')->with('konfirm', 'Perubaha Data berhasil disimpan');
     }
     public function hapus_potongan_gaji($id)
     {
         $del = PotonganGajiModel::find($id);
         $del->delete();
         return redirect('hrd/masterdata/potongan_gaji')->with('konfirm', 'Data berhasil dihapus');
     }

     //Master pelatihan
     public function pelatihan()
    {
        $list_result= MasterPelatihanModel::all();
        return view("HRD.masterdata.pelatihan.index", ['list_result'=>$list_result]);
    }
    public function simpan_pelatihan(Request $request)
    {
        $simpan = MasterPelatihanModel::create([
            'nama_pelatihan' => $request->inp_nama
        ]);
        return redirect('hrd/masterdata/pelatihan')->with('konfirm', 'Data berhasil disimpan');
    }
    public function edit_pelatihan($id)
    {
        $result = MasterPelatihanModel::find($id);
        return view("HRD.masterdata.pelatihan.edit", ["res"=>$result]);
    }
    public function update_pelatihan(Request $request, $id)
     {
         $update = MasterPelatihanModel::find($id);
         $update->nama_pelatihan = $request->inp_nama;
         $update->update();
         return redirect('hrd/masterdata/pelatihan')->with('konfirm', 'Perubaha Data berhasil disimpan');
     }
     public function hapus_pelatihan($id)
     {
         $del = MasterPelatihanModel::find($id);
         $del->delete();
         return redirect('hrd/masterdata/pelatihan')->with('konfirm', 'Data berhasil dihapus');
     }
    //master jenis pelanggaran
    public function jenis_pelanggaran()
    {
        $list_result= JenisPelanggaranModel::all();
        return view("HRD.masterdata.jenis_pelanggaran.index", ['list_result'=>$list_result]);
    }
    public function simpan_jenis_pelanggaran(Request $request)
    {
        $simpan = JenisPelanggaranModel::create([
            'jenis_pelanggaran' => $request->inp_nama,
            'status' => 1 //aktif
        ]);
        return redirect('hrd/masterdata/jenisPelanggaran')->with('konfirm', 'Data berhasil disimpan');
    }
    public function edit_jenis_pelanggaran($id)
    {
        $result = JenisPelanggaranModel::find($id);
        return view("HRD.masterdata.jenis_pelanggaran.edit", ["res"=>$result]);
    }
    public function update_jenis_pelanggaran(Request $request, $id)
     {
         $update = JenisPelanggaranModel::find($id);
         $update->jenis_pelanggaran = $request->inp_nama;
         $update->update();
         return redirect('hrd/masterdata/jenisPelanggaran')->with('konfirm', 'Perubaha Data berhasil disimpan');
     }
     public function hapus_jenis_pelanggaran($id)
     {
         $del = JenisPelanggaranModel::find($id);
         $del->delete();
         return redirect('hrd/masterdata/jenisPelanggaran')->with('konfirm', 'Data berhasil dihapus');
     }

     //KPI
     //Perspektif KPI
     public function perspektifKPI()
     {
        $data['listPerspektif'] = KPIPerspektifModel::all();
        return view('HRD.masterdata.perspektif_kpi.index', $data);
     }
     public function perspektifKPISimpan(Request $request)
    {
        KPIPerspektifModel::create([
            'perspektif' => $request->inp_nama,
            'active' => 1 //aktif
        ]);
        return redirect('hrd/masterdata/perspektifKPI')->with('konfirm', 'Data berhasil disimpan');
    }
    public function perspektifKPIEdit($id)
    {
        $result = KPIPerspektifModel::find($id);
        return view("HRD.masterdata.perspektif_kpi.edit", ["res"=>$result]);
    }
    public function perspektifKPIUpdate(Request $request, $id)
    {
        $update = KPIPerspektifModel::find($id);
        $update->perspektif = $request->inp_nama;
        $update->active = $request->rdo_status;
        $update->update();
        return redirect('hrd/masterdata/perspektifKPI')->with('konfirm', 'Perubaha Data berhasil disimpan');
    }
    public function perspektifKPIHapus($id)
    {
        $del = KPIPerspektifModel::find($id);
        $del->delete();
        return redirect('hrd/masterdata/perspektifKPI')->with('konfirm', 'Data berhasil dihapus');
    }
    //Sasaran strategi KPI
    public function sasaranKPI()
    {
       $data['listData'] = KPISasaranModel::all();
       return view('HRD.masterdata.sasaran_strategi_kpi.index', $data);
    }
    public function sasaranKPISimpan(Request $request)
   {
       KPISasaranModel::create([
           'sasaran_strategi' => $request->inp_nama,
           'active' => 1 //aktif
       ]);
       return redirect('hrd/masterdata/sasaranKPI')->with('konfirm', 'Data berhasil disimpan');
   }
   public function sasaranKPIEdit($id)
   {
       $result = KPISasaranModel::find($id);
       return view("HRD.masterdata.sasaran_strategi_kpi.edit", ["res"=>$result]);
   }
   public function sasaranKPIUpdate(Request $request, $id)
   {
       $update = KPISasaranModel::find($id);
       $update->sasaran_strategi = $request->inp_nama;
       $update->active = $request->rdo_status;
       $update->update();
       return redirect('hrd/masterdata/sasaranKPI')->with('konfirm', 'Perubaha Data berhasil disimpan');
   }
   public function sasaranKPIHapus($id)
   {
       $del = KPISasaranModel::find($id);
       $del->delete();
       return redirect('hrd/masterdata/sasaranKPI')->with('konfirm', 'Data berhasil dihapus');
   }
    //Tipe KPI
    public function tipeKPI()
    {
        $data['listData'] = KPITipeModel::all();
        return view('HRD.masterdata.tipe_kpi.index', $data);
    }
    public function tipeKPISimpan(Request $request)
    {
        KPITipeModel::create([
            'tipe_kpi' => $request->inp_nama,
            'active' => 1 //aktif
        ]);
        return redirect('hrd/masterdata/tipeKPI')->with('konfirm', 'Data berhasil disimpan');
    }
    public function tipeKPIEdit($id)
    {
        $result = KPITipeModel::find($id);
        return view("HRD.masterdata.tipe_kpi.edit", ["res"=>$result]);
    }
    public function tipeKPIUpdate(Request $request, $id)
    {
        $update = KPITipeModel::find($id);
        $update->tipe_kpi = $request->inp_nama;
        $update->active = $request->rdo_status;
        $update->update();
        return redirect('hrd/masterdata/tipeKPI')->with('konfirm', 'Perubaha Data berhasil disimpan');
    }
    public function tipeKPIHapus($id)
    {
        $del = KPITipeModel::find($id);
        $del->delete();
        return redirect('hrd/masterdata/tipeKPI')->with('konfirm', 'Data berhasil dihapus');
    }
    //Tipe KPI
    public function satuanKPI()
    {
        $data['listData'] = KPISatuanModel::all();
        return view('HRD.masterdata.satuan_kpi.index', $data);
    }
    public function satuanKPISimpan(Request $request)
    {
        KPISatuanModel::create([
            'satuan_kpi' => $request->inp_nama,
            'active' => 1 //aktif
        ]);
        return redirect('hrd/masterdata/satuanKPI')->with('konfirm', 'Data berhasil disimpan');
    }
    public function satuanKPIEdit($id)
    {
        $result = KPISatuanModel::find($id);
        return view("HRD.masterdata.satuan_kpi.edit", ["res"=>$result]);
    }
    public function satuanKPIUpdate(Request $request, $id)
    {
        $update = KPISatuanModel::find($id);
        $update->satuan_kpi = $request->inp_nama;
        $update->active = $request->rdo_status;
        $update->update();
        return redirect('hrd/masterdata/satuanKPI')->with('konfirm', 'Perubaha Data berhasil disimpan');
    }
    public function satuanKPIHapus($id)
    {
        $del = KPISatuanModel::find($id);
        $del->delete();
        return redirect('hrd/masterdata/satuanKPI')->with('konfirm', 'Data berhasil dihapus');
    }

    //status tanggungan
    public function statusTanggungan()
     {
         $list_result= StatusTanggunganModel::all();
         return view("HRD.masterdata.status_tanggungan.index", ['list_result'=>$list_result]);
     }
     public function statusTanggunganSimpan(Request $request)
     {
         $simpan = StatusTanggunganModel::create([
             'status_tanggungan' => $request->inp_status,
             'kode' => $request->inp_kode,
             'status' => 1
         ]);
         return redirect('hrd/masterdata/statusTanggungan')->with('konfirm', 'Data berhasil disimpan');
     }
     public function statusTanggunganEdit($id)
     {
         $result = StatusTanggunganModel::find($id);
         return view("HRD.masterdata.status_tanggungan.edit", ["res"=>$result]);
     }
     public function statusTanggunganUpdate(Request $request, $id)
     {
         $update = StatusTanggunganModel::find($id);
         $update->status_tanggungan = $request->inp_status;
         $update->kode = $request->inp_kode;
         $update->status = $request->rdo_status;
         $update->save();
         return redirect('hrd/masterdata/statusTanggungan')->with('konfirm', 'Perubaha Data berhasil disimpan');
     }
     public function statusTanggunganHapus($id)
     {
         $del = StatusTanggunganModel::find($id);
         $del->delete();
         return redirect('hrd/masterdata/statusTanggungan')->with('konfirm', 'Data berhasil dihapus');
     }
}
