<table id="user-list-table" class="table table-responsive table-hover table-striped table-bordered mt-4" style="font-size: 12px" role="grid" aria-describedby="user-list-page-info">
    <thead>
        <tr>
            <th rowspan="3" scope="col" style="width: 3%;">#</th>
            <th rowspan="3" scope="col">KARYAWAN</th>
            <th rowspan="3" scope="col" style="text-align: center; width: 10%">DEPARTEMEN</th>
            <th rowspan="3" scope="col" style="text-align: center; width: 10%">UPDAH</th>
            <th colspan="2" scope="col" style="text-align: center;">JHT</th>
            <th colspan="2" scope="col" style="text-align: center;">JKK</th>
            <th colspan="2" scope="col" style="text-align: center;">JKM</th>
            <th colspan="2" scope="col" style="text-align: center;">JP</th>
            <th rowspan="3" scope="col" style="text-align: center; width: 7%">TOTAL</th>
        </tr>
        <tr>
            <th scope="col" style="width: 7%; text-align: center;">TENAGA&nbsp;KERJA</th>
            <th scope="col" style="width: 7%; text-align: center;">PERUSAHAAN</th>
            <th scope="col" style="width: 7%; text-align: center;">TENAGA&nbsp;KERJA</th>
            <th scope="col" style="width: 7%; text-align: center;">PERUSAHAAN</th>
            <th scope="col" style="width: 7%; text-align: center;">TENAGA&nbsp;KERJA</th>
            <th scope="col" style="width: 7%; text-align: center;">PERUSAHAAN</th>
            <th scope="col" style="width: 7%; text-align: center;">TENAGA&nbsp;KERJA</th>
            <th scope="col" style="width: 7%; text-align: center;">PERUSAHAAN</th>
        </tr>
        <tr>
            <th scope="col" style="width: 7%; text-align: center;">{{ number_format($persen_jht_kary, 2, ",", ".") }} %</th>
            <th scope="col" style="width: 7%; text-align: center;">{{ number_format($persen_jht_pers, 2, ",", ".") }} %</th>
            <th scope="col" style="width: 7%; text-align: center;">{{ number_format($persen_jkk_kary, 2, ",", ".") }} %</th>
            <th scope="col" style="width: 7%; text-align: center;">{{ number_format($persen_jkk_pers, 2, ",", ".") }} %</th>
            <th scope="col" style="width: 7%; text-align: center;">{{ number_format($persen_jkm_kary, 2, ",", ".") }} %</th>
            <th scope="col" style="width: 7%; text-align: center;">{{ number_format($persen_jkm_pers, 2, ",", ".") }} %</th>
            <th scope="col" style="width: 7%; text-align: center;">{{ number_format($persen_jp_kary, 2, ",", ".") }} %</th>
            <th scope="col" style="width: 7%; text-align: center;">{{ number_format($persen_jp_pers, 2, ",", ".") }} %</th>
        </tr>
    </thead>
    <tbody>
        @php $total=0; $nom=1; @endphp
        @foreach($list_data as $list)
            @php
            $sub_total = doubleval($list->bpjstk_jht_karyawan) + doubleval($list->bpjstk_jht_perusahaan) + doubleval($list->bpjstk_jkk_karyawan) + doubleval($list->bpjstk_jkk_perusahaan) + doubleval($list->bpjstk_jkm_karyawan) + doubleval($list->bpjstk_jkm_perusahaan) + doubleval($list->bpjstk_jp_karyawan) + doubleval($list->bpjstk_jp_perusahaan);
            @endphp
            <tr>
                <td>{{ $nom }}</td>
                <td>{{ $list->get_profil->nik }}<br>{{ $list->get_profil->nm_lengkap}}</td>
                <td>{{ $list->get_profil->get_departemen->nm_dept }}</td>
                <td style="text-align: right;">{{ number_format($list->gaji_bpjs, 0, ",", ".") }}</td>
                <td style="text-align: right;">{{ number_format($list->bpjstk_jht_karyawan, 0, ",", ".") }}</td>
                <td style="text-align: right;">{{ number_format($list->bpjstk_jht_perusahaan, 0, ",", ".") }}</td>
                <td style="text-align: right;">{{ number_format($list->bpjstk_jkk_karyawan, 0, ",", ".") }}</td>
                <td style="text-align: right;">{{ number_format($list->bpjstk_jkk_perusahaan, 0, ",", ".") }}</td>
                <td style="text-align: right;">{{ number_format($list->bpjstk_jkm_karyawan, 0, ",", ".") }}</td>
                <td style="text-align: right;">{{ number_format($list->bpjstk_jkm_perusahaan, 0, ",", ".") }}</td>
                <td style="text-align: right;">{{ number_format($list->bpjstk_jp_karyawan, 0, ",", ".") }}</td>
                <td style="text-align: right;">{{ number_format($list->bpjstk_jp_perusahaan, 0, ",", ".") }}</td>
                <td style="text-align: right;">{{ number_format($sub_total, 0, ",", ".") }}</td>
            </tr>
            @php $nom++; $total+=$sub_total; @endphp
        @endforeach
    </tbody>
    <tfoot class="btn-primary">
        <tr>
            <td colspan="12" style="text-align: right;"><b>TOTAL</b></td>
            <td style="text-align: right;"><b>{{ number_format($total, 0, ",", ".") }}</b></td>
        </tr>
    </tfoot>
</table>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#user-list-table').DataTable();
    });
</script>
