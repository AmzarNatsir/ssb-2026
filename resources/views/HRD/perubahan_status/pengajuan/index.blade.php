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
    .list-pengajuan-body {
        max-height: 70vh;
        overflow-y: auto;
        padding-right: 6px;
    }
    .pengajuan-card {
        border: 1px solid #e8edf3;
        border-radius: 12px;
        padding: 14px;
        margin-bottom: 12px;
        background: #ffffff;
        box-shadow: 0 2px 8px rgba(31, 45, 61, 0.05);
    }
    .pengajuan-card:last-child {
        margin-bottom: 0;
    }
    .pengajuan-meta {
        color: #6c757d;
        font-size: 12px;
    }
    .pengajuan-grid {
        width: 100%;
        margin-top: 8px;
    }
    .pengajuan-grid td {
        padding: 4px 0;
        vertical-align: top;
        font-size: 13px;
    }
    .pengajuan-grid td:first-child {
        color: #6c757d;
        width: 36%;
    }
    .status-pill {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
    }
    .status-pending {
        background: #fff3cd;
        color: #856404;
    }
    .status-approved {
        background: #d4edda;
        color: #155724;
    }
    .status-rejected {
        background: #f8d7da;
        color: #721c24;
    }
    .monitoring-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .monitoring-item {
        border: 1px solid #e8edf3;
        border-radius: 12px;
        padding: 12px;
        background: #fff;
    }
    .monitoring-avatar {
        width: 58px;
        height: 58px;
        object-fit: cover;
    }
    .monitoring-name {
        font-size: 16px;
        margin-bottom: 0;
    }
    .monitoring-job {
        color: #6c757d;
        margin-bottom: 0;
        font-size: 12px;
    }
    .monitoring-status {
        margin-bottom: 6px;
        font-size: 13px;
    }
    .monitoring-period {
        margin-bottom: 0;
        font-size: 13px;
    }
    @media (max-width: 991px) {
        .monitoring-item .row {
            row-gap: 10px;
        }
    }
</style>
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item" aria-current="page">Evaluasi Karyawan - Perubahan Status</li>
        <li class="breadcrumb-item active">Monitoring PKWT - Pengajuan</li>
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
    @include('HRD.perubahan_status.remainder')
</div>
<div class="row">
    <div class="col-lg-9">
        <div class="iq-card">
            <div id="spinner-div" class="pt-5 justify-content-center spinner-div"><div class="spinner-border text-primary" role="status"></div></div>
            <div id="view_data">
                @include('HRD.perubahan_status.pengajuan.result_filter', ['list' => $list_jtp_hari_ini, 'keterangan' => $keterangan_default])
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="iq-right-fixed rounded iq-card iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">List Pengajuan</h4>
                </div>
                <span class="badge badge-primary">{{ count($list_pengajuan) }}</span>
            </div>
            <div class="iq-card-body list-pengajuan-body">
                @if(count($list_pengajuan) == 0)
                    <div class="alert alert-light mb-0 text-center">
                        Belum ada pengajuan.
                    </div>
                @else
                    @foreach($list_pengajuan as $list)
                        <div class="pengajuan-card">
                            <div class="d-flex justify-content-between align-items-start">
                                <h6 class="mb-1">{{ $list->get_profil->nm_lengkap }}</h6>
                                <span class="pengajuan-meta">{{ date_format(date_create($list->tgl_pengajuan), 'd-m-Y') }}</span>
                            </div>
                            <div class="pengajuan-meta mb-2">
                                {{ (empty($list->get_profil->get_jabatan->nm_jabatan)) ? '-' : $list->get_profil->get_jabatan->nm_jabatan }} | {{ $list->get_profil->get_departemen->nm_dept }}
                            </div>
                            <table class="pengajuan-grid">
                                <tr>
                                    <td>Periode Lama</td>
                                    <td>
                                        {{ date_format(date_create($list->tgl_eff_lama), 'd-m-Y') }}
                                        s/d
                                        {{ date_format(date_create($list->tgl_akh_lama), 'd-m-Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Status Saat Ini</td>
                                    <td><span class="badge badge-primary">{{ $list->get_status_karyawan($list->id_sts_lama) }}</span></td>
                                </tr>
                                <tr>
                                    <td>Status Usulan</td>
                                    <td><span class="badge badge-success">{{ $list->get_status_karyawan($list->id_sts_baru) }}</span></td>
                                </tr>
                            </table>

                            <div class="mb-2">
                                @if($list->status_pengajuan==1)
                                    <span class="status-pill status-pending">Menunggu Persetujuan</span>
                                    <div class="pengajuan-meta mt-1">
                                        {{ optional($list->get_current_approve)->nm_lengkap }}
                                        @if(optional(optional($list->get_current_approve)->get_jabatan)->nm_jabatan)
                                            - {{ optional(optional($list->get_current_approve)->get_jabatan)->nm_jabatan }}
                                        @endif
                                    </div>
                                @elseif($list->status_pengajuan==2)
                                    <span class="status-pill status-approved">Pengajuan Disetujui</span>
                                @else
                                    <span class="status-pill status-rejected">Pengajuan Ditolak</span>
                                @endif
                            </div>

                            <button type="button" class="btn btn-outline-danger btn-block btn-sm" data-toggle="modal" data-target="#modalDetailPengajuan" onclick="goDetail(this)" value="{{ $list->id }}">Detail</button>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

<div id="modalFormPengajuan" class="modal fade bg-modal" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
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
    var goForm = function(el)
    {
        var id_data = $(el).val();
        $("#v_inputan").load("{{ url('hrd/perubahanstatus/form_pengajuan') }}/"+id_data);
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
            url : "{{ url('hrd/perubahanstatus/filterdata_perdept') }}",
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
