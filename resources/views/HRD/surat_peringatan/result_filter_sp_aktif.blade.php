<p>Daftar Surat Peringatan Aktif</p>
<table class="table list_sp" style="width:100%">
    <tbody>
        @php $nom=1 @endphp
        @foreach ($list_sp as $list)
        <tr>
            <td style="width: 10%; vertical-align: middle">
                @if(!empty($list->photo))
                <img src="{{ url(Storage::url('hrd/photo/'.$list->photo)) }}"
                    class="rounded-circle" alt="avatar" style="width: 80px; height: auto;">
                @else
                <a href="{{ asset('assets/images/user/1.jpg') }}" data-fancybox data-caption="avatar">
                <img src="{{ asset('assets/images/user/1.jpg') }}"
                    class="rounded-circle" alt="avatar sdsdsd" style="width: 80px; height: auto;"></a>
                @endif
            </td>
            <td style="width: 25%; vertical-align: middle">
                <h5 class="mb-0">{{ $list->nm_lengkap }}</h5>
                <h6 class="mb-0">{{ $list->get_jabatan->nm_jabatan }} | {{ $list->get_departemen->nm_dept }}</h6>
            </td>
            <td style="vertical-align: middle">
                <h5 class="mb-0">Jenis SP : {{ $list->get_jenis_sp->nm_jenis_sp }}</h5>
                <h6 class="mb-0">Uraian Pelanggaran : {{ $list->get_detail_sp->uraian_pelanggaran }}</h6>
                </h6>
            </td>
            <td style="width: 20%; vertical-align: middle">
                <h5 class="mb-0">Masa Aktif</h5>
                <h6 class="mb-0"><span class="badge badge-primary">{{ date('d-m-Y', strtotime($list->sp_mulai_active)) }}</span>  s/d <span class="badge badge-danger">{{ date('d-m-Y', strtotime($list->sp_akhir_active)) }}</span></h6>
            </td>
            <td style="width: 20%; vertical-align: middle">
                @if($list->get_detail_sp->get_penonaktifan_sp()->get()->count()==0)
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Tools
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <button type="button" class="dropdown-item tbl-detail-sp" data-toggle="modal" data-target="#modalFormPengajuanSP" id="{{ $list->sp_reff }}"><i class="fa fa-print mr-2"></i>Detail</button>
                            <a class="dropdown-item" href="{{ url('hrd/suratperingatan/printsp', $list->sp_reff) }}" target="_new"><i class="fa fa-print mr-2"></i>Print SP</a>
                            <button type="button" class="dropdown-item tbl-nonaktif-sp" data-toggle="modal" data-target="#modalFormPengajuanSP" id="{{ $list->sp_reff }}"><i class="fa fa-times mr-2"></i>Penonaktifan SP</button>
                        </div>
                    </div>
                </div>
                @else
                    <button type="button" class="btn btn-success" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-hourglass"></i> Progress Penonaktifan SP</button>
                @endif
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
        $(".list_sp").on("click", ".tbl-nonaktif-sp", function(){
            var id_data = this.id;
            $("#v_inputan_sp").load("{{ url('hrd/suratperingatan/formNonAktifSP') }}/" + id_data);
        });
    });
    var goDetail = function(el)
    {
        window.open("{{ url('hrd/suratperingatan/printST') }}/"+el.id);
    }
</script>
