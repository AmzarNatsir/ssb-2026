<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Persetujuan Perjalanan Dinas - Atasan Langsung</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<form action="{{ url('hrd/perjalanandinas/persetujuan/persetujuanStore_al') }}" method="post" onsubmit="return konfirm()">
{{ csrf_field() }}
<input type="hidden" name="id_pengajuan" value="{{ $profil->id }}">
<div class="modal-body">
    <div class="iq-card">
        <div class="iq-card-header d-flex justify-content-between">
           <div class="iq-header-title">
              <h4 class="card-title">Profil Karyawan</h4>
           </div>
        </div>
        <div class="iq-card-body">
           <ul class="list-group">
              <li class="list-group-item disabled" aria-disabled="true">NIK : {{ $profil->get_profil->nik }}</li>
              <li class="list-group-item">Nama Karyawan : {{ $profil->get_profil->nm_lengkap }}</li>
              <li class="list-group-item">Jabatan : {{ $profil->get_profil->get_jabatan->nm_jabatan }}</li>
              <li class="list-group-item">Jabatan : {{ $profil->get_profil->get_departemen->nm_dept }}</li>
           </ul>
        </div>
        <div class="iq-card-header d-flex justify-content-between">
            <div class="iq-header-title">
               <h4 class="card-title">Data Pengajuan</h4>
            </div>
        </div>
        <div class="iq-card-body">
            <ul class="list-group">
                <li class="list-group-item disabled" aria-disabled="true">Tanggal Pengajuan : {{ date_format(date_create($profil->tgl_perdis), 'd-m-Y') }}</li>
                <li class="list-group-item">Alasan Pengajuan : {{ $profil->maksud_tujuan }}</li>
                <li class="list-group-item">Tanggal Berangkat : {{ date('d-m-Y', strtotime($profil->tgl_berangkat)) }} s/d {{ date('d-m-Y', strtotime($profil->tgl_kembali)) }}</li>
                <li class="list-group-item">Diajukan Oleh : {{ $profil->get_diajukan_oleh->nm_lengkap }} - {{ $profil->get_diajukan_oleh->get_jabatan->nm_jabatan }}</li>
             </ul>
        </div>
    </div>
    <div class="iq-card iq-card-block iq-card-stretch">
        <div class="iq-card-body">
            <ul class="list-group" style="margin-bottom: 15px">
                <li class="list-group-item active">Persetujuan</li>
            </ul>
            <div class=" row align-items-center">
                <label class="col-sm-4">Status Persetujuan</label>
                <div class="col-sm-8">
                    <select class="form-control select2" id="pil_persetujuan" name="pil_persetujuan" style="width: 100%;" required>
                        <option value="1">Setuju</option>
                        <option value="2">Tolak</option>
                    </select>
                </div>
            </div>
            <hr>
            <div class=" row align-items-center">
                <div class="form-group col-sm-12">
                    <label>Deskripsi Persetujuan</label>
                    <textarea class="form-control" name="inp_keterangan" id="inp_keterangan" required></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save changes</button>
</div>
</form>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
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
