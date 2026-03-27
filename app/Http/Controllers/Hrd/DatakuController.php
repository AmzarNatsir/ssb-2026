<?php

namespace App\Http\Controllers\HRD;

use App\Helpers\Hrdhelper;
use App\Http\Controllers\Controller;
use App\Models\HRD\AbsensiModel;
use App\Models\HRD\CutiModel;
use App\Models\HRD\IzinModel;
use App\Models\HRD\JenisCutiIzinModel;
use App\Models\HRD\KaryawanModel;
use App\Models\HRD\PerdisFasilitasModel;
use App\Models\HRD\PerdisModel;
use App\Models\HRD\SetupHariLiburModel;
use Illuminate\Http\Request;
use App\Helpers\Hrdhelper as hrdfunction;
use App\Models\HRD\ApprovalModel;
use App\Models\HRD\ExitInterviewsModel;
use App\Models\HRD\JabatanModel;
use App\Models\HRD\LemburModel;
use App\Models\HRD\PayrollModel;
use App\Models\HRD\PelatihanDetailModel;
use App\Models\HRD\PelatihanHeaderModel;
use App\Models\HRD\PinjamanKaryawanDokumenModel;
use App\Models\HRD\PinjamanKaryawanModel;
use App\Models\HRD\PinjamanKaryawanMutasiModel;
use App\Models\HRD\ResignModel;
use App\Models\HRD\SuratPeringatanModel;
use App\Models\HRD\SuratTeguranModel;
use Exception;
use Hamcrest\Arrays\IsArray;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use PDF;
use Svg\Tag\Rect;

class DatakuController extends Controller
{
    public function absensi()
    {
        $data['list_bulan'] = Config::get("constants.bulan");
        return view("HRD.profile_user.absensi.index", $data);
    }

    public function get_absensi(Request $request)
    {
        $thn = $request->pil_tahun;
        $bln = $request->pil_bulan;
        $id_karyawan = auth()->user()->karyawan->id;
        $id_finger = KaryawanModel::find($id_karyawan)->id_finger;
        $tgl_libur = array();
        $result_hari_libur = SetupHariLiburModel::whereMonth('tanggal', $bln)->whereYear('tanggal', $thn)->orderBy('tanggal')->get();
        foreach($result_hari_libur as $lbr) {
            $tgl_libur[] = $lbr->tanggal;
        }
        $ket_periode = \App\Helpers\Hrdhelper::get_nama_bulan($bln)." ".$thn;
        $jml_hari = Hrdhelper::tglAkhirBulan($thn, $bln);
        $jml_cols = $jml_hari + 5;
        $html = "";
        $html .= "<table class='table-hover table-bordered dataTable dataTable-scroll-x tbl_asbensi' style='font-size: small;'><thead><tr>
        <th colspan=".$jml_hari." style='text-align:center'>Periode ".$ket_periode."</th>
        <th rowspan='2' style='text-align:center'>Total Hadir</th>
        <th rowspan='2' style='text-align:center'>Total Cuti</th>
        <th rowspan='2' style='text-align:center'>Total Izin</th>
        <th rowspan='2' style='text-align:center'>Total Perdis</th>
        <th rowspan='2' style='text-align:center'>Total Training</th>
        </tr>
        <tr>";
        $tot_hadir=0;
        $tot_cuti=0;
        $tot_izin=0;
        $tot_perdis=0;
        $tot_pelatihan=0;
        for($col=1; $col<=$jml_hari; $col++)
        {
            $html .= "<th style='text-align:center'>$col</th>";
        }
        $html .= "</tr>";
        for($i=1; $i<=$jml_hari; $i++)
        {
            $libur = 'n';
            $jml_hadir=0;
            $jml_cuti=0;
            $jml_izin=0;
            $jml_perdis=0;
            $jml_pelatihan=0;
            $day=sprintf("%02s", $i);
            $filter_tanggal = $thn."-".$bln."-".$day;
            $val_libur = Hrdhelper::isWeekend($filter_tanggal);
            if($val_libur=='sunday') //$val_libur=='saturday' sabtu
            {
                $blok_wrn = "background-color: #c44a12";
                $libur = 'y';
                // $blok_wrn = "bgcolor='red'";
            }
            else
            {
                if (in_array($filter_tanggal, $tgl_libur))
                {
                    $blok_wrn = "background-color: #1764bd"; // "btn-primary";
                    // $blok_wrn = "bgcolor='blue'";
                    $libur = 'y';
                }
                else
                {
                    $blok_wrn = "";
                    //$tampil = "Tanpa Ket.";
                }
            }
            //cek kehadiran
            $res_check_in = AbsensiModel::selectRaw('id_finger, MIN(TIME(tanggal)) as tgl_checkin, MAX(TIME(hrd_absensi.tanggal)) AS tgl_checkout')
                ->whereDate('tanggal', $filter_tanggal)
                // ->where('status', 'C/Masuk')
                ->where('id_finger', $id_finger)
                // ->groupBy('status')
                ->groupBy('id_finger')
                ->first();
            // dd($res_check_in);
            if(empty($res_check_in['tgl_checkin'])) {
                $ket_hadir_in = "";
            } else {
                $ket_hadir_in = "<i class='ri-check-line bg-primary'></i>&nbsp;".date_format(date_create($res_check_in['tgl_checkin']), 'H:s')."&nbsp;IN";
                $jml_hadir=1;
            }
            if(empty($res_check_in['tgl_checkout'])) {
                $ket_hadir_out = "";
            } else {
                $ket_hadir_out = " <i class='ri-check-line bg-success'></i>&nbsp;".date_format(date_create($res_check_in['tgl_checkout']), 'H:s')."&nbsp;OUT";
                $jml_hadir=1;
            }
            //Cek Cuti Karyawan
            $result_cuti = CutiModel::where('id_karyawan', $id_karyawan)
                        ->where('tgl_awal', '<=', $filter_tanggal)
                        ->where('tgl_akhir', '>=', $filter_tanggal)
                        ->where('sts_pengajuan', 2)->get()->count();
            //Cek Izin Karyawan
            $result_izin = IzinModel::where('id_karyawan', $id_karyawan)
                        ->where('tgl_awal', '<=', $filter_tanggal)
                        ->where('tgl_akhir', '>=', $filter_tanggal)
                        ->where('sts_pengajuan', 2)->get()->count();
            //Cek Perdis
            $result_perdis = PerdisModel::where('id_karyawan', $id_karyawan)
                        ->where('tgl_berangkat', '<=', $filter_tanggal)
                        ->where('tgl_kembali', '>=', $filter_tanggal)
                        ->where('sts_persetujuan', 1)->get()->count();
            //Cek Pelatihan
            $result_pelatihan = \DB::table('hrd_pelatihan_h')
                        ->join('hrd_pelatihan_d', 'hrd_pelatihan_h.id', '=', 'hrd_pelatihan_d.id_head')
                        ->where('hrd_pelatihan_h.tanggal_awal', '<=', $filter_tanggal)
                        ->where('hrd_pelatihan_h.tanggal_sampai', '>=', $filter_tanggal)
                        ->where('hrd_pelatihan_d.id_karyawan', $id_karyawan)
                        ->where('hrd_pelatihan_h.status_pelatihan', 1)->get()->count();
            if($result_cuti >= 1) {
                if($libur=='n')
                {
                    $jml_cuti=1;
                    $html .= "<td style='background-color: #bd9f17; color: white; text-align: center'>C</td>";
                } else {
                    $html .= "<td style='".$blok_wrn."'></td>";
                }

            } else if ($result_izin >= 1) {
                if($libur=='n')
                {
                    $jml_izin=1;
                    $html .= "<td style='background-color: #bd9f17; color: white; text-align: center'>I</td>";
                } else {
                    $html .= "<td style='".$blok_wrn."'></td>";
                }
            } else if ($result_perdis >= 1) {
                if($libur=='n')
                {
                    $jml_perdis=1;
                    $html .= "<td style='background-color: #bd9f17; color: white; text-align: center'>P</td>";
                } else {
                    $html .= "<td style='".$blok_wrn."'></td>";
                }
            } else if ($result_pelatihan >= 1) {
                if($libur=='n')
                {
                    $jml_pelatihan=1;
                    $html .= "<td style='background-color: #bd9f17; color: white; text-align: center'>T</td>";
                } else {
                    $html .= "<td style='".$blok_wrn."'></td>";
                }

            } else {
                $html .= "<td style='".$blok_wrn."'>".$ket_hadir_in.$ket_hadir_out."</td>";
            }

            // $html .= "<td style='".$blok_wrn."'>".$ket_hadir_in.$ket_hadir_out."</td>";

            $tot_hadir+=$jml_hadir;
            $tot_cuti+=$jml_cuti;
            $tot_izin+=$jml_izin;
            $tot_perdis+=$jml_perdis;
            $tot_pelatihan+=$jml_pelatihan;
        }
        $html .= "<td style='text-align:center'><b>".$tot_hadir."</b></td>";
        $html .= "<td style='text-align:center'><b>".$tot_cuti."</b></td>";
        $html .= "<td style='text-align:center'><b>".$tot_izin."</b></td>";
        $html .= "<td style='text-align:center'><b>".$tot_perdis."</b></td>";
        $html .= "<td style='text-align:center'><b>".$tot_pelatihan."</b></td>";

        $html .= "</tr>";

        $html .="<tr><td colspan='".$jml_cols."' style='height: 30px'></td></tr><tr>
        <td style='background-color: #1764bd'></td>
        <td colspan='".($jml_cols-1)."'>Hari Libur Bersama</td>
        </tr>
        <tr>
        <td style='background-color:  #c44a12'></td>
        <td colspan='".($jml_cols-1)."'>Hari Minggu/Ahad</td>
        </tr>
        <tr>
        <td style='background-color:  #bd9f17'></td>
        <td colspan='".($jml_cols-1)."'>C = Cuti; I = Izin; P = Perjalanan Dinas; T = Training</td>
        </tr>

        </tbody>
        </table>";
        echo $html;

    }

    public function loadAbsensi(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        $jam_ishoma_start = "11:00";
        $jam_ishoma_end = "14:00";
        $start = $request->input('start'); // format: YYYY-MM-DD
        $end = $request->input('end');
        $query = AbsensiModel::from('hrd_absensi as a')
                ->select([
                    'a.tanggal',
                    DB::raw("MIN(CASE WHEN status = 'C/Masuk' THEN jam END) as check_in"),
                    DB::raw("MIN(CASE WHEN status = 'C/Keluar' AND jam BETWEEN '$jam_ishoma_start' AND '$jam_ishoma_end' THEN jam END) as ishoma_keluar"),
                    DB::raw("MAX(CASE WHEN status = 'C/Masuk' AND jam BETWEEN '$jam_ishoma_start' AND '$jam_ishoma_end' THEN jam END) as ishoma_masuk"),
                    DB::raw("MAX(CASE WHEN status = 'C/Keluar' THEN jam END) as pulang"),
                ])
            ->where('a.nik_lama', auth()->user()->karyawan->nik_lama)->groupBy(['a.tanggal']);

        if ($bulan && $tahun) {
            $query->whereMonth('a.tanggal', $bulan)
                ->whereYear('a.tanggal', $tahun);
        } else {

            $query->whereBetween('a.tanggal', [$start, $end]);
        }

        $absensi = $query->get();
        // dd($absensi);
        $events = [];
        foreach($absensi as $list)
        {
            $in         = $list->check_in ? date('H:i', strtotime($list->check_in)) : "";
            $ishoma_out = $list->ishoma_keluar ? date('H:i', strtotime($list->ishoma_keluar)) : "";
            $ishoma_in  = $list->ishoma_masuk ? date('H:i', strtotime($list->ishoma_masuk)) : "";
            $out        = $list->pulang ? date('H:i', strtotime($list->pulang)) : "";

            // ⛔ Abaikan kalau ishoma_masuk ternyata lebih besar dari jam pulang
            if ($ishoma_in && $out && strtotime($ishoma_in) > strtotime($out)) {
                $ishoma_in = "";
            }
            // ⛔ Abaikan kalau hanya salah satu (keluar tanpa masuk, atau masuk tanpa keluar)
            if ($ishoma_out && !$ishoma_in) {
                $ishoma_out = "";
            }
            if ($ishoma_in && !$ishoma_out) {
                $ishoma_in = "";
            }

            $titleParts = [];
            if ($in) $titleParts[] = $in." -";
            if ($ishoma_out && $ishoma_in) {
                $titleParts[] = $ishoma_out." | ".$ishoma_in;
            } elseif ($ishoma_out) {
                $titleParts[] = $ishoma_out."-";
            } elseif ($ishoma_in) {
                $titleParts[] = "| ".$ishoma_in;
            }
            if ($out) $titleParts[] = $out;

            $events[] = [
                'title' => implode(" ", $titleParts),
                'start' => $list->tanggal.'T'.($list->check_in ?? "00:00"),
                'backgroundColor' => '#28a745',
                'borderColor'     => '#28a745',
            ];
        }
        // dd(json_encode($events));
        return response()->json($events);
    }

    //perjalanan dinas
    public function perjalanan_dinas()
    {
        $data['list_bulan'] = Config::get("constants.bulan");
        return view("HRD.profile_user.perdis.index", $data);
    }

    public function get_perjalanan_dinas(Request $request)
    {
        $thn = $request->pil_tahun;
        $bln = $request->pil_bulan;
        $id_karyawan = auth()->user()->karyawan->id;
        if($bln==0)
        {
            $data['list_perdis'] = PerdisModel::where('id_karyawan', $id_karyawan)->whereYear('tgl_berangkat', $thn)->orderby('tgl_perdis', 'desc')->get();
        } else {
            $data['list_perdis'] = PerdisModel::where('id_karyawan', $id_karyawan)->whereMonth('tgl_berangkat', $bln)->whereYear('tgl_berangkat', $thn)->orderby('tgl_perdis', 'desc')->get();
        }

        return view("HRD.profile_user.perdis.list", $data);
    }

    public function get_detail_perjalanan_dinas($id)
    {
        $data['profil'] = PerdisModel::find($id);
        if(empty($data['profil']->id))
        {
            return redirect('hrd/dataku/perjalananDinas');
        }
        $data['fasilitas'] = PerdisFasilitasModel::where('id_perdis', $id)->get();
        return view('HRD.profile_user.perdis.detail', $data);
    }

    public function upload_dokumen_perdis($id)
    {
        // $data['id_fasilitas_perdis'] = $id;
        $data['detail'] = PerdisFasilitasModel::find($id);
        return view('HRD.profile_user.perdis.upload_dokumen', $data);
    }

    public function upload_dokumen_perdis_store(Request $request)
    {
        $allowedfileExtension=['jpg','png','jpeg'];
        Image::configure(array('driver' => 'gd'));
        $path_file = "public/hrd/dataku/perdis/".$request->id_perdis."/";
        $path = storage_path("app/public/hrd/dataku/perdis/".$request->id_perdis);
        if(!File::isDirectory($path)) {
            $path = Storage::disk('public')->makeDirectory("hrd/dataku/perdis/".$request->id_perdis);
        }
        $detail = PerdisFasilitasModel::find($request->id_detail_perdis);
        $file_1= (empty($detail->file_1)) ? NULL : $detail->file_1;
        $file_2= (empty($detail->file_2)) ? NULL : $detail->file_2;
        if($request->hasFile('inp_file_1'))
        {
            $image = $request->file('inp_file_1');
            $extension = $image->getClientOriginalExtension();
            $check=in_array($extension,$allowedfileExtension);
            if($check)
            {
                $filename = "1-".$request->id_detail_perdis.time().date('dmY').".".$extension;
                $image_resize = Image::make($image->getRealPath());
                $image_resize->save(storage_path("app/public/hrd/dataku/perdis/".$request->id_perdis."/".$filename));
                $file_1 = $filename;
            }

        }
        if($request->hasFile('inp_file_2'))
        {
            $image = $request->file('inp_file_2');
            $extension = $image->getClientOriginalExtension();
            $check=in_array($extension,$allowedfileExtension);
            if($check)
            {
                $filename = "2-".$request->id_detail_perdis.time().date('dmY').".".$extension;
                $image_resize = Image::make($image->getRealPath());
                $image_resize->save(storage_path("app/public/hrd/dataku/perdis/".$request->id_perdis."/".$filename));
                $file_2 = $filename;
            }

        }

        $update = PerdisFasilitasModel::find($request->id_detail_perdis);
        $update->file_1 = $file_1;
        $update->file_2 = $file_2;
        $update->save();
        return redirect('hrd/dataku/detailPerdis/'.$request->id_perdis)->with('konfirm', 'Dokumen Perjalanan Dinas berhasil disimpan.');
    }

    public function update_realisasi_biaya_perdis(Request $request)
    {
        $id_perdis = $request->id_perdis;
        foreach(array($request) as $key => $value)
        {
            for($i=0; $i < count($request->id_rincian); $i++)
            {
                $update = PerdisFasilitasModel::find($value['id_rincian'][$i]);
                $update->realisasi = str_replace(",","", $value['inp_realisasi'][$i]);
                $update->save();
            }
        }
        return redirect('hrd/dataku/detailPerdis/'.$request->id_perdis)->with('konfirm', 'Realisasi penggunaan biaya perjalanan dinas berhasil disimpan.');
    }

    //cuti -izin
    public function cuti_izin()
    {
        $data['all_cuti'] = CutiModel::where('id_karyawan', auth()->user()->karyawan->id)->get();
        $data['all_izin'] = IzinModel::where('id_karyawan', auth()->user()->karyawan->id)->get();
        $data['count_aktif_cuti'] = CutiModel::where('sts_pengajuan', 1)
                                ->where('id_karyawan', auth()->user()->karyawan->id)
                                ->where('tgl_akhir', '>', date("Y-m-d"))
                                ->get();
        $data['count_aktif_izin'] = CutiModel::whereNull('sts_pengajuan')
            ->where('id_karyawan', auth()->user()->karyawan->id)
            ->where('tgl_akhir', '>', date("Y-m-d"))
            ->get();
        $data['list_bulan'] = Config::get("constants.bulan");

        return view('HRD.profile_user.cuti_izin.index', $data);
    }

    public function get_cuti_izin($pil_bulan, $pil_tahun)
    {
        $thn = $pil_tahun;
        $bln = $pil_bulan;

        if($bln==0)
        {
            $data['list_cuti'] = CutiModel::with('get_jenis_cuti')->whereIn('sts_pengajuan', [1, 2, 3])->where('id_karyawan', auth()->user()->karyawan->id)->whereYear('tgl_awal', $thn)->orderBy('tgl_awal', 'desc')->get();
            $data['list_izin'] = IzinModel::with('get_jenis_izin')->whereIn('sts_pengajuan', [1, 2, 3])->where('id_karyawan', auth()->user()->karyawan->id)->whereYear('tgl_awal', $thn)->orderBy('tgl_awal', 'desc')->get();
        } else {
            $data['list_cuti'] = CutiModel::with(['get_jenis_cuti'])->whereIn('sts_pengajuan', [1, 2, 3])->whereMonth('tgl_awal', $bln)->whereYear('tgl_awal',$thn)->where('id_karyawan', auth()->user()->karyawan->id)->orderBy('tgl_awal', 'desc')->get();
            $data['list_izin'] = IzinModel::with(['get_jenis_izin'])->whereIn('sts_pengajuan', [1, 2, 3])->whereMonth('tgl_awal', $bln)->whereYear('tgl_awal',$thn)->where('id_karyawan', auth()->user()->karyawan->id)->orderBy('tgl_awal', 'desc')->get();
        }
        return view('HRD.profile_user.cuti_izin.list', $data);
    }

    public function form_cuti()
    {
        $id_karyawan = auth()->user()->karyawan->id;
        $res_riwayat_cuti = CutiModel::orderby('id', 'desc')->where('id_karyawan', $id_karyawan)->get();
        $res_jenis_cuti = JenisCutiIzinModel::where('jenis_ci', 1)->where('status', 1)->get();
        return view('HRD.profile_user.cuti_izin.add_cuti', ['list_jenis_cuti'=>$res_jenis_cuti, 'list_riwayat_cuti'=>$res_riwayat_cuti]);
    }

    public function store_pengajuan_cuti(Request $request)
    {
        // $id_gakom = JabatanModel::find(auth()->user()->karyawan->id_jabatan)->id_gakom;
        // $get_approval_first = KaryawanModel::where('id_jabatan', $id_gakom)->first();
        $id_depat_karyawan = KaryawanModel::find(auth()->user()->karyawan->id)->id_departemen;
        $_uuid = Str::uuid();
        $group = 3;
        $ifSet = hrdfunction::set_approval_cek($group, $id_depat_karyawan);
        if($ifSet > 0)
        {
            CutiModel::create([
                'id_karyawan' => auth()->user()->karyawan->id,
                'id_jenis_cuti' => $request->pil_jenis_cuti,
                'tgl_pengajuan' => date("Y-m-d"),
                'tgl_awal' => $request->tgl_mulai,
                'tgl_akhir' => $request->tgl_akhir,
                'tgl_masuk' => $request->tgl_masuk,
                'jumlah_hari' => $request->inp_jumlah_hari,
                'ket_cuti' => $request->keterangan,
                'id_user' => auth()->user()->id,
                'id_departemen' => $id_depat_karyawan,
                'sts_pengajuan' => 1,
                'approval_key' => $_uuid,
                'current_approval_id' => hrdfunction::set_approval_get_first($group, $id_depat_karyawan),
                'is_draft' => 1 //pengajuan masih bisa diedit
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
            return redirect('hrd/dataku/cuti_izin')->with('konfirm', 'Pengajuan cuti anda berhasil disimpan');
        } else {
            return redirect('rd/dataku/cuti_izin')->with('konfirm', 'Matriks persetujuan belum diatur');
        }
    }

    public function form_cuti_edit($id)
    {
        $data = CutiModel::find($id);
        $res_jenis_cuti = JenisCutiIzinModel::where('jenis_ci', 1)->where('status', 1)->get();
        $sisa_quota = $this->ambil_sisa_quota_cuti(auth()->user()->karyawan->id, $data->id_jenis_cuti);
        return view('HRD.profile_user.cuti_izin.edit_cuti', [
            'list_jenis_cuti'=>$res_jenis_cuti,
            'res' => $data,
            'sisa_quota' => $sisa_quota
            ]
        );
    }
    public function ambil_sisa_quota_cuti($id_karyawan, $id_jenis_cuti)
    {
        $thn = date("Y");
        $jumlah_quota = JenisCutiIzinModel::find($id_jenis_cuti)->lama_cuti;
        //dd($id_karyawan);
        $quota_terpakai = CutiModel::where('id_karyawan', $id_karyawan)->where('id_jenis_cuti', $id_jenis_cuti)->whereYear('tgl_awal', $thn)->where('sts_persetujuan', 2)->sum('jumlah_hari');

        $sisa_quota = $jumlah_quota - $quota_terpakai;
        //dd($sisa_quota);
        return $sisa_quota;
    }

    public function update_pengajuan_cuti(Request $request, $id)
    {
        $update = CutiModel::find($id);
        $update->id_jenis_cuti = $request->pil_jenis_cuti;
        $update->tgl_awal = $request->tgl_mulai;
        $update->tgl_akhir = $request->tgl_akhir;
        $update->jumlah_hari = $request->inp_jumlah_hari;
        $update->ket_cuti = $request->keterangan;
        $update->save();
        return redirect('hrd/dataku/cuti_izin')->with('konfirm', 'Perubahan data pengajuan berhasil disimpan');
    }

    public function detail_pengajuan_cuti($id)
    {
        $data = CutiModel::find($id);
        $res_jenis_cuti = JenisCutiIzinModel::where('jenis_ci', 1)->where('status', 1)->get();
        $sisa_quota = $this->ambil_sisa_quota_cuti(auth()->user()->karyawan->id, $data->id_jenis_cuti);
        $hirarki_persetujuan = ApprovalModel::where('approval_key', $data->approval_key)->orderBy('approval_level')->get();
        return view('HRD.profile_user.cuti_izin.detail_cuti', [
            'list_jenis_cuti'=>$res_jenis_cuti,
            'res' => $data,
            'sisa_quota' => $sisa_quota,
            'hirarki_persetujuan' => $hirarki_persetujuan
            ]
        );
    }

    public function form_cuti_cancel(Request $request, $id)
    {
        $update = CutiModel::find($id);
        $update->sts_pengajuan = 4; //pengajuan batal
        $update->is_draft = 2;
        $update->save();
        //hapus hirarki persetujuan
        $check_data = ApprovalModel::where('approval_key', $update->approval_key)->get()->count();
        if($check_data > 0) {
            ApprovalModel::where('approval_key', $update->approval_key)->delete();
        }
        return redirect('hrd/dataku/cuti_izin')->with('konfirm', 'Pengajuan anda berhasil dibatalkan');
    }

    //izin
    public function form_izin()
    {
        $id_karyawan = auth()->user()->karyawan->id;
        $data['list_jenis_izin'] = JenisCutiIzinModel::where('jenis_ci', 2)->where('status', 1)->get();
        return view('HRD.profile_user.cuti_izin.add_izin', $data);
    }

    public function get_izin($pil_bulan, $pil_tahun)
    {
        $thn = $pil_tahun;
        $bln = $pil_bulan;
        if($bln==0)
        {
            $data['list_izin'] = IzinModel::with('get_jenis_izin')->whereIn('sts_pengajuan', [1, 2, 3])->where('id_karyawan', auth()->user()->karyawan->id)->whereYear('tgl_awal', $thn)->orderBy('tgl_pengajuan', 'desc')->get();
        } else {
            $data['list_izin'] = IzinModel::with(['get_jenis_izin'])->whereIn('sts_pengajuan', [1, 2, 3])->whereMonth('tgl_awal', $bln)->whereYear('tgl_awal',$thn)->where('id_karyawan', auth()->user()->karyawan->id)->orderBy('tgl_pengajuan', 'desc')->get();
        }
        return view('HRD.profile_user.cuti_izin.list_izin', $data);
    }

    public function store_pengajuan_izin(Request $request)
    {
        $id_depat_karyawan = KaryawanModel::find(auth()->user()->karyawan->id)->id_departemen;
        $_uuid = Str::uuid();
        $group = 4;
        $ifSet = hrdfunction::set_approval_cek($group, $id_depat_karyawan);
        if($ifSet > 0)
        {
            IzinModel::create([
                'id_karyawan' => auth()->user()->karyawan->id,
                'id_jenis_izin' => $request->pil_jenis_izin,
                'tgl_pengajuan' => date("Y-m-d"),
                'tgl_awal' => $request->tgl_mulai,
                'tgl_akhir' => $request->tgl_akhir,
                'jumlah_hari' => $request->inp_jumlah_hari,
                'ket_izin' => $request->keterangan,
                'id_user' => auth()->user()->id,
                'id_departemen' => $id_depat_karyawan,
                'sts_pengajuan' => 1,
                'approval_key' => $_uuid,
                'current_approval_id' => hrdfunction::set_approval_get_first($group, $id_depat_karyawan),
                'is_draft' => 1 //pengajuan masih bisa diedit
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
            return redirect('hrd/dataku/cuti_izin')->with('konfirm', 'Pengajuan izin anda berhasil disimpan');
        } else {
            return redirect('hrd/dataku/cuti_izin')->with('konfirm', 'Matriks persetujuan belum diatur');
        }
    }

    public function form_cuti_izin($id)
    {
        $data = IzinModel::find($id);
        $res_jenis_izin = JenisCutiIzinModel::where('jenis_ci', 2)->where('status', 1)->get();
        return view('HRD.profile_user.cuti_izin.edit_izin', [
            'res_jenis_izin'=>$res_jenis_izin,
            'res' => $data,
            ]
        );
    }

    public function update_pengajuan_izin(Request $request, $id)
    {
        $update = IzinModel::find($id);
        $update->id_jenis_izin = $request->pil_jenis_izin;
        $update->tgl_awal = $request->tgl_mulai;
        $update->tgl_akhir = $request->tgl_akhir;
        $update->jumlah_hari = $request->inp_jumlah_hari;
        $update->ket_izin = $request->keterangan;
        $update->save();
        return redirect('hrd/dataku/cuti_izin')->with('konfirm', 'Perubahan data pengajuan berhasil disimpan');
    }

    public function detail_pengajuan_izin($id)
    {
        $data = IzinModel::find($id);
        $res_jenis_izin = JenisCutiIzinModel::where('jenis_ci', 2)->where('status', 1)->get();
        $hirarki_persetujuan = ApprovalModel::where('approval_key', $data->approval_key)->orderBy('approval_level')->get();
        return view('HRD.profile_user.cuti_izin.detail_izin', [
            'res_jenis_izin'=>$res_jenis_izin,
            'res' => $data,
            'hirarki_persetujuan' => $hirarki_persetujuan
            ]
        );
    }
    public function form_izin_cancel(Request $request, $id)
    {
        $update = IzinModel::find($id);
        $update->sts_pengajuan = 4; //pengajuan batal
        $update->is_draft = 2;
        $update->save();
        //hapus hirarki persetujuan
        $check_data = ApprovalModel::where('approval_key', $update->approval_key)->get()->count();
        if($check_data > 0) {
            ApprovalModel::where('approval_key', $update->approval_key)->delete();
        }
        return redirect('hrd/dataku/cuti_izin')->with('konfirm', 'Pengajuan izin anda berhasil dibatalkan');
    }

    //lembur
    public function lembur()
    {
        // $data['all_lembur'] = LemburModel::where('id_karyawan', auth()->user()->karyawan->id)->get();
        $data['list_bulan'] = Config::get("constants.bulan");
        $data['thn_start'] = 2021;
        return view("HRD.profile_user.lembur.index", $data);
    }

    public function get_lembur($pil_bulan, $pil_tahun)
    {
        $thn = $pil_tahun;
        $bln = $pil_bulan;
        if($bln==0)
        {
            $data['list_data'] = LemburModel::where('id_karyawan', auth()->user()->karyawan->id)->whereYear('tgl_pengajuan', $thn)->orderBy('tgl_pengajuan', 'desc')->get();
        } else {
            $data['list_data'] = LemburModel::whereMonth('tgl_pengajuan', $bln)->whereYear('tgl_pengajuan',$thn)->where('id_karyawan', auth()->user()->karyawan->id)->orderBy('tgl_pengajuan', 'desc')->get();
        }
        return view('HRD.profile_user.lembur.list_lembur', $data);
    }

    public function lembur_form()
    {
        return view('HRD.profile_user.lembur.add');
    }

    public function lembur_form_store(Request $request)
    {
        $id_depat_karyawan = KaryawanModel::find(auth()->user()->karyawan->id)->id_departemen;
        $_uuid = Str::uuid();
        $group = 7;
        $ifSet = hrdfunction::set_approval_cek($group, $id_depat_karyawan);
        if($ifSet > 0)
        {
            $path = storage_path("app/public/hrd/lembur");
            if(!File::isDirectory($path)) {
                $path = Storage::disk('public')->makeDirectory('hrd/lembur');
            }
            $file = $request->file('inp_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/hrd/lembur', $filename);

            LemburModel::create([
                'id_karyawan' => auth()->user()->karyawan->id,
                'tgl_pengajuan' => $request->tanggal,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'total_jam' => $request->inp_total,
                'deskripsi_pekerjaan' => $request->keterangan,
                'status_pengajuan' => 1, //Pengajuan
                'approval_key' => $_uuid,
                'current_approval_id' => hrdfunction::set_approval_get_first($group, $id_depat_karyawan),
                'file_surat_perintah_lembur' => $filename
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
            return redirect('hrd/dataku/lembur')->with('konfirm', 'Pengajuan lembur anda berhasil disimpan');
        } else {
            return redirect('hrd/dataku/lembur')->with('konfirm', 'Matriks persetujuan belum diatur');
        }
    }

    //surat peringatan
    public function surat_peringatan()
    {
        $data['list_bulan'] = Config::get("constants.bulan");
        $data['thn_start'] = 2021;
        return view("HRD.profile_user.surat_peringatan.index", $data);
    }
    public function get_surat_peringatan($bulan, $tahun)
    {
        $data['list_sp'] = SuratPeringatanModel::with(['profil_karyawan', 'get_master_jenis_sp_diajukan', 'get_diajukan_oleh'])
                    ->where('id_karyawan', auth()->user()->karyawan->id)
                    ->where('sts_pengajuan', 2)
                    ->whereMonth('tgl_sp', $bulan)
                    ->whereyear('tgl_sp', $tahun)
                    ->orderby('tgl_sp', 'desc')->get();
        $data['list_st'] = SuratTeguranModel::where('id_karyawan', auth()->user()->karyawan->id)
                    ->where('status_pengajuan', 2)
                    ->whereMonth('tanggal_pengajuan', $bulan)
                    ->whereyear('tanggal_pengajuan', $tahun)
                    ->orderBy('tanggal_pengajuan', 'desc')->get();
        return view('HRD.profile_user.surat_peringatan.list_data', $data);
    }

    public function detail_sp($id)
    {
        $profil = SuratPeringatanModel::find($id);
        $hirarki_persetujuan = ApprovalModel::where('approval_key', $profil->approval_key)->orderBy('approval_level')->get();
        return view('HRD.profile_user.surat_peringatan.detail_sp', [
            'profil' => $profil,
            'hirarki_persetujuan' => $hirarki_persetujuan
        ]);
    }

    //pinjaman karyawan
    public function pinjamanKaryawan()
    {
        $data['aktif_tombol_pengajuan'] = PinjamanKaryawanModel::where('id_karyawan', auth()->user()->karyawan->id)->where('aktif', 'y')->get()->count();
        $data['list_bulan'] = Config::get("constants.bulan");
        $data['thn_start'] = 2021;
        return view('HRD.profile_user.pinjaman_karyawan.index', $data);
    }

    public function getListPengajuan()
    {
        $data['list_data'] = PinjamanKaryawanModel::where('id_karyawan', auth()->user()->karyawan->id)->orderBy('tgl_pengajuan', 'desc')->get();
        return view('HRD.profile_user.pinjaman_karyawan.list_data', $data);
    }

    public function pengajuanPinjaman()
    {
        $qKaryawan = KaryawanModel::find(auth()->user()->karyawan->id);
        $data = [
            'profil' =>  $qKaryawan,
            'status_karyawan' => Hrdhelper::get_status_karyawan($qKaryawan->id_status_karyawan)
        ];
        return view('HRD.profile_user.pinjaman_karyawan.add', $data);
    }

    public function pengajuanPinjamanStore(Request $request)
    {
        $id_depat_karyawan = KaryawanModel::find(auth()->user()->karyawan->id)->id_departemen;
        $_uuid = Str::uuid();
        $group = 13;
        $ifSet = hrdfunction::set_approval_cek($group, $id_depat_karyawan);
        if($ifSet > 0)
        {
            $lastID = PinjamanKaryawanModel::create([
                'id_karyawan' => auth()->user()->karyawan->id,
                'tgl_pengajuan' => date('Y-m-d'),
                'kategori' => $request->pil_jenis,
                'alasan_pengajuan' => $request->pil_alasan,
                'nominal_apply' => str_replace(",", "", $request->inpNominal),
                'tenor_apply' => $request->inpTenor,
                'angsuran' => str_replace(",", "", $request->inpAngsuran),
                'status_pengajuan' => 1,
                'approval_key' => $_uuid,
                'current_approval_id' => hrdfunction::set_approval_get_first($group, $id_depat_karyawan),
                'is_draft' => 1, //pengajuan masih bisa diedit,
                'aktif' => 'y'
            ])->id;
            //insert mutasi
            for($i=1; $i <= $request->inpTenor; $i++) {
                $bayar_aktif=0;
                if($i==1) {
                    $bayar_aktif = 1;
                }
                PinjamanKaryawanMutasiModel::create([
                    'id_head' => $lastID,
                    'nominal' => str_replace(",", "", $request->inpAngsuran),
                    'bayar_aktif' => $bayar_aktif
                ]);
            }
            //set tgl jatuh tempo
            Hrdhelper::generate_duedate_pinjaman_karyawan($lastID, date('Y-m-d'));
            // insert dokumen
            if($request->pil_jenis==2)
            {
                $path_file = "app/public/hrd/dataku/dokumen_pinjaman_karyawan/".auth()->user()->karyawan->nik."/";
                $path = storage_path("app/public/hrd/dataku/dokumen_pinjaman_karyawan/".auth()->user()->karyawan->nik);
                if(!File::isDirectory($path)) {
                    $path = Storage::disk('public')->makeDirectory("hrd/dataku/dokumen_pinjaman_karyawan/".auth()->user()->karyawan->nik);
                }
                $jml_row = (is_array(($request->fileDokumen))) ? count($request->fileDokumen) : 0;
                if($jml_row > 0)
                {
                    foreach(array($request) as $key => $value)
                    {
                        for($i=0; $i < $jml_row; $i++)
                        {
                            if($value['fileDokumen'] != "")
                            {
                                $_uuid_img = Str::uuid();
                                $image = $request->file('fileDokumen')[$i];
                                $extension = $image->getClientOriginalExtension();
                                $filename = "img_".$_uuid_img.".".$extension;
                                // $image->save(storage_path($path_file.$filename));
                                $insert = [
                                    'id_head' => $lastID,
                                    'file_dokumen' => $filename,
                                    'keterangan' => $value['inpKeterangan'][$i]

                                ];
                                PinjamanKaryawanDokumenModel::create($insert);
                            }
                        }
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
                    'approval_group' => $group, //Pengajuan Cuti
                    'approval_active' => $approval_active
                ]);
            }
            return redirect('hrd/dataku/pinjamanKaryawan')->with('konfirm', 'Pengajuan Pinjaman anda berhasil disimpan');
        } else {
            return redirect('hrd/dataku/pinjamanKaryawan')->with('konfirm', 'Matriks persetujuan belum diatur');
        }
    }

    public function mutasiPinjamanKaryawan($id)
    {
        $result = PinjamanKaryawanModel::with([
            'getKaryawan',
            'getDokumen',
            'getMutasi'
        ])->find($id);
        $terbayar = PinjamanKaryawanMutasiModel::where('id_head', $id)->where('status', '1')->sum('nominal');
        $oustanding = $result->nominal_apply - $terbayar;
        $data = [
            'data' => $result,
            'status_karyawan' => Hrdhelper::get_status_karyawan($result->getKaryawan->id_status_karyawan),
            'outstanding' => $terbayar
        ];
        return view('HRD.profile_user.pinjaman_karyawan.view_mutasi', $data);
    }

    //payroll
    public function payroll()
    {
        $data['thn_start'] = 2021;
        return view('HRD.profile_user.payroll.index', $data);
    }

    public function getListPayroll($tahun)
    {
        $data = [
            'listPayroll' => PayrollModel::where('tahun', $tahun)
                            ->where('flag', 1)
                            ->where('id_karyawan', auth()->user()->karyawan->id)->get()
        ];
        return view('HRD.profile_user.payroll.list_payroll', $data);
    }

    public function detailPayroll($id)
    {
        $main = PayrollModel::find($id);
        $karyawan = KaryawanModel::find($main->id_karyawan);
        $data = [
            'payroll' => $main,
            'profil' => $karyawan
        ];
        return view('HRD.profile_user.payroll.detail_payroll', $data);
    }

    //pelatihan
    public function pelatihan()
    {
        $data['list_bulan'] = Config::get("constants.bulan");
        $data['thn_start'] = 2021;
        return view("HRD.profile_user.pelatihan.index", $data);
    }
    public function data_pelatihan($bulan, $tahun)
    {
        $data = [
            'list_pelatihan' => PelatihanHeaderModel::select('hrd_pelatihan_h.*', 'hrd_pelatihan_d.pasca')
            ->leftJoin('hrd_pelatihan_d', function($join) {
                $join->on('hrd_pelatihan_d.id_head', '=', 'hrd_pelatihan_h.id');
            })->where('hrd_pelatihan_d.id_karyawan', auth()->user()->karyawan->id)->get()
        ];
        return view('HRD.profile_user.pelatihan.list_data', $data);
    }
    public function detail_pelatihan($id)
    {
        $data['dt_h'] = PelatihanHeaderModel::with('get_peserta')->find($id);
        return view('HRD.profile_user.pelatihan.detail', $data);
    }
    public function edit_pelatihan($id)
    {
        $data['dt_h'] = PelatihanHeaderModel::with('get_peserta')->find($id);
        $data['dt_d'] = PelatihanDetailModel::where('id_head', $id)->where('id_karyawan', auth()->user()->karyawan->id)->first();
        return view('HRD.profile_user.pelatihan.update', $data);
    }
    public function update_pelatihan(Request $request)
    {
        $id_detail = $request->id_detail;
        $path = storage_path("app/public/hrd/evidence_pelatihan");
        if(!File::isDirectory($path)) {
            $path = Storage::disk('public')->makeDirectory('hrd/evidence_pelatihan');
        }
        $file = $request->file('inp_file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('public/hrd/evidence_pelatihan', $filename);
        $update = PelatihanDetailModel::find($id_detail);
        $update->tujuan_pelatihan_pasca = $request->inp_tujuan;
        $update->uraian_materi_pasca = $request->inp_uraian;
        $update->tindak_lanjut_pasca = $request->inp_tindak_lanjut;
        $update->dampak_pasca = $request->inp_dampak;
        $update->penutup_pasca = $request->inp_penutup;
        $update->evidence_pasca = $filename;
        $update->pasca = 1;
        $update->save();
        return redirect('hrd/dataku/pelatihan')->with('konfirm', 'Laporan pasca pelatihan berhasil disimpan');
    }

    public function detail_pasca_pelatihan($id)
    {
        $data['dt_h'] = PelatihanHeaderModel::with('get_peserta')->find($id);
        $data['dt_d'] = PelatihanDetailModel::where('id_head', $id)->where('id_karyawan', auth()->user()->karyawan->id)->first();
        return view('HRD.profile_user.pelatihan.detail_pasca', $data);
    }

    //pengajuan resign
    public function resign()
    {
        $main = ResignModel::with(['get_current_approve', 'get_current_approve.get_jabatan'])->where('id_karyawan', auth()->user()->karyawan->id)->get()->map(
            function($row) {
                $arr = $row->toArray();
                $exitForm = ExitInterviewsModel::with([
                    'get_current_approve',

                ])->where('id_head', $row['id']);
                if($exitForm->get()->count() > 0)
                {
                    $arr['count_exit'] = $exitForm->get()->count();
                    $arr['data_exit'] = $exitForm->first();
                } else {
                    $arr['count_exit'] = 0;
                }
                return $arr;
            }
        );
        $data = [
            'list_pengajuan' => $main,
            'count_pengajuan' => ResignModel::whereIn('sts_pengajuan', [1, 2])->where('id_karyawan', auth()->user()->karyawan->id)->get()->count()
        ];
        // dd($data);
        return view("HRD.profile_user.resign.index", $data);
    }
    public function form_resign()
    {
        return view("HRD.profile_user.resign.add");
    }
    public function store_pengajuan_resign(Request $request)
    {
        $id_depat_karyawan = KaryawanModel::find(auth()->user()->karyawan->id)->id_departemen;
        $_uuid = Str::uuid();
        $group = 15;
        $ifSet = hrdfunction::set_approval_cek($group, $id_depat_karyawan);
        if($ifSet > 0)
        {
            $path = storage_path("app/public/hrd/dataku/resign");
            if(!File::isDirectory($path)) {
                $path = Storage::disk('public')->makeDirectory('hrd/dataku/resign');
            }
            $file = $request->file('inp_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/hrd/dataku/resign', $filename);

            $toDay = date("Y-m-d");
            $tgl_eff_resign = date('Y-m-d', strtotime($toDay . ' +30 day'));
            $data = [
                'id_karyawan' => auth()->user()->karyawan->id,
                'alasan_resign' => $request->inp_alasan,
                'file_surat_resign' => $filename,
                'tgl_eff_resign' => $tgl_eff_resign,
                'sts_pengajuan' => 1, //Pengajuan
                'approval_key' => $_uuid,
                'current_approval_id' => hrdfunction::set_approval_get_first($group, $id_depat_karyawan),
                'create_by' => auth()->user()->id,
                'is_draft' => 1,
                'created_at' => date("Y-m-d H:i:s")
            ];
            ResignModel::insert($data);
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
            return redirect('hrd/dataku/resign')->with('konfirm', 'Pengajuan pengunduran anda berhasil disimpan');

        } else {
            return redirect('hrd/dataku/resign')->with('konfirm', 'Matriks persetujuan belum diatur');
        }
    }
    public function form_edit_resign($id)
    {
        $data = [
            'data' => ResignModel::find($id)
        ];
        return view("HRD.profile_user.resign.edit", $data);
    }

    public function update_pengajuan_resign(Request $request, $id)
    {
        $filename = (empty($request->inp_temp_file)) ? NULL : $request->inp_temp_file;
        if($request->hasFile('inp_file'))
        {
            if($request->inp_temp_file)
            {
                $image_path = storage_path('app/public/hrd/dataku/resign/'.$request->inp_temp_file);
                if(File::exists($image_path)) {
                    File::delete($image_path);
                }
                $file = $request->file('inp_file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('public/hrd/dataku/resign', $filename);

            }
        }

        $data = [
            'alasan_resign' => $request->inp_alasan,
            'file_surat_resign' => $filename,
            'updated_at' => date("Y-m-d H:i:s")
        ];
        ResignModel::find($id)->update($data);
        return redirect('hrd/dataku/resign')->with('konfirm', 'Perubahan pengajuan pengunduran anda berhasil disimpan');
    }

    public function form_cancel_resign($id)
    {
        $data = [
            'data' => ResignModel::find($id)
        ];
        return view("HRD.profile_user.resign.cancel", $data);
    }

    public function form_pengajuan_cancel_resign($id)
    {
        $update = ResignModel::find($id);
        $update->sts_pengajuan = 4; //pengajuan batal
        $update->is_draft = 2;
        $update->save();
        //hapus hirarki persetujuan
        $check_data = ApprovalModel::where('approval_key', $update->approval_key)->get()->count();
        if($check_data > 0) {
            ApprovalModel::where('approval_key', $update->approval_key)->delete();
        }
        return redirect('hrd/dataku/resign')->with('konfirm', 'Pengajuan anda berhasil dibatalkan');
    }
    public function form_detail_resign($id)
    {
        $main = ResignModel::find($id);
        $data = [
            'data' => $main,
            'hirarki_persetujuan' => ApprovalModel::where('approval_key', $main->approval_key)->orderBy('approval_level')->get()
        ];
        return view("HRD.profile_user.resign.detail", $data);
    }
    public function showPdfSuratResign($id)
    {
        $pdf_file = ResignModel::find($id);
        $filePath = storage_path("app/public/hrd/dataku/resign/".$pdf_file->file_surat_resign);
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
        ]);
    }
    //form exit interviews
    public function form_exit_interviews_resign($id)
    {
        $main = ResignModel::with([
            'getKaryawan'
        ])->find($id);
        $data = [
            'data' => $main
        ];
        return view("HRD.profile_user.resign.form_exit_interviews", $data);
    }
    public function store_pengajuan_exit_interviews(Request $request)
    {
        $id_depat_karyawan = KaryawanModel::find(auth()->user()->karyawan->id)->id_departemen;
        $_uuid = Str::uuid();
        $group = 16;
        $ifSet = hrdfunction::set_approval_cek($group, $id_depat_karyawan);
        if($ifSet > 0)
        {
            $data = [
                'id_head' => $request->id_head,
                'jawaban_1' => $request->inp_jawaban_1,
                'jawaban_1_1' => $request->inp_jawaban_1_1,
                'jawaban_1_2' => $request->inp_jawaban_1_2,
                'jawaban_1_3' => str_replace(",","",  $request->inp_jawaban_1_3),
                'jawaban_2' => $request->inp_jawaban_2,
                'jawaban_3' => $request->inp_jawaban_3,
                'jawaban_4' => $request->inp_jawaban_4,
                'jawaban_5' => $request->inp_jawaban_5,
                'jawaban_6' => $request->inp_jawaban_6,
                'jawaban_6_1' => $request->inp_jawaban_6_1,
                'jawaban_6_2' => $request->inp_jawaban_6_2,
                'jawaban_7' => $request->inp_jawaban_7,
                'jawaban_8' => $request->pilihan_8,
                'jawaban_8_1' => $request->inp_jawaban_8_1,
                'jawaban_9' => $request->inp_jawaban_9,
                'jawaban_9_1' => $request->pilihan_9_1,
                'jawaban_9_2' => $request->pilihan_9_2,
                'jawaban_9_3' => $request->pilihan_9_3,
                'jawaban_9_4' => $request->pilihan_9_4,
                'jawaban_9_5' => $request->pilihan_9_5,
                'jawaban_9_6' => $request->pilihan_9_6,
                'jawaban_9_7' => $request->pilihan_9_7,
                'jawaban_9_8' => $request->pilihan_9_8,
                'jawaban_9_9' => $request->pilihan_9_9,
                'jawaban_10' => $request->inp_jawaban_10,
                'approval_key' => $_uuid,
                'current_approval_id' => hrdfunction::set_approval_get_first($group, $id_depat_karyawan),
                'create_by' => auth()->user()->id,
                'is_draft' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'sts_pengajuan' => 1
            ];
            ExitInterviewsModel::insert($data);
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
            return redirect('hrd/dataku/resign')->with('konfirm', 'Data Exit Interviews anda berhasil disimpan');
        } else {
            return redirect('hrd/dataku/resign')->with('konfirm', 'Matriks persetujuan belum diatur');
        }

    }
    public function form_edit_exit_interviews_resign($id)
    {
        $data = [
            'data' => ExitInterviewsModel::find($id)
        ];
        return view("HRD.profile_user.resign.form_exit_interviews_edit", $data);
    }
    public function update_exit_interviews_resign(Request $request, $id)
    {
        $data = [
            'jawaban_1' => $request->inp_jawaban_1,
            'jawaban_1_1' => $request->inp_jawaban_1_1,
            'jawaban_1_2' => $request->inp_jawaban_1_2,
            'jawaban_1_3' => str_replace(",","",  $request->inp_jawaban_1_3),
            'jawaban_2' => $request->inp_jawaban_2,
            'jawaban_3' => $request->inp_jawaban_3,
            'jawaban_4' => $request->inp_jawaban_4,
            'jawaban_5' => $request->inp_jawaban_5,
            'jawaban_6' => $request->inp_jawaban_6,
            'jawaban_6_1' => $request->inp_jawaban_6_1,
            'jawaban_6_2' => $request->inp_jawaban_6_2,
            'jawaban_7' => $request->inp_jawaban_7,
            'jawaban_8' => $request->pilihan_8,
            'jawaban_8_1' => $request->inp_jawaban_8_1,
            'jawaban_9' => $request->inp_jawaban_9,
            'jawaban_9_1' => $request->pilihan_9_1,
            'jawaban_9_2' => $request->pilihan_9_2,
            'jawaban_9_3' => $request->pilihan_9_3,
            'jawaban_9_4' => $request->pilihan_9_4,
            'jawaban_9_5' => $request->pilihan_9_5,
            'jawaban_9_6' => $request->pilihan_9_6,
            'jawaban_9_7' => $request->pilihan_9_7,
            'jawaban_9_8' => $request->pilihan_9_8,
            'jawaban_9_9' => $request->pilihan_9_9,
            'jawaban_10' => $request->inp_jawaban_10,
            'updated_at' => date("Y-m-d H:i:s")
        ];
        ExitInterviewsModel::find($id)->update($data);
        return redirect('hrd/dataku/resign')->with('konfirm', 'Perubahan form exit interviews anda berhasil disimpan');
    }
}
