<table id="user-list-table" class="table-hover table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info" style="width: 100%; font-size: 13px">
    <thead>
        <tr>
            <th scope="col" style="text-align: center; width: 3%;"></th>
            <th scope="col" style="text-align: center; width: 3%;">No</th>
            <th scope="col" style="width: 20%; text-align: center">Karyawan</th>
            <th scope="col" style="width: 20%; text-align: center">Posisi</th>
            <th scope="col" style="width: 10%; text-align: center">Status</th>
            <th scope="col" style="text-align: center; width: 10%">Gaji Pokok</th>
            <th scope="col" style="text-align: center; width: 10%">Tunjangan</th>
            <th scope="col" style="text-align: center; width: 10%">Gaji Bruto</th>
            <th scope="col" style="text-align: center; width: 10%">Potongan</th>
            <th scope="col" style="text-align: center; width: 10%">THP</th>
        </tr>
    </thead>
    <tbody>
    {{-- @if($all_karyawan_gapok->count()==0) --}}
        @php $ket="N"; $jml_y=0; $nom=1; @endphp
        @foreach($all_karyawan as $list)
            @php
            $tunj_perusahaan = 0;
            $tunj_tetap = 0;
            $hours_meter = 0;
            $lembur = 0;
            $tot_tunjangan = 0;
            @endphp
            @if($list['payrol']==null)
                @php
                $gapok = $list['gaji_pokok'];
                $pot_bpjs_ks = 0;
                $pot_jht = 0;
                $pot_jp = 0;
                $pot_jkm = 0;
                $tot_potongan = $pot_bpjs_ks + $pot_jht + $pot_jp + $pot_jkm;
                $tunj_bpjs_perusahaan = 0;
                $total_tunj_perusahaan = 0;
                $gaji_bruto=0;
                $thp = 0;
                @endphp
            @else
                @php
                $gapok = $list['payrol']['gaji_pokok'];
                //potongan
                $pot_bpjs_ks = $list['payrol']['bpjsks_karyawan'];
                $pot_jht = $list['payrol']['bpjstk_jht_karyawan'];
                $pot_jp = $list['payrol']['bpjstk_jp_karyawan'];
                $pot_jkm = $list['payrol']['bpjstk_jkm_karyawan'];
                $pot_sedekah = $list['payrol']['pot_sedekah'];
                $pot_pkk = $list['payrol']['pot_pkk'];
                $pot_air = $list['payrol']['pot_air'];
                $pot_rumah = $list['payrol']['pot_rumah'];
                $pot_toko_alif = $list['payrol']['pot_toko_alif'];
                $tot_potongan = $pot_bpjs_ks + $pot_jht + $pot_jp + $pot_jkm + $pot_sedekah + $pot_pkk + $pot_air + $pot_rumah + $pot_toko_alif;
                //tunjangan
                $total_tunj_perusahaan = $list['payrol']['tunj_perusahaan'] ?? 0;
                $tunj_bpjs_perusahaan = $list['payrol']['pot_tunj_perusahaan'] ?? 0;
                //gaji bruto
                $gaji_bruto = $gapok + $total_tunj_perusahaan;
                //thp
                $thp = $gaji_bruto - $tunj_bpjs_perusahaan - $tot_potongan;
                @endphp
            @endif
            <tr>
                <td style="text-align: center">
                    @if($list['payrol']==null)
                    <span class="badge iq-bg-danger"><i class="fa fa-edit"></i></span></td>
                    @else
                        {{ $list['payrol']['flag'] }}
                        <span class="badge iq-bg-success"><i class="fa fa-check"></i></span></td>
                    @endif

                <td style="text-align: center">{{ $nom }}</td>
                <td>{{ $list['nik']}} - {{ $list['nm_lengkap']}}</td>
                <td>{{ (!empty($list['id_jabatan']) ? $list['get_jabatan']['nm_jabatan'] : "") }}</td>
                <td style="text-align: center">
                    @php if($list['id_status_karyawan']==1)
                    {
                        $badge_thema = 'badge iq-bg-info';
                    } elseif($list['id_status_karyawan']==2) {
                        $badge_thema = 'badge iq-bg-primary';
                    } elseif($list['id_status_karyawan']==3) {
                        $badge_thema = 'badge iq-bg-success';
                    } elseif($list['id_status_karyawan']==7) {
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
                        if($key==$list['id_status_karyawan'])
                        {
                            $ket_status = $value;
                            break;
                        }
                    }
                    @endphp
                    {{ $ket_status }}</span>
                </td>
                <td style="text-align: right"><b>{{ number_format($list['gaji_pokok'], 0) }}</b></td>
                <td style="text-align: right">
                    @if(!empty($list['gaji_pokok']))
                    <div class="btn-group mb-1 dropup">
                        <button type="button" class="btn btn-success">{{ number_format($total_tunj_perusahaan, 0) }}</button>
                        <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Aksi</span>
                        </button>
                        <div class="dropdown-menu">
                           <a class="dropdown-item" data-toggle="modal" data-target="#ModalForm" onclick="goTunjangan(this)" id="{{ $list['id'] }}">Detail</a>
                        </div>
                    </div>
                    @endif
                </td>
                <td>0</td>
                <td style="text-align: right">
                    @if(!empty($list['gaji_pokok']))
                    <div class="btn-group mb-1 dropup">
                        <button type="button" class="btn btn-danger">{{ number_format($tot_potongan, 0) }}</button>
                        <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Aksi</span>
                        </button>
                        <div class="dropdown-menu">
                        <a class="dropdown-item" data-toggle="modal" data-target="#ModalForm" onclick="goPotongan(this)" id="{{ $list['id'] }}">Detail</a>
                        </div>
                    </div>
                    @endif
                </td>
                <td style="text-align: right"><b>{{ number_format($thp, 0) }}</b></td>
            </tr>
            @php $nom++; @endphp
        @endforeach
    {{-- @else
        <tr>
            <td colspan="13" style="text-align: center; height: 40px;">Pengaturan Penggajian Telah Disimpan. Silahkan Periksa Dipelaporan Penggajian..</td>
        </tr>
    @endif --}}
    </tbody>
</table>
<div id="ModalForm" class="modal fade bg-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-ml" role="document">
        <div class="modal-content" id="v_form"></div>
    </div>
 </div>

<script>
    var goTunjangan = function(el)
    {
        var id_data = el.id
        var bulan = $("#pil_periode_bulan").val();
        var tahun = $("#inp_periode_tahun").val();
        $("#v_form").load("{{ url('hrd/penggajian/detailTunjangan/')}}/"+id_data+"/"+bulan+"/"+tahun, function(){
            $(".angka").number(true, 0);
        });
    }
    var goPotongan = function(el)
    {
        var id_data = el.id;
        var bulan = $("#pil_periode_bulan").val();
        var tahun = $("#inp_periode_tahun").val();
        $("#v_form").load("{{ url('hrd/penggajian/detailPotongan/')}}/"+id_data+"/"+bulan+"/"+tahun, function(){
            $(".angka").number(true, 0);
        });
    }
</script>
