@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Evaluasi Karyawan - Mutasi</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/mutasi') }}">Refresh (F5)</a></li>
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
                    <h4 class="card-title">Monitoring Mutasi Karyawan Bulan ini</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <ul class="nav nav-tabs" id="myTab-1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Monitoring</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Pengajuan <code>({{ $list_pengajuan->count() }})</code></a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent-2">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        {{-- <div class="row justify-content-between">
                            <div class="col-sm-12 col-md-12">
                                <div class="user-list-files d-flex float-right">
                                    <a href="{{ url('hrd/mutasi/baru') }}"><i class="fa fa-plus"></i> Form Mutasi</a>
                                </div>
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="iq-card-body" style="width:100%; height:auto">
                                <table id="user-list-table" class="table datatable table-hover table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nomor/Tanggal</th>
                                            <th scope="col">NIK</th>
                                            <th scope="col">Nama Karyawan</th>
                                            <th scope="col">Posisi Lama</th>
                                            <th scope="col">Posisi Baru</th>
                                            <th scope="col">Kategori</th>
                                            <th scope="col">Ket.</th>
                                            <th>Act</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $nom=1; @endphp
                                        @foreach($list_monitoring as $list)
                                        <tr>
                                            <td>{{ $nom }}</td>
                                            <td>{{ $list->no_surat }}<br>{{ date_format(date_create($list->tgl_surat), "d-m-Y") }}</td>
                                            <td>{{ $list->get_profil->nik }}</td>
                                            <td>{{ $list->get_profil->nm_lengkap }}</td>
                                            <td>
                                            Jabatan : <b>{{ $list->get_jabatan_lama->nm_jabatan }}</b><br>
                    Departemen : <b>{{ (!empty($list->id_dept_lm)) ? $list->get_dept_lama->nm_dept : "" }}</b>
                                            </td>
                                            <td>
                                            Jabatan : <b>{{ $list->get_jabatan_baru->nm_jabatan }}</b><br>
                    Departemen : <b>{{ (!empty($list->id_dept_br)) ? $list->get_dept_baru->nm_dept : "" }}</b>
                                            </td>
                                            <td>@foreach($list_kategori as $key => $value)
                                                @if($key==$list->kategori)
                                                    {{ $value }}
                                                    @php break; @endphp
                                                @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $list->keterangan }}</td>
                                            <td class="text-center">
                                            <button type="button" class="btn btn-primary tbl_print" id="{{ $list->id }}"><i class="fa fa-print"></i></button>
                                            </td>
                                        </tr>
                                        @php $nom++;@endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <table id="user-list-table" class="table datatable table-hover table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info" style="width: 100%; font-size: 12px">
                            <thead>
                            <tr>
                                <th scope="col" rowspan="2" style="width: 5%;">#</th>
                                <th colspan="2" class="btn-success" style="text-align: center">Karyawan</th>
                                <th colspan="4" class="btn-primary" style="text-align: center">Pengajuan</th>
                                <th scope="col" rowspan="2" style="width: 10%; text-align:center">Persetujuan</th>
                                <th rowspan="2" style="width: 5%; text-align:center">Aksi</th>
                            </tr>
                            <tr>
                                <th style="width: 15%;">Nama Karyawan</th>
                                <th style="width: 15%;">Posisi Saat Ini</th>
                                <th style="width: 10%;">Tanggal</th>
                                <th style="width: 20%;">Alasan Pengajuan</th>
                                <th style="width: 15%;">Usulan Posisi Baru</th>
                                <th style="width: 10%;">Kategori</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $nom=1 @endphp
                            @foreach($list_pengajuan as $list)
                                <tr>
                                    <td>{{ $nom }}</td>
                                    <td>{{ $list->get_profil->nik }} | {{ $list->get_profil->nm_lengkap }}</td>
                                    <td><b>{{ $list->get_jabatan_lama->nm_jabatan }}{{ (!empty($list->id_dept_lm)) ? " - ".$list->get_dept_lama->nm_dept : "" }}</b>
                                    </td>
                                    <td>{{ date("d-m-Y", strtotime($list['tgl_pengajuan'])) }}</td>
                                    <td>{{ $list['alasan_pengajuan'] }}</td>
                                    <td><b>{{ $list->get_jabatan_baru->nm_jabatan }}{{ (!empty($list->id_dept_br)) ? " - ".$list->get_dept_baru->nm_dept : "" }}</b>
                                    </td>
                                    <td>@foreach($list_kategori as $key => $value)
                                            @if($key==$list->kategori)
                                                {{ $value }}
                                                @php break; @endphp
                                            @endif
                                            @endforeach</td>

                                    <td style="text-align: center;">
                                    @if($list->status_pengajuan==1)
                                        <span class="badge badge-pill badge-danger">Menunggu Persetujuan : {{ $list->get_current_approve->nm_lengkap }}</span>
                                        <span class="badge badge-pill badge-danger">{{ $list->get_current_approve->get_jabatan->nm_jabatan }}</span>
                                    @elseif($list->status_pengajuan==2)
                                        <span class="badge badge-success">Disetujui</span>
                                    @else
                                        <span class="badge badge-danger">Ditolak</span>
                                    @endif
                                    </td>
                                    <td>
                                        @if($list->status_pengajuan==2)
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalFormProses" value="{{ $list->id }}" onclick="goForm(this)"><i class='ri-pencil-line'></i></button>
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
</div>
<div id="modalFormProses" class="modal fade bg-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content" id="v_inputan" style="overflow-y: auto;"></div>
    </div>
 </div>

<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".select2").select2();
        $('.datatable').DataTable({
            searchDelay: 500,
            processing: true,
        });
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".tbl_print").on("click", function()
        {
            var id_data = this.id;
            window.open("{{ url('hrd/mutasi/print') }}/"+id_data);
        });
    });
    var goForm = function(el)
    {
        var id_data = $(el).val();
        $("#v_inputan").load("{{ url('hrd/mutasi/formproses') }}/"+id_data);
    }
</script>
@endsection
