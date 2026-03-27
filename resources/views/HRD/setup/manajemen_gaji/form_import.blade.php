@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/setup/manajemengapok') }}">Pengaturan Gaji Pokok</a></li>
        <li class="breadcrumb-item active" aria-current="page">Import Gaji Pokok, BPJS, JAMSOSTEK</li>
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
<form action="{{ url('hrd/setup/manajemengapok/doImportGapok') }}" method="post" enctype="multipart/form-data">
{{ csrf_field() }}
<div class="row">
    <div class="col-lg-4">
        <div class="iq-card">
            <div class="iq-card-body">
                <div class="form-group">
                    <div class="alert alert-danger" role="alert">
                        <div class="iq-alert-text">
                            <h5 class="alert-heading">Informasi !</h5><hr>
                            <p class="mb-0">Pastikan file excel yang akan diimport sesuai dengan template database gaji pokok, bpjs dan jamsostek karyawan</p>
                            <hr>
                            <p><button type="button" class="btn btn-danger" name="tbl_download_template" id="tbl_download_template" onClick="goDownloadTemplateGapok()"><i class="fa fa-download"></i> Download Template Gaji Pokok, BPJS dan JAMSOSTEK Karyawan</button></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Proses Import Data</h4>
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
                <button class="btn btn-primary" name="tbl_import" id="tbl_import"><i class="fa fa-upload"></i> Import Data</button>
                <hr>
            </div>
        </div>
    </div>
</div>
</form>
<script>
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    });
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
    var goDownloadTemplateGapok = function()
    {
        window.open("{{ url('hrd/setup/manajemengapok/downloadtemplateGapok') }}")
    }
</script>
@stop
