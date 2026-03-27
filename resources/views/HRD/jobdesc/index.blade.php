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
        <li class="breadcrumb-item active" aria-current="page">Job Description</li>
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
            <div class="iq-card-body">
                <div class="row">
                    <div class="col-lg-4 profile-right">
                        <div class="iq-card iq-card-block iq-card-stretch">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">Filter Data</h4>
                                </div>
                            </div>
                            <div class="iq-card-body">
                                <div class="form-group col-sm-12">
                                    <label for="pil_departemen">Departemen :</label>
                                    <select class="form-control select2" name="pil_departemen" id="pil_departemen" style="width: 100%">
                                        <option value="0">All</option>
                                        @foreach ($all_dept as $item)
                                        <option value="{{ $item->id }}">{{ $item->nm_dept }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-primary" onclick="actFilter()">Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 profile-left">
                        <div class="iq-card iq-card-block iq-card-stretch">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">List Job Decsription</h4>
                                </div>
                            </div>
                            <div class="iq-card-body">
                                <p class="mb-4">Upload file Job Description di menu <code>[ data master -> struktur -> jabatan ]</code></p>
                            </div>
                        </div>
                        <div class="iq-card-body" style="width:100%; height:auto">
                            <div class="row justify-content-center">
                                <div class="iq-card table-responsive" id="list_jobdesc"></div>
                                <div id="spinner-div" class="pt-5 justify-content-center spinner-div"><div class="spinner-border text-primary" role="status"></div></div>
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
        $(".select2").select2();
        $('#spinner-div').hide();
        get_data();
    });
    function get_data()
    {
        $('#spinner-div').show();
        var departemen = $("#pil_departemen").val();
        $("#list_jobdesc").load("{{ url('hrd/jobdesc/data')}}/"+departemen, function(){
            $('#spinner-div').hide();
        });
    }
    var actFilter = function()
    {
        get_data();
    }
</script>
@endsection
