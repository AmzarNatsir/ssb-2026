<!-- TOP Nav Bar -->
<div class="iq-top-navbar">
    <div class="top-menu">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-navbar-custom d-flex align-items-center justify-content-between">
                        <div class="iq-sidebar-logo">
                            <div class="top-logo">
                                <a href="{{ url('hrd/home') }}" class="logo">
                                <img src="{{ asset('assets/images/logo.png') }}" class="img-fluid" alt="">
                                <span>SSB-HRD</span>
                                </a>
                            </div>
                        </div>
                        @include('HRD.partials._app_header')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>