<h2>DAFTAR KARYAWAN</h2>
<p>Departemen : {{ $ket_departemen }}</p>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>NIK</th>
            <th>Nama Karyawan</th>
            <th>Gender</th>
            <th>Alamat/No.Telepon</th>
            <th>Jabatan</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @php $nom=1; @endphp
        @foreach($list_karyawan as $list)
        <tr>
            <td>{{ $nom }}</td>
            <td>{{ $list->nik}}</td>
            <td>{{ $list->nm_lengkap}}</td>
            <td>{{ ($list->jenkel==1)? "Laki-Laki" : "Perempuan" }}</td>
            <td>{{ $list->alamat."/".$list->notelp}}</td>
            <td>{{ (empty($list->get_jabatan->nm_jabatan)) ? "" : $list->get_jabatan->nm_jabatan }} - {{ (empty($list->get_departemen->nm_dept)) ? "" : $list->get_departemen->nm_dept }}</td>
            <td>{{ $list->get_status_karyawan($list->id_status_karyawan) }}</td>
        </tr>
        @php $nom++; @endphp
        @endforeach
    </tbody>
</table>
