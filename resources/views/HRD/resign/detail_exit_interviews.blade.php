<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Detail Form Exit Interviews</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12 col-lg-6">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                       <h4 class="card-title">Profil Karyawan</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    <table class="table" style="width:100%">
                        <tbody>
                            <tr>
                                <td style="width: 10%">
                                    @if(!empty($profil->getPengajuan->getKaryawan->photo))
                                        <a href="{{ url(Storage::url('hrd/photo/'.$profil->getPengajuan->getKaryawan->photo)) }}" data-fancybox data-caption="avatar">
                                        <img src="{{ url(Storage::url('hrd/photo/'.$profil->getPengajuan->getKaryawan->photo)) }}"
                                        class="rounded-circle" alt="avatar"  style="width: 80px; height: auto;"></a>
                                    @else
                                        <a href="{{ asset('assets/images/user/1.jpg') }}" data-fancybox data-caption="avatar">
                                        <img src="{{ asset('assets/images/user/1.jpg') }}"
                                        class="rounded-circle" alt="avatar" style="width: 80px; height: auto;"></a>
                                    @endif
                                </td>
                                <td>
                                    <h4 class="mb-0">{{ $profil->getPengajuan->getKaryawan->nik }}</h4>
                                    <h4 class="mb-0">{{ $profil->getPengajuan->getKaryawan->nm_lengkap }}</h4>
                                    <h6 class="mb-0">{{ $profil->getPengajuan->getKaryawan->get_jabatan->nm_jabatan }} | {{ $profil->getPengajuan->getKaryawan->get_departemen->nm_dept }}</h6>
                                    <p style="font-size: 12px" class="mb-0 badge badge-success">Tanggal masuk : {{ (empty($profil->getPengajuan->getKaryawan->tgl_masuk)) ? "" : date('d-m-Y', strtotime($profil->getPengajuan->getKaryawan->tgl_masuk)) }}</p>
                                    <p style="font-size: 12px" class="mb-0 badge badge-danger">Lama bekerja : {{ (empty($profil->getPengajuan->getKaryawan->tgl_masuk)) ? "" : App\Helpers\Hrdhelper::get_lama_kerja_karyawan($profil->getPengajuan->getKaryawan->tgl_masuk) }}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-6">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                    <h4 class="card-title">Data Pengajuan Resign</h4>
                    </div>
                </div>
                <ul class="list-group">
                    <li class="list-group-item disabled" aria-disabled="true">Tanggal Pengajuan : <b><p style="font_size: 12px" class="badge badge-primary">{{ date('d-m-Y', strtotime($profil->getPengajuan->created_at)) }}</p></b></li>
                    <li class="list-group-item">Alasan Pengajuan : <br><b>{{ $profil->getPengajuan->alasan_resign }}</b></li>
                    <li class="list-group-item">Rencana Efektif Resign Tanggal : <b><p style="font_size: 12px" class="badge badge-danger">{{ date_format(date_create($profil->getPengajuan->tgl_eff_resign), 'd-m-Y') }}</p></b></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                       <h4 class="card-title">Form Exit Interviews</h4>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card iq-mb-0 border-primary" >
                        <div class="card-body text-primary">
                            <h4 class="card-title text-primary">1. Apa yang menjadi alasan anda mengundurkan diri dari PT. SSB</h4>
                            <textarea class="form-control" name="inp_jawaban_1" id="inp_jawaban_1" disabled>{{ $profil->jawaban_1 }}</textarea>
                            <div class="iq-card-body" style="width:100%; height:auto">
                                <p>* Jika pindah ke perusahaan lain, silahkan isi informasi berikut:</p>
                                <div class="form-group row">
                                    <label class="col-lg-4">Nama Perusahaan</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" name="inp_jawaban_1_1" id="inp_jawaban_1_1" value="{{ $profil->jawaban_1_1 }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4">Posisi yang ditawarkan</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" name="inp_jawaban_1_2" id="inp_jawaban_1_2" value="{{ $profil->jawaban_1_2 }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4">Gaji yang ditawarkan</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control angka" name="inp_jawaban_1_3" id="inp_jawaban_1_3" value="{{ $profil->jawaban_1_3 }}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>
                </div>
                <div class="col-lg-12">
                    <div class="card iq-mb-0 border-primary" >
                        <div class="card-body text-primary">
                            <h4 class="card-title text-primary">2. Apa yang membuat anda mempertimbangkan keputusan anda untuk mengundurkan diri ?</h4>
                            <textarea class="form-control" name="inp_jawaban_2" id="inp_jawaban_2" disabled>{{ $profil->jawaban_2 }}</textarea>
                        </div>
                     </div>
                </div>
                <div class="col-lg-12">
                    <div class="card iq-mb-0 border-primary" >
                        <div class="card-body text-primary">
                            <h4 class="card-title text-primary">3. Adakah hal-hal yang tidak sesuai dengan keinginan anda selama anda bekerjadi PT SSB ?</h4>
                            <textarea class="form-control" name="inp_jawaban_3" id="inp_jawaban_3" disabled>{{ $profil->jawaban_3 }}</textarea>
                        </div>
                     </div>
                </div>
                <div class="col-lg-12">
                    <div class="card iq-mb-0 border-primary" >
                        <div class="card-body text-primary">
                            <h4 class="card-title text-primary">4. Apakah menurut anda upah yang diterima dari perusahaan ini sesuai dengan kemampuan dan posisi anda ?</h4>
                            <textarea class="form-control" name="inp_jawaban_4" id="inp_jawaban_4" disabled>{{ $profil->jawaban_4 }}</textarea>
                        </div>
                     </div>
                </div>
                <div class="col-lg-12">
                    <div class="card iq-mb-0 border-primary" >
                        <div class="card-body text-primary">
                            <h4 class="card-title text-primary">5. Apakah menurut anda fasilitas yang diberikan oleh perusahaan kepada karyawan sudah cukup? Kalau tidak, silahkan berikan alasan. </h4>
                            <textarea class="form-control" name="inp_jawaban_5" id="inp_jawaban_5" disabled>{{ $profil->jawaban_5 }}</textarea>
                        </div>
                     </div>
                </div>
                <div class="col-lg-12">
                    <div class="card iq-mb-0 border-primary" >
                        <div class="card-body text-primary">
                            <h4 class="card-title text-primary">6. Apa yang paling anda sukai dari pekerjaan andadi PT SSB ?</h4>
                            <textarea class="form-control" name="inp_jawaban_6" id="inp_jawaban_6" disabled>{{ $profil->jawaban_6 }}</textarea>
                            <div class="iq-card-body" style="width:100%; height:auto">
                                <p>* Berikut ringkasan karir anda di PT SSB, silahkan isi informasi berikut :</p>
                                <div class="form-group row">
                                    <label class="col-lg-4">Posisi awal bergabung</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" name="inp_jawaban_6_1" id="inp_jawaban_6_1" value="{{ $profil->jawaban_6_1 }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4">Posisi terakhir</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" name="inp_jawaban_6_2" id="inp_jawaban_6_2" value="{{ $profil->jawaban_6_2 }}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>
                </div>
                <div class="col-lg-12">
                    <div class="card iq-mb-0 border-primary" >
                        <div class="card-body text-primary">
                            <h4 class="card-title text-primary">7. Menurut anda, apakah tugas & tanggung jawab pekerjaan anda sudah jelas selama di PT SSB ?</h4>
                            <textarea class="form-control" name="inp_jawaban_7" id="inp_jawaban_7" disabled>{{ $profil->jawaban_7 }}</textarea>
                        </div>
                     </div>
                </div>
                <div class="col-lg-12">
                    <div class="card iq-mb-0 border-primary" >
                        <div class="card-body text-primary">
                            <h4 class="card-title text-primary">8. Bagaimana anda menilai atasan langsung anda ?</h4>
                            <div class="iq-card-body" style="width:100%; height:auto">
                                <div class="form-group">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="checkBagus" name="pilihan_8" value="Bagus" {{ ($profil->jawaban_8=="Bagus") ? "checked" : "" }} disabled>
                                        <label class="custom-control-label" for="checkBagus">Bagus</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="checkCukup" name="pilihan_8" value="Cukup" {{ ($profil->jawaban_8=="Cukup") ? "checked" : "" }} disabled>
                                        <label class="custom-control-label" for="checkCukup">Cukup</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="checkKurang" name="pilihan_8" value="Kurang" {{ ($profil->jawaban_8=="Kurang") ? "checked" : "" }} disabled>
                                        <label class="custom-control-label" for="checkKurang">Kurang</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2">Alasan :</label>
                                    <div class="col-lg-10">
                                        <textarea class="form-control" name="inp_jawaban_8_1" id="inp_jawaban_8_1" disabled>{{ $profil->jawaban_8_1 }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>
                </div>
                <div class="col-lg-12">
                    <div class="card iq-mb-0 border-primary" >
                        <div class="card-body text-primary">
                            <h4 class="card-title text-primary">9. Menurut anda perbaikan apakah yang harus dilakukan oleh manajemen di PT. SSB agar perusahaan semakin baik, dilihat dari posisi anda sebagai karyawan ?</h4>
                            <div class="iq-card-body" style="width:100%; height:auto">
                                <textarea class="form-control" name="inp_jawaban_9" id="inp_jawaban_9" disabled>{{ $profil->jawaban_9 }}</textarea>
                                <p>* Silahkan berikan skala penilaian 1 s/d 4 dari  dibawah ini ( skala 4 adalah nilai yang
                                    paling baik ) </p>
                                <div class="iq-card-body" style="width:100%; height:auto">
                                    <div class="form-group row">
                                        <label class="col-lg-4">1. Kenyamanan kerja</label>
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_1_1" name="pilihan_9_1" value="1" {{ ($profil->jawaban_9_1==1) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_1_1">1</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_1_2" name="pilihan_9_1" value="2" {{ ($profil->jawaban_9_1==2) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_1_2">2</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_1_3" name="pilihan_9_1" value="3" {{ ($profil->jawaban_9_1==3) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_1_3">3</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_1_4" name="pilihan_9_1" value="4" {{ ($profil->jawaban_9_1==4) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_1_4">4</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4">2. Beban kerja</label>
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_2_1" name="pilihan_9_2" value="1" {{ ($profil->jawaban_9_2==1) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_2_1">1</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_2_2" name="pilihan_9_2" value="2" {{ ($profil->jawaban_9_2==2) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_2_2">2</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_2_3" name="pilihan_9_2" value="3" {{ ($profil->jawaban_9_2==3) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_2_3">3</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_2_4" name="pilihan_9_2" value="4" {{ ($profil->jawaban_9_2==4) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_2_4">4</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4">3. Gaji & Tunjangan </label>
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_3_1" name="pilihan_9_3" value="1" {{ ($profil->jawaban_9_3==1) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_3_1">1</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_3_2" name="pilihan_9_3" value="2" {{ ($profil->jawaban_9_3==2) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_3_2">2</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_3_3" name="pilihan_9_3" value="3" {{ ($profil->jawaban_9_3==3) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_3_3">3</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_3_4" name="pilihan_9_3" value="4" {{ ($profil->jawaban_9_3==4) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_3_4">4</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4">4. Kesempatan berkembang</label>
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_4_1" name="pilihan_9_4" value="1" {{ ($profil->jawaban_9_4==1) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_4_1">1</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_4_2" name="pilihan_9_4" value="2" {{ ($profil->jawaban_9_4==2) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_4_2">2</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_4_3" name="pilihan_9_4" value="3" {{ ($profil->jawaban_9_4==3) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_4_3">3</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_4_4" name="pilihan_9_4" value="4" {{ ($profil->jawaban_9_4==4) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_4_4">4</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4">5. Efektivitas organisasi</label>
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_5_1" name="pilihan_9_5" value="1" {{ ($profil->jawaban_9_5==1) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_5_1">1</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_5_2" name="pilihan_9_5" value="2" {{ ($profil->jawaban_9_5==2) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_5_2">2</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_5_3" name="pilihan_9_5" value="3" {{ ($profil->jawaban_9_5==3) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_5_3">3</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_5_4" name="pilihan_9_5" value="4" {{ ($profil->jawaban_9_5==4) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_5_4">4</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4">6. Kelebihan Asuransi</label>
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_6_1" name="pilihan_9_6" value="1" {{ ($profil->jawaban_9_6==1) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_6_1">1</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_6_2" name="pilihan_9_6" value="2" {{ ($profil->jawaban_9_6==2) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_6_2">2</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_6_3" name="pilihan_9_6" value="3" {{ ($profil->jawaban_9_6==3) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_6_3">3</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_6_4" name="pilihan_9_6" value="4" {{ ($profil->jawaban_9_6==4) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_6_4">4</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4">7. Perhatian Manajemen</label>
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_7_1" name="pilihan_9_7" value="1" {{ ($profil->jawaban_9_7==1) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_7_1">1</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_7_2" name="pilihan_9_7" value="2" {{ ($profil->jawaban_9_7==2) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_7_2">2</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_7_3" name="pilihan_9_7" value="3" {{ ($profil->jawaban_9_7==3) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_7_3">3</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_7_4" name="pilihan_9_7" value="4" {{ ($profil->jawaban_9_7==4) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_7_4">4</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4">8. Lingkungan Kerja</label>
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_8_1" name="pilihan_9_8" value="1" {{ ($profil->jawaban_9_8==1) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_8_1">1</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_8_2" name="pilihan_9_8" value="2" {{ ($profil->jawaban_9_8==2) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_8_2">2</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_8_3" name="pilihan_9_8" value="3" {{ ($profil->jawaban_9_8==3) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_8_3">3</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_8_4" name="pilihan_9_8" value="4" {{ ($profil->jawaban_9_8==4) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_8_4">4</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4">9. Kualitas pelatihan</label>
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_9_1" name="pilihan_9_9" value="1" {{ ($profil->jawaban_9_9==1) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_9_1">1</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_9_2" name="pilihan_9_9" value="2" {{ ($profil->jawaban_9_9==2) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_9_2">2</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_9_3" name="pilihan_9_9" value="3" {{ ($profil->jawaban_9_9==3) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_9_3">3</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" id="check_9_4" name="pilihan_9_9" value="4" {{ ($profil->jawaban_9_9==4) ? "checked" : "" }} disabled>
                                                    <label class="custom-control-label" for="check_9_4">4</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>
                </div>
                <div class="col-lg-12">
                    <div class="card iq-mb-0 border-primary" >
                        <div class="card-body text-primary">
                            <h4 class="card-title text-primary">10. Berikan komentar anda selain yang sudah dituliskan diatas sebagai masukan perusahaan.</h4>
                            <textarea class="form-control" name="inp_jawaban_10" id="inp_jawaban_10" disabled>{{ $profil->jawaban_10 }}</textarea>
                        </div>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
