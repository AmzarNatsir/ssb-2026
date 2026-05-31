@extends('HRD.layouts.master')
@section('content')
<style>
    :root {
        --primary-color: #4e73df;
        --success-color: #1cc88a;
        --warning-color: #f6c23e;
        --danger-color: #e74a3b;
        --surface: #ffffff;
        --line: #e8edf5;
        --muted: #64748b;
        --shadow-soft: 0 8px 24px rgba(2, 6, 23, 0.06);
    }

    .period-summary-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fc 100%);
        border: 1px solid var(--line);
        border-radius: 16px;
        box-shadow: var(--shadow-soft);
        margin-bottom: 20px;
    }

    .period-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 2px;
    }

    .period-subtitle {
        color: var(--muted);
        font-size: 0.85rem;
    }

    .badge-soft-primary { background: #eef2ff; color: #4e73df; }
    .badge-soft-success { background: #e7f9f3; color: #1cc88a; }
    .badge-soft-warning { background: #fffbf0; color: #f6c23e; }
    .badge-soft-danger { background: #fdf2f2; color: #e74a3b; }

    .status-badge {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    .spinner-div {
    position: absolute;
    display: none;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    text-align: center;
    background-color: rgba(255, 255, 255, 0.8);
    z-index: 2;
    }

    .collapsible-link {
        width: 100%;
        position: relative;
        text-align: left;
        padding-right: 28px;
    }

    .accordion-section-header {
        background: #edf2f7;
        border-radius: 8px;
    }

    .accordion-section-header .section-title {
        font-weight: 700;
        color: #1f2937;
    }

    .section-body {
        border: 1px solid var(--line);
        border-top: 0;
    }

    .action-stack {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .table-shell {
        border: 1px solid var(--line);
        border-radius: 10px;
        overflow: hidden;
    }

    .table-shell thead th {
        background: #f8fafc;
        border-bottom: 1px solid var(--line);
        font-size: 12px;
        letter-spacing: 0.2px;
    }

    .collapsible-link::before {
    content: "\f107";
    position: absolute;
    top: 50%;
    right: 0.8rem;
    transform: translateY(-50%);
    display: block;
    font-family: "FontAwesome";
    font-size: 1.1rem;
    }

    .collapsible-link[aria-expanded="true"]::before {
    content: "\f106";
    }

    @media (max-width: 768px) {
        .period-summary-card .text-md-right {
            text-align: left !important;
        }
    }
</style>
<input type="hidden" name="periode_bulan" id="periode_bulan" value="{{ $periode->bulan }}">
<input type="hidden" name="periode_tahun" id="periode_tahun" value="{{ $periode->tahun }}">
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/penggajian') }}">Periode Penggajian</a></li>
        <li class="breadcrumb-item active" aria-current="page">Penggajian Karyawan</li>
        </ul>
    </nav>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="period-summary-card p-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                <div>
                    <div class="period-title">Detail Penggajian Periode {{ \App\Helpers\Hrdhelper::get_nama_bulan($periode->bulan) }} {{ $periode->tahun }}</div>
                    <div class="period-subtitle">Review data penggajian per departemen sebelum pengajuan persetujuan.</div>
                </div>
                <div class="mt-3 mt-md-0 text-md-right">
                    @if($periode->is_draft==1 && empty($periode->status_pengajuan))
                        <span class="status-badge badge-soft-primary"><i class="ri-edit-line mr-1"></i> DRAFT MODE</span>
                    @elseif($periode->status_pengajuan==1)
                        <span class="status-badge badge-soft-warning"><i class="ri-time-line mr-1"></i> PENDING APPROVAL</span>
                    @elseif($periode->status_pengajuan==2)
                        <span class="status-badge badge-soft-success"><i class="ri-checkbox-circle-line mr-1"></i> APPROVED</span>
                    @else
                        <span class="status-badge badge-soft-danger"><i class="ri-close-circle-line mr-1"></i> REJECTED</span>
                    @endif
                </div>
            </div>
            <div class="action-stack mt-3">
                <a href="{{ url('hrd/penggajian') }}" class="btn btn-light">
                    <i class="ri-arrow-left-line mr-1"></i> Kembali ke Dashboard
                </a>
                @if($periode->is_draft==1 && empty($periode->status_pengajuan))
                    <a href="{{ url('hrd/penggajian/submitPenggajian/'.$periode->bulan.'/'.$periode->tahun.'/'.$periode->approval_key) }}" class="btn btn-warning font-weight-bold">
                        <i class="ri-send-plane-line mr-1"></i> Submit for Review
                    </a>
                @endif
            </div>
        </div>
    </div>
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
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="iq-card">
            <div class="iq-card-body">
                <div id="accordionExample" class="accordion shadow">
                    <div class="card mb-1">
                        <div id="headingOne" class="card-header shadow-sm border-0 accordion-section-header">
                            <h2 class="mb-0">
                            <button type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                aria-controls="collapseOne"
                                class="btn btn-link text-dark text-uppercase collapsible-link">
                                <span class="section-title">Non Departemen</span>
                            </button>
                            </h2>
                        </div>
                        <div id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionExample" class="collapse show">
                            <div class="card-body p-3 section-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="todo-date d-flex mr-3">
                                        <i class="ri-calendar-2-line text-success mr-2"></i>
                                        <span>Daftar Gaji Karyawan</span>
                                    </div>
                                    <div class="action-stack">
                                        @if($periode->is_draft==1 && empty($periode->status_pengajuan))
                                        <button type="button" class="btn btn-primary" onclick="goPengaturan(this)" value="0"><i class="ri-edit-line mr-2"></i> Atur Penggajian</button>&nbsp;
                                        {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalFormPeriode"><i class="ri-edit-line mr-2"></i> Atur Penggajian</button>&nbsp; --}}
                                        @endif
                                        <button type="button" class="btn btn-success" onclick="getData(this)" value="0"><i class="ri-table-line mr-2"></i> Tampilkan Data</button>
                                    </div>
                                </div>
                                <hr>
                                <div class="table-shell">
                                    <table id="listPayroll-0" class="table table-hover table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info" style="width: 100%; font-size: 13px">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="text-align: center; width: 4%;">No</th>
                                                <th scope="col" style="width: 20%; text-align: center">Karyawan</th>
                                                <th scope="col" style="width: 20%; text-align: center">Posisi</th>
                                                <th scope="col" style="width: 10%; text-align: center">Status</th>
                                                <th scope="col" style="text-align: center; width: 10%">Gaji Pokok</th>
                                                <th scope="col" style="text-align: center; width: 11%">Tunjangan</th>
                                                <th scope="col" style="text-align: center; width: 11%">Gaji Bruto</th>
                                                <th scope="col" style="text-align: center; width: 11%">Potongan</th>
                                                <th scope="col" style="text-align: center; width: 10%">THP</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><!-- End -->
                    @foreach ($departemen as $dept)
                    <div class="card mb-1">
                        <div id="heading{{ $dept->id }}" class="card-header shadow-sm border-0 accordion-section-header">
                            <h2 class="mb-0">
                            <button type="button" data-toggle="collapse" data-target="#collapse{{ $dept->id }}" aria-expanded="true"
                                aria-controls="collapse{{ $dept->id }}"
                                class="btn btn-link text-dark text-uppercase collapsible-link">
                                <span class="section-title">{{ $dept->nm_dept }}</span>
                            </button>
                            </h2>
                        </div>
                        <div id="collapse{{ $dept->id }}" aria-labelledby="heading{{ $dept->id }}" data-parent="#accordionExample" class="collapse">
                            <div class="card-body p-3 section-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="todo-date d-flex mr-3">
                                        <i class="ri-calendar-2-line text-success mr-2"></i>
                                        <span>Daftar Gaji Karyawan</span>
                                    </div>
                                    <div class="action-stack">
                                        @if($periode->is_draft==1 && empty($periode->status_pengajuan))
                                        <button type="button" class="btn btn-primary" onclick="goPengaturan(this)" value="{{ $dept->id }}"><i class="ri-edit-line mr-2"></i> Atur Penggajian</button>&nbsp;
                                        @endif
                                        <button type="button" class="btn btn-success" onclick="getData(this)" value="{{ $dept->id }}"><i class="ri-table-line mr-2"></i> Tampilkan Data</button>
                                    </div>
                                </div>
                                <hr>
                                <div class="table-shell">
                                    <table id="listPayroll-{{ $dept->id }}" class="table table-hover table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info" style="width: 100%; font-size: 13px">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="text-align: center; width: 4%;">No</th>
                                                <th scope="col" style="width: 20%; text-align: center">Karyawan</th>
                                                <th scope="col" style="width: 20%; text-align: center">Posisi</th>
                                                <th scope="col" style="width: 10%; text-align: center">Status</th>
                                                <th scope="col" style="text-align: center; width: 10%">Gaji Pokok</th>
                                                <th scope="col" style="text-align: center; width: 11%">Tunjangan</th>
                                                <th scope="col" style="text-align: center; width: 11%">Gaji Bruto</th>
                                                <th scope="col" style="text-align: center; width: 11%">Potongan</th>
                                                <th scope="col" style="text-align: center; width: 10%">THP</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><!-- End -->
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<div id="ModalFormDetail" class="modal fade bg-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-ml" role="document">
        <div class="modal-content" id="v_form"></div>
    </div>
 </div>
<script>
    var getData = function(el)
    {
        var bulan = $("#periode_bulan").val();
        var tahun = $("#periode_tahun").val();
        var id_dept = $(el).val();
        var table = $('#listPayroll-'+id_dept).DataTable();
        table.destroy();

        var tableAjax = new DataTable('#listPayroll-'+id_dept, {
            ajax: {
                url: "{{ url('hrd/penggajian/getDataPenggajian') }}",
                // type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: function (d)
                {
                    d.bulan = bulan;
                    d.tahun = tahun;
                    d.id_dept = id_dept;
                }
            },
            processing: true,
            serverSide: true,
            columns: [
                { data: 'no' },
                { data: 'karyawan' },
                { data: 'posisi' },
                { data: 'status' },
                { data: 'gapok' },
                { data: 'tunjangan' },
                { data: 'gaji_bruto' },
                { data: 'potongan' },
                { data: 'thp' }
            ],
            columnDefs: [
                {
                    targets: [0, 3],
                    className: "dt-center"
                },
                {
                    targets: [4, 5, 6, 7],
                    className: "dt-right"
                }
            ],
        });
    }
    var detailTunjangan = function(el)
    {
        var id_data = el.id
        var bulan = $("#periode_bulan").val();
        var tahun = $("#periode_tahun").val();
        $("#v_form").load("{{ url('hrd/penggajian/detailTunjangan/')}}/"+id_data+"/"+bulan+"/"+tahun, function(){
            $(".angka").number(true, 0);
        });
    }
    var detailPotongan = function(el)
    {
        var id_data = el.id;
        var bulan = $("#periode_bulan").val();
        var tahun = $("#periode_tahun").val();
        $("#v_form").load("{{ url('hrd/penggajian/detailPotongan/')}}/"+id_data+"/"+bulan+"/"+tahun, function(){
            $(".angka").number(true, 0);
        });
    }

    var goPengaturan = function(el)
    {
        var id_data = $(el).val();
        var bulan = $("#periode_bulan").val();
        var tahun = $("#periode_tahun").val();
        var link = document.createElement("a")
            link.href = "{{ url('hrd/penggajian/pengaturanPenggajian') }}/"+id_data+"/"+bulan+"/"+tahun
            link.target = "_blank"
            link.click()
    }
</script>
@endsection
