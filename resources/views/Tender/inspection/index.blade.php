@extends('Tender.layouts.master')
@section('content')
<div class="row">
  <x-reusable.breadcrumb :list="$breadcrumb" />
</div>
<div class="iq-card">  
  <div class="iq-card-body" style="padding:1.5rem 3rem;">
    <div class="row">
      <div class="col-sm-8">
        <h4 class="card-title text-primary">
          <span class="ri-chat-check-line pr-2"></span>Daftar P2H
        </h4>
      </div>
      <div class="col-sm-4 text-right"></div>
    </div>

    <div class="row mt-4 mb-4 d-flex justify-content-center border-bottom">
      <form id="filter-daftar-p2h" name="filter-daftar-p2h" method="POST" enctype="multipart/form-data" autocomplete="off" action="{{ route('Project.loadDataTable') }}">
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
            <button id="btn-filter-p2h" type="button" class="btn btn-lg btn-block btn-primary px-6" style="height:45px;">
              <i class="ri-filter-line pr-1"></i><strong>Filter</strong>
            </button>
          </div>
        </div>       
      </form>
    </div>

    <div class="row">
      <div id="action-tags" class="col-md-3 text-center d-flex align-items-center justify-content-start d-none">        
        <button id="action-tag-viewAsPdf" data-id="" class="tag mr-2">
          <i class="fa fa-file-pdf-o pt-2 h5" aria-hidden="true"></i>
        </button>
      </div>
      <div class="flex-grow-1"></div>                  
      <div class="col-md-3">
        <div class="form-group">
          <input id="searchFilter" name="searchFilter" class="form-control form-control-sm pl-3" type="text" placeholder="Filter" />
        </div>
      </div>
    </div>
        
    <div class="row">      
      <div class="col-12 mt-2">
        {{-- Table filter --}}
        <table id="table-inspection" class="table table-data nowrap w-100">
          <thead>
            <tr class="tr-shadow">
              <th></th>
              <th>No. Assignment</th>
              <th>Petugas Inspeksi</th>                
              <th>Lokasi</th>
              <th>Equipment</th>
              <th>Tanggal Inspeksi</th>
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
<script src="{{ asset('js/hse/index.js') }}"></script>
<script type="text/javascript">
  var loadInspectionListUrl = "{{ route('hse.p2h.loadDataTable') }}", 
      viewAsPDFUrl = "{{ route('hse.p2h.viewAsPDF', ['inspectionId' => ':inspectionId' ]) }}",    
      selectedRow;  
</script>
{{-- {{ dd($inspectionItem) }} --}}
{{-- <div 
  id="inspection-list" 
  data-inspection-items="{{ $inspectionItem }}"
  data-equipment-category="{{ $equipmentCategory }}"
  data-equipment="{{ $equipment }}"
  data-location="{{ $location }}"></div>
@endsection --}}