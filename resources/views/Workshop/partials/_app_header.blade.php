<!-- TOP Nav Bar -->
<div class="iq-top-navbar">
  <div class="iq-navbar-custom">
    <div class="iq-sidebar-logo">
      <div class="top-logo">
        <a href="/" class="logo">
          <img src="{{ asset('assets/images/logo.png') }}" class="img-fluid" alt="">
          <span>Warehouse</span>
        </a>
      </div>
    </div>
    <div class="navbar-breadcrumb">
      <h5 class="mb-0">Dashboard</h5>
      <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
          @php
            $lastBreadCrumbItem = count($breadCrumb) - 1;

            foreach ($breadCrumb as $key => $value) {
                $isBreadCrumbItemActive = $value['isActive'] ? 'active' : '';
                if ($key == $lastBreadCrumbItem) {
                    echo '<li class="breadcrumb-item ' . $isBreadCrumbItemActive . '" aria-current="page" >' . $value['text'] . '</li>';
                } else {
                    echo '<li class="breadcrumb-item ' . $isBreadCrumbItemActive . '"><a href="' . $value['url'] . '">' . $value['text'] . '</a></li>';
                }
            }
          @endphp
        </ul>
      </nav>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light p-0">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
          <li class="nav-item dropdown">
            @php
              $unreadNotifications = auth()->user()->unreadNotifications;
            @endphp
            <a href="#" class="search-toggle iq-waves-effect" onclick="read_notification()">
              <i class="ri-mail-line"></i>
              <span class="badge badge-pill badge-primary badge-up count-mail">{{ $unreadNotifications->count() }}</span>
            </a>
            <div class="iq-sub-dropdown">
              <div class="iq-card iq-card-block iq-card-stretch iq-card-height shadow-none m-0">
                <div class="iq-card-body p-0 ">
                  <div class="bg-primary p-3">
                    <h5 class="mb-0 text-white">All Messages<small class="badge  badge-light float-right pt-1">{{ $unreadNotifications->count() }}</small></h5>
                  </div>
                  @foreach ($unreadNotifications as $notification)
                    <a href="#" class="iq-sub-card">
                      <div class="media-body ml-3">
                        <h6 class="mb-0 ">{{ $notification->data['message'] }}</h6>
                      </div>
                    </a>
                  @endforeach
                </div>
              </div>
            </div>
          </li>
          <li class="nav-item iq-full-screen"><a href="#" class="iq-waves-effect" id="btnFullscreen"><i
                class="ri-fullscreen-line"></i></a></li>
        </ul>
      </div>
      <ul class="navbar-list">
        <li>
          <a href="#" class="search-toggle iq-waves-effect bg-primary text-white"><img
              src="{{ asset('assets/images/user/1.jpg') }}" class="img-fluid rounded" alt="user"></a>
          <div class="iq-sub-dropdown iq-user-dropdown">
            <div class="iq-card shadow-none m-0">
              <div class="iq-card-body p-0 ">
                <div class="bg-primary p-3">
                  <h5 class="mb-0 text-white line-height">{{ $currentUser->nama }}
                  </h5>
                </div>
                <div class="d-flex w-100 p-3 justify-content-between">
                  <a href="{{ Config::get('app.url') }}/home" class="iq-bg-info iq-sign-btn"
                     role="button"><i class="ri-login-box-line ml-2"></i> Home</a>
                  <form action="{{ env('APP_URL') . '/logout' }}" method="POST">
                    @csrf
                    <button class="iq-bg-danger iq-sign-btn" href="sign-in.html" role="button">Sign
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
<!-- TOP Nav Bar END -->
