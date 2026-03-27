<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
    <div class="iq-card-body" style="width:100%; height:auto">
        <ul class="list-group" style="margin-bottom: 15px">
            <li class="list-group-item bg-primary active">Riwayat Pelatihan Karyawan</li>
        </ul>
    </div>
    <div class="iq-card-body" style="width:100%; height:auto">
        <ul class="iq-timeline">
            @foreach($history as $list)
            <li>
            <div class="timeline-dots"></div>
            <h6 class="float-left mb-1">{{ ($list->kategori=="Internal") ? $list->nama_pelatihan_internal : $list->nama_pelatihan }}</h6>
            <small class="float-right mt-1">{{ App\Helpers\Hrdhelper::get_tanggal_pelaksanaan($list->tanggal_awal, $list->tanggal_sampai, NULL, NULL) }}</small>
            <div class="d-inline-block w-100">
                <p>{{ $list->kompetensi }}</p>
            </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>
