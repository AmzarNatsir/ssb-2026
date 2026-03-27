<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Pengajuan Perubahan Status</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<form action="{{ url('hrd/perubahanstatus/store_proses') }}" method="post" onsubmit="return konfirm()">
{{ csrf_field() }}
<input type="hidden" name="id_pengajuan" value="{{ $profil->id }}">
<input type="hidden" name="id_karyawan" value="{{ $profil->id_karyawan }}">
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
              <li class="list-group-item">Status Karyawan : {{ $profil->get_status_karyawan($profil->id_sts_lama) }}</li>
              <li class="list-group-item">Tanggal Efektif : {{ (empty($profil->tgl_eff_lama)) ? "" : date_format(date_create($profil->tgl_eff_lama), 'd-m-Y') }}</li>
              <li class="list-group-item">Tanggal Berakhir : {{ (empty($profil->tgl_akh_lama)) ? "" : date_format(date_create($profil->tgl_akh_lama), 'd-m-Y') }}</li>
           </ul>
        </div>
        <div class="iq-card-header d-flex justify-content-between">
            <div class="iq-header-title">
               <h4 class="card-title">Data Pengajuan</h4>
            </div>
        </div>
        <div class="iq-card-body">
            <ul class="list-group">
                <li class="list-group-item disabled" aria-disabled="true">Tanggal Pengajuan : {{ date_format(date_create($profil->tgl_pengajuan), 'd-m-Y') }}</li>
                <li class="list-group-item">Alasan Pengajuan : {{ $profil->alasan_pengajuan }}</li>
                <li class="list-group-item">Status Yang Diusulkan : {{ $profil->get_status_karyawan($profil->id_sts_baru) }}</li>
             </ul>
        </div>
        <div class="iq-card-header d-flex justify-content-between">
            <div class="iq-header-title">
            <h4 class="card-title">Lampiran Hasil Evaluasi</h4>
            </div>
        </div>
        <div class="iq-card-body">
            <p>Hasil Evaluasi</p>
        </div>
        <div class="iq-card-header d-flex justify-content-between">
            <div class="iq-header-title">
               <h4 class="card-title">Hirarki Persetujuan</h4>
            </div>
        </div>
        <div class="iq-card-body">
            <table class="table" style="width: 100%; font-size: 12px">
                <thead>
                <tr>
                    <th rowspan="2" style="width: 5%">Level</th>
                    <th rowspan="2">Pejabat</th>
                    <th colspan="3" class="text-center">Persetujuan</th>
                </tr>
                <tr>
                    <th class="text-left">Tanggal</th>
                    <th class="text-left">Keterangan</th>
                    <th class="text-center">Status</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($hirarki_persetujuan as $list)
                    <tr>
                        <td class="text-center">
                            @if($list->approval_active==1)
                            <h4><span class="badge badge-pill badge-success">{{ $list->approval_level }}</span></h4>
                            @else
                            <h4><span class="badge badge-pill badge-danger">{{ $list->approval_level }}</span></h4>
                            @endif
                        </td>
                        <td>{{ $list->get_profil_employee->nm_lengkap }}<br>
                            {{ $list->get_profil_employee->get_jabatan->nm_jabatan }}</td>
                        <td>
                            {{ (empty($list->approval_date)) ? "" : date('d-m-Y', strtotime($list->approval_date))  }}
                        </td>
                        <td>{{ $list->approval_remark }}</td>
                        <td class="text-center">
                            @if($list->approval_status==1)
                            <h4><span class="badge badge-pill badge-success">Approved</span></h4>
                            @elseif($list->approval_status==2)
                            <h4><span class="badge badge-pill badge-danger">Rejected</span></h4>
                            @else

                            @endif
                            </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="iq-card iq-card-block iq-card-stretch">
        <div class="iq-card-body">
            <ul class="list-group" style="margin-bottom: 15px">
                <li class="list-group-item active">Proses Registrasi</li>
            </ul>
            <div class="form-group row">
                <label class="col-sm-4">Nomor Surat</label>
                <div class="col-sm-8">
                    <input type="text" name="inp_nomor_surat" id="inp_nomor_surat" maxlength="50" class="form-control" value="{{ $no_surat }}" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Tanggal Surat</label>
                <div class="col-sm-8">
                    <input type="text" name="inp_tgl_surat" id="inp_tgl_surat" class="form-control" value="<?= date('d/m/Y') ?>"  readonly>
                </div>
            </div>
            <ul class="list-group" style="margin-bottom: 15px">
                <li class="list-group-item active">Perubahan Status Karyawan</li>
            </ul>
            <div class="form-group row">
                <label class="col-sm-4">Status Karyawan Baru</label>
                <div class="col-sm-8">
                    <input type="hidden" class="form-control" name="pil_sts_baru" id="pil_sts_baru" value="{{ $profil->id_sts_baru }}" >
                    <input type="text" class="form-control" value="{{ $profil->get_status_karyawan($profil->id_sts_baru) }}" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Tanggal Efektif</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-calendar"></i></span>
                        </div>
                        <input type="text" name="tgl_eff_mulai_baru" id="tgl_eff_mulai_baru" class="form-control datepicker" required>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Tanggal Berakhir</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-calendar"></i></span>
                        </div>
                        <input type="text" name="tgl_eff_akhir_baru" id="tgl_eff_akhir_baru" class="form-control datepicker" {{ ($profil->id_sts_baru==3) ? "disabled" : "required" }}>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary" id="tbl_simpan">Save changes</button>
</div>
</form>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        // document.getElementById('inp_tgl_surat').value = moment().format('YYYY-MM-DD');
        // document.getElementById('tgl_eff_mulai_baru').value = moment().format('YYYY-DD-MM');
        // document.getElementById('tgl_eff_akhir_baru').value = moment().format('YYYY-MM-DD');
        $(".datepicker").datepicker({
            format: 'dd/mm/yyyy',
            orientation : "button right",
            todayHighlight: true
        });
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
