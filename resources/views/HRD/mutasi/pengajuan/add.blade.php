<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Pengajuan Mutasi</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<form action="{{ url('hrd/mutasi/storepengajuan') }}" enctype="multipart/form-data" method="post" onsubmit="return konfirm()">
{{ csrf_field() }}
<div class="modal-body">
    <div class="iq-card iq-card-block iq-card-stretch">
        <div class="iq-card-body">
            <div class=" row align-items-center">
                <div class="form-group col-sm-12">
                    <label for="pil_karyawan">Pilih Karyawan : </label>
                    <select class="form-control select2" id="pil_karyawan" name="pil_karyawan" onChange="getDataKaryawan();" style="width: 100%;">
                        <option value="0">-> Pilih Karyawan</option>
                        @foreach($list_karyawan as $list)
                        <option value="{{ $list->id }}">{{ $list->nik." - ".$list->nm_lengkap }} ({{ (!empty($list->id_jabatan) ? $list->get_jabatan->nm_jabatan : "") }}{{ (!empty($list->id_departemen) ? " - ".$list->get_departemen->nm_dept : "") }} - {{ $list->get_status_karyawan($list->id_status_karyawan) }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <ul class="list-group" style="margin-bottom: 15px">
                <li class="list-group-item active">Posisi/Jabatan Karyawan Saat Ini</li>
            </ul>
            <div class="form-group row">
                <label class="col-sm-4">Status Karyawan</label>
                <div class="col-sm-8">
                <label id="sts_lama">:</label>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Divisi</label>
                <div class="col-sm-8">
                <input type="hidden" name="inp_id_divisi_lama" id="inp_id_divisi_lama">
                <label id="divisi_lama">:</label>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Departemen</label>
                <div class="col-sm-8">
                <input type="hidden" name="inp_id_dept_lama" id="inp_id_dept_lama">
                <label id="departemen_lama">:</label>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Sub Departemen</label>
                <div class="col-sm-8">
                <input type="hidden" name="inp_id_subdept_lama" id="inp_id_subdept_lama">
                <label id="subdepartemen_lama">:</label>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Jabatan</label>
                <div class="col-sm-8">
                <input type="hidden" name="inp_id_jabatan_lama" id="inp_id_jabatan_lama">
                <label id="jabatan_lama">:</label>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Efektif Jabatan</label>
                <div class="col-sm-8">
                <input type="hidden" name="inp_tgl_efektif_lama" id="inp_tgl_efektif_lama">
                <label id="tanggal_efektif_lama">:</label>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Bergabung Tanggal</label>
                <div class="col-sm-8">
                <label id="tanggal_masuk">:</label>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Lama Bekerja</label>
                <div class="col-sm-8">
                <label id="lama_bekerja">:</label>
                </div>
            </div>
            <hr>
            <ul class="list-group" style="margin-bottom: 15px">
                <li class="list-group-item active">Lampirkan Hasil Evaluasi Karyawan</li>
            </ul>
            <div class="form-group">
                <label for="inp_file_jobdesc">Upload File Hasil Evaluasi (* pdf file only) :</label>
                <div class="custom-file">
                    <input type="file" class="form-control" id="inp_file_evaluasi" name="inp_file_evaluasi" onchange="loadFile(this)" required disabled>
                    <input type="hidden" name="tmp_file">
                </div>
            </div>
            <hr>
            <ul class="list-group" style="margin-bottom: 15px">
                <li class="list-group-item active">Perubahan Posisi/Jabatan</li>
            </ul>
            <div class="form-group row">
                <label class="col-sm-4">Kategori</label>
                <div class="col-sm-8">
                    <select class="form-control" name="pil_kategori" id="pil_kategori" required disabled>
                        @foreach($list_kategori as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Divisi Baru</label>
                <div class="col-sm-8">
                    <select class="form-control" name="pil_divisi_baru" id="pil_divisi_baru" required disabled>
                        <option value="0" selected>Non Divisi</option>
                        @foreach($list_divisi as $divisi)
                        <option value="{{ $divisi->id }}">{{ $divisi->nm_divisi }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Departemen Baru</label>
                <div class="col-sm-8">
                    <select class="form-control" name="pil_dept_baru" id="pil_dept_baru" required disabled>
                        <option value="0" selected>Non Departemen</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Sub Departemen Baru</label>
                <div class="col-sm-8">
                    <select class="form-control" name="pil_subdept_baru" id="pil_subdept_baru" required disabled onChange="getJabatan();">
                        <option value="0" selected>Non Sub Departemen</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Jabatan Baru</label>
                <div class="col-sm-8">
                    <select class="form-control" name="pil_jabt_baru" id="pil_jabt_baru" required disabled>
                        @foreach($list_jabatan as $jabatan)
                        <option value="{{ $jabatan->id }}">{{ $jabatan->nm_jabatan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Keterangan</label>
                <div class="col-sm-8">
                    <textarea class="form-control" name="keterangan" id="keterangan" required disabled></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Submit</button>
</div>
</form>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".select2").select2();
    });
    function getDataKaryawan()
    {
        var id_karyawan = $("#pil_karyawan").val();
        hapus_teks();
        if(id_karyawan==0)
        {
            aktif_teks(true);
        } else {
            $.ajax({
                url: "{{ url('hrd/mutasi/getprofil')}}",
                type : 'post',
                headers : {
                    'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
                },
                data : {id_karyawan:id_karyawan},
                dataType: 'json',
                success : function(res)
                {
                    var len = res.length;
                    var arr_tgl_1 = res.tgl_tmt_jabatan_lm.split("-");
                    $("#sts_lama").html("<b>: "+res.nm_status_lm+"</b>");
                    $("#divisi_lama").html("<b>: "+res.nm_divisi_lm+"</b>");
                    $("#departemen_lama").html("<b>: "+res.nm_dept_lm+"</b>");
                    $("#subdepartemen_lama").html("<b>: "+res.nm_subdept_lm+"</b>");
                    $("#jabatan_lama").html("<b>: "+res.nm_jabt_lm+"</b>");
                    $("#tanggal_efektif_lama").html("<b>: "+arr_tgl_1[2]+"-"+arr_tgl_1[1]+"-"+arr_tgl_1[0]+"</b>");
                    $("#inp_id_divisi_lama").val(res.id_divisi_lm);
                    $("#inp_id_dept_lama").val(res.id_dept_lm);
                    $("#inp_id_subdept_lama").val(res.id_subdept_lm);
                    $("#inp_id_jabatan_lama").val(res.id_jabt_lm);
                    $("#inp_tgl_efektif_lama").val(res.tgl_tmt_jabatan_lm);
                    $("#tanggal_masuk").html("<b>: "+res.tgl_masuk+"</b>")
                    $("#lama_bekerja").html("<b>: "+res.lama_kerja+"</b>");
                    aktif_teks(false);

                }
            });
        }
        $("#result_riwayat").load("{{ url('hrd/mutasi/getriwayatmutasi') }}/"+id_karyawan);
    }
    $("#pil_divisi_baru").on("change", function()
    {
        var id_pil = $("#pil_divisi_baru").val();
        hapus_teks_dept_sub();
        if(id_pil==0)
        {
            $("#pil_jabt_baru").load("{{ url('hrd/mutasi/load_jabatan_default_mutasi') }}");
        } else {
            $("#pil_dept_baru").load("{{ url('hrd/mutasi/load_departement_mutasi') }}/"+id_pil);
            $("#pil_jabt_baru").load("{{ url('hrd/mutasi/load_jabatan_divisi_mutasi') }}/"+id_pil);
        }
    });
    $("#pil_dept_baru").on("change", function()
    {
        var id_pil_divisi = $("#pil_divisi_baru").val();
        var id_pil_dept = $("#pil_dept_baru").val();
        hapus_teks_sub();
        if(id_pil_dept==0)
        {
            $("#pil_jabt_baru").load("{{ url('hrd/mutasi/load_jabatan_divisi_mutasi') }}/"+id_pil_divisi);
        } else {
            $("#pil_subdept_baru").load("{{ url('hrd/mutasi/load_subdept_mutasi') }}/"+id_pil_dept);
            $("#pil_jabt_baru").load("{{ url('hrd/mutasi/load_jabatan_dept_mutasi') }}/"+id_pil_dept);
        }
    });
    $("#pil_subdept_baru").on("change", function()
    {
        var id_pil_dept = $("#pil_dept_baru").val();
        var id_pil_subdept = $("#pil_subdept_baru").val();
        if(id_pil_subdept==0)
        {
            $("#pil_jabt_baru").load("{{ url('hrd/mutasi/load_jabatan_dept_mutasi') }}/"+id_pil_dept);
        } else {
            //$("#pil_subdepartemen").load("{{ url('hrd/karyawan/loadsubdept') }}/"+id_pil_dept);
            $("#pil_jabt_baru").load("{{ url('hrd/mutasi/load_jabatan_subdept_mutasi') }}/"+id_pil_subdept);
        }
    });
    function hapus_teks_dept_sub()
    {
        $("#pil_dept_baru").empty();
        $("#pil_subdept_baru").empty();
        $("#pil_dept_baru").append("<option value='0'>Non Departemen</option>");
        $("#pil_subdept_baru").append("<option value='0'>Non Sub Departemen</option>");
    }
    function hapus_teks_sub()
    {
        $("#pil_subdept_baru").empty();
        $("#pil_subdept_baru").append("<option value='0'>Non Sub Departemen</option>");
    }
    function aktif_teks(tf)
    {
        $('#pil_kategori').get(0).selectedIndex = 0;
        $('#pil_divisi_baru').get(0).selectedIndex = 0;
        $('#pil_dept_baru').get(0).selectedIndex = 0;
        $('#pil_subdept_baru').get(0).selectedIndex = 0;
        $('#pil_jabt_baru').get(0).selectedIndex = 0;
        $("#pil_kategori").attr("disabled", tf);
        $("#pil_divisi_baru").attr("disabled", tf);
        $("#pil_dept_baru").attr("disabled", tf);
        $("#pil_subdept_baru").attr("disabled", tf);
        $("#pil_jabt_baru").attr("disabled", tf);
        $("#keterangan").attr("disabled", tf);
        $("#tbl_simpan").attr("disabled", tf);
        $("#inp_file_evaluasi").attr("disabled", tf);
    }
    function hapus_teks()
    {
        $("#sts_lama").html(":");
        $("#tanggal_efektif_lama").html(":");
        $("#divisi_lama").html(":");
        $("#departemen_lama").html(":");
        $("#subdepartemen_lama").html(":");
        $("#jabatan_lama").html(":");
        $("#inp_id_divisi_lama").val("");
        $("#inp_id_dept_lama").val("");
        $("#inp_id_subdept_lama").val("");
        $("#inp_id_jabatan_lama").val("");
        $("#inp_tgl_efektif_lama").val("");
        $("#inp_file_evaluasi").val("");
        $("#tanggal_masuk").html(":");
        $("#lama_bekerja").html(":");
    }
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
                    Swal.fire({
                        title: 'Warning',
                        text: "Maaf, " + sFileName + " tidak valid, jenis file yang boleh di upload adalah : " + _validFileExtensions.join(", "),
                        icon: 'warning'
                    }).then(function() {
                        oInput.value = "";
                        return false
                    });
                }
            }

        }
        return true;

    };
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
