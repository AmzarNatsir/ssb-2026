<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Pengajuan Resign</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <form action="{{ url('hrd/dataku/pengajuanResignStore') }}" method="post" enctype="multipart/form-data" id="myForm">
    {{ csrf_field() }}
    <div class="iq-card-body">
        <div class="form-group">
            <label for="inp_alasan">Masukkan alasan pengajuan pengunduran diri anda</label>
            <textarea class="form-control" name="inp_alasan" id="inp_alasan" required></textarea>
        </div>
        <hr>
        <div class="form-group">
            <label for="inp_nama">Upload surat pengunduran diri</label>
            <input type="file" name="inp_file" id="inp_file" class="form-control" onchange="loadFile(this)" required>
            <span class="badge badge-danger mt-2">* .pdf</span>
        </div>
        <div class="form-group">
            <div class="alert text-white bg-danger" role="alert">
                <div class="iq-alert-icon"><i class="ri-alert-line"></i></div>
                <div class="id-alert-text">Pengajuan pengunduran diri dibuat 30 hari sebelum pengunduran diri anda</div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-save">Submit</button>
    </div>
    </form>
</div>

<script type="text/javascript">
    var _validFileExtensions = [".pdf"];
    var loadFile = function(oInput)
    {
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
                    alert("Maaf, " + sFileName + " tidak valid, jenis file yang boleh di upload adalah: " + _validFileExtensions.join(", "));
                    oInput.value = "";
                    return false;
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
