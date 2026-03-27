@php
$fl_logo = App\Helpers\Hrdhelper::get_profil_perusahaan()->logo_perusahaan;
@endphp
<!DOCTYPE html>
 <html lang="en">
 <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>SSB | Smart System Base | HRD | Pelaporan | Payroll</title>
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
    <h3 class="card-title" style="text-align: center;">DAFTAR GAJI KARYAWAN</h3>
    <p><b>Periode : {{ $ket_periode }}</b></p>
    <p><b>Departemen : {{ $departemen }}</b></p>
    <table style="width: 100%; border-collapse:collapse" border="1" cellpadding="3">
        <thead>
            <tr>
                <td align="center" height='25px'>No</td>
                <td align="center">Karyawan</td>
                <td align="center">Posisi</td>
                <td align="center">Status</td>
                <td align="center">Gaji Pokok</td>
                <td align="center">Total Tunjangan</td>
                <td align="center">Total Potongan</td>
                <td align="center">THP</td>
            </tr>
        </thead>
        <tbody>
            @php $total=0; $total_gapok=0; $total_potongan=0; $total_tunjangan=0; $nom=1; @endphp
            @foreach ($list_data as $list)
            @php
            $tot_tunj = doubleval($list->tunj_perusahaan) + doubleval($list->tunj_tetap) + doubleval($list->hours_meter) + doubleval($list->lembur);
            $tot_pot = doubleval($list->bpjsks_karyawan) + doubleval($list->bpjstk_jht_karyawan) + doubleval($list->bpjstk_jp_karyawan) + doubleval($list->pot_sedekah) + doubleval($list->pot_pkk) + doubleval($list->pot_air) + doubleval($list->pot_rumah) + doubleval($list->pot_toko_alif);
            $thp = (doubleval($list->gaji_pokok) + doubleval($tot_tunj)) - doubleval($tot_pot);
            @endphp
            <tr>
                <td  align="center" height='20px'>{{ $nom }}</td>
                <td>{{ $list->get_profil->nik }} - {{ $list->get_profil->nm_lengkap}}</td>
                <td>{{ (!empty($list->get_profil->id_jabatan) ? $list->get_profil->get_jabatan->nm_jabatan : "") }}</td>
                <td style="text-align: center">
                    @php
                    $list_status = Config::get('constants.status_karyawan');
                    foreach($list_status as $key => $value)
                    {
                        if($key==$list->get_profil->id_status_karyawan)
                        {
                            $ket_status = $value;
                            break;
                        }
                    }
                    @endphp
                    {{ $ket_status }}</span>
                </td>
                <td style="text-align: right;"><b>{{ number_format($list->gaji_pokok, 0, ",", ".") }}</b></td>
                <td style="text-align: right;"><b>{{ number_format($tot_tunj, 0) }}</b></td>
                <td style="text-align: right;"><b>{{ number_format($tot_pot, 0) }}</b></td>
                <td style="text-align: right;"><b>{{ number_format($thp, 0, ",", ".") }}</b></td>
            </tr>
            @php $nom++;
            $total_gapok+=$list->gaji_pokok;
            $total+=$thp;
            $total_tunjangan+=$tot_tunj;
            $total_potongan+=$tot_pot;
            @endphp
            @endforeach
            <tr>
                <td colspan="4" style="text-align: right;"><b>TOTAL</b></td>
                <td style="text-align: right;"><b>{{ number_format($total_gapok, 0, ",", ".") }}</b></td>
                <td style="text-align: right;"><b>{{ number_format($total_tunjangan, 0, ",", ".") }}</b></td>
                <td style="text-align: right;"><b>{{ number_format($total_potongan, 0, ",", ".") }}</b></td>
                <td style="text-align: right;"><b>{{ number_format($total, 0, ",", ".") }}</b></td>
            </tr>
        </tbody>
    </table>
</main>
