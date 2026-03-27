@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item">Pengajuan Rekomendasi Penernitan SP</li>
        <li class="breadcrumb-item active" aria-current="page">Daftar Pengajuan Rekomodenasi Penerbitan SP</li>
        </ul>
    </nav>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Daftar Pengajuan</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <table class="table table-hover table-bordered mt-4" role="grid" aria-describedby="user-list-page-info" style="width:100%; font-size: 12px;">
                    <thead>
                        <tr>
                            <th scope="col" rowspan="2" style="width: 5%;">#</th>
                            <th scope="col" rowspan="2" style="width: 10%;"></th>
                            <th scope="col" rowspan="2" style="width: 20%;">Karyawan Yang Direkomendasikan</th>
                            <th scope="col" colspan="3" style="text-align: center;">Keterangan Pengajuan</th>
                            <th scope="col" rowspan="2" style="text-align:center; width:10%">Persetujuan</th>
                        </tr>
                        <tr>
                            <th style="width: 10%; text-align:center">Tanggal</th>
                            <th style="width: 20%; text-align:center">Tingkatan Sanksi</th>
                            <th style="width: 25%; text-align:center">Uraian Pelanggaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no_urut=1; @endphp
                        @foreach($list_pengajuan as $list)
                        <tr>
                            <td>{{ $no_urut }}</td>
                            <td class="text-center">
                            <a href="{{ asset('upload/photo/'.$list->profil_karyawan->photo) }}" data-fancybox><img class="rounded-circle avatar-40" src="{{ asset('upload/photo/'.$list->profil_karyawan->photo) }}" alt="profile"></a></td>
                            <td>{{ $list->profil_karyawan->nik." | ".$list->profil_karyawan->nm_lengkap }}<br>
                            {{ $list->profil_karyawan->get_departemen->nm_dept." | ".$list->profil_karyawan->get_jabatan->nm_jabatan }}
                            </td>
                            <td class="text-center">{{ date_format(date_create($list->tgl_pengajuan), 'd-m-Y') }}</td>
                            <td>{{ $list->get_master_jenis_sp_diajukan->nm_jenis_sp }}</td>
                            <td>{{ $list->uraian_pelanggaran }}</td>
                            <td class="text-center">
                                @if(empty($list->sts_persetujuan))
                                <button type="button" class="btn btn-primary" title="Klik untuk proses persetujuan" onClick="prosesPersetujuanHrd(this)" value="{{ $list->id }}"><i class="fa fa-pencil-square-o"></i></button>
                                @else
                                    @if($list->sts_persetujuan==1)
                                    <button type="button" class="btn btn-success" title="Disetujui"><i class="fa fa-check-circle"></i></button>
                                    @else
                                    <button type="button" class="btn btn-danger"><i class="fa fa-close"></i></button>
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
    });
    var prosesPersetujuanHrd = function(el)
    {
        var id_pengajuan = $(el).val();
        window.open("{{ url('hrd/suratperingatan/formpersetujuanhrd') }}/"+id_pengajuan);
    };
</script>
@endsection