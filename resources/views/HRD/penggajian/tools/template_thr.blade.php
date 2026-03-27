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
            <th>tunj_tetap</th>
            <th>total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($list_karyawan as $list)
        @php
        foreach($list_status as $key => $value)
        {
            if($key==$list['id_status_karyawan'])
            {
                $ket_status = $value;
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
            <td>0</td>
            <td>{{ $list['gaji_pokok'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
