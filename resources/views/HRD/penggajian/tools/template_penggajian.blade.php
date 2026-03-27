<table>
    <thead>
        <tr>
            <th>id_karyawan</th>
            <th>bulan</th>
            <th>tahun</th>
            <th>nik</th>
            <th>nama_karyawan</th>
            <th>posisi</th>
            <th>id_departemen</th>
            <th>departemen</th>
            <th>status_karyawan</th>
            <th>tgl_masuk</th>
            <th>lama_bekerja</th>
            <th>gaji_pokok</th>
            <th>gaji_bpjs</th>
            <th>tunj_bpjs</th>
            <th>tunj_tetap</th>
            <th>hours_meter</th>
            <th>bonus</th>
            <th>lembur</th>
            <th>bpjsks_perusahaan</th>
            <th>bpjstk_jht_perusahaan</th>
            <th>bpjstk_jp_perusahaan</th>
            <th>bpjstk_jkm_perusahaan</th>
            <th>bpjstk_jkk_perusahaan</th>
            <th>gaji_bruto</th>
            <th>bpjsks_karyawan</th>
            <th>bpjstk_jht_karyawan</th>
            <th>bpjstk_jp_karyawan</th>
            <th>bpjstk_jkm_karyawan</th>
            <th>bpjstk_jkk_karyawan</th>
            <th>pot_sedekah</th>
            <th>pot_pkk</th>
            <th>pot_air</th>
            <th>pot_rumah</th>
            <th>pot_toko_alif</th>
            <th>total_potongan</th>
            <th>pot_tunj_perusahaan</th>
            <th>thp</th>
        </tr>
    </thead>
    <tbody>
        @foreach($list_karyawan as $list)
        @php
        $tunj_perusahaan = $list['tunj_bpjsks_perusahaan'] + $list['tunj_jht_perusahaan'] + $list['tunj_jp_perusahaan'] + $list['tunj_jkm_perusahaan'] + $list['tunj_jkk_perusahaan'];
        $pot_karyawan = $list['pot_bpjsks_karyawan'] + $list['pot_jht_karyawann'] + $list['pot_jp_karyawann'] + $list['pot_jkm_karyawann'] + $list['pot_jkk_karyawann'];
        $gaji_bruto = $tunj_perusahaan + $list['gaji_pokok'];
        $thp = $gaji_bruto - $pot_karyawan - $tunj_perusahaan;
        foreach($list_status as $key => $value)
        {
            $ket_tambahan = "";
            if($key==$list['id_status_karyawan'])
            {
                if($key==2) {
                    $ket_tambahan = " (PKWT)";
                }
                if($key==3) {
                    $ket_tambahan = " (PKWTT)";
                }
                $ket_status = $value.$ket_tambahan;
                break;
            }
        }
        $lama_bekerja = (!empty($list['tgl_masuk'])) ? App\Helpers\Hrdhelper::get_lama_kerja_karyawan($list['tgl_masuk']) : "0";
        @endphp
        <tr>
            <td>{{ $list['id'] }}</td>
            <td>{{ $bulan }}</td>
            <td>{{ $tahun }}</td>
            <td>{{ "'".$list['nik']}}</td>
            <td>{{ $list['nm_lengkap']}}</td>
            <td>{{ $list['nm_jabatan']}}</td>
            <td>{{ $list['id_departemen']}}</td>
            <td>{{ $list['nm_dept']}}</td>
            <td>{{ $ket_status }}</td>
            <td>{{ $list['tgl_masuk'] }}</td>
            <td>{{ $lama_bekerja }}</td>
            <td>{{ $list['gaji_pokok'] }}</td>
            <td>{{ $list['gaji_bpjs'] }}</td>
            <td>{{ $tunj_perusahaan }}</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>{{ $list['tunj_bpjsks_perusahaan'] }}</td>
            <td>{{ $list['tunj_jht_perusahaan'] }}</td>
            <td>{{ $list['tunj_jp_perusahaan'] }}</td>
            <td>{{ $list['tunj_jkm_perusahaan'] }}</td>
            <td>{{ $list['tunj_jkk_perusahaan'] }}</td>
            <td>{{ $gaji_bruto }}</td>
            <td>{{ $list['pot_bpjsks_karyawan'] }}</td>
            <td>{{ $list['pot_jht_karyawann'] }}</td>
            <td>{{ $list['pot_jp_karyawann'] }}</td>
            <td>{{ $list['pot_jkm_karyawann'] }}</td>
            <td>{{ $list['pot_jkk_karyawann'] }}</td>

            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>{{ $pot_karyawan }}</td>
            <td>{{ $tunj_perusahaan }}</td>
            <td>{{ $thp }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
