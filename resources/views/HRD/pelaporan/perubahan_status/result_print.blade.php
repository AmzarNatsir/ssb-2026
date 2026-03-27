@php
$fl_logo = App\Helpers\Hrdhelper::get_profil_perusahaan()->logo_perusahaan;
@endphp
<!DOCTYPE html>
 <html lang="en">
 <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>SSB | Smart System Base | HRD | Pelaporan | Perubahan Status Karyawan</title>
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
/*
footer { position: fixed; bottom: -60px; left: 0px; right: 0px; background-color: #03a9f4; height: 25px; }
*/
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
                {{-- <pre> --}}
                    https://pt-ssb.co.id<br>
                    POMALA - KOLAKA - SULAWESI TENGGARA - INDONESIA
                {{-- </pre> --}}
            </td>
        </tr>
        <tr><td colspan="2"><hr></td></tr>
    </table>
</div>
</header>
<main>
    <h3 class="card-title" style="text-align: center;">DATA PERUBAHAN STATUS KARYAWAN</h3>
    <p><b>Periode Bulan {{ $ket_bulan }} Tahun {{ $ket_tahun }}</b></p>
    <table style="width: 100%; border-collapse:collapse" border="1">
        <thead>
            <tr>
                <th scope="col" rowspan="3" style="width: 5%;">#</th>
                <th scope="col" rowspan="3" style="width: 20%;">Karyawan</th>
                <th scope="col" rowspan="3" style="width: 15%;">Surat</th>
                <th scope="col" colspan="6" style="text-align: center;">Perubahan Status</th>
            </tr>
            <tr>
                <th colspan="3" class="btn-success" style="text-align: center">Status Lama</th>
                <th colspan="3" class="btn-danger" style="text-align: center">Status Baru</th>
            </tr>
            <tr>
                <th style="width: 10%;">Status</th>
                <th style="width: 10%;">Efektif</th>
                <th style="width: 10%;">Berakhir</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 10%;">Efektif</th>
                <th style="width: 10%;">Berakhir</th>
            </tr>
        </thead>
        <tbody id="result_riwayat">
        @php $nom=1; @endphp
        @foreach($list_data as $list)
            <tr>
                <td style="vertical-align: top; text-align:center">{{ $nom }}</td>
                <td>{{ $list->get_profil->nik }} - {{ $list->get_profil->nm_lengkap }}<br>
                Jabatan : {{ (!empty($list->get_profil->get_jabatan->nm_jabatan)) ? $list->get_profil->get_jabatan->nm_jabatan : "" }} {{ (!empty($list->get_profil->id_departemen)) ? "Dept. : ".$list->get_profil->get_departemen->nm_dept : "" }}
                </td>
                <td style="vertical-align: top;">Nomor : {{ $list->no_surat }}<br>Tanggal : {{ date_format(date_create($list->tgl_surat), "d-m-Y") }}</td>
                <td style="vertical-align: top; text-align:center">{{ $list->get_status_karyawan($list->id_sts_lama) }}</td>
                <td style="vertical-align: top; text-align:center">{{ date_format(date_create($list->tgl_eff_lama), 'd-m-Y') }}</td>
                <td style="vertical-align: top; text-align:center">{{ date_format(date_create($list->tgl_akh_lama), 'd-m-Y') }}</td>
                <td style="vertical-align: top; text-align:center">{{ $list->get_status_karyawan($list->id_sts_baru) }}</td>
                <td style="vertical-align: top; text-align:center">{{ date_format(date_create($list->tgl_eff_baru), 'd-m-Y') }}</td>
                <td style="vertical-align: top; text-align:center">@if(!empty($list->tgl_akh_baru)){{ date_format(date_create($list->tgl_akh_baru), 'd-m-Y') }} @endif</td>
            </tr>
        @php $nom++; @endphp
        @endforeach
        </tbody>
    </table>
    <!--
    <div class="page-break"></div>
    <h1>Page 2</h1>
    -->
</main>
