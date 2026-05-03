@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/karyawan/daftar') }}">Karyawan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tools | Import Database Karyawan</li>
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
<form action="{{ route('doImportKaryawa') }}" method="post" onsubmit="return konfirm()" enctype="multipart/form-data">
{{ csrf_field() }}
<div class="row">
    <div class="col-lg-4">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Pengaturan</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <div class="form-group">
                    <label for="pil_lvl_jabatan">Level Jabatan :</label>
                    <select class="select2 form-control mb-3" id="pil_lvl_jabatan" name="pil_lvl_jabatan" required>
                        @foreach($all_level as $key => $leveljab)
                        <option value="{{ $leveljab->id }}">{{ $leveljab->nm_level }} -> Level {{ $leveljab->level }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="pil_divisi">Divisi :</label>
                    <select class="select2 form-control mb-3" id="pil_divisi" name="pil_divisi" required onchange="getDepartemen(this)">
                        <option value="0">Non Divisi</option>
                        @foreach($all_divisi as $divisi)
                        <option value="{{ $divisi->id }}">{{ $divisi->nm_divisi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="pil_departemen">Departemen :</label>
                    <select class="select2 form-control mb-3" id="pil_departemen" name="pil_departemen" required onchange="getSubDepartemen(this)">
                    <option value="0">Non Departemen</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="pil_departemen">Sub Departemen :</label>
                    <select class="select2 form-control mb-3" id="pil_subdepartemen" name="pil_subdepartemen">
                    <option value="0">Non Sub Departemen</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="iq-card">
            <table class="table" style="width: 100%">
            <tr>
                <td>No</td>
                <td>Tabel</td>
                <td>Jumlah Data</td>
                <td></td>
            </tr>
            <tr>
                <td>1</td>
                <td>Perdis</td>
                <td>{{ $all_perdis->count() }}</td>
                <td>
                    <a href="{{ url('hrd/tools/hapusPerdis') }}" class="btn btn-danger mb-2" onClick="return hapusKonfirm()"><i class="ri-delete-bin-line pr-0 btn btn-danger"></i></a></td>
            </tr>
            </table>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Proses Import Data</h4>
                </div>
                <div class="iq-card-header-toolbar d-flex align-items-center">
                    <a href="{{ route('downloadTemplateKaryawan') }}" class="btn btn-success"><i class="ri-file-excel-2-line"></i> Download Template</a>
                </div>
            </div>
            <div class="iq-card-body">
                <div class="row align-items-center">
                    <div class="form-group col-md-12">
                            <input class="form-control" type="file" name="file_imp" id="file_imp" onchange="loadFile(this)" required />
                            <span>* .csv|.xlsx only</span>
                    </div>
                </div>
                <hr>
                <button class="btn btn-primary" name="tbl_import" id="tbl_import">Preview Data</button>
            </div>
            
        </div>
    </div>
</div>
</form>
<script>
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".select2").select2({
            width: '100%'
        });
    });
    var getDepartemen = function(el)
    {
        var id_divisi = $(el).val();
        hapus_teks();
        if(id_divisi==0)
        {
            return false;
        } else {
            $("#pil_departemen").load("{{ url('hrd/masterdata/subdepartemen/loaddepartement') }}/"+id_divisi);
        }
    }
    var getSubDepartemen = function(el)
    {
        var id_departemen = $(el).val();
        $("#pil_subdepartemen").empty();
        if(id_departemen==0)
        {
            return false;
        } else {
            //aktif_teks(false);
            $("#pil_subdepartemen").load("{{ url('hrd/masterdata/jabatan/loadsubdepartement') }}/"+id_departemen);
        }
    }
    function aktif_teks(tf)
    {
        $("#pil_departemen").attr("disabled", tf);
        $("#pil_subdepartemen").attr("disabled", tf);
        $("#pil_lvl_jabatan").attr("disabled", tf);
        $("#inp_nama").attr("disabled", tf);
        $("#tbl_simpan").attr("disabled", tf);
    }
    function hapus_teks()
    {
        $("#pil_departemen").empty();
        $("#pil_subdepartemen").empty();
        $("#pil_departemen").append("<option value='0'>Non Departemen</option>");
        $("#pil_subdepartemen").append("<option value='0'>Non Sub Departemen</option>");
    }
    var _validFileExtensions = [".csv", ".xlsx"]; 
    var loadFile = function(oInput) {
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            var sSizeFile = oInput.files[0].size;
            //var output = document.getElementById('preview_upload');
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
                    return false;
                } 
            }
            
        }
        return true;

    }; 
    function hapusKonfirm()
    {
        var psn = confirm("Yakin akan menghapus data ?")
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
</script>
@stop