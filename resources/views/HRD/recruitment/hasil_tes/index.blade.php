@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Recruitment</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/recruitment/rekap_hasil_tes') }}">Rekapitulasi Hasil Tes (F5)</a></li>
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
                    <h4 class="card-title">Rekapitulasi Hasil Tes</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <div class="row justify-content-between">
                    <div class="col-sm-12 col-md-4">
                        <div id="user_list_datatable_info" class="dataTables_filter">
                            <select class="form-control select2" name="pil_departemen" id="pil_departemen" style="width: 100%">
                            <option value="0">Pilihan Departemen</option>
                            @foreach($departemen as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->nm_dept }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div id="user_list_datatable_info" class="dataTables_filter">
                            <select class="form-control select2" name="pil_jabatan" id="pil_jabatan" style="width: 100%">
                                <option value="0">Pilihan Jabatan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="user-list-files d-flex float-left">
                            <button type="button" class="btn btn-primary" name="btnSearch" id="btnSearch"><i class="fa fa-search"></i> FILTER</button>&nbsp;
                            <button type="button" class="btn btn-success" name="btnPdf" id="btnPdf" onClick="actPrint();"><i class="fa fa-print"></i> PDF</button>&nbsp;
                            <button type="button" class="btn btn-danger" name="btnExcel" id="btnExcel" onClick="actExcel();"><i class="fa fa-table"></i> Excel</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="iq-card-body table-responsive">
                <table id="rekap-list-table" class="table table-sm table-responsive table-hover table-striped table-bordered mt-4"  style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 4%; vertical-align: middle" rowspan="3">No</th>
                            <th style="text-align: center; width: 5%; vertical-align: middle" rowspan="3">Photo</th>
                            <th style="text-align: center; vertical-align: middle" rowspan="3">Nama</th>
                            <th style="width: 5%; text-align: center; vertical-align: middle" rowspan="3">Usia</th>
                            <th style="text-align: center; width: 15%; vertical-align: middle" rowspan="3">Pendidikan Terakhir</th>
                            <th style="text-align: center;" colspan="4">Hasil Tes</th>
                            <th style="text-align: center; width: 5%; vertical-align: middle" rowspan="3">Total Skor</th>
                            <th style="text-align: center; width: 5%; vertical-align: middle" rowspan="3">Rank</th>
                        </tr>
                        <tr>
                            <th style="text-align: center;" colspan="2">Psikotes</th>
                            <th style="text-align: center;" colspan="2">Wawancara</th>
                        </tr>
                        <tr>
                            <th style="text-align: center; width: 5%;">Nilai</th>
                            <th style="text-align: center;  width: 15%">Keterangan</th>
                            <th style="text-align: center; width: 5%;">Nilai</th>
                            <th style="text-align: center;  width: 15%">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="p_preview"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $(".select2").select2();
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        var table = $("#rekap-list-table").DataTable({
            processing: true,
            serverSide: true,
            autoWidth: true,
            // responsive: true,
            scrollX: true,
            ajax: {
                headers : {
                    'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
                },
                url: '{{ url("hrd/recruitment/rekap_hasil_tes/data") }}',
                type : 'post',
                data: function (d) {
                    d.dept = $("#pil_departemen").val();
                    d.jabatan = $("#pil_jabatan").val();
                }
            },
            columns: [
                { data: 'no'},
                { data: 'photo'},
                { data: 'nama_lengkap'},
                { data: 'usia' },
                { data: 'pend_akhir'},
                { data: 'nilai_psikotes'},
                { data: 'ket_psikotes'},
                { data: 'nilai_wawancara' },
                { data: 'ket_wawancara' },
                { data: 'total_skor'},
                { data: 'no'},
            ],
            columnDefs: [
                {
                    targets: [0, 1, 3, 4, 5, 7, 9, 10],
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
            var departemen = $("#pil_departemen").val();
            var jabatan = $("#pil_jabatan").val();
            if(departemen==0)
            {
                Swal.fire({
                    title: 'Warning',
                    text: 'Kolom pilihan departemen Tidak boleh kosong',
                    icon: 'warning'
                }).then(function() {
                    return false
                });
            } else if(jabatan==0)
            {
                Swal.fire({
                    title: 'Warning',
                    text: 'Kolom pilihan Jabatan Tidak boleh kosong',
                    icon: 'warning'
                }).then(function() {
                    return false
                });
            } else {
                table.draw();
            }
        });

    });
    function hapus_teks_jab()
    {
        $("#pil_jabatan").empty();
        $("#pil_jabatan").append("<option value='0'>Pilihan Jabatan</option>");
    }
    var actPrint = function()
    {
        var departemen = $("#pil_departemen").val();
        var jabatan = $("#pil_jabatan").val();
        if(departemen==0)
        {
            Swal.fire({
                title: 'Warning',
                text: 'Kolom pilihan departemen Tidak boleh kosong',
                icon: 'warning'
            }).then(function() {
                return false
            });
        } else if(jabatan==0)
        {
            Swal.fire({
                title: 'Warning',
                text: 'Kolom pilihan Jabatan Tidak boleh kosong',
                icon: 'warning'
            }).then(function() {
                return false
            });
        } else {
            window.open('{{ url("hrd/recruitment/rekap_hasil_tes/print") }}/'+departemen+"/"+jabatan);
        }

    }
    var actExcel = function()
    {
        var departemen = $("#pil_departemen").val();
        var jabatan = $("#pil_jabatan").val();
        if(departemen==0)
        {
            Swal.fire({
                title: 'Warning',
                text: 'Kolom pilihan departemen Tidak boleh kosong',
                icon: 'warning'
            }).then(function() {
                return false
            });
        } else if(jabatan==0)
        {
            Swal.fire({
                title: 'Warning',
                text: 'Kolom pilihan Jabatan Tidak boleh kosong',
                icon: 'warning'
            }).then(function() {
                return false
            });
        } else {
            window.open('{{ url("hrd/recruitment/rekap_hasil_tes/excel") }}/'+departemen+"/"+jabatan);
        }
    }
</script>
@endsection
