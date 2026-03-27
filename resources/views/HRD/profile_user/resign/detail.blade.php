<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Detail Pengajuan Resign</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12 col-lg-6">
            <div class="iq-card-body">
                <div class="alert alert-success" role="alert">
                    <div class="iq-alert-text">
                       <h5 class="alert-heading">Alasan pengajuan pengunduran diri anda: </h5>
                       <p>{{ $data->alasan_resign }}</p>
                       <hr>
                    </div>
                 </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-6">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                <h4 class="card-title">Hirarki Persetujuan</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <ul class="iq-timeline">
                    @foreach ($hirarki_persetujuan as $list)
                    <li>
                        <div class="timeline-dots {{ ($list->approval_active==0) ? "border-success" : "border-danger" }}">{{ $list->approval_level }}</div>
                        <h6 class="float-left mb-1">{{ $list->get_profil_employee->nm_lengkap }}</h6><br>
                        <h6 class="float-left mb-1">{{ $list->get_profil_employee->get_jabatan->nm_jabatan }}</h6>
                        <small class="float-right mt-1 badge badge-danger">{{ (empty($list->approval_date)) ? "" : date('d-m-Y', strtotime($list->approval_date))  }}</small>
                        <div class="d-inline-block w-100">
                        <p>{{ $list->approval_remark }}</p>
                        @if($list->approval_status==1)
                            <h4><span class="badge badge-pill badge-success"><i class="fa fa-check"></i> Approved</span></h4>
                            @elseif($list->approval_status==2)
                            <h4><span class="badge badge-pill badge-danger"><i class="fa fa-times"></i> Rejected</span></h4>
                            @else

                            @endif
                        </div>
                        <hr>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
