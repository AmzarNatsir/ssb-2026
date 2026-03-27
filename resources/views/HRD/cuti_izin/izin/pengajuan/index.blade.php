@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active">Izin Karyawan</li>
        </ul>
    </nav>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-5">
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
    <div class="col-sm-12 col-lg-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Izin Karyawan</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                 <ul class="nav nav-tabs" id="myTab-three" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab-three" data-toggle="tab" href="#pengajuan-tab" role="tab" aria-controls="home" aria-selected="true">Pengajuan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab-three" data-toggle="tab" href="#riwayat-tab" role="tab" aria-controls="profile" aria-selected="false">Riwayat Izin</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent-4">
                    <div class="tab-pane fade show active" id="pengajuan-tab" role="tabpanel" aria-labelledby="home-tab-three">
                        <p>Berikut adalah daftar pengajuan izin anda. Klik tombol <b>(+)</b> untuk mengajukan izin</p>
                        @if($cek_pengajuan->count()==0)
                        <div class="user-list-files d-flex float-right" style="margin-bottom: 10px;">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalForm" onclick="goFormAdd(this)"><i class="fa fa-plus"></i></button>
                        </div>
                        @endif
                        <table class="table">
                            <thead>
                                <tr>
                                <th style="width: 10%;" rowspan="2">Tanggal</th>
                                <th style="width: 15%;" rowspan="2">Jenis Izin</th>
                                <th style="width: 20%" rowspan="2">Durasi</th>
                                <th style="width: 20%;" rowspan="2">Status</th>
                                <th style="width: 15%; text-align:center" colspan="1">Persetujuan</th>
                                <th style="width: 5%;" rowspan="2">Act</th>
                                </tr>
                                <tr>
                                    <th style="text-align:center">Atasan Langsung</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result_list as $ct)
                                <tr>
                                    <td>{{ $ct->tgl_pengajuan }}</td>
                                    <td>{{ $ct->get_jenis_izin->nm_jenis_ci }}</td>
                                    <td>{{ date_format(date_create($ct->tgl_awal), 'd-m-Y') }} s/d {{ date_format(date_create($ct->tgl_akhir), 'd-m-Y') }}<br>({{ $ct->jumlah_hari }} hari)</td>
                                    <td>
                                        @if(empty($ct->sts_appr_atasan))
                                            Menunggu Persetujuan Atasan Langsung
                                        @else
                                            @if($ct->sts_appr_atasan==1)
                                                Pengajuan Izin Anda Disetujui
                                            @else
                                                Pengajuan Izin Anda Ditolak
                                            @endif
                                        @endif
                                    </td>
                                    <td style="text-align: center">
                                        @if(empty($ct->sts_appr_atasan))
                                            <button type="button" class="btn btn-warning"><i class="fa fa-hourglass-half"></i></button>
                                        @else
                                            @if($ct->sts_appr_atasan==1)
                                                <button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="<?= $ct->ket_appr_atasan ?>"><i class="fa fa-check"></i></button>
                                            @else
                                                <button type="button" class="btn btn-danger" title="Ditolak" data-toggle="tooltip" data-placement="top" title="<?= $ct->ket_appr_atasan ?>"><i class="fa fa-close"></i></button>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-placement="top" title="Detail" data-target="#ModalForm" onclick="goFormDetail(this)" value="{{ $ct->id }}"><i class="fa fa-eye"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="riwayat-tab" role="tabpanel" aria-labelledby="profile-tab-three">
                        <p>Berikut adalah daftar riwayat cuti anda.</p>
                        <table class="table">
                            <thead>
                                <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 10%">Tgl.&nbsp;Pengajuan</th>
                                <th style="width: 25%">Jenis Izin</th>
                                <th style="width: 25%">Durasi</th>
                                <th>Alasan Izin</th>
                            </thead>
                            <tbody>
                                @if(count($riwayat_izin)==0)
                                    <tr>
                                        <td colspan="4" style="text-align: center;">Data is Empty!</td>
                                    </tr>
                                @else
                                    @php $nom=1 @endphp
                                    @foreach($riwayat_izin as $riwayat)
                                    <tr>
                                        <td>{{ $nom }}</td>
                                        <td>{{ date_format(date_create($riwayat->tgl_pengajuan), 'd-m-Y') }}</td>
                                        <td>{{ $riwayat->get_jenis_izin->nm_jenis_ci }}</td>
                                        <td>{{ date_format(date_create($riwayat->tgl_awal), 'd-m-Y') }} s/d {{ date_format(date_create($riwayat->tgl_akhir), 'd-m-Y') }}<br>({{ $riwayat->jumlah_hari }} hari)</td>
                                        <td>{{ $riwayat->ket_izin }}</td>
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
</div>
<div id="ModalForm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" id="v_inputan"></div>
    </div>
 </div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    });
    var goFormAdd = function()
    {
        $("#v_inputan").load("{{ url('hrd/cutiizin/formpengajuanizin') }}");
    }
    var goFormDetail = function(el)
    {
        $("#v_inputan").load("{{ url('hrd/cutiizin/detailpengajuanizin') }}/"+$(el).val());
    }
</script>
@endsection
