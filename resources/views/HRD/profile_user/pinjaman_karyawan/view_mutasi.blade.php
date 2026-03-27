<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Preview Mutasi Pinjaman</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <div class="iq-card-body" style="width:100%; height:auto">
        <div class="iq-card">
            <div class="row">
                <div class="col-sm-6 col-lg-6">
                    <ul class="list-group">
                        <li class="list-group-item disabled" aria-disabled="true">NIK : <b>{{ $data->getKaryawan->nik }}</b></li>
                        <li class="list-group-item">Nama Karyawan : <b>{{ $data->getKaryawan->nm_lengkap }}</b></li>
                        <li class="list-group-item">Jabatan : <b>{{ $data->getKaryawan->get_jabatan->nm_jabatan }}</b></li>
                        <li class="list-group-item">Departemen : <b>{{ $data->getKaryawan->get_departemen->nm_dept }}</b></li>
                        <li class="list-group-item disabled" aria-disabled="true">Kategori Pinjaman : <b>{{ ($data->kategori==1) ? "Panjar Gaji" : "Pinjaman Kesejahteraan Karyawan (PKK)" }}</b></li>
                        <li class="list-group-item">Jumlah Pinjaman : <b>Rp. {{ number_format($data->nominal_apply, 0) }}</b></li>
                        <li class="list-group-item">Tenor : <b>{{ $data->tenor_apply }} Bulan</b></li>
                        <li class="list-group-item">Alasan Pengajuan : <b>{{ $data->alasan_pengajuan }}</b></li>
                    </ul>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title">Riwayat Pembayaran</h4>
                           </div>
                        </div>
                        <div class="iq-card-body">
                            <table class="table table-sm" style="width: 100%">
                                <thead>
                                    <th style="width: 5%">No.</th>
                                    <th style="width: 20%">Tanggal</th>
                                    <th style="width: 30%; text-align: right">Angsuran</th>
                                    <th style="width: 30%; text-align: right">Oustanding</th>
                                    <th style="width: 15%">Status</th>
                                </thead>
                                <tbody>
                                    @php($nom=1)
                                    @php($sisa = $data->nominal_apply)
                                    @foreach ($data->getMutasi as $row)
                                        @if($nom==1)
                                            @if($row->status==1)
                                                @php($sisa-=$row->nominal)
                                            @else
                                                @php($sisa = $sisa)
                                            @endif
                                        @else
                                            @if($row->status==1)
                                                @php($sisa-=$row->nominal)
                                            @else
                                                @php($sisa=0)
                                            @endif
                                        @endif
                                        @if($sisa < 0)
                                            @php($sisa=0)
                                        @endif
                                        <tr>
                                            <td>{{ $nom }}</td>
                                            <td>{{ (!empty($row->tanggal)) ? date('d-m-Y', strtotime($row->tanggal)) : "" }}</td>
                                            <td style="text-align: right">{{ number_format($row->nominal, 0) }}</td>
                                            <td style="text-align: right">{{ number_format($sisa, 0) }}</td>
                                            <td style="text-align: center">
                                                @if($row->status==1)
                                                    <button type="button" class="btn btn-outline-success active px-4"><i class="fa fa-check"></i></button>
                                                @endif
                                            </td>
                                        </tr>
                                        @php($nom++)
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function()
    {
        $(".angka").number(true, 0);
    });
</script>
