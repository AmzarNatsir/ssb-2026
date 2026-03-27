<p>Daftar Pengajuan Surat Peringatan</p>
<table class="table list_sp" style="width:100%">
    <tbody>
        @php $nom=1 @endphp
        @foreach ($list_pengajuan as $list)
        <tr>
            <td style="width: 10%; vertical-align: middle">
                @if(!empty($list->profil_karyawan->photo))
                <img src="{{ url(Storage::url('hrd/photo/'.$list->profil_karyawan->photo)) }}"
                    class="rounded-circle" alt="avatar" style="width: 80px; height: auto;">
                @else
                <a href="{{ asset('assets/images/user/1.jpg') }}" data-fancybox data-caption="avatar">
                <img src="{{ asset('assets/images/user/1.jpg') }}"
                    class="rounded-circle" alt="avatar sdsdsd" style="width: 80px; height: auto;"></a>
                @endif
            </td>
            <td style="width: 20%">
                <h4 class="mb-0">{{ $list->profil_karyawan->nm_lengkap }}</h4>
                <h6 class="mb-0">{{ $list->profil_karyawan->get_jabatan->nm_jabatan }} | {{ $list->profil_karyawan->get_departemen->nm_dept }}</h6>
            </td>
            <td>
                <h4 class="mb-0">Rekomendasi SP : {{ $list->get_master_jenis_sp_diajukan->nm_jenis_sp }}</h4>
                <h6 class="mb-0">Uraian Pelanggaran : {{ $list->uraian_pelanggaran }}</h6>
                </h6>
            </td>
            <td style="width: 10%; vertical-align: middle">
                @if($list->sts_pengajuan==1)
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
            <td style="width: 5%; vertical-align: middle">
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Tools
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <button type="button" class="dropdown-item tbl-detail-sp" tbl-detail-st id="{{ $list->id }}" data-toggle="modal" data-target="#modalFormPengajuanSP" name="btn-detail-sp[]" title="Detail"><i class="fa fa-eye"></i> Detail Pengajuan</button>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        @php $nom++ @endphp
        @endforeach
    </tbody>
</table>
<div id="modalFormPengajuanSP" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content" id="v_inputan_sp" style="overflow-y: auto;"></div>
    </div>
 </div>
 <script type="text/javascript">
    $(document).ready(function()
    {
        $(".list_sp").on("click", ".tbl-detail-sp", function(){
            var id_data = this.id;
            $("#v_inputan_sp").load("{{ url('hrd/suratperingatan/detailSP') }}/" + id_data);
        });
    });
</script>
