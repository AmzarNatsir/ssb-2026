<form action="{{ route('updatePendidikan', $result->id) }}" method="post" onsubmit="return konfirm()" enctype="multipart/form-data">
{{ csrf_field() }}
{{ method_field('PUT') }}
<div class="modal-body">
    <input type="hidden" name="id_pelamar" value="{{ $result->id_pelamar }}">
    <div class="iq-card iq-card-block iq-card-stretch">
        <div class="iq-card-body">
            <div class="row align-items-center">
                <div class="form-group col-sm-12">
                    <label for="pil_jenjang">Jenjang Pendidikan :</label>
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
                    <label for="inp_nama">Nama Sekolah/Perguruan Tinggi :</label>
                    <input type="text" class="form-control" name="inp_nama" id="inp_nama" maxlength="150" value="{{ $result->nm_sekolah_pt }}" required>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="form-group col-sm-12">
                    <label for="inp_alamat">Alamat :</label>
                    <input type="text" class="form-control" name="inp_alamat" id="inp_alamat" maxlength="200" value="{{ $result->alamat }}" required>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="form-group col-sm-12">
                    <label for="inp_tahun_mulai">Tahun Pendidikan :</label>
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control tahun_mask" name="inp_tahun_mulai" id="inp_tahun_mulai" placeholder="Mulai Tahun" maxlength="4" value="{{ $result->mulai_tahun }}" required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control tahun_mask" name="inp_tahun_akhir" id="inp_tahun_akhir" placeholder="Sampai Tahun" maxlength="4" value="{{ $result->sampai_tahun }}" required>
                        </div>
                    </div>
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
