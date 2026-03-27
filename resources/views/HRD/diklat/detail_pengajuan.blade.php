<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Detail Pengajuan Pelatihan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <div class="iq-card-body" style="width:100%; height:auto">
        <div class="iq-card">
            <div class="row">
                <div class="col-sm-5 col-lg-6">
                    <ul class="list-group" style="margin-bottom: 15px">
                        <li class="list-group-item bg-primary active">Detail Pelatihan</li>
                    </ul>
                    <div class="form-group">
                        <label for="inpNamaPelatihan">Nama Pelatihan</label>
                        <input type="text" class="form-control" name="inpNamaPelatihan" id="inpNamaPelatihan" maxlength="200" value="{{ ($dt_h->kategori=='Internal') ? $dt_h->get_nama_pelatihan->nama_pelatihan : $dt_h->nama_pelatihan }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="inpNamaVendor">Nama Vendor/Pelaksana Pelatihan</label>
                        <input type="text" class="form-control" name="inpNamaVendor" id="inpNamaVendor" maxlength="200" value="{{ ($dt_h->kategori=='Internal') ? $dt_h->get_pelaksana->nama_lembaga : $dt_h->nama_vendor }}" disabled>
                    </div>
                    @if($dt_h->kategori=="Eksternal")
                    <div class="form-group">
                        <label for="inpKontakVendor">Kontak Vendor/Pelaksana Pelatihan</label>
                        <input type="text" class="form-control" name="inpKontakVendor" id="inpKontakVendor" maxlength="50" value="{{ $dt_h->kontak_vendor }}" disabled>
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="inpTempat">Tempat Pelaksanaan</label>
                        <input type="text" name="inpTempat" id="inpTempat" class="form-control" maxlength="200" value="{{ $dt_h->tempat_pelaksanaan }}" disabled>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-6">Tanggal Pelaksanaan</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control dateRangePicker" name="inpTglPelaksanaan" id="inpTglPelaksanaan" value="{{ date('d/m/Y', strtotime($dt_h->tanggal_awal))." - ".date('d/m/Y', strtotime($dt_h->tanggal_sampai)) }}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-6">Durasi</label>
                        <div class="col-sm-6">
                            <input type="text" name="inpDurasi" id="inpDurasi" class="form-control" maxlength="100" value="{{ $dt_h->durasi }}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-6">Investasi/Biaya<p><code>Biaya Perorang</code></p></label>
                        <div class="col-sm-6">
                            <input type="text" name="inpBiaya" id="inpBiaya" class="form-control angka" value="{{ $dt_h->investasi_per_orang }}" style="text-align: right;" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inpKompetensi">Kompetensi yang dipelajari</label>
                        <textarea name="inpKompetensi" id="inpKompetensi" class="form-control" disabled>{{ $dt_h->kompetensi }}</textarea>
                    </div>
                </div>
                <div class="col-sm-7 col-lg-6 border-left">
                    <ul class="list-group" style="margin-bottom: 15px">
                        <li class="list-group-item bg-primary active">Peserta Pelatihan</li>
                    </ul>
                    <div class="iq-card-body" style="width:100%; height:auto">
                        <div class="row">
                            <ul class="suggestions-lists m-0 p-0">
                                @php $nom=1 @endphp
                                {{-- {{ dd($list->getPelatihan->get_peserta) }} --}}
                                @foreach ($peserta as $peserta)
                                <li class="d-flex mb-4 align-items-center">
                                    <div class="user-img img-fluid">
                                        @if(!empty($peserta->get_karyawan->photo))
<a href="{{ url(Storage::url('hrd/photo/'.$peserta->get_karyawan->photo)) }}" data-fancybox data-caption='{{ $peserta->get_karyawan->nm_lengkap }}'><img class="rounded-circle img-fluid avatar-40" src="{{ url(Storage::url('hrd/photo/'.$peserta->get_karyawan->photo)) }}" alt="profile"></a>
@else
<a href="{{ asset('assets/images/no_image.png') }}" data-fancybox data-caption='{{ $peserta->get_karyawan->nm_lengkap }}'><img class="rounded-circle img-fluid avatar-40" src="{{ asset('assets/images/no_image.png') }}" alt="profile"></a>
@endif
                                    </div>
                                    <div class="media-support-info ml-3">
                                        <h6>{{ $peserta->get_karyawan->nik." - ".$peserta->get_karyawan->nm_lengkap }}</h6>
                                        <p>{{ (blank($peserta->get_karyawan->id_departemen)) ? "" : $peserta->get_karyawan->get_departemen->nm_dept }} - {{ (blank($peserta->get_karyawan->id_jabatan)) ? "" : $peserta->get_karyawan->get_jabatan->nm_jabatan }}</p>
                                    </div>
                                 </li>
                                 @php $nom++ @endphp
                                @endforeach
                              </ul>
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
