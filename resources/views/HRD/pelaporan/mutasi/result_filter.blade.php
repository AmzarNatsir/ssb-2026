<table id="user-list-table" class="table  table-hover table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info">
    <thead>
        <tr>
            <th scope="col" rowspan="2" style="width: 5%;">#</th>
            <th scope="col" rowspan="2" style="width: 20%;">Karyawan</th>
            <th scope="col" rowspan="2" style="width: 20%;">Surat</th>
            <th scope="col" colspan="2" style="text-align: center;">Penempatan Posisi/Jabatan</th>
            <th scope="col" rowspan="2">Act</th>
        </tr>
        <tr>
            <th class="btn-success" style="text-align: center; width: 25%;">Posisi/Jabatan Lama</th>
            <th class="btn-danger" style="text-align: center; width: 25%;">Posisi/Jabatan Baru</th>
        </tr>
    </thead>
    <tbody id="result_riwayat">
    @php $nom=1; @endphp
    @foreach($list_data as $list)
        <tr>
            <td style="vertical-align: top; text-align:center">{{ $nom }}</td>
            <td style="vertical-align: top;">{{ $list->get_profil->nik }} - {{ $list->get_profil->nm_lengkap }}
            </td>
            <td style="vertical-align: top;">Nomor : {{ $list->no_surat }}<br>
            Tanggal : {{ date_format(date_create($list->tgl_surat), "d-m-Y") }}
            </td>
            <td>
                Jabatan : {{ $list->get_jabatan_lama->nm_jabatan }}<br>
                Departemen : {{ (!empty($list->id_dept_lm)) ? $list->get_dept_lama->nm_dept : "" }}<br>
            </td>
            <td>
                Jabatan : {{ $list->get_jabatan_baru->nm_jabatan }}<br>
                Departemen : {{ (!empty($list->id_dept_br)) ? $list->get_dept_baru->nm_dept : "" }}<br>
            </td>
            <td><button type="button" class="btn btn-primary tbl_print" id="{{ $list->id }}"><i class="fa fa-print"></i></button></td>
        </tr>
    @php $nom++; @endphp
    @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function()
    {
        $(".tbl_print").on("click", function()
        {
            var id_data = this.id;
            window.open("{{ url('hrd/mutasi/print') }}/"+id_data);
        });
    });
</script>
