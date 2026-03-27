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
        <li class="breadcrumb-item active" aria-current="page">Resign</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/resign') }}">Refresh (F5)</a></li>
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
@include('HRD.resign.summary')
<div class="row" id="result_data">
    {{-- <div id="spinner-div" class="pt-5 justify-content-center spinner-div"><div class="spinner-border text-primary" role="status"></div></div> --}}
</div>
<div id="ModalFormXL" class="modal fade bg-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" id="v_inputan_xl"></div>
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
    var showData = function(el)
    {
        $('#spinner-div').show();
        $("#result_data").load("{{ url('hrd/resign/all_data') }}", function(){
            $('#spinner-div').hide();
        });
    }
    var showPengajuan = function(el)
    {
        $('#spinner-div').show();
        $("#result_data").load("{{ url('hrd/resign/all_pengajuan') }}", function(){
            $('#spinner-div').hide();
        });
    }
    var showExitInterviews = function(el)
    {
        $('#spinner-div').show();
        $("#result_data").load("{{ url('hrd/resign/all_exit_form') }}", function(){
            $('#spinner-div').hide();
        });
    }
    var goDetailExitInterviews = function(el)
    {
        var id_data = $(el).val();
        $("#v_inputan_xl").load("{{ url('hrd/resign/detailFormExitInterviews') }}/"+id_data);
    }
    var goPengaturan = function(el)
    {
        var id_data = $(el).val();
        $("#v_inputan_xl").load("{{ url('hrd/resign/pengaturanResign') }}/"+id_data, function(){
            $(".datepicker").datepicker({
            format: 'dd/mm/yyyy',
            orientation : "button right",
            todayHighlight: true,
            autoclose: true,
        });
        });
    }
    var goPrintSKK = function(el)
    {
        var id_data = $(el).val();
        window.open('{{ url("hrd/resign/printSKK") }}/'+id_data);
    }
</script>
@endsection
