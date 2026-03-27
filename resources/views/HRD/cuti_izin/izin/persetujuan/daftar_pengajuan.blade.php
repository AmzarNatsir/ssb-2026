@extends('HRD.layouts.master')
@section('content')
@php
$user = auth()->user();
$id_jabatan_setup_hrd = (empty($arr_appr_setup->id_dept_manager_hrd)) ? "" : $arr_appr_setup->id_dept_manager_hrd;
$id_jabatan_user_hrd = (empty($lvl_appr_user->id_jabatan)) ? "" : $lvl_appr_user->id_jabatan;
$id_user = (empty($lvl_appr_user->id)) ? "" : $lvl_appr_user->id;
@endphp
<script src='https://kit.fontawesome.com/a076d05399.js'></script>
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Pengajuan Izin</li>
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
    </div>
    <div class="col-sm-12 col-lg-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Daftar Pengajuan Izin</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
            <table class="table table-hover table-bordered mt-4" role="grid" aria-describedby="user-list-page-info" style="width:100%; font-size: 12px;">
                    <thead>
                        <tr>
                            <th scope="col" rowspan="2">#</th>
                            <th scope="col" rowspan="2"></th>
                            <th scope="col" rowspan="2" style="width: 20%;">Karyawan</th>
                            <th scope="col" colspan="4" style="text-align: center;">Pengajuan Cuti</th>
                            <th scope="col" colspan="2" style="text-align:center">Aksi</th>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis Cuti</th>
                            <th>Durasi</th>
                            <th>Keterangan</th>
                            <th style="width: 5%; text-align:center">Atasan Langsung</th>
                            <th style="width: 5%; text-align:center">HRD</th>
                        </tr>
                    </thead>
                    <tbody id="result_daftar">
                        @php
                        $no_urut=1;
                        @endphp
                        @foreach($list_pengajuan as $list)
                        @if(!empty( $list->profil_karyawan->get_jabatan->id_gakom))
                        <tr>
                            <td>{{ $no_urut }}</td>
                            <td class="text-left">
                            @if(!empty($list->profil_karyawan->photo))
                            <a href="{{ url(Storage::url('hrd/photo/'.$list->profil_karyawan->photo)) }}" data-fancybox data-caption='{{ $list->nm_lengkap }}'><img class="rounded-circle img-fluid avatar-40" src="{{ url(Storage::url('hrd/photo/'.$list->profil_karyawan->photo)) }}" alt="profile"></a>
                            @else
                            <a href="{{ asset('upload/photo/'.$list->profil_karyawan->photo) }}" data-fancybox data-caption='{{ $list->nm_lengkap }}'><img class="rounded-circle img-fluid avatar-40" src="{{ asset('upload/photo/'.$list->profil_karyawan->photo) }}" alt="profile"></a>
                            @endif
                            </td>
                            <td>{{ $list->profil_karyawan->nik." | ".$list->profil_karyawan->nm_lengkap }}<br>
                            {{ (empty($list->profil_karyawan->id_departemen)) ? ""  : " | ".$list->profil_karyawan->get_departemen->nm_dept }}
                            {{ (empty($list->profil_karyawan->id_jabatan)) ? "" : " | ".$list->profil_karyawan->get_jabatan->nm_jabatan }}
                            </td>
                            <td>{{ date_format(date_create($list->tgl_pengajuan), 'd-m-Y') }}</td>
                            <td>{{ $list->get_jenis_izin->nm_jenis_ci }}</td>
                            <td>{{ date_format(date_create($list->tgl_awal), 'd-m-Y') }} s/d {{ date_format(date_create($list->tgl_akhir), 'd-m-Y') }} ({{ $list->jumlah_hari }} hari)</td>
                            <td>{{ $list->ket_izin }}</td>
                            <td>
                            @if ($user->can('persetujuan_izin_approve'))
                                @if(empty($list->sts_appr_atasan))
                                    @if($list->id_atasan==$id_user)
                                        <button type="button" class="btn btn-primary" title="Klik untuk proses persetujuan" onClick="prosesPersetujuan(this)" value="{{ $list->id }}"><i class="fa fa-edit"></i></button>
                                    @else
                                        <button type="button" class="btn btn-warning"><i class="fa fa-hourglass-half"></i></button>
                                    @endif
                                @else
                                    @if($list->sts_appr_atasan==1)
                                    <button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="<?= $list->ket_appr_atasan ?>"><i class="fa fa-check-circle"></i></button>
                                    @else
                                    <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="<?= $list->ket_appr_atasan ?>"><i class="fa fa-close"></i></button>
                                    @endif
                                @endif
                            @endif

                            </td>
                            <td style="text-align: center;">
                            @if ($user->can('persetujuan_izin_approve'))
                                @if($list->sts_appr_atasan==1)
                                    @if(empty($list->sts_persetujuan))
                                        @if($list->id_persetujuan==$id_user)
                                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Klik untuk proses persetujuan" onClick="prosesPersetujuanHrd(this)" value="{{ $list->id }}"><i class="fa fa-pencil-square-o"></i></button>
                                        @else
                                            <button type="button" class="btn btn-warning"><i class="fa fa-hourglass-half"></i></button>
                                        @endif
                                    @else
                                        @if($list->sts_persetujuan==1)
                                            <button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="<?= $list->ket_persetujuan ?>"><i class="fa fa-check-circle"></i></button>
                                        @else
                                            <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="<?= $list->ket_persetujuan ?>"><i class="fa fa-close"></i></button>
                                        @endif
                                    @endif
                                @else
                                    <button type="button" class="btn btn-warning"><i class="fa fa-hourglass-half"></i></button>
                                @endif
                            @endif
                            </td>

                        </tr>
                        @endif
                        @php $no_urut++; @endphp
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
    var prosesPersetujuan = function(el)
    {
        var id_pengajuan = $(el).val();
        window.open("{{ url('hrd/cutiizin/formpersetujuan') }}/"+id_pengajuan);
    };
    var prosesPersetujuanHrd = function(el)
    {
        var id_pengajuan = $(el).val();
        window.open("{{ url('hrd/cutiizin/formpersetujuanizin_hrd') }}/"+id_pengajuan);
    };
</script>
@endsection
