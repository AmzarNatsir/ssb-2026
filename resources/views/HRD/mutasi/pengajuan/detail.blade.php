<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Pengajuan Mutasi</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<form action="{{ url('hrd/mutasi/formpengajuanDelete/'.$karyawan->id) }}" enctype="multipart/form-data" method="post" onsubmit="return konfirm()">
{{ csrf_field() }}
{{ method_field('PUT') }}
<div class="modal-body">
    <div class="iq-card iq-card-block iq-card-stretch">
        <div class="iq-card-body">
            <table class="table" style="width:100%">
                <tbody>
                    <tr>
                        <td style="width: 20%">
                            <h4 class="mb-0">{{ $karyawan->get_profil->nik }}</h4>
                        </td>
                        <td>
                            <h4 class="mb-0">{{ $karyawan->get_profil->nm_lengkap }}</h4>
                            <h6 class="mb-0">Divisi : {{ ($karyawan->get_profil->id_divisi==NULL)? "" : $karyawan->get_profil->get_divisi->nm_divisi }}</h6>
                            <h6 class="mb-0">Departemen : {{ ($karyawan->get_profil->id_departemen==0 || empty($karyawan->get_profil->id_departemen)) ? "" : $karyawan->get_profil->get_departemen->nm_dept }}</h6>
                            <h6 class="mb-0">Sub Departemen : {{ ($karyawan->get_profil->id_subdepartemen==0 || empty($karyawan->get_profil->id_subdepartemen))? "" : $karyawan->get_profil->get_subdepartemen->nm_subdept }}</h6>
                            <h6 class="mb-0">Jabatan: {{ ($karyawan->get_profil->id_jabatan==0 || empty($karyawan->get_profil->id_jabatan))? "" : $karyawan->get_profil->get_jabatan->nm_jabatan }}</h6>
                            <h6 class="mb-0">Status Karyawan : {{ $nm_status_lm }}</h6>
                            <h6 class="mb-0">Efektif Jabatan : {{ (empty($karyawan->get_profil->tmt_jabatan)) ? "" : date_format(date_create( $karyawan->get_profil->tmt_jabatan), 'd-m-Y') }}</h6>
                            <h6 class="mb-0">Bergabung Tanggal : {{ $tgl_masuk }}</h6>
                            <h6 class="mb-0">Lama Bekerja : {{ $lama_kerja }}</h6>
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr>
            <ul class="list-group" style="margin-bottom: 15px">
                <li class="list-group-item active">Lampirkan Hasil Evaluasi Karyawan</li>
            </ul>
            <div class="form-group">
                <label for="inp_file_jobdesc">File Hasil Evaluasi:</label>
                <div class="custom-file">
                    @if(!empty($list->file_hasil_evaluasi))
                    <a href="{{ url('hrd/mutasi/mutasi_showPdf', $list->id) }}" target="_new"><i class="fa fa-file-pdf-o"></i></a>
                    @else
                    Tidak ada File
                    @endif
                </div>
            </div>
            <hr>
            <ul class="list-group" style="margin-bottom: 15px">
                <li class="list-group-item active">Perubahan Posisi/Jabatan</li>
            </ul>
            <div class="form-group row">
                <label class="col-sm-4">Kategori</label>
                <div class="col-sm-8">
                    <select class="form-control" name="pil_kategori" id="pil_kategori" disabled>
                        @foreach($list_kategori as $key => $value)
                        <option value="{{ $key }}" {{ ($key == $karyawan->kategori) ? "selected" : "" }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Divisi Baru</label>
                <div class="col-sm-8">
                    <select class="form-control" name="pil_divisi_baru" id="pil_divisi_baru" disabled>
                        <option value="0" selected>Non Divisi</option>
                        @foreach($list_divisi as $divisi)
                        <option value="{{ $divisi->id }}" {{ ($divisi->id == $karyawan->id_divisi_br) ? "selected" : "" }}>{{ $divisi->nm_divisi }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Departemen Baru</label>
                <div class="col-sm-8">
                    <select class="form-control" name="pil_dept_baru" id="pil_dept_baru" disabled>
                        <option value="0" selected>Non Departemen</option>
                        @foreach($list_departemen as $departemen)
                        <option value="{{ $departemen->id }}" {{ ($departemen->id == $karyawan->id_dept_br) ? "selected" : "" }}>{{ $departemen->nm_dept }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Sub Departemen Baru</label>
                <div class="col-sm-8">
                    <select class="form-control" name="pil_subdept_baru" id="pil_subdept_baru" disabled>
                        <option value="0" selected>Non Sub Departemen</option>
                        @foreach($list_sub_departemen as $subdept)
                        <option value="{{ $subdept->id }}" {{ ($subdept->id == $karyawan->id_subdept_br) ? "selected" : "" }}>{{ $subdept->nm_subdept }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Jabatan Baru</label>
                <div class="col-sm-8">
                    <select class="form-control" name="pil_jabt_baru" id="pil_jabt_baru" disabled>
                        @foreach($list_jabatan as $jabatan)
                        <option value="{{ $jabatan->id }}" {{ ($jabatan->id == $karyawan->id_jabt_br) ? "selected" : "" }}>{{ $jabatan->nm_jabatan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Keterangan</label>
                <div class="col-sm-8">
                    <textarea class="form-control" name="keterangan" id="keterangan" disabled>{{ $karyawan->keterangan }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    @if($karyawan->is_draft==1)
    <button type="submit" class="btn btn-danger">Batalkan Pengejuan</button>
    @endif
</div>
</form>

