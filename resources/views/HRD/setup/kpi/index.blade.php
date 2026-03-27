@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Pengaturan Key Performance Indicator (KPI) Departemen</li>
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
        @foreach ($all_departemen as $r)
        <div class="col-sm-12">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">{{ $r['nm_dept'] }}</h4>
                    </div>
                    <div class="todo-notification d-flex align-items-center">
                        <button type="button" class="btn iq-bg-primary" data-toggle="modal" data-target="#ModalForm" onclick="goFormAdd(this)" value="{{ $r['id'] }}"><i class="ri-add-line mr-2"></i>Buat KPI Baru</button>
                    </div>
                </div>
                <div class="iq-card-body table-responsive" id="p_preview" style="width:100%; height:auto">
                    <table id="user-list-table" class="table  table-hover table-striped table-bordered" role="grid" aria-describedby="user-list-page-info">
                        <thead>
                            <tr>
                                <th style="text-align: center;">KPI</th>
                                <th style="width: 10%; text-align: center;">Bobot</th>
                                <th style="width: 10%; text-align: center;">Tipe</th>
                                <th style="width: 10%; text-align: center;">Satuan</th>
                                <th style="width: 20%; text-align: center;">Formula Hitung</th>
                                <th style="width: 20%; text-align: center;">Data Pendukung</th>
                                <th style="width: 5%;">Act.</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($r['list_kpi'] as $kpi)
                            <tr>
                                <td>{{ $kpi->nama_kpi }}</td>
                                <td class="text-center">{{ $kpi->bobot_kpi }} %</td>
                                <td class="text-center">{{ $kpi->tipeKPI->tipe_kpi }}</td>
                                <td class="text-center">{{ $kpi->satuanKPI->satuan_kpi }}</td>
                                <td>{{ $kpi->formula_hitung }}</td>
                                <td>{{ $kpi->data_pendukung }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary mb-2 btn_edit" data-toggle="modal" data-target="#ModalForm" onclick="goFormEdit(this)" value="{{ $kpi->id }}"><i class="ri-edit-fill pr-0"></i></button>
                                    <a href="{{ url('hrd/setup/kpi_hapus/'.$kpi->id) }}" class="btn btn-danger mb-2" onClick="return hapusKonfirm()"><i class="ri-delete-bin-line pr-0"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endforeach
</div>
<div id="ModalForm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" id="v_inputan"></div>
    </div>
 </div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $('#spinner-div').hide();
        $(".select2").select2();
    });
    var goFormAdd = function(el)
    {
        var id_dept = $(el).val();
        $("#v_inputan").load("{{ url('hrd/setup/kpi_baru') }}/"+id_dept);
    }
    var goFormEdit = function(el)
    {
        var id_kpi = $(el).val();
        $("#v_inputan").load("{{ url('hrd/setup/kpi_edit') }}/"+id_kpi);
    }
    function hapusKonfirm()
    {
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
