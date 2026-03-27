<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Detail Pengajuan Izin</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <form action="{{ url('hrd/dataku/pengajuanIzinCancel/'.$res->id) }}" method="post" onsubmit="return konfirm()">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="form-group row">
        <label class="col-sm-4">Jenis Izin</label>
        <div class="col-sm-8">
            <select class="form-control select2" name="pil_jenis_izin" id="pil_jenis_izin" style="width: 100%;" disabled>
                <option value="0">Pilihan</option>
                @foreach($res_jenis_izin as $jenis)
                @if($jenis->id==$res->id_jenis_izin)
                <option value="{{ $jenis->id }}" selected>{{ $jenis->nm_jenis_ci }}</option>
                @else
                <option value="{{ $jenis->id }}">{{ $jenis->nm_jenis_ci }}</option>
                @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4">Tanggal Mulai Izin</label>
        <div class="col-sm-8">
            <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control" value="{{ $res->tgl_awal }}" disabled>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4">Tanggal Akhir Izin</label>
        <div class="col-sm-8">
            <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" value="{{ $res->tgl_akhir }}" disabled>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4">Jumlah Hari</label>
        <div class="col-sm-8">
            <input type="text" name="inp_jumlah_hari" id="inp_jumlah_hari" class="form-control" value="{{ $res->jumlah_hari }}" disabled>
        </div>
    </div>
    <div class="alert text-white bg-danger" role="alert" id="danger-alert" style="display: none;">
        <div class="iq-alert-icon">
            <i class="ri-alert-line"></i>
        </div>
        <div class="iq-alert-text"></div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4">Keterangan</label>
        <div class="col-sm-8">
            <textarea class="form-control" name="keterangan" id="keterangan" disabled>{{ $res->ket_izin }}</textarea>
        </div>
    </div>
    <div class="iq-card-header d-flex justify-content-between">
        <div class="iq-header-title">
           <h4 class="card-title">Hirarki Persetujuan</h4>
        </div>
    </div>
    <div class="iq-card-body">
        <table class="table" style="width: 100%; font-size: 12px">
            <thead>
            <tr>
                <th rowspan="2" style="width: 5%">Level</th>
                <th rowspan="2">Pejabat</th>
                <th colspan="3" class="text-center">Persetujuan</th>
            </tr>
            <tr>
                <th class="text-left">Tanggal</th>
                <th class="text-left">Keterangan</th>
                <th class="text-center">Status</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($hirarki_persetujuan as $list)
                <tr>
                    <td class="text-center">
                        @if($list->approval_active==1)
                        <h4><span class="badge badge-pill badge-success">{{ $list->approval_level }}</span></h4>
                        @else
                        <h4><span class="badge badge-pill badge-danger">{{ $list->approval_level }}</span></h4>
                        @endif
                    </td>
                    <td>{{ $list->get_profil_employee->nm_lengkap }}<br>
                        {{ $list->get_profil_employee->get_jabatan->nm_jabatan }}</td>
                    <td>
                        {{ (empty($list->approval_date)) ? "" : date('d-m-Y', strtotime($list->approval_date))  }}
                    </td>
                    <td>{{ $list->approval_remark }}</td>
                    <td class="text-center">
                        @if($list->approval_status==1)
                        <h4><span class="badge badge-pill badge-success">Approved</span></h4>
                        @elseif($list->approval_status==2)
                        <h4><span class="badge badge-pill badge-danger">Rejected</span></h4>
                        @else

                        @endif
                        </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        @if($res->is_draft==1)
        <button type="submit" class="btn btn-danger">Batal Pengajuan</button>
        @endif
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
    </form>
</div>
<script type="text/javascript">
    function konfirm()
    {
        var psn = confirm("Yakin data akan membatalkan pengajuan izin anda ?");
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
</script>
