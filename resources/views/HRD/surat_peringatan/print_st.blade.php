@php
$fl_logo = App\Helpers\Hrdhelper::get_profil_perusahaan()->logo_perusahaan;
@endphp
<!DOCTYPE html>
 <html lang="en">
 <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>SSB | Smart System Base | HRD | Surat Teguran (ST)</title>
<style>
    @page {
        margin: 0px;
    }
    body {
        margin : 120px 100px;
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
    header { position: fixed; top: 5px; left: 20px; right: 20px; height: 30px; }
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
<main>
    <table style="width: 100%" cellpadding='5' class="isi">
        <tr>
            <td style="text-align: center; font-size:large"><b>SURAT TEGURAN<br>PELANGGARAN KESELAMATAN KERJA</b></td>
        </tr>
    </table>
    <table style="border: 2px solid black; border-collapse: collapse; width: 100%;" cellpadding='5' class="isi">
    <tr>
        <td colspan="3" style="text-align: center; height: 40px;">SURAT TEGURAN INI DIKELUARKAN APABILA KARYAWAN YANG TELAH MELAKUKAN PELANGGARAN TERHADAP KESELAMATAN KERJA YANG DAPAT MEMBAHAYAKAN DIRINYA SENDIRI ATAUPUN ORANG LAIN.</td>
    </tr>
    <tr>
        <td colspan="3" style="border-top: 2px solid black; border-collapse: collapse;">Telah terjadi pelanggaran peraturan KESELAMATAN KERJA yang dilakukan oleh :</td>
    </tr>
    <tr>
        <td style="width: 20%;">Nama</td>
        <td style="text-align: right; width: 1%;">:</td>
        <td style="width: 79%;"><b>{{ $dt_st->get_karyawan->nm_lengkap }}</b></td>
    </tr>
    <tr>
        <td>NIK</td>
        <td style="text-align: right;">:</td>
        <td><b>{{ $dt_st->get_karyawan->nik }}</b></td>
    </tr>
    <tr>
        <td>Jabatan</td>
        <td style="text-align: right;">:</td>
        <td><b>{{ $dt_st->get_karyawan->get_jabatan->nm_jabatan }}</b></td>
    </tr>
    <tr>
        <td>Tanggal Kejadian</td>
        <td style="text-align: right;">:</td>
        <td><b>{{ date('d-m-Y', strtotime($dt_st->tanggal_kejadian)) }}</b></td>
    </tr>
    <tr>
        <td>Waktu</td>
        <td style="text-align: right;">:</td>
        <td><b>{{ date('H:i', strtotime($dt_st->waktu_kejadian)) }}</b></td>
    </tr>
    <tr>
        <td>Tempat</td>
        <td style="text-align: right;">:</td>
        <td><b>{{ $dt_st->tempat_kejadian }}</b></td>
    </tr>
    <tr>
        <td>Jenis pelanggaran </td>
        <td style="text-align: right;">:</td>
        <td><b>{{ $dt_st->get_jenis_pelanggaran->jenis_pelanggaran }}</b></td>
    </tr>
    <tr>
        <td colspan="3" style="border-top: 2px solid black; border-collapse: collapse;">Akibat pelanggaran tersebut terjadi :</td>
    </tr>
    <tr>
        <td colspan="3"><b>{{ $dt_st->akibat }}</b></td>
    </tr>
    <tr>
        <td colspan="3">Tindakan perbaikan yang dilakukan setelah kejadian :</td>
    </tr>
    <tr>
        <td colspan="3" style="border-bottom: 2px solid black; border-collapse: collapse;"><b>{{ $dt_st->tindakan }}</b></td>
    </tr>
    <tr>
        <td colspan="3">Rekomendasi dari atasan pelanggaran :</td>
    </tr>
    <tr>
        <td colspan="3"><b>{{ $dt_st->rekomendasi }}</b></td>
    </tr>
    <tr>
        <td colspan="3">
            <table style="width: 100%" cellpadding="5">
            <tr>
                <td style="width: 14%">Nama</td>
                <td style="width: 1%">:</td>
                <td style="width: 35%">{{ $dt_st->get_diajukan_oleh->nm_lengkap }}</td>
                <td style="width: 14%">Tanda Tangan</td>
                <td style="width: 1%">:</td>
                <td style="width: 35%"></td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $dt_st->get_diajukan_oleh->get_jabatan->nm_jabatan }}</td>
                <td>Tanggal</td>
                <td>:</td>
                <td>{{ date('d-m-Y', strtotime($dt_st->tanggal_pengajuan)) }}</td>
            </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="border-top: 2px solid black; border-collapse: collapse;">Komentar dari pelanggar :</td>
    </tr>
    <tr>
        <td colspan="3"><b>{{ $dt_st->komentar }}</b></td>
    </tr>
    <tr>
        <td colspan="3">
            <table style="width: 100%" cellpadding="5">
            <tr>
                <td style="width: 14%">Nama</td>
                <td style="width: 1%">:</td>
                <td style="width: 35%">{{ $dt_st->get_karyawan->nm_lengkap }}</td>
                <td style="width: 14%">Tanda Tangan</td>
                <td style="width: 1%">:</td>
                <td style="width: 35%"></td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $dt_st->get_karyawan->get_jabatan->nm_jabatan }}</td>
                <td>Tanggal</td>
                <td>:</td>
                <td>{{ date('d-m-Y', strtotime($dt_st->tanggal_kejadian)) }}</td>
            </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="border-top: 2px solid black; border-collapse: collapse;">Disetujui Oleh :</td>
    </tr>
    <tr>
        <td colspan="3">
            <table style="width: 100%" cellpadding="5">
                <tr>
                    <td style="width: 5%"><b>#</b></td>
                    <td style="width: 35%"><b>Pejabat</b></td>
                    <td style="width: 15%"><b>Tanggal</b></td>
                    <td style="width: 30%"><b>Keterangan</b></td>
                    <td style="width: 15%"><b>Status</b></td>
                </tr>
                @foreach ($hirarki_persetujuan as $list)
                <tr>
                    <td class="text-center">
                        @if($list->approval_active==1)
                        <h4><span class="badge badge-pill badge-success">{{ $list->approval_level }}</span></h4>
                        @else
                        <h4><span class="badge badge-pill badge-danger">{{ $list->approval_level }}</span></h4>
                        @endif
                    </td>
                    <td>{{ $list->get_profil_employee->nm_lengkap }}<br>
                        {{ $list->get_profil_employee->get_jabatan->nm_jabatan }}</td>
                    <td>
                        {{ (empty($list->approval_date)) ? "" : date('d-m-Y', strtotime($list->approval_date))  }}
                    </td>
                    <td>{{ $list->approval_remark }}</td>
                    <td>
                        @if($list->approval_status==1)
                        <h4><span class="badge badge-pill badge-success">Approved</span></h4>
                        @elseif($list->approval_status==2)
                        <h4><span class="badge badge-pill badge-danger">Rejected</span></h4>
                        @else

                        @endif
                        </td>
                </tr>
                @endforeach
            </table>
        </td>
    </tr>
    </table>
</main>
</body>
 </html>
