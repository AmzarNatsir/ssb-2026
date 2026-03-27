@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Surat Teguran (ST)- Surat Peringatan (SP)</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/suratperingatan') }}">Refresh (F5)</a></li>
        </ul>
    </nav>
</div>
<div class="row">
    @if(\Session::has('konfirm'))
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
    @endif
    @include('HRD.surat_peringatan.summary_all_sp_st')
</div>
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Data Surat Teguran (ST) - Surat Peringatan (SP)</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <div id="spinner-div" class="pt-5 justify-content-center spinner-div"><div class="spinner-border text-primary" role="status"></div></div>
                <div id="view_data"></div>
            </div>
        </div>
    </div>
</div>

<div id="ModalForm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" id="v_inputan"></div>
    </div>
 </div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#spinner-div').hide();
        $('.datatable').DataTable();
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    });
    var showData = function(el)
    {
        $('#spinner-div').show();
        var filter = $(el).val();
        $("#view_data").load("{{ url('hrd/suratperingatan/showData') }}/"+filter, function(){
            $('#spinner-div').hide();
        });
    }
</script>
@endsection
