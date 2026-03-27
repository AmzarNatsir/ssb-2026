@extends('HRD.layouts.master')
@section('content')
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
            @if(\Session::get('status')==true)
            <div class="alert text-white bg-success" role="alert" id="success-alert">
                <div class="iq-alert-icon">
                    <i class="ri-alert-line"></i>
                </div>
                <div class="iq-alert-text">{{ \Session::get('konfirm') }}</div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="ri-close-line"></i>
                </button>
            </div>
            @else
            <div class="alert text-white bg-danger" role="alert" id="success-alert">
                <div class="iq-alert-icon">
                    <i class="ri-alert-line"></i>
                </div>
                <div class="iq-alert-text">{{ \Session::get('konfirm') }}</div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="ri-close-line"></i>
                </button>
            </div>
            @endif
        @endif
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Daftar Pengajuan Mutasi</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <div class="row justify-content-between">
                    <div class="col-sm-6 col-md-12">
                        <div class="user-list-files d-flex float-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalFormPengajuan" onclick="goForm(this)"><i class="fa fa-plus"> </i> Form Pengajuan</button>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-3">
                    <table id="user-list-table" class="table  table-hover table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info" style="font-size: 12px">
                        <thead>
                        <tr>
                            <th rowspan="2" style="width: 5%;">#</th>
                            <th colspan="2" class="btn-success" style="text-align: center">Karyawan</th>
                            <th colspan="4" class="btn-primary" style="text-align: center">Pengajuan</th>
                            <th rowspan="2" style="width: 10%; text-align:center">Persetujuan</th>
                        </tr>
                        <tr>
                            <th style="width: 15%;">NIK - Nama</th>
                            <th style="width: 15%;">Posisi Saat Ini</th>
                            <th style="width: 10%;">Tanggal</th>
                            <th style="width: 20%;">Alasan Pengajuan</th>
                            <th style="width: 15%;">Usulan Posisi Baru</th>
                            <th style="width: 10%;">Kategori</th>
                            <th style="width: 10%;">Act</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $nom=1 @endphp
                        @foreach($list_pengajuan as $list)
                            <tr>
                                <td>{{ $nom }}</td>
                                <td>{{ $list->get_profil->nik }} - {{ $list->get_profil->nm_lengkap }}</td>
                                <td>
                                <b>{{ $list->get_jabatan_lama->nm_jabatan }} - {{ (!empty($list->id_dept_lm)) ? $list->get_dept_lama->nm_dept : "" }}</b>
                                </td>
                                <td>{{ date("d-m-Y", strtotime($list['tgl_pengajuan'])) }}</td>
                                <td>{{ $list['alasan_pengajuan'] }}</td>
                                <td>
                                <b>{{ $list->get_jabatan_baru->nm_jabatan }} - {{ (!empty($list->id_dept_br)) ? $list->get_dept_baru->nm_dept : "" }}</b>
                                </td>
                                <td>@foreach($list_kategori as $key => $value)
                                        @if($key==$list->kategori)
                                            {{ $value }}
                                            @php break; @endphp
                                        @endif
                                        @endforeach</td>
                                <td style="text-align: center;">
                                @if($list->status_pengajuan==1)
                                    <span class="badge badge-pill badge-danger">Menunggu Persetujuan : {{ $list->get_current_approve->nm_lengkap }}</span>
                                    <span class="badge badge-pill badge-danger">{{ $list->get_current_approve->get_jabatan->nm_jabatan }}</span>
                                @elseif($list->status_pengajuan==2)
                                    <span class="badge badge-success">Disetujui</span>
                                @else
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                                </td>
                                <td>
                                    @if($list->is_draft==1)
                                    <button type="button" class="btn btn-primary tbl-edit" data-toggle="modal" data-target="#modalFormPengajuan" id="{{ $list->id }}" name="btn-edit[]" data-placement="top" title="Edit Pengajuan"><i class="las la-edit"></i></button>
                                    @endif
                                    <button type="button" class="btn btn-danger tbl-detail" data-toggle="modal" data-target="#modalFormPengajuan" id="{{ $list->id }}" name="btn-detail[]" data-placement="top" title="Detail"><i class="las la-eye"></i></button>
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
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 3000);

        $(".tbl-edit").on("click", function(){
            var id_data = this.id;
            $("#v_inputan").load("{{ url('hrd/mutasi/formpengajuanEdit') }}/" + id_data);
        });
        $(".tbl-detail").on("click", function(){
            var id_data = this.id;
            $("#v_inputan").load("{{ url('hrd/mutasi/formpengajuanDetail') }}/" + id_data);
        })

    });
    var goForm = function(el)
    {
        var id_data = $(el).val();
        $("#v_inputan").load("{{ url('hrd/mutasi/formpengajuan') }}");
    }
</script>
@endsection
