@extends('Tender.layouts.master')

{{-- Modal --}}
@include('Tender.project.partials.add_komite_modal',
[
'opsiDepartemen' => $opsiDepartemen,
'opsiJabatan' => $opsiJabatan,
'opsiKaryawan' => $opsiKaryawan
]
)

@include ('Tender.project.partials.approval_modal')

{{-- End Modal --}}

@section('content')
{{-- Breadcrumbs --}}
<div class="row">
    <div class="col-lg-12">
        <div class="navbar-breadcrumb">
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Project Management</li>
                    <li class="breadcrumb-item active" aria-current="page">Project Approval</li>
                </ul>
            </nav>
        </div>
    </div>
</div>
{{-- Page --}}
<div class="iq-card">
    <div class="iq-card-body" style="padding:1.5rem 3rem;">
        <div class="row">
            <div class="col-sm-8">
                <h4 class="card-title text-primary">
                    <span class="ri-chat-check-line pr-2"></span>Project Approval
                </h4>
            </div>
        </div>
        {{-- Toast --}}
        <x-tender.common.toast />

        <div class="row mt-4 mb-4 d-flex justify-content-center border-bottom">
            <form id="filter-approval-form" name="filter-approval-form" method="POST" enctype="multipart/form-data" autocomplete="off" action="{{ route('Approval.loadApprovalDataTable') }}">
                @csrf
                <div class="form-row">

                    <div class="form-group pr-2">
                        <label>Tanggal awal</label>
                        <input class="form-control form-control-sm pl-3" id="startDate" name="startDate" type="date" />
                    </div>

                    <div class="form-group pr-2">
                        <label>Tanggal akhir</label>
                        <input class="form-control form-control-sm pl-3" id="endDate" name="endDate" type="date" />
                    </div>

                    <div class="form-group pr-2">
                        <label>&nbsp;</label>
                        <button id="btn-filter-project" type="button" class="btn btn-lg btn-block btn-primary px-6" style="height:45px;">
                            <i class="ri-filter-line pr-1"></i><strong>Filter</strong>
                        </button>
                    </div>
                </div>

            </form>
        </div>

        <div class="row">
            {{-- Action Tags --}}
            <div id="project-approve-tags" class="col-md-3 text-center d-flex d-none">

                <button id="action-tag-approve-project" type="button" class="tag tag-primary mr-2" style="border: solid 1px #3490dc;" data-toggle="modal" data-target="#projectApprovalModal">
                    <i class="ri-file-paper-line"></i>
                </button>

                <button id="action-tag-cetak-approval" class="tag tag-primary mr-2" style="cursor:pointer;border: solid 1px #3490dc;" target="_blank">
                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                </button>

            </div>
            <div class="flex-grow-1"></div>
            {{-- Search/Filter --}}
            <div class="col-md-3">
                <div class="form-group">
                    <input id="searchFilter" name="searchFilter" class="form-control form-control-sm pl-3" type="text" placeholder="Filter" />
                </div>
            </div>
        </div>

        {{-- Tabel --}}

        <div class="row mt-2">
            <div class="col-12">
                <table id="table-approval" class="table table-data nowrap w-100">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nama Project</th>
                            <th>Tgl Project</th>
                            <th>Disurvey Oleh</th>
                            <th>Tgl Selesai Survey</th>
                            <th>Project Manager</th>
                            <th>Manager Operasional</th>
                            <th>Direktur</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('js/tender/approval.js') }}"></script>
<script type="text/javascript">
    var selectedRow
        , updateOrderUrl = "{{ url('/project/komite/order') }}"
        , loadApprovalTableUrl = "{{ route('Approval.loadApprovalDataTable') }}"
        , cetakPDFUrl = "{{ route('Approval.cetak', ['projectId' => ':projectId' ]) }}";

</script>
