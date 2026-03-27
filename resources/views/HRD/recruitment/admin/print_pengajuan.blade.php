<!DOCTYPE html>
 <html lang="en">
 <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>SSB | Smart System Base | HRD | Recruitment | Form Pengajuan Permintaan Penambahan Karyawan</title>
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
    <table style="border: 1px solid black; border-collapse: collapse; width: 100%; font-size: 12px" cellpadding="3">
        <tr>
            <td colspan="3" style="text-align: center; font-size:large" style="height: 30px;" class="ln-bottom"><b>PERMINTAAN TENAGA KERJA</b></td>
        </tr>
        <tr>
            <td colspan="3" style="height: 20px"></td>
        </tr>
        <tr>
            <td style="width: 30%" class="ln-bottom">Departemen / Bagian / Divisi</td>
            <td style="width: 2%; text-align:center" class="ln-bottom">:</td>
            <td class="ln-bottom"><b>{{ $detail_pengajuan->get_departemen->nm_dept }}</b></td>
        </tr>
        <tr>
            <td class="ln-bottom">Posisi</td>
            <td class="ln-bottom" style="width: 2%; text-align:center">:</td>
            <td class="ln-bottom"><b>{{ $detail_pengajuan->get_jabatan->nm_jabatan }}</b></td>
        </tr>
        <tr>
            <td class="ln-bottom">Jumlah Permintaan</td>
            <td class="ln-bottom" style="width: 2%; text-align:center">:</td>
            <td class="ln-bottom"><b>{{ $detail_pengajuan->tanggal_dibutuhkan }} Orang</b></td>
        </tr>
        <tr>
            <td class="ln-bottom">Tanggal Dibutuhkan</td>
            <td class="ln-bottom" style="width: 2%; text-align:center">:</td>
            <td class="ln-bottom"><b>{{ date_format(date_create($detail_pengajuan->tanggal_pengajuan), 'd-m-Y') }}</b></td>
        </tr>
        <tr>
            <td class="ln-bottom">Alasan permintaan</td>
            <td class="ln-bottom" style="width: 2%; text-align:center">:</td>
            <td class="ln-bottom"><b>{{ $detail_pengajuan->alasan_permintaan }}</b></td>
        </tr>
        <tr>
            <td colspan="3" style="height: 30px; vertical-align: bottom" class="ln-bottom"><b>Kualifikasi yang dibutuhkan</b></td>
        </tr>
        <tr>
            <td class="ln-bottom">1. Jenis Kelamin</td>
            <td class="ln-bottom" style="width: 2%; text-align:center">:</td>
            <td class="ln-bottom"><b>{{ ($detail_pengajuan->jenkel==1) ? "Laki-Laki" : (($detail_pengajuan->jenkel==2) ? "Perempuan" : "Boleh Laki-Laki atau Perempuan" ) }}</b></td>
        </tr>
        <tr>
            <td class="ln-bottom">2. Umur</td>
            <td class="ln-bottom" style="width: 2%; text-align:center">:</td>
            <td class="ln-bottom"><b>Min {{ $detail_pengajuan->umur_min }} th, Maks {{ $detail_pengajuan->umur_maks }} th</b></td>
        </tr>
        <tr>
            <td class="ln-bottom">3. Pendidikan</td>
            <td class="ln-bottom" style="width: 2%; text-align:center">:</td>
            <td class="ln-bottom"><b>{{ $detail_pengajuan->pendidikan }}</b></td>
        </tr>
        <tr>
            <td class="ln-bottom">4. Keahlian Khusus</td>
            <td class="ln-bottom" style="width: 2%; text-align:center">:</td>
            <td class="ln-bottom"><b>{{ $detail_pengajuan->keahlian_khusus }}</b></td>
        </tr>
        <tr>
            <td class="ln-bottom">5. Pengalaman</td>
            <td class="ln-bottom" style="width: 2%; text-align:center">:</td>
            <td class="ln-bottom"><b>{{ $detail_pengajuan->pengalaman }}</b></td>
        </tr>
        <tr>
            <td class="ln-bottom">6. Kemampuan Bahasa</td>
            <td class="ln-bottom" style="width: 2%; text-align:center">:</td>
            <td class="ln-bottom"><b>- Bahasa Inggirs : {{ $detail_pengajuan->kemampuan_bahasa_ing }}</b></td>
        </tr>
        <tr>
            <td class="ln-bottom"></td>
            <td class="ln-bottom" style="width: 2%; text-align:center">:</td>
            <td class="ln-bottom"><b>- Bahasa Indonesia : {{ $detail_pengajuan->kemampuan_bahasa_ind }}</b></td>
        </tr>
        <tr>
            <td class="ln-bottom"></td>
            <td class="ln-bottom" style="width: 2%; text-align:center">:</td>
            <td class="ln-bottom"><b>- Lain - lain : {{ $detail_pengajuan->kemampuan_bahasa_lain }}</b></td>
        </tr>
        <tr>
            <td class="ln-bottom">7. Kepribadian</td>
            <td class="ln-bottom" style="width: 2%; text-align:center">:</td>
            <td class="ln-bottom"><b>{{ $detail_pengajuan->kepribadian }}</b></td>
        </tr>
        <tr>
            <td class="ln-bottom">8. Catatan</td>
            <td class="ln-bottom" style="width: 2%; text-align:center">:</td>
            <td class="ln-bottom"><b>{{ $detail_pengajuan->catatan }}</b></td>
        </tr>
    </table>
    <br>
    <table style="border: 1px solid black; border-collapse: collapse; width: 100%; font-size: 12px" cellpadding="3">
        <tr>
            <td style="width: {{ $witdhColumn }}%; text-align: center" class="ln-bottom ln-right">Yang mengajukan,</td>
            @foreach ($approver as $head)
            <td style="text-align: center; width: {{ $witdhColumn }}%" class="ln-bottom ln-right">Menyetujui,</td>
            @endforeach
            <td style="text-align: center; width: {{ $witdhColumn }}%" class="ln-bottom">Mengetahui,</td>
        </tr>
        <tr>
            <td style="height: 50px" class="ln-bottom ln-right"></td>
            @foreach ($approver as $space)
            <td class="ln-bottom ln-right"></td>
            @endforeach
            <td style="height: 50px" class="ln-bottom"></td>
        </tr>
        <tr>
            <td class="ln-bottom ln-right" style="text-align: center">{{ $detail_pengajuan->user_create->karyawan->nm_lengkap }}</td>
            @foreach ($approver as $pejabat)
            <td class="ln-bottom ln-right" style="text-align: center">{{ $pejabat->get_profil_employee->nm_lengkap }}</td>
            @endforeach
            <td class="ln-bottom" style="text-align: center">{{ $knowing->get_profil_employee->nm_lengkap }}</td>
        </tr>
        <tr>
            <td class="ln-bottom ln-right">Tgl. {{ date_format(date_create($detail_pengajuan->tanggal_pengajuan), 'd-m-Y') }}</td>
            @foreach ($approver as $tgl)
            <td class="ln-bottom ln-right">Tgl. {{ date_format(date_create($tgl->approval_date), 'd-m-Y') }}</td>
            @endforeach
            <td class="ln-bottom">Tgl. {{ date_format(date_create($knowing->approval_date), 'd-m-Y') }}</td>
        </tr>
    </table>
</main>
 </html>
