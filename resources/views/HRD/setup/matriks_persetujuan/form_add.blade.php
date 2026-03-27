<div class="form-group col-sm-6">
    <table class="table list_item_1" style="width: 100%">
        <tr>
            <th>Level</th>
            <td style="width: 80%">Pejabat</td>
            <td style="width: 15%"></td>
        </tr>
        <tr>
            <td><input type="text" class="form-control" name="inpLevel" id="inpLevel" value="{{ $current_level }}" style="text-align: center" readonly></td>
            <td>
                <select class="select2 form-control mb-3" id="pil_pejabat" name="pil_pejabat" required>
                    <option selected="" disabled="" value="">Pilihan...</option>
                    @foreach($list_karyawan as $r)
                    <option value="{{ $r->id }}">{{ $r->nik }} - {{ $r->nm_lengkap }} - {{ $r->get_jabatan->nm_jabatan }}</option>
                    @endforeach
                </select>
            </td>
            <td><button onclick="addButton(this)" type="button" class="btn btn-primary btn-square waves-effect waves-light"><i class="fa fa-plus"></i></button></td>
        </tr>
    </table>
</div>
<div class="form-group col-sm-6">
    <table class="table list_item_1" style="width: 100%">
        <tr>
            <th style="width: 10%">Level</th>
            <td>Pejabat</td>
            <td style="width: 35%">Jabatan</td>
            <td style="width: 15%"></td>
        </tr>
        @foreach ($list_matriks as $m)
        <tr>
            <td>{{ $m->approval_level }}</td>
            <td>{{ $m->getPejabat->nm_lengkap }}</td>
            <td>{{ $m->getPejabat->get_jabatan->nm_jabatan }}</td>
            <td><button type="button" class="btn btn-danger" name="btn_del[]" onclick="goDelete(this)" value="{{ $m->id }}"><i class="ri-delete-bin-line pr-0"></i></button></td>
        </tr>
        @endforeach
    </table>
</div>
