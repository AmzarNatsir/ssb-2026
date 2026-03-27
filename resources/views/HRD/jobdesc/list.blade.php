<table style="width: 100%; font-size:12px" id="table_lembur" class="table datatable">
    <thead>
        <th class="text-center">No.</th>
        <th class="text-center">Jabatan</th>
        <th class="text-center">Departemen</th>
        <th class="text-center">Sub Departemen</th>
        <th class="text-center">Job Description</th>
    </thead>
    <tbody>
        @php($no=1)
        @foreach ($list_data as $list)
        <tr>
            <td class="text-center">{{ $no }}</td>
            <td>{{ $list->nm_jabatan }}</td>
            <td>{{ (!empty($list->id_dept)) ? $list->mst_departemen->nm_dept : "" }}</td>
            <td>{{ (!empty($list->id_subdept)) ? $list->mst_subdepartemen->nm_subdept : "" }}</td>
            <td class="text-center">
                @if(!blank($list->file_jobdesc))
                <a href="{{ url('hrd/masterdata/jabatan/jobdesc/download/'.$list->id) }}" target="_new" class="btn btn-danger btn-block"><i class="ri-download-line"></i></a>
                @endif
            </td>
        </tr>
        @php($no++)
        @endforeach
    </tbody>
</table>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('.datatable').DataTable();
    });
</script>
