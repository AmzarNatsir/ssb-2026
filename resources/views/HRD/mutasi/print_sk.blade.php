@php
$fl_logo = App\Helpers\Hrdhelper::get_profil_perusahaan()->logo_perusahaan;
@endphp
<!DOCTYPE html>
 <html lang="en">
 <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>SSB | Smart System Base | HRD | Pelaporan | Mutasi Karyawan</title>
<style>
    @page {
        margin: 0px;
    }
    body {
        margin : 110px 100px;
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
                       {{ $kop_surat['alamat_situs'] }}<br>
                       {{ $kop_surat['lokasi'] }}
                    {{-- </pre> --}}
                </td>
            </tr>
            <tr><td colspan="2"><hr></td></tr>
        </table>
    </div>
    </header>
<main>
<table style="width: 100%;" class="isi">
    <tr>
        <td style="text-align: center; font-size:large"><b>SURAT MUTASI KARYAWAN</b></td>
    </tr>
    <tr>
    <td style="text-align: center; font-size:13px"><b>NO. {{ $result->no_surat }}</b></td>
    </tr>
    <tr><td style="height: 30px;"></td></tr>
    <tr>
        <td style="text-align: justify;">Yang bertanda tangan dibawah ini :</td>
    </tr>
    <tr><td style="height: 20px;"></td></tr>
</table>
<table style="width: 100%;" class="isi">
<tr>
    <td style="width: 5%; text-align: right;"></td>
    <td style="width: 25%;">Nama</td>
    <td style="width: 1%;; text-align: right;">:</td>
    <td style="width: 69%;"><b>MISBAH</b></td>
</tr>
<tr>
    <td></td>
    <td>Jabatan</td>
    <td style="text-align: right;">:</td>
    <td><b>Mgr. HRD</b></td>
</tr>
<tr><td colspan="4" style="height: 20px;"></td></tr>
<tr>
    <td colspan="4">Dengan ini bertindak untuk dan atas nama PT. Sumber Setia Budi memutuskan untuk melakukan mutasi terhadap :</td>
</tr>
<tr>
    <td style="width: 5%; text-align: right;"></td>
    <td style="width: 25%;">Nama</td>
    <td style="width: 1%;; text-align: right;">:</td>
    <td style="width: 69%;"><b>{{ $result->get_profil->nm_lengkap }}</b></td>
</tr>
<tr>
    <td style="width: 5%; text-align: right;"></td>
    <td style="width: 25%;">NIK</td>
    <td style="width: 1%;; text-align: right;">:</td>
    <td style="width: 69%;"><b>{{ $result->get_profil->nik }}</b></td>
</tr>
<tr>
    <td style="width: 5%; text-align: right;"></td>
    <td style="width: 25%;">Bagian</td>
    <td style="width: 1%;; text-align: right;">:</td>
    <td style="width: 69%;"><b>{{ $result->get_dept_lama->nm_dept }}</b></td>
</tr>
<tr>
    <td style="width: 5%; text-align: right;"></td>
    <td style="width: 25%;">Jabatan</td>
    <td style="width: 1%;; text-align: right;">:</td>
    <td style="width: 69%;"><b>{{ $result->get_jabatan_lama->nm_jabatan }}</b></td>
</tr>
<tr><td colspan="4" style="height: 20px;"></td></tr>
<tr>
    <td colspan="4">Bagian dan jabatan baru :</td>
</tr>
<tr>
    <td style="width: 5%; text-align: right;"></td>
    <td style="width: 25%;">Bagian</td>
    <td style="width: 1%;; text-align: right;">:</td>
    <td style="width: 69%;"><b>{{ $result->get_dept_baru->nm_dept }}</b></td>
</tr>
<tr>
    <td style="width: 5%; text-align: right;"></td>
    <td style="width: 25%;">Jabatan</td>
    <td style="width: 1%;; text-align: right;">:</td>
    <td style="width: 69%;"><b>{{ $result->get_jabatan_baru->nm_jabatan }}</b></td>
</tr>
<tr><td colspan="4" style="height: 20px;"></td></tr>
<tr>
    <td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mutasi ini efektif pada hari {{ \App\Helpers\Hrdhelper::get_hari($result->tgl_surat) }}, {{ date_format(date_create($result->tgl_surat), 'd') }} {{ \App\Helpers\Hrdhelper::get_nama_bulan(date_format(date_create($result->tgl_eff_baru), 'm')) }} {{ date_format(date_create($result->tgl_eff_baru), 'Y') }}, oleh karena itu kepada karyawan yang bersangkutan mempersiapkan segala sesuatunya sebelum tanggal tersebut.</td>
</tr>
<tr><td colspan="4" style="height: 20px;"></td></tr>
<tr>
    <td colspan="4">Demikian surat mutasi ini dibuat untuk di pergunakan sebagaimana mestinya</td>
</tr>
<tr><td colspan="4" style="height: 20px;"></td></tr>
</table>
<table style="width: 100%;" class="isi">
    <tr>
        <td style="width: 50%;"></td>
        <td style="width: 50%;">Pomalaa, {{ date_format(date_create($result->tgl_surat), 'd') }} {{ \App\Helpers\Hrdhelper::get_nama_bulan(date_format(date_create($result->tgl_eff_baru), 'm')) }} {{ date_format(date_create($result->tgl_eff_baru), 'Y') }}</td>
    </tr>
    <tr><td style="height: 60px;"></td></tr>
    <tr>
        <td></td>
        <td><b><u>{{ $result->get_current_approve->nm_lengkap }}</u></b><br><b>{{ $result->get_current_approve->get_jabatan->nm_jabatan }}</b></td>
    </tr>
    <tr><td colspan="2" style="height: 30px;"></td></tr>
    <tr>
        <td style="font-size: 10px;">Tembusan:<br>1. Tenaga Kerja <br>2. Arsip</td>
        <td></td>
    </tr>
</table>
</main>
</body>
