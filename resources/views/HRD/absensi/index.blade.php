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
        border-radius: 5px;
    }

    .table {
        margin-bottom: 0;
    }

    /* Lebar & posisi kolom beku (No, NIK, NIK Lama, Karyawan) — header hanya baris pertama */
    .table thead tr:first-child th:nth-child(1),
    .table tbody td:nth-child(1) { left: 0;     width: 45px;  min-width: 45px;  max-width: 45px; }
    .table thead tr:first-child th:nth-child(2),
    .table tbody td:nth-child(2) { left: 45px;  width: 100px; min-width: 100px; max-width: 100px; }
    .table thead tr:first-child th:nth-child(3),
    .table tbody td:nth-child(3) { left: 145px; width: 100px; min-width: 100px; max-width: 100px; }
    .table thead tr:first-child th:nth-child(4),
    .table tbody td:nth-child(4) { left: 245px; width: 150px; min-width: 150px; max-width: 150px; }

    /* Body: 4 kolom kiri tetap saat scroll horizontal */
    .table tbody td:nth-child(1),
    .table tbody td:nth-child(2),
    .table tbody td:nth-child(3),
    .table tbody td:nth-child(4) {
        position: sticky;
        z-index: 2;
        background-color: #f9f9f9;
        font-weight: 500;
    }

    /* Header tetap di atas saat scroll vertikal */
    .table thead th {
        position: sticky;
        top: 0;
        background-color: #f8f9fa;
        z-index: 3;
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
    }

    /* Header 4 kolom kiri: beku ke atas & ke kiri sekaligus (pojok) */
    .table thead tr:first-child th:nth-child(1),
    .table thead tr:first-child th:nth-child(2),
    .table thead tr:first-child th:nth-child(3),
    .table thead tr:first-child th:nth-child(4) {
        z-index: 4;
    }

    .table tbody tr:hover {
        background-color: #f5f5f5;
    }

    .table td {
        text-align: center;
        padding: 8px !important;
        font-size: 13px;
    }

    .table td:nth-child(4) {
        text-align: left;
        padding: 10px !important;
    }

    /* Filter Form Improvements */
    .form-control, .form-control:focus {
        border-radius: 4px;
        font-size: 13px;
    }

    .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    label {
        font-size: 13px;
        color: #333;
    }

    .btn {
        font-size: 13px;
        font-weight: 500;
        border-radius: 4px;
    }

    .btn-primary, .btn-info {
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
    }

    .btn-info:hover {
        background-color: #0062cc;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(23, 162, 184, 0.3);
    }

    /* Schedule Card Styling (Opsi 4) */
    .schedule-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fbff 100%);
        border: 1px solid #e8f0ff;
        border-radius: 8px;
        padding: 8px 10px;
        margin: 0;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .schedule-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
        border-color: #d0e0ff;
    }

    .schedule-shift {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        line-height: 1.4;
        padding: 4px 0;
    }

    .shift-badge {
        font-size: 10px;
        display: inline-block;
        min-width: 12px;
    }

    .shift-badge.pagi {
        color: #0066ff;
    }

    .shift-badge.siang {
        color: #00aa00;
    }

    .shift-label {
        font-weight: 600;
        color: #555;
        min-width: 35px;
        white-space: nowrap;
    }

    .shift-time {
        color: #333;
        font-weight: 500;
        font-family: 'Courier New', monospace;
    }

    .shift-duration {
        color: #999;
        font-size: 10px;
        font-style: italic;
        margin-left: auto;
        white-space: nowrap;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .schedule-card {
            padding: 8px 10px;
            font-size: 11px;
        }

        .schedule-shift {
            font-size: 10px;
        }

        .shift-label {
            min-width: 30px;
        }

        .shift-time {
            font-size: 10px;
        }
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
            <div class="iq-card-header d-flex justify-content-between align-items-center">
                <div class="iq-header-title">
                    <h4 class="card-title">Monitoring Absensi Karyawan</h4>
                </div>
                <div class="iq-card-header-toolbar">
                    <a href="{{ url('hrd/absensi/input') }}" class="btn btn-primary"><i class="fa fa-edit mr-2"></i>Absensi Harian</a>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <form method="post">
                {{ csrf_field() }}

                <!-- Filter Section -->
                <div class="row align-items-end mb-4">
                    <div class="col-lg-2 col-md-3 col-sm-6 mb-3">
                        <label class="d-block font-weight-bold mb-2">Bulan</label>
                        <select class="form-control" name="pil_bulan" id="pil_bulan">
                            <option value="0">Pilih Bulan</option>
                            @foreach($list_bulan as $key => $value)
                            @if($key==date("m"))
                            <option value="{{ $key }}" selected>{{ $value }}</option>
                            @else
                            <option value="{{ $key }}">{{ $value }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-1 col-md-2 col-sm-6 mb-3">
                        <label class="d-block font-weight-bold mb-2">Tahun</label>
                        <input type="text" name="inp_tahun" id="inp_tahun" value="{{ date('Y') }}" class="form-control" maxlength="4" required>
                    </div>
                    <div class="col-lg-3 col-md-7 col-sm-12 mb-3">
                        <label class="d-block font-weight-bold mb-2">Departemen</label>
                        <select class="form-control" name="pil_departemen" id="pil_departemen">
                            <option value="">Pilih Departemen</option>
                            @foreach($all_departemen as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->nm_dept }} | {{ $dept->get_master_divisi->nm_divisi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-5 col-sm-12 mb-3">
                        <label class="d-block font-weight-bold mb-2">Jabatan</label>
                        <select class="form-control" name="pil_jabatan" id="pil_jabatan">
                            <option value="">- Semua Jabatan</option>
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12 mb-3">
                        <div class="d-flex flex-wrap" style="gap: 8px;">
                            <button type="button" class="btn btn-primary" onClick="actFilter();"><i class="fa fa-search mr-2"></i>Filter</button>
                            <button type="button" class="btn btn-success" onClick="actExcel();"><i class="fa fa-table mr-2"></i>Excel</button>
                            <a href="{{ url('hrd/absensi/importdataabsensi') }}" target="_new" class="btn btn-info"><i class="fa fa-upload mr-2"></i>Import Data</a>
                        </div>
                    </div>
                </div>

                <hr class="my-4">
                <!-- Legend Section -->
                <div class="row mb-4">
                    <div class="col-lg-12">
                        <h6 class="font-weight-bold mb-3">Keterangan Warna:</h6>
                        <div class="row">
                            <div class="col-lg-4 col-md-6 mb-2">
                                <div class="d-flex align-items-center">
                                    <div style="width: 20px; height: 20px; background-color: #1764bd; border-radius: 3px; margin-right: 10px;"></div>
                                    <span>Hari Libur Bersama</span>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 mb-2">
                                <div class="d-flex align-items-center">
                                    <div style="width: 20px; height: 20px; background-color: #A0A0A0; border-radius: 3px; margin-right: 10px;"></div>
                                    <span>Hari Minggu/Ahad</span>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 mb-2">
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-info" style="height: 20px; padding: 5px 8px;">C = Cuti | I = Izin | P = Dinas | T = Training</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Table Section -->
                <div class="row">
                    <div class="col-lg-12">
                        <div id="spinner-div" class="pt-5 justify-content-center spinner-div"><div class="spinner-border text-primary" role="status"></div></div>
                        <div class="iq-card table-responsive" id="data_list"></div>
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
    // muat daftar jabatan sesuai departemen terpilih
    $("#pil_departemen").on('change', function(){
        var id_dept = $(this).val();
        $("#pil_jabatan").html('<option value="">- Semua Jabatan</option>');
        if(id_dept=="") return;
        $.ajax({
            type: "post",
            headers: { 'X-CSRF-TOKEN': '<?php echo csrf_token() ?>' },
            url: "{{ url('hrd/absensi/getJabatanDept') }}",
            data: { id_dept:id_dept },
            success: function(res){
                $.each(res, function(i, item){
                    $("#pil_jabatan").append('<option value="'+item.id+'">'+item.nm_jabatan+'</option>');
                });
            }
        });
    });
    var actFilter = function()
    {
        var id_dept = $("#pil_departemen").val();
        var id_jabatan = $("#pil_jabatan").val();
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
                data : {id_dept:id_dept, id_jabatan:id_jabatan, pil_bulan:pil_bulan, pil_tahun:pil_tahun},
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
    var actExcel = function()
    {
        var id_dept = $("#pil_departemen").val();
        var id_jabatan = $("#pil_jabatan").val();
        var pil_bulan = $("#pil_bulan").val();
        var pil_tahun = $("#inp_tahun").val();
        if(id_dept=="")
        {
            alert('Kolom Pilihan Departemen tidak boleh kosong !');
            return false;
        } else if(pil_bulan==0) {
            alert('Kolom Pilihan Bulan tidak boleh kosong !');
            return false;
        } else {
            var jab = (id_jabatan=="" || id_jabatan==null) ? 0 : id_jabatan;
            window.open("{{ url('hrd/absensi/exportExcel') }}/"+id_dept+"/"+pil_bulan+"/"+pil_tahun+"/"+jab);
        }
    };
</script>
@endsection
