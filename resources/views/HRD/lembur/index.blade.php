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
        <li class="breadcrumb-item active" aria-current="page">Lembur</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/lembur') }}">Refresh (F5)</a></li>
        </ul>
    </nav>
</div>
<div class="row">
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
    @include('HRD.lembur.summary_lembur')
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="iq-card">
            <div id="spinner-div" class="pt-5 justify-content-center spinner-div"><div class="spinner-border text-primary" role="status"></div></div>
            <div id="view_data">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">Monitoring Data Lembur Karyawan</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                </div>
            </div>
        </div>
    </div>

</div>
<div id="modalFormProses" class="modal fade bg-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content" id="v_inputan" style="overflow-y: auto;"></div>
    </div>
 </div>
 <div id="modalDetailPengajuan" class="modal fade bg-modal" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content" id="v_detail" style="overflow-y: auto;"></div>
    </div>
 </div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#spinner-div').hide();
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    });
    var showData = function(el)
    {
        $('#spinner-div').show();
        var filter = $(el).val();
        $("#view_data").load("{{ url('hrd/lembur/showData') }}/"+filter, function(){
            $('#spinner-div').hide();
        });
    }
</script>
@endsection
