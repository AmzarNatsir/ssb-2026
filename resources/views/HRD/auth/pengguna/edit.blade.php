<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Manajemen Pengguna | Edit Pengguna</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<div style="overflow-y: auto; height: calc(100vh - 15rem);">
    <form action="{{ url('hrd/setup/manajemenpengguna/update/'.$user_profil->id) }}" method="POST" onsubmit="return konfirm()">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="modal-body">
        <input type="hidden" name="id_user" value="{{ $user_profil->id }}">
        <div class=" row align-items-center">
            <div class="form-group col-sm-12">
                <div>
                    <div class="media-support-info mt-2">
                        <h3 class="mb-0" style="text-align: center">{{ $user_profil->karyawan->nm_lengkap }}</h3>
                        <p class="mb-0 text-primary" style="text-align: center">{{ (!empty($user_profil->karyawan->id_jabatan)) ? $user_profil->karyawan->get_jabatan->nm_jabatan : "" }}</p>
                        <p class="mb-0 text-primary" style="text-align: center">{{ (!empty($user_profil->karyawan->id_departemen)) ? $user_profil->karyawan->get_departemen->nm_dept : "" }}</p>
                        </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="iq-card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="iq-header-title">
                        <h4 class="card-title ">List Roles User</h4>
                    </div>
                    <table class="table" style="width: 100%; height: auto;">
                        @foreach($roles as $ls)
                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="{{ $ls['id'] }}" name="roles[]" value="{{ $ls['id'] }}"
                                    @foreach($roles_user as $ruser)
                                        @if($ruser->id==$ls['id']) {{ "checked "}} @endif
                                    @endforeach
                                    >
                                    <label class="custom-control-label" for="{{ $ls['id'] }}">{{ $ls['name'] }}</label>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </div>
    </form>
</div>
