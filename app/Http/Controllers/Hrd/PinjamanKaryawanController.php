<?php

namespace App\Http\Controllers\Hrd;

use App\Helpers\Hrdhelper;
use App\Http\Controllers\Controller;
use App\Models\HRD\PembayaranPinjamanKaryawanModel;
use App\Models\HRD\PinjamanKaryawanDokumenModel;
use App\Models\HRD\PinjamanKaryawanModel;
use App\Models\HRD\PinjamanKaryawanMutasiModel;
use App\Traits\HasUpload;
use Illuminate\Http\Request;
use PDF;
use Symfony\Component\Console\Helper\Helper;

class PinjamanKaryawanController extends Controller
{
    use HasUpload;

    public function index()
    {
        $data = [
            'jumlah_pengajuan' => PinjamanKaryawanModel::where('status_pengajuan', 1)->get()->count(),
            'jumlah_pinjaman_aktif' => PinjamanKaryawanModel::where('status_pengajuan', 2)->where('aktif', 'y')->get()->count(),
            'jumlah_pinjaman_lunas' => PinjamanKaryawanModel::where('status_pengajuan', 2)->where('aktif', 'n')->get()->count()
        ];
        return view('HRD.pinjaman_karyawan.index', $data);
    }

    public function listPengajuan()
    {
        $data = [
            'list_pengajuan' => PinjamanKaryawanModel::where('status_pengajuan', 1)->get()
        ];
        return view('HRD.pinjaman_karyawan.list_pengajuan', $data);
    }

    public function listPinjamanKaryawan()
    {
        $data = [
            'list_pinjaman_karyawan' => PinjamanKaryawanModel::select('hrd_pinjaman_karyawan.*', 'hrd_karyawan.nm_lengkap')
            ->leftJoin('hrd_karyawan', 'hrd_pinjaman_karyawan.id_karyawan', '=', 'hrd_karyawan.id')->where('hrd_pinjaman_karyawan.status_pengajuan', 2)->where('hrd_pinjaman_karyawan.aktif', 'y')->get()
            ->map( function ($items) {
                $arr = $items->toArray();
                // $arr['outs'] = PinjamanKaryawanMutasiModel::where('id_head',  $arr['id'])->where('status', 1)->sum('nominal');
                // $arr['pembayaran_ke'] = PinjamanKaryawanMutasiModel::where('id_head',  $arr['id'])->where('status', 1)->get()->count();
                $arr['outs'] = PembayaranPinjamanKaryawanModel::where('id_head',  $arr['id'])->sum('nominal');
                $arr['pembayaran_ke'] = PembayaranPinjamanKaryawanModel::where('id_head',  $arr['id'])->get()->count();
                return $arr;
            })

        ];
        // dd($data);
        return view('HRD.pinjaman_karyawan.list_pinjaman_karyawan', $data);
    }

    public function listPinjamanKaryawanLunas()
    {
        $data = [
            'list_pinjaman_karyawan' => PinjamanKaryawanModel::select('hrd_pinjaman_karyawan.*', 'hrd_karyawan.nm_lengkap')
            ->leftJoin('hrd_karyawan', 'hrd_pinjaman_karyawan.id_karyawan', '=', 'hrd_karyawan.id')
            ->where('hrd_pinjaman_karyawan.status_pengajuan', 2)
            ->where('hrd_pinjaman_karyawan.aktif', 'n')->get()
            ->map( function ($items) {
                $arr = $items->toArray();
                $arr['outs'] = PembayaranPinjamanKaryawanModel::where('id_head',  $arr['id'])->sum('nominal');
                $arr['pembayaran_ke'] = PembayaranPinjamanKaryawanModel::where('id_head',  $arr['id'])->get()->count();
                // $arr['outs'] = PinjamanKaryawanMutasiModel::where('id_head',  $arr['id'])->where('status', 1)->sum('nominal');
                // $arr['pembayaran_ke'] = PinjamanKaryawanMutasiModel::where('id_head',  $arr['id'])->where('status', 1)->get()->count();
                return $arr;
            })

        ];
        // dd($data);
        return view('HRD.pinjaman_karyawan.list_pinjaman_karyawan_lunas', $data);
    }

    public function getFormProses($id)
    {
        $result = PinjamanKaryawanModel::with([
            'getKaryawan',
            'getDokumen',
            'getMutasi'
        ])->find($id);
        // $terbayar = PinjamanKaryawanMutasiModel::where('id_head', $id)->where('status', '1')->sum('nominal');
        $terbayar = PembayaranPinjamanKaryawanModel::where('id_head', $id)->sum('nominal');
        $list_pembayaran = PembayaranPinjamanKaryawanModel::where('id_head', $id)->get();
        $oustanding = $result->nominal_apply - $terbayar;
        $data = [
            'data' => $result,
            'status_karyawan' => Hrdhelper::get_status_karyawan($result->getKaryawan->id_status_karyawan),
            'outstanding' => $oustanding,
            'list_pembayaran' => $list_pembayaran,
            "pembayaran_ke" => ($list_pembayaran->count()==0) ? 1 : ($list_pembayaran->count() + 1)
        ];
        return view('HRD.pinjaman_karyawan.form_proses', $data);
    }

    public function getDataPembayaran(Request $request)
    {
        $result = PinjamanKaryawanMutasiModel::find($request->id_mutasi);

        return response()->json([
            'nominal' => $result->nominal,
            'id_data' => $result->id
        ]);
    }

    public function prosesPembayaranStore(Request $request)
    {
        try {
            $id_mutasi = $request->id_mutasi;
            $dataH = PinjamanKaryawanModel::find($request->id_head);
            if($request->hasFile('inpFileImage')) {
                $fileUpload = $this->uploadImage($request, 'public/hrd/bukti_pembayaran_pinjaman_karyawan/', 'hrd/bukti_pembayaran_pinjaman_karyawan');
            } else {
                $fileUpload=NULL;
            }
            $jumlah_bayar = str_replace(",", "", $request->inpJumlahBayar);
            $data_pembayaran = [
                "id_head" => $request->id_head,
                "tanggal" =>  $request->inpTanggalBayar,
                "nominal" => $jumlah_bayar,
                "id_user" => auth()->user()->id,
                "bukti_bayar" => $fileUpload
            ];
            PembayaranPinjamanKaryawanModel::create($data_pembayaran);
            return redirect('hrd/pinjaman_karyawan')->with('konfirm', 'Data pembayaran berhasil disimpan');

        } catch (\Exception $ex) {
            return redirect('hrd/pinjaman_karyawan')->with('konfirm', 'Data pembayaran gagal disimpan. '.$ex->getMessage());
        }

        // $fileUpload=NULL;
        // $update = PinjamanKaryawanMutasiModel::find($id_mutasi);
        // $update->tanggal = $request->inpTanggalBayar;
        // $update->status = 1;
        // $update->nominal = $jumlah_bayar;
        // $update->bukti_bayar = $fileUpload;
        // $update->bayar_aktif = 0;
        // $update->save();
        // //next data
        // $terbayar = PinjamanKaryawanMutasiModel::where('id_head', $request->id_head)->where('status', 1)->sum('nominal');
        // $oustanding = $dataH->nominal_apply - $terbayar;
        // $next_data = PinjamanKaryawanMutasiModel::where('id_head', $request->id_head)->whereNull('status')->first();
        // if(!empty($next_data->id))
        // {
        //     if($oustanding == 0)
        //     {
        //         $update_next = PinjamanKaryawanMutasiModel::find($next_data->id);
        //         $update_next->bayar_aktif = 0;
        //         $update_next->save();
        //         //jika lunas
        //         $update_head = PinjamanKaryawanModel::find($request->id_head);
        //         $update_head->aktif = 'n'; //y = belum lunas, n=lunas
        //         $update_head->save();
        //         Hrdhelper::generate_mutasi_lunas_awal($request->id_head);
        //     } else {
        //         $update_next = PinjamanKaryawanMutasiModel::find($next_data->id);
        //         $update_next->bayar_aktif = 1;
        //         $update_next->save();
        //         if($jumlah_bayar != $dataH->angsuran)
        //         {
        //             Hrdhelper::generate_mutasi($request->id_head, $dataH->nominal_apply, $dataH->tenor_apply);
        //         }
        //         //generate tgl jatuh tempo
        //         Hrdhelper::generate_duedate_pinjaman_karyawan($request->id_head, $request->inpTanggalBayar);
        //     }

        // } else {
        //     //jika lunas
        //     $update_head = PinjamanKaryawanModel::find($request->id_head);
        //     $update_head->aktif = 'n'; //y = belum lunas, n=lunas
        //     $update_head->save();
        // }
        // return redirect('hrd/pinjaman_karyawan')->with('konfirm', 'Data pembayaran berhasil disimpan');
    }

    public function printMutasi($id)
    {
        $result = PinjamanKaryawanModel::with([
            'getKaryawan',
            'getDokumen',
            'getMutasi',
            'getListPembayaran'
        ])->find($id);
        // $terbayar = PinjamanKaryawanMutasiModel::where('id_head', $id)->where('status', '1')->sum('nominal');
        $terbayar = PembayaranPinjamanKaryawanModel::where('id_head', $id)->sum('nominal');
        $oustanding = $result->nominal_apply - $terbayar;
        $data = [
            'data' => $result,
            'status_karyawan' => Hrdhelper::get_status_karyawan($result->getKaryawan->id_status_karyawan),
            'outstanding' => $oustanding,
            'kop_surat' => Hrdhelper::get_kop_surat()
        ];
        $pdf = PDF::loadview('HRD.pinjaman_karyawan.print_mutasi', $data)->setPaper('A4', 'potrait');
        return $pdf->stream();

        // return view('HRD.profile_user.pinjaman_karyawan.view_mutasi', $data);
    }
}
