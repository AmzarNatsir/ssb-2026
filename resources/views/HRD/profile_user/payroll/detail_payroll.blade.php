<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Detail Payroll</h5>
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
        @php
        $total_1 = $payroll->gaji_pokok + $payroll->tunj_perusahaan + $payroll->hours_meter + $payroll->lembur + $payroll->bonus;
        $total_bpjs = $payroll->bpjsks_karyawan + $payroll->bpjstk_jht_karyawan + $payroll->bpjstk_jp_karyawan
        @endphp
        <div class="iq-card">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <table width='100%' style='border-collapse:collapse; font-size:13px"'>
                        <tr>
                            <td style="text-align: center; font-size:15px"><b>DETAIL PAYROLL
                            <br>
                            PERIODE {{ \App\Helpers\Hrdhelper::get_nama_bulan($payroll->bulan) }} {{ $payroll->tahun }}</b></td>
                        </tr>
                    </table>
                    <table width='100%' style='border-collapse:collapse; font-size:13px"'>
                        <tr>
                            <td style="width:5%">NO</td>
                            <td style="width:70%">KETERANGAN</td>
                            <td style="width:25%; text-align:right">JUMLAH</td>
                        </tr>
                        <tr>
                            <td colspan="3"><hr style="border-collapse: collapse; border:solid;"></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Gaji Pokok</td>
                            <td style="text-align:right;"><b>{{ number_format($payroll->gaji_pokok, 0, ",", ".") }}</b></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Tunjangan Perusahaan</td>
                            <td style="text-align:right;"><b>{{ number_format($payroll->tunj_perusahaan, 0, ",", ".") }}</b></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Hours Meter</td>
                            <td style="text-align:right;"><b>{{ number_format($payroll->hours_meter, 0, ",", ".") }}</b></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Lembur</td>
                            <td style="text-align:right;"><b>{{ number_format($payroll->lembur, 0, ",", ".") }}</b></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Bonus</td>
                            <td style="text-align:right;"><b>{{ number_format($payroll->bonus, 0, ",", ".") }}</b></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="text-align:right;"><hr style="border-collapse: collapse; border:solid;"><b>{{ number_format($total_1, 0, ",", ".") }}</b></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="height:30px"></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>BPJS</td>
                            <td style="text-align:right;"><b>{{ number_format($total_bpjs, 0, ",", ".") }}</b></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Sedekah Bulanan</td>
                            <td style="text-align:right;"><b>{{ number_format($payroll->pot_sedekah, 0, ",", ".") }}</b></td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>PKK</td>
                            <td style="text-align:right;"><b>{{ number_format($payroll->pot_pkk, 0, ",", ".") }}</b></td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Air</td>
                            <td style="text-align:right;"><b>{{ number_format($payroll->pot_air, 0, ",", ".") }}</b></td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Rumah</td>
                            <td style="text-align:right;"><b>{{ number_format($payroll->pot_rumah, 0, ",", ".") }}</b></td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Toko Alif</td>
                            <td style="text-align:right;"><b>{{ number_format($payroll->pot_toko_alif, 0, ",", ".") }}</b></td>
                        </tr>
                        @php
                        $total_2=$total_bpjs + $payroll->pot_sedekah + $payroll->pot_pkk + $payroll->pot_air + $payroll->pot_rumah + $payroll->pot_toko_alif;
                        @endphp
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="text-align:right;"><hr style="border-collapse: collapse; border:solid;"><b>{{ number_format($total_2, 0, ",", ".") }}</b></td>
                        </tr>
                        <tr>
                            <td colspan="3"><hr style="border-collapse: collapse; border:solid;"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right"><b>TOTAL DITERIMA</b></td>
                            <td style="text-align:right;"><b>{{ number_format($total_1 - $total_2, 0, ",", ".") }}</b></td>
                        </tr>
                        <tr>
                            <td colspan="3"><hr style="border-collapse: collapse; border:solid;"></td>
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
