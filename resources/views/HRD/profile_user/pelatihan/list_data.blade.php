<table class="table table-striped table-bordered" style="width: 100%; font-size:13px">
    <thead class="thead-light">
        <th style="width: 5%">No</th>
        <th style="width: 5%">Act</th>
        <th style="width: 15%">Tanggal</th>
        <th>Pelatihan</th>
        <th style="width: 10%">Durasi</th>
        <th style="width: 10%">Kategori</th>
        <th style="width: 10%">Status</th>
    </thead>
    <tbody>
        @php $nom=1 @endphp
        @foreach($list_pelatihan as $item)
        @php
        $nama_pelatihan = ($item->kategori=='Internal') ? $item->get_nama_pelatihan->nama_pelatihan : $item->nama_pelatihan;
        $nama_vendor = ($item->kategori=='Internal') ? $item->get_pelaksana->nama_lembaga : $item->nama_vendor;
        @endphp
        <tr>
            <td>{{ $nom }}</td>
            <td>
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Opsi
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <button class="dropdown-item btn_detail" type="button" data-toggle="modal" data-target="#ModalForm" onclick="goDetail(this)" value="{{ $item->id }}"><i class="fa fa-eye mr-2"></i></i>Detail</button>
                            @if(empty($item->pasca))
                            <button class="dropdown-item btn_update" type="button" data-toggle="modal" data-target="#ModalFormUpdate" onclick="goUpdate(this)" value="{{ $item->id }}"><i class="fa fa-edit mr-2"></i></i>Update</button>
                            @else
                            <button class="dropdown-item btn_laporan" type="button" data-toggle="modal" data-target="#ModalFormUpdate" onclick="goLaporan(this)" value="{{ $item->id }}"><i class="fa fa-eye mr-2"></i></i>Detail Laporan Kegiatan</button>
                            @endif
                        </div>
                    </div>
                </div>
            </td>
            <td>{{ App\Helpers\Hrdhelper::get_tanggal_pelaksanaan($item->tanggal_awal, $item->tanggal_sampai, NULL, NULL) }}</td>
            <td>{{ $nama_pelatihan }}</td>
            <td>{{ $item->durasi }}</td>
            <td>{{ $item->kategori }}</td>
            <td style="text-align:center">
                @if($item->status_pelatihan==2)
                    <span class="badge badge-success"><i class='fa fa-check-circle'></i> Status : Disetujui</span>
                @elseif($item->status_pelatihan==4)
                    <span class="badge badge-info"><i class='fa fa-check-circle'></i> Status : Sedang Berlangsung</span>
                @elseif($item->status_pelatihan==5)
                    <span class="badge badge-info"><i class='fa fa-check-circle'></i> Status : Selesai</span>
                @else
                    <span class="badge badge-danger"><i class='fa fa-close'></i> Status : Pengajuan Ditolak</span>
                @endif
            </td>
        </tr>
        @php $nom++ @endphp
        @endforeach
    </tbody>
</table>
