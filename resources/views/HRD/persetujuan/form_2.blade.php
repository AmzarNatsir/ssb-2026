<script src="{{ asset('assets/js/custom.js') }}"></script>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Persetujuan Pengajuan Aplikasi Pelamar</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<form action="{{ url('hrd/persetujuan/storeApproval') }}" method="post" onsubmit="return konfirm()">
{{ csrf_field() }}
<input type="hidden" name="id_pengajuan" value="{{ $data_approval->id }}">
<input type="hidden" name="key_approval" value="{{ $data_approval->approval_key }}">
<input type="hidden" name="level_approval" value="{{ $data_approval->approval_level }}">
<input type="hidden" name="date_approval" value="{{ $data_approval->approval_date }}">
<input type="hidden" name="group_approval" value="{{ $data_approval->approval_group }}">
<input type="hidden" name="status_approval" value="{{ $profil->status_pengajuan }}">
<div class="modal-body">

    <div class="row">
        <div class="col-sm-12 col-lg-6">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                   <div class="iq-header-title">
                      <h4 class="card-title">Aplikasi Pelamar</h4>
                   </div>
                </div>
                <div class="iq-card-body">
                    <p>Berikut adalah data profil pelamar</p>
                    <div class="iq-accordion career-style faq-style">
                        <div class="iq-card iq-accordion-block accordion-active">
                            <div class="active-faq clearfix">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-12"><a class="accordion-title"><span> <i class="fa fa-user"></i> Data Diri</span> </a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-details">
                                <div class="iq-card-body" style="width:100%; height:auto">
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <div class="form-group col-sm-12">
                                                <img class="avatar-140 profile-pic" id="preview_upload" src="{{ url(Storage::url('hrd/pelamar/photo/'.$profil->file_photo)) }}" alt="profile-pic">
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <table class="table" style="width: 100%;">
                                            <tr>
                                                <td><h4>{{ $profil->nama_lengkap }}</h4></td>
                                            </tr>
                                            <tr>
                                                <td><i class="ri-phone-line"></i> {{ $profil->no_hp }}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-whatsapp"></i> {{ $profil->no_wa }}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="ri-map-pin-fill"></i> {{ $profil->alamat }}</td>
                                            </tr>
                                            <tr>
                                                <td><i class="ri-mail-line"></i> {{ $profil->email }}</td>
                                            </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="iq-card iq-accordion-block ">
                            <div class="active-faq clearfix">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-12"><a class="accordion-title"><span><i class="fa fa-pencil"></i> Hasil Tes</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-details">
                                <table class="table" style="width: 100%">
                                    <tr>
                                        <td colspan="3" style="text-align: left"><b>PSIKOTEST</b></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 13%">Nilai</td>
                                        <td style="width: 2%">:</td>
                                        <td>{{ $profil->psikotes_nilai }}</td>
                                    </tr>
                                    <tr>
                                        <td>Keterangan</td>
                                        <td>:</td>
                                        <td>{{ $profil->psikotes_ket }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="text-align: left"><b>WAWANCARA</b></td>
                                    </tr>
                                    <tr>
                                        <td>Nilai</td>
                                        <td>:</td>
                                        <td>{{ $profil->wawancara_nilai }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nilai</td>
                                        <td>:</td>
                                        <td>{{ $profil->wawancara_ket }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="text-align: left"><b>TOTAL SKOR : {{ $profil->total_skor }}</b></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="iq-card iq-accordion-block ">
                            <div class="active-faq clearfix">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-12"><a class="accordion-title"><span><i class="fa fa-users"></i> Data Keluarga </h4><p>Latar Belakang Keluarga (Ayah, Ibu & Saudara)</p></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-details">
                                <div class="iq-card-body" style="width:100%; height:auto">
                                    <div class="row col-lg-12 table-responsive">
                                        <table class="table" style="font-size: 12px">
                                            <thead>
                                                <th>No.</th>
                                                <th>Hubungan</th>
                                                <th>Nama Keluarga</th>
                                                <th>Tempat/Tanggal Lahir</th>
                                                <th>Jenkel</th>
                                                <th>Pendidikan Terakhir</th>
                                                <th>Pekerjaan</th>
                                            </thead>
                                            <tbody>
                                            @php $nom=1; @endphp
                                            @foreach($lb_keluarga as $lbk)
                                            <tr>
                                                <td>{{$nom}}</td>
                                                <td>{{ $lbk->get_hubungan_keluarga($lbk->id_hubungan) }}</td>
                                                <td>{{ $lbk->nm_keluarga }}</td>
                                                <td>{{ $lbk->tmp_lahir.", ".date_format(date_create($lbk->tgl_lahir), 'd-m-Y') }}</td>
                                                <td>{{ ($lbk->jenkel==1)? "Laki-Laki" : "Perempuan" }}</td>
                                                <td>{{ $lbk->get_pendidikan_akhir($lbk->id_jenjang) }}</td>
                                                <td>{{ $lbk->pekerjaan }}</td>
                                            </tr>
                                            @php $nom++; @endphp
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($profil->status_nikah==2)
                        <div class="iq-card iq-accordion-block ">
                            <div class="active-faq clearfix">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-12"><a class="accordion-title"><span><i class="fa fa-users"></i> Data Keluarga </h4><p>(Suami/Istri & Anak)</p></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-details">
                                <div class="iq-card-body" style="width:100%; height:auto">
                                    <div class="row col-lg-12 table-responsive">
                                        <table class="table" style="font-size: 12px">
                                            <thead>
                                                <th>No.</th>
                                                <th>Hubungan</th>
                                                <th>Nama Keluarga</th>
                                                <th>Tempat/Tanggal Lahir</th>
                                                <th>Jenkel</th>
                                                <th>Pendidikan Terakhir</th>
                                                <th>Pekerjaan</th>
                                            </thead>
                                            <tbody>
                                            @php $nom=1; @endphp
                                            @foreach($keluarga as $kel)
                                            <tr>
                                                <td>{{$nom}}</td>
                                                <td>{{ $kel->get_hubungan_keluarga($kel->id_hubungan) }}</td>
                                                <td>{{ $kel->nm_keluarga }}</td>
                                                <td>{{ $kel->tmp_lahir.", ".date_format(date_create($kel->tgl_lahir), 'd-m-Y') }}</td>
                                                <td>{{ ($kel->jenkel==1)? "Laki-Laki" : "Perempuan" }}</td>
                                                <td>{{ $kel->get_pendidikan_akhir($kel->id_jenjang) }}</td>
                                                <td>{{ $kel->pekerjaan }}</td>
                                            </tr>
                                            @php $nom++; @endphp
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="iq-card iq-accordion-block ">
                            <div class="active-faq clearfix">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-12"><a class="accordion-title"><span><i class="fa fa-graduation-cap"></i> Riwayat Pendidikan</h4></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-details">
                                <div class="iq-card-body" style="width:100%; height:auto">
                                    <div class="row col-lg-12 table-responsive">
                                        <table class="table" style="font-size: 12px">
                                            <thead>
                                                <th>No.</th>
                                                <th>Jenjang Pendidikan</th>
                                                <th>Nama Sekolah/Perguruan Tinggi</th>
                                                <th>Alamat</th>
                                                <th>Tahun Pendidikan</th>
                                            </thead>
                                            <tbody>
                                            @php $nom=1; @endphp
                                                @foreach($pendidikan as $jenj)
                                                <tr>
                                                    <td>{{$nom}}</td>
                                                    <td>{{ $jenj->get_jenjang_pendidikan($jenj->id_jenjang) }}</td>
                                                    <td>{{ $jenj->nm_sekolah_pt }}</td>
                                                    <td>{{ $jenj->alamat }}</td>
                                                    <td>{{ $jenj->mulai_tahun." s/d".$jenj->sampai_tahun }}</td>
                                                </tr>
                                                @php $nom++; @endphp
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="iq-card iq-accordion-block ">
                            <div class="active-faq clearfix">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-12"><a class="accordion-title"><span><i class="fa fa-id-card" aria-hidden="true"></i> Pengalaman Organisasi</h4></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-details">
                                <div class="iq-card-body" style="width:100%; height:auto">
                                    <div class="row col-lg-12 table-responsive">
                                        <table class="table" style="font-size: 12px">
                                            <thead>
                                                <th>No.</th>
                                                <th>Nama Organisasi</th>
                                                <th>Posisi/Jabatan</th>
                                                <th>Periode Tahun</th>
                                            </thead>
                                            <tbody>
                                            @php $nom=1; @endphp
                                                @foreach($organisasi as $org)
                                                <tr>
                                                    <td>{{$nom}}</td>
                                                    <td>{{ $org->nama_organisasi }}</td>
                                                    <td>{{ $org->posisi }}</td>
                                                    <td>{{ $org->mulai_tahun." s/d".$org->sampai_tahun }}</td>
                                                </tr>
                                                @php $nom++; @endphp
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="iq-card iq-accordion-block ">
                            <div class="active-faq clearfix">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-12"><a class="accordion-title"><span><i class="fa fa-building" aria-hidden="true"></i> Pengalaman Kerja</h4></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-details">
                                <div class="iq-card-body" style="width:100%; height:auto">
                                    <div class="row col-lg-12 table-responsive">
                                        <table class="table" style="font-size: 12px">
                                            <thead>
                                                <th>No.</th>
                                                <th>Nama Perusahaan</th>
                                                <th>Posisi/Jabatan</th>
                                                <th>Alamat</th>
                                                <th>Periode Tahun</th>
                                            </thead>
                                            <tbody>
                                            @php $nom=1; @endphp
                                                @foreach($pekerjaan as $krj)
                                                <tr>
                                                    <td>{{$nom}}</td>
                                                    <td>{{ $krj->nm_perusahaan }}</td>
                                                    <td>{{ $krj->posisi }}</td>
                                                    <td>{{ $krj->alamat }}</td>
                                                    <td>{{ $krj->mulai_tahun." s/d".$krj->sampai_tahun }}</td>
                                                </tr>
                                                @php $nom++; @endphp
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="iq-card iq-accordion-block ">
                            <div class="active-faq clearfix">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-12"><a class="accordion-title"><span><i class="fa fa-paperclip" aria-hidden="true"></i> Dokumen</h4></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-details">
                                <div class="iq-card-body" style="width:100%; height:auto">
                                    <div class="row col-lg-12 table-responsive">
                                        <div class="ckeckout-product-lists">
                                            <table class="table" style="width: 100%">
                                                @foreach($jenis_dokumen as $dok)
                                                <tr>
                                                    <td style="width: 30%"><div class="ckeckout-product">
                                                        @foreach($list_dokumen as $dtdok => $valdok)
                                                            @if($valdok->id_dokumen==$dok->id)
                                                                <a href="{{ url(Storage::url($valdok->path_file.$valdok->file_dokumen)) }}" data-fancybox data-caption='{{ $dok->id.". ".$dok->nm_dokumen}}'>
                                                                <img src="{{ url(Storage::url($valdok->path_file.$valdok->file_dokumen)) }}"  class="card-img-top" alt="{{ $dok->id.". ".$dok->nm_dokumen}}" style="heigth:100px; width:100px;"></a>
                                                                @php
                                                                break;
                                                                @endphp
                                                            @endif
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td style="vertical-align: middle"><h5>{{ $dok->nm_dokumen }}</h5></td>
                                                </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-6">
            <div class="iq-card iq-card-block iq-card-stretch">
                <div class="iq-card-body">
                    <ul class="list-group" style="margin-bottom: 15px">
                        <li class="list-group-item active">Hirarki Persetujuan</li>
                    </ul>
                    <div class="row align-items-center">
                        <table class="table" style="width: 100%; font-size: 10px">
                            <thead>
                            <tr>
                                <th rowspan="2" style="width: 5%">Level</th>
                                <th rowspan="2">Pejabat</th>
                                <th colspan="3" class="text-center">Persetujuan</th>
                            </tr>
                            <tr>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Keterangan</th>
                                <th class="text-center">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($hirarki_persetujuan as $list)
                                <tr>
                                    <td class="text-center">
                                        @if($list->approval_active==1)
                                        <h4><span class="badge badge-pill badge-success">{{ $list->approval_level }}</span></h4>
                                        @else
                                        <h4><span class="badge badge-pill badge-danger">{{ $list->approval_level }}</span></h4>
                                        @endif
                                    </td>
                                    <td>{{ $list->get_profil_employee->nm_lengkap }}<br>
                                        {{ $list->get_profil_employee->get_jabatan->nm_jabatan }}</td>
                                    <td>
                                        {{ (empty($list->approval_date)) ? "" : date('d-m-Y', strtotime($list->approval_date))  }}
                                    </td>
                                    <td>{{ $list->approval_remark }}</td>
                                    <td>
                                        @if($list->approval_status==1)
                                        <h4><span class="badge badge-pill badge-success">Approved</span></h4>
                                        @elseif($list->approval_status==2)
                                        <h4><span class="badge badge-pill badge-danger">Rejected</span></h4>
                                        @else

                                        @endif
                                        </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <ul class="list-group" style="margin-bottom: 15px">
                        <li class="list-group-item active">Form Persetujuan</li>
                    </ul>
                    <div class=" row align-items-center">
                        <label class="col-sm-4">Status Persetujuan</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" id="pil_persetujuan" name="pil_persetujuan" style="width: 100%;" required>
                                <option value="1">Setuju</option>
                                <option value="2">Tolak</option>
                                <option value="3">Pending</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class=" row align-items-center">
                        <div class="form-group col-sm-12">
                            <label>Deskripsi Persetujuan</label>
                            <textarea class="form-control" name="inp_keterangan" id="inp_keterangan" required></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save changes</button>
</div>
</form>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    });
    function konfirm()
    {
        var psn = confirm("Yakin data akan disimpan ?");
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
</script>
