@php
$fl_logo = App\Helpers\Hrdhelper::get_profil_perusahaan()->logo_perusahaan;
$total_1 = $result->gaji_pokok + $result->tunj_perusahaan + $result->hours_meter + $result->lembur;
$total_bpjs = $result->bpjsks_karyawan + $result->bpjstk_jht_karyawan + $result->bpjstk_jp_karyawan
@endphp
<!DOCTYPE html>
 <html lang="en">
 <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>SSB | Smart System Base | HRD | Perubahan Status | Surat Keputusan</title>
<style>
    @page {
        margin: 0px;
    }
    body {
        margin : 110px 110px;
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
    <table width='100%' style='border-collapse:collapse; font-size:13px"'>
        <tr>
            <td style="width: 30%">PT. SUMBER SETIA BUDI</td>
            <td rowspan="2" style="text-align: center; font-size:15px"><b>SLIP GAJI</b>
            <br>
            {{ \App\Helpers\Hrdhelper::get_nama_bulan($result->bulan) }} {{ $result->tahun }}</td>
            <td style="width: 10%">Tanggal</td>
            <td style="width: 2%">:</td>
            <td style="width: 18%">{{ date_format(date_create($result->created_at), 'd-m-Y') }}</td>
        </tr>
        <tr>
            <td>Jl. Dawi-Dawi Pomala</td>
            <td>No</td>
            <td>:</td>
            <td>{{ sprintf('%09s', $result->id) }}</td>
        </tr>
        <tr>
            <td colspan="5"><hr style="border-collapse: collapse; border:solid;"></td>
        </tr>
    </table>
    <table width='100%' style='border-collapse:collapse; font-size:13px"'>
        <tr>
            <td style="width:13%">Nama/NIK</td>
            <td style="width:2%">:</td>
            <td style="width: 35%"><b>{{ $result->get_profil->nm_lengkap."/".$result->get_profil->nik }}</b></td>
            <td style="width:13%">Alamat</td>
            <td style="width:2%">:</td>
            <td style="width:35%"><b>{{ $result->get_profil->alamat }}</b></td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td><b>{{ $result->get_profil->get_jabatan->nm_jabatan }}</b></td>
            <td>Telepon</td>
            <td>:</td>
            <td><b>{{ $result->get_profil->no_telp }}</b></td>
        </tr>
        <tr>
            <td colspan="6"><hr style="border-collapse: collapse; border:solid;"></td>
        </tr>
    </table>
    <table width='100%' style='border-collapse:collapse; font-size:13px"'>
        <tr>
            <td style="width:5%">NO</td>
            <td style="width:70%">KETERANGAN</td>
            <td style="width:25%; text-align:right">JUMLAH</td>
        </tr>
        <tr>
            <td colspan="3"><hr style="border-collapse: collapse; border:solid;"></td>
        </tr>
        <tr>
            <td>1</td>
            <td>Gaji Pokok</td>
            <td style="text-align:right;"><b>{{ number_format($result->gaji_pokok, 0, ",", ".") }}</b></td>
        </tr>
        <tr>
            <td>2</td>
            <td>Tunjangan Perusahaan</td>
            <td style="text-align:right;"><b>{{ number_format($result->tunj_perusahaan, 0, ",", ".") }}</b></td>
        </tr>
        <tr>
            <td>3</td>
            <td>Hours Meter</td>
            <td style="text-align:right;"><b>{{ number_format($result->hours_meter, 0, ",", ".") }}</b></td>
        </tr>
        <tr>
            <td>4</td>
            <td>Lembur</td>
            <td style="text-align:right;"><b>{{ number_format($result->lembur, 0, ",", ".") }}</b></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td style="text-align:right;"><hr style="border-collapse: collapse; border:solid;"><b>{{ number_format($total_1, 0, ",", ".") }}</b></td>
        </tr>
        <tr>
            <td colspan="3" style="height:30px"></td>
        </tr>
        <tr>
            <td>4</td>
            <td>BPJS</td>
            <td style="text-align:right;"><b>{{ number_format($total_bpjs, 0, ",", ".") }}</b></td>
        </tr>
        <tr>
            <td>5</td>
            <td>Sedekah Bulanan</td>
            <td style="text-align:right;"><b>{{ number_format($result->pot_sedekah, 0, ",", ".") }}</b></td>
        </tr>
        <tr>
            <td>6</td>
            <td>PKK</td>
            <td style="text-align:right;"><b>{{ number_format($result->pot_pkk, 0, ",", ".") }}</b></td>
        </tr>
        <tr>
            <td>7</td>
            <td>Air</td>
            <td style="text-align:right;"><b>{{ number_format($result->pot_air, 0, ",", ".") }}</b></td>
        </tr>
        <tr>
            <td>8</td>
            <td>Rumah</td>
            <td style="text-align:right;"><b>{{ number_format($result->pot_rumah, 0, ",", ".") }}</b></td>
        </tr>
        <tr>
            <td>8</td>
            <td>Toko Alif</td>
            <td style="text-align:right;"><b>{{ number_format($result->pot_toko_alif, 0, ",", ".") }}</b></td>
        </tr>
        @php
        $total_2=$total_bpjs + $result->pot_sedekah + $result->pot_pkk + $result->pot_air + $result->pot_rumah + $result->pot_toko_alif;
        @endphp
        <tr>
            <td></td>
            <td></td>
            <td style="text-align:right;"><hr style="border-collapse: collapse; border:solid;"><b>{{ number_format($total_2, 0, ",", ".") }}</b></td>
        </tr>
        <tr>
            <td colspan="3"><hr style="border-collapse: collapse; border:solid;"></td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align:right"><b>TOTAL DITERIMA</b></td>
            <td style="text-align:right;"><b>{{ number_format($total_1 - $total_2, 0, ",", ".") }}</b></td>
        </tr>
        <tr>
            <td colspan="3"><hr style="border-collapse: collapse; border:solid;"></td>
        </tr>
    </table>
</main>
</body>
</html>
