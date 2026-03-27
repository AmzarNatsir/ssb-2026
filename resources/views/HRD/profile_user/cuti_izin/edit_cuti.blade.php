<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Pengajuan Cuti</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <form action="{{ url('hrd/dataku/pengajuanCutiUpdate/'.$res->id) }}" method="post" onsubmit="return konfirm()">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
        <div class="form-group row">
            <label class="col-sm-4">Jenis Cuti</label>
            <div class="col-sm-8">
                <select class="form-control select2" name="pil_jenis_cuti" id="pil_jenis_cuti" style="width: 100%;">
                    <option value="0">Pilihan</option>
                    @foreach($list_jenis_cuti as $jenis)
                    @if($jenis->id==$res->id_jenis_cuti)
                    <option value="{{ $jenis->id }}" selected>{{ $jenis->nm_jenis_ci }}</option>
                    @else
                    <option value="{{ $jenis->id }}">{{ $jenis->nm_jenis_ci }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4">Tanggal Mulai Cuti</label>
            <div class="col-sm-8">
                <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control" value="{{ $res->tgl_awal }}" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4">Tanggal Akhir Cuti</label>
            <div class="col-sm-8">
                <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" value="{{ $res->tgl_akhir }}" required >
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4">Jumlah Hari</label>
            <div class="col-sm-8">
                <input type="text" name="inp_jumlah_hari" id="inp_jumlah_hari" class="form-control" value="{{ $res->jumlah_hari }}" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4">Sisa Hak Cuti</label>
            <div class="col-sm-8">
                <input type="text" name="inp_sisa_hak" id="inp_sisa_hak" class="form-control" value="{{ $sisa_quota }}" readonly>
            </div>
        </div>
        <div class="alert text-white bg-danger" role="alert" id="danger-alert" style="display: none;">
            <div class="iq-alert-icon">
                <i class="ri-alert-line"></i>
            </div>
            <div class="iq-alert-text"></div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4">Keterangan</label>
            <div class="col-sm-8">
                <textarea class="form-control" name="keterangan" id="keterangan" required>{{ $res->ket_cuti }}</textarea>
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
        $("#pil_jenis_cuti").on("change", function()
        {
            var id_karyawan = $("#id_user").val();
            var id_pil_jenis = $("#pil_jenis_cuti").val();
            if(id_pil_jenis==0)
            {
                hapus_teks_inputan();
            } else {
                //hapus_teks_inputan();
                $.ajax({
                    url: "{{ url('hrd/cutiizin/getsisaquotacuti')}}",
                    type : 'post',
                    headers : {
                        'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
                    },
                    data : {id_karyawan:id_karyawan, id_pil_jenis:id_pil_jenis},
                    //dataType: 'json',
                    success : function(res)
                    {
                        $("#inp_sisa_hak").val(res);
                        if(res==0)
                        {
                            aktif_teks_inputan(true);
                            //hapus_teks_inputan();
                        } else {
                            aktif_teks_inputan(false);
                            //hapus_teks_inputan();
                        }
                    }
                });
            }
        });
        $("#tgl_akhir").on("change", function()
        {

            var tgl_1 = $("#tgl_mulai").val();
            var tgl_2 = $("#tgl_akhir").val();
            if(tgl_1=="")
            {
                alert("Masukkan tanggal awal cuti");
                return false;
            } else if(tgl_2=="")
            {
                alert("Masukkan tanggal akhir cuti");
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
                        periksa_quota_cuti();
                    }
                });
            }
        });
    });
    function periksa_quota_cuti()
    {
        var jml_hari = $("#inp_jumlah_hari").val();
        var sisa_quota = $("#inp_sisa_hak").val();
        if(parseFloat(jml_hari) > parseFloat(sisa_quota))
        {
            $(".iq-alert-text").html("Maaf. Jumlah Hari Cuti tidak boleh lebih dari Sisa Hak Cuti");
            $("#danger-alert").show(1000);
            $("#tbl_simpan").attr("disabled", true);
        } else if(parseFloat(jml_hari) <= 0)
        {
            $(".iq-alert-text").html("Periksa kolom pilihan tanggal mulai dan akhir cuti anda..");
            $("#danger-alert").show(1000);
            $("#tbl_simpan").attr("disabled", true);
        } else {
            $("#danger-alert").hide(1000);
            $("#tbl_simpan").attr("disabled", false);
        }
    }
    function hapus_teks_inputan()
    {
        $("#tgl_mulai").val("");
        $("#tgl_akhir").val("");
        $("#inp_jumlah_hari").val("0");
        $("#inp_sisa_hak").val("0");
        $("#keterangan").val("");
        $("#pil_pengganti").get(0).selectedIndex = 0;
    }
    function aktif_teks_inputan(tf)
    {
        $("#tgl_mulai").attr("disabled", tf);
        $("#tgl_akhir").attr("disabled", tf);
        $("#keterangan").attr("disabled", tf);
        $("#pil_pengganti").attr("disabled", tf);
        $("#tbl_simpan").attr("disabled", true);
    }
    function aktif_teks(tf)
    {
        $("#inp_tgl_pengajuan").attr("disabled", tf);
        $("#pil_jenis_cuti").attr("disabled", tf);
        $("#tgl_mulai").attr("disabled", tf);
        $("#tgl_akhir").attr("disabled", tf);
        $("#keterangan").attr("disabled", tf);
        $("#pil_pengganti").attr("disabled", tf);
    }
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
