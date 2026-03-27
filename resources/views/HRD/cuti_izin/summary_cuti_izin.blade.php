<div class="col-sm-12">
    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
       <div class="iq-card-body">
          <div class="row">
             <div class="col-md-6 col-lg-4">
                <div class="d-flex align-items-center mb-3 mb-lg-0">
                   <div class="rounded-circle iq-card-icon iq-bg-danger mr-3"> <i class="ri-group-line"></i></div>
                   <div class="text-left">
                      <h5 class='text-danger'>Cuti : {{ $count_pengajuan_cuti }} orang | Izin : {{ $count_pengajuan_izin }} orang</h5>
                      <p class="mb-0">Pengajuan</p>
                      <button type="button" class="btn btn-danger" id="showPengajuan" value="pengajuan" onclick="actFilter(this)">Tampilkan Data</button>
                   </div>
                </div>
             </div>
             <div class="col-md-6 col-lg-4">
                <div class="d-flex align-items-center mb-3 mb-md-0">
                   <div class="rounded-circle iq-card-icon iq-bg-success mr-3"> <i class="ri-group-line"></i></div>
                   <div class="text-left">
                      <h5 class='text-success'>Cuti : {{ $count_cuti_hari_ini }} orang | Izin : {{ $count_izin_hari_ini }} orang</h5>
                      <p class="mb-0">Karyawan cuti/izin tanggal  <b>{{ \App\Helpers\Hrdhelper::get_hari_ini(date('d-m-Y')).', '.date('d').' '.\App\Helpers\Hrdhelper::get_nama_bulan(date('m')). ' '.date('Y') }}</b></p>
                      <button type="button" class="btn btn-success" id="showToDay" value="to_day" onclick="actFilter(this)">Tampilkan Data</button>
                   </div>
                </div>
             </div>
             <div class="col-md-6 col-lg-4">
                <div class="d-flex align-items-center mb-3 mb-md-0">
                   <div class="rounded-circle iq-card-icon iq-bg-primary mr-3"> <i class="ri-group-line"></i></div>
                   <div class="text-left">
                      <h5 class='text-primary'>Cuti : {{ $count_cuti_bulan_ini }} orang | Izin : {{ $count_izin_bulan_ini }} orang</h5>
                      <p class="mb-0">Karyawan cuti/izin Bulan <b>{{ \App\Helpers\Hrdhelper::get_nama_bulan(date('m')).', '.date('Y') }}</b></p>
                      <button type="button" class="btn btn-primary" id="showThisMonth" value="this_month" onclick="actFilter(this)">Tampilkan Data</button>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
</div>
