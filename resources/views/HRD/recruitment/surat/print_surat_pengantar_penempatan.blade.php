@php
$fl_logo = App\Helpers\Hrdhelper::get_profil_perusahaan()->logo_perusahaan;
@endphp
<!DOCTYPE html>
 <html lang="en">
 <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>SSB | Smart System Base | HRD | Recruitment | Surat Pengantar Penempatan</title>
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
    <td style="text-align: center; font-size:15px"><b><u>SURAT PENGANTAR PENEMPATAN</u></b></td>
</tr>
<tr>
    <td style="text-align: center; font-size:13px"><b>NO. {{ $profil->no_surat_pengantar }}</b></td>
</tr>
<tr><td style="height: 30px;"></td></tr>
<tr>
    <td style="text-align: justify;">Hal : Penempatan Tenaga {{ $profil->get_jabatan->nm_jabatan }}</td>
</tr>
<tr><td style="height: 30px;"></td></tr>
<tr><td style="text-align: justify;">Kepada Yth.</td></tr>
<tr><td style="text-align: justify;">Manajer {{ $profil->get_departmen->nm_dept }}</td></tr>
<tr><td style="text-align: justify;">Di</td></tr>
<tr><td style="text-align: justify;">&nbsp;&nbsp;&nbsp;Tempat</td></tr>
<tr><td style="height: 20px;"></td></tr>
</table>
<table style="width: 100%;" class="isi">
<tr>
    <td colspan="3">Dengan Hormat,</td>
</tr>
<tr>
    <td colspan="3" style="text-align: justify;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bersama ini kami menempatkan karyawan yang telah memenuhi persyaratan & standar di PT Sumber Setia Budi untuk melakukan masa orientasi pada Departemen {{ $profil->get_departmen->nm_dept }}. Adapun identitas karyawan tersebut adalah :</td>
</tr>
<tr><td colspan="3" style="height: 20px;"></td></tr>
<tr>
    <td style="width: 30%;">&nbsp;&nbsp;&nbsp;&nbsp;Nama</td>
    <td style="width: 1%;; text-align: right;">:</td>
    <td style="width: 69%;"><b>{{ $profil->nama_lengkap }}</b></td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;Jabatan</td>
    <td style="text-align: right;">:</td>
    <td><b>{{ $profil->get_jabatan->nm_jabatan }}</b></td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;Tempat, Tanggal Lahir</td>
    <td style="text-align: right;">:</td>
    <td><b>{{ $profil->tempat_lahir }}, {{ date_format(date_create($profil->tanggal_lahir), 'd') }} {{ \App\Helpers\Hrdhelper::get_nama_bulan(date_format(date_create($profil->tanggal_lahir), 'm')) }} {{ date_format(date_create($profil->tanggal_lahir), 'Y') }}</b></td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;Pend. Terakhir</td>
    <td style="text-align: right;">:</td>
    <td><b>
    @foreach($list_jenjang as $key => $jenjang)
    @if($key==$profil->id_jenjang)
        {{ $jenjang }}
        @php break; @endphp
    @endif
    @endforeach
    </b></td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;Alamat</td>
    <td style="text-align: right;">:</td>
    <td><b>{{ $profil->alamat }}</b></td>
</tr>
<tr><td colspan="3" style="height: 20px;"></td></tr>
<tr><td colspan="3">Untuk selanjutnya tugas dan tanggung jawab akan diarahkan oleh Mgr. {{ $profil->get_departmen->nm_dept }}.</td></tr>
<tr><td colspan="3" style="height: 20px;"></td></tr>
<tr><td colspan="3">Demikian surat pengantar ini disampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.</td></tr>
<tr><td colspan="3" style="height: 30px;"></td></tr>
<tr><td colspan="3" style="height: 30px;">Pomala, {{ date_format(date_create($profil->tgl_surat_pengantar), 'd') }} {{ \App\Helpers\Hrdhelper::get_nama_bulan(date_format(date_create($profil->tgl_surat_pengantar), 'm')) }} {{ date_format(date_create($profil->tgl_surat_pengantar), 'Y') }}</td></tr>
</table>
<table style="width: 100%;" class="isi">
<tr>
    <td style="width: 50%;">Yang Membuat, </td>
    <td style="width: 50%;">Yang Mengetahui,</td>
</tr>
<tr><td colspan="2" style="height: 50px;"></td></tr>
<tr>
    <td><b>{{ $profil->get_create_by($profil->surat_by)->nm_lengkap }}</b></td>
    <td><b>{{ $profil->get_current_approve->nm_lengkap }}</b></td>
</tr>
<tr>
    <td>{{ $profil->get_create_by($profil->surat_by)->nm_jabatan }}</td>
    <td>{{ $profil->get_current_approve->get_jabatan->nm_jabatan }}</td>
</tr>
</table>
  </main>
</body>
 </html>
