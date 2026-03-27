<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Persetujuan Pengajuan Mutasi</h5>
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
                       <li class="list-group-item disabled" aria-disabled="true">NIK : <b>{{ $profil->get_profil->nik }}</b></li>
                       <li class="list-group-item">Nama Karyawan : <b>{{ $profil->get_profil->nm_lengkap }}</b></li>
                       <li class="list-group-item">Status Karyawan : <b>{{ $profil->get_profil->get_status_karyawan($profil->get_profil->id_status_karyawan) }}</b></li>
                       <li class="list-group-item">Divisi : <b>{{ (empty($profil->get_profil->id_divisi)) ? "" : $profil->get_profil->get_divisi->nm_divisi }}</b></li>
                       <li class="list-group-item">Departemen : <b>{{ (empty($profil->get_profil->id_departemen)) ? "" : $profil->get_profil->get_departemen->nm_dept }}</b></li>
                       <li class="list-group-item">Jabatan : <b>{{ (empty($profil->get_profil->id_jabatan)) ? "" :  $profil->get_profil->get_jabatan->nm_jabatan }}</b></li>
                       <li class="list-group-item">Efektif Jabatan : <b>{{ $ket_efektif_jabatan }}</b></li>
                       <li class="list-group-item">Tanggal Bergabung : <b>{{ $ket_tgl_masuk }}</b></li>
                       <li class="list-group-item">Lama Bekerja : <b>{{ $ket_lama_kerja }}</b></li>
                    </ul>
                 </div>
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                       <h4 class="card-title">Data Pengajuan</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    <ul class="list-group">
                        <li class="list-group-item disabled" aria-disabled="true">Tanggal Pengajuan : <b>{{ date_format(date_create($profil->tgl_pengajuan), 'd-m-Y') }}</b></li>
                        <li class="list-group-item">Alasan Pengajuan : <b>{{ $profil->alasan_pengajuan }}</b></li>
                        <li class="list-group-item">Diusulkan : <b>@foreach($list_kategori as $key => $value)
                        @if($key==$profil->kategori)
                            {{ $value }}
                            @php break; @endphp
                        @endif
                        @endforeach</b></li>
                        <li class="list-group-item">Divisi : <b>{{ (empty($profil->id_divisi_br)) ? "" : $profil->get_divisi_baru->nm_divisi }}</b></li>
                       <li class="list-group-item">Departemen : <b>{{ (empty($profil->id_dept_br)) ? "" : $profil->get_dept_baru->nm_dept }}</b></li>
                       <li class="list-group-item">Sub Departemen : <b>{{ (empty($profil->id_subdept_br)) ? "" : $profil->get_subdept_baru->nm_subdept }}</b></li>
                       <li class="list-group-item">Jabatan : <b>{{ (empty($profil->id_jabt_br)) ? "" :  $profil->get_jabatan_baru->nm_jabatan }}</b></li>
                     </ul>
                </div>
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
