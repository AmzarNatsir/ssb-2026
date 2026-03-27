@extends('HRD.layouts.master')
@section('content')
<style>
        .progress { position:relative; width:100%; }
        .bar { background-color: #00ff00; width:0%; height:20px; }
        .percent { position:absolute; display:inline-block; left:50%; color: #040608;}
   </style>
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Recruitment</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/recruitment/aplikasi_pelamar') }}">Aplikasi Pelamar</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/recruitment/aplikasi_pelamar/data_lain/'.$profil->id) }}">Profil Pelamar</a></li>
        <li class="breadcrumb-item">Data Dokumen Pelamar</li>
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
                    <h4 class="card-title">Data Dokumen Pelamar</h4>
                </div>
                <div class="user-post-data p-3">
                    <div class="d-flex flex-wrap">
                        <div class="media-support-user-img mr-3">
                            <img class="rounded-circle img-fluid" src="{{ asset('upload/photo/'.$profil->file_photo) }}" alt="">
                        </div>
                        <div class="media-support-info mt-2">
                            <h5 class="mb-0">{{ $profil->nm_lengkap }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="iq-card-body">
                <div class="col-sm-12">
                    
                        <div class="iq-card iq-card-block iq-card-stretch">
                            <div class="iq-card-body">
                                <div class="user-detail text-center">
                                    <div class="user-profile">
                                        <img class="avatar-130 img-fluid" src="{{ url(Storage::url('hrd/pelamar/photo/'.$profil->file_photo)) }}" alt="profile-pic">
                                        
                                    </div>
                                    <div class="profile-detail mt-3">
                                        <h3 class="d-inline-block">{{ $profil->nama_lengkap }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">Form Upload Dokumen Pelamar</h4>
                            </div>
                        </div>
                        <div class="iq-card iq-card-block iq-card-stretch">
                            <div class="iq-card-body">

                                <div id="js-product-list">
                                    <div class="Products">
                                        <ul class="product_list gridcount grid row">
                                            @php $ket_dok="baru"; $id_dok_pelamar=""; @endphp
                                            @foreach($jenis_dokumen as $dok)
                                            <li class="product_item col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                                <div class="product-miniature">
                                                    <div class="thumbnail-container">
                                                        @foreach($list_dokumen as $dtdok => $valdok)
                                                        @if($valdok->id_dokumen==$dok->id)
                                                            <a href="{{ url(Storage::url($valdok->path_file.$valdok->file_dokumen)) }}" data-fancybox data-caption='{{ $dok->id.". ".$dok->nm_dokumen}}'>
                                                            <img src="{{ url(Storage::url($valdok->path_file.$valdok->file_dokumen)) }}"  class="card-img-top" alt="{{ $dok->id.". ".$dok->nm_dokumen}}"></a>  
                                                            @php 
                                                            $ket_dok="edit";
                                                            $id_dok_pelamar=$valdok->id; 
                                                            break; 
                                                            @endphp
                                                        @else 
                                                            @php $ket_dok="baru";  @endphp
                                                        @endif     
                                                        @endforeach                                 
                                                    </div>
                                                    <div class="product-description">
                                                        <h4>{{ $dok->nm_dokumen }}</h4>
                                                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                                                            <div class="product-action">
                                                                <div class="add-to-cart">
                                                                    @if($ket_dok=="baru")
                                                                    <a href="#modal-dok" class="tbl_add" id="{{ $dok->id }}" data-toggle="modal" data-placement="top" title="Upload Dokumen"><i class="fa fa-plus"></i> </a>
                                                                    @else
                                                                    <a href="#modal-dok" class="tbl_edit" id="{{ $id_dok_pelamar }}" data-toggle="modal" data-placement="top" title="Update Dokumen"><i class="fa fa-edit"></i> </a>
                                                                    @endif
                                                                </div>
                                                                @if($ket_dok=="edit")
                                                                <div class="wishlist">
                                                                    <a href="{{ route('deleteDokumen', $id_dok_pelamar) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Hapus Dokumen" onclick="hapusKonfirm();"> <i class="fa fa-remove"></i> </a>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-dok" data-backdrop="false">
  <div class="modal-dialog">
    <div class="modal-content bg-primary" id="frm_modal">
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".tbl_add").on("click", function()
        {
            var id_data = this.id;
            var id_pelamar = "{{ $profil->id }}";
            $("#frm_modal").load('{{ url("hrd/recruitment/aplikasi_pelamar/frm_dokumen_baru") }}/'+id_data+'/'+id_pelamar);
        });
        $(".tbl_edit").on("click", function()
        {
            var id_data = this.id;
            var id_pelamar = "{{ $profil->id }}";
            $("#frm_modal").load('{{ url("hrd/recruitment/aplikasi_pelamar/frm_dokumen_edit") }}/'+id_data+'/'+id_pelamar);
        });
    });
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
    function hapusKonfirm()
    {
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