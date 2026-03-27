@extends('Tender.layouts.master')
@include('Tender.jampel.partials.jampel_modal')
@include('Tender.jampel.partials.delete_document_modal')
@section('content')
<div class="row">
  <div class="col-lg-12">
      <div class="navbar-breadcrumb">
          <nav aria-label="breadcrumb">
              <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
              <li class="breadcrumb-item">Project Management</li>
              <li class="breadcrumb-item" aria-current="page">Project</li>
              <li class="breadcrumb-item active" aria-current="page">Jampel & Penyusunan dokumen</li>
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
            <span class="ri-chat-check-line pr-2"></span>Jaminan Pelaksanaan & Penyusunan dokumen lelang
          </h4>
        </div>
        <div class="col-sm-4 text-right">
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
     {{-- end Toast --}}


     <div class="row">
     	<div id="action-tags" class="col-md-3 text-center d-flex align-items-center justify-content-start d-none">
     		<button
          id="action-tag-form-jampel"
          type="button"
          class="tag tag-primary mr-2"
          style="border: solid 1px #3490dc;"
          data-toggle="modal"
          data-target="#createJampelModal"
          data-backdrop="static">
          <i class="ri-edit-box-fill h5"></i>
        </button>
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
          <table id="table-bond" class="table table-data nowrap w-100">
            <thead>
              <tr class="tr-shadow">
                <th></th>
                <th>Nama project</th>
                <th>Tgl Registrasi</th>
                <th>Nilai project</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Tipe</th>
                <th>Lokasi</th>
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
<script src="{{ asset('js/tender/jampel.js') }}"></script>
<script type="text/javascript">
	var selectedRow,
		loadBondUrl = "{{ route('bond.datatable') }}";
</script>
