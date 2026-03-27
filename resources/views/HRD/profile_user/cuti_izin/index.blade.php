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
    },
    .spinner-div-izin {
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
        <li class="breadcrumb-item active" aria-current="page">Dataku - Cuti/Izin</li>
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
    <div class="col-sm-12">
        <div class="iq-card">
            <div class="iq-card-body">
                <div class="row">
                    <div class="col-lg-9 profile-left">
                        <div class="iq-card iq-card-block iq-card-stretch">
                            <div class="iq-card-body p-0">
                                <table class="table" style="width: 100%;" id="table_cuti_izin">
                                    <tr>
                                        <td style="text-align: left; background-color: rgb(5, 120, 250); color: white"><b>DAFTAR CUTI</b><div class="user-list-files d-flex float-right"><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ModalForm" onclick="goFormAddCuti(this)" @if($all_cuti->count()>0)
                                            {{ ($count_aktif_cuti->count()==0) ? "" : "disabled" }}
                                            @endif
                                            ><i class="fa fa-plus"></i> Pengajuan Cuti</button></div></td>
                                    </tr>
                                    <tr>
                                        <td id="list_cuti" style="vertical-align: top">
                                        <div id="spinner-div" class="pt-5 justify-content-center spinner-div"><div class="spinner-border text-primary" role="status"></div></div>
                                        </td>
                                    </tr>
                                    <tr><td style="text-align: left; background-color: rgb(5, 120, 250); color: white"><b>DAFTAR IZIN</b><div class="user-list-files d-flex float-right"><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ModalForm" onclick="goFormAddIzin(this)"
                                        @if($all_izin->count()>0)
                                        {{ ($count_aktif_izin->count()==0) ? "" : "disabled" }}
                                        @endif
                                        ><i class="fa fa-plus"></i> Pengajuan Izin</button></div></td></tr>
                                    <tr>
                                        <td id="list_izin" style="vertical-align: top;">
                                            <div id="spinner-div-izin" class="pt-5 justify-content-center spinner-div-izin"><div class="spinner-border text-primary" role="status"></div></div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 profile-right">
                        <div class="iq-card iq-card-block iq-card-stretch">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">Filter Data</h4>
                                </div>
                            </div>
                            <div class="iq-card-body">
                                <div class="form-group col-sm-12">
                                    <label for="pil_jenis">Bulan :</label>
                                    <select class="form-control" name="pil_bulan" id="pil_bulan" style="width: 100%">
                                        <option value="0">All</option>
                                        @foreach($list_bulan as $key => $value)
                                        @if($key==date("m"))
                                        <option value="{{ $key }}" selected>{{ $value }}</option>
                                        @else
                                        <option value="{{ $key }}">{{ $value }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="pil_jenis">Tahun :</label>
                                    @php
                                    $thn_start = 2021;
                                    $thn_end = date('Y') + 1;
                                    @endphp
                                    <select class="form-control" name="inp_tahun" id="inp_tahun">
                                    @for ($i=$thn_start; $i<=$thn_end; $i++)
                                        @if($i==date("Y"))
                                        <option value="{{ $i }}" selected>{{ $i }}</option>
                                        @else
                                        <option value="{{ $i }}">{{ $i }}</option>
                                        @endif
                                    @endfor
                                    </select>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-primary" onclick="actFilter()">Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $('#spinner-div').hide();
        $('#spinner-div-izin').hide();
        get_data();
    });
    function get_data()
    {
        $('#spinner-div').show();
        $('#spinner-div-izin').show();
        var pil_bulan = $("#pil_bulan").val();
        var pil_tahun = $("#inp_tahun").val();
        $("#list_cuti").load("{{ url('hrd/dataku/getCutiIzin')}}/"+pil_bulan+"/"+pil_tahun, function(){
            $('#spinner-div').hide();
        });
        $("#list_izin").load("{{ url('hrd/dataku/getIzin')}}/"+pil_bulan+"/"+pil_tahun, function(){
            $('#spinner-div-izin').hide();
        });
    }
    var actFilter = function()
    {
        get_data();
    }
    var goFormAddCuti = function()
    {
        $("#v_inputan").load("{{ url('hrd/dataku/formPengajuanCuti') }}");
    }
    var goFormAddIzin = function()
    {
        $("#v_inputan").load("{{ url('hrd/dataku/formPengajuanIzin') }}");
    }
</script>
@endsection
