<h2>DATA SURAT PERINGATAN (SP) KARYAWAN</h2>
<p>Periode {{ ($ket_bulan=="0") ? "" : $ket_bulan }} {{ $ket_tahun }}</p>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Karyawan</th>
            <th>Surat</th>
            <th>Tingkatan Sanksi</th>
            <th>Uraian Pelanggaran</th>
        </tr>
    </thead>
    <tbody>
    @if(!empty($list_data))
        @php $nom=1; @endphp
        @foreach($list_data as $list)
        <tr>
            <td>{{ $nom }}</td>
            <td>
            {{ $list->profil_karyawan->nik }} - {{ $list->profil_karyawan->nm_lengkap }}<br>
            {{ (!empty($list->profil_karyawan->get_jabatan->nm_jabatan)) ? $list->profil_karyawan->get_jabatan->nm_jabatan : "" }} - {{ (!empty($list->profil_karyawan->id_departemen)) ? $list->profil_karyawan->get_departemen->nm_dept : "" }}
            </td>
            <td>Nomor : {{ $list->no_sp }}<br>Tanggal : {{ date_format(date_create($list->tgl_sp), 'd-m-Y') }}</td>
            <td>{{ $list->get_master_jenis_sp_disetujui->nm_jenis_sp }}</td>
            <td>{{ $list->uraian_pelanggaran }}</td>
        </tr>
        @php $nom++; @endphp
        @endforeach
    @endif
    </tbody>
</table>
