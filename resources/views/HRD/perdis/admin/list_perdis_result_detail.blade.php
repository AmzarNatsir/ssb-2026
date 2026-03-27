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
                            <tr style="background-color: rgb(72, 152, 244); color: white">
                              <td colspan="4" style="text-align:center">Rincian Biaya</td>
                              <td colspan="2" style="text-align:center">Dokumen</td>
                            </tr>
                            <tr>
                                <td>Item</td>
                                <td style="width: 5%; text-align:center">Hari</td>
                                <td style="width: 15%; text-align:right">Biaya</td>
                                <td style="width: 20%; text-align:right">Sub Total</td>
                                <td colspan="2" style="text-align:center;">File</td>
                            </tr>
                            @php $total=0; $path = "hrd/dataku/perdis/".$profil->id."/"; @endphp
                            @foreach ($fasilitas as $list)
                            <tr>
                                <td>- {{ $list->get_master_fasilitas_perdis->nm_fasilitas }}</td>
                                <td style="text-align:center">{{ $list->hari }}</td>
                                <td style="text-align:right">{{ number_format($list->biaya, 0) }}</td>
                                <td style="text-align:right">{{ number_format($list->sub_total, 0) }}</td>
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
                            @php $total+=$list->sub_total @endphp
                            @endforeach
                            <tr>
                                <td colspan="3" style="text-align:right">Total</td>
                                <td style="text-align:right"><b>{{ number_format($total, 0) }}</b></td>
                                <td></td>
                                <td></td>
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
</div>
