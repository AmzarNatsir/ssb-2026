@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/karyawan/daftar') }}">Daftar Karyawan</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/karyawan/profil/'.$res_lb->get_profil->id) }}">Profil Karyawan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Keluarga</li>
        </ul>
    </nav>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Data Keluarga (Suami/Istri & Anak)</h4>
                </div>
                <div class="user-post-data p-3">
                    <div class="d-flex flex-wrap">
                        <div class="media-support-user-img mr-3">
                            <img class="rounded-circle img-fluid" src="{{ asset('upload/photo/'.$res_lb->get_profil->photo) }}" alt="">
                        </div>
                        <div class="media-support-info mt-2">
                            <h5 class="mb-0">{{ $res_lb->get_profil->nm_lengkap }}</h5>
                            <p class="mb-0 text-primary">{{ $res_lb->get_profil->nik }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="iq-card-body">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <form action="{{ url('hrd/karyawan/rubahkeluarga/'.$res_lb->id) }}" method="post" onsubmit="return konfirm()" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <input type="hidden" name="id_karyawan" value="{{ $res_lb->get_profil->id }}">
                                <div class="iq-card-header d-flex justify-content-between">
                                    <div class="iq-header-title">
                                        <h4 class="card-title">Edit Belakang Keluarga</h4>
                                    </div>
                                </div>
                                <div class="iq-card iq-card-block iq-card-stretch">
                                    <div class="iq-card-body">
                                        <div class="row align-items-center">
                                            <div class="form-group col-sm-6">
                                                <label for="pil_hubungan">Hubungan Keluarga :</label>
                                                <select class="form-control" id="pil_hubungan" name="pil_hubungan">
                                                    @foreach($list_keluarga as $key => $keluarga)
                                                    @if($key==$res_lb->id_hubungan)
                                                    <option value="{{ $key }}" selected>{{ $keluarga }}</option>
                                                    @else
                                                    <option value="{{ $key }}">{{ $keluarga }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="inp_nama">Nama :</label>
                                                <input type="text" class="form-control" name="inp_nama" id="inp_nama" maxlength="150" value="{{ $res_lb->nm_keluarga }}" required>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="form-group col-sm-8">
                                                <label for="inp_tmp_lahir">Tempat Lahir :</label>
                                                <input type="text" class="form-control" name="inp_tmp_lahir" id="inp_tmp_lahir" maxlength="100" value="{{ $res_lb->tmp_lahir }}" required>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label for="inp_tgl_lahir">Tanggal Lahir :</label>
                                                <input type="date" class="form-control" name="inp_tgl_lahir" id="inp_tgl_lahir" value="{{ $res_lb->tgl_lahir }}" required>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="form-group col-sm-4">
                                                <label class="d-block">Jenis Kelamin :</label>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="rdo_jenkel_1" name="rdo_jenkel" class="custom-control-input" checked="" value="1" {{ ($res_lb->jenkel==1)? "checked" : "" }}>
                                                <label class="custom-control-label" for="rdo_jenkel_1"> Laki-Laki </label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="rdo_jenkel_2" name="rdo_jenkel" class="custom-control-input" value="2" {{ ($res_lb->jenkel==2)? "checked" : "" }}>
                                                <label class="custom-control-label" for="rdo_jenkel_2"> Perempuan </label>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label for="pil_jenjang">Pendidikan Terakhir :</label>
                                                <select class="form-control" id="pil_jenjang" name="pil_jenjang">
                                                    @foreach($list_jenjang as $key => $jenjang)
                                                    @if($key==$res_lb->id_jenjang)
                                                    <option value="{{ $key }}" selected>{{ $jenjang }}</option>
                                                    @else
                                                    <option value="{{ $key }}">{{ $jenjang }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label for="inp_pekerjaan">Pekerjaan :</label>
                                                <input type="text" class="form-control" name="inp_pekerjaan" id="inp_pekerjaan" maxlength="100" value="{{ $res_lb->pekerjaan }}">
                                            </div>
                                        </div>
                                        <hr>
                                        <button type="submit" id="tbl_simpan" class="btn btn-primary"><i class="fa fa-save"></i> Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
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