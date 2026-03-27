@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/karyawan/daftar') }}">Daftar Karyawan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Karyawan</li>
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
                    <h4 class="card-title">Input Data Karyawan Baru</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <form action="{{ url('hrd/karyawan/simpan') }}" method="post" onsubmit="return konfirm()" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="iq-card iq-card-block iq-card-stretch">
                                <div class="iq-card-header d-flex justify-content-between">
                                    <div class="iq-header-title">
                                    <h4 class="card-title">Data Pribadi</h4>
                                    </div>
                                </div>
                                <div class="iq-card-body">
                                    <div class="row align-items-center">
                                        <div class="form-group col-sm-4">
                                            <label for="inp_tgl_masuk">Tanggal Masuk :</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input type="text" class="form-control datepicker" id="inp_tgl_masuk" name="inp_tgl_masuk" placeholder="dd/mm/yyyy" required>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                            <button type="button" class="btn btn-primary" name="btn_buat_nik" id="btn_buat_nik" onclick="buatNIKbaru()">Buat NIK Baru</button>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label class="d-block">NIK : </label>
                                            <input type="text" class="form-control" id="inp_nik" name="inp_nik" maxlength="20" required readonly>
                                        </div>
                                    </div>
                                    <span>* NIK dibetuk berdasarkan tanggal masuk karyawan (Auto)</span><br>
                                    <span>* Masukkan/Pilih Tanggal Masuk dan Klik kolom NIK untuk membuat NIK baru</span>
                                    <hr>
                                    <button type="button" class="btn btn-primary" id="tbl_baru" onClick="inputKolom()"><i class="fa fa-edit"></i> Klik untuk mengisi data karyawan baru</button>
                                    <hr>
                                    <div class="row align-items-center">
                                        <div class="form-group col-md-12">
                                            <div class="profile-img-edit">
                                                <img class="profile-pic" id="preview_upload" src="{{ asset('assets/images/user/06.jpg') }}" alt="profile-pic">
                                                <input class="form-control" type="file" name="file_photo" id="file_photo" accept="image/*" onchange="loadFile(this)" required disabled />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row align-items-center">
                                        <div class="form-group col-sm-12">
                                            <label for="inp_nama">Nama Lengkap :</label>
                                            <input type="text" class="form-control" id="inp_nama" name="inp_nama" maxlength="150" required disabled>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="form-group col-sm-8">
                                            <label for="inp_tempat_lahir">Tempat Lahir :</label>
                                            <input type="text" class="form-control" id="inp_tempat_lahir" name="inp_tempat_lahir" maxlength="150" required disabled>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="inp_tgl_lahir">Tanggal Lahir :</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input type="text" class="form-control datepicker" id="inp_tgl_lahir" name="inp_tgl_lahir" placeholder="dd/mm/yyyy" required readonly disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="form-group col-sm-12">
                                            <label class="d-block">Jenis Kelamin :</label>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="rdo_jenkel_1" name="rdo_jenkel" class="custom-control-input" checked="" value="1" disabled>
                                                <label class="custom-control-label" for="rdo_jenkel_1"> Laki-Laki </label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="rdo_jenkel_2" name="rdo_jenkel" class="custom-control-input" value="2" disabled>
                                                <label class="custom-control-label" for="rdo_jenkel_2"> Perempuan </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="form-group col-sm-12">
                                            <label for="pil_agama">Agama :</label>
                                            <select class="form-control" id="pil_agama" name="pil_agama" required disabled>
                                                @foreach($list_agama as $key => $agama)
                                                <option value="{{ $key }}">{{ $agama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="form-group col-sm-12">
                                            <label for="pil_jenjang">Pendidikan Terakhir :</label>
                                            <select class="form-control" id="pil_jenjang" name="pil_jenjang" required disabled>
                                                @foreach($list_jenjang as $key => $jenjang)
                                                <option value="{{ $key }}">{{ $jenjang }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="form-group col-sm-6">
                                            <label for="pil_status_nikah">Status Pernikahan :</label>
                                            <select class="form-control" id="pil_status_nikah" name="pil_status_nikah" required disabled>
                                                @foreach($list_status_nikah as $key => $nikah)
                                                <option value="{{ $key }}">{{ $nikah }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="pil_status_nikah">Status Tanggungan :</label>
                                            <select class="form-control" id="pil_status_tanggungan" name="pil_status_tanggungan" required disabled>
                                                @foreach($list_status_tanggungan as $tanggungan)
                                                <option value="{{ $tanggungan['id'] }}">{{ $tanggungan['kode'] }} | {{ $tanggungan['status_tanggungan'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="form-group col-sm-12">
                                            <label for="inp_nomor_ktp">Nomor KTP :</label>
                                            <input type="text" class="form-control" id="inp_nomor_ktp" name="inp_nomor_ktp" maxlength="50" required disabled>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="form-group col-sm-12">
                                            <label for="inp_alamat">Alamat :</label>
                                            <input type="text" class="form-control" id="inp_alamat" name="inp_alamat" maxlength="150" required disabled>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="form-group col-sm-12">
                                            <label for="inp_suku">Suku :</label>
                                            <input type="text" class="form-control" id="inp_suku" name="inp_suku" maxlength="100" disabled>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="form-group col-sm-12">
                                            <label for="inp_notelepon">No. Telepon :</label>
                                            <input type="text" class="form-control" id="inp_notelepon" name="inp_notelepon" maxlength="50" required disabled>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="form-group col-sm-12">
                                            <label for="inp_email">Email :</label>
                                            <input type="text" class="form-control" id="inp_email" name="inp_email" maxlength="100" disabled>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="form-group col-sm-4">
                                            <label for="inp_nomor_npwp">Nomor NPWP :</label>
                                            <input type="text" class="form-control" id="inp_nomor_npwp" name="inp_nomor_npwp" maxlength="50" required disabled>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="inp_nomor_bpjstk">Nomor BPJSTK :</label>
                                            <input type="text" class="form-control" id="inp_nomor_bpjstk" name="inp_nomor_bpjstk" maxlength="50" required disabled>
                                            <span>* BPJS Tenaga Kerja</span>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="inp_nomor_bpjsks">Nomor BPJSKS :</label>
                                            <input type="text" class="form-control" id="inp_nomor_bpjsks" name="inp_nomor_bpjsks" maxlength="50" required disabled>
                                            <span>* BPJS Kesehatan</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="iq-card iq-card-block iq-card-stretch">
                                <div class="iq-card-header d-flex justify-content-between">
                                    <div class="iq-header-title">
                                    <h4 class="card-title">Data Pekerjaan</h4>
                                    </div>
                                </div>
                                <div class="iq-card-body">
                                    <div class="row align-items-center">
                                        <div class="form-group col-sm-12">
                                            <label for="pil_divisi">Divisi :</label>
                                            <select class="form-control" id="pil_divisi" name="pil_divisi" disabled>
                                                <option value="0">Non Divisi</option>
                                                @foreach($list_divisi as $divisi)
                                                <option value="{{ $divisi->id }}">{{ $divisi->nm_divisi }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="form-group col-sm-12">
                                            <label for="pil_departemen">Departemen :</label>
                                            <select class="form-control" id="pil_departemen" name="pil_departemen" disabled>
                                                <option value="0">Non Departemen</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="form-group col-sm-12">
                                            <label for="pil_subdepartemen">Sub Departemen :</label>
                                            <select class="form-control" id="pil_subdepartemen" name="pil_subdepartemen" disabled>
                                            <option value="0">Non Sub Departemen</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="form-group col-sm-12">
                                            <label for="pil_jabatan">Jabatan :</label>
                                            <select class="form-control" id="pil_jabatan" name="pil_jabatan" required disabled>
                                                @foreach($list_jabatan as $jabatan)
                                                <option value="{{ $jabatan->id }}">{{ $jabatan->nm_jabatan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="form-group col-sm-6">
                                            <label for="inp_tgl_eff_jabatan">Tanggal Efektif Posisi/Jabatan :</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input type="text" class="form-control datepicker" id="inp_tgl_eff_jabatan" name="inp_tgl_eff_jabatan" placeholder="dd/mm/yyyy" required readonly disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row align-items-center">
                                        <div class="form-group col-sm-12">
                                            <label for="pil_sts_karyawan">Status Karyawan :</label>
                                            <select class="form-control" id="pil_sts_karyawan" name="pil_sts_karyawan" required disabled>
                                                @foreach($list_sts_karyawan as $key => $sts_karyawan)
                                                @if($key==2 || $key==7)
                                                <option value="{{ $key }}">{{ $sts_karyawan }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="form-group col-sm-6">
                                            <label for="inp_tgl_eff_mulai">Efektif Mulai :</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input type="text" class="form-control datepicker" id="inp_tgl_eff_mulai" name="inp_tgl_eff_mulai" placeholder="dd/mm/yyyy" required readonly disabled>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="inp_tgl_eff_akhir">Efektif Akhir :</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input type="text" class="form-control datepicker" id="inp_tgl_eff_akhir" name="inp_tgl_eff_akhir" placeholder="dd/mm/yyyy" required readonly disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <button type="submit" id="tbl_simpan" class="btn btn-primary" disabled><i class="fa fa-save"></i> Submit</button>
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
        $(".datepicker").datepicker({
            format: 'dd/mm/yyyy',
            orientation : "button right",
            todayHighlight: true
        });
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
        $("#pil_sts_karyawan").on("change", function()
        {
            var id_pil_sts = $("#pil_sts_karyawan").val();
            if(parseInt(id_pil_sts) >= 3)
            {
                $("#inp_tgl_eff_akhir").attr("disabled", true);
                $("#inp_tgl_eff_akhir").attr("required", false);
                $("#inp_tgl_eff_akhir").val("");
            } else {
                $("#inp_tgl_eff_akhir").attr("disabled", false);
                $("#inp_tgl_eff_akhir").attr("required", true);
            }
        });
    });
    var _validFileExtensions = [".jpg", ".jpeg", ".png"];
    var loadFile = function(oInput) {
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            var sSizeFile = oInput.files[0].size;
            var output = document.getElementById('preview_upload');
            //alert(sSizeFile);
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions.length; j++) {
                    var sCurExtension = _validFileExtensions[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    }
                }

                if (!blnValid) {
                    alert("Maaf, " + sFileName + " tidak valid, jenis file yang boleh di upload adalah : " + _validFileExtensions.join(", "));
                    oInput.value = "";
                    output.src = "{{ asset('assets/images/user/06.jpg') }}";
                    return false;
                }
                if(sSizeFile>400000) //50 KB
                {
                    alert("Maaf, " + sFileName + " tidak valid, Ukuran file terlalu besar: " + sSizeFile);
                    oInput.value = "";
                    output.src = "{{ asset('assets/images/user/06.jpg') }}";
                    return false;
                } else {

                output.src = URL.createObjectURL(oInput.files[0]);
                }
            }

        }
        return true;

    };
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

    function buatNIKbaru()
    {
        var tgl_masuk  = $("#inp_tgl_masuk").val();
        //var nik = $("#inp_nik").val();
        if(tgl_masuk=="")
        {
            alert("Kolom Tanggal Masuk Masih Kosong..");
            $("#inp_nik").val("");
            return false;
        } else {
            $.ajax(
            {
                url: "{{ url('hrd/karyawan/buatnikbaru')}}",
                type : 'post',
                headers : {
                    'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
                },
                data : {tgl_masuk:tgl_masuk},
                success : function(res)
                {
                    $("#inp_nik").val(res);
                }

            });
        }
    }
    function inputKolom()
    {
        var nik = $("#inp_nik").val();
        if(nik=="")
        {
            alert("Kolom NIK tidak boleh kosong...");
            aktif_teks(true);
            hapus_teks();
            return false;
        } else {
            aktif_teks(false);
            hapus_teks()
            return true;
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
        $("#pil_status_tanggungan").attr('disabled', tf);
        $("#inp_nomor_ktp").attr('disabled', tf);
        $("#inp_alamat").attr('disabled', tf);
        $("#inp_suku").attr('disabled', tf);
        $("#inp_notelepon").attr('disabled', tf);
        $("#inp_email").attr('disabled', tf);
        $("#inp_nomor_npwp").attr('disabled', tf);
        $("#inp_nomor_bpjstk").attr('disabled', tf);
        $("#inp_nomor_bpjsks").attr('disabled', tf);
        $("#pil_divisi").attr('disabled', tf);
        $("#pil_departemen").attr('disabled', tf);
        $("#pil_subdepartemen").attr('disabled', tf);
        $("#pil_jabatan").attr('disabled', tf);
        $("#inp_tgl_eff_jabatan").attr('disabled', tf);
        $("#pil_sts_karyawan").attr('disabled', tf);
        $("#inp_tgl_eff_mulai").attr('disabled', tf);
        $("#inp_tgl_eff_akhir").attr('disabled', tf);
        $("#tbl_simpan").attr('disabled', tf);
    }
    function hapus_teks()
    {
        $("#file_photo").val("");
        $("#img_preview").attr("src", "{{ asset('assets/images/user/06.jpg') }}");
        $("#inp_nama").val("")
        $("#inp_tempat_lahir").val("")
        $("#inp_tgl_lahir").val("");
        $("#rdo_jenkel_1").attr("checked", true);
        $("#rdo_jenkel_2").attr('checked', false);
        $('#pil_agama').get(0).selectedIndex = 0;
        $('#pil_jenjang').get(0).selectedIndex = 0;
        $('#pil_status_nikah').get(0).selectedIndex = 0;
        $('#pil_status_tanggungan').get(0).selectedIndex = 0;
        $("#inp_nomor_ktp").val("")
        $("#inp_alamat").val("")
        $("#inp_suku").val("");
        $("#inp_notelepon").val("");
        $("#inp_email").val("");
        $("#inp_nomor_npwp").val("");
        $("#inp_nomor_bpjstk").val("");
        $("#inp_nomor_bpjsks").val("");
        $("#pil_divisi").get(0).selectedIndex = 0;
        $("#pil_departemen").get(0).selectedIndex = 0;
        $("#pil_subdepartemen").empty();
        $("#pil_jabatan").get(0).selectedIndex = 0;
        $("#inp_tgl_eff_jabatan").val("");
        $("#pil_sts_karyawan").get(0).selectedIndex = 0;
        $("#inp_tgl_eff_mulai").val("");
        $("#inp_tgl_eff_akhir").val("");
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
