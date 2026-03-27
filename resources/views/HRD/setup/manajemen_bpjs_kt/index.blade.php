@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Setup | Pengaturan Persentase BPJS Ketenagakerjaan</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/setup/manajemenbpjskt') }}">Refresh (F5)</a></li>
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
<form action="{{ url('hrd/setup/manajemenbpjs/simpanbpjs') }}" method="post" onsubmit="return konfirm()" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="hidden" name="id_data" id="id_data" value="{{ (empty($persen_bpjs->id)) ? '' : $persen_bpjs->id }}">
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Pengaturan Persentase Perhitungan BPJS Ketenagakerjaan</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <div class="form-group row">
                    <label class="col-sm-2">JHT (Karyawan)(%)</label>
                    <div class="col-sm-1">
                        <input type="text" name="inp_persen_jht_karyawan" id="inp_persen_jht_karyawan" class="form-control angka" maxlength="10" value="{{ (empty($persen_bpjs->jht_karyawan)) ? '0' : $persen_bpjs->jht_karyawan }}" style="text-align: right;" required>
                    </div>
                    <label class="col-sm-2">JHT (Perusahaan)(%)</label>
                    <div class="col-sm-1">
                        <input type="text" name="inp_persen_jht_perusahaan" id="inp_persen_jht_perusahaan" class="form-control angka" maxlength="10" value="{{ (empty($persen_bpjs->jht_perusahaan)) ? '0' : $persen_bpjs->jht_perusahaan }}" style="text-align: right;" required>
                    </div>
                    <label class="col-sm-2">JKK (Karyawan)(%)</label>
                    <div class="col-sm-1">
                        <input type="text" name="inp_persen_jkk_karyawan" id="inp_persen_jkk_karyawan" class="form-control angka" maxlength="10" value="{{ (empty($persen_bpjs->jkk_karyawan)) ? '0' : $persen_bpjs->jkk_karyawan }}" style="text-align: right;" required>
                    </div>
                    <label class="col-sm-2">JKK (Perusahaan)(%)</label>
                    <div class="col-sm-1">
                        <input type="text" name="inp_persen_jkk_perusahaan" id="inp_persen_jkk_perusahaan" class="form-control angka" maxlength="10" value="{{ (empty($persen_bpjs->jkk_perusahaan)) ? '0' : $persen_bpjs->jkk_perusahaan }}" style="text-align: right;" required>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label class="col-sm-2">JKM (Karyawan)(%)</label>
                    <div class="col-sm-1">
                        <input type="text" name="inp_persen_jkm_karyawan" id="inp_persen_jkm_karyawan" class="form-control angka" maxlength="10" value="{{ (empty($persen_bpjs->jkm_karyawan)) ? '0' : $persen_bpjs->jkm_karyawan }}" style="text-align: right;" required>
                    </div>
                    <label class="col-sm-2">JKM (Perusahaan)(%)</label>
                    <div class="col-sm-1">
                        <input type="text" name="inp_persen_jkm_perusahaan" id="inp_persen_jkm_perusahaan" class="form-control angka" maxlength="10" value="{{ (empty($persen_bpjs->jkm_perusahaan)) ? '0' : $persen_bpjs->jkm_perusahaan }}" style="text-align: right;" required>
                    </div>
                    <label class="col-sm-2">JP (Karyawan)(%)</label>
                    <div class="col-sm-1">
                        <input type="text" name="inp_persen_jp_karyawan" id="inp_persen_jp_karyawan" class="form-control angka" maxlength="10" value="{{ (empty($persen_bpjs->jp_karyawan)) ? '0' : $persen_bpjs->jp_karyawan }}" style="text-align: right;" required>
                    </div>
                    <label class="col-sm-2">JP (Perusahaan)(%)</label>
                    <div class="col-sm-1">
                        <input type="text" name="inp_persen_jp_perusahaan" id="inp_persen_jp_perusahaan" class="form-control angka" maxlength="10" value="{{ (empty($persen_bpjs->jp_perusahaan)) ? '0' : $persen_bpjs->jp_perusahaan }}" style="text-align: right;" required>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Pengaturan Persentase Perhitungan BPJS Kesehatan</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <div class="form-group row">
                    <label class="col-sm-2">Karyawan (%)</label>
                    <div class="col-sm-1">
                        <input type="text" name="inp_persen_bpjsks_karyawan" id="inp_persen_bpjsks_karyawan" class="form-control angka" maxlength="10" value="{{ (empty($persen_bpjs->bpjsks_karyawan)) ? '0' : $persen_bpjs->bpjsks_karyawan }}" style="text-align: right;" required>
                    </div>
                    <label class="col-sm-2">Perusahaan (%)</label>
                    <div class="col-sm-1">
                        <input type="text" name="inp_persen_bpjsks_perusahaan" id="inp_persen_bpjsks_perusahaan" class="form-control angka" maxlength="10" value="{{ (empty($persen_bpjs->bpjsks_perusahaan)) ? '0' : $persen_bpjs->bpjsks_perusahaan }}" style="text-align: right;" required>
                    </div>
                </div>
                <hr>
                <div class="form-group" style="text-align: center;">
                <button type="submit" class="btn btn-primary" name="tbl_simpan" id="tbl_simpan">Simpan Pengaturan</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".angka").number(true, 2);
    });
    function konfirm()
    {
        var psn = confirm("Yakin akan menyimpan pengaturan gaji pokok karyawan ?");
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
</script>
@endsection