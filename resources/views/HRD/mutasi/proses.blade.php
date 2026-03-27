<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Proses Pengajuan Mutasis</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<form action="{{ url('hrd/mutasi/storeproses') }}" method="post" onsubmit="return konfirm()">
{{ csrf_field() }}
<input type="hidden" name="id_pengajuan" value="{{ $profil->id }}">
<input type="hidden" name="id_karyawan" value="{{ $profil->id_karyawan }}">
<div class="modal-body">
    <div class="iq-card">
        <div class="iq-card-body">
            <div class="row">
                <div class="col-lg-6">
                    @php
                    if(empty($profil->get_profil->tgl_masuk)) {
                        $ket_lama_kerja = "";
                        $ket_tgl_masuk = "Tanpa Keterangan";
                    } else {
                        $ket_lama_kerja = App\Helpers\Hrdhelper::get_lama_kerja_karyawan($profil->get_profil->tgl_masuk);
                        $ket_tgl_masuk = date_format(date_create($profil->get_profil->tgl_masuk), "d-m-Y");
                    }
                    @endphp
                    <table class="table" style="width:100%">
                        <tr>
                            <td style="width: 10%">
                                @if(!empty($profil->get_profil->photo))
                                <img src="{{ url(Storage::url('hrd/photo/'.$profil->get_profil->photo)) }}"
                                    class="rounded-circle" alt="avatar" style="width: 80px; height: auto;">
                                @else
                                <a href="{{ asset('assets/images/user/1.jpg') }}" data-fancybox data-caption="avatar">
                                <img src="{{ asset('assets/images/user/1.jpg') }}"
                                    class="rounded-circle" alt="avatar" style="width: 80px; height: auto;"></a>
                                @endif
                            </td>
                            <td>
                                <h4 class="mb-0">{{ $profil->get_profil->nm_lengkap }}</h4>
                                <h4 class="mb-0">{{ $profil->get_profil->nik }}</h4>
                                <h6 class="mb-0">{{ $profil->get_profil->get_jabatan->nm_jabatan }} | {{ $profil->get_profil->get_departemen->nm_dept }}</h6>
                                <h6 class="mb-0">Status Karyawan : {{ $profil->get_profil->get_status_karyawan($profil->get_profil->id_status_karyawan) }}</h6>
                                <h6 class="mb-0">Efektif Jabatan : {{ (empty($profil->get_profil->tmt_jabatan)) ? "" : date("d-m-Y", strtotime($profil->get_profil->tmt_jabatan)) }}</h6>
                                <h6 class="mb-0">Tanggal Bergabung : {{ $ket_tgl_masuk }} | Lama Bekerja : {{ $ket_lama_kerja }}</h6>
                                <h6 class="mb-0"></h6>
                            </td>
                        </tr>
                    </table>
                    <ul class="list-group" style="margin-bottom: 15px">
                        <li class="list-group-item active">Data Pengajuan</li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item disabled" aria-disabled="true">Tanggal Pengajuan : <b>{{ date_format(date_create($profil->tgl_pengajuan), 'd-m-Y') }}</b></li>
                        <li class="list-group-item">Alasan Pengajuan : <b>{{ $profil->alasan_pengajuan }}</b></li>
                        <li class="list-group-item">Diusulkan : <b>@foreach($list_kategori as $key => $value)
                            @if($key==$profil->kategori)
                                {{ $value }}
                                @php break; @endphp
                            @endif
                            @endforeach</b></li>
                    </ul>
                    <div class="iq-card-header d-flex">
                        <div class="iq-header-title">
                        <h4 class="card-title">Lampiran Hasil Evaluasi</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <table class="table" style="width: 100%;">
                            <tr>
                                <td>
                                    <a href="{{ url('hrd/perubahanstatus/download/hasil_evaluasi/'.$profil->id) }}" target="_new" class="btn btn-danger btn-block"><i class="ri-download-line"></i> File Lampiran Hasil Evaluasi Kerja</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="iq-card-header d-flex">
                        <div class="iq-header-title">
                            <h4 class="card-title">Hirarki Persetujuan</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <table class="table" style="width: 100%; font-size: 12px">
                            <thead>
                            <tr>
                                <th rowspan="2" style="width: 5%">Level</th>
                                <th rowspan="2">Pejabat</th>
                                <th colspan="3" class="text-center">Persetujuan</th>
                            </tr>
                            <tr>
                                <th class="text-left">Tanggal</th>
                                <th class="text-left">Keterangan</th>
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
                                    <td class="text-center">
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
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                        <h4 class="card-title">Form Registrasi/Proses</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="iq-card-body">
                        <ul class="list-group" style="margin-bottom: 15px">
                            <li class="list-group-item active">Posisi Yang Diusulkan</li>
                        </ul>
                        <div class="form-group row">
                            <label class="col-sm-4">Jabatan</label>
                            <div class="col-sm-8">
                            <label id="tgl_akh_lama">: {{ $profil->get_jabatan_baru->nm_jabatan }}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4">Departemen</label>
                            <div class="col-sm-8">
                            <label id="tgl_akh_lama">: {{ (!empty($profil->id_dept_br)) ? $profil->get_dept_baru->nm_dept : "" }}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4">Tanggal Efektif</label>
                            <div class="col-sm-8">
                                <input type="date" name="tgl_eff_baru" id="tgl_eff_baru" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="iq-card-body">
                        <ul class="list-group" style="margin-bottom: 15px">
                            <li class="list-group-item active">Proses Registrasi</li>
                        </ul>
                        <div class="form-group row">
                            <label class="col-sm-4">Nomor Surat</label>
                            <div class="col-sm-8">
                                <input type="text" name="inp_nomor_surat" id="inp_nomor_surat" maxlength="50" class="form-control" value="{{ $no_surat }}" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4">Tanggal Surat</label>
                            <div class="col-sm-8">
                                <input type="date" name="inp_tgl_surat" id="inp_tgl_surat" class="form-control" required readonly>
                            </div>
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
        document.getElementById('inp_tgl_surat').value = moment().format('YYYY-MM-DD');
        document.getElementById('tgl_eff_baru').value = moment().format('YYYY-MM-DD');
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
