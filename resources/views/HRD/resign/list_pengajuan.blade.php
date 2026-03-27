<div class="col-sm-12 col-lg-12">
    <div class="iq-card">
        <div class="iq-card-header d-flex justify-content-between">
            <div class="iq-header-title">
               <h4 class="card-title">Daftar Pengajuan Resign</h4>
            </div>
         </div>
        <div class="iq-card-body" style="width:100%; height:auto">
            <table class="table table-striped table-bordered" style="width: 100%; font-size:13px">
                <thead class="thead-light">
                    <th style="width: 5%; text-align:center">No</th>
                    <th style="width: 20%" colspan="2">Karyawan</th>
                    <th style="width: 10%; text-align:center">Diajukan pada</th>
                    <th>Alasan Pengajuan</th>
                    <th style="width: 5%; text-align:center">File</th>
                    <th style="width: 10%; text-align:center">Eff. Resign</th>
                    <th style="width: 15%">Status</th>
                    <th style="width: 15%">Act</th>
                </thead>
                <tbody>
                    @php($nom=1)
                    @foreach ($list_pengajuan as $list)
                    <tr>
                        <td style="text-align:center; vertical-align: middle">{{ $nom}}</td>
                        <td style="width: 5%">@if(!empty($list['getKaryawan']['photo']))
                            <a href="{{ url(Storage::url('hrd/photo/'.$list['getKaryawan']['photo'])) }}" data-fancybox data-caption="avatar">
                            <img src="{{ url(Storage::url('hrd/photo/'.$list['getKaryawan']['photo'])) }}"
                                class="rounded-circle" alt="avatar" style="width: 80px; height: auto;"></a>
                            @else
                            <a href="{{ asset('assets/images/user/1.jpg') }}" data-fancybox data-caption="avatar">
                            <img src="{{ asset('assets/images/user/1.jpg') }}"
                                class="rounded-circle" alt="avatar" style="width: 80px; height: auto;"></a>
                            @endif
                        </td>
                        <td style="width: 15%; vertical-align: middle">
                            <h4 class="mb-0">{{ $list['getKaryawan']['nm_lengkap'] }}</h4>
                            <h6 class="mb-0">{{ $list['getKaryawan']['get_jabatan']['nm_jabatan'] }} | {{ $list['getKaryawan']['get_departemen']['nm_dept'] }}</h6>
                        </td>
                        <td style="text-align:center; vertical-align: middle"><p style="font-size: 12px" class="badge badge-success">{{ date('d-m-Y', strtotime($list->created_at)) }}</p></td>
                        <td style="vertical-align: middle">{{ $list->alasan_resign }}</td>
                        <td style="vertical-align: middle; text-align: center">
                            @if(!empty($list->file_surat_resign))
                                <a href="{{ url('hrd/dataku/resign/showPdf', $list->id) }}" target="_new"><i class="fa fa-file-pdf-o"></i></a>
                                @endif
                        </td>
                        <td style="text-align:center; vertical-align: middle"><p style="font-size: 12px" class="badge badge-danger">{{ date('d-m-Y', strtotime($list->tgl_eff_resign)) }}</p></td>
                        <td style="vertical-align: middle">
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
                        <td style="vertical-align: middle">
                            @if($list->sts_pengajuan == 2)
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Act
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                        <button type="button" class="dropdown-item tbl-exit-form" data-toggle="modal" data-target="#ModalForm" id="{{ $list->id }}" name="btn-exit-form" data-placement="top" title="Exit Interviews Form"><i class="ri-profile-line"></i> Exit Interviews Form</button>
                                    </div>
                                </div>
                            </div>
                            @else
                                <button type="button" class="btn btn-info" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-hourglass"></i> On Progress</button>
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
