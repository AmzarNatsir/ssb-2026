@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Form Pengajuan Izin</li>
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
                <form action="{{ url('hrd/cutiizin/simpanpengajuanizin') }}" method="post" onsubmit="return konfirm()">
                {{ csrf_field() }}
                    <div class="form-group row">
                        <label class="col-sm-4">Jenis Izin</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="pil_jenis_izin" id="pil_jenis_izin">
                                <option value="0">Pilihan</option>
                                @foreach($list_jenis_izin as $jenis)
                                <option value="{{ $jenis->id }}">{{ $jenis->nm_jenis_ci }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Tanggal Mulai Izin</label>
                        <div class="col-sm-8">
                            <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Tanggal Akhir Izin</label>
                        <div class="col-sm-8">
                            <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Jumlah Hari</label>
                        <div class="col-sm-8">
                            <input type="text" name="inp_jumlah_hari" id="inp_jumlah_hari" class="form-control" value="0" required readonly>
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
                            <textarea class="form-control" name="keterangan" id="keterangan" required></textarea>
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
                    <h4 class="card-title">Riwayat Izin</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <table class="table table-hover" style="font-size: 12px;">
                <thead>
                        <tr>
                            <th scope="col" rowspan="2">#</th>
                            <th scope="col" rowspan="2" style="width: 10%;">Tanggal</th>
                            <th scope="col" rowspan="2" style="width: 30%;">Data Pengajuan</th>
                            <th scope="col" colspan="2" style="text-align: center;">Persetujuan</th>
                        </tr>
                        <tr>
                            <th style="text-align: center" style="width: 30%;">Atasan Langsung</th>
                            <th style="text-align: center" style="width: 30%;">HRD</th>
                        </tr>
                    </thead>
                    <tbody id="result_riwayat">
                    @if(!empty($riwayat_izin))
                        @php $nom=1; @endphp
                        @foreach($riwayat_izin as $l_izin)

                        <tr>
                            <td>{{ $nom }}</td>
                            <td>{{ date_format(date_create($l_izin->tgl_pengajuan), 'd-m-Y') }}</td>
                            <td>Jenis Izin : <b>{{ $l_izin->get_jenis_izin->nm_jenis_ci }}</b><br>
                            Tanggal Izin : <b>{{ date_format(date_create($l_izin->tgl_awal), 'd-m-Y') }} s/d {{ date_format(date_create($l_izin->tgl_akhir), 'd-m-Y') }}</b><br>
                            Jumlah Hari : <b>{{ $l_izin->jumlah_hari }} hari</b><br>
                            Keterangan : <b>{{ $l_izin->ket_izin }}</b>
                            </td>
                            <td>
                            @if(empty($l_izin->sts_pengajuan))
                                @if(empty($l_izin->id_atasan))
                                    @if(date('Y-m-d') > date_format(date_create($l_izin->tgl_awal), 'Y-m-d'))
                                        Status : <b>Tidak Diproses</b>
                                    @else
                                        Status : <b>Belum Diproses</b>
                                    @endif
                                @else
                                    Status : <b>
                                    @if($l_izin->sts_appr_atasan==1)
                                        Disetujui
                                    @else
                                        Ditolak
                                    @endif</b>
                                    <br>Tanggal : <b>{{ date_format(date_create($l_izin->tgl_appr_atasan), 'd-m-Y') }}</b><br>
                                    Keterangan : <b>{{ $l_izin->ket_appr_atasan }}</b><br>
                                    </b>
                                @endif
                            @else
                                <br>(Dicatat Oleh Admin)
                            @endif
                            </td>
                            <td>
                            @if(empty($l_izin->sts_pengajuan))
                                @if(empty($l_izin->id_persetujuan))
                                    @if(date('Y-m-d') < date_format(date_create($l_izin->tgl_awal), 'Y-m-d'))
                                        Status : <b>Belum Diproses</b>
                                    @endif
                                @else
                                    Status : <b>
                                    @if($l_izin->sts_persetujuan==1)
                                        Disetujui
                                    @else
                                        Ditolak
                                    @endif</b>
                                    <br>Tanggal : <b>{{ date_format(date_create($l_izin->tgl_persetujuan), 'd-m-Y') }}</b><br>
                                    Keterangan : <b>{{ $l_izin->ket_persetujuan }}</b>
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
        $("#tgl_akhir").on("change", function()
        {

            var tgl_1 = $("#tgl_mulai").val();
            var tgl_2 = $("#tgl_akhir").val();
            if(tgl_1=="")
            {
                alert("Masukkan tanggal awal izin");
                return false;
            } else if(tgl_2=="")
            {
                alert("Masukkan tanggal akhir izin");
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
                    if(parseFloat(res) <= 0)
                    {
                        $(".iq-alert-text").html("Periksa kolom pilihan tanggal mulai dan akhir izin anda..");
                        $("#danger-alert").show(1000);
                        $("#tbl_simpan").attr("disabled", true);
                    } else {
                        $("#danger-alert").hide(1000);
                        $("#tbl_simpan").attr("disabled", false);
                    }
                }
            });
            }
        });
    });
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