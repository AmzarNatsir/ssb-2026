<form action="{{ url('hrd/setup/manajemenmenu/simpan') }}" method="POST" onsubmit="return konfirm()">
    {{ csrf_field() }}
    <div class="form-group row">
        <label class="col-sm-4">Kategori Aplikasi</label>
        <div class="col-sm-8">
            <select class="form-control" id="pil_kategori" name="pil_kategori">
                <option value="1">HRD</option>
                <option value="2">WAREHOUSE</option>
                <option value="3">TENDER</option>
                <option value="4">HSE</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4">Nama Menu</label>
        <div class="col-sm-8">
            <input type="text" name="inp_nama_menu" id="inp_nama_menu" class="form-control" maxlength="150" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>