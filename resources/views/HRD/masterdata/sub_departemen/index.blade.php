@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active" aria-current="page">Departemen</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/masterdata/subdepartemen') }}">Refresh (F5)</a></li>
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
                    <h4 class="card-title">Input Master Sub Departemen</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <form action="{{ url('hrd/masterdata/subdepartemen/simpan') }}" method="post" onsubmit="return konfirm()">
                {{ csrf_field() }}
                    @if(count($list_departemen)>0)
                    <div class=" row align-items-center">
                        <div class="form-group col-sm-12">
                            <label for="inp_nama">Divisi :</label>
                            <select class="select2 form-control mb-3" id="pil_divisi" name="pil_divisi" required>
                                <option value="0">Pilihan Divisi</option>
                                @foreach($list_divisi as $divisi)
                                <option value="{{ $divisi->id }}">{{ $divisi->nm_divisi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class=" row align-items-center">
                        <div class="form-group col-sm-12">
                            <label for="pil_departemen">Departemen :</label>
                            <select class="select2 form-control mb-3" id="pil_departemen" name="pil_departemen" required disabled>
                            </select>
                        </div>
                    </div>
                    <div class=" row align-items-center">
                        <div class="form-group col-sm-12">
                            <label for="inp_nama">Nama Sub Departemen :</label>
                            <input type="text" class="form-control" id="inp_nama" name="inp_nama" maxlength="200" required disabled>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary" id="tbl_simpan" disabled>Submit</button>
                    @else
                    <span>Pendataan Master Sub Departemen Belum Bisa Dilakukan. Silahkan mengisi data master Departemen.</span>
                    @endif
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-7">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">List Master Sub Departemen</h4>
                </div>
                <div class="user-list-files d-flex float-left">
                    <a href="javascript:void();" class="chat-icon-video" onClick="actExcel();"><i class="fa fa-table"></i> Excel</a>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Divisi</th>
                            <th scope="col">Departemen</th>
                            <th scope="col">Sub Departemen</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(!empty($list_subdepartemen))
                        @php $nom=1; @endphp
                        @foreach($list_subdepartemen as $list)
                        <tr>
                            <th scope="row">{{ $nom }}</th>
                            <td>@if(!empty($list->id_divisi))    
                            {{ $list->divisi->nm_divisi }}
                            @endif
                            </td>
                            <td>{{ $list->departemen->nm_dept }}</td>
                            <td>{{ $list->nm_subdept }}</td>
                            <td>
                                <button type="button" class="btn btn-primary mb-2 btn_edit" id="{{ $list->id }}"><i class="ri-edit-fill pr-0"></i></button>
                                <a href="{{ url('hrd/masterdata/subdepartemen/hapus/'.$list->id) }}" class="btn btn-danger mb-2" onClick="return hapusKonfirm()"><i class="ri-delete-bin-line pr-0"></i></a>
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
        $(".select2").select2({
            width: '100%',
            placeholder : 'Pilih Departemen'
        });
        $(".btn_edit").on("click", function()
        {
            var id_data = this.id;
            $("#page_view").load("{{ url('hrd/masterdata/subdepartemen/edit') }}/"+id_data);
        });
        $("#pil_divisi").on("change", function()
        {
            var id_pil = $("#pil_divisi").val();
            hapus_teks();
            if(id_pil==0)
            {
                aktif_teks(true);
                return false;
            } else {
                aktif_teks(false);
                $("#pil_departemen").load("{{ url('hrd/masterdata/subdepartemen/loaddepartement') }}/"+id_pil);
            }
        });
    });
    function aktif_teks(tf)
    {
        $("#pil_departemen").attr("disabled", tf);
        $("#inp_nama").attr("disabled", tf);
        $("#tbl_simpan").attr("disabled", tf);
    }
    function hapus_teks()
    {
        $("#pil_departemen").empty();
        $("#inp_nama").val("");
    }
    var actExcel = function()
    {
        window.open('{{ route("ExportSubDepartemen") }}');
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