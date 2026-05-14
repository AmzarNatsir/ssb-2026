@extends('HRD.layouts.master')

@section('content')
<style>
    /* â”€â”€ Stat Cards â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    .stat-card {
        border-radius: 10px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        color: #fff;
        box-shadow: 0 4px 15px rgba(0,0,0,.12);
    }
    .stat-card .stat-icon {
        width: 52px; height: 52px;
        border-radius: 50%;
        background: rgba(255,255,255,.25);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; flex-shrink: 0;
    }
    .stat-card .stat-value { font-size: 1.8rem; font-weight: 700; line-height: 1; }
    .stat-card .stat-label { font-size: 0.78rem; opacity: .85; margin-top: 2px; }
    .sc-blue   { background: linear-gradient(135deg,#1a3c6e,#2563a8); }
    .sc-green  { background: linear-gradient(135deg,#1a6e4e,#22a06b); }
    .sc-orange { background: linear-gradient(135deg,#7a3d00,#e07b00); }
    .sc-purple { background: linear-gradient(135deg,#4b1a8c,#7c3aed); }

    /* â”€â”€ Memo card â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    .memo-item {
        display: flex; gap: 14px;
        padding: 14px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .memo-item:last-child { border-bottom: none; }
    .memo-thumb {
        width: 72px; height: 72px; border-radius: 8px;
        object-fit: cover; flex-shrink: 0;
        background: #f5f5f5;
        display: flex; align-items: center; justify-content: center;
    }
    .memo-thumb img { width: 72px; height: 72px; border-radius: 8px; object-fit: cover; }
    .memo-thumb .pdf-icon { font-size: 2rem; color: #e74c3c; }
    .memo-meta { font-size: 0.75rem; color: #6c757d; }
    .memo-title { font-size: 0.9rem; font-weight: 600; margin-bottom: 2px; color: #212529; }
    .memo-dept  { font-size: 0.76rem; color: #2563a8; }

    /* â”€â”€ Birthday â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    .bday-card {
        background: #fff;
        border-radius: 14px;
        text-align: center;
        overflow: hidden;
        border: 1px solid #e9ecef;
        max-width: 260px;
        margin: 0 auto;
        box-shadow: 0 2px 12px rgba(0,0,0,.07);
    }
    .bday-card-body { padding: 28px 20px 0; }
    .bday-card .bday-photo {
        width: 120px; height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #1a6e4e;
        margin-bottom: 14px;
    }
    .bday-card .bday-name {
        font-weight: 700; font-size: 1rem;
        text-transform: uppercase; letter-spacing: .4px;
        color: #212529; margin-bottom: 4px;
    }
    .bday-card .bday-jabatan {
        font-size: 0.80rem; color: #6c757d;
        margin-bottom: 4px;
    }
    .bday-card .bday-dept {
        font-size: 0.82rem; color: #1a6e4e; font-weight: 700;
        margin-bottom: 0;
    }
    .bday-card .bday-footer {
        background: #1a6e4e; color: #fff;
        font-weight: 700; font-size: 0.88rem;
        padding: 10px 0; margin-top: 16px;
        letter-spacing: .3px;
    }
    .bday-carousel .carousel-indicators { bottom: -16px; }
    .bday-carousel .carousel-indicators li {
        background-color: #1a6e4e; width: 8px; height: 8px;
        border-radius: 50%; border: none;
    }

    /* â”€â”€ Welcome banner â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    .welcome-banner {
        background: linear-gradient(135deg, #1a3c6e 0%, #2563a8 60%, #3b82f6 100%);
        border-radius: 10px; color: #fff;
        padding: 24px 28px; position: relative; overflow: hidden;
    }
    .welcome-banner h4 { color: #fff; font-weight: 700; margin-bottom: 4px; }
    .welcome-banner p  { opacity: .8; margin: 0; font-size: 0.85rem; }
    .welcome-banner .banner-img {
        position: absolute; right: 20px; top: 0; bottom: 0;
        display: flex; align-items: center; opacity: .15;
    }
    .welcome-banner .banner-img img { height: 120px; }

    /* â”€â”€ Calendar â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    #calendar_1 { font-size: 0.8rem; }
    .holiday-badge {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 0.76rem; padding: 2px 8px;
        background: #fef2f2; color: #dc2626;
        border-radius: 20px; margin: 2px;
    }
</style>

{{-- â”€â”€ Welcome Banner â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ --}}
<div class="row mb-3">
    <div class="col-12">
        <div class="welcome-banner">
            <div class="banner-img"><img src="{{ asset('assets/images/page-img/34.png') }}"></div>
            <h4><i class="ri-user-smile-line mr-2"></i>Selamat datang, <b>{{ auth()->user()->karyawan->nm_lengkap }}</b></h4>
            <p>Smart System Base &mdash; Human Resource Departemen &bull; PT Sumber Setia Budi &bull; {{ \App\Helpers\Hrdhelper::get_nama_bulan(date('m')) }} {{ date('Y') }}</p>
        </div>
    </div>
</div>

{{-- â”€â”€ Stat Cards â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ --}}
<div class="row mb-3">
    <div class="col-6 col-lg-3 mb-3 mb-lg-0">
        <div class="stat-card sc-blue">
            <div class="stat-icon"><i class="ri-group-line"></i></div>
            <div>
                <div class="stat-value">{{ $stat_karyawan }}</div>
                <div class="stat-label">Karyawan Aktif</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 mb-3 mb-lg-0">
        <div class="stat-card sc-green">
            <div class="stat-icon"><i class="ri-calendar-check-line"></i></div>
            <div>
                <div class="stat-value">{{ $stat_cuti_pending }}</div>
                <div class="stat-label">Cuti Pending Bulan Ini</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 mb-3 mb-lg-0">
        <div class="stat-card sc-orange">
            <div class="stat-icon"><i class="ri-time-line"></i></div>
            <div>
                <div class="stat-value">{{ $stat_lembur_pending }}</div>
                <div class="stat-label">Lembur Pending Bulan Ini</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card sc-purple">
            <div class="stat-icon"><i class="ri-swap-line"></i></div>
            <div>
                <div class="stat-value">{{ $stat_mutasi_pending }}</div>
                <div class="stat-label">Mutasi Menunggu Proses</div>
            </div>
        </div>
    </div>
</div>

{{-- â”€â”€ Main Content â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ --}}
<div class="row">
    {{-- Left column --}}
    <div class="col-sm-12 col-lg-8">

        {{-- Memo Internal --}}
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between align-items-center">
                <div class="iq-header-title">
                    <h4 class="card-title"><i class="ri-notification-2-line mr-1"></i> Memo Internal</h4>
                </div>
                <span class="badge badge-primary">{{ count($list_memo) }}</span>
            </div>
            <div class="iq-card-body">
                @forelse($list_memo as $memo)
                @php
                    $ext = strtolower(pathinfo($memo->file_memo, PATHINFO_EXTENSION));
                    $isPdf = $ext === 'pdf';
                    $fileUrl = url(Storage::url('memo_internal/'.$memo->file_memo));
                @endphp
                <div class="memo-item">
                    <a href="{{ $fileUrl }}" target="_blank" class="memo-thumb">
                        @if($isPdf)
                            <div class="memo-thumb" style="width:72px;height:72px;border-radius:8px;background:#fef2f2;display:flex;align-items:center;justify-content:center;">
                                <i class="ri-file-pdf-line pdf-icon"></i>
                            </div>
                        @else
                            <img src="{{ $fileUrl }}" alt="{{ $memo->judul }}" data-fancybox data-caption="{{ $memo->judul }}">
                        @endif
                    </a>
                    <div class="flex-grow-1">
                        <div class="memo-title">{{ $memo->judul }}</div>
                        <div class="memo-meta mb-1">
                            <i class="ri-calendar-line mr-1"></i>
                            {{ date_format(date_create($memo->tgl_post), 'd') }}
                            {{ \App\Helpers\Hrdhelper::get_nama_bulan(date_format(date_create($memo->tgl_post), 'm')) }}
                            {{ date_format(date_create($memo->tgl_post), 'Y') }}
                        </div>
                        <p class="mb-1" style="font-size:.82rem;color:#495057;">{{ Str::limit($memo->deskripsi, 120) }}</p>
                        <span class="memo-dept"><i class="ri-building-line mr-1"></i>{{ $memo->get_departemen->nm_dept ?? '-' }}</span>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="ri-inbox-line" style="font-size:2rem;display:block;margin-bottom:6px;"></i>
                    Belum ada memo internal
                </div>
                @endforelse
            </div>
        </div>

        {{-- Agenda Pelatihan --}}
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between align-items-center">
                <div class="iq-header-title">
                    <h4 class="card-title"><i class="ri-book-open-line mr-1"></i> Agenda Pelatihan {{ date('Y') }}</h4>
                </div>
            </div>
            <div class="iq-card-body">
                {{-- Filter bulan --}}
                <div class="d-flex flex-wrap gap-1 mb-3">
                    @php $bln_now = date('m'); @endphp
                    @for($i = $bln_now; $i <= 12; $i++)
                    <button type="button"
                        class="btn btn-sm {{ $i == $bln_now ? 'btn-primary' : 'btn-outline-secondary' }} px-2 py-1"
                        onclick="goThisMonth(this)" value="{{ $i }}">
                        {{ \App\Helpers\Hrdhelper::get_nama_bulan($i) }}
                    </button>
                    @endfor
                </div>
                <div class="showPage">
                    <div id="spinner-div" class="text-center py-4" style="display:none;">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                    <table class="table table-sm table-hover table-bordered" style="width:100%">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:5%">No</th>
                                <th>Pelatihan</th>
                                <th style="width:30%">Tanggal</th>
                                <th style="width:12%">Durasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($hari_ini_pelatihan as $i => $item)
                            @php
                                $nama_pelatihan = ($item->kategori == 'Internal') ? $item->get_nama_pelatihan->nama_pelatihan : $item->nama_pelatihan;
                            @endphp
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $nama_pelatihan }}</td>
                                <td>{{ App\Helpers\Hrdhelper::get_tanggal_pelaksanaan($item->tanggal_awal, $item->tanggal_sampai, null, null) }}</td>
                                <td>{{ $item->durasi }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">Tidak ada pelatihan bulan ini</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- Right column --}}
    <div class="col-sm-12 col-lg-4">
        {{-- Ulang Tahun Carousel --}}
        @if(count($ulang_tahun) > 0)
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between align-items-center position-relative" style="padding-bottom:0;">
                <div class="iq-header-title">
                    <h4 class="card-title"><i class="ri-cake-line mr-1"></i> Ulang Tahun Bulan Ini <span class="badge badge-success ml-1">{{ count($ulang_tahun) }}</span></h4>
                </div>
                {{-- carousel nav arrows --}}
                <div style="position:absolute;right:16px;top:16px;display:flex;gap:4px;">
                    <button class="btn p-0" style="width:28px;height:28px;background:#e9ecef;border-radius:50%;" data-target="#bdayCarousel" data-slide="prev">
                        <i class="ri-arrow-left-s-line"></i>
                    </button>
                    <button class="btn p-0" style="width:28px;height:28px;background:#e9ecef;border-radius:50%;" data-target="#bdayCarousel" data-slide="next">
                        <i class="ri-arrow-right-s-line"></i>
                    </button>
                </div>
            </div>
            <div class="iq-card-body pt-2 pb-4">
                <div id="bdayCarousel" class="carousel slide bday-carousel" data-ride="carousel" data-interval="4000">
                    {{-- Indicators --}}
                    @php $pages = ceil(count($ulang_tahun) / 1); @endphp
                    <ol class="carousel-indicators">
                        @for($p = 0; $p < $pages; $p++)
                        <li data-target="#bdayCarousel" data-slide-to="{{ $p }}" class="{{ $p === 0 ? 'active' : '' }}"></li>
                        @endfor
                    </ol>
                    <div class="carousel-inner">
                        @foreach($ulang_tahun->chunk(1) as $chunkIndex => $chunk)
                        <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                            <div class="row mx-0" style="justify-content:center;">
                                @foreach($chunk as $k)
                                @php
                                    $photoSrc = !empty($k->photo)
                                        ? url(Storage::url('hrd/photo/'.$k->photo))
                                        : asset('assets/images/no_image.png');
                                    $jabatan  = $k->get_jabatan->nm_jabatan ?? '-';
                                    $dept     = $k->get_departemen->nm_dept ?? '';
                                    $tglLahir = date('d', strtotime($k->tgl_lahir)) . ' ' . \App\Helpers\Hrdhelper::get_nama_bulan(date('m', strtotime($k->tgl_lahir)));
                                @endphp
                                <div class="col-12">
                                    <div class="bday-card">
                                        <div class="bday-card-body">
                                            <img src="{{ $photoSrc }}" class="bday-photo" alt="{{ $k->nm_lengkap }}">
                                            <div class="bday-name">{{ $k->nm_lengkap }}</div>
                                            <div class="bday-jabatan">{{ $jabatan }}</div>
                                            @if($dept)
                                            <div class="bday-dept">{{ $dept }}</div>
                                            @endif
                                        </div>
                                        <div class="bday-footer">Birthdate: {{ $tglLahir }}</div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
        {{-- Kalender --}}
        <div class="iq-card">
            <div class="iq-card-header">
                <div class="iq-header-title">
                    <h4 class="card-title"><i class="ri-calendar-2-line mr-1"></i> Kalender</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <div id='calendar_1'></div>
                @if(count($list_hari_libur) > 0)
                <div class="mt-2">
                    <small class="text-muted d-block mb-1"><i class="ri-information-line mr-1"></i>Hari Libur Bulan Ini</small>
                    @foreach($list_hari_libur as $libur)
                    <span class="holiday-badge">
                        <i class="ri-calendar-event-line"></i>
                        {{ date_format(date_create($libur->tanggal), 'd') }} &mdash; {{ $libur->keterangan }}
                    </span>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var calendarEl = document.getElementById('calendar_1');
        var Calendar = FullCalendar.Calendar;
        var calendar = new Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            initialDate: new Date(),
            headerToolbar: { left: 'prev,next today', center: 'title', right: '' },
            editable: false,
            droppable: true,
            displayEventTime: false,
        });
        calendar.render();
    });

    function goThisMonth(el) {
        $('#spinner-div').show();
        var filter = $(el).val();
        $('.showPage').load("{{ url('hrd/home/getPelatihan') }}/" + filter, function() {
            $('#spinner-div').hide();
        });
    }
</script>
@endsection
