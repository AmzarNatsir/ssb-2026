<div class="col-sm-12">
    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
        <div class="iq-card-body">
           <div class="row">
                <div class="col-md-6 col-lg-3">
                    <div class="d-flex align-items-center mb-3 mb-md-0">
                    <div class="rounded-circle iq-card-icon iq-bg-info mr-3"> <i class="ri-user-line"></i></div>
                    <div class="text-left">
                        <h4>{{ $count_pengajuan_st }} Orang</h4>
                        <p class="mb-0">Pengajuan Surat Teguran</p>
                        <button type="button" class="btn btn-info" id="showPengajuanST" value="pengajuan_st" onclick="showData(this)">Tampilkan Data</button>
                    </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="d-flex align-items-center mb-3 mb-md-0">
                    <div class="rounded-circle iq-card-icon iq-bg-info mr-3"> <i class="ri-user-line"></i></div>
                    <div class="text-left">
                        <h4>{{ $count_pengajuan_sp }} Orang</h4>
                        <p class="mb-0">Pengajuan SP</p>
                        <button type="button" class="btn btn-info" id="showPengajuanSP" value="pengajuan_sp" onclick="showData(this)">Tampilkan Data</button>
                    </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="d-flex align-items-center mb-3 mb-lg-0">
                    <div class="rounded-circle iq-card-icon iq-bg-danger mr-3"> <i class="ri-user-line"></i></div>
                    <div class="text-left">
                        <h4>{{ $count_sp_aktif }} Orang</h4>
                        <p class="mb-0">SP Aktif</p>
                        <button type="button" class="btn btn-danger" id="showSPAktif" value="sp_aktif" onclick="showData(this)">Tampilkan Data</button>
                    </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="d-flex align-items-center mb-3 mb-lg-0">
                    <div class="rounded-circle iq-card-icon iq-bg-warning mr-3"> <i class="ri-user-line"></i></div>
                    <div class="text-left">
                        <h4>{{ $count_st_aktif }} Orang</h4>
                        <p class="mb-0">Surat Teguran</p>
                        <button type="button" class="btn btn-warning" id="showST" value="st_aktif" onclick="showData(this)">Tampilkan Data</button>
                    </div>
                    </div>
                </div>
           </div>
        </div>
    </div>
</div>
