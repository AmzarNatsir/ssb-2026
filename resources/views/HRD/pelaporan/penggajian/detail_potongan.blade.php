<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Detail Potongan Gaji Karyawan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
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
                        <li class="list-group-item active">Daftar Potongan Gaji Karyawan</li>
                    </ul>
                    <table class="table" style="width: 100%">
                        <tr>
                            <td style="width: 50%">BPJS Kesehatan</td>
                            <td style="text-align: right">{{ (empty($payroll->bpjsks_karyawan)) ? 0 : number_format($payroll->bpjsks_karyawan, 0) }}</td>
                        </tr>
                        <tr>
                            <td>JHT</td>
                            <td style="text-align: right">{{ (empty($payroll->bpjstk_jht_karyawan)) ? 0 : number_format($payroll->bpjstk_jht_karyawan, 0) }}</td>
                        </tr>
                        <tr>
                            <td>JP</td>
                            <td style="text-align: right">{{ (empty($payroll->bpjstk_jp_karyawan)) ? 0 : number_format($payroll->bpjstk_jp_karyawan, 0) }}</td>
                        </tr>
                        <tr>
                            <td>Sedekah Bulanan</td>
                            <td style="text-align: right">{{ (empty($payroll->pot_sedekah)) ? 0 : number_format($payroll->pot_sedekah, 0) }}</td>
                        </tr>
                        <tr>
                            <td>PKK</td>
                            <td style="text-align: right">{{ (empty($payroll->pot_pkk)) ? 0 : number_format($payroll->pot_pkk, 0) }}</td>
                        </tr>
                        <tr>
                            <td>Air</td>
                            <td style="text-align: right">{{ (empty($payroll->pot_air)) ? 0 : number_format($payroll->pot_air, 0) }}</td>
                        </tr>
                        <tr>
                            <td>Rumah</td>
                            <td style="text-align: right">{{ (empty($payroll->pot_rumah)) ? 0 : number_format($payroll->pot_rumah, 0) }}</td>
                        </tr>
                        <tr>
                            <td>Toko Alif</td>
                            <td style="text-align: right">{{ (empty($payroll->pot_toko_alif)) ? 0 : number_format($payroll->pot_toko_alif, 0) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup Form</button>
</div>
