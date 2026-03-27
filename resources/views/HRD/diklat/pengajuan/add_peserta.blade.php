<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
    <div class="iq-card-body" style="width:100%; height:auto">
        <ul class="list-group" style="margin-bottom: 5px">
            <li class="list-group-item bg-primary active">Peserta Pelatihan</li>
        </ul>
        <div class="form-group row">
            <div class="col-sm-12"><label for="pil_peserta_internal">Pilih Peserta Pelatihan Internal</label></div>
            <div class="col-sm-10">

                <select class="form-control select2" name="pil_peserta_internal" id="pil_peserta_internal" style="width: 100%;" onchange="getRiwayatPelatihan(this)">
                    <option></option>
                    @foreach($all_karyawan as $list_internal)
                        <option value="{{ $list_internal->id }}">{{ $list_internal->nik." - ".$list_internal->nm_lengkap }} - {{ $list_internal->get_jabatan->nm_jabatan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-2 col-lx-12">
                <button type="button" class="btn btn-success" onclick="simpanPeserta(this)"><i class="fa fa-plus"></i></button>
            </div>
        </div>
    </div>
    <div class="iq-card-body" style="width:100%; height:auto">
        <div class="row justify-content-center">
            <table class="table list_item" style="width: 100%; height: auto">
                <thead>
                    <th>Act</th>
                    <th style="width: 3%">#</th>
                    <th style="width: 10%">NIK</th>
                    <th>Peserta</th>
                    <th style="width: 25%">Departemen</th>
                    <th style="width: 25%">Jabatan</th>
                </thead>
                <tbody>
                    @if($peserta->count() > 0)
                    @php $nom=1 @endphp
                    @foreach($peserta as $list)
                    <tr>
                        <td>
                            @if($list->get_karyawan->id_departemen == $dept_user)
                            <button type="button" title="Hapus Baris" class="btn btn-danger btn-sm waves-effect waves-light" onclick="delete_item(this)" id="{{ $list->id }}"><i class="fa fa-minus"></i></button>
                            @endif
                        </td>
                        <td>{{ $nom }}</td>
                        <td>{{ $list->get_karyawan->nik }}</td>
                        <td>{{ $list->get_karyawan->nm_lengkap }}</td>
                        <td>{{ (empty($list->get_karyawan->id_departemen)) ? "" : $list->get_karyawan->get_departemen->nm_dept }}</td>
                        <td>{{ (empty($list->get_karyawan->id_jabatan)) ? "" : $list->get_karyawan->get_jabatan->nm_jabatan }}</td>
                    </tr>
                    @php $nom++ @endphp
                    @endforeach
                    @endif
                </tbody>
            </table>

        </div>
    </div>
</div>
