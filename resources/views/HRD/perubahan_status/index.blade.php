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
    .monitoring-shell {
        padding: 0 8px 8px;
    }
    .monitoring-card {
        border: 1px solid #e8edf3;
        border-radius: 14px;
        padding: 14px 16px;
        background: #fff;
        box-shadow: 0 2px 8px rgba(31, 45, 61, 0.05);
        margin-bottom: 12px;
    }
    .monitoring-card:last-child {
        margin-bottom: 0;
    }
    .monitoring-avatar {
        width: 74px;
        height: 74px;
        object-fit: cover;
    }
    .monitoring-name {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 4px;
    }
    .monitoring-job {
        color: #6c757d;
        margin-bottom: 0;
        font-size: 13px;
    }
    .monitoring-status {
        margin-bottom: 6px;
        font-size: 14px;
    }
    .monitoring-period {
        margin-bottom: 0;
        font-size: 14px;
    }
    .monitoring-action {
        min-width: 140px;
    }
    .pengajuan-shell {
        max-height: 76vh;
        overflow-y: auto;
        padding: 0 8px 8px;
    }
    .pengajuan-card {
        border: 1px solid #e8edf3;
        border-radius: 14px;
        background: #fff;
        padding: 14px;
        box-shadow: 0 2px 8px rgba(31, 45, 61, 0.05);
        margin-bottom: 12px;
    }
    .pengajuan-card:last-child {
        margin-bottom: 0;
    }
    .pengajuan-name {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 2px;
    }
    .pengajuan-meta {
        color: #6c757d;
        font-size: 12px;
        margin-bottom: 0;
    }
    .pengajuan-block {
        margin-top: 10px;
    }
    .pengajuan-table {
        width: 100%;
        margin-top: 8px;
    }
    .pengajuan-table td {
        padding: 4px 0;
        vertical-align: top;
        font-size: 13px;
    }
    .pengajuan-table td:first-child {
        color: #6c757d;
        width: 40%;
    }
    .pengajuan-status {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
    }
    .pengajuan-pending {
        background: #fff3cd;
        color: #856404;
    }
    .pengajuan-approved {
        background: #d4edda;
        color: #155724;
    }
    .pengajuan-rejected {
        background: #f8d7da;
        color: #721c24;
    }
    .pengajuan-avatar {
        width: 54px;
        height: 54px;
        object-fit: cover;
    }
    .pengajuan-actions .btn {
        margin-top: 8px;
    }
    @media (max-width: 767.98px) {
        .monitoring-card {
            padding: 12px;
        }
        .monitoring-avatar {
            width: 58px;
            height: 58px;
        }
        .monitoring-name {
            font-size: 16px;
        }
        .monitoring-action {
            min-width: 100%;
        }
        .pengajuan-shell {
            max-height: none;
        }
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
    @if(Session::has('konfirm'))
        <div class="alert text-white bg-success" role="alert" id="success-alert">
            <div class="iq-alert-icon">
                <i class="ri-alert-line"></i>
            </div>
            <div class="iq-alert-text">{{ Session::get('konfirm') }}</div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="ri-close-line"></i>
            </button>
        </div>
    @endif
    @include('HRD.perubahan_status.summary_status')
    @include('HRD.perubahan_status.remainder')
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="iq-card">
            <div id="spinner-div" class="pt-5 justify-content-center spinner-div">
                <div class="spinner-border text-primary" role="status"></div>
            </div>
            <div id="view_data">
                @include('HRD.perubahan_status.status_karyawan', ['list' => $list_jtp_hari_ini, 'keterangan' => $keterangan_default])
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="iq-right-fixed rounded iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-header d-flex justify-content-between align-items-center">
                <div class="iq-header-title">
                    <h4 class="card-title mb-0">List Pengajuan</h4>
                </div>
                <span class="badge badge-primary">{{ count($list_pengajuan) }}</span>
            </div>
            <div class="iq-card-body pengajuan-shell">
                @if(count($list_pengajuan) == 0)
                    <div class="alert alert-light mb-0 text-center">
                        Belum ada pengajuan.
                    </div>
                @else
                    @foreach($list_pengajuan as $list)
                        <div class="pengajuan-card">
                            <div class="d-flex align-items-start">
                                <div class="mr-3 flex-shrink-0">
                                    @if(!empty($list->get_profil->photo))
                                        <img src="{{ url(Storage::url('hrd/photo/'.$list->get_profil->photo)) }}" class="rounded-circle pengajuan-avatar" alt="avatar">
                                    @else
                                        <img src="{{ asset('assets/images/user/1.jpg') }}" class="rounded-circle pengajuan-avatar" alt="avatar">
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="pengajuan-name">{{ $list->get_profil->nm_lengkap }}</div>
                                            <p class="pengajuan-meta">{{ date_format(date_create($list->tgl_pengajuan), 'd-m-Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="pengajuan-meta mb-2">
                                        {{ (empty($list->get_profil->get_jabatan->nm_jabatan)) ? '-' : $list->get_profil->get_jabatan->nm_jabatan }} | {{ $list->get_profil->get_departemen->nm_dept }}
                                    </div>
                                </div>
                            </div>

                            <div class="pengajuan-block">
                                <table class="pengajuan-table">
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
                            </div>

                            <div class="mt-2">
                                @if($list->status_pengajuan==1)
                                    <span class="pengajuan-status pengajuan-pending">Menunggu Persetujuan</span>
                                    <div class="pengajuan-meta mt-1">
                                        {{ optional($list->get_current_approve)->nm_lengkap }}
                                        @if(optional(optional($list->get_current_approve)->get_jabatan)->nm_jabatan)
                                            - {{ optional(optional($list->get_current_approve)->get_jabatan)->nm_jabatan }}
                                        @endif
                                    </div>
                                @elseif($list->status_pengajuan==2)
                                    <span class="pengajuan-status pengajuan-approved">Pengajuan Disetujui</span>
                                @else
                                    <span class="pengajuan-status pengajuan-rejected">Pengajuan Ditolak</span>
                                @endif
                            </div>

                            <div class="pengajuan-actions">
                                <button type="button" class="btn btn-outline-danger btn-block btn-sm" data-toggle="modal" data-target="#modalDetailPengajuan" onclick="goDetail(this)" value="{{ $list->id }}">Detail</button>
                                @if($list->status_pengajuan==2)
                                    <button type="button" class="btn btn-primary btn-block btn-sm" data-toggle="modal" data-target="#modalFormProses" value="{{ $list->id }}" onclick="goForm(this)"><i class='ri-pencil-line'></i> Registrasi {{ $list->id }}</button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
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
    $(document).ready(function () {
        $('#spinner-div').hide();
        window.setTimeout(function () {
            $('#success-alert').alert('close');
        }, 2000);
    });

    var goForm = function (el) {
        $('#spinner-div').show();
        var id_data = $(el).val();
        $('#v_inputan').load("{{ url('hrd/perubahanstatus/form_proses') }}/" + id_data, function () {
            $('#spinner-div').hide();
        });
    };

    var goDetail = function (el) {
        var id_data = $(el).val();
        $('#v_detail').load("{{ url('hrd/perubahanstatus/detail_pengajuan') }}/" + id_data);
    };

    var showData = function (el) {
        $('#spinner-div').show();
        var kategori = $(el).val();

        $.ajax({
            type: 'post',
            url: "{{ url('hrd/perubahanstatus/filterdata') }}",
            headers: {
                'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'
            },
            data: { kategori: kategori },
            beforeSend: function () {
                $('#spinner-div').show();
            },
            success: function (respond) {
                $('#view_data').html(respond);
                $('#spinner-div').hide();
            },
            error: function () {
                $('#spinner-div').hide();
            }
        });
    };
</script>
@endsection
