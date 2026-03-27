<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Detail Surat Peringatan</h5>
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
                       <h4 class="card-title">Data Pengajuan</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    <ul class="list-group">
                        <li class="list-group-item disabled" aria-disabled="true">Tanggal Pengajuan : <b>{{ date_format(date_create($profil->tgl_pengajuan), 'd-m-Y') }}</b></li>
                        <li class="list-group-item">Tingkatan Sanksi yang diajukan : <b>{{ $profil->get_master_jenis_sp_diajukan->nm_jenis_sp }}</b></li>
                        <li class="list-group-item">Uraian Pelanggaran : <b>{{ $profil->uraian_pelanggaran }}</b></li>
                     </ul>
                </div>
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                       <h4 class="card-title">Status Surat Peringatan</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    <ul class="list-group">
                        <li class="list-group-item disabled" aria-disabled="true">Status : <b>
                            @if($profil->profil_karyawan->sp_active=="active")
                            <span class="badge badge-pill badge-success">{{ $profil->profil_karyawan->sp_active }}</span>
                            @else
                            <span class="badge badge-pill badge-dark">{{ $profil->profil_karyawan->sp_active }}</span>
                            @endif
                            </b>
                        </li>
                        <li class="list-group-item">Masa Berlaku : <b>{{ date('d-m-Y', strtotime($profil->profil_karyawan->sp_mulai_active)) }} s/d {{ date('d-m-Y', strtotime($profil->profil_karyawan->sp_akhir_active)) }}</b></li>
                     </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-6">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                       <h4 class="card-title">Hirarki Persetujuan</h4>
                    </div>
                </div>
                <div class="iq-card-body">
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
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
