@extends('HRD.layouts.master')
@section('content')
    <div class="navbar-breadcrumb">
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">SSO</li>
                <li class="breadcrumb-item"><a href="{{ route('sso.clients.index') }}">Aplikasi Client SSO</a></li>
            </ul>
        </nav>
    </div>

    @if (session('success'))
        <div class="row">
            <div class="col-sm-12">
                <div class="alert text-white bg-success" role="alert" id="success-alert">
                    <div class="iq-alert-icon"><i class="ri-check-line"></i></div>
                    <div class="iq-alert-text">{{ session('success') }}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if (session('new_client_id'))
        <div class="row">
            <div class="col-sm-12">
                <div class="alert text-white bg-info" role="alert">
                    <div class="iq-alert-icon"><i class="ri-key-2-line"></i></div>
                    <div class="iq-alert-text">
                        <strong>Kredensial client baru</strong> (isikan di aplikasi client):<br>
                        <code class="text-white">client_id = {{ session('new_client_id') }}</code>
                        @if (session('new_client_secret'))
                            <br><code class="text-white">client_secret = {{ session('new_client_secret') }}</code>
                            <br><small>Secret hanya ditampilkan sekali — simpan sekarang.</small>
                        @else
                            <br><small>Tipe public/PKCE — tidak ada secret.</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-sm-12">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title"><i class="fa fa-key"></i> Aplikasi Client SSO</h4>
                    </div>
                    <div class="iq-card-header-toolbar d-flex align-items-center">
                        <a href="{{ route('sso.clients.create') }}" class="btn btn-primary">
                            <i class="ri-add-line"></i> Tambah Client
                        </a>
                    </div>
                </div>
                <div class="iq-card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Client ID</th>
                                    <th>Nama</th>
                                    <th>Slug</th>
                                    <th>Redirect URI</th>
                                    <th class="text-center">Tipe</th>
                                    <th class="text-center">Aktif</th>
                                    <th class="text-center">Trusted</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($clients as $c)
                                    <tr>
                                        <td><code>{{ $c->oauth_client_id }}</code></td>
                                        <td>{{ $c->name }}</td>
                                        <td>{{ $c->slug ?? '-' }}</td>
                                        <td><small>{{ optional($c->oauthClient)->redirect }}</small></td>
                                        <td class="text-center">
                                            @if (optional($c->oauthClient)->secret)
                                                <span class="badge badge-secondary">confidential</span>
                                            @else
                                                <span class="badge badge-info">public/PKCE</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($c->is_active)
                                                <span class="badge badge-success">ya</span>
                                            @else
                                                <span class="badge badge-danger">tidak</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($c->trusted)
                                                <span class="badge badge-warning">skip consent</span>
                                            @else
                                                <span class="badge badge-light">consent</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('sso.clients.edit', $c) }}" class="btn btn-primary btn-sm mb-1">
                                                <i class="ri-edit-fill pr-0"></i>
                                            </a>
                                            <form action="{{ route('sso.clients.destroy', $c) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Hapus client ini? Seluruh token-nya akan direvoke.');">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-danger btn-sm mb-1"><i class="ri-delete-bin-line pr-0"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="8" class="text-center text-muted">Belum ada client SSO.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            window.setTimeout(function() {
                $("#success-alert").alert('close');
            }, 4000);
        });
    </script>
@endsection
