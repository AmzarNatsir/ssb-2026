@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/karyawan/daftar') }}">Daftar Karyawan</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/karyawan/profil/'.$res->id) }}">Profil Karyawan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Biodata Karyawan</li>
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
                    <h4 class="card-title">Edit Biodata</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <form action="{{ url('hrd/karyawan/rubahbiodata/'.$res->id) }}" method="post" onsubmit="return konfirm()" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="iq-card iq-card-block iq-card-stretch">
                                <div class="iq-card-body">
                                    <div class="row align-items-center">
                                        <div class="form-group col-md-12">
                                            <div class="profile-img-edit">
                                            @if(empty($res->photo))
                                                <img class="profile-pic" src="{{ asset('assets/images/user/no_photo.png') }}" alt="profile-pic">
                                            @else
                                                <img class="profile-pic" src="{{ url(Storage::url('hrd/photo/'.$res->photo)) }}" alt="profile-pic">
                                            @endif
                                                <input class="form-control" type="file" name="file_photo" id="file_photo" accept="image/*" onchange="readURL(this);" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="form-group col-md-4">
                                            <label class="d-block">NIK : </label>
                                            <input type="text" class="form-control" id="inp_nik" name="inp_nik" maxlength="20" value="{{ $res->nik }}" readonly>
                                        </div>
                                        <div class="form-group col-sm-8">
                                            <label for="inp_nama">Nama Lengkap :</label>
                                            <input type="text" class="form-control" id="inp_nama" name="inp_nama" maxlength="150" value="{{ $res->nm_lengkap }}" required>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="form-group col-sm-6">
                                            <label for="inp_tempat_lahir">Tempat Lahir :</label>
                                            <input type="text" class="form-control" id="inp_tempat_lahir" name="inp_tempat_lahir" maxlength="150" value="{{ $res->tmp_lahir }}" required>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="inp_tgl_lahir">Tanggal Lahir :</label>
                                            <input type="date" class="form-control" id="inp_tgl_lahir" name="inp_tgl_lahir" value="{{ $res->tgl_lahir }}" required>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label class="d-block">Jenis Kelamin :</label>
                                            <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="rdo_jenkel_1" name="rdo_jenkel" class="custom-control-input" value="1" {{ ($res->jenkel==1)? "checked" : "" }}>
                                            <label class="custom-control-label" for="rdo_jenkel_1"> Laki-Laki </label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="rdo_jenkel_2" name="rdo_jenkel" class="custom-control-input" value="2" {{ ($res->jenkel==2)? "checked" : "" }}>
                                            <label class="custom-control-label" for="rdo_jenkel_2"> Perempuan </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="form-group col-sm-4">
                                            <label for="pil_agama">Agama :</label>
                                            <select class="form-control" id="pil_agama" name="pil_agama" required>
                                                @foreach($list_agama as $key => $agama)
                                                @if($key==$res->agama)
                                                <option value="{{ $key }}" selected>{{ $agama }}</option>
                                                @else
                                                <option value="{{ $key }}">{{ $agama }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="pil_jenjang">Pendidikan Terakhir :</label>
                                            <select class="form-control" id="pil_jenjang" name="pil_jenjang" required>
                                                @foreach($list_jenjang as $key => $jenjang)
                                                @if($key==$res->pendidikan_akhir)
                                                <option value="{{ $key }}" selected>{{ $jenjang }}</option>
                                                @else
                                                <option value="{{ $key }}">{{ $jenjang }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="pil_status_nikah">Status Pernikahan :</label>
                                            <select class="form-control" id="pil_status_nikah" name="pil_status_nikah" required>
                                                @foreach($list_status_nikah as $key => $nikah)
                                                @if($key==$res->status_nikah)
                                                <option value="{{ $key }}" selected>{{ $nikah }}</option>
                                                @else
                                                <option value="{{ $key }}">{{ $nikah }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">

                                        <div class="form-group col-sm-4">
                                            <label for="pil_status_tanggungan">Status Tanggungan :</label>
                                            <select class="form-control" id="pil_status_tanggungan" name="pil_status_tanggungan" required>
                                                @foreach($list_status_tanggungan as $tanggungan)
                                                @if($tanggungan['id']==$res->id_status_tanggungan)
                                                <option value="{{ $tanggungan['id'] }}" selected>{{ $tanggungan['kode'] }} | {{ $tanggungan['status_tanggungan'] }}</option>
                                                @else
                                                <option value="{{ $tanggungan['id'] }}">{{ $tanggungan['kode'] }} | {{ $tanggungan['status_tanggungan'] }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="inp_nomor_ktp">Nomor KTP :</label>
                                            <input type="text" class="form-control" id="inp_nomor_ktp" name="inp_nomor_ktp" maxlength="50" value="{{ $res->no_ktp }}" required>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="inp_alamat">Alamat :</label>
                                            <input type="text" class="form-control" id="inp_alamat" name="inp_alamat" maxlength="150" value="{{ $res->alamat }}" required>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="form-group col-sm-4">
                                            <label for="inp_suku">Suku :</label>
                                            <input type="text" class="form-control" id="inp_suku" name="inp_suku" maxlength="100" value="{{ $res->suku }}">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="inp_notelepon">No. Telepon :</label>
                                            <input type="text" class="form-control" id="inp_notelepon" name="inp_notelepon" maxlength="50" value="{{ $res->notelp }}" required>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="inp_email">Email :</label>
                                            <input type="email" class="form-control" id="inp_email" name="inp_email" maxlength="100" value="{{ $res->nmemail }}">
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="form-group col-sm-3">
                                            <label for="inp_nomor_npwp">Nomor NPWP :</label>
                                            <input type="text" class="form-control" id="inp_nomor_npwp" name="inp_nomor_npwp" maxlength="50" value="{{ $res->no_npwp }}">
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="inp_nomor_bpjstk">Nomor BPJSTK :</label>
                                            <input type="text" class="form-control" id="inp_nomor_bpjstk" name="inp_nomor_bpjstk" maxlength="50" value="{{ $res->no_bpjstk }}">
                                            <span>* BPJS Tenaga Kerja</span>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="inp_nomor_bpjsks">Nomor BPJSKS :</label>
                                            <input type="text" class="form-control" id="inp_nomor_bpjsks" name="inp_nomor_bpjsks" maxlength="50" value="{{ $res->no_bpjsks }}">
                                            <span>* BPJS Kesehatan</span>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="inp_id_finger">NIK Lama :</label>
                                            <input type="text" class="form-control" id="inp_id_finger" name="inp_id_finger" value="{{ $res->nik_lama }}" maxlength="10">
                                        </div>
                                    </div>
                                    <hr>
                                    <button type="submit" id="tbl_simpan" class="btn btn-primary"><i class="fa fa-save"></i> Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $(".angka").number(true, 0);
    });
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
    function readURL(input)
    {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
        $('.profile-pic')
            .attr('src', e.target.result);
            };

        reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
