<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\HRD\ExitInterviewsModel;
use App\Models\HRD\KaryawanModel;
use App\Models\HRD\ResignModel;
use Illuminate\Http\Request;
use App\Helpers\Hrdhelper as hrdfunction;
use App\User;
use Carbon\Carbon;
use PDF;

class ResignController extends Controller
{
    public function index()
    {
        $data = [
            'total_resign' => KaryawanModel::where('id_status_karyawan', 4)->where('nik', '<>', '999999999')->get()->count(),
            'total_pengajuan' => ResignModel::where('sts_pengajuan', 1)->get()->count(),
            'total_exit_form' => ExitInterviewsModel::whereIn('sts_pengajuan', [1, 2, 3])->get()->count()
        ];
        return view('HRD.resign.index', $data);
    }
    public function all_data()
    {
        $data['list_data'] = KaryawanModel::with('get_jabatan')->where('nik', '<>', '999999999')->where('id_status_karyawan', 4)->get();
        return view('HRD.resign.karyawan_resign', $data);
    }
    public function all_pengajuan()
    {
        $data = [
            'list_pengajuan' => ResignModel::with([
                'getKaryawan'
            ])->where('sts_pengajuan', 1)->orderBy('created_at', 'desc')->get()
        ];
        return view('HRD.resign.list_pengajuan', $data);
    }
    public function all_exit_form()
    {
        $data = [
            'list_pengajuan' => ExitInterviewsModel::with([
                'getPengajuan',
                'getPengajuan.getKaryawan'
            ])->whereIn('sts_pengajuan', [1, 2, 3])->orderBy('created_at', 'desc')->get()
        ];
        // dd($data);
        return view('HRD.resign.list_exit_form', $data);
    }
    public function detail_form_exit_interiews($id)
    {
        $data = [
            'profil' => ExitInterviewsModel::with([
                'getPengajuan.getKaryawan'
                ])->find($id)
        ];
        return view('HRD.resign.detail_exit_interviews', $data);
    }
    public function pengaturan_resign($id)
    {
        $data = [
            'profil' => ExitInterviewsModel::with([
                'getPengajuan',
                'getPengajuan.getKaryawan'
                ])->find($id)
        ];
        return view('HRD.resign.pengaturan_resign', $data);
    }

    public function buat_nomor_skk($tanggal_skk)
    {
        $thn = date('Y');
        // $bln = date('m');
        $bln =  hrdfunction::get_bulan_romawi(date('m'));
        $no_urut = 1;
        $ket_surat = "SSB / SSB / SKK / ";
        $nomor_awal = $ket_surat.$bln."-".$thn;
        $result = ResignModel::where('sts_pengajuan', 2)->orderBy('tgl_skk', 'desc')->first();
        if(empty($result->nomor_skk))
        {
            $nomor_urut = sprintf('%03s', $no_urut);
        } else {
            $nomor_urut_terakhir = substr($result->nomor_skk, 0, 3)+1;
            $nomor_urut = sprintf('%03s', $nomor_urut_terakhir);
        }
        return $nomor_urut." / ".$nomor_awal;
    }
    public function pengaturan_resign_store(Request $request, $id_pengajuan)
    {
        $tgl_skk = $request->filled('inp_tgl_skk')
            ? Carbon::createFromFormat('d/m/Y', $request->inp_tgl_skk)->format('Y-m-d')
            : date('Y-m-d');

        $tgl_resign = $request->filled('inp_tgl_resign')
            ? Carbon::createFromFormat('d/m/Y', $request->inp_tgl_resign)->format('Y-m-d')
            : date('Y-m-d');

        $data = [
            'cara_keluar' => $request->caraKeluar,
            'tgl_skk' => $tgl_skk,
            'nomor_skk' => $this->buat_nomor_skk($tgl_skk),
            'tgl_eff_resign' =>  $tgl_resign,
        ];

        ResignModel::find($id_pengajuan)->update($data);
        //update data karyawan
        $update_karyawan = KaryawanModel::find($request->id_karyawan);
        $update_karyawan->id_status_karyawan = 4; //status resign
        $update_karyawan->tgl_resign = $tgl_resign;
        $update_karyawan->update();
        //delete users
        $data_user = User::where('nik', $update_karyawan->nik);
        if($data_user->get()->count() > 0)
        {
            $user = User::find($data_user->first()->id);
            $roles_user = $user->roles;
            foreach ($roles_user as $lroles) {
                $user->removeRole($lroles->id);
            }
            $user->delete();
        }
        return redirect('hrd/resign')->with('konfirm', 'Data berhasil disimpan');
    }
    public function print_skk($id_pengajuan)
    {
        $data = [
            'main' => ResignModel::with([
                'getKaryawan'
            ])->find($id_pengajuan),
            'kop_surat' => hrdfunction::get_kop_surat()
        ];
        $pdf = PDF::loadview('HRD.resign.print_skk', $data)->setPaper('A4', 'potrait');
        return $pdf->stream();
    }
}
