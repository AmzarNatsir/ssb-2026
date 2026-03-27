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
            <th>gaji_pokok</th>
            <th>bonus</th>
            <th>lembur</th>
            <th>total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($list_karyawan as $list)
        <tr>
            <td>{{ $list['id'] }}</td>
            <td>{{ $bulan }}</td>
            <td>{{ $tahun }}</td>
            <td>{{ "'".$list['nik']}}</td>
            <td>{{ $list['nm_lengkap']}}</td>
            <td>{{ $list['nm_jabatan']}}</td>
            <td>{{ $list['id_departemen']}}</td>
            <td>{{ $list['nm_dept']}}</td>
            <td>{{ $list['gaji_pokok'] }}</td>
            <td>0</td>
            <td>0</td>
            <td>{{ $list['gaji_pokok'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
