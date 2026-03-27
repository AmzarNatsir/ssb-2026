@php $nom=1; @endphp
@foreach($list_result as $list)
    <tr>
        <td>{{ $nom }}</td>
        <td>{{ $list->no_surat }}<br>{{ date_format(date_create($list->tgl_surat), "d-m-Y") }}</td>
        <td>
            Divisi : {{ (!empty($list->id_divisi_lm)) ? $list->get_divisi_lama->nm_divisi : "" }}<br>
            Departemen : {{ (!empty($list->id_dept_lm)) ? $list->get_dept_lama->nm_dept : "" }}<br>
            Sub Departemen : {{ (!empty($list->id_subdept_lm)) ? $list->get_subdept_lama->nm_subdept : "" }}<br>
            Jabatan : {{ $list->get_jabatan_lama->nm_jabatan }}<br>
            Efektif Tanggal : {{ date_format(date_create($list->tgl_efektif_lm), 'd-m-Y') }}
        </td>
        <td>
            Divisi : {{ (!empty($list->id_divisi_br)) ? $list->get_divisi_baru->nm_divisi : "" }}<br>
            Departemen : {{ (!empty($list->id_dept_br)) ? $list->get_dept_baru->nm_dept : "" }}<br>
            Sub Departemen : {{ (!empty($list->id_subdept_br)) ? $list->get_subdept_baru->nm_subdept : "" }}<br>
            Jabatan : {{ $list->get_jabatan_baru->nm_jabatan }}<br>
            Efektif Tanggal : {{ date_format(date_create($list->tgl_efektif_br), 'd-m-Y') }}
        </td>
    </tr>
@php $nom++; @endphp
@endforeach