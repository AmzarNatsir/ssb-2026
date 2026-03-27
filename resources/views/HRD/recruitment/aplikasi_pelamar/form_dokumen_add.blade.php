<div class="modal-header">
  <h4 class="modal-title">Upload Dokumen Baru</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
</div>
<form role="form" method="post" action="{{ route('insertDokumen') }}" enctype="multipart/form-data" onsubmit="return konfirm()">
{{ csrf_field() }}
<input type="hidden" name="id_dokumen" value="{{ $id_dokumen }}">
<input type="hidden" name="id_pelamar" value="{{ $id_pelamar }}">
<div class="modal-body">
    <div class="form-group">
      <label for="inp_nama">Jenis Dokumen : {{ $profil_dok->nm_dokumen }}</label>
      
    </div>
    <hr>
    <div class="form-group">
      <label for="inp_nama">Upload Dokumen</label>
      <input type="file" name="inp_dokumen" id="inp_dokumen" class="form-control" onchange="loadFile(this)" required>
      <span>* .jpg | .jpeg | .png</span>
    </div>
    <div class="form-group row">
      <div class="col-sm-12">
          <img id="preview_upload" style="width: 100%; height: auto;"> 
      </div>
    </div>
</div>
<div class="modal-footer justify-content-between">
  <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
  <button type="submit" class="btn btn-outline-light">Save changes</button>
</div>
</form>
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
</script>