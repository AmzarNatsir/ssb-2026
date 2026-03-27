{{-- <style>
    table-detail {
      width: 100%;
    }
    thead,  tr {
      display: table;
      width: 100%;
      table-layout: fixed;
    }
     tbody {
      display: block;
      overflow-y: auto;
      table-layout: fixed;
      max-height: 500px;
    }
    </style> --}}
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Detail Penggajian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <form action="{{ url('hrd/penggajian/persetujuan_store') }}" method="POST" onsubmit="return konfirm()">
        {{ csrf_field() }}
        <input type="hidden" name="periode_bulan" value="{{ $bulan }}">
        <input type="hidden" name="periode_tahun" value="{{ $tahun }}">
        <div class="modal-body">
            <div class="form-group row">
                <label class="col-sm-12"><strong>Periode : {{ $periode }}</strong></label>
            </div>
            <div class="iq-card-body">
                <div class="table-responsive">
                    <table class="table tablefixed table-striped table-detail" style="width: 100%">
                    <thead>
                        <tr>
                            <th rowspan="2" scope="col">#</th>
                            <th rowspan="2" scope="col" style="width: 10%;">Karyawan</th>
                            <th rowspan="2" scope="col" style="text-align: right; width: 10%">Gaji Pokok</th>
                            <th colspan="5" scope="col" style="text-align: center;">Tunjangan</th>
                            <th colspan="4" scope="col" style="text-align: center;">Potongan</th>
                            <th rowspan="2" scope="col" style="text-align: right; width: 10%">THP</th>
                        </tr>
                        <tr>
                            <th scope="col">Tunj. Perusahaan</th>
                            <th scope="col">Tunj. Tetap</th>
                            <th scope="col">Hours Meter</th>
                            <th scope="col">Lembur</th>
                            <th scope="col">Total Tunj.</th>
                            <th scope="col">BPJS Kesehatan</th>
                            <th scope="col">JHT</th>
                            <th scope="col">JP</th>
                            <th scope="col">Total Pot.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total=0; $nom=1; @endphp
                        @foreach($list_data as $list)
                            @php 
                            $tot_tunj = doubleval($list->tunj_perusahaan) + doubleval($list->tunj_tetap) + doubleval($list->hours_meter); 
                            $tot_pot = doubleval($list->bpjsks_karyawan) + doubleval($list->bpjstk_jht_karyawan) + doubleval($list->bpjstk_jp_karyawan);
                            $thp = (doubleval($list->gaji_pokok) + doubleval($tot_tunj)) - doubleval($tot_pot);
                            @endphp
                            <tr>
                                <td>{{ $nom }}</td>
                                <td>{{ $list->get_profil->nik }}<br>{{ $list->get_profil->nm_lengkap}}</td>
                                <td style="text-align: right;">{{ number_format($list->gaji_pokok, 0, ",", ".") }}</td>
                                <td style="text-align: right;">{{ number_format($list->tunj_perusahaan, 0, ",", ".") }}</td>
                                <td style="text-align: right;">{{ number_format($list->tunj_tetap, 0, ",", ".") }}</td>
                                <td style="text-align: right;">{{ number_format($list->hours_meter, 0, ",", ".") }}</td>
                                <td style="text-align: right;">{{ number_format($list->lembur, 0, ",", ".") }}</td>
                                <td style="text-align: right;">{{ number_format($tot_tunj, 0, ",", ".") }}</td>
                                <td style="text-align: right;">{{ number_format($list->bpjsks_karyawan, 0, ",", ".") }}</td>
                                <td style="text-align: right;">{{ number_format($list->bpjstk_jht_karyawan, 0, ",", ".") }}</td>
                                <td style="text-align: right;">{{ number_format($list->bpjstk_jp_karyawan, 0, ",", ".") }}</td>
                                <td style="text-align: right;">{{ number_format($tot_pot, 0, ",", ".") }}</td>
                                <td style="text-align: right;">{{ number_format($thp, 0, ",", ".") }}</td>
                            </tr>
                            @php $nom++; $total+=$thp; @endphp
                        @endforeach
                    </tbody> 
                    <tfoot class="btn-primary">
                        <tr>
                            <td colspan="12" style="text-align: right;"><b>TOTAL</b></td>
                            <td style="text-align: right;"><b>{{ number_format($total, 0, ",", ".") }}</b></td>
                        </tr>
                    </tfoot> 
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Approve And Submit</button>
            </div>
        </div>
        
    </form>
    <script type="text/javascript">
        $(document).ready(function()
        {
            $('.table-detail').DataTable();
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
    