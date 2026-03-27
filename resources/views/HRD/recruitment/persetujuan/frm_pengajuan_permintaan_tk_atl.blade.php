@extends('HRD.layouts.master')
@section('content')
@php
$user = auth()->user();
@endphp
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Recruitment</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/recruitment/pengajuan_tenaga_kerja/list_persetujuan') }}">Daftar Pengajuan Permintaan Tenaga Kerja</a></li>
        <li class="breadcrumb-item active" aria-current="page">Persetujuan Atasan Tidak Langsung</li>
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
                    <h4 class="card-title">Form Permintaan Tenaga Kerja</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <div class="form-group row">
                    <label for="inp_dept_pengaju" class="col-sm-3">Departemen/Bagian/Divisi : </label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" value="{{ (empty($profil->id_departemen) ? 'Super Admin' : $profil->get_departemen->nm_dept) }}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="req_jabatan" class="col-sm-3">Posisi/Jabatan : </label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" value="{{ $detail_pengajuan->get_jabatan->nm_jabatan }}" disabled></div>
                </div>
                <div class="form-group row">
                    <label for="req_jabatan" class="col-sm-3">Jumlah Orang :</label>
                    <div class="col-sm-3"><input type="text" class="form-control" value="{{ $detail_pengajuan->jumlah_orang }}" disabled>
                    </div>
                    <label for="req_tanggal" class="col-sm-3">Tanggal Dibutuhkan :</label>
                    <div class="col-sm-3"><input type="text" class="form-control" value="{{ date_format(date_create( $detail_pengajuan->tanggal_dibutuhkan), 'd-m-Y') }}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="req_alasan" class="col-sm-3">Alasan Permintaan :</label>
                    <div class="col-sm-3">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="check_alasan1" name="check_alasan" class="custom-control-input" value="Penambahan Karyawan" {{ ($detail_pengajuan->alasan_permintaan=="Penambahan Karyawan") ? "checked": "" }} disabled>
                            <label class="custom-control-label" for="check_alasan1"> Penambahan Karyawan</label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="check_alasan2" name="check_alasan" class="custom-control-input" value="Project Luar" {{ ($detail_pengajuan->alasan_permintaan=="Project Luar") ? "checked": "" }} disabled>
                            <label class="custom-control-label" for="check_alasan2"> Project Luar</label>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="check_alasan3" name="check_alasan" class="custom-control-input" value="Menggantikan Karyawan" {{ ($detail_pengajuan->alasan_permintaan=="Menggantikan Karyawan") ? "checked": "" }} disabled>
                            <label class="custom-control-label" for="check_alasan3"> Menggantikan Karyawan</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12"><b><u>Kualifikasi yang dibutuhkan</u></b></label>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3">1. Jenis Kelamin :</label>
                    <div class="col-sm-2">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="check_jenkel_1" name="check_jenkel" class="custom-control-input" value="1" {{ ($detail_pengajuan->jenkel == 1) ? "checked": "" }} disabled>
                            <label class="custom-control-label" for="check_jenkel_1"> Laki-Laki</label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="check_jenkel_2" name="check_jenkel" class="custom-control-input" value="2" {{ ($detail_pengajuan->jenkel == 2) ? "checked": "" }} disabled>
                            <label class="custom-control-label" for="check_jenkel_2"> Perempuan</label>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="check_jenkel_3" name="check_jenkel" class="custom-control-input" value="3" {{ ($detail_pengajuan->jenkel == 3) ? "checked": "" }} disabled>
                            <label class="custom-control-label" for="check_jenkel_3"> Boleh Laki-Laki atau Perempuan</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3">2. Umur :</label>
                    <div class="col-sm-2">
                        Min Tahun<input type="text" class="form-control" id="req_umur_min" name="req_umur_min" value="{{ $detail_pengajuan->umur_min }}" disabled>
                    </div>
                    <div class="col-sm-2">
                        Maks Tahun<input type="text" class="form-control" id="req_umur_maks" name="req_umur_maks" value="{{ $detail_pengajuan->umur_maks }}" disabled>
                    </div>
                    <div class="col-sm-5"></div>
                </div>
                <div class="form-group row">
                    <label for="req_pendidikan" class="col-sm-3">3. Pendidikan :</label>
                    <div class="col-sm-1">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="check_pendidikan1" name="check_pendidikan" class="custom-control-input" value="SD/SMP" {{ ($detail_pengajuan->pendidikan == "SD/SMP") ? "checked": "" }} disabled>
                            <label class="custom-control-label" for="check_pendidikan1"> SD/SMP</label>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="check_pendidikan2" name="check_pendidikan" class="custom-control-input" value="SMA/D1" {{ ($detail_pengajuan->pendidikan == "SMA/D1") ? "checked": "" }} disabled>
                            <label class="custom-control-label" for="check_pendidikan2"> SMA/D1</label>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="check_pendidikan3" name="check_pendidikan" class="custom-control-input" value="D2/D3" {{ ($detail_pengajuan->pendidikan == "D2/D3") ? "checked": "" }} disabled>
                            <label class="custom-control-label" for="check_pendidikan3"> D2/D3</label>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="check_pendidikan4" name="check_pendidikan" class="custom-control-input" value="S1/D4" {{ ($detail_pengajuan->pendidikan == "S1/D4") ? "checked": "" }} disabled>
                            <label class="custom-control-label" for="check_pendidikan4"> S1/D4</label>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="check_pendidikan5" name="check_pendidikan" class="custom-control-input" value="S2/S3" {{ ($detail_pengajuan->pendidikan == "S2/S3") ? "checked": "" }} disabled>
                            <label class="custom-control-label" for="check_pendidikan5"> S2/S3</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="req_keahlian" class="col-sm-3">4. Keahlian Khusus :</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="req_keahlian" id="req_keahlian" cols="30" disabled>{{ $detail_pengajuan->keahlian_khusus }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="req_pendidikan" class="col-sm-3">5. Pengalaman :</label>
                    <div class="col-sm-2">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="check_pengalaman1" name="check_pengalaman" class="custom-control-input" value="< 1 Tahun" {{ ($detail_pengajuan->pengalaman == "< 1 Tahun") ? "checked": "" }} disabled>
                            <label class="custom-control-label" for="check_pengalaman1"> < 1 Tahun</label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="check_pengalaman2" name="check_pengalaman" class="custom-control-input" value="1-2 Tahun" {{ ($detail_pengajuan->pengalaman == "1-2 Tahun") ? "checked": "" }} disabled>
                            <label class="custom-control-label" for="check_pengalaman2"> 1-2 Tahun</label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="check_pengalaman3" name="check_pengalaman" class="custom-control-input" value="2-3 Tahun" {{ ($detail_pengajuan->pengalaman == "2-3 Tahun") ? "checked": "" }} disabled>
                            <label class="custom-control-label" for="check_pengalaman3"> 2-3 Tahun</label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="check_pengalaman4" name="check_pengalaman" class="custom-control-input" value="3-5 Tahun" {{ ($detail_pengajuan->pengalaman == "3-5 Tahun") ? "checked": "" }} disabled>
                            <label class="custom-control-label" for="check_pengalaman4"> 3-5 Tahun</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="req_pendidikan" class="col-sm-3"></label>
                    <div class="col-sm-9">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="check_pengalaman5" name="check_pengalaman" class="custom-control-input" value="> 5 Tahun" {{ ($detail_pengajuan->pengalaman == "> 5 Tahun") ? "checked": "" }} disabled>
                            <label class="custom-control-label" for="check_pengalaman5"> > 5 Tahun</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3">6. Kemampuan Bahasa</label>
                    <label class="col-sm-3">- Bahasa Inggris :</label>
                    <div class="col-sm-1">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="check_bhs_inggris_1" name="check_bhs_inggris" class="custom-control-input" value="Aktif" {{ ($detail_pengajuan->kemampuan_bahasa_ing == "Aktif") ? "checked": "" }} disabled>
                            <label class="custom-control-label" for="check_bhs_inggris_1"> Aktif</label>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="check_bhs_inggris_2" name="check_bhs_inggris" class="custom-control-input" value="Pasif" {{ ($detail_pengajuan->kemampuan_bahasa_ing == "Pasif") ? "checked": "" }} disabled>
                            <label class="custom-control-label" for="check_bhs_inggris_2"> Pasif</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3"></label>
                    <label class="col-sm-3">- Bahasa Indonesia :</label>
                    <div class="col-sm-1">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="check_bhs_indonesia_1" name="check_bhs_indonesia" class="custom-control-input" value="Aktif" {{ ($detail_pengajuan->kemampuan_bahasa_ind == "Aktif") ? "checked": "" }} disabled>
                            <label class="custom-control-label" for="check_bhs_indonesia_1"> Aktif</label>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="check_bhs_indonesia_2" name="check_bhs_indonesia" class="custom-control-input" value="Pasif" {{ ($detail_pengajuan->kemampuan_bahasa_ind == "Pasif") ? "checked": "" }} disabled>
                            <label class="custom-control-label" for="check_bhs_indonesia_2"> Pasif</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3"></label>
                    <label class="col-sm-3">- Lain-Lain :</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="inp_bhs_lain" id="inp_bhs_lain" maxlength="200" value="{{ $detail_pengajuan->kemampuan_bahasa_lain }}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3">7. Kepribadian :</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="req_kepribadian" id="req_kepribadian" disabled>{{ $detail_pengajuan->kepribadian }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="req_catatan" class="col-sm-3">8. Catatan :</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="req_catatan" id="req_catatan" disabled>{{ $detail_pengajuan->catatan }}</textarea>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label class="col-sm-12"><b><u>Persetujuan Atasan Langsung</u></b></label>
                </div>
                <div class="form-group row">
                    <label for="req_catatan_appr" class="col-sm-3">Tanggal Persetujuan :</label>
                    <div class="col-sm-9">{{ date_format(date_create($detail_pengajuan->tanggal_approval_al), 'd-m-Y') }}</div>
                </div>
                <div class="form-group row">
                    <label for="req_catatan_appr" class="col-sm-3">Nama Atasan Tangsung :</label>
                    <div class="col-sm-9">{{ $detail_pengajuan->user_al->karyawan->nm_lengkap }}</div>
                </div>
                <div class="form-group row">
                    <label for="req_catatan_appr" class="col-sm-3">Jabatan :</label>
                    <div class="col-sm-9">{{ $detail_pengajuan->user_al->get_jabatan->nm_jabatan }}</div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3">Status Persetujuan :</label>
                    <div class="col-sm-2">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="status_appr_al_1" name="status_appr_al" class="custom-control-input" value="1" {{ ($detail_pengajuan->status_approval_al == 1) ? "checked": "" }} disabled>
                            <label class="custom-control-label" for="status_appr_al_1"> Setuju</label>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="status_appr_al_2" name="status_appr_al" class="custom-control-input" value="2" {{ ($detail_pengajuan->status_approval_al == 2) ? "checked": "" }} disabled>
                            <label class="custom-control-label" for="status_appr_al_2"> Tidak Setuju</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="req_catatan_appr" class="col-sm-3">Catatan Persetujuan :</label>
                    <div class="col-sm-9">{{ $detail_pengajuan->desk_approval_al }}</div>
                </div>
                <hr>
                <div class="form-group row">
                    <label class="col-sm-12"><b><u>Persetujuan</u></b></label>
                </div>
                <form action="{{ url('hrd/recruitment/pengajuan_tenaga_kerja/persetujuan_atl_store/'.$detail_pengajuan->id) }}" method="post" onsubmit="return konfirm()">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group row">
                    <label class="col-sm-3">Status Persetujuan :</label>
                    <div class="col-sm-2">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="check_status_appr_1" name="check_status_appr" class="custom-control-input" value="1" checked>
                            <label class="custom-control-label" for="check_status_appr_1"> Setuju</label>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="check_status_appr_2" name="check_status_appr" class="custom-control-input" value="2">
                            <label class="custom-control-label" for="check_status_appr_2"> Tidak Setuju</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="req_catatan_appr" class="col-sm-3">Catatan Persetujuan :</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="req_catatan_appr" id="req_catatan_appr" required></textarea>
                    </div>
                </div>
                <hr>
                <button type="submit" id="tbl_simpan" class="btn btn-primary"><i class="fa fa-save"></i> Submit</button>
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
</script>
@endsection
