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
            <li class="nav-item iq-full-screen"><a href="#" class="iq-waves-effect" id="btnFullscreen"><i
                        class="ri-fullscreen-line"></i></a></li>
        </ul>
    </div>
    <ul class="navbar-list">
        <li>
            {{-- \Illuminate\Support\Str::startsWith("project/") --}}
            <a href="#"
                class="search-toggle iq-waves-effect text-white {{ in_array(request()->path(), ['home', '/']) ? 'pt-1' : 'pt-3' }}">
                <img src="{{ asset('assets/images/user/1.jpg') }}" class="img-fluid rounded" alt="user"></a>
            <div class="iq-sub-dropdown iq-user-dropdown">
                <div class="iq-card shadow-none m-0">
                    <div class="iq-card-body p-0 ">
                        <div class="bg-primary p-3">
                            <h5 class="mb-0 text-white line-height">
                                {{ $currentUser->nik . ' - ' . ucwords($currentUser->nama) ?? '' }}</h5>                                
                            <span class="text-white font-size-12">{{ $currentUser->jabatan ?? '' }}</span>
                        </div>
                        <a href="profile.html" class="iq-sub-card iq-bg-primary-hover">
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
                        {{-- <a href="profile-edit.html" class="iq-sub-card iq-bg-primary-success-hover">
                    <div class="media align-items-center">
                        <div class="rounded iq-card-icon iq-bg-success">
                            <i class="ri-profile-line"></i>
                        </div>
                        <div class="media-body ml-3">
                            <h6 class="mb-0 ">Edit Profile</h6>
                            <p class="mb-0 font-size-12">Modify your personal details.</p>
                        </div>
                    </div>
                </a>
                <a href="account-setting.html" class="iq-sub-card iq-bg-primary-danger-hover">
                    <div class="media align-items-center">
                        <div class="rounded iq-card-icon iq-bg-danger">
                            <i class="ri-account-box-line"></i>
                        </div>
                        <div class="media-body ml-3">
                            <h6 class="mb-0 ">Account settings</h6>
                            <p class="mb-0 font-size-12">Manage your account parameters.</p>
                        </div>
                    </div>
                </a>
                <a href="privacy-setting.html" class="iq-sub-card iq-bg-primary-secondary-hover">
                    <div class="media align-items-center">
                        <div class="rounded iq-card-icon iq-bg-secondary">
                            <i class="ri-lock-line"></i>
                        </div>
                        <div class="media-body ml-3">
                            <h6 class="mb-0 ">Privacy Settings</h6>
                            <p class="mb-0 font-size-12">Control your privacy parameters.</p>
                        </div>
                    </div>
                </a> --}}
                        <div class="d-flex w-100 p-3 justify-content-between">
                            <a href="{{ Config::get('app.url') }}/home" class="iq-bg-info iq-sign-btn"
                                role="button"><i class="ri-login-box-line ml-2"></i>Home</a>
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
