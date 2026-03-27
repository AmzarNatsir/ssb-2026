<table style="width: 100%; font-size:13px" id="table_lembur" class="table datatable">
    <thead>
        <th class="text-center">No.</th>
        <th class="text-center">Tanggal</th>
        <th class="text-center">Jam Mulai</th>
        <th class="text-center">Jam Selesai</th>
        <th class="text-center">Total Jam</th>
        <th>Deskripsi</th>
        <th>Status</th>
    </thead>
    <tbody>
        @php($no=1)
        @foreach ($list_data as $list)
        <tr>
            <td class="text-center">{{ $no }}</td>
            <td class="text-center">{{ date('d-m-Y', strtotime($list->tgl_pengajuan)) }}</td>
            <td class="text-center">{{ date('H:s', strtotime($list->jam_mulai)) }}</td>
            <td class="text-center">{{ date('H:s', strtotime($list->jam_selesai)) }}</td>
            <td class="text-center">{{ $list->total_jam }} Jam</td>
            <td>{{ $list->deskripsi_pekerjaan }}</td>
            <td>
                @if($list->status_pengajuan==1)
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
        </tr>
        @php($no++)
        @endforeach
    </tbody>
</table>

<div id="ModalForm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" id="v_inputan"></div>
    </div>
 </div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('.datatable').DataTable();
        $(".tbl-edit").on("click", function(){
            var id_data = this.id;
            $("#v_inputan").load("{{ url('hrd/dataku/formEditPengajuanIzin') }}/" + id_data);
        });
        $(".tbl-detail").on("click", function(){
            var id_data = this.id;
            $("#v_inputan").load("{{ url('hrd/dataku/formDetailPengajuanIzin') }}/" + id_data);
        })
    });
</script>
