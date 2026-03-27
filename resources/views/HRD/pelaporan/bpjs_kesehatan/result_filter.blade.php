<table id="user-list-table" class="table table-responsive table-hover table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info">
    <thead>
        <tr>
            <th rowspan="3" scope="col" style="width: 5%;">#</th>
            <th rowspan="3" scope="col" style="width: 10%;">NIK</th>
            <th rowspan="3" scope="col">NAMA&nbsp;KARYAWAN</th>
            <th rowspan="3" scope="col" style="text-align: center; width: 10%">Upah</th>
            <th colspan="2" scope="col" style="text-align: center;">KESEHATAN</th>
            <th rowspan="3" scope="col" style="text-align: center; width: 10%">TOTAL</th>
            <th rowspan="3" scope="col" style="text-align: center; width: 20%">KETERANGAN</th>
        </tr>
        <tr>
            <th scope="col" style="width: 10%; text-align: center;">TENAGA&nbsp;KERJA</th>
            <th scope="col" style="width: 10%; text-align: center;">PERUSAHAAN</th>
        </tr>
        <tr>
            <th scope="col" style="width: 10%; text-align: center;">{{ number_format($persen_bpjsks_kary, 2, ",", ".") }} %</th>
            <th scope="col" style="width: 10%; text-align: center;">{{ number_format($persen_bpjsks_pers, 2, ",", ".") }} %</th>
        </tr>
    </thead>
    <tbody>
        @php $total=0; $nom=1; @endphp
        @foreach($list_data as $list)
            @php
            $sub_total = doubleval($list->bpjsks_karyawan) + doubleval($list->bpjstk_jht_karyawan);
            @endphp
            <tr>
                <td>{{ $nom }}</td>
                <td>{{ $list->get_profil->nik }}</td>
                <td>{{ $list->get_profil->nm_lengkap}}</td>
                <td style="text-align: right;">{{ number_format($list->gaji_bpjs, 0, ",", ".") }}</td>
                <td style="text-align: right;">{{ number_format($list->bpjsks_karyawan, 0, ",", ".") }}</td>
                <td style="text-align: right;">{{ number_format($list->bpjstk_jht_karyawan, 0, ",", ".") }}</td>
                <td style="text-align: right;">{{ number_format($sub_total, 0, ",", ".") }}</td>
                <td>{{ $list->get_profil->get_departemen->nm_dept }}</td>
            </tr>
            @php $nom++; $total+=$sub_total; @endphp
        @endforeach
    </tbody>
    <tfoot class="btn-primary">
        <tr>
            <td colspan="6" style="text-align: right;"><b>TOTAL</b></td>
            <td style="text-align: right;"><b>{{ number_format($total, 0, ",", ".") }}</b></td>
            <td></td>
        </tr>
    </tfoot>
</table>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#user-list-table').DataTable();
    });
</script>
