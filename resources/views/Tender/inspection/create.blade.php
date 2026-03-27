@extends('Tender.layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
      <div class="navbar-breadcrumb">
          <nav aria-label="breadcrumb">
              <ul class="breadcrumb">              
              <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
              <li class="breadcrumb-item">HSE</li>
              <li class="breadcrumb-item active" aria-current="page">P2H</li>
              </ul>
          </nav>
      </div>
  </div>
</div>

<div id="inspection-form-dom"></div>


{{-- 
  data-inspection-items="{{ $inspectionItem }}"
  data-equipment-category="{{ $equipmentCategory }}"
  data-equipment="{{ $equipment }}"
  data-location="{{ $location }}" --}}

@endsection
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
{{-- <script src="{{ asset('js/app.js') }}"></script> --}}
@push('scripts')    
    <script src="{{ asset('js/hse.js') }}"></script>
@endpush
