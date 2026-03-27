<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Persetujuan Pengajuan Lembur</h5>
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
                      <h4 class="card-title">Pengajuan</h4>
                   </div>
                </div>
                <div class="iq-card-body">
                    <ul class="list-group">
                        <li class="list-group-item disabled" aria-disabled="true">Departemen/Bagian/Divisi : {{ $profil->get_departemen->nm_dept }}</li>
                        <li class="list-group-item">Posisi/Jabatan : {{ $profil->get_jabatan->nm_jabatan }}</li>
                        <li class="list-group-item">Jumlah Orang : {{ $profil->jumlah_orang }}</li>
                        <li class="list-group-item">Tanggal Dibutuhkan : {{ date('d-m-Y', strtotime($profil->tanggal_dibutuhkan)) }}</li>
                        <li class="list-group-item">Alasan Permintaan : {{ $profil->alasan_permintaan }}</li>
                        <li class="list-group-item">Alasan Permintaan : {{ $profil->alasan_permintaan }}</li>
                    </ul>
                     <div class="form-group row mt-2">
                        <label class="col-sm-12"><b><u>Kualifikasi yang dibutuhkan</u></b></label>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item disabled" aria-disabled="true">1. Jenis Kelamin :
                        @if ($profil->jenkel == 1)
                        Laki-Laki
                        @elseif($profil->jenkel == 2)
                        Perempuan
                        @else
                        Boleh Laki-Laki atau Perempuan
                        @endif</li>
                        <li class="list-group-item">2. Umur : {{ $profil->umur_min }} s/d {{ $profil->umur_maks }} Tahun</li>
                        <li class="list-group-item">3. Pendidikan : {{ $profil->pendidikan }}</li>
                        <li class="list-group-item">4. Keahlian Khusus : {{ $profil->keahlian_khusus }}</li>
                        <li class="list-group-item">5. Pengalaman : {{ $profil->pengalaman }}</li>
                        <li class="list-group-item">6. Kemampuan Bahasa :</li>
                        <li class="list-group-item">- Bahasa Inggris : {{ $profil->kemampuan_bahasa_ing }}</li>
                        <li class="list-group-item">- Bahasa Indonesia : {{ $profil->kemampuan_bahasa_ind }}</li>
                        <li class="list-group-item">- Lain-Lain : {{ $profil->kemampuan_bahasa_lain }}</li>
                        <li class="list-group-item">7. Kepribadian : {{ $profil->kepribadian }}</li>
                        <li class="list-group-item">8. Catatan : {{ $profil->catatan }}</li>
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
