@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/karyawan/daftar') }}">Daftar Karyawan</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/karyawan/profil/'.$res->id) }}">Profil Karyawan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Dokumen Karyawan</li>
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
                    <h4 class="card-title">Daftar Dokumen Karyawan</h4>
                </div>
                <div class="user-post-data p-3">
                    <div class="d-flex flex-wrap">
                        <div class="media-support-user-img mr-3">
                            <img class="rounded-circle img-fluid" src="{{ asset('upload/photo/'.$res->photo) }}" alt="">
                        </div>
                        <div class="media-support-info mt-2">
                            <h5 class="mb-0">{{ $res->nm_lengkap }}</h5>
                            <p class="mb-0 text-primary">{{ $res->nik }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="iq-card-body">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12" id="page_view">
                            <form action="{{ url('hrd/karyawan/simpandokumen') }}" method="post" onsubmit="return konfirm()" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="id_karyawan" value="{{ $res->id }}">
                                <input type="hidden" name="nik" value="{{ $res->nik }}">
                                <div class="iq-card iq-card-block iq-card-stretch">
                                    <div class="iq-card-body">
                                        <div class="row">
                                        @php $nom=1; @endphp
                                        @foreach($list_jenis_dok as $keyb => $valueb)
                                        <div class="col-sm-2">
                                            <input type="hidden" name="id_dokumen[]" id="id_dokumen[]" value="{{ $valueb->id }}">
                                            <div class="card iq-mb-3">
                                                
                                                @foreach($list_dokumen as $dtdok => $valdok)
                                                    @if($valdok->id_dokumen==$valueb->id)
                                                    <a href="{{ url(Storage::url('hrd/dokumen/'.$res->nik.'/'.$valdok->file_dokumen)) }}" data-fancybox data-caption='{{ $nom.". ".$valueb->nm_dokumen}}'>
                                                    <img src="{{ url(Storage::url('hrd/dokumen/'.$res->nik.'/'.$valdok->file_dokumen)) }}"  class="card-img-top" alt="No Image Found"></a>
                                                        @php break; @endphp
                                                    @endif
                                                @endforeach
                                                
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $nom.". ".$valueb->nm_dokumen}}</h5>
                                                    <input type="file" name="input-file[]" />
                                                    <code>* image only (jpg, png, jpeg) </code>
                                                </div>
                                            </div>
                                        </div>
                                        @php $nom++; @endphp
                                        @endforeach
                                        </div>
                                        <div class="col-xl-12" align="center">
                                            <hr>
                                            <button class="btn btn-primary">Perbaharui Dokumen Nasabah</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
        $('.tahun_mask').mask('0000');
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