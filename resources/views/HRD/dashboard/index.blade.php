@extends('HRD.layouts.master')

@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ul>
    </nav>
</div>

@if($tanpa_niklama > 0)
<div class="alert text-white bg-warning d-flex align-items-center" role="alert">
    <i class="ri-alert-line mr-2" style="font-size:20px;"></i>
    <div>Ada <b>{{ $tanpa_niklama }}</b> karyawan aktif tanpa <b>NIK Lama</b> — absensi mereka tidak akan terbaca. Lengkapi di master karyawan.</div>
</div>
@endif

<!-- ====== KPI CARDS ====== -->
<div class="row">
    <div class="col-md-6 col-lg-3">
        <div class="iq-card">
            <div class="iq-card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle iq-card-icon iq-bg-primary mr-3"><i class="ri-group-line"></i></div>
                    <div class="text-left">
                        <h3 class="mb-0">{{ number_format($kpi['total_aktif']) }}</h3>
                        <p class="mb-0 text-secondary">Karyawan Aktif</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="iq-card">
            <div class="iq-card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle iq-card-icon iq-bg-success mr-3"><i class="ri-user-add-line"></i></div>
                    <div class="text-left">
                        <h3 class="mb-0">{{ number_format($kpi['karyawan_baru']) }}</h3>
                        <p class="mb-0 text-secondary">Karyawan Baru ({{ $nama_bulan }})</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="iq-card">
            <div class="iq-card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle iq-card-icon iq-bg-danger mr-3"><i class="ri-user-unfollow-line"></i></div>
                    <div class="text-left">
                        <h3 class="mb-0">{{ number_format($kpi['resign_bulan']) }}</h3>
                        <p class="mb-0 text-secondary">Resign ({{ $nama_bulan }})</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="iq-card">
            <div class="iq-card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle iq-card-icon iq-bg-warning mr-3"><i class="ri-time-line"></i></div>
                    <div class="text-left">
                        <h3 class="mb-0">{{ number_format($kpi['pkwt_30hari']) }}</h3>
                        <p class="mb-0 text-secondary">PKWT Berakhir &le;30 Hari</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ====== APPROVAL PENDING + KEHADIRAN HARI INI ====== -->
<div class="row">
    <div class="col-lg-8">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title"><h4 class="card-title">Menunggu Persetujuan</h4></div>
                <span class="badge badge-pill badge-danger align-self-center">{{ $pending['total'] }} total</span>
            </div>
            <div class="iq-card-body">
                <div class="row text-center">
                    <div class="col-6 col-md-3 mb-3">
                        <a href="{{ url('hrd/cutiizin') }}" class="d-block p-3 rounded" style="background:#eef7ff;">
                            <h3 class="mb-0 text-primary">{{ $pending['cuti'] }}</h3>
                            <small class="text-secondary">Cuti</small>
                        </a>
                    </div>
                    <div class="col-6 col-md-3 mb-3">
                        <a href="{{ url('hrd/cutiizin') }}" class="d-block p-3 rounded" style="background:#eafaf1;">
                            <h3 class="mb-0 text-success">{{ $pending['izin'] }}</h3>
                            <small class="text-secondary">Izin</small>
                        </a>
                    </div>
                    <div class="col-6 col-md-3 mb-3">
                        <a href="{{ url('hrd/mutasi') }}" class="d-block p-3 rounded" style="background:#fff5e6;">
                            <h3 class="mb-0 text-warning">{{ $pending['mutasi'] }}</h3>
                            <small class="text-secondary">Mutasi</small>
                        </a>
                    </div>
                    <div class="col-6 col-md-3 mb-3">
                        <a href="{{ url('hrd/perubahanstatus') }}" class="d-block p-3 rounded" style="background:#fdecec;">
                            <h3 class="mb-0 text-danger">{{ $pending['perubahan'] }}</h3>
                            <small class="text-secondary">Perubahan Status</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title"><h4 class="card-title">Kehadiran Hari Ini</h4></div>
                <span class="align-self-center font-weight-bold text-primary">{{ $kehadiran['persen'] }}%</span>
            </div>
            <div class="iq-card-body">
                <div id="chart-kehadiran"></div>
                <div class="d-flex justify-content-around mt-2" style="font-size:12px;">
                    <span><i class="ri-checkbox-blank-circle-fill text-success"></i> Hadir {{ $kehadiran['hadir'] }}</span>
                    <span><i class="ri-checkbox-blank-circle-fill text-info"></i> Cuti {{ $kehadiran['cuti'] }}</span>
                    <span><i class="ri-checkbox-blank-circle-fill text-warning"></i> Izin {{ $kehadiran['izin'] }}</span>
                    <span><i class="ri-checkbox-blank-circle-fill text-secondary"></i> Alpa {{ $kehadiran['tidak_hadir'] }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ====== CHART DEMOGRAFI ====== -->
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="iq-card"><div class="iq-card-body"><div id="high-pie-chart-1"></div></div></div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="iq-card"><div class="iq-card-body"><div id="high-pie-chart-3"></div></div></div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="iq-card"><div class="iq-card-body"><div id="high-pie-chart-2"></div></div></div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="iq-card"><div class="iq-card-body"><div id="high-pie-chart-4"></div></div></div>
    </div>
</div>

<!-- ====== REMINDER ====== -->
<div class="row">
    <div class="col-lg-4">
        <div class="iq-card">
            <div class="iq-card-header"><div class="iq-header-title"><h4 class="card-title"><i class="ri-time-line text-warning"></i> PKWT Berakhir &le;30 Hari</h4></div></div>
            <div class="iq-card-body p-0">
                <table class="table table-sm mb-0">
                    <tbody>
                    @forelse($pkwt_list as $row)
                        <tr>
                            <td>{{ $row->nm_lengkap }}<br><small class="text-secondary">{{ $row->nm_dept }}</small></td>
                            <td class="text-right align-middle"><span class="badge badge-warning">{{ date('d-m-Y', strtotime($row->tgl_sts_efektif_akhir)) }}</span></td>
                        </tr>
                    @empty
                        <tr><td class="text-center text-secondary">Tidak ada</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="iq-card">
            <div class="iq-card-header"><div class="iq-header-title"><h4 class="card-title"><i class="ri-shield-check-line text-success"></i> Karyawan dengan Fasilitas BPJS</h4></div></div>
            <div class="iq-card-body">
                <div id="chart-bpjs"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="iq-card">
            <div class="iq-card-header"><div class="iq-header-title"><h4 class="card-title"><i class="ri-error-warning-line text-danger"></i> Karyawan dengan SP Aktif</h4></div></div>
            <div class="iq-card-body p-0">
                <table class="table table-sm mb-0">
                    <tbody>
                    @forelse($sp_list as $row)
                        <tr>
                            <td>{{ $row->nm_lengkap }}<br><small class="text-secondary">{{ $row->nm_dept }}</small></td>
                            <td class="text-right align-middle"><span class="badge badge-danger">SP</span></td>
                        </tr>
                    @empty
                        <tr><td class="text-center text-secondary">Tidak ada</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- highcharts -->
<script src="{{ asset('assets/js/highcharts.js') }}"></script>
<script src="{{ asset('assets/js/highcharts-3d.js') }}"></script>
<script src="{{ asset('assets/js/highcharts-more.js') }}"></script>
<script>
function pieChart(id, title, seriesName, data) {
    if (!jQuery('#' + id).length) return;
    Highcharts.chart(id, {
        chart: { type: 'pie', height: 260 },
        title: { text: title, style: { fontSize: '13px' } },
        tooltip: { pointFormat: '{series.name}: <b>{point.y}</b> ({point.percentage:.1f}%)' },
        plotOptions: { pie: { allowPointSelect: true, cursor: 'pointer',
            dataLabels: { enabled: true, format: '<b>{point.name}</b>: {point.percentage:.0f}%', style: { fontSize: '10px' } } } },
        credits: { enabled: false },
        series: [{ name: seriesName, colorByPoint: true, data: data }]
    });
}

pieChart('high-pie-chart-1', 'Per Departemen', 'Departemen', [
    @foreach($data_chart_1 as $v){ name: "{{ $v['nm_dept'] }}", y: {{ $v['jml_karyawan'] }} },@endforeach
]);
pieChart('high-pie-chart-3', 'Per Status', 'Status', [
    @foreach($data_chart_2 as $v){ name: "{{ $v['status'] }}", y: {{ $v['jml_karyawan'] }} },@endforeach
]);
pieChart('high-pie-chart-2', 'Per Usia', 'Usia', [
    { name: "<= 25 thn", y: {{ $usia_1 }} },
    { name: "26 - 30 thn", y: {{ $usia_2 }} },
    { name: "31 - 40 thn", y: {{ $usia_3 }} },
    { name: "> 40 thn", y: {{ $usia_4 }} }
]);
pieChart('high-pie-chart-4', 'Per Jenis Kelamin', 'Jenis Kelamin', [
    { name: "Laki-laki", y: {{ $jk_l }}, color: '#0084ff' },
    { name: "Perempuan", y: {{ $jk_p }}, color: '#ef5db8' }
]);

if (jQuery('#chart-kehadiran').length) {
    Highcharts.chart('chart-kehadiran', {
        chart: { type: 'pie', height: 200 },
        title: { text: null },
        tooltip: { pointFormat: '<b>{point.y}</b> ({point.percentage:.1f}%)' },
        plotOptions: { pie: { innerSize: '60%', dataLabels: { enabled: false } } },
        credits: { enabled: false },
        series: [{ name: 'Karyawan', data: [
            { name: 'Hadir', y: {{ $kehadiran['hadir'] }}, color: '#28a745' },
            { name: 'Cuti', y: {{ $kehadiran['cuti'] }}, color: '#17a2b8' },
            { name: 'Izin', y: {{ $kehadiran['izin'] }}, color: '#ffc107' },
            { name: 'Tidak Hadir', y: {{ $kehadiran['tidak_hadir'] }}, color: '#adb5bd' }
        ] }]
    });
}

if (jQuery('#chart-bpjs').length) {
    Highcharts.chart('chart-bpjs', {
        chart: { type: 'pie', height: 280 },
        title: { text: null },
        tooltip: { pointFormat: '<b>{point.y}</b> karyawan ({point.percentage:.1f}%)' },
        plotOptions: { pie: { allowPointSelect: true, cursor: 'pointer',
            dataLabels: { enabled: true, format: '<b>{point.name}</b>: {point.y}', style: { fontSize: '11px' } } } },
        credits: { enabled: false },
        series: [{ name: 'Fasilitas BPJS', colorByPoint: true, data: [
            { name: 'Kesehatan', y: {{ $bpjs['kesehatan'] }} },
            { name: 'JHT', y: {{ $bpjs['jht'] }} },
            { name: 'JKK', y: {{ $bpjs['jkk'] }} },
            { name: 'JKM', y: {{ $bpjs['jkm'] }} },
            { name: 'JP', y: {{ $bpjs['jp'] }} }
        ] }]
    });
}
</script>
@endsection
