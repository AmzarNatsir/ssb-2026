<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Pengaturan Tunjangan Karyawan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<form action="{{ url('hrd/penggajian/simpanPenggajianTunjangan') }}" method="post" onsubmit="return konfirm()" id="form_tunjangan">
{{ csrf_field() }}
<input type="hidden" name="id_karyawan" id="id_karyawan" value="{{ $profil->id }}">
<input type="hidden" name="id_departemen" id="id_departemen" value="{{ (empty($profil->id_departemen)) ? 0 : $profil->id_departemen }}">
<input type="hidden" name="periode_bulan" id="periode_bulan" value="{{ $bulan }}">
<input type="hidden" name="periode_tahun" id="periode_tahun" value="{{ $tahun }}">
<input type="hidden" name="gaji_pokok" id="gaji_pokok" value="{{ $profil->gaji_pokok }}">
<input type="hidden" name="gaji_bpjs" id="gaji_bpjs" value="{{ $profil->gaji_bpjs }}">
<input type="hidden" name="gaji_jamsostek" id="gaji_jamsostek" value="{{ $profil->gaji_jamsostek }}">
<div class="modal-body" style="height: 500px">
    <div class="iq-card-body p-0">
        <div class="iq-card">
            <div class="user-post-data p-3">
                <div class="d-flex flex-wrap">
                    <div class="media-sellers">
                        <div class="media-sellers-img">
                        @if(!empty($profil->photo))
                            <a href="{{ url(Storage::url('hrd/photo/'.$profil->photo)) }}" data-fancybox data-caption='{{ $profil->nm_lengkap }}'><img class="mr-3 rounded" src="{{ url(Storage::url('hrd/photo/'.$profil->photo)) }}" alt="profile"></a>
                        @else
                            <a href="{{ asset('assets/images/no_image.png') }}" data-fancybox data-caption='{{ $profil->nm_lengkap }}'><img class="mr-3 rounded" src="{{ asset('assets/images/no_image.png') }}" alt="profile"></a>
                        @endif
                        </div>
                        <div class="media-sellers-media-info">
                            <h5 class="mb-0"><a class="text-dark" href="#">{{ $profil->nik }} - {{ $profil->nm_lengkap }}</a></h5>
                            <p class="mb-1">{{ $profil->get_jabatan->nm_jabatan }}</p>
                            <div class="sellers-dt">
                                @php if($profil->id_status_karyawan==1)
                                {
                                    $badge_thema = 'badge iq-bg-info';
                                } elseif($profil->id_status_karyawan==2) {
                                    $badge_thema = 'badge iq-bg-primary';
                                } elseif($profil->id_status_karyawan==3) {
                                    $badge_thema = 'badge iq-bg-success';
                                } elseif($profil->id_status_karyawan==7) {
                                    $badge_thema = 'badge iq-bg-warning';
                                } else {
                                    $badge_thema = 'badge iq-bg-danger';
                                }
                                @endphp
                                <span class="font-size-12">Status: <a href="#"> <span class="{{ $badge_thema }}">{{ $profil->get_status_karyawan($profil->id_status_karyawan) }}</span></a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="iq-card">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <ul class="list-group">
                        <li class="list-group-item active">Tunjangan Karyawan Periode {{ $ket_periode }}</li>
                    </ul>
                    <div class="row">
                        <div class="col-sm-12 col-lg-4">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <div class="form-group row">
                                        <label class="col-sm-6">BPJS Kesehatan</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control angka" name="inpTunjBpjsKesehatan" id="inpTunjBpjsKesehatan" style="text-align: right" value="{{ $bpjsks_perusahaan }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-6">Jaminan Hari Tua (JHT)</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control angka" name="inpTunjJht" id="inpTunjJht" style="text-align: right" value="{{ $bpjstk_jht_perusahaan }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-6">Jaminan Kecelakaan Kerja (JKK)</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control angka" name="inpTunjJkk" id="inpTunjJkk" style="text-align: right" value="{{ $bpjstk_jkk_perusahaan }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-6">Jaminan Pensiun (JP)</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control angka" name="inpTunjJp" id="inpTunjJp" style="text-align: right" value="{{ $bpjstk_jp_perusahaan }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-6">Jaminan Kematian (JKM)</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control angka" name="inpTunjJKM" id="inpTunjJKM" style="text-align: right" value="{{ $bpjstk_jkm_perusahaan }}" readonly>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <div class="form-group row">
                                        <label class="col-sm-6">Tunjangan Tetap</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control angka" name="inpTunjTetap" id="inpTunjTetap" style="text-align: right; background: white; border: 1px solid" value="{{ $tunj_tetap }}" onblur="handleNull(this)" oninput="getTotalTunjangan(this); ">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-6">Hours Meter</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control angka" name="inpTunjHoursMeter" id="inpTunjHoursMeter" style="text-align: right; background: white; border: 1px solid" value="{{ $hours_meter }}" onblur="getTotalTunjangan(this); handleNull(this)">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-6">Lembur</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control angka" name="inpTunjLembur" id="inpTunjLembur" style="text-align: right; background: white; border: 1px solid" value="{{ $lembur }}" onblur="getTotalTunjangan(this); handleNull(this)">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-6">Bonus</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control angka" name="inpTunjBonus" id="inpTunjBonus" style="text-align: right; background: white; border: 1px solid" value="{{ $bonus }}" onblur="getTotalTunjangan(this); handleNull(this)">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <div class="form-group row">
                                        <label class="col-sm-6">Total Tunj. Perusahaan (BPJS)</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control angka" name="inpTunjPerusahaanBPJS" id="inpTunjPerusahaanBPJS" style="text-align: right" value="{{ $tunj_perusahaan_bpjs }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-6">Total Tunjangan</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control angka" name="inpTotalTunjangan" id="inpTotalTunjangan" style="text-align: right" value="{{ $total_tunjangan }}" readonly>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup Form</button>
    <button type="submit" class="btn btn-primary" name="btn-submit" id="btn-submit">Simpan Data</button>
</div>
</form>
<script>
    var handleNull = function(el) {
        if ($(el).val() == '') {
            $(el).val(0);
        }
        $("#inpTotalTunjangan").val(TotalTunjangan());
    }
    var getTotalTunjangan = function(el) {
        $("#inpTotalTunjangan").val(TotalTunjangan());
    }
    function TotalTunjangan() {
            var tunjangan_perusahaan = parseFloat($('#inpTunjPerusahaanBPJS').val());
            var tunjangan_tetap = parseFloat($('#inpTunjTetap').val());
            var tunjangan_hm = parseFloat($('#inpTunjHoursMeter').val());
            var tunjangan_lembur = parseFloat($('#inpTunjLembur').val());
            var tunjangan_bonus = parseFloat($('#inpTunjBonus').val());
            var total_tunjangan = parseFloat(tunjangan_perusahaan) + parseFloat(tunjangan_tetap) + parseFloat(tunjangan_hm) + parseFloat(tunjangan_lembur) + parseFloat(tunjangan_bonus);
            // alert(tunjangan_perusahaan);
            return total_tunjangan;
        }
</script>
