<div class="col-lg-6">
    <div class="iq-card">
        <div class="iq-card-header d-flex justify-content-between">
            <div class="iq-header-title">
            <h4 class="card-title">Pengajuan Cuti</h4>
            </div>
        </div>
        <div class="iq-card-body">
            <table class="table" style="width:100%">
                <tbody>
                    @php($nom=1)
                    @foreach ($pengajuan_cuti as $cuti)
                    <tr>
                        <td style="width: 10%">
                            @if(!empty($cuti->profil_karyawan->photo))
                            <img src="{{ url(Storage::url('hrd/photo/'.$cuti->profil_karyawan->photo)) }}"
                                class="rounded-circle" alt="avatar" style="width: 80px; height: auto;">
                            @else
                            <a href="{{ asset('assets/images/user/1.jpg') }}" data-fancybox data-caption="avatar">
                            <img src="{{ asset('assets/images/user/1.jpg') }}"
                                class="rounded-circle" alt="avatar" style="width: 80px; height: auto;"></a>
                            @endif
                        </td>
                        <td style="width: 50%">
                            <h4 class="mb-0">{{ $cuti->profil_karyawan->nm_lengkap }}</h4>
                            <h6 class="mb-0">{{ (empty($cuti->profil_karyawan->get_jabatan->nm_jabatan)) ? "" : $cuti->profil_karyawan->get_jabatan->nm_jabatan }} | {{ (empty($cuti->profil_karyawan->get_departemen->nm_dept)) ? "" : $cuti->profil_karyawan->get_departemen->nm_dept }}</h6>
                            <h6 class="mb-0"><span class="text-primary"><i class="fa fa-clock-o"></i> {{ date('d-m-Y', strtotime($cuti->tgl_awal)) }} s/d {{ date('d-m-Y', strtotime($cuti->tgl_akhir)) }}</span></h6>
                                <h6 class="mb-0"><span class="text-primary">Pengganti : {{ (empty($cuti->id_pengganti)) ? "" : $cuti->get_karyawan_pengganti->nm_lengkap }}</span></h6>
                            @if(empty($cuti->sts_pengajuan))
                                @if(date("Y-m-d") > date_format(date_create($cuti->tgl_awal), 'Y-m-d'))
                                    <span class="badge badge-danger"><i class="fa fa-close"></i> Status : Expired</span>
                                @else
                                    <span class="badge badge-warning"><i class='fa fa-clock-o'></i> Status : Pengajuan</span>
                                @endif
                            @elseif($cuti->sts_pengajuan==1)
                                <span class="badge badge-pill badge-danger">Menunggu Persetujuan : {{ $cuti->get_current_approve->nm_lengkap }} - {{ (empty($cuti->get_current_approve->get_jabatan->nm_jabatan)) ? "" : $cuti->get_current_approve->get_jabatan->nm_jabatan }}</span>
                            @elseif($cuti->sts_pengajuan==2)
                                <span class="badge badge-success"><i class='fa fa-check-circle'></i> Status : Disetujui</span>
                            @else
                                <span class="badge badge-danger"><i class='fa fa-close'></i> Status : Pengajuan Ditolak</span>
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
            <h4 class="card-title">Pengajuan Izin</h4>
            </div>
        </div>
        <div class="iq-card-body">
            <table class="table" style="width:100%">
                <tbody>
                    @php($nom=1)
                    @foreach ($pengajuan_izin as $izin)
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
                            @if($izin->sts_pengajuan==1)
                                <span class="badge badge-pill badge-success">Menunggu Persetujuan : {{ $izin->get_current_approve->nm_lengkap }} - {{ $izin->get_current_approve->get_jabatan->nm_jabatan }}</span>
                            @elseif($izin->sts_pengajuan==2)
                                <span class="badge badge-success"><i class='fa fa-check-circle'></i> Status : Disetujui</span>
                            @else
                                <span class="badge badge-danger"><i class='fa fa-close'></i> Status : Pengajuan Ditolak</span>
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
