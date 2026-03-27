@if(!empty($list_perdis))
    @php $nom=1; @endphp
    @foreach($list_perdis as $list)
    <tr>
        <td>{{ $nom }}</td>
        <td>{{ $list->no_perdis }} / {{ date_format(date_create($list->tgl_perdis), 'd-m-Y') }}</td>
        <td>{{ $list->maksud_tujuan }}</td>
        <td>{{ date_format(date_create($list->tgl_berangkat), 'd-m-Y') }}</td>
        <td>{{ date_format(date_create($list->tgl_kembali), 'd-m-Y') }}</td>
        <td>{{ $list->get_master_fasilitas_perdis->nm_fasilitas }}</td>
        <td>{{ number_format($list->id_uangsaku, 0, ",", ".") }}</td>
        <td>{{ $list->ket_perdis }}</td>
    </tr>
    @php $nom++; @endphp
    @endforeach
@endif