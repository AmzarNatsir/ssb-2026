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
            <form action="{{ url('hrd/recruitment/aplikasi_pelamar/profil/simpan') }}" method="post" onsubmit="return konfirm()" enctype="multipart/form-data">
                {{ csrf_field() }}
            <div class="row">
                <div class="col-lg-2">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title"><i class="fa fa-image" aria-hidden="true"></i> Photo</h4>
                            </div>
                        </div>
                        <div class="iq-card-body" style="width:100%; height:auto">
                            <div class="row align-items-center">
                                <div class="form-group col-md-12">
                                    <div class="profile-img-edit">
                                        <img class="profile-pic" id="preview_upload" src="{{ asset('assets/images/user/06.jpg') }}" alt="profile-pic">
                                        <input class="form-control" type="file" name="file_photo" id="file_photo" accept="image/*" onchange="loadFile(this)" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title"><i class="fa fa-user"></i> Biodata</h4>
                            </div>
                        </div>
                        <div class="iq-card-body" style="width:100%; height:auto">
                            <div class="row align-items-center">
                                <div class="form-group col-sm-4">
                                    <label for="inp_no_identitas">Nomor Identitas (KTP) :</label>
                                    <input type="text" class="form-control" id="inp_no_identitas" name="inp_no_identitas" maxlength="50" required>
                                </div>
                                <div class="form-group col-sm-8">
                                    <label for="inp_nama">Nama Lengkap :</label>
                                    <input type="text" class="form-control" id="inp_nama" name="inp_nama" maxlength="150" required>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="form-group col-sm-8">
                                    <label for="inp_tempat_lahir">Tempat Lahir :</label>
                                    <input type="text" class="form-control" id="inp_tempat_lahir" name="inp_tempat_lahir" maxlength="150" required>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="inp_tgl_lahir">Tanggal Lahir :</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-calendar"></i></span>
                                        </div>
                                        <input type="text" class="form-control datepicker" id="inp_tgl_lahir" name="inp_tgl_lahir" placeholder="dd/mm/yyyy" required readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="form-group col-sm-6">
                                    <label class="d-block">Jenis Kelamin :</label>
                                    <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="rdo_jenkel_1" name="rdo_jenkel" class="custom-control-input" checked="" value="1">
                                    <label class="custom-control-label" for="rdo_jenkel_1"> Laki-Laki </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="rdo_jenkel_2" name="rdo_jenkel" class="custom-control-input" value="2">
                                    <label class="custom-control-label" for="rdo_jenkel_2"> Perempuan </label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="d-block">Status Pernikahan :</label>
                                    <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="rdo_sts_nikah_1" name="rdo_sts_nikah" class="custom-control-input" checked="" value="1">
                                    <label class="custom-control-label" for="rdo_sts_nikah_1"> Belum Menikah </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="rdo_sts_nikah_2" name="rdo_sts_nikah" class="custom-control-input" value="2">
                                    <label class="custom-control-label" for="rdo_sts_nikah_2"> Menikah </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-center">
                                <div class="form-group col-sm-4">
                                    <label for="pil_agama">Agama :</label>
                                    <select class="form-control" id="pil_agama" name="pil_agama" required>
                                        @foreach($all_agama as $key => $agama)
                                        <option value="{{ $key }}">{{ $agama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-8">
                                    <label for="inp_alamat">Alamat :</label>
                                    <input type="text" class="form-control" id="inp_alamat" name="inp_alamat" maxlength="150" required>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="form-group col-sm-6">
                                    <label for="inp_hp">No. HP :</label>
                                    <input type="text" class="form-control" id="inp_hp" name="inp_hp" maxlength="50" required>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="inp_wa">No. WA :</label>
                                    <input type="text" class="form-control" id="inp_wa" name="inp_wa" maxlength="50" required>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="form-group col-sm-6">
                                    <label for="inp_email">Email :</label>
                                    <input type="email" class="form-control" id="inp_email" name="inp_email" maxlength="100">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="pil_jenjang">Pendidikan Terakhir :</label>
                                    <select class="form-control" id="pil_jenjang" name="pil_jenjang" required>
                                        @foreach($all_jenjang as $key => $jenjang)
                                        <option value="{{ $key }}">{{ $jenjang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title"><i class="fa fa-building"></i> Bagian Yang Dilamar</h4>
                            </div>
                        </div>
                        <div class="iq-card-body" style="width:100%; height:auto">
                            <div class="row align-items-center">
                                <div class="form-group col-sm-6">
                                    <label for="pil_departemen">Departemen :</label>
                                    <select class="form-control select2" id="pil_departemen" name="pil_departemen">
                                    <option value="0">Pilih Departemen</option>
                                        @foreach($all_departemen as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->nm_dept }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="pil_subdepartemen">Sub Departemen :</label>
                                    <select class="form-control select2" id="pil_subdepartemen" name="pil_subdepartemen">
                                    <option value="0">Pilihan Sub Departemen</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="form-group col-sm-12">
                                    <label for="pil_jabatan">Jabatan :</label>
                                    <select class="form-control select2" id="pil_jabatan" name="pil_jabatan" required>
                                        <option value="0">Pilihan Jabatan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title"><i class="fa fa-pencil"></i> Hasil Tes</h4>
                            </div>
                        </div>
                        <div class="iq-card-body" style="width:100%; height:auto">
                            <table class="table" style="width: 100%">
                                <tr>
                                    <td colspan="3" style="text-align: left"><b>PSIKOTEST</b></td>
                                </tr>
                                <tr>
                                    <td style="width: 15%">Nilai</td>
                                    <td style="width: 20%">Kesimpulan</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" class="form-control angka" value="0" style="text-align: center" maxlength="3" name="nil_psikotes" id="nil_psikotes" required>
                                    </td>
                                    <td>
                                        <select class="form-control" id="pil_kesimpulan_psikotes" name="pil_kesimpulan_psikotes" required>
                                            <option value="0">Pilihan</option>
                                            <option value="Dapat Disarankan">Dapat Disarankan</option>
                                            <option value="Dipertimbangkan">Dipertimbangkan</option>
                                            <option value="Tidak Disarankan">Tidak Disarankan</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align: left"><b>WAWANCARA</b></td>
                                </tr>
                                <tr>
                                    <td>Nilai</td>
                                    <td>Kesimpulan</td>
                                    <td>Saran/Komentar</td>
                                </tr>
                                <tr>
                                    <td><input type="text" class="form-control angka" value="0" style="text-align: center" maxlength="3" name="nil_wawancara" id="nil_wawancara" required></td>
                                    <td>
                                        <select class="form-control" id="pil_kesimpulan_wawancara" name="pil_kesimpulan_wawancara" required>
                                            <option value="0">Pilihan</option>
                                            <option value="Dapat Disarankan">Dapat Disarankan</option>
                                            <option value="Dipertimbangkan">Dipertimbangkan</option>
                                            <option value="Tidak Disarankan">Tidak Disarankan</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" maxlength="100" name="ket_wawancara" id="ket_wawancara" required>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <hr>
                        <button type="submit" id="tbl_simpan" class="btn btn-primary"><i class="fa fa-save"></i> Submit</button>
                    </div>


                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $(".select2").select2();
        $(".angka").number(true, 0);
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".datepicker").datepicker({
            format: 'dd/mm/yyyy',
            orientation : "button right",
            todayHighlight: true,
            autoclose: true,
        });
        $("#pil_departemen").on("change", function()
        {
            var id_pil_dept = $("#pil_departemen").val();
            hapus_teks_sub();
            if(id_pil_dept==0) {
                hapus_teks_jab();
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
    function hapus_teks_sub()
    {
        $("#pil_subdepartemen").empty();
        $("#pil_subdepartemen").append("<option value='0'>Pilihan Sub Departemen</option>");
    }
    function hapus_teks_jab()
    {
        $("#pil_jabatan").empty();
        $("#pil_jabatan").append("<option value='0'>Pilihan Jabatan</option>");
    }
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
                } else {
                    output.src = URL.createObjectURL(oInput.files[0]);
                }
            }

        }
        return true;

    };
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
