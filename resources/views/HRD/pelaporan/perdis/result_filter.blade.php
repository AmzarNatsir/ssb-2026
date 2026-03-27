<table id="user-list-table" class="table  table-hover table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info" style="font-size: 12px">
    <thead>
        <tr>
            <th scope="col" rowspan="2" style="width: 5%;">#</th>
            <th scope="col" rowspan="2">Karyawan</th>
            <th scope="col" rowspan="2" style="width: 15%">Jabatan/Departemen</th>
            <th scope="col" rowspan="2" style="width: 15%">Maksud dan Tujuan</th>
            <th scope="col" rowspan="2" style="width: 10%">Lokasi</th>
            <th scope="col" colspan="2" style="text-align: center;">Tanggal Perjalanan</th>
            <th scope="col" rowspan="2" style="width: 10%;">Total Biaya</th>
            <th scope="col" rowspan="2" style="width: 15%;">Keterangan</th>
        </tr>
        <tr>
            <th style="text-align: center; width: 5%;">Berangkat</th>
            <th style="text-align: center; width: 5%;">Kembali</th>
        </tr>
    </thead>
    <tbody>
    @if(!empty($list_data))
        @php $nom=1; @endphp
        @foreach($list_data as $list)
        <tr>
            <td>{{ $nom }}</td>
            <td>{{ $list->get_profil->nik }} / {{ $list->get_profil->nm_lengkap }}</td>
            <td>{{ (!empty($list->get_profil->get_jabatan->nm_jabatan)) ? $list->get_profil->get_jabatan->nm_jabatan : "" }}  {{ (!empty($list->get_profil->id_departemen)) ? " / ".$list->get_profil->get_departemen->nm_dept : "" }}</td>
            <td>{{ $list->maksud_tujuan }}</td>
            <td>{{ $list->tujuan }}</td>
            <td>{{ date_format(date_create($list->tgl_berangkat), 'd-m-Y') }}</td>
            <td>{{ date_format(date_create($list->tgl_kembali), 'd-m-Y') }}</td>
            <td>Rp. {{ number_format($list->get_fasilitas->sum('sub_total'), 0) }}</td>
            <td>{{ $list->no_perdis }} - {{ date_format(date_create($list->tgl_perdis), 'd-m-Y') }}</td>
        </tr>
        @php $nom++; @endphp
        @endforeach
    @endif
    </tbody>
</table>