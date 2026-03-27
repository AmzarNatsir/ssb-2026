@extends('Tender.layouts.master')
@include('Tender.survey.partials.survey_modal')
@include('Tender.survey.partials.add_location_modal')
@include('Tender.project.partials.delete_document_modal')
@section('content')
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="navbar-breadcrumb">
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Project</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Survey</li>
                </ul>
            </nav>
        </div>
        <div class="iq-card">
            <div class="iq-card-body" style="padding:1.5rem 3rem;">
                <div class="row">
                    <div class="col-sm-8">
                        <h4 class="card-title text-primary">
                            <span class="ri-file-shield-2-line pr-2"></span>Daftar Survey
                        </h4>
                    </div>
                    <div class="col-sm-4 text-right">
                        {{--
                  <button id="createSurveyBtn" type="button" class="btn btn-lg mb-3 btn-primary rounded-pill" data-toggle="modal" data-backdrop="static" data-target="#surveyFormModal">
                    <i class="ri-file-shield-2-line"></i>Create Survey
                  </button> --}}
                    </div>
                </div>
                {{-- Toast --}}
                {{-- <x-tender.common.toast /> --}}

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

                {{-- Filter Tanggal --}}
                <div class="row mt-4 mb-4 d-flex justify-content-center border-bottom">
                    <form id="filter-survey-form" name="filter-survey-form" method="POST" enctype="multipart/form-data" autocomplete="off" action="{{ route('Survey.loadDataTable') }}">
                        @csrf
                        <div class="form-row">
                            <div class="form-group pr-2">
                                <label>Filter berdasarkan</label>
                                <select id="dateOption" name="dateOption" class="form-control" style="border-right: 10px transparent solid;border-bottom: 15px;">
                                    <option value="1">Tanggal Assign</option>
                                    <option value="2">Tanggal Survey</option>
                                </select>
                            </div>

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
                                <button id="btn-filter-survey" type="button" class="btn btn-lg btn-block btn-primary px-6" style="height:45px;">
                                    <i class="ri-filter-line pr-1"></i><strong>Filter</strong>
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
                {{-- End Filter Tanggal --}}

                <div class="row">
                    <div id="action-tags" class="col-md-4 text-center d-flex align-items-center justify-content-start d-none">
                        {{-- @hasrole('project_survey')
                        <h5>yes</h5>
                        @else
                        <h5>no</h5>
                        @endhasrole --}}
                        {{-- {{ dd($currentUser->getRoleNames()) }} --}}

                        @hasrole('project_survey')

                        <button id="action-tag-create-survey" type="button" class="tag tag-primary mr-2" style="border: solid 1px #3490dc;" data-toggle="modal" data-target="#createSurveyModal">
                            <i class="ri-file-shield-2-line h5"></i>
                        </button>

                        <button id="action-tag-edit-survey" type="button" class="tag tag-primary mr-2" style="border: solid 1px #3490dc;" data-toggle="modal" data-target="#editSurveyModal" data-backdrop="static">
                            <i class="ri-edit-box-fill h5"></i>
                        </button>

                        @else
                        <span class="text-danger">
                            <i class="ri-information-line pr-1"></i>
                            Hanya Surveyor dapat mengisi hasil survey</span>
                        @endhasrole
                    </div>
                    <div class="flex-grow-1"></div>

                    {{-- Search/Filter --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <input id="searchFilter" name="searchFilter" class="form-control form-control-sm pl-3" type="text" placeholder="Filter" />
                        </div>
                    </div>

                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <table id="table-surveys" class="table table-data nowrap w-100">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Project</th>
                                    <th>Tgl Project<span class="ri-information-line font-size-16 pl-1" data-toggle="tooltip" title="Tanggal registrasi project"></span></th>
                                    <th>Tgl Assign Survey<span class="ri-information-line font-size-16 pl-1" data-toggle="tooltip" title="Tanggal perintah survey"></span></th>
                                    <th>Di Assign oleh</th>
                                    <th>Tgl Survey</th>
                                    <th>Surveyor<span class="ri-information-line font-size-16 pl-1" data-toggle="tooltip" title="Nama petugas survey"></span></th>
                                    <th>Customer</th>
                                    <th>Status Project</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('js/tender/survey.js') }}"></script>
<script type="text/javascript">
    var selectedRow
        , surveyLocations = []
        , existingSurvey
        , loadSurveyUrl = "{{ route('Survey.loadDataTable') }}"
        , createSurveyUrl = "{{ route('survey.create') }}"
        , currentUserId = "{{ auth()->id() }}"
        , currentUser = "{{ auth()->user()->idKaryawan }}";

</script>
