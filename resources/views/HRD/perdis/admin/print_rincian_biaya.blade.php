@php
$fl_logo = App\Helpers\Hrdhelper::get_profil_perusahaan()->logo_perusahaan;
@endphp
<!DOCTYPE html>
 <html lang="en">
 <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>SSB | Smart System Base | HRD | Perjalanan Dinas | Surat Perjalanan Dinas</title>
<style>
    @page {
        margin: 10px;
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
    header { position: fixed; top: -10px; left: 20px; right: 20px; background-color: #fefefe; height: 30px; }
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
        <td colspan="6" style="text-align: center; font-size:large"><b>RINCIAN BIAYA PERJALANAN DINAS</b></td>
    </tr>
    <tr>
        <td colspan="6" style="text-align: center; font-size:13px"><b>NO. {{ $profil->no_perdis }}</b></td>
    </tr>
    <tr>
        <td colspan="6" style="text-align: center; font-size:13px">&nbsp;</td>
    </tr>
    <tr>
        <td style="width: 20%">Nama</td>
        <td style="width: 1%">:</td>
        <td style="width: 29%">{{ $profil->get_profil->nm_lengkap }}</td>
        <td style="width: 20%">Maksud dan Tujuan</td>
        <td style="width: 1%">:</td>
        <td style="width: 29%">{{ $profil->maksud_tujuan }}</td>
    </tr>
    <tr>
        <td>NIK</td>
        <td>:</td>
        <td>{{ $profil->get_profil->nik }}</td>
        <td>Tujuan/Lokasi</td>
        <td>:</td>
        <td>{{ $profil->tujuan }}</td>
    </tr>
    <tr>
        <td>Jabatan</td>
        <td>:</td>
        <td>{{ $profil->get_profil->get_jabatan->nm_jabatan }}</td>
        <td>Waktu Pelaksanaan</td>
        <td>:</td>
        <td>{{ date('d-m-Y', strtotime($profil->tgl_berangkat)) }} s/d {{ date('d-m-Y', strtotime($profil->tgl_kembali)) }}</td>
    </tr>
    <tr>
        <td>Departemen</td>
        <td>:</td>
        <td>{{ $profil->get_profil->get_departemen->nm_dept }}</td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>
<br>
<table  style="border: 1px solid black; border-collapse: collapse; font-size:12px; width: 100%;" cellpadding="5" class="isi">
    <tr  style="border: 1px solid black; border-collapse: collapse; height: 30px; text-align: center">
        <td style="text-align:left">Item</td>
        <td style="width: 10%; text-align:center">Hari</td>
        <td style="width: 15%; text-align:right">Biaya</td>
        <td style="width: 20%; text-align:right">Sub Total</td>
        <td style="width: 20%; text-align:right">Realisasi</td>
    </tr>
    @php $total=0; $total_realisasi=0; $selisih=0; @endphp
    @foreach ($fasilitas as $list)
    <tr>
        <td>- {{ $list->get_master_fasilitas_perdis->nm_fasilitas }}</td>
        <td style="text-align:center">{{ $list->hari }}</td>
        <td style="text-align:right">{{ number_format($list->biaya, 0) }}</td>
        <td style="text-align:right">{{ number_format($list->sub_total, 0) }}</td>
        <td style="text-align:right">{{ number_format($list->realisasi, 0) }}</td>
    </tr>
    @php $total+=$list->sub_total; $total_realisasi+=$list->realisasi @endphp
    @endforeach
    @php $selisih = $total - $total_realisasi @endphp
    <tr  style="border: 1px solid black; border-collapse: collapse; height: 30px; text-align: center">
        <td colspan="3" style="text-align:right">Total</td>
        <td style="text-align:right"><b style="color: blue">{{ number_format($total, 0) }}</b></td>
        <td style="text-align:right"><b style="color: green">{{ number_format($total_realisasi, 0) }}</b></td>
    </tr>
    <tr  style="border: 1px solid black; border-collapse: collapse; height: 30px; text-align: center">
        <td colspan="3" style="text-align:right">Selisih</td>
        <td style="text-align:right">
            @if($selisih < 0)
            <b style="color: red">{{ number_format($selisih, 0) }}</b>
            @else
            <b style="color: blue">{{ number_format($selisih, 0) }}</b>
            @endif
        </td>
        <td style="text-align:right"></td>
    </tr>
</table>
</main>
</body>
</html>
