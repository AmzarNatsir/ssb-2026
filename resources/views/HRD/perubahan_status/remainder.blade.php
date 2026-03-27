<div class="col-sm-12">
    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
       <div class="iq-card-body">
          <div class="row">
             <div class="col-md-6 col-lg-4">
                <div class="d-flex align-items-center mb-3 mb-lg-0">
                   <div class="rounded-circle iq-card-icon iq-bg-danger mr-3"> <i class="ri-group-line"></i></div>
                   <div class="text-left">
                      <h4>{{ $dueDay }} orang</h4>
                      <p class="mb-0">PKWT jatuh tempo hari <b>{{ \App\Helpers\Hrdhelper::get_hari_ini(date('d-m-Y')).', '.date('d').' '.\App\Helpers\Hrdhelper::get_nama_bulan(date('m')). ' '.date('Y') }}</b></p>
                      <button type="button" class="btn btn-danger" id="showToDay" value="duetoday" onclick="showData(this)">Tampilkan Data</button>
                   </div>
                </div>
             </div>
             <div class="col-md-6 col-lg-4">
                <div class="d-flex align-items-center mb-3 mb-lg-0">
                   <div class="rounded-circle iq-card-icon iq-bg-warning mr-3"> <i class="ri-group-line"></i></div>
                   <div class="text-left">
                      <h4>{{ $dueThisMonth }} orang</h4>
                      <p class="mb-0">PKWT jatuh tempo bulan <b>{{ \App\Helpers\Hrdhelper::get_nama_bulan(date('m')). ' '.date('Y') }}</b></p>
                      <button type="button" class="btn btn-warning" id="showThisMonth" value="duethismonth" onclick="showData(this)">Tampilkan Data</button>
                   </div>
                </div>
             </div>
             <div class="col-md-6 col-lg-4">
                <div class="d-flex align-items-center mb-3 mb-md-0">
                   <div class="rounded-circle iq-card-icon iq-bg-success mr-3"> <i class="ri-group-line"></i></div>
                   <div class="text-left">
                      <h4>{{ $due30days }} orang</h4>
                      <p class="mb-0">PKWT jatuh tempo dalam <b>30 hari</b></p>
                      <button type="button" class="btn btn-success" id="show30Days" value="due30days" onclick="showData(this)">Tampilkan Data</button>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
</div>
