<!DOCTYPE html>
 <html lang="en">
 <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>SSB | Smart System Base | HRD | Cuti | Surat Cuti Karyawan</title>
<style>
    @page {
        margin: 0px;
    }
    body {
        margin : 110px 80px;
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
    td.ln-top {
		border-top: 1px solid black;
    }
    td.ln-left {
        border-left: 1px solid black;
    }
    td.ln-right {
        border-right: 1px solid black;
    }
    td.ln-bottom {
        border-bottom: 1px solid black;
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
                {{-- <img src="{{ url(Storage::url('logo_perusahaan/'.$fl_logo)) }}" alt="Logo" width="100px" width="auto" class="logo"/> --}}
                <img src="{{ url('storage/logo_perusahaan/'.$logo) }}" alt="Logo" width="100px" width="auto" class="logo"/>
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
            <table style="width: 100%; border-collapse:collapse; font-size: 12px">
                <tr>
                    <td colspan="3" align="center" ><h2>FORMULIR PERMOHONAN CUTI</h2></td>
                </tr>
                <tr>
                    <td style="width: 38%; height: 25px;">Nama</td>
                    <td style="width: 2%">:</td>
                    <td>{{ $cuti->profil_karyawan->nm_lengkap }}</td>
                </tr>
                <tr>
                    <td style="height: 25px;">NIK</td>
                    <td>:</td>
                    <td>{{ $cuti->profil_karyawan->nik }}</td>
                </tr>
                <tr>
                    <td style="height: 25px;">Jabatan</td>
                    <td>:</td>
                    <td>{{ $cuti->profil_karyawan->get_jabatan->nm_jabatan }}</td>
                </tr>
                <tr>
                    <td style="height: 25px;">Keperluan Cuti</td>
                    <td>:</td>
                    <td>{{ $cuti->ket_cuti }}</td>
                </tr>
                <tr>
                    <td style="height: 25px;">Masa Waktu Cuti</td>
                    <td>:</td>
                    <td>{{ date_format(date_create($cuti->tgl_awal), 'd') }} {{ \App\Helpers\Hrdhelper::get_nama_bulan(date_format(date_create($cuti->tgl_awal), 'm')) }} {{ date_format(date_create($cuti->tgl_awal), 'Y') }} s/d {{ date_format(date_create($cuti->tgl_akhir), 'd') }} {{ \App\Helpers\Hrdhelper::get_nama_bulan(date_format(date_create($cuti->tgl_akhir), 'm')) }} {{ date_format(date_create($cuti->tgl_akhir), 'Y') }}</td>
                </tr>
                <tr>
                    <td style="height: 25px;">Tanggal Masuk Kerja</td>
                    <td>:</td>
                    <td>@php
                        $tgl_masuk = (empty($cuti->tgl_masuk)) ? date('d-m-Y', strtotime($cuti->tgl_akhir . ' +1 day')) : date('d-m-Y', strtotime($cuti->tgl_masuk));
                        @endphp
                        {{ date_format(date_create($tgl_masuk), 'd') }} {{ \App\Helpers\Hrdhelper::get_nama_bulan(date_format(date_create($tgl_masuk), 'm')) }} {{ date_format(date_create($tgl_masuk), 'Y') }}</td>
                </tr>
                <tr>
                    <td style="height: 25px;">Karyawan Pengganti</td>
                    <td>:</td>
                    <td>{{ (empty($cuti->id_pengganti)) ? "-" : $cuti->get_karyawan_pengganti->nm_lengkap }}</td>
                </tr>
            </table>
            <br>
            <table style="width: 100%; border-collapse:collapse; font-size: 12px" cellpadding="3">
                <tr>
                    <td style="width: {{ $witdhColumn }}%">Memohon</td>
                    @foreach ($approval as $head)
                    <td style="width: {{ $witdhColumn }}%"> {{ ($head->approval_level == $levelMax) ? "Mengetahui" : "Menyetujui" }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>Karyawan</td>
                    @foreach ($approval as $jabatan)
                    <td style="width: {{ $witdhColumn }}%">{{ $jabatan->get_profil_employee->get_jabatan->nm_jabatan }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td style="height: 50px"></td>
                    @foreach ($approval as $space)
                    <td style="width: {{ $witdhColumn }}%"></td>
                    @endforeach
                </tr>
                <tr>
                    <td><b>{{$cuti->profil_karyawan->nm_lengkap }}</b></td>
                    @foreach ($approval as $pejabat)
                    <td style="width: {{ $witdhColumn }}%"><b>{{ $pejabat->get_profil_employee->nm_lengkap }}</b></td>
                    @endforeach
                </tr>
            </table>
            <br>
            <table style="border: 1px solid black; border-collapse: collapse; width: 100%; font-size: 12px" cellpadding="3">
                <tr>
                    <td colspan="3" style="text-align: center; height: 25px;" class="ln-bottom">Diisi Personalia</td>
                </tr>
                <tr>
                    <td style="height: 25px; width: 25%">Cuti Tahunan</td>
                    <td style="width: 25%" class="ln-left">: {{ $masterCuti->lama_cuti }} Hari</td>
                    <td class="ln-left">Pomalaa, {{ date_format(date_create($cuti->tanggal_surat), 'd') }} {{ \App\Helpers\Hrdhelper::get_nama_bulan(date_format(date_create($cuti->tanggal_surat), 'm')) }} {{ date_format(date_create($cuti->tanggal_surat), 'Y') }}</td>
                </tr>
                <tr>
                    <td style="height: 25px;">Cuti yang sudah diambil</td>
                    <td class="ln-left">: {{ $quotaTerpakai }} Hari</td>
                    <td rowspan="3" style="vertical-align: bottom; text-align:center" class="ln-left"><b>{{ auth()->user()->karyawan->nm_lengkap }}</b></td>
                </tr>
                <tr>
                    <td style="height: 25px;">Cuti yang akan diambil</td>
                    <td class="ln-left">: {{ $cuti->jumlah_hari }} Hari</td>
                </tr>
                <tr>
                    <td style="height: 25px;">Sisa cuti tahunan</td>
                    <td class="ln-left">: {{ $masterCuti->lama_cuti - $quotaTerpakai }} Hari</td>
                </tr>
                <tr>
                    <td colspan="3" class="ln-top" style="height: 25px;">Note : Untuk pengurusan permohonan cuti maks. 14 hari sebelum melaksanakan cuti terkecuali izin kedukaan & sakit.</td>
                </tr>
            </table>
        </main>
    </body>
 </html>
