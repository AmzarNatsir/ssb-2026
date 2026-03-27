@include('HRD.partials.template_two._body_style')
<section class="sign-in-page bg-white">
    <div class="container-fluid p-0">
        <div class="row no-gutters">
            <div class="col-sm-5 align-self-center">
                <div class="sign-in-from">
                    <h1 class="mb-0">Log in</h1>
                    <p>Masukkan NIK dan PASSWORD anda</p>
                    <form class="mt-4" action="{{ route('hrd.auth.login') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="nik" class="col-form-label">{{ __('Nomor Induk Karyawan') }}</label>
                            <input type="text" class="form-control mb-0" id="nik" name="nik" placeholder="Nomor Induk Karyawan" required>
                            @if ($errors->has('nik'))
                            <br>
                                <div class="alert text-white bg-danger" role="alert">
                                    <div class="iq-alert-text">{{ $errors->first('nik') }}</div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <i class="ri-close-line"></i>
                                    </button>
                                 </div>
                            @endif

                        </div>
                        <div class="form-group">
                            <label for="password" class="col-form-label">{{ __('Kata Kunci') }}</label>
                            <input type="password" class="form-control mb-0" id="password" name="password" placeholder="Kata Kunci" required>
                            @if ($errors->has('password'))
                            <br>
                                <div class="alert text-white bg-danger" role="alert">
                                    <div class="iq-alert-text">{{ $errors->first('password') }}</div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <i class="ri-close-line"></i>
                                    </button>
                                 </div>
                            @endif
                        </div>
                        <div class="d-inline-block w-100">
                            <button type="submit" class="btn btn-primary float-right">{{ __('Log In')}}</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-sm-7 text-center">
                <div class="sign-in-detail text-white" style="background: url({{ asset('assets/images/login/2.jpg') }}) no-repeat 0 0; background-size: cover;">
                    <a class="sign-in-logo mb-5" href="#">
                    <img src="{{ asset('assets/images/ssb_logo.png') }}" class="img-fluid" alt="logo">
                    </a>
                    <div class="owl-carousel" data-autoplay="true" data-loop="true" data-nav="false" data-dots="true" data-items="1" data-items-laptop="1" data-items-tab="1" data-items-mobile="1" data-items-mobile-sm="1" data-margin="0">
                        <div class="item" style="text-align: center;">
                            <img src="{{asset('assets/images/login/1.jpg') }}" class="img-fluid mb-4" alt="logo">
                            <h4 class="mb-1 text-white">Welcome to Smart System Base - Human Resource Departemen</h4>
                            <p>
                            @if(empty(App\Helpers\Hrdhelper::get_profil_perusahaan()->id))
                            PT SUMBER SETIA BUDI - POMALA - KOLAKA
                            @else
                            {{ App\Helpers\Hrdhelper::get_profil_perusahaan()->nm_perusahaan }}
                            @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('HRD.partials.template_two._body_footer')
