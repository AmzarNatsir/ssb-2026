<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Master Jabatan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<form action="{{ url('hrd/masterdata/jabatan/simpan') }}" method="post" onsubmit="return konfirm()">
{{ csrf_field() }}
<div class="modal-body">
    <div class=" row align-items-center">
        <div class="form-group col-sm-6">
            <label for="pil_lvl_jabatan">Level Jabatan :</label>
            <select class="select2 form-control mb-3" id="pil_lvl_jabatan" name="pil_lvl_jabatan" required>
                <option value="">Pilihan Level Jabatan</option>
                @foreach($list_level_jabatan as $key => $leveljab)
                <option value="{{ $leveljab->id }}">{{ $leveljab->nm_level }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-sm-6">
            <label for="inp_nama">Divisi :</label>
            <select class="select2 form-control mb-3" id="pil_divisi" name="pil_divisi" required>
                <option value="0">Non Divisi</option>
                @foreach($list_divisi as $divisi)
                <option value="{{ $divisi->id }}">{{ $divisi->nm_divisi }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class=" row align-items-center">
        <div class="form-group col-sm-6">
            <label for="pil_departemen">Departemen :</label>
            <select class="select2 form-control mb-3" id="pil_departemen" name="pil_departemen" required>
            <option value="0">Non Departemen</option>
            </select>
        </div>
        <div class="form-group col-sm-6">
            <label for="pil_departemen">Sub Departemen :</label>
            <select class="select2 form-control mb-3" id="pil_subdepartemen" name="pil_subdepartemen">
            <option value="0">Non Sub Departemen</option>
            </select>
        </div>
    </div>
    <div class=" row align-items-center">
        <div class="form-group col-sm-12">
            <label for="inp_nama">Nama Jabatan :</label>
            <input type="text" class="form-control" id="inp_nama" name="inp_nama" maxlength="200" required>
        </div>
    </div>
    <div class=" row align-items-center">
        <div class="form-group col-sm-6">
            <label for="pil_gakom">Garis Komando (Atasan Langsung) :</label>
            <select class="select2 form-control mb-3" id="pil_gakom" name="pil_gakom" required>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</div>
</form>
<script type="text/javascript">
    $(document).ready(function()
    {
        $(".select2").select2({
            width: '100%'
        });
        $("#pil_lvl_jabatan").on("change", function()
        {
            var id_pil = $("#pil_lvl_jabatan").val();
            hapus_teks();
            if(id_pil=="")
            {
                return false;
            } else {
                $("#pil_departemen").load("{{ url('hrd/masterdata/subdepartemen/loaddepartement') }}/"+id_pil);
                $("#pil_gakom").load("{{ url('hrd/masterdata/jabatan/loadjabatangakom') }}/"+id_pil);
            }
        });
        $("#pil_divisi").on("change", function(){
            hapus_teks();
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
    function aktif_teks(tf)
    {
        $("#pil_departemen").attr("disabled", tf);
        $("#pil_subdepartemen").attr("disabled", tf);
        $("#pil_lvl_jabatan").attr("disabled", tf);
        $("#inp_nama").attr("disabled", tf);
        $("#tbl_simpan").attr("disabled", tf);
    }
    function hapus_teks()
    {
        $("#pil_departemen").empty();
        $("#pil_subdepartemen").empty();
        $("#pil_departemen").append("<option value='0'>Non Departemen</option>");
        $("#pil_subdepartemen").append("<option value='0'>Non Sub Departemen</option>");
        // $("#pil_gakom").append("<option value='0'>Non Garis Komandon</option>");
    }
    function konfirm()
    {
        var psn = confirm("Yakin akan menyimpan data ?");
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }


</script>
