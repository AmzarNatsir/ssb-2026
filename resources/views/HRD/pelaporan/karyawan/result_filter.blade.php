<table id="user-list-table" class="table datatable table-hover table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Photo</th>
            <th scope="col">NIK</th>
            <th scope="col">Nama Karyawan</th>
            <th scope="col">Gender</th>
            <th scope="col">Alamat/No.Telepon</th>
            <th scope="col">Jabatan</th>
            <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>
        @php $nom=1; @endphp
        @foreach($list_karyawan as $list)
        <tr>
            <td>{{ $nom }}</td>
            <td class="text-left">
            <a href="{{ asset('upload/photo/'.$list->photo) }}" data-fancybox data-caption='{{ $list->nm_lengkap }}'><img class="rounded-circle img-fluid avatar-40" src="{{ asset('upload/photo/'.$list->photo) }}" alt="profile"></a></td>
            <td>{{ $list->nik}}</td>
            <td>{{ $list->nm_lengkap}}</td>
            <td>{{ ($list->jenkel==1)? "Laki-Laki" : "Perempuan" }}</td>
            <td>{{ $list->alamat."/".$list->notelp}}</td>
            <td>{{ (empty($list->get_jabatan->nm_jabatan)) ? "" : $list->get_jabatan->nm_jabatan }}{{ (empty($list->get_departemen->nm_dept)) ? "" : " - ".$list->get_departemen->nm_dept }}</td>
            <td><span class="badge iq-bg-primary">
            @php
            $list_status = Config::get('constants.status_karyawan');
            foreach($list_status as $key => $value)
            {
                if($key==$list->id_status_karyawan)
                {
                    $ket_status = $value;
                    break;
                }
            }
            @endphp
            {{ $ket_status }}
            </span></td>
        </tr>
        @php $nom++; @endphp
        @endforeach
    </tbody>
</table>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('.datatable').DataTable({
            searchDelay: 500,
            processing: true,
        });
    });
</script>
