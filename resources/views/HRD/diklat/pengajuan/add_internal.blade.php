<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Pengajuan Pelatihan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <div class="iq-card">
        <div class="col-md-12">
            <div class="iq-card-body">
                <input type="hidden" name="id_head" id="id_head" value="{{ $dt_h->id }}">
                <div class="bg-cobalt-blue p-3 rounded d-flex align-items-center justify-content-between mb-3">
                    <h5 class="text-white">{{ ($dt_h->kategori=="Internal") ? $dt_h->get_nama_pelatihan->nama_pelatihan : $dt_h->nama_pelatihan }}</h5>
                    <div class="rounded-circle iq-card-icon bg-white">
                        <i class="ri-quill-pen-line text-cobalt-blue"></i>
                    </div>
                </div>
                <h4 class="mb-3 border-bottom">{{ $dt_h->kompetensi}}</h4>
                <div class="row align-items-center justify-content-between mt-3">
                    <div class="col-sm-5">
                        <p class="mb-0">Vendor</p>
                        <h6>{{ ($dt_h->kategori=="Internal") ? $dt_h->get_pelaksana->nama_lembaga : $dt_h->nama_vendor }}</h6>
                    </div>
                    <div class="col-sm-2">
                        <p class="mb-0">Kategori</p>
                        <h5><div class="badge badge-pill {{ ($dt_h->kategori=='Internal') ? 'badge-danger' : 'badge-dark' }}">{{ $dt_h->kategori }}</div></h5>
                    </div>
                    <div class="col-sm-3">
                        <h6 class="mb-0"><i class="fa fa-calendar"></i> {{ App\Helpers\Hrdhelper::get_tanggal_pelaksanaan($dt_h->tanggal_awal, $dt_h->tanggal_sampai, NULL, NULL) }}</h6>
                        <h6 class="mb-0"><i class="fa fa-clock-o"></i> {{ $dt_h->durasi}}</h6>
                    </div>
                    <div class="col-sm-2">
                        <h6 class="mb-0"><i class="fa fa-user"></i> {{ $dt_h->get_peserta->count() }} <span>Peserta</span></h6>
                        <h6 class="mb-0">Rp. {{ number_format($dt_h->investasi_per_orang, 0) }}</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7" id="list_peserta">
                <div id="spinner-div-peserta" class="pt-5 justify-content-center spinner-div" style="text-align: center"><div class="spinner-border text-primary" role="status"></div></div>
            </div>
            <div class="col-sm-5" id="list_riwayat">
                <div id="spinner-div-riwayat" class="pt-5 justify-content-center spinner-div" style="text-align: center"><div class="spinner-border text-primary" role="status"></div></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup Form</button>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#spinner-div-peserta').hide();
        $('#spinner-div-riwayat').hide();
        get_data();
    });
    function get_data()
    {
        $('#spinner-div-peserta').show();
        var id_data = $("#id_head").val();
        $("#list_peserta").load("{{ url('hrd/pelatihan/getFormAddPeserta')}}/"+id_data, function(){
            $('#spinner-div-peserta').hide();
            $(".select2").select2({
                placeholder: "Pilih peserta pelatihan",
                allowClear: true
            });
        });
    }
    var getRiwayatPelatihan = function(el)
    {
        $('#spinner-div-riwayat').show();
        var id_data = $(el).val();
        $("#list_riwayat").load("{{ url('hrd/pelatihan/getRiwayatPelatihan')}}/"+id_data, function(){
            $('#spinner-div-riwayat').hide();
        });
    }
    var simpanPeserta = function(el)
    {
        var id_data = $("#id_head").val();
        var id_peserta = $("#pil_peserta_internal").val();
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
</script>
