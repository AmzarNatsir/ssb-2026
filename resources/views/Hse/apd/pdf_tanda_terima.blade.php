@php
	$fl_logo = App\Helpers\Hrdhelper::get_profil_perusahaan()->logo_perusahaan;
@endphp
@php
/*$printed_by = auth()->user()->karyawan->nm_lengkap;*/
$printed_date = date_format(now(),"d/m/Y H:i:s");
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page {
           margin-top: 10px;
           margin-left: 15px;
           margin-right: 15px;
        }

        table {
            font-size: 10px;
            font-family: 'Poppins', sans-serif;
        }

        table td, th {
            padding: 5px;
        }
        .section-label {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            margin:10px 0px 5px 0px;
            padding:0px;
        }
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
                        https://pt-ssb.co.id<br>
                        POMALA - KOLAKA - SULAWESI TENGGARA - INDONESIA
                </td>
            </tr>
            <tr><td colspan="2"><hr></td></tr>
        </table>
    </div>
</header>
<main>



    <h4 class="card-title" style="text-align: center;margin:15px 0px 0px 0px;text-transform:uppercase;font-family:'Poppins', sans-serif;">
        TANDA TERIMA APD
    </h4>
    <h5 class="card-title" style="text-align: center;margin:0px;text-transform:uppercase;font-family:'Poppins', sans-serif;">
        PT. SUMBER SETIA BUDI
    </h5>

    <table style="width: 100%; margin-top:10px; border-collapse:collapse;text-align:left;font-family:'Poppins', sans-serif;text-transform:uppercase;" border="1">
        <thead>
            <tr>
                <th align="left">tanggal</th>
                <th align="left">nik</th>
                <th align="left">nama</th>
                <th align="left">project</th>
                <th align="left">jabatan</th>
                <th align="left">nama barang</th>
                <th align="left" colspan="2">qty</th>
                <th align="left">paraf</th>
                <th align="left">no registrasi</th>
                <th align="left">keterangan</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($query as $key=>$value)
            <tr>
                <td>{{ $value['tanggal_keluar']}}</td>
                <td>{{ $value['karyawan']['nik']}}</td>
                <td>{{ $value['karyawan']['nm_lengkap']}}</td>
                <td>{{ $value['project']['name']}}</td>
                <td></td>
                <td>{{ $value['apd']['nama_apd']}}</td>
                <td>{{ $value['qty_out']}}</td>
                <td></td>
                <td></td>
                <td>{{ $value['no_register']}}</td>
                <td>{{ $value['keterangan']}}</td>
            </tr>
        @endforeach
        </tbody>
        {{-- <thead>
            <tr>
                <td style="width:13%;">NO UNIT</td>
                <td style="width:28%;"></td>
                <td style="width:13%;">HM AWAL</td>
                <td>{{ $hm_awal }}</td>
                <td style="width:13%;">OPERATOR</td>
                <td>{{ $officer }}</td>
            </tr>
            <tr>
                <td>TYPE/JENIS</td>
                <td>{{ $equipment_type." / ".$equipment_jenis  }}</td>
                <td>HM AKHIR</td>
                <td>{{ $hm_akhir }}</td>
                <td>BN</td>
                <td></td>
            </tr>
            <tr>
                <td>TGL/BLN</td>
                <td></td>
                <td></td>
                <td></td>
                <td>LOKASI</td>
                <td>{{ $location }}</td>
            </tr>
        </thead> --}}
    </table>


<footer>
    {{-- <span class="printed_by">printed by : {{ auth()->user()->nama }} {{ date("d/m/Y H:i:s", strtotime(now())) }}</span> --}}
    Hal <span class="pagenum"></span>
</footer>
</main>
