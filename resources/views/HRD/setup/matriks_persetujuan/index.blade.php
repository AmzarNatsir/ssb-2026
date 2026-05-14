@extends('HRD.layouts.master')
@section('content')
<style>
    /* ── Card group ─────────────────────────────── */
    .approval-group-card {
        margin-bottom: 1.5rem;
    }
    .approval-group-card .iq-card-header {
        background: linear-gradient(135deg, #1a3c6e 0%, #2563a8 100%);
        border-radius: 6px 6px 0 0;
    }
    .approval-group-card .card-title {
        color: #fff;
        font-weight: 600;
        font-size: 1rem;
        margin: 0;
    }
    /* ── Dept pills ─────────────────────────────── */
    .dept-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 1rem;
    }
    .dept-pills .nav-link {
        border: 1px solid #dee2e6;
        border-radius: 20px;
        padding: 4px 14px;
        font-size: 0.82rem;
        color: #495057;
        background: #f8f9fa;
        transition: all .2s;
    }
    .dept-pills .nav-link:hover {
        background: #e2ecf9;
        border-color: #2563a8;
        color: #2563a8;
    }
    .dept-pills .nav-link.active {
        background: #2563a8;
        border-color: #2563a8;
        color: #fff;
    }
    /* ── Timeline chain ─────────────────────────── */
    .approval-chain {
        display: flex;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 0;
        padding: 12px 0 4px;
    }
    .chain-item {
        display: flex;
        align-items: flex-start;
    }
    .chain-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 130px;
        text-align: center;
    }
    .chain-step .step-badge {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #2563a8;
        color: #fff;
        font-size: 0.9rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 6px;
        box-shadow: 0 2px 6px rgba(37,99,168,.3);
    }
    .chain-step .step-name {
        font-size: 0.8rem;
        font-weight: 600;
        color: #212529;
        line-height: 1.2;
        margin-bottom: 2px;
    }
    .chain-step .step-jabatan {
        font-size: 0.72rem;
        color: #6c757d;
        line-height: 1.2;
    }
    .chain-arrow {
        display: flex;
        align-items: center;
        padding: 0 6px;
        margin-top: 10px;
        color: #adb5bd;
        font-size: 1.2rem;
    }
    /* ── Empty state ────────────────────────────── */
    .empty-state {
        padding: 20px 0;
        text-align: center;
        color: #adb5bd;
    }
    .empty-state i { font-size: 2rem; display: block; margin-bottom: 6px; }
</style>

<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
            <li class="breadcrumb-item active">Setup</li>
            <li class="breadcrumb-item"><a href="{{ url('hrd/setup/matriks_persetujuan') }}">Matriks Persetujuan</a></li>
        </ul>
    </nav>
</div>

@if(\Session::has('konfirm'))
<div class="row">
    <div class="col-sm-12">
        <div class="alert text-white bg-success" role="alert" id="success-alert">
            <div class="iq-alert-icon"><i class="ri-alert-line"></i></div>
            <div class="iq-alert-text">{{ \Session::get('konfirm') }}</div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="ri-close-line"></i>
            </button>
        </div>
    </div>
</div>
@endif

<div class="row">
    @foreach ($list_matriks as $r)
    @php $groupId = $r['id']; $depts = $r['list_departemen']; @endphp
    <div class="col-lg-12 approval-group-card">
        <div class="iq-card" style="margin-bottom:0">
            <div class="iq-card-header d-flex justify-content-between align-items-center">
                <div class="iq-header-title">
                    <h4 class="card-title">
                        <i class="ri-git-branch-line mr-2"></i>{{ $r['ref_group'] }}
                    </h4>
                </div>
                <button type="button" class="btn btn-light btn-sm" onclick="goPengaturan({{ $groupId }})">
                    <i class="fa fa-gear"></i> Pengaturan
                </button>
            </div>
            <div class="iq-card-body">
                @if(count($depts) === 0)
                    <div class="empty-state">
                        <i class="ri-inbox-line"></i>
                        Belum ada departemen yang dikonfigurasi
                        <br>
                        <button class="btn btn-outline-primary btn-sm mt-2" onclick="goPengaturan({{ $groupId }})">
                            <i class="fa fa-plus"></i> Mulai Konfigurasi
                        </button>
                    </div>
                @else
                    {{-- Tab pills: list departemen --}}
                    <ul class="nav dept-pills" id="tab-{{ $groupId }}" role="tablist">
                        @foreach ($depts as $di => $dep)
                        <li class="nav-item">
                            <a class="nav-link {{ $di === 0 ? 'active' : '' }}"
                               id="pill-{{ $groupId }}-{{ $dep['id'] }}"
                               data-toggle="tab"
                               href="#pane-{{ $groupId }}-{{ $dep['id'] }}"
                               role="tab">
                                {{ $dep['nm_dept'] }}
                                <span class="badge badge-light ml-1">{{ count($dep['list_matriks']) }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>

                    {{-- Tab panes: chain per departemen --}}
                    <div class="tab-content">
                        @foreach ($depts as $di => $dep)
                        <div class="tab-pane fade {{ $di === 0 ? 'show active' : '' }}"
                             id="pane-{{ $groupId }}-{{ $dep['id'] }}"
                             role="tabpanel">
                            <div class="d-flex align-items-center mb-1">
                                <small class="text-muted">
                                    <i class="ri-building-line mr-1"></i>
                                    {{ $dep['nm_dept'] }} &mdash; {{ $dep['get_master_divisi']['nm_divisi'] }}
                                </small>
                            </div>
                            <div class="approval-chain">
                                @foreach ($dep['list_matriks'] as $mi => $matriks)
                                <div class="chain-item">
                                    @if($mi > 0)
                                    <div class="chain-arrow">
                                        <i class="ri-arrow-right-line"></i>
                                    </div>
                                    @endif
                                    <div class="chain-step">
                                        <div class="step-badge">{{ $matriks->approval_level }}</div>
                                        <div class="step-name">{{ $matriks->getPejabat->nm_lengkap }}</div>
                                        <div class="step-jabatan">{{ $matriks->getPejabat->get_jabatan->nm_jabatan }}</div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

<script type="text/javascript">
    $(document).ready(function() {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    });

    function goPengaturan(id) {
        location.href = "{{ url('hrd/setup/matriks_persetujuan_setup') }}/" + id;
    }
</script>
@endsection

