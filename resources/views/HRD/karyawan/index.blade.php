@extends('HRD.layouts.master')
@section('content')
<style>
    .spinner-div {
    position: absolute;
    display: none;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    text-align: center;
    background-color: rgba(255, 255, 255, 0.8);
    z-index: 2;
    }
</style>
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Karyawan</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/karyawan/daftar') }}">Refresh (F5)</a></li>
        </ul>
    </nav>
</div>
@if(\Session::has('konfirm'))
<div class="row">
    <div class="alert text-white bg-success" role="alert" id="success-alert">
        <div class="iq-alert-icon">
            <i class="ri-alert-line"></i>
        </div>
        <div class="iq-alert-text">{{ \Session::get('konfirm') }}</div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ri-close-line"></i>
        </button>
    </div>
</div>
@endif
<div class="row">
    <!-- KIRI: Total + Ringkasan Departemen -->
    <div class="col-lg-3 col-md-12">
        @include('HRD.karyawan.summary_karyawan')
    </div>
    <!-- KANAN: Daftar Karyawan -->
    <div class="col-lg-9 col-md-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                   <h4 class="card-title">Daftar Karyawan</h4>
                </div>
                <div class="iq-card-header-toolbar d-flex align-items-center">
                    @if(auth()->user()->id==1)
                    <a class="dropdown-bg" href="{{ url('hrd/karyawan/baru') }}"><i class="fa fa-plus"></i> Tambah Data</a>
                    <a class="dropdown-bg" href="{{ route('importDBKaryawan') }}"><i class="fa fa-download"></i> Import Database</a>
                    <a class="dropdown-bg" href="{{ route('hapusDBKaryawan') }}" onclick="confirmHapus();"><i class="fa fa-trash"></i> Hapus Database</a>
                    @endif
                </div>
             </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <div class="row align-items-end mb-2">
                    <div class="col-md-4 col-sm-6 mb-2">
                        <label class="mb-1"><i class="ri-building-2-line"></i> Departemen</label>
                        <select class="form-control select2-filter" id="filter-departemen">
                            <option value="">Semua Departemen</option>
                            <option value="non">Non Departemen</option>
                            @foreach ($list_departemen as $dept)
                            <option value="{{ $dept['id'] }}">{{ $dept['nm_dept'] }} | {{ $dept['get_master_divisi']['nm_divisi'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-2">
                        <label class="mb-1"><i class="ri-shield-user-line"></i> Status</label>
                        <select class="form-control select2-filter" id="filter-status">
                            <option value="">Semua Status</option>
                            <option value="aktif">— Semua Aktif —</option>
                            <option value="nonaktif">— Semua Non-Aktif —</option>
                            <optgroup label="Status Detail">
                            @foreach ($sts_karyawan as $key => $val)
                            <option value="{{ $key }}">{{ $val }}</option>
                            @endforeach
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-2">
                        <label class="mb-1"><i class="ri-user-line"></i> Gender</label>
                        <select class="form-control select2-filter" id="filter-gender">
                            <option value="">Semua</option>
                            <option value="1">Laki-Laki</option>
                            <option value="2">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-2 col-sm-6 mb-2">
                        <button type="button" class="btn btn-outline-secondary btn-block" onclick="resetFilter()"><i class="fa fa-undo"></i> Reset</button>
                    </div>
                </div>
                <div id="spinner-div" class="pt-5 justify-content-center spinner-div"><div class="spinner-border text-primary" role="status"></div></div>
                <div class="data_karyawan"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#spinner-div').hide();
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".select2").select2();
        $(".select2-filter").select2({ width: '100%' });
        // Pengguna mengubah filter -> muat ulang data
        $('#filter-departemen, #filter-status, #filter-gender').on('change', applyFilter);
        // Muat semua data saat halaman pertama dibuka
        applyFilter();
    });

    // Memuat data berdasarkan kombinasi filter (departemen + status + gender)
    function applyFilter()
    {
        $('#spinner-div').show();
        var params = $.param({
            departemen: $('#filter-departemen').val() || '',
            status: $('#filter-status').val() || '',
            gender: $('#filter-gender').val() || ''
        });
        $(".data_karyawan").load("{{ url('hrd/karyawan/filter_data') }}?" + params, function(){
            $('#spinner-div').hide();
        });
    }

    // Set nilai dropdown lalu muat sekali (change.select2 hanya menyegarkan tampilan, tidak memicu handler)
    function setFilter(departemen, status, gender)
    {
        if (departemen !== null) $('#filter-departemen').val(departemen);
        if (status !== null) $('#filter-status').val(status);
        if (gender !== null) $('#filter-gender').val(gender);
        $('.select2-filter').trigger('change.select2');
        applyFilter();
    }

    function resetFilter()
    {
        setFilter('', '', '');
    }

    // Tombol "Total" pada kartu summary -> filter departemen (status & gender direset)
    var actFilter = function(el)
    {
        setFilter($(el).val(), '', '');
    }
    // Tombol "Aktif"/"Non-Aktif" pada kartu summary -> filter departemen + grup status
    var actFilterStatus = function(el)
    {
        const myArray = $(el).val().split("-");
        let status = myArray[0];        // 'aktif' / 'nonaktif'
        let id_departemen = myArray[1]; // id / 'non'
        setFilter(id_departemen, status, '');
    }
    // Tombol gender pada kartu summary -> filter departemen + gender (status direset)
    var actFilterGender = function(el)
    {
        const myArray = $(el).val().split("-");
        let gender = myArray[0];
        let id_departemen = myArray[1];
        setFilter(id_departemen, '', gender);
    }
</script>
@endsection
