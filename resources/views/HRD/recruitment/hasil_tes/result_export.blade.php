<h2>REKAPITULASI HASIL TEST</h2>
<p>Departemen : {{ $departemen->nm_dept }}</p>
<p>Jabatan : {{ $jabatan->nm_jabatan }}</p>
<table>
    <thead>
        <tr>
            <td rowspan="3">NO</td>
            <td rowspan="3">NAMA</td>
            <td rowspan="3">USIA</td>
            <td rowspan="3">PENDIDIKAN TERAKHIR</td>
            <td colspan="4">HASIL TES</td>
            <td rowspan="3">TOTAL SKOR</td>
            <td rowspan="3">RANK</td>
        </tr>
        <tr>
            <td colspan="2">PSIKOTES</td>
            <td colspan="2">WAWANCARA</td>
        </tr>
        <tr>
            <td>NILAI</td>
            <td>KETERANGAN</td>
            <td>NILAI</td>
            <td>KETERANGAN</td>
        </tr>
    </thead>
    <tbody>
        @php($nom=1)
        @foreach ($list as $list)
        <tr>
            <td>{{ $nom }}</td>
            <td>{{ $list->nama_lengkap }}</td>
            <td>{{ \App\Helpers\Hrdhelper::get_umur_karyawan($list->tanggal_lahir) }}</td>
            <td>{{ $list->get_pendidikan_akhir($list->id_jenjang) }}</td>
            <td>{{ $list->psikotes_nilai }}</td>
            <td>{{ $list->psikotes_ket }}</td>
            <td>{{ $list->wawancara_nilai }}</td>
            <td>{{ $list->wawancara_ket }}</td>
            <td>{{ $list->total_skor }}</td>
            <td>{{ $nom }}</td>
        </tr>
        @php($nom++)
        @endforeach
    </tbody>
</table>
