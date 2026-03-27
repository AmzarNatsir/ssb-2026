<table id="user-list-table" class="table table-responsive table-hover table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info">
    <thead>
        <tr>
            <th scope="col" style="text-align: center; width: 4%;">No</th>
            <th scope="col" style="width: 20%; text-align: center">Karyawan</th>
            <th scope="col" style="width: 20%; text-align: center">Posisi</th>
            <th scope="col" style="width: 10%; text-align: center">Status</th>
            <th scope="col" style="text-align: center; width: 10%">Gaji Pokok</th>
            <th scope="col" style="text-align: center; width: 10%">Tunjangan</th>
            <th scope="col" style="text-align: center; width: 10%">Potongan</th>
            <th scope="col" style="text-align: center; width: 10%">THP</th>
        </tr>
    </thead>
    <tbody>
        @php $total=0; $total_gapok=0; $total_potongan=0; $total_tunjangan=0; $nom=1; @endphp
        @foreach($list_data as $list)
            @php
            $tot_tunj = doubleval($list->tunj_perusahaan) + doubleval($list->tunj_tetap) + doubleval($list->hours_meter) + doubleval($list->lembur);
            $tot_pot = doubleval($list->bpjsks_karyawan) + doubleval($list->bpjstk_jht_karyawan) + doubleval($list->bpjstk_jp_karyawan) + doubleval($list->pot_sedekah) + doubleval($list->pot_pkk) + doubleval($list->pot_air) + doubleval($list->pot_rumah) + doubleval($list->pot_toko_alif);
            $thp = (doubleval($list->gaji_pokok) + doubleval($tot_tunj)) - doubleval($tot_pot);
            @endphp
            <tr>
                <td>{{ $nom }}</td>
                <td>{{ $list->get_profil->nik }} - {{ $list->get_profil->nm_lengkap}}</td>
                <td>{{ (!empty($list->get_profil->id_jabatan) ? $list->get_profil->get_jabatan->nm_jabatan : "") }}</td>
                <td style="text-align: center">
                    @php if($list->get_profil->id_status_karyawan==1)
                    {
                        $badge_thema = 'badge iq-bg-info';
                    } elseif($list->get_profil->id_status_karyawan==2) {
                        $badge_thema = 'badge iq-bg-primary';
                    } elseif($list->get_profil->id_status_karyawan==3) {
                        $badge_thema = 'badge iq-bg-success';
                    } elseif($list->get_profil->id_status_karyawan==7) {
                        $badge_thema = 'badge iq-bg-warning';
                    } else {
                        $badge_thema = 'badge iq-bg-danger';
                    }
                    @endphp
                    <span class="{{ $badge_thema }}">
                    @php
                    $list_status = Config::get('constants.status_karyawan');
                    foreach($list_status as $key => $value)
                    {
                        if($key==$list->get_profil->id_status_karyawan)
                        {
                            $ket_status = $value;
                            break;
                        }
                    }
                    @endphp
                    {{ $ket_status }}</span>
                </td>
                <td style="text-align: right;">{{ number_format($list->gaji_pokok, 0, ",", ".") }}</td>
                <td style="text-align: right;">
                    <div class="btn-group mb-1 dropup">
                        <button type="button" class="btn btn-success">{{ number_format($tot_tunj, 0) }}</button>
                        <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Aksi</span>
                        </button>
                        <div class="dropdown-menu">
                        <a class="dropdown-item" data-toggle="modal" data-target="#ModalForm" onclick="goTunjangan(this)" id="{{ $list['id'] }}"><i class="ri-table-line mr-2"></i> Detail</a>
                        </div>
                    </div>
                </td>
                <td style="text-align: right;">
                    <div class="btn-group mb-1 dropup">
                        <button type="button" class="btn btn-danger">{{ number_format($tot_pot, 0) }}</button>
                        <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Aksi</span>
                        </button>
                        <div class="dropdown-menu">
                        <a class="dropdown-item" data-toggle="modal" data-target="#ModalForm" onclick="goPotongan(this)" id="{{ $list['id'] }}"><i class="ri-table-line mr-2"></i> Detail</a>
                        </div>
                    </div>
                </td>
                <td style="text-align: right;">{{ number_format($thp, 0, ",", ".") }}</td>
            </tr>
            @php $nom++;
            $total_gapok+=$list->gaji_pokok;
            $total+=$thp;
            $total_tunjangan+=$tot_tunj;
            $total_potongan+=$tot_pot;
            @endphp
        @endforeach
    </tbody>
    <tfoot class="btn-primary">
        <tr>
            <td colspan="4" style="text-align: right;"><b>TOTAL</b></td>
            <td style="text-align: right;"><b>{{ number_format($total_gapok, 0, ",", ".") }}</b></td>
            <td style="text-align: right;"><b>{{ number_format($total_tunjangan, 0, ",", ".") }}</b></td>
            <td style="text-align: right;"><b>{{ number_format($total_potongan, 0, ",", ".") }}</b></td>
            <td style="text-align: right;"><b>{{ number_format($total, 0, ",", ".") }}</b></td>
        </tr>
    </tfoot>
</table>
<div id="ModalForm" class="modal fade bg-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-ml" role="document">
        <div class="modal-content" id="v_form"></div>
    </div>
 </div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#user-list-table').DataTable();
    });
    var goTunjangan = function(el)
    {
        var id_data = el.id
        $("#v_form").load("{{ url('hrd/pelaporan/penggajian/detailTunjangan/')}}/"+id_data, function(){
            $(".angka").number(true, 0);
        });
    }
    var goPotongan = function(el)
    {
        var id_data = el.id;
        $("#v_form").load("{{ url('hrd/pelaporan/penggajian/detailPotongan/')}}/"+id_data, function(){
            $(".angka").number(true, 0);
        });
    }
</script>
