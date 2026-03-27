<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Detail Data Lembur</h5>
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
                                <td style="width: 15%">
                                    @if(!empty($profil->get_profil_karyawan->photo))
                                    <img src="{{ url(Storage::url('hrd/photo/'.$profil->get_profil_karyawan->photo)) }}"
                                        class="rounded-circle" alt="avatar"  style="width: 80px; height: auto;">
                                    @else
                                    <a href="{{ asset('assets/images/user/1.jpg') }}" data-fancybox data-caption="avatar">
                                    <img src="{{ asset('assets/images/user/1.jpg') }}"
                                        class="rounded-circle" alt="avatar" style="width: 80px; height: auto;"></a>
                                    @endif
                                </td>
                                <td>
                                    <h4 class="mb-0">{{ $profil->get_profil_karyawan->nik }}</h4>
                                    <h4 class="mb-0">{{ $profil->get_profil_karyawan->nm_lengkap }}</h4>
                                    <h6 class="mb-0">{{ $profil->get_profil_karyawan->get_jabatan->nm_jabatan }} | {{ $profil->get_profil_karyawan->get_departemen->nm_dept }}</h6>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="iq-card-header d-flex justify-content-between">
                   <div class="iq-header-title">
                      <h4 class="card-title">Data Pengajuan</h4>
                   </div>
                </div>
                <ul class="list-group">
                    <li class="list-group-item disabled" aria-disabled="true">Tanggal Pengajuan : <b>{{ date('d-m-Y', strtotime($profil->created_at)) }}</b></li>
                    <li class="list-group-item">Alasan Pengajuan : <b>{{ $profil->tgl_pengajuan }}</b></li>
                    <li class="list-group-item">Waktu : <b>{{ date('H:s', strtotime($profil->jam_mulai)) }} s/d {{ date('H:s', strtotime($profil->jam_selesai)) }}</b></li>
                    <li class="list-group-item">Total Jam : <b>{{ $profil->total_jam }} Jam</b></li>
                    <li class="list-group-item">Deskripsi Pekerjaan : <b>{{ $profil->deskripsi_pekerjaan }}</b></li>
                    <li class="list-group-item">Lampiran Surat Perintah Lembur :</li>
                </ul>
                <div class="iq-card-body">
                    <table class="table" style="width:100%">
                        <tbody>
                            <tr>
                                <td style="text-align: center">
                                    @if(!empty($profil->file_surat_perintah_lembur))
                                    <a href="{{ url(Storage::url('hrd/lembur/'.$profil->file_surat_perintah_lembur)) }}" data-fancybox data-caption="avatar">
                                    <img src="{{ url(Storage::url('hrd/lembur/'.$profil->file_surat_perintah_lembur)) }}"
                                       alt="avatar" style="width: 150px; height: auto;" class="img-fluid img-thumbnail"></a>
                                    @else
                                    <a href="{{ asset('assets/images/user/1.jpg') }}" data-fancybox data-caption="avatar">
                                    <img src="{{ asset('assets/images/user/1.jpg') }}"
                                        alt="avatar" style="width: 150px; height: auto;" class="img-fluid img-thumbnail"></a>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-6">
            <div class="iq-card iq-card-block iq-card-stretch">
                <div class="iq-card-body">
                    <ul class="list-group" style="margin-bottom: 15px">
                        <li class="list-group-item active">Hirarki Persetujuan</li>
                    </ul>
                    <div class="row align-items-center">
                        <table class="table" style="width: 100%; font-size: 10px">
                            <thead>
                            <tr>
                                <th rowspan="2" style="width: 5%">Level</th>
                                <th rowspan="2">Pejabat</th>
                                <th colspan="3" class="text-center">Persetujuan</th>
                            </tr>
                            <tr>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Keterangan</th>
                                <th class="text-center">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($hirarki_persetujuan as $list)
                                <tr>
                                    <td class="text-center">
                                        @if($list->approval_active==1)
                                        <h4><span class="badge badge-pill badge-success">{{ $list->approval_level }}</span></h4>
                                        @else
                                        <h4><span class="badge badge-pill badge-danger">{{ $list->approval_level }}</span></h4>
                                        @endif
                                    </td>
                                    <td>{{ $list->get_profil_employee->nm_lengkap }}<br>
                                        {{ $list->get_profil_employee->get_jabatan->nm_jabatan }}</td>
                                    <td>
                                        {{ (empty($list->approval_date)) ? "" : date('d-m-Y', strtotime($list->approval_date))  }}
                                    </td>
                                    <td>{{ $list->approval_remark }}</td>
                                    <td>
                                        @if($list->approval_status==1)
                                        <h4><span class="badge badge-pill badge-success">Approved</span></h4>
                                        @elseif($list->approval_status==2)
                                        <h4><span class="badge badge-pill badge-danger">Rejected</span></h4>
                                        @else

                                        @endif
                                        </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
