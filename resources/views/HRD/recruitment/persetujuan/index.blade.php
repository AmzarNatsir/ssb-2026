@extends('HRD.layouts.master')
@section('content')
@php
$user = auth()->user();
$id_jabatan_user = (empty($lvl_appr_user->id)) ? "" : $lvl_appr_user->id;
@endphp
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Recruitment</li>
        <li class="breadcrumb-item active" aria-current="page">Persetujuan</li>
        <li class="breadcrumb-item"><a href="#">Aplikasi Pelamar</a></li>
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
                    <h4 class="card-title">Daftar Aplikasi Pelamar</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <table id="user-list-table" class="table datatable table-hover table-striped table-bordered mt-4 table-responsive" role="grid" aria-describedby="user-list-page-info">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 5%;" rowspan="2">#</th>
                            <th scope="col" style="width: 10%;" rowspan="2">Tgl. Aplikasi</th>
                            <th scope="col" style="width: 15%;" rowspan="2">Nama Pelamar</th>
                            <th scope="col" style="width: 15%;" rowspan="2">Tempat/Tgl. Lahir</th>
                            <th scope="col" style="width: 10%;" rowspan="2">Jenis Kelamin</th>
                            <th scope="col" style="width: 15%;" rowspan="2">Alamat/No.Telepon</th>
                            <th scope="col" style="width: 15%;" rowspan="2">Pekerjaan Yg Dilamar</th>
                            <th scope="col" style="width: 5%;" colspan="3" class="text-center">Persetujuan</th>
                            <th scope="col" style="width: 5%;" rowspan="2">Act.</th>
                        </tr>
                        <tr>
                            <th class="text-center">Atasan Langsung</th>
                            <th class="text-center">Atasan Tidak Langsung</th>
                            <td class="text-center">HRD</td>
                        </tr>
                    </thead>
                    <tbody>
                    @if($all_pelamar->count() > 0)
                        @php $nom=1; @endphp
                        @foreach($all_pelamar as $dt)
                        @php
                        $sts_lvl_1 = "";
                        $user_lvl_1="";
                        $sts_lvl_2 = "";
                        $user_lvl_2="";
                        $sts_lvl_3 = "";
                        $user_lvl_3="";
                        @endphp
                        <tr>
                            <td>{{ $nom }}</td>
                            <td>{{ date_format(date_create($dt->created_at), 'd-m-Y') }}</td>
                            <td>{{ $dt->nama_lengkap }}</td>
                            <td>{{ $dt->tempat_lahir.", ".date_format(date_create($dt->tanggal_lahir), 'd-m-Y') }}</td>
                            <td>@if($dt->jenkel==1)
                            {{ "Laki-Laki" }}
                            @elseif($dt->jenkel==2)
                            {{ "Perempuan" }}
                            @else
                            {{ "Boleh Laki-Laki atau Perempuan" }}
                            @endif</td>
                            <td>{{ $dt->alamat }}<br>
                            <i class="fa fa-phone"></i> {{ $dt->no_hp }}<br>
                            <i class="fa fa-whatsapp"></i> {{ $dt->no_wa }}
                            </td>
                            <td>
                                Jabatan : {{ (empty($dt->id_jabatan)) ? "" : $dt->get_jabatan->nm_jabatan }}
                                <br>Departemen : {{ (empty($dt->id_departemen)) ? "" : $dt->get_departmen->nm_dept }}
                                {{ (empty($dt->id_sub_departemen)) ? "" : $dt->get_sub_departemen->nm_sub_dept }}
                            </td>
                            <td class="text-center">
                                @if ($user->can('persetujuan_aplikasi_pelamar_approve'))
                                    @foreach($dt->get_list_persetujuan as $lvl_1)
                                        @if($lvl_1->level==1)
                                            @php $sts_lvl_1 = $lvl_1->hasil; $user_lvl_1 = $lvl_1->user_id; @endphp
                                        @endif
                                    @endforeach
                                    @if($sts_lvl_1==0)
                                        @if($user_lvl_1==$id_jabatan_user)
                                            <a href="{{ route('formPersetujaunRecruitment', $dt->id) }}" class="btn btn-primary" title="Apply"><i class="fa fa-edit"></i></a>
                                        @else
                                            <button type="buttom" class="btn btn-warning" title="Waiting"><i class="fa fa-hourglass"></i></button>
                                        @endif
                                    @elseif($sts_lvl_1==1)
                                        <button type="buttom" class="btn btn-success" title="Direkomendasikan"><i class="fa fa-check"></i></button>
                                    @else
                                        <button type="buttom" class="btn btn-danger" title="Tidak Direkomendasikan"><i class="fa fa-times"></i></button>
                                    @endif
                                @endif
                            </td>
                            <td class="text-center">
                                @foreach($dt->get_list_persetujuan as $lvl_2)
                                    @if($lvl_2->level==2)
                                        @php $sts_lvl_2 = $lvl_2->hasil; $user_lvl_2 = $lvl_2->user_id;  @endphp
                                    @endif
                                @endforeach
                                @if (empty($dt->status))
                                    @if($user->can('persetujuan_aplikasi_pelamar_approve'))
                                        @if($sts_lvl_1==0)
                                            <button type="buttom" class="btn btn-warning" title="Waiting"><i class="fa fa-hourglass"></i></button>
                                        @elseif($sts_lvl_1==1)
                                            @if($sts_lvl_2==0)
                                                @if($user_lvl_2==$id_jabatan_user)
                                                    <a href="{{ route('formPersetujaunRecruitmentAtl', $dt->id) }}" class="btn btn-primary" title="Apply"><i class="fa fa-edit"></i></a>
                                                @else
                                                    <button type="buttom" class="btn btn-warning" title="Waiting"><i class="fa fa-hourglass"></i></button>
                                                @endif
                                            @elseif($sts_lvl_2==1)
                                                <button type="buttom" class="btn btn-success" title="Direkomendasikan"><i class="fa fa-check"></i></button>
                                            @else
                                                <button type="buttom" class="btn btn-danger" title="Tidak Direkomendasikan"><i class="fa fa-times"></i></button>
                                            @endif
                                        @else
                                            <button type="buttom" class="btn btn-danger" title="Tidak Direkomendasikan"><i class="fa fa-times"></i></button>
                                        @endif

                                    @endif
                                @else
                                    @if($sts_lvl_2==0)
                                        @if($dt->status==1 || $dt->status==3)
                                        <button type="buttom" class="btn btn-success" title="Direkomendasikan"><i class="fa fa-check"></i></button>
                                        @else
                                        <button type="buttom" class="btn btn-danger" title="Tidak Direkomendasikan"><i class="fa fa-times"></i></button>
                                        @endif
                                    @else
                                        @if($sts_lvl_2==1)
                                            <button type="buttom" class="btn btn-success" title="Direkomendasikan"><i class="fa fa-check"></i></button>
                                        @else
                                            <button type="buttom" class="btn btn-danger" title="Tidak Direkomendasikan"><i class="fa fa-times"></i></button>
                                        @endif
                                    @endif
                                @endif
                            </td>
                            <td class="text-center">
                                @if (empty($dt->status))
                                    @if($user->can('persetujuan_aplikasi_pelamar_approve'))
                                        @foreach($dt->get_list_persetujuan as $lvl_3)
                                            @if($lvl_3->level==3)
                                                @php $sts_lvl_3 = $lvl_3->hasil; $user_lvl_3 = $lvl_3->user_id;  @endphp
                                            @endif
                                        @endforeach
                                        @if($sts_lvl_2==0)
                                            <button type="buttom" class="btn btn-warning" title="Waiting"><i class="fa fa-hourglass"></i></button>
                                        @elseif($sts_lvl_2==1)
                                            @if($sts_lvl_3==0)
                                                @if($user_lvl_3==$id_jabatan_user)
                                                    <a href="{{ route('formPersetujaunRecruitmentHRD', $dt->id) }}" class="btn btn-primary" title="Form Persetujuan HRD"><i class="fa fa-edit"></i></a>
                                                @else
                                                    <button type="buttom" class="btn btn-warning"> <i class="fa fa-hourglass"></i></button>
                                                @endif
                                            @endif
                                        @else
                                            <button type="buttom" class="btn btn-danger" title="Tidak Direkomendasikan"><i class="fa fa-times"></i></button>
                                        @endif
                                    @endif
                                @else
                                    @if($dt->status==1 || $dt->status==3)
                                    <button type="buttom" class="btn btn-success" title="Direkomendasikan"><i class="fa fa-check"></i></button>
                                    @else
                                    <button type="buttom" class="btn btn-danger" title="Tidak Direkomendasikan"><i class="fa fa-times"></i></button>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if(!empty($dt->status))
                                <div class="dropdown">
                                    <span class="dropdown-toggle text-primary" id="dropdownMenuButton3" data-toggle="dropdown">
                                    <i class="ri-more-2-fill"></i>
                                    </span>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                        @if(!empty($dt->no_surat_pengantar))
                                            @if($dt->id_departemen==$user->karyawan->id_departemen)
                                                    <a class="dropdown-item" href="{{ url('hrd/recruitment/surat_pengantar_penempatan/'.$dt->id) }}" target="_new"><i class="fa fa-print mr-2"></i>Surat Pengantar Penempatan</a>
                                            @endif
                                        @endif
                                        <a class="dropdown-item" href="{{ url('hrd/recruitment/persetujuan/aplikasi_pelamar/detail/'.$dt->id) }}" target="_new"><i class="fa fa-eye mr-2"></i> Detail</a>
                                    </div>
                                </div>
                                 @endif
                            </td>
                        </tr>
                        @php $nom++; @endphp
                        @endforeach
                    @else
                        <tr>
                            <td colspan="11">Data Pengajuan Kosong !!</td>
                        </tr>
                    @endif
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
</script>
@endsection
