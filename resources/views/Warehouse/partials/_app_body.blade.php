<!-- Wrapper Start -->
<div class="wrapper">
    <!-- Sidebar  -->
    @include('Warehouse.partials._body_left_sidebar')
    <!-- Sidebar End -->
    <!-- TOP Nav Bar -->
    @include('Warehouse.partials._app_header')
    <!-- TOP Nav Bar End -->
    <!-- Page Content  -->
        @yield('content')
    <!-- Content End -->
</div>
<!-- Wrapper END -->
<!-- Footer -->
@include('Warehouse.partials._body_footer')
<!-- Footer END -->
