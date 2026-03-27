<div class="iq-card">
    <div class="iq-card-header d-flex justify-content-between">
        <div class="iq-header-title">
            <h4 class="card-title">Pengaturan KPI Periode {{ $currentMonth }} - {{ $namaDept }}</h4>
        </div>
    </div>
    <div class="iq-card-body">
        <div class="table-responsive" id="p_preview" style="width:100%; height:auto">
            @if($statusSetup=='draft')
            <button type="submit" class="btn btn-primary mb-3" id="tbl_submit_draf" name="tbl_submit_draf" value="simpan"><i class="ri-bill-fill"></i> SIMPAN DRAFT</button>
            <button type="submit" class="btn btn-success mb-3" id="tbl_submit" name="tbl_submit" value="posting"><i class="ri-bill-fill"></i> POSTING</button>
            @endif
            @if($statusSetup=='posting')
            <div class="alert alert-success" role="alert">
                <div class="iq-alert-text">Pengaturan KPI telah di<b> POSTING</b></div>
            </div>
            @endif
            @if($statusSetup=='approval')
            <div class="alert alert-danger" role="alert">
                <div class="iq-alert-text">Pengaturan KPI telah di <b>SUBMIT </b> dan menunggu <b>PERSETUJUAN</b></div>
            </div>
            @endif
            @if($statusSetup=='closed')
            <div class="alert alert-info" role="alert">
                <div class="iq-alert-text">KPI Departemen telah di <b>Approve </b></div>
            </div>
            @endif
            <input type="hidden" name="periode_bulan" value="{{ date('m') }}">
            <input type="hidden" name="idHeAD" value="{{ $idHead }}">
            <table class="table" style="width: 100%; border-collapse: collapse" border="1">
                <thead>
                    <tr style="background-color: #3877dc; color: white">
                        <th>Key Performance Indicator (KPI)</th>
                        <th style="width: 10%" class="text-center">Tipe</th>
                        <th style="width: 15%" class="text-center">Satuan</th>
                        <th style="width: 10%" class="text-center">Bobot</th>
                        <th style="width: 10%" class="text-center">Target&nbsp;(%)</th>
                    </tr>
                </thead>
                <tbody>
                    @if(empty($listKPIDepartemen))
                    <tr>
                        <td colspan="5" class="text-center">KPI Departemen belum diatur</td>
                    </tr>
                    @endif
                    @foreach ($listKPIDepartemen  as $r)
                    <input type="hidden" name="id_detail_kpi[]" value="{{ $r['id_detail'] }}">
                    <input type="hidden" name="id_kpi[]" value="{{ $r['id_kpi'] }}">
                    <input type="hidden" name="bobot_kpi[]" value="{{ $r['bobot_kpi'] }}">
                    <tr>
                        <td style="vertical-align: middle">{{ $r['nama_kpi'] }}</td>
                        <td class="text-center" style="vertical-align: middle">{{ $r['tipe_kpi'] }}</td>
                        <td class="text-center" style="vertical-align: middle">{{ $r['satuan_kpi'] }}</td>
                        <td class="text-center" style="vertical-align: middle">{{ $r['bobot_kpi'] }}</td>
                        <td><input type="text" class="form-control pill-input" name="target[]" value="{{ $r['target_kpi'] }}" {{ ($statusSetup=='posting') ? "readonly" : "" }}></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
