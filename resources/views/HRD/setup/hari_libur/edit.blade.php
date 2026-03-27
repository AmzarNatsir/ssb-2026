<div class="iq-card-header d-flex justify-content-between">
    <div class="iq-header-title">
        <h4 class="card-title">Edit Data</h4>
    </div>
</div>
<div class="iq-card-body" style="width:100%; height:auto">
    <form action="{{ url('hrd/setup/harilibur/update/'.$profil_hari_libur->id) }}" method="post" onsubmit="return konfirm()">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
        <div class="form-group row">
            <label class="col-sm-4">Tanggal</label>
            <div class="col-sm-8">
                <input type="date" name="tgl_libur" id="tgl_libur" class="form-control" value="{{ $profil_hari_libur->tanggal }}" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">
                <label>Deskripsi Hari Libur</label>
                <textarea class="form-control" name="keterangan" id="keterangan" required>{{ $profil_hari_libur->keterangan }}</textarea>
            </div>
        </div>
        <hr>
        <button type="submit" id="tbl_simpan" class="btn btn-primary">Submit</button>
    </form>
</div>