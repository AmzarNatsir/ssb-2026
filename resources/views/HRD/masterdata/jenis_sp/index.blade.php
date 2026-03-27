@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item">Master Data</li>
        <li class="breadcrumb-item active" aria-current="page">Tingkatan Surat Peringatan (SP)</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/masterdata/jenissp') }}">Refresh (F5)</a></li>
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
                    <h4 class="card-title">Input Master TIngkatan SP</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <form action="{{ url('hrd/masterdata/jenissp/simpan') }}" method="post" onsubmit="return konfirm()">
                {{ csrf_field() }}
                    <div class=" row align-items-center">
                        <div class="form-group col-sm-12">
                            <label for="inp_nama">Nama Tingkatan SP :</label>
                            <input type="text" class="form-control" id="inp_nama" name="inp_nama" maxlength="200" required>
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="inp_nama">Lama Berlaku (Bulan) :</label>
                            <input type="text" class="form-control angka" id="inp_lama" name="inp_lama" value="0" maxlength="2">
                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-7">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">List Master Jenis SP</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tingkatan SP</th>
                            <th scope="col">Lama Berlaku (Bulan)</th>
                            <th scope="col">Status Data</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(!empty($list_result))
                        @php $nom=1; @endphp
                        @foreach($list_result as $list)
                        <tr>
                            <th scope="row">{{ $nom }}</th>
                            <td>{{ $list->nm_jenis_sp }}</td>
                            <td class="text-center">{{ $list->lama_berlaku }}</td>
                            <td class="text-center">{{ ($list->status==1)? "Aktif" : "Tidak Aktif" }}</td>
                            <td>
                                <button type="button" class="btn btn-primary mb-2 btn_edit" id="{{ $list->id }}"><i class="ri-edit-fill pr-0"></i></button>
                                <a href="{{ url('hrd/masterdata/jenissp/hapus/'.$list->id) }}" class="btn btn-danger mb-2" onClick="return hapusKonfirm()"><i class="ri-delete-bin-line pr-0"></i></a>
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
        $(".angka").number(true, 0);
        $(".btn_edit").on("click", function()
        {
            var id_data = this.id;
            $("#page_view").load("{{ url('hrd/masterdata/jenissp/edit') }}/"+id_data);
        });
    });
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
