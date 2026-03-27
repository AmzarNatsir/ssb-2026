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
        <li class="breadcrumb-item active" aria-current="page">Penggajian</li>
        <li class="breadcrumb-item">Cetak Slip Gaji</li>
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
    <div class="col-sm-12 col-lg-4">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Cari Karyawan</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <div class="form-group">
                    <div class="custom-file">
                        <select class="form-control select2" id="inp_key" name="inp_key" style="width: 100%;">
                            <option value="0">-> Pilih Karyawan</option>
                            @foreach($list_karyawan as $list)
                            <option value="{{ $list->id }}">{{ $list->nik." - ".$list->nm_lengkap }}{{ (!empty($list->id_jabatan) ? $list->get_jabatan->nm_jabatan : "") }}{{ (!empty($list->id_departemen) ? " - ".$list->get_departemen->nm_dept : "") }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" onclick="actSearch()">Submit</button>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-8">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Hasil Pencarian</h4>
                </div>
            </div>
            <div class="iq-card-body" id="v_preview">
                <div id="spinner-div" class="pt-5 justify-content-center spinner-div"><div class="spinner-border text-primary" role="status"></div></div>
            </div>
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
    var actSearch = function()
    {
        $('#spinner-div').show();
        var inp_key = $("#inp_key").val();
        $("#v_preview").load("{{ url('hrd/penggajian/slipgaji_view_karyawan') }}/"+inp_key, function(){
            $('#spinner-div').hide();
        });
    }
    var actPrint = function()
    {
        var id_departemen = $("#pil_departemen").val();
        if(id_departemen==0)
        {
            alert("Kolom Pilihan Departemen Tidak boleh kosong");
            return false
        } else {
            window.open('{{ url("hrd/pelaporan/karyawan/print") }}/'+id_departemen);
        }
        //$("#p_preview").load("{{ url('hrd/pelaporan/karyawan/print') }}/"+id_departemen);
    }
</script>
@endsection
