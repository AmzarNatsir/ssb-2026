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
                <div id="preview-section" style="display:none;">
                    <div class="alert alert-info">
                        <strong>Preview Data:</strong>
                        <small id="preview-info"></small>
                    </div>
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-sm table-bordered" id="preview-table">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>NIK (nik_lama)</th>
                                    <th>Tanggal Scan</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Status</th>
                                    <th>Validasi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div id="preview-errors" style="display:none;" class="alert alert-warning mt-3"></div>
                </div>
                <button type="button" class="btn btn-danger" name="tbl_preview" id="tbl_preview" style="display:none;"><i class="fa fa-eye"></i> Preview</button>
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

        // Initialize import button as disabled
        $('#tbl_import').prop('disabled', true).addClass('disabled').css('opacity', '0.6');

        // Preview button click handler
        $('#tbl_preview').click(function(e) {
            e.preventDefault();
            showPreview();
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
                    $('#preview-section').hide();
                    return false;
                } else {
                    // Show preview button when file is selected
                    $('#tbl_preview').show();
                }
            }

        }
        return true;

    };

    // Preview data
    var showPreview = function() {
        var fileInput = document.getElementById('file_imp');
        if (!fileInput.files[0]) {
            alert('Silakan pilih file terlebih dahulu');
            return;
        }

        let formData = new FormData(document.getElementById('formImport'));
        $.ajax({
            url: "{{ url('hrd/absensi/previewdataabsensi') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.success) {
                    renderPreview(response.preview, response.totalRows, response.errorCount);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Preview',
                        text: response.message || 'Terjadi kesalahan saat preview.'
                    });
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: "Gagal!",
                    text: "Terjadi kesalahan saat membaca preview data"
                });
            }
        });
    };

    var renderPreview = function(rows, totalRows, errorCount) {
        var tbody = $('#preview-table tbody');
        tbody.empty();

        rows.forEach(function(row, index) {
            var statusClass = row.valid ? 'success' : 'danger';
            var statusIcon = row.valid ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>';
            var errorMsg = row.valid ? '<span class="text-success">✓ Valid</span>' : '<span class="text-danger">' + row.errors.join(', ') + '</span>';

            var tr = `<tr>
                <td>${index + 1}</td>
                <td>${row.nik_lama}</td>
                <td>${row.tanggal_scan}</td>
                <td>${row.tanggal}</td>
                <td>${row.jam}</td>
                <td>${row.status}</td>
                <td>${errorMsg}</td>
            </tr>`;
            tbody.append(tr);
        });

        // Show preview section
        $('#preview-info').text(`Total: ${totalRows} baris | Errors: ${errorCount} baris`);
        $('#preview-section').show();

        // Enable/Disable import button based on error count
        if (errorCount > 0) {
            $('#tbl_import').prop('disabled', true).addClass('disabled').css('opacity', '0.6');
            var errorSummary = `<strong>⚠ Ditemukan ${errorCount} error pada data:</strong><ul style="margin: 10px 0; padding-left: 20px;">`;
            rows.forEach(function(row, index) {
                if (!row.valid) {
                    errorSummary += `<li>Baris ${index + 1}: ${row.errors.join(', ')}</li>`;
                }
            });
            errorSummary += `</ul>`;
            $('#preview-errors').html(errorSummary).show();
        } else {
            $('#tbl_import').prop('disabled', false).removeClass('disabled').css('opacity', '1');
            $('#preview-errors').hide();
        }
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
