@extends('HRD.layouts.master')
@section('content')
<script src='https://kit.fontawesome.com/a076d05399.js'></script>
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Pengajuan Cuti</li>
        </ul>
    </nav>
</div>
<div class="row"></div>
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
    <div class="col-sm-12 col-lg-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Daftar Pengajuan Cuti</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <table class="table datatable table-hover table-bordered mt-4 table-responsive" role="grid" aria-describedby="user-list-page-info" style="width:100%; font-size: 12px;">
                    <thead>
                        <tr>
                            <th scope="col" rowspan="2">#</th>
                            <th scope="col" rowspan="2" style="width: 20%;">Karyawan</th>
                            <th scope="col" colspan="5" style="text-align: center;">Pengajuan Cuti</th>
                            <th scope="col" colspan="2" style="text-align:center">Persetujuan</th>
                            <th scope="col" rowspan="2" style="text-align:center">Status</th>
                        </tr>
                        <tr>
                            <th>Tanggal Pengajuan</th>
                            <th>Jenis Cuti</th>
                            <th>Durasi</th>
                            <th>Karyawan Pengganti</th>
                            <th>Keterangan</th>
                            <th style="width: 10%; text-align:center">Atasan Langsung</th>
                            <th style="width: 10%; text-align:center">HRD</th>
                        </tr>
                    </thead>
                    <tbody id="result_daftar">
                        @php
                        $no_urut=1;
                        @endphp
                        @foreach($allpengajuan_cuti as $list)
                        <tr>
                            <td>{{ $no_urut }}</td>
                            <td><b>{{ $list->profil_karyawan->nik." - ".$list->profil_karyawan->nm_lengkap }}</b><br>
                            ({{ $list->profil_karyawan->get_departemen->nm_dept." - ".$list->profil_karyawan->get_jabatan->nm_jabatan }})
                            </td>
                            <td>{{ date_format(date_create($list->tgl_pengajuan), 'd-m-Y') }}</td>
                            <td>{{ $list->get_jenis_cuti->nm_jenis_ci }}</td>
                            <td>{{ date_format(date_create($list->tgl_awal), 'd-m-Y') }} s/d {{ date_format(date_create($list->tgl_akhir), 'd-m-Y') }} ({{ $list->jumlah_hari }} hari)</td>
                            <td>{{ (!empty($list->id_pengganti)) ? $list->get_karyawan_pengganti->nm_lengkap : "" }}</td>
                            <td>{{ $list->ket_cuti }}</td>
                            <td style="text-align:center">
                                @if(empty($list->sts_appr_atasan))
                                    @if(date("Y-m-d") > date_format(date_create($list->tgl_awal), 'Y-m-d'))
                                        <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Expired"><i class="fas fa-stopwatch"></i></button>
                                    @else
                                        <button type="button" class="btn btn-primary" title="Proses persetujuan"><i class="fas fa-pen"></i></button>
                                    @endif
                                @else
                                    @if($list->sts_appr_atasan==1)
                                    <button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="<?= $list->ket_appr_atasan ?>"><i class="fa fa-check-circle"></i></button>
                                    @else
                                    <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="<?= $list->ket_appr_atasan ?>"><i class="fa fa-close"></i></button>
                                    @endif
                                @endif
                            </td>
                            <td style="text-align:center">
                                @if($list->sts_appr_atasan==1)
                                    @if(empty($list->sts_persetujuan))
                                        @if(date("Y-m-d") > date_format(date_create($list->tgl_awal), 'Y-m-d'))
                                        <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Expired"><i class="fa fa-times-circle-o"></i></button>
                                        @else
                                        <button type="button" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i></button>
                                        @endif
                                    @else
                                        @if($list->sts_persetujuan==1)
                                        <button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="<?= $list->ket_persetujuan ?>"><i class="fa fa-check-circle"></i></button>
                                        @else
                                        <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="<?= $list->ket_persetujuan ?>"><i class="fa fa-close"></i></button>
                                        @endif
                                    @endif
                                @else
                                    @if(date("Y-m-d") < date_format(date_create($list->tgl_awal), 'Y-m-d'))
                                    <button type="button" class="btn btn-warning"><i class="fa fa-hourglass-half"></i></button>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @php
                                $now = date("Y-m-d");
                                @endphp
                                @if(empty($list->sts_persetujuan))
                                    Proses Persetujuan
                                @else
                                    @if($list->tgl_awal > $now)
                                        Menunggu Tanggal Mulai Cuti
                                    @elseif(($list->tgl_awal <= $now) && ($list->tgl_akhir >= $now))
                                        Sementara Cuti
                                    @else
                                        Selesai Cuti
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @php $no_urut++; @endphp
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
        $('.datatable').DataTable({
            searchDelay: 500,
            processing: true,
        });
    });
    var prosesPersetujuan = function(el)
    {
        var id_pengajuan = $(el).val();
        window.open("{{ url('hrd/cutiizin/formpersetujuan_al') }}/"+id_pengajuan);
    };
</script>
@endsection
