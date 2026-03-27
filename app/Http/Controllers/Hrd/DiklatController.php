<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Helpers\Hrdhelper;
use Illuminate\Http\Request;
use App\Models\HRD\DiklatModel;
use App\Models\HRD\KaryawanModel;
use App\Models\HRD\PelaksanaDiklatModel;
use App\Models\HRD\MasterPelatihanModel;
use App\Models\HRD\PelatihanHeaderModel;
use App\Models\HRD\PelatihanDetailModel;
use App\Models\HRD\SetupPersetujuanModel;
use App\Helpers\Hrdhelper as hrdfunction;
use App\Models\HRD\ApprovalModel;
use App\Models\HRD\JabatanModel;
use App\Models\HRD\PengajuanPelatihanDetailModel;
use App\Models\HRD\PengajuanPelatihanHeaderModel;
use PDF;
use Illuminate\Support\Str;

class DiklatController extends Controller
{
    public function index()
    {
        $data['jumlah_pengajuan'] = PelatihanHeaderModel::whereYear('tanggal_awal', date('Y'))->whereNull('status_pelatihan')->with('get_nama_pelatihan', 'get_pelaksana', 'get_detail')->get()->count();
        $data['jumlah_submit'] = PengajuanPelatihanHeaderModel::where('tahun', date('Y'))->where('status_pengajuan', 1)->get()->count();
        $data['list_laporan'] = PelatihanHeaderModel::select('hrd_pelatihan_h.*', 'hrd_pelatihan_d.pasca')
            ->leftJoin('hrd_pelatihan_d', function($join) {
                $join->on('hrd_pelatihan_d.id_head', '=', 'hrd_pelatihan_h.id');
            })
            ->whereYear('hrd_pelatihan_h.tanggal_awal', date("Y"))
            ->where('hrd_pelatihan_d.pasca', 1)->get()->count();
        return view('HRD.diklat.index', $data);
    }
    public function getAllPengajuan()
    {
        $data['all_pengajuan'] = PelatihanHeaderModel::whereYear('tanggal_awal', date('Y'))->whereNull('status_pelatihan')->with('get_nama_pelatihan', 'get_pelaksana', 'get_detail', 'get_peserta')->orderBy('created_at', 'desc')->get();
        return view('HRD.diklat.list_pengajuan', $data);
    }
    public function getAllPelatihan()
    {
        $data['all_pelatihan'] = PelatihanHeaderModel::whereYear('tanggal_awal', date('Y'))->with('get_nama_pelatihan', 'get_pelaksana', 'get_detail')->where('status_pelatihan', '>=', 2)->whereYear('tanggal_awal', date("Y"))->get();
        return view('HRD.diklat.agenda.list', $data);
    }
    public function getAllSubmit()
    {
        $data['all_submit'] = PengajuanPelatihanHeaderModel::with([
            'get_detail',
            'get_detail.getPelatihan',
            'get_detail.getPelatihan.get_nama_pelatihan',
            'get_detail.getPelatihan.get_pelaksana'
        ])->where('tahun', date('Y'))->where('status_pengajuan', 1)->get();
        return view('HRD.diklat.submit.list_submit', $data);
    }
    public function formAdd()
    {
        return view('HRD.diklat.add');
    }
    public function addPelatihanInternal()
    {
        $data['all_pelaksana'] = PelaksanaDiklatModel::all();
        $data['all_pelatihan'] = MasterPelatihanModel::all();
        $data['list_hari'] = Hrdhelper::get_list_hari();
        $data['all_karyawan'] = KaryawanModel::whereIn('id_status_karyawan', [1, 2, 3])->get();
        return view('HRD.diklat.add_internal', $data);
    }
    public function addPelatihanEksternal()
    {
        return view('HRD.diklat.add_eksternal');
    }
    public function get_history($id)
    {
        $res['history'] = DiklatModel::where('id_karyawan', $id)->get();
        return view('HRD.diklat.history', $res);
    }
    public function simpan_data(Request $request)
    {
        $arrTanggal = explode(" - ", $request->inpTglPelaksanaan);
        $arrTgl_1 = explode("/", $arrTanggal[0]);
        $arrTgl_2 = explode("/", $arrTanggal[1]);
        $tgl_awal = $arrTgl_1[2]."-".$arrTgl_1[1]."-".$arrTgl_1[0];
        $tgl_akhir = $arrTgl_2[2]."-".$arrTgl_2[1]."-".$arrTgl_2[0];
        if($request->inpKategori=="Internal")
        {
            PelatihanHeaderModel::create([
                'kategori' => "Internal",
                'id_pelatihan' => $request->inpNamaPelatihan,
                'id_pelaksana' => $request->inpNamaVendor,
                'tempat_pelaksanaan' => $request->inpTempat,
                'tanggal_awal' => $tgl_awal,
                'tanggal_sampai' => $tgl_akhir,
                'durasi' => $request->inpDurasi,
                'kompetensi' => $request->inpKompetensi,
                'investasi_per_orang' => str_replace(",","", $request->inpBiaya),
            ]);
        } else {
            PelatihanHeaderModel::create([
                'kategori' => "Eksternal",
                'nama_pelatihan' => $request->inpNamaPelatihan,
                'nama_vendor' => $request->inpNamaVendor,
                'kontak_vendor' => $request->inpKontakVendor,
                'tempat_pelaksanaan' => $request->inpTempat,
                'tanggal_awal' => $tgl_awal,
                'tanggal_sampai' => $tgl_akhir,
                'durasi' => $request->inpDurasi,
                'kompetensi' => $request->inpKompetensi,
                'investasi_per_orang' => str_replace(",","", $request->inpBiaya),
            ]);
        }
        return redirect('hrd/pelatihan')->with('konfirm', 'Data berhasil disimpan');
    }
    //add peserta
    public function getListPeserta($id)
    {
        $data = [
            'peserta' => PelatihanDetailModel::with(['get_karyawan'])->where('id_head', $id)->get()
        ];
        return view('HRD.diklat.list_peserta', $data);
    }
    public function storePeserta(Request $request)
    {
        $exec = PelatihanDetailModel::create([
            'id_head' => $request->id_data,
            'id_karyawan' => $request->id_peserta
        ]);
        if($exec)
        {
            $tf = true;
        } else {
            $tf = false;
        }
        return response()->json([
            'success' => $tf
        ]);
    }
    public function deletePeserta(Request $request)
    {
        $del = PelatihanDetailModel::find($request->id_data);
        $exec = $del->delete();
        if($exec)
        {
            $tf = true;
        } else {
            $tf = false;
        }
        return response()->json([
            'success' => $tf
        ]);
    }
    //edit pengajuan
    public function form_edit($id_data)
    {
        $id_peserta = array();
        $arr = PelatihanDetailModel::where('id_head', $id_data)->get();
        foreach ($arr as $arr_) {
            $id_peserta[] = $arr_['id_karyawan'];
        }

        $data['dt_h'] = PelatihanHeaderModel::find($id_data);
        $data['dt_d'] = PelatihanDetailModel::where('id_head', $id_data)->get();
        $data['all_pelaksana'] = PelaksanaDiklatModel::all();
        $data['all_pelatihan'] = MasterPelatihanModel::all();
        $data['list_hari'] = Hrdhelper::get_list_hari();
        $data['all_karyawan'] = KaryawanModel::whereIn('id_status_karyawan', [1, 2, 3])->whereNotIn('id', $id_peserta)->get();
        return view('HRD.diklat.edit', $data);
    }

    //submit pengajuan
    public function goFormSubmit()
    {
        $data['all_pengajuan'] = PelatihanHeaderModel::whereNull('status_pelatihan')->with('get_nama_pelatihan', 'get_pelaksana', 'get_detail')->get();
        return view('HRD.diklat.submit.add_submit', $data);
    }

    //detail pengajuan
    public function goFormDetail($id)
    {
        $data['dt_h'] = PelatihanHeaderModel::find($id);
        $data['peserta'] = PelatihanDetailModel::where('id_head', $id)->get();
        return view('HRD.diklat.detail_pengajuan', $data);
    }
    //submit pengajuan
    public function submitPengajuan(Request $request)
    {
        $id_depat_karyawan = KaryawanModel::find(auth()->user()->karyawan->id)->id_departemen;
        $_uuid = Str::uuid();
        $group = 9;
        $ifSet = hrdfunction::set_approval_cek($group, $id_depat_karyawan);
        if($ifSet > 0)
        {
            $jml_row = (isset($request->checkPengajuan)) ? count($request->checkPengajuan) : 0;
            if($jml_row > 0)
            {
                $dHead = [
                    'tahun' => $request->inpPeriode,
                    'deskripsi' => $request->inpDeskripsiPengajuan,
                    'approval_key' => $_uuid,
                    'status_pengajuan' => 1,
                    'current_approval_id' => hrdfunction::set_approval_get_first($group, $id_depat_karyawan),
                    'is_draft' => 1,
                    'diajukan_oleh' => auth()->user()->karyawan->id
                ];
                $idHead = PengajuanPelatihanHeaderModel::create($dHead)->id;
                foreach(array($request) as $key => $value)
                {
                    for($i=0; $i < $jml_row; $i++)
                    {
                        if(isset($request->checkPengajuan))
                        {
                            PengajuanPelatihanDetailModel::create([
                                'id_head' => $idHead,
                                'id_pelatihan' => $value['checkPengajuan'][$i]
                            ]);
                            $update = PelatihanHeaderModel::find($value['checkPengajuan'][$i]);
                            $update->status_pelatihan = 1; //pelatihan status approval
                            $update->update();
                        }
                    }
                }
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
                        'approval_group' => $group,
                        'approval_active' => $approval_active
                    ]);
                }
                $msg = 'Pengajuan pelatihan berhasil disubmit';
            } else {
                $msg = 'Pengajuan pelatihan gagal disubmit';
            }
        } else {
            $msg = 'Matriks persetujuan belum diatur';
        }
        return redirect('hrd/pelatihan')->with('konfirm', $msg);

    }

    public function proses_pelatihan($id_data)
    {
        $data['dt_h'] = PelatihanHeaderModel::find($id_data);
        $data['dt_d'] = PelatihanDetailModel::where('id_head', $id_data)->get();
        $data['all_pelaksana'] = PelaksanaDiklatModel::all();
        $data['all_pelatihan'] = MasterPelatihanModel::all();
        $data['list_hari'] = Hrdhelper::get_list_hari();
        $data['all_karyawan'] = KaryawanModel::whereIn('id_status_karyawan', [1, 2, 3])->get();
        return view('HRD.diklat.detail_pelatihan', $data);
    }
    public function store_proses_pelatihan($id_data)
    {
        //ambil ttd pejabat HRD
        $update = PelatihanHeaderModel::find($id_data);
        $update->nomor = $this->buat_nomorsurat_baru_pengajuan($id_data);
        $update->tanggal = date("Y-m-d");
        $update->id_ttd = $this->getPejabatan(5); //5 => HRD
        $update->update();
        return redirect('hrd/pelatihan/prosespelatihan/'.$id_data)->with('konfirm', 'Update Proses pengajuan pelatihan berhasil.');

    }

    public function update_proses_pelatihan($id_data, $kat)
    {
        $update = PelatihanHeaderModel::find($id_data);
        $update->status_pelatihan = $kat;
        $update->update();
        if($kat==4) {
            return redirect('hrd/pelatihan/prosespelatihan/'.$id_data)->with('konfirm', 'Update Status pelatihan disimpan.');
        } else {
            return redirect('hrd/pelatihan')->with('konfirm', 'Update Status pelatihan disimpan.');
        }
    }
    public function buat_nomorsurat_baru_pengajuan($current_id)
    {
        $thn = date('Y');
        $bln =  hrdfunction::get_bulan_romawi(date('m'));
        $no_urut = 1;
        $ket_surat = "SPP/SSB";
        $nomor_awal = $ket_surat."/".$bln."/".$thn;
        $result = PelatihanHeaderModel::whereNotIn('id', [$current_id])->orderBy('id', 'desc')->first();
        if(empty($result->nomor))
        {
            $nomor_urut = sprintf('%03s', $no_urut);
        } else {
            $nomor_urut_terakhir = substr($result->nomor, 0, 3)+1;
            $nomor_urut = sprintf('%03s', $nomor_urut_terakhir);
        }
        return $nomor_urut."/".$nomor_awal;
    }

    public function buat_nomorsurat_baru()
    {
        $thn = date('Y');
        $bln =  hrdfunction::get_bulan_romawi(date('m'));
        $no_urut = 1;
        $ket_surat = "SPP/SSB";
        $nomor_awal = $ket_surat."/".$bln."/".$thn;
        $result = PelatihanHeaderModel::orderBy('id', 'desc')->first();
        if(empty($result->nomor))
        {
            $nomor_urut = sprintf('%03s', $no_urut);
        } else {
            $nomor_urut_terakhir = substr($result->nomor, 0, 3)+1;
            $nomor_urut = sprintf('%03s', $nomor_urut_terakhir);
        }
        return $nomor_urut."/".$nomor_awal;
    }

    public function update_diklat(Request $request, $id_data)
    {
        $update = PelatihanHeaderModel::find($id_data);
        $update->id_pelatihan = $request->pil_pelatihan;
        $update->id_pelaksana = $request->pil_pelaksana;
        $update->hari_awal = $request->pil_hari_mulai;
        $update->hari_sampai = $request->pil_hari_selesai;
        $update->tanggal_awal = $request->tgl_mulai;
        $update->tanggal_sampai = $request->tgl_akhir;
        $update->pukul_awal = $request->jam_mulai;
        $update->pukul_sampai = $request->jam_selesai;
        $update->tempat_pelaksanaan = $request->inp_tempat;
        $update->id_ttd = $request->pil_pejabat;
        $update->update();
        PelatihanDetailModel::where('id_head', $id_data)->delete();
        foreach($request->pil_peserta as $key => $value)
        {
            PelatihanDetailModel::create([
                'id_head' => $id_data,
                'id_karyawan' => $value
            ]);
        }
        return redirect('hrd/pelatihan/edit_diklat/'.$id_data)->with('konfirm', 'Perubaha Data berhasil disimpan');
    }

    public function delete_spp($id_data)
    {
        $del_d = PelatihanDetailModel::where('id_head', $id_data)->delete();
        if($del_d) {
            $del_h = PelatihanHeaderModel::find($id_data)->delete();
            if($del_h) {
                return redirect('hrd/pelatihan')->with('konfirm', 'Data berhasil dihapus');
            }
        } else {
            return redirect('hrd/pelatihan')->with('konfirm', 'Data gagal dihapus');
        }
    }

    public function print_spp($id_data)
    {
        $data['print_h'] = PelatihanHeaderModel::find($id_data);
        $data['print_d'] = PelatihanDetailModel::where('id_head', $id_data)->with('get_karyawan')->get();
        $data['kop_surat'] = hrdfunction::get_kop_surat();
        $pdf = PDF::loadview('HRD.diklat.print_spp', $data)->setPaper('A4', 'potrait');
        return $pdf->stream();
    }

    //Pengajuan
    public function pengajuan()
    {
        $data = [
            'pelatihan_internal' => PelatihanHeaderModel::where('kategori', 'Internal')
                        ->whereNull('status_pelatihan')
                        ->whereYear('tanggal_awal', date("Y"))->get(),
            'pelatihan_eksternal' => PelatihanHeaderModel::where('kategori', 'Eksternal')
                        ->whereNull('status_pelatihan')
                        ->whereYear('tanggal_awal', date("Y"))
                        ->where(function($query) {
                            $query->whereNull('departemen_by')
                            ->orWhere('departemen_by', auth()->user()->karyawan->id_departemen);
                        })->get()
        ];
        return view('HRD.diklat.pengajuan.index', $data);
    }
    public function form_pengajuan()
    {
        return view('HRD.diklat.pengajuan.add');
    }
    public function addPengajuanInternal($id)
    {
        $id_peserta = array();
        $arr = PelatihanDetailModel::where('id_head', $id)->get();
        foreach ($arr as $arr_) {
            $id_peserta[] = $arr_['id_karyawan'];
        }
        $data = [
            'dt_h' => PelatihanHeaderModel::find($id),
        ];
        return view('HRD.diklat.pengajuan.add_internal', $data);
    }

    public function addPengajuanEksternal()
    {
        return view('HRD.diklat.pengajuan.add_eksternal');
    }

    public function getFormAddPeserta($id)
    {
        $id_peserta = array();
        $arr = PelatihanDetailModel::where('id_head', $id)->get();
        foreach ($arr as $arr_) {
            $id_peserta[] = $arr_['id_karyawan'];
        }
        $data = [
            'peserta' => PelatihanDetailModel::where('id_head', $id)->get(),
            'all_karyawan' => KaryawanModel::where('id_departemen', auth()->user()->karyawan->id_departemen)
                        ->whereIn('id_status_karyawan', [1, 2, 3])
                        ->whereNotIn('id', $id_peserta)->get(),
            'dept_user' => auth()->user()->karyawan->id_departemen
        ];
        return view('HRD.diklat.pengajuan.add_peserta', $data);
    }
    public function getRiwayatPelatihan($id)
    {
        $res['history'] = PelatihanHeaderModel::select(
            'hrd_pelatihan_h.tanggal_awal',
            'hrd_pelatihan_h.tanggal_sampai',
            'hrd_pelatihan_h.kategori',
            'hrd_pelatihan_h.nama_pelatihan',
            'hrd_pelatihan_h.nama_vendor',
            'hrd_pelatihan_h.kompetensi',
            'mst_hrd_pelatihan.nama_pelatihan as nama_pelatihan_internal',
            'mst_hrd_pelaksana_diklat.nama_lembaga'
            )
                        ->leftJoin('hrd_pelatihan_d', 'hrd_pelatihan_d.id_head', '=', 'hrd_pelatihan_h.id')
                        ->leftJoin('mst_hrd_pelatihan', 'hrd_pelatihan_h.id_pelatihan', '=', 'mst_hrd_pelatihan.id')
                        ->leftJoin('mst_hrd_pelaksana_diklat', 'hrd_pelatihan_h.id_pelaksana', '=', 'mst_hrd_pelaksana_diklat.id')
                        ->where('hrd_pelatihan_d.id_karyawan', $id)
                        ->where('hrd_pelatihan_h.status_pengajuan', 2)
                        ->get();
        return view('HRD.diklat.pengajuan.list_riwayat', $res);
    }

    public function simpanPengajuanEksternal(Request $request)
    {
        $arrTanggal = explode(" - ", $request->inpTglPelaksanaan);
        $arrTgl_1 = explode("/", $arrTanggal[0]);
        $arrTgl_2 = explode("/", $arrTanggal[1]);
        $tgl_awal = $arrTgl_1[2]."-".$arrTgl_1[1]."-".$arrTgl_1[0];
        $tgl_akhir = $arrTgl_2[2]."-".$arrTgl_2[1]."-".$arrTgl_2[0];
        PelatihanHeaderModel::create([
            'kategori' => "Eksternal",
            'nama_pelatihan' => $request->inpNamaPelatihan,
            'nama_vendor' => $request->inpNamaVendor,
            'kontak_vendor' => $request->inpKontakVendor,
            'tempat_pelaksanaan' => $request->inpTempat,
            'tanggal_awal' => $tgl_awal,
            'tanggal_sampai' => $tgl_akhir,
            'durasi' => $request->inpDurasi,
            'kompetensi' => $request->inpKompetensi,
            'investasi_per_orang' => str_replace(",","", $request->inpBiaya),
            'diajukan_by' => auth()->user()->karyawan->id,
            'departemen_by' => auth()->user()->karyawan->id_departemen
        ]);
        return redirect('hrd/pelatihan/pengajuan')->with('konfirm', 'Data berhasil disimpan');
    }

    public function delete_pengajuan($id_data)
    {
        $count = PelatihanDetailModel::where('id_head', $id_data)->get()->count();
        if($count==0) {
            $del_h = PelatihanHeaderModel::find($id_data)->delete();
            if($del_h) {
                return redirect('hrd/pelatihan/pengajuan')->with('konfirm', 'Data berhasil dihapus');
            }
        } else {
            $del_d = PelatihanDetailModel::where('id_head', $id_data)->delete();
            if($del_d) {
                $del_h = PelatihanHeaderModel::find($id_data)->delete();
                if($del_h) {
                    return redirect('hrd/pelatihan/pengajuan')->with('konfirm', 'Data berhasil dihapus');
                }
            } else {
                return redirect('hrd/pelatihan/pengajuan')->with('konfirm', 'Data gagal dihapus');
            }
        }

    }

    //list laporan kegiatan
    public function list_laporan_pasca_pelatihan()
    {
        // $data = [
        //     'list_pelatihan' => PelatihanHeaderModel::where('hrd_pelatihan_d.pasca', 1)->get()
        // ];
        $data['list_laporan'] = PelatihanHeaderModel::select('hrd_pelatihan_h.*', 'hrd_pelatihan_d.pasca', 'hrd_pelatihan_d.id_karyawan', 'hrd_karyawan.nm_lengkap', 'hrd_pelatihan_d.updated_at')
            ->leftJoin('hrd_pelatihan_d', function($join) {
                $join->on('hrd_pelatihan_d.id_head', '=', 'hrd_pelatihan_h.id');
            })
            ->leftjoin('hrd_karyawan', 'hrd_pelatihan_d.id_karyawan', '=', 'hrd_karyawan.id')
            ->whereYear('hrd_pelatihan_h.tanggal_awal', date("Y"))
            ->where('hrd_pelatihan_d.pasca', 1)->get();


        return view('HRD.diklat.pasca.list_data', $data);
    }

    public function getDetailPelatihan($id)
    {
        $data['dt_h'] = PelatihanHeaderModel::with('get_peserta')->find($id);
        $data['dt_d'] = PelatihanDetailModel::with(['get_karyawan'])->where('id_head', $id)->get();
        return view('HRD.diklat.pasca.detail', $data);
    }

    public function detail_pasca_pelatihan($id)
    {
        $data['dt_d'] = PelatihanDetailModel::find($id);
        return view('HRD.diklat.pasca.detail_pasca', $data);
    }


    // public function store_pengajuan(Request $request)
    // {
    //     $lastID = PelatihanHeaderModel::create([
    //         'nomor' => '-',
    //         'tanggal' => date("Y-m-d"),
    //         'id_pelatihan' => $request->pil_pelatihan,
    //         'id_pelaksana' => $request->pil_pelaksana,
    //         'hari_awal' => "-",
    //         'hari_sampai' => "-",
    //         'tanggal_awal' => $request->tgl_mulai,
    //         'tanggal_sampai' => $request->tgl_akhir,
    //         'pukul_awal' => $request->jam_mulai,
    //         'pukul_sampai' => $request->jam_selesai,
    //         'tempat_pelaksanaan' => $request->inp_tempat,
    //         'alasan_pengajuan' => $request->inp_alasan,
    //         'status_pelatihan' => 1, //pengajuan
    //         'diajukan_by' => auth()->user()->id,
    //         'departemen_by' => auth()->user()->karyawan->id_departemen,
    //         'total_investasi' => str_replace(",","", $request->inp_total_investasi)
    //     ])->id;
    //     if($lastID)
    //     {
    //         foreach(array($request) as $key => $value)
    //         {
    //             for($i=0; $i < count($request->pil_peserta); $i++)
	// 		    {
    //                 PelatihanDetailModel::create([
    //                     'id_head' => $lastID,
    //                     'id_karyawan' => $value['pil_peserta'][$i],
    //                     'biaya_investasi' => str_replace(",","", $value['inp_biaya'][$i])
    //                 ]);
    //             }
    //         }
    //     }
    //     // dd(array($request));
    //     return redirect('hrd/pelatihan/listpengajuan')->with('konfirm', 'Pengajuan berhasil disimpan');
    // }

    // public function edit_pengajuan($id_data)
    // {
    //     $data['dt_h'] = PelatihanHeaderModel::find($id_data);
    //     $data['dt_d'] = PelatihanDetailModel::where('id_head', $id_data)->get();
    //     $data['all_pelaksana'] = PelaksanaDiklatModel::all();
    //     $data['all_pelatihan'] = MasterPelatihanModel::all();
    //     $data['list_hari'] = Hrdhelper::get_list_hari();
    //     $data['all_karyawan'] = KaryawanModel::whereIn('id_status_karyawan', [1, 2, 3])->get();
    //     return view('HRD.diklat.pengajuan.edit', $data);
    // }

    public function update_pengajuan(Request $request, $id_data)
    {
        $arrTanggal = explode(" - ", $request->inpTglPelaksanaan);
        $arrTgl_1 = explode("/", $arrTanggal[0]);
        $arrTgl_2 = explode("/", $arrTanggal[1]);
        $tgl_awal = $arrTgl_1[2]."-".$arrTgl_1[1]."-".$arrTgl_1[0];
        $tgl_akhir = $arrTgl_2[2]."-".$arrTgl_2[1]."-".$arrTgl_2[0];

        $update = PelatihanHeaderModel::find($id_data);
        $update->tanggal_awal = $tgl_awal;
        $update->tanggal_sampai = $tgl_akhir;
        $update->durasi = $request->inpDurasi;
        $update->kompetensi = $request->inpKompetensi;
        $update->tempat_pelaksanaan = $request->inp_tempat;
        $update->investasi_per_orang = str_replace(",","", $request->inpBiaya);
        $update->update();
        return redirect('hrd/pelatihan/')->with('konfirm', 'Perubaha Data Pengajuan berhasil disimpan');
    }


    // public function detail_pengajuan($id_data)
    // {
    //     $data['dt_h'] = PelatihanHeaderModel::find($id_data);
    //     $data['dt_d'] = PelatihanDetailModel::where('id_head', $id_data)->get();
    //     $data['all_pelaksana'] = PelaksanaDiklatModel::all();
    //     $data['all_pelatihan'] = MasterPelatihanModel::all();
    //     $data['list_hari'] = Hrdhelper::get_list_hari();
    //     $data['all_karyawan'] = KaryawanModel::whereIn('id_status_karyawan', [1, 2, 3])->get();
    //     return view('HRD.diklat.pengajuan.detail', $data);
    // }

    //persetujuan
    public function list_pengajuan_persetujuan()
    {
        $arr_appr_setup = SetupPersetujuanModel::find(6); //pengaturan persetujuan pengajuan pelatihan
        $lvl_appr_user = KaryawanModel::find(auth()->user()->karyawan->id); //cek level jabatan user
        $all_pengajuan = PelatihanHeaderModel::where('status_pelatihan', 1)->with('get_nama_pelatihan', 'get_pelaksana', 'get_detail', 'get_departemen')->get();

        return view('HRD.diklat.persetujuan.index', compact(['arr_appr_setup', 'lvl_appr_user', 'all_pengajuan']));
    }

    public function form_pengajuan_persetujuan($id_data)
    {
        $data['dt_h'] = PelatihanHeaderModel::find($id_data);
        $data['dt_d'] = PelatihanDetailModel::where('id_head', $id_data)->get();
        $data['all_pelaksana'] = PelaksanaDiklatModel::all();
        $data['all_pelatihan'] = MasterPelatihanModel::all();
        $data['list_hari'] = Hrdhelper::get_list_hari();
        $data['all_karyawan'] = KaryawanModel::whereIn('id_status_karyawan', [1, 2, 3])->get();
        return view('HRD.diklat.persetujuan.formpersetujuan', $data);
    }

    public function store_pengajuan_persetujuan(Request $request, $id_data)
    {
        $update = PelatihanHeaderModel::find($id_data);
        $update->status_pelatihan = $request->check_status_appr;
        $update->id_approval = auth()->user()->karyawan->id;
        $update->tgl_approval = date('Y-m-d');
        $update->catatam_approval = $request->req_catatan_appr;
        $update->id_ttd = auth()->user()->karyawan->id;
        $update->update();
        return redirect('hrd/pelatihan/persetujuan/listpengajuan')->with('konfirm', 'Data Persetujuan berhasil dihapus');
    }

    function getPejabatan($departemen)
    {
        $id_pejabat = "";
        $query_jabatan = JabatanModel::where('id_dept', $departemen)->where('id_level', 4)->where('status', 1)->first();
        if($query_jabatan)
        {
            $query_pejabat = KaryawanModel::where('id_jabatan', $query_jabatan->id)->first();
            if($query_pejabat)
            {
                $id_pejabat = $query_pejabat->id;
            }
        }
        return $id_pejabat;
    }

}
