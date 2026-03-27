@php
$fl_logo = App\Helpers\Hrdhelper::get_profil_perusahaan()->logo_perusahaan;
@endphp
<!DOCTYPE html>
 <html lang="en">
 <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>SSB | Smart System Base | HRD | Pelaporan | Cuti/Izin Karyawan</title>
<style>
    @page {
        margin: 0px;
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
    <h3 class="card-title" style="text-align: center;">DATA {{ $ket_kategori}} KARYAWAN</h3>
    <p><b>Periode Bulan {{ $ket_bulan }} Tahun {{ $ket_tahun }}</b></p>
    <table style="width: 100%; border-collapse:collapse" border="1">
        <thead>
            <tr>
                <th scope="col" rowspan="2" style="width: 5%;">#</th>
                <th scope="col" rowspan="2" style="width: 30%;">Karyawan</th>
                <th scope="col" rowspan="2" style="width: 10%;">Pengajuan</th>
                <th scope="col" rowspan="2" style="width: 10%;">Jenis Izin</th>
                <th scope="col" colspan="2" style="text-align: center;">Jadwal Izin</th>
                <th scope="col" rowspan="2" style="width: 5%;">Jumlah Hari</th>
                <th scope="col" rowspan="2" style="width: 20%;">Keterangan</th>
            </tr>
            <tr>
                <th style="text-align: center; width: 10%;">Mulai</th>
                <th style="text-align: center; width: 10%;">Sampai</th>
            </tr>
        </thead>
        <tbody>
        @if(!empty($list_data))
            @php $nom=1; @endphp
            @foreach($list_data as $list)
            <tr>
                <td style="text-align:center">{{ $nom }}</td>
                <td>{{ $list->profil_karyawan->nik }} - {{ $list->profil_karyawan->nm_lengkap }}<br>
                {{ (!empty($list->profil_karyawan->get_jabatan->nm_jabatan)) ? $list->profil_karyawan->get_jabatan->nm_jabatan : "" }}{{ (!empty($list->profil_karyawan->id_departemen)) ? " - ".$list->profil_karyawan->get_departemen->nm_dept : "" }}
                </td>
                <td style="text-align:center">{{ date_format(date_create($list->tgl_pengajuan), 'd-m-Y') }}</td>
                <td>{{ $list->get_jenis_izin->nm_jenis_ci }}</td>
                <td style="text-align:center">{{ date_format(date_create($list->tgl_awal), 'd-m-Y') }}</td>
                <td style="text-align:center">{{ date_format(date_create($list->tgl_akhir), 'd-m-Y') }}</td>
                <td style="text-align:center">{{ $list->jumlah_hari }}</td>
                <td>{{ $list->ket_izin }}</td>
            </tr>
            @php $nom++; @endphp
            @endforeach
        @endif
        </tbody>
    </table>
    <!--
    <div class="page-break"></div>
    <h1>Page 2</h1>
    -->
</main>
