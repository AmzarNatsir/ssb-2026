<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Pengajuan Perubahan Status</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<form action="{{ url('hrd/perubahanstatus/store_pengajuan') }}" method="post" id="myForm" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="hidden" name="pil_karyawan" value="{{ $profil->id }}">
<div class="modal-body">
    <div class="iq-card iq-card-block iq-card-stretch">
        <div class="iq-card-body">
            <div class=" row align-items-center">
                <table class="table" style="width:100%">
                    <tr>
                        <td style="width: 10%">
                            @if(!empty($profil->photo))
                            <img src="{{ url(Storage::url('hrd/photo/'.$profil->photo)) }}"
                                class="rounded-circle" alt="avatar" style="width: 80px; height: auto;">
                            @else
                            <a href="{{ asset('assets/images/user/1.jpg') }}" data-fancybox data-caption="avatar">
                            <img src="{{ asset('assets/images/user/1.jpg') }}"
                                class="rounded-circle" alt="avatar" style="width: 80px; height: auto;"></a>
                            @endif
                        </td>
                        <td style="width: 40%">
                            <h4 class="mb-0">{{ $profil->nm_lengkap }}</h4>
                            <h4 class="mb-0">{{ $profil->nik }}</h4>
                            <h6 class="mb-0">{{ $profil->get_jabatan->nm_jabatan }} | {{ $profil->get_departemen->nm_dept }}</h6>
                        </td>
                    </tr>
                </table>
            </div>
            <ul class="list-group" style="margin-bottom: 15px">
                <li class="list-group-item active">Status Karyawan Saat Ini</li>
            </ul>
            <div class="form-group row">
                <label class="col-sm-4">Status Karyawan</label>
                <div class="col-sm-8">
                <input type="hidden" name="inp_id_status_lama" id="inp_id_status_lama" value="{{ $profil->id_status_karyawan }}">
                <label id="sts_lama"><b>: {{ $profil->get_status_karyawan($profil->id_status_karyawan) }}</b></label>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Tanggal Efektif</label>
                <div class="col-sm-8">
                <input type="hidden" name="inp_tgl_eff_lama" id="inp_tgl_eff_lama" value="{{ (empty($profil->tgl_sts_efektif_mulai)) ? "" : $profil->tgl_sts_efektif_mulai }}">
                <label id="tgl_eff_lama"><b>: {{ (empty($profil->tgl_sts_efektif_mulai)) ? "" : date_format(date_create($profil->tgl_sts_efektif_mulai), 'd-m-Y') }}</b></label>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Tanggal Berakhir</label>
                <div class="col-sm-8">
                <input type="hidden" name="inp_tgl_akh_lama" id="inp_tgl_akh_lama" value="{{ (empty($profil->tgl_sts_efektif_akhir)) ? "" : $profil->tgl_sts_efektif_akhir }}">
                <label id="tgl_akh_lama"><b>: {{ (empty($profil->tgl_sts_efektif_akhir)) ? "" : date_format(date_create($profil->tgl_sts_efektif_akhir), 'd-m-Y') }}</b></label>
                </div>
            </div>
            <hr>
            <ul class="list-group" style="margin-bottom: 15px">
                <li class="list-group-item active">Lampirkan Hasil Evaluasi Karyawan</li>
            </ul>
            <div class="form-group">
                <label for="inp_file_jobdesc">Upload File Hasil Evaluasi (* pdf file only) :</label>
                <div class="custom-file">
                    <input type="file" class="form-control" id="inp_file_evaluasi" name="inp_file_evaluasi" onchange="loadFile(this)" required>
                    <input type="hidden" name="tmp_file" required>
                </div>
            </div>
            <hr>
            <ul class="list-group" style="margin-bottom: 15px">
                <li class="list-group-item active">Perubahan Yang Diusulkan</li>
            </ul>
            <div class="form-group row">
                <label class="col-sm-4">Pilih Status Karyawan</label>
                <div class="col-sm-8">
                    <select class="form-control" name="pil_sts_baru" id="pil_sts_baru" required>
                        @foreach($list_status as $key => $value)
                            @if($key==1 || $key==2 || $key==3 || $key==7)
                            <option value="{{ $key }}">{{ $value }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class=" row align-items-center">
                <div class="form-group col-sm-12">
                    <label>Alasan Pengajuan</label>
                    <textarea class="form-control" name="inp_alasan" id="inp_alasan" required></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Submit</button>
</div>
</form>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".select2").select2();
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
    var _validFileExtensions = [".pdf"];
    var loadFile = function(oInput) {
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            var sSizeFile = oInput.files[0].size;
            //alert(sSizeFile);
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions.length; j++) {
                    var sCurExtension = _validFileExtensions[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    }
                }

                if (!blnValid) {
                    Swal.fire({
                        title: 'Warning',
                        text: "Maaf, " + sFileName + " tidak valid, jenis file yang boleh di upload adalah : " + _validFileExtensions.join(", "),
                        icon: 'warning'
                    }).then(function() {
                        oInput.value = "";
                        return false
                    });
                }
            }

        }
        return true;

    };
</script>
