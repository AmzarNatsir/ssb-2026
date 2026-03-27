<ul class="iq-timeline">
    @foreach ($listPayroll as $item)
    <li>
        <div class="timeline-dots border-success"></div>
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <h6 class="float-left mb-1">Periode</h6>
                    <div class="d-inline-block w-100">
                        <h3>{{ \App\Helpers\Hrdhelper::get_nama_bulan($item->bulan) }} {{ $item->tahun }}</h3>
                    </div>
                </div>
                <div class="col col-lg-1">
                    <div class="iq-card-header-toolbar d-flex align-items-center float-right">
                        <div class="dropdown">
                            <span class="dropdown-toggle text-primary" id="dropdownMenuButton40" data-toggle="dropdown">
                                <a href="#" class="text-secondary"><i class="ri-more-2-line ml-3"></i></a>
                            </span>
                            <div class="dropdown-menu dropdown-menu-right p-0">
                                <a class="dropdown-item" data-toggle="modal" data-target="#ModalForm" onclick="goDetail(this)" id="{{ $item['id'] }}"><i class="ri-table-line mr-2"></i>Detail</a>
                                <a class="dropdown-item" href="{{ url('hrd/penggajian/slipgaji_print_slip/'.\App\Helpers\Hrdhelper::encrypt_decrypt('encrypt', $item->id)) }}" target="_new"><i class="ri-table-line mr-2"></i>Slip</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    </li>
    @endforeach
</ul>
