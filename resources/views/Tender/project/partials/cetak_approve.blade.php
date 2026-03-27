@php
$fl_logo = App\Helpers\Hrdhelper::get_profil_perusahaan()->logo_perusahaan;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <!-- Typography CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/typography.css') }}"/> --}}
    <!-- Style CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/tender.css') }}" /> --}}
    <style>
        @page {
            margin: 0cm 0cm;
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
    {{-- <header>
		<div style="display: flex;flex-direction: row;justify-content: center;text-align: right;">
			<div style="flex:1;">&nbsp;</div>
			<div style="flex:1;padding-bottom: 1.5rem;">
				<h6 style="margin-bottom:0cm;">PT. SUMBER SETIA BUDI</h6>
	            <p style="margin-bottom:0cm;padding-bottom:0cm;">https://pt-ssb.co.id</p>
	            <p style="margin-bottom:0cm;padding-bottom:0cm;">POMALA - KOLAKA</p>
	            <p style="margin-bottom:0cm;padding-bottom:0cm;">Sulawesi Tenggara, Indonesia</p>
			</div>
		</div>
    </header> --}}

    <header>
        <div class="information">
            <table width="100%">
                <tr>
                    <td align="left" style="width: 50%;">
                        <img src="{{ url(Storage::url('logo_perusahaan/'.$fl_logo)) }}" alt="Logo" width="100px" width="auto" class="logo" />
                    </td>
                    <td align="right" style="width: 50%;">
                        <h2>PT. SUMBER SETIA BUDI</h2>
                        https://pt-ssb.co.id<br>
                        POMALA - KOLAKA - SULAWESI TENGGARA - INDONESIA
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

    {{-- <img src="{{ asset('upload/logo_perusahaan/'.$fl_logo) }}" alt="Logo" width="64" class="logo"/> --}}
    <h4 class="font-poppins" style="text-align: center;margin-top:2rem;text-transform:uppercase;font-family:'Poppins', sans-serif;">
        Persetujuan Project
    </h4>

    <br />
    <table style="width:100%;border:none;margin-bottom:2rem;">
        <tbody>
            <tr>
                <td style="width:20%;">Nama Project</td>
                <td style="width:40%;">{{ $project->name }}</td>
            </tr>
            <tr>
                <td>Tanggal Project</td>
                <td>
                    {{ date("d/m/Y", strtotime($project->created_at)) }}
                </td>
            </tr>
            <tr>
                <td>Customer</td>
                <td>{{ $project->customer->company_name }}</td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%; border-collapse:collapse;font-family:'Poppins', sans-serif;" border="1">

        <thead>
            <tr>
                <th style="text-align:left;padding:.4rem;">Nama</th>
                <th style="text-align:left;padding:.4rem;">Jabatan</th>
                <th style="text-align:left;padding:.4rem;">Tgl Rekomendasi</th>
                <th style="text-align:left;padding:.4rem;">Rekomendasi</th>
                <th style="text-align:left;padding:.4rem;">Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($approval as $dt)
            @if( !is_null($dt->hasil) && $dt->hasil == "1" )
            @php
            $hasil = "Setuju"
            @endphp
            @elseif(!is_null($dt->hasil) && $dt->hasil == "0")
            @php
            $hasil = "Tolak"
            @endphp
            @elseif(is_null($dt->hasil))
            @php
            $hasil = "Belum memberikan rekomendasi persetujuan"
            @endphp
            @endif
            <tr>
                <td style="padding:.4rem;vertical-align:top;">{{ ucfirst($dt->nama_komite) }}</td>
                <td style="padding:.4rem;vertical-align:top;">{{ ucfirst($dt->jabatan) }}</td>
                <td style="padding:.4rem;vertical-align:top;">{{ !empty($dt->tgl_approval) ? date("d/m/Y", strtotime($dt->tgl_approval)) : "" }}</td>
                <td style="padding:.4rem;vertical-align:top;">{{ $hasil }}</td>
                <td style="padding:.4rem;vertical-align:top;">{{ $dt->note }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <footer>
        Hal <span class="pagenum"></span>
    </footer>
</body>
