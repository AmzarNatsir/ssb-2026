<div class="row">
    @foreach ($list_pengajuan as $list)
    <div class="col-lg-6 col-md-12">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-body">
               <div class="bg-cobalt-blue p-3 rounded d-flex align-items-center justify-content-between mb-3">
                  <h5 class="text-white">{{ $list->get_jabatan->nm_jabatan }} </h5>
                  <div class="rounded-circle iq-card-icon bg-white">
                     <i class="ri-quill-pen-line text-cobalt-blue"></i>
                  </div>
                </div>
                <h4 class="mb-2">{{ $list->alasan_permintaan }}</h4>
                <table style="width: 100%">
                    <tr>
                        <td><h6 class="mb-0"><i class="fa fa-calendar"></i>  Dibutuhkan tanggal : {{ date('d-m-Y', strtotime($list->tanggal_dibutuhkan)) }}</h6></td>
                    </tr>
                    <tr>
                        <td><h6 class="mb-0"><i class="fa fa-user"></i> Jumlah Aplikasi : {{ $list->jumlah_orang }} Pelamar</h6></td>
                    </tr>
                </table>
                <hr>
                <div class="mt-3" style="text-align: right">
                    <button type="button" name="tbl_rekap" class="btn btn-success" data-toggle="modal" data-target="#ModalForm" value="{{ $list->id }}" onclick="goRekap(this)"><i class="fa fa-table"></i> Rekapitulasi Hasil Tes</button>
                    <a href="{{ url('hrd/recruitment/aplikasi_pelamar/profil/'.App\Helpers\Hrdhelper::encrypt_decrypt('encrypt', $list->id)) }}" class="btn btn-primary" target="_new"><i class="fa fa-plus"></i> Aplikasi Baru</a>
                </div>
             </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
