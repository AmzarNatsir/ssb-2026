@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Pelatihan</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/pelatihan') }}">Refresh (F5)</a></li>
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
                    <h4 class="card-title">Data Pelatihan</h4>
                </div>
                <div class="user-list-files d-flex float-left">
                    <button type="button" class="btn btn-outline-primary active px-3" data-toggle="modal" data-target="#ModalForm" title="Form Pengajuan" onclick="goPengajuan(this)"><i class="fa fa-plus"></i> Pengajuan Baru</button>
                </div>
            </div>
        </div>
        <div class="iq-card">
            <div class="card-body">
               <div class="row">
                  <div class="col-lg-12 d-flex justify-content-md-between">
                     <div>
                        <div class="btn-group ml-2 bg-white" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-outline-success active px-4" onclick="getAgenda()"><i class="fa fa-calendar"></i> Agenda Pelatihan Tahun {{ date('Y') }}</button>
                            @if($jumlah_pengajuan>0)
                                <button type="button" class="btn btn-outline-primary active px-4" onclick="getPengajuan()"><i class="fa fa-table"></i> Daftar Pengajuan <span class="badge {{ ($jumlah_pengajuan==0) ? "badge-light" : "badge-danger" }} ml-2">{{ $jumlah_pengajuan }}</span></button>
                                <button type="button" class="btn btn-outline-dark active px-4" onclick="getSubmit()"><i class="fa fa-send"></i> Submit Pengajuan <span class="badge {{ ($jumlah_pengajuan==0) ? "badge-light" : "badge-danger" }} ml-2">{{ $jumlah_pengajuan }}</span></button>
                            @endif
                            @if($jumlah_submit>0)
                                <button type="button" class="btn btn-outline-info active px-5" onclick="getProgress()"><i class="fa fa-clock-o"></i> Monitoring Pengajuan Pelatihan <span class="badge {{ ($jumlah_submit==0) ? "badge-light" : "badge-danger" }} ml-2">{{ $jumlah_submit }}</span></button>
                            @endif

                            <button type="button" class="btn btn-outline-success active px-4" onclick="getPasca()"><i class="fa fa-user-o"></i> Laporan Kegiatan Pasca Pelatihan <span class="badge {{ ($list_laporan==0) ? "badge-light" : "badge-danger" }} ml-2">{{ $list_laporan }}</span></button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
        </div>
        <div class="iq-card">
            <div class="card-body">
               <div class="row">
                    <div class="col-lg-12 d-flex">
                        <div id="spinner-div" class="pt-5 spinner-div" style="text-align: center">
                            <div class="spinner-border text-primary" role="status"></div>
                        </div>
                        <div class="table-responsive" id="viewResult"></div>
                    </div>
               </div>
            </div>
        </div>
    </div>
</div>
<div id="ModalForm" class="modal fade bg-modal"  role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" id="v_form"></div>
    </div>
</div>
<div id="ModalFormPasca" class="modal fade bg-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" id="v_pasca"></div>
    </div>
 </div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#spinner-div').hide();
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".select2").select2();
        // $('.datatable').DataTable();
    });
    var getPengajuan = function()
    {
        $('#spinner-div').show();
        $("#viewResult").load("{{ url('hrd/pelatihan/getAllPengajuan')}}", function(){
            $('#spinner-div').hide();
            $(".select2").select2();
        });
    }
    var getAgenda = function()
    {
        $('#spinner-div').show();
        $("#viewResult").load("{{ url('hrd/pelatihan/getAllPelatihan')}}", function(){
            $('#spinner-div').hide();
        });
    }
    var getSubmit = function()
    {
        $('#spinner-div').show();
        $("#viewResult").load("{{ url('hrd/pelatihan/goFormSubmit')}}", function(){
            $('#spinner-div').hide();
        });
    }
    var getProgress = function()
    {
        $('#spinner-div').show();
        $("#viewResult").load("{{ url('hrd/pelatihan/getAllSubmit')}}", function(){
            $('#spinner-div').hide();
        });
    }

    var goDetail = function(el)
    {
        $("#v_form").load("{{ url('hrd/pelatihan/goFormDetail')}}/"+el.id);
    }
    var goPrint = function(el) {
        var id_data = $(el).val();
        window.open('{{ url("hrd/pelatihan/print_spp") }}/'+id_data);
    }
    var goPengajuan = function(el)
    {
        $("#v_form").load("{{ url('hrd/pelatihan/formdiklat') }}");
    }

    var getPasca = function(el)
    {
        $('#spinner-div').show();
        $("#viewResult").load("{{ url('hrd/pelatihan/goListLaporan')}}", function(){
            $('#spinner-div').hide();
        });
    }

    var goDetailPasca = function(el)
    {
        var id_data = $(el).val();
        $("#v_pasca").load("{{ url('hrd/pelatihan/getDetailPelatihan') }}/"+id_data);
    }

    var goDetailLaporan = function(el)
    {
        var id_data = $(el).val();
        $("#v_pasca").load("{{ url('hrd/pelatihan/getDetailPelatihan') }}/"+id_data);
    }

    var goDelete = function() {
        var psn = confirm("Yakin akan menghapus data ?")
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
</script>
@endsection
