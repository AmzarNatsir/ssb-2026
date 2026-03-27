<div class="col-sm-12 col-lg-12">
    <div class="iq-card">
        <div class="iq-card-header d-flex justify-content-between">
            <div class="iq-header-title">
               <h4 class="card-title">Daftar Karyawan Resign</h4>
            </div>
         </div>
        <div class="iq-card-body" style="width:100%; height:auto">
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
                        <th scope="col">Tgl.Masuk</th>
                        <th scope="col">Tgl.Resign</th>
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
                        <td>{{ $list->alamat."/".$list->notelp}}</td>
                        <td>{{ $list->get_jabatan->nm_jabatan }} </td>
                        <td>{{ (empty($list->tgl_masuk)) ? "" : date('d-m-Y', strtotime($list->tgl_masuk)) }} </td>
                        <td>{{ (empty($list->tgl_resign)) ? "" : date('d-m-Y', strtotime($list->tgl_resign)) }} </td>
                    </tr>
                    @php $nom++ @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function()
    {
        $('.datatable').DataTable({
            searchDelay: 500,
            processing: true,
        });
    });
</script>
