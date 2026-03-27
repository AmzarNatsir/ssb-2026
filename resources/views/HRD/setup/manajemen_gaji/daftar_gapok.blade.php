<form action="{{ url('hrd/setup/manajemengapok/simpangapok') }}" method="post" onsubmit="return konfirm()">
{{ csrf_field() }}
    <table id="user-list-table" class="table table-hover table-striped table-bordered mt-4" style="width:100%">
        <thead>
            <th>#</th>
            <th style="text-align: center;">NIK</th>
            <th style="text-align: center; width: 15%;">Nama Karyawan</th>
            <th style="text-align: right; width: 12%">Gaji&nbsp;Pokok</th>
            <th style="text-align: right; width: 12%">BPJS</th>
            <th style="text-align: right; width: 12%">JAMSOSTEK</th>
            <th style="text-align: center">Jabatan</th>
            <th style="text-align: center">Status</th>
        </thead>
        <tbody>
            @php $nom=1; $tot_gapok=0; $tot_bpjs=0; $tot_jamsostek=0  @endphp
            @foreach($all_karyawan_gapok as $list)
            <tr>
                <td>{{ $nom }}</td>
                <td>{{ $list->nik}}</td>
                <td>{{ $list->nm_lengkap}}</td>
                <td>
                    <input type="hidden" name="id_karyawan[]" id="id_karyawan" value="{{ $list->id }}">
                    <input type="text" class="form-control-sm angka" name="inp_gapok[]" id="inp_gapok" value="{{ (empty($list->gaji_pokok)) ? 0 : $list->gaji_pokok }}" style="text-align: right; background: white; border: 1px solid black; font-size:12px; width: 100%;" required>
                </td>
                <td>
                    <input type="text" class="form-control-sm angka" name="inp_gaji_bpjs[]" id="inp_gaji_bpjs" value="{{ (empty($list->gaji_bpjs)) ? 0 : $list->gaji_bpjs }}" style="text-align: right; background: white; border: 1px solid black; font-size:12px; width: 100%;" required>
                </td>
                <td>
                    <input type="text" class="form-control-sm angka" name="inp_gaji_jamsostek[]" id="inp_gaji_jamsostek" value="{{ (empty($list->gaji_jamsostek)) ? 0 : $list->gaji_jamsostek }}" style="text-align: right; background: white; border: 1px solid black; font-size:12px; width: 100%;" required>
                </td>
                <td>{{ (!empty($list->nm_jabatan)) ? $list->nm_jabatan : "" }}{{ (!empty($list->nm_dept)) ? " - ".$list->nm_dept : "" }}</td>
                <td>@php if($list->id_status_karyawan==1)
                    {
                        $badge_thema = 'badge iq-bg-info';
                    } elseif($list->id_status_karyawan==2) {
                        $badge_thema = 'badge iq-bg-primary';
                    } elseif($list->id_status_karyawan==3) {
                        $badge_thema = 'badge iq-bg-success';
                    } elseif($list->id_status_karyawan==7) {
                        $badge_thema = 'badge iq-bg-danger';
                    } else {
                        $badge_thema = 'badge iq-bg-warning';
                    }
                    @endphp
                   <span class="{{ $badge_thema }}">
                {{ $list->get_status_karyawan($list->id_status_karyawan) }}</span></td>

            </tr>
            @php
            $nom++;
            $tot_gapok+=$list->gaji_pokok;
            $tot_bpjs+=$list->gaji_bpjs;
            $tot_jamsostek+=$list->gaji_jamsostek;
            @endphp
            @endforeach
            <tr>
                <td colspan="3">TOTAL</td>
                <td><input type="text" class="form-control-sm angka" value="{{ $tot_gapok }}" style="text-align: right; background: #e9ecef; border: 1px solid black; font-size:12px; width: 100%;" disabled></td>
                <td><input type="text" class="form-control-sm angka" value="{{ $tot_bpjs }}" style="text-align: right; background: #e9ecef; border: 1px solid black; font-size:12px; width: 100%;" disabled></td>
                <td><input type="text" class="form-control-sm angka" value="{{ $tot_jamsostek }}" style="text-align: right; background: #e9ecef; border: 1px solid black; font-size:12px; width: 100%;" disabled></td>
                <td colspan="2"></td>
            </tr>
            <tfoot>
                <tr>
                    <td colspan="8" style="text-align: center">
                        {{-- <button type="submit" class="btn btn-success" name="tbl_simpan" id="tbl_simpan" {{ ($tot_gapok==0) ? "disabled" : "" }}>Simpan Pengaturan Gaji Pokok</button> --}}
                        <button type="submit" class="btn btn-success" name="tbl_simpan" id="tbl_simpan">Simpan Pengaturan Gaji Pokok</button>
                    </td>
                </tr>
            </tfoot>

        </tbody>
    </table>
</form>
<script type="text/javascript">
    $(document).ready(function()
    {

    });
    function konfirm()
    {
        var psn = confirm("Yakin akan menyimpan pengaturan gaji pokok karyawan ?");
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
</script>
