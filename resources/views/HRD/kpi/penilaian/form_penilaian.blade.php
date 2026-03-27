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
                        <th style="width: 10%" class="text-center">Bobot</th>
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
                    <input type="hidden" name="id_detail_kpi[]" value="{{ $r2->id }}">
                    <input type="hidden" name="id_kpi[]" value="{{ $r2->id_kpi }}">
                    <input type="hidden" name="bobot_kpi[]" value="{{ $r2->getKPIMaster->bobot_kpi }}">
                    <input type="hidden" name="nama_kpi[]" value="{{ $r2->getKPIMaster->nama_kpi }}">
                    <input type="hidden" name="tipe_kpi[]" value="{{ $r2->getKPIMaster->tipeKPI->tipe_kpi }}">
                    <input type="hidden" name="satuan_kpi[]" value="{{ $r2->getKPIMaster->satuanKPI->satuan_kpi }}">
                    @php
                    $realisasi = (empty($r2->realisasi)) ? 0 : $r2->realisasi;
                    $skor_akhir = (empty($r2->skor_akhir)) ? 0 : ( $r2->skor_akhir);
                    $nilai_kpi = (empty($r2->nilai_kpi)) ? 0 : $r2->nilai_kpi;
                    @endphp
                    <tr>
                        <td><a href="javascript:void(0)" onclick="goDetailKPI(this)" id="{{ $r2->id_kpi }}" name="detailKPI" data-toggle="modal" data-target="#ModalForm">{{ $r2->getKPIMaster->nama_kpi }}</a></td>
                        <td class="text-center">{{ $r2->getKPIMaster->tipeKPI->tipe_kpi }}</td>
                        <td class="text-center">{{ $r2->getKPIMaster->satuanKPI->satuan_kpi }}</td>
                        <td class="text-center"><input type="text" class="form-control pill-input" name="bobot[]" value="{{ $r2->getKPIMaster->bobot_kpi }}" style="width: 70px" readonly></td>
                        <td class="text-center"><input type="text" class="form-control pill-input" name="target[]" value="{{ $r2->target }}" style="width: 70px" readonly></td>
                        <td><input type="text" class="form-control pill-input angka" name="realisasi[]" value="{{ $realisasi }}" style="width: 70px" onblur="calculateSkorAkhir(this); changeToNull(this);" maxlength="3"></td>
                        <td><input type="text" class="form-control pill-input" name="skor_akhir[]" value="{{ $skor_akhir }}" style="width: 70px" readonly></td>
                        <td><input type="text" class="form-control pill-input" name="nilai_akhir[]" value="{{ $nilai_kpi }}" style="width: 70px" readonly></td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="7" class="text-right"><b>TOTAL NILAI KPI (%)</b></td>
                        <td><input type="text" class="form-control pill-input" name="total_nilai_kpi" id="total_nilai_kpi" value="{{ $headKPI->total_kpi }}" style="width: 70px" readonly></td>
                    </tr>
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary mb-3" id="tbl_submit_draf" name="tbl_submit_draf" value="simpan"><i class="ri-bill-fill"></i> SIMPAN DRAFT</button>
            <button type="submit" class="btn btn-success mb-3" id="tbl_submit" name="tbl_submit" value="submit"><i class="ri-bill-fill"></i> SUBMIT</button>
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
                        <th style="width: 10%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($LampiranKPI as $r3)
                    <tr>
                        <td>{{ $r3['get_k_p_i_master']['nama_kpi'] }}</td>
                        <td>{{ $r3['get_k_p_i_master']['data_pendukung'] }}</td>
                        <td class="text-center"><button type="button" class="btn btn-success" data-toggle="modal" data-target="#ModalForm" onclick="goUploadLampiran(this)" id="{{ $r3['id'] }}"><i class="fa fa-plus"></i></button></td>
                    </tr>
                    <tr>
                        @if(count($r3['lampiran']) > 0)
                        <tr>
                            <td colspan="3">
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
                                                <button type="button" class="btn btn-danger" onclick="goDeleteLampiran(this)" id="{{ $r4->id }}">Hapus</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        @else
                        <td colspan="3" class="text-center">Belum ada lampiran</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
