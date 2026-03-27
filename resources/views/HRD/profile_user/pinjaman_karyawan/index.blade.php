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
        <li class="breadcrumb-item active" aria-current="page">Dataku - Pinjaman Karyawan</li>
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
    <div class="col-sm-12">
        <div class="iq-card">
            <div class="iq-card-body">
                <div class="row">
                    <div class="col-lg-12 profile-left">
                        <div class="iq-card iq-card-block iq-card-stretch">
                            <div class="iq-card-body p-0">
                                <table class="table" style="width: 100%;" id="table_cuti_izin">
                                    <tr>
                                        <td style="text-align: left; background-color: rgb(5, 120, 250); color: white">
                                        <b>DAFTAR PINJAMAN</b>
                                        <div class="user-list-files d-flex float-right"><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ModalFormXL" onclick="goFormAdd(this)"
                                            @if($aktif_tombol_pengajuan > 0)
                                            disabled
                                            @endif
                                        ><i class="fa fa-plus"></i> Pengajuan Pinjaman</button>
                                        </div>

                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="iq-card-body" style="width:100%; height:auto">
                            <div class="row justify-content-center">
                                <div class="iq-card table-responsive" id="list_pengajuan"></div>
                                <div id="spinner-div" class="pt-5 justify-content-center spinner-div"><div class="spinner-border text-primary" role="status"></div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="ModalForm" class="modal fade bg-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
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
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 3000);
        $('#spinner-div').hide();
        $('#spinner-div-izin').hide();
        get_data();
    });
    function get_data()
    {
        $('#spinner-div').show();
        $('#spinner-div-izin').show();
        $("#list_pengajuan").load("{{ url('hrd/dataku/getListPengajuan')}}", function(){
            $('#spinner-div').hide();
        });
    }
    var actFilter = function()
    {
        get_data();
    }
    var goFormAdd = function()
    {
        $("#v_inputan_xl").load("{{ url('hrd/dataku/pengajuanPinjaman') }}");
    }
</script>
@endsection
