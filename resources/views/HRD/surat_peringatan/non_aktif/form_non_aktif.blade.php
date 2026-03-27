<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Penonaktifan Surat Peringatan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<form action="{{ url('hrd/suratperingatan/storeNonAktifSP') }}" method="post" enctype="multipart/form-data" id="myForm">
{{ csrf_field() }}
<input type="hidden" name="id_sp" id="id_sp" value="{{ $profil->id }}">
<input type="hidden" name="id_karyawan" id="id_karyawan" value="{{ $profil->profil_karyawan->id }}">
<input type="hidden" name="id_karyawan_jabatan" id="id_karyawan_jabatan" value="{{ $profil->profil_karyawan->get_jabatan->id }}">
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
                    <table class="table" style="width:100%">
                        <tbody>
                            <tr>
                                <td style="width: 10%">
                                    @if(!empty($profil->profil_karyawan->photo))
                                    <img src="{{ url(Storage::url('hrd/photo/'.$profil->profil_karyawan->photo)) }}"
                                        class="rounded-circle" alt="avatar"  style="width: 80px; height: auto;">
                                    @else
                                    <a href="{{ asset('assets/images/user/1.jpg') }}" data-fancybox data-caption="avatar">
                                    <img src="{{ asset('assets/images/user/1.jpg') }}"
                                        class="rounded-circle" alt="avatar" style="width: 80px; height: auto;"></a>
                                    @endif
                                </td>
                                <td>
                                    <h4 class="mb-0">{{ $profil->profil_karyawan->nik }}</h4>
                                    <h4 class="mb-0">{{ $profil->profil_karyawan->nm_lengkap }}</h4>
                                    <h6 class="mb-0">{{ $profil->profil_karyawan->get_jabatan->nm_jabatan }} | {{ $profil->profil_karyawan->get_departemen->nm_dept }}</h6>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                       <h4 class="card-title">Status Surat Peringatan</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    <ul class="list-group">
                        <li class="list-group-item disabled" aria-disabled="true">Status : <b>
                            @if($profil->profil_karyawan->sp_active=="active")
                            <span class="badge badge-pill badge-success">{{ $profil->profil_karyawan->sp_active }}</span>
                            @else
                            <span class="badge badge-pill badge-dark">{{ $profil->profil_karyawan->sp_active }}</span>
                            @endif
                            </b>
                        </li>
                        <li class="list-group-item">Masa Berlaku : <b>{{ date('d-m-Y', strtotime($profil->profil_karyawan->sp_mulai_active)) }} s/d {{ date('d-m-Y', strtotime($profil->profil_karyawan->sp_akhir_active)) }}</b></li>
                        <li class="list-group-item">Uraian Pelanggaran : <b>{{ $profil->uraian_pelanggaran }}</b></li>
                     </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-6">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                       <h4 class="card-title">Form Penonaktif Surat Peringatan</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    <div class="form-group">
                        <label for="inp_alasan">Masukkan alasan surat peringatan di nonaktifkan</label>
                        <textarea class="form-control" name="inp_alasan" id="inp_alasan" required></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary btn-save">Submit</button>
</div>
</form>
<script type="text/javascript">
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

