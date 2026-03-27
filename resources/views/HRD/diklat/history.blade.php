@if(!empty($history))
    @php $nom=1; @endphp
    @foreach($history as $list)
<tr>
    <td>{{ $nom }}</td>
    <td>{{ $list->nama_diklat }}</td>
    <td>{{ $list->profil_pelaksana->nama_lembaga }}</td>
    <td>{{ $list->tempat }}</td>
    <td style="width: 10%; text-align: center">{{ date_format(date_create($list->tgl_awal), 'd-m-Y')." s/d ".date_format(date_create($list->tgl_selesai), 'd-m-Y') }}</td>
    <td></td>
    <td style="width: 10%; text-align: center">@if($list->status==1)
                    Lulus
                    @elseif($list->status==2)
                    Tidak Lulus
                    @else
                    Tanpa Keterangan
                    @endif</td>
    <td style="width: 10%; text-align: center">{{ $list->nilai}}</td>
    <td style="width: 10%; text-align: center"></td>
</tr>
    @php $nom++; @endphp
    @endforeach
@endif
