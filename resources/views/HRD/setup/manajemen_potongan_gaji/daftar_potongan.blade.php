<form action="{{ url('hrd/setup/manajemengapok/simpangapok') }}" method="post" onsubmit="return konfirm()">
    <table id="user-list-table" class="table  table-hover table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info">
        <thead>
            <tr>
                <th scope="col" style="width: 5%;">#</th>
                <th scope="col" style="width: 10%;">Photo</th>
                <th scope="col" style="width: 10%;">NIK</th>
                <th scope="col" style="width: 20%;">Nama Karyawan</th>
                <th scope="col" style="width: 20%;">Jabatan</th>
                <th scope="col" style="text-align: right; width: 15%">Gaji Pokok (Rp.)</th>
                <th scope="col" style="text-align: right; width: 15%">Total Potongan (Rp.)</th>
                <th scope="col" style="width: 5%;"></th>
            </tr>
        </thead>
        <tbody>
        
        {{ csrf_field() }}
            @php $nom=1 @endphp
            @foreach($all_karyawan_potongan as $list)
            <tr>
                <td>{{ $nom }}</td>
                <td class="text-left">
                <a href="{{ asset('upload/photo/'.$list->photo) }}" data-fancybox data-caption='{{ $list->nm_lengkap }}'><img class="rounded-circle img-fluid avatar-40" src="{{ asset('upload/photo/'.$list->photo) }}" alt="profile"></a></td>
                <td>{{ $list->nik}}</td>
                <td>{{ $list->nm_lengkap}}</td>
                <td>{{ (!empty($list->get_jabatan->nm_jabatan)) ? $list->get_jabatan->nm_jabatan : "" }} ( {{ (!empty($list->id_departemen)) ? "Dept. : ".$list->get_departemen->nm_dept : "" }})</td>
                <td style="text-align: right">{{ number_format($list->gaji_pokok, 0, ',', '.') }}</td>
                <td style="text-align: right">{{ number_format($list->get_potongan_karyawan->sum('jumlah'), '0', ',', '.') }}</td>
                <td><button type="button" class="btn btn-primary tbl_inputan" id="{{ $list->id }}" data-toggle="modal" data-target="#exampleModalCenteredScrollable"><i class="fa fa-edit"></i></button>

                </td>
            </tr>
            @php $nom++ @endphp
            @endforeach
        </tbody>    
    </table>
    </form>

    <div id="exampleModalCenteredScrollable" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content" id="v_inputan"></div>
        </div>
     </div>


    <script type="text/javascript">
        $(document).ready(function()
        {
            $(".tbl_inputan").on('click', function()
            {
                $(".angka").number(true, 0);
                $("#v_inputan").load("{{ url('hrd/setup/manajemenpot/forminputpotonggaji') }}/"+this.id);
            });
        });
    </script>
    