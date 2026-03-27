<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Detail Pengajuan Perubahan Status</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <div class="iq-card iq-card-block iq-card-stretch">
        <div class="iq-card-body">
            <div class="row">
                <div class="col-lg-6">
                    <table class="table" style="width:100%">
                        <tr>
                            <td style="width: 10%">
                                @if(!empty($data->get_profil->photo))
                                <img src="{{ url(Storage::url('hrd/photo/'.$data->get_profil->photo)) }}"
                                    class="rounded-circle" alt="avatar" style="width: 80px; height: auto;">
                                @else
                                <a href="{{ asset('assets/images/user/1.jpg') }}" data-fancybox data-caption="avatar">
                                <img src="{{ asset('assets/images/user/1.jpg') }}"
                                    class="rounded-circle" alt="avatar" style="width: 80px; height: auto;"></a>
                                @endif
                            </td>
                            <td style="width: 40%">
                                <h4 class="mb-0">{{ $data->get_profil->nm_lengkap }}</h4>
                                <h4 class="mb-0">{{ $data->get_profil->nik }}</h4>
                                <h6 class="mb-0">{{ (empty($data->get_profil->get_jabatan->nm_jabatan)) ? "" : $data->get_profil->get_jabatan->nm_jabatan }} | {{ $data->get_profil->get_departemen->nm_dept }}</h6>
                            </td>
                        </tr>
                    </table>
                    <ul class="list-group" style="margin-bottom: 15px">
                        <li class="list-group-item active">Status Karyawan Saat Ini</li>
                    </ul>
                    <div class="row">
                        <label class="col-sm-4">Status Karyawan</label>
                        <div class="col-sm-8">
                        <label id="sts_lama"><b>: {{ $data->get_profil->get_status_karyawan($data->get_profil->id_status_karyawan) }}</b></label>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-4">Tanggal Efektif</label>
                        <div class="col-sm-8">
                        <label id="tgl_eff_lama"><b>: {{ (empty($data->get_profil->tgl_sts_efektif_mulai)) ? "" : date_format(date_create($data->get_profil->tgl_sts_efektif_mulai), 'd-m-Y') }}</b></label>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-4">Tanggal Berakhir</label>
                        <div class="col-sm-8">
                        <label id="tgl_akh_lama"><b>: {{ (empty($data->get_profil->tgl_sts_efektif_akhir)) ? "" : date_format(date_create($data->get_profil->tgl_sts_efektif_akhir), 'd-m-Y') }}</b></label>
                        </div>
                    </div>
                    <ul class="list-group" style="margin-bottom: 15px">
                        <li class="list-group-item active">Data Pengajuan</li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item disabled" aria-disabled="true">Tanggal Pengajuan : {{ date_format(date_create($data->tgl_pengajuan), 'd-m-Y') }}</li>
                        <li class="list-group-item">Alasan Pengajuan : {{ $data->alasan_pengajuan }}</li>
                        <li class="list-group-item">Status Yang Diusulkan : {{ $data->get_status_karyawan($data->id_sts_baru) }}</li>
                        <li class="list-group-item">Diajukan Oleh : {{ $data->get_diajukan_oleh->karyawan->nm_lengkap }}<br>
                            {{ $data->get_diajukan_oleh->karyawan->get_jabatan->nm_jabatan }} - {{ $data->get_diajukan_oleh->karyawan->get_departemen->nm_dept }}
                        </li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <div class="iq-card-header d-flex">
                        <div class="iq-header-title">
                        <h4 class="card-title">Lampiran Hasil Evaluasi</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <table class="table" style="width: 100%;">
                            <tr>
                                <td>
                                    <a href="{{ url('hrd/perubahanstatus/download/hasil_evaluasi/'.$data->id) }}" target="_new" class="btn btn-danger btn-block"><i class="ri-download-line"></i> File Lampiran Hasil Evaluasi Kerja</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="iq-card-header d-flex">
                        <div class="iq-header-title">
                        <h4 class="card-title">Hirarki Persetujuan</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <table class="table" style="width: 100%; font-size: 12px">
                            <thead>
                            <tr>
                                <th rowspan="2" style="width: 5%">Level</th>
                                <th rowspan="2">Pejabat</th>
                                <th colspan="3" class="text-center">Persetujuan</th>
                            </tr>
                            <tr>
                                <th class="text-left">Tanggal</th>
                                <th class="text-left">Keterangan</th>
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
                                    <td class="text-center">
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
