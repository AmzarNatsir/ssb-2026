@extends('HRD.layouts.master')
@section('content')
@php
$user = auth()->user();
@endphp
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Recruitment</li>
        <li class="breadcrumb-item"><a href="#">Pengajuan Permintaan Tenaga Kerja</a></li>
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
            <div class="iq-card-body" style="width:100%; height:auto">
                <div class="row justify-content-between">
                    <div class="col-sm-12 col-md-4">
                        <div id="user_list_datatable_info" class="dataTables_filter">
                            <select class="form-control select2" name="pil_departemen" id="pil_departemen" style="width: 100%">
                            @foreach($departemen as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->nm_dept }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div id="user_list_datatable_info" class="dataTables_filter">
                            <select class="form-control select2" name="pil_jabatan" id="pil_jabatan" style="width: 100%">
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="user-list-files d-flex float-left">
                            <button type="button" class="btn btn-primary" name="btnSearch" id="btnSearch"><i class="fa fa-search"></i> FILTER</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Daftar Pengajuan</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <br>
                <table id="list-table" class="table table-hover table-striped table-bordered mt-4" style="font-size: 13px">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 5%;" class="text-center">#</th>
                            <th scope="col" style="width: 10%;" class="text-center">Pengajuan</th>
                            <th scope="col" style="width: 15%;">Jabatan</th>
                            <th scope="col" style="width: 15%;">Departemen</th>
                            <th scope="col" style="width: 5%;" class="text-center">Jumlah Permintaan</th>
                            <th scope="col" style="width: 10%;" class="text-center">Tanggal dibutuhkan</th>
                            <th scope="col" class="text-center">Alasan Permintaan</th>
                            <th scope="col" style="width: 10%;" class="text-center">Status Pengajuan</th>
                            <th scope="col" style="width: 5%;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".select2").select2({
            allowClear: true,
            placeholder: "Select"
        });
        // $('.datatable').DataTable();
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
                url: '{{ url("hrd/recruitment/daftar_pengajuan_tenaga_kerja/data") }}',
                type : 'post',
                data: function (d) {
                    d.dept =($("#pil_departemen").val()==null) ? "" : $("#pil_departemen").val();
                    d.jabatan = ($("#pil_jabatan").val()==null) ? "" : $("#pil_jabatan").val();
                }
            },
            columns: [
                { data: 'no'},
                { data: 'tanggal_pengajuan'},
                { data: 'jabatan'},
                { data: 'departemen'},
                { data: 'jumlah' },
                { data: 'tgl_dibutuhkan'},
                { data: 'alasan_permintaan'},
                { data: 'status_pengajuan'},
                { data: 'action' },
            ],
            columnDefs: [
                {
                    targets: [0, 1, 4, 5, 7],
                    className: "text-center"
                },
            ],
        });
        $("#pil_departemen").on("change", function()
        {
            var id_pil_dept = ($("#pil_departemen").val()==null) ? 0 : $("#pil_departemen").val();
            hapus_teks_jab();
            if(id_pil_dept==0) {
                hapus_teks_jab();
            } else {
                $("#pil_jabatan").load("{{ url('hrd/karyawan/loadalljabatan') }}/"+id_pil_dept);
            }
        });
        $("#btnSearch").on("click", function(){
            var departemen = ($("#pil_departemen").val()==null) ? 0 : $("#pil_departemen").val();
            var jabatan = ($("#pil_jabatan").val()==null) ? 0 : $("#pil_jabatan").val();
            // if(departemen==0)
            // {
            //     Swal.fire({
            //         title: 'Warning',
            //         text: 'Kolom pilihan departemen Tidak boleh kosong',
            //         icon: 'warning'
            //     }).then(function() {
            //         return false
            //     });
            // } else {
                table.draw();
            // }
        });
    });
    function hapus_teks_jab()
    {
        $("#pil_jabatan").empty();
        $("#pil_jabatan").append("<option value='0'>Pilihan Jabatan</option>");
    }
    var goDelete = function() {
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
