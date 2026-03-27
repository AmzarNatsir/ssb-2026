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
        <td colspan="4" style="text-align: center; font-size:large"><b>SURAT PERJALANAN DINAS</b></td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: center; font-size:13px"><b>NO. {{ $profil->no_perdis }}</b></td>
    </tr>
    <tr>
        <td colspan="4" style="height: 30px"></td>
    </tr>
    <tr>
        <td colspan="4">PT. Sumber Setia Budi, dengan ini menugaskan karyawan perusahaan sebagai berikut :</td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td style="width: 5%"></td>
        <td style="width: 20%">Nama</td>
        <td style="width: 1%">:</td>
        <td>{{ $profil->get_profil->nm_lengkap }}</td>
    </tr>
    <tr>
        <td></td>
        <td>NIK</td>
        <td>:</td>
        <td>{{ $profil->get_profil->nik }}</td>
    </tr>
    <tr>
        <td></td>
        <td>Jabatan</td>
        <td>:</td>
        <td>{{ $profil->get_profil->get_jabatan->nm_jabatan }}</td>
    </tr>
    <tr>
        <td></td>
        <td>Departemen</td>
        <td>:</td>
        <td>{{ $profil->get_profil->get_departemen->nm_dept }}</td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="4">Untuk melakukan perjalanan dinas guna melaksanakan pekerjaan sebagai berikut : </td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td></td>
        <td>Maksud dan Tujuan</td>
        <td>:</td>
        <td>{{ $profil->maksud_tujuan }}</td>
    </tr>
    <tr>
        <td></td>
        <td>Tujuan/Lokasi</td>
        <td>:</td>
        <td>{{ $profil->tujuan }}</td>
    </tr>
    <tr>
        <td></td>
        <td>Waktu Pelaksanaan</td>
        <td>:</td>
        <td>{{ date('d-m-Y', strtotime($profil->tgl_berangkat)) }} s/d {{ date('d-m-Y', strtotime($profil->tgl_kembali)) }}</td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="4">Demikian surat tugas ini kami sampaikan. Atas perhatian dan kerja sama Bapak/Ibu kami sampaikan terima kasih</td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: right">Pomala, {{ date_format(date_create($profil->tgl_perdis), 'd') }} {{ \App\Helpers\Hrdhelper::get_nama_bulan(date_format(date_create($profil->tgl_perdis), 'm')) }} {{ date_format(date_create($profil->tgl_perdis), 'Y') }}</td>
    </tr>
</table>
<table style="border: 1px solid black; border-collapse: collapse; font-size:12px; width: 100%;">
    <tr>
        <td style="text-align: center">Penerima Tugas </td>
        <td colspan="2" style="border: 1px solid black; border-collapse: collapse; height: 30px; text-align: center">Disetujui</td>
    </tr>
    <tr>
        <td style="border: 1px solid black; border-collapse: collapse; height: 100px;"></td>
        <td style="border: 1px solid black; border-collapse: collapse; height: 100px; width: 33%;"></td>
        <td style="border: 1px solid black; border-collapse: collapse; height: 100px; width: 33%;"></td>
    </tr>
    <tr>
        <td style="border: 1px solid black; border-collapse: collapse; height: 30px; text-align: center">{{ $profil->get_profil->nm_lengkap }}</td>
        <td style="border: 1px solid black; border-collapse: collapse; height: 30px; text-align: center">{{ $profil->get_diajukan_oleh->nm_lengkap }}<br>Atasan Langsung</td>
        <td style="border: 1px solid black; border-collapse: collapse; height: 30px; text-align: center">{{ $profil->get_current_approve->nm_lengkap }}<br>{{ $profil->get_current_approve->get_jabatan->nm_jabatan }}</td>
    </tr>
</table>
{{-- @if($fasilitas->count() > 0)
<div class="page-break"></div>
<table  style="border: 1px solid black; border-collapse: collapse; font-size:12px; width: 100%;" cellpadding="5" class="isi">
    <tr>
        <td colspan="4" style="text-align: center; font-size:large"><b>RINCIAN BIAYA</b></td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr  style="border: 1px solid black; border-collapse: collapse; height: 30px; text-align: center">
        <td style="text-align:left">Item</td>
        <td style="width: 10%; text-align:center">Hari</td>
        <td style="width: 15%; text-align:right">Biaya</td>
        <td style="width: 20%; text-align:right">Sub Total</td>
    </tr>
    @php $total=0 @endphp
    @foreach ($fasilitas as $list)
    <tr>
        <td>- {{ $list->get_master_fasilitas_perdis->nm_fasilitas }}</td>
        <td style="text-align:center">{{ $list->hari }}</td>
        <td style="text-align:right">{{ number_format($list->biaya, 0) }}</td>
        <td style="text-align:right">{{ number_format($list->sub_total, 0) }}</td>
    </tr>
    @php $total+=$list->sub_total @endphp
    @endforeach
    <tr  style="border: 1px solid black; border-collapse: collapse; height: 30px; text-align: center">
        <td colspan="3" style="text-align:right">Total</td>
        <td style="text-align:right"><b>{{ number_format($total, 0) }}</b></td>
    </tr>
</table>
@endif --}}
</main>
</body>
</html>
