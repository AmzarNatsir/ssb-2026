@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active">Surat Teguran - Surat Peringatan (SP)</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/suratperingatan/listPengajuan') }}">Refresh (F5)</a></li>
        </ul>
    </nav>
</div>
<div class="row">
    @if(\Session::has('konfirm'))
    <div class="col-sm-12 col-lg-12">
        <div class="alert text-white bg-success" role="alert" id="success-alert">
            <div class="iq-alert-icon">
                <i class="ri-alert-line"></i>
            </div>
            <div class="iq-alert-text">{{ \Session::get('konfirm') }}</div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="ri-close-line"></i>
            </button>
        </div>
    </div>
    @endif
    @include('HRD.surat_peringatan.pengajuan.summary_pengajuan_sp')
</div>
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Data Surat Teguran - Surat Peringatan (SP)</h4>
                </div>
                <div class="iq-card-header-toolbar d-flex align-items-center">
                    <div class="user-list-files d-flex float-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalFormPengajuan" onclick="goFormST(this)"><i class="fa fa-plus"> </i> Pengajuan Surat Teguran</button>&nbsp;
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalFormPengajuan" onclick="goFormSP(this)"><i class="fa fa-plus"> </i> Pengajuan Surat Peringatan</button>
                    </div>
                </div>
            </div>
            <div class="iq-card-body">
                <div id="spinner-div" class="pt-5 justify-content-center spinner-div"><div class="spinner-border text-primary" role="status"></div></div>
                <div id="view_data"></div>
            </div>
        </div>
    </div>
</div>

{{-- <div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Data Surat Teguran - Surat Peringatan (SP)</h4>
                </div>
                <div class="iq-card-header-toolbar d-flex align-items-center">
                    <div class="user-list-files d-flex float-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalFormPengajuan" onclick="goFormST(this)"><i class="fa fa-plus"> </i> Pengajuan Surat Teguran</button>&nbsp;
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalFormPengajuan" onclick="goFormSP(this)"><i class="fa fa-plus"> </i> Pengajuan Surat Peringatan</button>
                    </div>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <ul class="nav nav-tabs" id="myTab-1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="st-tab" data-toggle="tab" href="#st" role="tab" aria-controls="st" aria-selected="true">Surat Teguran</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="sp-tab" data-toggle="tab" href="#sp" role="tab" aria-controls="sp" aria-selected="false">Surat Peringatan </code></a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent-2">
                    <div class="tab-pane fade show active" id="st" role="tabpanel" aria-labelledby="st-tab">
                        <p>Daftar Pengajuan Surat Teguran</p>
                        <table class="table table-hover table-bordered list_st" role="grid" style="width:100%; font-size: 12px;">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th style="width: 10%; text-align: center;">Pengajuan</th>
                                    <th style="width: 25%; text-align: center;">Karyawan</th>
                                    <th style="width: 25%; text-align: center;">Kejadian</th>
                                    <th style="text-align:center; width:20%">Status Pengajuan</th>
                                    <th style="text-align:center; width:15%">Act</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $nom=1 @endphp
                            @foreach ($list_st as $list)
                            <tr>
                                <td>{{ $nom }}</td>
                                <td class="text-center">{{ date('d-m-Y', strtotime($list->tanggal_pengajuan)) }}</td>
                                <td>
                                    <h5 class="mb-0"><a class="text-dark" href="#">{{ $list->get_karyawan->nik }} -{{ $list->get_karyawan->nm_lengkap }}</a></h5>
                                    <p class="mb-1">{{ (!empty($list->get_karyawan->id_jabatan)) ? $list->get_karyawan->get_jabatan->nm_jabatan : "" }} / {{ (!empty($list->get_karyawan->id_departemen)) ? $list->get_karyawan->get_departemen->nm_dept : "" }}</p>
                                </td>
                                <td>
                                    <h5 class="mb-0"><a class="text-dark" href="#">{{ $list->get_jenis_pelanggaran->jenis_pelanggaran }}</a></h5>
                                    <div class="sellers-dt">
                                        <span class="font-size-12">Tempat: <a href="#"> {{ $list->tempat_kejadian }}</a></span>
                                     </div>
                                     <div class="sellers-dt">
                                        <span class="font-size-12">Waktu: <a href="#"> {{ date('d-m-Y', strtotime($list->tanggal_kejadian)) }} | {{ date('H:i', strtotime($list->waktu_kejadian)) }}</a></span>
                                     </div>

                                </td>
                                <td class="text-center">
                                    @if($list->status_pengajuan==1)
                                        <span class="badge badge-pill badge-primary">Menunggu Persetujuan : {{ $list->get_current_approve->nm_lengkap }}</span>
                                        <span class="badge badge-pill badge-primary">{{ $list->get_current_approve->get_jabatan->nm_jabatan }}</span>
                                    @elseif($list->status_pengajuan==2)
                                        <span class="badge badge-success">Disetujui</span>
                                    @else
                                        <span class="badge badge-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($list->is_draft==1)
                                    <button type="button" class="btn btn-primary tbl-edit-st" data-toggle="modal" data-target="#modalFormPengajuan" id="{{ $list->id }}" name="btn-edit[]" data-placement="top" title="Edit Pengajuan"><i class="las la-edit"></i></button>
                                    <button type="button" class="btn btn-danger tbl-cancel-st" data-toggle="modal" data-target="#modalFormPengajuan" id="{{ $list->id }}" name="btn-cancel[]" data-placement="top" title="Batal Pengajuan"><i class="las la-times"></i></button>
                                    @else
                                    <button type="button" class="btn btn-success tbl-detail-st" tbl-detail-st id="{{ $list->id }}" data-toggle="modal" data-target="#modalFormPengajuan" name="btn-detail[]" title="Detail"><i class="fa fa-eye"></i></button>
                                    @endif
                                </td>
                            </tr>
                            @php $nom++ @endphp
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="sp" role="tabpanel" aria-labelledby="sp-tab">
                        <p>Daftar Pengajuan Surat Peringatan</p>
                        <table class="table table-hover table-bordered mt-4 list_sp" role="grid" aria-describedby="user-list-page-info" style="width:100%; font-size: 12px;">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th style="width: 10%;">Pengajuan</th>
                                    <th style="width: 20%;">Karyawan</th>
                                    <th style="width: 15%; text-align:center">Tingkatan Sanksi</th>
                                    <th style="width: 20%; text-align:center">Uraian Pelanggaran</th>
                                    <th style="width: 20% text-align:center;">Status Pengajuan</th>
                                    <th style="text-align:center; width:10%">Act</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no_urut=1; @endphp
                                @foreach($list_pengajuan as $list)
                                <tr>
                                    <td>{{ $no_urut }}</td>
                                    <td class="text-center">{{ date_format(date_create($list->tgl_pengajuan), 'd-m-Y') }}</td>
                                    <td><h5 class="mb-0"><a class="text-dark" href="#">{{ $list->profil_karyawan->nik }} -{{ $list->profil_karyawan->nm_lengkap }}</a></h5>
                                        <p class="mb-1">{{ (!empty($list->profil_karyawan->id_jabatan)) ? $list->profil_karyawan->get_jabatan->nm_jabatan : "" }} / {{ (!empty($list->profil_karyawan->id_departemen)) ? $list->profil_karyawan->get_departemen->nm_dept : "" }}</p>
                                    </td>

                                    <td>{{ $list->get_master_jenis_sp_diajukan->nm_jenis_sp }}</td>
                                    <td>{{ $list->uraian_pelanggaran }}</td>
                                    <td class="text-center">
                                        @if($list->sts_pengajuan==1)
                                            <span class="badge badge-pill badge-primary">Menunggu Persetujuan : {{ $list->get_current_approve->nm_lengkap }}</span>
                                            <span class="badge badge-pill badge-primary">{{ $list->get_current_approve->get_jabatan->nm_jabatan }}</span>
                                        @elseif($list->status_pengajuan==2)
                                            <span class="badge badge-success">Disetujui</span>
                                        @else
                                            <span class="badge badge-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($list->is_draft==1)
                                        <button type="button" class="btn btn-primary tbl-edit-sp" data-toggle="modal" data-target="#modalFormPengajuan" id="{{ $list->id }}" name="btn-edit-sp[]" data-placement="top" title="Edit Pengajuan"><i class="las la-edit"></i></button>
                                        <button type="button" class="btn btn-danger tbl-cancel-sp" data-toggle="modal" data-target="#modalFormPengajuan" id="{{ $list->id }}" name="btn-cancel-sp[]" data-placement="top" title="Batal Pengajuan"><i class="las la-times"></i></button>
                                        @else
                                        <button type="button" class="btn btn-success tbl-detail-sp" tbl-detail-st id="{{ $list->id }}" data-toggle="modal" data-target="#modalFormPengajuan" name="btn-detail-sp[]" title="Detail"><i class="fa fa-eye"></i></button>
                                        @endif
                                    </td>
                                </tr>
                                @php $no_urut++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<div id="modalFormPengajuan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content" id="v_inputan" style="overflow-y: auto;"></div>
    </div>
 </div>
 <script type="text/javascript">
    $(document).ready(function()
    {
        $('#spinner-div').hide();
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    });
    var goFormST = function(el)
    {
        var id_data = $(el).val();
        $("#v_inputan").load("{{ url('hrd/suratperingatan/formPengajuanST') }}");
    }
    var goFormSP = function(el)
    {
        var id_data = $(el).val();
        $("#v_inputan").load("{{ url('hrd/suratperingatan/formPengajuan') }}");
    }
    var showData = function(el)
    {
        $('#spinner-div').show();
        var filter = $(el).val();
        $("#view_data").load("{{ url('hrd/suratperingatan/pengajuan/showData') }}/"+filter, function(){
            $('#spinner-div').hide();
        });
    }
</script>

@endsection
