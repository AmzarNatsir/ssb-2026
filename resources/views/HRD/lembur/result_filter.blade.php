<div class="iq-card-header d-flex justify-content-between">
    <div class="iq-header-title">
        <h4 class="card-title">{{ $ket }}</h4>
    </div>
</div>
<div class="iq-card-body" style="width:100%; height:auto">
    <table class="table datatable table-hover" style="font-size: 13px;">
        <thead>
            <tr>
                <th scope="col" rowspan="2" style="width: 5%;">#</th>
                <th scope="col" rowspan="2" style="width: 20%;">Karyawan</th>
                <th scope="col" rowspan="2" style="text-align: center; width: 10%;">Tanggal</th>
                <th scope="col" colspan="3" style="text-align: center; width: 20%;">Durasi Jam</th>
                <th scope="col" rowspan="2">Deskripsi Pekerjaan</th>
                <th scope="col" rowspan="2" style="text-align: center; width: 10%;">Status</th>
                <th scope="col" rowspan="2" style="text-align: center; width: 10%;">Act</th>
            </tr>
            <tr>
                <th style="text-align: center">Mulai</th>
                <th style="text-align: center">Selesai</th>
                <th style="text-align: center">Total</th>
            </tr>
        </thead>
        <tbody>
        @php $nom=1 @endphp
        @foreach($list_pengajuan as $list)
        <tr>
            <td style="text-align: center;">{{ $nom }}</td>
            <td>{{ $list->get_profil_karyawan->nik }} | {{ $list->get_profil_karyawan->nm_lengkap }}<br>
                {{ (!empty($list->get_profil_karyawan->get_jabatan->nm_jabatan)) ? $list->get_profil_karyawan->get_jabatan->nm_jabatan : "" }}  {{ (!empty($list->get_profil_karyawan->id_departemen)) ? " - ".$list->get_profil_karyawan->get_departemen->nm_dept : "" }}
            </td>
            <td style="text-align: center;">{{ date_format(date_create($list->tgl_pengajuan), 'd-m-Y') }}</td>
            <td style="text-align: center;">{{ $list->jam_mulai }}</td>
            <td style="text-align: center;">{{ $list->jam_selesai }}</td>
            <td style="text-align: center;">{{ $list->total_jam }}</td>
            <td>{{ $list->deskripsi_pekerjaan }}</td>
            <td style="text-align: center;">
            @if($list->status_pengajuan==1)
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Menunggu Persetujuan
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item" href="#"><i class="fa fa-user mr-1"></i>{{ $list->get_current_approve->nm_lengkap }}</a>
                            <a class="dropdown-item" href="#"><i class="fa fa-user mr-1"></i>{{ $list->get_current_approve->get_jabatan->nm_jabatan }}</a>
                        </div>
                    </div>
                </div>
            @elseif($list->status_pengajuan==2)
                <button type="button" class="btn btn-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-check"></i> Approved</button>
            @else
                <button type="button" class="btn btn-dark" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-times"></i> Rejected</button>
            @endif
            </td>
            <td style="text-align: center">
                @if($list->status_pengajuan==2)
                <button type="button" class="btn btn-primary" value="{{ $list->id }}" data-toggle="modal" data-target="#modalDetail" onclick="goDetail(this)" title="Detail Lembur"><i class="fa fa-eye"></i></button>
                @endif
            </td>
        </tr>
        @php $nom++ @endphp
        @endforeach
        </tbody>
    </table>
</div>
<div id="modalDetail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" id="v_inputan" style="overflow-y: auto;"></div>
    </div>
 </div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    });
    var goDetail = function(el)
    {
        var id_data = $(el).val();
        $("#v_inputan").load("{{ url('hrd/lembur/detailData') }}/"+id_data);
    }
</script>
