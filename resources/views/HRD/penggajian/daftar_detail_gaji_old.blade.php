<table id="user-list-table" class="table-hover table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info" style="width: 100%; font-size: 12px">
    <thead>
        <tr>
            <th rowspan="2" scope="col">#</th>
            <th rowspan="2" scope="col" style="width: 10%">Karyawan</th>
            <th rowspan="2" scope="col" style="text-align: right; width: 8%">Gaji Pokok</th>
            <th colspan="5" scope="col" style="text-align: center;">Tunjangan</th>
            <th colspan="4" scope="col" style="text-align: center;">Potongan</th>
            <th rowspan="2" scope="col" style="text-align: right; width: 8%">THP</th>
        </tr>
        <tr>
            <th scope="col" style="width: width: 8%">Tj.Perusahan</th>
            <th scope="col" style="width: width: 8%">Tj.Tetap</th>
            <th scope="col" style="width: width: 8%">Hours Meter</th>
            <th scope="col" style="width: width: 8%">Lembur</th>
            <th scope="col" style="width: width: 8%">Total Tunj.</th>
            <th scope="col" style="width: width: 8%">BPJS Kesehatan</th>
            <th scope="col" style="width: width: 8%">JHT</th>
            <th scope="col" style="width: width: 8%">JP</th>
            <th scope="col">Total Pot.</th>
        </tr>
    </thead>
    <tbody>
    @if($all_karyawan_gapok->count()==0)
        @php $ket="N"; $jml_y=0; $nom=1; @endphp
        @foreach($all_karyawan as $list)
            @php
            $gapok = $list->gaji_pokok;
            $pot_bpjs_ks = ($gapok * $persen_bpjs) / 100;
            $pot_jht = ($gapok * $persen_jht) / 100;
            $pot_jp = ($gapok * $persen_jp) / 100;
            $tot_potongan = $pot_bpjs_ks + $pot_jht + $pot_jp;
            $thp = $gapok - $tot_potongan;
            @endphp
            <tr>
                <td>{{ $nom }}</td>
                <td>{{ $list->nik}}<br>{{ $list->nm_lengkap}}<br>{{ (!empty($list->id_jabatan) ? $list->get_jabatan->nm_jabatan : "") }}</td>
                <td>
                    <input type="hidden" name="id_karyawan[]" id="id_karyawan" value="{{ $list->id }}">
                    <input type="text" class="form-control angka" name="inp_gapok[]" id="inp_gapok" value="{{ $list->gaji_pokok }}" style="text-align: right; background: #e9ecef; border: 1px solid black; font-size:12px; width: 100%;" readonly>
                </td>
                <td>
                    <input type="text" class="form-control angka" name="inp_tunj_perus[]" id="inp_tunj_perus" value="0" style="text-align: right; background: white; border: 1px solid black; font-size:12px; width: 100%;" onInput="hitungTotalPotongan(this);" required>
                </td>
                <td>
                    <input type="text" class="form-control angka" name="inp_tunj_tetap[]" id="inp_tunj_tetap" value="0" style="text-align: right; background: white; border: 1px solid black; font-size:12px; width: 100%;" onInput="hitungTotalPotongan(this);" required>
                </td>
                <td>
                    <input type="text" class="form-control angka" name="inp_tunj_hours[]" id="inp_tunj_hours" value="0" style="text-align: right; background: white; border: 1px solid black; font-size:12px; width: 100%;" onInput="hitungTotalPotongan(this);" required>
                </td>
                <td>
                    <input type="text" class="form-control angka" name="inp_tunj_lembur[]" id="inp_tunj_lembur" value="0" style="text-align: right; background: white; border: 1px solid black; font-size:12px; width: 100%;" onInput="hitungTotalPotongan(this);" required>
                </td>
                <td>
                    <input type="text" class="form-control angka" name="inp_total_tunj[]" id="inp_total_tunj" value="0" style="text-align: right; background: #e9ecef; border: 1px solid black; font-size:12px; width: 100%"; readonly>
                </td>
                <td>
                    <input type="text" class="form-control angka" name="inp_bpjs_ks[]" id="inp_bpjs_ks" value="{{ $pot_bpjs_ks }}" style="text-align: right; background: #e9ecef; border: 1px solid black; font-size:12px; width: 100%;" readonly>
                </td>
                <td>
                    <input type="text" class="form-control angka" name="inp_jht_karyawan[]" id="inp_jht_karyawan" value="{{ $pot_jht }}" style="text-align: right; background: #e9ecef; border: 1px solid black; font-size:12px; width: 100%;" readonly>
                </td>
                <td>
                    <input type="text" class="form-control angka" name="inp_jp_karyawan[]" id="inp_jp_karyawan" value="{{ $pot_jp }}" style="text-align: right; background: #e9ecef; border: 1px solid black; font-size:12px; width: 100%;" readonly>
                </td>
                <td>
                    <input type="text" class="form-control angka" name="inp_total_pot[]" id="inp_total_pot" value="{{ $tot_potongan }}" style="text-align: right;background: #e9ecef; border: 1px solid black; font-size:12px; width: 100%;" readonly>
                </td>
                <td>
                    <input type="text" class="form-control angka" name="inp_thp[]" id="inp_thp" value="{{ $thp }}" style="text-align: right; background: #e9ecef; border: 1px solid black; font-size:12px; width: 100%;" readonly>
                </td>
            </tr>
            @php $nom++; @endphp
        @endforeach
        <tr>
            <td colspan="13" style="height: 50px; text-align:center; vertical-align: bottom"><button type="submit" class="btn btn-primary" name="tbl_simpan" id="tbl_simpan">Simpan Pengaturan Gaji Pokok</button></td>
        </tr>
    @else
        <tr>
            <td colspan="13" style="text-align: center; height: 40px;">Pengaturan Penggajian Telah Disimpan. Silahkan Periksa Dipelaporan Penggajian..</td>
        </tr>
    @endif
    </tbody>
</table>
<script>
    var hitungTotalPotongan = function(el) {
        var barisaktif = $(el).closest("tr");
        var gaji_pokok = $(el).parent().parent().find('input[name="inp_gapok[]"]').val();
        var tunj_perusahaan = $(el).parent().parent().find('input[name="inp_tunj_perus[]"]').val();
        var tunj_tetap = $(el).parent().parent().find('input[name="inp_tunj_tetap[]"]').val();
        var tunj_hours = $(el).parent().parent().find('input[name="inp_tunj_hours[]"]').val();
        var tunj_lembur = $(el).parent().parent().find('input[name="inp_tunj_lembur[]"]').val();
        var total_potongan = $(el).parent().parent().find('input[name="inp_total_pot[]"]').val();
        var total_tunjangan = parseFloat(tunj_perusahaan) + parseFloat(tunj_tetap) + parseFloat(tunj_hours)+ parseFloat(tunj_lembur);
        var thp = parseFloat(gaji_pokok) + parseFloat(total_tunjangan) - parseFloat(total_potongan);
        barisaktif.find('td:eq(7) input[name="inp_total_tunj[]"]').val(total_tunjangan);
        barisaktif.find('td:eq(12) input[name="inp_thp[]"]').val(thp);
    }
</script>
