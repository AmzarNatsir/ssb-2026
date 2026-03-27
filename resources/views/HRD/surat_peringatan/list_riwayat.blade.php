@if(!empty($list_result))
    @php $nom=1; @endphp
    @foreach($list_result as $list)
    <tr>
        <td>{{ $nom }}</td>
        <td>{{ $list->no_sp }}<br>{{ date_format(date_create($list->tgl_sp), 'd-m-Y') }}</td>
        <td>{{ $list->uraian_pelanggaran }}</td>
        <td>{{ $list->get_master_jenis_sp_disetujui->nm_jenis_sp }}</td>
    </tr>
    @php $nom++; @endphp
    @endforeach
@endif