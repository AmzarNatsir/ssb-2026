<table id="user-list-table" class="table datatable table-hover table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info">
    <thead>
        <tr>
            <th scope="col" rowspan="2" style="width: 5%">#</th>
            <th scope="col" rowspan="2">Karyawan</th>
            <th scope="col" rowspan="2" style="width: 10%; text-align: center">BPJS Kesehatan</th>
            <th scope="col" colspan="4" style="text-align: center">BPJS Ketenagakerjaan</th>
            <th scope="col" rowspan="2" style="width: 5%; text-align: center">Aksi</th>
        </tr>
        <tr>
            <th scope="col" style="width: 5%; text-align: center">JP</th>
            <th scope="col" style="width: 5%; text-align: center">JHT</th>
            <th scope="col" style="width: 5%; text-align: center">JKK</th>
            <th scope="col" style="width: 5%; text-align: center">JKM</th>
        </tr>
    </thead>
    <tbody id="body-data">
        @php $nom=1 @endphp
        @foreach($list_data as $list)
            @php if($list->id_status_karyawan==1)
            {
                $badge_thema = 'badge badge-info';
            } elseif($list->id_status_karyawan==2) {
                $badge_thema = 'badge badge-primary';
            } elseif($list->id_status_karyawan==3) {
                $badge_thema = 'badge badge-success';
            } elseif($list->id_status_karyawan==7) {
                $badge_thema = 'badge badge-warning';
            } else {
                $badge_thema = 'badge badge-danger';
            }
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
        <tr>
            <td>{{ $nom }}</td>
            <td>
                <ul class="todo-task-lists m-0 p-0">
                    <li class="d-flex align-items-center p-0">
                    <div class="user-img img-fluid">
                        @if(!empty($list->photo))
                            <a href="{{ url(Storage::url('hrd/photo/'.$list->photo)) }}" data-fancybox data-caption='{{ $list->nm_lengkap }}'><img class="rounded-circle img-fluid avatar-40" src="{{ url(Storage::url('hrd/photo/'.$list->photo)) }}" alt="profile"></a>
                        @else
                            <a href="{{ asset('assets/images/user/1.jpg') }}" data-fancybox data-caption="avatar">
                            <img src="{{ asset('assets/images/user/1.jpg') }}"
                                class="rounded-circle img-fluid avatar-40" alt="avatar"></a>
                        @endif
                    </div>
                    <div class="media-support-info ml-3">
                        <h6 class="d-inline-block">{{ $list->nik}} - {{ $list->nm_lengkap}}</h6>
                        <span class="{{ $badge_thema }} ml-3 text-white">{{ $ket_status }}</span>
                        <p class="mb-0">{{ $list->get_jabatan->nm_jabatan }} {{ (empty($list->id_departemen)) ? "" : " -".$list->get_departemen->nm_dept }}</p>
                    </div>
                    </li>
                </ul>
                </td>
            <td style="text-align: center">{!! ($list->bpjs_kesehatan == "y") ? "<i class='fa fa-check text-success'></i>" : "" !!}</td>
            <td style="text-align: center">{!! ($list->bpjs_tk_jp == "y") ? "<i class='fa fa-check text-success'></i>" : "" !!}</td>
            <td style="text-align: center">{!! ($list->bpjs_tk_jht == "y") ? "<i class='fa fa-check text-success'></i>" : "" !!}</td>
            <td style="text-align: center">{!! ($list->bpjs_tk_jkk == "y") ? "<i class='fa fa-check text-success'></i>" : "" !!}</td>
            <td style="text-align: center">{!! ($list->bpjs_tk_jkm == "y") ? "<i class='fa fa-check text-success'></i>" : "" !!}</td>
            <td>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalFormSetting" onclick="goFormSetting({{ $list->id }})"><i class="fa fa-gear"></i></button>
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
</script>
