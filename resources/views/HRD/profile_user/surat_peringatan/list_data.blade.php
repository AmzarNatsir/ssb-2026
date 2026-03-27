<ul class="nav nav-tabs" id="myTab-1" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="st-tab" data-toggle="tab" href="#st" role="tab" aria-controls="st" aria-selected="true">Surat Teguran</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="sp-tab" data-toggle="tab" href="#sp" role="tab" aria-controls="sp" aria-selected="false">Surat Peringatan </code></a>
    </li>
</ul>
<div class="tab-content" id="myTabContent-2">
    <div class="tab-pane fade show active" id="st" role="tabpanel" aria-labelledby="st-tab">
        <p>Daftar Pengajuan Surat Teguran</p>
        <table class="table table-hover table-bordered list_st" role="grid" style="width:100%; font-size: 12px;">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 10%; text-align: center;">Pengajuan</th>
                    <th style="width: 25%; text-align: center;">Karyawan</th>
                    <th style="width: 25%; text-align: center;">Kejadian</th>
                    <th style="text-align:center; width:20%">Persetujuan</th>
                    <th style="text-align:center; width:15%">Act</th>
                </tr>
            </thead>
            <tbody>
                @php $nom=1 @endphp
            @foreach ($list_st as $list)
            <tr>
                <td>{{ $nom }}</td>
                <td class="text-center">{{ date('d-m-Y', strtotime($list->tanggal_pengajuan)) }}</td>
                <td>
                    <h5 class="mb-0"><a class="text-dark" href="#">{{ $list->get_karyawan->nik }} -{{ $list->get_karyawan->nm_lengkap }}</a></h5>
                    <p class="mb-1">{{ (!empty($list->get_karyawan->id_jabatan)) ? $list->get_karyawan->get_jabatan->nm_jabatan : "" }} / {{ (!empty($list->get_karyawan->id_departemen)) ? $list->get_karyawan->get_departemen->nm_dept : "" }}</p>
                </td>
                <td>
                    <h5 class="mb-0"><a class="text-dark" href="#">{{ $list->get_jenis_pelanggaran->jenis_pelanggaran }}</a></h5>
                    <div class="sellers-dt">
                        <span class="font-size-12">Tempat: <a href="#"> {{ $list->tempat_kejadian }}</a></span>
                        </div>
                        <div class="sellers-dt">
                        <span class="font-size-12">Waktu: <a href="#"> {{ date('d-m-Y', strtotime($list->tanggal_kejadian)) }} | {{ date('H:i', strtotime($list->waktu_kejadian)) }}</a></span>
                        </div>

                </td>
                <td class="text-center">
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
                    @elseif($list->sts_pengajuan==2)
                        <button type="button" class="btn btn-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-check"></i> Approved</button>
                    @else
                        <button type="button" class="btn btn-dark" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-times"></i> Rejected</button>
                    @endif
                </td>
                <td class="text-center">
                    @if($list->status_pengajuan==2)
                    <button type="button" class="btn btn-primary tbl_print-st" id="{{ $list->id }}" title="Print Surat Teguran" onClick="actPrintST(this);"><i class="fa fa-print"></i></button>
                    @endif
                </td>
            </tr>
            @php $nom++ @endphp
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="sp" role="tabpanel" aria-labelledby="sp-tab">
        <p>Daftar Pengajuan Surat Peringatan</p>
        <table class="table list_sp" style="width:100%">
            <tbody>
                @php $nom=1 @endphp
                @foreach ($list_sp as $list)
                <tr>
                    <td style="width: 5%; text-align:center; vertical-align: middle">
                        {{ $nom }}
                    </td>
                    <td style="vertical-align: middle">
                        <h5 class="mb-0">Jenis SP : {{ $list->get_master_jenis_sp_diajukan->nm_jenis_sp }}</h5>
                        <h6 class="mb-0">Uraian Pelanggaran : {{ $list->uraian_pelanggaran }}</h6>
                        </h6>
                    </td>
                    <td style="width: 5%; text-align:center;  vertical-align: middle">
                        <h5 class="mb-0">Status</h5>
                        <h6 class="mb-0">
                            @if($list->profil_karyawan->sp_active=='active')
                            <span class="badge badge-success">Aktif</span>
                            @else
                            <span class="badge badge-dark">Tidak Aktif</span>
                            @endif
                        </h6>
                    </td>
                    <td style="width: 30%; text-align:center;  vertical-align: middle">
                        <h5 class="mb-0">Masa Aktif</h5>
                        <h6 class="mb-0"><span class="badge badge-primary">{{ date('d-m-Y', strtotime($list->sp_mulai_active)) }}</span>  s/d <span class="badge badge-danger">{{ date('d-m-Y', strtotime($list->sp_akhir_active)) }}</span></h6>
                    </td>
                    <td style="width: 15%; text-align:center;  vertical-align: middle">
                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Tools
                                </button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <button type="button" class="dropdown-item tbl-detail-sp" data-toggle="modal" data-target="#modalFormDetail" id="{{ $list->id }}"><i class="fa fa-eye mr-2"></i>Detail</button>
                                    <button type="button" class="dropdown-item tbl_print" id="{{ $list->id }}" title="Print Surat Peringatan" onClick="actPrintSP(this);"><i class="fa fa-print"></i> Print</button>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @php $nom++ @endphp
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div id="modalFormDetail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content" id="v_form" style="overflow-y: auto;"></div>
    </div>
 </div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".list_sp").on("click", ".tbl-detail-sp", function(){
            var id_data = this.id;
            $("#v_form").load("{{ url('hrd/dataku/detailSP') }}/" + id_data);
        });
    });
    var actPrintST = function(el)
    {
        window.open("{{ url('hrd/suratperingatan/printST') }}/"+el.id);
    }
    var actPrintSP = function(el)
    {
        window.open("{{ url('hrd/suratperingatan/printsp') }}/"+el.id);
    }
</script>
