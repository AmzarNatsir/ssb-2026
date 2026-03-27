<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Rekapitulasi Hasil Tes</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="iq-card">
            <div class="iq-card-body">
                <table id="rekap-list-table" class="table table-sm table-responsive table-hover table-striped table-bordered"  style="width: 100%; font-size: 12px">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 4%; vertical-align: middle" rowspan="3">No</th>
                            <th style="text-align: center; width: 5%; vertical-align: middle" rowspan="3">Photo</th>
                            <th style="text-align: center; vertical-align: middle" rowspan="3">Nama</th>
                            <th style="width: 5%; text-align: center; vertical-align: middle" rowspan="3">Usia</th>
                            <th style="text-align: center; width: 15%; vertical-align: middle" rowspan="3">Pendidikan Terakhir</th>
                            <th style="text-align: center;" colspan="4">Hasil Tes</th>
                            <th style="text-align: center; width: 5%; vertical-align: middle" rowspan="3">Total Skor</th>
                            <th style="text-align: center; width: 5%; vertical-align: middle" rowspan="3">Rank</th>
                        </tr>
                        <tr>
                            <th style="text-align: center;" colspan="2">Psikotes</th>
                            <th style="text-align: center;" colspan="2">Wawancara</th>
                        </tr>
                        <tr>
                            <th style="text-align: center; width: 5%;">Nilai</th>
                            <th style="text-align: center;  width: 15%">Keterangan</th>
                            <th style="text-align: center; width: 5%;">Nilai</th>
                            <th style="text-align: center;  width: 15%">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($nom=1)
                        @foreach ($result_rekap as $list)
                        @php($umur = App\Helpers\Hrdhelper::get_umur_karyawan($list->tanggal_lahir))
                        <tr>
                            <td style="text-align: center">{{ $nom }}</td>
                            <td><a href="{{ url(Storage::url("hrd/pelamar/photo/".$list->file_photo)) }}" data-fancybox data-caption="avatar">
                                <img src="{{ url(Storage::url("hrd/pelamar/photo/".$list->file_photo)) }}" style="width: 80px; height: auto" alt=""></a></td>
                            <td>{{ $list->nama_lengkap }}</td>
                            <td style="text-align: center">{{ $umur }}</td>
                            <td>{{ $list->get_pendidikan_akhir($list->id_jenjang) }}</td>
                            <td style="text-align: center">{{ $list->psikotes_nilai }}</td>
                            <td>{{ $list->psikotes_ket }}</td>
                            <td style="text-align: center">{{ $list->wawancara_nilai }}</td>
                            <td>{{ $list->wawancara_ket }}</td>
                            <td style="text-align: center">{{ $list->total_skor }}</td>
                            <td style="text-align: center">{{ $nom }}</td>
                        </tr>
                        @php($nom++)
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
