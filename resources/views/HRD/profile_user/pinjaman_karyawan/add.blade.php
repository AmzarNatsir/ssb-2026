<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Pengajuan Pinjaman Karyawan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <form action="{{ url('hrd/dataku/pengajuanPinjamanStore') }}" method="post" enctype="multipart/form-data" onsubmit="return konfirm()">
    {{ csrf_field() }}
    <div class="iq-card">
        <div class="iq-card-body" style="width:100%; height:auto">
            <div class="iq-card">
                <div class="row">
                    <div class="col-sm-6 col-lg-6">
                        {{-- <div class="iq-card-body"> --}}
                            <ul class="list-group">
                                <li class="list-group-item disabled" aria-disabled="true">NIK : {{ $profil->nik }}</li>
                                <li class="list-group-item">Nama Karyawan : {{ $profil->nm_lengkap }}</li>
                                <li class="list-group-item">Jabatan : {{ $profil->get_jabatan->nm_jabatan }}</li>
                                <li class="list-group-item">Departemen : {{ $profil->get_departemen->nm_dept }}</li>
                            </ul>
                        {{-- </div> --}}
                    </div>
                    <div class="col-sm-6 col-lg-6">
                        {{-- <div class="iq-card-body"> --}}
                            <ul class="list-group">
                                <li class="list-group-item disabled" aria-disabled="true">Status Karyawan : {{ $status_karyawan }}</li>
                                <li class="list-group-item">Bergabung Tanggal : {{ (!empty($profil->tgl_masuk)) ? date_format(date_create($profil->tgl_masuk), 'd-m-Y') : "Tanpa Keterangan" }}</li>
                                <li class="list-group-item">Lama Bekerja : {{ (!empty($profil->tgl_masuk)) ? App\Helpers\Hrdhelper::get_lama_kerja_karyawan($profil->tgl_masuk) : "Tanpa Keterangan" }}</li>
                                <li class="list-group-item">Gaji Pokok : Rp. {{ (!empty($profil->gaji_pokok)) ? number_format($profil->gaji_pokok, 0) : 0 }}</li>
                            </ul>
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
            <div class="iq-card">
                <div class="iq-card-body" style="width:100%; height:auto">
                    <ul class="list-group" style="margin-bottom: 15px">
                        <li class="list-group-item bg-primary active">Form Pengajuan</li>
                    </ul>
                    <div class="row">
                        <input type="hidden" name="status_kryawan" id="status_kryawan" value="{{ $profil->id_status_karyawan }}">
                        <input type="hidden" name="gapok" id="gapok" value="{{ $profil->gaji_pokok }}">
                        <div class="col-sm-6 col-lg-6">
                            <div class="form-group">
                                <label for="pil_jenis">Jenis Pinjaman</label>
                                <select class="form-control select2" name="pil_jenis" id="pil_jenis" style="width: 100%" onchange="getValidasi(this)" required>
                                    <option value="0" selected>-- Pilihan --</option>
                                    <option value="1">Panjar Gaji</option>
                                    <option value="2">Pinjaman Kesejahteraan Karyawan (PKK)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pil_alasan">Alasan Pengajuan Pinjaman</label>
                                <select class="form-control select2" name="pil_alasan" id="pil_alasan" style="width: 100%" required>
                                    <option value="0" selected>-- Pilihan --</option>
                                    <option value="Pendidikan">Pendidikan</option>
                                    <option value="Berobat">Berobat</option>
                                    <option value="Rumah Tangga">Rumah Tangga</option>
                                    <option value="Musibah">Musibah</option>
                                    <option value="Alasan darurat lainnya (pengurusan SIM & SIO)">Alasan darurat lainnya (pengurusan SIM & SIO)</option>
                                </select>
                            </div>
                            <div class="alert alert-success" role="alert">
                                <div class="iq-alert-text">
                                    <h5 class="alert-heading">Informasi !</h5>
                                    <table style="width: 100%; font-size: 15px">
                                    <tr>
                                        <td style="width: 50%"><p>Maksimal Pengajuan</p></td>
                                        <td style="text-align: right"><input type="text" class="form-control angka" name="maks_pinjaman" id="maks_pinjaman" style="text-align: right; background-color: white" value="0" readonly></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 50%"><p>Maksimal Tenor (Bulan)</p></td>
                                        <td style="text-align: right"><input type="text" class="form-control" name="maks_tenor" id="maks_tenor" value="0" style="text-align: right; background-color: white" value="0" readonly></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 50%"><p>Maksimal Angsuran</p></td>
                                        <td style="text-align: right"><input type="text" class="form-control angka" name="maks_angsuran" id="maks_angsuran" style="text-align: right; background-color: white" value="0" readonly></td>
                                    </tr>
                                    </table>
                                    <hr>
                                    <p>Maksimal Angsuran (Panjar Gaji) = Nilai maksimal angsuran yaitu 50% dari pendapatan tetap</p>
                                    <p>* Maksimal Angsuran (PKK) = Nilai maksimal angsuran yaitu 35% dari pendapatan tetap setiap bulan dikurangi kewajiban angsuran lainnya</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-6">
                            <div class="form-group row">
                                <label class="col-sm-6">Masukkan Jumlah Pengajuan</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control angka" name="inpNominal" id="inpNominal" style="text-align: right" value="0" oninput="getNomAngsuran()">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-9">Tenor (Bulan)</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control angka" name="inpTenor" id="inpTenor" style="text-align: right" value="0" maxlength="2" oninput="getNomAngsuran()">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-6">Angsuran</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control angka" name="inpAngsuran" id="inpAngsuran" style="text-align: right" value="0" readonly>
                                </div>
                            </div>
                            <div class="alert alert-danger" role="alert" id="warningInfo" style="display: none">
                                <div class="iq-alert-text">
                                    <h5 class="alert-heading">Warning !</h5>
                                    <div id="infoWarning"></div>
                                </div>
                            </div>
                            <div class="uploadDokumen" style="display: none">
                                <ul class="list-group" style="margin-bottom: 15px">
                                    <li class="list-group-item bg-primary active"><i class="fa fa-paperclip"></i> Upload Dokumen
                                        <div class="user-list-files d-flex float-right">
                                            <button onclick="addButton(this)" type="button" class="btn btn-warning"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </li>
                                </ul>
                                <table class="list_item_1" style="width: 100%; height: auto"></table>
                            </div>
                            <br>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="btn-submit" id="btn-submit" disabled>Submit</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </form>
</div>

<script type="text/javascript">
    $(document).ready(function()
    {
        $(".select2").select2();
        $(".angka").number(true, 0);
    });
    var getValidasi = function(el)
    {
        var gapok = $("#gapok").val();
        var maks_pinjaman_pg = 0; //pg = panjar gaji
        var mask_tenor_pg = 1;
        var maks_pinjaman_pkk = 20000000;
        var mask_tenor_pkk = 24;
        var mask_angsuran_pkk = (parseFloat(gapok) * 35) / 100;
        $("#inpTenor").val("0");
        $("#inpAngsuran").val("0");
        $("#maks_pinjaman").val("0");
        $("#inpTenor").attr('readonly', true);
        $("#btn-submit").attr('disabled', true);
        $(".uploadDokumen").hide(1000);
        if($(el).val()==0)
        {
            // aktif_text(true);
            $("#maks_tenor").val("0");
            $("#inpNominal").val("0");
        } else if($(el).val()==1) {
            maks_pinjaman_pg = (parseFloat(gapok) * 50) / 100;
            $("#inpNominal").val(maks_pinjaman_pg);
            $("#inpTenor").val(mask_tenor_pg);
            $("#inpAngsuran").val(maks_pinjaman_pg);
            //temp
            $("#maks_pinjaman").val(maks_pinjaman_pg);
            $("#maks_tenor").val(mask_tenor_pg);
            $("#maks_angsuran").val(maks_pinjaman_pg);
            $("#btn-submit").attr('disabled', false);
            // aktif_text(false);
        } else {
            $("#inpNominal").val("0");
            $("#inpTenor").val("0");
            $("#inpAngsuran").val("0");
            //temp
            $("#maks_pinjaman").val(maks_pinjaman_pkk);
            $("#maks_tenor").val(mask_tenor_pkk);
            $("#maks_angsuran").val(mask_angsuran_pkk);
            $("#inpTenor").attr('readonly', false);
            $("#btn-submit").attr('disabled', true);
            $(".uploadDokumen").show(1000);
            // aktif_text(false);
        }
    }

    var getNomAngsuran = function()
    {
        var nomPengajuan = $("#inpNominal").val();
        var nomTenor = $("#inpTenor").val();
        var maskPinjaman = $("#maks_pinjaman").val();
        var maskTenor = $("#maks_tenor").val();
        var maskAngsuran = $("#maks_angsuran").val();
        var jenisPengajuan = $("#pil_jenis").val();
        var nomAngsuran = parseFloat(nomPengajuan) / parseInt(nomTenor)
        $("#inpAngsuran").val(nomAngsuran);
        if(parseFloat(nomPengajuan) > parseFloat(maskPinjaman))
        {
            $("#warningInfo").show();
            $("#infoWarning").html("<p>Nominal yang anda ajukan melebihi batas maksimum pinjaman</p>");
            $("#btn-submit").attr('disabled', true);
        } else if(parseFloat(nomTenor) > parseFloat(maskTenor)) {
            $("#warningInfo").show();
            $("#infoWarning").html("<p>Tenor yang anda ajukan melebihi batas maksimum tenor pinjaman</p>");
            $("#btn-submit").attr('disabled', true);
        // } else if(parseFloat(nomAngsuran) > parseFloat(maskAngsuran)) {
        //     $("#warningInfo").show();
        //     $("#infoWarning").html("<p>Nominal angsuran yang anda ajukan melebihi batas maksimum nominal angsuran pinjaman</p>");
        } else {
            $("#warningInfo").hide();
            $("#infoWarning").html("");
            $("#btn-submit").attr('disabled', false);
        }
    }

    var addButton = function(){
        let content = `<tr>
                <td style="width: 45%"><input type="file" class="form-control" name="fileDokumen[]" id="fileDokumen[]"></td>
                <td style="width: 45%"><input type="text" class="form-control" name="inpKeterangan[]" id="inpKeterangan[]" placeholder="Keterangan Dokumen"></td>
                <td><button type="button" title="Hapus Baris" class="btn btn-danger btn-sm waves-effect waves-light" onclick="delete_item(this)"><i class="fa fa-minus"></i></button></td>
            </tr>`;
        $(".list_item_1").append(content);
    }
    var delete_item = function(el){
        $(el).parent().parent().slideUp(100,function(){
            $(this).remove();
        });
    }

    function aktif_text(tf)
    {
        $("#inpNominal").attr('disabled', tf);
        $("#inpTenor").attr('disabled', tf);
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
