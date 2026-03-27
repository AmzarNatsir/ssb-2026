@extends('Tender.layouts.master')
@section('content')
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<div id="project-upload" data-opsi_upload_kategori={{ $opsi_upload_kategori }}></div>
<script src="{{ asset('js/app.js') }}"></script>
@endsection