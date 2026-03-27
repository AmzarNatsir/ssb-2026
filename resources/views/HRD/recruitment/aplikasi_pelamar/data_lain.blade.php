@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Recruitment</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/recruitment/aplikasi_pelamar') }}">Aplikasi Pelamar</a></li>
        <li class="breadcrumb-item">Aplikasi Pelamar Baru</li>
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
                    <h4 class="card-title">Form Aplikasi Pelamar</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title"><i class="fa fa-user-circle" aria-hidden="true"></i> Profil Pelamar</h4>
                            </div>
                            {{-- @if ($profil->is_draft==1)
                            <div class="d-flex flex-wrap">
                                <div class="iq-card-header-toolbar d-flex align-items-center">
                                    <div class="dropdown">
                                        <span class="dropdown-toggle text-primary" id="dropdownMenuButton40" data-toggle="dropdown">
                                            <a href="#" class="text-secondary">Opsi <i class="ri-more-2-line ml-3"></i></a>
                                        </span>
                                        <div class="dropdown-menu dropdown-menu-right p-0">
                                            <a class="dropdown-item" href="{{ url('hrd/karyawan/editbiodata/'.$profil->id)}}"><i class="ri-pencil-line mr-2"></i>Edit</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif --}}
                        </div>
                        <div class="iq-card-body" style="width:100%; height:auto">
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="form-group col-sm-12">
                                        <img class="avatar-140 profile-pic" id="preview_upload" src="{{ url(Storage::url('hrd/pelamar/photo/'.$profil->file_photo)) }}" alt="profile-pic">
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <table class="table" style="width: 100%;">
                                    <tr>
                                        <td><h4>{{ $profil->nama_lengkap }}</h4></td>
                                    </tr>
                                    <tr>
                                        <td><i class="ri-phone-line"></i> {{ $profil->no_hp }}</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-whatsapp"></i> {{ $profil->no_wa }}</td>
                                    </tr>
                                    <tr>
                                        <td><i class="ri-map-pin-fill"></i> {{ $profil->alamat }}</td>
                                    </tr>
                                    <tr>
                                        <td><i class="ri-mail-line"></i> {{ $profil->email }}</td>
                                    </tr>
                                    </table>
                                </div>
                                <div class="col-lg-12">
                                    <table style="width: 100%;">
                                        <tr>
                                            <td><b>Posisi/Jabatan yang dilamar : </b><p>{{ (empty($profil->id_jabatan)) ? "" : $profil->get_jabatan->nm_jabatan }}</p></td>
                                        </tr>
                                        <tr>
                                            <td><b>Sub Departemen : </b><p>{{ (empty($profil->id_sub_departemen)) ? "" : $profil->get_sub_departemen->nm_subdept }}</p></td>
                                        </tr>
                                        <tr>
                                            <td><b>Departemen : </b><p>{{ (empty($profil->id_departemen)) ? "" : $profil->get_departmen->nm_dept }}</p></td>
                                        </tr>
                                        <tr>
                                            <td><b>Divisi : </b><p>{{ (empty($profil->get_jabatan->id_divisi)) ? "" : $profil->get_jabatan->mst_divisi->nm_divisi }}</p></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title"><i class="fa fa-pencil" aria-hidden="true"></i> Hasil Tes</h4>
                            </div>
                        </div>
                        <div class="iq-card-body" style="width:100%; height:auto">
                            <table class="table" style="width: 100%">
                                <tr>
                                    <td colspan="3" style="text-align: left"><b>PSIKOTEST</b></td>
                                </tr>
                                <tr>
                                    <td style="width: 13%">Nilai</td>
                                    <td style="width: 2%">:</td>
                                    <td>{{ $profil->psikotes_nilai }}</td>
                                </tr>
                                <tr>
                                    <td>Keterangan</td>
                                    <td>:</td>
                                    <td>{{ $profil->psikotes_ket }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align: left"><b>WAWANCARA</b></td>
                                </tr>
                                <tr>
                                    <td>Nilai</td>
                                    <td>:</td>
                                    <td>{{ $profil->wawancara_nilai }}</td>
                                </tr>
                                <tr>
                                    <td>Nilai</td>
                                    <td>:</td>
                                    <td>{{ $profil->wawancara_ket }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align: left"><b>TOTAL SKOR : {{ $profil->total_skor }}</b></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title"><i class="fa fa-check-circle" aria-hidden="true"></i> Hirarki Persetujuan</h4>
                            </div>
                        </div>
                        <div class="iq-card-body" style="width:100%; height:auto">
                            <div class="row">
                                <table class="table" style="width: 100%; font-size: 12px">
                                    <thead>
                                    <tr>
                                        <th rowspan="2" style="width: 5%">Level</th>
                                        <th rowspan="2">Pejabat</th>
                                        <th colspan="3" class="text-center">Persetujuan</th>
                                    </tr>
                                    <tr>
                                        <th class="text-left">Tanggal</th>
                                        <th class="text-left">Keterangan</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($hirarki_persetujuan as $list)
                                        <tr>
                                            <td class="text-center">
                                                @if($list->approval_active==1)
                                                <h4><span class="badge badge-pill badge-success">{{ $list->approval_level }}</span></h4>
                                                @else
                                                <h4><span class="badge badge-pill badge-danger">{{ $list->approval_level }}</span></h4>
                                                @endif
                                            </td>
                                            <td>{{ $list->get_profil_employee->nm_lengkap }}<br>
                                                {{ $list->get_profil_employee->get_jabatan->nm_jabatan }}</td>
                                            <td>
                                                {{ (empty($list->approval_date)) ? "" : date('d-m-Y', strtotime($list->approval_date))  }}
                                            </td>
                                            <td>{{ $list->approval_remark }}</td>
                                            <td class="text-center">
                                                @if($list->approval_status==1)
                                                <h4><span class="badge badge-pill badge-success">Approved</span></h4>
                                                @elseif($list->approval_status==2)
                                                <h4><span class="badge badge-pill badge-danger">Rejected</span></h4>
                                                @elseif($list->approval_status==3)
                                                <h4><span class="badge badge-pill badge-danger">Pending</span></h4>
                                                @else
                                                <h4><span class="badge badge-pill badge-primary">Waiting</span></h4>
                                                @endif
                                                </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="iq-accordion career-style faq-style">
                        <div class="iq-card iq-accordion-block accordion-active">
                            <div class="active-faq clearfix">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-12"><a class="accordion-title"><span> <i class="fa fa-user"></i> Data Keluarga</span> </a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-details">
                                <div class="iq-card-body" style="width:100%; height:auto">
                                    <div class="iq-card-header d-flex justify-content-between">
                                        <div class="iq-header-title">
                                            <h5 class="card-title">Latar Belakang Keluarga (Ayah, Ibu & Saudara)</h5>
                                        </div>
                                    </div>
                                    <div class="iq-card-body">
                                        <div class="row col-lg-12 table-responsive">
                                            <div class="user-list-files d-flex float-right mb-2">
                                                @if (count($profil->get_list_persetujuan)==0)
                                                <div class="user-list-files d-flex float-right">
                                                    <a href="{{ url('hrd/recruitment/aplikasi_pelamar/frm_lb_keluarga/'.$profil->id) }}" class="btn btn-secondary mt-3"><i class="fa fa-plus"></i> Tambah Data Baru</a>
                                                </div>
                                                @endif
                                            </div>
                                            <table class="table" style="font-size: 11px">
                                                <thead>
                                                    <th>No.</th>
                                                    <th>Hubungan</th>
                                                    <th>Nama&nbsp;Keluarga</th>
                                                    <th>Tempat/Tanggal&nbsp;Lahir</th>
                                                    <th>Jenkel</th>
                                                    <th>Pendidikan&nbsp;Terakhir</th>
                                                    <th>Pekerjaan</th>
                                                </thead>
                                                <tbody>
                                                @php $nom=1; @endphp
                                                @foreach($lb_keluarga as $lbk)
                                                <tr>
                                                    <td>{{$nom}}</td>
                                                    <td>{{ $lbk->get_hubungan_keluarga($lbk->id_hubungan) }}</td>
                                                    <td>{{ $lbk->nm_keluarga }}</td>
                                                    <td>{{ $lbk->tmp_lahir.", ".date_format(date_create($lbk->tgl_lahir), 'd-m-Y') }}</td>
                                                    <td>@if($lbk->jenkel==1)
                                                    {{ "Laki-Laki" }}
                                                    @else
                                                    {{ "Perempuan" }}
                                                    @endif</td>
                                                    <td>{{ $lbk->get_pendidikan_akhir($lbk->id_jenjang) }}</td>
                                                    <td>{{ $lbk->pekerjaan }}</td>
                                                </tr>
                                                @php $nom++; @endphp
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    @if($profil->status_nikah==2)
                                    <div class="iq-card-header d-flex justify-content-between">
                                        <div class="iq-header-title">
                                            <h4 class="card-title">Data Keluarga (Suami/Istri & Anak)</h4>
                                        </div>
                                    </div>
                                    <div class="iq-card-body">
                                        <div class="row col-lg-12 table-responsive">
                                            <div class="user-list-files d-flex float-right mb-2">
                                                @if (count($profil->get_list_persetujuan)==0)
                                                <div class="user-list-files d-flex float-right">
                                                    <a href="{{ route('addKeluarga', $profil->id) }}" class="btn btn-secondary mt-3"><i class="fa fa-plus"></i> Tambah Data Baru</a>
                                                </div>
                                                @endif
                                            </div>
                                            <table class="table" style="font-size: 11px">
                                                <thead>
                                                    <th>No.</th>
                                                    <th>Hubungan</th>
                                                    <th>Nama&nbsp;Keluarga</th>
                                                    <th>Tempat/Tanggal&nbsp;Lahir</th>
                                                    <th>Jenkel</th>
                                                    <th>Pendidikan&nbsp;Terakhir</th>
                                                    <th>Pekerjaan</th>
                                                </thead>
                                                <tbody>
                                                @php $nom=1; @endphp
                                                @foreach($keluarga as $kel)
                                                <tr>
                                                    <td>{{$nom}}</td>
                                                    <td>{{ $kel->get_hubungan_keluarga($kel->id_hubungan) }}</td>
                                                    <td>{{ $kel->nm_keluarga }}</td>
                                                    <td>{{ $kel->tmp_lahir.", ".date_format(date_create($kel->tgl_lahir), 'd-m-Y') }}</td>
                                                    <td>{{ ($kel->jenkel==1)? "Laki-Laki" : "Perempuan" }}</td>
                                                    <td>{{ $kel->get_pendidikan_akhir($kel->id_jenjang) }}</td>
                                                    <td>{{ $kel->pekerjaan }}</td>
                                                </tr>
                                                @php $nom++; @endphp
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="iq-card iq-accordion-block ">
                            <div class="active-faq clearfix">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-12"><a class="accordion-title"><span><i class="fa fa-graduation-cap"></i> Riwayat Pendidikan</h4> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-details">
                                <div class="iq-card-body" style="width:100%; height:auto">
                                    <div class="row col-lg-12 table-responsive">
                                        <div class="user-list-files d-flex float-right mb-2">
                                            @if (count($profil->get_list_persetujuan)==0)
                                            <div class="user-list-files d-flex float-right">
                                                <a href="{{ route('addPendidikan', $profil->id) }}" class="btn btn-secondary mt-3"><i class="fa fa-plus"></i> Tambah Data Baru</a>
                                            </div>
                                            @endif
                                        </div>
                                        <table class="table" style="font-size: 11px">
                                            <thead>
                                                <th>No.</th>
                                                <th>Jenjang&nbspPendidikan</th>
                                                <th>Nama&nbsp;Sekolah/Perguruan&nbsp;Tinggi</th>
                                                <th>Alamat</th>
                                                <th>Tahun&nbsp;Pendidikan</th>
                                            </thead>
                                            <tbody>
                                            @php $nom=1; @endphp
                                                @foreach($pendidikan as $jenj)
                                                <tr>
                                                    <td>{{$nom}}</td>
                                                    <td>{{ $jenj->get_jenjang_pendidikan($jenj->id_jenjang) }}</td>
                                                    <td>{{ $jenj->nm_sekolah_pt }}</td>
                                                    <td>{{ $jenj->alamat }}</td>
                                                    <td>{{ $jenj->mulai_tahun." s/d".$jenj->sampai_tahun }}</td>
                                                </tr>
                                                @php $nom++; @endphp
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="iq-card iq-accordion-block ">
                            <div class="active-faq clearfix">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-12"><a class="accordion-title"><span><i class="fa fa-id-card" aria-hidden="true"></i> Pengalaman Organisasi</h4> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-details">
                                <div class="iq-card-body" style="width:100%; height:auto">
                                    <div class="row col-lg-12 table-responsive">
                                        <div class="user-list-files d-flex float-right mb-2">
                                            @if (count($profil->get_list_persetujuan)==0)
                                            <div class="user-list-files d-flex float-right">
                                                <a href="{{ route('addOrganisasi', $profil->id) }}" class="btn btn-secondary mt-3"><i class="fa fa-plus"></i> Tambah Data Baru</a>
                                            </div>
                                            @endif
                                        </div>
                                        <table class="table" style="font-size: 11px">
                                            <thead>
                                                <th>No.</th>
                                                <th>Nama&nbsp;Organisasi</th>
                                                <th>Posisi/Jabatan</th>
                                                <th>Periode&nbsp;Tahun</th>
                                            </thead>
                                            <tbody>
                                            @php $nom=1; @endphp
                                                @foreach($organisasi as $org)
                                                <tr>
                                                    <td>{{$nom}}</td>
                                                    <td>{{ $org->nama_organisasi }}</td>
                                                    <td>{{ $org->posisi }}</td>
                                                    <td>{{ $org->mulai_tahun." s/d".$org->sampai_tahun }}</td>
                                                </tr>
                                                @php $nom++; @endphp
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="iq-card iq-accordion-block ">
                            <div class="active-faq clearfix">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-12"><a class="accordion-title"><span><i class="fa fa-building" aria-hidden="true"></i> Pengalaman Kerja</h4> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-details">
                                <div class="iq-card-body" style="width:100%; height:auto">
                                    <div class="row col-lg-12 table-responsive">
                                        <div class="user-list-files d-flex float-right mb-2">
                                            @if (count($profil->get_list_persetujuan)==0)
                                            <div class="user-list-files d-flex float-right">
                                                <a href="{{ route('addPekerjaan', $profil->id) }}" class="btn btn-secondary mt-3"><i class="fa fa-plus"></i> Tambah Data Baru</a>
                                            </div>
                                            @endif
                                        </div>
                                        <table class="table" style="font-size: 11px">
                                            <thead>
                                                <th>No.</th>
                                                <th>Nama&nbsp;Perusahaan</th>
                                                <th>Posisi/Jabatan</th>
                                                <th>Alamat</th>
                                                <th>Periode&nbsp;Tahun</th>
                                            </thead>
                                            <tbody>
                                            @php $nom=1; @endphp
                                                @foreach($pekerjaan as $krj)
                                                <tr>
                                                    <td>{{$nom}}</td>
                                                    <td>{{ $krj->nm_perusahaan }}</td>
                                                    <td>{{ $krj->posisi }}</td>
                                                    <td>{{ $krj->alamat }}</td>
                                                    <td>{{ $krj->mulai_tahun." s/d".$krj->sampai_tahun }}</td>
                                                </tr>
                                                @php $nom++; @endphp
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="iq-card iq-accordion-block ">
                            <div class="active-faq clearfix">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-12"><a class="accordion-title"><span><i class="fa fa-paperclip" aria-hidden="true"></i> Dokumen</h4> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-details">
                                <div class="iq-card-body" style="width:100%; height:auto">
                                    <div class="row col-lg-12 table-responsive">
                                        <div class="user-list-files d-flex float-right mb-2">
                                            @if (count($profil->get_list_persetujuan)==0)
                                            <div class="user-list-files d-flex float-right">
                                                <a href="{{ route('listDokumen', $profil->id) }}" class="btn btn-secondary mt-3"><i class="fa fa-plus"></i> Tambah Data Baru</a>
                                            </div>
                                            @endif
                                        </div>
                                        @foreach($jenis_dokumen as $dok)
                                        <div class="iq-card">
                                            <div class="iq-card-body">
                                                <div class="ckeckout-product-lists">
                                                    <table class="table" style="width: 100%">
                                                        <tr>
                                                            <td style="width: 30%"><div class="ckeckout-product">
                                                                @foreach($list_dokumen as $dtdok => $valdok)
                                                                    @if($valdok->id_dokumen==$dok->id)
                                                                        <a href="{{ url(Storage::url($valdok->path_file.$valdok->file_dokumen)) }}" data-fancybox data-caption='{{ $dok->id.". ".$dok->nm_dokumen}}'>
                                                                        <img src="{{ url(Storage::url($valdok->path_file.$valdok->file_dokumen)) }}"  class="card-img-top" alt="{{ $dok->id.". ".$dok->nm_dokumen}}" style="heigth:100px; width:100px;"></a>
                                                                        @php
                                                                        break;
                                                                        @endphp
                                                                    @endif
                                                                    @endforeach
                                                                </div>
                                                            </td>
                                                            <td style="vertical-align: middle"><h5>{{ $dok->nm_dokumen }}</h5></td>
                                                        </tr>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    });
    function confirmHapus()
    {
        var pesan = confirm("Yakin data akan dihapus ?");
        if(pesan==true) {
            return true;
        } else {
            return false;
        }
    }
</script>
@endsection
