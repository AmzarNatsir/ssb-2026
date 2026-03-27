@if(!empty($list_jenis_izin))
    @php $nom=1; @endphp
    @foreach($list_jenis_izin as $key => $j_izin)
    <tr>
        <td>{{ $nom }}</td>
        <td>{{ $j_izin['nama'] }}</td>
        <td>{{ $j_izin['total'] }}</td>
    </tr>
    @php $nom++; @endphp
    @endforeach
@endif
