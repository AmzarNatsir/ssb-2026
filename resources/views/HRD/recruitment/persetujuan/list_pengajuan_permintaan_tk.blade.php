@extends('HRD.layouts.master')
@section('content')
@php
$id_jabatan_user = (empty($lvl_appr_user->id)) ? "" : $lvl_appr_user->id;
@endphp
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Recruitment</li>
        <li class="breadcrumb-item"><a href="#">Persetujuan Permintaan Tenaga Kerja</a></li>
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
                    <h4 class="card-title">Daftar Pengajuan</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <table id="user-list-table" class="table datatable table-hover table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info" style="font-size: 12px">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 5%;" rowspan="2" class="text-center">#</th>
                            <th scope="col" style="width: 10%;" rowspan="2" class="text-center">Tanggal Pengajuan</th>
                            <th scope="col" style="width: 15%;" rowspan="2">Posisi/Jabatan</th>
                            <th scope="col" style="width: 5%;" rowspan="2" class="text-center">Jumlah Permintaan</th>
                            <th scope="col" style="width: 10%;" rowspan="2" class="text-center">Tanggal dibutuhkan</th>
                            <th scope="col" rowspan="2" class="text-center">Alasan Permintaan</th>
                            <th scope="col" style="width: 10%;" colspan="3" class="text-center">Status Persetujuan</th>
                            <th scope="col" style="width: 5%;" rowspan="2" class="text-center">Aksi</th>
                        </tr>
                        <tr>
                            <th class="text-center">Atasan Langsung</td>
                            <th class="text-center">Atasan Tidak Langsung</td>
                            <th class="text-center">HRD</td>
                        </tr>
                    </thead>
                    <tbody>
                    @php $nom=1; @endphp
                    @foreach($list_pengajuan as $list)
                    <tr>
                        <td>{{ $nom }}</td>
                        <td class="text-center">{{ date_format(date_create($list->tanggal_pengajuan), 'd-m-Y') }}</td>
                        <td>{{ $list->get_jabatan->nm_jabatan }} | {{ $list->get_departemen->nm_dept }}</td>
                        <td class="text-center">{{ $list->jumlah_orang }} Orang</td>
                        <td class="text-center">{{ date_format(date_create($list->tanggal_dibutuhkan), 'd-m-Y') }}</td>
                        <td>{{ $list->alasan_permintaan}}</td>
                        <!-- row atasan langsung -->
                        <td class="text-center">
                        @if(empty($list->status_approval_al))
                            @if($list->id_approval_al==$id_jabatan_user)
                                <a href="{{ url('hrd/recruitment/pengajuan_tenaga_kerja/persetujuan_atasan_langsung', $list->id) }}" class="btn btn-primary" title="Apply"><i class="fa fa-edit"></i></a>
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
                        </td>
                        <td class="text-center">
                            @if(empty($list->status_approval_al))
                                <button type="buttom" class="btn btn-warning" title="Waiting"><i class="fa fa-hourglass"></i></button>
                            @else
                                @if($list->status_approval_al==2)
                                    <button type="button" class="btn btn-danger" title="Pengajuan Tidak Dilanjutkan"><i class="fa fa-times"></i></button>
                                @else
                                    @if(empty($list->status_approval_atl))
                                        @if($list->id_approval_atl==$id_jabatan_user)
                                            <a href="{{ url('hrd/recruitment/pengajuan_tenaga_kerja/persetujuan_atasan_tidak_langsung', $list->id) }}" class="btn btn-primary" title="Apply"><i class="fa fa-edit"></i></a>
                                        @else
                                            <button type="buttom" class="btn btn-warning" title="Waiting"><i class="fa fa-hourglass"></i></button>
                                        @endif
                                    @else
                                        @if($list->status_approval_atl==1)
                                        <button type="button" class="btn btn-success" title="Pengajuan Disetujui"><i class="fa fa-check"></i></button>
                                        @else
                                        <button type="button" class="btn btn-danger" title="Pengajuan Tidak Disetujui"><i class="fa fa-times"></i></button>
                                        @endif
                                    @endif
                                @endif
                            @endif
                        </td>
                        <!-- row hrd -->
                        <td class="text-center">
                        @if(empty($list->status_approval_atl))
                            <button type="buttom" class="btn btn-warning" title="Waiting"><i class="fa fa-hourglass"></i></button>
                        @else
                            @if($list->status_approval_al==2 || $list->status_approval_atl==2)
                                <button type="button" class="btn btn-danger" title="Pengajuan Tidak Dilanjutkan"><i class="fa fa-times"></i></button>
                            @else
                                @if(empty($list->status_approval_hrd))
                                    @if($list->id_approval_hrd==$id_jabatan_user)
                                        <a href="{{ url('hrd/recruitment/pengajuan_tenaga_kerja/persetujuan_hrd', $list->id) }}" class="btn btn-primary" title="Apply"><i class="fa fa-edit"></i></a>
                                    @else
                                        <button type="buttom" class="btn btn-warning" title="Waiting"><i class="fa fa-hourglass"></i></button>
                                    @endif
                                @else
                                    @if($list->status_approval_hrd==1)
                                    <button type="button" class="btn btn-success" title="Pengajuan Disetujui"><i class="fa fa-check"></i></button>
                                    @else
                                    <button type="button" class="btn btn-danger" title="Pengajuan Tidak Disetujui"><i class="fa fa-times"></i></button>
                                    @endif
                                @endif
                            @endif
                        @endif
                        </td>
                        <td class="text-center">
                        @if(!empty($list->id_approval_al))
                        <div class="iq-card-header-toolbar d-flex align-items-center">
                            <div class="dropdown">
                            <span class="dropdown-toggle text-primary" id="dropdownMenuButton40" data-toggle="dropdown">
                                <a href="#" class="text-secondary"><i class="ri-more-2-line ml-3"></i></a>
                            </span>
                            <div class="dropdown-menu dropdown-menu-right p-0">
                                <a class="dropdown-item" href="{{ url('hrd/recruitment/pengajuan_tenaga_kerja/persetujuan_detail/'.$list->id) }}" target="_new"><i class="fa fa-eye mr-2"></i> Detail</a>
                            </div>
                            </div>
                        </div>
                        @endif
                        </td>
                    </tr>
                    @php $nom++; @endphp
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $('.datatable').DataTable();
    });
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
