<div class="iq-card-header d-flex justify-content-between">
    <div class="iq-header-title">
        <h4 class="card-title">Daftar Pengajuan Perjalanan Dinas</h4>
    </div>
</div>
<div class="iq-card-body" style="width:100%; height:auto">
    <table class="table datatable table-hover" style="font-size: 13px;">
        <thead>
            <tr>
                <th scope="col" rowspan="2" style="width: 5%;">#</th>
                <th scope="col" rowspan="2" style="width: 10%;">Tanggal&nbsp;Pengajuan</th>
                <th scope="col" rowspan="2" style="width: 15%;">Karyawan</th>
                <th scope="col" rowspan="2" style="width: 15%;">Tujuan/Lokasi</th>
                <th scope="col" rowspan="2">Alasan</th>
                <th scope="col" colspan="2" style="text-align: center; width: 20%;">Tanggal Perjalanan</th>
                <th scope="col" rowspan="2" style="text-align: center; width: 10%;">Persetujuan</th>
                <th scope="col" rowspan="2" style="text-align: center; width: 10%;">Act</th>
            </tr>
            <tr>
                <th style="text-align: center">Berangkat</th>
                <th style="text-align: center">Kembali</th>
            </tr>
        </thead>
        <tbody>
        @php $nom=1 @endphp
        @foreach($list_pengajuan as $list)
        <tr>
            <td style="text-align: center;">{{ $nom }}</td>
            <td style="text-align: center;">{{ date_format(date_create($list->tgl_pengajuan), 'd-m-Y') }}</td>
            <td>{{ $list->get_profil->nm_lengkap }}</td>
            <td>{{ $list->tujuan }}</td>
            <td>{{ $list->maksud_tujuan }}</td>
            <td style="text-align: center;">{{ date_format(date_create($list->tgl_berangkat), 'd-m-Y') }}</td>
            <td style="text-align: center;">{{ date_format(date_create($list->tgl_kembali), 'd-m-Y') }}</td>
            <td style="text-align: center;">
            @if($list->sts_pengajuan==1)
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
            @elseif($list->sts_pengajuan==2)
                <button type="button" class="btn btn-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-check"></i> Approved</button>
            @else
                <button type="button" class="btn btn-dark" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-times"></i> Rejected</button>
            @endif
            </td>
            <td style="text-align: center;">
            @if($list->sts_pengajuan==2)
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Opsi
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            @if($list->tgl_berangkat >= date('Y-m-d'))
                                <button type="button"class="dropdown-item" value="{{ $list->id }}" data-toggle="modal" data-target="#modalFormSetting" onclick="goForm(this)" title="Pengaturan Administrasi"><i class="fa fa-gear"></i> Pengaturan Administrasi</button>
                            @else
                                <button type="button" class="dropdown-item" value="{{ $list->id }}" data-toggle="modal" data-target="#modalFormSetting" onclick="goDetail(this)" title="Detail"><i class="fa fa-eye"></i> Detail</button>
                            @endif
                            @if((!empty($list->no_perdis)))
                            <button type="button" class="dropdown-item" onclick="goPrint(this)" value="{{ $list->id }}"><i class="fa fa-print"></i> Surat Perjalanan Dinas</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            </td>
        </tr>
        @php $nom++ @endphp
        @endforeach
        </tbody>
    </table>
</div>
<div id="modalFormSetting" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" id="v_inputan" style="overflow-y: auto;"></div>
    </div>
 </div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    });
    var goForm = function(el)
    {
        var id_data = $(el).val();
        $("#v_inputan").load("{{ url('hrd/perjalanandinas/pengaturanPerdis') }}/"+id_data);
    }
    var goDetail = function(el)
    {
        var id_data = $(el).val();
        $("#v_inputan").load("{{ url('hrd/perjalanandinas/detailPerdis') }}/"+id_data);
    }
    var goPrint = function(el)
    {
        var id_data = $(el).val();
        window.open("{{ url('hrd/perjalanandinas/printSuratPerdis') }}/"+id_data);
    }
</script>
