<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AbsensiModel extends Model
{
    protected $table = "hrd_absensi";
    protected $fillable = [
        'id_departemen',
        'id_finger',
        'tanggal',
        'jam',
        'status',
        'lokasi_id',
        'user_id',
        'dhuhur', //y atau t
        'ashar', // y atau t
        'nik_lama'
    ];

    // Hitung rekap kehadiran seluruh karyawan (per departemen / semua) pada bulan & tahun tertentu
    public static function rekap_bulanan($bulan, $tahun, $departemen)
    {
        $thn = (int) $tahun;
        $bln = (int) $bulan;
        $bln_pad = sprintf('%02d', $bln);
        $jml_hari = \App\Helpers\Hrdhelper::tglAkhirBulan($thn, $bln_pad);
        $awal_bln = sprintf('%04d-%02d-01', $thn, $bln);
        $akhir_bln = sprintf('%04d-%02d-%02d', $thn, $bln, $jml_hari);

        // tanggal libur (hari libur nasional/khusus) pada bulan tsb
        $tgl_libur = [];
        $result_hari_libur = \App\Models\HRD\SetupHariLiburModel::whereMonth('tanggal', $bln)->whereYear('tanggal', $thn)->get();
        foreach ($result_hari_libur as $lbr) {
            $tgl_libur[] = date('Y-m-d', strtotime($lbr->tanggal));
        }

        // daftar karyawan aktif (per departemen / semua)
        $q_karyawan = \App\Models\HRD\KaryawanModel::wherein('id_status_karyawan', [1, 2, 3, 7])
            ->where('nik', '<>', '999999999');
        if ($departemen != 0) {
            $q_karyawan->where('id_departemen', $departemen);
        }
        $list_karyawan = $q_karyawan->orderBy('id_departemen')->orderBy('nik')->get();

        $rekap = [];
        foreach ($list_karyawan as $kry) {
            // tanggal-tanggal yang ada record absensi (hadir) dalam bulan
            $tgl_hadir = [];
            if (!empty($kry->nik_lama)) {
                $rows = DB::table('hrd_absensi')
                    ->select(DB::raw('DATE(tanggal) as tgl'))
                    ->where('nik_lama', $kry->nik_lama)
                    ->whereYear('tanggal', $thn)
                    ->whereMonth('tanggal', $bln)
                    ->groupBy(DB::raw('DATE(tanggal)'))
                    ->pluck('tgl')->toArray();
                foreach ($rows as $r) {
                    $tgl_hadir[date('Y-m-d', strtotime($r))] = true;
                }
            }

            // cuti / izin / perdis / pelatihan yang beririsan dengan bulan
            $cuti_rows = \App\Models\HRD\CutiModel::where('id_karyawan', $kry->id)->where('sts_pengajuan', 2)
                ->where('tgl_awal', '<=', $akhir_bln)->where('tgl_akhir', '>=', $awal_bln)->get();
            $izin_rows = \App\Models\HRD\IzinModel::where('id_karyawan', $kry->id)->where('sts_pengajuan', 2)
                ->where('tgl_awal', '<=', $akhir_bln)->where('tgl_akhir', '>=', $awal_bln)->get();
            $perdis_rows = \App\Models\HRD\PerdisModel::where('id_karyawan', $kry->id)->where('sts_persetujuan', 1)
                ->where('tgl_berangkat', '<=', $akhir_bln)->where('tgl_kembali', '>=', $awal_bln)->get();
            $pelatihan_rows = DB::table('hrd_pelatihan_h')
                ->join('hrd_pelatihan_d', 'hrd_pelatihan_h.id', '=', 'hrd_pelatihan_d.id_head')
                ->where('hrd_pelatihan_d.id_karyawan', $kry->id)
                ->where('hrd_pelatihan_h.status_pelatihan', 5)
                ->where('hrd_pelatihan_h.tanggal_awal', '<=', $akhir_bln)
                ->where('hrd_pelatihan_h.tanggal_sampai', '>=', $awal_bln)
                ->select('hrd_pelatihan_h.tanggal_awal', 'hrd_pelatihan_h.tanggal_sampai')->get();

            $hari_kerja = 0; $hadir = 0; $cuti = 0; $izin = 0; $perdis = 0; $training = 0; $alpa = 0;
            for ($d = 1; $d <= $jml_hari; $d++) {
                $tgl = sprintf('%04d-%02d-%02d', $thn, $bln, $d);
                $is_libur = (\App\Helpers\Hrdhelper::isWeekend($tgl) == 'sunday') || in_array($tgl, $tgl_libur);
                if ($is_libur) {
                    continue;
                }
                $hari_kerja++;
                if (self::tgl_in_range($tgl, $cuti_rows, 'tgl_awal', 'tgl_akhir')) {
                    $cuti++;
                } elseif (self::tgl_in_range($tgl, $izin_rows, 'tgl_awal', 'tgl_akhir')) {
                    $izin++;
                } elseif (self::tgl_in_range($tgl, $perdis_rows, 'tgl_berangkat', 'tgl_kembali')) {
                    $perdis++;
                } elseif (self::tgl_in_range($tgl, $pelatihan_rows, 'tanggal_awal', 'tanggal_sampai')) {
                    $training++;
                } elseif (isset($tgl_hadir[$tgl])) {
                    $hadir++;
                } else {
                    $alpa++;
                }
            }

            $rekap[] = (object) [
                'nik' => $kry->nik,
                'nm_lengkap' => $kry->nm_lengkap,
                'nm_dept' => optional($kry->get_departemen)->nm_dept,
                'hari_kerja' => $hari_kerja,
                'hadir' => $hadir,
                'cuti' => $cuti,
                'izin' => $izin,
                'perdis' => $perdis,
                'training' => $training,
                'alpa' => $alpa,
            ];
        }

        return $rekap;
    }

    // Cek apakah suatu tanggal (Y-m-d) berada dalam salah satu rentang pada koleksi rows
    private static function tgl_in_range($tgl, $rows, $field_start, $field_end)
    {
        foreach ($rows as $row) {
            $start = date('Y-m-d', strtotime($row->$field_start));
            $end = date('Y-m-d', strtotime($row->$field_end));
            if ($tgl >= $start && $tgl <= $end) {
                return true;
            }
        }
        return false;
    }

    // Bangun grid harian absensi 1 departemen (mengikuti logika AbsensiController::list_data)
    // Dipakai untuk menampilkan & meng-export hasil filter agar identik.
    public static function grid_bulanan($id_dept, $bulan, $tahun, $id_jabatan = null)
    {
        $thn = (int) $tahun;
        $bln = (int) $bulan;
        $bln_pad = sprintf('%02d', $bln);
        $jml_hari = \App\Helpers\Hrdhelper::tglAkhirBulan($thn, $bln_pad);
        $ket_periode = \App\Helpers\Hrdhelper::get_nama_bulan($bln_pad) . " " . $thn;

        $jam_ishoma_start = "11:00";
        $jam_ishoma_end = "14:00";

        // tanggal libur bersama
        $tgl_libur = [];
        $result_hari_libur = \App\Models\HRD\SetupHariLiburModel::whereMonth('tanggal', $bln)->whereYear('tanggal', $thn)->get();
        foreach ($result_hari_libur as $lbr) {
            $tgl_libur[] = date('Y-m-d', strtotime($lbr->tanggal));
        }

        $q_karyawan = \App\Models\HRD\KaryawanModel::wherein('id_status_karyawan', [1, 2, 3, 7])
            ->where('id_departemen', $id_dept)
            ->where('nik', '<>', '999999999');
        if (!empty($id_jabatan)) {
            $q_karyawan->where('id_jabatan', $id_jabatan);
        }
        $list_karyawan = $q_karyawan->orderBy('nik', 'asc')->get();

        $rows = [];
        foreach ($list_karyawan as $kry) {
            $cells = [];
            $tot_hadir = 0; $tot_cuti = 0; $tot_izin = 0; $tot_perdis = 0; $tot_pelatihan = 0;

            for ($i = 1; $i <= $jml_hari; $i++) {
                $day = sprintf("%02s", $i);
                $filter_tanggal = $thn . "-" . $bln_pad . "-" . $day;
                $libur = (\App\Helpers\Hrdhelper::isWeekend($filter_tanggal) == 'sunday') || in_array($filter_tanggal, $tgl_libur) ? 'y' : 'n';

                // cek kehadiran (jam masuk / ishoma / pulang)
                $jml_hadir = 0;
                $jadwal = "";
                $res = DB::table('hrd_absensi as a')
                    ->select([
                        DB::raw("(SELECT MIN(jam) FROM hrd_absensi WHERE nik_lama = a.nik_lama AND tanggal = '$filter_tanggal' AND status = 'C/Masuk') as check_in"),
                        DB::raw("(SELECT MIN(jam) FROM hrd_absensi WHERE nik_lama = a.nik_lama AND tanggal = '$filter_tanggal' AND status = 'C/Keluar' AND jam BETWEEN '$jam_ishoma_start' AND '$jam_ishoma_end') as ishoma_keluar"),
                        DB::raw("(SELECT MAX(jam) FROM hrd_absensi WHERE nik_lama = a.nik_lama AND tanggal = '$filter_tanggal' AND status = 'C/Masuk' AND jam BETWEEN '$jam_ishoma_start' AND '$jam_ishoma_end') as ishoma_masuk"),
                        DB::raw("(SELECT MAX(jam) FROM hrd_absensi WHERE nik_lama = a.nik_lama AND tanggal = '$filter_tanggal' AND status = 'C/Keluar') as pulang"),
                    ])
                    ->whereDate('a.tanggal', $filter_tanggal)
                    ->where('a.nik_lama', $kry->nik_lama)
                    ->groupBy('a.nik_lama')
                    ->first();
                if ($res) {
                    $in = empty($res->check_in) ? "" : date('H:i', strtotime($res->check_in));
                    $ishoma_out = empty($res->ishoma_keluar) ? "" : date('H:i', strtotime($res->ishoma_keluar));
                    $ishoma_in = empty($res->ishoma_masuk) ? "" : date('H:i', strtotime($res->ishoma_masuk));
                    $out = empty($res->pulang) ? "" : date('H:i', strtotime($res->pulang));
                    if ($in || $out) {
                        if ($ishoma_out || $ishoma_in) {
                            $pagi = $in . ($ishoma_out ? '-' . $ishoma_out : '');
                            $siang = $ishoma_in ? ($ishoma_in . '-' . $out) : '';
                            $jadwal = trim($pagi . ($siang ? ' | ' . $siang : ''));
                        } else {
                            $jadwal = $in . ($out ? '-' . $out : '');
                        }
                    }
                    $jml_hadir = 1;
                }

                // cek cuti / izin / perdis / pelatihan
                $result_cuti = \App\Models\HRD\CutiModel::where('id_karyawan', $kry->id)
                    ->where('tgl_awal', '<=', $filter_tanggal)->where('tgl_akhir', '>=', $filter_tanggal)
                    ->where('sts_pengajuan', 2)->count();
                $result_izin = \App\Models\HRD\IzinModel::where('id_karyawan', $kry->id)
                    ->where('tgl_awal', '<=', $filter_tanggal)->where('tgl_akhir', '>=', $filter_tanggal)
                    ->where('sts_pengajuan', 2)->count();
                $result_perdis = \App\Models\HRD\PerdisModel::where('id_karyawan', $kry->id)
                    ->where('tgl_berangkat', '<=', $filter_tanggal)->where('tgl_kembali', '>=', $filter_tanggal)
                    ->where('sts_persetujuan', 1)->count();
                $result_pelatihan = DB::table('hrd_pelatihan_h')
                    ->join('hrd_pelatihan_d', 'hrd_pelatihan_h.id', '=', 'hrd_pelatihan_d.id_head')
                    ->where('hrd_pelatihan_h.tanggal_awal', '<=', $filter_tanggal)
                    ->where('hrd_pelatihan_h.tanggal_sampai', '>=', $filter_tanggal)
                    ->where('hrd_pelatihan_d.id_karyawan', $kry->id)
                    ->where('hrd_pelatihan_h.status_pelatihan', 5)->count();

                $jml_cuti = 0; $jml_izin = 0; $jml_perdis = 0; $jml_pelatihan = 0;
                if ($result_cuti >= 1) {
                    if ($libur == 'n') { $jml_cuti = 1; $cell = 'CUTI'; } else { $cell = ''; }
                } elseif ($result_izin >= 1) {
                    if ($libur == 'n') { $jml_izin = 1; $cell = 'IZIN'; } else { $cell = ''; }
                } elseif ($result_perdis >= 1) {
                    if ($libur == 'n') { $jml_perdis = 1; $cell = 'DINAS'; } else { $cell = ''; }
                } elseif ($result_pelatihan >= 1) {
                    if ($libur == 'n') { $jml_pelatihan = 1; $cell = 'TRAINING'; } else { $cell = ''; }
                } else {
                    $cell = $jadwal;
                }

                $cells[$i] = ['val' => $cell, 'libur' => $libur];
                $tot_hadir += $jml_hadir;
                $tot_cuti += $jml_cuti;
                $tot_izin += $jml_izin;
                $tot_perdis += $jml_perdis;
                $tot_pelatihan += $jml_pelatihan;
            }

            $rows[] = (object) [
                'nik' => $kry->nik,
                'nik_lama' => $kry->nik_lama,
                'nm_lengkap' => $kry->nm_lengkap,
                'cells' => $cells,
                'tot_hadir' => $tot_hadir,
                'tot_cuti' => $tot_cuti,
                'tot_izin' => $tot_izin,
                'tot_perdis' => $tot_perdis,
                'tot_pelatihan' => $tot_pelatihan,
            ];
        }

        return (object) [
            'jml_hari' => $jml_hari,
            'ket_periode' => $ket_periode,
            'rows' => $rows,
        ];
    }
}
