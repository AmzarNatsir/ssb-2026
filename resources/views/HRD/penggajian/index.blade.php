@extends('HRD.layouts.master')
@section('content')
<style>
    :root {
        --primary-color: #4e73df;
        --success-color: #1cc88a;
        --info-color: #36b9cc;
        --warning-color: #f6c23e;
        --danger-color: #e74a3b;
        --bg-glass: rgba(255, 255, 255, 0.95);
        --border-glass: rgba(255, 255, 255, 0.3);
        --shadow-subtle: 0 8px 30px rgba(0, 0, 0, 0.05);
    }

    .payroll-header {
        background: linear-gradient(135deg, white 0%, #f8f9fc 100%);
        border-radius: 20px;
        border: 1px solid var(--border-glass);
        box-shadow: var(--shadow-subtle);
        margin-bottom: 30px;
        animation: fadeInDown 0.6s ease-out;
    }

    .card-payroll-modern {
        background: var(--bg-glass);
        backdrop-filter: blur(10px);
        border-radius: 18px;
        border: 1px solid var(--border-glass);
        box-shadow: var(--shadow-subtle);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        margin-bottom: 24px;
        overflow: hidden;
        animation: fadeInUp 0.5s ease-out backwards;
    }

    .card-payroll-modern:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        border-color: var(--primary-color);
    }

    /* Status Badges - Soft Style */
    .badge-soft-primary { background: #eef2ff; color: #4e73df; }
    .badge-soft-success { background: #e7f9f3; color: #1cc88a; }
    .badge-soft-danger { background: #fdf2f2; color: #e74a3b; }
    .badge-soft-warning { background: #fffbf0; color: #f6c23e; }
    
    .badge-modern {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        letter-spacing: 0.3px;
        font-size: 0.75rem;
    }

    .period-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #2e384d;
        margin-bottom: 4px;
    }

    .period-year {
        font-size: 0.85rem;
        color: #b0b8c1;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .approver-tag {
        font-size: 0.8rem;
        color: #64748b;
        display: flex;
        align-items: center;
        margin-top: 12px;
    }

    .approver-tag i { font-size: 1rem; margin-right: 6px; color: #94a3b8; }

    .action-btn-modern {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f5f9;
        color: #475569;
        border: none;
        transition: all 0.2s;
    }

    .action-btn-modern:hover {
        background: #e2e8f0;
        color: var(--primary-color);
    }

    .btn-add-modern {
        border-radius: 12px;
        padding: 10px 24px;
        font-weight: 700;
        box-shadow: 0 4px 15px rgba(28, 200, 138, 0.3);
        transition: all 0.3s;
    }

    .btn-add-modern:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(28, 200, 138, 0.4);
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Modal Styling */
    .modal-content-modern {
        border-radius: 24px;
        border: none;
        overflow: hidden;
    }
    .modal-header-modern {
        background: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
        padding: 24px;
    }
</style>

<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
            <li class="breadcrumb-item active">Penggajian</li>
            <li class="breadcrumb-item"><a href="{{ url('hrd/penggajian') }}" class="text-primary font-weight-bold ml-2">Reload Page</a></li>
        </ul>
    </nav>
</div>

<!-- Alert Section -->
@if(\Session::has('konfirm'))
<div class="alert badge-soft-success border-0 alert-dismissible fade show mb-4 animated fadeIn" role="alert">
    <strong>Success!</strong> {{ \Session::get('konfirm') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<!-- Header Section -->
<div class="payroll-header p-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2 class="font-weight-bold text-dark mb-1">Payroll Dashboard</h2>
            <p class="text-muted mb-0">Manage and monitor employee payroll periods for {{ date("Y") }}.</p>
        </div>
        <div class="col-md-6 text-md-right mt-3 mt-md-0">
            <button type="button" class="btn btn-success btn-add-modern px-4" data-toggle="modal" data-target="#ModalFormPeriode">
                <i class="ri-add-line mr-2"></i>Tambah Periode
            </button>
        </div>
    </div>
</div>

<!-- Grid List -->
<div class="row">
    @foreach ($PeriodePenggajian as $index => $item)
    <div class="col-sm-12 col-md-6 col-lg-4">
        <div class="card-payroll-modern p-4" style="animation-delay: {{ $index * 0.05 }}s">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <div class="period-year">Periode Laporan</div>
                    <div class="period-title">{{ \App\Helpers\Hrdhelper::get_nama_bulan($item->bulan) }} {{ $item->tahun }}</div>
                </div>
                <div class="dropdown">
                    <button class="action-btn-modern" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ri-more-2-line"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right shadow-sm border-0">
                        <a class="dropdown-item py-2" href="{{ url('hrd/penggajian/detailPeriodePenggajian/'.$item->id) }}">
                             <i class="ri-search-line mr-2 text-primary"></i> {{ ($item->is_draft==1 && empty($item->status_pengajuan)) ? "Pengaturan" : "Lihat Detail" }}
                        </a>
                        @if($item->is_draft==1 && empty($item->status_pengajuan))
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item py-2" href="{{ url('hrd/penggajian/downloadtemplatePeriodePenggajian/'.$item->tahun."/".$item->bulan) }}">
                                <i class="ri-download-cloud-line mr-2 text-success"></i> Download Template
                            </a>
                            <a class="dropdown-item py-2" href="{{ url('hrd/penggajian/importPeriodePenggajian') }}">
                                <i class="ri-upload-cloud-line mr-2 text-info"></i> Import Excel Data
                            </a>
                            <a class="dropdown-item py-2 font-weight-bold" href="{{ url('hrd/penggajian/submitPenggajian/'.$item->bulan.'/'.$item->tahun.'/'.$item->approval_key) }}">
                                <i class="ri-send-plane-line mr-2 text-warning"></i> Submit for Review
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="status-section">
                @if($item->is_draft==1 && empty($item->status_pengajuan))
                    <span class="badge-modern badge-soft-primary"><i class="ri-edit-line mr-1"></i> DRAFT MODE</span>
                @else
                    @if($item->status_pengajuan==1)
                        <span class="badge-modern badge-soft-warning mb-2 d-inline-block"><i class="ri-time-line mr-1"></i> PENDING APPROVAL</span>
                        <div class="approver-tag">
                            <i class="ri-shield-user-line"></i>
                            <span>{{ $item->get_current_approve->nm_lengkap }} ({{ $item->get_current_approve->get_jabatan->nm_jabatan }})</span>
                        </div>
                    @elseif($item->status_pengajuan==2)
                        <span class="badge-modern badge-soft-success"><i class="ri-checkbox-circle-line mr-1"></i> APPROVED</span>
                    @else
                        <span class="badge-modern badge-soft-danger"><i class="ri-close-circle-line mr-1"></i> REJECTED</span>
                    @endif
                @endif
            </div>

            <div class="mt-4 pt-3 border-top d-flex align-items-center justify-content-between">
                <a href="{{ url('hrd/penggajian/detailPeriodePenggajian/'.$item->id) }}" class="btn btn-link p-0 text-primary font-weight-bold">
                    View Records <i class="ri-arrow-right-line"></i>
                </a>
                <small class="text-muted"><i class="ri-calendar-event-line"></i> {{ date('d M Y', strtotime($item->created_at)) }}</small>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Modern Add Modal -->
<div id="ModalFormPeriode" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-modern shadow-lg">
            <div class="modal-header modal-header-modern align-items-center">
                <h5 class="modal-title font-weight-bold text-dark">
                    <i class="ri-add-circle-fill text-success mr-2"></i>Tambah Periode Baru
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="form_periode">
                @csrf
                <div class="modal-body p-4">
                    <div class="alert badge-soft-info border-0 mb-4" style="font-size: 0.85rem;">
                        <i class="ri-information-line mr-1"></i> Pilih bulan untuk membuat periode penggajian baru. Tahun akan otomatis diatur ke {{ date('Y') }}.
                    </div>
                    <div class="row gutter-sm">
                        <div class="col-sm-8">
                            <label class="font-weight-bold text-muted small text-uppercase">Bulan</label>
                            <select class="form-control form-control-lg custom-select border-0 shadow-none bg-light" name="pil_periode_bulan" id="pil_periode_bulan" style="height: 50px;">
                                @foreach($list_bulan as $key => $value)
                                    <option value="{{ $key }}" {{ $key == date('m') ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label class="font-weight-bold text-muted small text-uppercase">Tahun</label>
                            <input type="text" class="form-control form-control-lg border-0 bg-light-soft text-center" name="inp_periode_tahun" id="inp_periode_tahun" value="{{ date('Y') }}" readonly style="height: 50px; background: rgba(0,0,0,0.03);">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light px-4 font-weight-bold" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 btn-add-modern" id="btn-submit">Buat Periode</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // Success alert autohide
        setTimeout(function () { $("#success-alert").fadeOut(); }, 3000);

        // Handle Add Period Form Submission
        $('#form_periode').submit(function (e) {
            e.preventDefault();
            
            Swal.fire({
                title: "Konfirmasi Periode",
                text: "Apakah Anda yakin ingin membuat periode penggajian baru ini?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: '#4e73df',
                cancelButtonColor: '#858796',
                confirmButtonText: "Ya, Buat!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#btn-submit').prop('disabled', true).html('<i class="ri-loader-4-line ri-spin"></i> Processing...');
                    
                    $.ajax({
                        url: "{{ url('hrd/penggajian/simpanPeriodePenggajian') }}",
                        type: "POST",
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if (response.status) {
                                $('#ModalFormPeriode').modal('hide');
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: response.message,
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                $('#btn-submit').prop('disabled', false).html('Buat Periode');
                                Swal.fire('Gagal!', response.message, 'error');
                            }
                        },
                        error: function (xhr) {
                            $('#btn-submit').prop('disabled', false).html('Buat Periode');
                            Swal.fire('Oops!', 'Terjadi kesalahan sistem.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection

