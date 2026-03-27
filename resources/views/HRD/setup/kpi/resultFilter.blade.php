<div class="iq-card">
    <div class="iq-card-header d-flex justify-content-between">
        <div class="iq-header-title">
            <h4 class="card-title">Daftar Key Performance Indicator</h4>
        </div>
        <div class="todo-notification d-flex align-items-center">
            <button type="button" class="btn iq-bg-primary" data-toggle="modal" data-target="#ModalForm" onclick="goFormAdd(this)" value="{{ $id_dept }}"><i class="ri-add-line mr-2"></i>Buat KPI Baru</button>
         </div>
    </div>
    <div class="iq-card-body table-responsive" id="p_preview" style="width:100%; height:auto">
        <table id="user-list-table" class="table  table-hover table-striped table-bordered" role="grid" aria-describedby="user-list-page-info">
            <thead>
                <tr>
                    <td colspan="9">Departemen : <b>{{ $nama_departemen }}</b></td>
                </tr>
                <tr>
                    <th style="width: 15%; text-align: center;">Perspektif</th>
                    <th style="width: 15%; text-align: center;">Sasaran Strategi</th>
                    <th style="text-align: center;">KPI</th>
                    <th style="width: 10%; text-align: center;">Bobot KPI</th>
                    <th style="width: 10%; text-align: center;">Tipe</th>
                    <th style="width: 10%; text-align: center;">Satuan</th>
                    <th style="width: 5%;">Act.</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kpi as $items)
                <tr>
                    <td class="text-center">{{ $items->Perspektif->perspektif }}</td>
                    <td>{{ $items->SasaranStrategi->sasaran_strategi }}</td>
                    <td>{{ $items->nama_kpi }}</td>
                    <td class="text-center">{{ $items->bobot_kpi }} %</td>
                    <td class="text-center">{{ $items->TipeKPI->tipe_kpi }}</td>
                    <td class="text-center">{{ $items->SatuanKPI->satuan_kpi }}</td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

