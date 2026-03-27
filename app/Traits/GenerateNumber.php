<?php
namespace App\Traits;

use App\Helpers\Hrdhelper;
use App\Models\HRD\CutiModel;
use App\Models\HRD\PinjamanKaryawanModel;

trait GenerateNumber
{
    public static function generate_no_surat()
    {
        $thn = date('Y');
        $bln =  Hrdhelper::get_bulan_romawi(date('m'));
        $no_urut = 1;
        $ket_surat = "SC/SSB";
        $nomor_awal = $ket_surat."/".$bln."/".$thn;
        $result = CutiModel::where('sts_pengajuan', 2)->whereYear('tgl_pengajuan', $thn)->orderBy('id', 'desc')->first();
        if(empty($result->nomor_surat))
        {
            $nomor_urut = sprintf('%03s', $no_urut);
        } else {
            $nomor_urut_terakhir = substr($result->nomor_surat, 0, 3)+1;
            $nomor_urut = sprintf('%03s', $nomor_urut_terakhir);
        }
        return $nomor_urut."/".$nomor_awal;
    }

    public static function generate_no_pinjaman()
    {
        $thn = date('Y');
        $bln =  date('m');
        $no_urut = 1;
        $nomor_awal = $bln.$thn;
        $result = PinjamanKaryawanModel::where('status_pengajuan', 2)->whereYear('tgl_pengajuan', $thn)->orderBy('id', 'desc')->first();
        if(empty($result->nomor_pinjaman))
        {
            $nomor_urut = sprintf('%05s', $no_urut);
        } else {
            $nomor_urut_terakhir = substr($result->nomor_pinjaman, 0, 5)+1;
            $nomor_urut = sprintf('%05s', $nomor_urut_terakhir);
        }
        return $nomor_urut.$nomor_awal;
    }

}
