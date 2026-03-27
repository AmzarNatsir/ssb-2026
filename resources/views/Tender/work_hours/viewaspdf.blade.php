@php
$fl_logo = App\Helpers\Hrdhelper::get_profil_perusahaan()->logo_perusahaan;
@endphp

@php
$printed_by = auth()->user()->karyawan->nm_lengkap;
$printed_date = date_format(now(),"d/m/Y H:i:s");
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        @page {
            margin: 0px;
        }

        .pagenum:before {
            content: counter(page);
        }

        header {
            position: fixed;
            top: 0.5cm;
            left: 0.5cm;
            right: 0.5cm;
            height: 2cm;
        }

        footer {
            position: fixed;
            bottom: 1cm;
            text-align: center;
        }

        .printed_by {
            position: fixed;
            bottom: 1cm;
            right: 1cm;
            text-align: right;
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

        body {
            /*margin : 150px 50px;*/
            font-size: 12px;
            font-family: 'Poppins', sans-serif;
            margin-top: 3cm;
            margin-left: 1cm;
            margin-right: 1cm;
            margin-bottom: 2cm;
        }

        .font-poppins {
            font-family: 'Poppins', sans-serif;
        }

    </style>
</head>
<body>

    <header>
        <div class="information">
            <table width="100%">
                <tr>
                    <td align="left" style="width: 50%;">
                        <img src="{{ url(Storage::url('logo_perusahaan/'.$fl_logo)) }}" alt="Logo" width="100px" width="auto" class="logo" />
                    </td>
                    <td align="right" style="width: 50%;">
                        <h2>PT. SUMBER SETIA BUDI</h2>
                        {{-- <pre> --}}
                        https://pt-ssb.co.id<br>
                        POMALA - KOLAKA - SULAWESI TENGGARA - INDONESIA
                        {{-- </pre> --}}
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr>
                    </td>
                </tr>
            </table>
        </div>
    </header>
    <main>
        <h3 class="card-title" style="text-align: center;margin-top:2rem;">Laporan Operasional Harian</h5>

    </main>
    <table style="width: 100%; border-collapse:collapse" border="0">
        <tbody>
            <tr>
                <td style="width:10%;">Tanggal</td>
                <td style="width:40%;">{{ date("d/m/Y H:i:s", strtotime($fulfillment[0]->created_at)) }}</td>
            </tr>
            <tr>
                <td style="width:10%;">Nomor Project</td>
                <td style="width:40%;">{{ $fulfillment[0]->project->number }}</td>
            </tr>
            <tr>
                <td style="width:10%;">Entry By</td>
                <td style="width:40%;">{{ strtoupper($fulfillment[0]->user->karyawan->nm_lengkap) }}</td>
            </tr>
            <tr>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>

    <h3 class="card-title" style="text-align: center;margin-top:2rem;">
        Laporan Harian Operasional
    </h3>
    <table style="width: 100%; border-collapse:collapse" border="1">
        <thead>
            <tr>
                <th style="width:4%;text-align: center;padding:6px;">NO.</th>
                <th>KATEGORI</th>
                <th>CODE</th>
                <th>NAMA</th>
                <th>CHASSIS NO</th>
                <th>ENGINE NO</th>
                <th>YOP</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach($fulfillment[0]->details as $key => $detail)
             <tr>
                <td style="text-align: center;vertical-align:top;padding:6px;">{{ $loop->index + 1 }}</td>
            <td style="text-align: center;vertical-align:top;padding:6px;">{{ strtoupper($detail->equipment->equipment_category->name) }}</td>
            <td style="text-align: center;vertical-align:top;padding:6px;">{{ $detail->equipment->code }}</td>
            <td style="text-align: center;vertical-align:top;padding:6px;">{{ $detail->equipment->name }}</td>
            <td style="text-align: center;vertical-align:top;padding:6px;">{{ $detail->equipment->chassis_no }}</td>
            <td style="text-align: center;vertical-align:top;padding:6px;">{{ $detail->equipment->engine_no }}</td>
            <td style="text-align: center;vertical-align:top;padding:6px;">{{ $detail->equipment->yop }}</td>
            </tr>
        </tbody>
        @endforeach --}}
    </table>
    <footer>
        <span class="printed_by">printed by : {{ $printed_by }} {{ date("d/m/Y H:i:s", strtotime(now())) }}</span>
        Hal <span class="pagenum"></span>
    </footer>
</body>
</html>
