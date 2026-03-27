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
        <li class="breadcrumb-item" aria-current="page">Perjalanan Dinas</li>
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
                    <h4 class="card-title">Daftar Pengajuan Perjalanan Dinas</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <div class="row justify-content-center table-responsive">
                <table class="table datatable table-hover" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th scope="col" rowspan="2" style="width: 5%;">#</th>
                            <th scope="col" rowspan="2" style="width: 10%;">Tanggal&nbsp;Pengajuan</th>
                            <th scope="col" rowspan="2" style="width: 15%;">Karyawan</th>
                            <th scope="col" rowspan="2" style="width: 15%;">Tujuan</th>
                            <th scope="col" rowspan="2">Alasan</th>
                            <th scope="col" colspan="2" style="text-align: center; width: 20%;">Tanggal Perjalanan</th>
                            <th scope="col" colspan="2" style="width: 10%;">Persetujuan</th>
                        </tr>
                        <tr>
                            <th style="text-align: center">Berangkat</th>
                            <th style="text-align: center">Kembali</th>
                            <th style="text-align: center">Atasan Langsung</th>
                            <th style="text-align: center">HRD</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $nom=1 @endphp
                    @foreach($list_pengajuan as $list)
                    <tr>
                        <td style="text-align: center;">{{ $nom }}</td>
                        <td style="text-align: center;">{{ date_format(date_create($list->tgl_pengajuan), 'd-m-Y') }}</td>
                        <td>{{ $list->get_profil->nm_lengkap }}</td>
                        <td>{{ $list->tujuan }}</td>
                        <td>{{ $list->maksud_tujuan }}</td>
                        <td style="text-align: center;">{{ date_format(date_create($list->tgl_berangkat), 'd-m-Y') }}</td>
                        <td style="text-align: center;">{{ date_format(date_create($list->tgl_kembali), 'd-m-Y') }}</td>
                        <td style="text-align: center;">
                            @if ($user->can('persetujuan_perjalanan_dinas_approve'))
                                @if(empty($list->status_approval_al))
                                    @if($list->id_approval_al==$id_user)
                                        <button type="button" class="btn btn-primary" value="{{ $list->id }}" data-toggle="modal" data-target="#modalFormPersetujuan" onclick="goFormAL(this)"><i class="fa fa-edit"></i></button>
                                    @else
                                        <button type="buttom" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Waiting"><i class="fa fa-hourglass"></i></button>
                                    @endif
                                @else
                                    @if($list->status_approval_al==1)
                                    <button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Pengajuan Disetujui"><i class="fa fa-check"></i></button>
                                    @else
                                    <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Pengajuan Tidak Disetujui"><i class="fa fa-times"></i></button>
                                    @endif
                                @endif
                            @endif
                        </td>
                        <td>
                            @if ($user->can('persetujuan_perjalanan_dinas_approve'))
                                @if($list->sts_pengajuan==1)
                                    @if(empty($list->status_approval_al))
                                        <button type="buttom" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Waiting"><i class="fa fa-hourglass"></i></button>
                                    @else
                                        @if($list->id_persetujuan==$id_user)
                                            <button type="button" class="btn btn-primary" value="{{ $list->id }}" data-toggle="modal" data-target="#modalFormPersetujuan" onclick="goFormHRD(this)"><i class="fa fa-edit"></i></button>
                                        @else
                                            <button type="buttom" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Waiting"><i class="fa fa-hourglass"></i></button>
                                        @endif
                                    @endif
                                @else
                                    @if($list->sts_persetujuan==1)
                                        <button type="buttom" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Disetujui"><i class="fa fa-check"></i></button>
                                    @else
                                        <button type="buttom" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Ditolak"><i class="fa fa-times"></i></button>
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
<div id="modalFormPersetujuan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" id="v_inputan" style="overflow-y: auto;"></div>
    </div>
 </div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $('.datatable').DataTable({
            searchDelay: 500,
            processing: true,
        });
    });
    var goFormAL = function(el)
    {
        var id_data = $(el).val();
        $("#v_inputan").load("{{ url('hrd/perjalanandinas/persetujuan/formPersetujuan_al') }}/"+id_data);
    }
    var goFormHRD = function(el)
    {
        var id_data = $(el).val();
        $("#v_inputan").load("{{ url('hrd/perjalanandinas/persetujuan/formPersetujuan_hrd') }}/"+id_data);
    }
</script>
@endsection
