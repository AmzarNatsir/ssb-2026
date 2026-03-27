<table style="width: 100%; font-size:12px" id="table_pengajuan" class="table datatable">
    <thead>
        <th class="text-center">No.</th>
        <th class="text-center">Tanggal</th>
        <th class="text-center">Kategori</th>
        <th class="text-center">Alasan Pengajuan</th>
        <th class="text-center">Nominal</th>
        <th class="text-center">Tenor</th>
        <th class="text-center">Angsuran</th>
        <th>Status</th>
    </thead>
    <tbody>
        @php($no=1)
        @foreach ($list_pengajuan as $list)
        <tr>
            <td class="text-center">{{ $no }}</td>
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
        </tr>
        @php($no++)
        @endforeach
    </tbody>
</table>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('.datatable').DataTable();
    });
</script>
