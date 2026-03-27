<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Detai KPI</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    {{-- <div class="row"> --}}
        <div class="iq-card">
            <div class="iq-card-body">
                <table class="table" style="width: 100%;">
                    <tr>
                        <td>Nama KPI: <b>{{ $detail->nama_kpi }}</b></td>
                    </tr>
                    <tr>
                        <td>Formula Hitung</td>
                    </tr>
                    <tr>
                        <td><b>{{ $detail->formula_hitung }}</b></td>
                    </tr>
                    <tr>
                        <td>Data Pendukung</td>
                    </tr>
                    <tr>
                        <td><b>{{ $detail->data_pendukung }}</b></td>
                    </tr>
                </table>
            </div>
        </div>
    {{-- </div> --}}
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
