{{-- <div class="row row-eq-height">
    <div class="col-lg-2 col-md-12">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height wow fadeInUp" data-wow-delay="0.6s">
            <div class="iq-card-body">
               <div class="row" style="text-align: center;">
                    <div class="col-lg-12 mb-2 d-flex justify-content-center align-items-center">
                        <div class="icon iq-icon-box rounded-circle iq-bg-primary d-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px;" data-wow-delay="0.2s">
                            <i class="ri-group-line" style="font-size: 36px; color: #007bff;"></i>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-3">
                        <h6 class="card-title text-uppercase text-secondary mb-0">Total Karyawan</h6>
                        <span class="h2 text-primary mb-0 counter d-inline-block w-100">{{ $total_karyawan }}</span>
                    </div>
                    <div class="col-lg-12 mt-3">
                        <h6 class="card-title text-uppercase text-secondary mb-0">Aktif</h6>
                        <span class="h2 text-success mb-0 counter d-inline-block w-100">{{ $total_karyawan_aktif }}</span>
                    </div>
                    <div class="col-lg-12 mt-3">
                        <h6 class="card-title text-uppercase text-secondary mb-0">Tidak Aktif</h6>
                        <span class="h2 text-danger mb-0 counter d-inline-block w-100">{{ $total_karyawan_tidak_aktif }}</span>
                    </div>
               </div>
            </div>
        </div>
    </div>
    <div class="col-lg-10 col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="iq-card iq-card-block iq-card-stretch iq-card-height wow fadeInUp" data-wow-delay="0.6s">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Summary</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <div class="d-flex align-items-center mb-3 mb-md-2">
                                    <div class="rounded-circle iq-card-icon iq-bg-primary mr-3"> <i class="ri-group-line"></i></div>
                                    <div class="text-left">
                                        <h4>
                                            <button type="button" class="btn btn-success badge badge-success badge-pill" onclick="actFilter(this)" value="non">{{ $non_departemen['total_non'] }} Orang</button> <button type="button" class="btn btn-danger badge badge-danger badge-pill" onclick="actFilter(this)" value="non">{{ $non_departemen['total_non'] }} Orang</button> |
                                            <button type="button" class="btn btn-dark badge badge-dark badge-pill" onclick="actFilterGender(this)" value="1-non"><i class='fa fa-male'></i> {{ $non_departemen['total_laki_non'] }}</button> |
                                            <button type="button" class="btn btn-danger badge badge-danger badge-pill" onclick="actFilterGender(this)" value="2-non"><i class='fa fa-female'></i> {{ $non_departemen['total_perempuan_non'] }}
                                            </button>
                                        </h4>
                                        <p class="mb-0">Non Departemen</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            @foreach ($list_departemen as $dept)
                            <div class="col-md-6 col-lg-4">
                                <div class="d-flex align-items-center mb-3 mb-md-2">
                                    <div class="rounded-circle iq-card-icon iq-bg-success mr-3"> <i class="ri-group-line"></i></div>
                                    <div class="text-left">
                                        <h4>
                                            <button type="button" class="btn btn-success badge badge-success badge-pill" onclick="actFilter(this)" value="{{ $dept['id'] }}">{{ $dept['total'] }} Orang</button> |
                                            <button type="button" class="btn btn-dark badge badge-dark badge-pill" onclick="actFilterGender(this)" value="1-{{ $dept['id'] }}"><i class='fa fa-male'></i> {{ $dept['total_laki'] }}</button> |
                                            <button type="button" class="btn btn-danger badge badge-danger badge-pill" onclick="actFilterGender(this)" value="2-{{ $dept['id'] }}"><i class='fa fa-female'></i> {{ $dept['total_perempuan'] }}
                                            </button>
                                        </h4>
                                        <p class="mb-0">{{ $dept['nm_dept'] }} | {{ $dept['get_master_divisi']['nm_divisi'] }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div> --}}

{{-- Kolom kiri: Total Karyawan + Ringkasan Departemen (bertumpuk vertikal) --}}
<div class="iq-card iq-card-block iq-card-stretch">
    <div class="iq-card-body">
        <div class="row" style="text-align: center;">
            <div class="col-lg-12 mb-2 d-flex justify-content-center align-items-center">
                <div class="icon iq-icon-box rounded-circle iq-bg-primary d-flex align-items-center justify-content-center"
                    style="width: 80px; height: 80px;">
                    <i class="ri-group-line" style="font-size: 36px; color: #007bff;"></i>
                </div>
            </div>
            <div class="col-4 mt-3">
                <h6 class="card-title text-uppercase text-secondary mb-0">Total</h6>
                <span class="h3 text-primary mb-0 counter d-inline-block w-100">{{ $total_karyawan }}</span>
            </div>
            <div class="col-4 mt-3">
                <h6 class="card-title text-uppercase text-secondary mb-0">Aktif</h6>
                <span class="h3 text-success mb-0 counter d-inline-block w-100">{{ $total_karyawan_aktif }}</span>
            </div>
            <div class="col-4 mt-3">
                <h6 class="card-title text-uppercase text-secondary mb-0">Non-Aktif</h6>
                <span class="h3 text-danger mb-0 counter d-inline-block w-100">{{ $total_karyawan_tidak_aktif }}</span>
            </div>
        </div>
    </div>
</div>

<h6 class="text-uppercase text-secondary mb-2 ml-1"><i class="ri-building-2-line"></i> Ringkasan Departemen</h6>

{{-- Daftar departemen bisa di-scroll vertikal agar kolom kiri tidak memanjang --}}
<div class="dept-summary-scroll" style="max-height: 65vh; overflow-y: auto; overflow-x: hidden; padding-right: 6px;">
{{-- Non Departemen --}}
<div class="d-flex align-items-center mb-3 p-2 shadow-sm rounded bg-white">
    <div class="rounded-circle d-flex align-items-center justify-content-center mr-2 flex-shrink-0"
        style="width: 48px; height: 48px; background-color: #f0f8ff;">
        <i class="ri-group-line" style="font-size: 24px; color:#007bff;"></i>
    </div>
    <div class="flex-fill">
        <h6 class="mb-1 text-secondary">Non Departemen</h6>
        <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn btn-sm btn-primary rounded-pill mr-1 mb-1"
                    onclick="actFilter(this)" value="non">
                {{ $non_departemen['total_non'] }} Total
            </button>
            <button type="button" class="btn btn-sm btn-success rounded-pill mr-1 mb-1"
                    onclick="actFilterStatus(this)" value="aktif-non">
                {{ $non_departemen['total_aktif_non'] }} Aktif
            </button>
            <button type="button" class="btn btn-sm btn-danger rounded-pill mr-1 mb-1"
                    onclick="actFilterStatus(this)" value="nonaktif-non">
                {{ $non_departemen['total_tidak_aktif_non'] }} Non-Aktif
            </button>
            <button type="button" class="btn btn-sm btn-dark rounded-pill mr-1 mb-1"
                    onclick="actFilterGender(this)" value="1-non">
                <i class="fa fa-male"></i> {{ $non_departemen['total_laki_non'] }}
            </button>
            <button type="button" class="btn btn-sm btn-danger rounded-pill mr-1 mb-1"
                    onclick="actFilterGender(this)" value="2-non">
                <i class="fa fa-female"></i> {{ $non_departemen['total_perempuan_non'] }}
            </button>
        </div>
    </div>
</div>

{{-- Looping Departemen --}}
@foreach ($list_departemen as $dept)
<div class="d-flex align-items-center mb-3 p-2 shadow-sm rounded bg-white">
    <div class="rounded-circle d-flex align-items-center justify-content-center mr-2 flex-shrink-0"
        style="width: 48px; height: 48px; background-color: #e6ffe6;">
        <i class="ri-building-2-line" style="font-size: 24px; color:#28a745;"></i>
    </div>
    <div class="flex-fill">
        <h6 class="mb-1 text-secondary">{{ $dept['nm_dept'] }} | {{ $dept['get_master_divisi']['nm_divisi'] }}</h6>
        <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn btn-sm btn-primary rounded-pill mr-1 mb-1"
                    onclick="actFilter(this)" value="{{ $dept['id'] }}">
                {{ $dept['total'] }} Total
            </button>
            <button type="button" class="btn btn-sm btn-success rounded-pill mr-1 mb-1"
                    onclick="actFilterStatus(this)" value="aktif-{{ $dept['id'] }}">
                {{ $dept['total_aktif'] }} Aktif
            </button>
            <button type="button" class="btn btn-sm btn-danger rounded-pill mr-1 mb-1"
                    onclick="actFilterStatus(this)" value="nonaktif-{{ $dept['id'] }}">
                {{ $dept['total_tidak_aktif'] }} Non-Aktif
            </button>
            <button type="button" class="btn btn-sm btn-dark rounded-pill mr-1 mb-1"
                    onclick="actFilterGender(this)" value="1-{{ $dept['id'] }}">
                <i class="fa fa-male"></i> {{ $dept['total_laki'] }}
            </button>
            <button type="button" class="btn btn-sm btn-danger rounded-pill mr-1 mb-1"
                    onclick="actFilterGender(this)" value="2-{{ $dept['id'] }}">
                <i class="fa fa-female"></i> {{ $dept['total_perempuan'] }}
            </button>
        </div>
    </div>
</div>
@endforeach
</div>
{{-- /dept-summary-scroll --}}

