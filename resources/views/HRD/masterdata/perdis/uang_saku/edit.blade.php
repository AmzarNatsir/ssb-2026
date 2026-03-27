<div class="iq-card-header d-flex justify-content-between">
    <div class="iq-header-title">
        <h4 class="card-title">Input Master Perjalanan Dinas - Uang Saku</h4>
    </div>
</div>
<div class="iq-card-body">
    <form action="{{ url('hrd/masterdata/perdis/uangsaku/update/'.$res->id) }}" method="post" onsubmit="return konfirm()">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
        <div class=" row align-items-center">
            <div class="form-group col-sm-12">
                <label for="inp_nama">Nominal (Rp.) :</label>
                <input type="text" class="form-control angka" id="inp_nominal" name="inp_nominal" style="text-align: right" value="{{ $res->nominal }}" required>
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
    $(document).ready(function()
    {
        $(".angka").number(true, 0);
    });
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