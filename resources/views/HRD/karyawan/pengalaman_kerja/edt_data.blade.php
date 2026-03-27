@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/karyawan/daftar') }}">Daftar Karyawan</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/karyawan/profil/'.$res_kerja->get_profil->id) }}">Profil Karyawan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Pengalaman Kerja</li>
        </ul>
    </nav>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Data Pengalaman Kerja</h4>
                </div>
                <div class="user-post-data p-3">
                    <div class="d-flex flex-wrap">
                        <div class="media-support-user-img mr-3">
                            <img class="rounded-circle img-fluid" src="{{ asset('upload/photo/'.$res_kerja->get_profil->photo) }}" alt="">
                        </div>
                        <div class="media-support-info mt-2">
                            <h5 class="mb-0">{{ $res_kerja->get_profil->nm_lengkap }}</h5>
                            <p class="mb-0 text-primary">{{ $res_kerja->get_profil->nik }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="iq-card-body">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <form action="{{ url('hrd/karyawan/rubahpengalamankerja/'.$res_kerja->id) }}" method="post" onsubmit="return konfirm()" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <input type="hidden" name="id_karyawan" value="{{ $res_kerja->get_profil->id }}">
                                <div class="iq-card-header d-flex justify-content-between">
                                    <div class="iq-header-title">
                                        <h4 class="card-title">Edit Pengalaman Kerja</h4>
                                    </div>
                                </div>
                                <div class="iq-card iq-card-block iq-card-stretch">
                                    <div class="iq-card-body">
                                    <div class="row align-items-center">
                                            <div class="form-group col-sm-6">
                                                <label for="pil_jenjang">Nama Perusahaan :</label>
                                                <input type="text" class="form-control" name="inp_nama" id="inp_nama" maxlength="150" value="{{ $res_kerja->nm_perusahaan }}" required>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="inp_posisi">Posisi/Jabatan :</label>
                                                <input type="text" class="form-control" name="inp_posisi" id="inp_posisi" maxlength="150" value="{{ $res_kerja->posisi }}" required>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="form-group col-sm-8">
                                                <label for="inp_alamat">Alamat :</label>
                                                <input type="text" class="form-control" name="inp_alamat" id="inp_alamat" maxlength="200" value="{{ $res_kerja->alamat }}" required>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label for="inp_tahun_mulai">Tahun Bekerja :</label>
                                                <div class="row">
                                                    <div class="col">
                                                        <input type="text" class="form-control tahun_mask" name="inp_tahun_mulai" id="inp_tahun_mulai" placeholder="Mulai Tahun" maxlength="4" value="{{ $res_kerja->mulai_tahun }}" required>
                                                    </div>
                                                    <div class="col">
                                                        <input type="text" class="form-control tahun_mask" name="inp_tahun_akhir" id="inp_tahun_akhir" placeholder="Sampai Tahun" maxlength="4" value="{{ $res_kerja->sampai_tahun }}" required>
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