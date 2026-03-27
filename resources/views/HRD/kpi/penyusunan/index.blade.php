@extends('HRD.layouts.master')
@section('content')
<style>
    .loader {
        border: 8px solid #f3f3f3;
        border-top: 8px solid #3498db;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        animation: spin 1s linear infinite;
        margin: 0 auto;
    }
    /* @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    } */
</style>
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Key Performance Indicator (KPI)</li>
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
<form id="createForm" method="post">
    @csrf
<div class="row">
    <div class="col-sm-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Penyusunan KPI Departemen Periode {{ $currentYear }}</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="iq-card">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">Filter Data</h4>
                                </div>
                            </div>
                            <div class="iq-card-body">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>Periode Bulan:</label>
                                        <select class="form-control select2" name="pil_bulan" id="pil_bulan" style="width: 100%">
                                            <option value="0">- Pilihan Bulan</option>
                                            @foreach ($listBulan as $key => $bln)
                                            <option value="{{ $key }}" {{ $key == date('m') ? 'selected' : '' }}>{{ $bln }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Periode Tahun:</label>
                                        <select class="form-control select2" name="pil_tahun" id="pil_tahun" style="width: 100%">
                                            <option value="0">- Pilihan Tahun</option>
                                            @for($year = $startYear; $year <= $currentYear; $year++)
                                            <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>{{ $year }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Departemen:</label>
                                        <select class="form-control select2" name="pil_dept" id="pil_dept" style="width: 100%">
                                            <option value="0">- Pilihan Departemen</option>
                                            @foreach ($allDepartemen as $departemen)
                                            <option value="{{ $departemen->id }}">{{ $departemen->nm_dept }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="user-list-files d-flex float-left" >
                                            <a href="javascript:void(0);" class="chat-icon-phone" onClick="actFilter();"><i class="fa fa-search"></i> FILTER</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                {{-- </div>
                <div class="row"> --}}
                    <div class="col-lg-9">
                        <div id="loader" class="text-center my-3" style="display: none;">
                            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                                <span class="visually-hidden"></span>
                            </div>
                        </div>
                        <div id="p_preview"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $('#spinner-div').hide();
        $(".select2").select2();
    });
    var actFilter = function()
    {
        var bulan = $("#pil_bulan").val();
        var tahun = $("#pil_tahun").val();
        var pil_departemen = $("#pil_dept").val();
        if(bulan==0)
        {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Kolom pilihan bulan Tidak boleh kosong '
            });
            return false
        }
        if(tahun==0)
        {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Kolom pilihan tahun Tidak boleh kosong '
            });
            return false
        }
        if(pil_departemen==0)
        {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Kolom pilihan departemen Tidak boleh kosong '
            });
            return false
        }
        $("#loader").show();
        $("#p_preview").hide();

        $("#p_preview").load("{{ url('hrd/kpi/getKPI') }}/"+pil_departemen+"/"+tahun+"/"+bulan, function() {
            $("#loader").hide();
            $("#p_preview").fadeIn();
        });
    }
    document.querySelector('#createForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting
        var bulan = $("#pil_tahun").val();
        var tahun = $("#pil_tahun").val();
        var pil_departemen = $("#pil_dept").val();
        if(bulan==0)
        {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Kolom pilihan bulan Tidak boleh kosong '
            });
            return false
        }
        if(tahun==0)
        {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Kolom pilihan tahun Tidak boleh kosong '
            });
            return false
        }
        if(pil_departemen==0)
        {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Kolom pilihan departemen Tidak boleh kosong '
            });
            return false
        }
        var action = document.activeElement.value;
        Swal.fire({
            title: "Anda yakin " + (action === 'simpan' ? "menyimpan sebagai draft" : "submit") + " KPI departemen ?",
            text: "Pengaturan KPI Departemen!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: action === 'simpan' ? "Simpan Draft!" : "Submit!",
            // confirmButtonText: "Simpan!",
            cancelButtonText: "Batal",
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('hrd/kpi/storeKPIDepartemen') }}",
                    type: "POST",
                    data: $(this).serialize() + "&action=" + action,
                    beforeSend: function()
                    {
                        $("#loader").show();
                    },

                    success: function (response) {
                        if (response.success == true) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.replace("{{ url('hrd/kpi/penyusunan') }}");
                            });
                        } else {
                            Swal.fire("Terjadi kesalahan", response.message, "error");
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        Swal.fire("Terjadi kesalahan", "Ada yang salah!", "error");
                    },
                    complete: function()
                    {
                        $("#loader").hide();
                    }
                });
            }
        });
    });
</script>
@endsection
