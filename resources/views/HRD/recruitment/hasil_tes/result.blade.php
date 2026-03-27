@php($nom=1)
@foreach ($result as $list)
<tr>
    <td style="text-align: center">{{ $nom }}</td>
    <td>{{ $list->nama_lengkap }}</td>
    <td></td>
    <td></td>
    <td style="text-align: center">{{ $list->psikotes_nilai }}</td>
    <td>{{ $list->psikotes_ket }}</td>
    <td style="text-align: center">{{ $list->wawancara_nilai }}</td>
    <td>{{ $list->wawancara_ket }}</td>
    <td style="text-align: center">{{ $list->total_skor }}</td>
    <td style="text-align: center">{{ $nom }}</td>
</tr>
@php($nom++)
@endforeach
