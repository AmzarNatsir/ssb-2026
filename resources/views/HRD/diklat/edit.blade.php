<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Edit Pengajuan Pelatihan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <form action="{{ url('hrd/pelatihan/updatepengajuan/'.$dt_h->id) }}" method="post" onsubmit="return konfirm()">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <input type="hidden" name="id_head" id="id_head" value="{{ $dt_h->id }}">
    <div class="iq-card-body" style="width:100%; height:auto">
        <div class="iq-card">
            <div class="row">
                <div class="col-sm-5 col-lg-5">
                    <ul class="list-group" style="margin-bottom: 15px">
                        <li class="list-group-item bg-primary active">Detail Pelatihan</li>
                    </ul>
                    @if($dt_h->kategori=='Internal')
                    <div class="form-group">
                        <label for="inpNamaPelatihan">Nama Pelatihan</label>
                        <select class="form-control select2" id="inpNamaPelatihan" name="inpNamaPelatihan" style="width: 100%;" required>
                            @foreach($all_pelatihan as $list)
                            <option value="{{ $list->id }}">{{ $list->nama_pelatihan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inpNamaVendor">Pelaksana Pelatihan</label>
                        <select class="form-control select2" name="inpNamaVendor" id="inpNamaVendor" style="width: 100%;" required>
                            @foreach($all_pelaksana as $lembaga)
                            <option value="{{ $lembaga->id }}">{{ $lembaga->nama_lembaga }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    @if($dt_h->kategori=='Eksternal')
                    <div class="form-group">
                        <label for="inpNamaPelatihan">Nama Pelatihan</label>
                        <input type="text" class="form-control" name="inpNamaPelatihan" id="inpNamaPelatihan" maxlength="200" value="{{ $dt_h->nama_pelatihan }}" required>
                    </div>
                    <div class="form-group">
                        <label for="inpNamaVendor">Nama Vendor/Pelaksana Pelatihan</label>
                        <input type="text" class="form-control" name="inpNamaVendor" id="inpNamaVendor" maxlength="200" value="{{ $dt_h->nama_vendor }}" required>
                    </div>
                    <div class="form-group">
                        <label for="inpKontakVendor">Kontak Vendor/Pelaksana Pelatihan</label>
                        <input type="text" class="form-control" name="inpKontakVendor" id="inpKontakVendor" maxlength="50" value="{{ $dt_h->kontak_vendor }}" required>
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="inpTempat">Tempat Pelaksanaan</label>
                        <input type="text" name="inpTempat" id="inpTempat" class="form-control" maxlength="200" value="{{ $dt_h->tempat_pelaksanaan }}" required>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-6">Tanggal Pelaksanaan</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control dateRangePicker" name="inpTglPelaksanaan" id="inpTglPelaksanaan" value="{{ date('d/m/Y', strtotime($dt_h->tanggal_awal))." - ".date('d/m/Y', strtotime($dt_h->tanggal_sampai)) }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-6">Durasi</label>
                        <div class="col-sm-6">
                            <input type="text" name="inpDurasi" id="inpDurasi" class="form-control" maxlength="100" value="{{ $dt_h->durasi }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-6">Investasi/Biaya<p><code>Biaya Perorang</code></p></label>
                        <div class="col-sm-6">
                            <input type="text" name="inpBiaya" id="inpBiaya" class="form-control angka" value="{{ $dt_h->investasi_per_orang }}" style="text-align: right;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inpKompetensi">Kompetensi yang dipelajari</label>
                        <textarea name="inpKompetensi" id="inpKompetensi" class="form-control">{{ $dt_h->kompetensi }}</textarea>
                    </div>
                </div>
                <div class="col-sm-7 col-lg-7 border-left">
                    <ul class="list-group" style="margin-bottom: 15px">
                        <li class="list-group-item bg-primary active">Peserta Pelatihan</li>
                    </ul>
                    <div class="form-group row">
                        <div class="col-sm-12"><label for="pil_peserta">Pilih Peserta Pelatihan</label></div>
                        <div class="col-sm-10">

                            <select class="form-control select2" name="pil_peserta" id="pil_peserta" style="width: 100%;">
                                <option></option>
                                @foreach($all_karyawan as $peserta)
                                    <option value="{{ $peserta->id }}">{{ $peserta->nik." - ".$peserta->nm_lengkap }} - {{ $peserta->get_jabatan->nm_jabatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-primary" onclick="simpanPeserta(this)"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="iq-card-body" style="width:100%; height:auto">
                        <div class="row justify-content-center">
                            <div class="iq-card table-responsive" id="list_peserta"></div>
                            <div id="spinner-div-peserta" class="pt-5 justify-content-center spinner-div"><div class="spinner-border text-primary" role="status"></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup Form</button>
        <button type="submit" class="btn btn-primary" name="btn-submit" id="btn-submit">Simpan Pengajuan</button>
    </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#spinner-div-peserta').hide();
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $('.dateRangePicker').daterangepicker({
            "locale": {
                "format": 'DD/MM/YYYY'
            }
        });
        $(".angka").number(true, 0);
        $(".select2").select2({
            placeholder: "Pilih peserta pelatihan",
            allowClear: true
        });
        get_data();
    });
    function get_data()
    {
        $('#spinner-div-peserta').show();
        var id_data = $("#id_head").val();
        $("#list_peserta").load("{{ url('hrd/pelatihan/getListPeserta')}}/"+id_data, function(){
            $('#spinner-div-peserta').hide();
        });
    }
    var simpanPeserta = function(el)
    {
        var id_data = $("#id_head").val();
        var id_peserta = $("#pil_peserta").val();
        if(id_peserta=="")
        {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Anda belum memilih peserta!",
            });
        } else {
            Swal.fire({
            title: "Yakin peserta pelatihan akan disimpan ?",
            showCancelButton: true,
            confirmButtonText: "Simpan",
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        headers : {
                            'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
                        },
                        type: "POST",
                        url: "{{ url('hrd/pelatihan/storePeserta') }}",
                        data: {id_data:id_data, id_peserta: id_peserta},
                        dataType: 'json',
                        success: function(response)
                        {
                            if(response.success==true)
                            {
                                Swal.fire("Data berhasi disimpan!", "", "success");
                                get_data();
                            } else {
                                return false;
                            }
                        }
                    });
                }
            });
        }
    }
    var delete_item = function(el){
        Swal.fire({
        title: "Data akan dihapus?",
        text: "Yakin akan menghapus data peserta!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Hapus !"
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                headers : {
                    'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
                },
                type: "POST",
                url: "{{ url('hrd/pelatihan/deletePeserta') }}",
                data: {id_data:el.id},
                dataType: 'json',
                success: function(response)
                {
                    if(response.success==true)
                    {
                        $(el).parent().parent().slideUp(100,function(){
                            $(this).remove();
                        });
                        Swal.fire({
                        title: "Hapus Data!",
                        text: "Data peserta berhasil dihapus.",
                        icon: "success"
                        });
                        get_data();
                    } else {
                        return false;
                    }
                }
            });
        }
        });
    }
    function konfirm()
    {
        var psn = confirm("Yakin perubahan data akan disimpan ?");
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
</script>
