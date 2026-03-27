<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Pengajuan Lembur</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <form action="{{ url('hrd/dataku/pengajuanLemburStore') }}" method="post" enctype="multipart/form-data" id="myForm">
    {{ csrf_field() }}
        <div class=" row align-items-center">
            <div class="form-group col-sm-6">
                <label for="tanggal">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="form-group col-sm-2">
                <label for="jam_mulai">Mulai Jam</label>
                <input type="text" name="jam_mulai" id="jam_mulai" class="form-control jamClass" placeholder="00:00" style="text-align: center" required>
            </div>
            <div class="form-group col-sm-2">
                <label for="jam_selesai">Selesai Jam</label>
                <input type="text" name="jam_selesai" id="jam_selesai" class="form-control jamClass" placeholder="00:00" onblur="getTotal(this)" style="text-align: center" required>
            </div>
            <div class="form-group col-sm-2">
                <label for="inp_total">Total Jam</label>
                <input type="text" name="inp_total" id="inp_total" class="form-control" value="0" style="text-align: center" required readonly>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3">Deskripsi Pekerjaan</label>
            <div class="col-sm-9">
                <textarea class="form-control" name="keterangan" id="keterangan" required></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="inp_nama">File Pertama</label>
        </div>
        <hr>
        <div class="form-group">
            <label for="inp_nama">Upload Surat Perintah Lembur</label>
            <input type="file" name="inp_file" id="inp_file" class="form-control" onchange="loadFile(this, 1)" required>
            <span>* .jpg | .jpeg | .png</span>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">
                <img id="preview_upload" class="justify-content-center" style="width: 30%; height: auto;">
            </div>
        </div>
        <hr>
        <div class="alert alert-danger" role="alert">
            <div class="iq-alert-icon">
               <i class="ri-information-line"></i>
            </div>
            <div class="iq-alert-text">Karyawan hanya diperkenankan lembur min. 1 jam / hari, maks. 8 jam / hari</div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-save">Submit</button>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function()
    {
        $(".select2").select2();
        $(".jamClass").mask("99:99");
    });
    var getTotal = function(el)
    {
        var dateStr = $("#tanggal").val();
        var time_1 = $("#jam_mulai").val();
        var time_2 = $("#jam_selesai").val();
        if(time_1=="" || time_2=="")
        {
            var total = 0;
        } else if(time_1 == time_2) {
            alert("Jam Mulai dan Selesai tidak boleh sama");
            return false;
        } else {
            var total = getTotalHoursMinute(dateStr, time_1, time_2);
            if(total==false) {
                alert("Total Lembur min 1 jam");
                $(".btn-save").attr("disabled", true);
                return false;
            }
            if(total > 8) {
                alert("Total Lembur maksimal 8 jam");
                $(".btn-save").attr("disabled", true);
                return false;
            }
        }
        $(".btn-save").attr("disabled", false);
        $("#inp_total").val(total);
    }

    function getTotalHoursMinute(dateStr, timeStr1, timeStr2) {
        var start_time = new Date(dateStr+" "+timeStr1);
        var end_time = new Date(dateStr+" "+timeStr2);

        var mulai = new Date(dateStr+'T' + timeStr1);
        var selesai = new Date(dateStr+'T' + timeStr2);

        var diff = selesai - mulai;
        var jam = diff / (1000 * 60 * 60);

        if(isNaN(jam)) {
            return false;
        } else {
            return jam;
        }
    }
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
