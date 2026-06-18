<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HRD\KaryawanModel;
use App\Models\HRD\CutiModel;
use App\Models\HRD\IzinModel;
use App\Models\HRD\MutasiModel;
use App\Models\HRD\PerubahanStatusModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // status karyawan yang dianggap aktif (Training, Kontrak, Tetap, Harian)
    private $activeStatuses = [1, 2, 3, 7];
    private $excludeNik = '999999999';

    public function index()
    {
        $now = Carbon::now();
        $thn = $now->year;
        $bln = $now->month;
        $today = $now->toDateString();
        $day30 = $now->copy()->addDays(30)->toDateString();
        $all_sts_karyawan = Config::get("constants.status_karyawan");

        // ============ A. DATA DASAR (agregat, hemat query) ============
        $totalAktif = $this->baseKaryawan()->count();

        // per departemen (1 query)
        $perDept = DB::table('hrd_karyawan')
            ->join('mst_hrd_departemen', 'hrd_karyawan.id_departemen', '=', 'mst_hrd_departemen.id')
            ->whereIn('hrd_karyawan.id_status_karyawan', $this->activeStatuses)
            ->where('hrd_karyawan.nik', '<>', $this->excludeNik)
            ->select('mst_hrd_departemen.nm_dept', DB::raw('count(*) as jml'))
            ->groupBy('mst_hrd_departemen.id', 'mst_hrd_departemen.nm_dept')
            ->orderBy('mst_hrd_departemen.nm_dept')
            ->get();
        $data_chart_1 = [];
        foreach ($perDept as $d) {
            $data_chart_1[] = ['nm_dept' => $d->nm_dept, 'jml_karyawan' => (int) $d->jml];
        }

        // per status (1 query)
        $perStatus = DB::table('hrd_karyawan')
            ->whereIn('id_status_karyawan', $this->activeStatuses)
            ->where('nik', '<>', $this->excludeNik)
            ->select('id_status_karyawan', DB::raw('count(*) as jml'))
            ->groupBy('id_status_karyawan')->pluck('jml', 'id_status_karyawan');
        $data_chart_2 = [];
        foreach ($this->activeStatuses as $key) {
            $data_chart_2[] = [
                'status' => $all_sts_karyawan[$key] ?? $key,
                'jml_karyawan' => (int) ($perStatus[$key] ?? 0),
            ];
        }

        // usia (1 query, CASE)
        $usia = $this->baseKaryawan()
            ->selectRaw("
                SUM(CASE WHEN timestampdiff(year, tgl_lahir, curdate()) <= 25 THEN 1 ELSE 0 END) as u1,
                SUM(CASE WHEN timestampdiff(year, tgl_lahir, curdate()) BETWEEN 26 AND 30 THEN 1 ELSE 0 END) as u2,
                SUM(CASE WHEN timestampdiff(year, tgl_lahir, curdate()) BETWEEN 31 AND 40 THEN 1 ELSE 0 END) as u3,
                SUM(CASE WHEN timestampdiff(year, tgl_lahir, curdate()) > 40 THEN 1 ELSE 0 END) as u4
            ")->first();

        // jenis kelamin (1 query)
        $jk = $this->baseKaryawan()
            ->selectRaw("
                SUM(CASE WHEN jenkel = 'L' THEN 1 ELSE 0 END) as l,
                SUM(CASE WHEN jenkel = 'P' THEN 1 ELSE 0 END) as p
            ")->first();

        // fasilitas BPJS (1 query)
        $bpjs = $this->baseKaryawan()
            ->selectRaw("
                SUM(CASE WHEN bpjs_kesehatan = 'y' THEN 1 ELSE 0 END) as kesehatan,
                SUM(CASE WHEN bpjs_tk_jht = 'y' THEN 1 ELSE 0 END) as jht,
                SUM(CASE WHEN bpjs_tk_jkk = 'y' THEN 1 ELSE 0 END) as jkk,
                SUM(CASE WHEN bpjs_tk_jkm = 'y' THEN 1 ELSE 0 END) as jkm,
                SUM(CASE WHEN bpjs_tk_jp = 'y' THEN 1 ELSE 0 END) as jp
            ")->first();
        $data['bpjs'] = [
            'kesehatan' => (int) $bpjs->kesehatan,
            'jht'       => (int) $bpjs->jht,
            'jkk'       => (int) $bpjs->jkk,
            'jkm'       => (int) $bpjs->jkm,
            'jp'        => (int) $bpjs->jp,
        ];

        // ============ B1. KPI CARDS ============
        $data['kpi'] = [
            'total_aktif'   => $totalAktif,
            'karyawan_baru' => KaryawanModel::whereMonth('tgl_masuk', $bln)->whereYear('tgl_masuk', $thn)
                                ->whereIn('id_status_karyawan', $this->activeStatuses)->where('nik', '<>', $this->excludeNik)->count(),
            'resign_bulan'  => KaryawanModel::whereMonth('tgl_resign', $bln)->whereYear('tgl_resign', $thn)
                                ->where('nik', '<>', $this->excludeNik)->count(),
            'pkwt_30hari'   => KaryawanModel::whereBetween('tgl_sts_efektif_akhir', [$today, $day30])
                                ->whereIn('id_status_karyawan', [1, 2])->where('nik', '<>', $this->excludeNik)->count(),
        ];

        // ============ B3. APPROVAL PENDING ============
        $data['pending'] = [
            'cuti'      => CutiModel::where('sts_pengajuan', 1)->count(),
            'izin'      => IzinModel::where('sts_pengajuan', 1)->count(),
            'mutasi'    => MutasiModel::where('status_pengajuan', 1)->count(),
            'perubahan' => PerubahanStatusModel::where('status_pengajuan', 1)->count(),
        ];
        $data['pending']['total'] = array_sum($data['pending']);

        // ============ B2. KEHADIRAN HARI INI ============
        $hadir = DB::table('hrd_absensi')->whereDate('tanggal', $today)->where('status', 'C/Masuk')->distinct()->count('nik_lama');
        $cutiHariIni = CutiModel::where('sts_pengajuan', 2)->where('tgl_awal', '<=', $today)->where('tgl_akhir', '>=', $today)->count();
        $izinHariIni = IzinModel::where('sts_pengajuan', 2)->where('tgl_awal', '<=', $today)->where('tgl_akhir', '>=', $today)->count();
        $tidakHadir = max(0, $totalAktif - $hadir - $cutiHariIni - $izinHariIni);
        $data['kehadiran'] = [
            'hadir'       => $hadir,
            'cuti'        => $cutiHariIni,
            'izin'        => $izinHariIni,
            'tidak_hadir' => $tidakHadir,
            'persen'      => $totalAktif > 0 ? round($hadir / $totalAktif * 100, 1) : 0,
        ];

        // ============ B4. REMINDER / ALERT ============
        $data['pkwt_list'] = DB::table('hrd_karyawan')
            ->leftJoin('mst_hrd_departemen', 'hrd_karyawan.id_departemen', '=', 'mst_hrd_departemen.id')
            ->whereBetween('hrd_karyawan.tgl_sts_efektif_akhir', [$today, $day30])
            ->whereIn('hrd_karyawan.id_status_karyawan', [1, 2])
            ->where('hrd_karyawan.nik', '<>', $this->excludeNik)
            ->select('hrd_karyawan.nik', 'hrd_karyawan.nm_lengkap', 'hrd_karyawan.tgl_sts_efektif_akhir', 'mst_hrd_departemen.nm_dept')
            ->orderBy('hrd_karyawan.tgl_sts_efektif_akhir')->limit(8)->get();

        $data['sp_list'] = DB::table('hrd_karyawan')
            ->leftJoin('mst_hrd_departemen', 'hrd_karyawan.id_departemen', '=', 'mst_hrd_departemen.id')
            ->where('hrd_karyawan.sp_active', 1)
            ->where('hrd_karyawan.nik', '<>', $this->excludeNik)
            ->select('hrd_karyawan.nik', 'hrd_karyawan.nm_lengkap', 'mst_hrd_departemen.nm_dept')
            ->limit(8)->get();

        $data['tanpa_niklama'] = $this->baseKaryawan()
            ->where(function ($q) {
                $q->whereNull('nik_lama')->orWhere('nik_lama', '');
            })->count();

        $data['usia_1'] = (int) $usia->u1;
        $data['usia_2'] = (int) $usia->u2;
        $data['usia_3'] = (int) $usia->u3;
        $data['usia_4'] = (int) $usia->u4;
        $data['jk_l'] = (int) $jk->l;
        $data['jk_p'] = (int) $jk->p;
        $data['data_chart_1'] = $data_chart_1;
        $data['data_chart_2'] = $data_chart_2;
        $data['periode_tahun'] = $thn;
        $data['nama_bulan'] = Config::get("constants.bulan")[sprintf('%02d', $bln)] ?? $bln;

        return view('HRD.dashboard.index', $data);
    }

    // query dasar karyawan aktif (reusable)
    private function baseKaryawan()
    {
        return KaryawanModel::whereIn('id_status_karyawan', $this->activeStatuses)
            ->where('nik', '<>', $this->excludeNik);
    }
}
