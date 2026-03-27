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

<div class="row">
    <div class="col-lg-2 col-md-12">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height ">
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
        <!-- Non Departemen -->
        <div class="col-md-6 col-lg-4">
            <div class="d-flex align-items-center mb-4 p-3 shadow-sm rounded bg-white">
                <div class="rounded-circle d-flex align-items-center justify-content-center mr-3"
                    style="width: 60px; height: 60px; background-color: #f0f8ff;">
                    <i class="ri-group-line" style="font-size: 28px; color:#007bff;"></i>
                </div>
                <div class="flex-fill">
                    <h6 class="mb-1 text-secondary">Non Departemen</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn btn-sm btn-primary rounded-pill"
                                onclick="actFilter(this)" value="non">
                            {{ $non_departemen['total_non'] }} Total
                        </button>&nbsp;
                        <button type="button" class="btn btn-sm btn-success rounded-pill"
                                onclick="actFilter(this)" value="non">
                            {{ $non_departemen['total_aktif_non'] }} Aktif
                        </button>&nbsp;
                        <button type="button" class="btn btn-sm btn-danger rounded-pill"
                                onclick="actFilter(this)" value="non">
                            {{ $non_departemen['total_tidak_aktif_non'] }} Tidak Aktif
                        </button>
                        <div class="w-100 mb-1"></div>
                        <button type="button" class="btn btn-sm btn-dark rounded-pill"
                                onclick="actFilterGender(this)" value="1-non">
                            <i class="fa fa-male"></i> {{ $non_departemen['total_laki_non'] }}
                        </button>&nbsp;
                        <button type="button" class="btn btn-sm btn-danger rounded-pill"
                                onclick="actFilterGender(this)" value="2-non">
                            <i class="fa fa-female"></i> {{ $non_departemen['total_perempuan_non'] }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Looping Departemen -->
        @foreach ($list_departemen as $dept)
        <div class="col-md-6 col-lg-4">
            <div class="d-flex align-items-center mb-4 p-3 shadow-sm rounded bg-white">
                <div class="rounded-circle d-flex align-items-center justify-content-center mr-3"
                    style="width: 60px; height: 60px; background-color: #e6ffe6;">
                    <i class="ri-building-2-line" style="font-size: 28px; color:#28a745;"></i>
                </div>
                <div class="flex-fill">
                    <h6 class="mb-1 text-secondary">{{ $dept['nm_dept'] }} | {{ $dept['get_master_divisi']['nm_divisi'] }}</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn btn-sm btn-primary rounded-pill"
                                onclick="actFilter(this)" value="{{ $dept['id'] }}">
                            {{ $dept['total'] }} Total
                        </button>&nbsp;
                        <button type="button" class="btn btn-sm btn-success rounded-pill"
                                onclick="actFilter(this)" value="{{ $dept['id'] }}">
                            {{ $dept['total_aktif'] }} Aktif
                        </button>&nbsp;
                        <button type="button" class="btn btn-sm btn-danger rounded-pill"
                                onclick="actFilter(this)" value="{{ $dept['id'] }}">
                            {{ $dept['total_tidak_aktif'] }} Tidak Aktif
                        </button>
                        <div class="w-100 mb-1"></div>
                        <button type="button" class="btn btn-sm btn-dark rounded-pill"
                                onclick="actFilterGender(this)" value="1-{{ $dept['id'] }}">
                            <i class="fa fa-male"></i> {{ $dept['total_laki'] }}
                        </button>&nbsp;
                        <button type="button" class="btn btn-sm btn-danger rounded-pill"
                                onclick="actFilterGender(this)" value="2-{{ $dept['id'] }}">
                            <i class="fa fa-female"></i> {{ $dept['total_perempuan'] }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <!-- End Looping Departemen -->
        </div>
    </div>

</div>

