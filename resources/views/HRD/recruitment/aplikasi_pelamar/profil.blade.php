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
@if(\Session::has('konfirm'))
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="alert text-white bg-success" role="alert" id="success-alert">
            <div class="iq-alert-icon">
                <i class="ri-alert-line"></i>
            </div>
            <div class="iq-alert-text">{{ \Session::get('konfirm') }}</div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="ri-close-line"></i>
            </button>
        </div>
    </div>
</div>
@endif
<div class="row row-eq-height">
    <div class="col-lg-4 col-md-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="iq-card iq-card-block iq-card-stretch iq-card-height wow iq-profile-card text-center">
                    <div class="iq-card-body">
                        <div class="iq-team text-center p-0">
                            <img src="{{ asset('assets/images/img_profil.jpg') }}"
                                 class="img-fluid mb-3 avatar-120 rounded-circle" alt="">
                            <h4 class="mb-0">{{ $data_lowongan->get_jabatan->nm_jabatan }}</h4>
                            <p class="mt-1">{{ $data_lowongan->get_departemen->nm_dept }}</p>
                            <hr>
                            <ul class="list-inline mb-0 d-flex justify-content-between">
                                <li class="list-inline-item">
                                    <h5>Aplikasi</h5>
                                    <p class="badge badge-primary">{{ $total_aplikasi }}</p>
                                </li>
                                <li class="list-inline-item">
                                    <h5>Approved</h5>
                                    <p class="badge badge-success">{{ $total_aplikasi_approve }}</p>
                                </li>
                                <li class="list-inline-item">
                                    <h5>Rejected</h5>
                                    <p class="badge badge-danger">{{ $total_aplikasi_approve }}</p>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="iq-card iq-card-block iq-card-stretch iq-card-height wow">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Rekapitulasi Hasil Tes</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        @foreach ($result_rekap as $rekap)
                        <div class="media">
                            <img class="img-fluid mr-3 avatar-80 rounded-circle" src="{{ url(Storage::url("hrd/pelamar/photo/".$rekap->file_photo)) }}"
                                 alt="Generic placeholder image">
                            <div class="media-body">
                                <h5 class="mt-0 mb-0">{{ $rekap->nama_lengkap }}</h5>
                                <ul class="list-inline mb-0 d-flex justify-content-between">
                                    <li class="list-inline-item">
                                        <h5>Psikotes</h5>
                                        <p class="badge badge-primary">{{ (empty($rekap->psikotes_nilai)) ? 0 : $rekap->psikotes_nilai }}</p>
                                    </li>
                                    <li class="list-inline-item">
                                        <h5>Wawancara</h5>
                                        <p class="badge badge-primary">{{ (empty($rekap->wawancara_nilai)) ? 0 : $rekap->wawancara_nilai }}</p>
                                    </li>
                                    <li class="list-inline-item">
                                        <h5>Total Skor</h5>
                                        <p class="badge badge-success">{{ $rekap->total_skor }}</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-md-12">
        <div class="row">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">Form Aplikasi Pelamar</h4>
                    </div>
                </div>
                <form action="{{ url('hrd/recruitment/aplikasi_pelamar/profil/simpan') }}" method="post" onsubmit="return konfirm()" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="id_lowongan" id="id_lowongan" value="{{ $data_lowongan->id }}">
                <input type="hidden" name="pil_departemen" id="pil_departemen" value="{{ $data_lowongan->get_jabatan->id_dept }}">
                <input type="hidden" name="pil_subdepartemen" id="pil_subdepartemen" value="{{ $data_lowongan->get_jabatan->id_subdept }}">
                <input type="hidden" name="pil_jabatan" id="pil_jabatan" value="{{ $data_lowongan->get_jabatan->id }}">
                <div class="row">
                    <div class="col-lg-3">
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
                                            <input class="form-control" type="file" name="file_photo" id="file_photo" accept="image/*" onchange="loadFile(this)" disabled />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
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
                                    <div class="form-group col-sm-3">
                                        <label for="inp_no_identitas">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <button type="button" class="btn btn-success" name="tbl_periksa_id" id="tbl_periksa_id" onclick="checkID();">Perikasa Data</button>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="form-group col-sm-12">
                                        <label for="inp_nama">Nama Lengkap :</label>
                                        <input type="text" class="form-control" id="inp_nama" name="inp_nama" maxlength="150" disabled  required>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="form-group col-sm-8">
                                        <label for="inp_tempat_lahir">Tempat Lahir :</label>
                                        <input type="text" class="form-control" id="inp_tempat_lahir" name="inp_tempat_lahir" maxlength="150" disabled required>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="inp_tgl_lahir">Tanggal Lahir :</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-calendar"></i></span>
                                            </div>
                                            <input type="text" class="form-control datepicker" id="inp_tgl_lahir" name="inp_tgl_lahir" placeholder="dd/mm/yyyy" required disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="form-group col-sm-6">
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
                                    <div class="form-group col-sm-6">
                                        <label class="d-block">Status Pernikahan :</label>
                                        <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="rdo_sts_nikah_1" name="rdo_sts_nikah" class="custom-control-input" checked="" value="1" disabled>
                                        <label class="custom-control-label" for="rdo_sts_nikah_1"> Belum Menikah </label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="rdo_sts_nikah_2" name="rdo_sts_nikah" class="custom-control-input" value="2" disabled>
                                        <label class="custom-control-label" for="rdo_sts_nikah_2"> Menikah </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row align-items-center">
                                    <div class="form-group col-sm-4">
                                        <label for="pil_agama">Agama :</label>
                                        <select class="form-control" id="pil_agama" name="pil_agama" required disabled>
                                            @foreach($all_agama as $key => $agama)
                                            <option value="{{ $key }}">{{ $agama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-8">
                                        <label for="inp_alamat">Alamat :</label>
                                        <input type="text" class="form-control" id="inp_alamat" name="inp_alamat" maxlength="150" required disabled>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="form-group col-sm-6">
                                        <label for="inp_hp">No. HP :</label>
                                        <input type="text" class="form-control" id="inp_hp" name="inp_hp" maxlength="50" required disabled>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="inp_wa">No. WA :</label>
                                        <input type="text" class="form-control" id="inp_wa" name="inp_wa" maxlength="50" disabled>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="form-group col-sm-6">
                                        <label for="inp_email">Email :</label>
                                        <input type="email" class="form-control" id="inp_email" name="inp_email" maxlength="100" disabled>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="pil_jenjang">Pendidikan Terakhir :</label>
                                        <select class="form-control" id="pil_jenjang" name="pil_jenjang" required disabled>
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
                                        <td colspan="2">Kesimpulan</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control angka_psikotes" value="0" style="text-align: center" name="nil_psikotes" id="nil_psikotes" onblur="getNormaPsikotes(this)" required disabled>
                                        </td>
                                        <td colspan="2">
                                            <input type="text" class="form-control" id="pil_kesimpulan_psikotes" name="pil_kesimpulan_psikotes" readonly>
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
                                        <td><input type="text" class="form-control angka" value="0" style="text-align: center" maxlength="3" name="nil_wawancara" id="nil_wawancara" required disabled></td>
                                        <td>
                                            <select class="form-control" id="pil_kesimpulan_wawancara" name="pil_kesimpulan_wawancara" required disabled>
                                                <option value="0">Pilihan</option>
                                                <option value="Dapat Disarankan">Dapat Disarankan</option>
                                                <option value="Dipertimbangkan">Dipertimbangkan</option>
                                                <option value="Tidak Disarankan">Tidak Disarankan</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" maxlength="100" name="ket_wawancara" id="ket_wawancara" required disabled>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <hr>
                            <button type="submit" id="tbl_simpan" class="btn btn-primary" disabled><i class="fa fa-save"></i> Submit</button>
                        </div>


                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">

    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $(".select2").select2();
        $(".angka").number(true, 0);
        $(".angka_psikotes").number(true, 1);
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".datepicker").datepicker({
            format: 'dd/mm/yyyy',
            orientation : "button right",
            todayHighlight: true,
            autoclose: true,
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
                } else {
                    output.src = URL.createObjectURL(oInput.files[0]);
                }
            }

        }
        return true;

    };
    var getNormaPsikotes = function(el)
    {
        var nilai = $(el).val();
        $.ajax({
                url: "{{ route('setup.norma_psikotest.getHasil')}}",
                type : 'post',
                headers : {
                    'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
                },
                data : {nilai:nilai},
                dataType: 'json',
                success : function(res)
                {
                    $("#pil_kesimpulan_psikotes").val(res.result);
                }
            })
    }
    var checkID = function() {
        var noID = $("#inp_no_identitas").val();
        $.ajax({
            url: "{{ url('hrd/recruitment/aplikasi_pelamar/profil/checkID')}}",
            type : 'post',
            headers : {
                'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
            },
            data : {noID:noID},
            dataType: 'json',
            success : function(res)
            {
                if(res.result==0) {
                    aktif_teks(false);
                    hapus_teks();
                } else {
                    alert("Nomor Identitas yang anda masukkan sudah terdaftar");
                    aktif_teks(true);
                    hapus_teks();
                }
            }
        })
    }
    function hapus_teks()
    {
        $("#inp_nama").val("");
        $("#inp_tempat_lahir").val("");
        $("#inp_tgl_lahir").val("");
        $("#pil_agama").val("");
        $("#inp_alamat").val("");
        $("#inp_hp").val("");
        $("#inp_wa").val("");
        $("#inp_email").val("");
        $("#pil_jenjang").val("");
        $("#nil_psikotes").val("0");
        $("#pil_kesimpulan_psikotes").val("");
        $("#nil_wawancara").val(0);
        $("#pil_kesimpulan_wawancara").val(0);
        $("#ket_wawancara").val("");
    }
    function aktif_teks(tf)
    {
        $("#file_photo").attr("disabled", tf);
        $("#inp_nama").attr("disabled", tf);
        $("#inp_tempat_lahir").attr("disabled", tf);
        $("#inp_tgl_lahir").attr("disabled", tf);
        $("#rdo_jenkel_1").attr("disabled", tf);
        $("#rdo_jenkel_2").attr("disabled", tf);
        $("#rdo_sts_nikah_1").attr("disabled", tf);
        $("#rdo_sts_nikah_2").attr("disabled", tf);
        $("#pil_agama").attr("disabled", tf);
        $("#inp_alamat").attr("disabled", tf);
        $("#inp_hp").attr("disabled", tf);
        $("#inp_wa").attr("disabled", tf);
        $("#inp_email").attr("disabled", tf);
        $("#pil_jenjang").attr("disabled", tf);
        $("#nil_psikotes").attr("disabled", tf);
        $("#pil_kesimpulan_psikotes").attr("disabled", tf);
        $("#nil_wawancara").attr("disabled", tf);
        $("#pil_kesimpulan_wawancara").attr("disabled", tf);
        $("#ket_wawancara").attr("disabled", tf);
        $("#tbl_simpan").attr("disabled", tf);
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
