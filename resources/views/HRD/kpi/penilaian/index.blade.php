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
<form id="penilaianForm" method="post">
@csrf
<div class="row">
    <div class="col-lg-9">
        <div class="row">
            <div class="col-sm-12">
                {{-- notifikasi jika ada kpi telah di posting --}}
                @if(count($kpiPosting) > 0)
                <div class="iq-card">
                    <div class="iq-card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="todo-notification d-flex align-items-center">
                                @foreach ($kpiPosting as $r)
                                <div class="notification-icon position-relative d-flex align-items-center mr-3">
                                    <i class="ri-notification-3-line font-size-16"></i>
                                </div>
                                <button type="button" class="btn iq-bg-danger" value="{{ $r->id }}" onclick="goPenilaian(this)">PENILAIAN KINERJA PERIODE {{ strtoupper($helper::get_nama_bulan($r->bulan)). " ". $r->tahun }}</button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if(count($kpiApproval) > 0)
                <div class="iq-card">
                    <div class="iq-card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="todo-notification d-flex align-items-center">
                                @foreach ($kpiApproval as $r)
                                <div class="notification-icon position-relative d-flex align-items-center mr-3">
                                    <i class="ri-notification-3-line font-size-16"></i>
                                </div>
                                <button type="button" class="btn iq-bg-success" value="{{ $r->id }}" onclick="goKPI(this)">PENILAIAN KINERJA PERIODE {{ strtoupper($helper::get_nama_bulan($r->bulan)). " ". $r->tahun }}</button> &nbsp;
                                <button type="button" class="btn iq-bg-info"><i class="ri-arrow-right-s-line"></i> Waiting Approval</button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                {{-- end notif --}}
                <div class="iq-card">
                    <div class="iq-card-body">
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
    <div class="col-md-3">
        <div class="iq-card">
            <div class="iq-card-body">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">Arsip {{ date("Y") }}</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    @foreach ($kpiClosed as $closed)
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="todo-notification d-flex align-items-center">
                            <button type="button" class="btn iq-bg-success" value="{{ $closed->id }}" onclick="goKPI(this)">KPI Periode {{ strtoupper($helper::get_nama_bulan($closed->bulan)). " ". $closed->tahun }}</button>
                        </div>
                    </div>
                    <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<div id="ModalForm" class="modal fade bg-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" id="v_detail"></div>
    </div>
 </div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $('#spinner-div').hide();
        $(".select2").select2();
    });
    var goPenilaian = function(el)
    {
        var idData = $(el).val();
        $("#loader").show();
        $("#p_preview").hide();

        $("#p_preview").load("{{ url('hrd/kpi/formPenilaian') }}/"+idData, function() {
            $("#loader").hide();
            $("#p_preview").fadeIn();
            $(".angka").number(true, 0);
        });
    }
    var goKPI = function(el)
    {
        var idData = $(el).val();
        $("#loader").show();
        $("#p_preview").hide();

        $("#p_preview").load("{{ url('hrd/kpi/kpiPeriodik') }}/"+idData, function() {
            $("#loader").hide();
            $("#p_preview").fadeIn();
        });
    }
    var goDetailKPI = function(el)
    {
        $("#v_detail").load("{{ url('hrd/kpi/detailKPI') }}/"+el.id);
    }

    var goUploadLampiran = function(el)
    {
        $("#v_detail").load("{{ url('hrd/kpi/formUploadLampiranKPI') }}/"+el.id, function() {
            $("#uploadForm").validate({
                rules: {
                    inp_keterangan: {
                        required: true,
                    },
                    inp_file: {
                        required: true,
                    },
                },
                messages: {
                    inp_keterangan: {
                        required: "Inputan keterangan file lampiran tidak boleh kosong",
                    },
                    inp_file: {
                        required: "Inputan file lampiran tidak boleh kosong",
                    },
                },
                errorClass: "text-danger",
                errorElement: "small",
                highlight: function(element) {
                    $(element).addClass("is-invalid");
                },
                unhighlight: function(element) {
                    $(element).removeClass("is-invalid");
                }
            });
            document.querySelector('#uploadForm').addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent the form from submitting
                Swal.fire({
                    title: "Anda yakin menyimpan data ?",
                    text: "Upload File Pendukung Penilaian KPI Departemen!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Submit!",
                    // confirmButtonText: "Simpan!",
                    cancelButtonText: "Batal",
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger"
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        let form = document.querySelector('#uploadForm');
                        let formData = new FormData(form); // 🔥 Inilah yang bisa handle file
                        $.ajax({
                            url: "{{ url('hrd/kpi/storeUploadLampiranKPI') }}",
                            type: "POST",
                            data: formData,
                            processData: false, // ⛔ Jangan proses data (biarkan FormData)
                            contentType: false, // ⛔ Jangan set contentType (biar browser yang atur)
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
                                        location.replace("{{ url('hrd/kpi/penilaian') }}");
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
        });
    }

    var changeToNull = function(el)
    {

        if($(el).val()=="")
        {
            $(el).val("0");
        }
        calculateSkorAkhir(el);
    }

    var calculateSkorAkhir = function(el)
    {
        var currentRow=$(el).closest("tr");
        var current_bobot = $(el).parent().parent().find('input[name="bobot[]"]').val();
        var current_target = $(el).parent().parent().find('input[name="target[]"]').val();
        var current_realisasi = $(el).parent().parent().find('input[name="realisasi[]"]').val();
        var skor = (current_target==0) ? 0 : (current_realisasi/current_target)*100;
        var skor_akhir = (skor * current_bobot) / 100;
        if(parseFloat(current_realisasi) > parseFloat(current_target)) {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Realisasi tidak boleh melebihi target'
            });
            $(el).parent().parent().find('input[name="realisasi[]"]').val("0");
            currentRow.find('input[name="skor_akhir[]"]').val("0");
            currentRow.find('input[name="nilai_akhir[]"]').val("0");
            return false
        }
        currentRow.find('input[name="skor_akhir[]"]').val(skor);
        currentRow.find('input[name="nilai_akhir[]"]').val(skor_akhir);
        calculateTotalKPI();

    }
    var calculateTotalKPI = function()
    {
        var total = 0;
        $.each($('input[name="nilai_akhir[]"]'),function(key, value){
            total += parseFloat($(value).val());
        })
        $("#total_nilai_kpi").val(total);
    }

    var _validFileExtensions = [".pdf", ".doc", ".docx", ".xls", ".xlsx"];
    var loadFile = function(oInput)
    {
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            var sSizeFile = oInput.files[0].size;
            //alert(sSizeFile);
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions.length; j++) {
                    var sCurExtension = _validFileExtensions[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    }
                }

                if (!blnValid) {
                    Swal.fire("Maaf, " + sFileName + " tidak valid, jenis file yang boleh di upload adalah: " + _validFileExtensions.join(", "), "Warming!", "warning");
                    oInput.value = "";
                    return false;
                }
            }

        }
        return true;
    };
    document.querySelector('#penilaianForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting
        var action = document.activeElement.value;
        Swal.fire({
            title: "Anda yakin " + (action === 'simpan' ? "menyimpan sebagai draft" : "submit") + " KPI departemen ?",
            text: "Penilaian KPI Departemen!",
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
                    url: "{{ url('hrd/kpi/storePenilaianKPIDepartemen') }}",
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
                                location.replace("{{ url('hrd/kpi/penilaian') }}");
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

    var goDownloadLampiran = function(el)
    {
        window.open("{{ url('hrd/kpi/downloadLampiranKPI') }}/"+el.id);
    }

    var goDeleteLampiran = function(el) {
        Swal.fire({
            title: "Anda yakin ingin menghapus lampiran ini ?",
            text: "Lampiran KPI!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Hapus!",
            // confirmButtonText: "Simpan!",
            cancelButtonText: "Batal",
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax(
                {
                    url: "{{ url('hrd/kpi/deleteLampiranKPI') }}/"+el.id,
                    type: "GET",
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
                                location.reload();
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
        })
    }
</script>
@endsection
