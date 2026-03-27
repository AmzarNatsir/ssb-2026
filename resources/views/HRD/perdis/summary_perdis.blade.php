<div class="col-sm-12">
    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
        <div class="iq-card-body">
           <div class="row">
                <div class="col-md-6 col-lg-4">
                    <div class="d-flex align-items-center mb-3 mb-md-0">
                    <div class="rounded-circle iq-card-icon iq-bg-primary mr-3"> <i class="ri-file-line"></i></div>
                    <div class="text-left">
                        <h4>{{ $count_pengajuan }} pengajuan</h4>
                        <p class="mb-0">Pengajuan</p>
                        <button type="button" class="btn btn-primary" id="showPengajuan" value="pengajuan" onclick="showData(this)">Tampilkan Data</button>
                    </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="d-flex align-items-center mb-3 mb-md-0">
                    <div class="rounded-circle iq-card-icon iq-bg-info mr-3"> <i class="ri-user-line"></i></div>
                    <div class="text-left">
                        <h4>{{ $count_approved }} pengajuan</h4>
                        <p class="mb-0">Proses Pengajuan </p>
                        <button type="button" class="btn btn-info" id="showProses" value="proses" onclick="showData(this)">Tampilkan Data</button>
                    </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="d-flex align-items-center mb-3 mb-md-0">
                    <div class="rounded-circle iq-card-icon iq-bg-success mr-3"> <i class="ri-user-line"></i></div>
                    <div class="text-left">
                        <h4>{{ $karyawan_perdis }} Orang</h4>
                        <p class="mb-0">Perjalanan dinas bulan <b>{{ \App\Helpers\Hrdhelper::get_nama_bulan(date('m')). ' '.date('Y') }}</b></p>
                        <button type="button" class="btn btn-success" id="showPerdis" value="perdis" onclick="showData(this)">Tampilkan Data</button>
                    </div>
                    </div>
                </div>

           </div>
        </div>
    </div>
</div>
