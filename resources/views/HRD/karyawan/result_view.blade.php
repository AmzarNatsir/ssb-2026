<table id="user-list-table" class="table datatable table-hover table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Photo</th>
            <th scope="col">NIK</th>
            <th scope="col">Nama Karyawan</th>
            <th scope="col">Gender</th>
            <th scope="col">Alamat</th>
            <th scope="col">No.Telepon</th>
            <th scope="col">Jabatan</th>
            <th scope="col">Departemen</th>
            <th scope="col">Status</th>
            <th scope="col">NIK&nbsp;Lama</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody id="body-data">
        @php $nom=1 @endphp
        @foreach($list_data as $list)
        <tr>
            <td>{{ $nom }}</td>
            <td class="text-left">
            @if(!empty($list->photo))
                <a href="{{ url(Storage::url('hrd/photo/'.$list->photo)) }}" data-fancybox data-caption='{{ $list->nm_lengkap }}'><img class="rounded-circle img-fluid avatar-40" src="{{ url(Storage::url('hrd/photo/'.$list->photo)) }}" alt="profile"></a>
            @else
                <a href="{{ asset('assets/images/user/1.jpg') }}" data-fancybox data-caption="avatar">
                <img src="{{ asset('assets/images/user/1.jpg') }}"
                    class="rounded-circle img-fluid avatar-40" alt="avatar"></a>
            @endif
            </td>
            <td>{{ $list->nik}}</td>
            <td>{{ $list->nm_lengkap}}</td>
            <td>@if($list->jenkel==1)
                {{ "Laki-Laki" }}
                @elseif($list->jenkel==2)
                {{ "Perempuan" }}
                @else
                {{ "Laki-Laki dan Perempuan" }}
                @endif</td>
            <td>{{ $list->alamat}}</td>
            <td>{{ $list->notelp}}</td>
            <td>{{ (empty($list->get_jabatan->nm_jabatan) || (empty($list->id_jabatan))) ? "Non Jabatan" : $list->get_jabatan->nm_jabatan }} </td>
            <td>{{ (empty($list->get_departemen->nm_dept) || (empty($list->id_departemen))) ? "" : $list->get_departemen->nm_dept }} </td>
            <td>
                @php if($list->id_status_karyawan==1)
                {
                    $badge_thema = 'badge iq-bg-info';
                } elseif($list->id_status_karyawan==2) {
                    $badge_thema = 'badge iq-bg-primary';
                } elseif($list->id_status_karyawan==3) {
                    $badge_thema = 'badge iq-bg-success';
                } elseif($list->id_status_karyawan==7) {
                    $badge_thema = 'badge iq-bg-warning';
                } else {
                    $badge_thema = 'badge iq-bg-danger';
                }
                @endphp
               <span class="{{ $badge_thema }}">
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
            {{ $ket_status }}</span></td>
            <td>{{ $list->nik_lama }}</td>
            <td>
                <div class="flex align-items-center list-user-action">
                    <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Profil" href="{{ url('hrd\karyawan\profil') }}\{{ $list->id }}" target="_new"><i class="ri-user-line"></i></a>
                </div>
            </td>
        </tr>
        @php $nom++ @endphp
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

    function confirmHapus()
    {
        var pesan = confirm("Yakin data akan dihapus ?");
        if(pesan==true) {
            return true;
        } else {
            return false;
        }
    }
</script>
