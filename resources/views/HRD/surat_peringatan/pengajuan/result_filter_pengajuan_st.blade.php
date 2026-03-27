<p>Daftar Pengajuan Surat Teguran</p>
<table class="table list_st" style="width:100%">
    <tbody>
        @php $nom=1 @endphp
        @foreach ($list_pengajuan as $list)
        <tr>
            <td style="width: 10%; vertical-align: middle">
                @if(!empty($list->get_karyawan->photo))
                <img src="{{ url(Storage::url('hrd/photo/'.$list->get_karyawan->photo)) }}"
                    class="rounded-circle" alt="avatar" style="width: 80px; height: auto;">
                @else
                <a href="{{ asset('assets/images/user/1.jpg') }}" data-fancybox data-caption="avatar">
                <img src="{{ asset('assets/images/user/1.jpg') }}"
                    class="rounded-circle" alt="avatar" style="width: 80px; height: auto;"></a>
                @endif
            </td>
            <td style="width: 20%">
                <h4 class="mb-0">{{ $list->get_karyawan->nm_lengkap }}</h4>
                <h6 class="mb-0">{{ $list->get_karyawan->get_jabatan->nm_jabatan }} | {{ $list->get_karyawan->get_departemen->nm_dept }}</h6>
            </td>
            <td>
                <h4 class="mb-0">Jenis Pelanggaran : {{ $list->get_jenis_pelanggaran->jenis_pelanggaran }}</h4>
                <h6 class="mb-0">Tempat : <span class="text-danger">{{ $list->tempat_kejadian }}</span></span></h6>
                </h6>
                <h6 class="mb-0">Waktu : <span class="text-danger">{{ date('d-m-Y', strtotime($list->tanggal_kejadian)) }} | {{ date('H:i', strtotime($list->waktu_kejadian)) }}</span></h6>
                </h6>
            </td>
            <td style="width: 10%; vertical-align: middle">
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
                    <button type="button" class="btn btn-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-check"></i> Approved</button>
                @else
                    <button type="button" class="btn btn-dark" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-times"></i> Rejected</button>
                @endif
            </td>
            <td style="width: 5%; vertical-align: middle">
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Tools
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            @if($list->is_draft==1)
                                <button type="button" class="dropdown-item tbl-edit-st" data-toggle="modal" data-target="#modalFormPengajuanST" id="{{ $list->id }}" name="btn-edit[]" data-placement="top" title="Edit Pengajuan"><i class="las la-edit"></i> Edit Pengajuan</button>
                                <button type="button" class="dropdown-item tbl-cancel-st" data-toggle="modal" data-target="#modalFormPengajuanST" id="{{ $list->id }}" name="btn-cancel[]" data-placement="top" title="Batal Pengajuan"><i class="las la-times"></i> Batal Pengajuan</button>
                            @else
                                <button type="button" class="dropdown-item tbl-detail-st" tbl-detail-st id="{{ $list->id }}" data-toggle="modal" data-target="#modalFormPengajuanST" name="btn-detail[]" title="Detail"><i class="fa fa-eye"></i> Detail Pengajuan</button>
                            @endif
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        @php $nom++ @endphp
        @endforeach
    </tbody>
</table>
<div id="modalFormPengajuanST" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content" id="v_inputan_st" style="overflow-y: auto;"></div>
    </div>
 </div>
 <script type="text/javascript">
    $(document).ready(function()
    {
        $(".list_st").on("click", ".tbl-edit-st", function(){
            var id_data = this.id;
            $("#v_inputan_st").load("{{ url('hrd/suratperingatan/formEditPengajuanST') }}/" + id_data);
        });
        $(".list_st").on("click", ".tbl-cancel-st", function(){
            var id_data = this.id;
            $("#v_inputan_st").load("{{ url('hrd/suratperingatan/formDetailPengajuanST') }}/" + id_data);
        });
        $(".list_st").on("click", ".tbl-detail-st", function(){
            var id_data = this.id;
            $("#v_inputan_st").load("{{ url('hrd/suratperingatan/formDetailPengajuanST') }}/" + id_data);
        });
    });
</script>

