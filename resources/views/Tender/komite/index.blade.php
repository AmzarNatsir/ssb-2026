@extends('Tender.layouts.master')
@include('Tender.project.partials.add_komite_modal', 
  [
    'opsiDepartemen' => $opsiDepartemen,
    'opsiJabatan' => $opsiJabatan,
    'opsiKaryawan' => $opsiKaryawan
  ])

<style>
	.table_head_column {
		font-size: 12px;
	    color: #555;
	    text-transform: uppercase;
	    border: none;
	    font-weight: 600;
	    vertical-align: top;
	}
</style>

@section('content')	
	{{-- Breadcrumb --}}	
	<x-tender.common.breadcrumb :item="$breadcrumb" />

	{{-- Page --}}

	<div class="iq-card">  
	  <div class="iq-card-body" style="padding:1.5rem 3rem;">    
	      
	      {{-- Row #1 --}}
	      <div class="row">
	        <div class="col-sm-8">
	          <h4 class="card-title text-primary">
	            <span class="ri-chat-check-line pr-2"></span>Daftar Komite
	          </h4>
	        </div>
	        <div class="col-sm-4 text-right">
	          {{-- @hasrole('project_manager') --}}
	            <button id="addKomiteBtn" type="button" class="btn btn-lg mb-3 btn-primary rounded-pill" data-toggle="modal" data-backdrop="static" data-target="#addKomiteModal">
	              <i class="las la-pen"></i>Tambah Anggota Komite
	            </button>
	          {{-- @endhasrole --}}
	        </div>
	      </div>
	      {{-- Toast --}}
	      <x-tender.common.toast />

	      {{-- Row #2 --}}
	      <div class="row">
	        {{-- Reorder --}}
	        {{-- <div id="actions-reorder-container" class="col-md-4 d-flex align-items-center pl-4">	          
	            <button 
	            	type="button" 
	            	class="btn-toggle-reorder mr-2" 
	            	id="reorder-komite" 
	            	data-toggle="tooltip" 
	            	title="Toggle reorder">
	              <i class="ri-drag-move-2-line"></i>
	            </button>
	            <button 
	            	type="button" 
	            	class="btn-accept-reorder mr-2 d-none" 
	            	id="accept-reorder-komite" 
	            	data-toggle="tooltip" 
	            	title="Accept reorder">
	              <i class="ri-check-fill"></i>
	            </button>
	            <button 
	            	type="button" 
	            	class="btn-cancel-reorder mr-2 d-none" 
	            	id="cancel-reorder-komite" 
	            	data-toggle="tooltip" 
	            	title="Cancel reorder">
	              <i class="ri-close-fill"></i>
	            </button>	            
	        </div> --}}

	        
	      	{{-- Action Tags --}}
	      	<div id="action-tags" class="col-md-3 text-center d-flex align-items-center justify-content-start d-none">
	      		<form method="POST" class="delete-member">
	      			@csrf
		      		<button 
			            id="action-tag-delete-komite"
			            type="button" 
			            class="tag-danger mr-2" 
			            data-toggle="tooltip" 
			            title="hapus anggota komite">
			            <i class="ri-delete-bin-line h5"></i>
			        </button>
			        {{-- <button 
			            id="action-tag-update-komite"
			            type="button" 
			            class="tag mr-2" 
			            data-toggle="tooltip"			            
			            title="update anggota komite">
			            <i class="ri-edit-box-fill h5"></i>
			        </button> --}}
		        </form>
	      	</div>
	      	<div class="col-md-6 d-flex align-items-center justify-content-center alert alert-info" style="padding:0!important;">
	        	<i class="ri-information-line pt-2 pr-2 h6"></i>
	        	<small>Klik & drag pada sembarang baris di kolom <strong>ORDER NO</strong> dan lepaskan untuk merubah urutan approval</small>
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
					<table id="table-komite" class="table table-komite display nowrap w-100">
						<thead>
							<tr class="tr-shadow">
								<th></th>
								<th><i class="ri-drag-move-2-line h6 pr-2"></i>Order No </th>
								<th>Nama Lengkap</th>
								<th>Departemen</th>
								<th>Jabatan</th>								
							</tr>						
						</thead>
						<tbody>							
						</tbody>
					</table>
					<form id="reorder-member-form" method="POST" action="{{ route('Komite.reorderMember') }}" enctype="multipart/form-data" autocomplete="off" class="reorder-komite-form">
						@csrf
						{{-- input hidden will be added dynamically --}}
					</form>
				</div>			
			</div>
	    </div>	    
	</div>	
@endsection
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script type="text/javascript">  
  var filterUrl = "{{ url('/project/filter/') }}",
  	loadKomiteUrl = "{{ route('Komite.loadKomiteDataTable') }}",
  	reorderMember = "{{ route('Komite.reorderMember') }}";
  	
</script>
<script src="{{ asset('js/tender/komite.js') }}"></script>
{{-- // deleteMemberUrl = "{{ route('Komite.hapusMember') }}"; --}}