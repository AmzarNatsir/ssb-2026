@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Dataku - Perjalanan Dinas - Detail</li>
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
            <div class="iq-card-body" style="width:100%; height:auto">
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
                                <form action="{{ url('hrd/dataku/updateRealisasiBiayaPerdis') }}" method="post" id="myForm">
                                {{ csrf_field() }}
                                <input type="hidden" name="id_perdis" value="{{ $profil->id }}">
                                <div class="container-fluid">
                                    <table class="table table-sm list_item_1" style="width: 100%; height: auto" border="1">
                                        <tr style="background-color: rgb(72, 152, 244); color: white">
                                          <td colspan="5" style="text-align:center">Rincian Biaya</td>
                                          <td colspan="3" style="text-align:center">Dokumen</td>
                                        </tr>
                                        <tr>
                                            <td>Item</td>
                                            <td style="width: 5%; text-align:center">Hari</td>
                                            <td style="width: 10%; text-align:right">Biaya</td>
                                            <td style="width: 10%; text-align:right">Sub Total</td>
                                            <td style="width: 15%; text-align:right">Realiasi</td>
                                            <td style="text-align:center;" colspan="2">File</td>
                                            <td style="width: 10%; text-align:center;">Upload</td>
                                        </tr>
                                        @php $total=0; $total_realisasi=0; $path = "hrd/dataku/perdis/".$profil->id."/"; @endphp
                                        @foreach ($fasilitas as $list)
                                        <tr>
                                            <td>- {{ $list->get_master_fasilitas_perdis->nm_fasilitas }}</td>
                                            <td style="text-align:center">{{ $list->hari }}</td>
                                            <td style="text-align:right">{{ number_format($list->biaya, 0) }}</td>
                                            <td style="text-align:right">{{ number_format($list->sub_total, 0) }}</td>
                                            <td style="text-align:right">
                                                <input type="hidden" name="id_rincian[]" value="{{ $list->id }}">
                                                <input type="text" class="form-control angka" name="inp_realisasi[]" value="{{ $list->realisasi }}" style="text-align: right" oninput="inputRealisasi(this)">
                                            </td>
                                            <td style="text-align:center; width: 10%;">
                                                @if(!empty($list->file_1))
                                                <a href="{{ url(Storage::url($path.$list->file_1)) }}" data-fancybox data-caption='Dokumen'>
                                                <img src="{{ url(Storage::url($path.$list->file_1)) }}" style="width: auto; height: 100px" alt="Dokumen"></a>
                                                @endif
                                            </td>
                                            <td style="text-align:center;  width: 10%;">
                                                @if(!empty($list->file_2))
                                                <a href="{{ url(Storage::url($path.$list->file_2)) }}" data-fancybox data-caption='Dokumen'>
                                                <img src="{{ url(Storage::url($path.$list->file_2)) }}" style="width: auto; height: 100px" alt="Dokumen"></a>
                                                @endif
                                            </td>
                                            <td style="text-align:center;">
                                                {{-- @if(empty($list->file_1) || empty($list->file_2)) --}}
                                                <a href="#modal-dok" class="btn btn-primary tbl_add" id="{{ $list->id }}" data-toggle="modal" data-placement="top" title="Upload Dokumen"><i class="fa fa-plus"></i> </a>
                                                {{-- @endif --}}
                                            </td>
                                        </tr>
                                        @php $total+=$list->sub_total; $total_realisasi+=$list->realisasi @endphp
                                        @endforeach
                                        <tr>
                                            <td colspan="3" style="text-align:right">Total</td>
                                            <td style="text-align:right"><b>{{ number_format($total, 0) }}</b></td>
                                            <td style="text-align:right"><input type="text" class="form-control angka" name="inp_total_realisasi" id="inp_total_realisasi" value="{{ $total_realisasi }}" style="text-align: right" readonly></td>
                                            <td colspan="3"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="text-align:right"></td>
                                            <td><button type="submit" class="btn btn-success btn-block" name="btn_update" id="btn_update">Update Realisasi</button></td>
                                            <td colspan="3"></td>
                                        </tr>
                                    </table>
                                </div>
                                </form>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-dok" data-backdrop="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-primary" id="frm_modal" style="color: white">
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".angka").number(true, 0);
        $(".tbl_add").on("click", function()
        {
            var id_data = this.id;
            $("#frm_modal").load('{{ url("hrd/dataku/uploadDokumenPerdis") }}/'+id_data);
        });
    });
    var inputRealisasi = function(el)
    {
        total();
    }
    var total = function(){
        var total = 0;
        var sub_total = 0;
        $.each($('input[name="inp_realisasi[]"]'),function(key, value){
            sub_total = $(value).val() ?  $(value).val() : 0;
            total += parseFloat($(value).val());
        })

        $('input[name="inp_total_realisasi"]').val(total);
    }
    document.querySelector('#myForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting

        Swal.fire({
            title: 'Are you sure?',
            text: "Submit this application!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user confirms, submit the form
                this.submit();
            }
        });
    });
</script>
@endsection
