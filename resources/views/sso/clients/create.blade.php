@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 class="mb-3">Tambah Client SSO</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('sso.clients.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>Nama Aplikasi <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>

                        <div class="form-group">
                            <label>Slug (kunci app, mis. <code>ess</code>, <code>warehouse</code>)</label>
                            <input type="text" name="slug" class="form-control" value="{{ old('slug') }}">
                        </div>

                        <div class="form-group">
                            <label>Redirect URI <span class="text-danger">*</span></label>
                            <input type="url" name="redirect" class="form-control" value="{{ old('redirect') }}"
                                   placeholder="https://ess.example.com/auth/ssb/callback" required>
                            <small class="text-muted">URL callback app client setelah otorisasi.</small>
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
                        </div>

                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" id="public" name="public" value="1" {{ old('public') ? 'checked' : '' }}>
                            <label class="form-check-label" for="public">
                                Public client / <strong>PKCE</strong> (tanpa secret — disarankan untuk web app)
                            </label>
                        </div>

                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" id="trusted" name="trusted" value="1" {{ old('trusted') ? 'checked' : '' }}>
                            <label class="form-check-label" for="trusted">
                                Trusted (first-party) — <strong>skip layar consent</strong>
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Aktif</label>
                        </div>

                        <button class="btn btn-primary">Simpan</button>
                        <a href="{{ route('sso.clients.index') }}" class="btn btn-link">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
