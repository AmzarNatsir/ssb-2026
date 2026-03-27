<!-- Wrapper Start -->
<div class="wrapper">
    <!-- Sidebar  -->
    @include('Workshop.partials._body_left_sidebar')
    <!-- Sidebar End -->
    <!-- TOP Nav Bar -->
    @include('Workshop.partials._app_header')
    <!-- TOP Nav Bar End -->
    <!-- Page Content  -->
        @yield('content')
    <!-- Content End -->
</div>
<!-- Wrapper END -->
<!-- Footer -->
@include('Workshop.partials._body_footer')
<!-- Footer END -->
