@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('hrd/pelatihan/listpengajuan') }}">Daftar Pengajuan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Pengajuan Pelatihan</li>
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
        <div class="iq-card" id="page_view">

            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Edit Data Pengajuan</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <form action="{{ url('hrd/pelatihan/updatepengajuan/'.$dt_h->id) }}" method="post" onsubmit="return konfirm()">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group row">
                    <label class="col-sm-2">Nama Pelatihan</label>
                    <div class="col-sm-10">
                        <select class="form-control select2" id="pil_pelatihan" name="pil_pelatihan" style="width: 100%;" required>
                            @foreach($all_pelatihan as $list)
                            @if ($list->id==$dt_h->id_pelatihan)
                            <option value="{{ $list->id }}" selected>{{ $list->nama_pelatihan }}</option>
                            @else
                            <option value="{{ $list->id }}">{{ $list->nama_pelatihan }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2">Institusi Penyelenggara</label>
                    <div class="col-sm-10">
                        <select class="form-control select2" name="pil_pelaksana" id="pil_pelaksana" style="width: 100%;" required>
                            @foreach($all_pelaksana as $lembaga)
                            @if ($lembaga->id==$dt_h->id_pelaksana)
                            <option value="{{ $lembaga->id }}" selected>{{ $lembaga->nama_lembaga }}</option>
                            @else
                            <option value="{{ $lembaga->id }}">{{ $lembaga->nama_lembaga }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2">Alamat Penyelenggara</label>
                    <div class="col-sm-10">
                        <input type="text" name="inp_tempat" id="inp_tempat" class="form-control" maxlength="200" value="{{ $dt_h->tempat_pelaksanaan }}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2">Alasan</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="inp_alasan" id="inp_alasan" required>{{ $dt_h->alasan_pengajuan }}</textarea>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label class="col-sm-12"><b>Waktu Pelaksanaan Pelatihan</b></label>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2">Tanggal Mulai</label>
                    <div class="col-sm-2">
                        <input type="date" class="form-control-sm" name="tgl_mulai" id="tgl_mulai" value="{{ $dt_h->tanggal_awal }}" required>
                    </div>
                    <label class="col-sm-2">Tanggal Selesai</label>
                    <div class="col-sm-2">
                        <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control-sm" value="{{ $dt_h->tanggal_sampai }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2">Jam Mulai</label>
                    <div class="col-sm-2">
                        <input type="text" name="jam_mulai" id="jam_mulai" class="form-control jamClass" value="{{ $dt_h->pukul_awal }}"  required>
                    </div>
                    <label class="col-sm-2">Jam Selesai</label>
                    <div class="col-sm-2">
                        <input type="text" name="jam_selesai" id="jam_selesai" class="form-control jamClass" value="{{ $dt_h->pukul_sampai }}"  required>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label class="col-sm-12"><b>karyawan yang akan mengikuti pelatihan</b></label>
                </div>
                <table class="table list_item" style="width: 100%; height: auto">
                    <tr>
                        <td style="width: 3%">#</td>
                        <td>Peserta</td>
                        <td style="width: 15%; text-align:right">Biaya Investasi</td>
                    </tr>
                    <tr>
                        <td colspan="3"><button onclick="addButton(this)" type="button" class="btn btn-primary btn-square waves-effect waves-light"><i class="fa fa-plus"></i> Tambah Peserta</button></td>
                    </tr>
                    @if($dt_d->count() > 0)
                    @foreach($dt_d as $dt_detail)
                    <tr>
                        <td><button type="button" title="Hapus Baris" class="btn btn-danger btn-sm waves-effect waves-light" onclick="delete_item(this)"><i class="fa fa-minus"></i></button></td>
                        <td>
                        <select class="form-control" name="pil_peserta[]" id="pil_peserta[]" style="width: 100%;" required>
                            @foreach($all_karyawan as $peserta)
                            @if($peserta->id == $dt_detail->id_karyawan)
                                <option value="{{ $peserta->id }}" selected>{{ $peserta->nik." - ".$peserta->nm_lengkap }} - {{ $peserta->get_jabatan->nm_jabatan }}</option>
                            @else
                                <option value="{{ $peserta->id }}">{{ $peserta->nik." - ".$peserta->nm_lengkap }} - {{ $peserta->get_jabatan->nm_jabatan }}</option>
                            @endif
                            @endforeach
                        </select>
                        </td>
                        <td>
                        <input type="text" class="form-control angka" name="inp_biaya[]" id="inp_biaya[]" value="{{ (empty($dt_detail->biaya_investasi)) ? 0 : $dt_detail->biaya_investasi }}" required style="text-align: right;" oninput="calculateInQty(this)" onblur="calculateInQty(this)">
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </table>
                <table class="table" style="width: 100%; height: auto">
                    <tr>
                        <td style="width: 3%"></td>
                        <td style="text-align:right">Total Investasi</td>
                        <td style="width: 15%"><input type="text" id="inp_total_investasi" name="inp_total_investasi" value="{{ $dt_h->total_investasi }}" class="form-control angka" style="text-align: right; font-size: 15pt" readonly></td>
                    </tr>
                </table>
                <hr>
                <button type="submit" id="tbl_simpan" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".select2").select2();
        $(".angka").number(true, 0);
        $(".jamClass").mask("99:99");
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
                <option value="{{ $peserta->id }}">{{ $peserta->nik." - ".$peserta->nm_lengkap }} - {{ $peserta->get_jabatan->nm_jabatan }})</option>
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
