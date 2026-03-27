<div class="iq-card">
    <div class="iq-card-header d-flex justify-content-between btn-outline-success active">
        <div class="iq-header-title">
            <h4 class="card-title" style="color: white"><i class="fa fa-user"></i> Daftar Laporan Kegiatan Pasca Pelatihan</h4>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-striped table-bordered" style="width: 100%; font-size:13px">
            <thead class="thead-light">
                <th style="width: 5%">No</th>
                <th style="width: 5%">Act</th>
                <th style="width: 15%">Tanggal Pelatihan</th>
                <th>Pelatihan</th>
                <th style="width: 10%">Kategori</th>
                <th style="width: 10%">Dilaporkan Tanggal</th>
            </thead>
            <tbody>
                @php $nom=1 @endphp
                @foreach($list_laporan as $item)
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
                                    <button class="dropdown-item btn_detail_pasca" type="button" data-toggle="modal" data-target="#ModalFormPasca" onclick="goDetailPasca(this)" value="{{ $item->id }}"><i class="fa fa-eye mr-2"></i></i>Detail</button>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>{{ App\Helpers\Hrdhelper::get_tanggal_pelaksanaan($item->tanggal_awal, $item->tanggal_sampai, NULL, NULL) }}</td>
                    <td>{{ $nama_pelatihan }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td>{{ date('d-m-Y', strtotime($item->updated_at)) }}</td>
                </tr>
                @php $nom++ @endphp
                @endforeach
            </tbody>
        </table>
    </div>
</div>
