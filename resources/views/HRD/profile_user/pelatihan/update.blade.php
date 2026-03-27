<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Update Pasca Pelatihan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <form role="form" method="post" action="{{ url('hrd/dataku/updatePelatihan') }}" enctype="multipart/form-data" id="myForm">
    {{ csrf_field() }}
    <input type="hidden" name="id_head" value="{{ $dt_h->id }}">
    <input type="hidden" name="id_detail" value="{{ $dt_d->id }}">
    <div class="iq-card-body" style="width:100%; height:auto">
        <div class="row">
            <div class="col-sm-12 col-lg-5">
                <div class="iq-card iq-card-block iq-card-stretch">
                    <div class="iq-card-body p-0">
                        <div class="user-post-data p-3">
                            <div class="d-flex flex-wrap">
                            <div class="media-support-user-img mr-3">
                                <img class="img-fluid" src="{{ asset('assets/images/page-img/29.png') }}" alt="">
                            </div>
                            <div class="media-support-info mt-2">
                                <h5 class="mb-0"><a href="#" class="">{{ ($dt_h->kategori=='Internal') ? $dt_h->get_nama_pelatihan->nama_pelatihan : $dt_h->nama_pelatihan }}</a></h5>
                                <p class="mb-0 text-primary">{{ ($dt_h->kategori=='Internal') ? $dt_h->get_pelaksana->nama_lembaga : $dt_h->nama_vendor }}</p>
                            </div>
                            </div>
                        </div>
                    </div>
                    <hr class="mt-0">
                    <p class="p-3 mb-0">{{ $dt_h->kompetensi }}</p>
                    <div class="comment-area p-3">
                        <hr class="mt-0">
                        <h6 class="mb-0"><i class="ri-star-s-fill text-dark"></i>Kategori : {{ $dt_h->kategori }}</h6>
                        <h6 class="mb-0"><i class="fa fa-clock-o"></i> Durasi : {{  $dt_h->durasi }}</h6>
                        <h6 class="mb-0"><i class="fa fa-calendar"></i>
                            @if($dt_h->tanggal_awal==$dt_h->tanggal_sampai)
                                {{ App\Helpers\Hrdhelper::get_hari($dt_h->tanggal_awal) }}
                            @else
                                {{ App\Helpers\Hrdhelper::get_hari_ini($dt_h->tanggal_awal). " - ".App\Helpers\Hrdhelper::get_hari_ini($dt_h->tanggal_sampai) }}
                            @endif,
                            {{ App\Helpers\Hrdhelper::get_tanggal_pelaksanaan($dt_h->tanggal_awal, $dt_h->tanggal_sampai, $dt_h->hari_awal, $dt_h->hari_sampai) }}</h6>
                        <h6 class="mb-0"><i class="fa fa-users"></i> Jumlah Peserta : {{  $dt_h->get_peserta()->get()->count() }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-7">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                           <h4 class="card-title">Form laporan pasca pelatihan</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <div class="form-group">
                            <label for="inp_tujuan">Tujuan pelatihan</label>
                            <textarea class="form-control" name="inp_tujuan" id="inp_tujuan" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="inp_uraian">Uraian materi</label>
                            <textarea class="form-control" name="inp_uraian" id="inp_uraian" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="inp_tindak_lanjut">Tindak lanjut setelah pelatihan</label>
                            <textarea class="form-control" name="inp_tindak_lanjut" id="inp_tindak_lanjut" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="inp_dampak">Dampak setelah mengikuti pelatihan</label>
                            <textarea class="form-control" name="inp_dampak" id="inp_dampak" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="inp_penutup">Penutup/Harapan</label>
                            <textarea class="form-control" name="inp_penutup" id="inp_penutup" required></textarea>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="inp_file">Upload evidence pelaksanaan pelatihan</label>
                            <input type="file" name="inp_file" id="inp_file" class="form-control" onchange="loadFile(this)" required>
                            <span class="badge badge-danger">* Allow file type: .jpg | .jpeg | .png; Max file: 1 file</span>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <img id="preview_upload" class="justify-content-center" style="width: 30%; height: auto;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup Form</button>
        <button type="submit" class="btn btn-primary btn-save">Simpan Data</button>
    </div>
    </form>
</div>
<script type="text/javascript">
    var _validFileExtensions = [".jpg", ".jpeg", ".png"];
    var loadFile = function(oInput)
    {
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            var sSizeFile = oInput.files[0].size;
            var output = document.getElementById('preview_upload');
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
                    alert("Maaf, " + sFileName + " tidak valid, jenis file yang boleh di upload adalah: " + _validFileExtensions.join(", "));
                    oInput.value = "";
                    output.src = "";
                    return false;
                } else {
                    output.src = URL.createObjectURL(oInput.files[0]);
                }
            }

        }
        return true;
    };

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
