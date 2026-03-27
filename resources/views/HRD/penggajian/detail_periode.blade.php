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
</style>
<input type="hidden" name="periode_bulan" id="periode_bulan" value="{{ $periode->bulan }}">
<input type="hidden" name="periode_tahun" id="periode_tahun" value="{{ $periode->tahun }}">
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/penggajian') }}">Periode Penggajian</a></li>
        <li class="breadcrumb-item active" aria-current="page">Penggajian Karyawan</li>
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
                        <span>Daftar Penggajian Karyawan {{ \App\Helpers\Hrdhelper::get_nama_bulan($periode->bulan) }} {{ $periode->tahun }}</span>
                    </div>
                </div>
           </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-12">
        <div class="iq-card">
            <div class="iq-card-body">
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
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="todo-date d-flex mr-3">
                                        <i class="ri-calendar-2-line text-success mr-2"></i>
                                        <span>Daftar Gaji Karyawan</span>
                                    </div>
                                    <div class="todo-notification d-flex align-items-center">
                                        @if($periode->is_draft==1 && empty($periode->status_pengajuan))
                                        <button type="button" class="btn btn-primary" onclick="goPengaturan(this)" value="0"><i class="ri-edit-line mr-2"></i> Atur Penggajian</button>&nbsp;
                                        {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalFormPeriode"><i class="ri-edit-line mr-2"></i> Atur Penggajian</button>&nbsp; --}}
                                        @endif
                                        <button type="button" class="btn btn-success" onclick="getData(this)" value="0"><i class="ri-table-line mr-2"></i> Tampilkan Data</button>
                                    </div>
                                </div>
                                <hr>
                                <table id="listPayroll-0" class="table table-hover table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info" style="width: 100%; font-size: 13px">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="text-align: center; width: 4%;">No</th>
                                            <th scope="col" style="width: 20%; text-align: center">Karyawan</th>
                                            <th scope="col" style="width: 20%; text-align: center">Posisi</th>
                                            <th scope="col" style="width: 10%; text-align: center">Status</th>
                                            <th scope="col" style="text-align: center; width: 10%">Gaji Pokok</th>
                                            <th scope="col" style="text-align: center; width: 11%">Tunjangan</th>
                                            <th scope="col" style="text-align: center; width: 11%">Gaji Bruto</th>
                                            <th scope="col" style="text-align: center; width: 11%">Potongan</th>
                                            <th scope="col" style="text-align: center; width: 10%">THP</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- End -->
                    @foreach ($departemen as $dept)
                    <div class="card mb-1">
                        <div id="heading{{ $dept->id }}" class="card-header shadow-sm border-0" style="background-color: #dcdcdc">
                            <h2 class="mb-0">
                            <button type="button" data-toggle="collapse" data-target="#collapse{{ $dept->id }}" aria-expanded="true"
                                aria-controls="collapse{{ $dept->id }}"
                                class="btn btn-link text-dark font-weight-bold text-uppercase collapsible-link">{{ $dept->nm_dept }}</button>
                            </h2>
                        </div>
                        <div id="collapse{{ $dept->id }}" aria-labelledby="heading{{ $dept->id }}" data-parent="#accordionExample" class="collapse">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="todo-date d-flex mr-3">
                                        <i class="ri-calendar-2-line text-success mr-2"></i>
                                        <span>Daftar Gaji Karyawan</span>
                                    </div>
                                    <div class="todo-notification d-flex align-items-center">
                                        @if($periode->is_draft==1 && empty($periode->status_pengajuan))
                                        <button type="button" class="btn btn-primary" onclick="goPengaturan(this)" value="{{ $dept->id }}"><i class="ri-edit-line mr-2"></i> Atur Penggajian</button>&nbsp;
                                        @endif
                                        <button type="button" class="btn btn-success" onclick="getData(this)" value="{{ $dept->id }}"><i class="ri-table-line mr-2"></i> Tampilkan Data</button>
                                    </div>
                                </div>
                                <hr>
                                <table id="listPayroll-{{ $dept->id }}" class="table table-hover table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info" style="width: 100%; font-size: 13px">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="text-align: center; width: 4%;">No</th>
                                            <th scope="col" style="width: 20%; text-align: center">Karyawan</th>
                                            <th scope="col" style="width: 20%; text-align: center">Posisi</th>
                                            <th scope="col" style="width: 10%; text-align: center">Status</th>
                                            <th scope="col" style="text-align: center; width: 10%">Gaji Pokok</th>
                                            <th scope="col" style="text-align: center; width: 11%">Tunjangan</th>
                                            <th scope="col" style="text-align: center; width: 11%">Gaji Bruto</th>
                                            <th scope="col" style="text-align: center; width: 11%">Potongan</th>
                                            <th scope="col" style="text-align: center; width: 10%">THP</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- End -->
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<div id="ModalFormDetail" class="modal fade bg-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-ml" role="document">
        <div class="modal-content" id="v_form"></div>
    </div>
 </div>
<script>
    var getData = function(el)
    {
        var bulan = $("#periode_bulan").val();
        var tahun = $("#periode_tahun").val();
        var id_dept = $(el).val();
        var table = $('#listPayroll-'+id_dept).DataTable();
        table.destroy();

        var tableAjax = new DataTable('#listPayroll-'+id_dept, {
            ajax: {
                url: "{{ url('hrd/penggajian/getDataPenggajian') }}",
                // type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: function (d)
                {
                    d.bulan = bulan;
                    d.tahun = tahun;
                    d.id_dept = id_dept;
                }
            },
            processing: true,
            serverSide: true,
            columns: [
                { data: 'no' },
                { data: 'karyawan' },
                { data: 'posisi' },
                { data: 'status' },
                { data: 'gapok' },
                { data: 'tunjangan' },
                { data: 'gaji_bruto' },
                { data: 'potongan' },
                { data: 'thp' }
            ],
            columnDefs: [
                {
                    targets: [0, 3],
                    className: "dt-center"
                },
                {
                    targets: [4, 5, 6, 7],
                    className: "dt-right"
                }
            ],
        });
    }
    var detailTunjangan = function(el)
    {
        var id_data = el.id
        var bulan = $("#periode_bulan").val();
        var tahun = $("#periode_tahun").val();
        $("#v_form").load("{{ url('hrd/penggajian/detailTunjangan/')}}/"+id_data+"/"+bulan+"/"+tahun, function(){
            $(".angka").number(true, 0);
        });
    }
    var detailPotongan = function(el)
    {
        var id_data = el.id;
        var bulan = $("#periode_bulan").val();
        var tahun = $("#periode_tahun").val();
        $("#v_form").load("{{ url('hrd/penggajian/detailPotongan/')}}/"+id_data+"/"+bulan+"/"+tahun, function(){
            $(".angka").number(true, 0);
        });
    }

    var goPengaturan = function(el)
    {
        var id_data = $(el).val();
        var bulan = $("#periode_bulan").val();
        var tahun = $("#periode_tahun").val();
        var link = document.createElement("a")
            link.href = "{{ url('hrd/penggajian/pengaturanPenggajian') }}/"+id_data+"/"+bulan+"/"+tahun
            link.target = "_blank"
            link.click()
    }
</script>
@endsection
