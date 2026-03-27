<form action="{{ route('updateDataLBKeluarga', $result->id) }}" method="post" onsubmit="return konfirm()" enctype="multipart/form-data">
{{ csrf_field() }}
{{ method_field('PUT') }}
<div class="modal-body">
    <input type="hidden" name="id_pelamar" value="{{ $result->id_pelamar }}">
    <div class="iq-card iq-card-block iq-card-stretch">
        <div class="iq-card-body">
            <div class="row align-items-center">
                <div class="form-group col-sm-12">
                    <label for="pil_hubungan">Hubungan Keluarga :</label>
                    <select class="form-control" id="pil_hubungan" name="pil_hubungan">
                        @foreach($list_lbkeluarga as $key => $lbkeluarga)
                        @if($key==$result->id_hubungan)
                        <option value="{{ $key }}" selected>{{ $lbkeluarga }}</option>
                        @else
                        <option value="{{ $key }}">{{ $lbkeluarga }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="form-group col-sm-12">
                    <label for="inp_nama">Nama :</label>
                    <input type="text" class="form-control" name="inp_nama" id="inp_nama" maxlength="150" value="{{ $result->nm_keluarga }}" required>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="form-group col-sm-8">
                    <label for="inp_tmp_lahir">Tempat Lahir :</label>
                    <input type="text" class="form-control" name="inp_tmp_lahir" id="inp_tmp_lahir" maxlength="100" value="{{ $result->tmp_lahir }}" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="inp_tgl_lahir">Tanggal Lahir :</label>
                    <input type="date" class="form-control" name="inp_tgl_lahir" id="inp_tgl_lahir" value="{{ $result->tgl_lahir }}" required>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="form-group col-sm-12">
                    <label class="d-block">Jenis Kelamin :</label>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="rdo_jenkel_1_edit" name="rdo_jenkel_edit" class="custom-control-input" checked="" value="1" {{ ($result->jenkel==1)? "checked" : "" }}>
                    <label class="custom-control-label" for="rdo_jenkel_1_edit"> Laki-Laki </label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="rdo_jenkel_2_edit" name="rdo_jenkel_edit" class="custom-control-input" value="2" {{ ($result->jenkel==2)? "checked" : "" }}>
                    <label class="custom-control-label" for="rdo_jenkel_2_edit"> Perempuan </label>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="form-group col-sm-12">
                    <label for="pil_jenjang">Pendidikan Terakhir :</label>
                    <select class="form-control" id="pil_jenjang" name="pil_jenjang">
                        @foreach($list_jenjang as $key => $jenjang)
                        @if($key==$result->id_jenjang)
                        <option value="{{ $key }}" selected>{{ $jenjang }}</option>
                        @else
                        <option value="{{ $key }}">{{ $jenjang }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="form-group col-sm-12">
                    <label for="inp_pekerjaan">Pekerjaan :</label>
                    <input type="text" class="form-control" name="inp_pekerjaan" id="inp_pekerjaan" maxlength="100" value="{{ $result->pekerjaan }}">
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