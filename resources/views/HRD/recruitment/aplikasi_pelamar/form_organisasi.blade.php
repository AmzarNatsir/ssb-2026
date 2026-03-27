@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Recruitment</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/recruitment/aplikasi_pelamar') }}">Aplikasi Pelamar</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/recruitment/aplikasi_pelamar/data_lain/'.$profil->id) }}">Profil Pelamar</a></li>
        <li class="breadcrumb-item">Data Pengalaman Organisasi</li>
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
                    <h4 class="card-title">Data Pengalaman Organisasi</h4>
                </div>
                <div class="user-post-data p-3">
                    <div class="d-flex flex-wrap">
                        <div class="media-support-user-img mr-3">
                            <img class="rounded-circle img-fluid" src="{{ asset('upload/photo/'.$profil->file_photo) }}" alt="">
                        </div>
                        <div class="media-support-info mt-2">
                            <h5 class="mb-0">{{ $profil->nm_lengkap }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="iq-card-body">
                <div class="col-sm-12">
                    
                        <div class="iq-card iq-card-block iq-card-stretch">
                            <div class="iq-card-body">
                                <div class="user-detail text-center">
                                    <div class="user-profile">
                                        <img class="avatar-130 img-fluid" id="preview_upload" src="{{ url(Storage::url('hrd/pelamar/photo/'.$profil->file_photo)) }}" alt="profile-pic">
                                        
                                    </div>
                                    <div class="profile-detail mt-3">
                                        <h3 class="d-inline-block">{{ $profil->nama_lengkap }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-5" id="page_view">
                            <div class="iq-card">
                                <form action="{{ route('insertOrganisasi') }}" method="post" onsubmit="return konfirm()" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id_pelamar" value="{{ $profil->id }}">
                                    <div class="iq-card-header d-flex justify-content-between">
                                        <div class="iq-header-title">
                                            <h4 class="card-title">Tambah Data Baru</h4>
                                        </div>
                                    </div>
                                    <div class="iq-card iq-card-block iq-card-stretch">
                                        <div class="iq-card-body">
                                            <div class="row align-items-center">
                                                <div class="form-group col-sm-12">
                                                    <label for="inp_nama">Nama Organisasi :</label>
                                                    <input type="text" class="form-control" name="inp_nama" id="inp_nama" maxlength="150" required>
                                                </div>
                                            </div>
                                            <div class="row align-items-center">
                                                <div class="form-group col-sm-12">
                                                    <label for="inp_posisi">Posisi/Jabatan :</label>
                                                    <input type="text" class="form-control" name="inp_posisi" id="inp_posisi" maxlength="150" required>
                                                </div>
                                            </div>
                                            <div class="row align-items-center">
                                                <div class="form-group col-sm-12">
                                                    <label for="inp_tahun_mulai">Periode Tahun :</label>
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
                        </div>
                        <div class="col-sm-7">
                            <div class="iq-card">
                                <div class="iq-card-header d-flex justify-content-between">
                                    <div class="iq-header-title">
                                        <h4 class="card-title">Daftar Pengalaman Organisasi</h4>
                                    </div>
                                </div>
                                <div class="iq-card iq-card-block iq-card-stretch">
                                    <div class="iq-card-body">
                                        <table class="table">
                                            <thead>
                                                <th>No.</th>
                                                <th>Nama Organisasi</th>
                                                <th>Posisi/Jabatan</th>
                                                <th>Periode Tahun</th>
                                                <th></th>
                                            </thead>
                                            <tbody>
                                            @php $nom=1; @endphp
                                            @foreach($list_organisasi as $org)
                                            <tr>
                                                <td>{{$nom}}</td>
                                                <td>{{ $org->nama_organisasi }}</td>
                                                <td>{{ $org->posisi }}</td>
                                                <td>{{ $org->mulai_tahun." s/d".$org->sampai_tahun }}</td>
                                                <td>
                                                <button type="button" id="{{ $org->id }}" class="btn btn-primary btn_edit" data-toggle="modal" data-target="#ModalEdit"><i class="ri-pencil-line"></i></button>
                                                <a href="{{ route('deleteOrganisasi', $org->id)}}" class="btn btn-danger" onClick="return hapusKonfirm()"><i class="ri-delete-bin-line"></i></a>
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
</div>
<!-- Modal -->
<div id="ModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Edit Data Pengalaman Organisasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div id="bodyForm"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $('.tahun_mask').mask('0000');
        $(".btn_edit").on("click", function()
        {
            var id_data = this.id;
            $("#bodyForm").load('{{ url("hrd/recruitment/aplikasi_pelamar/frm_organisasi/edit") }}/'+id_data);
        });
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