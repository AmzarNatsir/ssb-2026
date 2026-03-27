@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Setup</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/setup/persetujuan') }}">Pengaturan Persetujuan (F5)</a></li>
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
    <div class="col-lg-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Pengaturan Persetujuan Pengajuan</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <table class="table" width="100%>">
                    <tr>
                        <th style="width: 5%">No</th>
                        <th>Modul</th>
                        <th>Level Pengajuan</th>
                        <th>Level Persetujuan Pertama</th>
                        <th>Level Persetujuan Akhir</th>
                        <th style="width: 10%"></th>
                    </tr>
                @php $nom=1; @endphp
                @if($res_all_setup->count() > 0 )
                    @foreach ($res_all_setup as $key => $item)
                    <tr>
                        <td>{{ $nom }}</td>
                        <td>{{ $item->modul }}</td>
                        <td>@if ($item->lvl_pengajuan)
                                @php $list_pil_1 = explode(",", $item->lvl_pengajuan); @endphp
                                @foreach($list_level as $level_ct)
                                    @foreach($list_pil_1 as $pil_1) 
                                        @if($level_ct->id== $pil_1)
                                        {{"- ".$level_ct->nm_level }}
                                        @endif
                                    @endforeach
                                @endforeach
                            @endif
                        </td>
                        <td>
                            @if ($item->lvl_persetujuan)
                                @foreach($list_level as $level_ct)
                                    @if($level_ct->id==$item->lvl_persetujuan) 
                                    {{ "- ".$level_ct->nm_level }}
                                    @endif
                                @endforeach
                            @endif
                        </td>
                        <td>
                            @if ($item->id_dept_manager_hrd)
                                @foreach($list_jabatan as $lvl_jabatan) 
                                    @if($lvl_jabatan->id==$item->id_dept_manager_hrd)
                                        {{ "- ".$lvl_jabatan->nm_jabatan }}
                                    @endif
                                @endforeach
                            @else
                                Belum Diatur
                            @endif
                        </td>
                        <td><button type="button" class="btn btn-primary" value="{{ $item->id }}" data-toggle="modal" data-target="#exampleModalCenteredScrollable" onclick="goForm(this)"><i class="fa fa-edit"></i></button></td>
                    </tr>
                    @php $nom++; @endphp
                    @endforeach
                @else
                <tr>
                    <td colspan="6">Data Pengaturan Level Persetujuan Masih Kosong</td>
                </tr>
                @endif
                </table>
            </div>
        </div>
    </div>
</div>
<div id="exampleModalCenteredScrollable" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content" id="v_inputan"></div>
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
        $("#v_inputan").load("{{ url('hrd/setup/persetujuan/form_pengaturan') }}/"+id_data);
    }
    function konfirm()
    {
        var psn = confirm("Yakin akan menyimpan data ?");
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
</script>
@endsection