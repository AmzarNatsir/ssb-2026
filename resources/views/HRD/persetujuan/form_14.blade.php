<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Persetujuan Pengajuan Perubahan Masa Cuti</h5>
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
        <div class="col-sm-12 col-lg-5">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                       <h4 class="card-title">Profil Karyawan</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    <table class="table" style="width:100%">
                        <tbody>
                            <tr>
                                <td style="width: 10%">
                                    @if(!empty($profil->get_cuti_origin->profil_karyawan->photo))
                                    <img src="{{ url(Storage::url('hrd/photo/'.$profil->get_cuti_origin->profil_karyawan->photo)) }}"
                                        class="rounded-circle" alt="avatar"  style="width: 80px; height: auto;">
                                    @else
                                    <a href="{{ asset('assets/images/user/1.jpg') }}" data-fancybox data-caption="avatar">
                                    <img src="{{ asset('assets/images/user/1.jpg') }}"
                                        class="rounded-circle" alt="avatar" style="width: 80px; height: auto;"></a>
                                    @endif
                                </td>
                                <td>
                                    <h4 class="mb-0">{{ $profil->get_cuti_origin->profil_karyawan->nik }}</h4>
                                    <h4 class="mb-0">{{ $profil->get_cuti_origin->profil_karyawan->nm_lengkap }}</h4>
                                    <h6 class="mb-0">{{ $profil->get_cuti_origin->profil_karyawan->get_jabatan->nm_jabatan }} | {{ $profil->get_cuti_origin->profil_karyawan->get_departemen->nm_dept }}</h6>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                       <h4 class="card-title">Data Pengajuan Perubahan</h4>
                    </div>
                </div>
                <ul class="list-group">
                    <li class="list-group-item disabled" aria-disabled="true">Tanggal Pengajuan : <b>{{ date('d-m-Y', strtotime($profil->created_at)) }}</b></li>
                    <li class="list-group-item">Alasan Pengajuan : <b>{{ $profil->alasan_perubahan }}</b></li>
                    <li class="list-group-item">Perubahan Masa Cuti : <b>{{ date_format(date_create($profil->tgl_awal_origin), 'd-m-Y') }} s/d {{ date_format(date_create($profil->tgl_akhir_edit), 'd-m-Y') }}</b></li>
                    <li class="list-group-item">Jumlah Hari : <b>{{ $profil->jumlah_hari_edit }} hari</b></li>
                </ul>
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                       <h4 class="card-title">Data Pengajuan Awal</h4>
                    </div>
                </div>
                <ul class="list-group">
                    <li class="list-group-item">Rencana Cuti : <b>{{ date_format(date_create($profil->tgl_awal_origin), 'd-m-Y') }} s/d {{ date_format(date_create($profil->tgl_akhir_origin), 'd-m-Y') }}</b></li>
                    <li class="list-group-item">Jumlah Hari : <b>{{ $profil->jumlah_hari_origin }} hari</b></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-12 col-lg-7">
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
                            <select class="form-control" id="pil_persetujuan" name="pil_persetujuan" style="width: 100%;" required>
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
        $(".select2").select2({
            dropdownParent: $('#modalFormPersetujuan')
        });
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
