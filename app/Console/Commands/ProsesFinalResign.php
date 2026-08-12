<?php

namespace App\Console\Commands;

use App\Models\HRD\KaryawanModel;
use App\Models\HRD\ResignModel;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ProsesFinalResign extends Command
{
    /**
     * Nama dan signature command artisan.
     *
     * @var string
     */
    protected $signature = 'resign:proses-final';

    /**
     * Deskripsi command.
     *
     * @var string
     */
    protected $description = 'Memproses finalisasi resign: update status karyawan dan hapus akun user ketika tgl_eff_resign sudah jatuh tempo.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::today()->toDateString();

        // Ambil data resign yang:
        // - sts_pengajuan = 2 (sudah disetujui / SKK sudah dibuat)
        // - tgl_eff_resign <= hari ini
        // - Karyawan belum berstatus resign (id_status_karyawan != 4)
        $data_resign = ResignModel::with('getKaryawan')
            ->where('sts_pengajuan', 2)
            ->whereDate('tgl_eff_resign', '<=', $today)
            ->whereHas('getKaryawan', function ($q) {
                $q->where('id_status_karyawan', '!=', 4);
            })
            ->get();

        if ($data_resign->isEmpty()) {
            $this->info('[' . now() . '] Tidak ada data resign yang perlu diproses.');
            return 0;
        }

        $this->info('[' . now() . '] Memproses ' . $data_resign->count() . ' data resign...');

        foreach ($data_resign as $resign) {
            $karyawan = $resign->getKaryawan;

            if (!$karyawan) {
                $this->warn('  [SKIP] ID Resign #' . $resign->id . ' - Data karyawan tidak ditemukan.');
                continue;
            }

            try {
                // 1. Update status karyawan menjadi resign
                $karyawan->id_status_karyawan = 4; // status resign
                $karyawan->tgl_resign = $resign->tgl_eff_resign;
                $karyawan->save();

                // 2. Hapus akun user beserta seluruh roles-nya
                $data_user = User::where('nik', $karyawan->nik);
                if ($data_user->count() > 0) {
                    $user = User::find($data_user->first()->id);
                    foreach ($user->roles as $role) {
                        $user->removeRole($role->id);
                    }
                    $user->delete();
                    $this->line('  [OK] NIK ' . $karyawan->nik . ' - ' . $karyawan->nama_karyawan . ' → Status resign + akun user dihapus.');
                } else {
                    $this->line('  [OK] NIK ' . $karyawan->nik . ' - ' . $karyawan->nama_karyawan . ' → Status resign (akun user tidak ditemukan).');
                }
            } catch (\Throwable $th) {
                $this->error('  [ERROR] NIK ' . $karyawan->nik . ' - ' . $th->getMessage());
            }
        }

        $this->info('[' . now() . '] Selesai.');
        return 0;
    }
}
