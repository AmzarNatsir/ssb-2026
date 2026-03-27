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
        <li class="breadcrumb-item active" aria-current="page">Perubahan Status</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/perubahanstatus') }}">Refresh (F5)</a></li>
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
    @include('HRD.perubahan_status.summary_status')
    @include('HRD.perubahan_status.remainder')
</div>
<div class="row">
    <div class="col-lg-9">
        <div class="iq-card">
            <div id="spinner-div" class="pt-5 justify-content-center spinner-div"><div class="spinner-border text-primary" role="status"></div></div>
            <div id="view_data">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">Monitoring PKWT Jatuh Tempo <b class="ketView">{{ \App\Helpers\Hrdhelper::get_hari_ini(date('d-m-Y')).', '.date('d').' '.\App\Helpers\Hrdhelper::get_nama_bulan(date('m')). ' '.date('Y') }}</b></h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    <div class="row">
                        @if(count($list_jtp_hari_ini)==0)
                            <div class="col-lg-12">
                                <div class="alert text-white bg-secondary" role="alert">
                                    <div class="iq-alert-text">No matching records found !</div>
                                </div>
                            </div>
                        @else
                            <div class="col-lg-12">
                                <table class="table" style="width:100%">
                                    <tbody>
                                        @php($nom=1)
                                        @foreach($list_jtp_hari_ini as $list)
                                        <tr>
                                            <td style="width: 10%">
                                                @if(!empty($list->photo))
                                                <img src="{{ url(Storage::url('hrd/photo/'.$list->photo)) }}"
                                                    class="rounded-circle" alt="avatar" style="width: 80px; height: auto;">
                                                @else
                                                <a href="{{ asset('assets/images/user/1.jpg') }}" data-fancybox data-caption="avatar">
                                                <img src="{{ asset('assets/images/user/1.jpg') }}"
                                                    class="rounded-circle" alt="avatar" style="width: 80px; height: auto;"></a>
                                                @endif
                                            </td>
                                            <td style="width: 40%">
                                                <h4 class="mb-0">{{ $list->nm_lengkap }}</h4>
                                                <h6 class="mb-0">{{ (empty($list->get_jabatan->nm_jabatan)) ? "" : $list->get_jabatan->nm_jabatan }} | {{ $list->get_departemen->nm_dept }}</h6>
                                            </td>
                                            <td style="width: 40%">
                                                <h4 class="mb-0">Status Karyawan : {{ $list->get_status_karyawan($list->id_status_karyawan) }}</h4>
                                                <h6 class="mb-0">
                                                    PKWT Efektif Mulai : <span class="text-success">{{ date_format(date_create($list->tgl_sts_efektif_mulai), 'd-m-Y') }}</span> s/d <span class="text-danger">{{ date_format(date_create($list->tgl_sts_efektif_akhir), 'd-m-Y') }}</span></h6>
                                                </h6>
                                            </td>
                                            <td style="width: 10%; vertical-align: middle">
                                                <button type="button" name="tbl_rubah_status" id="{{ \App\Helpers\Hrdhelper::encrypt_decrypt('encrypt', $list->id) }}" class="btn btn-primary btn-block" onClick="prosesPerubahanStatus(this);">Proses</button>
                                            </td>
                                        </tr>
                                        @php($nom++)
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="iq-right-fixed rounded iq-card iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">List Pengajuan</h4>
                </div>
            </div>
            <div class="iq-card-body" style="overflow-y: auto;">
                <div class="owl-carousel"  data-autoplay="true" data-loop="true" data-nav="false" data-dots="true" data-items="1" data-items-laptop="1" data-items-tab="1" data-items-mobile="1" data-items-mobile-sm="1" data-margin="30">
                    @foreach($list_pengajuan as $list)
                    <div class="item">
                        <ul class="iq-timeline">
                            <li>
                                <div class="timeline-dots border-success"></div>
                                <h6 class="float-left mb-1">{{ $list->get_profil->nm_lengkap }}</h6>
                                <small class="float-right mt-1">{{ date_format(date_create($list->tgl_pengajuan), 'd-m-Y') }}</small>
                                <div class="d-inline-block w-100">
                                    <p><i>{{ (empty($list->get_profil->get_jabatan->nm_jabatan)) ? "" : $list->get_profil->get_jabatan->nm_jabatan. ' | ' .$list->get_profil->get_departemen->nm_dept}}</i></p>
                                    <table class="table table-sm" style="width: 100%">
                                        <tr>
                                            <td style="width: 50%">Efektif</td>
                                            <td>Berakhir</td>
                                        </tr>
                                        <tr>
                                            <td>{{ date_format(date_create($list->tgl_eff_lama), 'd-m-Y') }}</td>
                                            <td>{{ date_format(date_create($list->tgl_akh_lama), 'd-m-Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Saat ini</td>
                                            <td>Usulan</td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge badge-primary">{{ $list->get_status_karyawan($list->id_sts_baru) }}</span></td>
                                            <td><span class="badge badge-success">{{ $list->get_status_karyawan($list->id_sts_lama) }}</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">@if($list->status_pengajuan==1)
                                                <span class="badge badge-pill badge-danger">Menunggu Persetujuan : {{ $list->get_current_approve->nm_lengkap }}</span>
                                                <span class="badge badge-pill badge-danger">{{ $list->get_current_approve->get_jabatan->nm_jabatan }}</span>
                                            @elseif($list->status_pengajuan==2)
                                                <span class="badge badge-success badge-block"><i class="fa fa-check"></i> Pengajuan Disetujui</span>
                                            @else
                                                <span class="badge badge-danger"><i class="fa fa-times"></i> Pengajuan Ditolak</span>
                                            @endif</td>
                                        </tr>
                                    </table>
                                    <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#modalDetailPengajuan" onclick="goDetail(this)" value="{{ $list->id }}">Detail</button>
                                    @if($list->status_pengajuan==2)
                                    <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalFormProses" value="{{ $list->id }}" onclick="goForm(this)"><i class='ri-pencil-line'></i> Registrasi</button>
                                    @endif
                                </div>
                            </li>
                        </ul>
                    </div>
                    @endforeach

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
        $(".select2").select2();
        $('.datatable').DataTable({
            searchDelay: 500,
            processing: true,
        });
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    });
    var getDataDept = function()
    {
        $('#spinner-div').show();
        var bulan = $("#pil_bulan").val();
        var tahun = $("#inp_tahun").val();
        var id_dept = $("#pil_dept").val();
        $.ajax({
            type : "post",
            url : "{{ url('hrd/perubahanstatus/filterdata') }}",
            headers : {
                'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
            },
            data : {id_dept:id_dept, bulan:bulan, tahun:tahun},
            beforeSend : function()
            {
                $('#spinner-div').show();
            },
            success : function(respond)
            {
                $("#view_data").html(respond);
                //$('#datatable').DataTable();
                $('#spinner-div').hide();
            }
        });
    }
    var prosesPerubahanStatus = function(el)
    {
        var id_karyawan = el.id;
        window.location.assign("{{ url('hrd/perubahanstatus/baru') }}/"+id_karyawan);
    }
    var goForm = function(el)
    {
        $('#spinner-div').show();
        var id_data = $(el).val();
        $("#v_inputan").load("{{ url('hrd/perubahanstatus/form_proses') }}/"+id_data, function(){
            $('#spinner-div').hide();
        });
    }
    var goDetail = function(el)
    {
        var id_data = $(el).val();
        $("#v_detail").load("{{ url('hrd/perubahanstatus/detail_pengajuan') }}/"+id_data);
    }
    var showData = function(el)
    {
        $('#spinner-div').show();
        var kategori = $(el).val();
        $.ajax({
            type : "post",
            url : "{{ url('hrd/perubahanstatus/filterdata') }}",
            headers : {
                'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
            },
            data : {kategori:kategori},
            beforeSend : function()
            {
                $('#spinner-div').show();
            },
            success : function(respond)
            {
                $("#view_data").html(respond);
                //$('#datatable').DataTable();
                $('#spinner-div').hide();
            }
        });
    }
</script>
@endsection
