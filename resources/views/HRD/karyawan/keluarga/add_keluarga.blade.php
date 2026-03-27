@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/karyawan/daftar') }}">Daftar Karyawan</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/karyawan/profil/'.$res->id) }}">Profil Karyawan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Keluarga</li>
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
                    <h4 class="card-title">Data Keluarga (Suami/Istri & Anak)</h4>
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
                            <form action="{{ url('hrd/karyawan/simpankeluarga') }}" method="post" onsubmit="return konfirm()" enctype="multipart/form-data">
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
                                                <label for="pil_hubungan">Hubungan Keluarga :</label>
                                                <select class="form-control" id="pil_hubungan" name="pil_hubungan">
                                                    @foreach($list_status_keluarga as $key => $keluarga)
                                                    <option value="{{ $key }}">{{ $keluarga }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="form-group col-sm-12">
                                                <label for="inp_nama">Nama :</label>
                                                <input type="text" class="form-control" name="inp_nama" id="inp_nama" maxlength="150" required>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="form-group col-sm-8">
                                                <label for="inp_tmp_lahir">Tempat Lahir :</label>
                                                <input type="text" class="form-control" name="inp_tmp_lahir" id="inp_tmp_lahir" maxlength="100" required>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label for="inp_tgl_lahir">Tanggal Lahir :</label>
                                                <input type="date" class="form-control" name="inp_tgl_lahir" id="inp_tgl_lahir" required>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="form-group col-sm-12">
                                                <label class="d-block">Jenis Kelamin :</label>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="rdo_jenkel_1" name="rdo_jenkel" class="custom-control-input" checked="" value="1">
                                                <label class="custom-control-label" for="rdo_jenkel_1"> Laki-Laki </label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="rdo_jenkel_2" name="rdo_jenkel" class="custom-control-input" value="2">
                                                <label class="custom-control-label" for="rdo_jenkel_2"> Perempuan </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="form-group col-sm-12">
                                                <label for="pil_jenjang">Pendidikan Terakhir :</label>
                                                <select class="form-control" id="pil_jenjang" name="pil_jenjang">
                                                    @foreach($list_jenjang as $key => $jenjang)
                                                    <option value="{{ $key }}">{{ $jenjang }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="form-group col-sm-12">
                                                <label for="inp_pekerjaan">Pekerjaan :</label>
                                                <input type="text" class="form-control" name="inp_pekerjaan" id="inp_pekerjaan" maxlength="100">
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
                                <div class="iq-card-body table-responsive">
                                    <table class="table">
                                        <thead>
                                            <th>No.</th>
                                            <th>Hubungan</th>
                                            <th>Nama Keluarga</th>
                                            <th>Tempat/Tanggal Lahir</th>
                                            <th>Jenkel</th>
                                            <th>Pendidikan Terakhir</th>
                                            <th>Pekerjaan</th>
                                            <th></th>
                                        </thead>
                                        <tbody>
                                            @php $nom=1; @endphp
                                            @foreach($list_keluarga as $lbk)
                                            <tr>
                                                <td>{{$nom}}</td>
                                                <td>{{ $lbk->get_hubungan_keluarga($lbk->id_hubungan) }}</td>
                                                <td>{{ $lbk->nm_keluarga }}</td>
                                                <td>{{ $lbk->tmp_lahir.", ".date_format(date_create($lbk->tgl_lahir), 'd-m-Y') }}</td>
                                                <td>{{ ($lbk->jenkel==1)? "Laki-Laki" : "Perempuan" }}</td>
                                                <td>{{ $lbk->get_pendidikan_akhir($lbk->id_jenjang) }}</td>
                                                <td>{{ $lbk->pekerjaan }}</td>
                                                <td>
                                                <div class="flex align-items-center list-user-action">
                                                    <a class="btn_edit" id="{{ $lbk->id }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="{{ url('hrd\karyawan\editkeluarga') }}\{{ $lbk->id }}"><i class="ri-pencil-line"></i></a>
                                                    <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Hapus" href="{{ url('hrd\karyawan\hapuskeluarga') }}/{{$lbk->id}}/{{$res->id}}" onClick="return hapusKonfirm()"><i class="ri-delete-bin-line"></i></a>
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
        $(".btn_edit").on("click", function()
        {
            var id_data = this.id;
            $("#page_view").load("{{ url('hrd/masterdata/jeniscutiizin/edit') }}/"+id_data);
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