@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item" aria-current="page">Perjalanan Dinas</li>
        <li class="breadcrumb-item active">Daftar Pengajuan</li>
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
                    <h4 class="card-title">Daftar Pengajuan Perjalanan Dinas</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <div class="row justify-content-between">
                    <div class="col-sm-6 col-md-12">
                        <div class="user-list-files d-flex float-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalFormPengajuan" onclick="goForm(this)"><i class="fa fa-plus"> </i> Form Pengajuan</button>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-3">
                <table class="table table-hover" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th scope="col" rowspan="2" style="width: 5%;">#</th>
                            <th scope="col" rowspan="2" style="width: 10%;">Tanggal&nbsp;Pengajuan</th>
                            <th scope="col" rowspan="2" style="width: 15%;">Karyawan</th>
                            <th scope="col" rowspan="2" style="width: 15%;">Tujuan</th>
                            <th scope="col" rowspan="2">Alasan</th>
                            <th scope="col" colspan="2" style="text-align: center; width: 20%;">Tanggal Perjalanan</th>
                            <th scope="col" rowspan="2" style="text-align: center; width: 15%;">Persetujuan</th>
                        </tr>
                        <tr>
                            <th style="text-align: center">Berangkat</th>
                            <th style="text-align: center">Kembali</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($listpengajuan)==0)
                            <tr>
                                <td colspan="10" style="text-align: center;"><b>Data Kosong</b></td>
                            </tr>
                        @else
                            @php $nom=1 @endphp
                            @foreach($listpengajuan as $list)
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
                                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Menunggu Persetujuan
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                <a class="dropdown-item" href="#"><i class="fa fa-user mr-1"></i>{{ $list->get_current_approve->nm_lengkap }}</a>
                                                <a class="dropdown-item" href="#"><i class="fa fa-user mr-1"></i>{{ $list->get_current_approve->get_jabatan->nm_jabatan }}</a>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($list->sts_pengajuan==2)
                                    <button type="button" class="btn btn-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-check"></i> Approved</button>
                                @else
                                    <button type="button" class="btn btn-dark" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-times"></i> Rejected</button>
                                @endif
                                </td>
                            </tr>
                            @php $nom++ @endphp
                            @endforeach
                        @endif
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modalFormPengajuan" class="modal fade" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" id="v_inputan"></div>
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
        $("#v_inputan").load("{{ url('hrd/perjalanandinas/formpengajuan') }}");
    }
</script>
@endsection
