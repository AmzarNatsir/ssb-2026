@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/karyawan/daftar') }}">Daftar Karyawan</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/karyawan/profil/'.$res->id) }}">Profil Karyawan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Riwayat Pendidikan</li>
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
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Data Riwayat Pendidikan</h4>
                </div>
                <div class="user-post-data p-3">
                    <div class="d-flex flex-wrap">
                        <div class="media-support-user-img mr-3">
                            <img class="rounded-circle img-fluid" src="{{ asset('upload/photo/'.$res->photo) }}" alt="">
                        </div>
                        <div class="media-support-info mt-2">
                            <h5 class="mb-0">{{ $res->nm_lengkap }}</h5>
                            <p class="mb-0 text-primary">{{ $res->nik }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="iq-card-body">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-5" id="page_view">
                            <form action="{{ url('hrd/karyawan/simpanrwytpendidikan') }}" method="post" onsubmit="return konfirm()" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="id_karyawan" value="{{ $res->id }}">
                                <div class="iq-card-header d-flex justify-content-between">
                                    <div class="iq-header-title">
                                        <h4 class="card-title">Tambah Data Baru</h4>
                                    </div>
                                </div>
                                <div class="iq-card iq-card-block iq-card-stretch">
                                    <div class="iq-card-body">
                                        <div class="row align-items-center">
                                            <div class="form-group col-sm-12">
                                                <label for="pil_jenjang">Jenjang Pendidikan :</label>
                                                <select class="form-control" id="pil_jenjang" name="pil_jenjang">
                                                    @foreach($list_jenjang as $key => $jenjang)
                                                    <option value="{{ $key }}">{{ $jenjang }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="form-group col-sm-12">
                                                <label for="inp_nama">Nama Sekolah/Perguruan Tinggi :</label>
                                                <input type="text" class="form-control" name="inp_nama" id="inp_nama" maxlength="150" required>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="form-group col-sm-12">
                                                <label for="inp_alamat">Alamat :</label>
                                                <input type="text" class="form-control" name="inp_alamat" id="inp_alamat" maxlength="200" required>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="form-group col-sm-12">
                                                <label for="inp_tahun_mulai">Tahun Pendidikan :</label>
                                                <div class="row">
                                                    <div class="col">
                                                        <input type="text" class="form-control tahun_mask" name="inp_tahun_mulai" id="inp_tahun_mulai" placeholder="Mulai Tahun" maxlength="4" required>
                                                    </div>
                                                    <div class="col">
                                                        <input type="text" class="form-control tahun_mask" name="inp_tahun_akhir" id="inp_tahun_akhir" placeholder="Sampai Tahun" maxlength="4" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <button type="submit" id="tbl_simpan" class="btn btn-primary"><i class="fa fa-save"></i> Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-7">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">Daftar Keluarga</h4>
                                </div>
                            </div>
                            <div class="iq-card iq-card-block iq-card-stretch">
                                <div class="iq-card-body">
                                    <table class="table">
                                        <thead>
                                            <th>No.</th>
                                            <th>Jenjang Pendidikan</th>
                                            <th>Nama Sekolah/Perguruan Tinggi</th>
                                            <th>Alamat</th>
                                            <th>Tahun Pendidikan</th>
                                            <th></th>
                                        </thead>
                                        <tbody>
                                        @php $nom=1; @endphp
                                        @foreach($list_rwyt_pendidikan as $pendidikan)
                                        <tr>
                                            <td>{{$nom}}</td>
                                            <td>{{ $pendidikan->get_jenjang_pendidikan($pendidikan->id_jenjang) }}</td>
                                            <td>{{ $pendidikan->nm_sekolaj_pt }}</td>
                                            <td>{{ $pendidikan->alamat }}</td>
                                            <td>{{ $pendidikan->mulai_tahun." s/d".$pendidikan->sampai_tahun }}</td>
                                            <td>
                                                <div class="flex align-items-center list-user-action">
                                                    <a class="btn_edit" id="{{ $pendidikan->id }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="{{ url('hrd\karyawan\editrwytpendidikan') }}\{{ $pendidikan->id }}"><i class="ri-pencil-line"></i></a>
                                                    <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Hapus" href="{{ url('hrd\karyawan\hapusrwytpendidikan') }}/{{$pendidikan->id}}/{{$res->id}}" onClick="return hapusKonfirm()"><i class="ri-delete-bin-line"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        @php $nom++; @endphp
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $('.tahun_mask').mask('0000');
    });
    function konfirm()
    {
        var psn = confirm("Yakin akan menyimpan data ?");
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
    function hapusKonfirm()
    {
        var psn = confirm("Yakin akan menghapus data ?")
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
</script>
@endsection