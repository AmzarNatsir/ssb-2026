@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/pelatihan') }}">Daftra Pelatihan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail Pelatihan</li>
        </ul>
    </nav>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-6">
        <div class="iq-card" id="page_view">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Data Pelatihan</h4>
                </div>
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    @if(empty($dt_h->nomor))
                        <a href="{{ url('hrd/pelatihan/prosespelatihanstore/'.$dt_h->id) }}" class="btn btn-primary" onClick="return goFormProcess()"><i class="fa fa-check"></i> Proses</a>
                    @else
                        <button class="dropdown-item btn_print" type="button" onclick="goPrint(this)" value="{{ $dt_h->id }}"><i class="fa fa-print mr-2"></i></i>Print SPP</button>
                        @if($dt_h->status_pelatihan < 5)
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Update Status Pelatihan
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                @if($dt_h->status_pelatihan==2)
                                <a href="{{ url('hrd/pelatihan/prosespelatihanupdate/'.$dt_h->id.'/4') }}" class="dropdown-item" onClick="return goFormUpdate()"><i class="fa fa-check"></i> Klik Jika Pelatihan Sedang Berlangsung</a>
                                @endif
                                @if($dt_h->status_pelatihan==4)
                                <a href="{{ url('hrd/pelatihan/prosespelatihanupdate/'.$dt_h->id.'/5') }}" class="dropdown-item" onClick="return goFormUpdate()"><i class="fa fa-check"></i> Klik Jika Pelatihan Telah Selesai</a>
                                @endif
                            </div>
                        </div>
                        @endif
                    @endif

                </div>
            </div>
            <div class="iq-card-body">
                <table class="table" style="width: 100%;">
                <tbody>
                    <tr>
                        <td style="width: 30%;">Nama Pelatihan</td>
                        <td style="width: 2%;">:</td>
                        <td><b>{{ (empty($dt_h->id_pelatihan)) ? $dt_h->nama_pelatihan : $dt_h->get_nama_pelatihan->nama_pelatihan }}</b></td>
                    </tr>
                    <tr>
                        <td>Institusi Penyelenggara</td>
                        <td>:</td>
                        <td><b>{{ (empty($dt_h->id_pelaksana)) ?  $dt_h->nama_vendor : $dt_h->get_pelaksana->nama_lembaga }}</b></td>
                    </tr>
                    <tr>
                        <td>Alamat Penyelenggara</td>
                        <td>:</td>
                        <td><b>{{ $dt_h->tempat_pelaksanaan }}</b></td>
                    </tr>
                    @if(!empty($dt_h->departemen_by))
                    <tr>
                        <td>Departemen Yang Mengajukan</td>
                        <td>:</td>
                        <td><b>{{ $dt_h->get_departemen->nm_dept }}</b></td>
                    </tr>
                    @endif
                    <tr>
                        <td colspan="3"><b>Waktu Pelaksanaan Pelatihan</b></td>
                    </tr>
                    <tr>
                        <td>Hari/Tanggal</td>
                        <td>:</td>
                        <td><b>@if($dt_h->tanggal_awal==$dt_h->hari_sampai)
                            {{ App\Helpers\Hrdhelper::get_hari($dt_h->tanggal_awal) }}
                            @else
                            {{ App\Helpers\Hrdhelper::get_hari_ini($dt_h->tanggal_awal). " - ".App\Helpers\Hrdhelper::get_hari_ini($dt_h->tanggal_sampai) }}
                            @endif, {{ App\Helpers\Hrdhelper::get_tanggal_pelaksanaan($dt_h->tanggal_awal, $dt_h->tanggal_sampai, $dt_h->hari_awal, $dt_h->hari_sampai) }}</b></td>
                    </tr>
                    <tr>
                        <td>Durasi</td>
                        <td>:</td>
                        <td><b>{{ $dt_h->durasi }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Kompetensi</b></td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>{{ $dt_h->kompetensi }}</b></td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-6">
        <div class="iq-card" id="page_view">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Peserta Pelatihan</h4>
                </div>
            </div>
            <div class="iq-card-body">
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
</div>
<div id="ModalForm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content" id="v_inputan"></div>
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
    var goPrint = function(el) {
        var id_data = $(el).val();

        window.open('{{ url("hrd/pelatihan/print_spp") }}/'+id_data);
    }
    var goFormProcess = function(el)
    {
        var psn = confirm("Yakin akan memproses penagjuan ini ?")
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
    var goFormUpdate = function(el)
    {
        var psn = confirm("Yakin akan merubah status pelatihan ?")
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
</script>
@endsection
