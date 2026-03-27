<table id="user-list-table" class="table  table-hover table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info">
    <thead>
        <tr>
            <th scope="col" rowspan="3" style="width: 5%;">#</th>
            <th scope="col" rowspan="3" style="width: 30%;">Karyawan</th>
            <th scope="col" rowspan="3" style="width: 20%;">Surat</th>
            <th scope="col" colspan="6" style="text-align: center;">Perubahan Status</th>
            <th scope="col" rowspan="3" style="width: 5%;">Act.</th>
        </tr>
        <tr>
            <th colspan="3" class="btn-success" style="text-align: center">Status Lama</th>
            <th colspan="3" class="btn-danger" style="text-align: center">Status Baru</th>
        </tr>
        <tr>
            <th style="width: 10%;">Status</th>
            <th style="width: 5%;">Efektif</th>
            <th style="width: 5%;">Berakhir</th>
            <th style="width: 10%;">Status</th>
            <th style="width: 5%;">Efektif</th>
            <th style="width: 5%;">Berakhir</th>
        </tr>
    </thead>

    <tbody id="result_riwayat">
    @php $nom=1; @endphp
    @foreach($list_data as $list)
        <tr>
            <td style="vertical-align: top;">{{ $nom }}</td>
            <td>NIK : {{ $list->get_profil->nik }}<br>
            Nama : {{ $list->get_profil->nm_lengkap }}<br>
            Jabatan : {{ (!empty($list->get_profil->get_jabatan->nm_jabatan)) ? $list->get_profil->get_jabatan->nm_jabatan : "" }} 
            {{ (!empty($list->get_profil->id_departemen)) ? "Dept. : ".$list->get_profil->get_departemen->nm_dept : "" }}
            {{ (!empty($list->get_profil->id_subdepartemen)) ? ", Sub Dept. : ".$list->get_profil->get_subdepartemen->nm_subdept : "" }} )
            </td>
            <td style="vertical-align: top;">Nomor : {{ $list->no_surat }}<br>Tanggal : {{ date_format(date_create($list->tgl_surat), "d-m-Y") }}</td>
            <td style="vertical-align: top;">{{ $list->get_status_karyawan($list->id_sts_lama) }}</td>
            <td style="vertical-align: top;">{{ date_format(date_create($list->tgl_eff_lama), 'd-m-Y') }}</td>
            <td style="vertical-align: top;">{{ date_format(date_create($list->tgl_akh_lama), 'd-m-Y') }}</td>
            <td style="vertical-align: top;">{{ $list->get_status_karyawan($list->id_sts_baru) }}</td>
            <td style="vertical-align: top;">{{ date_format(date_create($list->tgl_eff_baru), 'd-m-Y') }}</td>
            <td style="vertical-align: top;">@if(!empty($list->tgl_akh_baru)){{ date_format(date_create($list->tgl_akh_baru), 'd-m-Y') }} @endif</td>
            <td>
            <button type="button" class="btn btn-primary tbl_print" id="{{ \App\Helpers\Hrdhelper::encrypt_decrypt('encrypt',$list->id) }}" ><i class="fa fa-print"></i></button>
            </td>
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
            window.open("{{ url('hrd/perubahanstatus/print') }}/"+id_data);
        });
    });
</script>