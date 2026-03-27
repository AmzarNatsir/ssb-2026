@extends('HRD.layouts.master')
@section('content')
<style>
    .spinner-div {
    position: absolute;
    display: none;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    text-align: center;
    background-color: rgba(255, 255, 255, 0.8);
    z-index: 2;
    }
    .btn-circle.btn-md {
            width: 40px;
            height: 40px;
            padding: 7px 10px;
            border-radius: 25px;
            font-size: 12px;
            text-align: center;
        }

    .table-responsive {
        overflow-x: auto;
    }
    .table thead th:first-child,
    .table tbody td:first-child {
        position: sticky;
        left: 0;
        background-color: #fff;
        z-index: 2;
    }

    .table thead th {
        position: sticky;
        top: 0;
        background-color: #f8f9fa;
        z-index: 3;
    }

    .table tbody td:first-child {
        z-index: 1;
    }
</style>
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Absensi</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/absensi') }}">Refresh (F5)</a></li>
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
                    <h4 class="card-title">Monitoring Absensi Karyawan</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <form method="post">
                {{ csrf_field() }}
                <div class="row justify-content-between">
                    <div class="col-sm-12 col-md-2">
                        <select class="form-control" name="pil_bulan" id="pil_bulan" style="width: 100%">
                        <option value="0">Pilihan Bulan</option>
                        @foreach($list_bulan as $key => $value)
                        @if($key==date("m"))
                        <option value="{{ $key }}" selected>{{ $value }}</option>
                        @else
                        <option value="{{ $key }}">{{ $value }}</option>
                        @endif
                        @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-1">
                        <input type="text" name="inp_tahun" id="inp_tahun" value="{{ date('Y') }}" class="form-control" maxlength="4" required>
                    </div>
                    <div class="col-sm-6 col-md-3 float-left">

                        <div class="input-group">
                            <select class="form-control" name="pil_departemen" id="pil_departemen">
                                <option value="">Pilihan Departemen</option>
                                @foreach($all_departemen as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->nm_dept }} | {{ $dept->get_master_divisi->nm_divisi }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2 float-left">
                        <button type="button" class="btn btn-primary"  onClick="actFilter();"><i class="fa fa-search"></i> Filter</button>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="user-list-files d-flex float-right">
                            <a href="{{ url('hrd/absensi/importdataabsensi') }}" target="_new"><i class="fa fa-upload"></i> Import Data Absensi</a>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div id="spinner-div" class="pt-5 justify-content-center spinner-div"><div class="spinner-border text-primary" role="status"></div></div>
                        <div class="iq-card table-responsive" id="data_list"></div>
                        <table class="table table-sm">
                           <tr>
                            <td style='height: 30px'></td></tr><tr>
                                <td style='background-color: #1764bd'></td>
                                <td>Hari Libur Bersama</td>
                                </tr>
                                <tr>
                                <td style='background-color:  #c44a12'></td>
                                <td>Hari Minggu/Ahad</td>
                                </tr>
                                <tr>
                                <td style='background-color:  #bd9f17'></td>
                                <td>C = Cuti; I = Izin; P = Perjalanan Dinas; T = Training</td>
                                </tr>
                                </table>";
                        </table>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#spinner-div').hide();
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".select2").select2({
            // theme: "flat",
		    placeholder: "Search Departemen"
        });

    });
    var actFilter = function()
    {
        var id_dept = $("#pil_departemen").val();
        var pil_bulan = $("#pil_bulan").val();
        var pil_tahun = $("#inp_tahun").val();
        if(id_dept=="")
        {
            alert('Kolom Pilihan Departemen tidak boleh kosong !');
            return false;
        } else {

            // $('.datatable').DataTable();
            $.ajax({
                type : "post",
                headers : {
                        'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
                    },
                url : "{{ url('hrd/absensi/getAbsensi')}}",
                data : {id_dept:id_dept, pil_bulan:pil_bulan, pil_tahun:pil_tahun},
                beforeSend : function()
                {
                    $('#spinner-div').show();
                },
                success : function(respond)
                {
                    $("#data_list").html(respond);
                },
                complete : function()
                {
                    $('#spinner-div').hide();
                }
            });
        }
    };
</script>
@endsection
