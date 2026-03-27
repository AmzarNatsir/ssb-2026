@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Setup</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/setup/persetujuan') }}">Pengaturan Persetujuan (F5)</a></li>
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
<div class="row">
    <div class="col-lg-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Pengaturan Persetujuan Pengajuan</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <form action="{{ url('hrd/setup/simpanpengaturanpersetujuan') }}" method="post" onsubmit="return konfirm()">
                {{ csrf_field() }}
                <ul class=" m-0 p-0">
                    <li class="d-flex align-items-center p-3">
                        <div class="media-support-info ml-3 col-lg-3 btn-primary">
                            <h6 class="d-inline-block" style="color:white">Modul</h6>
                        </div>
                        <div class="media-support-info ml-3 col-lg-3 btn-danger">
                            <h6 class="d-inline-block" style="color:white">Level Pengajuan (Tahap 1)</h6>
                        </div>
                        <div class="media-support-info ml-3 col-lg-3 btn-success">
                            <h6 class="d-inline-block mb-0" style="color:white">Level Persetujuan Atasan Langsung (Tahap 2)</h6>
                        </div>
                        <div class="media-support-info ml-3 col-lg-3 btn-warning">
                            <h6 class="d-inline-block mb-0" style="color:white">Jabatan Persetujuan HRD (Tahap 3)</h6>
                        </div>
                    </li>
                    
                    @if(!empty($dt_set_1))
                    <li class="d-flex align-items-center p-3">
                        <div class="media-support-info ml-3 col-lg-3">
                            <input type="hidden" name="id_modul_1" value="1">
                            <h6 class="d-inline-block">- Modul Pengajuan Cuti</h6>
                        </div>
                        <div class="iq-card-header-toolbar d-flex col-lg-3">
                            <select class="select2 select2-multiple" name="pil_lvl_pengajuan_cuti[]" id="pil_lvl_pengajuan_cuti" multiple="multiple" data-placeholder="Pilih" style="width: 100%;">
                            @php $list_pil_1 = explode(",", $dt_set_1->lvl_pengajuan); @endphp
                            @foreach($list_level as $level_ct)
                                <option value="{{ $level_ct->id }}" 
                                @foreach($list_pil_1 as $pil_1) 
                                    {{ ($pil_1==$level_ct->id) ? "selected" : "" }}
                                @endforeach>{{ $level_ct->level." - ".$level_ct->nm_level }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="iq-card-header-toolbar d-flex col-lg-3">
                            <select class="form-control" name="pil_lvl_persetujuan_cuti" id="pil_lvl_persetujuan_cuti" style="width: 100%;">
                            <option value="">Pilihan</option>
                            @foreach($list_level as $level_ct)
                            <option value="{{ $level_ct->id }}" {{ ($level_ct->id==$dt_set_1->lvl_persetujuan) ? "selected" : "" }}>{{ $level_ct->level." - ".$level_ct->nm_level }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="iq-card-header-toolbar d-flex col-lg-3">
                            <select class="form-control" name="pil_lvl_persetujuan_cuti_hrd" id="pil_lvl_persetujuan_cuti_hrd" style="width: 100%;">
                            <option value="">Pilihan</option>
                            @foreach($list_jabatan as $lvl_jabatan)
                            <option value="{{ $lvl_jabatan->id }}" {{ ($lvl_jabatan->id==$dt_set_1->id_dept_manager_hrd) ? "selected" : "" }}>{{ $lvl_jabatan->nm_jabatan }}</option>
                            @endforeach
                            </select>
                        </div>
                    </li>
                    @else
                        <li class="d-flex align-items-center p-3">Data Pengaturan Level Persetujuan Masih Kosong</li>
                    @endif
                </ul>
                <hr>
                @if(!empty($dt_set_1))
                <button class="btn btn-primary" type="submit">Simpan Pengaturan</button>
                @endif
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $(".select2").select2();
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    });
    function konfirm()
    {
        var psn = confirm("Yakin akan menyimpan data ?");
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
</script>
@endsection