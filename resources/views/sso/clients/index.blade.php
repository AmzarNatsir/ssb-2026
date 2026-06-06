@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">Aplikasi Client SSO</h4>
                <a href="{{ route('sso.clients.create') }}" class="btn btn-primary btn-sm">+ Tambah Client</a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('new_client_id'))
                <div class="alert alert-info">
                    <strong>Kredensial client baru</strong> (untuk diisi di app client):<br>
                    <code>client_id = {{ session('new_client_id') }}</code>
                    @if (session('new_client_secret'))
                        <br><code>client_secret = {{ session('new_client_secret') }}</code>
                        <br><small class="text-danger">Secret hanya ditampilkan sekali — simpan sekarang.</small>
                    @else
                        <br><small>Tipe public/PKCE — tidak ada secret.</small>
                    @endif
                </div>
            @endif

            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Client ID</th>
                                <th>Nama</th>
                                <th>Slug</th>
                                <th>Redirect URI</th>
                                <th class="text-center">Tipe</th>
                                <th class="text-center">Aktif</th>
                                <th class="text-center">Trusted</th>
                                <th class="text-right">Aksi</th>
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
                                    <td class="text-right">
                                        <a href="{{ route('sso.clients.edit', $c) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                                        <form action="{{ route('sso.clients.destroy', $c) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Hapus client ini? Seluruh token-nya akan direvoke.');">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-outline-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="text-center text-muted py-3">Belum ada client SSO.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
