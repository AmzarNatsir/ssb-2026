<style>
    .spinner-div {
        position: absolute;
        display: none;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        text-align: center;
        background-color: rgba(255, 255, 255, 0.8);
        z-index: 2;
    }
</style>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Master Jabatan | Pengaturan Atasan Langsung (Gakom)</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<div style="overflow-y: auto; height: calc(100vh - 15rem);">
<form action="{{ url('hrd/masterdata/jabatan/updateJabatanAll') }}" method="post" onsubmit="return konfirm()">
{{ csrf_field() }}
<div class="modal-body">
    <div class=" row align-items-center">
        <div class="form-group col-sm-6">
            <select class="select2 form-control mb-3" id="pil_departemen" name="pil_departemen" required>
            <option value="0">--> Pilih Departemen</option>
            @foreach ($all_departemen as $dept)
                <option value="{{ $dept->id}}">{{ $dept->nm_dept }}</option>
            @endforeach
            </select>
        </div>
        <div class="form-group col-sm-6">
            <div class="user-list-files d-flex float-left">
                <a href="javascript:void(0);" class="chat-icon-phone" onClick="actFilter();"><i class="fa fa-search"></i> FILTER</a>
            </div>
        </div>
    </div>
    <div class="iq-card-body">
        <div id="spinner-div" class="pt-5 justify-content-center spinner-div"><div class="spinner-border text-primary" role="status"></div></div>
        <table class="table tablefixed" style="width: 100%">
            <thead>
                <tr>
                    <td style="width: 5%">No.</td>
                    <td style="width: 45%">Jabatan</td>
                    <td style="width: 50%">Atasan Langsung/Garis Komando (Gakom)</td>
                </tr>
            </thead>
            <tbody id="p_preview"></tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</div>
</form>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#spinner-div').hide();
        $(".select2").select2({
            width: '100%'
        });

    });
    var actFilter = function()
    {
        $('#spinner-div').show();
        var pil_departemen = $("#pil_departemen").val();
        if(pil_departemen==0)
        {
            alert("Kolom pilihan departemen Tidak boleh kosong");
            $('#spinner-div').hide();
            return false;
        } else {
            $("#p_preview").load("{{ url('hrd/masterdata/jabatan/filter_jabatan') }}/"+pil_departemen, function(){
                $('#spinner-div').hide();
            });
        }
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
