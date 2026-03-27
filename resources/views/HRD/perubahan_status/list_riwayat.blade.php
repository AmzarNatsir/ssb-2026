@php $nom=1; @endphp
@foreach($list_result as $list)
    <tr>
        <td>{{ $nom }}</td>
        <td>{{ $list->no_surat }}<br>{{ date_format(date_create($list->tgl_surat), "d-m-Y") }}</td>
        <td>{{ $list->get_status_karyawan($list->id_sts_lama) }}</td>
        <td>{{ date_format(date_create($list->tgl_eff_lama), 'd-m-Y') }}</td>
        <td>{{ date_format(date_create($list->tgl_akh_lama), 'd-m-Y') }}</td>
        <td>{{ $list->get_status_karyawan($list->id_sts_baru) }}</td>
        <td>{{ date_format(date_create($list->tgl_eff_baru), 'd-m-Y') }}</td>
        <td>@if(!empty($list->tgl_akh_baru)){{ date_format(date_create($list->tgl_akh_baru), 'd-m-Y') }} @endif</td>
    </tr>
@php $nom++; @endphp
@endforeach