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
        <li class="breadcrumb-item active" aria-current="page">Karyawan</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/karyawan/daftar') }}">Refresh (F5)</a></li>
        </ul>
    </nav>
</div>
@if(\Session::has('konfirm'))
<div class="row">
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
@endif
@include('HRD.karyawan.summary_karyawan')
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                   <h4 class="card-title">Daftar Karyawan</h4>
                </div>
                <div class="iq-card-header-toolbar d-flex align-items-center">
                    @if(auth()->user()->id==1)
                    <a class="dropdown-bg" href="{{ url('hrd/karyawan/baru') }}"><i class="fa fa-plus"></i> Tambah Data</a>
                    <a class="dropdown-bg" href="{{ route('importDBKaryawan') }}"><i class="fa fa-download"></i> Import Database</a>
                    <a class="dropdown-bg" href="{{ route('hapusDBKaryawan') }}" onclick="confirmHapus();"><i class="fa fa-trash"></i> Hapus Database</a>
                    @endif
                </div>
             </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <div id="spinner-div" class="pt-5 justify-content-center spinner-div"><div class="spinner-border text-primary" role="status"></div></div>
                <div class="data_karyawan"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#spinner-div').hide();
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".select2").select2();
        // $(".data_karyawan").load("{{ url('hrd/karyawan/filter_all') }}");
    });
    var actFilter = function(el)
    {
        $('#spinner-div').show();
        var id_departemen = $(el).val();
        $(".data_karyawan").load("{{ url('hrd/karyawan/filter_departemen') }}/"+id_departemen, function(){
            $('#spinner-div').hide();
        });
    }
    var actFilterGender = function(el)
    {
        $('#spinner-div').show();
        const myArray =  $(el).val().split("-");
        let gender = myArray[0];
        let id_departemen = myArray[1];
        $(".data_karyawan").load("{{ url('hrd/karyawan/filter_departemen_gender') }}/"+id_departemen+"/"+gender, function(){
            $('#spinner-div').hide();
        });
    }
</script>
@endsection
