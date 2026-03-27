@extends('HRD.layouts.master')
@section('content')
@php
$user = auth()->user();
@endphp
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Recruitment</li>
        <li class="breadcrumb-item"><a href="#">Pengajuan Permintaan Tenaga Kerja</a></li>
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
                <div class="row justify-content-between">
                    <div class="col-sm-12 col-md-12">
                        <div class="user-list-files d-flex float-right">
                            <a href="{{ url('hrd/recruitment/pengajuan_tenaga_kerja/baru') }}"><i class="fa fa-plus"></i> Pengajuan Baru</a>
                        </div>
                    </div>
                </div>
                <br>
                <table id="user-list-table" class="table datatable table-hover table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info" style="font-size: 12px">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 5%;" class="text-center">#</th>
                            <th scope="col" style="width: 10%;" class="text-center">Pengajuan</th>
                            <th scope="col" style="width: 15%;">Posisi/Jabatan</th>
                            <th scope="col" style="width: 5%;" class="text-center">Jumlah Permintaan</th>
                            <th scope="col" style="width: 10%;" class="text-center">Tanggal dibutuhkan</th>
                            <th scope="col" class="text-center">Alasan Permintaan</th>
                            <th scope="col" style="width: 10%;" class="text-center">Status Pengajuan</th>
                            <th scope="col" style="width: 5%;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $nom=1; @endphp
                    @foreach($list_pengajuan as $list)
                    <tr>
                        <td>{{ $nom }}</td>
                        <td class="text-center">{{ date_format(date_create($list->tanggal_pengajuan), 'd-m-Y') }}</td>
                        <td>{{ $list->get_jabatan->nm_jabatan }}</td>
                        <td class="text-center">{{ $list->jumlah_orang }} Orang</td>
                        <td class="text-center">{{ date_format(date_create($list->tanggal_dibutuhkan), 'd-m-Y') }}</td>
                        <td>{{ $list->alasan_permintaan}}</td>
                        <td class="text-center">
                            @if($list->status_pengajuan==1)
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Menunggu Persetujuan
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                        <a class="dropdown-item" href="#"><i class="fa fa-user mr-1"></i>{{ $list->get_current_approve->nm_lengkap }}</a>
                                        <a class="dropdown-item" href="#"><i class="fa fa-user mr-1"></i>{{ $list->get_current_approve->get_jabatan->nm_jabatan }}</a>
                                    </div>
                                </div>
                            </div>
                            @elseif($list->status_pengajuan==2)
                            <span class="badge badge-success">Disetujui</span>
                            @else
                            <span class="badge badge-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>

                        <div class="iq-card-header-toolbar d-flex align-items-center">
                            <div class="dropdown">
                                <span class="dropdown-toggle text-primary" id="dropdownMenuButton40" data-toggle="dropdown">
                                    <a href="#" class="text-secondary"><i class="ri-more-2-line ml-3"></i></a>
                                </span>
                                <div class="dropdown-menu dropdown-menu-right p-0">
                                    @if($list->is_draft==1)
                                        <a class="dropdown-item" href="{{ url('hrd/recruitment/pengajuan_tenaga_kerja/edit/'.$list->id) }}" target="_self"><i class="fa fa-edit "></i> Edit</a>
                                        <a class="dropdown-item" href="{{ url('hrd/recruitment/pengajuan_tenaga_kerja/delete/'.$list->id) }}" onclick="return goDelete()"><i class="fa fa-trash mr-2"></i> Hapus</a>
                                    @else
                                        <a class="dropdown-item" href="{{ url('hrd/recruitment/pengajuan_tenaga_kerja/persetujuan_detail/'.$list->id) }}" target="_new"><i class="fa fa-eye mr-2"></i> Detail</a>
                                    @endif
                                </div>
                            </div>
                        </div>
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
