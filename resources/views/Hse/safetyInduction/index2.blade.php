@extends('Hse.layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
      <div class="navbar-breadcrumb">
          <nav aria-label="breadcrumb">
              <ul class="breadcrumb">              
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                <li class="breadcrumb-item">HSE</li>
                <li class="breadcrumb-item active" aria-current="page">Safety Induction</li>
              </ul>
          </nav>
      </div>
  </div>
</div>

<div id="index2-dom"></div>
@endsection
@push('scripts')
    <script src="{{ asset('js/hse/safetyinduction/index2.js') }}"></script>
@endpush