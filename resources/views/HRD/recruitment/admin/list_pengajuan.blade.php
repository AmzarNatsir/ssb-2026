@extends('HRD.layouts.master')
@section('content')
@php
$user = auth()->user();
@endphp
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Recruitment</li>
        <li class="breadcrumb-item"><a href="#">Pengajuan Permintaan Tenaga Kerja</a></li>
        </ul>
    </nav>
</div>
@if(\Session::has('konfirm'))
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="alert text-white bg-success" role="alert" id="success-alert">
            <div class="iq-alert-icon">
                <i class="ri-alert-line"></i>
            </div>
            <div class="iq-alert-text">{{ \Session::get('konfirm') }}</div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="ri-close-line"></i>
            </button>
        </div>
    </div>
</div>
@endif
<div class="row">
    <div class="col-sm-12 col-lg-4 p-2">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                   <h4 class="card-title">Departemen</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <ul class="list-group">
                    @foreach($departemen as $dept)
                        @if($dept['total_pengajuan']==0)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $dept['nm_dept'] }}
                            <span class="badge badge-secondary badge-pill">{{ $dept['total_pengajuan'] }}</span>
                        </li>
                        @else
                            <a href="javascript:" onclick="goPengajuan({{ $dept['id'] }})">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $dept['nm_dept'] }}
                                <span class="badge badge-danger badge-pill">{{ $dept['total_pengajuan'] }}</span>
                            </li>
                            </a>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-8 p-2">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
               <div class="iq-header-title">
                  <h4 class="card-title">Pengajuan Kebutuhan Tenaga Kerja</h4>
               </div>
            </div>
            <div class="iq-card-body" id="v_pengajuan"></div>
        </div>
    </div>
</div>
<div id="ModalForm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" id="v_detail"></div>
    </div>
 </div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    });

    var goPengajuan = function(val)
    {
        $("#v_pengajuan").load("{{ url('hrd/recruitment/list_pengajuan_tk_departemen') }}/"+val);
    }
    var goDetail = function(val)
    {
        $("#v_detail").load("{{ url('hrd/recruitment/detail_pengajuan_tenaga_kerja') }}/"+val);
    }
    var goDelete = function() {
        var psn = confirm("Yakin akan menghapus data ?")
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
</script>
@endsection
