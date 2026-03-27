<div class="iq-card-header d-flex justify-content-between">
    <div class="iq-header-title">
        <h4 class="card-title">Edit Master Jenis Cuti/Izin</h4>
    </div>
</div>
<div class="iq-card-body">
    <form action="{{ url('hrd/masterdata/jeniscutiizin/update/'.$res->id) }}" method="post" onsubmit="return konfirm()">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
        <div class="row align-items-center">
            <div class="form-group col-sm-12">
                <label for="pil_jenis">Jenis Cuti/Izin :</label>
                <select class="select2 form-control mb-3" id="pil_jenis" name="pil_jenis" required>
                    @php $arr_ci = array("1"=>"Cuti", "2"=>"Izin"); @endphp
                    @foreach($arr_ci as $key => $value)
                        @if($key==$res->jenis_ci)
                        <option value="{{ $key }}" selected>{{ $value }}</option>
                        @else
                        <option value="{{ $key }}">{{ $value }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-12">
                <label for="inp_nama">Nama Jenis Cuti/Izin :</label>
                <input type="text" class="form-control" id="inp_nama" name="inp_nama" maxlength="100" value="{{ $res->nm_jenis_ci }}" required>
            </div>
            <div class="form-group col-sm-12">
                <label for="inp_nama">Lama Cuti (* Diisi jika pilihan Jenis adalah Cuti) :</label>
                <input type="text" class="form-control angka" id="inp_lama" name="inp_lama" value="{{ $res->lama_cuti }}" style="text-align: right;" maxlength="3" required>
                <span>* Masukkan Jumlah Hari</span>
            </div>
            <div class="form-group col-sm-12">
                <label for="inp_nama">Deskripsi :</label>
                <textarea class="form-control" name="inp_deskripsi">{{ $res->keterangan }}</textarea>
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