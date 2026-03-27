<div class="iq-card">
    <div class="iq-card-header d-flex justify-content-between btn-outline-success active">
        <div class="iq-header-title">
            <h4 class="card-title" style="color: white">Pelatihan Internal</h4>
        </div>
    </div>
    <div class="card-body">
        <input type="hidden" name="inpKategori" id="inpKategori" value="Internal">
        <div class="form-group row">
            <label class="col-sm-4">Nama Pelatihan</label>
            <div class="col-sm-8">
                <select class="form-control select2" id="inpNamaPelatihan" name="inpNamaPelatihan" style="width: 100%;" required>
                    @foreach($all_pelatihan as $list)
                    <option value="{{ $list->id }}">{{ $list->nama_pelatihan }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4">Pelaksana Pelatihan</label>
            <div class="col-sm-8">
                <select class="form-control select2" name="inpNamaVendor" id="inpNamaVendor" style="width: 100%;" required>
                    @foreach($all_pelaksana as $lembaga)
                    <option value="{{ $lembaga->id }}">{{ $lembaga->nama_lembaga }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4">Tempat Pelaksanaan</label>
            <div class="col-sm-8">
                <input type="text" name="inpTempat" id="inpTempat" class="form-control" maxlength="200" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4">Tanggal Pelaksanaan</label>
            <div class="col-sm-8">
                <input type="text" class="form-control dateRangePicker" name="inpTglPelaksanaan" id="inpTglPelaksanaan" style="width: 250px" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4">Durasi<p><code>Contoh : 2 s/d 3 Jam atau jumlah hari</code></p></label>
            <div class="col-sm-8">
                <input type="text" name="inpDurasi" id="inpDurasi" class="form-control" maxlength="100" style="width: 250px" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4">Kompetensi yang dipelajari</label>
            <div class="col-sm-8">
                <textarea name="inpKompetensi" id="inpKompetensi" class="form-control"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4">Investasi/Biaya<p><code>Biaya Perorang</code></p></label>
            <div class="col-sm-8">
                <input type="text" name="inpBiaya" id="inpBiaya" class="form-control angka" value="0" style="text-align: right; width: 250px">
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {

    });
</script>
