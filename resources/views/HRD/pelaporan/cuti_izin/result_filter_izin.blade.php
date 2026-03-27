<table id="user-list-table" class="table  table-hover table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info">
    <thead>
        <tr>
            <th scope="col" rowspan="2" style="width: 5%;">#</th>
            <th scope="col" rowspan="2" style="width: 35%;">Karyawan</th>
            <th scope="col" rowspan="2" style="width: 10%;">Pengajuan</th>
            <th scope="col" rowspan="2" style="width: 10%;">Jenis Izin</th>
            <th scope="col" colspan="2" style="text-align: center;">Jadwal Izin</th>
            <th scope="col" rowspan="2" style="width: 10%;">Jumlah Hari</th>
            <th scope="col" rowspan="2" style="width: 20%;">Keterangan</th>
        </tr>
        <tr>
            <th style="text-align: center; width: 5%;">Mulai</th>
            <th style="text-align: center; width: 5%;">Sampai</th>
        </tr>
    </thead>
    <tbody>
    @if(!empty($list_data))
        @php $nom=1; @endphp
        @foreach($list_data as $list)
        <tr>
            <td style="text-align:center">{{ $nom }}</td>
            <td>{{ $list->profil_karyawan->nik }} - {{ $list->profil_karyawan->nm_lengkap }}<br>
            {{ (!empty($list->profil_karyawan->get_jabatan->nm_jabatan)) ? $list->profil_karyawan->get_jabatan->nm_jabatan : "" }}{{ (!empty($list->profil_karyawan->id_departemen)) ? " - ".$list->profil_karyawan->get_departemen->nm_dept : "" }}
            </td>
            <td style="text-align:center">{{ date_format(date_create($list->tgl_pengajuan), 'd-m-Y') }}</td>
            <td>{{ $list->get_jenis_izin->nm_jenis_ci }}</td>
            <td style="text-align:center">{{ date_format(date_create($list->tgl_awal), 'd-m-Y') }}</td>
            <td style="text-align:center">{{ date_format(date_create($list->tgl_akhir), 'd-m-Y') }}</td>
            <td style="text-align:center">{{ $list->jumlah_hari }}</td>
            <td>{{ $list->ket_izin }}</td>
        </tr>
        @php $nom++; @endphp
        @endforeach
    @endif
    </tbody>
</table>
