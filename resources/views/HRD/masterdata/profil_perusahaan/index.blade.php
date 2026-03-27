@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active" aria-current="page">Profil Perusahaan</li>
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
                    <h4 class="card-title">Input Profil Perusahaan</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <form action="{{ url('hrd/masterdata/profilperusahaan/simpan') }}" method="post" enctype="multipart/form-data" onsubmit="return konfirm()">
                    {{ csrf_field() }}
                    <input type="hidden" name="id_perusahaan" value="{{ (!empty($profil->id)) ? $profil->id : '' }}">
                    <div class=" row align-items-center">
                        <div class="form-group col-sm-6">
                            <label for="inp_nama">Nama Perusahaan :</label>
                            <input type="text" class="form-control" id="inp_nama" name="inp_nama" maxlength="200" required value="{{ (!empty($profil->nm_perusahaan)) ? $profil->nm_perusahaan : '' }}">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="inp_nm_pimpinan">Nama Pimpinan :</label>
                            <input type="text" class="form-control" id="inp_nm_pimpinan" name="inp_nm_pimpinan" maxlength="100" required value="{{ (!empty($profil->nm_pimpinan)) ? $profil->nm_pimpinan : '' }}">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="inp_alamat">Alamat :</label>
                            <input type="text" class="form-control" id="inp_alamat" name="inp_alamat" maxlength="200" required value="{{ (!empty($profil->alamat)) ? $profil->alamat : '' }}">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="inp_kelurahan">Kelurahan :</label>
                            <input type="text" class="form-control" id="inp_kelurahan" name="inp_kelurahan" maxlength="100" value="{{ (!empty($profil->kelurahan)) ? $profil->kelurahan : '' }}">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="inp_kecamatan">Kecamatan :</label>
                            <input type="text" class="form-control" id="inp_kecamatan" name="inp_kecamatan" maxlength="100" value="{{ (!empty($profil->kecamatan)) ? $profil->kecamatan : '' }}">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="inp_kabupaten">Kabupaten :</label>
                            <input type="text" class="form-control" id="inp_kabupaten" name="inp_kabupaten" maxlength="100" value="{{ (!empty($profil->kabupaten)) ? $profil->kabupaten : '' }}">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="inp_provinsi">Provinsi :</label>
                            <input type="text" class="form-control" id="inp_provinsi" name="inp_provinsi" maxlength="100" value="{{ (!empty($profil->provinsi)) ? $profil->provinsi : '' }}">
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="inp_notelp">No.Telepon :</label>
                            <input type="text" class="form-control" id="inp_notelp" name="inp_notelp" maxlength="50" required value="{{ (!empty($profil->no_telpon)) ? $profil->no_telpon : '' }}">
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="inp_nofax">No. Fax :</label>
                            <input type="text" class="form-control" id="inp_nofax" name="inp_nofax" maxlength="50" value="{{ (!empty($profil->no_fax)) ? $profil->no_fax : '' }}">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="inp_email">Email :</label>
                            <input type="email" class="form-control" id="inp_email" name="inp_email" maxlength="100" required value="{{ (!empty($profil->nm_emaili)) ? $profil->nm_emaili : '' }}">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="inp_file">Logo Perusahaan :</label>
                            <input type="file" class="form-control" id="inp_file" name="inp_file" {{ (!empty($profil->logo_perusahaan)) ? '' : 'required' }} onchange="readURL(this);">
                            @if(!empty($profil->logo_perusahaan))
                            <br>
                            <div style="text-align: center">
                                <img src="{{ url(Storage::url('logo_perusahaan/'.$profil->logo_perusahaan)) }}" class="img-fluid" id="img_view" title="" width="250px">
                                @else
                                <img src="" class="picture-src img-responsive" id="img_view" title="" width="250px">
                                @endif
                            </div>

                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
        $(document).ready(function()
        {
            window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
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
            $('#img_view')
                .attr('src', e.target.result);
                };

            reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
