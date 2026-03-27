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
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    {{-- <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/tender.css') }}"/> --}}
    <style>
    	@page {
           margin: 0px;
        }

        body {
            margin : 110px 50px;
            font-size: 12px;
            font-family: 'Poppins', sans-serif;
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
            bottom:1cm;
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

        .font-poppins {
            font-family: 'Poppins', sans-serif;
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
        <h3 class="card-title" style="text-align: center;margin-top:2rem;">
            BILL OF QUANTITY (BOQ)
        </h3>
        @php
            $total_qty = 0;
            $total_target = 0;
            $total_price = 0;
            $total_cost = 0;
        @endphp
        <table style="width: 100%; border-collapse:collapse" border="1">
            <thead>
                <tr>
                    <th style="width:4%;text-align: center;padding:6px;">No</th>
                    <th style="width:40%;text-align: center;">Uraian</th>
                    <th>Jumlah</th>
                    <th>Target</th>
                    <th>Harga</th>
                    <th>Biaya (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bill as $bill)
                @if($bill->detail->count())
                    @foreach($bill->detail as $item)
                    <tr>
                        <td style="text-align: center;vertical-align:top;padding:6px;">{{ $loop->index + 1 }}</td>
                        <td style="vertical-align:top;padding:6px;">{!! $item->desc !!}</td>
                        <td style="text-align: center;vertical-align:top;padding:6px;">{!! $item->qty !!}</td>
                        <td style="text-align: center;vertical-align:top;padding:6px;">{{ number_format($item->target) }}</td>
                        <td style="text-align: center;vertical-align:top;padding:6px;">{!! number_format($item->price) !!}</td>
                        <td style="text-align: center;vertical-align:top;padding:6px;">{!! number_format($item->cost) !!}</td>
                    </tr>
                    @php
                        $total_qty += $item->qty;
                        $total_target += $item->target;
                        $total_price += $item->price;
                        $total_cost += $item->cost;
                    @endphp
                    @endforeach
                @endif
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" style="width:100%;padding:6px;">TOTAL HARGA SEBELUM PPN</th>
                    <th>{{ number_format($total_qty) }}</th>
                    <th>{{ number_format($total_target) }}</th>
                    <th>{{ number_format($total_price) }}</th>
                    <th>{{ number_format($total_cost) }}</th>
                </tr>
                <tr>
                    <th colspan="4" style="padding:6px;">PPN 10%</th>
                    <th>{{ number_format($total_price) }}</th>
                    <th>{{ number_format($total_cost) }}</th>
                </tr>
                <tr>
                    <th colspan="4" style="padding:6px;">TOTAL HARGA SETELAH PPN</th>
                    <th>{{ number_format($total_price + ($total_price*10/100)) }}</th>
                    <th>{{ number_format($total_cost + ($total_cost*10/100)) }}</th>
                </tr>
            </tfoot>
        </table>
	<footer>
        <span class="printed_by">printed by : {{ auth()->user()->nama }} {{ date("d/m/Y H:i:s", strtotime(now())) }}</span>
		Hal <span class="pagenum"></span>
	</footer>
</main>
