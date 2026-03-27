<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Pengaturan Persetujuan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<form action="{{ url('hrd/setup/simpanpengaturanpersetujuan') }}" method="post" onsubmit="return konfirm()">
{{ csrf_field() }}
<input type="hidden" name="id_modul" value="{{ $main->id }}">
<div class="modal-body">
    <div class="iq-card iq-card-block iq-card-stretch">
        <div class="iq-card-body">
            <div class="row align-items-center">
                <div class="form-group col-sm-12">
                    <label for="pil_lvl_pengajuan_cuti">Nama Modul : <strong>{{ $main->modul }}</strong></label>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="form-group col-sm-12">
                    <label for="pil_lvl_pengajuan_cuti">Level Pengajuan :</label>
                    <select class="select2 select2-multiple" name="pil_lvl_pengajuan_cuti[]" id="pil_lvl_pengajuan_cuti" multiple="multiple" data-placeholder="Pilihan" style="width: 100%;">
                        @php $list_pil_1 = explode(",", $main->lvl_pengajuan); @endphp
                        @foreach($list_level as $level_ct)
                            <option value="{{ $level_ct->id }}" 
                            @foreach($list_pil_1 as $pil_1) 
                                {{ ($pil_1==$level_ct->id) ? "selected" : "" }}
                            @endforeach>{{ $level_ct->level." - ".$level_ct->nm_level }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="form-group col-sm-12">
                    <label for="pil_lvl_persetujuan_cuti">Level Persetujuan Pertama :</label>
                    <select class="form-control select2" name="pil_lvl_persetujuan_cuti" id="pil_lvl_persetujuan_cuti" style="width: 100%;">
                        <option value="">Pilihan</option>
                        @foreach($list_level as $level_ct)
                        <option value="{{ $level_ct->id }}" {{ ($level_ct->id==$main->lvl_persetujuan) ? "selected" : "" }}>{{ $level_ct->level." - ".$level_ct->nm_level }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="form-group col-sm-12">
                    <label for="pil_lvl_persetujuan_cuti_hrd">Level Persetujuan Akhir :</label>
                    <select class="form-control select2" name="pil_lvl_persetujuan_cuti_hrd" id="pil_lvl_persetujuan_cuti_hrd" style="width: 100%;">
                        <option value="">Pilihan</option>
                        @foreach($list_jabatan as $lvl_jabatan)
                        <option value="{{ $lvl_jabatan->id }}" {{ ($lvl_jabatan->id==$main->id_dept_manager_hrd) ? "selected" : "" }}>{{ $lvl_jabatan->nm_jabatan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save changes</button>
</div>
</form>
<script type="text/javascript">
    $(document).ready(function()
    {
        $(".select2").select2();
    });
</script>