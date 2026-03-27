@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item">Perjalanan Dinas</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/perjalanandinas') }}">Monitoring</a></li>
        <li class="breadcrumb-item active" aria-current="page">Form Perjalanan Dinas</li>
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
                <form action="{{ url('hrd/perjalanandinas/simpanperdis') }}" method="post" onsubmit="return konfirm()">
                {{ csrf_field() }}
                    <div class=" row align-items-center">
                        <div class="form-group col-sm-12">
                            <label for="pil_karyawan">Pilih Karyawan :</label>
                            <select class="form-control select2" id="pil_karyawan" name="pil_karyawan" onChange="getProfilKaryawan();" style="width: 100%;">
                                <option value="0">-> Pilih Karyawan</option>
                                @foreach($list_karyawan as $list)
                                <option value="{{ $list->id }}">{{ $list->nik." - ".$list->nm_lengkap }}{{ (!empty($list->id_jabatan) ? " - ".$list->get_jabatan->nm_jabatan : "") }}{{ (!empty($list->id_departemen) ? " - ".$list->get_departemen->nm_dept : "") }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="p_profil" style="display: none;">
                        <hr>
                        <div class="form-group row">
                            <label class="col-sm-4">Status Karyawan</label>
                            <div class="col-sm-8">
                            <label id="nm_status">:</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4">Divisi</label>
                            <div class="col-sm-8">
                            <label id="nm_divisi">:</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4">Departemen</label>
                            <div class="col-sm-8">
                            <label id="nm_departemen">:</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4">Sub Departemen</label>
                            <div class="col-sm-8">
                            <label id="nm_subdepartemen">:</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4">Jabatan</label>
                            <div class="col-sm-8">
                            <label id="nm_jabatan">:</label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label class="col-sm-4">Nomor Surat</label>
                        <div class="col-sm-8">
                            <input type="text" name="inp_nomor_surat" id="inp_nomor_surat" class="form-control" maxlength="20" required readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Tanggal Surat</label>
                        <div class="col-sm-8">
                            <input type="date" name="inp_tgl_surat" id="inp_tgl_surat" class="form-control" required disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Maksud dan Tujuan</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="inp_maksud_tujuan" id="inp_maksud_tujuan" required disabled></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4">Tanggal Berangkat</label>
                        <div class="col-sm-8">
                            <input type="date" name="tgl_berangkat" id="tgl_berangkat" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Tanggal Kembali</label>
                        <div class="col-sm-8">
                            <input type="date" name="tgl_kembali" id="tgl_kembali" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Fasiltas Perjalanan</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="pil_fasilitas" id="pil_fasilitas">
                                @foreach($list_fasilitas as $fasilitas)
                                <option value="{{ $fasilitas->id }}">{{ $fasilitas->nm_fasilitas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Uang Saku Perjalanan</label>
                        <div class="col-sm-8">
                            <input type="text" name="inp_uang_saku" id="inp_uang_saku" class="form-control angka" style="text-align: right" value="0" required disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Keterangan</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="keterangan" id="keterangan" required disabled></textarea>
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
                    <h4 class="card-title">List Riwayat Perjalana Dinas Karyawan</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <table class="table table-hover" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th scope="col" rowspan="2">#</th>
                            <th scope="col" rowspan="2">Nomor/Tanggal</th>
                            <th scope="col" rowspan="2">Maksud dan Tujuan</th>
                            <th scope="col" colspan="2" style="text-align: center;">Tanggal Perjalanan</th>
                            <th scope="col" rowspan="2">Fasilitas</th>
                            <th scope="col" rowspan="2">Uang Saku</th>
                            <th scope="col" rowspan="2">Keterangan</th>
                        </tr>
                        <tr>
                            <th style="text-align: center">Berangkat</th>
                            <th style="text-align: center">Kembali</th>
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
        $(".angka").number(true, 0);
        $(".select2").select2();
    });
    function getProfilKaryawan()
    {
        var id_karyawan = $("#pil_karyawan").val();
        hapus_teks();
        if(id_karyawan==0)
        {
            aktif_teks(true);
            $("#p_profil").hide(1000);
        } else {
            $("#p_profil").show(1000);
            $.ajax({
                url: "{{ url('hrd/perjalanandinas/get_profil_karyawan')}}",
                type : 'post',
                headers : {
                    'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
                },
                data : {id_karyawan:id_karyawan},
                dataType: 'json',
                success : function(res)
                {
                    var len = res.length;
                    $("#inp_nomor_surat").val(res.nom_perdis);
                    $("#nm_status").html(": "+res.nm_status);
                    $("#nm_divisi").html(": "+res.nm_divisi);
                    $("#nm_departemen").html(": "+res.nm_dept);
                    $("#nm_subdepartemen").html(": "+res.nm_subdept);
                    $("#nm_jabatan").html(": "+res.nm_jabt);
                }
            });
            aktif_teks(false);
        }
        $("#result_riwayat").load("{{ url('hrd/perjalanandinas/getlistperdiskaryawan') }}/"+id_karyawan);
    }
    function hapus_teks()
    {
        $("#nm_status").html(":");
        $("#nm_divisi").html(":");
        $("#nm_departemen").html(":");
        $("#nm_subdepartemen").html(":");
        $("#nm_jabatan").html(":");
        $("#inp_nomor_surat").val("");
        $("#inp_tgl_surat").val("");
        $("#inp_maksud_tujuan").val("");
        $("#tgl_berangkat").val("");
        $("#tgl_kembali").val("");
        $("#pil_fasilitas").get(0).selectedIndex = 0;
        $("#inp_uang_saku").val("0");
        $("#keterangan").val("");
    }
    function aktif_teks(tf)
    {
        //$("#inp_nomor_surat").attr("disabled", tf);
        $("#inp_tgl_surat").attr("disabled", tf);
        $("#inp_maksud_tujuan").attr("disabled", tf);
        $("#tgl_berangkat").attr("disabled", tf);
        $("#tgl_kembali").attr("disabled", tf);
        $("#pil_fasilitas").attr("disabled", tf);
        $("#inp_uang_saku").attr("disabled", tf);
        $("#keterangan").attr("disabled", tf);
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
