@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item" aria-current="page">Recruitment</li>
        <li class="breadcrumb-item"><a href="{{ route('persetujaunRecruitment') }}">Daftar Aplikasi Pelamar</a></li>
        <li class="breadcrumb-item active">Persetujuan Aplikasi Pelamar | Atasan Tidak Langsung</li>
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
</div>
<div class="row">
    <div class="col-sm-12 col-lg-6">
       <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Aplikasi Pelamar</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <p>Berikut adalah data profil pelamar</p>
                <div class="iq-accordion career-style faq-style">
                    <div class="iq-card iq-accordion-block accordion-active">
                        <div class="active-faq clearfix">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12"><a class="accordion-title"><span> <i class="fa fa-user"></i> Data Diri</span> </a></div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-details">
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
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="iq-card iq-accordion-block ">
                        <div class="active-faq clearfix">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12"><a class="accordion-title"><span><i class="fa fa-users"></i> Data Keluarga </h4><p>Latar Belakang Keluarga (Ayah, Ibu & Saudara)</p></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-details">
                            <div class="iq-card-body" style="width:100%; height:auto">
                                <div class="row col-lg-12 table-responsive">
                                    <table class="table" style="font-size: 12px">
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
                                        @foreach($lb_keluarga as $lbk)
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
                    @if($profil->status_nikah==2)
                    <div class="iq-card iq-accordion-block ">
                        <div class="active-faq clearfix">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12"><a class="accordion-title"><span><i class="fa fa-users"></i> Data Keluarga </h4><p>(Suami/Istri & Anak)</p></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-details">
                            <div class="iq-card-body" style="width:100%; height:auto">
                                <div class="row col-lg-12 table-responsive">
                                    <table class="table" style="font-size: 12px">
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
                        </div>
                    </div>
                    @endif
                    <div class="iq-card iq-accordion-block ">
                        <div class="active-faq clearfix">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12"><a class="accordion-title"><span><i class="fa fa-graduation-cap"></i> Riwayat Pendidikan</h4></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-details">
                            <div class="iq-card-body" style="width:100%; height:auto">
                                <div class="row col-lg-12 table-responsive">
                                    <table class="table" style="font-size: 12px">
                                        <thead>
                                            <th>No.</th>
                                            <th>Jenjang Pendidikan</th>
                                            <th>Nama Sekolah/Perguruan Tinggi</th>
                                            <th>Alamat</th>
                                            <th>Tahun Pendidikan</th>
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
                                    <div class="col-sm-12"><a class="accordion-title"><span><i class="fa fa-id-card" aria-hidden="true"></i> Pengalaman Organisasi</h4></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-details">
                            <div class="iq-card-body" style="width:100%; height:auto">
                                <div class="row col-lg-12 table-responsive">
                                    <table class="table" style="font-size: 12px">
                                        <thead>
                                            <th>No.</th>
                                            <th>Nama Organisasi</th>
                                            <th>Posisi/Jabatan</th>
                                            <th>Periode Tahun</th>
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
                                    <div class="col-sm-12"><a class="accordion-title"><span><i class="fa fa-building" aria-hidden="true"></i> Pengalaman Kerja</h4></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-details">
                            <div class="iq-card-body" style="width:100%; height:auto">
                                <div class="row col-lg-12 table-responsive">
                                    <table class="table" style="font-size: 12px">
                                        <thead>
                                            <th>No.</th>
                                            <th>Nama Perusahaan</th>
                                            <th>Posisi/Jabatan</th>
                                            <th>Alamat</th>
                                            <th>Periode Tahun</th>
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
                                    <div class="col-sm-12"><a class="accordion-title"><span><i class="fa fa-paperclip" aria-hidden="true"></i> Dokumen</h4></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-details">
                            <div class="iq-card-body" style="width:100%; height:auto">
                                <div class="row col-lg-12 table-responsive">
                                    <div class="ckeckout-product-lists">
                                        <table class="table" style="width: 100%">
                                            @foreach($jenis_dokumen as $dok)
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
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-6">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Persetujuan Atasan Langsung</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <table class="table">
                    <tr>
                        <td colspan="2" class="btn-primary">Persetujuan Atasan Langsung</td>
                    </tr>
                    @foreach($persetujuan_al as $ls_al)
                    <tr>
                        <td style="width: 20%;">Tanggal</td>
                        <td>: {{ date_format(date_create($ls_al->tanggal_persetujuan), 'd-m-Y') }}</td>
                    </tr>
                    <tr>
                        <td>Pejabat</td>
                        <td>: {{ $ls_al->user_by->nm_lengkap }}</td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td>: {{ $ls_al->user_by->get_jabatan->nm_jabatan }}</td>
                    </tr>
                    <tr>
                        <td>Catatan</td>
                        <td>: {{ $ls_al->keterangan }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td>Departemen Yang Dilamar</td>
                        <td>: <b>{{ $profil->get_departmen->nm_dept }}</b></td>
                    </tr>
                    <tr>
                        <td>Jabatan/Posisi Yang Dilamar</td>
                        <td>: <b>{{ $profil->get_jabatan->nm_jabatan }}</b></td>
                    </tr>
                </table>
            </div>
        </div>
        <form action="{{ route('formPersetujaunRecruitmentSimpanAtl') }}" method="post" onsubmit="return konfirm()" enctype="multipart/form-data">
        {{ csrf_field() }}
            <input type="hidden" name="id_pelamar" value="{{ $profil->id }}">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Form Persetujuan</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <div class="form-group row">
                    <label class="col-sm-3">Status Persetujuan :</label>
                    <div class="col-sm-2">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="check_status_appr_1" name="check_status_appr" class="custom-control-input" value="1" checked>
                            <label class="custom-control-label" for="check_status_appr_1"> Setuju</label>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="check_status_appr_2" name="check_status_appr" class="custom-control-input" value="2">
                            <label class="custom-control-label" for="check_status_appr_2"> Tidak Setuju</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="req_catatan_appr" class="col-sm-3">Catatan Persetujuan :</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="req_catatan_appr" id="req_catatan_appr" required></textarea>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <button type="submit" id="tbl_simpan" class="btn btn-primary"><i class="fa fa-save"></i> Submit</button>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".angka").number(true, 0);
        hitungRating();
        //hitungTotalDriverAll();
    });
    var hitungRating = function()
    {
        var total = 0;
        var pilihan = 0;
        for(let i = 1; i <= 15; i++)
        {
            pilihan = $('input[name="kriteria_'+i+'"]:checked').val();
            total += parseFloat(pilihan);
        }
        $("#inp_total_rating").val(total);

    }
    var cekNull = function(el)
    {
        if($(el).val()=="") {
            $(el).val("0");
        }
    }
    var driver_total_1 = function(el)
    {
        var total = 0;
        var nilai = 0;
        for(let i = 1; i <= 2; i++)
        {
            nilai = $('input[name="drive_nilai_'+i+'"]').val() ? $('input[name="drive_nilai_'+i+'"]').val() : 0;
            total += parseFloat(nilai);
        }
        $("#drive_total_1").val(total);
        hitungTotalDriverAll();
    }
    var driver_total_2 = function(el)
    {
        var total = 0;
        var nilai = 0;
        for(let i = 3; i <= 7; i++)
        {
            nilai = $('input[name="drive_nilai_'+i+'"]').val() ? $('input[name="drive_nilai_'+i+'"]').val() : 0;
            total += parseFloat(nilai);
        }
        $("#drive_total_2").val(total);
        hitungTotalDriverAll();
    }
    var driver_total_3 = function(el)
    {
        var total = 0;
        var nilai = 0;
        for(let i = 8; i <= 17; i++)
        {
            nilai = $('input[name="drive_nilai_'+i+'"]').val() ? $('input[name="drive_nilai_'+i+'"]').val() : 0;
            total += parseFloat(nilai);
        }
        $("#drive_total_3").val(total);
        hitungTotalDriverAll();
    }
    var driver_total_4 = function(el)
    {
        var total = 0;
        var nilai = 0;
        for(let i = 18; i <= 19; i++)
        {
            nilai = $('input[name="drive_nilai_'+i+'"]').val() ? $('input[name="drive_nilai_'+i+'"]').val() : 0;
            total += parseFloat(nilai);
        }
        $("#drive_total_4").val(total);
        hitungTotalDriverAll();
    }
    var hitungTotalDriverAll = function()
    {
        var total = parseFloat($("#drive_total_1").val()) + parseFloat($("#drive_total_2").val()) + parseFloat($("#drive_total_3").val()) + parseFloat($("#drive_total_4").val());
        $("#drive_total_akhir").val(total);

    }
    function konfirm()
    {
        var psn = confirm("Yakin akan menyimpan data ?");
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
</script>
@endsection
