@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item">Cuti/Izin Karyawan</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/cutiizin/daftarpengajuancuti') }}">Persetujuan Pengajuan Cuti</a></li>
        <li class="breadcrumb-item active" aria-current="page">Form Persetujuan Atasan Langsung</li>
        </ul>
    </nav>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-6">
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
            <div class="iq-card-body">
                <form action="{{ url('hrd/cutiizin/simpanpersetujuancuti_al') }}" method="post" onsubmit="return konfirm()">
                {{ csrf_field() }}
                    <input type="hidden" name="id_pengajuan" value="{{ $profil_pengajuan->id }}">
                    <p><b>Profil Karyawan</b></p><hr>
                    <div class="d-flex justify-content-between">
                        <span class="col-sm-5">NIK</span>
                        <span class="col-sm-7">: <b>{{ $profil_pengajuan->profil_karyawan->nik }}</b></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="col-sm-5">Nama Karyawan</span>
                        <span class="col-sm-7">: <b>{{ $profil_pengajuan->profil_karyawan->nm_lengkap }}</b></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="col-sm-5">Status Karyawan</span>
                        <span class="col-sm-7">: <b>{{ $profil_pengajuan->profil_karyawan->get_status_karyawan($profil_pengajuan->profil_karyawan->id_status_karyawan) }}</b></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="col-sm-5">Departemen</span>
                        <span class="col-sm-7">: <b>{{ $profil_pengajuan->profil_karyawan->get_departemen->nm_dept ?? "" }}</b></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="col-sm-5">Sub Departemen</span>
                        <span class="col-sm-7">: <b>{{ $profil_pengajuan->profil_karyawan->get_subdepartemen->nm_subdept ?? "" }}</b></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="col-sm-5">Jabatan</span>
                        <span class="col-sm-7">: <b>{{ $profil_pengajuan->profil_karyawan->get_jabatan->nm_jabatan ?? "" }}</b></span>
                    </div>
                    <hr>
                    <p><b>Data Pengajuan</b></p><hr>
                    <div class="form-group row">
                        <label class="col-sm-4">Tanggal Pengajuan</label>
                        <div class="col-sm-8">
                        <label id="nm_jabatan">: {{ date_format(date_create($profil_pengajuan->tgl_pengajuan), 'd/m/Y') ?? "" }}</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Jenis Cuti</label>
                        <div class="col-sm-8">
                        <label id="nm_jabatan">: {{ $profil_pengajuan->get_jenis_cuti->nm_jenis_ci }}</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Tanggal Mulai Cuti</label>
                        <div class="col-sm-8">
                            <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control" value="{{ $profil_pengajuan->tgl_awal }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Tanggal Akhir Cuti</label>
                        <div class="col-sm-8">
                            <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" value="{{ $profil_pengajuan->tgl_akhir }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Jumlah Hari</label>
                        <div class="col-sm-8">
                            <input type="text" name="inp_jumlah_hari" id="inp_jumlah_hari" class="form-control" value="{{ $profil_pengajuan->jumlah_hari }}" required readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Sisa Hak Cuti</label>
                        <div class="col-sm-8">
                            <input type="text" name="inp_sisa_hak" id="inp_sisa_hak" class="form-control" value="{{ $sisa_quota }}" readonly>
                            <code>* Sisa hak cuti belum termasuk jumlah pengajuan</code>
                        </div>
                    </div>
                    <div class="alert text-white bg-danger" role="alert" id="danger-alert" style="display: none;">
                        <div class="iq-alert-icon">
                            <i class="ri-alert-line"></i>
                        </div>
                        <div class="iq-alert-text"></div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4">Status Persetujuan</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" id="pil_persetujuan" name="pil_persetujuan" style="width: 100%;" required>
                                <option value="1">Setuju</option>
                                <option value="2">Tolak</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12">Karyawan Pengganti</label>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <select class="form-control select2" id="pil_pengganti" name="pil_pengganti" style="width: 100%;" required>
                                <option value=" ">-> Pilih Karyawan</option>
                                @foreach($list_karyawan as $list)
                                <option value="{{ $list->id }}">{{ $list->nik." - ".$list->nm_lengkap }} ({{ $list->get_jabatan->nm_jabatan }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label>Deskripsi Persetujuan</label>
                            <textarea class="form-control" name="keterangan" id="keterangan" required></textarea>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" id="tbl_simpan" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-6">
        <div class="iq-card">
            <div class="iq-card-body" style="width:100%; height:auto">
                <p><b>Rekapitulasi Cuti Karyawan Tahun {{ date("Y") }}</b></p><hr>
                <table class="table table-hover" id="tabel_rekap" style="width: 100%; font-size: 12px;">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 5%;">#</th>
                            <th scope="col" style="width: 85%;">Jenis Cuti</th>
                            <th scope="col" style="width: 10%;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody id="result_rekap">
                    @if(!empty($rekap_cuti))
                        @php $nom=1; @endphp
                        @foreach($rekap_cuti as $key => $j_cuti)
                        <tr>
                            <td>{{ $nom }}</td>
                            <td>{{ $j_cuti['nama'] }}</td>
                            <td>{{ $j_cuti['total'] }}</td>
                        </tr>
                        @php $nom++; @endphp
                        @endforeach
                    @endif
                    </tbody>    
                </table>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <p><b>List Riwayat Cuti Karyawan</b></p><hr>
                <table class="table table-hover table-responsive" style="width:100%; font-size: 12px;">
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
                    <tbody id="result_riwayat">
                    @if(!empty($riwayat_cuti))
                        @php $nom=1; @endphp
                        @foreach($riwayat_cuti as $l_cuti)
                        <tr>
                            <td>{{ $nom }}</td>
                            <td>{{ date_format(date_create($l_cuti->tgl_pengajuan), 'd-m-Y') }}</td>
                            <td>{{ $l_cuti->get_jenis_cuti->nm_jenis_ci }}</td>
                            <td>{{ date_format(date_create($l_cuti->tgl_awal), 'd-m-Y') }}</td>
                            <td>{{ date_format(date_create($l_cuti->tgl_akhir), 'd-m-Y') }}</td>
                            <td>{{ $l_cuti->jumlah_hari }}</td>
                            <td>{{ $l_cuti->ket_cuti }}</td>
                            <td>
                            @if(!empty($l_cuti->id_pengganti))
                            {{ $l_cuti->get_karyawan_pengganti->nm_lengkap }}
                            @endif</td>
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