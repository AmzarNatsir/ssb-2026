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
        <li class="breadcrumb-item" aria-current="page">Perubahan Status Karyawan</li>
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
                    <h4 class="card-title">Daftar Pengajuan Perubahan Status Karyawan</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <div class="row justify-content-center mt-3">
                <table class="table table-hover" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th rowspan="2" style="width: 5%;">#</th>
                            <th rowspan="2" style="width: 20%;">Nama Karyawan</th>
                            <th  rowspan="2">Jabatan/Departemen</th>
                            <th colspan="3" class="btn-primary" style="text-align: center">Pengajuan</th>
                            <th colspan="3" class="btn-success" style="text-align: center">Status Karyawan Saat Ini</th>
                            <th colspan="2" style="width: 10%; text-align:center">Persetujuan</th>
                        </tr>
                        <tr>
                            <th style="width: 10%;">Tanggal</th>
                            <th style="width: 20%;">Alasan Pengajuan</th>
                            <th style="width: 10%;">Usulan</th>
                            <th style="text-align: center;">Status</th>
                            <th style="text-align: center;">Efektif</th>
                            <th style="text-align: center;">Berakhir</th>
                            <th style="text-align: center;">Atasan Langsung</th>
                            <th style="text-align: center;">HRD</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $nom=1; @endphp
                    @foreach($list_pengajuan as $list)
                        <tr>
                            <td>{{ $nom }}</td>
                            <td>{{ $list->get_profil->nik." | ".$list->get_profil->nm_lengkap }}</td>
                            <td>{{ $list->get_profil->get_jabatan->nm_jabatan." | ".$list->get_profil->get_departemen->nm_dept }}</td>
                            <td>{{ date_format(date_create($list->tgl_pengajuan), 'd-m-Y') }}</td>
                            <td>{{ $list->alasan_pengajuan }}</td>
                            <td>{{ $list->get_status_karyawan($list->id_sts_baru) }}</td>
                            <td>{{ $list->get_status_karyawan($list->id_sts_lama) }}</td>
                            <td>{{ (empty($list->tgl_eff_lama)) ? "" : date_format(date_create($list->tgl_eff_lama), 'd-m-Y') }}</td>
                            <td>{{ (empty($list->tgl_akh_lama)) ? "" : date_format(date_create($list->tgl_akh_lama), 'd-m-Y') }}</td>
                            <td style="text-align: center;">
                                @if ($user->can('persetujuan_perubahan_status_approve'))
                                    @if(empty($list->status_approval_al))
                                        @if($list->id_approval_al==$id_user)
                                            <button type="button" class="btn btn-primary" value="{{ $list->id }}" data-toggle="modal" data-target="#modalFormPersetujuan" onclick="goFormAL(this)"><i class="fa fa-edit"></i></button>
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
                                @if ($user->can('persetujuan_perubahan_status_approve'))
                                    @if($list->status_pengajuan==1)
                                        @if(empty($list->status_approval_al))
                                            <button type="buttom" class="btn btn-warning" title="Waiting"><i class="fa fa-hourglass"></i></button>
                                        @else
                                            @if($list->id_persetujuan==$id_user)
                                                <button type="button" class="btn btn-primary" value="{{ $list->id }}" data-toggle="modal" data-target="#modalFormPersetujuan" onclick="goForm(this)"><i class="fa fa-edit"></i></button>
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
                    @endforeach
                    @php $nom++; @endphp
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modalFormPersetujuan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" id="v_inputan" style="overflow-y: auto;"></div>
    </div>
 </div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    });
    var goForm = function(el)
    {
        var id_data = $(el).val();
        $("#v_inputan").load("{{ url('hrd/perubahanstatus/form_persetujuan') }}/"+id_data);
    }
    var goFormAL = function(el)
    {
        var id_data = $(el).val();
        $("#v_inputan").load("{{ url('hrd/perubahanstatus/form_persetujuan_al') }}/"+id_data);
    }
</script>
@endsection
