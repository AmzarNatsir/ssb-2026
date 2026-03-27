@extends('HRD.layouts.master')
@section('content')
<style>
    .spinner-div {
    position: absolute;
    display: none;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    text-align: center;
    background-color: rgba(255, 255, 255, 0.8);
    z-index: 2;
    }
</style>
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Pelaporan</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/pelaporan/karyawan') }}">Karyawan (F5)</a></li>
        </ul>
    </nav>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-12">
        @if(\Session::has('konfirm'))
            <div class="alert text-white bg-success" role="alert" id="success-alert">
                <div class="iq-alert-icon">
                    <i class="ri-alert-line"></i>
                </div>
                <div class="iq-alert-text">{{ \Session::get('konfirm') }}</div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="ri-close-line"></i>
                </button>
            </div>
        @endif
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Pelaporan Karyawan</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <div class="row justify-content-between">
                    <div class="col-sm-12 col-md-4">
                        <div id="user_list_datatable_info" class="dataTables_filter">
                            <select class="form-control select2" name="pil_departemen" id="pil_departemen" style="width: 100%">
                            <option value="0">Semua Departemen</option>
                            @foreach($all_departemen as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->nm_dept }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <div class="user-list-files d-flex float-left">
                            <a href="javascript:void(0);" class="chat-icon-phone" onClick="actFilter();"><i class="fa fa-search"></i> FILTER</a>
                            <a href="javascript:void(0);" class="chat-icon-phone" onClick="actPrint();"><i class="fa fa-print"></i> PDF</a>
                            <a href="javascript:void();" class="chat-icon-video" onClick="actExcel();"><i class="fa fa-table"></i> Excel</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="spinner-div" class="pt-5 justify-content-center spinner-div"><div class="spinner-border text-primary" role="status"></div></div>
            <div class="iq-card-body" id="p_preview" style="width:100%; height:auto"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#spinner-div').hide();
        $(".select2").select2();
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    });
    var actFilter = function()
    {
        $('#spinner-div').show();
        var id_departemen = $("#pil_departemen").val();
        $("#p_preview").load("{{ url('hrd/pelaporan/karyawan/filter') }}/"+id_departemen, function(){
            $('#spinner-div').hide();
        });
    }
    var actPrint = function()
    {
        var id_departemen = $("#pil_departemen").val();
        window.open('{{ url("hrd/pelaporan/karyawan/print") }}/'+id_departemen);
    }
    var actExcel = function()
    {
        var id_departemen = $("#pil_departemen").val();
        window.open('{{ url("hrd/pelaporan/karyawan/excel") }}/'+id_departemen);
    }
</script>
@endsection
