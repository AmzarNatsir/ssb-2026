<div class="col-lg-6">
    <div class="iq-card">
        <div class="iq-card-header d-flex justify-content-between">
            <div class="iq-header-title">
            <h4 class="card-title">Karyawan Yang Sedang Cuti</h4>
            </div>
        </div>
        <div class="iq-card-body">
            <table class="table" style="width:100%">
                <tbody>
                    @php($nom=1)
                    @foreach ($all_cuti_hari_ini as $cuti)
                    <tr>
                        <td style="width: 10%">
                            @if(!empty($cuti['profil_karyawan']['photo']))
                            <img src="{{ url(Storage::url('hrd/photo/'.$cuti['profil_karyawan']['photo'])) }}"
                                class="rounded-circle" alt="avatar" style="width: 80px; height: auto;">
                            @else
                            <a href="{{ asset('assets/images/user/1.jpg') }}" data-fancybox data-caption="avatar">
                            <img src="{{ asset('assets/images/user/1.jpg') }}"
                                class="rounded-circle" alt="avatar" style="width: 80px; height: auto;"></a>
                            @endif
                        </td>
                        <td>
                            <h4 class="mb-0">{{ $cuti['profil_karyawan']['nm_lengkap'] }}</h4>
                            <h6 class="mb-0">{{ $cuti['profil_karyawan']['get_jabatan']['nm_jabatan'] }} | {{ $cuti['profil_karyawan']['get_departemen']['nm_dept'] }}</h6>
                            <h6 class="mb-0"><span class="text-primary"><i class="fa fa-clock-o"></i> {{ date('d-m-Y', strtotime($cuti['tgl_awal'])) }} s/d {{ date('d-m-Y', strtotime($cuti['tgl_akhir'])) }}</span></h6>
                                <h6 class="mb-0"><span class="text-primary">Pengganti : {{ (empty($cuti['id_pengganti'])) ? "" : $cuti['get_karyawan_pengganti']['nm_lengkap'] }}</span></h6>
                            @if($cuti['perubahan']->count() > 0)
                            <hr>
                                @if($cuti['perubahan'][0]['sts_pengajuan']==1)
                                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Menunggu Persetujuan
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                <a class="dropdown-item" href="#"><i class="fa fa-user mr-1"></i>{{ $cuti['perubahan'][0]['get_current_approve']['nm_lengkap'] }}</a>
                                                <a class="dropdown-item" href="#"><i class="fa fa-user mr-1"></i>{{ $cuti['perubahan'][0]['get_current_approve']['get_jabatan']['nm_jabatan'] }}</a>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($cuti['perubahan'][0]['sts_pengajuan']==2)
                                    <span class="badge badge-success"><i class='fa fa-check-circle'></i> Status : Disetujui</span>
                                @else
                                    <span class="badge badge-danger"><i class='fa fa-close'></i> Status : Pengajuan Ditolak</span>
                                @endif
                            @endif
                        </td>
                        <td style="width: 10%; vertical-align: middle">
                            @if($cuti['perubahan']->count() == 0)
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Opsi
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                        <a class="dropdown-item" href="{{ url('hrd/pelaporan/cuti_izin/print_form_cuti', $cuti['id']) }}"><i class="fa fa-print mr-1"></i>Print Form Cuti</a>
                                        <a class="dropdown-item" href="{{ url('hrd/pelaporan/cuti_izin/print_surat_cuti', $cuti['id']) }}"><i class="fa fa-print mr-1"></i>Print Surat Cuti</a>
                                        <button type="button" class="dropdown-item" data-toggle="modal" data-target="#ModalForm" onclick="goFormPengajuan(this)" value="{{ $cuti['id'] }}"><i class="fa fa-exchange mr-1"></i>Ajukan Perubahan</button>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @php($nom++)
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="col-lg-6">
    <div class="iq-card">
        <div class="iq-card-header d-flex justify-content-between">
            <div class="iq-header-title">
            <h4 class="card-title">Karyawan Yang Sedang Izin</h4>
            </div>
        </div>
        <div class="iq-card-body">
            <table class="table" style="width:100%">
                <tbody>
                    @php($nom=1)
                    @foreach ($all_izin_hari_ini as $izin)
                    <tr>
                        <td style="width: 10%">
                            @if(!empty($izin->profil_karyawan->photo))
                            <img src="{{ url(Storage::url('hrd/photo/'.$izin->profil_karyawan->photo)) }}"
                                class="rounded-circle" alt="avatar"  style="width: 80px; height: auto;">
                            @else
                            <a href="{{ asset('assets/images/user/1.jpg') }}" data-fancybox data-caption="avatar">
                            <img src="{{ asset('assets/images/user/1.jpg') }}"
                                class="rounded-circle" alt="avatar" style="width: 80px; height: auto;"></a>
                            @endif
                        </td>
                        <td>
                            <h4 class="mb-0">{{ $izin->profil_karyawan->nm_lengkap }}</h4>
                            <h6 class="mb-0">{{ $izin->profil_karyawan->get_jabatan->nm_jabatan }} | {{ $izin->profil_karyawan->get_departemen->nm_dept }}</h6>
                            <h6 class="mb-0"><span class="text-primary"><i class="fa fa-clock-o"></i> {{ date('d-m-Y', strtotime($izin->tgl_awal)) }} s/d {{ date('d-m-Y', strtotime($izin->tgl_akhir)) }}</span></h6>
                            <h6 class="mb-0"><span class="text-primary">Keterangan : {{ $izin->get_jenis_izin->nm_jenis_ci }}</span></h6>
                        </td>
                    </tr>
                    @php($nom++)
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
