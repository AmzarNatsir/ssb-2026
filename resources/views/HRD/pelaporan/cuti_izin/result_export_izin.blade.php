<h2>DATA {{ $ket_kategori }} KARYAWAN</h2>
<p>Periode Bulan {{ $ket_bulan }} Tahun {{ $ket_tahun }}</p>
<table>
    <thead>
        <tr>
            <th rowspan="2">#</th>
            <th rowspan="2">Karyawan</th>
            <th rowspan="2">Pengajuan</th>
            <th rowspan="2">Jenis Izin</th>
            <th colspan="2">Jadwal Izin</th>
            <th rowspan="2">Jumlah Hari</th>
            <th rowspan="2">Keterangan</th>
        </tr>
        <tr>
            <th>Mulai</th>
            <th>Sampai</th>
        </tr>
    </thead>
    <tbody>
    @if(!empty($list_data))
        @php $nom=1; @endphp
        @foreach($list_data as $list)
        <tr>
            <td>{{ $nom }}</td>
            <td>{{ $list->profil_karyawan->nik }} - {{ $list->profil_karyawan->nm_lengkap }}<br>
            {{ (!empty($list->profil_karyawan->get_jabatan->nm_jabatan)) ? $list->profil_karyawan->get_jabatan->nm_jabatan : "" }}{{ (!empty($list->profil_karyawan->id_departemen)) ? " - ".$list->profil_karyawan->get_departemen->nm_dept : "" }}
            </td>
            <td>{{ date_format(date_create($list->tgl_pengajuan), 'd-m-Y') }}</td>
            <td>{{ $list->get_jenis_izin->nm_jenis_ci }}</td>
            <td>{{ date_format(date_create($list->tgl_awal), 'd-m-Y') }}</td>
            <td>{{ date_format(date_create($list->tgl_akhir), 'd-m-Y') }}</td>
            <td>{{ $list->jumlah_hari }}</td>
            <td>{{ $list->ket_izin }}</td>
        </tr>
        @php $nom++; @endphp
        @endforeach
    @endif
    </tbody>
</table>
