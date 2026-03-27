@if(!empty($list_izin))
    @php $nom=1; @endphp
    @foreach($list_izin as $l_izin)
    <tr>
        <td>{{ $nom }}</td>
        <td>{{ date_format(date_create($l_izin->tgl_pengajuan), 'd-m-Y') }}</td>
        <td>{{ $l_izin->get_jenis_izin->nm_jenis_ci }}</td>
        <td>{{ date_format(date_create($l_izin->tgl_awal), 'd-m-Y') }}</td>
        <td>{{ date_format(date_create($l_izin->tgl_akhir), 'd-m-Y') }}</td>
        <td>{{ $l_izin->jumlah_hari }}</td>
        <td>{{ $l_izin->ket_izin }}</td>
    </tr>
    @php $nom++; @endphp
    @endforeach
@endif