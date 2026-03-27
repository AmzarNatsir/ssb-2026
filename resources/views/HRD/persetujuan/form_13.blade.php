<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Persetujuan Pengajuan Penerbitan Surat Peringatan</h5>
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

    <div class="row">
        <div class="col-sm-12 col-lg-6">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                       <h4 class="card-title">Profil Karyawan</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    <ul class="list-group">
                        <li class="list-group-item disabled" aria-disabled="true">NIK : {{ $profil->getKaryawan->nik }}</li>
                        <li class="list-group-item">Nama Karyawan : {{ $profil->getKaryawan->nm_lengkap }}</li>
                        <li class="list-group-item">Jabatan : {{ $profil->getKaryawan->get_jabatan->nm_jabatan }}</li>
                        <li class="list-group-item">Departemen : {{ $profil->getKaryawan->get_departemen->nm_dept }}</li>
                        <li class="list-group-item disabled" aria-disabled="true">Status Karyawan :  {{ $profil->getKaryawan->get_status_karyawan($profil->getKaryawan->id_status_karyawan) }}</li>
                        <li class="list-group-item">Bergabung Tanggal : {{ (!empty($profil->getKaryawan->tgl_masuk)) ? date_format(date_create($profil->getKaryawan->tgl_masuk), 'd-m-Y') : "Tanpa Keterangan" }}</li>
                        <li class="list-group-item">Lama Bekerja : {{ (!empty($profil->getKaryawan->tgl_masuk)) ? App\Helpers\Hrdhelper::get_lama_kerja_karyawan($profil->getKaryawan->tgl_masuk) : "Tanpa Keterangan" }}</li>
                    </ul>
                </div>
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                       <h4 class="card-title">Data Pengajuan</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                     <table class="table" style="width: 100%">
                        <tr>
                            <td style="width: 40%">Kategori Pinjaman</td>
                            <td><b>: {{ ($profil->kategori==1) ? "Panjar Gaji" : "Pinjaman Kesejahteraan Karyawan (PKK)" }}</b></td>
                        </tr>
                        <tr>
                            <td>Tanggal Pengajuan</td>
                            <td><b>: {{ date_format(date_create($profil->tgl_pengajuan), 'd-m-Y') }}</b></td>
                        </tr>
                        <tr>
                            <td>Alasan Pengajuan</td>
                            <td><b>: {{ $profil->alasan_pengajuan }}</b></td>
                        </tr>
                        <tr>
                            <td>Nominal Pengajuan</td>
                            <td><b>: {{ number_format($profil->nominal_apply, 0) }}</b></td>
                        </tr>
                        <tr>
                            <td>Tenor</td>
                            <td><b>: {{ $profil->tenor_apply }} Bulan</b></td>
                        </tr>
                        <tr>
                            <td>Angsuran</td>
                            <td><b>: {{ number_format($profil->angsuran, 0) }}</b></td>
                        </tr>
                     </table>
                </div>
                @if($profil->kategori==2)
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                       <h4 class="card-title">Lampiran Dokumen</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    <table class="table" style="width: 100%">
                    <tr>
                        <td style="width: 30%">Dokumen</td>
                        <td>Keterangan</td>
                    </tr>
                    @foreach ($profil->getDokumen as $dok)
                    <tr>
                        <td style="text-align: center"><a href="{{ url(Storage::url('hrd/dataku/dokumen_pinjaman_karyawan/'.$profil->getKaryawan->nik.'/'.$dok->file_dokumen)) }}" data-fancybox data-caption='{{ $dok->keterangan }}'><img class="rounded-circle img-fluid avatar-100" src="{{ url(Storage::url('hrd/dataku/dokumen_pinjaman_karyawan/'.$profil->getKaryawan->nik.'/'.$dok->file_dokumen)) }}" alt="profile"></a></td>
                        <td style="vertical-align: middle">{{ $dok->keterangan }}</td>
                    </tr>
                    @endforeach
                    </table>
                </div>
                @endif
            </div>
        </div>
        <div class="col-sm-12 col-lg-6">
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
