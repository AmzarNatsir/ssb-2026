<div class="iq-card-header d-flex justify-content-between">
    <div class="iq-header-title">
        <h4 class="card-title">Edit Master Status Tanggungan Karyawan</h4>
    </div>
</div>
<div class="iq-card-body">
    <form action="{{ url('hrd/masterdata/statusTanggungan/update/'.$res->id) }}" method="post" onsubmit="return konfirm()">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
        <div class=" row align-items-center">
            <div class="form-group col-sm-12">
                <label for="inp_nama">Status Tanggungan :</label>
                <input type="text" class="form-control" id="inp_status" name="inp_status" maxlength="50" value="{{ $res->status_tanggungan }}" required>
            </div>
            <div class="form-group col-sm-12">
                <label for="inp_lama">Kode :</label>
                <input type="text" class="form-control" id="inp_kode" name="inp_kode" maxlength="10" value="{{ $res->kode }}">
            </div>
            <div class="form-group col-sm-6">
                <hr>
                <label>Status Data :</label>
            </div>
            <div class="form-group col-sm-6">
                <hr>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="rdo_status_1" name="rdo_status" class="custom-control-input" value="1" {{ ($res->status==1)? 'checked' : '' }}>
                    <label class="custom-control-label" for="rdo_status_1"> Aktif</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="rdo_status_2" name="rdo_status" class="custom-control-input" value="2" {{ ($res->status==2)? 'checked' : '' }}>
                    <label class="custom-control-label" for="rdo_status_2"> Tidak Aktif</label>
                </div>
            </div>
        </div>
        <hr>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<script>
    function konfirm()
    {
        var psn = confirm("Yakin akan menyimpan perubahan data ?");
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
</script>
