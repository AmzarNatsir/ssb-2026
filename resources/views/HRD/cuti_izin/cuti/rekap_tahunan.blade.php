@if(!empty($list_jenis_cuti))
    @php $nom=1; @endphp
    @foreach($list_jenis_cuti as $key => $j_cuti)
    <tr>
        <td>{{ $nom }}</td>
        <td>{{ $j_cuti['nama'] }}</td>
        <td>{{ $j_cuti['total'] }}</td>
    </tr>
    @php $nom++; @endphp
    @endforeach
@endif
