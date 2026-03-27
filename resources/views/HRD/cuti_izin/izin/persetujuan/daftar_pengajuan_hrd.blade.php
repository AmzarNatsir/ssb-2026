@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Pengajuan Izin</li>
        </ul>
    </nav>
</div>
<div class="row">
    @if(App\Helpers\Hrdhelper::get_level_persetujuan_hrd_modul_izin()!=auth()->user()->karyawan->id_jabatan)
    <div class="col-sm-12 col-lg-12" style="text-align: center;">
        Anda tidak bisa mengakses halaman ini !!
    </div>
    @else
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
                    <h4 class="card-title">Daftar Pengajuan Izin</h4>

                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <table class="table table-hover table-bordered mt-4" role="grid" aria-describedby="user-list-page-info" style="width:100%; font-size: 12px;">
                    <thead>
                        <tr>
                            <th scope="col" rowspan="2">#</th>
                            <th scope="col" rowspan="2"></th>
                            <th scope="col" rowspan="2" style="width: 20%;">Karyawan</th>
                            <th scope="col" colspan="6" style="text-align: center;">Pengajuan Izin</th>
                            <th scope="col" colspan="2" style="text-align:center">Aksi</th>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis Izin</th>
                            <th>Tgl.Mulai</th>
                            <th>Tgl.Akhir</th>
                            <th style="width: 5%; text-align:center">Jumlah Hari</th>
                            <th>Keterangan</th>
                            <th style="width: 5%; text-align:center">Atasan Langsung</th>
                            <th style="width: 5%; text-align:center">HRD</th>
                        </tr>
                    </thead>
                    <tbody id="result_daftar">
                        @php 
                        $no_urut=1;
                        @endphp
                        @foreach($list_pengajuan as $list)
                        <tr>
                            <td>{{ $no_urut }}</td>
                            <td class="text-left">
                            <a href="{{ asset('upload/photo/'.$list->photo) }}" data-fancybox><img class="rounded-circle avatar-40" src="{{ asset('upload/photo/'.$list->photo) }}" alt="profile"></a></td>
                            <td>{{ $list->nik." | ".$list->nm_lengkap }}<br>
                            {{ $list->nm_dept." | ".$list->nm_jabatan }}
                            </td>
                            <td>{{ date_format(date_create($list->tgl_pengajuan), 'd-m-Y') }}</td>
                            <td>{{ $list->nm_jenis_ci }}</td>
                            <td>{{ date_format(date_create($list->tgl_awal), 'd-m-Y') }}</td>
                            <td>{{ date_format(date_create($list->tgl_akhir), 'd-m-Y') }}</td>
                            <td style="text-align:center">{{ $list->jumlah_hari }}</td>
                            <td>{{ $list->ket_izin }}</td>
                            <td>
                                @if(empty($list->id_atasan))
                                    @if(date("Y-m-d") > date_format(date_create($list->tgl_awal), 'Y-m-d'))
                                        <button type="button" class="btn btn-danger" title="Expired"><i class="fa fa-times-circle-o"></i></button>
                                    @else
                                        @if($list->id_departemen==auth()->user()->karyawan->id_departemen)
                                        <button type="button" class="btn btn-primary" title="Klik untuk proses persetujuan" onClick="prosesPersetujuanAL(this)" value="{{ $list->id }}"><i class="fa fa-pencil-square-o"></i></button>
                                        @else
                                        <button type="button" class="btn btn-primary" title="Diproses Atasan Langsung"><i class="fa fa-pencil-square-o"></i></button>
                                        @endif
                                    @endif
                                @else
                                    @if($list->sts_appr_atasan==1)
                                    <button type="button" class="btn btn-success" title="Disetujui"><i class="fa fa-check-circle"></i></button>
                                    @else
                                    <button type="button" class="btn btn-success" title="Disetujui"><i class="fa fa-check-circles"></i></button>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if($list->sts_appr_atasan==1)
                                    @if(empty($list->id_persetujuan))
                                        @if(date("Y-m-d") > date_format(date_create($list->tgl_awal), 'Y-m-d'))
                                        <button type="button" class="btn btn-danger" title="Expired"><i class="fa fa-times-circle-o"></i></button>
                                        @else
                                        <button type="button" class="btn btn-primary" title="Klik untuk proses persetujuan" onClick="prosesPersetujuanHrd(this)" value="{{ $list->id }}"><i class="fa fa-pencil-square-o"></i></button>
                                        @endif
                                    @else
                                        @if($list->sts_persetujuan==1)
                                        <button type="button" class="btn btn-success" title="Disetujui"><i class="fa fa-check-circle"></i></button>
                                        @else
                                        <button type="button" class="btn btn-success" title="Disetujui"><i class="fa fa-check-circles"></i></button>
                                        @endif
                                    @endif
                                @else
                                    @if(date("Y-m-d") < date_format(date_create($list->tgl_awal), 'Y-m-d'))
                                    <button type="button" class="btn btn-warning"><i class="fa fa-hourglass-half"></i></button>
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
    @endif
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    });
    var prosesPersetujuanAL = function(el)
    {
        var id_pengajuan = $(el).val();
        window.open("{{ url('hrd/cutiizin/formpersetujuanizin_al') }}/"+id_pengajuan);
    };
    var prosesPersetujuanHrd = function(el)
    {
        var id_pengajuan = $(el).val();
        window.open("{{ url('hrd/cutiizin/formpersetujuanizin_hrd') }}/"+id_pengajuan);
    };
</script>
@endsection