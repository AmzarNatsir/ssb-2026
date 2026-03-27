<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Master Jabatan (Edit)</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<form action="{{ url('hrd/masterdata/jabatan/update/'.$res->id) }}" method="post" enctype="multipart/form-data" onsubmit="return konfirm()">
{{ csrf_field() }}
{{ method_field('PUT') }}
<div class="modal-body">
    <div class=" row align-items-center">
        <div class="form-group col-sm-6">
            <label for="pil_lvl_jabatan">Level Jabatan :</label>
            <select class="select2 form-control mb-3" id="pil_lvl_jabatan" name="pil_lvl_jabatan" required>
                @foreach($list_level_jabatan as $key => $leveljab)
                    @if($leveljab->id==$res->id_level)
                        <option value="{{ $leveljab->id }}" selected>{{ $leveljab->nm_level }}</option>
                    @else
                        <option value="{{ $leveljab->id }}">{{ $leveljab->nm_level }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-group col-sm-6">
            <label for="inp_nama">Divisi :</label>
            <select class="select2 form-control mb-3" id="pil_divisi" name="pil_divisi" required>
                <option value="0">Non Divisi</option>
                @foreach($list_divisi as $divisi)
                @if($divisi->id==$res->id_divisi)
                <option value="{{ $divisi->id }}" selected>{{ $divisi->nm_divisi }}</option>
                @else
                <option value="{{ $divisi->id }}">{{ $divisi->nm_divisi }}</option>
                @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class=" row align-items-center">
        <div class="form-group col-sm-6">
            <label for="pil_departemen">Departemen :</label>
            <select class="select2 form-control mb-3" id="pil_departemen" name="pil_departemen" required>
            <option value="0">Non Departemen</option>
            @foreach($list_departemen as $list_dept)
            @if($list_dept->id==$res->id_dept)
            <option value="{{ $list_dept->id }}" selected>{{ $list_dept->nm_dept }}</option>
            @else
            <option value="{{ $list_dept->id }}">{{ $list_dept->nm_dept }}</option>
            @endif
            @endforeach
            </select>
        </div>
        <div class="form-group col-sm-6">
            <label for="pil_departemen">Sub Departemen :</label>
            <select class="select2 form-control mb-3" id="pil_subdepartemen" name="pil_subdepartemen">
            <option value="0">Non Sub Departemen</option>
            @foreach($list_subdept as $list_subdept)
                @if($list_subdept->id==$res->id_subdept)
                <option value="{{ $list_subdept->id }}" selected>{{ $list_subdept->nm_subdept }}</option>
                @else
                <option value="{{ $list_subdept->id }}">{{ $list_subdept->nm_subdept }}</option>
                @endif
            @endforeach
            </select>
        </div>
    </div>
    <div class=" row align-items-center">
        <div class="form-group col-sm-12">
            <label for="inp_nama">Nama Jabatan :</label>
            <input type="text" class="form-control" id="inp_nama" name="inp_nama" maxlength="200" value="{{ $res->nm_jabatan }}" required>
        </div>
    </div>
    <div class=" row align-items-center">
        <div class="form-group col-sm-6">
            <label for="pil_gakom">Garis Komando (Atasan Langsung) :</label>
            <select class="select2 form-control mb-3" id="pil_gakom" name="pil_gakom" required>
            <option value='0'>Non Garis Komando</option>
            @foreach($res_jabatan_gakom as $list)
                @if($list->id==$res->id_gakom)
                    <option value="{{ $list->id}}" selected>{{ $list->nm_jabatan }}</option>
                @else
                <option value="{{ $list->id}}">{{ $list->nm_jabatan }}</option>
                @endif
            @endforeach
            </select>
        </div>
        <div class="form-group col-sm-6">
            <label for="inp_file_jobdesc">Upload Job Description (* pdf file only) :</label>
            <div class="custom-file">
                <input type="file" class="form-control" id="inp_file_jobdesc" name="inp_file_jobdesc" onchange="loadFile(this)">
                <input type="hidden" name="tmp_file" value="{{ $res->file_jobdesc }}">
                @if(!blank($res->file_jobdesc))
                <hr>
                <a href="{{ url('hrd/masterdata/jabatan/jobdesc/download/'.$res->id) }}" target="_new" class="btn btn-danger btn-block">Download File</a>
                @endif
            </div>
        </div>
    </div>
    <div class=" row align-items-center">
        <div class="form-group col-sm-2">
            <hr>
            <label>Status Data :</label>
        </div>
        <div class="form-group col-sm-4">
            <hr>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="rdo_status_1" name="rdo_status" class="custom-control-input" value="1" {{ ($res->status==1)? 'checked' : '' }}>
                <label class="custom-control-label" for="rdo_status_1"> Aktif</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="rdo_status_2" name="rdo_status" class="custom-control-input" value="2" {{ ($res->status==2)? 'checked' : '' }}>
                <label class="custom-control-label" for="rdo_status_2"> Tidak Aktif</label>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</div>
</form>
<script>
    $(document).ready(function()
    {
        $(".select2").select2({
            width: '100%'
        });
        $("#pil_lvl_jabatan").on("change", function()
        {
            var id_pil = $("#pil_lvl_jabatan").val();
            // hapus_teks();
            if(id_pil=="")
            {
                return false;
            } else {
                $("#pil_departemen").load("{{ url('hrd/masterdata/subdepartemen/loaddepartement') }}/"+id_pil);
                $("#pil_gakom").load("{{ url('hrd/masterdata/jabatan/loadjabatangakom') }}/"+id_pil);
            }
        });
        $("#pil_divisi").on("change", function(){
            // hapus_teks();
            var id_pil = $("#pil_divisi").val();
            if(id_pil==0)
            {
                return false;
            } else {
                $("#pil_departemen").load("{{ url('hrd/karyawan/loaddepartement') }}/"+id_pil);
            }
        });

        $("#pil_departemen").on("change", function()
        {
            var id_pil = $("#pil_departemen").val();
            $("#pil_subdepartemen").empty();
            if(id_pil==0)
            {
                return false;
            } else {
                //aktif_teks(false);
                $("#pil_subdepartemen").load("{{ url('hrd/masterdata/jabatan/loadsubdepartement') }}/"+id_pil);
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
                    alert("Maaf, " + sFileName + " tidak valid, jenis file yang boleh di upload adalah : " + _validFileExtensions.join(", "));
                    oInput.value = "";
                    return false;
                }
            }

        }
        return true;

    };
    function konfirm()
    {
        var psn = confirm("Yakin akan menyimpan perubahan data ?");
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
</script>
