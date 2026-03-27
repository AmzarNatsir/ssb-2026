@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/karyawan/daftar') }}">Daftar Karyawan</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/karyawan/profil/'.$res_pendidikan->get_profil->id) }}">Profil Karyawan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Riwayat Pendidikan</li>
        </ul>
    </nav>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Data Keluarga</h4>
                </div>
                <div class="user-post-data p-3">
                    <div class="d-flex flex-wrap">
                        <div class="media-support-user-img mr-3">
                            <img class="rounded-circle img-fluid" src="{{ asset('upload/photo/'.$res_pendidikan->get_profil->photo) }}" alt="">
                        </div>
                        <div class="media-support-info mt-2">
                            <h5 class="mb-0">{{ $res_pendidikan->get_profil->nm_lengkap }}</h5>
                            <p class="mb-0 text-primary">{{ $res_pendidikan->get_profil->nik }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="iq-card-body">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <form action="{{ url('hrd/karyawan/rubahrwytpendidikan/'.$res_pendidikan->id) }}" method="post" onsubmit="return konfirm()" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <input type="hidden" name="id_karyawan" value="{{ $res_pendidikan->get_profil->id }}">
                                <div class="iq-card-header d-flex justify-content-between">
                                    <div class="iq-header-title">
                                        <h4 class="card-title">Edit Riwayat Pendidikan</h4>
                                    </div>
                                </div>
                                <div class="iq-card iq-card-block iq-card-stretch">
                                    <div class="iq-card-body">
                                    <div class="row align-items-center">
                                            <div class="form-group col-sm-4">
                                                <label for="pil_jenjang">Jenjang Pendidikan :</label>
                                                <select class="form-control" id="pil_jenjang" name="pil_jenjang">
                                                    @foreach($list_jenjang as $key => $jenjang)
                                                    @if($key==$res_pendidikan->id_jenjang)
                                                    <option value="{{ $key }}" selected>{{ $jenjang }}</option>
                                                    @else
                                                    <option value="{{ $key }}">{{ $jenjang }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-8">
                                                <label for="inp_nama">Nama Sekolah/Perguruan Tinggi :</label>
                                                <input type="text" class="form-control" name="inp_nama" id="inp_nama" maxlength="150" value="{{$res_pendidikan->nm_sekolaj_pt }}" required>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="form-group col-sm-8">
                                                <label for="inp_alamat">Alamat :</label>
                                                <input type="text" class="form-control" name="inp_alamat" id="inp_alamat" maxlength="200" value="{{$res_pendidikan->alamat }}" required>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label for="inp_tahun_mulai">Tahun Pendidikan :</label>
                                                <div class="row">
                                                    <div class="col">
                                                        <input type="text" class="form-control tahun_mask" name="inp_tahun_mulai" id="inp_tahun_mulai" placeholder="Mulai Tahun" maxlength="4" value="{{$res_pendidikan->mulai_tahun }}" required>
                                                    </div>
                                                    <div class="col">
                                                        <input type="text" class="form-control tahun_mask" name="inp_tahun_akhir" id="inp_tahun_akhir" placeholder="Sampai Tahun" maxlength="4" value="{{$res_pendidikan->sampai_tahun }}" required>
                                                    </div>
                                                </div>
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
    $(document).ready(function()
    {
        $('.tahun_mask').mask('0000');
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
</script>
@endsection