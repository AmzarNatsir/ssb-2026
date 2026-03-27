@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/pelatihan/persetujuan/listpengajuan') }}">Daftar Pengajuan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Persetujuan Pengajuan Pelatihan</li>
        </ul>
    </nav>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-6">
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
        <div class="iq-card" id="page_view">

            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Data Pengajuan Pelatihan</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <table class="table" style="width: 100%;">
                <tbody>
                    <tr>
                        <td style="width: 30%;">Nama Pelatihan</td>
                        <td style="width: 2%;">:</td>
                        <td><b>{{ $dt_h->get_nama_pelatihan->nama_pelatihan }}</b></td>
                    </tr>
                    <tr>
                        <td>Institusi Penyelenggara</td>
                        <td>:</td>
                        <td><b>{{ $dt_h->get_pelaksana->nama_lembaga }}</b></td>
                    </tr>
                    <tr>
                        <td>Alamat Penyelenggara</td>
                        <td>:</td>
                        <td><b>{{ $dt_h->tempat_pelaksanaan }}</b></td>
                    </tr>
                    <tr>
                        <td>Alasan Pengajuan</td>
                        <td>:</td>
                        <td><b>{{ $dt_h->alasan_pengajuan }}</b></td>
                    </tr>
                    <tr>
                        <td>Departemen Yang Mengajukan</td>
                        <td>:</td>
                        <td><b>{{ $dt_h->get_departemen->nm_dept }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Waktu Pelaksanaan Pelatihan</b></td>
                    </tr>
                    <tr>
                        <td>Hari/Tanggal</td>
                        <td>:</td>
                        <td><b>@if($dt_h->tanggal_awal==$dt_h->hari_sampai)
                            {{ App\Helpers\Hrdhelper::get_hari($dt_h->tanggal_awal) }}
                            @else
                            {{ App\Helpers\Hrdhelper::get_hari_ini($dt_h->tanggal_awal). " - ".App\Helpers\Hrdhelper::get_hari_ini($dt_h->tanggal_sampai) }}
                            @endif
                            , {{ App\Helpers\Hrdhelper::get_tanggal_pelaksanaan($dt_h->tanggal_awal, $dt_h->tanggal_sampai, $dt_h->hari_awal, $dt_h->hari_sampai) }}</b></td>
                    </tr>
                    <tr>
                        <td>Jam</td>
                        <td>:</td>
                        <td><b>{{ substr($dt_h->pukul_awal, 0, 5).' s/d '.substr($dt_h->pukul_sampai, 0, 5) }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Peserta Pelatihan</b></td>
                    </tr>
                </tbody>
                </table>
                <table class="table list_item" style="width: 100%; height: auto">
                    <tr>
                        <td style="width: 3%">#</td>
                        <td>Peserta</td>
                        <td style="width: 30%; text-align:right">Biaya Investasi</td>
                    </tr>
                    @if($dt_d->count() > 0)
                    @php $nom=1; @endphp
                    @foreach($dt_d as $dt_detail)
                    <tr>
                        <td>{{ $nom }}</td>
                        <td>{{ $dt_detail->get_karyawan->nm_lengkap }}</td>
                        <td style="text-align: right;">{{ number_format($dt_detail->biaya_investasi, 0, ",", ".") }}</td>
                    </tr>
                    @php $nom++; @endphp
                    @endforeach
                    @endif
                    <tr>
                        <td colspan="2" style="text-align: right"><b>Total Investasi</b></td>
                        <td style="text-align: right"><b>{{ number_format($dt_h->total_investasi, 0, ",", ".") }}</b></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-6">
        <form action="{{ url('hrd/pelatihan/persetujuan/storepersetujuan/'.$dt_h->id) }}" method="post" onsubmit="return konfirm()">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Form Persetujuan</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <div class="form-group row">
                    <label class="col-sm-5">Status Persetujuan :</label>
                    <div class="col-sm-2">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="check_status_appr_1" name="check_status_appr" class="custom-control-input" value="2" checked>
                            <label class="custom-control-label" for="check_status_appr_1"> Setuju</label>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="check_status_appr_2" name="check_status_appr" class="custom-control-input" value="3">
                            <label class="custom-control-label" for="check_status_appr_2"> Tolak</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="req_catatan_appr" class="col-sm-12">Catatan Persetujuan :</label>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <textarea class="form-control" name="req_catatan_appr" id="req_catatan_appr" required></textarea>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <button type="submit" id="tbl_simpan" class="btn btn-primary"><i class="fa fa-save"></i> Submit</button>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".select2").select2();
        $(".angka").number(true, 0);
        // $(".angka").number(true, 0);
    });
    function konfirm()
    {
        var psn = confirm("Yakin perubahan data akan disimpan ?");
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
    var addButton = function(){
      let content = `<tr>
            <td><button type="button" title="Hapus Baris" class="btn btn-danger btn-sm waves-effect waves-light" onclick="delete_item(this)"><i class="fa fa-minus"></i></button></td>
            <td>
            <select class="form-control select2" name="pil_peserta[]" id="pil_peserta[]" style="width: 100%;" required>
                @foreach($all_karyawan as $peserta)
                <option value="{{ $peserta->id }}">{{ $peserta->nik." - ".$peserta->nm_lengkap }} ({{ $peserta->get_jabatan->nm_jabatan }})</option>
                @endforeach
            </select>
            </td>
            <td>
            <input type="text" class="form-control angka" name="inp_biaya[]" id="inp_biaya[]" value="0" required style="text-align: right;" oninput="calculateInQty(this)" onblur="calculateInQty(this)">
            </td>
          </tr>`;
      $(".list_item").append(content);
      $(".angka").number(true, 0);
      $(".select2").select2();
    }
    var delete_item = function(el){
        $(el).parent().parent().slideUp(100,function(){
            $(this).remove();
            total();
        });
    }
    var calculateInQty = function(el){
        total();
    }

    var total = function(){
        var total = 0;
        var sub_total = 0;
        $.each($('input[name="inp_biaya[]"]'),function(key, value){
            sub_total = $(value).val() ?  $(value).val() : 0;
            total += parseFloat($(value).val());
        })

        $('input[name="inp_total_investasi"]').val(total);
    }
</script>
@endsection
