<table id="user-list-table" class="table  table-hover table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info">
    <thead>
        <tr>
            <th scope="col" style="width: 5%;">#</th>
            <th scope="col" style="width: 25%">Karyawan</th>
            <th scope="col" style="width: 20%">Surat</th>
            <th scope="col" style="width: 30%;">Uraian Pelanggaran</th>
            <th scope="col" style="width: 20%;">Tingkatan Sanksi</th>
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
            <td>Nomor : {{ $list->no_sp }}<br>Tanggal : {{ date_format(date_create($list->tgl_sp), 'd-m-Y') }}</td>
            <td>{{ $list->uraian_pelanggaran }}</td>
            <td>{{ $list->get_master_jenis_sp_disetujui->nm_jenis_sp }}</td>
        </tr>
        @php $nom++; @endphp
        @endforeach
    @endif
    </tbody>
</table>
