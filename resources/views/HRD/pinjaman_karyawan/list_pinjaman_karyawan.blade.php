<table style="width: 100%; font-size:12px" id="table_pengajuan" class="table datatable">
    <thead>
        <th class="text-center">#</th>
        <th class="text-center">Nomor.</th>
        <th class="text-left">Karyawan</th>
        <th class="text-left">Kategori</th>
        <th class="text-left">Alasan&nbsp;Pengajuan</th>
        <th class="text-right px-4">Nominal</th>
        <th class="text-right px-4">Tenor</th>
        <th class="text-right">Angsuran</th>
        <th class="text-right">Pembayaran&nbsp;Ke</th>
        <th class="text-right">Terbayar</th>
        <th class="text-right px-4">Outstanding</th>
        <th class="text-center">Aksi</th>
    </thead>
    <tbody>
        @php($no=1);
        @foreach ($list_pinjaman_karyawan as $list)
        <tr>
            <td class="text-center">{{ $no }}</td>
            <td class="text-center">{{ $list['nomor_pinjaman'] }}</td>
            <td class="text-left">{{ $list['nm_lengkap'] }}</td>
            <td class="text-left">{{ ($list['kategori']==1) ? "Panjar Gaji" : "Pinjaman Kesejahteraan Karyawan (PKK)" }}</td>
            <td class="text-left">{{ $list['alasan_pengajuan'] }}</td>
            <td class="text-right">{{ number_format($list['nominal_apply'], 0) }}</td>
            <td class="text-right">{{ $list['tenor_apply'] }} Bulan</td>
            <td class="text-right">{{ number_format($list['angsuran'], 0) }}</td>
            <td class="text-center"><badge class="badge badge-success">{{ $list['pembayaran_ke'] }}</badge></td>
            <td class="text-right"><b>{{ number_format($list['outs'], 0) }}</b></td>
            <td class="text-right"><b>{{ number_format($list['nominal_apply'] - $list['outs'], 0) }}</b></td>
            <td class="text-center">
                <button type="button" class="btn btn-outline-danger active" data-toggle="modal" data-target="#ModalForm" id="{{ $list['id'] }}" title="Proses" onclick="getProses(this)"><i class="fa fa-edit"></i></button>
                <a href="{{ url('hrd/pinjaman_karyawan/print_mutasi', $list['id']) }}" class="btn btn-success" target="_new"><i class="fa fa-print"></i></a>
            </td>
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
