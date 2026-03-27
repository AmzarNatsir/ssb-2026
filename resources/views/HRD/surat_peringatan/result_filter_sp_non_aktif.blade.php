<p>Daftar Pengajuan Surat Peringatan</p>
<table class="table list_sp" style="width:100%">
    <tbody>
        @php $nom=1 @endphp
        @foreach ($list_pengajuan as $list)
        <tr>
            <td style="width: 10%; vertical-align: middle">
                @if(!empty($list->getSP->profil_karyawan->photo))
                    <a href="{{ url(Storage::url('hrd/photo/'.$list->getSP->profil_karyawan->photo)) }}" data-fancybox data-caption="avatar">
                    <img src="{{ url(Storage::url('hrd/photo/'.$list->getSP->profil_karyawan->photo)) }}"
                    class="rounded-circle" alt="avatar" style="width: 80px; height: auto;"></a>
                @else
                    <a href="{{ asset('assets/images/user/1.jpg') }}" data-fancybox data-caption="avatar">
                    <img src="{{ asset('assets/images/user/1.jpg') }}"
                    class="rounded-circle" alt="avatar sdsdsd" style="width: 80px; height: auto;"></a>
                @endif
            </td>
            <td style="width: 20%">
                <h4 class="mb-0">{{ $list->getSP->profil_karyawan->nm_lengkap }}</h4>
                <h6 class="mb-0">{{ $list->getSP->profil_karyawan->get_jabatan->nm_jabatan }} | {{ $list->getSP->profil_karyawan->get_departemen->nm_dept }}</h6>
            </td>
            <td style="width: 20%">
                <h4 class="mb-0">Masa Aktif</h4>
                <h6 class="mb-0"><span class="badge badge-primary">{{ date('d-m-Y', strtotime($list->getSP->sp_mulai_active)) }}</span>  s/d <span class="badge badge-danger">{{ date('d-m-Y', strtotime($list->getSP->sp_akhir_active)) }}</span></h6>
            </td>
            <td>
                <h4 class="mb-0">Alasan Penonaktifan Surat Peringatan : </h4>
                <h6 class="mb-0">{{ $list->alasan_non_aktif }}</h6>
                </h6>
            </td>
            <td style="width: 10%; vertical-align: middle">
                @if($list->sts_pengajuan==1)
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Menunggu Persetujuan
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item" href="#"><i class="fa fa-user mr-1"></i>{{ $list->get_current_approve->nm_lengkap }}</a>
                            <a class="dropdown-item" href="#"><i class="fa fa-user mr-1"></i>{{ $list->get_current_approve->get_jabatan->nm_jabatan }}</a>
                        </div>
                    </div>
                </div>
                @elseif($list->sts_pengajuan==2)
                    <button type="button" class="btn btn-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-check"></i> Approved</button>
                @else
                    <button type="button" class="btn btn-dark" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-times"></i> Rejected</button>
                @endif
            </td>
        </tr>
        @php $nom++ @endphp
        @endforeach
    </tbody>
</table>
