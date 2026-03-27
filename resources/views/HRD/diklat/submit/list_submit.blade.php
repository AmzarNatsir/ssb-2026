<div class="iq-card">
    <div class="iq-card-header d-flex justify-content-between btn-outline-primary active">
        <div class="iq-header-title">
            <h4 class="card-title" style="color: white"><i class="fa fa-table"></i> Monitoring Persetujuan Pengajuan Pelatihan</h4>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-hover" style="width:100%; font-size: 13px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th style="width: 10%;">Pengajuan</th>
                    <th style="width: 10%;">Periode</th>
                    <th>Deskripsi</th>
                    <th style="width: 10%;">Jumlah&nbsp;Pelatihan</th>
                    <th style="text-align: center; width: 20%">Status</th>
                </tr>
            </thead>
            <tbody>
                @php $nom=1; @endphp
                @foreach ($all_submit as $item)
                    <tr>
                        <td>{{ $nom }}</td>
                        <td>{{ date_format(date_create($item->created_at), 'd/m/Y') }}</td>
                        <td>{{ $item->tahun }}</td>
                        <td>{{ $item->deskripsi }}</td>
                        <td style="width: 10%; text-align: center">{{ $item->get_detail()->get()->count() }}</td>
                        <td style="text-align: center;">
                            @if($item->status_pengajuan==1)
                                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                    <div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Menunggu Persetujuan
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                            <a class="dropdown-item" href="#"><i class="fa fa-user mr-1"></i>{{ $item->get_current_approve->nm_lengkap }}</a>
                                            <a class="dropdown-item" href="#"><i class="fa fa-user mr-1"></i>{{ $item->get_current_approve->get_jabatan->nm_jabatan }}</a>
                                        </div>
                                    </div>
                                </div>
                            @elseif($item->status_pengajuan==2)
                                <button type="button" class="btn btn-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-check"></i> Approved</button>
                            @else
                                <button type="button" class="btn btn-dark" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-times"></i> Rejected</button>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <div id="card-slider" class="row">
                                @foreach ($item->get_detail()->get() as $detail)
                                <div class="col-md-6">
                                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                        <div class="iq-card-body">
                                            <div class="bg-cobalt-blue p-3 rounded d-flex align-items-center justify-content-between mb-3">
                                                <h5 class="text-white">
                                                    @if(empty($detail->getPelatihan->id_pelatihan))
                                                    {{ $detail->getPelatihan->nama_pelatihan }}
                                                    @else
                                                    {{ $detail->getPelatihan->get_nama_pelatihan->nama_pelatihan }}
                                                    @endif
                                                </h5>
                                            </div>
                                            <h4 class="mb-3 border-bottom">{{ substr($detail->getPelatihan->kompetensi, 0, 100) }} ...</h4>
                                            <div class="row align-items-center justify-content-between mt-3">
                                                <div class="col-sm-7">
                                                    <p class="mb-0">Vendor : </p>
                                                    <h6>
                                                        @if(empty($detail->getPelatihan->id_pelaksana))
                                                        {{ $detail->getPelatihan->nama_vendor}}
                                                        @else
                                                        {{ $detail->getPelatihan->get_pelaksana->nama_lembaga}}
                                                        @endif
                                                    </h6>
                                                </div>
                                                <div class="col-sm-5">
                                                    <h6 class="mb-0"><i class="fa fa-calendar"></i> {{ App\Helpers\Hrdhelper::get_tanggal_pelaksanaan($detail->getPelatihan->tanggal_awal, $detail->getPelatihan->tanggal_sampai, NULL, NULL) }}</h6>
                                                    <h6 class="mb-0"><i class="fa fa-clock-o"></i> {{ $detail->getPelatihan->durasi}}</h6>
                                                    <h6 class="mb-0"><i class="fa fa-user"></i> {{ $detail->getPelatihan->get_peserta->count() }} <span>Peserta</span></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
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
        $('#spinner-div').hide();
        // $('.datatable').DataTable();
    });
    var goFormEdit = function(el)
    {
        var id_data = el.id;
        $("#v_form").load("{{ url('hrd/pelatihan/edit_diklat')}}/"+id_data);
    }
</script>
