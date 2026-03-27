@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Setup</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/setup/manajemenpengguna') }}">Manajemen Pengguna (F5)</a></li>
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
    <div class="col-lg-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title"><i class="fa fa-users"></i> Daftar Pengguna</h4>
                </div>
                <div class="user-list-files d-flex float-left">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalForm" onclick="goFormAdd(this)"><i class="fa fa-plus"></i> Data Baru</button>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <table class="table datatable table-hover table-bordered mt-4 table-responsive list_user" role="grid" style="width: 100%;">
                <thead>
                    <th style="width: 5%;">No.</th>
                    <th style="width: 10%;">NIK</th>
                    <th style="width: 20%;">Nama Pengguna</th>
                    <th style="width: 20%;">Departemen</th>
                    <th style="width: 15%;">Jabatan</th>
                    <th style="width: 20%;">Group Pengguna</th>
                    <th style="width: 10%;">Aksi</th>
                </thead>
                @foreach ($daftar_user as $item => $user)
                    <tr>
                        <td>{{ $item + 1}}</td>
                        <td>{{ $user->karyawan->nik }}</td>
                        <td>{{ $user->karyawan->nm_lengkap }}</td>
                        <td>{{ $user->karyawan->id_departemen ? $user->karyawan->get_departemen->nm_dept:'Non Departemen' }}</td>
                        <td>{{ (empty($user->karyawan->get_jabatan->nm_jabatan) || (empty($user->karyawan->id_jabatan))) ? "Non Jabatan" : $user->karyawan->get_jabatan->nm_jabatan }}</td>
                        <td>{{ implode(', ',$user->roles->pluck('name')->toArray()) }}</td>
                        <td>
                            <button type="button" class="btn btn-primary mb-2 btn_edit" data-toggle="modal" data-target="#ModalForm" id="{{ $user->id }}" onclick="goFormEdit(this)"><i class="ri-edit-fill pr-0"></i></button>

                            <a href="{{ url('hrd/setup/manajemenpengguna/hapus/'.$user->id) }}" class="btn btn-danger mb-2" onClick="return konfirmHapus()"><i class="ri-delete-bin-line pr-0"></i></a>
                        </td>
                    </tr>
                @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
<div id="ModalForm" class="modal fade" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" id="v_inputan"></div>
    </div>
 </div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $(".select2").select2();
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $('.datatable').DataTable({
            searchDelay: 500,
            processing: true,
        });
    });
    var goFormAdd = function()
    {
        $("#v_inputan").load("{{ url('hrd/setup/manajemenpengguna/add') }}");
    }
    var goFormEdit = function(el)
    {
        var id_data = el.id;
        $("#v_inputan").load("{{ url('hrd/setup/manajemenpengguna/edit') }}/"+id_data);
    }
    function konfirmHapus()
    {
        var psn = confirm("Yakin data akan dihapus ?");
        if(psn==true)
        {
            true;
        } else {
            false;
        }
    }
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
</script>
@endsection
