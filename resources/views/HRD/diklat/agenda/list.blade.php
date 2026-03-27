<div class="iq-card">
    <div class="iq-card-header d-flex justify-content-between btn-outline-success active">
        <div class="iq-header-title">
            <h4 class="card-title" style="color: white"><i class="fa fa-table"></i> Agenda Pelatihan Tahun {{ date("Y") }}</h4>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-hover datatable" style="width:100%; font-size: 12px;">
            <thead>
                <tr>
                    <th scope="col" rowspan="2" style="width: 5%">#</th>
                    <th scope="col" rowspan="2" style="width: 5%"></th>
                    <th scope="col" rowspan="2" style="width: 10%;">Kategori</th>
                    <th scope="col" rowspan="2" style="width: 20%;">Nama Pelatihan</th>
                    <th scope="col" rowspan="2" style="width: 20%">Vendor/Pelaksana</th>
                    <th scope="col" rowspan="2" style="width: 15%;">Tempat Pelaksanaan</th>
                    <th scope="col" colspan="2" style="text-align: center">Pelaksanaan</th>
                    <th scope="col" rowspan="2" style="width: 5%"></th>
                </tr>
                <tr>
                    <th>Hari/Tanggal</th>
                    <th>Durasi</th>
                </tr>
            </thead>
            <tbody>
                @php $nom=1; @endphp
                @foreach ($all_pelatihan as $item)
                    @php
                    $nama_pelatihan = ($item->kategori=='Internal') ? $item->get_nama_pelatihan->nama_pelatihan : $item->nama_pelatihan;
                    $nama_vendor = ($item->kategori=='Internal') ? $item->get_pelaksana->nama_lembaga : $item->nama_vendor;
                    @endphp
                    <tr class="iq-email-sender-info">
                        <td>{{ $nom }}</td>
                        <td style="text-align: center">
                            @if(!empty($item->nomor))
                            <h3 class="badge badge-success" title="Registered"><i class="fa fa-check"></i></h3>
                            @endif
                        </td>
                        <td>{{ $item->kategori }}</td>
                        <td>{{ $nama_pelatihan }}</td>
                        <td>{{ $nama_vendor }}</td>
                        <td>{{ $item->tempat_pelaksanaan }}</td>
                        <td>@if($item->tanggal_awal==$item->hari_sampai)
                            {{ App\Helpers\Hrdhelper::get_hari($item->tanggal_awal) }}
                            @else
                            {{ App\Helpers\Hrdhelper::get_hari_ini($item->tanggal_awal). " - ".App\Helpers\Hrdhelper::get_hari_ini($item->tanggal_sampai) }}
                            @endif
                            , {{ App\Helpers\Hrdhelper::get_tanggal_pelaksanaan($item->tanggal_awal, $item->tanggal_sampai, $item->hari_awal, $item->hari_sampai) }}</td>
                        <td>{{ $item->durasi }}</td>
                        <td>
                            <div class="iq-card-header-toolbar d-flex align-items-center">
                                <div class="dropdown">
                                <span class="dropdown-toggle text-primary" id="dropdownMenuButton40" data-toggle="dropdown">
                                    <a href="#" class="text-secondary"><i class="ri-more-2-line ml-3"></i></a>
                                </span>
                                <div class="dropdown-menu dropdown-menu-right p-0">
                                    <button class="dropdown-item btn_detail" type="button" data-toggle="modal" data-target="#modalFormDetail" onclick="goDetail(this)" value="{{ $item->id }}"><i class="fa fa-eye mr-2"></i></i>Detail</button>
                                    @if(empty($item->nomor) || ($item->status_pelatihan >=2  || $item->status_pelatihan < 5))
                                        <button class="dropdown-item btn_proses" type="button" onclick="goProses(this)" value="{{ $item->id }}"><i class="fa fa-edit mr-2"></i></i>Proses</button>
                                    @endif
                                    @if(!empty($item->nomor))
                                        <button class="dropdown-item btn_print" type="button" onclick="goPrint(this)" value="{{ $item->id }}"><i class="fa fa-print mr-2"></i></i>Print</button>
                                    @endif
                                </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @php $nom++; @endphp
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div id="modalFormDetail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" id="v_detail" style="overflow-y: auto;"></div>
    </div>
 </div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('.datatable').DataTable();
    });
    var goDetail = function(el)
    {
        var id_data = $(el).val();
        $("#v_detail").load("{{ url('hrd/pelatihan/goFormDetail') }}/"+id_data);
    }
    var goProses = function(el)
    {
        var id_data = $(el).val();
        window.open("{{ url('hrd/pelatihan/prosespelatihan') }}/"+id_data)
        // $("#v_detail").load("{{ url('hrd/pelatihan/prosespelatihan') }}/"+id_data);
    }
    var goPrint = function(el) {
        var id_data = $(el).val();
        window.open('{{ url("hrd/pelatihan/print_spp") }}/'+id_data);
    }
</script>
