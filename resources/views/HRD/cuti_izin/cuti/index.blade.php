@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item">Cuti/Izin Karyawan</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/cutiizin') }}">Monitoring</a></li>
        <li class="breadcrumb-item active" aria-current="page">Form Cuti Karyawan</li>
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
                <form action="{{ url('hrd/cutiizin/simpancuti') }}" method="post" onsubmit="return konfirm()">
                {{ csrf_field() }}
                    <div class=" row align-items-center">
                        <div class="form-group col-sm-12">
                            <label for="pil_karyawan">Pilih Karyawan :</label>
                            <select class="form-control select2" id="pil_karyawan" name="pil_karyawan" onChange="getRiwayatCuti();" style="width: 100%;">
                                <option value="0">-> Pilih Karyawan</option>
                                @foreach($list_karyawan as $list)
                                <option value="{{ $list->id }}">{{ $list->nik." - ".$list->nm_lengkap }}</option>
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
                        <label class="col-sm-4">Tanggal Pengajuan</label>
                        <div class="col-sm-8">
                            <input type="date" name="inp_tgl_pengajuan" id="inp_tgl_pengajuan" class="form-control" required disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Jenis Cuti</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="pil_jenis_cuti" id="pil_jenis_cuti" style="width: 100%;" disabled>
                                <option value="0">Pilihan</option>
                                @foreach($list_jenis_cuti as $jenis)
                                <option value="{{ $jenis->id }}">{{ $jenis->nm_jenis_ci." (".$jenis->lama_cuti." hari)" }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Tanggal Mulai Cuti</label>
                        <div class="col-sm-8">
                            <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control" required disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Tanggal Akhir Cuti</label>
                        <div class="col-sm-8">
                            <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" required disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Jumlah Hari</label>
                        <div class="col-sm-8">
                            <input type="text" name="inp_jumlah_hari" id="inp_jumlah_hari" class="form-control" value="0" required readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Sisa Hak Cuti</label>
                        <div class="col-sm-8">
                            <input type="text" name="inp_sisa_hak" id="inp_sisa_hak" class="form-control" value="0" readonly>
                        </div>
                    </div>
                    <div class="alert text-white bg-danger" role="alert" id="danger-alert" style="display: none;">
                        <div class="iq-alert-icon">
                            <i class="ri-alert-line"></i>
                        </div>
                        <div class="iq-alert-text"></div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Karyawan Pengganti</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" id="pil_pengganti" name="pil_pengganti" style="width: 100%;" disabled>
                                <option value="0">-> Pilih Karyawan</option>
                                @foreach($list_karyawan as $list)
                                <option value="{{ $list->id }}">{{ $list->nik." - ".$list->nm_lengkap }}</option>
                                @endforeach
                            </select>
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
                    <h4 class="card-title">Rekapitulasi Cuti Karyawan Tahun <?php echo date("Y");?></h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <table class="table table-hover" id="tabel_rekap" style="width: 100%; font-size: 12px;">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 5%;">#</th>
                            <th scope="col" style="width: 85%;">Jenis Cuti</th>
                            <th scope="col" style="width: 10%;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody id="result_rekap"></tbody>    
                </table>
            </div>
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">List Riwayat Cuti Karyawan</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <table class="table table-hover" style="width:100%; font-size: 12px;">
                    <thead>
                        <tr>
                            <th scope="col" rowspan="2">#</th>
                            <th scope="col" rowspan="2">Tanggal Pengajuan</th>
                            <th scope="col" rowspan="2">Jenis Cuti</th>
                            <th scope="col" colspan="2" style="text-align: center;">Jadwal Cuti</th>
                            <th scope="col" rowspan="2">Jumlah Hari</th>
                            <th scope="col" rowspan="2">Keterangan</th>
                            <th scope="col" rowspan="2">Pengganti</th>
                        </tr>
                        <tr>
                            <th style="text-align: center">Mulai</th>
                            <th style="text-align: center">Sampai</th>
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
        $("#pil_jenis_cuti").on("change", function()
        {
            var id_karyawan = $("#pil_karyawan").val();
            var id_pil_jenis = $("#pil_jenis_cuti").val();
            if(id_pil_jenis==0)
            {
                hapus_teks_inputan();
            } else {
                hapus_teks_inputan();
                $.ajax({
                    url: "{{ url('hrd/cutiizin/getsisaquotacuti')}}",
                    type : 'post',
                    headers : {
                        'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
                    },
                    data : {id_karyawan:id_karyawan, id_pil_jenis:id_pil_jenis},
                    //dataType: 'json',
                    success : function(res)
                    {
                        $("#inp_sisa_hak").val(res);
                        if(res==0)
                        {
                            aktif_teks_inputan(true);
                            //hapus_teks_inputan();
                        } else {
                            aktif_teks_inputan(false);
                            //hapus_teks_inputan();
                        }
                    }
                });
            }
        });

        $("#tgl_akhir").on("change", function()
        {

            var tgl_1 = $("#tgl_mulai").val();
            var tgl_2 = $("#tgl_akhir").val();
            if(tgl_1=="")
            {
                alert("Masukkan tanggal awal cuti");
                return false;
            } else if(tgl_2=="")
            {
                alert("Masukkan tanggal akhir cuti");
                return false;
            } else {
                $.ajax({
                url: "{{ url('hrd/cutiizin/getjumlahhari')}}",
                type : 'post',
                headers : {
                    'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
                },
                data : {tgl_1:tgl_1, tgl_2:tgl_2},
                //dataType: 'json',
                success : function(res)
                {
                    $("#inp_jumlah_hari").val(res);
                    periksa_quota_cuti();
                }
            });
            }
        });
    });
    function periksa_quota_cuti()
    {
        var jml_hari = $("#inp_jumlah_hari").val();
        var sisa_quota = $("#inp_sisa_hak").val();
        if(parseFloat(jml_hari) > parseFloat(sisa_quota))
        {
            $(".iq-alert-text").html("Maaf. Jumlah Hari Cuti tidak boleh lebih dari Sisa Hak Cuti");
            $("#danger-alert").show(1000);
            $("#tbl_simpan").attr("disabled", true);
        } else if(parseFloat(jml_hari) <= 0)
        {
            $(".iq-alert-text").html("Periksa kolom pilihan tanggal mulai dan akhir cuti anda..");
            $("#danger-alert").show(1000);
            $("#tbl_simpan").attr("disabled", true);
        } else {
            $("#danger-alert").hide(1000);
            $("#tbl_simpan").attr("disabled", false);
        }

    }
    function getRiwayatCuti()
    {
        var id_karyawan = $("#pil_karyawan").val();
        hapus_teks();
        if(id_karyawan==0)
        {
            aktif_teks(true);
            $("#p_profil").hide(1000);
        } else {
            $.ajax({
                url: "{{ url('hrd/karyawan/getprofilkaryawan')}}",
                type : 'post',
                headers : {
                    'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
                },
                data : {id_karyawan:id_karyawan},
                dataType: 'json',
                success : function(res)
                {
                    var len = res.length;
                    $("#nm_status").html(": "+res.nm_status);
                    $("#nm_divisi").html(": "+res.nm_divisi);
                    $("#nm_departemen").html(": "+res.nm_dept);
                    $("#nm_subdepartemen").html(": "+res.nm_subdept);
                    $("#nm_jabatan").html(": "+res.nm_jabt);
                    aktif_teks(false);
                    
                }
            });
            $("#p_profil").show(1000);
        }
        $("#result_rekap").load("{{ url('hrd/cutiizin/getrekapcutikaryawan') }}/"+id_karyawan);
        $("#result_riwayat").load("{{ url('hrd/cutiizin/getlistcutikaryawan') }}/"+id_karyawan);
    }
    function hapus_teks()
    {
        $("#nm_status").html(":");
        $("#nm_divisi").html(":");
        $("#nm_departemen").html(":");
        $("#nm_subdepartemen").html(":");
        $("#nm_jabatan").html(":");
        $("#inp_tgl_pengajuan").val("");
        $("#pil_jenis_cuti").get(0).selectedIndex = 0;
        $("#tgl_mulai").val("");
        $("#tgl_akhir").val("");
        $("#inp_jumlah_hari").val("0");
        $("#inp_sisa_hak").val("0");
        $("#keterangan").val("");
        $("#pil_pengganti").get(0).selectedIndex = 0;
    }
    function hapus_teks_inputan()
    {
        $("#tgl_mulai").val("");
        $("#tgl_akhir").val("");
        $("#inp_jumlah_hari").val("0");
        $("#inp_sisa_hak").val("0");
        $("#keterangan").val("");
        $("#pil_pengganti").get(0).selectedIndex = 0;
    }
    function aktif_teks_inputan(tf)
    {
        $("#tgl_mulai").attr("disabled", tf);
        $("#tgl_akhir").attr("disabled", tf);
        $("#keterangan").attr("disabled", tf);
        $("#pil_pengganti").attr("disabled", tf);
        $("#tbl_simpan").attr("disabled", true);
    }
    function aktif_teks(tf)
    {
        $("#inp_tgl_pengajuan").attr("disabled", tf);
        $("#pil_jenis_cuti").attr("disabled", tf);
        $("#tgl_mulai").attr("disabled", tf);
        $("#tgl_akhir").attr("disabled", tf);
        $("#keterangan").attr("disabled", tf);
        $("#pil_pengganti").attr("disabled", tf);
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