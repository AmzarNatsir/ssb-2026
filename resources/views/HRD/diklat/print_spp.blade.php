@php
$fl_logo = App\Helpers\Hrdhelper::get_profil_perusahaan()->logo_perusahaan;
@endphp
<!DOCTYPE html>
 <html lang="en">
 <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>SSB | Smart System Base | HRD | Pendidikan dan Pelatihan | Surat Perintah Pelatihan</title>
<style>
    @page {
        margin: 10px;
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
<main>
    <table width='100%' style='border-collapse:collapse;'>
        <tr>
            <td class="card-title" style="text-align: center; font-size: 14px"><u><b>SURAT PERINTAH PELATIHAN</b></u></td>
        </tr>
        <tr>
            <td style="text-align: center"><b>No. {{ $print_h->nomor }}</b></td>
        </tr>
        <tr>
            <td style="height: 30px"></td>
        </tr>
        <tr>
            <td>Kepada Yth:</td>
        </tr>
    </table>
    <br>
    @if ($print_d->count() == 1)
    <table width='100%' style='border-collapse:collapse;'>
        @foreach ($print_d as $peserta)
        <tr>
            <td style="width: 30%; height: 25px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nama</td>
            <td style="width: 2%">:</td>
            <td>{{ $peserta->get_karyawan->nm_lengkap}}</td>
        </tr>
        <tr>
            <td style="height: 25px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NIK</td>
            <td>:</td>
            <td>{{ $peserta->get_karyawan->nik}}</td>
        </tr>
        <tr>
            <td style="height: 25px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jabatan</td>
            <td>:</td>
            <td>{{ $peserta->get_karyawan->get_jabatan->nm_jabatan }}</td>
        </tr>
        @endforeach
    </table>
    @else
    <table style="width: 100%; border-collapse:collapse;" border="1" cellpadding="5">
        <tr>
            <td style="width: 5%; text-align:center"><b>NO.</b></td>
            <td style="width: 15%; text-align:center"><b>NIK</b></td>
            <td style="width: 35%; text-align:center"><b>NAMA</b></td>
            <td style="width: 35%; text-align:center"><b>JABATAN</b></td>
            <td style="width: 10%; text-align:center"><b>KET</b></td>
        </tr>
        @php $nom=1 @endphp
        @foreach ($print_d as $peserta)
        <tr>
            <td style="text-align:center">{{ $nom }}</td>
            <td style="text-align:center">{{ $peserta->get_karyawan->nik}}</td>
            <td>{{ $peserta->get_karyawan->nm_lengkap}}</td>
            <td>{{ $peserta->get_karyawan->get_jabatan->nm_jabatan }}</td>
            <td></td>
        </tr>
        @php $nom++ @endphp
        @endforeach
    </table>
    @endif
    <br>
    <table width='100%' style='border-collapse:collapse;'>
        <tr>
            <td colspan="3">Ditugaskan kepada saudara untuk mengikuti pelatihan yang penyelenggaraannya diatur sebagai berikut: </td>
        </tr>
        <tr>
            <td style="height: 25px" colspan="3"></td>
        </tr>
        <tr>
            <td style="width: 30%; height: 25px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nama Pelatihan</td>
            <td style="width: 2%">:</td>
            <td>{{ (empty($print_h->id_pelatihan)) ?  $print_h->nama_pelatihan : $print_h->get_nama_pelatihan->nama_pelatihan }}</td>
        </tr>
        <tr>
            <td style="height: 25px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Penyelenggara</td>
            <td>:</td>
            <td>{{ (empty( $print_h->id_pelaksana)) ? $print_h->nama_vendor : $print_h->get_pelaksana->nama_lembaga }}</td>
        </tr>
        <tr>
            <td style="height: 25px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hari / Tanggal </td>
            <td>:</td>
            <td>
                @if($print_h->tanggal_awal==$print_h->hari_sampai)
                {{ App\Helpers\Hrdhelper::get_hari($print_h->tanggal_awal) }}
                @else
                {{ App\Helpers\Hrdhelper::get_hari_ini($print_h->tanggal_awal). " - ".App\Helpers\Hrdhelper::get_hari_ini($print_h->tanggal_sampai) }}
                @endif
                , {{ App\Helpers\Hrdhelper::get_tanggal_pelaksanaan($print_h->tanggal_awal, $print_h->tanggal_sampai, $print_h->hari_awal, $print_h->hari_sampai) }}
                {{-- {{ $print_h->hari_awal }}-{{ $print_h->hari_sampai }}, {{ date_format(date_create($print_h->tanggal_awal), 'd/m/Y') }} s/d {{ date_format(date_create($print_h->tanggal_sampai), 'd/m/Y') }} --}}
            </td>
        </tr>
        <tr>
            <td style="height: 25px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Durasi</td>
            <td>:</td>
            <td>{{ $print_h->durasi }}</td>
        </tr>
        <tr>
            <td style="height: 25px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tempat</td>
            <td>:</td>
            <td>{{ $print_h->tempat_pelaksanaan }}</td>
        </tr>
        <tr>
            <td style="height: 25px" colspan="3"></td>
        </tr>
        <tr>
            <td colspan="3">Untuk lebih efektifnya diwajibkan mengikuti pelatihan ini dengan baik dan bersungguh-sungguh.</td>
        </tr>
    </table>
    <br>
    <table width='100%' style='border-collapse:collapse;'>
        <tr>
            <td style="width: 60%"></td>
            <td style="text-align: center">Pomalaa, {{ date_format(date_create($print_h->tanggal), 'd')." ".App\Helpers\Hrdhelper::get_nama_bulan(date_format(date_create($print_h->tanggal), 'm'))." ".date_format(date_create($print_h->tanggal), 'Y') }}</td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: center">PT. Sumber Setia Budi</td>
        </tr>
        <tr>
            <td style="height: 50px"></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: center"><u>{{ $print_h->get_karyawan_ttd->nm_lengkap }}</u></td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: center">{{ $print_h->get_karyawan_ttd->get_jabatan->nm_jabatan }}</td>
        </tr>
    </table>
</main>
