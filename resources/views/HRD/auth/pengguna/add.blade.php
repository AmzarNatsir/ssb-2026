<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Manajemen Pengguna | Pengguna Baru</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<div style="overflow-y: auto; height: calc(100vh - 15rem);">
<form action="{{ url('hrd/setup/manajemenpengguna/simpan') }}" method="post" onsubmit="return konfirm()">
{{ csrf_field() }}
<div class="modal-body">
    <div class=" row align-items-center">
        <div class="form-group col-sm-12">
            <label for="pil_karyawan">Pilih Pengguna (Karyawan) :</label>
            <select class="form-control select2" id="pil_karyawan" name="pil_karyawan" style="width: 100%;">
                <option value="0">-> Pilih Karyawan</option>
                @foreach($karyawan_aktif as $list)
                <option value="{{ $list->id }}"><b>{{ $list->nik." | ".$list->nm_lengkap }} </b>- {{ (empty($list->id_jabatan) || empty($list->get_jabatan->nm_jabatan)) ? " (empty) " : $list->get_jabatan->nm_jabatan }} {{ (!empty($list->id_departemen)) ? "- ".$list->get_departemen->nm_dept : "" }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <hr>
    <div class="iq-card-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="iq-header-title">
                    <h4 class="card-title ">
                    List Roles</h4>
                </div>
                <table class="table" style="width: 100%; height: auto;">
                    @foreach($roles as $ls)
                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="{{ $ls['id'] }}" name="roles[]" value="{{ $ls['id'] }}">
                                <label class="custom-control-label" for="{{ $ls['id'] }}">{{ $ls['name'] }}</label>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td>
                            <div class="alert text-white bg-danger" role="alert">
                                <div class="iq-alert-icon">
                                <i class="ri-information-line"></i>
                                </div>
                                <div class="iq-alert-text"><b>Password pengguna dibentuk secara otomatis (default : 123456)</b></div>
                            </div>
                        </td>
                    </tr>
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
<script type="text/javascript">
    $(document).ready(function()
    {
        $(".select2").select2({
            width: '100%'
        });

    });
    function konfirm()
    {
        var psn = confirm("Yakin akan menyimpan data ?");
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }


</script>
