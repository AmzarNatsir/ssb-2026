@php
$fl_logo = App\Helpers\Hrdhelper::get_profil_perusahaan()->logo_perusahaan;
@endphp
<!DOCTYPE html>
 <html lang="en">
 <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>SSB | Smart System Base | HRD | Perubahan Status | Surat Keputusan</title>
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
    .isi {
        font-size: 13px;
    }
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
        <td colspan="3" style="text-align: center; font-size:large"><b>SURAT KEPUTUSAN</b></td>
    </tr>
    <tr>
        <td colspan="3" style="text-align: center; font-size:13px"><b>NO. {{ $dt_status->no_surat }}</b></td>
    </tr>
    <tr><td colspan="3" style="height: 30px;"></td></tr>
    <tr>
        <td colspan="3" style="text-align: justify;">Berdasarkan kebijakan Manajemen PT. Sumber Setia Budi dan hasil seleksi administratif, maka dengan ini ditetapkan bahwa :</td>
    </tr>
    <tr><td colspan="3" style="height: 20px;"></td></tr>
    <tr>
        <td style="width: 30%;">Nama</td>
        <td style="text-align: right; width: 1%;">:</td>
        <td style="width: 69%;"><b>{{ $dt_status->get_profil->nm_lengkap }}</b></td>
    </tr>
    <tr>
        <td>NIK</td>
        <td style="text-align: right;">:</td>
        <td><b>{{ $dt_status->get_profil->nik }}</b></td>
    </tr>
    <tr>
        <td>Departemen</td>
        <td style="text-align: right;">:</td>
        <td><b>{{ $dt_status->get_profil->get_departemen->nm_dept }}</b></td>
    </tr>
    <tr>
        <td>Jabatan</td>
        <td style="text-align: right;">:</td>
        <td><b>{{ $dt_status->get_profil->get_jabatan->nm_jabatan }}</b></td>
    </tr>
    <tr><td colspan="3" style="height: 20px;"></td></tr>
    <tr>
        <td colspan="3" style="text-align: justify;">Telah secara resmi diangkat menjadi karyawan TETAP terhitung sejak tanggal {{ date_format(date_create($dt_status->tgl_eff_baru), 'd') }} {{ \App\Helpers\Hrdhelper::get_nama_bulan(date_format(date_create($dt_status->tgl_eff_baru), 'm')) }} {{ date_format(date_create($dt_status->tgl_eff_baru), 'Y') }}.</td>
    </tr>
    <tr>
        <td colspan="3" style="text-align: justify;">Segala hak dan kewajiban lainnya diatur sebagimana tercantum dalam ketentuan-ketentuan maupun Peraturan Perusahaan yang berlaku.</td>
    </tr>
    <tr><td colspan="3" style="height: 20px;"></td></tr>
    <tr>
        <td colspan="3">Pomalaa, {{ date_format(date_create($dt_status->tgl_surat), 'd') }} {{ \App\Helpers\Hrdhelper::get_nama_bulan(date_format(date_create($dt_status->tgl_surat), 'm')) }} {{ date_format(date_create($dt_status->tgl_surat), 'Y') }}</td>
    </tr>
    <tr><td colspan="3" style="height: 50px;"></td></tr>
    <tr>
        <td colspan="3"><u><b>_______________________</b></u><br><b>DIREKTUR UTAMA</b></td>
    </tr>
</table>
</main>
</body>
</html>
