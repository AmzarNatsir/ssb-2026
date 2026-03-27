<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Edit KPI</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <form action="{{ url('hrd/setup/kpi_update/'.$res->id) }}" method="post" onsubmit="return konfirm()">
     {{ csrf_field() }}
    {{ method_field('PUT') }}
        <div class="form-group row">
            <label class="col-sm-4">Departemen</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="nm_dept" id="nm_dept" value="{{ $res->departemen->nm_dept }}">
                <input type="hidden" name="id_dept" id="id_dept" value="{{ $res->departemen->id }}">
            </div>
        </div>
        <div class="row align-items-center">
            <div class="form-group col-sm-12">
                <label for="inpKPI">Key Performance Indicator (KPI)</label>
                <textarea class="form-control" name="inpKPI" id="inpKPI" required>{{ $res->nama_kpi }}</textarea>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="form-group col-sm-4">
                <label for="inpBobot">Bobot (%)</label>
                <input type='text' class='form-control angka' name='inpBobot' id='inpBobot' value='{{ $res->bobot_kpi }}' style='text-align:right' maxlength="3" required>
            </div>
            <div class="form-group col-sm-4">
                <label for="pilTipe">Tipe</label>
                <select class="form-control select2" name="pilTipe" id="pilTipe" style="width: 100%;" required>
                    <option value="0">Pilihan</option>
                    @foreach($allTipe as $tipe)
                    <option value="{{ $tipe->id }}" {{ $res->id_tipe==$tipe->id ? 'selected' : '' }}>{{ $tipe->tipe_kpi }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="pilSatuan">Satuan</label>
                <select class="form-control select2" name="pilSatuan" id="pilSatuan" style="width: 100%;" required>
                    <option value="0">Pilihan</option>
                    @foreach($allSatuan as $satuan)
                    <option value="{{ $satuan->id }}" {{ $res->id_satuan==$satuan->id ? 'selected' : '' }}>{{ $satuan->satuan_kpi }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="form-group col-sm-12">
                <label for="inpFormula">Formula Hitung</label>
                <textarea class="form-control" name="inpFormula" id="inpFormula" required>{{ $res->formula_hitung }}</textarea>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="form-group col-sm-12">
                <label for="inpLaporan">Laporan / Data Pendukung</label>
                <textarea class="form-control" name="inpLaporan" id="inpLaporan" required>{{ $res->data_pendukung }}</textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function()
    {
        $(".select2").select2();
    });
    function konfirm()
    {
        var psn = confirm("Yakin data akan disimpan ?");
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
</script>
