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
                    <table class="table" style="width: 100%">
                        <tr>
                            <td>NIK</td>
                            <td>Nama Peserta</td>
                            <td></td>
                        </tr>
                        @foreach ($dt_d as $detail)
                        <tr>
                            <td>{{ $detail->get_karyawan->nik }}</td>
                            <td>{{ $detail->get_karyawan->nm_lengkap }}</td>
                            <td>
                                @if($detail['pasca']==1)
                                <button type="button" class="btn btn-success" name="btn_detail[]" onclick="goDetailLaporan(this)" value="{{ $detail->id }}"><i class="fa fa-check"></i></button>
                                @else
                                <button type="button" class="btn btn-danger" name="btn_detail[]" onclick="goDetailLaporan(this)" value="{{ $detail->id }}"><i class="fa fa-times"></i></button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="col-sm-12 col-lg-7">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                           <h4 class="card-title">Laporan kegiatan pasca pelatihan</h4>
                        </div>
                    </div>
                    <div class="iq-card-body detail_pasca_tranining" ></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup Form</button>
    </div>
</div>
<script type="text/javascript">
    var goDetailLaporan = function(el)
    {
        var id_data = $(el).val();
        $(".detail_pasca_tranining").load("{{ url('hrd/pelatihan/detailPascaPelatihan') }}/"+id_data);
    }
</script>
