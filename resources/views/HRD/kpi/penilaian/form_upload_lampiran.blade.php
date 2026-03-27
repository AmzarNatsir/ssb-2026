<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Upload Data Pendukung KPI</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<form id="uploadForm" method="post" enctype="multipart/form-data" class="needs-validation">
@csrf
<input type="hidden" name="id_kpi" value="{{ $profil->id }}">
<input type="hidden" name="id_head" value="{{ $profil->id_head }}">
<input type="hidden" name="periode_bulan" value="{{ $profil->getKPIPeriodik->bulan }}">
<input type="hidden" name="periode_tahun" value="{{ $profil->getKPIPeriodik->tahun }}">
<input type="hidden" name="id_dept" value="{{ $profil->getKPIPeriodik->id_departemen }}">
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="iq-card">
                <div class="iq-card-body">
                    <table class="table" style="width: 100%;" cellpadding="3">
                        <tr>
                            <td class="text-center"><b>{{ $profil->getKPIMaster->nama_kpi }}</b></td>
                        </tr>
                    </table>
                    <div class="form-group">
                        <label for="inp_keterangan">Keterangan File</label>
                        <input type="text" class="form-control" name="inp_keterangan" id="inp_keterangan" maxlength="100" required>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="inp_nama">Upload FIle</label>
                        <input type="file" name="inp_file" id="inp_file" class="form-control" onchange="loadFile(this)" required>
                        <span class="badge badge-danger mt-2">* .pdf/.docx/.doc/.xlsx</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary btn-save">Submit</button>
</div>
</form>
