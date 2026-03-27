@if(!empty($list_cuti))
    @php $nom=1; @endphp
    @foreach($list_cuti as $l_cuti)
    <tr>
        <td>{{ $nom }}</td>
        <td>{{ date_format(date_create($l_cuti->tgl_pengajuan), 'd-m-Y') }}</td>
        <td>{{ $l_cuti->get_jenis_cuti->nm_jenis_ci }}</td>
        <td>{{ date_format(date_create($l_cuti->tgl_awal), 'd-m-Y') }}</td>
        <td>{{ date_format(date_create($l_cuti->tgl_akhir), 'd-m-Y') }}</td>
        <td>{{ $l_cuti->jumlah_hari }}</td>
        <td>{{ $l_cuti->ket_cuti }}</td>
        <td>
        @if(!empty($l_cuti->id_pengganti))
        {{ $l_cuti->get_karyawan_pengganti->nm_lengkap }}
        @endif</td>
    </tr>
    @php $nom++; @endphp
    @endforeach
@endif
