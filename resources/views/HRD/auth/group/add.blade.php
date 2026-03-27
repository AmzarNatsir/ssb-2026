<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Input Group Baru</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<form action="{{ url('hrd/setup/manajemengroup/simpan') }}" method="post" onsubmit="return konfirm()">
{{ csrf_field() }}
<div class="modal-body">
    <div class="form-group row">
        <label class="col-sm-4">Nama Group</label>
        <div class="col-sm-8">
            <input type="text" name="inp_nama_group" id="inp_nama_group" class="form-control" maxlength="100" required>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save changes</button>
</div>
</form>
