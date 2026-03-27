@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/karyawan/daftar') }}">Daftar Karyawan</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/karyawan/profil/'.$res->id) }}">Profil Karyawan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Data Pekerjaan Karyawan</li>
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
                    <h4 class="card-title">Edit Data Pekerjaan</h4>
                </div>
                <div class="user-post-data p-3">
                    <div class="d-flex flex-wrap">
                        <div class="media-support-user-img mr-3">
                            <img class="rounded-circle img-fluid" src="{{ asset('upload/photo/'.$res->photo) }}" alt="">
                        </div>
                        <div class="media-support-info mt-2">
                            <h5 class="mb-0">{{ $res->nm_lengkap }}</h5>
                            <p class="mb-0 text-primary">{{ $res->nik }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="iq-card-body">
                <form action="{{ url('hrd/karyawan/rubahpekerjaan/'.$res->id) }}" method="post" onsubmit="return konfirm()" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="iq-card iq-card-block iq-card-stretch">
                                <div class="iq-card-body">
                                    <div class="row align-items-center">
                                        <div class="form-group col-sm-2">
                                            <label for="inp_tgl_masuk">Tanggal Masuk :</label>
                                            <input type="date" class="form-control" id="inp_tgl_masuk" name="inp_tgl_masuk" value="{{ $res->tgl_masuk }}" required>
                                        </div>
                                        <div class="form-group col-sm-5">
                                            <label for="pil_divisi">Divisi : </label>
                                            <select class="form-control" id="pil_divisi" name="pil_divisi" disabled>
                                                <option value="0">Non Divisi</option>
                                                @foreach($list_divisi as $divisi)
                                                    @if($divisi->id==$res->id_divisi)
                                                    <option value="{{ $divisi->id }}" selected>{{ $divisi->nm_divisi }}</option>
                                                    @else
                                                    <option value="{{ $divisi->id }}">{{ $divisi->nm_divisi }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-5">
                                            <label for="pil_sts_karyawan">Status Karyawan :</label>
                                            <select class="form-control" id="pil_sts_karyawan" name="pil_sts_karyawan" disabled>
                                                @foreach($list_sts_karyawan as $key => $sts_karyawan)
                                                    @if($key==$res->id_status_karyawan)
                                                    <option value="{{ $key }}" selected>{{ $sts_karyawan }}</option>
                                                    @else
                                                    <option value="{{ $key }}">{{ $sts_karyawan }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="form-group col-sm-2"></div>
                                        <div class="form-group col-sm-5">
                                            <label for="pil_departemen">Departemen :</label>
                                            <select class="form-control" id="pil_departemen" name="pil_departemen" disabled>
                                                <option value="0">Non Departemen</option>
                                                @foreach($list_departemen as $dept)
                                                    @if($dept->id==$res->id_departemen)
                                                    <option value="{{ $dept->id }}" selected>{{ $dept->nm_dept }}</option>
                                                    @else
                                                    <option value="{{ $dept->id }}">{{ $dept->nm_dept }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-5">
                                            <label for="inp_tgl_eff_mulai">Efektif Mulai :</label>
                                            <input type="date" class="form-control" id="inp_tgl_eff_mulai" name="inp_tgl_eff_mulai" value="{{ $res->tgl_sts_efektif_mulai }}" required>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="form-group col-sm-2"></div>
                                        <div class="form-group col-sm-5">
                                            <label for="pil_subdepartemen">Sub Departemen : </label>
                                            <select class="form-control" id="pil_subdepartemen" name="pil_subdepartemen" disabled>
                                                <option value="0">Non Sub Departemen</option>
                                                @foreach($list_subdepartemen as $subdept)
                                                    @if($subdept->id==$res->id_subdepartemen)
                                                    <option value="{{ $subdept->id }}" selected>{{ $subdept->nm_subdept }}</option>
                                                    @else
                                                    <option value="{{ $subdept->id }}">{{ $subdept->nm_subdept }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-5">
                                            <label for="inp_tgl_eff_akhir">Efektif Akhir :</label>
                                            <input type="date" class="form-control" id="inp_tgl_eff_akhir" name="inp_tgl_eff_akhir" value="{{ $res->tgl_sts_efektif_akhir }}">
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="form-group col-sm-2"></div>
                                        <div class="form-group col-sm-5">
                                            <label for="pil_jabatan">Jabatan : </label>
                                            <select class="form-control" id="pil_jabatan" name="pil_jabatan" disabled required>
                                                @foreach($list_jabatan as $jabatan)
                                                    @if($jabatan->id==$res->id_jabatan)
                                                    <option value="{{ $jabatan->id }}" selected>{{ $jabatan->nm_jabatan }}</option>
                                                    @else
                                                    <option value="{{ $jabatan->id }}">{{ $jabatan->nm_jabatan }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-5"></div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="form-group col-sm-2"></div>
                                        <div class="form-group col-sm-5">
                                            <label for="inp_tgl_eff_jabatan">Tanggal Efektif Posisi/Jabatan :</label>
                                            <input type="date" class="form-control" id="inp_tgl_eff_jabatan" name="inp_tgl_eff_jabatan" value="{{ $res->tmt_jabatan }}" required>
                                        </div>
                                        <div class="form-group col-sm-5"></div>
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
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".angka").number(true, 0);
        $("#pil_divisi").on("change", function()
        {
            var id_pil = $("#pil_divisi").val();
            hapus_teks_dept_sub();
            if(id_pil==0)
            {
                $("#pil_jabatan").load("{{ url('hrd/karyawan/loadjabatandefault') }}");
            } else {
                $("#pil_departemen").load("{{ url('hrd/karyawan/loaddepartement') }}/"+id_pil);
                $("#pil_jabatan").load("{{ url('hrd/karyawan/loadjabatandivisi') }}/"+id_pil);
            }
        });
        $("#pil_departemen").on("change", function()
        {
            var id_pil_divisi = $("#pil_divisi").val();
            var id_pil_dept = $("#pil_departemen").val();
            hapus_teks_sub();
            if(id_pil_dept==0)
            {
                $("#pil_jabatan").load("{{ url('hrd/karyawan/loadjabatandivisi') }}/"+id_pil_divisi);
            } else {
                $("#pil_subdepartemen").load("{{ url('hrd/karyawan/loadsubdept') }}/"+id_pil_dept);
                $("#pil_jabatan").load("{{ url('hrd/karyawan/loadjabatandept') }}/"+id_pil_dept);
            }
        });
        $("#pil_subdepartemen").on("change", function()
        {
            var id_pil_dept = $("#pil_departemen").val();
            var id_pil_subdept = $("#pil_subdepartemen").val();
            if(id_pil_subdept==0)
            {
                $("#pil_jabatan").load("{{ url('hrd/karyawan/loadjabatandept') }}/"+id_pil_dept);
            } else {
                //$("#pil_subdepartemen").load("{{ url('hrd/karyawan/loadsubdept') }}/"+id_pil_dept);
                $("#pil_jabatan").load("{{ url('hrd/karyawan/loadjabatansubdept') }}/"+id_pil_subdept);
            }
        });

    });
    function hapus_teks_dept_sub()
    {
        $("#pil_departemen").empty();
        $("#pil_subdepartemen").empty();
        $("#pil_departemen").append("<option value='0'>Non Departemen</option>");
        $("#pil_subdepartemen").append("<option value='0'>Non Sub Departemen</option>");
    }
    function hapus_teks_sub()
    {
        $("#pil_subdepartemen").empty();
        $("#pil_subdepartemen").append("<option value='0'>Non Sub Departemen</option>");
    }
    function konfirm()
    {
        var psn = confirm("Yakin akan menyimpan data ?");
        if(psn==true)
        {
            validasi.cekNIMSimpan();
            //return true;
        } else {
            return false;
        }
    }

    function cekNIK()
    {
        var nik = $("#inp_nik").val();
        if(nik=="")
        {
            alert("Kolom input NIK tidak boleh kosong...");
            return false;
        } else {
            $.ajax(
            {
                url: "{{ url('hrd/karyawan/periksa_nik')}}",
                type : 'post',
                headers : {
                    'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
                },
                data : {nik:nik},
                success : function(res)
                {
                    if(res==1)
                    {
                        alert('NIK yang anda masukkan sudah Terdaftar');
                        aktif_teks(true);
                        return false;
                    } else {
                        aktif_teks(false);
                        return true;
                    }
                }

            });
        }
    }
    function aktif_teks(tf)
    {
        $("#file_photo").attr('disabled', tf);
        $("#inp_nama").attr('disabled', tf);
        $("#inp_tempat_lahir").attr('disabled', tf);
        $("#inp_tgl_lahir").attr('disabled', tf);
        $("#rdo_jenkel_1").attr('disabled', tf);
        $("#rdo_jenkel_2").attr('disabled', tf);
        $("#pil_agama").attr('disabled', tf);
        $("#pil_jenjang").attr('disabled', tf);
        $("#pil_status_nikah").attr('disabled', tf);
        $("#inp_nomor_ktp").attr('disabled', tf);
        $("#inp_alamat").attr('disabled', tf);
        $("#inp_suku").attr('disabled', tf);
        $("#inp_notelepon").attr('disabled', tf);
        $("#inp_email").attr('disabled', tf);
        $("#inp_nomor_npwp").attr('disabled', tf);
        $("#inp_nomor_bpjstk").attr('disabled', tf);
        $("#inp_nomor_bpjsks").attr('disabled', tf);
        $("#inp_tgl_masuk").attr('disabled', tf);
        $("#pil_divisi").attr('disabled', tf);
        $("#pil_departemen").attr('disabled', tf);
        $("#pil_subdepartemen").attr('disabled', tf);
        $("#pil_jabatan").attr('disabled', tf);
        $("#pil_sts_karyawan").attr('disabled', tf);
        $("#inp_tgl_eff_mulai").attr('disabled', tf);
        $("#inp_tgl_eff_akhir").attr('disabled', tf);
        $("#tbl_simpan").attr('disabled', tf);
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
