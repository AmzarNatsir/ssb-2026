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
            font-size: 12px;
            font-family: 'Poppins', sans-serif;
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
    @php
    $hm_awal = $p2h[0]['checkpoints'][0]['properties']['hm_awal'];
    $hm_akhir = $p2h[0]['checkpoints'][0]['properties']['hm_akhir'];
    $officer = $p2h[0]['officer']['nm_lengkap'];
    $location = $p2h[0]['location']['location_name'];

    $equipment_type = $p2h[0]['equipment']['equipment_category']['name'];
    $equipment_jenis = $p2h[0]['equipment']['code']." ".$p2h[0]['equipment']['name'];

    // section 1
    $section_name = $p2h[0]['checkpoints'][1]['checkpointItems'][0]['name'];
    $section_label = $p2h[0]['checkpoints'][1]['checkpointItems'][0]['label'];
    $checkpoints = $p2h[0]['checkpoints'][1]['properties'];

    // section 2
    $section_name_2 = $p2h[0]['checkpoints'][2]['checkpointItems'][0]['name'];
    $section_label_2 = $p2h[0]['checkpoints'][2]['checkpointItems'][0]['label'];
    $checkpoints_2 = $p2h[0]['checkpoints'][2]['properties'];

    // section 3
    $section_name_3 = $p2h[0]['checkpoints'][3]['checkpointItems'][0]['name'];
    $section_label_3 = $p2h[0]['checkpoints'][3]['checkpointItems'][0]['label'];
    $checkpoints_3 = $p2h[0]['checkpoints'][3]['properties'];
    //dd($checkpoints);
    @endphp

    <h4 class="card-title" style="text-align: center;margin-top:15px;text-transform:uppercase;font-family:'Poppins', sans-serif;">
        CHECKLIST DAILY {{ $equipment_type }}
    </h4>

    <table style="width: 100%; border-collapse:collapse;font-family:'Poppins', sans-serif;" border="0">
        <thead>
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
        </thead>
    </table>

    {{--  CHECKPOINT 1 --}}
    <h5 class="section-label">{{ $section_label }}</h5>
    <table style="width: 100%; border-collapse:collapse; margin-top:0px;" border="1">
        <thead>
            <tr>
                <th colspan="2" style="text-transform:uppercase;">{{ $section_name }}</th>
                <th>BAIK</th>
                <th>TDK BAIK</th>
                <th>KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
        @php $no = 1; @endphp
        @foreach($checkpoints as $key => $value)
            <tr>
                <td style="width:3%;text-align:center;">{{ $no++ }}</td>
                <td style="width:35%;padding:0px 5px;text-transform:capitalize;">{{ str_replace("_", " ", $key) }}</td>
                <td style="width:12%;text-align:center;">
                    {{ $value === "1" ? "v" : "" }}
                </td>
                <td style="width:12%;text-align:center;">
                    {{ $value === "2" ? "v" : "" }}
                </td>
                <td></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{-- CHECKPOINT 2 --}}
    <h5 class="section-label">{{ $section_label_2 }}</h5>
    <table style="width: 100%; border-collapse:collapse; margin-top:10px;" border="1">
        <thead>
            <tr>
                <th colspan="2" style="text-transform:uppercase;">{{ $section_name_2 }}</th>
                <th>BAIK</th>
                <th>TDK BAIK</th>
                <th>KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
        @php $no = 1; @endphp
        @foreach($checkpoints_2 as $key => $value)
            <tr>
                <td style="width:3%;text-align:center;">{{ $no++ }}</td>
                <td style="width:35%;padding:0px 5px;text-transform:capitalize;">{{ str_replace("_", " ", $key) }}</td>
                <td style="width:12%;text-align:center;">
                    {{ $value === "1" ? "v" : "" }}
                </td>
                <td style="width:12%;text-align:center;">
                    {{ $value === "2" ? "v" : "" }}
                </td>
                <td></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{-- CHECKPOINT 3 --}}
    <h5 class="section-label">{{ $section_label_3 }}</h5>
    <table style="width: 100%; border-collapse:collapse; margin-top:10px;" border="1">
        <thead>
            <tr>
                <th colspan="2" rowspan="2" style="text-transform:uppercase;">{{ $section_name_3 }}</th>
                <th colspan="2">PERBAIKAN</th>
                <th rowspan="2">KETERANGAN</th>
            </tr>
            <tr>
                <th>YA</th>
                <th>TIDAK</th>
            </tr>
        </thead>
        <tbody>
        @php $no = 1; @endphp
        @foreach($checkpoints_3 as $key => $value)
            <tr>
                <td style="width:3%;text-align:center;">{{ $no++ }}</td>
                <td style="width:35%;padding:0px 5px;text-transform:capitalize;">{{ str_replace("_", " ", $key) }}</td>
                <td style="width:12%;text-align:center;">
                    {{ $value === "1" ? "v" : "" }}
                </td>
                <td style="width:12%;text-align:center;">
                    {{ $value === "2" ? "v" : "" }}
                </td>
                <td></td>
            </tr>
        @endforeach
        </tbody>
    </table>
<footer>
    {{-- <span class="printed_by">printed by : {{ auth()->user()->nama }} {{ date("d/m/Y H:i:s", strtotime(now())) }}</span> --}}
    Hal <span class="pagenum"></span>
</footer>
</main>
