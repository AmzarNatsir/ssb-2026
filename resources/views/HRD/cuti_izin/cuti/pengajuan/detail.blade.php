<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Detail Pengajuan Cuti</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <div class="iq-card-body">
        <table class="table" style="width: 100%;">
        <tr>
            <td style="width: 28%;">Tanggal Penganjuan</td>
            <td style="width: 2%;">:</td>
            <td style="width: 70%;">{{ date_format(date_create($result->tgl_pengajuan), 'd-m-Y') }}</td>
        </tr>
        <tr>
            <td>Jenis Cuti</td>
            <td>:</td>
            <td>{{ $result->get_jenis_cuti->nm_jenis_ci }}</td>
        </tr>
        <tr>
            <td>Durasi</td>
            <td>:</td>
            <td>{{ date_format(date_create($result->tgl_awal), 'd-m-Y') }} s/d {{ date_format(date_create($result->tgl_akhir), 'd-m-Y') }} ({{ $result->jumlah_hari }} hari)</td>
        </tr>
        <tr>
            <td>Alasan Cuti</td>
            <td>:</td>
            <td>{{ $result->ket_cuti }}</td>
        </tr>
        <tr class="btn-primary">
            <td colspan="3">Persetujuan</td>
        </tr>
        @if(!empty($result->sts_appr_atasan))
        <tr>
            <td colspan="3"><b>Atasan Langsung</b></td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td>{{ date_format(date_create($result->tgl_appr_atasan), 'd-m-Y') }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>:</td>
            <td>{{ ($result->sts_appr_atasan==1) ? "Disetujui" : "Ditolak" }}</td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td>{{ $result->ket_appr_atasan }}</td>
        </tr>
        @endif
        @if(!empty($result->sts_persetujuan))
        <tr>
            <td colspan="3"><b>HRD</b></td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td>{{ date_format(date_create($result->tgl_persetujuan), 'd-m-Y') }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>:</td>
            <td>{{ ($result->sts_persetujuan==1) ? "Disetujui" : "Ditolak" }}</td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td>{{ $result->ket_persetujuan }}</td>
        </tr>
        @endif
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
</div>