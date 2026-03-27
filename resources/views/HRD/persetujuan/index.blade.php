@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Persetujuan</li>
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
                    <h4 class="card-title">Daftar Pengajuan</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <div class="row justify-content-center table-responsive">
                <table class="table datatable table-hover" style="font-size: 13px;">
                    <thead>
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th class="text-center" style="width: 5%;">Level</th>
                            <th style="width: 20%;">Kategori</th>
                            <th style="width: 10%;">Pengajuan</th>
                            <th style="width: 15%;">Departemen</th>
                            <th>Keterangan</th>
                            <th style="width: 15%;">Diajukan Oleh</th>
                            <th style="width: 5%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($no=1)
                        @foreach ($list_persetujuan as $list)
                        <tr>
                            <td>{{ $no }}</td>
                            <td class="text-center"><h4><span class="badge badge-pill badge-success">{{ $list['approval_level'] }}</span></h4></td>
                            <td>{{ $list['get_ref_approval']['ref_group'] }}</td>
                            <td>{{ date('d-m-Y', strtotime($list['detail']['tgl_pengajuan'])) }}</td>
                            <td>{{ $list['detail']['departemen'] }}</td>
                            <td>{{ $list['detail']['catatan_pengajuan'] }}</td>
                            <td>{{ $list['detail']['diajukan_oleh'] }}</td>
                            <td>
                                @if(empty($list['detail']['status_app']))
                                <button type="button" class="btn btn-primary" value="{{ $list['id'] }}" data-toggle="modal" data-target="#modalFormPersetujuan" onclick="goForm(this)"><i class="fa fa-edit"></i></button>
                                @elseif($list['detail']['status_app']=="pending")
                                <h4><span class="badge badge-pill badge-danger">Pending</span></h4>
                                @else
                                <h4><span class="badge badge-pill badge-danger">Closed</span></h4>
                                @endif
                            </td>
                        </tr>
                        @php($no++)
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modalFormPersetujuan" class="modal fade bg-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" id="v_inputan" style="overflow-y: auto;"></div>
    </div>
 </div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $('.datatable').DataTable({
            searchDelay: 500,
            processing: true,
        });
    });
    var goForm = function(el)
    {
        var id_data = $(el).val();
        $("#v_inputan").load("{{ url('hrd/persetujuan/formApproval') }}/"+id_data, function(){
            jQuery('ul.iq-email-sender-list li').click(function() {
                jQuery(this).next().addClass('show');
            });
            jQuery('.email-app-details li h4').click(function() {
                jQuery('.email-app-details').removeClass('show');
            });
        });
    }
</script>
@endsection
