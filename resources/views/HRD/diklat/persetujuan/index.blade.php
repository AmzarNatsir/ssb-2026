@extends('HRD.layouts.master')
@section('content')
@php
$user = auth()->user();
$id_jabatan_setup_hrd = (empty($arr_appr_setup->id_dept_manager_hrd)) ? "" : $arr_appr_setup->id_dept_manager_hrd;
$id_jabatan_user_hrd = (empty($lvl_appr_user->id_jabatan)) ? "" : $lvl_appr_user->id_jabatan;
@endphp

<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item ">Pelatihan</li>
        <li class="breadcrumb-item active" aria-current="page">Daftar Pengajuan</li>
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
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Daftar Pengajuan Pelatihan</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="iq-card">
                            <div class="iq-card-body">
                                <table class="table table-hover" style="width:100%; font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th scope="col" rowspan="2">#</th>
                                            <th scope="col" colspan="2" style="width: 10%; text-align:center">Pengajuan</th>
                                            <th scope="col" colspan="2" style="text-align: center">Waktu Pelatihan</th>
                                            <th scope="col" rowspan="2" style="width: 20%;">Nama Pelatihan</th>
                                            <th scope="col" rowspan="2" style="width: 20%">Institusi&nbsp;Penyelenggara</th>
                                            <th scope="col" rowspan="2" style="width: 10%; text-align: center">Biaya&nbsp;Investasi</th>
                                            <th scope="col" rowspan="2" style="width: 5%">Persetujuan</th>
                                        </tr>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Departemen</th>
                                            <th>Hari/Tanggal</th>
                                            <th>Jam</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $nom=1; @endphp
                                        @foreach ($all_pengajuan as $item)
                                            <tr>
                                                <td>{{ $nom }}</td>
                                                <td>{{ date_format(date_create($item->tanggal), 'd/m/Y') }}</td>
                                                <td>{{ $item->get_departemen->nm_dept }}</td>
                                                <td>{{ App\Helpers\Hrdhelper::get_tanggal_pelaksanaan($item->tanggal_awal, $item->tanggal_sampai, $item->hari_awal, $item->hari_sampai) }}</td>
                                                <td>{{ date("h:i", strtotime($item->pukul_awal)).' s/d '.date("h:i", strtotime($item->pukul_sampai)) }}</td>
                                                <td>{{ $item->get_nama_pelatihan->nama_pelatihan }}</td>
                                                <td>{{ $item->get_pelaksana->nama_lembaga }}</td>
                                                <td style="text-align:right">{{ number_format($item->total_investasi, 0, ",", ".") }}</td>
                                                <td style="text-align:center">
                                                @if($id_jabatan_setup_hrd==$id_jabatan_user_hrd)
                                                    @if ($user->can('persetujuan_Penggajian_approve'))
                                                    <a href="{{ url('hrd/pelatihan/persetujuan/formpersetujuan', $item->id) }}" class="btn btn-primary" title="Apply"><i class="fa fa-edit"></i></a>
                                                    @endif
                                                @endif
                                                </td>
                                            </tr>
                                            @php $nom++; @endphp
                                        @endforeach    
                                    </tbody> 
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".select2").select2();
    });
    var goPrint = function(el) {
        var id_data = $(el).val();
        window.open('{{ url("hrd/diklat/print_spp") }}/'+id_data);
    }
    var goDelete = function() {
        var psn = confirm("Yakin akan menghapus data ?")
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
</script>
@endsection