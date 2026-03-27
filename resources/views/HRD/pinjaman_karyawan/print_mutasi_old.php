@php
$fl_logo = App\Helpers\Hrdhelper::get_profil_perusahaan()->logo_perusahaan;
@endphp
<!DOCTYPE html>
 <html lang="en">
 <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>SSB | Smart System Base | HRD | Pinjaman Karyawan | Mutasi Pembayaran</title>
<style>
    @page {
        margin: 0px;
    }
    body {
        margin : 110px 100px;
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
    td.ln-top {
		border-top: 1px solid black;
    }
    td.ln-left {
        border-left: 1px solid black;
    }
    td.ln-right {
        border-right: 1px solid black;
    }
    td.ln-bottom {
        border-bottom: 1px solid black;
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
    <table style="width: 100%; border-collapse:collapse; font-size: 12px">
        <tr>
            <td colspan="6" align="center" ><h3>MUTASI PEMBAYARAN PINJAMAN KARYAWAN</h3></td>
        </tr>
        <tr>
            <td style="width: 15%; height: 22px;">Nomor</td>
            <td style="width: 2%">:</td>
            <td style="width: 30%">{{ $data->nomor_pinjaman }}</td>
            <td style="width: 18%;"></td>
            <td style="width: 2%"></td>
            <td></td>
        </tr>
        <tr>
            <td style="width: 15%; height: 22px;">Nama</td>
            <td style="width: 2%">:</td>
            <td style="width: 30%">{{ $data->getKaryawan->nm_lengkap }}</td>
            <td style="width: 18%;">Kategori Pinjaman</td>
            <td style="width: 2%">:</td>
            <td>{{ ($data->kategori==1) ? "Panjar Gaji" : "Pinjaman Kesejahteraan Karyawan (PKK)" }}</td>
        </tr>
        <tr>
            <td style="height: 22px;">NIK</td>
            <td>:</td>
            <td>{{ $data->getKaryawan->nik }}</td>
            <td>Jumlah Pinjaman</td>
            <td>:</td>
            <td>Rp. {{ number_format($data->nominal_apply, 0) }}</td>
        </tr>
        <tr>
            <td style="height: 22px;">Jabatan</td>
            <td>:</td>
            <td>{{ $data->getKaryawan->get_jabatan->nm_jabatan }}</td>
            <td>Alasan Pengajuan</td>
            <td>:</td>
            <td>{{ $data->alasan_pengajuan }}</td>
        </tr>
    </table>
    <br>
    <table style="border: 1px solid black; border-collapse: collapse; width: 100%; font-size: 13px" cellpadding="3">
        <thead>
            <td style="width: 5%; text-align: center" class="ln-right">No.</td>
            <td style="width: 20%; text-align: center" class="ln-right">Tgl.Jatuh Tempo</td>
            <td style="width: 30%; text-align: right" class="ln-right">Angsuran</td>
            <td style="width: 30%; text-align: right" class="ln-right">Oustanding</td>
            <td style="width: 15%; text-align: center" class="ln-right">Status</td>
        </thead>
        <tbody>
            @php($nom=1)
            @php($sisa = $data->nominal_apply)
            @foreach ($data->getMutasi as $row)
                @if($nom==1)
                    @if($row->status==1)
                        @php($sisa-=$row->nominal)
                    @else
                        @php($sisa = $sisa)
                    @endif
                @else
                    @if($row->status==1)
                        @php($sisa-=$row->nominal)
                    @else
                        @php($sisa=0)
                    @endif
                @endif
                @if($sisa < 0)
                    @php($sisa=0)
                @endif
                <tr>
                    <td style="text-align: center" class="ln-top ln-right">{{ $nom }}</td>
                    <td style="text-align: center" class="ln-top ln-right">{{ (!empty($row->tanggal)) ? date('d-m-Y', strtotime($row->tanggal)) : "" }}</td>
                    <td style="text-align: right" class="ln-top ln-right">{{ number_format($row->nominal, 0) }}</td>
                    <td style="text-align: right" class="ln-top ln-right">{{ number_format($sisa, 0) }}</td>
                    <td style="text-align: center" class="ln-top ln-right">
                        @if($row->status==1)
                            Terbayar
                        @endif
                    </td>
                </tr>
                @php($nom++)
            @endforeach
            @if($outstanding == 0)
            <tr>
                <td colspan="5" class="ln-top ln-right"><b>Status : LUNAS</b></td>
            </tr>
            @endif
        </tbody>
    </table>
    <br>
    <table style="width: 100%; border-collapse:collapse; font-size: 12px">
        <tr>
            <td style="width: 70%"></td>
            <td>Pomalaa, {{ date('d-m-Y') }}</td>
        </tr>
        <tr>
            <td></td>
            <td>Dicetak Oleh :</td>
        </tr>
        <tr>
            <td style="height: 50px"></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>
                {{ auth()->user()->karyawan->nm_lengkap }}<br>
                {{ auth()->user()->karyawan->get_jabatan->nm_jabatan }}
            </td>
        </tr>
    </table>
 </html>
