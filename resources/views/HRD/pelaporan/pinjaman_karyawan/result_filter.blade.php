<table style="width: 100%; font-size:12px" id="table_pengajuan" class="table datatable">
    <thead>
        <th class="text-center">No.</th>
        <th class="text-center">Karyawan</th>
        <th class="text-center">Kategori</th>
        <th class="text-center">Alasan Pengajuan</th>
        <th class="text-center px-4">Nominal</th>
        <th class="text-center px-4">Tenor</th>
        <th class="text-center">Angsuran</th>
        <th class="text-center">Terbayar</th>
        <th class="text-center px-4">Outstanding</th>
    </thead>
    <tbody>
        @php($no=1);
        @foreach ($list_pinjaman_karyawan as $list)
        <tr>
            <td class="text-center">{{ $no }}</td>
            <td class="text-left">{{ $list['nm_lengkap'] }}</td>
            <td class="text-left">{{ ($list['kategori']==1) ? "Panjar Gaji" : "Pinjaman Kesejahteraan Karyawan (PKK)" }}</td>
            <td class="text-left">{{ $list['alasan_pengajuan'] }}</td>
            <td class="text-right">{{ number_format($list['nominal_apply'], 0) }}</td>
            <td class="text-right">{{ $list['tenor_apply'] }} Bulan</td>
            <td class="text-right">{{ number_format($list['angsuran'], 0) }}</td>
            <td class="text-right"><b>0</b></td>
            <td class="text-right"><b>{{ number_format($list['outs'], 0) }}</b></td>
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
