<div class="col-sm-12">
    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
        <div class="iq-card-body">
           <div class="row">
                <div class="col-md-6 col-lg-4">
                    <div class="d-flex align-items-center mb-3 mb-md-0">
                    <div class="rounded-circle iq-card-icon iq-bg-warning mr-3"> <i class="ri-user-line"></i></div>
                    <div class="text-left">
                        <h4>{{ $pengajuan }} Pengajuan</h4>
                        <p class="mb-0">Pengajuan</p>
                        <button type="button" class="btn btn-danger" id="showPengajuan" value="pengajuan" onclick="showData(this)">Tampilkan Data</button>
                    </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="d-flex align-items-center mb-3 mb-lg-0">
                    <div class="rounded-circle iq-card-icon iq-bg-primary mr-3"> <i class="ri-user-line"></i></div>
                    <div class="text-left">
                        <h4>{{ $lembur_hari_ini }} Orang</h4>
                        <p class="mb-0">Karyawan Lembur Hari ini, <b>{{ \App\Helpers\Hrdhelper::get_hari_ini(date('d-m-Y')).', '.date('d').' '.\App\Helpers\Hrdhelper::get_nama_bulan(date('m')). ' '.date('Y') }}</b></p>
                        <button type="button" class="btn btn-primary" id="showToday" value="today" onclick="showData(this)">Tampilkan Data</button>
                    </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="d-flex align-items-center mb-3 mb-lg-0">
                        <div class="rounded-circle iq-card-icon iq-bg-info mr-3"> <i class="ri-user-line"></i></div>
                        <div class="text-left">
                            <h4>{{ $lembur_bulan_ini }} Orang</h4>
                            <p class="mb-0">Karyawan Lembur Bulan ini, <b>{{ \App\Helpers\Hrdhelper::get_nama_bulan(date('m')). ' '.date('Y') }}</b></p>
                            <button type="button" class="btn btn-info" id="showMonth" value="month" onclick="showData(this)">Tampilkan Data</button>
                        </div>
                    </div>
                </div>
           </div>
        </div>
    </div>
</div>
