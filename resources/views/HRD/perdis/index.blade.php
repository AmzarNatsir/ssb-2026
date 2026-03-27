@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Perjalanan Dinas</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/perjalanandinas') }}">Refresh (F5)</a></li>
        </ul>
    </nav>
</div>
<div class="row">
    @if(\Session::has('konfirm'))
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
    @endif
    @include('HRD.perdis.summary_perdis')
</div>
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="iq-card">
            <div id="spinner-div" class="pt-5 justify-content-center spinner-div"><div class="spinner-border text-primary" role="status"></div></div>
            <div class="preview"></div>

            {{-- <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Monitoring Perjalanan Dinas Karyawan</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">

            </div> --}}

            {{-- <div class="iq-card-body" style="width:100%; height:auto">
                <div class="row justify-content-between">
                    <div class="col-sm-6 col-md-6">
                        <div class="user-list-files d-flex float-left">
                            <a href="{{ url('hrd/perjalanandinas/daftarPengajuan') }}"><i class="fa fa-table"></i> Daftar Pengajuan ({{ count($list_pengajuan) }})</a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="user-list-files d-flex float-right">
                            <a href="{{ url('hrd/perjalanandinas/daftarPerjalananDinas') }}"><i class="fa fa-table"></i> Data Perjalanan Dinas</a>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="iq-card">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                <h4 class="card-title">Karyawan Yang Melakukan Perjalanan Dinas Bulan Ini</h4>
                                </div>
                            </div>
                            <div class="iq-card-body">
                                @foreach ($karyawan_perdis as $list)
                                <div class="col-lg-3 " style="display: inline-block">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="iq-card iq-card-block iq-card-stretch iq-card-height iq-profile-card text-center">
                                                <div class="iq-card-body">

                                                    <div class="iq-team text-center p-0">
                                                        @if(!empty($list->get_profil->photo))
                                                        <img src="{{ url(Storage::url('hrd/photo/'.$list->get_profil->photo)) }}"
                                                            class="img-fluid mb-3 avatar-120 rounded-circle" alt="">
                                                        @else
                                                        <img src="images/user/1.jpg"
                                                            class="img-fluid mb-3 avatar-120 rounded-circle" alt="">
                                                        @endif
                                                        <h4 class="mb-0">{{ $list->get_profil->nm_lengkap }}</h4>
                                                        <a href="#" class="d-inline-block w-100">{{ $list->get_profil->nik }}</a>
                                                        <table class="table">
                                                            <tr>
                                                                <td>Tujuan : {{ $list->tujuan }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Brangkat : {{ date('d-m-Y', strtotime($list->tgl_berangkat)) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Kembali : {{ date('d-m-Y', strtotime($list->tgl_kembali)) }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#spinner-div').hide();
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    });
    var showData = function(el)
    {
        $('#spinner-div').show();
        var filter = $(el).val();
        $(".preview").load("{{ url('hrd/perjalanandinas/showData') }}/"+filter, function(){
            $('#spinner-div').hide();
        });
    }
</script>
@endsection
