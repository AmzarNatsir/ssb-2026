<h2>DATA PERUBAHAN STATUS KARYAWAN</h2>
<p>Periode Bulan {{ $ket_bulan }} Tahun {{ $ket_tahun }}</p>
<table>
    <thead>
        <tr>
            <th rowspan="3">#</th>
            <th rowspan="3">Karyawan</th>
            <th rowspan="3">Surat</th>
            <th colspan="6">Perubahan Status</th>
        </tr>
        <tr>
            <th colspan="3">Status Lama</th>
            <th colspan="3">Status Baru</th>
        </tr>
        <tr>
            <th>Status</th>
            <th>Efektif</th>
            <th>Berakhir</th>
            <th>Status</th>
            <th>Efektif</th>
            <th>Berakhir</th>
        </tr>
    </thead>
    <tbody>
    @php $nom=1; @endphp
    @foreach($list_data as $list)
        <tr>
            <td>{{ $nom }}</td>
            <td>NIK : {{ $list->get_profil->nik }}<br>
            Nama : {{ $list->get_profil->nm_lengkap }}<br>
            Jabatan : {{ (!empty($list->get_profil->get_jabatan->nm_jabatan)) ? $list->get_profil->get_jabatan->nm_jabatan : "" }} ( {{ (!empty($list->get_profil->id_divisi)) ? "Divisi : ".$list->get_profil->get_divisi->nm_divisi.", " : "" }}{{ (!empty($list->get_profil->id_departemen)) ? "Dept. : ".$list->get_profil->get_departemen->nm_dept : "" }}{{ (!empty($list->get_profil->id_subdepartemen)) ? ", Sub Dept. : ".$list->get_profil->get_subdepartemen->nm_subdept : "" }} )
            </td>
            <td>Nomor : {{ $list->no_surat }}<br>Tanggal : {{ date_format(date_create($list->tgl_surat), "d-m-Y") }}</td>
            <td>{{ $list->get_status_karyawan($list->id_sts_lama) }}</td>
            <td>{{ date_format(date_create($list->tgl_eff_lama), 'd-m-Y') }}</td>
            <td>{{ date_format(date_create($list->tgl_akh_lama), 'd-m-Y') }}</td>
            <td>{{ $list->get_status_karyawan($list->id_sts_baru) }}</td>
            <td>{{ date_format(date_create($list->tgl_eff_baru), 'd-m-Y') }}</td>
            <td>@if(!empty($list->tgl_akh_baru)){{ date_format(date_create($list->tgl_akh_baru), 'd-m-Y') }} @endif</td>
        </tr>
    @php $nom++; @endphp
    @endforeach
    </tbody>    
</table>