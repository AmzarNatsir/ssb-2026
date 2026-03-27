<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Detail Laporan Kegiatan Pasca Pelatihan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <div class="iq-card-body" style="width:100%; height:auto">
        <div class="row">
            <div class="col-sm-12 col-lg-5">
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
                    <div class="comment-area p-3">
                        <hr class="mt-0">
                        <h6 class="mb-0"><i class="ri-star-s-fill text-dark"></i>Kategori : {{ $dt_h->kategori }}</h6>
                        <h6 class="mb-0"><i class="fa fa-clock-o"></i> Durasi : {{  $dt_h->durasi }}</h6>
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
            <div class="col-sm-12 col-lg-7">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                           <h4 class="card-title">Laporan kegiatan pasca pelatihan</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                   <h5 class="mb-1">Tujuan pelatihan :</h5>
                                </div>
                                <p class="mb-1">{{ $dt_d->tujuan_pelatihan_pasca }}</p>
                             </a>
                             <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                   <h5 class="mb-1">Uraian materi :</h5>
                                </div>
                                <p class="mb-1">{{ $dt_d->uraian_materi_pasca }}</p>
                             </a>
                             <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                   <h5 class="mb-1">Tindak lanjut setelah pelatihan :</h5>
                                </div>
                                <p class="mb-1">{{ $dt_d->tindak_lanjut_pasca }}</p>
                             </a>
                             <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                   <h5 class="mb-1">Dampak setelah mengikuti pelatihan :</h5>
                                </div>
                                <p class="mb-1">{{ $dt_d->dampak_pasca }}</p>
                             </a>
                             <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                   <h5 class="mb-1">Penutup/Harapan :</h5>
                                </div>
                                <p class="mb-1">{{ $dt_d->penutup_pasca }}</p>
                             </a>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="inp_file">Evidence</label>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                @if(!empty($dt_d->evidence_pasca))
                                    <a href="{{ url(Storage::url('hrd/evidence_pelatihan/'.$dt_d->evidence_pasca)) }}" data-fancybox data-caption="evidance">
                                    <img src="{{ url(Storage::url('hrd/evidence_pelatihan/'.$dt_d->evidence_pasca)) }}"
                                       alt="evidance" style="width: 150px; height: auto;" class="img-fluid img-thumbnail"></a>
                                @else
                                    <a href="{{ asset('assets/images/user/1.jpg') }}" data-fancybox data-caption="evidance">
                                    <img src="{{ asset('assets/images/user/1.jpg') }}"
                                        alt="evidance" style="width: 150px; height: auto;" class="img-fluid img-thumbnail"></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup Form</button>
    </div>
</div>
