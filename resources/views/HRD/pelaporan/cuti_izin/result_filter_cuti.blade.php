<table id="user-list-table" class="table  table-hover table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info">
    <thead>
        <tr>
            <th scope="col" rowspan="2" style="width: 5%;">#</th>
            <th scope="col" rowspan="2" style="width: 20%;">Karyawan</th>
            <th scope="col" rowspan="2" style="width: 10%;">Pengajuan</th>
            <th scope="col" rowspan="2" style="width: 10%;">Jenis Cuti</th>
            <th scope="col" colspan="2" style="text-align: center;">Jadwal Cuti</th>
            <th scope="col" rowspan="2" style="width: 10%;">Jumlah Hari</th>
            <th scope="col" rowspan="2" style="width: 15%;">Keterangan</th>
            <th scope="col" rowspan="2" style="width: 15%;">Pengganti</th>
            <th scope="col" rowspan="2" style="width: 5%;"></th>
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
            <td>{{ $list->get_jenis_cuti->nm_jenis_ci }}</td>
            <td style="text-align:center">{{ date_format(date_create($list->tgl_awal), 'd-m-Y') }}</td>
            <td style="text-align:center">{{ date_format(date_create($list->tgl_akhir), 'd-m-Y') }}</td>
            <td style="text-align:center">{{ $list->jumlah_hari }}</td>
            <td>{{ $list->ket_cuti }}</td>
            <td>
            @if(!empty($list->id_pengganti))
            {{ $list->get_karyawan_pengganti->nm_lengkap }}
            @endif</td>
            <td>
                <div class="dropdown">
                    <span class="dropdown-toggle text-primary" id="dropdownMenuButton3" data-toggle="dropdown">
                    <i class="ri-more-2-fill"></i>
                    </span>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ url('hrd/pelaporan/cuti_izin/print_form_cuti', $list->id) }}"><i class="fa fa-print mr-2"></i>Print Form Cuti</a>
                        <a class="dropdown-item" href="{{ url('hrd/pelaporan/cuti_izin/print_surat_cuti', $list->id) }}"><i class="fa fa-print mr-2"></i>Print Surat Cuti</a>
                    </div>
                </div>
            </td>
        </tr>
        @php $nom++; @endphp
        @endforeach
    @endif
    </tbody>
</table>
