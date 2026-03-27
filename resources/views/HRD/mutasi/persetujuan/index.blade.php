@extends('HRD.layouts.master')
@section('content')
@php
$user = auth()->user();
$id_jabatan_setup_hrd = (empty($arr_appr_setup->id_dept_manager_hrd)) ? "" : $arr_appr_setup->id_dept_manager_hrd;
$id_jabatan_user_hrd = (empty($lvl_appr_user->id_jabatan)) ? "" : $lvl_appr_user->id_jabatan;
$id_user = (empty($lvl_appr_user->id)) ? "" : $lvl_appr_user->id;
@endphp
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item" aria-current="page">Mutasi</li>
        <li class="breadcrumb-item active">Daftar Pengajuan</li>
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
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Daftar Pengajuan Mutasi & Promosi</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <div class="row justify-content-center mt-3">
                    <table id="user-list-table" class="table  table-hover table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info">
                        <thead>
                        <tr>
                            <th rowspan="2" style="width: 5%;">#</th>
                            <th colspan="2" class="btn-success" style="text-align: center">Karyawan</th>
                            <th colspan="4" class="btn-primary" style="text-align: center">Pengajuan</th>
                            <th colspan="2" style="width: 10%; text-align:center">Persetujuan</th>
                        </tr>
                        <tr>
                            <th style="width: 15%;">Nama Karyawan</th>
                            <th style="width: 15%;">Posisi Saat Ini</th>
                            <th style="width: 10%;">Tanggal</th>
                            <th style="width: 20%;">Alasan Pengajuan</th>
                            <th style="width: 15%;">Usulan Posisi Baru</th>
                            <th style="width: 10%;">Kategori</th>
                            <th style="text-align: center;">Atasan Langsung</th>
                            <th style="text-align: center;">HRD</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $nom=1 @endphp
                        @foreach($list_pengajuan as $list)
                            <tr>
                                <td>{{ $nom }}</td>
                                <td>{{ $list->get_profil->nik }} | {{ $list->get_profil->nm_lengkap }}</td>
                                <td><b>{{ $list->get_jabatan_lama->nm_jabatan }}{{ (!empty($list->id_dept_lm)) ? " - ".$list->get_dept_lama->nm_dept : "" }}</b>
                                </td>
                                <td>{{ $list['tgl_pengajuan'] }}</td>
                                <td>{{ $list['alasan_pengajuan'] }}</td>
                                <td><b>{{ $list->get_jabatan_baru->nm_jabatan }}{{ (!empty($list->id_dept_br)) ? " - ".$list->get_dept_baru->nm_dept : "" }}</b>
                                </td>
                                <td>@foreach($list_kategori as $key => $value)
                                        @if($key==$list->kategori)
                                            {{ $value }}
                                            @php break; @endphp
                                        @endif
                                        @endforeach</td>
                                <td style="text-align: center;">
                                    @if ($user->can('persetujuan_mutasi_rotasi_approve'))
                                    @if(empty($list->status_approval_al))
                                        @if($list->id_approval_al==$id_user)
                                            <button type="button" class="btn btn-primary" value="{{ $list->id }}" data-toggle="modal" data-target="#modalFormPengajuan" onclick="goFormAL(this)"><i class="fa fa-edit"></i></button>
                                        @else
                                            <button type="buttom" class="btn btn-warning" title="Waiting"><i class="fa fa-hourglass"></i></button>
                                        @endif
                                    @else
                                        @if($list->status_approval_al==1)
                                        <button type="button" class="btn btn-success" title="Pengajuan Disetujui"><i class="fa fa-check"></i></button>
                                        @else
                                        <button type="button" class="btn btn-danger" title="Pengajuan Tidak Disetujui"><i class="fa fa-times"></i></button>
                                        @endif
                                    @endif
                                @endif
                                </td>
                                <td style="text-align: center;">
                                    @if ($user->can('persetujuan_mutasi_rotasi_approve'))
                                        @if($list->status_pengajuan==1)
                                            @if(empty($list->status_approval_al))
                                                <button type="buttom" class="btn btn-warning" title="Waiting"><i class="fa fa-hourglass"></i></button>
                                            @else
                                                @if($list->id_persetujuan==$id_user)
                                                    <button type="button" class="btn btn-primary" value="{{ $list->id }}" data-toggle="modal" data-target="#modalFormPengajuan" onclick="goFormHRD(this)"><i class="fa fa-edit"></i></button>
                                                @else
                                                    <button type="buttom" class="btn btn-warning" title="Waiting"><i class="fa fa-hourglass"></i></button>
                                                @endif
                                            @endif
                                        @else
                                            @if($list->sts_persetujuan==1)
                                                <button type="buttom" class="btn btn-success" title="Disetujui"><i class="fa fa-check"></i></button>
                                            @else
                                                <button type="buttom" class="btn btn-danger" title="Ditolak"><i class="fa fa-times"></i></button>
                                            @endif
                                        @endif

                                    @endif
                                </td>
                            </tr>
                        @php $nom++ @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modalFormPengajuan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content" id="v_inputan" style="overflow-y: auto;"></div>
    </div>
 </div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    });
    var goFormAL = function(el)
    {
        var id_data = $(el).val();
        $("#v_inputan").load("{{ url('hrd/mutasi/form_persetujuan_al') }}/"+id_data);
    }
    var goFormHRD = function(el)
    {
        var id_data = $(el).val();
        $("#v_inputan").load("{{ url('hrd/mutasi/formpersetujuan') }}/"+id_data);
    }
</script>
@endsection
