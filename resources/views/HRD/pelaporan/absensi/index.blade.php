@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Pelaporan</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/pelaporan/absensi') }}">Rekap Absensi</a></li>
        </ul>
    </nav>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Pelaporan Rekap Absensi Karyawan</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <div class="row justify-content-between">
                    <div class="col-sm-12 col-md-2">
                        <select class="form-control" name="pil_bulan" id="pil_bulan" style="width: 100%">
                        <option value="0">Pilihan Bulan</option>
                        @foreach($list_bulan as $key => $value)
                        @if($key==date("m"))
                        <option value="{{ $key }}" selected>{{ $value }}</option>
                        @else
                        <option value="{{ $key }}">{{ $value }}</option>
                        @endif
                        @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-1">
                        @php
                        $thn_start = 2010;
                        $thn_end = date('Y');
                        @endphp
                        <select class="form-control" name="inp_tahun" id="inp_tahun" style="width: 100%">
                           @for ($i=$thn_start; $i<=$thn_end; $i++)
                            @if($i==date("Y"))
                            <option value="{{ $i }}" selected>{{ $i }}</option>
                            @else
                            <option value="{{ $i }}">{{ $i }}</option>
                            @endif
                           @endfor
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-5">
                        <div id="user_list_datatable_info" class="dataTables_filter">
                            <select class="form-control" name="pil_departemen" id="pil_departemen" style="width: 100%">
                            <option value="0">- Semua Departemen</option>
                            @foreach($all_departemen as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->nm_dept }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="user-list-files d-flex float-left">
                            <a href="javascript:void(0);" class="chat-icon-phone" onClick="actFilter();"><i class="fa fa-search"></i> FILTER</a>
                            <a href="javascript:void(0);" class="chat-icon-phone" onClick="actPrint();"><i class="fa fa-print"></i> PDF</a>
                            <a href="javascript:void(0);" class="chat-icon-video" onClick="actExcel();"><i class="fa fa-table"></i> Excel</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="iq-card-body" id="p_preview" style="width:100%; height:auto">

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $(".select2").select2();
    });
    var actFilter = function()
    {
        var bulan = $("#pil_bulan").val();
        var tahun = $("#inp_tahun").val();
        var pil_departemen = $("#pil_departemen").val();
        if(bulan==0)
        {
            alert("Kolom Periode Pencetakan Tidak boleh kosong");
            return false
        } else {
            $("#p_preview").html("<div class='text-center p-3'><i class='fa fa-spinner fa-spin'></i> Memuat data...</div>");
            $("#p_preview").load("{{ url('hrd/pelaporan/absensi/filter') }}/"+bulan+"/"+tahun+"/"+pil_departemen);
        }
    }
    var actPrint = function()
    {
        var bulan = $("#pil_bulan").val();
        var tahun = $("#inp_tahun").val();
        var pil_departemen = $("#pil_departemen").val();
        if(bulan==0)
        {
            alert("Kolom Periode Pencetakan Tidak boleh kosong");
            return false
        } else {
            window.open('{{ url("hrd/pelaporan/absensi/print") }}/'+bulan+"/"+tahun+"/"+pil_departemen);
        }
    }
    var actExcel = function()
    {
        var bulan = $("#pil_bulan").val();
        var tahun = $("#inp_tahun").val();
        var pil_departemen = $("#pil_departemen").val();
        if(bulan==0)
        {
            alert("Kolom Periode Pencetakan Tidak boleh kosong");
            return false
        } else {
            window.open('{{ url("hrd/pelaporan/absensi/excel") }}/'+bulan+"/"+tahun+"/"+pil_departemen);
        }
    }
</script>
@endsection
