<div class="iq-top-navbar">
    <div class="iq-navbar-custom">
       <div class="iq-sidebar-logo">
          <div class="top-logo">
             <a href="index.html" class="logo">
             <img src="images/logo.png" class="img-fluid" alt="">
             <span>Sofbox</span>
             </a>
          </div>
       </div>
       <div class="navbar-breadcrumb">
          <h5 class="mb-0">Dashboard</h5>
          <nav aria-label="breadcrumb">
             <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Home</li>
             </ul>
          </nav>
       </div>
       <nav class="navbar navbar-expand-lg navbar-light p-0">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <i class="ri-menu-3-line"></i>
          </button>
          <div class="iq-menu-bt align-self-center">
             <div class="wrapper-menu">
                <div class="line-menu half start"></div>
                <div class="line-menu"></div>
                <div class="line-menu half end"></div>
             </div>
          </div>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
             <ul class="navbar-nav ml-auto navbar-list">
                <li class="nav-item">
                    {{ App\Helpers\Hrdhelper::get_notif_approval() }}
                </li>
                <li class="nav-item iq-full-screen"><a href="#" class="iq-waves-effect" id="btnFullscreen"><i class="ri-fullscreen-line"></i></a></li>
             </ul>
          </div>
          <ul class="navbar-list">
             <li>
                <a href="#" class="search-toggle iq-waves-effect ">
                    @if (empty(auth()->user()->karyawan->photo))
                        <i class="fa fa-user"></i>
                    @else
                        <img src="{{ url(Storage::url('hrd/photo/' . auth()->user()->karyawan->photo)) }}"
                            class="img-fluid rounded" alt="user">
                    @endif
                </a>
                <div class="iq-sub-dropdown iq-user-dropdown">
                    <div class="iq-card shadow-none m-0">
                        <div class="iq-card-body p-0 ">
                            <div class="bg-primary p-3">
                                <h5 class="mb-0 text-white line-height">{{ auth()->user()->karyawan->nm_lengkap }}</h5>
                                <span class="text-white font-size-12">{{ auth()->user()->karyawan->nik }}</span>
                            </div>
                            @if (auth()->user()->nik != "999999999")
                            <a href="{{ url('hrd/profil_user') }}" class="iq-sub-card iq-bg-primary-hover" style="padding: 5px">
                                <div class="media align-items-center">
                                   <div class="rounded iq-card-icon iq-bg-primary">
                                      <i class="ri-file-user-line"></i>
                                   </div>
                                   <div class="media-body ml-3">
                                      <h6 class="mb-0 ">My Profile</h6>
                                      <p class="mb-0 font-size-12">View personal profile details.</p>
                                   </div>
                                </div>
                             </a>
                             <a href="{{ url('hrd/dataku/cuti_izin') }}" class="iq-sub-card iq-bg-primary-hover" style="padding: 5px">
                                <div class="media align-items-center">
                                   <div class="rounded iq-card-icon iq-bg-primary">
                                        <i class="las la-calendar-check"></i>
                                   </div>
                                   <div class="media-body ml-3">
                                        <h6 class="mb-0 ">Cuti - Izin</h6>
                                   </div>
                                </div>
                             </a>
                             <a href="{{ url('hrd/dataku/lembur') }}" class="iq-sub-card iq-bg-primary-hover" style="padding: 5px">
                                <div class="media align-items-center">
                                   <div class="rounded iq-card-icon iq-bg-primary">
                                        <i class="las la-clock"></i>
                                   </div>
                                   <div class="media-body ml-3">
                                        <h6 class="mb-0 ">Lembur</h6>
                                   </div>
                                </div>
                             </a>
                             <a href="{{ url('hrd/dataku/absensi') }}" class="iq-sub-card iq-bg-primary-hover" style="padding: 5px">
                                <div class="media align-items-center">
                                   <div class="rounded iq-card-icon iq-bg-primary">
                                      <i class="las la-clock"></i>
                                   </div>
                                   <div class="media-body ml-3">
                                      <h6 class="mb-0 ">Absensi</h6>
                                   </div>
                                </div>
                             </a>
                             <a href="{{ url('hrd/dataku/perjalananDinas') }}" class="iq-sub-card iq-bg-primary-hover" style="padding: 5px">
                                <div class="media align-items-center">
                                   <div class="rounded iq-card-icon iq-bg-primary">
                                      <i class="las la-archive"></i>
                                   </div>
                                   <div class="media-body ml-3">
                                      <h6 class="mb-0 ">Perjalanan Dinas</h6>
                                   </div>
                                </div>
                             </a>
                             <a href="{{ url('hrd/dataku/suratPeringatan') }}" class="iq-sub-card iq-bg-primary-hover" style="padding: 5px">
                                <div class="media align-items-center">
                                   <div class="rounded iq-card-icon iq-bg-primary">
                                      <i class="las la-archive"></i>
                                   </div>
                                   <div class="media-body ml-3">
                                      <h6 class="mb-0 ">Surat Peringatan</h6>
                                   </div>
                                </div>
                             </a>
                             <a href="{{ url('hrd/dataku/pelatihan') }}" class="iq-sub-card iq-bg-primary-hover" style="padding: 5px">
                                <div class="media align-items-center">
                                   <div class="rounded iq-card-icon iq-bg-primary">
                                      <i class="las la-archive"></i>
                                   </div>
                                   <div class="media-body ml-3">
                                      <h6 class="mb-0 ">Pelatihan</h6>
                                   </div>
                                </div>
                             </a>
                             <a href="{{ url('hrd/dataku/pinjamanKaryawan') }}" class="iq-sub-card iq-bg-primary-hover" style="padding: 5px" >
                                <div class="media align-items-center">
                                   <div class="rounded iq-card-icon iq-bg-primary">
                                      <i class="las la-archive"></i>
                                   </div>
                                   <div class="media-body ml-3">
                                      <h6 class="mb-0 ">Pinjaman Karyawan</h6>
                                   </div>
                                </div>
                             </a>
                             <a href="{{ url('hrd/dataku/payroll') }}" class="iq-sub-card iq-bg-primary-hover" style="padding: 5px">
                                <div class="media align-items-center">
                                   <div class="rounded iq-card-icon iq-bg-primary">
                                      <i class="las la-archive"></i>
                                   </div>
                                   <div class="media-body ml-3">
                                      <h6 class="mb-0 ">Payroll</h6>
                                   </div>
                                </div>
                             </a>
                             <a href="{{ url('hrd/dataku/resign') }}" class="iq-sub-card iq-bg-primary-hover" style="padding: 5px">
                                <div class="media align-items-center">
                                   <div class="rounded iq-card-icon iq-bg-primary">
                                      <i class="las la-archive"></i>
                                   </div>
                                   <div class="media-body ml-3">
                                      <h6 class="mb-0 ">Resign</h6>
                                   </div>
                                </div>
                             </a>
                             @endif
                             <div class="d-flex w-100 p-3 justify-content-between">

                                <a href="{{ Config::get('app.url') }}/home" class="iq-bg-info iq-sign-btn"
                                    role="button"><i class="ri-login-box-line ml-2"></i> Home</a>
                                <form action="{{ route('auth.logout') }}" method="POST">
                                    @csrf
                                    <button class="iq-bg-danger iq-sign-btn" role="button">Sign
                                        out<i class="ri-login-box-line ml-2"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

             </li>
          </ul>
       </nav>
    </div>
 </div>
