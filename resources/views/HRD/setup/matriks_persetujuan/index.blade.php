@extends('HRD.layouts.master')
@section('content')
<style>
    .select2-container .select2-selection--single {
        height: 40px !important; /* Adjust the height */
        display: flex;
        align-items: center; /* Center text vertically */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 38px !important; /* Match line-height to height for alignment */
    }

    .select2-container--default .select2-selection--multiple {
        min-height: 40px !important; /* For multi-select dropdowns */
    }
</style>
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Setup</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/setup/matriks_persetujuan') }}">Matriks Persetujuan</a></li>
        </ul>
    </nav>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-12">
        @if(\Session::has('konfirm'))
            <div class="alert text-white bg-success" role="alert" id="success-alert">
                <div class="iq-alert-icon">
                    <i class="ri-alert-line"></i>
                </div>
                <div class="iq-alert-text">{{ \Session::get('konfirm') }}</div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="ri-close-line"></i>
                </button>
            </div>
        @endif
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="iq-card" id="page_view">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Matriks Persetujaun</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <table class="table-bordered" id="table_view" style="width: 100%;">
                    <thead>
                        <th style="width: 15%;">Aksi</th>
                        <th>Group</th>
                        <th style="width: 50%;">Hirarki</th>
                    </thead>
                    <tbody>
                        @foreach ($list_matriks as $r)
                        <tr>
                            <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalForm" onclick="goPengaturan(this)" value="{{ $r['id'] }}"><i class="fa fa-gear"></i> Pengaturan</button></td>
                            <td>{{ $r['ref_group'] }}</td>
                            <td>
                                <ul class="list-group">
                                    @foreach ($r['list_departemen'] as $dep)
                                    <li class="list-group-item list-group-item-dark">- {{ $dep['nm_dept'] }} | {{ $dep['get_master_divisi']['nm_divisi'] }}
                                        <table class="table-bordered" style="width: 100%">
                                            <tr>
                                                <td style="width: 10%; text-align:center">Level</td>
                                                <td>Pejabat</td>
                                                <td>Jabatan</td>
                                            </tr>
                                            @foreach ($dep['list_matriks'] as $matriks)
                                            <tr>
                                                <td style="text-align: center">{{ $matriks->approval_level }}</td>
                                                <td>{{ $matriks->getPejabat->nm_lengkap }}</td>
                                                <td>{{ $matriks->getPejabat->get_jabatan->nm_jabatan }}</td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="height: 15px"></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);

    });
    var goPengaturan = function(el)
    {
        var idData = $(el).val();
        location.replace("{{ url('hrd/setup/matriks_persetujuan_setup') }}/"+idData)
    }
</script>
@endsection
