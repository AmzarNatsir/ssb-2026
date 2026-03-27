<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>NIK</th>
            <th>Nama Karyawan</th>
            <th>Posisi</th>
            <th>ID Finger</th>
        </tr>
    </thead>
    <tbody>
        @foreach($list_karyawan as $list)
        <tr>
            <td>{{ $list->id }}</td>
            <td>{{ "'".$list->nik}}</td>
            <td>{{ $list->nm_lengkap}}</td>
            <td>{{ $list->nm_jabatan}}</td>
            <td>{{ $list->id_finger }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
