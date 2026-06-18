<table border="1">
    <thead>
        <tr>
            <th colspan="11" style="text-align:center;">REKAP ABSENSI KARYAWAN</th>
        </tr>
        <tr>
            <th colspan="11" style="text-align:center;">Periode {{ $ket_bulan }} {{ $ket_tahun }} - {{ $ket_departemen }}</th>
        </tr>
        <tr>
            <th>#</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Departemen</th>
            <th>Hari Kerja</th>
            <th>Hadir</th>
            <th>Cuti</th>
            <th>Izin</th>
            <th>Perdis</th>
            <th>Training</th>
            <th>Alpa</th>
        </tr>
    </thead>
    <tbody>
    @php $nom=1; @endphp
    @forelse($list_data as $list)
        <tr>
            <td>{{ $nom }}</td>
            <td>{{ $list->nik }}</td>
            <td>{{ $list->nm_lengkap }}</td>
            <td>{{ $list->nm_dept }}</td>
            <td>{{ $list->hari_kerja }}</td>
            <td>{{ $list->hadir }}</td>
            <td>{{ $list->cuti }}</td>
            <td>{{ $list->izin }}</td>
            <td>{{ $list->perdis }}</td>
            <td>{{ $list->training }}</td>
            <td>{{ $list->alpa }}</td>
        </tr>
    @php $nom++; @endphp
    @empty
        <tr><td colspan="11" style="text-align:center;">Data Tidak Ditemukan !</td></tr>
    @endforelse
    </tbody>
</table>
