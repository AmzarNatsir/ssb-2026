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
