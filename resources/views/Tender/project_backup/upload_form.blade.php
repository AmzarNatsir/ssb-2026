@extends('Tender.layouts.master')
@section('content')
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

<div id="upload-form" 
data-opsi_upload_kategori={{ $opsi_upload_kategori }}
data-project_id={{ $project_id }}></div>
<script src="{{ asset('js/app.js') }}"></script>
@endsection