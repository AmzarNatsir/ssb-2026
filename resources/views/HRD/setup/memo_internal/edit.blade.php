<div class="iq-card-header d-flex justify-content-between">
    <div class="iq-header-title">
        <h4 class="card-title">Edit Data Memo</h4>
    </div>
</div>
<div class="iq-card-body" style="width:100%; height:auto">
    <form action="{{ url('hrd/setup/memointernal/update/'.$dtmemo->id) }}" method="post" onsubmit="return konfirm()" enctype="multipart/form-data" name="form_edit">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
        <div class="form-group row">
            <div class="col-sm-12">
                <label>Judul Memo</label>
                <input type="text" name="inp_judul" id="inp_judul" class="form-control" maxlength="200" value="{{ $dtmemo->judul }}" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">
                <label>Deskripsi</label>
                <textarea class="form-control" name="keterangan" id="keterangan" required>{{ $dtmemo->deskripsi }}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">
                <label>Diterbitkan Oleh</label>
                <select class="form-control custom-select" name="pil_penerbit" id="pil_penerbit" required>
                    @foreach($list_departemen as $dept)
                    @if($dept->id==$dtmemo->departemen_post)
                        <option value="{{ $dept->id }}" selected>{{ $dept->nm_dept }}</option>
                    @else
                    <option value="{{ $dept->id }}">{{ $dept->nm_dept }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">
                <label>Status Memo</label>
                <select class="form-control" name="pil_status" id="pil_status">
                    @if($dtmemo->status==1)
                        <option value="1" selected>Aktif</option>
                        <option value="2">Tidak Aktif</option>
                    @else
                        <option value="1">Aktif</option>
                        <option value="2" selected>Tidak Aktif</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">
                <label>File Memo</label>
                <input type="file" name="inp_file" id="inp_file" class="form-control" onChange="loadFile(this);">
                <code>* jpg|jpeg|png only</code>
            </div>
        </div>
        <hr>
        <button type="submit" id="tbl_simpan" class="btn btn-primary">Submit</button>
        <hr>
        <div class="form-group row">
            <div class="col-sm-12">
                <img src="{{ url(Storage::url('memo_internal/'.$dtmemo->file_memo)) }}" id="preview_upload" style="width: 100%; height: auto;">
            </div>
        </div>
    </form>
</div>