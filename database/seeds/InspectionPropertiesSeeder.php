<?php

use Illuminate\Database\Seeder;
use App\Models\Hse\InspectionProperties;

class InspectionPropertiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        

        $dump = array (
          
          array (
            'inspection_item_id' => '1',
            'inspection_properties_input_id' => '4',
            'name' => 'Tanggal',
            'dataset' => 'null',
            'mandatory' => true            
          ),
          
          array (
            'inspection_item_id' => '1',
            'inspection_properties_input_id' => '5',
            'name' => 'HM awal',
            'dataset' => 'null',
            'mandatory' => true            
          ),
          
          array (
            'inspection_item_id' => '1',
            'inspection_properties_input_id' => '5',
            'name' => 'HM akhir',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '1',
            'inspection_properties_input_id' => '5',
            'name' => 'KM awal',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '1',
            'inspection_properties_input_id' => '5',
            'name' => 'KM akhir',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '2',
            'inspection_properties_input_id' => '3',
            'name' => 'periksa kebocoran',
            'dataset' => 'null',
            'mandatory' => true            
          ),
          
          array (
            'inspection_item_id' => '2',
            'inspection_properties_input_id' => '3',
            'name' => 'kondisi ban',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '2',
            'inspection_properties_input_id' => '3',
            'name' => 'level oli mesin',
            'dataset' => 'null',
            'mandatory' => true            
          ),
          
          array (
            'inspection_item_id' => '2',
            'inspection_properties_input_id' => '3',
            'name' => 'level oli transmisi',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '2',
            'inspection_properties_input_id' => '3',
            'name' => 'level oli hydraulic',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '2',
            'inspection_properties_input_id' => '3',
            'name' => 'level oli steering',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '2',
            'inspection_properties_input_id' => '3',
            'name' => 'level air radiator',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '2',
            'inspection_properties_input_id' => '3',
            'name' => 'batery',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '2',
            'inspection_properties_input_id' => '3',
            'name' => 'indicator saringan udara',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '2',
            'inspection_properties_input_id' => '3',
            'name' => 'level bahan bakar',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '2',
            'inspection_properties_input_id' => '3',
            'name' => 'v-belt',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '2',
            'inspection_properties_input_id' => '3',
            'name' => 'baut-baut longgar',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '2',
            'inspection_properties_input_id' => '3',
            'name' => 'buang air dalam tangki solar',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '2',
            'inspection_properties_input_id' => '3',
            'name' => 'periksa fungsi steering',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '2',
            'inspection_properties_input_id' => '3',
            'name' => 'segitiga pengaman',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '2',
            'inspection_properties_input_id' => '3',
            'name' => 'periksa tabung pemadam',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '2',
            'inspection_properties_input_id' => '3',
            'name' => 'kotak p3k',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '2',
            'inspection_properties_input_id' => '1',
            'name' => 'keterangan',
            'dataset' => 'null',
            'mandatory' => false
          ),
          
          array (
            'inspection_item_id' => '3',
            'inspection_properties_input_id' => '3',
            'name' => 'fungsi gauge/ems/cmns',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '3',
            'inspection_properties_input_id' => '3',
            'name' => 'rpm spidometer',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '3',
            'inspection_properties_input_id' => '3',
            'name' => 'wiper',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '3',
            'inspection_properties_input_id' => '3',
            'name' => 'fungsi alarm mundur',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '3',
            'inspection_properties_input_id' => '3',
            'name' => 'klakson',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '3',
            'inspection_properties_input_id' => '3',
            'name' => 'lampu weser',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '3',
            'inspection_properties_input_id' => '3',
            'name' => 'lampu dekat',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '3',
            'inspection_properties_input_id' => '3',
            'name' => 'lampu jauh',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '3',
            'inspection_properties_input_id' => '3',
            'name' => 'lampu rem',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '3',
            'inspection_properties_input_id' => '3',
            'name' => 'lampu mundur',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '3',
            'inspection_properties_input_id' => '3',
            'name' => 'lampu rotary',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '3',
            'inspection_properties_input_id' => '3',
            'name' => 'suhu mesin',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '3',
            'inspection_properties_input_id' => '3',
            'name' => 'periksa safety belt',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '3',
            'inspection_properties_input_id' => '3',
            'name' => 'perksa fungsi rem',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '3',
            'inspection_properties_input_id' => '3',
            'name' => 'periksa fungsi steering',
            'dataset' => 'null',
            'mandatory' => true
          ),
          
          array (
            'inspection_item_id' => '3',
            'inspection_properties_input_id' => '1',
            'name' => 'keterangan',
            'dataset' => 'null',
            'mandatory' => false            
          ),
          
          array (
            'inspection_item_id' => '4',
            'inspection_properties_input_id' => '1',
            'name' => 'pemeriksaan 1',
            'dataset' => 'null',
            'mandatory' => false            
          ),
          
          array (
            'inspection_item_id' => '4',
            'inspection_properties_input_id' => '1',
            'name' => 'pemeriksaan 2',
            'dataset' => 'null',
            'mandatory' => false
          ),
          
          array (
            'inspection_item_id' => '4',
            'inspection_properties_input_id' => '1',
            'name' => 'pemeriksaan 3',
            'dataset' => 'null',
            'mandatory' => false
          ),
          
          array (
            'inspection_item_id' => '4',
            'inspection_properties_input_id' => '1',
            'name' => 'pemeriksaan 4',
            'dataset' => 'null',
            'mandatory' => false
          ),
          
          array (
            'inspection_item_id' => '4',
            'inspection_properties_input_id' => '1',
            'name' => 'pemeriksaan 5',
            'dataset' => 'null',
            'mandatory' => false
          ),
          
          array (
            'inspection_item_id' => '4',
            'inspection_properties_input_id' => '1',
            'name' => 'pemeriksaan 6',
            'dataset' => 'null',
            'mandatory' => false
          ),
          
          array (
            'inspection_item_id' => '4',
            'inspection_properties_input_id' => '1',
            'name' => 'keterangan',
            'dataset' => 'null',
            'mandatory' => false
          ),
        );

    DB:: table('inspection_properties')->truncate();

		foreach ($dump as $value) {
			if (!InspectionProperties::where('name', '=', $value['name'])->exists()) {
                InspectionProperties::create([
                    'inspection_item_id' => $value['inspection_item_id'],
                    'inspection_properties_input_id' => $value['inspection_properties_input_id'],
                    'name' => $value['name'],
                    'mandatory' => $value['mandatory']
			    ]);
			}
		}
    }
}
