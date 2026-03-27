@extends('HRD.layouts.master')
@section('content')
<style>
    .select2-container .select2-selection--single {
        height: 40px !important; /* Adjust the height */
        display: flex;
        align-items: center; /* Center text vertically */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 38px !important; /* Match line-height to height for alignment */
    }

    .select2-container--default .select2-selection--multiple {
        min-height: 40px !important; /* For multi-select dropdowns */
    }
</style>
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Setup</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/setup/matriks_pkwt') }}">Matriks PKWT (F5)</a></li>
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
    <div class="col-lg-4">
        <div class="iq-card" id="page_view">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Pengaturan Matriks PKWT</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <form action="{{ url('hrd/setup/store_matriks_pkwt') }}" method="post" onsubmit="return konfirm()">
                {{ csrf_field() }}
                <input type="hidden" name="id_jabatan" id="id_jabatan" value="">
                <div class="form-group row">
                    <div class="col-sm-12">
                        <label>Departemen</label>
                        <input type="text" class="form-control" name="departemen" id="departemen" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <label>Sub Departemen</label>
                        <input type="text" class="form-control" name="sub_departemen" id="sub_departemen" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <label>Jabatan</label>
                        <input type="text" class="form-control" name="jabatan" id="jabatan" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <label>Output PKWT</label>
                        <select class="form-control select2" name="pil_output" id="pil_output" style="width: 100%" disabled>
                            <option></option>
                        </select>
                    </div>
                </div>
                <hr>
                <button type="submit" id="tbl_simpan" class="btn btn-primary" disabled><i class="fa fa-save"></i> Submit</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="iq-card" id="page_view">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Matriks PKWT</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <table class="table datatable datatable table-hover table-striped table-bordered" style="width: 100%;">
                    <thead>
                        <th style="width: 10%;">Aksi</th>
                        <th>Jabatan</th>
                        <th style="width: 30%;">Departemen</th>
                        <th style="width: 15%;">Output</th>
                    </thead>
                <tbody>
                @foreach ($list_jabatan as $jabatan)
                <tr>
                    <td><button type="button" class="btn btn-success" value="{{ $jabatan->id }}" onclick="getMatriks(this)"><i class="fa fa-edit"></i></button></td>
                    <td>{{ $jabatan->nm_jabatan }}</td>
                    <td>{{ (empty($jabatan->mst_departemen->nm_dept)) ? "" : $jabatan->mst_departemen->nm_dept }}</td>
                    <td>{{ $jabatan->file_pkwt }}</td>
                </tr>
                @endforeach
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $(".select2").select2({
            'placeholder': "Pilihan",
            'allowClear': true
        });
        $('.datatable').DataTable({
            searchDelay: 500,
            paging: true,
            searching: true,
            ordering: true
        });
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        aktif_teks(true);
        kosong_teks();
    });
    var getMatriks = function(el)
    {
        $.ajax(
        {
            url: "{{ url('hrd/setup/get_matriks_pkwt')}}",
            type : 'post',
            headers : {
                'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
            },
            data : {id_jabatan:$(el).val()},
            success : function(res)
            {
                kosong_teks();
                $("#id_jabatan").val(res.id_jabatan);
                $("#departemen").val(res.departemen);
                $("#sub_departemen").val(res.sub_dept);
                $("#jabatan").val(res.jabatan);
                $("#pil_output").load("{{ url('hrd/setup/get_list_matriks_pkwt') }}/"+res.output);
                aktif_teks(false);
            }

        });

    }
    function aktif_teks(tf)
    {
        $("#pil_output").attr("disabled", tf);
        $("#tbl_simpan").attr("disabled", tf);
    }
    function kosong_teks()
    {
        $("#id_jabatan").val("");
        $("#departemen").val("");
        $("#sub_departemen").val("");
        $("#jabatan").val("");
        $("#pil_output").prop('selected', false).find('option:first').prop('selected', true);
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
