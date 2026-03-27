@php $nom=1; @endphp
@foreach ($all_jabatan as $list)
<tr>
    <td>{{ $nom }}</td>
    <td>{{ $list->nm_jabatan}} </td>
    <td>
        <input type="hidden" name="id_jabatan[]" value="{{ $list->id }}">
    <select class="form-control select2" id="pil_gakom[]" name="pil_gakom[]" required>
        <option value="0" selected>Pilihan Atasan Langsung</option>
        @foreach($all_gakom as $gakom)
            @if($list->id_gakom==$gakom->id)
            <option value={{ $gakom->id }} selected>{{ $gakom->nm_jabatan }}</option>";
            @else
            <option value={{ $gakom->id }}>{{ $gakom->nm_jabatan }}</option>";
            @endif
        @endforeach
    </select></td>
</tr>
@php $nom++; @endphp
@endforeach
