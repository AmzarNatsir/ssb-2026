@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Setup</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/setup/memointernal') }}">Memo Internal (F5)</a></li>
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
    <div class="col-lg-5">
        <div class="iq-card" id="page_view">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Input Data Baru</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <form action="{{ url('hrd/setup/memointernal/simpan') }}" method="post" onsubmit="return konfirm()" enctype="multipart/form-data">
                {{ csrf_field() }}
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label>Judul Memo</label>
                            <input type="text" name="tgl_judul" id="tgl_judul" class="form-control" maxlength="200" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label>Deskripsi</label>
                            <textarea class="form-control" name="keterangan" id="keterangan" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label>Diterbitkan Oleh</label>
                            <select class="form-control custom-select" name="pil_penerbit" id="pil_penerbit" required>
                                @foreach($list_departemen as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->nm_dept }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label>File Memo</label>
                            <input type="file" name="inp_file" id="inp_file" class="form-control" onChange="loadFile(this);" required>
                            <code>* jpg|jpeg|png|pdf only</code>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <img id="preview_upload" style="width: 100%; height: auto;">
                        </div>
                    </div>
                    <hr>
                    <button type="submit" id="tbl_simpan" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Daftar Memo Internal</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <table class="table" style="width: 100%;">
                <thead>
                    <th style="width: 5%;">No.</th>
                    <th style="width: 20%;">Posting</th>
                    <th style="width: 20%;">Judul</th>
                    <th style="width: 30%;">Deskripsi</th>
                    <th style="width: 10%;">File</th>
                    <th style="width: 15%;">Aksi</th>
                </thead>
                <tbody>
                    @php $nom=1; @endphp
                    @foreach($list_memo as $list)
                    <tr>
                        <td>{{ $nom }}</td>
                        <td>{{ date_format(date_create($list->tgl_post), 'd-m-Y') }}<br>
                            Diterbitkan oleh : {{ (empty($list->get_departemen->nm_dept)) ? "" : $list->get_departemen->nm_dept }}
                        </td>
                        <td>{{ $list->judul }}</td>
                        <td>{{ $list->deskripsi }}</td>
                        <td>
                        <a href="{{ url(Storage::url('memo_internal/'.$list->file_memo)) }}" class="btn btn-primary" data-fancybox data-caption='Prview'><i class="fa fa-paperclip pr-0"></i></a>
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary mb-2 btn_edit" id="{{ $list->id }}"><i class="ri-edit-fill pr-0"></i></button>
                            <a href="{{ url('hrd/setup/memointernal/hapus/'.$list->id) }}" class="btn btn-danger mb-2" onClick="return hapusKonfirm()"><i class="ri-delete-bin-line pr-0"></i></a>
                        </td>
                    </tr>
                    @php $nom++; @endphp
                    @endforeach
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $(".select2").select2();
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".btn_edit").on("click", function()
        {
            var id_data = this.id;
            $("#page_view").load("{{ url('hrd/setup/memointernal/edit') }}/"+id_data);
        });
    });
    var _validFileExtensions = [".jpg", ".jpeg", ".png", '.pdf'];
  var loadFile = function(oInput) {
    if (oInput.type == "file") {
        var sFileName = oInput.value;
        var sSizeFile = oInput.files[0].size;
        var output = document.getElementById('preview_upload');
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
                alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
                oInput.value = "";
                output.src = "";
                return false;
            }
            if(sSizeFile>150000) //50 KB
            {
                alert("Sorry, " + sFileName + " is invalid, Ukuran file terlalu besar: " + sSizeFile);
                oInput.value = "";
                output.src = "";
                return false;
            } else {

              output.src = URL.createObjectURL(oInput.files[0]);
            }
        }

    }
    return true;

  };
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
