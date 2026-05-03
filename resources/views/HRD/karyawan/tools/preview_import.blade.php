@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/karyawan/daftar') }}">Karyawan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tools | Preview Import Karyawan</li>
        </ul>
    </nav>
</div>
@if(\Session::has('konfirm'))
<div class="row">
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
</div>
@endif

<div class="row">
    <div class="col-lg-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Preview Data Import</h4>
                </div>
                <div class="iq-card-header-toolbar d-flex align-items-center">
                    <form action="{{ route('processImportKaryawan') }}" method="post" onsubmit="return confirm('Proses data yang valid? Data tidak valid akan diabaikan.');">
                        {{ csrf_field() }}
                        <input type="hidden" name="file_path" value="{{ $file_path }}">
                        <a href="{{ route('importDBKaryawan') }}" class="btn btn-secondary mr-2">Kembali</a>
                        <button type="submit" class="btn btn-primary" {{ $hasValidData ? '' : 'disabled' }}>Konfirmasi Import</button>
                    </form>
                </div>
            </div>
            <div class="iq-card-body">
                <p>Berikut adalah preview data yang akan diimport. Baris dengan warna merah menandakan data tidak valid dan tidak akan diproses.</p>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" style="white-space: nowrap;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Status</th>
                                <th>Errors</th>
                                <th>NIK</th>
                                <th>Nama Lengkap</th>
                                <th>Tgl Masuk</th>
                                <th>Tgl Lahir</th>
                                <th>Jenis Kelamin</th>
                                <th>Agama</th>
                                <th>Pendidikan Akhir</th>
                                <th>Status Nikah</th>
                                <th>Status Karyawan</th>
                                <th>Divisi</th>
                                <th>Departemen</th>
                                <th>Sub Departemen</th>
                                <th>Jabatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($preview_data as $index => $row)
                            <tr class="{{ $row['isValid'] ? '' : 'table-danger' }}">
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($row['isValid'])
                                        <span class="badge badge-success">Valid</span>
                                    @else
                                        <span class="badge badge-danger">Invalid</span>
                                    @endif
                                </td>
                                <td>
                                    @if(!$row['isValid'])
                                        <ul class="mb-0 pl-3">
                                            @foreach($row['errors'] as $error)
                                                <li><small>{{ $error }}</small></li>
                                            @endforeach
                                        </ul>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $row['data']['nik'] ?? '-' }}</td>
                                <td>{{ $row['data']['nama_lengkap'] ?? '-' }}</td>
                                <td>{{ $row['data']['tanggal_masuk'] ?? '-' }}</td>
                                <td>{{ $row['data']['tanggal_lahir'] ?? '-' }}</td>
                                <td>{{ $row['data']['jenis_kelamin_id'] ?? '-' }}</td>
                                <td>{{ $row['data']['agama_id'] ?? '-' }}</td>
                                <td>{{ $row['data']['pendidikan_akhir_id'] ?? '-' }}</td>
                                <td>{{ $row['data']['status_pernikahan_id'] ?? '-' }}</td>
                                <td>{{ $row['data']['status_akryawan_id'] ?? '-' }}</td>
                                <td>{{ $row['data']['divisi_id'] ?? '-' }}</td>
                                <td>{{ $row['data']['departemen_id'] ?? '-' }}</td>
                                <td>{{ $row['data']['sub_departemen_id'] ?? '-' }}</td>
                                <td>{{ $row['data']['jabatan_id'] ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    });
</script>
@stop
