<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Persetujuan Pengajuan Perubahan Status Karyawan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<form action="{{ url('hrd/persetujuan/storeApproval') }}" method="post" onsubmit="return konfirm()">
{{ csrf_field() }}
<input type="hidden" name="id_pengajuan" value="{{ $data_approval->id }}">
<input type="hidden" name="key_approval" value="{{ $data_approval->approval_key }}">
<input type="hidden" name="level_approval" value="{{ $data_approval->approval_level }}">
<input type="hidden" name="date_approval" value="{{ $data_approval->approval_date }}">
<input type="hidden" name="group_approval" value="{{ $data_approval->approval_group }}">
<input type="hidden" name="status_approval" value="{{ $profil->status_pengajuan }}">
<div class="modal-body">
    <div class="iq-card iq-card-block iq-card-stretch">
        <div class="iq-card-body">
            <div class="row">
                <div class="col-lg-6">
                    <table class="table" style="width:100%">
                        <tr>
                            <td style="width: 10%">
                                @if(!empty($profil->get_profil->photo))
                                <img src="{{ url(Storage::url('hrd/photo/'.$profil->get_profil->photo)) }}"
                                    class="rounded-circle" alt="avatar" style="width: 80px; height: auto;">
                                @else
                                <a href="{{ asset('assets/images/user/1.jpg') }}" data-fancybox data-caption="avatar">
                                <img src="{{ asset('assets/images/user/1.jpg') }}"
                                    class="rounded-circle" alt="avatar" style="width: 80px; height: auto;"></a>
                                @endif
                            </td>
                            <td style="width: 40%">
                                <h4 class="mb-0">{{ $profil->get_profil->nm_lengkap }}</h4>
                                <h4 class="mb-0">{{ $profil->get_profil->nik }}</h4>
                                <h6 class="mb-0">{{ $profil->get_profil->get_jabatan->nm_jabatan }} | {{ $profil->get_profil->get_departemen->nm_dept }}</h6>
                            </td>
                        </tr>
                    </table>
                    <ul class="list-group" style="margin-bottom: 15px">
                        <li class="list-group-item active">Status Karyawan Saat Ini</li>
                    </ul>
                    <div class="row">
                        <label class="col-sm-4">Status Karyawan</label>
                        <div class="col-sm-8">
                        <label id="sts_lama"><b>: {{ $profil->get_profil->get_status_karyawan($profil->get_profil->id_status_karyawan) }}</b></label>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-4">Tanggal Efektif</label>
                        <div class="col-sm-8">
                        <label id="tgl_eff_lama"><b>: {{ (empty($profil->get_profil->tgl_sts_efektif_mulai)) ? "" : date_format(date_create($profil->get_profil->tgl_sts_efektif_mulai), 'd-m-Y') }}</b></label>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-4">Tanggal Berakhir</label>
                        <div class="col-sm-8">
                        <label id="tgl_akh_lama"><b>: {{ (empty($profil->get_profil->tgl_sts_efektif_akhir)) ? "" : date_format(date_create($profil->get_profil->tgl_sts_efektif_akhir), 'd-m-Y') }}</b></label>
                        </div>
                    </div>
                    <ul class="list-group" style="margin-bottom: 15px">
                        <li class="list-group-item active">Data Pengajuan</li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item disabled" aria-disabled="true">Tanggal Pengajuan : {{ date_format(date_create($profil->tgl_pengajuan), 'd-m-Y') }}</li>
                        <li class="list-group-item">Alasan Pengajuan : {{ $profil->alasan_pengajuan }}</li>
                        <li class="list-group-item">Status Yang Diusulkan : {{ $profil->get_status_karyawan($profil->id_sts_baru) }}</li>
                        <li class="list-group-item">Diajukan Oleh : {{ $profil->get_diajukan_oleh->karyawan->nm_lengkap }}<br>
                            {{ $profil->get_diajukan_oleh->karyawan->get_jabatan->nm_jabatan }} - {{ $profil->get_diajukan_oleh->karyawan->get_departemen->nm_dept }}
                        </li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                        <h4 class="card-title">Lampiran Hasil Evaluasi</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <table class="table" style="width: 100%;">
                            <tr>
                                <td>
                                    <a href="{{ url('hrd/perubahanstatus/download/hasil_evaluasi/'.$profil->id) }}" target="_new" class="btn btn-danger btn-block"><i class="ri-download-line"></i> File Lampiran Hasil Evaluasi Kerja</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="iq-card iq-card-block iq-card-stretch">
                        <div class="iq-card-body">
                            <ul class="list-group" style="margin-bottom: 15px">
                                <li class="list-group-item active">Hirarki Persetujuan</li>
                            </ul>
                            <div class="row align-items-center">
                                <table class="table" style="width: 100%; font-size: 10px">
                                    <thead>
                                    <tr>
                                        <th rowspan="2" style="width: 5%">Level</th>
                                        <th rowspan="2">Pejabat</th>
                                        <th colspan="3" class="text-center">Persetujuan</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Keterangan</th>
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
                                            <td>
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
                            <ul class="list-group" style="margin-bottom: 15px">
                                <li class="list-group-item active">Form Persetujuan</li>
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
