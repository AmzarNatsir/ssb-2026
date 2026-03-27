@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item" aria-current="page">Pelatihan</li>
        <li class="breadcrumb-item active">Pengajuan Pelatihan</li>
        </ul>
    </nav>
</div>
@if(\Session::has('konfirm'))
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="alert text-white bg-success" role="alert" id="success-alert">
            <div class="iq-alert-icon">
                <i class="ri-alert-line"></i>
            </div>
            <div class="iq-alert-text">{{ \Session::get('konfirm') }}</div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="ri-close-line"></i>
            </button>
        </div>
    </div>
</div>
@endif
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Daftar Pengajuan Pelatihan</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <ul class="nav nav-tabs" id="myTab-1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="internal-tab" data-toggle="tab" href="#internal" role="tab" aria-controls="internal" aria-selected="true">Pelatihan Internal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="eksternal-tab" data-toggle="tab" href="#eksternal" role="tab" aria-controls="eksternal" aria-selected="false">Pelatihan Eksternal</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent-2">
                    {{-- internal --}}
                    <div class="tab-pane fade show active" id="internal" role="tabpanel" aria-labelledby="internal-tab">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="iq-card">
                                    <div class="iq-card-header d-flex justify-content-between">
                                        <div class="iq-header-title">
                                            <h4 class="card-title">Pelatihan Internal</h4>
                                        </div>
                                    </div>
                                    <div class="iq-card-body">
                                        <div class="row">
                                            @foreach ($pelatihan_internal as $key => $item)
                                            <div class="col-md-6">
                                                <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                    <div class="iq-card-body">
                                                        <div class="bg-cobalt-blue p-3 rounded d-flex align-items-center justify-content-between mb-3">
                                                            <h5 class="text-white">{{ $item->get_nama_pelatihan->nama_pelatihan }} </h5>
                                                            <div class="rounded-circle iq-card-icon bg-white">
                                                                <i class="ri-quill-pen-line text-cobalt-blue"></i>
                                                            </div>
                                                        </div>
                                                        <h4 class="mb-3 border-bottom">{{ $item->kompetensi}}</h4>
                                                        <div class="row align-items-center justify-content-between mt-3">
                                                            <div class="col-sm-7">
                                                                <p class="mb-0">Vendor</p>
                                                                <h6>{{ $item->get_pelaksana->nama_lembaga}}</h6>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <h6 class="mb-0"><i class="fa fa-calendar"></i> {{ App\Helpers\Hrdhelper::get_tanggal_pelaksanaan($item->tanggal_awal, $item->tanggal_sampai, NULL, NULL) }}</h6>
                                                                <h6 class="mb-0"><i class="fa fa-clock-o"></i> {{ $item->durasi}}</h6>
                                                                <h6 class="mb-0"><i class="fa fa-user"></i> {{ $item->get_peserta->count() }} <span>Peserta</span></h6>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="modal-footer">
                                                        <button type="button" data-toggle="modal" data-target="#ModalForm" class="btn btn-primary" name="btn-daftar_internal" id="btn-daftar_internal" value="{{ $item->id }}" onclick="goDaftarInternal(this)">Daftar</button>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- eksternal --}}
                    <div class="tab-pane fade" id="eksternal" role="tabpanel" aria-labelledby="eksternal-tab">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="iq-card">
                                    <div class="iq-card-header d-flex justify-content-between">
                                        <div class="iq-header-title">
                                            <h4 class="card-title">Pelatihan Eksternal</h4>
                                        </div>
                                        <div class="user-list-files d-flex float-right">
                                            <button type="button" class="btn btn-outline-primary active px-3" data-toggle="modal" data-target="#ModalForm" title="Form Pengajuan" onclick="goFormPengajuanEksternal(this)"><i class="fa fa-plus"></i> Pengajuan Pelatihan Eksternal</button>
                                        </div>
                                    </div>
                                    <div class="iq-card-body">
                                        <div class="row">
                                            @foreach ($pelatihan_eksternal as $item)
                                            <div class="col-md-6">
                                                <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                                    <div class="iq-card-body">
                                                        <div class="bg-amber p-3 rounded d-flex align-items-center justify-content-between mb-3">
                                                            <h5 class="text-white">{{ $item->nama_pelatihan }}</h5>
                                                            <div class="rounded-circle iq-card-icon bg-white">
                                                                <i class="ri-quill-pen-line text-cobalt-blue"></i>
                                                            </div>
                                                        </div>
                                                        <h4 class="mb-3 border-bottom">{{ $item->kompetensi}}</h4>
                                                        <div class="row align-items-center justify-content-between mt-3">
                                                            <div class="col-sm-7">
                                                                <p class="mb-0">Vendor</p>
                                                                <h6>{{ $item->nama_vendor}}</h6>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <h6 class="mb-0"><i class="fa fa-calendar"></i> {{ App\Helpers\Hrdhelper::get_tanggal_pelaksanaan($item->tanggal_awal, $item->tanggal_sampai, NULL, NULL) }}</h6>
                                                                <h6 class="mb-0"><i class="fa fa-clock-o"></i> {{ $item->durasi}}</h6>
                                                                <h6 class="mb-0"><i class="fa fa-user"></i> {{ $item->get_peserta->count() }} <span>Peserta</span></h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" data-toggle="modal" data-target="#ModalForm" class="btn btn-primary" name="btn-daftar_internal" id="btn-daftar_internal" value="{{ $item->id }}" onclick="goDaftarInternal(this)"><i class="fa fa-list mr-2"></i> Daftar</button>
                                                        @if(empty($item->status_pelatihan) && (!empty($item->departemen_by)) )
                                                        <a class="btn btn-danger" href="{{ url('hrd/pelatihan/deletepengajuan/'.$item->id) }}" onclick="return goDelete()"><i class="fa fa-trash mr-2"></i>Cancel</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="ModalForm" class="modal fade bg-modal" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" id="v_form"></div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".select2").select2();
    });
    var goDaftarInternal = function(el)
    {
        var id_data = $(el).val();
        $("#v_form").load("{{ url('hrd/pelatihan/goPengajuanInternal') }}/"+id_data, function(){
            $(".select2").select2();   ;
        });

    }
    var goFormPengajuanEksternal = function(el)
    {
        $("#v_form").load("{{ url('hrd/pelatihan/goPengajuanEksternal') }}", function() {
            $('.dateRangePicker').daterangepicker({
                "startDate": "{{ date('d-m-Y')}}",
                "locale": {
                    "format": 'DD/MM/YYYY'
                }
            });
            $(".angka").number(true, 0);
        });
    }
    var goDelete = function() {
        var psn = confirm("Yakin akan menghapus data ?")
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
</script>
@endsection
