@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active" aria-current="page">Jabatan</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/masterdata/jabatan') }}">Refresh (F5)</a></li>
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
    <div class="col-sm-12 col-lg-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">List Master Sub Departemen</h4>
                </div>
                <div class="user-list-files d-flex float-left">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalForm" onclick="goFormAdd(this)"><i class="fa fa-plus"></i> Data Baru</button>&nbsp;
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalForm" onclick="goFormGK(this)"><i class="fa fa-gear"></i> Pengaturan Atasan Langsung</button>
                    <a href="javascript:void();" onClick="actExcel();"><i class="fa fa-table"></i> Excel</a>
                </div>
            </div>
            <div class="iq-card-body table-responsive" style="width:100%; height:auto">
                <table class="table datatable table-hover tbl_list" style="width: 100%">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 5%;">#</th>
                            <th scope="col" style="width: 20%;">Jabatan</th>
                            <th scope="col" style="width: 15%;">Bagian/Seksi</th>
                            <th scope="col" style="width: 15%;">Departemen</th>
                            <th scope="col" style="width: 15%;">Divisi</th>
                            <th scope="col" style="width: 15%;">Level</th>
                            <th scope="col" style="width: 5%;">Status</th>
                            <th scope="col" style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(!empty($list_jabatan))
                        @php $nom=1; @endphp
                        @foreach($list_jabatan as $list)
                        <tr>
                            <td scope="row">{{ $nom }}</td>
                            <td>{{ $list->nm_jabatan }}</td>
                            <td>{{ $list->nm_subdept }}</td>
                            <td>{{ $list->nm_dept }}</td>
                            <td>{{ $list->nm_divisi }}</td>
                            <td>{{ $list->nm_level }}</td>
                            <td>{{ ($list->status==1)? "Aktif" : "Tidak Aktif" }}</td>
                            <td>
                                <div class="iq-card-header-toolbar d-flex align-items-center">
                                    <div class="dropdown">
                                    <span class="dropdown-toggle text-primary" id="dropdownMenuButton40" data-toggle="dropdown">
                                        <a href="#" class="text-secondary"><i class="ri-more-2-line ml-3"></i></a>
                                    </span>
                                    <div class="dropdown-menu dropdown-menu-right p-0">
                                        <button type="button" class="dropdown-item btn_edit" id="{{ $list->id }}" data-toggle="modal" data-target="#ModalForm" onclick="goFormEdit(this)"><i class="ri-edit-fill pr-0"></i> Edit</button>
                                        <a href="{{ url('hrd/masterdata/jabatan/hapus/'.$list->id) }}" class="dropdown-item" onClick="return hapusKonfirm()"><i class="ri-delete-bin-line pr-0"></i> Hapus</a>
                                    </div>
                                    </div>
                                </div>

                            </td>
                        @php $nom++; @endphp
                        @endforeach
                    @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="ModalForm" class="modal fade bg-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" id="v_inputan"></div>
    </div>
 </div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $('.datatable').DataTable();
        $(".select2").select2({
            width: '100%'
        });
        // $(".tbl_list").on("click", ".btn_edit", function()
        // {
        //     var id_data = this.id;
        //     $("#page_view").load("{{ url('hrd/masterdata/jabatan/edit') }}/"+id_data);
        // });
    });
    var actExcel = function()
    {
        window.open('{{ route("ExportJabatan") }}');
    }
    var goFormAdd = function()
    {
        $("#v_inputan").load("{{ url('hrd/masterdata/jabatan/add') }}");
    }
    var goFormEdit = function(el)
    {
        var id_data = el.id;
        $("#v_inputan").load("{{ url('hrd/masterdata/jabatan/edit') }}/"+id_data);
    }
    var goFormGK = function()
    {
        $("#v_inputan").load("{{ url('hrd/masterdata/jabatan/editAll') }}");
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
