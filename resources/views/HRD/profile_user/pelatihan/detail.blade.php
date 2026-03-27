<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Detail Pelatihan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <div class="iq-card-body" style="width:100%; height:auto">
        <div class="iq-card iq-card-block iq-card-stretch">
            <div class="iq-card-body p-0">
                <div class="user-post-data p-3">
                    <div class="d-flex flex-wrap">
                       <div class="media-support-user-img mr-3">
                          <img class="img-fluid" src="{{ asset('assets/images/page-img/29.png') }}" alt="">
                       </div>
                       <div class="media-support-info mt-2">
                          <h5 class="mb-0"><a href="#" class="">{{ ($dt_h->kategori=='Internal') ? $dt_h->get_nama_pelatihan->nama_pelatihan : $dt_h->nama_pelatihan }}</a></h5>
                          <p class="mb-0 text-primary">{{ ($dt_h->kategori=='Internal') ? $dt_h->get_pelaksana->nama_lembaga : $dt_h->nama_vendor }}</p>
                       </div>
                    </div>
                </div>
            </div>
            <hr class="mt-0">
            <p class="p-3 mb-0">{{ $dt_h->kompetensi }}</p>
            <div class="comment-area p-3"><hr class="mt-0">
                <div class="row">
                    <div class="col-sm-12 col-lg-6">
                        <h6 class="mb-0"><i class="ri-star-s-fill text-dark"></i>Kategori : {{ $dt_h->kategori }}</h6>
                        <h6 class="mb-0"><i class="fa fa-clock-o"></i> Durasi : {{  $dt_h->durasi }}</h6>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <h6 class="mb-0"><i class="fa fa-calendar"></i>
                            @if($dt_h->tanggal_awal==$dt_h->tanggal_sampai)
                                {{ App\Helpers\Hrdhelper::get_hari($dt_h->tanggal_awal) }}
                            @else
                                {{ App\Helpers\Hrdhelper::get_hari_ini($dt_h->tanggal_awal). " - ".App\Helpers\Hrdhelper::get_hari_ini($dt_h->tanggal_sampai) }}
                            @endif,
                            {{ App\Helpers\Hrdhelper::get_tanggal_pelaksanaan($dt_h->tanggal_awal, $dt_h->tanggal_sampai, $dt_h->hari_awal, $dt_h->hari_sampai) }}</h6>
                        <h6 class="mb-0"><i class="fa fa-users"></i> Jumlah Peserta : {{  $dt_h->get_peserta()->get()->count() }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup Form</button>
    </div>
</div>
