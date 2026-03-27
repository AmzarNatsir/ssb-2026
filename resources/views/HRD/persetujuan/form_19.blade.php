<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Persetujuan KPI Depatemen</h5>
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
<input type="hidden" name="status_approval" value="{{ $profil['kpiH']['status_pengajuan'] }}">
<input type="hidden" name="periode_bulan" id="periode_bulan" value="{{ $profil['kpiH']['bulan'] }}">
<input type="hidden" name="periode_tahun" id="periode_tahun" value="{{ $profil['kpiH']['tahun'] }}">
<input type="hidden" name="departemen" id="departemen" value="">
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="iq-card">
                <div class="iq-card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="todo-date d-flex mr-3">
                        <i class="ri-calendar-2-line text-success mr-2"></i>
                        <span>Penilaian KPI Departemen {{ $profil['periode_kpi'] }}</span>
                        </div>
                    </div>
                    <div class="iq-edit-list">
                        <ul class="iq-edit-profile d-flex nav nav-pills">
                            <li class="col-md-6 p-0">
                                <a class="nav-link active" data-toggle="pill" href="#kpi-realisasi">
                                KPI REALISASI
                                </a>
                            </li>
                            <li class="col-md-6 p-0">
                                <a class="nav-link" data-toggle="pill" href="#kpi-data-pendukung">
                                 DATA PENDUDKUNG
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="kpi-realisasi" role="tabpanel">
                            <div class="iq-card-body">
                                <table class="table-sm" style="width: 100%; border-collapse: collapse" border="1">
                                    <thead>
                                        <th>KPI</th>
                                        <th style="width: 10%" class="text-center">Tipe</th>
                                        <th style="width: 10%" class="text-center">Satuan</th>
                                        <th style="width: 10%" class="text-center">Bobot (%)</th>
                                        <th style="width: 10%" class="text-center">Target (%)</th>
                                        <th style="width: 10%" class="text-center">Realisasi (%)</th>
                                        <th style="width: 10%" class="text-center">Skor&nbsp;Akhir (%)</th>
                                        <th style="width: 10%" class="text-center">Nilai KPI (%)</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($profil['detailKPI'] as $r1)
                                        <tr>
                                            <td>{{ $r1->nama_kpi }}</td>
                                            <td class="text-center">{{ $r1->tipe }}</td>
                                            <td class="text-center">{{ $r1->satuan }}</td>
                                            <td class="text-center">{{ $r1->bobot }}</td>
                                            <td class="text-center">{{ $r1->target }}</td>
                                            <td class="text-center">{{ $r1->realisasi }}</td>
                                            <td class="text-center">{{ $r1->skor_akhir }}</td>
                                            <td class="text-center">{{ $r1->nilai_kpi }}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="7" class="text-right"><b>TOTAL NILAI KPI (%)</b></td>
                                            <td class="text-center">{{ $profil['kpiH']['total_kpi'] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="kpi-data-pendukung" role="tabpanel">
                            <div class="iq-card-body">
                                <table class="table-sm" style="width: 100%; border-collapse: collapse" border="1">
                                    <thead>
                                        <tr style="background-color: #3877dc; color: white">
                                            <th>KPI</th>
                                            <th style="width: 40%">Data Pendukung</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($profil['LampiranKPI'] as $r3)
                                        <tr>
                                            <td>{{ $r3['get_k_p_i_master']['nama_kpi'] }}</td>
                                            <td>{{ $r3['get_k_p_i_master']['data_pendukung'] }}</td>
                                        </tr>
                                        <tr>
                                            @if(count($r3['lampiran']) > 0)
                                            <tr>
                                                <td colspan="2">
                                                    <table style="width: 100%; border-collapse: collapse">
                                                        <thead>
                                                            <tr>
                                                                <th colspan="3">Lampiran data pendukung</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($r3['lampiran'] as $r4)
                                                            <tr>
                                                                <td class="text-center" style="width: 5%">{{ $loop->iteration }}</td>
                                                                <td>{{ $r4->keterangan }}</td>
                                                                <td class="text-center" style="width: 25%">
                                                                    <button type="button" class="btn btn-primary" onclick="goDownloadLampiran(this)" id="{{ $r4->id }}">Download</button>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            @else
                                            <td colspan="2" class="text-center">Tidak ada lampiran</td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
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
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-6">
            <div class="iq-card iq-card-block iq-card-stretch">
                <div class="iq-card-body">
                    <ul class="list-group" style="margin-bottom: 15px">
                        <li class="list-group-item active">Form Persetujuan</li>
                    </ul>
                    <div class=" row align-items-center">
                        <label class="col-sm-4">Status Persetujuan</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" id="pil_persetujuan" name="pil_persetujuan" style="width: 100%;" required>
                                <option value="1">Setuju</option>
                                <option value="2">Tolak</option>
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
    var goDownloadLampiran = function(el)
    {
        window.open("{{ url('hrd/kpi/downloadLampiranKPI') }}/"+el.id);
    }
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
