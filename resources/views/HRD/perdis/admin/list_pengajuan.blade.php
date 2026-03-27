@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Perjalanan Dinas</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/perjalanandinas') }}">Monitoring</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/perjalanandinas/daftarPengajuan') }}">Refresh (F5)</a></li>
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
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">List Pengajuan Perjalanan Dinas</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <div class="row justify-content-center table-responsive">
                    <table class="table datatable table-hover" style="font-size: 13px;">
                        <thead>
                            <tr>
                                <th scope="col" rowspan="2" style="width: 5%;">#</th>
                                <th scope="col" rowspan="2" style="width: 10%;">Tanggal&nbsp;Pengajuan</th>
                                <th scope="col" rowspan="2" style="width: 15%;">Karyawan</th>
                                <th scope="col" rowspan="2" style="width: 15%;">Tujuan/Lokasi</th>
                                <th scope="col" rowspan="2">Alasan</th>
                                <th scope="col" colspan="2" style="text-align: center; width: 20%;">Tanggal Perjalanan</th>
                                <th scope="col" rowspan="2" style="text-align: center; width: 10%;">Persetujuan</th>
                                <th scope="col" rowspan="2" style="text-align: center; width: 10%;">Act</th>
                            </tr>
                            <tr>
                                <th style="text-align: center">Berangkat</th>
                                <th style="text-align: center">Kembali</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $nom=1 @endphp
                        @foreach($list_pengajuan as $list)
                        <tr>
                            <td style="text-align: center;">{{ $nom }}</td>
                            <td style="text-align: center;">{{ date_format(date_create($list->tgl_pengajuan), 'd-m-Y') }}</td>
                            <td>{{ $list->get_profil->nm_lengkap }}</td>
                            <td>{{ $list->tujuan }}</td>
                            <td>{{ $list->maksud_tujuan }}</td>
                            <td style="text-align: center;">{{ date_format(date_create($list->tgl_berangkat), 'd-m-Y') }}</td>
                            <td style="text-align: center;">{{ date_format(date_create($list->tgl_kembali), 'd-m-Y') }}</td>
                            <td style="text-align: center;">
                            @if($list->sts_pengajuan==1)
                                <span class="badge badge-pill badge-danger">Menunggu Persetujuan : {{ $list->get_current_approve->nm_lengkap }}</span>
                                <span class="badge badge-pill badge-danger">{{ $list->get_current_approve->get_jabatan->nm_jabatan }}</span>
                            @elseif($list->sts_pengajuan==2)
                                @if($list->tgl_berangkat >= date('Y-m-d'))
                                <button type="button" class="btn btn-primary" value="{{ $list->id }}" data-toggle="modal" data-target="#modalFormSetting" onclick="goForm(this)" title="Pengaturan Administrasi"><i class="fa fa-gear"></i></button>
                                @else
                                <button type="button" class="btn btn-success" value="{{ $list->id }}" data-toggle="modal" data-target="#modalFormSetting" onclick="goDetail(this)" title="Detail"><i class="fa fa-eye"></i></button>
                                @endif
                            @else
                                <button type="buttom" class="btn btn-warning" title="Waiting"><i class="fa fa-hourglass"></i></button>
                            @endif
                            </td>
                            <td style="text-align: center;">
                            @if($list->sts_pengajuan==2 && (!empty($list->no_perdis)))
                                <button type="button" class="btn btn-danger" value="{{ $list->id }}" onclick="goPrint(this)" title="Surat Perjalanan Dinas"><i class="fa fa-print"></i></button>
                            @endif
                            </td>
                        </tr>
                        @php $nom++ @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modalFormSetting" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" id="v_inputan" style="overflow-y: auto;"></div>
    </div>
 </div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    });
    var goForm = function(el)
    {
        var id_data = $(el).val();
        $("#v_inputan").load("{{ url('hrd/perjalanandinas/pengaturanPerdis') }}/"+id_data);
    }
    var goDetail = function(el)
    {
        var id_data = $(el).val();
        $("#v_inputan").load("{{ url('hrd/perjalanandinas/detailPerdis') }}/"+id_data);
    }
    var goPrint = function(el)
    {
        var id_data = $(el).val();
        window.open("{{ url('hrd/perjalanandinas/printSuratPerdis') }}/"+id_data);
    }
</script>
@endsection
