<table>
    <tr>
        <td>ID</td>
        <td>NIK</td>
        <td>NAMA_KARYAWAN</td>
        <td>STATUS</td>
        <td>POSISI</td>
        <td>GAJI_POKOK</td>
        <td>BPJS</td>
        <td>JAMSOSTEK</td>
    </tr>
    @foreach ($list_karyawan as $r)
    <tr>
        <td>{{ $r->id }}</td>
        <td>{{ "'".$r->nik }}</td>
        <td>{{ $r->nm_lengkap }}</td>
        <td>@php
            $ket_status = "";
            $list_status = Config::get('constants.status_karyawan');
            if(!empty($r->id_status_karyawan))
            {
                foreach($list_status as $key => $value)
                {
                    if($key==$r->id_status_karyawan)
                    {
                        $ket_status = $value;
                        break;
                    }
                }
            }
            @endphp
            {{ $ket_status }}</td>
        <td>{{ $r->nm_jabatan }} - {{ $r->nm_dept }}</td>
        <td>{{ $r->gaji_pokok }}</td>
        <td>{{ $r->gaji_bpjs }}</td>
        <td>{{ $r->gaji_jamsostek }}</td>
    </tr>
    @endforeach
</table>
