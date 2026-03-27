<div class="iq-edit-list">
    <ul class="iq-edit-profile d-flex nav nav-pills">
        <li class="col-md-4 p-0">
            <a class="nav-link active" data-toggle="pill" href="#kpi-setup">
            KPI SETUP PERIODE {{ strtoupper($periode_kpi) }}
            </a>
        </li>
        <li class="col-md-4 p-0">
            <a class="nav-link" data-toggle="pill" href="#kpi-realisasi">
            KPI REALISASI PERIODE {{ strtoupper($periode_kpi) }}
            </a>
        </li>
        <li class="col-md-4 p-0">
            <a class="nav-link" data-toggle="pill" href="#kpi-data-pendukung">
           DATA PENDUDKUNG
            </a>
        </li>
    </ul>
</div>
<div class="tab-content">
    <div class="tab-pane fade active show" id="kpi-setup" role="tabpanel">
        <div class="iq-card-body">
            <table class="table" style="width: 100%; border-collapse: collapse" border="1">
                <thead>
                    <tr style="background-color: #3877dc; color: white">
                        <th>KPI</th>
                        <th style="width: 10%" class="text-center">Tipe</th>
                        <th style="width: 15%" class="text-center">Satuan</th>
                        <th style="width: 10%" class="text-center">Bobot&nbsp;(%)</th>
                        <th style="width: 10%" class="text-center">Target&nbsp;(%)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailKPI as $r1)
                    <tr>
                        <td><a href="javascript:void(0)" onclick="goDetailKPI(this)" id="{{ $r1->id_kpi }}" name="detailKPI" data-toggle="modal" data-target="#ModalForm">{{ $r1->getKPIMaster->nama_kpi }}</a></td>
                        <td class="text-center">{{ $r1->getKPIMaster->tipeKPI->tipe_kpi }}</td>
                        <td class="text-center">{{ $r1->getKPIMaster->satuanKPI->satuan_kpi }}</td>
                        <td class="text-center">{{ $r1->getKPIMaster->bobot_kpi }}</td>
                        <td class="text-center">{{ $r1->target }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="tab-pane fade" id="kpi-realisasi" role="tabpanel">
        <div class="iq-card-header d-flex justify-content-between">
            <div class="iq-header-title">
                <h4 class="card-title">KPI Realisasi</h4>
            </div>
        </div>
        <div class="iq-card-body">
            <input type="hidden" name="idHeAD" value="{{ $headKPI->id }}">
            <table class="table" style="width: 100%; border-collapse: collapse" border="1">
                <thead>
                    <tr style="background-color: #3877dc; color: white">
                        <th>KPI</th>
                        <th style="width: 10%" class="text-center">Tipe</th>
                        <th style="width: 10%" class="text-center">Satuan</th>
                        <th style="width: 10%" class="text-center">Bobot</th>
                        <th style="width: 10%" class="text-center">Target (%)</th>
                        <th style="width: 10%" class="text-center">Realisasi (%)</th>
                        <th style="width: 10%" class="text-center">Skor&nbsp;Akhir (%)</th>
                        <th style="width: 10%" class="text-center">Nilai KPI (%)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailKPI as $r2)
                    <tr>
                        <td><a href="javascript:void(0)" onclick="goDetailKPI(this)" id="{{ $r2->id_kpi }}" name="detailKPI" data-toggle="modal" data-target="#ModalForm">{{ $r2->getKPIMaster->nama_kpi }}</a></td>
                        <td class="text-center">{{ $r2->getKPIMaster->tipeKPI->tipe_kpi }}</td>
                        <td class="text-center">{{ $r2->getKPIMaster->satuanKPI->satuan_kpi }}</td>
                        <td class="text-center">{{ $r2->bobot_kpi }}<</td>
                        <td class="text-center">{{ $r2->target }}</td>
                        <td class="text-center">{{ $r2->realisasi }}</td>
                        <td class="text-center">{{ $r2->skor_akhir }}</td>
                        <td class="text-center">{{ $r2->nilai_kpi }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="7" class="text-right"><b>TOTAL NILAI KPI (%)</b></td>
                        <td class="text-center">{{ $headKPI->total_kpi }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="tab-pane fade" id="kpi-data-pendukung" role="tabpanel">
        <div class="iq-card-body">
            <p>Data Pendukung</p>
            <table class="table-sm" style="width: 100%; border-collapse: collapse" border="1">
                <thead>
                    <tr style="background-color: #3877dc; color: white">
                        <th>KPI</th>
                        <th style="width: 40%">Data Pendukung</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($LampiranKPI as $r3)
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
