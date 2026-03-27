<!-- TOP Nav Bar -->
<div class="iq-top-navbar">
    <div class="top-menu">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-navbar-custom d-flex align-items-center justify-content-between">
                        <div class="iq-sidebar-logo">
                            <div class="top-logo">
                                <a href="index.html" class="logo">
                                <img src="{{ asset('assets/images/logo.png') }}" class="img-fluid" style="width:24px;height:24px;" alt="">
                                <h4 style="margin-left:20px;">Tender</h4>
                                </a>
                            </div>
                        </div>
                        @include('Tender.partials._app_header')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('Tender.partials._menu_top_bar')
</div>