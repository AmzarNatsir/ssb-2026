@extends('Tender.layouts.master')
@section('content')
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<div 
  id="daftar-project" 
  data-opsi_status_project="{{ $opsi_status_project }}"  
  data-opsi_kategori_proyek="{{ $opsi_kategori_proyek }}">
</div>
<script src="{{ asset('js/app.js') }}"></script>
@endsection
{{-- data-opsi_target_tender="{{ $opsi_target_tender }}" --}}
{{-- data-opsi_jenis_tender="{{ $opsi_jenis_tender }}" --}}
{{-- data-opsi_customer="{{ $opsi_customer }}" --}}