@php
$fl_logo = App\Helpers\Hrdhelper::get_profil_perusahaan()->logo_perusahaan;
@endphp
<!DOCTYPE html>
 <html lang="en">
 <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>SSB | Smart System Base | HRD | Resign | Surat Keterangan Kerja</title>
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
<body>
<main>
    <table width='100%' style='border-collapse:collapse; font-size:13px"' cellpadding="4">
        <tr>
            <td style="text-align:center" colspan="3"><b><u>SURAT KETERANGAN KERJA</u></b><br>CERTIFICATE OF EMPLOYMENT</td>
        </tr>
        <tr>
            <td style="text-align:center" colspan="3">NO : {{ $main->nomor_skk }}</td>
        </tr>
        <tr>
            <td colspan="3" style="height: 20px"></td>
        </tr>
        <tr>
            <td colspan="3"><u>Dengan ini menerangkan bahwa</u><br>This is to certify that</td>
        </tr>
        <tr>
            <td colspan="3" style="height: 20px"></td>
        </tr>
        <tr>
            <td style="width: 38%">Nama</td>
            <td style="width: 2%">:</td>
            <td><b>{{ $main->getKaryawan->nm_lengkap }}</b></td>
        </tr>
        <tr>
            <td>Jabatan Awal<br><u>Beginning Classification</u></td>
            <td>:</td>
            <td><b>{{ (empty($main->getKaryawan->jabatan_awal)) ? $main->getKaryawan->get_jabatan->nm_jabatan : $main->getKaryawan->get_jabatan_awal->nm_jabatan }}</b></td>
        </tr>
        <tr>
            <td>Jabatan Akhir <br><u>Final Classification </u></td>
            <td>:</td>
            <td><b>{{ $main->getKaryawan->get_jabatan->nm_jabatan }}</b></td>
        </tr>
        <tr>
            <td>NIK<br><u>Employ No.</u></td>
            <td>:</td>
            <td><b>{{ $main->getKaryawan->nik }}</b></td>
        </tr>
        <tr>
            <td>Masa Kerja<br><u>Period of Service</u></td>
            <td>:</td>
            <td>{{ date_format(date_create($main->getKaryawan->tgl_masuk), 'd') }} {{ \App\Helpers\Hrdhelper::get_nama_bulan(date_format(date_create($main->getKaryawan->tgl_masuk), 'm')) }} {{ date_format(date_create($main->getKaryawan->tgl_masuk), 'Y') }} sampai {{ date_format(date_create($main->tgl_eff_resign), 'd') }} {{ \App\Helpers\Hrdhelper::get_nama_bulan(date_format(date_create($main->tgl_eff_resign), 'm')) }} {{ date_format(date_create($main->tgl_eff_resign), 'Y') }}</td>
        </tr>
        <tr>
            <td>Alasan Berhenti<br><u>Reason for leaving</u></td>
            <td>:</td>
            <td><b>Resign</b></td>
        </tr>
        @if($main->cara_keluar==1)
        <tr>
            <td colspan="3" style="height: 20px"></td>
        </tr>
        <tr>
            <td colspan="3">Kami menyampaikan terima kasih atas segala usaha dan sumbangsih yang telah
                diberikan kepada perusahaan dan semoga keberhasilan selalu bersama anda.<br>
                =======================================================================<br>
                We would like to express our gratitude for the efforts contributions that have been given
                to Company and wish him every success in the future. </td>
        </tr>
        @endif
        <tr>
            <td colspan="3" style="height: 20px"></td>
        </tr>
        <tr>
            <td colspan="3" style="height: 20px"></td>
        </tr>
    </table>
    <table style="width: 100%; border-collapse:collapse; font-size: 12px" cellpadding="4">
        <tr>
            <td style="width: 40%; vertical-align: middle">
                @if(!empty($main->getKaryawan->photo))
                <img src="{{ url(Storage::url('hrd/photo/'.$main->getKaryawan->photo)) }}"
                    class="rounded-circle" alt="avatar" style="width: 120px; height: auto;" border="2"></a>
                @else
                <a href="{{ asset('assets/images/user/1.jpg') }}" data-fancybox data-caption="avatar">
                <img src="{{ asset('assets/images/user/1.jpg') }}"
                    class="rounded-circle" alt="avatar" style="width: 120px; height: auto;"></a>
                @endif
            </td>
            <td style="text-align: center; vertical-align: top">
                Pomalaa, {{ date_format(date_create($main->tgl_skk), 'd') }} {{ \App\Helpers\Hrdhelper::get_nama_bulan(date_format(date_create($main->tgl_skk), 'm')) }} {{ date_format(date_create($main->tgl_skk), 'Y') }}
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <b>{{ $main->get_current_approve->nm_lengkap }}</b>
                <br>
                <b>{{ $main->get_current_approve->get_jabatan->nm_jabatan }}</b>
            </td>
        </tr>
        {{-- <tr>
            <td style="height: 50px"></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: center"><b>{{ $main->get_current_approve->nm_lengkap }}</b></td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: center"><b>{{ $main->get_current_approve->get_jabatan->nm_jabatan }}</b></td>
        </tr> --}}
    </table>
</main>
</body>
</html>
