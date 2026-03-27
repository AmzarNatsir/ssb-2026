<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Pengajuan Izin</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <form action="{{ url('hrd/cutiizin/simpanpengajuanizin') }}" method="post" onsubmit="return konfirm()">
    {{ csrf_field() }}
        <div class="form-group row">
            <label class="col-sm-4">Jenis Izin</label>
            <div class="col-sm-8">
                <select class="form-control select2" name="pil_jenis_izin" id="pil_jenis_izin" style="width: 100%;">
                    <option value="0">Pilihan</option>
                    @foreach($list_jenis_izin as $jenis)
                    <option value="{{ $jenis->id }}">{{ $jenis->nm_jenis_ci }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4">Tanggal Mulai Izin</label>
            <div class="col-sm-8">
                <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control" value="{{ date('Y/m/d') }}" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4">Tanggal Akhir IZin</label>
            <div class="col-sm-8">
                <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" value="{{ date('Y/m/d') }}" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4">Jumlah Hari</label>
            <div class="col-sm-8">
                <input type="text" name="inp_jumlah_hari" id="inp_jumlah_hari" class="form-control" value="0" required readonly>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4">Keterangan</label>
            <div class="col-sm-8">
                <textarea class="form-control" name="keterangan" id="keterangan" required></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function()
    {
        $(".select2").select2();
        $("#tgl_akhir").on("change", function()
        {

            var tgl_1 = $("#tgl_mulai").val();
            var tgl_2 = $("#tgl_akhir").val();
            if(tgl_1=="")
            {
                alert("Masukkan tanggal awal izin");
                return false;
            } else if(tgl_2=="")
            {
                alert("Masukkan tanggal akhir izin");
                return false;
            } else {
                $.ajax({
                url: "{{ url('hrd/cutiizin/getjumlahhari')}}",
                type : 'post',
                headers : {
                    'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
                },
                data : {tgl_1:tgl_1, tgl_2:tgl_2},
                //dataType: 'json',
                success : function(res)
                {
                    $("#inp_jumlah_hari").val(res);
                    if(parseFloat(res) <= 0)
                    {
                        $(".iq-alert-text").html("Periksa kolom pilihan tanggal mulai dan akhir izin anda..");
                        $("#danger-alert").show(1000);
                        $("#tbl_simpan").attr("disabled", true);
                    } else {
                        $("#danger-alert").hide(1000);
                        $("#tbl_simpan").attr("disabled", false);
                    }
                }
            });
            }
        });
    });
    function konfirm()
    {
        var psn = confirm("Yakin data akan disimpan ?");
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
</script>