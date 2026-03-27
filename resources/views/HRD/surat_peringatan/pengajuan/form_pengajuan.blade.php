<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Pengajuan Surat Peringatan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<form action="{{ url('hrd/suratperingatan/simpanPengajuanSP') }}" method="post" id="myForm">
{{ csrf_field() }}
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
                        <option value="{{ $list->id }}">{{ $list->nik." - ".$list->nm_lengkap }} ({{ (!empty($list->id_jabatan) ? $list->get_jabatan->nm_jabatan : "") }}{{ (!empty($list->id_departemen) ? " - ".$list->get_departemen->nm_dept : "") }})</option>
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
                            <div class="iq-card-body" style="width:100%; height:auto">
                                <div class="form-group row">
                                    <label class="col-sm-4">Status Karyawan</label>
                                    <div class="col-sm-8">
                                    <label id="status_karyawan">:</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Divisi</label>
                                    <div class="col-sm-8">
                                    <label id="divisi">:</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Departemen</label>
                                    <div class="col-sm-8">
                                    <label id="departemen">:</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Sub Departemen</label>
                                    <div class="col-sm-8">
                                    <label id="subdepartemen">:</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Jabatan</label>
                                    <div class="col-sm-8">
                                    <label id="jabatan">:</label>
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
                            </div>
                        </div>
                        <ul class="list-group" style="margin-bottom: 15px">
                            <li class="list-group-item active">Riwayat Surat Peringatan</li>
                        </ul>
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
                                        <select class="form-control" name="pil_jenis_sp" id="pil_jenis_sp" disabled>
                                            @foreach($list_jenis_sp as $jenis)
                                            <option value="{{ $jenis->id }}">{{ $jenis->nm_jenis_sp }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="form-group col-sm-12">
                                        <label for="inp_rekomendasi">Uraian Pelanggaran</label>
                                        <textarea class="form-control" name="inp_uraian_pelanggaran" id="inp_uraian_pelanggaran" required disabled></textarea>
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
    <button type="submit" class="btn btn-primary" id="tbl_simpan" disabled>Submit</button>
</div>
</form>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".select2").select2({
            dropdownParent: $('#modalFormPengajuan')
        });
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
                    aktif_teks(false);

                }
            });
        }
    }
    function aktif_teks(tf)
    {
        $("#pil_jenis_sp").attr("disabled", tf);
        $("#inp_uraian_pelanggaran").attr("disabled", tf);
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
        $('#pil_jenis_sp').get(0).selectedIndex = 0;
        $("#inp_uraian_pelanggaran").val("");
    }
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
