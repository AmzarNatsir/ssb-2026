@extends('Tender.layouts.master')
@include('Tender.project.partials.preanalyst_modal')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="navbar-breadcrumb">
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Project Management</li>
                    <li class="breadcrumb-item active" aria-current="page">Project</li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<div class="iq-card">
    <div class="iq-card-body" style="padding:1.5rem 3rem;">
        <div class="row">
            <div class="col-sm-8">
                <h4 class="card-title text-primary">
                    <span class="ri-chat-check-line pr-2"></span>Pre Analyst, Scoring & Rekomendasi Project
                </h4>
            </div>
        </div>
        {{-- Toast --}}
        <div id="snackbar" class="alert text-white d-none {{ (\Session::has('danger') ? 'bg-danger' : 'bg-success') }}" role="alert" style="position:absolute;top:5%;right:25;z-index:2000;">
            <div id="snackbar_message" class="iq-alert-text">
                @if (\Session::has('danger'))
                {{ trim(\Session::get('danger')) }}
                @elseif(\Session::has('success'))
                {{ trim(\Session::get('success')) }}
                @endif
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="ri-close-line"></i>
            </button>
        </div>

        {{-- Filter options --}}
        <div class="row mt-4 mb-4 d-flex justify-content-center border-bottom">
            <form id="filter-project-form" name="filter-project-form" method="POST" enctype="multipart/form-data" autocomplete="off" action="{{ route('Project.preanalyst.loadDataTable') }}">
                @csrf

                <div class="form-row">
                    <div class="form-group pr-2">
                        <label>Filter berdasarkan<span class="ri-information-line pl-1" data-toggle="tooltip" title="filter project berdasarkan status rekomendasi"></span></label>
                        <select id="opsiStatus" name="opsiStatus" class="form-control" style="border-right: 10px transparent solid;border-bottom: 15px;">
                            <option value="0">Belum ada rekomendasi</option>
                            <option value="1">Sudah ada rekomendasi</option>
                        </select>
                    </div>

                    <div class="form-group pr-2">
                        <label>Tanggal awal<span class="ri-information-line pl-1" data-toggle="tooltip" title="filter project berdasarkan tanggal registrasi"></span></label>
                        <input class="form-control form-control-sm pl-3" id="startDate" name="startDate" type="date" />
                    </div>

                    <div class="form-group pr-2">
                        <label>Tanggal akhir<span class="ri-information-line pl-1" data-toggle="tooltip" title="filter project berdasarkan tanggal registrasi"></span></label>
                        <input class="form-control form-control-sm pl-3" id="endDate" name="endDate" type="date" />
                    </div>

                    <div class="form-group pr-2">
                        <label>&nbsp;</label>
                        <button id="btn-filter-project" type="button" class="btn btn-lg btn-block btn-primary px-6 position-relative" style="height:45px;">
                            <i class="ri-filter-line pr-1"></i><strong>Filter</strong>
                            <span class="badge bg-light ml-2 position-absolute top-0 start-100 rounded-circle text-dark translate-middle d-none">4</span>
                        </button>
                    </div>
                </div>

            </form>
        </div>
        {{-- End --}}

        {{-- show when user checking the row --}}
        <div class="row">

            <div id="action-tags" class="col-md-3 text-center d-flex align-items-center justify-content-start d-none">
                @hasrole('project_manager')
                <button id="action-tag-submit-preanalyst" data-id="" type="button" class="tag tag-primary mr-2" style="border: solid 1px #3490dc;" data-toggle="modal" data-target="#preAnalystModal">
                    <i class="ri-edit-box-fill h5"></i>
                </button>

                <button id="action-tag-view-preanalyst" data-id="" type="button" class="tag tag-primary mr-2" style="border: solid 1px #3490dc;" data-toggle="modal" data-target="#viewPreAnalystModal">
                    <i class="ri-eye-line h5"></i>
                </button>

                @endhasrole
            </div>


            <div class="flex-grow-1"></div>

            <div class="col-md-3">
                <div class="form-group">
                    <input id="searchFilter" name="searchFilter" class="form-control form-control-sm pl-3" type="text" placeholder="Filter" />
                </div>
            </div>

        </div>

        <div class="row mt-2">
            <div class="col-12">
                <table id="table-preanalyst-approval" class="table table-data nowrap w-100">
                    <thead>
                        <tr class="tr-shadow">
                            <th></th>
                            <th>Nama project</th>
                            <th>Sumber tender</th>
                            <th>Nilai project</th>
                            <th>Tgl Registrasi Project</th>
                            <th>Lokasi</th>
                            <th>Rekomendasi</th>
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
<script src="{{ asset('js/tender/pre-analyst-approval.js') }}"></script>
<script type="text/javascript">
    var loadPreAnalystApprovalUrl = "{{ route('Project.preanalyst.loadDataTable') }}"
        , submitPreanalystUrl = "{{ route('preanalyst.create') }}"
        , selectedRow;

</script>
