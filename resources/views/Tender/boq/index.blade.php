@extends('Tender.layouts.master')
@include('Tender.boq.partials.boq_modal')
@section('content')
<div class="row">
  <div class="col-lg-12">
      <div class="navbar-breadcrumb">
          <nav aria-label="breadcrumb">
              <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
              <li class="breadcrumb-item">Project Management</li>
              <li class="breadcrumb-item">Project</li>
              <li class="breadcrumb-item active" aria-current="page">Bill of Quantity</li>
              </ul>
          </nav>
      </div>
  </div>
</div>
<div class="iq-card">
  <div class="iq-card-body" style="padding:1.5rem 3rem;">

      {{-- Header --}}
	  <div class="row">
	    <div class="col-sm-8">
	      <h4 class="card-title text-primary">
	        <span class="ri-file-text-line pr-2"></span>Bill of Quantity (BOQ)
	      </h4>
	    </div>
	    <div class="col-sm-4 text-right">
	      {{-- @hasrole('project_manager')
	      <button id="createBoqBtn" type="button" class="btn btn-lg mb-3 btn-success rounded-pill" data-toggle="modal" data-backdrop="static" data-target="#createBoqModal">
	        <i class="las la-pen"></i>New BOQ
	      </button>
	      @endhasrole --}}
	    </div>
	  </div>
	  {{-- End Header --}}

    {{-- Snackbar --}}
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
    {{-- end Snackbar --}}

    {{-- Table Filter --}}
    <div class="row mt-4 mb-4 d-flex justify-content-center border-bottom">
      <form id="filter-boq-form" name="filter-boq-form" method="POST" enctype="multipart/form-data" autocomplete="off" action="{{ route('Survey.loadDataTable') }}">
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
            <button id="btn-filter-boq" type="button" class="btn btn-lg btn-block btn-primary px-6" style="height:45px;">
              <i class="ri-filter-line pr-1"></i><strong>Filter</strong>
            </button>
          </div>

        </div>
      </form>
    </div>
   {{-- End Table Filter --}}

      <div  class="row">
      	<div id="action-tags" class="col-md-3 text-center d-flex align-items-center justify-content-start d-none">
        @hasrole('project_manager')

          <button
            id="createBoqBtn"
            type="button"
            class="tag tag-primary p-2 mr-2"
            style="border: solid 1px #3490dc;"
            data-toggle="modal"
            data-backdrop="static"
            data-target="#createBoqModal">
            <i class="las la-pen"></i>
        </button>

        	<button id="action-tag-edit-boq" type="button" class="tag tag-primary p-2 mr-2" style="border: solid 1px #3490dc;" data-toggle="modal" data-target="#editBoqModal">
            <i class="ri-edit-box-fill"></i>
          </button>
          <button id="action-tag-print-pdf" type="button" class="tag tag-primary p-2 mr-2" style="border: solid 1px #3490dc;">
        		<i class="fa fa-file-pdf-o"></i>
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

		  {{-- Table --}}
		  <div class="row mt-2">
		  	<div class="col-12">
		  		<table id="table-boq" class="table table-data nowrap w-100">
		  			<thead>
		  				<tr class="tr-shadow">
		  					<th></th>
		  					<th>No Project</th>
		  					<th>Nama</th>
		  					<th>Tgl Project</th>
		  					<th>Tgl Boq</th>
		  					<th>Kategori</th>
		  					<th>Status</th>
		  					<th>Tipe</th>
		  				</tr>
		  			</thead>
		  			<tbody>
		  			</tbody>
		  		</table>
		  	</div>
		  </div>
		  {{-- End Table --}}

 </div>
</div>
@endsection
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('js/tender/boq.js') }}"></script>
<script type="text/javascript">
	var selectedRow,
      selectedBoqItemId = "",
      selectedBoqDetailId = "",
      boqIndexUrl = "{{ route('boq.index') }}",
      loadBOQUrl = "{{ route('boq.datatable') }}",
      boqCreateUrl = "{{ route('boq.create') }}",
      boqCreateSubmitUrl = "{{ route('boq.store') }}",
      boqAddItemUrl = "{{ route('boq.update') }}",
      boqDeleteItemUrl = "{{ route('boq.delete') }}",
      cetakPDFUrl = "{{ route('boq.print', ['projectId' => ':projectId' ]) }}";
</script>
