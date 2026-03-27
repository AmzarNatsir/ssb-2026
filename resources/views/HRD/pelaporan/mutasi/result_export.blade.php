<h2>DATA MUTASI KARYAWAN</h2>
<p>Periode Bulan {{ $ket_bulan }} Tahun {{ $ket_tahun }}</p>
<table>
    <thead>
        <tr>
            <th rowspan="2">#</th>
            <th rowspan="2">Karyawan</th>
            <th rowspan="2">Surat</th>
            <th colspan="2">Penempatan Posisi/Jabatan</th>
        </tr>
        <tr>
            <th>Posisi/Jabatan Lama</th>
            <th>Posisi/Jabatan Baru</th>
        </tr>
    </thead>
    <tbody>
    @php $nom=1; @endphp
    @foreach($list_data as $list)
        <tr>
            <td>{{ $nom }}</td>
            <td>
            NIK : {{ $list->get_profil->nik }}<br>
            Nama : {{ $list->get_profil->nm_lengkap }}<br>
            Jabatan : {{ (!empty($list->get_profil->get_jabatan->nm_jabatan)) ? $list->get_profil->get_jabatan->nm_jabatan : "" }} ( {{ (!empty($list->get_profil->id_divisi)) ? "Divisi : ".$list->get_profil->get_divisi->nm_divisi.", " : "" }}{{ (!empty($list->get_profil->id_departemen)) ? "Dept. : ".$list->get_profil->get_departemen->nm_dept : "" }}{{ (!empty($list->get_profil->id_subdepartemen)) ? ", Sub Dept. : ".$list->get_profil->get_subdepartemen->nm_subdept : "" }} )
            </td>
            <td>Nomor : {{ $list->no_surat }}<br>Tanggal : {{ date_format(date_create($list->tgl_surat), "d-m-Y") }}</td>
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
    </tbody>    
</table>