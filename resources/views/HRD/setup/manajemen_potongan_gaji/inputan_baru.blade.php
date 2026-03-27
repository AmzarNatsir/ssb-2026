<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Pengaturan Potongan Gaji Karyawan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<form action="{{ url('hrd/setup/manajemenpot/simpanpotonggaji/'.$profil_karyawan->id) }}" method="post" onsubmit="return konfirm()">
{{ csrf_field() }}
<div class="modal-body">
    <div class="iq-card-body row">
        <div class="col-sm-6">
            <div class="mt-2">
                <h6>NIK:</h6>
                <p>{{$profil_karyawan->nik}}</p>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mt-2">
                <h6>Nama Karyawan:</h6>
                <p>{{$profil_karyawan->nm_lengkap}}</p>
            </div>
        </div>
    </div>
    <hr>
    <div class="iq-card-body">
        @foreach ($list_item_potongan as $key => $item)
            <div class="form-group row">
                <label class="col-sm-6">{{ $item->nama_potongan}}</label>
                <div class="col-sm-6">
                    <input type="hidden" name="id_potongan[]" id="id_potongan" value="{{ $item->id }}">
                    <input type="text" class="form-control angka" name="inp_nominal[]" id="inp_nominal" value="0" style="text-align: right; background: white; border: 1px solid black; font-size:large" required>
                </div>
            </div>
        @endforeach
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save changes</button>
</div>
</form>
<script type="text/javascript">
    $(document).ready(function()
    {
        $(".angka").number(true, 0);
    });
    function konfirm()
    {
        var psn = confirm("Yakin akan menyimpan pengaturan potongan gaji karyawan ?");
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
</script>