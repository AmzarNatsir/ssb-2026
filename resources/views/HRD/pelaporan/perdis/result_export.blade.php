<h2>DATA PERJALANAN DINAS KARYAWAN</h2>
<p>Periode Bulan {{ $ket_bulan }} Tahun {{ $ket_tahun }}</p>
<table>
    <thead>
        <tr>
            <th rowspan="2">#</th>
            <th rowspan="2">Karyawan</th>
            <th rowspan="2">Jabatan/Departemen</th>
            <th rowspan="2">Maksud dan Tujuan</th>
            <th rowspan="2">Lokasi</th>
            <th colspan="2">Tanggal Perjalanan</th>
            <th rowspan="2">Total Biaya</th>
            <th rowspan="2">Keterangan</th>
        </tr>
        <tr>
            <th>Berangkat</th>
            <th>Kembali</th>
        </tr>
    </thead>
    <tbody>
    @if(!empty($list_data))
        @php $nom=1; @endphp
        @foreach($list_data as $list)
        <tr>
            <td>{{ $nom }}</td>
            <td>{{ $list->get_profil->nik }} / {{ $list->get_profil->nm_lengkap }}</td>
            <td>{{ (!empty($list->get_profil->get_jabatan->nm_jabatan)) ? $list->get_profil->get_jabatan->nm_jabatan : "" }} {{ (!empty($list->get_profil->id_departemen)) ? " / ".$list->get_profil->get_departemen->nm_dept : "" }}
            </td>
            <td>{{ $list->maksud_tujuan }}</td>
            <td>{{ $list->lokasi }}</td>
            <td>{{ date_format(date_create($list->tgl_berangkat), 'd-m-Y') }}</td>
            <td>{{ date_format(date_create($list->tgl_kembali), 'd-m-Y') }}</td>
            <td>{{ number_format($list->get_fasilitas->sum('sub_total'), 0) }}</td>
            <td>{{ $list->no_perdis }} / {{ date_format(date_create($list->tgl_perdis), 'd-m-Y') }}</td>
        </tr>
        @php $nom++; @endphp
        @endforeach
    @endif
    </tbody>    
</table>