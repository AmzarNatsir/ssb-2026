<table class="table list_item" style="width: 100%; height: auto">
    <thead>
        <th style="width: 3%">#</th>
        <th style="width: 10%">NIK</th>
        <th>Nama Karyawan</th>
        <th style="width: 25%">Departemen</th>
        <th style="width: 25%">Jabatan</th>
    </thead>
    <tbody>
        @if($peserta->count() > 0)
        @foreach($peserta as $list)
        <tr>
            <td><button type="button" title="Hapus Baris" class="btn btn-danger btn-sm waves-effect waves-light" onclick="delete_item(this)" id="{{ $list->id }}"><i class="fa fa-minus"></i></button></td>
            <td>{{ $list->get_karyawan->nik }}</td>
            <td>{{ $list->get_karyawan->nm_lengkap }}</td>
            <td>{{ (empty($list->get_karyawan->id_departemen)) ? "" : $list->get_karyawan->get_departemen->nm_dept }}</td>
            <td>{{ (empty($list->get_karyawan->id_jabatan)) ? "" : $list->get_karyawan->get_jabatan->nm_jabatan }}</td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
