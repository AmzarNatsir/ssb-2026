<table style="width: 100%; font-size:13px" id="table_pengajuan" class="table datatable">
    <thead>
        <th class="text-center">No.</th>
        <th class="text-center">Nomor</th>
        <th class="text-center">Tgl.Pengajuan</th>
        <th class="text-left">Kategori</th>
        <th class="text-left">Alasan Pengajuan</th>
        <th class="text-right">Nominal</th>
        <th class="text-right">Tenor</th>
        <th class="text-right">Angsuran</th>
        <th>Status</th>
        <th></th>
    </thead>
    <tbody>
        @php($no=1)
        @foreach ($list_data as $list)
        <tr>
            <td class="text-center">{{ $no }}</td>
            <td class="text-center">{{ sprintf("%'.06d\n", $list->id) }}</td>
            <td class="text-center">{{ date('d-m-Y', strtotime($list->tgl_pengajuan)) }}</td>
            <td class="text-left">{{ ($list->kategori==1) ? "Panjar Gaji" : "Pinjaman Kesejahteraan Karyawan (PKK)" }}</td>
            <td class="text-left">{{ $list->alasan_pengajuan }}</td>
            <td class="text-right">{{ number_format($list->nominal_apply, 0) }}</td>
            <td class="text-right">{{ $list->tenor_apply }} Bulan</td>
            <td class="text-right">{{ number_format($list->angsuran, 0) }}</td>
            <td>
            @if($list->status_pengajuan==1)
                <span class="badge badge-pill badge-danger">Menunggu Persetujuan : {{ $list->get_current_approve->nm_lengkap }}</span>
                <span class="badge badge-pill badge-success">{{ $list->get_current_approve->get_jabatan->nm_jabatan }}</span>
            @elseif($list->status_pengajuan==2)
                <span class="badge badge-success">Disetujui</span>
            @else
                <span class="badge badge-danger">Ditolak</span>
            @endif</td>
            <td><button type="button" class="btn btn-outline-danger btn-sm active px-3" data-toggle="modal" data-target="#ModalForm" id="{{ $list->id }}" title="Mutasi Pinjaman" onclick="getMutasi(this)"><i class="fa fa-list"></i></button></td>
        </tr>
        @php($no++)
        @endforeach
    </tbody>
</table>
<div id="ModalForm" class="modal fade bg-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" id="v_form"></div>
    </div>
 </div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('.datatable').DataTable();
        // $(".tbl-edit").on("click", function(){
        //     var id_data = this.id;
        //     $("#v_inputan").load("{{ url('hrd/dataku/formEditPengajuanIzin') }}/" + id_data);
        // });
        // $(".tbl-detail").on("click", function(){
        //     var id_data = this.id;
        //     $("#v_inputan").load("{{ url('hrd/dataku/formDetailPengajuanIzin') }}/" + id_data);
        // })
    });
    var getMutasi = function(el)
    {
        var id_data = el.id;
        $("#v_form").load("{{ url('hrd/dataku/pinjamanKaryawan/mutasi')}}/"+id_data);
    }
</script>
