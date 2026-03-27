<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Persetujuan Pengajuan Lembur</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<form action="{{ url('hrd/persetujuan/storeApproval') }}" method="post" id="myForm">
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
                    <div class=" row align-items-center">
                        <div class="form-group col-sm-6">
                            <label for="tanggal">Tanggal</label>
                            <input type="text" name="tanggal" id="tanggal" class="form-control" value="{{ date('d-m-Y', strtotime($profil->tgl_pengajuan)) }}" disabled>
                        </div>
                    </div>
                    <div class=" row align-items-center">
                        <div class="form-group col-sm-4">
                            <label for="jam_mulai">Mulai Jam</label>
                            <input type="text" name="jam_mulai" id="jam_mulai" class="form-control jamClass" placeholder="00:00" style="text-align: center" value="{{ date('H:s', strtotime($profil->jam_mulai)) }}" disabled>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="jam_selesai">Selesai Jam</label>
                            <input type="text" name="jam_selesai" id="jam_selesai" class="form-control jamClass" placeholder="00:00" onblur="getTotal(this)" style="text-align: center" value="{{ date('H:s', strtotime($profil->jam_selesai)) }}" disabled>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="inp_total">Total Jam</label>
                            <input type="text" name="inp_total" id="inp_total" class="form-control" value="{{ $profil->total_jam }} Jam" style="text-align: center" disabled>
                        </div>
                    </div>
                    <div class=" row align-items-center">
                        <div class="form-group col-sm-12">
                            <label for="keterangan">Deskripsi Pekerjaan</label>
                            <textarea class="form-control" name="keterangan" id="keterangan" disabled>{{ $profil->deskripsi_pekerjaan }}</textarea>
                        </div>
                    </div>
                    <div class=" row align-items-center">
                        <div class="form-group col-sm-12">
                            <label for="keterangan">Lampiran Surat Perintah Lembur</label>
                        </div>
                    </div>
                    <table class="table" style="width:100%">
                        <tbody>
                            <tr>
                                <td style="text-align: center">
                                    @if(!empty($profil->file_surat_perintah_lembur))
                                    <a href="{{ url(Storage::url('hrd/lembur/'.$profil->file_surat_perintah_lembur)) }}" data-fancybox data-caption="avatar">
                                    <img src="{{ url(Storage::url('hrd/lembur/'.$profil->file_surat_perintah_lembur)) }}"
                                       alt="avatar"  style="width: 150px; height: auto;"></a>
                                    @else
                                    <a href="{{ asset('assets/images/user/1.jpg') }}" data-fancybox data-caption="avatar">
                                    <img src="{{ asset('assets/images/user/1.jpg') }}"
                                        alt="avatar" style="width: 150px; height: auto;"></a>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
    document.querySelector('#myForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting

        Swal.fire({
            title: 'Are you sure?',
            text: "Submit this application!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user confirms, submit the form
                this.submit();
            }
        });
    });
</script>
