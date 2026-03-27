<div class="iq-card-header d-flex justify-content-between">
    <div class="iq-header-title">
        <h4 class="card-title">Edit Master Pelatihan</h4>
    </div>
</div>
<div class="iq-card-body">
    <form action="{{ url('hrd/masterdata/pelatihan/update/'.$res->id) }}" method="post" onsubmit="return konfirm()">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
        <div class=" row align-items-center">
            <div class="form-group col-sm-12">
                <label for="inp_nama">Nama Pelatihan :</label>
                <textarea class="form-control" name="inp_nama" id="inp_nama" required>{{ $res->nama_pelatihan}}</textarea>
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