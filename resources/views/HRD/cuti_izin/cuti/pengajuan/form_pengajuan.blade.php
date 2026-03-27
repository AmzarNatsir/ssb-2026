@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Form Pengajuan Cuti</li>
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
                    <h4 class="card-title">Input Pengajuan</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <form action="{{ url('hrd/cutiizin/simpanpengajuancuti') }}" method="post" onsubmit="return konfirm()">
                {{ csrf_field() }}
                    <input type="hidden" name="id_user" id="id_user" value="{{ auth()->user()->karyawan->id }}">
                    <div class="form-group row">
                        <label class="col-sm-4">Jenis Cuti</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="pil_jenis_cuti" id="pil_jenis_cuti" style="width: 100%;">
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
                            <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control" value="{{ date('Y/m/d') }}" required disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Tanggal Akhir Cuti</label>
                        <div class="col-sm-8">
                            <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" value="{{ date('Y/m/d') }}" required disabled>
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
                    <h4 class="card-title">Riwayat Cuti</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <table class="table table-hover" style="width:100%; font-size: 12px;">
                    <thead>
                        <tr>
                            <th scope="col" rowspan="2">#</th>
                            <th scope="col" rowspan="2" style="width: 10%;">Tanggal</th>
                            <th scope="col" rowspan="2" style="width: 30%;">Jadwal Cuti</th>
                            <th scope="col" colspan="2" style="text-align: center;">Persetujuan</th>
                        </tr>
                        <tr>
                            <th style="text-align: center" style="width: 30%;">Atasan Langsung</th>
                            <th style="text-align: center" style="width: 30%;">HRD</th>
                        </tr>
                    </thead>
                    <tbody id="result_riwayat">
                    @if(!empty($list_riwayat_cuti))
                        @php $nom=1; @endphp
                        @foreach($list_riwayat_cuti as $l_cuti)
                        <tr>
                            <td>{{ $nom }}</td>
                            <td>{{ date_format(date_create($l_cuti->tgl_pengajuan), 'd-m-Y') }}</td>
                            <td>Jenis Cuti : <b>{{ $l_cuti->get_jenis_cuti->nm_jenis_ci }}</b><br>
                            Tanggal Cuti : <b>{{ date_format(date_create($l_cuti->tgl_awal), 'd-m-Y') }} s/d {{ date_format(date_create($l_cuti->tgl_akhir), 'd-m-Y') }}</b><br>
                            Jumlah Hari : <b>{{ $l_cuti->jumlah_hari }} hari</b><br>
                            Keterangan : <b>{{ $l_cuti->ket_cuti }}</b>
                            </td>
                            <td>
                            @if(empty($l_cuti->sts_pengajuan))
                                @if(empty($l_cuti->id_atasan))
                                    @if(date('Y-m-d') >= date_format(date_create($l_cuti->tgl_awal), 'Y-m-d'))
                                        Status : <b>Tidak Diproses</b>
                                    @else
                                        Status : <b>Belum Diproses</b>
                                    @endif
                                @else
                                    Status : <b>
                                    @if($l_cuti->sts_appr_atasan==1)
                                        Disetujui
                                    @else
                                        Ditolak
                                    @endif</b>
                                    <br>Tanggal : <b>{{ date_format(date_create($l_cuti->tgl_appr_atasan), 'd-m-Y') }}</b><br>
                                    Keterangan : <b>{{ $l_cuti->ket_appr_atasan }}</b><br>
                                    Pengganti : <b>
                                    @if(!empty($l_cuti->id_pengganti))
                                        {{ $l_cuti->get_karyawan_pengganti->nm_lengkap }} | 
                                        {{ $l_cuti->get_karyawan_pengganti->get_jabatan->nm_jabatan }}
                                    @endif
                                    </b>
                                @endif
                            @else
                                Pengganti : <b>
                                @if(!empty($l_cuti->id_pengganti))
                                    {{ $l_cuti->get_karyawan_pengganti->nm_lengkap }}
                                @endif</b>
                                <br>(Dicatat Oleh Admin)
                            @endif
                            </td>
                            <td>
                            @if(empty($l_cuti->sts_pengajuan))
                                @if(empty($l_cuti->id_persetujuan))
                                    @if(date('Y-m-d') < date_format(date_create($l_cuti->tgl_awal), 'Y-m-d'))
                                        Status : <b>Belum Diproses</b>
                                    @endif
                                @else
                                    Status : <b>
                                    @if($l_cuti->sts_persetujuan==1)
                                        Disetujui
                                    @else
                                        Ditolak
                                    @endif</b>
                                    <br>Tanggal : <b>{{ date_format(date_create($l_cuti->tgl_persetujuan), 'd-m-Y') }}</b><br>
                                    Keterangan : <b>{{ $l_cuti->ket_persetujuan }}</b>
                                @endif
                            @else
                                Dicatat Oleh Admin
                            @endif
                            </td>
                        </tr>
                        @php $nom++; @endphp
                        @endforeach
                    @endif
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
        $(".select2").select2();
        $("#pil_jenis_cuti").on("change", function()
        {
            var id_karyawan = $("#id_user").val();
            var id_pil_jenis = $("#pil_jenis_cuti").val();
            if(id_pil_jenis==0)
            {
                hapus_teks_inputan();
            } else {
                //hapus_teks_inputan();
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