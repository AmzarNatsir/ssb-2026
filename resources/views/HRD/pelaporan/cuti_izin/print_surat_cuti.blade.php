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
                    <td colspan="3" align="center" style="font-size: 15px">SURAT CUTI</td>
                </tr>
                <tr>
                    <td colspan="3" align="center" style="font-size: 13px">No: {{ $cuti->nomor_surat }}</td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3">Memberikan Cuti Kepada</td>
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
                    <td style="height: 25px;">Alamat</td>
                    <td>:</td>
                    <td>{{ $cuti->profil_karyawan->alamat }}</td>
                </tr>
                <tr>
                    <td style="height: 25px;">Tujuan</td>
                    <td>:</td>
                    <td>{{ $cuti->ket_cuti }}</td>
                </tr>
                <tr>
                    <td style="height: 25px;">Terhitung Tanggal</td>
                    <td>:</td>
                    <td>
                        {{ date_format(date_create($cuti->tgl_awal), 'd') }} {{ \App\Helpers\Hrdhelper::get_nama_bulan(date_format(date_create($cuti->tgl_awal), 'm')) }} {{ date_format(date_create($cuti->tgl_awal), 'Y') }} s/d {{ date_format(date_create($cuti->tgl_akhir), 'd') }} {{ \App\Helpers\Hrdhelper::get_nama_bulan(date_format(date_create($cuti->tgl_akhir), 'm')) }} {{ date_format(date_create($cuti->tgl_akhir), 'Y') }}
                    </td>
                </tr>
                <tr>
                    <td style="height: 25px;">Masuk Bekerja</td>
                    <td>:</td>
                    <td>
                        @php
                        $tgl_masuk = (empty($cuti->tgl_masuk)) ? date('d-m-Y', strtotime($cuti->tgl_akhir . ' +1 day')) : date('d-m-Y', strtotime($cuti->tgl_masuk));
                        @endphp
                        {{ date_format(date_create($tgl_masuk), 'd') }} {{ \App\Helpers\Hrdhelper::get_nama_bulan(date_format(date_create($tgl_masuk), 'm')) }} {{ date_format(date_create($tgl_masuk), 'Y') }}</td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3">Dengan ketentuan sebagai berikut :</td>
                </tr>
                <tr>
                    <td colspan="3">1.	Sebelum melaksanakan cuti, harus menyerahkan pekerjaan kepada atasannya.</td>
                </tr>
                <tr>
                    <td colspan="3">2.	Setelah kembali menjalankan cuti, harus melaporkan diri kepada atasannya dan kembali bekerja seperti semula.</td>
                </tr>
                <tr>
                    <td colspan="3">3.	Surat cuti ini harap dikembalikan kepada bagian Personalia setelah kembali menjalankan cuti.</td>
                </tr>
                <tr>
                    <td colspan="3">4.	Apabila terlambat dari menjalankan cuti, sehingga terlambat masuk bekerja tanpa ada pemberitahuan, akan dikenakan sanksi sebagai berikut :</td>
                </tr>
                <tr>
                    <td colspan="3">-	Terlambat 1 (satu) hari kerja diberikan peringatan pertama</td>
                </tr>
                <tr>
                    <td colspan="3">-	Terlambat 2 (dua) hari kerja diberikan peringatan kedua.</td>
                </tr>
                <tr>
                    <td colspan="3">-	Terlambat 3 (tiga) hari kerja diberikan peringatan terakhir.</td>
                </tr>
                <tr>
                    <td colspan="3">-	Terlambat 5 (lima) hari kerja dianggap mengundurkan diri.</td>
                </tr>
                <tr>
                    <td colspan="3">Demikian surat cuti ini deberikan kepada yang bersangkutan untuk dipergunakan semestinya.</td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
            </table>
            <br>
            <table style="width: 100%; border-collapse:collapse; font-size: 12px">
                <tr>
                    <td style="width: 60%"></td>
                    <td style="width: 15%">Dikeluarkan </td>
                    <td>: Pomalaa</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Pada tanggal </td>
                    <td>: {{ date_format(date_create($cuti->tanggal_surat), 'd') }} {{ \App\Helpers\Hrdhelper::get_nama_bulan(date_format(date_create($cuti->tanggal_surat), 'm')) }} {{ date_format(date_create($cuti->tanggal_surat), 'Y') }}</td>
                </tr>
                <tr>
                    <td style="height: 50px"></td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2" style="text-align: center"><b>{{ $cuti->get_current_approve->nm_lengkap }}</b></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2" style="text-align: center"><b>{{ $cuti->get_current_approve->get_jabatan->nm_jabatan }}</b></td>
                </tr>
            </table>
        </main>
    </body>
 </html>
