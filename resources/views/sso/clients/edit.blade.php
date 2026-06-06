@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 class="mb-3">Edit Client SSO</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <p class="mb-3"><strong>Client ID:</strong> <code>{{ $ssoClient->oauth_client_id }}</code>
                        @if (optional($ssoClient->oauthClient)->secret)
                            <span class="badge badge-secondary">confidential</span>
                        @else
                            <span class="badge badge-info">public/PKCE</span>
                        @endif
                    </p>

                    <form action="{{ route('sso.clients.update', $ssoClient) }}" method="POST">
                        @csrf @method('PUT')

                        <div class="form-group">
                            <label>Nama Aplikasi <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $ssoClient->name) }}" required>
                        </div>

                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" name="slug" class="form-control" value="{{ old('slug', $ssoClient->slug) }}">
                        </div>

                        <div class="form-group">
                            <label>Redirect URI <span class="text-danger">*</span></label>
                            <input type="url" name="redirect" class="form-control"
                                   value="{{ old('redirect', optional($ssoClient->oauthClient)->redirect) }}" required>
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="description" class="form-control" rows="2">{{ old('description', $ssoClient->description) }}</textarea>
                        </div>

                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" id="trusted" name="trusted" value="1" {{ old('trusted', $ssoClient->trusted) ? 'checked' : '' }}>
                            <label class="form-check-label" for="trusted">Trusted (skip consent)</label>
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $ssoClient->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Aktif</label>
                        </div>

                        <button class="btn btn-primary">Update</button>
                        <a href="{{ route('sso.clients.index') }}" class="btn btn-link">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
