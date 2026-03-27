@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Setup | Pengaturan Potongan Gaji Karyawan</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/setup/manajemenpot') }}">Refresh (F5)</a></li>
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
                    <h4 class="card-title">Daftar Potongan Gaji Karyawan</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <div class="row justify-content-between">
                    <div class="col-sm-12 col-md-4">
                        <div id="user_list_datatable_info" class="dataTables_filter">
                            <select class="form-control" name="pil_departemen" id="pil_departemen" style="width: 100%">
                            <option value="0">Pilihan Departemen</option>
                            @foreach($all_departemen as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->nm_dept }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <div class="user-list-files d-flex float-left">
                            <button class="btn btn-primary" type="button" id="tbl_filter"><i class="fa fa-search"></i></button>
                            <button class="btn btn-primary" type="button" id="loaderDiv" style="display: none" disabled>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="view_data"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $("#tbl_filter").on("click", function(e)
        {
            e.preventDefault();
            var pil_departemen = $("#pil_departemen").val();
            $.ajax({
                type : "post",
                url : "{{ url('hrd/setup/manajemenpot/tampilkanpotongangaji') }}",
                data : {pil_departemen:pil_departemen},
                headers : {
                    'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
                },
                beforeSend : function()
                {
                    $("#loaderDiv").show();
                },
                success : function(respond)
                {
                    $(".view_data").html(respond);
                    $(".angka").number(true, 0);
                    $("#loaderDiv").hide();
                }
            });
        });
    });
</script>
@endsection
