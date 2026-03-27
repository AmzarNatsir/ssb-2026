<div class="row row-eq-height">
    <div class="col-lg-2 col-md-12">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height wow fadeInUp" data-wow-delay="0.6s">
            <div class="iq-card-body">
               <div class="row">
                  <div class="col-lg-12 mb-2 d-flex justify-content-between">
                     <div class="icon iq-icon-box rounded-circle iq-bg-primary rounded-circle" data-wow-delay="0.2s">
                        <i class="ri-group-line"></i>
                     </div>
                  </div>
                  <div class="col-lg-12 mt-3">
                     <h6 class="card-title text-uppercase text-secondary mb-0">Total Karyawan</h6>
                     <span class="h2 text-success mb-0 counter d-inline-block w-100">{{ $total_karyawan }}</span>
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
                                            <button type="button" class="btn btn-warning badge badge-warning badge-pill" onclick="actFilter(this)" value="non">{{ $non_departemen['total_non'] }} Orang</button> |
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
                                        <p class="mb-0">{{ $dept['nm_dept'] }}</p>
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
</div>
