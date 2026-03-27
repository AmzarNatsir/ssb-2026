<table style="width: 100%" id="table_cuti">
    @foreach ($list_cuti as $cuti)
    <tr>
        <td style="width: 80%"><h4>{{ $cuti->get_jenis_cuti->nm_jenis_ci }}</h4><p>{{ $cuti->ket_cuti }}</p><span class="badge badge-primary"><i class='fa fa-clock-o'></i> {{ date('d-m-Y', strtotime($cuti->tgl_awal)).' s/d '.date('d-m-Y', strtotime($cuti->tgl_akhir)) }} | Durasi : {{ $cuti->jumlah_hari }} hari</span>
        @if(empty($cuti->sts_pengajuan))
            @if(date("Y-m-d") > date_format(date_create($cuti->tgl_awal), 'Y-m-d'))
                <span class="badge badge-danger"><i class="fa fa-close"></i> Status : Expired</span>
            @else
                <span class="badge badge-warning"><i class='fa fa-clock-o'></i> Status : Pengajuan</span>
            @endif
        @elseif($cuti->sts_pengajuan==1)
            <span class="badge badge-pill badge-warning">Menunggu Persetujuan : {{ $cuti->get_current_approve->nm_lengkap }} - {{ $cuti->get_current_approve->get_jabatan->nm_jabatan }}</span>
        @elseif($cuti->sts_pengajuan==2)
            <span class="badge badge-success"><i class='fa fa-check-circle'></i> Status : Disetujui</span>
        @else
            <span class="badge badge-danger"><i class='fa fa-close'></i> Status : Pengajuan Ditolak</span>
        @endif
        </td>
        <td style="text-align: right; vertical-align: middle">
        @if($cuti->is_draft==1 && date("Y-m-d") < date_format(date_create($cuti->tgl_awal), 'Y-m-d'))
            <button type="button" class="btn btn-primary tbl-edit" data-toggle="modal" data-target="#ModalForm" id="{{ $cuti->id }}" name="btn-edit[]" data-placement="top" title="Edit Pengajuan"><i class="las la-edit"></i></button>
            <button type="button" class="btn btn-danger tbl-detail" data-toggle="modal" data-target="#ModalForm" id="{{ $cuti->id }}" name="btn-detail[]" data-placement="top" title="Batal Pengajuan"><i class="las la-times"></i></button>
        @else
            <button type="button" class="btn btn-success tbl-detail" data-toggle="modal" data-target="#ModalForm" id="{{ $cuti->id }}" name="btn-detail[]" data-placement="top" title="Detail Pengajuan"><i class="las la-eye"></i></button>
        @endif
        </td>
    </tr>
    @endforeach
</table>
<div id="ModalForm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" id="v_inputan"></div>
    </div>
 </div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $(".tbl-edit").on("click", function(){
            var id_data = this.id;
            $("#v_inputan").load("{{ url('hrd/dataku/formEditPengajuanCuti') }}/" + id_data);
        });
        $(".tbl-detail").on("click", function(){
            var id_data = this.id;
            $("#v_inputan").load("{{ url('hrd/dataku/formDetailPengajuanCuti') }}/" + id_data);
        })
    });
</script>
