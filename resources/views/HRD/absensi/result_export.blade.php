<table border="1">
    <thead>
        <tr>
            <th colspan="{{ $grid->jml_hari + 8 }}" style="text-align:center;">MONITORING ABSENSI KARYAWAN</th>
        </tr>
        <tr>
            <th colspan="{{ $grid->jml_hari + 8 }}" style="text-align:center;">Departemen {{ $ket_departemen }} - Periode {{ $grid->ket_periode }}</th>
        </tr>
        <tr>
            <th rowspan="2" style="text-align:center;">No</th>
            <th rowspan="2" style="text-align:center;">NIK</th>
            <th rowspan="2" style="text-align:center;">Karyawan</th>
            <th colspan="{{ $grid->jml_hari }}" style="text-align:center;">Periode {{ $grid->ket_periode }}</th>
            <th rowspan="2" style="text-align:center;">Total Hadir</th>
            <th rowspan="2" style="text-align:center;">Total Cuti</th>
            <th rowspan="2" style="text-align:center;">Total Izin</th>
            <th rowspan="2" style="text-align:center;">Total Perdis</th>
            <th rowspan="2" style="text-align:center;">Total Training</th>
        </tr>
        <tr>
            @for($c = 1; $c <= $grid->jml_hari; $c++)
            <th style="text-align:center;">{{ $c }}</th>
            @endfor
        </tr>
    </thead>
    <tbody>
    @php $nom=1; @endphp
    @forelse($grid->rows as $row)
        <tr>
            <td style="text-align:center;">{{ $nom }}</td>
            <td>{{ $row->nik }}</td>
            <td>{{ $row->nm_lengkap }}</td>
            @for($c = 1; $c <= $grid->jml_hari; $c++)
            <td style="text-align:center;">{{ $row->cells[$c]['val'] }}</td>
            @endfor
            <td style="text-align:center;">{{ $row->tot_hadir }}</td>
            <td style="text-align:center;">{{ $row->tot_cuti }}</td>
            <td style="text-align:center;">{{ $row->tot_izin }}</td>
            <td style="text-align:center;">{{ $row->tot_perdis }}</td>
            <td style="text-align:center;">{{ $row->tot_pelatihan }}</td>
        </tr>
    @php $nom++; @endphp
    @empty
        <tr><td colspan="{{ $grid->jml_hari + 8 }}" style="text-align:center;">Data Not Found !</td></tr>
    @endforelse
    </tbody>
</table>
