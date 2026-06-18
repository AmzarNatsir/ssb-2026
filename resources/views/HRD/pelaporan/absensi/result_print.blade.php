@php
$fl_logo = App\Helpers\Hrdhelper::get_profil_perusahaan()->logo_perusahaan;
@endphp
<!DOCTYPE html>
 <html lang="en">
 <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>SSB | Smart System Base | HRD | Pelaporan | Rekap Absensi Karyawan</title>
<style>
@page {
    margin: 0px;
}
body {
    margin : 110px 50px;
    font-size: 12px;
    font-family: 'Poppins', sans-serif;
}
a {
    color: #fff;
    text-decoration: none;
}
table {
    font-size: 11px;
    font-family: 'Poppins', sans-serif;
}
tfoot tr td {
    font-weight: bold;
    font-size: x-small;
}
.page-break {
    page-break-after: always;
}
.information {
    background-color: #ffffff;
    color: #020202;
}
.information .logo {
    margin: 5px;
}
.information table {
    padding: 10px;
}
header { position: fixed; top: -10px; left: 0px; right: 0px; background-color: #03a9f4; height: 30px; }
.page-break:last-child { page-break-after: never; }
</style>
</head>
<header>
<div class="information">
    <table width="100%">
        <tr>
            <td align="left" style="width: 50%;">
            <img src="{{ url(Storage::url('logo_perusahaan/'.$fl_logo)) }}" alt="Logo" width="100px" width="auto" class="logo"/>
            </td>
            <td align="right" style="width: 50%;">
                <h2>PT. SUMBER SETIA BUDI</h2>
                    https://pt-ssb.co.id<br>
                    POMALA - KOLAKA - SULAWESI TENGGARA - INDONESIA
            </td>
        </tr>
        <tr><td colspan="2"><hr></td></tr>
    </table>
</div>
</header>
<main>
    <h3 class="card-title" style="text-align: center;">REKAP ABSENSI KARYAWAN</h3>
    <p><b>Periode Bulan {{ $ket_bulan }} Tahun {{ $ket_tahun }} &mdash; Departemen : {{ $ket_departemen }}</b></p>
    <table style="width: 100%; border-collapse:collapse" border="1">
        <thead>
            <tr>
                <th style="width: 4%;">#</th>
                <th style="width: 12%;">NIK</th>
                <th style="width: 24%;">Nama</th>
                <th style="width: 16%;">Departemen</th>
                <th style="width: 7%; text-align:center;">Hari Kerja</th>
                <th style="width: 7%; text-align:center;">Hadir</th>
                <th style="width: 6%; text-align:center;">Cuti</th>
                <th style="width: 6%; text-align:center;">Izin</th>
                <th style="width: 6%; text-align:center;">Perdis</th>
                <th style="width: 6%; text-align:center;">Training</th>
                <th style="width: 6%; text-align:center;">Alpa</th>
            </tr>
        </thead>
        <tbody>
        @php $nom=1; @endphp
        @forelse($list_data as $list)
            <tr>
                <td style="text-align:center;">{{ $nom }}</td>
                <td>{{ $list->nik }}</td>
                <td>{{ $list->nm_lengkap }}</td>
                <td>{{ $list->nm_dept }}</td>
                <td style="text-align:center;">{{ $list->hari_kerja }}</td>
                <td style="text-align:center;">{{ $list->hadir }}</td>
                <td style="text-align:center;">{{ $list->cuti }}</td>
                <td style="text-align:center;">{{ $list->izin }}</td>
                <td style="text-align:center;">{{ $list->perdis }}</td>
                <td style="text-align:center;">{{ $list->training }}</td>
                <td style="text-align:center;">{{ $list->alpa }}</td>
            </tr>
        @php $nom++; @endphp
        @empty
            <tr><td colspan="11" style="text-align:center;">Data Tidak Ditemukan !</td></tr>
        @endforelse
        </tbody>
    </table>
</main>
