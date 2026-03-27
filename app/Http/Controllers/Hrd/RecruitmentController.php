<?php

namespace App\Http\Controllers\Hrd;

use App\Exports\RekapHasilTesRecruitmenExport;
use App\Models\HRD\PelamarNilaiWawancaraModel;
use App\Http\Controllers\Controller;
use App\Models\HRD\PelamarModel;
use App\Models\HRD\JabatanModel;
use App\Models\HRD\DepartemenModel;
use App\Models\HRD\PelamarLBKeluargaModel;
use App\Models\HRD\PelamarKeluargaModel;
use App\Models\HRD\PelamarRiwayatPendidikanModel;
use App\Models\HRD\PelamarOrganisasiModel;
use App\Models\HRD\PelamarPengalamanKerjaModel;
use App\Models\HRD\PelamarDokumenModel;
use App\Models\HRD\JenisDokumenKaryawanModel;
use App\Models\HRD\PerubahanStatusModel;
use App\Models\HRD\RecruitmentPersetujuanModel;
use App\Models\HRD\SetupPersetujuanModel;
//Model Karyawan
use App\Models\HRD\LBKeluargaModel;
use App\Models\HRD\KeluargaModel;
use App\Models\HRD\RiwayatPendidikanModel;
use App\Models\HRD\PengalamanKerjaModel;
use App\Models\HRD\DokumenKaryawanjaModel;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Storage;
use File;
use Config;
use PDF;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Hrdhelper as hrdfunction;
use App\Models\HRD\ApprovalModel;
use App\Models\HRD\KaryawanModel;
use App\Models\HRD\RecruitmentPengajuanTKModel;
use App\Traits\ApproverHrd;
use Illuminate\Support\Str;

class RecruitmentController extends Controller
{
    use ApproverHrd;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $dept_psdm = 13;

    public function index()
    {
        $data = [
            'departemen' => DepartemenModel::where('status', 1)->get(),
            'all_pelamar' => PelamarModel::orderBy('created_at', 'DESC')->get()
        ];

        return view("HRD.recruitment.aplikasi_pelamar.index", $data);
    }

    public function data(Request $request)
    {
        $columns = ['created_at'];
        $totalData = PelamarModel::count();
        $search = $request->input('search.value');

        $query = PelamarModel::with([
            'get_departmen',
            'get_sub_departemen',
            'get_jabatan'
        ]);
        if(!empty($request->dept))
        {
            $query->where('id_departemen',$request->dept);
        }
        if(!empty($request->jabatan))
        {
            $query->where('id_jabatan',$request->jabatan);
        }
        if(!empty($request->jenkel))
        {
            $query->where('jenkel',$request->jenkel);
        }
        $totalFiltered = $query->count();
        $query = $query->offset($request->input('start'))
            ->limit($request->input('length'))
            // ->orderBy($columns[$request->input('order.0.column')], $request->input('order.0.dir'))
            ->orderBy('created_at', 'desc')
            ->get();

        $data = array();
        if ($query) {
            $counter = 1;
            $status_persetujuan = "";
            $path = "hrd/pelamar/photo/";
            $action = "";
            foreach ($query as $r) {
                $alamat = $r->alamat.'<br><i class="fa fa-phone"></i>'.$r->no_hp.'<br><i class="fa fa-whatsapp"></i>'.$r->no_wa;
                $jabatan = (empty($r->id_jabatan)) ? "" : $r->get_jabatan->nm_jabatan;
                $departemen = (empty($r->id_departemen)) ? "" : $r->get_departmen->nm_dept;
                $subdept = (empty($r->id_sub_departemen)) ? "" : $r->get_sub_departemen->nm_sub_dept;
                $posisi_dilamar = "Jabatan : ".$jabatan."<br>Departemen : ".$departemen;

                $status_persetujuan = "<h5>";
                if($r->status_pengajuan==1) {
                    $status_persetujuan .= '<span class="badge badge-pill badge-primary">Menunggu Persetujuan : '.$r->get_current_approve->nm_lengkap.'</span><span class="badge badge-pill badge-warning">'. $r->get_current_approve->get_jabatan->nm_jabatan.'</span>';
                    if($r->status_app=="pending")
                    {
                        $status_persetujuan .= '<br><span class="badge badge-pill badge-danger">Pending</span>';
                    }
                } elseif($r->status_pengajuan==2) {
                     $status_persetujuan .= '<span class="badge badge-success">Disetujui</span>';
                } else {
                    $status_persetujuan .= '<span class="badge badge-danger">Ditolak</span>';
                }
                $status_persetujuan .= '</h5>';
                if($r->status_pengajuan==1){
                    if(empty($r->status_app))
                    {
                        $textColor = "text-primary";
                    } else {
                        $textColor = "text-danger";
                    }

                } else {
                    $textColor = "text-success";
                }
                $action = '<div class="dropdown">
                    <span class="dropdown-toggle '.$textColor.'" id="dropdownMenuButton3" data-toggle="dropdown">
                    <i class="ri-more-2-fill"></i>
                    </span>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="'.url('hrd/recruitment/aplikasi_pelamar/data_lain/'.$r->id).'"><i class="fa fa-user mr-2"></i>Profil Pelamar</a>';
                        if($r->status_pengajuan==1 ) {
                            if(empty($r->status_app))
                            {
                                $action .= '<a class="dropdown-item" href="javascript:void(0)" id="'.$r->id.'" onclick="prosesCloseApp(this)"><i class="fa fa-lock mr-2"></i>Close</a>';
                            }
                            if($r->status_app=="close")
                            {
                                $action .= '<a class="dropdown-item" href="javascript:void(0)" id="'.$r->id.'" onclick="prosesOpenApp(this)"><i class="fa fa-unlock mr-2"></i>Open</a>';
                            }
                            if(empty($r->status_app) || $r->status_app=="pending")
                            {
                                $action .= '<a class="dropdown-item" href="'.url('hrd/recruitment/aplikasi_pelamar/submit_app/'.$r->id).'"><i class="fa fa-thumbs-up mr-2"></i>Submit</a>';
                            }
                        }
                        if($r->status_pengajuan==2 ) {
                            $action .= '<a class="dropdown-item" href="'.url('hrd/recruitment/proses_menjadi_karyawan/'.$r->id).'"><i class="fa fa-check mr-2"></i>Registrasi Karyawan Baru </a>';
                        }
                        if(!empty($r->id_perubahan_status)) {
                            $action .= '<a class="dropdown-item" href="'.url('hrd/perubahanstatus/print').'/'. \App\Helpers\Hrdhelper::encrypt_decrypt('encrypt',$r->id_perubahan_status).'" target="_new"><i class="fa fa-print mr-2"></i>Surat Kontrak</a>';
                        }
                        if(!empty($r->no_surat_pengantar)) {
                            $action .= '<a class="dropdown-item" href="'.url('hrd/recruitment/surat_pengantar_penempatan/'.$r->id).'" target="_new"><i class="fa fa-print mr-2"></i>Surat Pengantar Penempatan</a>';
                        }
                        if(!empty($r->no_surat_si)) {
                            $action .=  '<a class="dropdown-item" href="'.url('hrd/recruitment/surat_pengantar_safety_induction/'.$r->id).'" target="_new"><i class="fa fa-print mr-2"></i>Surat Pengantar Safety Induction</a>';
                        }

                        $action .= '</div></div>';
                        $photo = '<a href="'.url(Storage::url($path.$r->file_photo)).'" data-fancybox data-caption="avatar">
                        <img src="'.url(Storage::url($path.$r->file_photo)).'" style="width: 70px; height: auto" alt="Dokumen"></a>';
                $nestedData['id'] = $r->id;
                $nestedData['tanggal_aplikasi'] = date_format(date_create($r->created_at), 'd-m-Y');
                $nestedData['no_identitas'] = $r->no_identitas;
                $nestedData['nama_pelamar'] = $r->nama_lengkap;
                $nestedData['ttl'] = $r->tempat_lahir.", ".date_format(date_create($r->tanggal_lahir), 'd-m-Y');
                $nestedData['umur'] = hrdfunction::get_umur_karyawan($r->tanggal_lahir);
                $nestedData['gender'] = ($r->jenkel==1) ? "Laki-Laki" : "Perempuan";
                $nestedData['alamat'] = $alamat;
                $nestedData['posisi_dilamar'] =$posisi_dilamar;
                $nestedData['status_pengajuan'] = $status_persetujuan;
                $nestedData['action'] = $action;
                $nestedData['no'] = $counter;
                $nestedData['photo'] = $photo;

                $data[] = $nestedData;
                $counter++;
            }
        }
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => $data
        ]);
    }

    public function baru()
    {
        $data = [
            'departemen' => DepartemenModel::where('status', 1)->get()->map(
                function($rows) {
                    $arr_row = $rows->toArray();
                    $arr_row['total_pengajuan'] = RecruitmentPengajuanTKModel::where('status_pengajuan', 2)->where('id_departemen', $rows['id'])->get()->count();
                    return $arr_row;
                }
            )
        ];
        return view("HRD.recruitment.aplikasi_pelamar.add", $data);
    }
    public function list_kebutuhan_tk($id_dept)
    {
        $data = [
            "list_pengajuan" => RecruitmentPengajuanTKModel::where('id_departemen', $id_dept)->orderBy('tanggal_pengajuan', "desc")->get()
        ];
        return view('HRD.recruitment.aplikasi_pelamar.list_kebutuhan_tk', $data);
    }
    public function rekap_hasil_tes_per_kebutuhan($id)
    {
        $data = [
            'result_rekap' => PelamarModel::with([
                'get_departmen',
                'get_jabatan'
            ])->where('id_lowongan', $id)->where('status_pengajuan', 1)->orderBy('total_skor', 'desc')->get()
        ];
        return view('HRD.recruitment.aplikasi_pelamar.rekap_hasil_tes', $data);
    }

    public function pelamar_profil($id)
    {
        $id_lowongan = hrdfunction::encrypt_decrypt('decrypt', $id);
        $data = [
            'all_agama' => Config::get("constants.agama"),
            'all_jenjang' => Config::get("constants.jenjang_pendidikan"),
            'all_departemen' => DepartemenModel::where('status', 1)->get(),
            'data_lowongan' => RecruitmentPengajuanTKModel::find($id_lowongan),
            'total_aplikasi' => PelamarModel::where('id_lowongan', $id_lowongan)->get()->count(),
            'total_aplikasi_approve' => PelamarModel::where('id_lowongan', $id_lowongan)->where('status_pengajuan', 2)->get()->count(),
            'total_aplikasi_pengajuan' => PelamarModel::where('id_lowongan', $id_lowongan)->where('status_pengajuan', 1)->get()->count(),
            'result_rekap' => PelamarModel::with([
                'get_departmen',
                'get_jabatan'
            ])->where('id_lowongan', $id_lowongan)->where('status_pengajuan', 1)->orderBy('total_skor', 'desc')->get()
        ];
        return view("HRD.recruitment.aplikasi_pelamar.profil", $data);
    }

    public function checkID(Request $request)
    {
        $result = PelamarModel::where('no_identitas', $request->noID)->get()->count();
        return response()->json([
            'result' => $result
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pelamar_profil_simpan(Request $request)
    {
        // $id_gakom = JabatanModel::find($request->pil_jabatan)->id_gakom;
        // $_uuid = Str::uuid();
        // $get_approval_first = KaryawanModel::where('id_jabatan', $id_gakom)->first();

        $id_pelamar = "";
        $tf = "";
        $pesan = "";
        $arr_tgl_lahir = explode("/", $request->inp_tgl_lahir);
        $tgl_lahir = $arr_tgl_lahir[2]."-".$arr_tgl_lahir[1]."-".$arr_tgl_lahir[0];

        $id_depat_karyawan = $request->pil_departemen;
        $_uuid = Str::uuid();
        $group = 2;
        $ifSet = hrdfunction::set_approval_cek($group, $id_depat_karyawan);
        if($ifSet > 0)
        {
            if($request->hasFile('file_photo'))
            {
                $allowedfileExtension=['jpg','png','jpeg'];
                Image::configure(array('driver' => 'gd'));
                $path = storage_path("app/public/hrd/pelamar/photo");
                $image = $request->file('file_photo');
                $extension = $image->getClientOriginalExtension();
                $check=in_array($extension,$allowedfileExtension);
                if($check)
                {
                    $filename = $request->inp_no_identitas.".".$extension;
                    if(!File::isDirectory($path)) {
                        $path = Storage::disk('public')->makeDirectory('hrd/pelamar/photo');
                    }
                    $image_resize = Image::make($image->getRealPath());
                    $image_resize->resize(150, null, function($construction){
                        $construction->aspectRatio();
                    });
                    $image_resize->save(storage_path("app/public/hrd/pelamar/photo/".$filename));

                    $last_id = PelamarModel::create([
                        'id_lowongan' => $request->id_lowongan,
                        'no_identitas' => $request->inp_no_identitas,
                        'nama_lengkap' => $request->inp_nama,
                        'tempat_lahir' => $request->inp_tempat_lahir,
                        'tanggal_lahir' => $tgl_lahir,
                        'jenkel' => $request->rdo_jenkel,
                        'status_nikah' => $request->rdo_sts_nikah,
                        'id_agama' => $request->pil_agama,
                        'alamat' => $request->inp_alamat,
                        'no_hp' => $request->inp_hp,
                        'no_wa' => $request->inp_wa,
                        'email' => $request->inp_email,
                        'file_photo' => $filename,
                        'id_jenjang' => $request->pil_jenjang,
                        'id_departemen' => $request->pil_departemen,
                        'id_sub_departemen' => $request->pil_subdepartemen,
                        'id_jabatan' => $request->pil_jabatan,
                        'status_pengajuan' => 1, //Pengajuan
                        'approval_key' => $_uuid,
                        'current_approval_id' => hrdfunction::set_approval_get_first($group, $id_depat_karyawan),
                        'is_draft' => 1, //pengajuan masih bisa diedit
                        'psikotes_nilai' => $request->nil_psikotes,
                        'psikotes_kesimpulan' => $request->pil_kesimpulan_psikotes,
                        'psikotes_ket' => $request->pil_kesimpulan_psikotes,
                        'wawancara_nilai' => $request->nil_wawancara,
                        'wawancara_ket' => $request->ket_wawancara,
                        'wawancara_kesimpulan' => $request->pil_kesimpulan_wawancara,
                        'total_skor' => $request->nil_psikotes + $request->nil_wawancara
                    ])->id;
                    $tf='true';
                    $pesan = "Data Pelamar berhasil disimpan";
                    $id_pelamar = $last_id;
                } else {
                    $tf='false';
                    $pesan = "Data gagal disimpan. File yang bisa diupload adalah jpg/jpeg, png. Periksa kembali data inputan anda.";
                }

            } else {
                $last_id = PelamarModel::create([
                    'id_lowongan' => $request->id_lowongan,
                    'no_identitas' => $request->inp_no_identitas,
                    'nama_lengkap' => $request->inp_nama,
                    'tempat_lahir' => $request->inp_tempat_lahir,
                    'tanggal_lahir' => $tgl_lahir,
                    'jenkel' => $request->rdo_jenkel,
                    'status_nikah' => $request->rdo_sts_nikah,
                    'id_agama' => $request->pil_agama,
                    'alamat' => $request->inp_alamat,
                    'no_hp' => $request->inp_hp,
                    'no_wa' => $request->inp_wa,
                    'email' => $request->inp_email,
                    'file_photo' => "",
                    'id_jenjang' => $request->pil_jenjang,
                    'id_departemen' => $request->pil_departemen,
                    'id_sub_departemen' => $request->pil_subdepartemen,
                    'id_jabatan' => $request->pil_jabatan,
                    'status_pengajuan' => 1, //Pengajuan
                    'approval_key' => $_uuid,
                    'current_approval_id' => hrdfunction::set_approval_get_first($group, $id_depat_karyawan),
                    'is_draft' => 1, //pengajuan masih bisa diedit
                    'psikotes_nilai' => $request->nil_psikotes,
                    'psikotes_kesimpulan' => $request->pil_kesimpulan_psikotes,
                    'psikotes_ket' => $request->pil_kesimpulan_psikotes,
                    'wawancara_nilai' => $request->nil_wawancara,
                    'wawancara_ket' => $request->ket_wawancara,
                    'wawancara_kesimpulan' => $request->pil_kesimpulan_wawancara,
                    'total_skor' => $request->nil_psikotes + $request->nil_wawancara
                ])->id;
                $tf='true';
                $pesan = "Data Pelamar berhasil disimpan";
                $id_pelamar = $last_id;
            }
            if($tf=='true') {
                $arr_appr =  hrdfunction::set_approval_new($group, $id_depat_karyawan);
                foreach($arr_appr as $appr)
                {
                    $approval_active=0;
                    if($appr['approval_level']==1) {
                        $approval_active = 1;
                    }
                    ApprovalModel::create([
                        'approval_by_employee' => $appr['approval_by_employee'],
                        'approval_level' => $appr['approval_level'],
                        'approval_key' => $_uuid,
                        'approval_group' => $group, //Pengajuan Cuti
                        'approval_active' => $approval_active
                    ]);
                }
                return redirect('hrd/recruitment/aplikasi_pelamar/data_lain/'.$id_pelamar)->with('konfirm', $pesan);
            } else {
                return redirect('hrd/recruitment/aplikasi_pelamar')->with('konfirm', $pesan);
            }
        } else {
            return redirect('hrd/recruitment/aplikasi_pelamar')->with('konfirm', 'Matriks persetujuan belum diatur');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pelamar_data_lain($id)
    {
        $profil = PelamarModel::with(['get_list_persetujuan'])->find($id);
        $lb_keluarga = PelamarLBKeluargaModel::where('id_pelamar', $id)->get();
        $keluarga = PelamarKeluargaModel::where('id_pelamar', $id)->get();
        $pendidikan = PelamarRiwayatPendidikanModel::where('id_pelamar', $id)->get();
        $organisasi = PelamarOrganisasiModel::where("id_pelamar", $id)->get();
        $pekerjaan = PelamarPengalamanKerjaModel::where("id_pelamar", $id)->get();
        $list_dokumen = PelamarDokumenModel::where('id_pelamar', $id)->get();
        $jenis_dokumen = JenisDokumenKaryawanModel::where('pelamar', 1)->get();
        $hirarki_persetujuan = ApprovalModel::where('approval_key', $profil->approval_key)->orderBy('approval_level')->get();
        return view("HRD.recruitment.aplikasi_pelamar.data_lain", compact(['profil', 'lb_keluarga', 'keluarga', 'pendidikan', 'organisasi', 'pekerjaan', 'list_dokumen', 'jenis_dokumen', 'hirarki_persetujuan']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function latar_belakang_keluarga($id)
    {
        $profil = PelamarModel::find($id);
        $list_lbkeluarga = Config::get('constants.hubungan_lbkeluarga');
        $list_jenjang = Config::get("constants.jenjang_pendidikan");
        $lb_keluarga = PelamarLBKeluargaModel::where('id_pelamar', $id)->get();
        return view("HRD.recruitment.aplikasi_pelamar.form_lb_keluarga", compact(['profil', 'list_lbkeluarga', 'list_jenjang', 'lb_keluarga']));
    }
    public function latar_belakang_keluarga_simpan(Request $request)
    {
        $id_pelamar = $request->id_pelamar;
        PelamarLBKeluargaModel::create([
            "id_pelamar" => $id_pelamar,
            "id_hubungan" => $request->pil_hubungan,
            "nm_keluarga" => $request->inp_nama,
            "tmp_lahir" => $request->inp_tmp_lahir,
            "tgl_lahir" => $request->inp_tgl_lahir,
            "jenkel" => $request->rdo_jenkel,
            "id_jenjang" => $request->pil_jenjang,
            "pekerjaan" => $request->inp_pekerjaan
        ]);
        return redirect('hrd/recruitment/aplikasi_pelamar/frm_lb_keluarga/'.$id_pelamar)->with('konfirm', 'Data Latar Belakang Keluarga Pelamar berhasil disimpan.');
    }
    public function latar_belakang_keluarga_edit($id)
    {
        $result = PelamarLBKeluargaModel::find($id);
        $list_lbkeluarga = Config::get('constants.hubungan_lbkeluarga');
        $list_jenjang = Config::get("constants.jenjang_pendidikan");
        return view("HRD.recruitment.aplikasi_pelamar.form_lb_keluarga_edit", compact(['result', 'list_lbkeluarga', 'list_jenjang']));
    }
    public function latar_belakang_keluarga_update(Request $request, $id) {
        $id_pelamar = $request->id_pelamar;
        $update = PelamarLBKeluargaModel::find($id);
        $update->id_hubungan = $request->pil_hubungan;
        $update->nm_keluarga = $request->inp_nama;
        $update->tmp_lahir = $request->inp_tmp_lahir;
        $update->tgl_lahir = $request->inp_tgl_lahir;
        $update->jenkel = $request->rdo_jenkel_edit;
        $update->id_jenjang = $request->pil_jenjang;
        $update->pekerjaan = $request->inp_pekerjaan;
        $update->save();
        return redirect('hrd/recruitment/aplikasi_pelamar/frm_lb_keluarga/'.$id_pelamar)->with('konfirm', 'Perubahan data latar belakang keluarga pelamar berhasil disimpan.');
    }

    public function latar_belakang_keluarga_delete($id)
    {
        $del = PelamarLBKeluargaModel::find($id);
        $id_pelamar = $del->id_pelamar;
        $del->delete();
        return redirect('hrd/recruitment/aplikasi_pelamar/frm_lb_keluarga/'.$id_pelamar)->with('konfirm', 'Data latar belakang keluarga pelamar berhasil dihapus.');
    }

    public function keluarga($id)
    {
        $profil = PelamarModel::find($id);
        $list_hubungan_keluarga = Config::get('constants.hubungan_keluarga');
        $list_jenjang = Config::get("constants.jenjang_pendidikan");
        $list_keluarga = PelamarKeluargaModel::where('id_pelamar', $id)->get();
        return view("HRD.recruitment.aplikasi_pelamar.form_keluarga", compact(['profil', 'list_hubungan_keluarga', 'list_jenjang', 'list_keluarga']));
    }
    public function keluarga_simpan(Request $request)
    {
        $id_pelamar = $request->id_pelamar;
        PelamarKeluargaModel::create([
            "id_pelamar" => $id_pelamar,
            "id_hubungan" => $request->pil_hubungan,
            "nm_keluarga" => $request->inp_nama,
            "tmp_lahir" => $request->inp_tmp_lahir,
            "tgl_lahir" => $request->inp_tgl_lahir,
            "jenkel" => $request->rdo_jenkel,
            "id_jenjang" => $request->pil_jenjang,
            "pekerjaan" => $request->inp_pekerjaan
        ]);
        return redirect('hrd/recruitment/aplikasi_pelamar/frm_keluarga/'.$id_pelamar)->with('konfirm', 'Data Keluarga Pelamar berhasil disimpan.');
    }
    public function keluarga_edit($id)
    {
        $result = PelamarKeluargaModel::find($id);
        $list_hubungan_keluarga = Config::get('constants.hubungan_keluarga');
        $list_jenjang = Config::get("constants.jenjang_pendidikan");
        return view("HRD.recruitment.aplikasi_pelamar.form_keluarga_edit", compact(['result', 'list_hubungan_keluarga', 'list_jenjang']));
    }
    public function keluarga_update(Request $request, $id) {
        $id_pelamar = $request->id_pelamar;
        $update = PelamarKeluargaModel::find($id);
        $update->id_hubungan = $request->pil_hubungan;
        $update->nm_keluarga = $request->inp_nama;
        $update->tmp_lahir = $request->inp_tmp_lahir;
        $update->tgl_lahir = $request->inp_tgl_lahir;
        $update->jenkel = $request->rdo_jenkel_edit;
        $update->id_jenjang = $request->pil_jenjang;
        $update->pekerjaan = $request->inp_pekerjaan;
        $update->save();
        return redirect('hrd/recruitment/aplikasi_pelamar/frm_keluarga/'.$id_pelamar)->with('konfirm', 'Perubahan data keluarga pelamar berhasil disimpan.');
    }
    public function keluarga_delete($id)
    {
        $del = PelamarKeluargaModel::find($id);
        $id_pelamar = $del->id_pelamar;
        $del->delete();
        return redirect('hrd/recruitment/aplikasi_pelamar/frm_keluarga/'.$id_pelamar)->with('konfirm', 'Data keluarga pelamar berhasil dihapus.');
    }

    public function riwayat_pendidikan($id)
    {
        $profil = PelamarModel::find($id);
        $list_jenjang = Config::get("constants.jenjang_pendidikan");
        $list_riwayat_pendidikan = PelamarRiwayatPendidikanModel::where('id_pelamar', $id)->get();
        return view("HRD.recruitment.aplikasi_pelamar.form_pendidikan", compact(['profil', 'list_jenjang', 'list_riwayat_pendidikan']));
    }
    public function riwayat_pendidikan_simpan(Request $request)
    {
        $id_pelamar = $request->id_pelamar;
        PelamarRiwayatPendidikanModel::create([
            "id_pelamar" => $id_pelamar,
            "id_jenjang" => $request->pil_jenjang,
            "nm_sekolah_pt" => $request->inp_nama,
            "alamat" => $request->inp_alamat,
            "mulai_tahun" => $request->inp_tahun_mulai,
            "sampai_tahun" => $request->inp_tahun_akhir
        ]);
        return redirect('hrd/recruitment/aplikasi_pelamar/frm_pendidikan/'.$id_pelamar)->with('konfirm', 'Data Riwayat Pendidikan Pelamar berhasil disimpan.');
    }
    public function riwayat_pendidikan_edit($id)
    {
        $result = PelamarRiwayatPendidikanModel::find($id);
        $list_jenjang = Config::get("constants.jenjang_pendidikan");
        return view("HRD.recruitment.aplikasi_pelamar.form_pendidikan_edit", compact(['result', 'list_jenjang']));
    }
    public function riwayat_pendidikan_update(Request $request, $id) {
        $id_pelamar = $request->id_pelamar;
        $update = PelamarRiwayatPendidikanModel::find($id);
        $update->id_jenjang = $request->pil_jenjang;
        $update->nm_sekolah_pt = $request->inp_nama;
        $update->alamat = $request->inp_alamat;
        $update->mulai_tahun = $request->inp_tahun_mulai;
        $update->sampai_tahun = $request->inp_tahun_akhir;
        $update->save();
        return redirect('hrd/recruitment/aplikasi_pelamar/frm_pendidikan/'.$id_pelamar)->with('konfirm', 'Perubahan data riwayat pendidikan pelamar berhasil disimpan.');
    }
    public function riwayat_pendidikan_delete($id)
    {
        $del = PelamarRiwayatPendidikanModel::find($id);
        $id_pelamar = $del->id_pelamar;
        $del->delete();
        return redirect('hrd/recruitment/aplikasi_pelamar/frm_pendidikan/'.$id_pelamar)->with('konfirm', 'Data riwayat pendidikan pelamar berhasil dihapus.');
    }

    public function pengalaman_organisasi($id)
    {
        $profil = PelamarModel::find($id);
        $list_organisasi = PelamarOrganisasiModel::where('id_pelamar', $id)->get();
        return view("HRD.recruitment.aplikasi_pelamar.form_organisasi", compact(['profil', 'list_organisasi']));
    }
    public function pengalaman_organisasi_simpan(Request $request)
    {
        $id_pelamar = $request->id_pelamar;
        PelamarOrganisasiModel::create([
            "id_pelamar" => $id_pelamar,
            "nama_organisasi" => $request->inp_nama,
            "posisi" => $request->inp_posisi,
            "mulai_tahun" => $request->inp_tahun_mulai,
            "sampai_tahun" => $request->inp_tahun_akhir
        ]);
        return redirect('hrd/recruitment/aplikasi_pelamar/frm_organisasi/'.$id_pelamar)->with('konfirm', 'Data Pengalaman Organisasi Pelamar berhasil disimpan.');
    }
    public function pengalaman_organisasi_edit($id)
    {
        $result = PelamarOrganisasiModel::find($id);
        return view("HRD.recruitment.aplikasi_pelamar.form_organisasi_edit", compact(['result']));
    }
    public function pengalaman_organisasi_update(Request $request, $id) {
        $id_pelamar = $request->id_pelamar;
        $update = PelamarOrganisasiModel::find($id);
        $update->nama_organisasi = $request->inp_nama;
        $update->posisi = $request->inp_posisi;
        $update->mulai_tahun = $request->inp_tahun_mulai;
        $update->sampai_tahun = $request->inp_tahun_akhir;
        $update->save();
        return redirect('hrd/recruitment/aplikasi_pelamar/frm_organisasi/'.$id_pelamar)->with('konfirm', 'Perubahan data pengalaman organisasi pelamar berhasil disimpan.');
    }
    public function pengalaman_organisasi_delete($id)
    {
        $del = PelamarOrganisasiModel::find($id);
        $id_pelamar = $del->id_pelamar;
        $del->delete();
        return redirect('hrd/recruitment/aplikasi_pelamar/frm_organisasi/'.$id_pelamar)->with('konfirm', 'Data pengalaman organisasi pelamar berhasil dihapus.');
    }
    //Pengalama Kerja
    public function pengalaman_kerja($id)
    {
        $profil = PelamarModel::find($id);
        $list_pekerjaan = PelamarPengalamanKerjaModel::where('id_pelamar', $id)->get();
        return view("HRD.recruitment.aplikasi_pelamar.form_pekerjaan", compact(['profil', 'list_pekerjaan']));
    }
    public function pengalaman_kerja_simpan(Request $request)
    {
        $id_pelamar = $request->id_pelamar;
        PelamarPengalamanKerjaModel::create([
            "id_pelamar" => $id_pelamar,
            "nm_perusahaan" => $request->inp_nama,
            "posisi" => $request->inp_posisi,
            "alamat" => $request->inp_alamat,
            "mulai_tahun" => $request->inp_tahun_mulai,
            "sampai_tahun" => $request->inp_tahun_akhir
        ]);
        return redirect('hrd/recruitment/aplikasi_pelamar/frm_pekerjaan/'.$id_pelamar)->with('konfirm', 'Data Pengalaman Kerja Pelamar berhasil disimpan.');
    }
    public function pengalaman_kerja_edit($id)
    {
        $result = PelamarPengalamanKerjaModel::find($id);
        return view("HRD.recruitment.aplikasi_pelamar.form_pekerjaan_edit", compact(['result']));
    }
    public function pengalaman_kerja_update(Request $request, $id) {
        $id_pelamar = $request->id_pelamar;
        $update = PelamarPengalamanKerjaModel::find($id);
        $update->nm_perusahaan = $request->inp_nama;
        $update->posisi = $request->inp_posisi;
        $update->alamat = $request->inp_alamat;
        $update->mulai_tahun = $request->inp_tahun_mulai;
        $update->sampai_tahun = $request->inp_tahun_akhir;
        $update->save();
        return redirect('hrd/recruitment/aplikasi_pelamar/frm_pekerjaan/'.$id_pelamar)->with('konfirm', 'Perubahan data pengalaman kerja pelamar berhasil disimpan.');
    }
    public function pengalaman_kerja_delete($id)
    {
        $del = PelamarPengalamanKerjaModel::find($id);
        $id_pelamar = $del->id_pelamar;
        $del->delete();
        return redirect('hrd/recruitment/aplikasi_pelamar/frm_pekerjaan/'.$id_pelamar)->with('konfirm', 'Data pengalaman kerja pelamar berhasil dihapus.');
    }

    public function dokumen($id)
    {
        $profil = PelamarModel::find($id);
        $list_dokumen = PelamarDokumenModel::where('id_pelamar', $id)->get();
        $jenis_dokumen = JenisDokumenKaryawanModel::where('pelamar', 1)->get();
        return view("HRD.recruitment.aplikasi_pelamar.form_dokumen", compact(['profil', 'list_dokumen', 'jenis_dokumen']));
    }

    public function dokumen_tambah($id_dokumen, $id_pelamar)
    {
        $profil = PelamarModel::find($id_pelamar);
        $profil_dok = JenisDokumenKaryawanModel::find($id_dokumen);
        return view("HRD.recruitment.aplikasi_pelamar.form_dokumen_add", compact([
            'id_dokumen',
            'id_pelamar',
            'profil',
            'profil_dok'
        ]));
    }

    public function dokumen_simpan(Request $request)
    {
        $id_pelamar = $request->id_pelamar;
        $id_dokumen = $request->id_dokumen;
        $allowedfileExtension=['jpg','png','jpeg'];
        Image::configure(array('driver' => 'gd'));
        $path_file = "public/hrd/pelamar/dokumen/".$id_dokumen."/";
        $path = storage_path("app/public/hrd/pelamar/dokumen/".$id_dokumen."/");
        if($request->hasFile('inp_dokumen'))
        {
            $image = $request->file('inp_dokumen');
            $extension = $image->getClientOriginalExtension();
            $check=in_array($extension,$allowedfileExtension);
            if($check)
            {
                $filename = $id_dokumen.$id_pelamar.time().date('dmY').".".$extension;
                if(!File::isDirectory($path)) {
                    $path = Storage::disk('public')->makeDirectory('hrd/pelamar/dokumen/'.$id_dokumen);
                }
                $image_resize = Image::make($image->getRealPath());
                $image_resize->resize(250, null, function($construction){
                    $construction->aspectRatio();
                });

                $image_resize->save(storage_path("app/public/hrd/pelamar/dokumen/".$id_dokumen."/".$filename));
                PelamarDokumenModel::create([
                    'id_pelamar' => $request->id_pelamar,
                    'id_dokumen' => $request->id_dokumen,
                    'file_dokumen' => $filename,
                    'path_file' => $path_file
                ]);
                return redirect('hrd/recruitment/aplikasi_pelamar/frm_dokumen/'.$id_pelamar)->with('konfirm', 'Dokumen pelamar berhasil disimpan.');
            }

        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function dokumen_edit($id_dokumen, $id_pelamar)
    {
        $profil = PelamarModel::find($id_pelamar);
        $profil_dok = PelamarDokumenModel::with('get_master_dokumen')->find($id_dokumen);

        return view("HRD.recruitment.aplikasi_pelamar.frm_dokumen_edit", compact([
            'id_pelamar',
            'profil',
            'profil_dok'
        ]));
    }

    public function dokumen_update(Request $request, $id_dok_pelamar)
    {
        $result = PelamarDokumenModel::findorFail($id_dok_pelamar);
        $id_pelamar = $result->id_pelamar;
        if($request->hasFile('inp_dokumen')) {
            try {
                $this->del_image_dokumen($id_dok_pelamar);
                Image::configure(array('driver' => 'gd'));
                $path_file = "public/hrd/pelamar/dokumen/".$result->id_dokumen."/";
                $path = storage_path("app/public/hrd/pelamar/dokumen/".$result->id_dokumen."/");
                $image = $request->file('inp_dokumen');
                $extension = $image->getClientOriginalExtension();
                $filename = $result->id_dokumen.$id_pelamar.time().date('dmY').".".$extension;
                if(!File::isDirectory($path)) {
                    $path = Storage::disk('public')->makeDirectory('hrd/pelamar/dokumen/'.$result->id_dokumen);
                }
                $image_resize = Image::make($image->getRealPath());
                $image_resize->resize(250, null, function($construction){
                    $construction->aspectRatio();
                });
                $image_resize->save(storage_path("app/public/hrd/pelamar/dokumen/".$result->id_dokumen."/".$filename));
                $result->update([
                    'file_dokumen' => $filename,
                    'path_file' => $path_file
                ]);
                return redirect('hrd/recruitment/aplikasi_pelamar/frm_dokumen/'.$id_pelamar)->with('konfirm', 'Perubahan dokumen pelamar berhasil disimpan.');


            } catch (QueryException $e) {
                return redirect('hrd/recruitment/aplikasi_pelamar/frm_dokumen/'.$id_pelamar)->with('konfirm', $e->errorInfo);
            }
        } else {
            return redirect('hrd/recruitment/aplikasi_pelamar/frm_dokumen/'.$id_pelamar)->with('konfirm', 'File dokumen kosong');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function dokumen_destroy($id)
    {
        $result = PelamarDokumenModel::findorFail($id);
        if(empty($result->id)) {
            return redirect('hrd/recruitment/aplikasi_pelamar/frm_dokumen/'.$result->id_pelamar)->with('konfirm', 'Data yang akan dihapus kosong');

        } else {
            $this->del_image_dokumen($id);
            $result->delete();
            return redirect('hrd/recruitment/aplikasi_pelamar/frm_dokumen/'.$result->id_pelamar)->with('konfirm', 'Data dokumen pelamar berhasil dihapus');
        }
    }
    public function del_image_dokumen($id)
    {
        $resfile = PelamarDokumenModel::where('id', $id)->first();
        $filename = $resfile->file_dokumen;
        $image_path = storage_path('app/'.$resfile->path_file.$filename);
        if(File::exists($image_path)) {
            File::delete($image_path);
        }
    }

    //Apply to Employee
    public function recr_to_karyawan($id)
    {
        $profil = PelamarModel::with([
            'get_departmen', 'get_sub_departemen', 'get_jabatan'
        ])->find($id);
        $lb_keluarga = PelamarLBKeluargaModel::where('id_pelamar', $id)->get();
        $keluarga = PelamarKeluargaModel::where('id_pelamar', $id)->get();
        $pendidikan = PelamarRiwayatPendidikanModel::where('id_pelamar', $id)->get();
        $organisasi = PelamarOrganisasiModel::where("id_pelamar", $id)->get();
        $pekerjaan = PelamarPengalamanKerjaModel::where("id_pelamar", $id)->get();
        $list_dokumen = PelamarDokumenModel::where('id_pelamar', $id)->get();
        $jenis_dokumen = JenisDokumenKaryawanModel::where('pelamar', 1)->get();
        $list_sts_karyawan = Config::get("constants.status_karyawan");
        $persetujuan_al = RecruitmentPersetujuanModel::where('level', 1)->where('id_pelamar', $id)->get();
        $persetujuan_hrd = RecruitmentPersetujuanModel::where('level', 2)->where('id_pelamar', $id)->get();
        return view("HRD.recruitment.recr_to_employee.index", compact(['profil', 'lb_keluarga', 'keluarga', 'pendidikan', 'organisasi', 'pekerjaan', 'list_dokumen', 'jenis_dokumen', 'list_sts_karyawan', 'persetujuan_al', 'persetujuan_hrd']));
    }

    public function recr_to_karyawan_store(Request $request)
    {
        $data_pelamar = PelamarModel::find($request->id_pelamar);
        $id_appr_hrd = (!empty(RecruitmentPersetujuanModel::where('level', 2)->where('id_pelamar', $request->id_pelamar)->first()->user_id)) ? RecruitmentPersetujuanModel::where('level', 2)->where('id_pelamar', $request->id_pelamar)->first()->user_id : 0;
        $tgl_masuk = $request->inp_tgl_mulai;
        $nik_baru = $this->buat_nik_baru($tgl_masuk);
        //move file photo rec to empl
        $filename = NULL;
        if(!empty($data_pelamar->file_photo))
        {
            $ext_file_photo_rec = explode('.', $data_pelamar->file_photo);
            $filename = $nik_baru.".".$ext_file_photo_rec[1];
            $from_path = storage_path("app/public/hrd/pelamar/photo/".$data_pelamar->file_photo);
            $to_path = storage_path("app/public/hrd/photo/".$filename);
            File::copy($from_path, $to_path);
        }


        $arr_tgl_masuk = explode("/", $request->inp_tgl_mulai);
        $tgl_masuk_simpan = $arr_tgl_masuk[2]."-".$arr_tgl_masuk[1]."-".$arr_tgl_masuk[0];
        $arr_tgl_akh = explode("/", $request->inp_tgl_akhir);
        $tgl_akh_simpan = $arr_tgl_akh[2]."-".$arr_tgl_akh[1]."-".$arr_tgl_akh[0];
        //simpan ke karyawan baru
        $lastID = KaryawanModel::create([
            'nik_auto' => 1, //manual
            'nik' => $nik_baru,
            'nm_lengkap' => $data_pelamar->nama_lengkap,
            'tmp_lahir' => $data_pelamar->tempat_lahir,
            'tgl_lahir' => $data_pelamar->tanggal_lahir,
            'jenkel' => $data_pelamar->jenkel,
            'no_ktp' => $data_pelamar->no_identitas,
            'alamat' => $data_pelamar->alamat,
            'notelp' => $data_pelamar->no_hp,
            'nmemail' => $data_pelamar->email,
            //'suku' => $request->inp_suku,
            'agama' => $data_pelamar->id_agama,
            'pendidikan_akhir' => $data_pelamar->id_jenjang,
            'status_nikah' => $data_pelamar->status_nikah,
            'gaji_pokok' =>  str_replace(",","",  $request->inp_gapok),
            'gaji_bpjs' =>  str_replace(",","", $request->inp_gapok_bpjskes),
            'gaji_jamsostek' =>  str_replace(",","", $request->inp_gapok_bpksket),
            'photo' => $filename,
            'tgl_masuk' => $tgl_masuk_simpan,
            'id_divisi' => $data_pelamar->get_departmen->id_divisi,
            'id_departemen' => $data_pelamar->id_departemen,
            'id_subdepartemen' => $data_pelamar->id_sub_departemen,
            'id_jabatan' => $data_pelamar->id_jabatan,
            'tmt_jabatan' => $tgl_masuk_simpan,
            'id_status_karyawan' => $request->pil_sts_karyawan,
            'tgl_sts_efektif_mulai' => $tgl_masuk_simpan,
            'tgl_sts_efektif_akhir' => $tgl_akh_simpan
        ])->id;
        //perubahan status
        $no_surat = $this->recr_to_karyawan_create_no_surat();
        $lastIDPerubahanStatus = PerubahanStatusModel::create([
            'id_karyawan' => $lastID,
            'no_surat' => $no_surat,
            'tgl_surat' => date("Y-m-d"),
            'tgl_eff_lama' => $tgl_masuk_simpan,
            'tgl_akh_lama' => $tgl_akh_simpan,
            'id_sts_lama' => $request->pil_sts_karyawan,
            'tgl_eff_baru' => $tgl_masuk_simpan,
            'tgl_akh_baru' => $tgl_akh_simpan,
            'id_sts_baru' => $request->pil_sts_karyawan,
            'no_auto' => 1, //auto
            'current_approval_id' => $data_pelamar->current_approval_id
        ])->id;

        //update table pelamar
        $data_pelamar->status = 3; //telah menjadi karyawan
        $data_pelamar->no_surat_pengantar = $this->recr_to_karyawan_create_no_surat_pengantar();
        $data_pelamar->tgl_surat_pengantar = date("Y-m-d");
        $data_pelamar->surat_by = auth()->user()->id; //id user
        $data_pelamar->hrd_by = $id_appr_hrd;
        $data_pelamar->no_surat_si = $this->recr_to_karyawan_create_no_surat_si();
        $data_pelamar->tgl_surat_si = date("Y-m-d");
        $data_pelamar->id_karyawan = $lastID;
        $data_pelamar->id_perubahan_status = $lastIDPerubahanStatus;
        $data_pelamar->update();

        //data latar belakang keluarga
        $list_lb_keluarga = PelamarLBKeluargaModel::where('id_pelamar', $request->id_pelamar)->get();
        if($list_lb_keluarga->count()>0)
        {
            foreach($list_lb_keluarga as $lbkel)
            {
                LBKeluargaModel::create([
                    'id_karyawan' => $lastID,
                    'id_hubungan' => $lbkel->id_hubungan,
                    'nm_keluarga' => $lbkel->nm_keluarga,
                    'tmp_lahir' => $lbkel->tmp_lahir,
                    'tgl_lahir' => $lbkel->tgl_lahir,
                    'jenkel' => $lbkel->jenkel,
                    'id_jenjang' => $lbkel->id_jenjang,
                    'pekerjaan' => $lbkel->pekerjaan
                ]);
            }
        }
        //data keluarga
        $list_keluarga = PelamarKeluargaModel::where('id_pelamar', $request->id_pelamar)->get();
        if($list_keluarga->count()>0)
        {
            foreach($list_keluarga as $dtkel)
            {
                KeluargaModel::create([
                    'id_karyawan' => $lastID,
                    'id_hubungan' => $dtkel->id_hubungan,
                    'nm_keluarga' => $dtkel->nm_keluarga,
                    'tmp_lahir' => $dtkel->tmp_lahir,
                    'tgl_lahir' => $dtkel->tgl_lahir,
                    'jenkel' => $dtkel->jenkel,
                    'id_jenjang' => $dtkel->id_jenjang,
                    'pekerjaan' => $dtkel->pekerjaan
                ]);
            }
        }
        //jenjang pendidikan
        $list_pendidikan = PelamarRiwayatPendidikanModel::where('id_pelamar', $request->id_pelamar)->get();
        if($list_pendidikan->count()>0)
        {
            foreach($list_pendidikan as $dtpend)
            {
                RiwayatPendidikanModel::create([
                    'id_karyawan' => $lastID,
                    'id_jenjang' => $dtpend->id_jenjang,
                    'nm_sekolaj_pt' => $dtpend->nm_sekolah_pt,
                    'alamat' => $dtpend->alamat,
                    'mulai_tahun' => $dtpend->mulai_tahun,
                    'sampai_tahun' => $dtpend->sampai_tahun
                ]);
            }
        }
        //pengalaman kerja
        $list_kerja = PelamarPengalamanKerjaModel::where('id_pelamar', $request->id_pelamar)->get();
        if($list_kerja->count()>0)
        {
            foreach($list_kerja as $dtkerja)
            {
                PengalamanKerjaModel::create([
                    'id_karyawan' => $lastID,
                    'nm_perusahaan' => $dtkerja->nm_perusahaan,
                    'posisi' => $dtkerja->posisi,
                    'alamat' => $dtkerja->alamat,
                    'mulai_tahun' => $dtkerja->mulai_tahun,
                    'sampai_tahun' => $dtkerja->sampai_tahun
                ]);
            }
        }
        //dokumen
        $path = storage_path("app/public/hrd/dokumen/".$nik_baru);
        if(!File::isDirectory($path)) {
            $path = Storage::disk('public')->makeDirectory('hrd/dokumen/'.$nik_baru);
        }

        $list_dokumen = PelamarDokumenModel::where('id_pelamar', $request->id_pelamar)->get();
        if($list_dokumen->count()>0)
        {
            foreach($list_dokumen as $dtdok)
            {
                $image = $dtdok->file_dokumen;
                $extension = explode(".", $image);
                $filename = date('dmY').time()."-".$dtdok->id_dokumen."-".$lastID;
                $file_sv = $filename.".".$extension[1];
                $from_path = storage_path("app/public/hrd/pelamar/dokumen/".$dtdok->id_dokumen."/".$image);
                $to_path = storage_path("app/public/hrd/dokumen/".$nik_baru."/".$file_sv);
                File::copy($from_path, $to_path);

                DokumenKaryawanjaModel::create([
                    'id_karyawan' => $lastID,
                    'id_dokumen' => $dtdok->id_dokumen,
                    'file_dokumen' => $file_sv
                ]);
            }
        }
        return redirect('hrd/recruitment/aplikasi_pelamar')->with('konfirm', 'Proses perubahan status pelamar menjadi karyawan berhasil dilakukan.');
    }

    public function buat_nik_baru($tgl_masuk)
    {
        $tgl_masuk = $tgl_masuk;
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
        return $nik_baru;
    }

    public function recr_to_karyawan_create_no_surat()
    {
        $thn = date('Y');
        $bln = hrdfunction::get_bulan_romawi(date('m'));
        $no_urut = 1;
        $ket_surat = "SSB/PKWT";
        $nomor_awal = $ket_surat."/".$bln."/".$thn;
        $result =  PerubahanStatusModel::orderBy('id', 'desc')->first();
        if(empty($result->no_surat))
        {
            $nomor_urut = sprintf('%03s', $no_urut);
        } else {
            $nomor_urut_terakhir = substr($result->no_surat, 0, 3)+1;
            $nomor_urut = sprintf('%03s', $nomor_urut_terakhir);
        }
        return $nomor_urut."/".$nomor_awal;
    }

    public function recr_to_karyawan_create_no_surat_pengantar()
    {
        $thn = date('Y');
        $bln = hrdfunction::get_bulan_romawi(date('m'));
        $no_urut = 1;
        $ket_surat = "SPP/SSB";
        $nomor_awal = $ket_surat."/".$bln."/".$thn;
        $result =  PelamarModel::orderBy('id', 'desc')->first();
        if(empty($result->no_surat_pengantar))
        {
            $nomor_urut = sprintf('%03s', $no_urut);
        } else {
            $nomor_urut_terakhir = substr($result->no_surat_pengantar, 0, 3)+1;
            $nomor_urut = sprintf('%03s', $nomor_urut_terakhir);
        }
        return $nomor_urut."/".$nomor_awal;
    }

    public function recr_to_karyawan_create_no_surat_si()
    {
        $thn = date('Y');
        $bln = hrdfunction::get_bulan_romawi(date('m'));
        $no_urut = 1;
        $ket_surat = "SPSI/SSB";
        $nomor_awal = $ket_surat."/".$bln."/".$thn;
        $result =  PelamarModel::orderBy('id', 'desc')->first();
        if(empty($result->no_surat_si))
        {
            $nomor_urut = sprintf('%03s', $no_urut);
        } else {
            $nomor_urut_terakhir = substr($result->no_surat_si, 0, 3)+1;
            $nomor_urut = sprintf('%03s', $nomor_urut_terakhir);
        }
        return $nomor_urut."/".$nomor_awal;
    }

    //Surat pengantar penempatan
    public function surat_pengantar_penempatan($id)
    {
        $id_employee = auth()->user()->karyawan->id;
        $list_jenjang = Config::get("constants.jenjang_pendidikan");
        $profil = PelamarModel::with([
            'get_departmen', 'get_sub_departemen', 'get_jabatan', 'get_current_approve'
        ])->find($id);
        $kop_surat = hrdfunction::get_kop_surat();
        $pdf = PDF::loadview('HRD.recruitment.surat.print_surat_pengantar_penempatan', compact([
            'profil',
            'list_jenjang',
            'id_employee',
            'kop_surat'
        ]))->setPaper('A4', 'potrait');
        return $pdf->stream();
    }
    public function surat_pengantar_safety_induction($id)
    {
        $id_employee = auth()->user()->karyawan->id;
        $list_jenjang = Config::get("constants.jenjang_pendidikan");
        $profil = PelamarModel::with([
            'get_departmen', 'get_sub_departemen', 'get_jabatan', 'get_current_approve'
        ])->find($id);
        $kop_surat = hrdfunction::get_kop_surat();
        $pdf = PDF::loadview('HRD.recruitment.surat.print_surat_induksi', compact([
            'profil',
            'list_jenjang',
            'id_employee',
            'kop_surat'
        ]))->setPaper('A4', 'potrait');
        return $pdf->stream();
    }


    //Pengajuan Tenaga Kerja
    //Admin HRD
    public function pengajuan_tenaga_kerja_adm()
    {
        $data = [
            'departemen' => DepartemenModel::where('status', 1)->get()->map(
                function($rows) {
                    $arr_row = $rows->toArray();
                    $arr_row['total_pengajuan'] = RecruitmentPengajuanTKModel::where('id_departemen', $rows['id'])->get()->count();
                    return $arr_row;
                }
            )
        ];
        // dd($data);
        // $list_pengajuan = RecruitmentPengajuanTKModel::orderBy('tanggal_pengajuan', 'DESC')->get();
        return view("HRD.recruitment.admin.list_pengajuan", $data);
    }
    public function data_pengajuan_tenaga_kerja_adm(Request $request)
    {
        $columns = ['created_at'];
        $totalData = RecruitmentPengajuanTKModel::count();
        $search = $request->input('search.value');

        $query = RecruitmentPengajuanTKModel::with([
            'get_departemen',
            'get_jabatan'
        ]);
        if(!empty($request->dept))
        {
            $query->where('id_departemen',$request->dept);
        }
        if(!empty($request->jabatan))
        {
            $query->where('id_jabatan',$request->jabatan);
        }
        $totalFiltered = $query->count();
        $query = $query->offset($request->input('start'))
            ->limit($request->input('length'))
            // ->orderBy($columns[$request->input('order.0.column')], $request->input('order.0.dir'))
            ->orderBy('tanggal_pengajuan', 'desc')
            ->get();

        $data = array();
        if ($query) {
            $counter = 1;
            $status_pengajuan = "";
            $action = "";
            foreach ($query as $r) {
                if($r->status_pengajuan==1) {
                    $status_pengajuan = '<span class="badge badge-pill badge-danger">Menunggu Persetujuan : '. $r->get_current_approve->nm_lengkap.'</span><span class="badge badge-pill badge-danger">'.$r->get_current_approve->get_jabatan->nm_jabatan.'</span>';
                } elseif ($r->status_pengajuan==2) {
                    $status_pengajuan = '<span class="badge badge-success">Disetujui</span>';
                } else {
                    $status_pengajuan = '<span class="badge badge-danger">Ditolak</span>';
                }
                if($r->status_pengajuan==2) {
                    $action = '<a class="btn btn-primary" href="'.url('hrd/recruitment/detail_pengajuan_tenaga_kerja/'.$r->id).'" target="_new"><i class="fa fa-eye"></i></a>
                    <a class="btn btn-success" href="'.url('hrd/recruitment/print_pengajuan_tenaga_kerja/'.$r->id).'" target="_new"><i class="fa fa-print"></i></a>';
                }
                $nestedData['id'] = $r->id;
                $nestedData['tanggal_pengajuan'] = date_format(date_create($r->tanggal_pengajuan), 'd-m-Y');
                $nestedData['jabatan'] = $r->get_jabatan->nm_jabatan;
                $nestedData['departemen'] = $r->get_departemen->nm_dept;
                $nestedData['jumlah'] = $r->jumlah_orang;
                $nestedData['tgl_dibutuhkan'] = date_format(date_create($r->tanggal_dibutuhkan), 'd-m-Y');
                $nestedData['alasan_permintaan'] = $r->alasan_permintaan;
                $nestedData['status_pengajuan'] = $status_pengajuan;
                $nestedData['action'] = $action;
                $nestedData['no'] = $counter;
                $data[] = $nestedData;
                $counter++;
            }
        }
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => $data
        ]);
    }
    public function detail_pengajuan_tenaga_kerja_adm($id)
    {
        $detail_pengajuan = RecruitmentPengajuanTKModel::find($id);
        $hirarki_persetujuan = ApprovalModel::where('approval_key', $detail_pengajuan->approval_key)->orderBy('approval_level')->get();
        return view("HRD.recruitment.admin.detail_pengajuan", compact(['detail_pengajuan', 'hirarki_persetujuan']));
    }

    public function list_pengajuan_tk_departemen($id_dept)
    {
        $data = [
            "list_pengajuan" => RecruitmentPengajuanTKModel::where('id_departemen', $id_dept)->orderBy('tanggal_pengajuan', "desc")->get()
        ];
        return view('HRD.recruitment.admin.list_pengajuan_tk_dept', $data);
    }

    public function print_pengajuan_tenaga_kerja_adm($id)
    {
        $main = RecruitmentPengajuanTKModel::find($id);
        $data = [
            'detail_pengajuan' => $main,
            'fl_logo' => hrdfunction::get_profil_perusahaan()->logo_perusahaan,
            'approver' => ApproverHrd::listApprover($main->approval_key),
            'knowing' => ApproverHrd::listKnowing($main->approval_key),
            'countColumn' => ApproverHrd::countLevel($main->approval_key),
            'witdhColumn' =>  100 / (ApproverHrd::countLevel($main->approval_key) + 1)
        ];
        $pdf = PDF::loadview('HRD.recruitment.admin.print_pengajuan', $data)->setPaper('A4', 'potrait');
        return $pdf->stream();
    }
    //Admin Departemen
    public function pengajuan_tenaga_kerja()
    {
        $id_depat_karyawan = auth()->user()->karyawan->id_departemen;
        $arrjabt = [];
        if(empty($id_depat_karyawan))
        {
            $queryJabt = JabatanModel::where('id_gakom', auth()->user()->karyawan->id_jabatan)->get();
            foreach($queryJabt as $r) {
                $arrjabt[] = $r->id_dept;
            }
            $list_pengajuan = RecruitmentPengajuanTKModel::whereIn('id_departemen', $arrjabt)->orderby('tanggal_pengajuan', 'desc')->get();

        } else {
            $list_pengajuan = RecruitmentPengajuanTKModel::where('id_departemen', $id_depat_karyawan)->orderby('tanggal_pengajuan', 'desc')->get();
        }

        return view("HRD.recruitment.pengajuan.index", compact(['list_pengajuan']));
    }
    public function pengajuan_tenaga_kerja_baru()
    {
        $profil = KaryawanModel::find(auth()->user()->karyawan->id);
        if(empty($profil->id_departemen)) {
            $list_jabatan = JabatanModel::where('status', 1)->get();
        } else {
            $list_jabatan = JabatanModel::where('id_dept', $profil->id_departemen)->get();
        }
        return view("HRD.recruitment.pengajuan.add", compact(['profil', 'list_jabatan']));
    }

    public function pengajuan_tenaga_kerja_store(Request $request)
    {
        // $id_gakom = JabatanModel::find($request->req_jabatan)->id_gakom;
        // $_uuid = Str::uuid();
        // $get_approval_first = KaryawanModel::where('id_jabatan', $id_gakom)->first();
        $id_depat_karyawan = $request->reg_departemen;

        if(empty($id_depat_karyawan))
        {
            $queryJabt = JabatanModel::find($request->req_jabatan);
            if($queryJabt) {
                $id_depat_karyawan = $queryJabt->id_dept;
            }

        }
        $_uuid = Str::uuid();
        $group = 1;
        $ifSet = hrdfunction::set_approval_cek($group, $id_depat_karyawan);
        if($ifSet > 0)
        {
            RecruitmentPengajuanTKModel::create([
                'tanggal_pengajuan' => date('Y-m-d'),
                'id_departemen' => $id_depat_karyawan,
                'id_jabatan' => $request->req_jabatan,
                'jumlah_orang' => $request->req_jumlah,
                'tanggal_dibutuhkan' => $request->req_tanggal,
                'alasan_permintaan' => $request->check_alasan,
                'jenkel' => $request->check_jenkel,
                'umur_min' => $request->req_umur_min,
                'umur_maks' => $request->req_umur_maks,
                'pendidikan' => $request->check_pendidikan,
                'keahlian_khusus' => $request->req_keahlian,
                'pengalaman' => $request->check_pengalaman,
                'kemampuan_bahasa_ing' => $request->check_bhs_inggris,
                'kemampuan_bahasa_ind' => $request->check_bhs_indonesia,
                'kemampuan_bahasa_lain' => $request->inp_bhs_lain,
                'kepribadian' => $request->req_kepribadian,
                'catatan' => $request->req_catatan,
                'user_id' => auth()->user()->id,
                'status_pengajuan' => 1, //Pengajuan
                'approval_key' => $_uuid,
                'current_approval_id' => hrdfunction::set_approval_get_first($group, $id_depat_karyawan),
                'is_draft' => 1, //pengajuan masih bisa diedit,
            ]);

            $arr_appr =  hrdfunction::set_approval_new($group, $id_depat_karyawan);
            foreach($arr_appr as $appr)
            {
                $approval_active=0;
                if($appr['approval_level']==1) {
                    $approval_active = 1;
                }
                ApprovalModel::create([
                    'approval_by_employee' => $appr['approval_by_employee'],
                    'approval_level' => $appr['approval_level'],
                    'approval_key' => $_uuid,
                    'approval_group' => $group, //Pengajuan Cuti
                    'approval_active' => $approval_active
                ]);
            }
            return redirect('hrd/recruitment/pengajuan_tenaga_kerja')->with('konfirm', 'Proses berhasil disimpan');
        } else {
            return redirect('hrd/recruitment/pengajuan_tenaga_kerja')->with('konfirm', 'Matriks persetujuan belum diatur');
        }

    }
    public function pengajuan_tenaga_kerja_edit($id)
    {
        $arr_kepribadian = array("Jujur", "Sholeh", "Loyalis", "Integritas", "Bersih");
        $profil = KaryawanModel::find(auth()->user()->karyawan->id);
        $list_jabatan = JabatanModel::where('id_dept', $profil->id_departemen)->get();
        $detail_pengajuan = RecruitmentPengajuanTKModel::find($id);
        return view("HRD.recruitment.pengajuan.edit", compact(['detail_pengajuan', 'list_jabatan', 'profil', 'arr_kepribadian']));
    }
    public function pengajuan_tenaga_kerja_update(Request $request, $id)
    {
        $update = RecruitmentPengajuanTKModel::find($id);
        $update->id_jabatan = $request->req_jabatan;
        $update->jumlah_orang = $request->req_jumlah;
        $update->tanggal_dibutuhkan = $request->req_tanggal;
        $update->alasan_permintaan = $request->check_alasan;
        $update->jenkel = $request->check_jenkel;
        $update->umur_min = $request->req_umur_min;
        $update->umur_maks = $request->req_umur_maks;
        $update->pendidikan = $request->check_pendidikan;
        $update->keahlian_khusus = $request->req_keahlian;
        $update->pengalaman = $request->check_pengalaman;
        $update->kemampuan_bahasa_ing = $request->check_bhs_inggris;
        $update->kemampuan_bahasa_ind = $request->check_bhs_indonesia;
        $update->kemampuan_bahasa_lain = $request->inp_bhs_lain;
        $update->kepribadian = $request->req_kepribadian;
        $update->catatan = $request->req_catatan;
        $update->save();
        return redirect('hrd/recruitment/pengajuan_tenaga_kerja/edit/'.$id)->with('konfirm', 'Perubahan data pengajuan berhasil disimpan.');
    }

    public function pengajuan_tenaga_kerja_delete($id)
    {
        $exec_delete = RecruitmentPengajuanTKModel::find($id)->delete();
        if($exec_delete) {
            return redirect('hrd/recruitment/pengajuan_tenaga_kerja')->with('konfirm', 'Data berhasil dihapus');
        }
    }

    public function persetujuan_pengajuan_tenaga_kerja_detail($id)
    {
        $detail_pengajuan = RecruitmentPengajuanTKModel::find($id);
        $hirarki_persetujuan = ApprovalModel::where('approval_key', $detail_pengajuan->approval_key)->orderBy('approval_level')->get();
        return view("HRD.recruitment.persetujuan.frm_pengajuan_permintaan_tk_detail", compact(['detail_pengajuan', 'hirarki_persetujuan']));
    }

    //rekap hasil tes
    public function rekap_hasil_tes()
    {
        $data = [
            'departemen' => DepartemenModel::where('status', 1)->get()
        ];

        return view('HRD.recruitment.hasil_tes.index', $data);
    }

    public function rekap_hasil_tes_data(Request $request)
    {
        $columns = ['created_at'];
        $totalData = PelamarModel::count();
        $search = $request->input('search.value');

        $query = PelamarModel::with([
            'get_departmen',
            'get_jabatan'
        ])->where('status_pengajuan', 1);
        if(!empty($request->dept))
        {
            $query->where('id_departemen',$request->dept);
        }
        if(!empty($request->jabatan))
        {
            $query->where('id_jabatan',$request->jabatan);
        }
        $totalFiltered = $query->count();
        $query = $query->offset($request->input('start'))
            ->limit($request->input('length'))
            // ->orderBy($columns[$request->input('order.0.column')], $request->input('order.0.dir'))
            ->orderBy('total_skor', 'desc')
            ->get();

        $data = array();
        if ($query) {
            $counter = 1;
            $path = "hrd/pelamar/photo/";
            foreach ($query as $r) {
                $umur = hrdfunction::get_umur_karyawan($r->tanggal_lahir);
                $photo = '<a href="'.url(Storage::url($path.$r->file_photo)).'" data-fancybox data-caption="avatar">
                <img src="'.url(Storage::url($path.$r->file_photo)).'" style="width: 50px; height: auto" alt="Dokumen"></a>';
                $nestedData['id'] = $r->id;
                $nestedData['photo'] = $photo;
                $nestedData['nama_lengkap'] = $r->nama_lengkap;
                $nestedData['usia'] = $umur;
                $nestedData['pend_akhir'] = $r->get_pendidikan_akhir($r->id_jenjang);
                $nestedData['nilai_psikotes'] = $r->psikotes_nilai;
                $nestedData['ket_psikotes'] = $r->psikotes_ket;
                $nestedData['nilai_wawancara'] = $r->wawancara_nilai;
                $nestedData['ket_wawancara'] = $r->wawancara_ket;
                $nestedData['total_skor'] = $r->total_skor;
                $nestedData['no'] = $counter;
                $data[] = $nestedData;
                $counter++;
            }
        }
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => $data
        ]);
    }

    public function rekap_hasil_tes_print($dept, $jabatan)
    {
        $query = PelamarModel::with([
            'get_departmen',
            'get_jabatan'
        ])->where('status_pengajuan', 1);
        if(!empty($dept))
        {
            $query->where('id_departemen',$dept);
        }
        if(!empty($jabatan))
        {
            $query->where('id_jabatan',$jabatan);
        }
        $list = $query->orderBy('total_skor', 'desc')
            ->get();

        $data = [
            'departemen' => DepartemenModel::find($dept),
            'jabatan' => JabatanModel::find($jabatan),
            'list' => $list,
            'fl_logo' => hrdfunction::get_profil_perusahaan()->logo_perusahaan,
            'al' => $this->getAtasan(auth()->user()->karyawan->id_departemen)
        ];

        $pdf = PDF::loadview('HRD.recruitment.hasil_tes.print', $data)->setPaper('A4', 'landscape');
        return $pdf->stream();
    }

    function getAtasan($departemen)
    {
        $result = array();
        $jabatan = JabatanModel::where('id_level', 4)->where('id_dept', $departemen)->first();
        if(empty($jabatan->id)) {
            $result = [
                "nama_pejabat" => "",
                "jabatan_pejabat" => ""
            ];
        } else {
            $pejabat = KaryawanModel::where('id_jabatan', $jabatan->id)->first();
            if(!empty($jabatan->id)) {
                $result = [
                    "nama_pejabat" => $pejabat->nm_lengkap,
                    "jabatan_pejabat" => $pejabat->get_jabatan->nm_jabatan
                ];
            } else {
                $result = [
                    "nama_pejabat" => "",
                    "jabatan_pejabat" => ""
                ];
            }

        }
        return $result;
    }

    public function rekap_hasil_tes_excel($dept, $jabatan)
    {
        return (new RekapHasilTesRecruitmenExport($dept, $jabatan))->download('rekapHasilTesRecruitmen-'.$dept.'-'.$jabatan.'.xlsx');
    }

    //close/app
    public function close_app($id)
    {
        $updateApp = PelamarModel::find($id);
        $updateApp->status_app = "close";
        $queryExec = $updateApp->update();
        if($queryExec) {
            $status = true;
            $pesan = "Aplikasi pelamar berhasil di close";
        } else {
            $status = false;
            $pesan = "Aplikasi pelamar gagal di close. Terjadi Error";
        }
        return response()->json([
            "success" => $status,
            "message" => $pesan
        ]);
    }

    public function open_app($id)
    {
        $updateApp = PelamarModel::find($id);
        $updateApp->status_app = NULL;
        $queryExec = $updateApp->update();
        if($queryExec) {
            $status = true;
            $pesan = "Aplikasi pelamar berhasil di open";
        } else {
            $status = false;
            $pesan = "Aplikasi pelamar gagal di open. Terjadi Error";
        }
        return response()->json([
            "success" => $status,
            "message" => $pesan
        ]);
    }

    public function submit_app($id)
    {
        $profil = PelamarModel::with(['get_list_persetujuan'])->find($id);
        $lb_keluarga = PelamarLBKeluargaModel::where('id_pelamar', $id)->get();
        $keluarga = PelamarKeluargaModel::where('id_pelamar', $id)->get();
        $pendidikan = PelamarRiwayatPendidikanModel::where('id_pelamar', $id)->get();
        $organisasi = PelamarOrganisasiModel::where("id_pelamar", $id)->get();
        $pekerjaan = PelamarPengalamanKerjaModel::where("id_pelamar", $id)->get();
        $list_dokumen = PelamarDokumenModel::where('id_pelamar', $id)->get();
        $jenis_dokumen = JenisDokumenKaryawanModel::where('pelamar', 1)->get();
        $hirarki_persetujuan = ApprovalModel::where('approval_key', $profil->approval_key)->orderBy('approval_level')->get();
        $listLowongan = RecruitmentPengajuanTKModel::with(['get_departemen', 'get_jabatan'])->where("status_pengajuan", 2)->get();
        return view("HRD.recruitment.aplikasi_pelamar.form_submit_app", compact(['profil', 'lb_keluarga', 'keluarga', 'pendidikan', 'organisasi', 'pekerjaan', 'list_dokumen', 'jenis_dokumen', 'hirarki_persetujuan', 'listLowongan']));
    }

    public function submit_app_update(Request $request)
    {
        $idData = $request->id_pelamar;
        $appr_key = $request->key_approval;
        $status_app = $request->status_app;
        $status_pengajuan = $request->status_pengajuan;
        if(empty($status_app))
        {
            $main_data = PelamarModel::find($idData)->update([
                'status_app' => NULL,
                'id_lowongan' => $request->pilPosisi
            ]);
            $getlist = ApprovalModel::where('approval_key', $appr_key)->get();
            foreach($getlist as $r) {
                ApprovalModel::find($r->id)->update([
                    'approval_active' => 0,
                    'approval_date' => NULL,
                    'approval_remark' => NULL,
                    'approval_status' => NULL,
                ]);
            }
            $selectFirst = ApprovalModel::where('approval_key', $appr_key)->where('approval_level', 1)->first();
            ApprovalModel::find($selectFirst->id)->update([
                'approval_active' => 1
            ]);
        }
        if($status_app=="pending") {
            $main_data = PelamarModel::find($idData);
            $main_data->status_app = NULL;
            $main_data->save();

            $data_approval = ApprovalModel::where('approval_key', $appr_key)->first();
            $data_approval->approval_active = 1;
            $data_approval->approval_date = NULL;
            $data_approval->approval_remark = NULL;
            $data_approval->approval_status = NULL;
            $data_approval->save();
        }

        return redirect('hrd/recruitment/aplikasi_pelamar')->with('konfirm', 'Aplikasi pelamar telah di submit kembali');
    }
}
