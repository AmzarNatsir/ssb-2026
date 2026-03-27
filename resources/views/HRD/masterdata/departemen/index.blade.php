@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active" aria-current="page">Departemen</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/masterdata/departemen') }}">Refresh (F5)</a></li>
        </ul>
    </nav>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-5">
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
        <div class="iq-card" id="page_view">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Input Master Departemen</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <form action="{{ url('hrd/masterdata/departemen/simpan') }}" method="post" onsubmit="return konfirm()">
                {{ csrf_field() }}
                    <div class=" row align-items-center">
                        <div class="form-group col-sm-12">
                            <label for="inp_nama">Divisi :</label>
                            <select class="select2 form-control mb-3" id="pil_divisi" name="pil_divisi" required>
                                @foreach($list_divisi as $divisi)
                                <option value="{{ $divisi->id }}">{{ $divisi->nm_divisi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @if(count($list_divisi)>0)
                    <div class=" row align-items-center">
                        <div class="form-group col-sm-12">
                            <label for="inp_nama">Nama Departemen :</label>
                            <input type="text" class="form-control" id="inp_nama" name="inp_nama" maxlength="200" required>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    @else
                    <span>Penginputan data master departemen belum bisa dilakukan. Silahkan mengisi data master divisi terlebih dahulu.</span>
                    @endif
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-7">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">List Master Departemen</h4>
                </div>
                <div class="user-list-files d-flex float-left">
                    <a href="javascript:void();" class="chat-icon-video" onClick="actExcel();"><i class="fa fa-table"></i> Excel</a>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <table class="table datatable table-hover tbl_list">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Departemen</th>
                            <th scope="col">Divisi</th>
                            <th scope="col">Status Data</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    @if(!empty($list_departemen))
                        @php $nom=1; @endphp
                        @foreach($list_departemen as $list =>$value)
                        <tr>
                            <th scope="row">{{ $nom }}</th>
                            <td>{{ $value->nm_dept }}</td>
                            <td>
                            {{ $value->nm_divisi }}
                            </td>
                            <td>{{ ($value->status==1)? "Aktif" : "Tidak Aktif" }}</td>
                            <td>
                                <button type="button" class="btn btn-primary mb-2 btn_edit" id="{{ $value->id }}"><i class="ri-edit-fill pr-0"></i></button>
                                <a href="{{ url('hrd/masterdata/departemen/hapus/'.$value->id) }}" class="btn btn-danger mb-2" onClick="return hapusKonfirm()"><i class="ri-delete-bin-line pr-0"></i></a>
                            </td>
                        </tr>
                        @php $nom++; @endphp
                        @endforeach
                    @endif
                    </tbody>    
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $('.datatable').DataTable();
        $(".angka").number(true, 0);
        $(".tbl_list").on("click", ".btn_edit", function()
        {
            var id_data = this.id;
            $("#page_view").load("{{ url('hrd/masterdata/departemen/edit') }}/"+id_data);
        });
    });
    var actExcel = function()
    {
        window.open('{{ route("ExportDepartemen") }}');
    }
    function konfirm()
    {
        var psn = confirm("Yakin akan menyimpan data ?");
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
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