<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Pengaturan Data Resign</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<form action="{{ url('hrd/resign/pengaturanResignStore/'.$profil->getPengajuan->id) }}" method="post" id="myForm">
{{ csrf_field() }}
{{ method_field('PUT') }}
<input type="hidden" name="id_resign" id="id_resign" value="{{ $profil->getPengajuan->id }}">
<input type="hidden" name="id_exit_form" id="id_exit_form" value="{{ $profil->id }}">
<input type="hidden" name="id_karyawan" id="id_karyawan" value="{{ $profil->getPengajuan->getKaryawan->id }}">
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
                                    @if(!empty($profil->getPengajuan->getKaryawan->photo))
                                        <a href="{{ url(Storage::url('hrd/photo/'.$profil->getPengajuan->getKaryawan->photo)) }}" data-fancybox data-caption="avatar">
                                        <img src="{{ url(Storage::url('hrd/photo/'.$profil->getPengajuan->getKaryawan->photo)) }}"
                                        class="rounded-circle" alt="avatar"  style="width: 80px; height: auto;"></a>
                                    @else
                                        <a href="{{ asset('assets/images/user/1.jpg') }}" data-fancybox data-caption="avatar">
                                        <img src="{{ asset('assets/images/user/1.jpg') }}"
                                        class="rounded-circle" alt="avatar" style="width: 80px; height: auto;"></a>
                                    @endif
                                </td>
                                <td>
                                    <h4 class="mb-0">{{ $profil->getPengajuan->getKaryawan->nik }}</h4>
                                    <h4 class="mb-0">{{ $profil->getPengajuan->getKaryawan->nm_lengkap }}</h4>
                                    <h6 class="mb-0">{{ $profil->getPengajuan->getKaryawan->get_jabatan->nm_jabatan }} | {{ $profil->getPengajuan->getKaryawan->get_departemen->nm_dept }}</h6>
                                    <p style="font-size: 12px" class="mb-0 badge badge-success">Tanggal masuk : {{ (empty($profil->getPengajuan->getKaryawan->tgl_masuk)) ? "" : date('d-m-Y', strtotime($profil->getPengajuan->getKaryawan->tgl_masuk)) }}</p>
                                    <p style="font-size: 12px" class="mb-0 badge badge-danger">Lama bekerja : {{ (empty($profil->getPengajuan->getKaryawan->tgl_masuk)) ? "" : App\Helpers\Hrdhelper::get_lama_kerja_karyawan($profil->getPengajuan->getKaryawan->tgl_masuk) }}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-6">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                       <h4 class="card-title">Pengaturan Surat Keterangan Kerja (SKK) dan Tanggal Efektif Resign</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    <div class="row align-items-center">
                        <div class="form-group col-sm-5">
                            <label for="inp_tgl_skk">Tanggal SKK :</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-calendar"></i></span>
                                </div>
                                <input type="text" class="form-control datepicker" id="inp_tgl_skk" name="inp_tgl_skk" placeholder="dd/mm/yyyy" required>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row align-items-center">
                        <div class="form-group col-sm-12">
                            <label for="inp_nomor_skk">Karyawan dinyatakan keluar secara : </label>
                            <div class="form-group">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="checkTerhormat" name="caraKeluar" value="1" checked>
                                    <label class="custom-control-label" for="checkTerhormat">Terhormat</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="checkTidakTerhormat" name="caraKeluar" value="2">
                                    <label class="custom-control-label" for="checkTidakTerhormat">Tidak Terhormat</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row align-items-center">
                        <div class="form-group col-sm-6">
                            <label for="inp_tgl_resign">Tanggal Efektif Keluar :</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-calendar"></i></span>
                                </div>
                                <input type="text" class="form-control datepicker" id="inp_tgl_resign" name="inp_tgl_resign" placeholder="dd/mm/yyyy" required>
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

