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
</style>
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Penggajian Karyawan</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/penggajian') }}">Refresh (F5)</a></li>
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
    <div class="col-sm-12">
        <div class="iq-card">
           <div class="iq-card-body">
              <div class="d-flex justify-content-between align-items-center">
                 <div class="todo-date d-flex mr-3">
                    <i class="ri-calendar-2-line text-success mr-2"></i>
                    <span>Periode Penggajian Tahun {{ date("Y") }}</span>
                 </div>
                 <div class="todo-notification d-flex align-items-center">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ModalFormPeriode"><i class="ri-add-line mr-2"></i> Tambahkan</button>
                 </div>
              </div>
           </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-12">
        <div class="iq-card">
            <div class="iq-card-body">
                <ul class="iq-timeline">
                    @foreach ($PeriodePenggajian as $item)
                    <li>
                        <div class="timeline-dots border-success"></div>
                        <div class="container-fluid p-2">
                            <div class="row">
                                <table class="table" style="width: 100%">
                                    <tr style="background-color: #e9ecef">
                                        <td style="width: 40%"><h6 class="float-left mb-1"><b>Periode</b></h6><br>
                                            <h4>{{ \App\Helpers\Hrdhelper::get_nama_bulan($item->bulan) }} {{ $item->tahun }}</h4></td>
                                        <td style="width: 40%">
                                            <b><h6 class="float-left mb-1">Status Laporan</h6></b><br>
                                            @if($item->is_draft==1 && empty($item->status_pengajuan))
                                            <span class="badge badge-primary">Draft</span>
                                        @else
                                            @if($item->status_pengajuan==1)
                                                Menunggu Persetujuan : <span class="badge badge-pill badge-danger">{{ $item->get_current_approve->nm_lengkap }}</span>
                                                <span class="badge badge-pill badge-success">{{ $item->get_current_approve->get_jabatan->nm_jabatan }}</span>
                                            @elseif($item->status_pengajuan==2)
                                                <span class="badge badge-success">Disetujui</span>
                                            @else
                                                <span class="badge badge-danger">Ditolak</span>
                                            @endif
                                        @endif</td>
                                        <td style="width: 20%">
                                            <div class="iq-card-header-toolbar d-flex align-items-center float-right">
                                                <div class="btn-group mb-1 dropup">
                                                    {{-- <button type="button" class="btn btn-secondary">Opsi</button> --}}
                                                    <button type="button" class="btn btn-default dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ri-more-2-line"></i>
                                                    <span class="sr-only"></span>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{ url('hrd/penggajian/detailPeriodePenggajian/'.$item->id) }}"><i class="ri-table-line mr-2"></i>{{ ($item->is_draft==1 && empty($item->status_pengajuan)) ? "Pengaturan" : "Detail" }}</a>
                                                        @if($item->is_draft==1 && empty($item->status_pengajuan))
                                                        <a class="dropdown-item" href="{{ url('hrd/penggajian/downloadtemplatePeriodePenggajian/'.$item->tahun."/".$item->bulan) }}"><i class="fa fa-download mr-2"></i>Download Template</a>
                                                        <a class="dropdown-item" href="{{ url('hrd/penggajian/importPeriodePenggajian') }}"><i class="fa fa-upload mr-2"></i>Import</a>
                                                        <a class="dropdown-item" href="{{ url('hrd/penggajian/submitPenggajian/'.$item->bulan.'/'.$item->tahun.'/'.$item->approval_key) }}"><i class="fa fa-check mr-2"></i>Submit</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
<div id="ModalFormPeriode" class="modal fade bg-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-ml" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Tambah Data Periode Penggajian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <form method="post" id="form_periode">
            {{csrf_field()}}
            <div class="modal-body">
                <div class="iq-card-body p-0">
                    <div class="row justify-content-between">
                        <div class="col-sm-8">
                            <select class="form-control" name="pil_periode_bulan" id="pil_periode_bulan" style="width: 100%;">
                            @foreach($list_bulan as $key => $value)
                            @if($key==date('m'))
                                <option value="{{ $key }}" selected>{{ $value }}</option>
                                @php break; @endphp
                            @else
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endif
                            @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="inp_periode_tahun" id="inp_periode_tahun" value="{{ date('Y') }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup Form</button>
                <button type="submit" class="btn btn-primary" name="btn-submit" id="btn-submit">Simpan Data</button>
            </div>
            </form>
        </div>
    </div>
 </div>
<script type="text/javascript">

    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $('#form_periode').submit(function (e) {
            e.preventDefault(); // Prevent default form submission
            Swal.fire({
                title: "Yakin akan menyimpan periode pengajuan ?",
                text: "Submit data!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Submit!",
                cancelButtonText: "Batal",
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    let formData = new FormData(document.getElementById('form_periode'));
                    $.ajax({
                        url: "{{ url('hrd/penggajian/simpanPeriodePenggajian') }}",
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        data: formData, //$(this).serialize(),
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if (response.status==true) {
                                $('#ModalFormPeriode').modal('hide');
                                Swal.fire({
                                    title: 'Success!',
                                    text: response.message,
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = "{{ url('hrd/penggajian') }}";
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: "It's danger!",
                                    text: response.message
                                });
                                return false;
                            }
                        },
                        error: function (xhr) {
                            console.log(xhr.responseText); // Debugging errors
                            Swal.fire({
                                icon: 'error',
                                title: "It's danger!",
                                text: "Something went wrong! "+xhr.responseText
                            });
                        }
                    });
                } else {
                    Swal.close();
                }
            });
        });


        // $("#btn-submit").on("click", function(event){
        //     let form = $("#form_periode");
        //     // event.preventDefault();
        //     var formData = form.serialize();
        //     $.ajax({
        //         headers : {
        //             'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
        //         },
        //         type: "POST",
        //         url: "{{ url('hrd/penggajian/simpanPeriodePenggajian') }}",
        //         data: formData,
        //         dataType: 'json',
        //         success: function(data) {
        //             if(data.status==true)
        //             {
        //                 Swal.fire({
        //                     title: 'Suksess',
        //                     text: data.message,
        //                     icon: 'success'
        //                 }).then(function() {
        //                     location.reload();
        //                 });
        //             } else {
        //                 Swal.fire({
        //                     title: 'Gagal',
        //                     text: data.message,
        //                     icon: 'error'
        //                 });
        //             }
        //         },
        //         error: function(data) {
        //             // Some error in ajax call
        //             Swal.fire({
        //                     title: 'Gagal',
        //                     text: data.message,
        //                     icon: 'error'
        //                 });
        //         }
        //     });
        // });

    });
</script>
@endsection
