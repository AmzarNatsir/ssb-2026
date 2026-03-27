@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Persetujuan | Penggajian Karyawan</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/penggajian/persetujuan') }}">Refresh (F5)</a></li>
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
    <div class="col-sm-12 col-lg-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Draf Gaji Karyawan</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <table id="user-list-table" class="table  table-hover table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info">
                    <thead>
                        <th style="width: 5%">No.</th>
                        <th style="width: 15%">Periode</th>
                        <th style="width: 15%; text-align:right">Total Gapok (Rp.)</th>
                        <th style="width: 15%; text-align:right">Total Tunjangan (Rp.)</th>
                        <th style="width: 15%; text-align:right">Total THP (Rp.)</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($result_payroll as $key => $item)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ \App\Helpers\Hrdhelper::get_nama_bulan($item->bulan) }} {{ $item->tahun }}</td>
                                <td style="text-align:right">{{ number_format($item->total_gapok, 0, ',', '.') }}</td>
                                <td style="text-align:right">{{ number_format($item->total_tunjangan, 0, '.', ',') }}</td>
                                <td style="text-align:right">{{ number_format($item->total_gapok + $item->total_tunjangan, 0, '.', ',') }}</td>
                                <td>
                                    @if ($role_user->can('persetujuan_Penggajian_approve') || $role_user->nik='999999999')
                                    <button type="button" class="btn btn-success btn_detail" data-toggle="modal" data-target="#ModalRole" id="{{ $item->bulan."-".$item->tahun }}"><i class="fa fa-list"></i> Detail</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="ModalRole" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true"
        data-backdrop="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" id="v_form_detail"></div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".btn_detail").on("click", function() {
            var id_data = this.id.split('-');
            var bulan = id_data[0];
            var tahun = id_data[1];
            $("#v_form_detail").load("{{ url('hrd/penggajian/detail') }}/"+bulan+"/"+tahun);
        });

    });
</script>
@endsection