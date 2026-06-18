<h5 class="mt-3 mb-2">Rekap Absensi Periode {{ $ket_bulan }} {{ $ket_tahun }}</h5>
<table id="user-list-table" class="table table-hover table-striped table-bordered mt-2" role="grid" aria-describedby="user-list-page-info">
    <thead>
        <tr>
            <th scope="col" style="width: 4%;">#</th>
            <th scope="col" style="width: 12%;">NIK</th>
            <th scope="col" style="width: 24%;">Nama</th>
            <th scope="col" style="width: 16%;">Departemen</th>
            <th scope="col" style="width: 7%; text-align:center;">Hari Kerja</th>
            <th scope="col" style="width: 7%; text-align:center;">Hadir</th>
            <th scope="col" style="width: 6%; text-align:center;">Cuti</th>
            <th scope="col" style="width: 6%; text-align:center;">Izin</th>
            <th scope="col" style="width: 6%; text-align:center;">Perdis</th>
            <th scope="col" style="width: 6%; text-align:center;">Training</th>
            <th scope="col" style="width: 6%; text-align:center;">Alpa</th>
        </tr>
    </thead>
    <tbody>
    @php $nom=1; @endphp
    @forelse($list_data as $list)
        <tr>
            <td>{{ $nom }}</td>
            <td>{{ $list->nik }}</td>
            <td>{{ $list->nm_lengkap }}</td>
            <td>{{ $list->nm_dept }}</td>
            <td style="text-align:center;">{{ $list->hari_kerja }}</td>
            <td style="text-align:center;">{{ $list->hadir }}</td>
            <td style="text-align:center;">{{ $list->cuti }}</td>
            <td style="text-align:center;">{{ $list->izin }}</td>
            <td style="text-align:center;">{{ $list->perdis }}</td>
            <td style="text-align:center;">{{ $list->training }}</td>
            <td style="text-align:center;">@if($list->alpa > 0)<span class="text-danger"><b>{{ $list->alpa }}</b></span>@else{{ $list->alpa }}@endif</td>
        </tr>
    @php $nom++; @endphp
    @empty
        <tr><td colspan="11" style="text-align:center;">Data Tidak Ditemukan !</td></tr>
    @endforelse
    </tbody>
</table>
<script>
    $(document).ready(function(){
        $('#user-list-table').DataTable({
            "pageLength": 25,
            "ordering": false
        });
    });
</script>
