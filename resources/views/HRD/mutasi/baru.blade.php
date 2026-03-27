@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item">Mutasi Karyawan</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/mutasi') }}">Monitoring</a></li>
        <li class="breadcrumb-item active" aria-current="page">Form Mutasi Karyawan</li>
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
                <form action="{{ url('hrd/mutasi/simpan') }}" method="post" enctype="multipart/form-data" onsubmit="return konfirm()">
                {{ csrf_field() }}
                    <div class=" row align-items-center">
                        <div class="form-group col-sm-12">
                            <label for="pil_karyawan">Pilih Karyawan :</label>
                            <select class="form-control select2" id="pil_karyawan" name="pil_karyawan" onChange="getDataKaryawan();" style="width: 100%;">
                                <option value="0">-> Pilih Karyawan</option>
                                @foreach($list_karyawan as $list)
                                <option value="{{ $list->id }}">{{ $list->nik." - ".$list->nm_lengkap }} ({{ (!empty($list->id_jabatan) ? " - ".$list->get_jabatan->nm_jabatan : "") }}{{ (!empty($list->id_departemen) ? " - ".$list->get_departemen->nm_dept : "") }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <ul class="list-group" style="margin-bottom: 15px">
                        <li class="list-group-item active">Posisi/Jabatan Karyawan Saat Ini</li>
                    </ul>
                    <div class="form-group row">
                        <label class="col-sm-4">Status Karyawan</label>
                        <div class="col-sm-8">
                        <label id="sts_lama">:</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Divisi</label>
                        <div class="col-sm-8">
                        <input type="hidden" name="inp_id_divisi_lama" id="inp_id_divisi_lama">
                        <label id="divisi_lama">:</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Departemen</label>
                        <div class="col-sm-8">
                        <input type="hidden" name="inp_id_dept_lama" id="inp_id_dept_lama">
                        <label id="departemen_lama">:</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Sub Departemen</label>
                        <div class="col-sm-8">
                        <input type="hidden" name="inp_id_subdept_lama" id="inp_id_subdept_lama">
                        <label id="subdepartemen_lama">:</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Jabatan</label>
                        <div class="col-sm-8">
                        <input type="hidden" name="inp_id_jabatan_lama" id="inp_id_jabatan_lama">
                        <label id="jabatan_lama">:</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Efektif Tanggal</label>
                        <div class="col-sm-8">
                        <input type="hidden" name="inp_tgl_efektif_lama" id="inp_tgl_efektif_lama">
                        <label id="tanggal_efektif_lama">:</label>
                        </div>
                    </div>
                    <hr>
                    <ul class="list-group" style="margin-bottom: 15px">
                        <li class="list-group-item active">Lampirkan Hasil Evaluasi Karyawan</li>
                    </ul>
                    <div class="form-group">
                        <label for="inp_file_jobdesc">Upload File Hasil Evaluasi (* pdf file only) :</label>
                        <div class="custom-file">
                            <input type="file" class="form-control" id="inp_file_evaluasi" name="inp_file_evaluasi" onchange="loadFile(this)" required disabled>
                            <input type="hidden" name="tmp_file">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label class="col-sm-4">Nomor Surat</label>
                        <div class="col-sm-8">
                            <input type="text" name="inp_nomor_surat" id="inp_nomor_surat" maxlength="100" class="form-control" required disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Tanggal Surat</label>
                        <div class="col-sm-8">
                            <input type="date" name="inp_tgl_surat" id="inp_tgl_surat" class="form-control" required disabled>
                        </div>
                    </div>
                    <ul class="list-group" style="margin-bottom: 15px">
                        <li class="list-group-item active">Perubahan Posisi/Jabatan</li>
                    </ul>
                    <div class="form-group row">
                        <label class="col-sm-4">Mutasi</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="pil_kategori" id="pil_kategori" required disabled>
                                @foreach($list_kategori as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center iq-bg-primary">Promosi : Kenaikan Pangkat</li>
                                <li class="list-group-item d-flex justify-content-between align-items-center iq-bg-success">Mutasi : Perpindahan dari jabatan/departemen pada level yang sama</li>
                                <li class="list-group-item d-flex justify-content-between align-items-center iq-bg-danger">Demosi : Penurunan Jabatan </li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Divisi Baru</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="pil_divisi_baru" id="pil_divisi_baru" required disabled onChange="getDepartemen();">
                                <option value="0" selected>Non Divisi</option>
                                @foreach($list_divisi as $divisi)
                                <option value="{{ $divisi->id }}">{{ $divisi->nm_divisi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Departemen Baru</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="pil_dept_baru" id="pil_dept_baru" required disabled onChange="getSubDepartemen();">
                                <option value="0" selected>Non Departemen</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Sub Departemen Baru</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="pil_subdept_baru" id="pil_subdept_baru" required disabled onChange="getJabatan();">
                                <option value="0" selected>Non Sub Departemen</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Jabatan Baru</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="pil_jabt_baru" id="pil_jabt_baru" required disabled>
                                @foreach($list_jabatan as $jabatan)
                                <option value="{{ $jabatan->id }}">{{ $jabatan->nm_jabatan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Tanggal Efektif</label>
                        <div class="col-sm-8">
                            <input type="date" name="tgl_eff_baru" id="tgl_eff_baru" class="form-control" required disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Keterangan</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="keterangan" id="keterangan" required disabled></textarea>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" id="tbl_simpan" class="btn btn-primary" disabled>Submit</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-7">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">List Riwayat Mutasi Karyawan</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <table class="table table-hover" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th scope="col" rowspan="2">#</th>
                            <th scope="col" rowspan="2">Nomor/Tanggal</th>
                            <th scope="col" colspan="2" style="text-align: center;">Perubahan Posisi/Jabatan</th>
                        </tr>
                        <tr>
                            <th class="btn-success" style="text-align: center">Posisi/Jabatan Lama</th>
                            <th class="btn-danger" style="text-align: center">Posisi/Jabatan Baru</th>
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
    });
    function getDataKaryawan()
    {
        var id_karyawan = $("#pil_karyawan").val();
        hapus_teks();
        if(id_karyawan==0)
        {
            aktif_teks(true);
        } else {
            $.ajax({
                url: "{{ url('hrd/mutasi/getprofil')}}",
                type : 'post',
                headers : {
                    'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
                },
                data : {id_karyawan:id_karyawan},
                dataType: 'json',
                success : function(res)
                {
                    var len = res.length;
                    var arr_tgl_1 = res.tgl_tmt_jabatan_lm.split("-");
                    $("#sts_lama").html(": "+res.nm_status_lm);
                    $("#divisi_lama").html(": "+res.nm_divisi_lm);
                    $("#departemen_lama").html(": "+res.nm_dept_lm);
                    $("#subdepartemen_lama").html(": "+res.nm_subdept_lm);
                    $("#jabatan_lama").html(": "+res.nm_jabt_lm);
                    $("#tanggal_efektif_lama").html(": "+arr_tgl_1[2]+"-"+arr_tgl_1[1]+"-"+arr_tgl_1[0]);
                    $("#inp_id_divisi_lama").val(res.id_divisi_lm);
                    $("#inp_id_dept_lama").val(res.id_dept_lm);
                    $("#inp_id_subdept_lama").val(res.id_subdept_lm);
                    $("#inp_id_jabatan_lama").val(res.id_jabt_lm);
                    $("#inp_tgl_efektif_lama").val(res.tgl_tmt_jabatan_lm);
                    $("#inp_nomor_surat").val(res.no_surat);
                    aktif_teks(false);

                }
            });
        }
        $("#result_riwayat").load("{{ url('hrd/mutasi/getriwayatmutasi') }}/"+id_karyawan);
    }
    $("#pil_divisi_baru").on("change", function()
    {
        var id_pil = $("#pil_divisi_baru").val();
        hapus_teks_dept_sub();
        if(id_pil==0)
        {
            $("#pil_jabt_baru").load("{{ url('hrd/karyawan/loadjabatandefault') }}");
        } else {
            $("#pil_dept_baru").load("{{ url('hrd/karyawan/loaddepartement') }}/"+id_pil);
            $("#pil_jabt_baru").load("{{ url('hrd/karyawan/loadjabatandivisi') }}/"+id_pil);
        }
    });
    $("#pil_dept_baru").on("change", function()
    {
        var id_pil_divisi = $("#pil_divisi_baru").val();
        var id_pil_dept = $("#pil_dept_baru").val();
        hapus_teks_sub();
        if(id_pil_dept==0)
        {
            $("#pil_jabt_baru").load("{{ url('hrd/karyawan/loadjabatandivisi') }}/"+id_pil_divisi);
        } else {
            $("#pil_subdept_baru").load("{{ url('hrd/karyawan/loadsubdept') }}/"+id_pil_dept);
            $("#pil_jabt_baru").load("{{ url('hrd/karyawan/loadjabatandept') }}/"+id_pil_dept);
        }
    });
    $("#pil_subdept_baru").on("change", function()
    {
        var id_pil_dept = $("#pil_dept_baru").val();
        var id_pil_subdept = $("#pil_subdept_baru").val();
        if(id_pil_subdept==0)
        {
            $("#pil_jabt_baru").load("{{ url('hrd/karyawan/loadjabatandept') }}/"+id_pil_dept);
        } else {
            //$("#pil_subdepartemen").load("{{ url('hrd/karyawan/loadsubdept') }}/"+id_pil_dept);
            $("#pil_jabt_baru").load("{{ url('hrd/karyawan/loadjabatansubdept') }}/"+id_pil_subdept);
        }
    });
    function hapus_teks_dept_sub()
    {
        $("#pil_dept_baru").empty();
        $("#pil_subdept_baru").empty();
        $("#pil_dept_baru").append("<option value='0'>Non Departemen</option>");
        $("#pil_subdept_baru").append("<option value='0'>Non Sub Departemen</option>");
    }
    function hapus_teks_sub()
    {
        $("#pil_subdept_baru").empty();
        $("#pil_subdept_baru").append("<option value='0'>Non Sub Departemen</option>");
    }
    function aktif_teks(tf)
    {
        $('#pil_kategori').get(0).selectedIndex = 0;
        $('#pil_divisi_baru').get(0).selectedIndex = 0;
        $('#pil_dept_baru').get(0).selectedIndex = 0;
        $('#pil_subdept_baru').get(0).selectedIndex = 0;
        $('#pil_jabt_baru').get(0).selectedIndex = 0;
        $("#inp_nomor_surat").attr("disabled", tf);
        $("#inp_tgl_surat").attr("disabled", tf);
        $("#pil_kategori").attr("disabled", tf);
        $("#pil_divisi_baru").attr("disabled", tf);
        $("#pil_dept_baru").attr("disabled", tf);
        $("#pil_subdept_baru").attr("disabled", tf);
        $("#pil_jabt_baru").attr("disabled", tf);
        $("#tgl_eff_baru").attr("disabled", tf);
        $("#keterangan").attr("disabled", tf);
        $("#tbl_simpan").attr("disabled", tf);
    }
    function hapus_teks()
    {
        $("#sts_lama").html(":");
        $("#tanggal_efektif_lama").html(":");
        $("#divisi_lama").html(":");
        $("#departemen_lama").html(":");
        $("#subdepartemen_lama").html(":");
        $("#jabatan_lama").html(":");
        $("#inp_id_divisi_lama").val("");
        $("#inp_id_dept_lama").val("");
        $("#inp_id_subdept_lama").val("");
        $("#inp_id_jabatan_lama").val("");
        $("#inp_tgl_efektif_lama").val("");
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
