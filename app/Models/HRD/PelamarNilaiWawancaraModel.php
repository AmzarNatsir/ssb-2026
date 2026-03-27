<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class PelamarNilaiWawancaraModel extends Model
{
    protected $table = 'hrd_recr_nilai_wawancara';
    protected $fillable = [
        'id_pelamar', 'kriteria_1', 'kriteria_2', 'kriteria_3', 'kriteria_4', 'kriteria_5', 'kriteria_6', 'kriteria_7', 'kriteria_8', 'kriteria_9', 'kriteria_10', 'kriteria_11', 'kriteria_12', 'kriteria_13', 'kriteria_14', 'kriteria_15', 'total_rating', 'hasil', 'saran_komentar', 'user_id', 'keterangan_1', 'keterangan_2', 'keterangan_3', 'keterangan_4', 'keterangan_5', 'keterangan_6', 'keterangan_7', 'keterangan_8', 'keterangan_9', 'keterangan_10', 'keterangan_11', 'keterangan_12', 'keterangan_13', 'keterangan_14', 'keterangan_15'
    ];

    public function get_profil_pelamar()
    {
        return $this->belongsTo('App\Models\HRD\PelamarModel', 'id_pelamar', 'id');
    }
}
