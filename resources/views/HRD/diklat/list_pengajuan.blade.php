<div class="iq-card">
    <div class="iq-card-header d-flex justify-content-between btn-outline-primary active">
        <div class="iq-header-title">
            <h4 class="card-title" style="color: white"><i class="fa fa-table"></i> Daftar Pengajuan</h4>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover datatable" style="width:100%; font-size: 13px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th style="width: 5%">Act.</th>
                    <th style="width: 10%;">Tgl.Pengajuan</th>
                    <th style="width: 10%;">Kategori</th>
                    <th style="width: 20%;">Nama&nbsp;Pelatihan</th>
                    <th style="width: 20%">Institusi&nbsp;Penyelenggara</th>
                    <th style="width: 10%; text-align: center">Biaya&nbsp;Investasi</th>
                    <th style="width: 5%">Peserta</th>
                    <th style="width: 10%; text-align: center">Total&nbsp;Investasi</th>
                    <th>Pelaksanaan</th>
                    <th>Durasi</th>
                    <th style="width: 5%">Status</th>
                </tr>
            </thead>
            <tbody>
                @php $nom=1; @endphp
                @foreach ($all_pengajuan as $item)
                    @php
                        $nama_pelatihan = ($item->kategori=='Internal') ? $item->get_nama_pelatihan->nama_pelatihan : $item->nama_pelatihan;
                        $nama_vendor = ($item->kategori=='Internal') ? $item->get_pelaksana->nama_lembaga : $item->nama_vendor;
                        $total_investasi = ($item->investasi_per_orang > 0) ? ($item->investasi_per_orang * count($item->get_peserta)) : 0;
                    @endphp
                    <tr>
                        <td>{{ $nom }}</td>
                        <td>
                            <div class="iq-card-header-toolbar d-flex align-items-center">
                                <div class="dropdown">
                                    <span class="dropdown-toggle text-primary" id="dropdownMenuButton40" data-toggle="dropdown">
                                        <a href="#" class="text-secondary"><i class="ri-more-2-line ml-3"></i></a>
                                    </span>
                                    <div class="dropdown-menu dropdown-menu-right p-0">
                                        @if(empty($item->status_pelatihan))
                                        <a class="dropdown-item" data-toggle="modal" data-target="#ModalForm" href="#ModalForm" onclick="goFormEdit(this)" id="{{ $item->id }}"><i class="ri-pencil-line mr-2"></i>Edit</a>
                                        <a class="dropdown-item" href="{{ url('hrd/pelatihan/deletepengajuan/'.$item->id) }}" onclick="return goDelete()"><i class="fa fa-trash mr-2"></i>Hapus</a>
                                        @else
                                        <a class="dropdown-item" href="{{ url('hrd/pelatihan/prosespelatihan/'.$item->id) }}" target="_new"><i class="ri-eye-line mr-2"></i>Detail</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>{{ date_format(date_create($item->created_at), 'd/m/Y') }}</td>
                        <td><div class="badge badge-pill {{ ($item->kategori=='Internal') ? "badge-dark" : "badge-danger" }}">{{ $item->kategori }}</div></td>
                        <td>{{ $nama_pelatihan }}</td>
                        <td>{{ $nama_vendor }}</td>
                        <td style="text-align:right">{{ number_format($item->investasi_per_orang, 0, ",", ".") }}</td>
                        <td>{{ count($item->get_peserta) }} Orang</td>
                        <td style="text-align:right">{{ number_format($total_investasi, 0, ",", ".") }}</td>
                        <td>{{ App\Helpers\Hrdhelper::get_tanggal_pelaksanaan($item->tanggal_awal, $item->tanggal_sampai, NULL, NULL) }}</td>
                        <td>{{ $item->durasi }}</td>
                        <td><div class="badge badge-pill badge-primary">Pengajuan</div></td>
                    </tr>
                    @php $nom++; @endphp
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('.datatable').DataTable();
    });
    var goFormEdit = function(el)
    {
        var id_data = el.id;
        $("#v_form").load("{{ url('hrd/pelatihan/edit_diklat')}}/"+id_data);
    }
</script>
