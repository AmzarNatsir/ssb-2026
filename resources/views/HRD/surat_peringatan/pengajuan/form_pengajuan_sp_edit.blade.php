<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Pengajuan Surat Peringatan - Edit</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<form action="{{ url('hrd/suratperingatan/updatePengajuanSP/'.$profil->id) }}" method="post" onsubmit="return konfirm()">
{{ csrf_field() }}
{{ method_field('PUT') }}
<div class="modal-body">
    <div class="iq-card iq-card-block iq-card-stretch">
        <div class="iq-card-body">
            <ul class="list-group" style="margin-bottom: 15px">
                <li class="list-group-item active">Telah terjadi pelanggaran peraturan KESELAMATAN KERJA yang dilakukan oleh :</li>
            </ul>
            <div class=" row align-items-center">
                <div class="form-group col-sm-12">
                    <label for="pil_karyawan">Pilih Karyawan : </label>
                    <select class="form-control select2" id="pil_karyawan" name="pil_karyawan" onChange="getDataKaryawan();" style="width: 100%;">
                        <option value="0">-> Pilih Karyawan</option>
                        @foreach($list_karyawan as $list)
                            @if($list->id==$profil->id_karyawan)
                                <option value="{{ $list->id }}" selected>{{ $list->nik." - ".$list->nm_lengkap }} ({{ (!empty($list->id_jabatan) ? $list->get_jabatan->nm_jabatan : "") }}{{ (!empty($list->id_departemen) ? " - ".$list->get_departemen->nm_dept : "") }})</option>
                            @else
                                <option value="{{ $list->id }}">{{ $list->nik." - ".$list->nm_lengkap }} ({{ (!empty($list->id_jabatan) ? $list->get_jabatan->nm_jabatan : "") }}{{ (!empty($list->id_departemen) ? " - ".$list->get_departemen->nm_dept : "") }})</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="iq-card">
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="list-group" style="margin-bottom: 15px">
                            <li class="list-group-item active">Profil Karyawan</li>
                        </ul>
                        <div class="iq-card">
                            <div class="form-group row">
                                <label class="col-sm-4">Status Karyawan</label>
                                <div class="col-sm-8">
                                <label id="status_karyawan"><b>: {{ $profil->profil_karyawan->get_status_karyawan($profil->profil_karyawan->id_status_karyawan) }}</b></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4">Divisi</label>
                                <div class="col-sm-8">
                                <label id="divisi"><b>: {{ (!empty($profil->profil_karyawan->id_divisi)) ? $profil->profil_karyawan->get_divisi->nm_divisi : "" }}</b></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4">Departemen</label>
                                <div class="col-sm-8">
                                <label id="departemen"><b>: {{ (!empty($profil->profil_karyawan->id_departemen)) ? $profil->profil_karyawan->get_departemen->nm_dept : "" }}</b></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4">Sub Departemen</label>
                                <div class="col-sm-8">
                                <label id="subdepartemen"><b>: {{ (!empty($profil->profil_karyawan->id_subdepartemen)) ? $profil->profil_karyawan->get_subdepartemen->nm_subdept : "" }}</b></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4">Jabatan</label>
                                <div class="col-sm-8">
                                <label id="jabatan"><b>: {{ (!empty($profil->profil_karyawan->id_jabatan)) ? $profil->profil_karyawan->get_jabatan->nm_jabatan : "" }}</b></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4">Bergabung Tanggal</label>
                                <div class="col-sm-8">
                                <label id="tanggal_masuk"><b>: {{ (!empty($profil->profil_karyawan->tgl_masuk)) ? date('d-m-Y', strtotime($profil->profil_karyawan->tgl_masuk)): "" }}</b></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4">Lama Bekerja</label>
                                <div class="col-sm-8">
                                <label id="lama_bekerja"><b>: {{ (!empty($profil->profil_karyawan->tgl_masuk)) ? App\Helpers\Hrdhelper::get_lama_kerja_karyawan($profil->profil_karyawan->tgl_masuk) : "Tanpa Keterangan" }}</b></label>
                                </div>
                            </div>
                            <ul class="list-group" style="margin-bottom: 15px">
                                <li class="list-group-item active">Riwayat Surat Teguran</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ul class="list-group" style="margin-bottom: 15px">
                            <li class="list-group-item active">Detail Pelanggaran</li>
                        </ul>
                        <div class="iq-card">
                            <div class="iq-card-body" style="width:100%; height:auto">
                                <div class="row align-items-center">
                                    <label class="col-sm-4">Tingkatan Sanksi</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="pil_jenis_sp" id="pil_jenis_sp">
                                            @foreach($res_jenis_sp as $jenis)
                                            @if($jenis->id==$profil->id_jenis_sp_pengajuan)
                                            <option value="{{ $jenis->id }}" selected>{{ $jenis->nm_jenis_sp }}</option>
                                            @else
                                            <option value="{{ $jenis->id }}">{{ $jenis->nm_jenis_sp }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="form-group col-sm-12">
                                        <label for="inp_rekomendasi">Uraian Pelanggaran</label>
                                        <textarea class="form-control" name="inp_uraian_pelanggaran" id="inp_uraian_pelanggaran" required>{{ $profil->uraian_pelanggaran }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    $("#status_karyawan").html("<b>: "+res.nm_status_lm+"</b>");
                    $("#divisi").html("<b>: "+res.nm_divisi_lm+"</b>");
                    $("#departemen").html("<b>: "+res.nm_dept_lm+"</b>");
                    $("#subdepartemen").html("<b>: "+res.nm_subdept_lm+"</b>");
                    $("#jabatan").html("<b>: "+res.nm_jabt_lm+"</b>");
                    $("#tanggal_masuk").html("<b>: "+res.tgl_masuk+"</b>")
                    $("#lama_bekerja").html("<b>: "+res.lama_kerja+"</b>");
                }
            });
        }
    }
    function aktif_teks(tf)
    {
        $("#tbl_simpan").attr("disabled", tf);
    }
    function hapus_teks()
    {
        $("#status_karyawan").html(":");
        $("#divisi").html(":");
        $("#departemen").html(":");
        $("#subdepartemen").html(":");
        $("#jabatan").html(":");
        $("#tanggal_masuk").html(":");
        $("#lama_bekerja").html(":");
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
