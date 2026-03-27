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
        <li class="breadcrumb-item active" aria-current="page">Dataku - Resign</li>
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
    <div class="col-sm-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Daftar Pengajuan</h4>
                </div>
                @if($count_pengajuan == 0)
                <div class="user-list-files d-flex float-left">
                    <button type="button" class="btn btn-outline-primary active px-3" data-toggle="modal" data-target="#ModalForm" title="Form Pengajuan" onclick="goPengajuan(this)"><i class="fa fa-plus"></i> Pengajuan Baru</button>
                </div>
                @endif
            </div>
            <div class="iq-card-body">
                <table class="table table-striped table-bordered" style="width: 100%; font-size:13px">
                    <thead class="thead-light">
                        <th style="width: 5%; text-align:center">No</th>
                        <th style="width: 10%; text-align:center">Diajukan pada</th>
                        <th>Alasan Pengajuan</th>
                        <th style="width: 5%; text-align:center">File</th>
                        <th style="width: 10%; text-align:center">Eff. Resign</th>
                        <th style="width: 15%">Pengajuan</th>
                        <th style="width: 15%">Exit Interviews</th>
                        <th style="width: 10%">Act</th>
                    </thead>
                    <tbody>
                        @php($nom=1)
                        @foreach ($list_pengajuan as $list)
                        <tr>
                            <td style="text-align:center">{{ $nom}}</td>
                            <td style="text-align:center"><p style="font-size: 12px" class="badge badge-success">{{ date('d-m-Y', strtotime($list['created_at'])) }}</p></td>
                            <td>{{ $list['alasan_resign'] }}</td>
                            <td class="text-center">
                                @if(!empty($list['file_surat_resign']))
                                <a href="{{ url('hrd/dataku/resign/showPdf', $list['id']) }}" target="_new"><i class="fa fa-file-pdf-o"></i></a>
                                @endif
                            </td>
                            <td style="text-align:center"><p style="font-size: 12px" class="badge badge-danger">{{ date('d-m-Y', strtotime($list['tgl_eff_resign'])) }}</p></td>
                            <td>
                                @if($list['sts_pengajuan']==1)
                                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Menunggu Persetujuan
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                <a class="dropdown-item" href="#"><i class="fa fa-user mr-1"></i>{{ $list['get_current_approve']['nm_lengkap'] }}</a>
                                                <a class="dropdown-item" href="#"><i class="fa fa-user mr-1"></i>{{ $list['get_current_approve']['get_jabatan']['nm_jabatan'] }}</a>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($list['sts_pengajuan']==2)
                                    <button type="button" class="btn btn-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-check"></i> Approved</button>
                                @elseif($list['sts_pengajuan']==3)
                                    <button type="button" class="btn btn-danger" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-times"></i> Rejected</button>
                                @else
                                    <button type="button" class="btn btn-dark" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-times"></i> Pengajuan Batal</button>
                                @endif
                            </td>
                            <td>
                                @if($list['count_exit'] > 0)
                                    @if($list['data_exit']['sts_pengajuan']==1)
                                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                            <div class="btn-group" role="group">
                                                <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Menunggu Persetujuan
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                    <a class="dropdown-item" href="#"><i class="fa fa-user mr-1"></i>{{ $list['data_exit']->get_current_approve->nm_lengkap }}</a>
                                                    <a class="dropdown-item" href="#"><i class="fa fa-user mr-1"></i>{{ $list['data_exit']->get_current_approve->get_jabatan->nm_jabatan }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($list['data_exit']['sts_pengajuan']==2)
                                        <button type="button" class="btn btn-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-check"></i> Approved</button>
                                    @elseif($list['data_exit']['sts_pengajuan']==3)
                                        <button type="button" class="btn btn-danger" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-times"></i> Rejected</button>
                                    @else
                                        <button type="button" class="btn btn-dark" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-times"></i> Pengajuan Batal</button>
                                    @endif
                                @else
                                    <p style="font-size: 12px" class="badge badge-dark">Form Exit Interviews Belum Diisi</p>
                                @endif
                            </td>
                            <td>
                                @if($list['sts_pengajuan'] < 4)
                                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                    <div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Act
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                            @if($list['is_draft']==1)
                                                <button type="button" class="dropdown-item tbl-edit" data-toggle="modal" data-target="#ModalForm" value="{{ $list['id'] }}" name="btn-edit" data-placement="top" title="Edit Pengajuan" onclick="goEdit(this)"><i class="las la-edit"></i> Edit Pengajuan</button>
                                                <button type="button" class="dropdown-item tbl-batal" data-toggle="modal" data-target="#ModalForm" value="{{ $list['id'] }}" name="btn-cancel" data-placement="top" title="Batal Pengajuan" onclick="goCancel(this)"><i class="las la-times"></i> Batal Pengajuan</button>
                                            @else
                                                <button type="button" class="dropdown-item tbl-detail" data-toggle="modal" data-target="#ModalFormXL" value="{{ $list['id'] }}" name="btn-detail" data-placement="top" title="Detail Pengajuan" onclick="goDetail(this)"><i class="las la-eye"></i> Detail Pengajuan</button>
                                                @if($list['count_exit'] == 0)
                                                    <button type="button" class="dropdown-item tbl-exit-form" data-toggle="modal" data-target="#ModalFormXL" value="{{ $list['id'] }}" name="btn-exit-form" data-placement="top" title="Exit Interviews Form" onclick="goFormExit(this)"><i class="ri-profile-line"></i> Exit Interviews Form</button>
                                                @else
                                                    <button type="button" class="dropdown-item tbl-exit-form" data-toggle="modal" data-target="#ModalFormXL" value="{{ $list['data_exit']['id'] }}" name="btn-exit-form" data-placement="top" title="Exit Interviews Form" onclick="goEditFormExit(this)"><i class="ri-profile-line"></i> Edit Exit Interviews Form</button>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @php($nom++)
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="ModalForm" class="modal fade bg-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" id="v_inputan"></div>
    </div>
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
        // get_data();
    });
    var goPengajuan = function(el)
    {
        $("#v_inputan").load("{{ url('hrd/dataku/formPengajuanResign') }}");
    }
    var goEdit = function(el)
    {
        var id_data = $(el).val();
        $("#v_inputan").load("{{ url('hrd/dataku/formEditPengajuanResign') }}/"+id_data);
    }
    var goCancel = function(el)
    {
        var id_data = $(el).val();
        $("#v_inputan").load("{{ url('hrd/dataku/formCancelPengajuanResign') }}/"+id_data);
    }
    var goDetail = function(el)
    {
        var id_data = $(el).val();
        $("#v_inputan_xl").load("{{ url('hrd/dataku/formDetailPengajuanResign') }}/"+id_data);
    }
    var goFormExit = function(el)
    {
        var id_data = $(el).val();
        $("#v_inputan_xl").load("{{ url('hrd/dataku/formExitInterviewsResign') }}/"+id_data, function(){
            $(".angka").number(true, 0);
        });
    }
    var goEditFormExit = function(el)
    {
        var id_data = $(el).val();
        $("#v_inputan_xl").load("{{ url('hrd/dataku/formEditExitInterviewsResign') }}/"+id_data, function(){
            $(".angka").number(true, 0);
        });
    }
    // function get_data()
    // {
    //     $('#spinner-div').show();
    //     var pil_bulan = $("#pil_bulan").val();
    //     var pil_tahun = $("#inp_tahun").val();
    //     $("#list_pelatihan").load("{{ url('hrd/dataku/getDataPelatihan')}}/"+pil_bulan+"/"+pil_tahun, function(){
    //         $('#spinner-div').hide();
    //     });
    // }
    // var actFilter = function()
    // {
    //     get_data();
    // }

    // var goUpdate = function(el)
    // {
    //     var id_data = $(el).val();
    //     $("#v_update").load("{{ url('hrd/dataku/editPelatihan') }}/"+id_data);
    // }
    // var goLaporan = function(el)
    // {
    //     var id_data = $(el).val();
    //     $("#v_update").load("{{ url('hrd/dataku/detailPascaPelatihan') }}/"+id_data);
    // }
</script>
@endsection
