<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Pengajuan Pelatihan Eksternal</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <form action="{{ url('hrd/pelatihan/simpanPengajuanEksternal') }}" method="post" onsubmit="return konfirm()">
    {{ csrf_field() }}
    <div class="iq-card">
        <div class="iq-card-body" style="width:100%; height:auto">
            <div class="row">
                <div class="col-md-6 border-right">
                    <input type="hidden" name="inpKategori" id="inpKategori" value="Eksternal">
                    <div class="form-group">
                        <label for="inpNamaPelatihan">Nama Pelatihan</label>
                        <input type="text" class="form-control" name="inpNamaPelatihan" id="inpNamaPelatihan" maxlength="200" required>
                    </div>
                    <div class="form-group">
                        <label for="inpNamaVendor">Nama Vendor/Pelaksana Pelatihan</label>
                        <input type="text" class="form-control" name="inpNamaVendor" id="inpNamaVendor" maxlength="200" required>
                    </div>
                    <div class="form-group">
                        <label for="inpKontakVendor">Kontak Vendor/Pelaksana Pelatihan</label>
                        <input type="text" class="form-control" name="inpKontakVendor" id="inpKontakVendor" maxlength="50" required>
                    </div>
                    <div class="form-group">
                        <label for="inpTempat">Tempat Pelaksanaan</label>
                        <input type="text" name="inpTempat" id="inpTempat" class="form-control" maxlength="200" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-6">Tanggal Pelaksanaan</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control dateRangePicker" name="inpTglPelaksanaan" id="inpTglPelaksanaan" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-6">Durasi</label>
                        <div class="col-sm-6">
                            <input type="text" name="inpDurasi" id="inpDurasi" class="form-control" maxlength="100" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-6">Investasi/Biaya<p><code>Biaya Perorang</code></p></label>
                        <div class="col-sm-6">
                            <input type="text" name="inpBiaya" id="inpBiaya" class="form-control angka" value="0" style="text-align: right;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inpKompetensi">Kompetensi yang dipelajari</label>
                        <textarea name="inpKompetensi" id="inpKompetensi" class="form-control"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup Form</button>
        <button type="submit" class="btn btn-primary" name="btn-submit" id="btn-submit">Simpan Pengajuan</button>
    </div>
    </form>
</div>
<script type="text/javascript">
    function konfirm()
    {
        var psn = confirm("Yakin akan menyimpan data ?")
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
</script>
