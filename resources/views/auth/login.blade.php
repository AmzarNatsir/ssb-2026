@include('Warehouse.partials._body_style')
<section class="sign-in-page bg-white">
    <div class="container-fluid p-0">
        <div class="row no-gutters">
            <div class="col-sm-6 align-self-center">
                <div class="sign-in-from">
                    <h1 class="mb-0">Log in SSB</h1>
                    <p>Masukkan Nama Pengguna dan Kata Kunci untuk masuk aplikasi</p>
                    @if (count($errors))
                        <div class="alert bg-white alert-danger" role="alert">
                            <div class="iq-alert-icon">
                                <i class="ri-information-line"></i>
                            </div>
                            @foreach ($errors->getMessages() as $key => $error)
                                <div class="iq-alert-text"><strong>{{ strtoupper($key) }}</strong> -
                                    @foreach ($error as $item)
                                        {{ $item }}
                                    @endforeach
                            </div><br>
                            @endforeach
                        </div>
                    @endif
                    <form class="mt-4" method="POST" action="{{ route('auth.do.login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="inp_namapengguna">Nama Pengguna</label>
                            <input type="text" class="form-control mb-0" id="inp_namapengguna" name="nik"
                                placeholder="Nama Pengguna" required>
                        </div>
                        <div class="form-group">
                            <label for="inp_katakunci">Kata Kunci</label>
                            <input type="password" class="form-control mb-0" id="inp_katakunci" name="password"
                                placeholder="Kata Kunci" required>
                        </div>
                        <div class="d-inline-block w-100">
                            <button type="submit" class="btn btn-primary float-right">Sign in</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-6 text-center">
                <div class="sign-in-detail text-white"
                    style="background: url({{ asset('assets/images/login/warehouse.jpg') }}) no-repeat 0 0; background-size: cover;">
                    <a class="sign-in-logo mb-5" href="#"><img src={{ asset('assets/images/ssb_logo.png') }}
                            class="img-fluid" alt="logo"></a>
                    <div class="owl-carousel" data-autoplay="true" data-loop="true" data-nav="false" data-dots="true"
                        data-items="1" data-items-laptop="1" data-items-tab="1" data-items-mobile="1"
                        data-items-mobile-sm="1" data-margin="0">
                        <div class="item">
                            <img src={{ asset('assets/images/login/1.png') }} class="img-fluid mb-4" alt="logo">
                            <h4 class="mb-1 text-white">Manajemen spare part</h4>
                            <p>It is a long established fact that a reader will be distracted by the readable content.
                            </p>
                        </div>
                        <div class="item">
                            <img src={{ asset('assets/images/login/1.png') }} class="img-fluid mb-4" alt="logo">
                            <h4 class="mb-1 text-white">Interaktif dashboard</h4>
                            <p>It is a long established fact that a reader will be distracted by the readable content.
                            </p>
                        </div>
                        <div class="item">
                            <img src={{ asset('assets/images/login/1.png') }} class="img-fluid mb-4" alt="logo">
                            <h4 class="mb-1 text-white">Fitur kartu kontrol otomatis</h4>
                            <p>It is a long established fact that a reader will be distracted by the readable content.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('Warehouse.partials._body_footer')
