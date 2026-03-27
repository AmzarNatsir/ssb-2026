<div class="modal-header">
    <h4 class="modal-title">Upload Dokumen Perjalanan Dinas</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span></button>
  </div>
  <form role="form" method="post" action="{{ url('hrd/dataku/storeUploadDokumenPerdis') }}" enctype="multipart/form-data" onsubmit="return konfirm()">
  {{ csrf_field() }}
  <input type="hidden" name="id_perdis" value="{{ $detail->id_perdis }}">
  <input type="hidden" name="id_detail_perdis" value="{{ $detail->id }}">
  <div class="modal-body">
    <div class="row">
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                <label for="inp_nama">File Pertama</label>
            </div>
            <hr>
            <div class="form-group">
                <label for="inp_nama">Upload Dokumen</label>
                <input type="file" name="inp_file_1" id="inp_file_1" class="form-control" onchange="loadFile(this, 1)">
                <span>* .jpg | .jpeg | .png</span>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                    <img id="preview_upload" class="justify-content-center" style="width: 30%; height: auto;">
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                <label for="inp_nama">File Kedua</label>
            </div>
            <hr>
            <div class="form-group">
                <label for="inp_nama">Upload Dokumen</label>
                <input type="file" name="inp_file_2" id="inp_file_2" class="form-control" onchange="loadFile(this, 2)">
                <span>* .jpg | .jpeg | .png</span>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                    <img id="preview_upload_2" class="justify-content-center" style="width: 30%; height: auto;">
                </div>
            </div>
        </div>
    </div>

  </div>
  <div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-outline-light closed_2" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-outline-light">Save changes</button>
  </div>
  </form>
  <script type="text/javascript">
  var _validFileExtensions = [".jpg", ".jpeg", ".png"];
  var loadFile = function(oInput, fileke)
  {
      if (oInput.type == "file") {
          var sFileName = oInput.value;
          var sSizeFile = oInput.files[0].size;
          if(fileke==1)
          {
            var output = document.getElementById('preview_upload');
          } else {
            var output = document.getElementById('preview_upload_2');
          }

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
  </script>
