<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Pengajuan Perubahan Masa Cuti</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <form action="{{ url('hrd/cutiizin/form_perubahan/store') }}" method="post" id="myForm">
    {{ csrf_field() }}
        <input type="hidden" name="id_cuti" value="{{ $profil->id }}">
        <input type="hidden" name="id_karyawan" value="{{ $profil->id_karyawan }}">
        <div class="row">
            <div class="col-sm-12 col-lg-6">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                        <h4 class="card-title">Profil Karyawan</h4>
                        </div>
                    </div>
                    <ul class="list-group list-group-sm">
                        <li class="list-group-item disabled" aria-disabled="true">NIK : {{ $profil->profil_karyawan->nik }}</li>
                        <li class="list-group-item">Nama Karyawan : {{ $profil->profil_karyawan->nm_lengkap }}</li>
                        <li class="list-group-item">Jabatan : {{ $profil->profil_karyawan->get_jabatan->nm_jabatan }}</li>
                    </ul>
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                        <h4 class="card-title">Data Pengajuan</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <div class="form-group row">
                            <label class="col-sm-4">Tanggal Mulai Cuti</label>
                            <div class="col-sm-8">
                                <input type="date" name="tgl_mulai_origin" id="tgl_mulai_origin" class="form-control" value="{{ $profil->tgl_awal }}" required readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4">Tanggal Akhir Cuti</label>
                            <div class="col-sm-8">
                                <input type="date" name="tgl_akhir_origin" id="tgl_akhir_origin" class="form-control" value="{{ $profil->tgl_akhir }}" required readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4">Jumlah Hari</label>
                            <div class="col-sm-8">
                                <input type="text" name="inp_jumlah_hari_origin" id="inp_jumlah_hari_origin" class="form-control" value="{{ $profil->jumlah_hari }}" required readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4">Sisa Hak Cuti</label>
                            <div class="col-sm-8">
                                <input type="text" name="inp_sisa_hak_origin" id="inp_sisa_hak_origin" class="form-control" value="{{ $sisa_quota }}" required readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                        <h4 class="card-title">Form Pengajuan Perubahan Masa Cuti</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <div class="form-group row">
                            <label class="col-sm-4">Tanggal Perubahan</label>
                            <div class="col-sm-8">
                                <input type="date" name="tgl_akhir_edit" id="tgl_akhir_edit" class="form-control" min="{{ $profil->tgl_awal }}" value="{{ date('Y/m/d') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4">Jumlah Hari</label>
                            <div class="col-sm-8">
                                <input type="text" name="inp_jumlah_hari_edit" id="inp_jumlah_hari_edit" class="form-control" value="0" required readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4">Sisa Hak Cuti</label>
                            <div class="col-sm-8">
                                <input type="text" name="inp_sisa_hak_edit" id="inp_sisa_hak_edit" class="form-control" value="0" readonly>
                            </div>
                        </div>
                        <div class="alert text-white bg-danger" role="alert" id="danger-alert" style="display: none;">
                            <div class="iq-alert-icon">
                                <i class="ri-alert-line"></i>
                            </div>
                            <div class="iq-alert-text"></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12">Keterangan</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" name="keterangan" id="keterangan" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
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
        $("#tgl_akhir_edit").on("change", function()
        {

            var tgl_1 = $("#tgl_mulai_origin").val();
            var tgl_2 = $("#tgl_akhir_edit").val();
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
                    dataType: 'json',
                    success : function(res)
                    {
                        // alert(res);
                        $("#inp_jumlah_hari_edit").val(res.jumlah_hari);
                        // $("#tgl_masuk").val(res.tgl_masuk);
                        periksa_quota_cuti();
                    }
                });
            }
        });
    })
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

    function periksa_quota_cuti()
    {
        var jml_hari_edit = $("#inp_jumlah_hari_edit").val();
        var jml_hari_origin = $("#inp_jumlah_hari_origin").val();
        var sisa_quota_origin = $("#inp_sisa_hak_origin").val();
        var sisa_quota = (parseFloat(sisa_quota_origin) - parseFloat(jml_hari_origin)) + parseFloat(jml_hari_edit);
        $("#inp_sisa_hak_edit").val(sisa_quota);
        if(parseFloat(jml_hari_edit) > parseFloat(sisa_quota))
        {
            $(".iq-alert-text").html("Maaf. Jumlah Hari Cuti tidak boleh lebih dari Sisa Hak Cuti");
            $("#danger-alert").show(1000);
            $("#tbl_simpan").attr("disabled", true);
        } else if(parseFloat(jml_hari_edit) <= 0)
        {
            $(".iq-alert-text").html("Periksa kolom pilihan tanggal mulai dan akhir cuti anda..");
            $("#danger-alert").show(1000);
            $("#tbl_simpan").attr("disabled", true);
        } else {
            $("#danger-alert").hide(1000);
            $("#tbl_simpan").attr("disabled", false);
        }
    }
</script>
