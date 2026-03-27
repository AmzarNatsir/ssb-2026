@include('Tender.partials._body_style')
<section class="sign-in-page bg-white">
    <div class="container-fluid p-0">
        <div class="row no-gutters">
            <div class="col-sm-6 align-self-center">
                <div class="sign-in-from">
                    <h1 class="mb-0">Log in</h1>
                    <p>Masukkan Username dan password yang valid untuk login ke aplikasi</p>
                    <form class="mt-4" method="POST" action="{{ route('tender.auth.login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="inp_namapengguna">Username</label>
                            <input type="text" class="form-control mb-0" id="inp_namapengguna" name="nik" placeholder="gunakan NIK anda" required>
                        </div>
                        <div class="form-group">
                            <label for="inp_katakunci">Password</label>
                            <input type="password" class="form-control mb-0" id="inp_katakunci" name="password" placeholder="gunakan password terkini" required>
                        </div>
                        <div class="d-inline-block w-100">
                            <button type="submit" class="btn btn-primary float-right">Login</button>
                        </div>
                    </form>
                </div>                
            </div>
            <div class="col-sm-6 text-center">
                <div class="sign-in-detail text-white" 
                    style="background:url({{ asset('assets/images/landing-bg.jpg') }}) rgba(74,137,254,1); background-repeat:no-no-repeat; background-size:cover;">
                    <a class="sign-in-logo mb-5" href="{{ route('tender.auth.login') }}">
                        <img src={{ asset('assets/images/ssb_logo.png') }} class="img-fluid" alt="logo">
                    </a>
                    <div class="owl-carousel" data-autoplay="true" data-loop="true" data-nav="false" data-dots="true" data-items="1" data-items-laptop="1" data-items-tab="1" data-items-mobile="1" data-items-mobile-sm="1" data-margin="0">
                        <div class="item">
                            <img src={{asset("assets/images/login/1.png")}} class="img-fluid mb-4" alt="logo">
                            <h4 class="mb-1 text-white">Manajemen Project</h4>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam accusantium quos nobis quisquam, rerum laboriosam.</p>
                        </div>
                        <div class="item">
                            <img src={{asset("assets/images/login/1.png")}} class="img-fluid mb-4" alt="logo">
                            <h4 class="mb-1 text-white">Manage your orders</h4>
                            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Esse quos, optio necessitatibus corrupti excepturi dolorem!</p>
                        </div>
                        <div class="item">
                            <img src={{asset("assets/images/login/1.png")}} class="img-fluid mb-4" alt="logo">
                            <h4 class="mb-1 text-white">Manage your orders</h4>
                            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eius, sunt!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('Tender.partials._body_footer')