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
        <li class="breadcrumb-item active" aria-current="page">Pendataan | Penggajian Karyawan</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/penggajian') }}">Refresh (F5)</a></li>
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
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Gaji Karyawan</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <div class="row justify-content-between">
                    <div class="col-sm-2">
                        <select class="form-control" name="pil_periode_bulan" id="pil_periode_bulan" style="width: 100%;">
                        @foreach($list_bulan as $key => $value)
                        @if($key==date('m'))
                        <option value="{{ $key }}" selected>{{ $value }}</option>
                        @else
                        <option value="{{ $key }}">{{ $value }}</option>
                        @endif
                        @endforeach
                        </select>
                    </div>
                    <div class="col-sm-1">
                        <input type="text" class="form-control" name="inp_periode_tahun" id="inp_periode_tahun" value="{{ date('Y') }}" readonly>
                    </div>
                    <div class="col-sm-4">
                        <div id="user_list_datatable_info" class="dataTables_filter">
                            <select class="form-control" name="pil_departemen" id="pil_departemen" style="width: 100%">
                            <option value="0">Semua Departemen</option>
                            @foreach($all_departemen as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->nm_dept }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="user-list-files d-flex float-left">
                            <button class="btn btn-primary" type="button" id="tbl_filter"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <hr>
                <div id="spinner-div" class="pt-5 justify-content-center spinner-div"><div class="spinner-border text-primary" role="status"></div></div>
                <div class="view_data table-responsive"></div>
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
        $(".angka").number(true, 0);
        $("#tbl_filter").on("click", function(e)
        {
            e.preventDefault();
            var pil_departemen = $("#pil_departemen").val();
            var pil_bulan = $("#pil_periode_bulan").val();
            var pil_tahun = $("#inp_periode_tahun").val();
            $.ajax({
                type : "post",
                url : "{{ url('hrd/penggajian/filterdetailgaji') }}",
                data : {pil_departemen:pil_departemen, pil_bulan:pil_bulan, pil_tahun:pil_tahun},
                headers : {
                    'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
                },
                beforeSend : function()
                {
                    $('#spinner-div').show();
                },
                success : function(respond)
                {
                    $(".view_data").html(respond);
                    $(".angka").number(true, 0);
                    $('#spinner-div').hide();
                }
            });
        });
    });
    function konfirm()
    {
        var psn = confirm("Yakin akan menyimpan pengaturan gaji  karyawan ?");
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
</script>
@endsection
