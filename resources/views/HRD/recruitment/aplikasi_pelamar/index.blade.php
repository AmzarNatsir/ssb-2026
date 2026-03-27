@extends('HRD.layouts.master')
@section('content')
@php
$user = auth()->user();
$id_jabatan_user = (empty($lvl_appr_user->id)) ? "" : $lvl_appr_user->id;
@endphp
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Recruitment</li>
        <li class="breadcrumb-item"><a href="#">Aplikasi Pelamar</a></li>
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
                    <h4 class="card-title">Daftar Aplikasi Pelamar</h4>
                </div>
                <div class="iq-card-header-toolbar d-flex align-items-center">
                    <a class="dropdown-bg" href="{{ url('hrd/recruitment/aplikasi_pelamar/baru') }}"><i class="fa fa-plus"></i> Tambah Aplikasi</a>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <div class="row justify-content-between">
                    <div class="col-sm-12 col-md-3">
                        <div id="user_list_datatable_info" class="dataTables_filter">
                            <select class="form-control select2" name="pil_departemen" id="pil_departemen" style="width: 100%">
                            @foreach($departemen as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->nm_dept }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div id="user_list_datatable_info" class="dataTables_filter">
                            <select class="form-control select2" name="pil_jabatan" id="pil_jabatan" style="width: 100%">
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <div id="user_list_datatable_info" class="dataTables_filter">
                            <select class="form-control select2" name="pil_jenkel" id="pil_jenkel" style="width: 100%">
                                <option value="1">Laki-Laki</option>
                                <option value="2">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="user-list-files d-flex float-left">
                            <button type="button" class="btn btn-primary" name="btnSearch" id="btnSearch"><i class="fa fa-search"></i> FILTER</button>&nbsp;
                        </div>
                    </div>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <div class="row col-lg-12 table-responsive">
                    <table id="list-table" class="table datatable table-hover table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info" style="font-size: 12px">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 5%;">Aksi</th>
                                <th scope="col" style="width: 5%;">#</th>
                                <th scope="col" style="width: 5%;">Photo</th>
                                <th scope="col" style="width: 10%;">Tgl.&nbsp;Aplikasi</th>
                                <th scope="col" style="width: 10%;">No.Identitas</th>
                                <th scope="col">Nama&nbsp;Pelamar</th>
                                <th scope="col" style="width: 10%;">Tempat/&nbsp;Tgl.Lahir</th>
                                <th scope="col" style="width: 5%;">Usia</th>
                                <th scope="col" style="width: 5%;">Jenkel</th>
                                <th scope="col" style="width: 15%;">Alamat/&nbsp;No.Telepon</th>
                                <th scope="col" style="width: 15%;">Posisi&nbsp;Yg&nbsp;Dilamar</th>
                                <th scope="col" style="width: 5%;" class="text-center">Status&nbsp;Pengajuan</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {

        $("#pil_departemen").select2({
            allowClear: true,
            placeholder: "Pilihan Departemen"
        });
        $("#pil_jabatan").select2({
            allowClear: true,
            placeholder: "Pilihan Jabatan"
        });
        $("#pil_jenkel").select2({
            allowClear: true,
            placeholder: "Pilihan Jenis Kelamin"
        });
        $("#pil_departemen").val('').trigger('change');
        $("#pil_jabatan").val('').trigger('change');
        $("#pil_jenkel").val('').trigger('change');
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        var table = $("#list-table").DataTable({
            processing: true,
            serverSide: true,
            autoWidth: true,
            // responsive: true,
            scrollX: true,
            ajax: {
                headers : {
                    'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
                },
                url: '{{ url("hrd/recruitment/aplikasi_pelamar/data") }}',
                type : 'post',
                data: function (d) {
                    d.dept = $("#pil_departemen").val();
                    d.jabatan = $("#pil_jabatan").val();
                    d.jenkel = $("#pil_jenkel").val();
                }
            },
            columns: [
                { data: 'action' },
                { data: 'no'},
                { data: 'photo'},
                { data: 'tanggal_aplikasi'},
                { data: 'no_identitas'},
                { data: 'nama_pelamar'},
                { data: 'ttl' },
                { data: 'umur' },
                { data: 'gender'},
                { data: 'alamat'},
                { data: 'posisi_dilamar'},
                { data: 'status_pengajuan' },

            ],
            columnDefs: [
                {
                    targets: [0, 1],
                    className: "text-center"
                },
            ],
        });
        $("#pil_departemen").on("change", function()
        {
            var id_pil_dept = $("#pil_departemen").val();
            hapus_teks_jab();
            if(id_pil_dept==0) {
                hapus_teks_jab();
            } else {
                $("#pil_jabatan").load("{{ url('hrd/karyawan/loadalljabatan') }}/"+id_pil_dept);
            }
        });
        $("#btnSearch").on("click", function(){
            table.draw();
        });
    });
    var prosesCloseApp = function(el)
    {
        var idData = el.id;
        Swal.fire({
            title: 'Are you sure?',
            text: "Close this application!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, close it!'
        }).then((result) => {
            if (result)
            {
                $.ajax({
                    url: "{{ url('hrd/recruitment/closeApp') }}/"+idData,
                    type: "GET",
                    success:function(response){
                        if(response.success==true) {
                            Swal.fire({
                                text: 'Success! '+response.message,
                                icon: 'success',
                                buttons: false,
                                timer: 2000
                            }).then(() => {
                                $("#list-table").DataTable().draw();
                            });
                        } else {
                            swal('Warning! '+response.message, {
                                icon: 'warning',
                            });
                        }
                    }
                });
            } else {
                swal('Warning! Selected data failed to process!', {
                    icon: 'warning',
                });
            }
        });
    }
    var prosesOpenApp = function(el)
    {
        var idData = el.id;
        Swal.fire({
            title: 'Are you sure?',
            text: "Open this application!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Open it!'
        }).then((result) => {
            if (result)
            {
                $.ajax({
                    url: "{{ url('hrd/recruitment/openApp') }}/"+idData,
                    type: "GET",
                    success:function(response){
                        if(response.success==true) {
                            Swal.fire({
                                text: 'Success! '+response.message,
                                icon: 'success',
                                buttons: false,
                                timer: 2000
                            }).then(() => {
                                $("#list-table").DataTable().draw();
                            });
                        } else {
                            swal('Warning! '+response.message, {
                                icon: 'warning',
                            });
                        }
                    }
                });
            } else {
                swal('Warning! Selected data failed to process!', {
                    icon: 'warning',
                });
            }
        });
    }
    function hapus_teks_jab()
    {
        $("#pil_jabatan").empty();
    }
    function confirmHapus()
    {
        var pesan = confirm("Yakin data akan dihapus ?");
        if(pesan==true) {
            return true;
        } else {
            return false;
        }
    }
</script>
@endsection
