@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item">Cuti/Izin Karyawan</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/cutiizin/daftarpengajuanizin') }}">Persetujuan Pengajuan Izin</a></li>
        <li class="breadcrumb-item active" aria-current="page">Form Persetujuan Atasan Langsung</li>
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
    <div class="col-sm-12 col-lg-4">
        <div class="iq-card" id="page_view">
            <div class="iq-card-body">
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
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-4">
        <div class="iq-card" id="page_view">
            <div class="iq-card-body">
                <p><b>Data Pengajuan</b></p><hr>
                <div class="d-flex justify-content-between">
                    <span class="col-sm-5">Tgl.Pengajuan</span>
                    <span class="col-sm-7">: <b>{{ date_format(date_create($profil_pengajuan->tgl_pengajuan), 'd/m/Y') ?? "" }}</b></span>
                </div>

                <div class="d-flex justify-content-between">
                    <span class="col-sm-5">Jenis Cuti</span>
                    <span class="col-sm-7">: <b>{{ $profil_pengajuan->get_jenis_izin->nm_jenis_ci }}</b></span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="col-sm-5">Tanggal Cuti</span>
                    <span class="col-sm-7">: <b>{{ date_format(date_create($profil_pengajuan->tgl_awal), 'd/m/Y') ?? "" }} s/d {{ date_format(date_create($profil_pengajuan->tgl_akhir), 'd/m/Y') ?? "" }}</b></span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="col-sm-5">Jumlah Hari</span>
                    <span class="col-sm-7">: <b>{{ $profil_pengajuan->jumlah_hari }} Hari</b></span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="col-sm-5">Alasan Pengajuan</span>
                    <span class="col-sm-7">: <b>{{ $profil_pengajuan->ket_izin }} Hari</b></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-4">
        <div class="iq-card" id="page_view">
            <div class="iq-card-body">
                <p><b>Form Persetujuan</b></p><hr>
                <form action="{{ url('hrd/cutiizin/simpanpersetujuanizin_al') }}" method="post" onsubmit="return konfirm()">
                {{ csrf_field() }}
                    <input type="hidden" name="id_pengajuan" value="{{ $profil_pengajuan->id }}">
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
    <div class="col-sm-12 col-lg-5">
        <div class="iq-card">
            <div class="iq-card-body" style="width:100%; height:auto">
                <p><b>Rekapitulasi Izin Karyawan Tahun {{ date("Y") }}</b></p>
                <table class="table table-hover" id="tabel_rekap" style="width: 100%; font-size: 12px;">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 5%;">#</th>
                            <th scope="col" style="width: 85%;">Jenis Izin</th>
                            <th scope="col" style="width: 10%;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody id="result_rekap">
                    @if(!empty($rekap_izin))
                        @php $nom=1; @endphp
                        @foreach($rekap_izin as $key => $j_izin)
                        <tr>
                            <td>{{ $nom }}</td>
                            <td>{{ $j_izin['nama'] }}</td>
                            <td>{{ $j_izin['total'] }}</td>
                        </tr>
                        @php $nom++; @endphp
                        @endforeach
                    @endif
                    </tbody>    
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-7">
        <div class="iq-card">
            <div class="iq-card-body" style="width:100%; height:auto">
                <p><b>List Riwayat Izin Karyawan</b></p>
                <table class="table table-hover" style="width:100%; font-size: 12px;">
                    <thead>
                        <tr>
                            <th scope="col" rowspan="2">#</th>
                            <th scope="col" rowspan="2">Tanggal Pengajuan</th>
                            <th scope="col" rowspan="2">Jenis Izin</th>
                            <th scope="col" colspan="2" style="text-align: center;">Jadwal Izin</th>
                            <th scope="col" rowspan="2">Jumlah Hari</th>
                            <th scope="col" rowspan="2">Keterangan</th>
                        </tr>
                        <tr>
                            <th style="text-align: center">Mulai</th>
                            <th style="text-align: center">Sampai</th>
                        </tr>
                    </thead>
                    <tbody id="result_riwayat">
                    @if(!empty($riwayat_izin))
                        @php $nom=1; @endphp
                        @foreach($riwayat_izin as $l_izin)
                        <tr>
                            <td>{{ $nom }}</td>
                            <td>{{ date_format(date_create($l_izin->tgl_pengajuan), 'd-m-Y') }}</td>
                            <td>{{ $l_izin->get_jenis_izin->nm_jenis_ci }}</td>
                            <td>{{ date_format(date_create($l_izin->tgl_awal), 'd-m-Y') }}</td>
                            <td>{{ date_format(date_create($l_izin->tgl_akhir), 'd-m-Y') }}</td>
                            <td>{{ $l_izin->jumlah_hari }}</td>
                            <td>{{ $l_izin->ket_izin }}</td>
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