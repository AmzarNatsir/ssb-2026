@extends('HRD.layouts.master')
@section('content')
<style>
    .collapsible-link {
        width: 100%;
        position: relative;
        text-align: left;
        }

    .collapsible-link::before {
        content: "\f107";
        position: absolute;
        top: 50%;
        right: 0.8rem;
        transform: translateY(-50%);
        display: block;
        font-family: "FontAwesome";
        font-size: 1.1rem;
    }

    .collapsible-link[aria-expanded="true"]::before {
        content: "\f106";
    }

    .datatable1 th:nth-child(2),
    .datatable1 td:nth-child(2) {
        position: sticky;
        left: 0;
        background: white;
        z-index: 2;
    }
</style>
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/penggajian') }}">Periode Penggajian</a></li>
        <li class="breadcrumb-item active" aria-current="page">Form Submit Penggajian</li>
        </ul>
    </nav>
</div>
@if(\Session::has('status'))
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="alert text-white bg-success" role="alert" id="success-alert">
            <div class="iq-alert-icon">
                <i class="ri-alert-line"></i>
            </div>
            <div class="iq-alert-text">{{ \Session::get('status') }}</div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="ri-close-line"></i>
            </button>
        </div>
    </div>
</div>
@endif
<form id="submitPengganjian" name="submitPengganjian" method="post">
{{ csrf_field() }}
<input type="hidden" name="periode_bulan" id="periode_bulan" value="{{ $bulan }}">
<input type="hidden" name="periode_tahun" id="periode_tahun" value="{{ $tahun }}">
<input type="hidden" name="periode_uuid" value="{{ $uuid_periode }}">
<div class="row">
    <div class="col-lg-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                   <h4 class="card-title">Daftar Gaji karyawan Periode : {{ $periode }} - (Preview)</h4>
                </div>
             </div>
            <div class="iq-card-body">
                <div class="form-group">
                    <div id="accordionExample" class="accordion shadow">
                        <div class="card mb-1">
                            <div id="headingOne" class="card-header shadow-sm border-0" style="background-color: #dcdcdc">
                                <h2 class="mb-0">
                                <button type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                    aria-controls="collapseOne"
                                    class="btn btn-link text-dark font-weight-bold text-uppercase collapsible-link">Non Departemen</button>
                                </h2>
                            </div>
                            <div id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionExample" class="collapse">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="user-list-table-1" class="table-hover table-striped table-bordered datatable" cellpadding="4" role="grid" aria-describedby="user-list-page-info" style="width: 100%; font-size: 14px">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center; width: 3%; ">No</th>
                                                    <th style="text-align: center;">Karyawan</th>
                                                    <th style="text-align: center;">Posisi</th>
                                                    <th style="text-align: center; width: 10%">Gaji&nbsp;Pokok</th>
                                                    <th style="text-align: center;">Total&nbsp;Tunjangan</th>
                                                    <th style="text-align: center;">Gaji&nbsp;Bruto</th>
                                                    <th style="text-align: center;">Total&nbsp;Potongan</th>
                                                    <th style="text-align: center;">Tunjangan&nbsp;BPJS</th>
                                                    <th style="text-align: center; width: 8%">THP</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $nom_non_dept = 1; @endphp
                                                @foreach ($data_non_dept as $r1)
                                                @php
                                                $gapok = $r1['list_data']['gaji_pokok'] ?? 0;
                                                $pot_bpjs_ks = $r1['list_data']['bpjsks_karyawan'] ?? 0;
                                                $pot_jht = $r1['list_data']['bpjstk_jht_karyawan'] ?? 0;
                                                $pot_jp = $r1['list_data']['bpjstk_jp_karyawan'] ?? 0;
                                                $pot_jkm = $r1['list_data']['bpjstk_jkm_karyawan'] ?? 0;
                                                $pot_sedekah = $r1['list_data']['pot_sedekah'] ?? 0;
                                                $pot_pkk = $r1['list_data']['pot_pkk'] ?? 0;
                                                $pot_air = $r1['list_data']['pot_air'] ?? 0;
                                                $pot_rumah = $r1['list_data']['pot_rumah'] ?? 0;
                                                $pot_toko_alif = $r1['list_data']['pot_toko_alif'] ?? 0;
                                                $tot_potongan = $pot_bpjs_ks + $pot_jht + $pot_jp + $pot_jkm + $pot_sedekah + $pot_pkk + $pot_air + $pot_rumah + $pot_toko_alif;
                                                //tunjangan
                                                $tunj_perusahaan = $r1['list_data']['tunj_perusahaan'] ?? 0;
                                                $total_tunj_perusahaan_bpjs = $r1['list_data']['pot_tunj_perusahaan'] ?? 0;
                                                $gaji_bruto = $gapok + $tunj_perusahaan;
                                                //thp
                                                $thp = $gaji_bruto - $total_tunj_perusahaan_bpjs  - $tot_potongan;

                                                @endphp
                                                <tr>
                                                    <td class="text-center">{{ $nom_non_dept++ }}</td>
                                                    <td>{{ $r1['nik'] }} - {{ $r1['nm_lengkap'] }}</td>
                                                    <td><b>{{ $r1['get_jabatan']['nm_jabatan'] }}</b></td>
                                                    <td style="text-align: right">{{ number_format($r1['list_data']['gaji_pokok'], 0) }}</td>
                                                    <td style="text-align: right">
                                                        @if(!empty($r1['list_data']['gaji_pokok']))
                                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ModalFormDetail" onclick="goTunjangan(this)" id="{{ $r1['list_data']['id_karyawan'] }}" name="detailTunjangan[]">{{ number_format($tunj_perusahaan, 0) }}</button>
                                                        @endif
                                                    </td>
                                                    <td style="text-align: right">{{ number_format($gaji_bruto, 0) }}</td>
                                                    <td style="text-align: right">
                                                        @if(!empty($r1['list_data']['gaji_pokok']))
                                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalFormDetail" onclick="goPotongan(this)" id="{{ $r1['list_data']['id_karyawan'] }}" name="detailPotongan[]">{{ number_format($tot_potongan, 0) }}</button>
                                                        @endif
                                                    </td>
                                                    <td style="text-align: right">{{ number_format($total_tunj_perusahaan_bpjs, 0) }}</td>
                                                    <td style="text-align: right"><b>{{ number_format($thp, 0) }}</b></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @foreach ($data as $r)
                        <div class="card mb-1">
                            <div id="heading{{ $r['id'] }}" class="card-header shadow-sm border-0" style="background-color: #dcdcdc">
                                <h2 class="mb-0">
                                <button type="button" data-toggle="collapse" data-target="#collapse{{ $r['id'] }}" aria-expanded="true"
                                    aria-controls="collapse{{ $r['id'] }}"
                                    class="btn btn-link text-dark font-weight-bold text-uppercase collapsible-link">{{ $r['nm_dept'] }}</button>
                                </h2>
                            </div>
                            <div id="collapse{{ $r['id'] }}" aria-labelledby="heading{{ $r['id'] }}" data-parent="#accordionExample" class="collapse">
                                <div class="card-body">
                                    <div class="table-responsive">
                                    <table id="user-list-table" class="table-hover table-striped table-bordered datatable" cellpadding="4" role="grid" aria-describedby="user-list-page-info" style="width: 100%; font-size: 14px">
                                        <thead>
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center; width: 3%; ">No</th>
                                                    <th style="text-align: center;">Karyawan</th>
                                                    <th style="text-align: center;">Posisi</th>
                                                    <th style="text-align: center; width: 10%">Gaji&nbsp;Pokok</th>
                                                    <th style="text-align: center;">Total&nbsp;Tunjangan</th>
                                                    <th style="text-align: center;">Gaji&nbsp;Bruto</th>
                                                    <th style="text-align: center;">Total&nbsp;Potongan</th>
                                                    <th style="text-align: center;">Tunjangan&nbsp;BPJS</th>
                                                    <th style="text-align: center; width: 8%">THP</th>
                                                </tr>
                                            </thead>
                                        </thead>
                                        <tbody>
                                            @php $nom_dept = 1; @endphp
                                            @foreach ($r['list_data'] as $r2)
                                            @php
                                            $gapok = $r2['gaji_pokok'] ?? 0;
                                            $pot_bpjs_ks = $r2['bpjsks_karyawan'] ?? 0;
                                            $pot_jht = $r2['bpjstk_jht_karyawan'] ?? 0;
                                            $pot_jp = $r2['bpjstk_jp_karyawan'] ?? 0;
                                            $pot_jkm = $r2['bpjstk_jkm_karyawan'] ?? 0;
                                            $pot_sedekah = $r2['pot_sedekah'] ?? 0;
                                            $pot_pkk = $r2['pot_pkk'] ?? 0;
                                            $pot_air = $r2['pot_air'] ?? 0;
                                            $pot_rumah = $r2['pot_rumah'] ?? 0;
                                            $pot_toko_alif = $r2['pot_toko_alif'] ?? 0;
                                            $tot_potongan = $pot_bpjs_ks + $pot_jht + $pot_jp + $pot_jkm + $pot_sedekah + $pot_pkk + $pot_air + $pot_rumah + $pot_toko_alif;
                                            //tunjangan
                                            $tunj_perusahaan = $r2['tunj_perusahaan'] ?? 0;
                                            $total_tunj_perusahaan_bpjs = $r2['pot_tunj_perusahaan'] ?? 0;
                                            $gaji_bruto = $gapok + $tunj_perusahaan;
                                            //thp
                                            $thp = $gaji_bruto - $total_tunj_perusahaan_bpjs  - $tot_potongan;

                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $nom_dept++ }}</td>
                                                <td>{{ $r2['nik'] }} - {{ $r2['nm_lengkap'] }}</td>
                                                <td><b>{{ $r2['jabatan'] }}</b></td>
                                                <td style="text-align: right">{{ number_format($r2['gaji_pokok'], 0) }}</td>
                                                <td style="text-align: right">
                                                    @if(!empty($r2['gaji_pokok']))
                                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ModalFormDetail" onclick="goTunjangan(this)" id="{{ $r2['id_karyawan'] }}" name="detailTunjangan[]">{{ number_format($tunj_perusahaan, 0) }}</button>
                                                    @endif
                                                </td>
                                                <td style="text-align: right">{{ number_format($gaji_bruto, 0) }}</td>
                                                <td style="text-align: right">
                                                    @if(!empty($r2['gaji_pokok']))
                                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalFormDetail" onclick="goPotongan(this)" id="{{ $r2['id_karyawan'] }}" name="detailPotongan[]">{{ number_format($tot_potongan, 0) }}</button>
                                                    @endif
                                                </td>
                                                <td style="text-align: right">{{ number_format($total_tunj_perusahaan_bpjs, 0) }}</td>
                                                <td style="text-align: right"><b>{{ number_format($thp, 0) }}</b></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="modal-footer d-flex justify-content-center mt-3">
                        <button type="submit" class="btn btn-primary" name="btn-submit" id="btn-submit">Klik untu men-submit pengajuan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="ModalFormDetail" class="modal fade bg-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" id="v_form_detail"></div>
    </div>
 </div>
</form>
<script>
    $(document).ready(function()
    {
        // window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        // $('.datatable').DataTable({
        //     fixedColumns: {
        //         start: 3,
        //         // end: 1,
        //     },
        //     scrollCollapse: true,
        //     scrollX: true,
        //     autoWidth: true, // <-- add this
        //     scrollY: 300,
        //     searchDelay: 500,
        //     processing: true,
        // });
        $('#submitPengganjian').submit(function (e) {
            e.preventDefault(); // Prevent default form submission
            Swal.fire({
                title: "Yakin akan men-Submit pengajuan ?",
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
                    let formData = new FormData(document.getElementById('submitPengganjian'));
                    $.ajax({
                        url: "{{ url('hrd/penggajian/storeSubmitPenggajian') }}", // Update this with your route
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        data: formData, //$(this).serialize(),
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if (response.status==true) {
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
    });
    var goTunjangan = function(el)
    {
        var id_data = el.id
        var bulan = $("#periode_bulan").val();
        var tahun = $("#periode_tahun").val();
        $("#v_form_detail").load("{{ url('hrd/penggajian/detailTunjangan/')}}/"+id_data+"/"+bulan+"/"+tahun, function(){
            $(".angka").number(true, 0);
        });
    }
    var goPotongan = function(el)
    {
        var id_data = el.id;
        var bulan = $("#periode_bulan").val();
        var tahun = $("#periode_tahun").val();
        $("#v_form_detail").load("{{ url('hrd/penggajian/detailPotongan/')}}/"+id_data+"/"+bulan+"/"+tahun, function(){
            $(".angka").number(true, 0);
        });
    }
</script>
@endsection
