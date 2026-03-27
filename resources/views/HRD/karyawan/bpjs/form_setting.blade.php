@php if($resProfil->id_status_karyawan==1)
{
    $badge_thema = 'badge badge-info';
} elseif($resProfil->id_status_karyawan==2) {
    $badge_thema = 'badge badge-primary';
} elseif($resProfil->id_status_karyawan==3) {
    $badge_thema = 'badge badge-success';
} elseif($resProfil->id_status_karyawan==7) {
    $badge_thema = 'badge badge-warning';
} else {
    $badge_thema = 'badge badge-danger';
}
$list_status = Config::get('constants.status_karyawan');
foreach($list_status as $key => $value)
{
    if($key==$resProfil->id_status_karyawan)
    {
        $ket_status = $value;
        break;
    }
}
@endphp

<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Pengaturan BPJS Karyawan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<form action="{{ url('hrd/karyawan/karyawan_bpjs_setting_simpan', $resProfil->id) }}" method="post" id="myForm">
{{ csrf_field() }}
{{ method_field('PUT') }}
<div class="modal-body">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <ul class="todo-task-lists m-0 p-0">
                    <li class="d-flex align-items-center p-0">
                        <div class="user-img img-fluid">
                            @if(!empty($resProfil->photo))
                                <a href="{{ url(Storage::url('hrd/photo/'.$resProfil->photo)) }}" data-fancybox data-caption='{{ $resProfil->nm_lengkap }}'><img class="rounded-circle img-fluid avatar-40" src="{{ url(Storage::url('hrd/photo/'.$resProfil->photo)) }}" alt="profile"></a>
                            @else
                                <a href="{{ asset('assets/images/user/1.jpg') }}" data-fancybox data-caption="avatar">
                                <img src="{{ asset('assets/images/user/1.jpg') }}"
                                    class="rounded-circle img-fluid avatar-40" alt="avatar"></a>
                            @endif
                        </div>
                        <div class="media-support-info ml-3">
                            <h6 class="d-inline-block">{{ $resProfil->nik}} - {{ $resProfil->nm_lengkap}}</h6>
                            <span class="{{ $badge_thema }} ml-3 text-white">{{ $ket_status }}</span>
                            <p class="mb-0">{{ $resProfil->get_jabatan->nm_jabatan }} {{ (empty($resProfil->id_departemen)) ? "" : " -".$resProfil->get_departemen->nm_dept }}</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="iq-card-body" style="width:100%; height:auto">
            <ul class="todo-task-lists m-0 p-0">
                <li class="d-flex align-items-center p-0">
                    <div class="media-support-info ml-3">
                       <h6 class="d-inline-block">- BPJS Kesehatan</h6>
                    </div>
                    <div class="iq-card-header-toolbar d-flex align-items-center">
                       <div class="custom-control custom-checkbox">
                          <input type="checkbox" name="check_bpjs_ks" class="custom-control-input" id="check_bpjs_ks" {{ ($resProfil->bpjs_kesehatan=='y') ? 'checked' : '' }}>
                          <label class="custom-control-label" for="check_bpjs_ks"></label>
                       </div>
                    </div>
                 </li>
                <li class="d-flex align-items-center p-0">
                   <div class="media-support-info ml-3">
                      <h6 class="d-inline-block">- Jaminan Hari Tua (JHT)</h6>
                   </div>
                   <div class="iq-card-header-toolbar d-flex align-items-center">
                      <div class="custom-control custom-checkbox">
                         <input type="checkbox" name="check_jht" class="custom-control-input" id="check_jht" {{ ($resProfil->bpjs_tk_jht=='y') ? 'checked' : '' }}>
                         <label class="custom-control-label" for="check_jht"></label>
                      </div>
                   </div>
                </li>
                <li class="d-flex align-items-center p-0">
                    <div class="media-support-info ml-3">
                        <h6 class="d-inline-block">- Jaminan Kecelakann Kerja (JKK)</h6>
                    </div>
                    <div class="iq-card-header-toolbar d-flex align-items-center">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="check_jkk" class="custom-control-input" id="check_jkk" {{ ($resProfil->bpjs_tk_jkk=='y') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="check_jkk"></label>
                        </div>
                    </div>
                </li>
                <li class="d-flex align-items-center p-0">
                    <div class="media-support-info ml-3">
                        <h6 class="d-inline-block">- Jaminan Kematian (JKM)</h6>
                    </div>
                    <div class="iq-card-header-toolbar d-flex align-items-center">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="check_jkm" class="custom-control-input" id="check_jkm" {{ ($resProfil->bpjs_tk_jkm=='y') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="check_jkm"></label>
                        </div>
                    </div>
                </li>
                <li class="d-flex align-items-center p-0">
                    <div class="media-support-info ml-3">
                        <h6 class="d-inline-block">- Jaminan Pensiun (JP)</h6>
                    </div>
                    <div class="iq-card-header-toolbar d-flex align-items-center">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="check_jp" class="custom-control-input" id="check_jp" {{ ($resProfil->bpjs_tk_jp=='y') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="check_jp"></label>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
</div>
</form>
