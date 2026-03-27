<!-- Wrapper Start -->
<div class="wrapper">
    <!-- top bar  -->
    @include('HRD.partials.template_one._menu_top')
    <!-- topbar End -->
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">
        @yield('content')
        </div>
    </div>
    <!-- Content End -->
</div>
<!-- Wrapper END -->
<!-- Footer -->
@include('HRD.partials.template_one._body_footer')
<!-- Footer END -->
