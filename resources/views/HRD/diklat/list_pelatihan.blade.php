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
                    <th scope="col" rowspan="2">#</th>
                    <th scope="col" rowspan="2" style="width: 10%;">Nomor/Tanggal Surat</th>
                    <th scope="col" rowspan="2" style="width: 20%;">Nama Pelatihan</th>
                    <th scope="col" rowspan="2" style="width: 15%">Lembaga Pelaksana</th>
                    <th scope="col" rowspan="2" style="width: 15%;">Tempat Pelaksanaan</th>
                    <th scope="col" colspan="2" style="text-align: center">Pelaksanaan</th>
                    <th scope="col" rowspan="2" style="width: 10%; text-align: center">Jumlah Peserta</th>
                    <th scope="col" rowspan="2" style="width: 5%"></th>
                </tr>
                <tr>
                    <th>Hari/Tanggal</th>
                    <th>Jam</th>
                </tr>
            </thead>
            <tbody>
                @php $nom=1; @endphp
                @foreach ($all_pelatihan as $item)
                    <tr>
                        <td>{{ $nom }}</td>
                        <td>{{ $item->nomor }} | {{ date_format(date_create($item->tanggal), 'd/m/Y') }}</td>
                        <td>{{ $item->get_nama_pelatihan->nama_pelatihan }}</td>
                        <td>{{ $item->get_pelaksana->nama_lembaga }}</td>
                        <td>{{ $item->tempat_pelaksanaan }}</td>
                        <td>@if($item->tanggal_awal==$item->hari_sampai)
                            {{ App\Helpers\Hrdhelper::get_hari($item->tanggal_awal) }}
                            @else
                            {{ App\Helpers\Hrdhelper::get_hari_ini($item->tanggal_awal). " - ".App\Helpers\Hrdhelper::get_hari_ini($item->tanggal_sampai) }}
                            @endif
                            , {{ App\Helpers\Hrdhelper::get_tanggal_pelaksanaan($item->tanggal_awal, $item->tanggal_sampai, $item->hari_awal, $item->hari_sampai) }}</td>
                        <td>{{ substr($item->pukul_awal, 0, 5).' s/d '.substr($item->pukul_sampai, 0, 5) }}</td>
                        <td>{{ $item->get_detail()->count() }} Peserta</td>
                        <td>
                            <div class="iq-card-header-toolbar d-flex align-items-center">
                                <div class="dropdown">
                                <span class="dropdown-toggle text-primary" id="dropdownMenuButton40" data-toggle="dropdown">
                                    <a href="#" class="text-secondary"><i class="ri-more-2-line ml-3"></i></a>
                                </span>
                                <div class="dropdown-menu dropdown-menu-right p-0">
                                    <!-- <a class="dropdown-item" href="{{ url('hrd/pelatihan/edit_diklat/'.$item->id) }}" target="_new"><i class="ri-pencil-line mr-2"></i>Edit</a>
                                    <a class="dropdown-item" href="{{ url('hrd/pelatihan/delete_spp/'.$item->id) }}" onclick="return goDelete()"><i class="fa fa-trash mr-2"></i>Hapus</a> -->
                                    @if($item->status_pelatihan > 2)
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
<script type="text/javascript">
    $(document).ready(function()
    {
        $('.datatable').DataTable();
    });
</script>
