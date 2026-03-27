<div class="col-sm-12 col-lg-12">
    <div class="iq-card">
        <div class="iq-card-header d-flex justify-content-between">
            <div class="iq-header-title">
               <h4 class="card-title">Daftar Form Exit Interviews</h4>
            </div>
         </div>
        <div class="iq-card-body" style="width:100%; height:auto">
            <table class="table table-striped table-bordered" style="width: 100%; font-size:13px">
                <thead class="thead-light">
                    <tr>
                        <th rowspan="2" style="width: 5%; text-align:center; vertical-align: middle">No</th>
                        <th rowspan="2" colspan="2" style="text-align:center; vertical-align: middle">Karyawan</th>
                        <th colspan="3" class="text-center">Pengajuan Resign</th>
                        <th colspan="2" style="width: 15%">Pengajuan Exit Interviews</th>
                        <th rowspan="2" style="width: 10%; text-align:center; vertical-align: middle">Act</th>
                    </tr>
                    <tr>
                        <th style="width: 5%; text-align: center">Tanggal</th>
                        <th style="width: 10%; text-align: center">Status</th>
                        <th style="width: 5%; text-align: center">Efektif&nbsp;Resign</th>
                        <th style="width: 5%; text-align: center">Tanggal</th>
                        <th style="width: 10%; text-align: center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php($nom=1)
                    @foreach ($list_pengajuan as $list)
                    <tr>
                        <td style="text-align:center; vertical-align: middle">{{ $nom}}</td>
                        <td style="width: 5%; text-align:center; vertical-align: middle">
                            @if(!empty($list->getPengajuan->getKaryawan->photo))
                            <a href="{{ url(Storage::url('hrd/photo/'.$list->getPengajuan->getKaryawan->photo)) }}" data-fancybox data-caption="avatar">
                            <img src="{{ url(Storage::url('hrd/photo/'.$list->getPengajuan->getKaryawan->photo)) }}"
                                class="rounded-circle" alt="avatar" style="width: 80px; height: auto;"></a>
                            @else
                            <a href="{{ asset('assets/images/user/1.jpg') }}" data-fancybox data-caption="avatar">
                            <img src="{{ asset('assets/images/user/1.jpg') }}"
                                class="rounded-circle" alt="avatar" style="width: 80px; height: auto;"></a>
                            @endif
                        </td>
                        <td style="vertical-align: middle">
                            <h4 class="mb-0">{{ $list->getPengajuan->getKaryawan->nm_lengkap }}</h4>
                            <h6 class="mb-0">{{ $list->getPengajuan->getKaryawan->get_jabatan->nm_jabatan }} | {{ $list->getPengajuan->getKaryawan->get_departemen->nm_dept }}</h6>
                            <p style="font-size: 12px" class="mb-0 badge badge-dark">Tanggal masuk : {{ (empty($list->getPengajuan->getKaryawan->tgl_masuk)) ? "" : date('d-m-Y', strtotime($list->getPengajuan->getKaryawan->tgl_masuk)) }}</p>
                            <p style="font-size: 12px" class="mb-0 badge badge-dark">Lama bekerja : {{ (empty($list->getPengajuan->getKaryawan->tgl_masuk)) ? "" : App\Helpers\Hrdhelper::get_lama_kerja_karyawan($list->getPengajuan->getKaryawan->tgl_masuk) }}</p>
                        </td>
                        <td style="text-align:center; vertical-align: middle">
                            <p style="font-size: 12px" class="badge badge-dark">{{ date('d-m-Y', strtotime($list->getPengajuan->created_at)) }}</p>
                        </td>
                        <td style="text-align:center; vertical-align: middle">
                            @if($list->getPengajuan->sts_pengajuan==2)
                                <button type="button" class="btn btn-success"><i class="fa fa-check"></i> Approved</button>
                            @elseif($list->getPengajuan->sts_pengajuan==3)
                                <button type="button" class="btn btn-danger"><i class="fa fa-times"></i> Rejected</button>
                            @else
                                <button type="button" class="btn btn-dark"><i class="fa fa-times"></i> Pengajuan Batal</button>
                            @endif
                        </td>
                        <td style="text-align:center; vertical-align: middle">
                            <p style="font-size: 12px" class="badge badge-danger">{{ date('d-m-Y', strtotime($list->getPengajuan->tgl_eff_resign)) }}</p>
                        </td>
                        <td style="text-align:center; vertical-align: middle">
                            <p style="font-size: 12px" class="badge badge-dark">{{ date('d-m-Y', strtotime($list->created_at)) }}</p>
                        </td>
                        <td style="text-align:center; vertical-align: middle">
                            @if($list->sts_pengajuan==1)
                                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                    <div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Menunggu Persetujuan
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                            <a class="dropdown-item" href="#"><i class="fa fa-user mr-1"></i>{{ $list->get_current_approve->nm_lengkap }}</a>
                                            <a class="dropdown-item" href="#"><i class="fa fa-user mr-1"></i>{{ $list->get_current_approve->get_jabatan->nm_jabatan }}</a>
                                        </div>
                                    </div>
                                </div>
                            @elseif($list->sts_pengajuan==2)
                                <button type="button" class="btn btn-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-check"></i> Approved</button>
                            @elseif($list->sts_pengajuan==3)
                                <button type="button" class="btn btn-danger" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-times"></i> Rejected</button>
                            @else
                                <button type="button" class="btn btn-dark" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-times"></i> Pengajuan Batal</button>
                            @endif
                        </td>
                        <td style="text-align:center; vertical-align: middle">
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Act
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                        <button type="button" class="dropdown-item tbl-exit-form" data-toggle="modal" data-target="#ModalFormXL" value="{{ $list->id }}" name="btn-exit-form" data-placement="top" title="Exit Interviews Form"  onclick="goDetailExitInterviews(this)"><i class="ri-profile-line"></i> Form Exit Interviews</button>
                                        @if($list->sts_pengajuan==2)
                                            @if(empty($list->getPengajuan->nomor_skk))
                                                <button type="button" class="dropdown-item tbl-setting" data-toggle="modal" data-target="#ModalFormXL" value="{{ $list->id }}" name="btn-exit-form" data-placement="top" title="Exit Interviews Form"  onclick="goPengaturan(this)"><i class="fa fa-gear"></i> Pengaturan</button>
                                            @else
                                                <button type="button" class="dropdown-item tbl-print_skk" value="{{ $list->getPengajuan->id }}" name="btn-print-skk" data-placement="top" title="Exit Interviews Form"  onclick="goPrintSKK(this)"><i class="fa fa-print"></i> Surat Keterangan Kerja</button>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @php($nom++)
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
