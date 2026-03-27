<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Detail Perjalanan Dinas</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <div class="iq-card">
        <div class="row">
            <div class="col-sm-6 col-lg-6">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                       <h4 class="card-title">Profil Karyawan</h4>
                    </div>
                 </div>
                 <div class="iq-card-body">
                    <ul class="list-group">
                       <li class="list-group-item disabled" aria-disabled="true">NIK : {{ $profil->get_profil->nik }}</li>
                       <li class="list-group-item">Nama Karyawan : {{ $profil->get_profil->nm_lengkap }}</li>
                       <li class="list-group-item">Jabatan : {{ $profil->get_profil->get_jabatan->nm_jabatan }}</li>
                       <li class="list-group-item">Departemen : {{ $profil->get_profil->get_departemen->nm_dept }}</li>
                    </ul>
                 </div>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                       <h4 class="card-title">Data Perjalanan Dinas</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    <ul class="list-group">
                        <li class="list-group-item disabled" aria-disabled="true">Tanggal Pengajuan : {{ date_format(date_create($profil->tgl_perdis), 'd-m-Y') }}</li>
                        <li class="list-group-item">Maksud dan Tujuan : {{ $profil->maksud_tujuan }}</li>
                        <li class="list-group-item">Tanggal Berangkat : {{ date('d-m-Y', strtotime($profil->tgl_berangkat)) }} s/d {{ date('d-m-Y', strtotime($profil->tgl_kembali)) }}</li>
                        <li class="list-group-item">Tujuan : {{ $profil->tujuan }}</li>
                     </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5 col-lg-12">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                       <h4 class="card-title">Fasilitas Perjalanan Dinas</h4>
                    </div>
                 </div>
                 <div class="iq-card-body">
                    <div class="container-fluid">
                        <table class="table list_item_1" style="width: 100%; height: auto">
                            <tr style="background-color: rgb(198, 213, 200); color: rgb(3, 3, 3)">
                              <td colspan="7" style="width: 95%">Rincian Biaya</td>
                            </tr>
                            <tr>
                                <td style="width: ">Item</td>
                                <td style="width: 10%; text-align:center">Hari</td>
                                <td style="width: 15%; text-align:right">Biaya</td>
                                <td style="width: 15%; text-align:right">Sub Total</td>
                                <td style="width: 15%; text-align:right">Realisasi</td>
                                <td colspan="2" style="text-align:center;">File</td>
                            </tr>
                            @php $total=0; $total_realisasi=0; $selisih=0; $path = "hrd/dataku/perdis/".$profil->id."/"; @endphp
                            @foreach ($fasilitas as $list)
                            <tr>
                                <td>- {{ $list->get_master_fasilitas_perdis->nm_fasilitas }}</td>
                                <td style="text-align:center">{{ $list->hari }}</td>
                                <td style="text-align:right">{{ number_format($list->biaya, 0) }}</td>
                                <td style="text-align:right">{{ number_format($list->sub_total, 0) }}</td>
                                <td style="text-align:right">{{ number_format($list->realisasi, 0) }}</td>
                                <td style="text-align:center; width: 10%;">
                                    @if(!empty($list->file_1))
                                    <a href="{{ url(Storage::url($path.$list->file_1)) }}" data-fancybox data-caption='Dokumen'>
                                    <img src="{{ url(Storage::url($path.$list->file_1)) }}" style="width: auto; height: 100px" alt="Dokumen"></a>
                                    @endif
                                </td>
                                <td style="text-align:center; width: 10%;">
                                    @if(!empty($list->file_2))
                                    <a href="{{ url(Storage::url($path.$list->file_2)) }}" data-fancybox data-caption='Dokumen'>
                                    <img src="{{ url(Storage::url($path.$list->file_2)) }}" style="width: auto; height: 100px" alt="Dokumen"></a>
                                    @endif
                                </td>
                            </tr>
                            @php $total+=$list->sub_total; $total_realisasi+=$list->realisasi @endphp
                            @endforeach
                            @php $selisih=$total - $total_realisasi @endphp
                            <tr style="background-color: rgb(198, 213, 200); color: rgb(3, 3, 3)">
                                <td colspan="3" style="text-align:right"><b>Total</b></td>
                                <td style="text-align:right"><b>{{ number_format($total, 0) }}</b></td>
                                <td style="text-align:right"><b>{{ number_format($total_realisasi, 0) }}</b></td>
                                <td colspan="2"></td>
                            </tr>
                            <tr style="background-color: rgb(198, 213, 200); color: rgb(3, 3, 3)">
                                <td colspan="3" style="text-align:right"><b>Selisih</b></td>
                                <td style="text-align:right">
                                    @if($selisih < 0)
                                        <b class="text-danger">{{ number_format($selisih, 0) }}</b>
                                    @else
                                        <b class="text-primary">{{ number_format($selisih, 0) }}</b>
                                    @endif
                                </td>
                                <td style="text-align:right"></td>
                                <td colspan="2"></td>
                            </tr>
                        </table>
                    </div>
                 </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" onclick="goPrintDetail(this)" value="{{ $profil->id }}"><i class="fa fa-print"></i> Print Rincian Biaya</button>
</div>

<script type="text/javascript">
    var goPrintDetail = function(el)
    {
        var id_data = $(el).val();
        window.open("{{ url('hrd/perjalanandinas/printRincianBiaya') }}/"+id_data);
    }
</script>
