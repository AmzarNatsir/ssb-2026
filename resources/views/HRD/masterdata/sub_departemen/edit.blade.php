<div class="iq-card-header d-flex justify-content-between">
    <div class="iq-header-title">
        <h4 class="card-title">Edit Master Sub Departemen</h4>
    </div>
</div>
<div class="iq-card-body">
    <form action="{{ url('hrd/masterdata/subdepartemen/update/'.$res->id) }}" method="post" onsubmit="return konfirm()">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
        <div class=" row align-items-center">
            <div class="form-group col-sm-12">
                <label for="inp_nama">Divisi :</label>
                <select class="select2 form-control mb-3" id="pil_divisi" name="pil_divisi" required>
                    @foreach($list_divisi as $divisi)
                        @if($divisi->id==$res->id_divisi)
                        <option value="{{ $divisi->id }}" selected>{{ $divisi->nm_divisi }}</option>
                        @else
                        <option value="{{ $divisi->id }}">{{ $divisi->nm_divisi }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class=" row align-items-center">
            <div class="form-group col-sm-12">
                <label for="pil_departemen">Departemen :</label>
                <select class="select2 form-control mb-3" id="pil_departemen" name="pil_departemen" required>
                    @foreach($list_departemen as $dept)
                        @if($dept->id==$res->id_dept)
                            <option value="{{ $dept->id }}" selected>{{ $dept->nm_dept }}</option>
                        @else
                            <option value="{{ $dept->id }}">{{ $dept->nm_dept }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class=" row align-items-center">
            <div class="form-group col-sm-12">
                <label for="inp_nama">Nama Sub Departemen :</label>
                <input type="text" class="form-control" id="inp_nama" name="inp_nama" maxlength="200" value="{{ $res->nm_subdept }}" required>
            </div>
            
        </div>
        <hr>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<script>
    $(document).ready(function()
    {
        $(".select2").select2({
            width: '100%',
            placeholder : 'Pilih Departemen'
        });
        $("#pil_divisi").on("change", function()
        {
            var id_pil = $("#pil_divisi").val();
            if(id_pil==0)
            {
                return false;
            } else {
                $("#pil_departemen").load("{{ url('hrd/masterdata/subdepartemen/loaddepartement') }}/"+id_pil);
            }
        });
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