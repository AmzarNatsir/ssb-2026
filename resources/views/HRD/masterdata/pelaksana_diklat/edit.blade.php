<div class="iq-card-header d-flex justify-content-between">
    <div class="iq-header-title">
        <h4 class="card-title">Edit Master Lembaga Pelaksana Diklat</h4>
    </div>
</div>
<div class="iq-card-body">
    <form action="{{ url('hrd/masterdata/pelaksana_diklat/update/'.$res->id) }}" method="post" onsubmit="return konfirm()">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
        <div class=" row align-items-center">
            <div class="form-group col-sm-12">
                <label for="inp_nama">Nama Lembaga :</label>
                <input type="text" class="form-control" id="inp_nama" name="inp_nama" maxlength="150" value="{{ $res->nama_lembaga }}" required>
            </div>
        </div>
        <div class=" row align-items-center">
            <div class="form-group col-sm-12">
                <label for="inp_alamat">Alamat :</label>
                <input type="text" class="form-control" id="inp_alamat" name="inp_alamat" maxlength="150" value="{{ $res->alamat }}" required>
            </div>
        </div>
        <div class=" row align-items-center">
            <div class="form-group col-sm-12">
                <label for="inp_notel">No. Telepon :</label>
                <input type="text" class="form-control" id="inp_notel" name="inp_notel" maxlength="50" value="{{ $res->no_telepon }}" required>
            </div>
        </div>
        <div class=" row align-items-center">
            <div class="form-group col-sm-12">
                <label for="inp_email">Nama Email :</label>
                <input type="email" class="form-control" id="inp_email" name="inp_email" maxlength="150" value="{{ $res->nama_email }}" required>
            </div>
        </div>
        <div class=" row align-items-center">
            <div class="form-group col-sm-12">
                <label for="inp_kontak_person">Kontak Person :</label>
                <input type="text" class="form-control" id="inp_kontak_person" name="inp_kontak_person" maxlength="100" value="{{ $res->kontak_person }}" required>
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