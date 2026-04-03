@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/penggajian') }}">Penggajian</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tools | Import Database Periode Penggajian Karyawan</li>
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
<form action="{{ url('hrd/penggajian/doImportPeriodePenggajian') }}" method="post" onsubmit="return konfirm()" enctype="multipart/form-data">
{{ csrf_field() }}
<div class="row animate-in">
    <!-- Information Column -->
    <div class="col-lg-4">
        <div class="iq-card card-modern">
            <div class="iq-card-header d-flex justify-content-between border-bottom-0">
                <div class="iq-header-title">
                    <h4 class="card-title"><i class="ri-information-line mr-2"></i>Informasi Import</h4>
                </div>
            </div>
            <div class="iq-card-body pt-0">
                <div class="summary-card info">
                    <span class="summary-label">Format Pendukung</span>
                    <span class="summary-val" style="font-size: 0.95rem;">Excel (.xlsx) / CSV</span>
                </div>
                <div class="mt-3 p-3 bg-light rounded shadow-sm" style="font-size: 0.85rem; border-left: 3px solid var(--primary-color);">
                    <p class="mb-0 text-dark">Pastikan data sesuai dengan template. ID Karyawan, Bulan, dan Tahun wajib diisi dengan benar.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Process Column -->
    <div class="col-lg-8">
        <div class="iq-card card-modern" id="upload-card">
            <div class="iq-card-header d-flex justify-content-between border-bottom-0">
                <div class="iq-header-title">
                    <h4 class="card-title"><i class="ri-upload-cloud-2-line mr-2"></i>Proses Import</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <!-- Modern Drag & Drop Zone -->
                <div class="upload-container" id="drop-zone">
                    <div class="upload-icon">
                        <i class="ri-file-excel-2-line"></i>
                    </div>
                    <div class="upload-text">
                        <h5>Pilih File atau Tarik ke Sini</h5>
                        <p class="text-muted">Klik untuk browsing file dari komputer Anda (Maks. 10MB)</p>
                    </div>
                    <input type="file" name="file_imp" id="file_imp" onchange="handleFileSelect(this)" required />
                </div>

                <div id="file-info" class="mt-2 text-center animate-in" style="display: none;">
                    <span class="badge badge-soft-primary p-2">
                        <i class="ri-attachment-line mr-1"></i> <span id="selected-file-name">filename.xlsx</span>
                    </span>
                </div>

                <!-- Action Button for traditional upload (hidden if preview is active) -->
                <div id="traditional-submit-container" class="mt-3 text-right">
                    <button type="submit" class="btn btn-primary shadow-sm px-4" name="tbl_import" id="tbl_import">
                        <i class="ri-rocket-line mr-1"></i> Mulai Import
                    </button>
                </div>

                <!-- Preview Container (Initially Hidden) -->
                <div id="preview-container" style="display: none;" class="animate-in">
                    <hr class="my-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="font-weight-bold text-dark m-0">Ringkasan Validasi</h5>
                        <span class="badge badge-pill badge-soft-info px-3 py-2" id="preview-status-badge">Menunggu Konfirmasi</span>
                    </div>

                    <!-- Modern Validation Summary Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3 col-6">
                            <div class="summary-card">
                                <span class="summary-label text-secondary">Total Baris</span>
                                <span class="summary-val" id="total-rows">0</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="summary-card valid">
                                <span class="summary-label text-success">Valid</span>
                                <span class="summary-val text-success" id="valid-rows">0</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="summary-card error">
                                <span class="summary-label text-danger">Error</span>
                                <span class="summary-val text-danger" id="error-rows">0</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="summary-card warning">
                                <span class="summary-label text-warning">Warning</span>
                                <span class="summary-val text-warning" id="warning-rows">0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Premium Preview Table -->
                    <div class="table-responsive shadow-sm">
                        <table class="table table-hover mb-0" id="preview-table">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 80px;">Status</th>
                                    <th>ID Karyawan</th>
                                    <th>Bulan</th>
                                    <th>Tahun</th>
                                    <th>NIK</th>
                                    <th>Nama Karyawan</th>
                                    <th>Posisi</th>
                                    <th>ID Dept</th>
                                    <th>Departemen</th>
                                    <th>THP</th>
                                    <!-- Add more columns if needed, keeping it concise -->
                                </tr>
                            </thead>
                            <tbody id="preview-table-body">
                                <!-- Dynamic rows -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Modern Pagination Controls -->
                    <div id="pagination-controls" class="pagination-container rounded-bottom">
                        <div class="text-muted" style="font-size: 0.8rem;">
                            Menampilkan <span id="page-start" class="font-weight-bold">0</span> - <span id="page-end" class="font-weight-bold">0</span> dari <span id="page-total" class="font-weight-bold">0</span> baris
                        </div>
                        <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-outline-primary btn-sm btn-circle mr-2" id="prev-page" disabled>
                                <i class="ri-arrow-left-s-line"></i>
                            </button>
                            <span class="mx-2 text-dark font-weight-bold" style="font-size: 0.85rem;">
                                Hal <span id="current-page">1</span> / <span id="total-pages">1</span>
                            </span>
                            <button type="button" class="btn btn-outline-primary btn-sm btn-circle ml-2" id="next-page" disabled>
                                <i class="ri-arrow-right-s-line"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Modern Action Buttons -->
                    <div class="mt-4 d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary mr-3" id="cancel-preview-btn">
                            <i class="ri-refresh-line mr-1"></i> Ganti File
                        </button>
                        <button type="button" class="btn btn-success px-5 shadow-sm" id="confirm-import-btn" disabled>
                            <i class="ri-checkbox-circle-line mr-1"></i> Konfirmasi & Simpan
                        </button>
                    </div>
                </div>
                </div>

                <!-- Loading Indicator Overlay (Modern) -->
                <div id="loading-overlay" class="loading-overlay">
                    <div class="text-center">
                        <div class="premium-loader mx-auto"></div>
                        <p class="mt-3 font-weight-bold text-primary">Memproses Data...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<style>
    :root {
        --primary-color: #4e73df;
        --success-color: #1cc88a;
        --warning-color: #f6c23e;
        --danger-color: #e74a3b;
        --info-color: #36b9cc;
        --card-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        --border-radius: 12px;
    }

    /* Container & Card Improvements */
    .iq-card {
        border-radius: var(--border-radius) !important;
        border: none !important;
        box-shadow: var(--card-shadow) !important;
        background: #fff;
        transition: all 0.3s ease;
    }

    .iq-header-title h4 {
        font-weight: 800;
        color: var(--primary-color);
        letter-spacing: 0.5px;
    }

    /* Modern Upload Zone */
    .upload-container {
        position: relative;
        background: #fdfdfd;
        border: 2px dashed #d1d3e2;
        border-radius: 16px;
        padding: 40px 20px;
        text-align: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        margin-bottom: 20px;
    }

    .upload-container:hover, .upload-container.dragover {
        border-color: var(--primary-color);
        background: rgba(78, 115, 223, 0.04);
        transform: translateY(-2px);
    }

    .upload-icon {
        font-size: 48px;
        color: #d1d3e2;
        margin-bottom: 15px;
        transition: color 0.3s ease;
    }

    .upload-container:hover .upload-icon {
        color: var(--primary-color);
    }

    #file_imp {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
        z-index: 2;
    }

    /* Summary Cards (Modern Badges) */
    .summary-card {
        border-left: 4px solid #e3e6f0;
        border-radius: 10px;
        padding: 15px;
        background: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        margin-bottom: 15px;
        transition: transform 0.2s ease;
    }

    .summary-card:hover { transform: translateX(5px); }
    .summary-card.valid { border-left-color: var(--success-color); }
    .summary-card.error { border-left-color: var(--danger-color); }
    .summary-card.warning { border-left-color: var(--warning-color); }

    .summary-val { font-size: 20px; font-weight: 800; color: #5a5c69; display: block; }
    .summary-label { font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: #858796; }

    /* Premium Table */
    .table-responsive {
        max-height: 500px;
        overflow-y: auto;
        border-radius: 8px;
        border: 1px solid #e3e6f0;
    }

    .table thead th {
        background-color: #f8f9fc;
        color: var(--primary-color);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.05em;
        border-bottom: 2px solid #e3e6f0;
        position: sticky;
        top: 0;
        z-index: 10;
        padding: 12px 15px;
    }

    .table td {
        padding: 10px 15px;
        vertical-align: middle;
        font-size: 0.8rem;
        white-space: nowrap;
    }

    /* Status Dot Indicators */
    .status-dot {
        height: 8px;
        width: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 10px;
    }
    .dot-valid { background-color: var(--success-color); box-shadow: 0 0 5px rgba(28, 200, 138, 0.4); }
    .dot-error { background-color: var(--danger-color); box-shadow: 0 0 5px rgba(231, 74, 59, 0.4); }
    .dot-warning { background-color: var(--warning-color); box-shadow: 0 0 5px rgba(246, 194, 62, 0.4); }

    /* Tooltip & Animations */
    .premium-loader {
        width: 40px;
        height: 40px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid var(--primary-color);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.9);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        backdrop-filter: blur(4px);
    }

    /* Tooltip */
    .tooltip-message { position: relative; display: inline-block; cursor: help; }
    .tooltip-message .tooltiptext {
        visibility: hidden; width: 180px; background-color: #333; color: #fff;
        text-align: left; border-radius: 4px; padding: 6px 10px; position: absolute;
        z-index: 100; bottom: 125%; left: 50%; margin-left: -90px; opacity: 0;
        transition: opacity 0.3s; font-size: 11px; box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }
    .tooltip-message:hover .tooltiptext { visibility: visible; opacity: 1; }

    /* Button Styling */
    .btn { border-radius: 8px; font-weight: 600; padding: 8px 16px; transition: all 0.2s ease; }
    .btn:hover { transform: translateY(-1px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
</style>

<script>
    $(document).ready(function() {
        // Initialize Select2 if needed
        if($.fn.select2) {
            $(".select2").select2({ placeholder: "Search Departemen" });
        }

        // Drag & Drop Functionality
        var dropZone = $('#drop-zone');
        var fileInput = $('#file_imp');

        dropZone.on('dragover dragenter', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).addClass('dragover');
        });

        dropZone.on('dragleave drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('dragover');
        });

        dropZone.on('drop', function(e) {
            var files = e.originalEvent.dataTransfer.files;
            if (files.length > 0) {
                fileInput[0].files = files;
                handleFileSelect(fileInput[0]);
            }
        });

        // Traditional Button Click for Upload (if file is already selected)
        $('#tbl_import').on('click', function(e) {
            if (fileInput[0].files.length > 0) {
                e.preventDefault();
                handleFileSelect(fileInput[0]);
            }
        });

        // Action Buttons
        $('#confirm-import-btn').on('click', function() { confirmImport(); });
        $('#cancel-preview-btn').on('click', function() { cancelPreview(); });
        
        // Pagination
        $('#prev-page').on('click', function() {
            if (currentPage > 1) { currentPage--; renderPreviewTable(previewData, false); }
        });
        $('#next-page').on('click', function() {
            var totalPages = Math.ceil(previewData.rows.length / rowsPerPage);
            if (currentPage < totalPages) { currentPage++; renderPreviewTable(previewData, false); }
        });
    });

    /**
     * Handle File Selection
     */
    function handleFileSelect(input) {
        var file = input.files[0];
        if (!file) return;

        // Basic validation
        var ext = file.name.split('.').pop().toLowerCase();
        if (['xlsx', 'csv'].indexOf(ext) === -1) {
            Swal.fire('Format Salah', 'Hanya mendukung file .xlsx atau .csv', 'error');
            input.value = '';
            return;
        }

        // UI Update
        $('#selected-file-name').text(file.name);
        $('#file-info').fadeIn();
        $('#traditional-submit-container').fadeOut();

        // AJAX Preview
        var formData = new FormData();
        formData.append('file_imp', file);
        formData.append('_token', '{{ csrf_token() }}');
        
        requestPreview(formData);
    }

    /**
     * requestPreview
     */
    function requestPreview(formData) {
        $('#loading-overlay').css('display', 'flex').hide().fadeIn(200);

        $.ajax({
            url: '{{ url("hrd/penggajian/previewImportPeriodePenggajian") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#loading-overlay').fadeOut(200);
                if (response.success) {
                    renderPreviewTable(response.data);
                    renderValidationSummary(response.data.summary);
                    $('#preview-container').slideDown(400);
                    $('#upload-card').css('opacity', '0.7');
                } else {
                    Swal.fire('Gagal', response.message || 'Gagal memproses file.', 'error');
                }
            },
            error: function(xhr) {
                $('#loading-overlay').fadeOut(200);
                var msg = xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan sistem.';
                Swal.fire('Error', msg, 'error');
            }
        });
    }

    var previewData = null;
    var currentPage = 1;
    var rowsPerPage = 50;

    /**
     * renderPreviewTable
     */
    function renderPreviewTable(data, resetPage = true) {
        previewData = data;
        if (resetPage) currentPage = 1;

        $('#preview-table-body').empty();

        var totalRows = data.rows.length;
        var totalPages = Math.ceil(totalRows / rowsPerPage);
        var startIndex = (currentPage - 1) * rowsPerPage;
        var endIndex = Math.min(startIndex + rowsPerPage, totalRows);

        for (var i = startIndex; i < endIndex; i++) {
            var row = data.rows[i];
            var validation = data.validation[i];
            var tr = $('<tr></tr>');

            // Status Indicator
            var dotClass = 'dot-valid';
            var tooltip = 'Valid';
            if (validation.status === 'error') {
                dotClass = 'dot-error';
                tooltip = validation.messages.join(', ');
            } else if (validation.status === 'warning') {
                dotClass = 'dot-warning';
                tooltip = validation.messages.join(', ');
            }

            var statusHtml = '<div class="tooltip-message"><div class="status-dot '+dotClass+'"></div>' +
                             '<span class="tooltiptext">' + tooltip + '</span></div>';
            
            tr.append('<td class="text-center">' + statusHtml + '</td>');
            tr.append('<td>' + (row.id_karyawan || '-') + '</td>');
            tr.append('<td>' + (row.bulan || '-') + '</td>');
            tr.append('<td>' + (row.tahun || '-') + '</td>');
            tr.append('<td>' + (row.nik || '-') + '</td>');
            tr.append('<td><span class="font-weight-bold">' + (row.nama_karyawan || '-') + '</span></td>');
            tr.append('<td>' + (row.posisi || '-') + '</td>');
            tr.append('<td>' + (row.id_departemen || '-') + '</td>');
            tr.append('<td>' + (row.departemen || '-') + '</td>');

            // Format THP Currency
            var formattedThp = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(row.thp || 0);
            tr.append('<td class="text-right text-primary font-weight-bold">' + formattedThp + '</td>');

            $('#preview-table-body').append(tr);
        }

        // Update UI info
        $('#page-start').text(startIndex + 1);
        $('#page-end').text(endIndex);
        $('#page-total').text(totalRows);
        $('#current-page').text(currentPage);
        $('#total-pages').text(totalPages);
        $('#prev-page').prop('disabled', currentPage <= 1);
        $('#next-page').prop('disabled', currentPage >= totalPages);
    }

    /**
     * renderValidationSummary
     */
    function renderValidationSummary(summary) {
        $('#total-rows').text(summary.total_rows);
        $('#valid-rows').text(summary.valid_rows);
        $('#error-rows').text(summary.error_rows);
        $('#warning-rows').text(summary.warning_rows);

        var statusBadge = $('#preview-status-badge');
        statusBadge.removeClass('badge-soft-info badge-soft-success badge-soft-danger badge-soft-warning');

        if (summary.error_rows > 0) {
            statusBadge.addClass('badge-soft-danger').text('Ditemukan Kesalahan');
            $('#confirm-import-btn').prop('disabled', true).addClass('btn-secondary').removeClass('btn-success');
        } else if (summary.warning_rows > 0) {
            statusBadge.addClass('badge-soft-warning').text('Ready dengan Peringatan');
            $('#confirm-import-btn').prop('disabled', false).addClass('btn-success').removeClass('btn-secondary');
        } else {
            statusBadge.addClass('badge-soft-success').text('Data Siap Diimport');
            $('#confirm-import-btn').prop('disabled', false).addClass('btn-success').removeClass('btn-secondary');
        }
    }

    /**
     * confirmImport
     */
    function confirmImport() {
        Swal.fire({
            title: 'Konfirmasi Import',
            text: "Apakah Anda yakin ingin menyimpan data yang valid ke database?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1cc88a',
            cancelButtonColor: '#858796',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#loading-overlay').css('display', 'flex').fadeIn(200);
                $.ajax({
                    url: '{{ url("hrd/penggajian/confirmImportPeriodePenggajian") }}',
                    type: 'POST',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        $('#loading-overlay').fadeOut(200);
                        if (response.success) {
                            Swal.fire('Berhasil!', response.data.imported_rows + ' baris data berhasil diimport.', 'success')
                                .then(() => { location.reload(); });
                        } else {
                            Swal.fire('Gagal', response.message || 'Proses simpan gagal.', 'error');
                        }
                    },
                    error: function() {
                        $('#loading-overlay').fadeOut(200);
                        Swal.fire('Error', 'Terjadi kesalahan sistem saat menyimpan data.', 'error');
                    }
                });
            }
        });
    }

    /**
     * cancelPreview
     */
    function cancelPreview() {
        $('#preview-container').slideUp(300);
        $('#upload-card').css('opacity', '1');
        $('#file-info').fadeOut();
        $('#traditional-submit-container').fadeIn();
        $('#file_imp').val('');
        
        // Notify backend cleanup
        $.ajax({ url: '{{ url("hrd/penggajian/cancelImportPreview") }}', type: 'POST', data: { _token: '{{ csrf_token() }}' } });
    }
</script>
</script>
@stop
