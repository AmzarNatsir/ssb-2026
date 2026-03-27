@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item">Perubahan Status</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/perubahanstatus') }}">Monitoring</a></li>
        <li class="breadcrumb-item active" aria-current="page">Form Perubahan Status</li>
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
                <form action="{{ url('hrd/perubahanstatus/simpan') }}" method="post" onsubmit="return konfirm()">
                {{ csrf_field() }}
                    <input type="hidden" name="frm_baru" id="frm_baru" value="1">
                    <div class=" row align-items-center">
                        <div class="form-group col-sm-12">
                            <label for="pil_karyawan">Pilih Karyawan :</label>
                            <select class="form-control select2" id="pil_karyawan" name="pil_karyawan" onChange="getDataKaryawan();" style="width: 100%;">
                                <option value="0">-> Pilih Karyawan</option>
                                @foreach($list_karyawan as $list)
                                <option value="{{ $list->id }}">{{ $list->nik." - ".$list->nm_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <ul class="list-group" style="margin-bottom: 15px">
                        <li class="list-group-item active">Status Karyawan Saat Ini</li>
                    </ul>
                    <div class="form-group row">
                        <label class="col-sm-4">Status Karyawan</label>
                        <div class="col-sm-8">
                        <input type="hidden" name="inp_id_status_lama" id="inp_id_status_lama">
                        <label id="sts_lama">:</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Tanggal Efektif</label>
                        <div class="col-sm-8">
                        <input type="hidden" name="inp_tgl_eff_lama" id="inp_tgl_eff_lama">
                        <label id="tgl_eff_lama">:</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Tanggal Berakhir</label>
                        <div class="col-sm-8">
                        <input type="hidden" name="inp_tgl_akh_lama" id="inp_tgl_akh_lama">
                        <label id="tgl_akh_lama">:</label>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label class="col-sm-4">Nomor Surat</label>
                        <div class="col-sm-8">
                            <input type="text" name="inp_nomor_surat" id="inp_nomor_surat" maxlength="50" class="form-control" required disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Tanggal Surat</label>
                        <div class="col-sm-8">
                            <input type="date" name="inp_tgl_surat" id="inp_tgl_surat" class="form-control" required disabled>
                        </div>
                    </div>
                    <ul class="list-group" style="margin-bottom: 15px">
                        <li class="list-group-item active">Perubahan Status Karyawan</li>
                    </ul>
                    <div class="form-group row">
                        <label class="col-sm-4">Status Karyawan Baru</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="pil_sts_baru" id="pil_sts_baru" required disabled onChange="validasiPilihan();">
                                @foreach($list_status as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Tanggal Efektif</label>
                        <div class="col-sm-8">
                            <input type="date" name="tgl_eff_mulai_baru" id="tgl_eff_mulai_baru" class="form-control" required disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Tanggal Berakhir</label>
                        <div class="col-sm-8">
                            <input type="date" name="tgl_eff_akhir_baru" id="tgl_eff_akhir_baru" class="form-control" required disabled>
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
                    <h4 class="card-title">List Riwayat Perubahan Status Karyawan</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <table class="table table-hover" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th scope="col" rowspan="3">#</th>
                            <th scope="col" rowspan="3">Nomor/Tanggal</th>
                            <th scope="col" colspan="6" style="text-align: center;">Perubahan Status</th>
                        </tr>
                        <tr>
                            <th colspan="3" class="btn-success" style="text-align: center">Status Lama</th>
                            <th colspan="3" class="btn-danger" style="text-align: center">Status Baru</th>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <th>Efektif</th>
                            <th>Berakhir</th>
                            <th>Status</th>
                            <th>Efektif</th>
                            <th>Berakhir</th>
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
        if(id_karyawan==0)
        {
            hapus_teks();
            aktif_teks(true);
        } else {
            $.ajax({
                url: "{{ url('hrd/perubahanstatus/getprofil')}}",
                type : 'post',
                headers : {
                    'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
                },
                data : {id_karyawan:id_karyawan},
                dataType: 'json',
                success : function(res)
                {
                    var len = res.length;
                    var arr_tgl_1 = res.tgl_eff_lm.split("-");
                    $("#inp_id_status_lama").val(res.id_status_lm);
                    $("#inp_tgl_eff_lama").val(res.tgl_eff_lm);
                    $("#inp_tgl_akh_lama").val(res.tgl_akh_lm);
                    $("#sts_lama").html(": "+res.nm_status_lm);
                    $("#tgl_eff_lama").html(": "+arr_tgl_1[2]+"-"+arr_tgl_1[1]+"-"+arr_tgl_1[0]);
                    $("#inp_nomor_surat").val(res.no_surat);
                    if(res.id_status_lm>=3) { // == null) {
                        $("#tgl_akh_lama").html(":");
                        aktif_teks(true);
                    } else {
                        var arr_tgl_2 = res.tgl_akh_lm.split("-");
                        $("#tgl_akh_lama").html(": "+arr_tgl_2[2]+"-"+arr_tgl_2[1]+"-"+arr_tgl_2[0]);
                        aktif_teks(false);
                    }

                }
            });
        }
        $("#result_riwayat").load("{{ url('hrd/perubahanstatus/getriwayat') }}/"+id_karyawan);
    }
    function validasiPilihan()
    {
        var id_pilihan = $("#pil_sts_baru").val();
        if(parseInt(id_pilihan) <=2)
        {
            $("#tgl_eff_akhir_baru").attr("disabled", false);
            $("#tgl_eff_akhir_baru").attr("required", true);
        } else {
            $("#tgl_eff_akhir_baru").attr("disabled", true);
            $("#tgl_eff_akhir_baru").attr("required", false);
        }
    }
    function aktif_teks(tf)
    {
        $('#pil_sts_baru').get(0).selectedIndex = 0;
        $("#inp_nomor_surat").attr("disabled", tf);
        $("#inp_tgl_surat").attr("disabled", tf);
        $("#pil_sts_baru").attr("disabled", tf);
        $("#tgl_eff_mulai_baru").attr("disabled", tf);
        $("#tgl_eff_akhir_baru").attr("disabled", tf);
        $("#tbl_simpan").attr("disabled", tf);
    }
    function hapus_teks()
    {
        $("#sts_lama").html(":");
        $("#tgl_eff_lama").html(":");
        $("#tgl_akh_lama").html(":");
        $("#inp_id_status_lama").val("");
        $("#inp_tgl_eff_lama").val("");
        $("#inp_tgl_akh_lama").val("");
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
