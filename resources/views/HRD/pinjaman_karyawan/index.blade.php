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
        <li class="breadcrumb-item active" aria-current="page">Pendataan | Pinjaman Karyawan</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/pinjaman_karyawan') }}">Refresh (F5)</a></li>
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
                    <h4 class="card-title">Daftar Pinjaman Karyawan</h4>
                </div>
            </div>
        </div>
        <div class="iq-card">
            <div class="card-body">
               <div class="row">
                  <div class="col-lg-12 d-flex justify-content-md-between">
                     <div>
                        <div class="btn-group ml-2 bg-white" role="group" aria-label="Basic example">
                           <button type="button" class="btn btn-outline-primary active px-5" onclick="getPengajuan()">Daftar Pengajuan <span class="badge badge-light ml-2">{{ $jumlah_pengajuan }}</span></button>
                           <button type="button" class="btn btn-outline-danger active px-4" onclick="getPinjamanKaryawan()">Daftar Pinjaman Karyawan Aktif <span class="badge badge-light ml-2">{{ $jumlah_pinjaman_aktif }}</span></button>
                           <button type="button" class="btn btn-outline-success active px-4" onclick="getPinjamanKaryawanLunas()">Daftar Pinjaman Karyawan Lunas <span class="badge badge-light ml-2">{{ $jumlah_pinjaman_lunas }}</span></button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
        </div>
        <div class="iq-card">
            <div class="card-body">
               <div class="row">
                    <div class="col-lg-12 d-flex justify-content-md-between">
                        <div class="table-responsive" id="viewResult"></div>
                        <div id="spinner-div" class="pt-5 justify-content-center spinner-div">
                            <div class="spinner-border text-primary" role="status"></div>
                        </div>
                    </div>
               </div>
            </div>
        </div>
    </div>
</div>
<div id="ModalForm" class="modal fade bg-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" id="v_form"></div>
    </div>
 </div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#spinner-div').hide();
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".select2").select2();
        $(".angka").number(true, 0);
    });
    var getPengajuan = function()
    {
        $('#spinner-div').show();
        $('#spinner-div-izin').show();
        $("#viewResult").load("{{ url('hrd/pinjaman_karyawan/getListPengajuan')}}", function(){
            $('#spinner-div').hide();
        });
    }
    var getPinjamanKaryawan = function()
    {
        $('#spinner-div').show();
        $('#spinner-div-izin').show();
        var pil_bulan = $("#pil_bulan").val();
        var pil_tahun = $("#inp_tahun").val();
        $("#viewResult").load("{{ url('hrd/pinjaman_karyawan/getListPinjamanKaryawan')}}", function(){
            $('#spinner-div').hide();
        });
    }
    var getPinjamanKaryawanLunas = function()
    {
        $('#spinner-div').show();
        $('#spinner-div-izin').show();
        // var pil_bulan = $("#pil_bulan").val();
        // var pil_tahun = $("#inp_tahun").val();
        $("#viewResult").load("{{ url('hrd/pinjaman_karyawan/getListPinjamanKaryawanLunas')}}", function(){
            $('#spinner-div').hide();
        });
    }
    var getProses = function(el)
    {
        var id_data = el.id;
        $("#v_form").load("{{ url('hrd/pinjaman_karyawan/getFormProses')}}/"+id_data);
    }

</script>
@endsection
