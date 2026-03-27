@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/karyawan/daftar') }}">Daftar Karyawan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Profil Karyawan</li>
        </ul>
    </nav>
</div>
<div class="row">
    @include('HRD.karyawan.header_profil')
    <div class="col-md-12">
        <div class="iq-card">
            <div class="iq-card-body">
                <ul class="nav nav-tabs justify-content-center" id="myTab-2" role="tablist">
                    <li class="nav-item">
                       <a class="nav-link active" id="home-tab-justify" data-toggle="tab" href="#profile-biodata" role="tab" aria-controls="home" aria-selected="true">Biodata</a>
                    </li>
                    <li class="nav-item">
                       <a class="nav-link" id="profile-tab-justify" data-toggle="tab" href="#profile-pekerjaan" role="tab" aria-controls="profile" aria-selected="false">Pekerjaan</a>
                    </li>
                    <li class="nav-item">
                       <a class="nav-link" id="contact-tab-justify" data-toggle="tab" href="#profile-keluarga" role="tab" aria-controls="contact" aria-selected="false">Keluarga</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab-justify" data-toggle="tab" href="#profile-pendidikan" role="tab" aria-controls="contact" aria-selected="false">Pendidikan</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="contact-tab-justify" data-toggle="tab" href="#profile-kerja" role="tab" aria-controls="contact" aria-selected="false">Pengalaman Kerja</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="contact-tab-justify" data-toggle="tab" href="#profile-dokumen" role="tab" aria-controls="contact" aria-selected="false">Dokumen</a>
                     </li>
                </ul>
                <div class="tab-content" id="myTabContent-3">
                    <div class="tab-pane fade show active" id="profile-biodata" role="tabpanel" aria-labelledby="home-tab-justify">
                        <div class="iq-card iq-card-block iq-card-stretch">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">Biodata</h4>
                                </div>
                                <div class="d-flex flex-wrap">
                                    <div class="iq-card-header-toolbar d-flex align-items-center">
                                        <div class="dropdown">
                                        <span class="dropdown-toggle text-primary" id="dropdownMenuButton40" data-toggle="dropdown">
                                            <a href="#" class="text-secondary">Opsi <i class="ri-more-2-line ml-3"></i></a>
                                        </span>
                                        <div class="dropdown-menu dropdown-menu-right p-0">
                                            <a class="dropdown-item" href="{{ url('hrd/karyawan/editbiodata/'.$res->id)}}"><i class="ri-pencil-line mr-2"></i>Edit</a>
                                            {{-- <a class="dropdown-item" href="#"><i class="fa fa-print mr-2"></i></i>Print</a> --}}
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="iq-card-body">
                                <div class="iq-card iq-card-block iq-card-stretch">
                                    <div class="iq-card-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mt-1">
                                                    <h6>No. Identitas/KTP :</h6>
                                                    <p>{{ $res->no_ktp }}</p>
                                                </div>
                                                <div class="mt-2">
                                                <h6>Tempat/Tanggal Lahir :</h6>
                                                    <p>{{ $res->tmp_lahir.", ".date_format(date_create($res->tgl_lahir), 'd M Y') }}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <h6>Jenis Kelamin :</h6>
                                                    <p>@if($res->jenkel==1)
                                                        {{ "Laki-Laki" }}
                                                        @elseif($res->jenkel==2)
                                                        {{ "Perempuan" }}
                                                        @else
                                                        {{ "Laki-Laki dan Perempuan" }}
                                                        @endif</p>
                                                </div>
                                                <div class="mt-2">
                                                    <h6>Golongan Darah :</h6>
                                                    <p>{{ $res->gol_darah }}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <h6>Agama :</h6>
                                                    <p>
                                                        @foreach($list_agama as $key => $agama)
                                                        @if($key==$res->agama)
                                                            {{ $agama }}
                                                            @php break; @endphp
                                                        @endif
                                                        @endforeach
                                                    </p>
                                                </div>
                                                <div class="mt-2">
                                                    <h6>Pendidikan Terakhir :</h6>
                                                    <p>
                                                        @foreach($list_jenjang as $key => $jenjang)
                                                        @if($key==$res->pendidikan_akhir)
                                                            {{ $jenjang }}
                                                            @php break; @endphp
                                                        @endif
                                                        @endforeach
                                                    </p>
                                                </div>
                                                <div class="mt-2">
                                                    <h6>Status Pernikahan :</h6>
                                                    <p>
                                                        @foreach($list_status_nikah as $key => $nikah)
                                                        @if($key==$res->status_nikah)
                                                            {{ $nikah }}
                                                            @php break; @endphp
                                                        @endif
                                                        @endforeach
                                                    </p>
                                                </div>
                                                <div class="mt-2">
                                                    <h6>Status Tanggungan :</h6>
                                                    <p>{{ (empty($res->get_status_tanggungan->status_tanggungan)) ? "" : $res->get_status_tanggungan->status_tanggungan }}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <h6>NIK Lama :</h6>
                                                    <p>
                                                        {{ $res->nik_lama }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mt-1">
                                                    <h6>Suku :</h6>
                                                    <p>{{ $res->suku }}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <h6>Alamat :</h6>
                                                    <p>{{ $res->alamat }}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <h6>No.Telepon :</h6>
                                                    <p>{{ $res->notelp }}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <h6>Email :</h6>
                                                    <p>{{ $res->nmemail }}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <h6>No. NPWP :</h6>
                                                    <p>{{ $res->no_npwp }}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <h6>No. BPJS Tenaga Kerja :</h6>
                                                    <p>{{ $res->no_bpjstk }}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <h6>No. BPJS Kesehatan :</h6>
                                                    <p>{{ $res->no_bpjsks }}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <h6>No. Rekening Bank :</h6>
                                                    <p>{{ $res->no_rekening }} / {{ $res->nm_bank }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile-pekerjaan" role="tabpanel" aria-labelledby="profile-tab-justify">
                        <div class="iq-card iq-card-block iq-card-stretch">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">Pekerjaan</h4>
                                </div>
                                <div class="d-flex flex-wrap">
                                    <div class="iq-card-header-toolbar d-flex align-items-center">
                                        <div class="dropdown">
                                        <span class="dropdown-toggle text-primary" id="dropdownMenuButton40" data-toggle="dropdown">
                                            <a href="#" class="text-secondary">Opsi <i class="ri-more-2-line ml-3"></i></a>
                                        </span>
                                        <div class="dropdown-menu dropdown-menu-right p-0">
                                            <a class="dropdown-item" href="{{ url('hrd/karyawan/editpekerjaan/'.$res->id)}}"><i class="ri-pencil-line mr-2"></i>Edit</a>
                                            {{-- <a class="dropdown-item" href="#"><i class="fa fa-print mr-2"></i></i>Print</a> --}}
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="iq-card-body">
                                <div class="iq-card iq-card-block iq-card-stretch">
                                    <div class="iq-card-body">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="mt-2">
                                                    <h6>NIK : </h6>
                                                    <p>{{ $res->nik }}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <h6>NIK Lama : </h6>
                                                    <p>{{ $res->nik_lama }}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <h6>Bergabung Tanggal :</h6>
                                                    <p>{{ date_format(date_create($res->tgl_masuk), 'd-m-Y') }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="mt-2">
                                                    <h6>Divisi : </h6>
                                                    <p>{{ (empty($res->id_divisi)) ? "" : $res->get_divisi->nm_divisi }}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <h6>Departemen :</h6>
                                                    <p>{{ (empty($res->id_departemen)) ? "" : $res->get_departemen->nm_dept }}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <h6>Sub Departemen :</h6>
                                                    <p>{{ (empty($res->id_subdepartemen)) ? "" : $res->get_subdepartemen->nm_subdept }}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <h6>Jabatan :</h6>
                                                    <p>{{ (empty($res->get_jabatan->nm_jabatan) || (empty($res->id_jabatan))) ? "Non Jabatan" : $res->get_jabatan->nm_jabatan }}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <h6>Tanggal Efektif Posisi/Jabatan :</h6>
                                                    <p>{{ (!empty($res->tmt_jabatan)) ? date_format(date_create($res->tmt_jabatan), 'd-m-Y') : "" }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mt-2">
                                                    <h6>Status Karyawan :</h6>
                                                    <p>
                                                    @php
                                                    $list_status = Config::get('constants.status_karyawan');
                                                    foreach($list_status as $key => $value)
                                                    {
                                                        if($key==$res->id_status_karyawan)
                                                        {
                                                            $ket_status = $value;
                                                            break;
                                                        }
                                                    }
                                                    @endphp
                                                    {{ $ket_status }}
                                                    </p>
                                                </div>
                                                <div class="mt-2">
                                                    <h6>Tanggal Efektif Status Mulai :</h6>
                                                    <p>{{ (!empty($res->tgl_sts_efektif_mulai)) ? date_format(date_create($res->tgl_sts_efektif_mulai), 'd-m-Y') : "" }}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <h6>Tanggal Efektif Status Akhir :</h6>
                                                    <p>{{ (!empty($res->tgl_sts_efektif_akhir)) ? date_format(date_create($res->tgl_sts_efektif_akhir), 'd-m-Y') : "" }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile-keluarga" role="tabpanel" aria-labelledby="profile-tab-justify">
                        <div class="iq-card iq-card-block iq-card-stretch">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">Data Keluarga</h4>
                                </div>
                                <div class="d-flex flex-wrap">
                                    <div class="iq-card-header-toolbar d-flex align-items-center">
                                        <div class="dropdown">
                                        <span class="dropdown-toggle text-primary" id="dropdownMenuButton40" data-toggle="dropdown">
                                            <a href="#" class="text-secondary">Opsi <i class="ri-more-2-line ml-3"></i></a>
                                        </span>
                                        <div class="dropdown-menu dropdown-menu-right p-0">
                                            <a class="dropdown-item" href="{{ url('hrd/karyawan/tambahdatalbkeluarga/'.$res->id)}}"><i class="fa fa-plus mr-2"></i> Tambah Data Latar Belakang Keluarga</a>
                                            @if($res->status_nikah==1 || $res->status_nikah==3 || $res->status_nikah==4)

                                            <a class="dropdown-item" href="{{ url('hrd/karyawan/tambahdatakeluarga/'.$res->id)}}"><i class="fa fa-plus mr-2"></i> Tambah Data Keluarga </a>
                                            @endif
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="iq-card-body">
                                <div class="iq-header-title">
                                    <h4 class="card-title">Latar Belakang Keluarga</h4>
                                </div>
                                <div class="iq-card-body">
                                    <div class="iq-card iq-card-block iq-card-stretch">
                                        <div class="row col-lg-12 table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <th>No.</th>
                                                    <th>Hubungan</th>
                                                    <th>Nama Keluarga</th>
                                                    <th>Tempat/Tanggal Lahir</th>
                                                    <th>Jenkel</th>
                                                    <th>Pendidikan Terakhir</th>
                                                    <th>Pekerjaan</th>
                                                </thead>
                                                <tbody>
                                                @php $nom=1; @endphp
                                                @foreach($list_lb_keluarga as $lbk)
                                                <tr>
                                                    <td>{{$nom}}</td>
                                                    <td>{{ $lbk->get_hubungan_keluarga($lbk->id_hubungan) }}</td>
                                                    <td>{{ $lbk->nm_keluarga }}</td>
                                                    <td>{{ $lbk->tmp_lahir.", ".date_format(date_create($lbk->tgl_lahir), 'd-m-Y') }}</td>
                                                    <td>{{ ($lbk->jenkel==1)? "Laki-Laki" : "Perempuan" }}</td>
                                                    <td>{{ $lbk->get_pendidikan_akhir($lbk->id_jenjang) }}</td>
                                                    <td>{{ $lbk->pekerjaan }}</td>
                                                </tr>
                                                @php $nom++; @endphp
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($res->status_nikah==1 || $res->status_nikah==3 || $res->status_nikah==4)
                            <div class="iq-card-body">
                                <div class="iq-header-title">
                                    <h4 class="card-title">Data Keluarga (Suami/Istri & Anak)</h4>
                                </div>
                                <div class="iq-card-body">
                                    <div class="iq-card iq-card-block iq-card-stretch">
                                        <div class="row col-lg-12 table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <th>No.</th>
                                                    <th>Hubungan</th>
                                                    <th>Nama Keluarga</th>
                                                    <th>Tempat/Tanggal Lahir</th>
                                                    <th>Jenkel</th>
                                                    <th>Pendidikan Terakhir</th>
                                                    <th>Pekerjaan</th>
                                                </thead>
                                                <tbody>
                                                    @php $nom=1; @endphp
                                                    @foreach($list_keluarga as $lbk)
                                                    <tr>
                                                        <td>{{$nom}}</td>
                                                        <td>{{ $lbk->get_hubungan_keluarga($lbk->id_hubungan) }}</td>
                                                        <td>{{ $lbk->nm_keluarga }}</td>
                                                        <td>{{ $lbk->tmp_lahir.", ".date_format(date_create($lbk->tgl_lahir), 'd-m-Y') }}</td>
                                                        <td>{{ ($lbk->jenkel==1)? "Laki-Laki" : "Perempuan" }}</td>
                                                        <td>{{ $lbk->get_pendidikan_akhir($lbk->id_jenjang) }}</td>
                                                        <td>{{ $lbk->pekerjaan }}</td>
                                                    </tr>
                                                    @php $nom++; @endphp
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile-pendidikan" role="tabpanel" aria-labelledby="profile-tab-justify">
                        <div class="iq-card iq-card-block iq-card-stretch">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">Data Riwayat Pendidikan</h4>
                                </div>
                                <div class="d-flex flex-wrap">
                                    <div class="iq-card-header-toolbar d-flex align-items-center">
                                        <div class="dropdown">
                                        <span class="dropdown-toggle text-primary" id="dropdownMenuButton40" data-toggle="dropdown">
                                            <a href="#" class="text-secondary">Opsi <i class="ri-more-2-line ml-3"></i></a>
                                        </span>
                                        <div class="dropdown-menu dropdown-menu-right p-0">
                                            <a class="dropdown-item" href="{{ url('hrd/karyawan/tambahrwytpendidikan/'.$res->id)}}"><i class="fa fa-plus mr-2"></i> Tambah Data Riwayat Pendidikan</a>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="iq-card-body">
                                <div class="iq-card iq-card-block iq-card-stretch">
                                    <div class="row col-lg-12 table-responsive">
                                        <table class="table">
                                            <thead>
                                                <th>No.</th>
                                                <th>Jenjang Pendidikan</th>
                                                <th>Nama Sekolah/Perguruan Tinggi</th>
                                                <th>Alamat</th>
                                                <th>Tahun Pendidikan</th>
                                            </thead>
                                            <tbody>
                                            @php $nom=1; @endphp
                                            @foreach($list_rwyt_pendidikan as $pendidikan)
                                            <tr>
                                                <td>{{$nom}}</td>
                                                <td>{{ $pendidikan->get_jenjang_pendidikan($lbk->id_jenjang) }}</td>
                                                <td>{{ $pendidikan->nm_sekolaj_pt }}</td>
                                                <td>{{ $pendidikan->alamat }}</td>
                                                <td>{{ $pendidikan->mulai_tahun." s/d".$pendidikan->sampai_tahun }}</td>
                                            </tr>
                                            @php $nom++; @endphp
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile-kerja" role="tabpanel" aria-labelledby="profile-tab-justify">
                        <div class="iq-card iq-card-block iq-card-stretch">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">Data Pengalaman Kerja</h4>
                                </div>
                                <div class="d-flex flex-wrap">
                                    <div class="iq-card-header-toolbar d-flex align-items-center">
                                        <div class="dropdown">
                                        <span class="dropdown-toggle text-primary" id="dropdownMenuButton40" data-toggle="dropdown">
                                            <a href="#" class="text-secondary">Opsi <i class="ri-more-2-line ml-3"></i></a>
                                        </span>
                                        <div class="dropdown-menu dropdown-menu-right p-0">
                                            <a class="dropdown-item" href="{{ url('hrd/karyawan/tambahpengalamankerja/'.$res->id)}}"><i class="fa fa-plus mr-2"></i> Tambah Data Pengalaman Kerja</a>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="iq-card-body">
                                <div class="iq-card iq-card-block iq-card-stretch">
                                    <div class="row col-lg-12 table-responsive">
                                        <table class="table">
                                            <thead>
                                                <th>No.</th>
                                                <th>Nama Perusahaan</th>
                                                <th>Posisi/Jabatan</th>
                                                <th>Alamat</th>
                                                <th>Tahun Bekerja</th>
                                            </thead>
                                            <tbody>
                                            @php $nom=1; @endphp
                                            @foreach($list_pengalaman_kerja as $kerja)
                                            <tr>
                                                <td>{{$nom}}</td>
                                                <td>{{ $kerja->nm_perusahaan }}</td>
                                                <td>{{ $kerja->posisi }}</td>
                                                <td>{{ $kerja->alamat }}</td>
                                                <td>{{ $kerja->mulai_tahun." s/d".$kerja->sampai_tahun }}</td>
                                            </tr>
                                            @php $nom++; @endphp
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile-dokumen" role="tabpanel" aria-labelledby="profile-tab-justify">
                        <div class="iq-card iq-card-block iq-card-stretch">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">Daftar Dokumen</h4>
                                </div>
                                <div class="d-flex flex-wrap">
                                    <div class="iq-card-header-toolbar d-flex align-items-center">
                                        <div class="dropdown">
                                        <span class="dropdown-toggle text-primary" id="dropdownMenuButton40" data-toggle="dropdown">
                                            <a href="#" class="text-secondary">Opsi <i class="ri-more-2-line ml-3"></i></a>
                                        </span>
                                        <div class="dropdown-menu dropdown-menu-right p-0">
                                            <a class="dropdown-item" href="{{ url('hrd/karyawan/tambahdokumen/'.$res->id)}}"><i class="fa fa-plus mr-2"></i> Tambah Dokumen</a>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="iq-card-body">
                                <div class="iq-card iq-card-block iq-card-stretch">
                                    <div class="row col-lg-12 table-responsive">
                                        <div id="js-product-list">
                                            <div class="Products">
                                                <ul class="product_list gridcount grid row">
                                                    @foreach($list_dokumen as $dok)
                                                    <li class="product_item col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                        <div class="product-miniature">
                                                            <div class="thumbnail-container">
                                                                <a href="{{ url(Storage::url('hrd/dokumen/'.$res->nik.'/'.$dok->file_dokumen)) }}" data-fancybox data-caption='{{ $nom.". ".$dok->get_jenis_dokumen->nm_dokumen}}'>
                                                                <img src="{{ url(Storage::url('hrd/dokumen/'.$res->nik.'/'.$dok->file_dokumen)) }}"  class="card-img-top" alt="No Image Found"></a>
                                                            </div>
                                                            <div class="product-description">
                                                                <h5>{{ $dok->get_jenis_dokumen->nm_dokumen }}</h5>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    @endforeach
                                                </ul>
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
</div>

<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    });
</script>
@endsection

