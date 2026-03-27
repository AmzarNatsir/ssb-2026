<div class="list-group">
    @foreach ($list_pengajuan as $list)
    <a href="javascript:" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#ModalForm" onclick="goDetail({{ $list->id }})">
       <div class="d-flex w-100 justify-content-between">
          <h5 class="mb-1 text-white">List group item heading</h5>
          <small class="badge badge-danger"><i class="fa fa-calendar"></i> {{ date('d-m-Y', strtotime($list->tanggal_pengajuan)) }}</small>
       </div>
       <p class="mb-1">{{ $list->alasan_permintaan }}</p>
       <p class="mb-1">Posisi : {{ $list->get_jabatan->nm_jabatan }}</p>
       <table class="table" style="width: 100%">
        <tr>
            <td style="width: 50%"><h6 class="mb-0"><i class="fa fa-calendar"></i> Dibutuhkan tanggal : {{ date('d-m-Y', strtotime($list->tanggal_dibutuhkan)) }}</h6></td>
            <td><h6 class="mb-0"><i class="fa fa-user"></i> Jumlah : {{ $list->jumlah_orang }} orang</h6></td>
        </tr>
        <tr>
            <td colspan="2"><h6 class="mb-0"><i class="fa fa-clock-o"></i> Status Pengajuan :
                @if($list->status_pengajuan==1)
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Menunggu Persetujuan
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <a class="dropdown-item" href="#"><i class="fa fa-user mr-1"></i>{{ $list->get_current_approve->nm_lengkap }}</a>
                                <a class="dropdown-item" href="#"><i class="fa fa-user mr-1"></i>{{ $list->get_current_approve->get_jabatan->nm_jabatan }}</a>
                            </div>
                        </div>
                    </div>
                    @elseif($list->status_pengajuan==2)
                    <span class="badge badge-success">Disetujui</span>
                    @else
                    <span class="badge badge-danger">Ditolak</span>
                    @endif
            </h6></td>
        </tr>
    </table>
    </a>
    @endforeach
</div>
