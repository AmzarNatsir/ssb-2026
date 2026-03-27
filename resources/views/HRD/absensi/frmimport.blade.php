@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/absensi') }}">Absensi</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tools | Import Database Absensi Karyawan</li>
        </ul>
    </nav>
</div>
@if(\Session::has('status'))
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="alert text-white bg-success" role="alert" id="success-alert">
            <div class="iq-alert-icon">
                <i class="ri-alert-line"></i>
            </div>
            <div class="iq-alert-text">{{ \Session::get('status') }}</div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="ri-close-line"></i>
            </button>
        </div>
    </div>
</div>
@endif
@if(session('failures'))
    <div class="alert alert-warning">
        <strong>Some rows failed:</strong>
        <ul>
            @foreach (session('failures') as $failure)
                <li>
                    Row {{ $failure->row() }}:
                    @foreach ($failure->errors() as $error)
                        {{ $error }}
                    @endforeach
                </li>
            @endforeach
        </ul>
    </div>
@endif

<form id="formImport" method="post" enctype="multipart/form-data">
{{ csrf_field() }}
<div class="row">
    <div class="col-lg-4">
        <div class="iq-card">
            <div class="iq-card-body">
                <div class="form-group">
                    <div class="alert alert-primary" role="alert">
                        <div class="iq-alert-text">
                            <h5 class="alert-heading">Informasi !</h5><hr>
                            {{-- <p>Pastikan ID Finger Karyawan sudah diatur. atau klik tombol <button type="button" class="btn btn-success" name="tbl_id_finger" id="tbl_id_finger" onclick="goIDFingerKaryawan()"><i class="fa fa-edit"></i> ID Finger Karyawan</button> untuk mengatur/mengisi ID Finger Karyawan</p>
                            <hr> --}}
                            <p>Pada template file excel, Kolom Departemen harus diisi ID Departemen. </p>
                            <p><button type="button" class="btn btn-primary" name="tbl_download_id_dept" id="tbl_download_id_dept" onclick="goIDDepartemen()"><i class="fa fa-download"></i> Download ID Departemen</button></p>
                            <hr>
                            <p class="mb-0">Pastikan file excel yang akan diimport sesuai dengan template database absensi karyawan</p>
                            <p><button type="button" class="btn btn-primary" name="tbl_download_template" id="tbl_download_template" onClick="goDownloadTemplateAbsensi()"><i class="fa fa-download"></i> Download Template Database Absensi Karyawa</button></p>
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
        // window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".select2").select2({
            // theme: "flat",
		    placeholder: "Search Departemen"
        });
        $('#formImport').submit(function (e) {
            e.preventDefault(); // Mencegah submit langsung

            if (!$(this).valid()) {
                return false;
            }

            // Tampilkan konfirmasi
            Swal.fire({
                title: 'Yakin mengimpor data?',
                text: 'Pastikan file dan format sudah benar!',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, impor!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let formData = new FormData(document.getElementById('formImport'));
                    console.log(formData.get('file_imp'));
                    $.ajax({
                        url: "{{ url('hrd/absensi/storedataabsensi') }}",
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if (response.success == true) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message || 'Terjadi kesalahan saat impor.'
                                });
                            }
                        },
                        error: function (xhr) {
                            console.log(xhr.responseText); // Debugging
                            Swal.fire({
                                icon: 'error',
                                title: "Gagal!",
                                html: "Terjadi kesalahan:<br><pre style='text-align:left;'>" + xhr.responseText + "</pre>"
                            });
                        }
                    });
                }
            });
        });

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
    var goIDFingerKaryawan = function()
    {
        window.open("{{ url('hrd/karyawan/importIDFingerKaryawan') }}")
    }
    var goIDDepartemen = function()
    {
        window.open("{{ url('hrd/masterdata/departemen/excel') }}")
    }
    var goDownloadTemplateAbsensi = function()
    {
        window.open("{{ url('hrd/karyawan/downloadtemplateAbsensiKaryawan') }}")
    }
</script>
@stop
