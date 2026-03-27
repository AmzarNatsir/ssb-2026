@extends('HRD.layouts.master')
@section('content')
<style>
    .spinner-div {
    position: absolute;
    display: none;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    text-align: center;
    background-color: rgba(255, 255, 255, 0.8);
    z-index: 2;
    }
</style>
<input type="hidden" name="periode_bulan" id="periode_bulan" value="{{ $bulan }}">
<input type="hidden" name="periode_tahun" id="periode_tahun" value="{{ $tahun }}">
<input type="hidden" name="id_departemen" id="id_departemen" value="{{ $id_departemen }}">
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/penggajian/pengaturanPenggajian/'.$id_departemen.'/'.$bulan.'/'.$tahun) }}">Refresh (F5)</a></li>
        <li class="breadcrumb-item active" aria-current="page">Pengaturan Penggajian Karyawan</li>
        </ul>
    </nav>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-12">
        @if(\Session::has('konfirm'))
            <div class="alert text-white bg-success" role="alert" id="success-alert">
                <div class="iq-alert-icon">
                    <i class="ri-alert-line"></i>
                </div>
                <div class="iq-alert-text">{{ \Session::get('konfirm') }}</div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="ri-close-line"></i>
                </button>
            </div>
        @endif
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="iq-card">
            <div class="iq-card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="todo-date d-flex mr-3">
                    <i class="ri-calendar-2-line text-success mr-2"></i>
                    <span>Periode Penggajian {{ \App\Helpers\Hrdhelper::get_nama_bulan($bulan) }} {{ $tahun }}</span>
                    </div>
                    <div class="todo-notification d-flex align-items-center">
                        <span><b>Departemen : {{ $nama_departemen }}</b></span>
                     </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Daftar Gaji Karyawan</h4>
                </div>
            </div>
            <table id="user-list-table" class="table table-hover table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info" style="width: 100%; font-size: 13px">
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
                    @php $ket="N"; $jml_y=0; $nom=1; @endphp
                    @foreach($data as $list)
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
                            $pot_jkk = 0;
                            $pot_jkm = 0;
                            $tot_potongan = $pot_bpjs_ks + $pot_jht + $pot_jp + $pot_jkk + $pot_jkm;
                            $tunj_bpjs_perusahaan = 0;
                            $total_tunj_perusahaan = 0;
                            $gaji_bruto=0;
                            $thp = 0;
                            @endphp
                        @else
                            @php
                            $gapok = $list['payrol']['gaji_pokok'];
                            //potongan
                            $pot_bpjs_ks = (empty($list['payrol']['bpjsks_karyawan'])) ? 0 : $list['payrol']['bpjsks_karyawan'];
                            $pot_jht = (empty($list['payrol']['bpjstk_jht_karyawan'])) ? 0 : $list['payrol']['bpjstk_jht_karyawan'];
                            $pot_jp = (empty($list['payrol']['bpjstk_jp_karyawan'])) ? 0 : $list['payrol']['bpjstk_jp_karyawan'];
                            $pot_jkk = (empty($list['payrol']['bpjstk_jkk_karyawan'])) ? 0 : $list['payrol']['bpjstk_jkk_karyawan'];
                            $pot_jkm = (empty($list['payrol']['bpjstk_jkm_karyawan'])) ? 0 : $list['payrol']['bpjstk_jkm_karyawan'];

                            $pot_sedekah = $list['payrol']['pot_sedekah'];
                            $pot_pkk = $list['payrol']['pot_pkk'];
                            $pot_air = $list['payrol']['pot_air'];
                            $pot_rumah = $list['payrol']['pot_rumah'];
                            $pot_toko_alif = $list['payrol']['pot_toko_alif'];
                            $tot_potongan = $pot_bpjs_ks + $pot_jht + $pot_jp + $pot_jkk + $pot_jkm + $pot_sedekah + $pot_pkk + $pot_air + $pot_rumah + $pot_toko_alif;
                            $tunj_bpjs_perusahaan = $list['payrol']['pot_tunj_perusahaan'] ?? 0;
                            $total_tunj_perusahaan = $list['payrol']['tunj_perusahaan'] ?? 0;
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
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ModalFormTunjangan" onclick="goTunjangan(this)" id="{{ $list['id'] }}">{{ number_format($total_tunj_perusahaan, 0) }}</button>
                                @endif
                            </td>
                            <td style="text-align: right"><b>{{ number_format($gaji_bruto, 0) }}</b></td>
                            <td style="text-align: right">
                                @if(!empty($list['gaji_pokok']))
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalForm" onclick="goPotongan(this)" id="{{ $list['id'] }}">{{ number_format($tot_potongan, 0) }}</button>
                                @endif
                            </td>
                            <td style="text-align: right"><b>{{ number_format($thp, 0) }}</b></td>
                        </tr>
                        @php $nom++; @endphp
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
<div id="ModalForm" class="modal fade bg-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-ml" role="document">
        <div class="modal-content" id="v_form"></div>
    </div>
 </div>
 <div id="ModalFormTunjangan" class="modal fade bg-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" id="v_form_tunjangan"></div>
    </div>
 </div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#spinner-div').hide();
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".select2").select2();
        $(".angka").number(true, 0);
    });
    var goTunjangan = function(el)
    {
        var id_data = el.id
        var bulan = $("#periode_bulan").val();
        var tahun = $("#periode_tahun").val();
        $("#v_form_tunjangan").load("{{ url('hrd/penggajian/formTunjangan/')}}/"+id_data+"/"+bulan+"/"+tahun, function(){
            $(".angka").number(true, 0);
        });
    }
    var goPotongan = function(el)
    {
        var id_data = el.id;
        var bulan = $("#periode_bulan").val();
        var tahun = $("#periode_tahun").val();
        $("#v_form").load("{{ url('hrd/penggajian/formPotongan/')}}/"+id_data+"/"+bulan+"/"+tahun, function(){
            $(".angka").number(true, 0);
        });
    }
    function konfirm()
    {
        var psn = confirm("Yakin akan menyimpan pengaturan gaji  karyawan ?");
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
</script>
@endsection
