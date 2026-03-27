<div class="col-sm-12">
    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
        <div class="iq-card-body">
           <div class="row">
                <div class="col-md-6 col-lg-4">
                    <div class="d-flex align-items-center mb-3 mb-md-0">
                    <div class="rounded-circle iq-card-icon iq-bg-danger mr-3"> <i class="ri-user-line"></i></div>
                    <div class="text-left">
                        <h4>{{ $total_resign }} Orang</h4>
                        <p class="mb-0">Karyawan Resign</p>
                        <button type="button" class="btn btn-danger" id="showAll" value="duetoday" onclick="showData(this)">Tampilkan Data</button>
                    </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="d-flex align-items-center mb-3 mb-md-0">
                    <div class="rounded-circle iq-card-icon iq-bg-primary mr-3"> <i class="ri-user-line"></i></div>
                    <div class="text-left">
                        <h4>{{ $total_pengajuan }} Orang</h4>
                        <p class="mb-0">Pengajuan Resign</p>
                        <button type="button" class="btn btn-primary" id="showPengajuan" value="duetoday" onclick="showPengajuan(this)">Tampilkan Data</button>
                    </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="d-flex align-items-center mb-3 mb-md-0">
                    <div class="rounded-circle iq-card-icon iq-bg-success mr-3"> <i class="ri-user-line"></i></div>
                    <div class="text-left">
                        <h4>{{ $total_exit_form }} Orang</h4>
                        <p class="mb-0">Form Exit Interviews</p>
                        <button type="button" class="btn btn-success" id="showPengajuan" value="duetoday" onclick="showExitInterviews(this)">Tampilkan Data</button>
                    </div>
                    </div>
                </div>
           </div>
        </div>
    </div>
</div>
