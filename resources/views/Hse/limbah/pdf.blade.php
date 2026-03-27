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
           margin-left: 10px;
           margin-right: 5px;
        }

        main {
            margin-top: 8rem;
            margin-left: 4rem;
            margin-right: 4rem;
        }

        table {
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            font-weight: normal;
        }

        .section-label {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            margin:10px 0px 5px 0px;
            padding:0px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 1cm;
            right: 0cm;
            /*height: 1cm;*/
            color: black;
            text-align: left;
            line-height: 1.5cm;
        }
    </style>
</head>

{{-- <header>
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
</header> --}}
<main>
    @php

        $nama_perusahaan = $bast[0]['perusahaan_angkutan']['nama'];
        $nama_pimpinan = $bast[0]['perusahaan_angkutan']['nama_pimpinan'];
        $alamat_prsh_angkut = $bast[0]['perusahaan_angkutan']['alamat'];

    @endphp

    <h4 class="card-title" style="text-align: center;margin-top:15px;margin-bottom: 2rem;text-transform:uppercase;font-family:'Poppins', sans-serif;">
        BERITA ACARA PENGANGKUTAN LIMBAH B3
    </h4>

    <p>yang bertanda tangan dibawah ini :</p>

    <table style="width: 100%; border-collapse:collapse;font-family:'Poppins', sans-serif;" border="0">
        <thead>
            <tr>
                <td style="width:13%;">Nama</td>
                <td style="width:2%;">:</td>
                <td >Andrie</td>
            </tr>
            <tr>
                <td style="width:13%;">Jabatan</td>
                <td style="width:2%;">:</td>
                <td >HSE</td>
            </tr>
            <tr>
                <td style="width:13%;">Alamat</td>
                <td style="width:2%;">:</td>
                <td>JL. Protokol</td>
            </tr>
        </thead>
    </table>

    <p>menyatakan bahwa :</p>

    <table style="width: 100%; border-collapse:collapse;font-family:'Poppins', sans-serif;" border="0">
        <thead>
            <tr>
                <td style="width:13%;">Nama</td>
                <td style="width:2%;">:</td>
                <td>{{ $nama_perusahaan }}</td>
            </tr>
            <tr>
                <td style="width:13%;">Pimpinan</td>
                <td style="width:2%;">:</td>
                <td>{{ $nama_pimpinan }}</td>
            </tr>
            <tr>
                <td style="width:13%;">Alamat</td>
                <td style="width:2%;">:</td>
                <td>{{ $alamat_prsh_angkut }}</td>
            </tr>
        </thead>
    </table>

    <p style="margin-top:2rem;">Bahwa benar telah mengangkut Limbah B3 milik PT. Sumber Setia Budi, untuk rincian limbah B3 sebagai berikut :</p>

    {{--  CHECKPOINT 1 --}}
    <h5 class="section-label"></h5>
    <table style="width: 100%; border-collapse:collapse; margin-top:0px;" border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Limbah B3</th>
                <th>Jenis Limbah B3</th>
                <th colspan="2">QTY</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
        @php $no = 1; @endphp
        @foreach($bast as $key => $value)
            <tr>
                <td style="width:5%;text-align:center;">{{ $no++ }}</td>
                <td style="width:22%;padding:0px 5px;text-transform:capitalize;">
                    {{ $value['limbah']['kode'] }}
                </td>
                <td style="width:22%;text-align:center;">
                    {{ $value['limbah']['nama'] }}
                </td>
                <td style="width:10%;text-align:center;">{{ $value['qty'] }}</td>
                <td style="width:10%;text-align:center;">{{ $value['limbah']['unit']['nama'] }}</td>
                <td>
                    {{ $value['plan']['keterangan'] }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <p style="margin-top:2rem;margin-bottom:5rem;">Demikian Surat keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>


    <table style="width: 100%; text-align:left; border-collapse:collapse;font-family:'Poppins', sans-serif;" border="0">
        <tbody>
            <tr>
                <th colspan="2" style="text-align:left;">Pomalaa, {{ date("d/m/Y", strtotime(now())) }}</th>
            </tr>
            <tr>
                <th style="width:70%;text-align:left;">PT. Sumber Setia Budi</th>
                <th style="width:30%;text-align:left;">Diterima oleh</th>
            </tr>
            <tr>
                <th style="height:4rem;">&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <tr>
                <th style="width:70%;text-align:left;">Andrie Chandra Sanjaya</th>
                <th style="width:30%;text-align:left;"></th>
            </tr>
            <tr>
                <th style="width:70%;text-align:left;">HSE</th>
                <th style="width:30%;text-align:left;">{{ $nama_perusahaan }}</th>
            </tr>
        </tbody>
    </table>

<footer>
    {{-- <span class="printed_by">printed by : {{ auth()->user()->nama }} {{ date("d/m/Y H:i:s", strtotime(now())) }}</span> --}}
    <span class="pagenum"></span>
</footer>
</main>
