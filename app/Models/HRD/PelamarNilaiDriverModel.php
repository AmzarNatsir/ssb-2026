<?php

namespace App\Models\HRD;

use Illuminate\Database\Eloquent\Model;

class PelamarNilaiDriverModel extends Model
{
    protected $table = 'hrd_recr_nilai_driver';
    protected $fillable = [
        'id_pelamar', 'nilai_2', 'nilai_3', 'nilai_4', 'nilai_5', 'nilai_6', 'nilai_7', 'nilai_8', 'nilai_9', 'nilai_10', 'nilai_11', 'nilai_12', 'nilai_13', 'nilai_14', 'nilai_15', 'nilai_16', 'nilai_17', 'nilai_18', 'nilai_19', 'catatan_1', 'catatan_2', 'catatan_3', 'catatan_4', 'catatan_5', 'catatan_6', 'catatan_7', 'catatan_8', 'catatan_9', 'catatan_10', 'catatan_11', 'catatan_12', 'catatan_13', 'catatan_14', 'catatan_15', 'catatan_16', 'catatan_17', 'catatan_18', 'catatan_19', 'hasil', 'komentar', 'user_id'
    ];

    public function get_profil_pelamar()
    {
        return $this->belongsTo('App\Models\HRD\PelamarModel', 'id_pelamar', 'id');
    }
}
