@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('hrd/pelatihan') }}">Kembali ke Daftar</a></li>
        <li class="breadcrumb-item active" aria-current="page">Form Pendataan Pendidikan dan Pelatihan (Diklat)</li>
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
        <div class="iq-card" id="page_view">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Input Data Baru</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <form action="{{ url('hrd/pelatihan/simpandiklat') }}" method="post" onsubmit="return konfirm()">
                {{ csrf_field() }}
                    <input type="hidden" name="id_user" id="id_user" value="{{ auth()->user()->karyawan->id }}">
                    <div class="form-group row">
                        <label class="col-sm-4">Pilih Karyawan</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" id="pil_karyawan" name="pil_karyawan" onChange="getRiwayatDiklat();" style="width: 100%;" required>
                                @foreach($all_karyawan as $list)
                                <option value="{{ $list->id }}">{{ $list->nik." - ".$list->nm_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Lembaga Pelaksana Diklat</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="pil_pelaksana" id="pil_pelaksana" style="width: 100%;" required>
                                @foreach($all_pelaksana as $lembaga)
                                <option value="{{ $lembaga->id }}">{{ $lembaga->nama_lembaga }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Nama Diklat</label>
                        <div class="col-sm-8">
                            <input type="text" name="inp_nama_diklat" id="inp_nama_diklat" class="form-control" maxlength="200" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Tanggal Mulai</label>
                        <div class="col-sm-8">
                            <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control input-md" value="{{ date('Y/m/d') }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Tanggal Selesai</label>
                        <div class="col-sm-8">
                            <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" value="{{ date('Y/m/d') }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Tempat Pelaksanaan</label>
                        <div class="col-sm-8">
                            <input type="text" name="inp_tempat" id="inp_tempat" class="form-control" maxlength="200" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Biaya (Rp.)</label>
                        <div class="col-sm-8">
                            <input type="text" name="inp_biaya" id="inp_biaya" class="form-control angka" value="0" style="text-align: right;" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Status Hasil</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="pil_status" id="pil_status" style="width: 100%;" required>
                                <option value="1">Lulus</option>
                                <option value="2">Tidak Lulus</option>
                                <option value="3">Tanpa Keterangan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Nilai/Hasil Diklat</label>
                        <div class="col-sm-8">
                            <input type="text" name="inp_nilai" id="inp_nilai" class="form-control" maxlength="3">
                        </div>
                    </div>
                    <hr>
                    <button type="submit" id="tbl_simpan" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-7">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Riwayat Diklat</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <table class="table table-hover" style="width:100%; font-size: 12px;">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" style="width: 20%;">Nama Diklat</th>
                            <th scope="col" style="width: 15%">Lembaga Pelaksana</th>
                            <th scope="col" style="width: 15%;">Tempat</th>
                            <th scope="col" style="width: 15%; text-align: center">Tanggal</th>
                            <th scope="col" style="width: 10%; text-align: right">Biaya</th>
                            <th scope="col" style="width: 10%; text-align: center">Status</th>
                            <th scope="col" style="width: 10%; text-align: center">Nilai</th>
                            <th scope="col" style="width: 5%"></th>
                        </tr>
                    </thead>
                    <tbody id="result_riwayat"></tbody>    
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".select2").select2();
        $(".angka").number(true, 0);
    });
    function getRiwayatDiklat()
    {
        var id_karyawan = $("#pil_karyawan").val();
        $("#result_riwayat").load("{{ url('hrd/pelatihan/historydiklat') }}/"+id_karyawan);
    }
    function konfirm()
    {
        var psn = confirm("Yakin data akan disimpan ?");
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
</script>
@endsection