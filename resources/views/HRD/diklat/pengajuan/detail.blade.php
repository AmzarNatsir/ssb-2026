@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/pelatihan/listpengajuan') }}">Daftar Pengajuan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail Pengajuan Pelatihan</li>
        </ul>
    </nav>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-6">
        <div class="iq-card" id="page_view">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Data Pengajuan Pelatihan</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <table class="table" style="width: 100%;">
                <tbody>
                    <tr>
                        <td style="width: 30%;">Nama Pelatihan</td>
                        <td style="width: 2%;">:</td>
                        <td><b>{{ $dt_h->get_nama_pelatihan->nama_pelatihan }}</b></td>
                    </tr>
                    <tr>
                        <td>Institusi Penyelenggara</td>
                        <td>:</td>
                        <td><b>{{ $dt_h->get_pelaksana->nama_lembaga }}</b></td>
                    </tr>
                    <tr>
                        <td>Alamat Penyelenggara</td>
                        <td>:</td>
                        <td><b>{{ $dt_h->tempat_pelaksanaan }}</b></td>
                    </tr>
                    <tr>
                        <td>Alasan Pengajuan</td>
                        <td>:</td>
                        <td><b>{{ $dt_h->alasan_pengajuan }}</b></td>
                    </tr>
                    <tr>
                        <td>Departemen Yang Mengajukan</td>
                        <td>:</td>
                        <td><b>{{ $dt_h->get_departemen->nm_dept }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Waktu Pelaksanaan Pelatihan</b></td>
                    </tr>
                    <tr>
                        <td>Hari/Tanggal</td>
                        <td>:</td>
                        <td><b>{{ App\Helpers\Hrdhelper::get_tanggal_pelaksanaan($dt_h->tanggal_awal, $dt_h->tanggal_sampai, $dt_h->hari_awal, $dt_h->hari_sampai) }}</b></td>
                    </tr>
                    <tr>
                        <td>Jam</td>
                        <td>:</td>
                        <td><b>{{ date("h:i", strtotime($dt_h->pukul_awal)).' s/d '.date("h:i", strtotime($dt_h->pukul_sampai)) }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Peserta Pelatihan</b></td>
                    </tr>
                </tbody>
                </table>
                <table class="table list_item" style="width: 100%; height: auto">
                    <tr>
                        <td style="width: 3%">#</td>
                        <td>Peserta</td>
                        <td style="width: 30%; text-align:right">Biaya Investasi</td>
                    </tr>
                    @if($dt_d->count() > 0)
                    @php $nom=1; @endphp
                    @foreach($dt_d as $dt_detail)
                    <tr>
                        <td>{{ $nom }}</td>
                        <td>{{ $dt_detail->get_karyawan->nm_lengkap }}</td>
                        <td style="text-align: right;">{{ number_format($dt_detail->biaya_investasi, 0, ",", ".") }}</td>
                    </tr>
                    @php $nom++; @endphp
                    @endforeach
                    @endif
                    <tr>
                        <td colspan="2" style="text-align: right"><b>Total Investasi</b></td>
                        <td style="text-align: right"><b>{{ number_format($dt_h->total_investasi, 0, ",", ".") }}</b></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-6">
        <div class="iq-card" id="page_view">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Data Persetujuan</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <table class="table" style="width: 100%;">
                <tbody>
                    <tr>
                        <td style="width: 30%;">Tanggal</td>
                        <td style="width: 2%;">:</td>
                        <td><b>{{ date_format(date_create($dt_h->tgl_approval), 'd-m-Y') }}</b></td>
                    </tr>
                    <tr>
                        <td>Catatan</td>
                        <td>:</td>
                        <td><b>{{ $dt_h->catatam_approval }}</b></td>
                    </tr>
                    <tr>
                        <td>Status Persetujuan</td>
                        <td>:</td>
                        <td><b>
                            @if($dt_h->status_pelatihan==2)
                            Pengajuan Disetujui
                            @endif
                            @if($dt_h->status_pelatihan==3)
                            Pengajuan Ditolak
                            @endif
                        </b></td>
                    </tr>
                    <tr>
                        <td>Oleh</td>
                        <td>:</td>
                        <td><b>{{ $dt_h->get_karyawan_approve->nm_lengkap }} <br>
                        ({{ $dt_h->get_karyawan_approve->get_jabatan->nm_jabatan }} -  {{ $dt_h->get_karyawan_approve->get_departemen->nm_dept }})</b></td>
                    </tr>
                    <tr>
                        <td>Status Pelatihan</td>
                        <td>:</td>
                        <td><b>
                            @if($dt_h->status_pelatihan==2)
                            Sedang Proses
                            @endif
                            @if($dt_h->status_pelatihan==4)
                            Sedang Berlangsung
                            @endif
                            @if($dt_h->status_pelatihan==5)
                            Selesai
                            @endif
                        </b></td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".select2").select2();
        $(".angka").number(true, 0);
        // $(".angka").number(true, 0);
    });
</script>
@endsection