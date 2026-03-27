<!DOCTYPE html>
 <html lang="en">
 <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>SSB | Smart System Base | HRD | Recruitment | Rekapitulasi Hasil Tes</title>
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
    <table style="width: 100%;" class="isi">
        <tr>
            <td colspan="2" style="text-align: center; font-size:large"><b>REKAPITULASI HASIL TES</b></td>
        </tr>
        <tr>
            <td colspan="2" style="height: 20px"></td>
        </tr>
        <tr>
            <td style="width: 15%">Departemen</td>
            <td>: <b>{{ $departemen->nm_dept }}</b></td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>: <b>{{ $jabatan->nm_jabatan }}</b></td>
        </tr>
    </table>
    <table style="border: 1px solid black; border-collapse: collapse; width: 100%; font-size: 12px" cellpadding="3">
        <thead>
            <tr>
                <td style="text-align: center; width: 4%; vertical-align: middle" rowspan="3" class="ln-right">NO</td>
                <td style="text-align: center; width: 5%; vertical-align: middle" rowspan="3" class="ln-right">PHOTO</td>
                <td style="text-align: center; vertical-align: middle" rowspan="3" class="ln-right">NAMA</td>
                <td style="width: 5%; text-align: center; vertical-align: middle" rowspan="3" class="ln-right">USIA</td>
                <td style="text-align: center; width: 15%; vertical-align: middle" rowspan="3" class="ln-right">PENDIDIKAN TERAKHIR</td>
                <td style="text-align: center;" colspan="4" class="ln-right">HASIL TES</td>
                <td style="text-align: center; width: 5%; vertical-align: middle" rowspan="3" class="ln-right">TOTAL SKOR</td>
                <td style="text-align: center; width: 5%; vertical-align: middle" rowspan="3" class="ln-right">RANK</td>
            </tr>
            <tr>
                <td style="text-align: center;" colspan="2" class="ln-right ln-top">PSIKOTES</td>
                <td style="text-align: center;" colspan="2" class="ln-right ln-top">WAWANCARA</td>
            </tr>
            <tr>
                <td style="text-align: center; width: 5%;" class="ln-right ln-top">NILAI</td>
                <td style="text-align: center;  width: 15%" class="ln-right ln-top">KETERANGAN</td>
                <td style="text-align: center; width: 5%;" class="ln-right ln-top">NILAI</td>
                <td style="text-align: center;  width: 15%" class="ln-right ln-top">KETERANGAN</ttdh>
            </tr>
        </thead>
        <tbody>
            @php($nom=1)
            @foreach ($list as $list)
            <tr>
                <td style="text-align: center" class="ln-top ln-right">{{ $nom }}</td>
                <td style="text-align: center" class="ln-top ln-right"><img src="{{ url(Storage::url("hrd/pelamar/photo/".$list->file_photo)) }}" style="width: 50px; height: auto" alt="avatar"></td>
                <td class="ln-top ln-right">{{ $list->nama_lengkap }}</td>
                <td style="text-align: center" class="ln-top ln-right">{{ \App\Helpers\Hrdhelper::get_umur_karyawan($list->tanggal_lahir) }}</td>
                <td style="text-align: center" class="ln-top ln-right">{{ $list->get_pendidikan_akhir($list->id_jenjang) }}</td>
                <td class="ln-top ln-right" style="text-align: center">{{ $list->psikotes_nilai }}</td>
                <td class="ln-top ln-right">{{ $list->psikotes_ket }}</td>
                <td class="ln-top ln-right" style="text-align: center">{{ $list->wawancara_nilai }}</td>
                <td class="ln-top ln-right">{{ $list->wawancara_ket }}</td>
                <td class="ln-top ln-right" style="text-align: center">{{ $list->total_skor }}</td>
                <td class="ln-top" style="text-align: center">{{ $nom }}</td>
            </tr>
            @php($nom++)
            @endforeach
        </tbody>
    </table>
    <br>
    <table style="width: 100%;">
        <tr>
            <td colspan="2">Pomala, {{ date("d M Y") }}</td>
        </tr>
        <tr>
            <td style="width: 50%">Dibuat oleh,</td>
            <td>Diketahui oleh,</td>
        </tr>
        <tr>
            <td colspan="2" style="height: 50px"></td>
        </tr>
        <tr>
            <td style="width: 50%"><b>{{ auth()->user()->karyawan->nm_lengkap }}</b></td>
            <td><b>{{ $al['nama_pejabat']}}</b></td>
        </tr>
        <tr>
            <td style="width: 50%"><b>{{ auth()->user()->karyawan->get_jabatan->nm_jabatan }}</b></td>
            <td><b>{{ $al['jabatan_pejabat']}}</b></td>
        </tr>
    </table>
</main>
 </html>
