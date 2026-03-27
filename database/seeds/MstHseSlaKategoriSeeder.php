<?php

use Illuminate\Database\Seeder;
use App\Models\Hse\MstHseSlaKategori;

class MstHseSlaKategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dump = array(
            array(
                "name" => "Category A",
                "label" => "alat pelindung diri",
                "items" => array(
                    array(
                        "label" => "mata & wajah",
                        "value" => 1,
                    ),
                    array(
                        "label" => "telinga",
                        "value" => 2,
                    ),
                    array(
                        "label" => "kepala",
                        "value" => 3,
                    ),
                    array(
                        "label" => "tangan & lengan",
                        "value" => 4,
                    ),
                    array(
                        "label" => "kaki",
                        "value" => 5,
                    ),
                    array(
                        "label" => "pernafasan",
                        "value" => 6,
                    ),
                    array(
                        "label" => "dada/badan",
                        "value" => 7,
                    ),
                ),
                "is_active" => 1,
            ),
            array(
                "name" => "Category B",
                "label" => "posisi orang",
                "items" => array(
                    array(

                        "label" => "tertubruk pada",
                        "value" => 1,
                    ),
                    array(

                        "label" => "ditubruk oleh",
                        "value" => 2,
                    ),
                    array(
                        "label" => "terjepit",
                        "value" => 3,
                    ),
                    array(
                        "label" => "terjatuh",
                        "value" => 4,
                    ),
                    array(
                        "label" => "temp ekstrim",
                        "value" => 5,
                    ),
                    array(
                        "label" => "arus listrik",
                        "value" => 6,
                    ),
                    array(
                        "label" => "terhisap",
                        "value" => 7,
                    ),
                    array(
                        "label" => "terhirup",
                        "value" => 8,
                    ),
                    array(
                        "label" => "tenggelam",
                        "value" => 9,
                    ),
                ),
                "is_active" => 1,
            ),
            array(
                "name" => "Category C",
                "label" => "ergonomic",
                "items" => array(
                    array(
                        "label" => "postur/bentuk",
                        "value" => 1,
                    ),
                    array(
                        "label" => "tipe dan jumlah gerakan",
                        "value" => 2,
                    ),
                    array(
                        "label" => "tempat angkat/pegangan",
                        "value" => 3,
                    ),
                    array(
                        "label" => "disain tempat kerja",
                        "value" => 4,
                    ),
                    array(
                        "label" => "alat dan pegangan",
                        "value" => 5,
                    ),
                    array(
                        "label" => "getaran",
                        "value" => 6,
                    ),
                    array(
                        "label" => "temperatur (suhu)",
                        "value" => 7,
                    ),
                    array(
                        "label" => "penerangan",
                        "value" => 8,
                    ),
                    array(
                        "label" => "kebisingan",
                        "value" => 9,
                    ),
                ),
                "is_active" => 1,
            ),
            array(
                "name" => "Category D",
                "label" => "peralatan",
                "items" => array(
                    array(
                        "label" => "sesuai",
                        "value" => 1,
                    ),
                    array(
                        "label" => "aman dipakai",
                        "value" => 2,
                    ),
                ),
                "is_active" => 1,
            ),
            array(
                "name" => "Category E",
                "label" => "prosedur",
                "items" => array(
                    array(
                        "label" => "apakah standar sesuai pekerjaan?",
                        "value" => 1,
                    ),
                    array(
                        "label" => "apakah ada standar kerjanya?",
                        "value" => 2,
                    ),
                    array(
                        "label" => "apakah standar kerja terbaru?",
                        "value" => 3,
                    ),
                ),
                "is_active" => 1,
            ),
            array(
                "name" => "Category F",
                "label" => "tempat kerja",
                "items" => array(
                    array(
                        "label" => "kebersihan",
                        "value" => 1,
                    ),
                    array(
                        "label" => "keteraturan",
                        "value" => 2,
                    ),
                ),
                "is_active" => 1,
            ),
        );

        DB:: table('mst_hse_sla_kategori')->truncate();

        foreach($dump as $value){
            if(MstHseSlaKategori::where('name', '<>', $value['name'])){
                MstHseSlaKategori::create([
                    'name' => $value['name'],
                    'label' => $value['label'],
                    'items' => $value['items'],
                    'is_active' => $value['is_active'],
                ]);
            }
        }
    }
}
