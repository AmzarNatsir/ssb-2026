<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Pengajuan Surat Teguran - Detail</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<form action="{{ url('hrd/suratperingatan/cancelPengajuanST/'.$profil->id) }}" method="post" onsubmit="return konfirm()">
{{ csrf_field() }}
{{ method_field('PUT') }}
<div class="modal-body">
    <div class="iq-card iq-card-block iq-card-stretch">
        <div class="iq-card-body">
            {{-- <div class="iq-card"> --}}
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="list-group" style="margin-bottom: 15px">
                            <li class="list-group-item active">Profil Karyawan</li>
                        </ul>
                        <div class="iq-card">
                            <div class="iq-card-body">
                                <div class="form-group row">
                                    <label class="col-sm-4">Karyawan</label>
                                    <div class="col-sm-8">
                                    <label id="status_karyawan"><b>: {{ $profil->get_karyawan->nik }} - {{ $profil->get_karyawan->nm_lengkap }}</b></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Status Karyawan</label>
                                    <div class="col-sm-8">
                                    <label id="status_karyawan"><b>: {{ $profil->get_karyawan->get_status_karyawan($profil->get_karyawan->id_status_karyawan) }}</b></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Divisi</label>
                                    <div class="col-sm-8">
                                    <label id="divisi"><b>: {{ (!empty($profil->get_karyawan->id_divisi)) ? $profil->get_karyawan->get_divisi->nm_divisi : "" }}</b></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Departemen</label>
                                    <div class="col-sm-8">
                                    <label id="departemen"><b>: {{ (!empty($profil->get_karyawan->id_departemen)) ? $profil->get_karyawan->get_departemen->nm_dept : "" }}</b></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Sub Departemen</label>
                                    <div class="col-sm-8">
                                    <label id="subdepartemen"><b>: {{ (!empty($profil->get_karyawan->id_subdepartemen)) ? $profil->get_karyawan->get_subdepartemen->nm_subdept : "" }}</b></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Jabatan</label>
                                    <div class="col-sm-8">
                                    <label id="jabatan"><b>: {{ (!empty($profil->get_karyawan->id_jabatan)) ? $profil->get_karyawan->get_jabatan->nm_jabatan : "" }}</b></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Bergabung Tanggal</label>
                                    <div class="col-sm-8">
                                    <label id="tanggal_masuk"><b>: {{ (!empty($profil->get_karyawan->tgl_masuk)) ? date('d-m-Y', strtotime($profil->get_karyawan->tgl_masuk)): "" }}</b></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Lama Bekerja</label>
                                    <div class="col-sm-8">
                                    <label id="lama_bekerja"><b>: {{ (!empty($profil->get_karyawan->tgl_masuk)) ? App\Helpers\Hrdhelper::get_lama_kerja_karyawan($profil->get_karyawan->tgl_masuk) : "Tanpa Keterangan" }}</b></label>
                                    </div>
                                </div>
                            </div>
                            <div class="iq-card-header d-flex justify-content-between">
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
                    <div class="col-lg-6">
                        <ul class="list-group" style="margin-bottom: 15px">
                            <li class="list-group-item active">Detail Pelanggaran</li>
                        </ul>
                        <div class="iq-card">
                            <div class="iq-card-body">
                                <div class="form-group row">
                                    <label class="col-sm-4">Tanggal Kejadian</label>
                                    <div class="col-sm-8">
                                    <label><b>: {{ date('d-m-Y', strtotime($profil->tanggal_kejadian)) }}</b></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Waktu Kejadian</label>
                                    <div class="col-sm-8">
                                    <label><b>: {{ date('H:i', strtotime($profil->waktu_kejadian)) }}</b></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Tempat Kejadian</label>
                                    <div class="col-sm-8">
                                    <label><b>: {{ $profil->tempat_kejadian }}</b></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Jenis Pelanggaran</label>
                                    <div class="col-sm-8">
                                    <label><b>: {{ $profil->get_jenis_pelanggaran->jenis_pelanggaran }}</b></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Akibat pelanggaran tersebut terjadi</label>
                                    <div class="col-sm-8">
                                    <label><b>: {{ $profil->akibat }}</b></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Tindakan perbaikan yang dilakukan setelah kejadian</label>
                                    <div class="col-sm-8">
                                    <label><b>: {{ $profil->tindakan }}</b></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Rekomendasi dari atasan pelanggar</label>
                                    <div class="col-sm-8">
                                    <label><b>: {{ $profil->rekomendasi }}</b></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Komentar dari pelanggaran</label>
                                    <div class="col-sm-8">
                                    <label><b>: {{ $profil->komentar_pelanggar }}</b></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {{-- </div> --}}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    @if($profil->is_draft==1)
    <button type="submit" class="btn btn-danger">Batalkan Pengajuan</button>
    @endif
</div>
</form>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
    });
    function konfirm()
    {
        var psn = confirm("Yakin data akan membatalkan pengajuan ?");
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
</script>
