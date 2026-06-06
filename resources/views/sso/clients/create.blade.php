@extends('HRD.layouts.master')
@section('content')
    <div class="navbar-breadcrumb">
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('sso.clients.index') }}">Aplikasi Client SSO</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ul>
        </nav>
    </div>

    @if ($errors->any())
        <div class="row">
            <div class="col-sm-12">
                <div class="alert text-white bg-danger" role="alert">
                    <div class="iq-alert-icon"><i class="ri-alert-line"></i></div>
                    <div class="iq-alert-text">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title"><i class="fa fa-plus"></i> Tambah Client SSO</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    <form action="{{ route('sso.clients.store') }}" method="POST">
                        @csrf

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nama Aplikasi <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Slug</label>
                            <div class="col-sm-9">
                                <input type="text" name="slug" class="form-control" value="{{ old('slug') }}"
                                       placeholder="mis. ess, warehouse">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Redirect URI <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="url" name="redirect" class="form-control" value="{{ old('redirect') }}"
                                       placeholder="https://ess.example.com/auth/ssb/callback" required>
                                <small class="text-muted">URL callback aplikasi client setelah otorisasi.</small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Deskripsi</label>
                            <div class="col-sm-9">
                                <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="public" name="public" value="1" {{ old('public') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="public">Public client / <strong>PKCE</strong> (tanpa secret — disarankan untuk web app)</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="trusted" name="trusted" value="1" {{ old('trusted') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="trusted">Trusted (first-party) — <strong>skip layar consent</strong></label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">Aktif</label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('sso.clients.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
