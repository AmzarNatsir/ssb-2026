@extends('Tender.layouts.master')
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
                    <span class="ri-chat-check-line pr-2"></span>Master Dokumen
                </h4>
            </div>
            <div class="col-sm-4 text-right">
                @hasrole('project_manager')
                <button id="createProjectBtn" type="button" class="btn btn-lg mb-3 btn-primary rounded-pill" data-toggle="modal" data-backdrop="static" data-target="#createProjectModal">
                    <i class="las la-pen"></i>Tambah Master Dokumen
                </button>
                @endhasrole
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
            <form id="filter-project-form" name="filter-project-form" method="POST" enctype="multipart/form-data" autocomplete="off" action="{{ route('Project.loadDataTable') }}">
                @csrf

                {{-- <div class="form-row">
          <div class="form-group pr-2">
            <label>Kategori</label>
            <select id="opsiKategori" name="opsiKategori" class="form-control" style="border-right: 10px transparent solid;border-bottom: 15px;">
              <option value=""></option>
              @foreach($opsiKategoriProject as $item)
                <option value="{{ $item->id }}">{{ $item->keterangan }}</option>
                @endforeach
                </select>
        </div>

        <div class="form-group pr-2">
            <label>Tipe/Jenis</label>
            <select id="opsiTipe" name="opsiTipe" class="form-control" style="border-right: 10px transparent solid;border-bottom: 15px;">
                <option value=""></option>
                @foreach($opsiTipeProject as $item)
                <option value="{{ $item->id }}">{{ $item->keterangan }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group pr-2">
            <label>Status</label>
            <select id="opsiStatus" name="opsiStatus" class="form-control" style="border-right: 10px transparent solid;border-bottom: 15px;">
                <option value=""></option>
                @foreach($opsiStatusProject as $item)
                <option value="{{ $item->id }}">{{ $item->keterangan }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group pr-2">
            <label>&nbsp;</label>
            <button id="btn-filter-project" type="button" class="btn btn-lg btn-block btn-primary px-6 position-relative" style="height:45px;">
                <i class="ri-filter-line pr-1"></i><strong>Filter</strong>
                <span class="badge bg-light ml-2 position-absolute top-0 start-100 rounded-circle text-dark translate-middle d-none">4</span>
            </button>
        </div>

    </div> --}}
</div>
{{-- End --}}

{{-- show when user checking the row --}}
<div class="row">

    <div id="action-tags" class="col-md-3 text-center d-flex align-items-center justify-content-center d-none">
        @hasrole('project_manager')
        <button id="action-tag-update" data-id="" type="button" class="tag mr-2" data-toggle="modal" data-target="#editProjectModal">
            <i class="ri-edit-box-fill h5"></i>
        </button>

        <button id="action-tag-delete" type="button" class="tag-danger mr-2" data-toggle="tooltip" title="hapus project">
            <i class="ri-delete-bin-line h5"></i>
        </button>

        <button id="action-tag-assign-survey" type="button" class="tag mr-2" data-toggle="modal" data-target="#surveyAssignmentModal">
            <i class="ri-file-shield-2-line h5"></i>
        </button>

        <button id="action-tag-share" type="button" class="tag mr-2" data-toggle="tooltip" title="share project">
            <i class="ri-share-line h5"></i>
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
        <table id="table-documents" class="table table-data nowrap w-100">
            <thead>
                <tr class="tr-shadow">
                    <th>Id</th>
                    <th>Nama Dokumen</th>
                </tr>
            </thead>
            <tbody>
                @if($documents->count() > 0)
                @foreach($documents as $key => $document)
                <tr>
                    <td>{{ $document->id }}</td>
                    <td>{{ $document->name }}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
@endsection
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('js/tender/master-dokumen.js') }}"></script>
<script type="text/javascript">
    var selectedRow;

</script>
