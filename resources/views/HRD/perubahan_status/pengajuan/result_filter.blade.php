<div class="iq-card-header d-flex justify-content-between">
    <div class="iq-header-title">
        <h4 class="card-title">Monitoring PKWT Jatuh Tempo {{ $keterangan }}</h4>
    </div>
</div>
<div class="iq-card-body">
    @if(count($list)==0)
        <div class="alert text-white bg-secondary mb-0" role="alert">
            <div class="iq-alert-text">No matching records found !</div>
        </div>
    @else
    <div class="monitoring-list">
        @foreach ($list as $list)
            <div class="monitoring-item">
                <div class="row align-items-center">
                    <div class="col-lg-1 col-md-2 col-sm-2 col-3">
                        @if(!empty($list->photo))
                            <img src="{{ url(Storage::url('hrd/photo/'.$list->photo)) }}" class="rounded-circle monitoring-avatar" alt="avatar">
                        @else
                            <img src="{{ asset('assets/images/user/1.jpg') }}" class="rounded-circle monitoring-avatar" alt="avatar">
                        @endif
                    </div>
                    <div class="col-lg-4 col-md-5 col-sm-10 col-9">
                        <h5 class="monitoring-name">{{ $list->nm_lengkap }}</h5>
                        <p class="monitoring-job">{{ (empty(optional($list->get_jabatan)->nm_jabatan)) ? '-' : $list->get_jabatan->nm_jabatan }} | {{ $list->get_departemen->nm_dept }}</p>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-8 col-12">
                        <p class="monitoring-status"><strong>Status:</strong> {{ $list->get_status_karyawan($list->id_status_karyawan) }}</p>
                        <p class="monitoring-period">
                            PKWT: <span class="text-success">{{ date_format(date_create($list->tgl_sts_efektif_mulai), 'd-m-Y') }}</span>
                            s/d <span class="text-danger">{{ date_format(date_create($list->tgl_sts_efektif_akhir), 'd-m-Y') }}</span>
                        </p>
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-4 col-12 text-right">
                        @if(empty($list->evaluasi_kerja))
                            <button type="button" name="tbl_rubah_status" value="{{ $list->id }}" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalFormPengajuan" onClick="goForm(this);">Submit</button>
                        @else
                            <span class="badge badge-success">Telah Diajukan</span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @endif
</div>
