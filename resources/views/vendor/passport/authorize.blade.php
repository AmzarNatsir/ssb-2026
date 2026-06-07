<!DOCTYPE html>
<html lang="id">
@include('HRD.partials.template_two._body_style')
<body>
<section class="sign-in-page bg-white">
    <div class="container-fluid p-0">
        <div class="row no-gutters">
            <div class="col-sm-5 align-self-center">
                <div class="sign-in-from">
                    <h1 class="mb-0">Permintaan Otorisasi</h1>
                    <p>
                        <strong>{{ $client->name }}</strong> meminta izin untuk mengakses akun Anda.
                    </p>

                    <!-- Scope List -->
                    @if (count($scopes) > 0)
                        <div class="mt-3">
                            <p class="mb-1"><strong>Aplikasi ini akan dapat:</strong></p>
                            <ul class="pl-3">
                                @foreach ($scopes as $scope)
                                    <li>{{ $scope->description }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="d-inline-block w-100 mt-4">
                        <!-- Authorize Button -->
                        <form method="post" action="{{ route('passport.authorizations.approve') }}" class="float-left mr-2">
                            @csrf
                            <input type="hidden" name="state" value="{{ $request->state }}">
                            <input type="hidden" name="client_id" value="{{ $client->id }}">
                            <input type="hidden" name="auth_token" value="{{ $authToken }}">
                            <button type="submit" class="btn btn-primary">Otorisasi</button>
                        </form>

                        <!-- Cancel Button -->
                        <form method="post" action="{{ route('passport.authorizations.deny') }}" class="float-left">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="state" value="{{ $request->state }}">
                            <input type="hidden" name="client_id" value="{{ $client->id }}">
                            <input type="hidden" name="auth_token" value="{{ $authToken }}">
                            <button type="submit" class="btn btn-secondary">Batal</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-sm-7 text-center">
                <div class="sign-in-detail text-white" style="background: url({{ asset('assets/images/login/2.jpg') }}) no-repeat 0 0; background-size: cover;">
                    <a class="sign-in-logo mb-5" href="#">
                        <img src="{{ asset('assets/images/ssb_logo.png') }}" class="img-fluid" alt="logo">
                    </a>
                    <div class="item" style="text-align: center;">
                        <img src="{{ asset('assets/images/login/1.jpg') }}" class="img-fluid mb-4" alt="logo">
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
</section>
@include('HRD.partials.template_two._body_footer')
</body>
</html>
