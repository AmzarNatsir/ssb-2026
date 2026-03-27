@php
$fl_logo = App\Helpers\Hrdhelper::get_profil_perusahaan()->logo_perusahaan;
@endphp
<!DOCTYPE html>
 <html lang="en">
 <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>SSB | Smart System Base | HRD | Pelaporan | Daftar Karyawan</title>
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
    <h3 class="card-title" style="text-align: center;">DAFTAR KARYAWAN</h3>
    <p><b>Departemen : {{ $ket_departemen }}</b></p>
    <table style="width: 100%; border-collapse:collapse" border="1">
        <thead>
            <tr>
                <th style="width: 5%; height: 25px;">#</th>
                <th style="width: 10%;">NIK</th>
                <th style="width: 20%;">Nama Karyawan</th>
                <th style="width: 10%;">Gender</th>
                <th style="width: 20%;">Alamat/No.Telepon</th>
                <th style="width: 25%;">Jabatan</th>
                <th style="width: 10%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @php $nom=1; @endphp
            @foreach($list_karyawan as $list)
            <tr>
                <td style="text-align: center;">{{ $nom }}</td>
                <td style="text-align: center;">{{ $list->nik}}</td>
                <td>{{ $list->nm_lengkap}}</td>
                <td style="text-align: center;">{{ ($list->jenkel==1)? "Laki-Laki" : "Perempuan" }}</td>
                <td>{{ $list->alamat."/".$list->notelp}}</td>
                <td>{{ (empty($list->get_jabatan->nm_jabatan)) ? "" : $list->get_jabatan->nm_jabatan }}{{ (empty($list->get_departemen->nm_dept)) ? "" : " - ".$list->get_departemen->nm_dept }}</td>
                <td style="text-align: center;">
                @php
                $list_status = Config::get('constants.status_karyawan');
                foreach($list_status as $key => $value)
                {
                    if($key==$list->id_status_karyawan)
                    {
                        $ket_status = $value;
                        break;
                    }
                }
                @endphp
                {{ $ket_status }}
                </td>
            </tr>
            @php $nom++; @endphp
            @endforeach
        </tbody>
    </table>
    <!--
    <div class="page-break"></div>
    <h1>Page 2</h1>
    -->
</main>
