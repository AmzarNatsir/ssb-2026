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
        <li class="breadcrumb-item active" aria-current="page">Dataku - Pelatihan</li>
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
    <div class="col-sm-9">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Daftar Pelatihan</h4>
                </div>
            </div>
            <div class="iq-card-body" id="list_pelatihan">
                <div id="spinner-div" class="pt-5 justify-content-center spinner-div"><div class="spinner-border text-primary" role="status"></div></div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
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
                    $thn_end = date('Y');
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
<div id="ModalForm" class="modal fade bg-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" id="v_inputan"></div>
    </div>
 </div>
 <div id="ModalFormUpdate" class="modal fade bg-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" id="v_update"></div>
    </div>
 </div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#spinner-div').hide();
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        get_data();
    });
    function get_data()
    {
        $('#spinner-div').show();
        var pil_bulan = $("#pil_bulan").val();
        var pil_tahun = $("#inp_tahun").val();
        $("#list_pelatihan").load("{{ url('hrd/dataku/getDataPelatihan')}}/"+pil_bulan+"/"+pil_tahun, function(){
            $('#spinner-div').hide();
        });
    }
    var actFilter = function()
    {
        get_data();
    }
    var goDetail = function(el)
    {
        var id_data = $(el).val();
        $("#v_inputan").load("{{ url('hrd/dataku/detailPelatihan') }}/"+id_data);
    }
    var goUpdate = function(el)
    {
        var id_data = $(el).val();
        $("#v_update").load("{{ url('hrd/dataku/editPelatihan') }}/"+id_data);
    }
    var goLaporan = function(el)
    {
        var id_data = $(el).val();
        $("#v_update").load("{{ url('hrd/dataku/detailPascaPelatihan') }}/"+id_data);
    }
</script>
@endsection
