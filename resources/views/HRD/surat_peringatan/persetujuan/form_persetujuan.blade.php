@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item">Pengajuan Rekomendasi Penernitan SP</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/suratperingatan/daftarpengajuansphrd') }}">Daftar Pengajuan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Form Persetujuan HRD</li>
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
                    <span class="col-sm-4">Tgl.Pengajuan</span>
                    <span class="col-sm-8">: <b>{{ date_format(date_create($profil_pengajuan->tgl_pengajuan), 'd/m/Y') ?? "" }}</b></span>
                </div>

                <div class="d-flex justify-content-between">
                    <span class="col-sm-4">Tingkatan Sanksi</span>
                    <span class="col-sm-8">: <b>{{ $profil_pengajuan->get_master_jenis_sp_diajukan->nm_jenis_sp }}</b></span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="col-sm-12">Uraian Pelanggaran :</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="col-sm-12"><b>{{ $profil_pengajuan->uraian_pelanggaran }}</b></span>
                </div>
                <hr>
                <p><b>Diajukan Oleh :</b></p><hr>
                <div class="d-flex justify-content-between">
                    <span class="col-sm-4">Nama</span>
                    <span class="col-sm-8">: <b>{{ $profil_pengajuan->profil_atasan_langsung->nm_lengkap }}</b></span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="col-sm-4">Departemen</span>
                    <span class="col-sm-8">: <b>{{ $profil_pengajuan->profil_atasan_langsung->get_departemen->nm_dept }}</b></span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="col-sm-4">Jabatan</span>
                    <span class="col-sm-8">: <b>{{ $profil_pengajuan->profil_atasan_langsung->get_jabatan->nm_jabatan }}</b></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-4">
        <div class="iq-card" id="page_view">
            <div class="iq-card-body">
                <p><b>Form Persetujuan</b></p><hr>
                <form action="{{ url('hrd/cutiizin/simpanpersetujuancuti_hrd') }}" method="post" onsubmit="return konfirm()">
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
    <div class="col-sm-12 col-lg-12">
        <div class="iq-card">
            <div class="iq-card-body" style="width:100%; height:auto">
                <p><b>List Riwayat Sanksi Karyawan</b></p>
                <table class="table table-hover" style="width:100%; font-size: 12px;">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Tingkatan Sanksi</th>
                            <th scope="col">Uraian Pelanggaran</th>
                        </tr>
                    </thead>
                    <tbody id="result_riwayat">
                    @if(!empty($riwayat_sp))
                        @php $nom=1; @endphp
                        @foreach($riwayat_sp as $l_sp)
                        <tr>
                            <td>{{ $nom }}</td>
                            <td>{{ date_format(date_create($l_sp->tgl_sp), 'd-m-Y') }}</td>
                            <td>{{ $l_sp->get_master_jenis_sp_disetujui->nm_jenis_sp }}</td>
                            <td>{{ $l_sp->uraian_pelanggaran }}</td>
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
