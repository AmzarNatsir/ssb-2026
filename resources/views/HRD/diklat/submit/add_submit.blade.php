<div class="iq-card">
    <div class="iq-card-header d-flex justify-content-between btn-outline-dark active">
        <div class="iq-header-title">
            <h4 class="card-title" style="color: white"><i class="fa fa-send"></i> Submit Pengajuan Pelatihan</h4>
        </div>
    </div>
    <div class="card-body">
        <form id="form_submit_pengajuan" action="{{ url('hrd/pelatihan/submitPengajuan') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group row">
            <label class="col-sm-4">Periode Pelatihan</label>
            <div class="col-sm-8">
                <select class="form-control select2" name="inpPeriode" id="inpPeriode" style="width: 100%;" required>
                    <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4">Deskripsi pengajuan pelatihan</label>
            <div class="col-sm-8">
                <textarea name="inpDeskripsiPengajuan" id="inpDeskripsiPengajuan" class="form-control" required></textarea>
            </div>
        </div>
        <div class="iq-card-header d-flex">
            <div class="iq-header-title">
                <h4 class="card-title"><i class="fa fa-table"></i> List Pelatihan Yang Diajukan</h4>
            </div>
        </div>
        <table class="table table-hover datatable" style="width:100%; font-size: 13px;">
            <thead>
                <tr>
                    <th style="text-align: center">#</th>
                    <th style="text-align: center">Act</th>
                    <th style="width: 8%;">Kategori</th>
                    <th style="width: 20%;">Nama Pelatihan</th>
                    <th style="width: 20%">Institusi&nbsp;Penyelenggara</th>
                    <th style="text-align: center">Pelaksanaan</th>
                    <th style="text-align: center">Durasi</th>
                    <th style="width: 10%; text-align: center">Biaya&nbsp;Investasi</th>
                    <th style="text-align: center">Peserta</th>
                    <th style="text-align: center">Detail</th>
                </tr>
            </thead>
            <tbody>
                @php $nom=1; $total=0 @endphp
                @foreach ($all_pengajuan as $item)
                    @php
                        $nama_pelatihan = ($item->kategori=='Internal') ? $item->get_nama_pelatihan->nama_pelatihan : $item->nama_pelatihan;
                        $nama_vendor = ($item->kategori=='Internal') ? $item->get_pelaksana->nama_lembaga : $item->nama_vendor;

                    @endphp
                    <tr>
                        <td>{{ $nom }}</td>
                        <td style="text-align: center">
                            <div class="custom-control custom-checkbox">
                                @if(count($item->get_peserta) > 0)
                                <input type="checkbox" class="custom-control" name="checkPengajuan[]" id="{{ $nom }}" value="{{ $item->id }}">
                                <input type="hidden" name="id_head[]" value="{{ $item->id }}">
                                @endif
                            </div>
                        </td>
                        <td><div class="badge badge-pill {{ ($item->kategori=='Internal') ? "badge-dark" : "badge-danger" }}">{{ $item->kategori }}</div></td>
                        <td>{{ $nama_pelatihan }}</td>
                        <td>{{ $nama_vendor }}</td>
                        <td>{{ App\Helpers\Hrdhelper::get_tanggal_pelaksanaan($item->tanggal_awal, $item->tanggal_sampai, NULL, NULL) }}</td>
                        <td>{{ $item->durasi }}</td>
                        <td style="text-align:right">{{ number_format($item->investasi_per_orang, 0, ",", ".") }}</td>
                        <td>{{ count($item->get_peserta) }} Orang</td>
                        <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalForm" onclick="goDetail(this)" id="{{ $item->id }}"><i class="fa fa-eye"></i></button></td>
                    </tr>
                    @php $nom++; $total+=$item->investasi_per_orang; @endphp
                @endforeach
                <tr>
                    <td colspan="7" class="text-right">TOTAL BIAYA PELATIHAN</td>
                    <td style="text-align:right">{{ number_format($total, 0, ",", ".") }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <div class="modal-footer">
            <button type="submit" class="btn btn-warning" name="btn-submit" id="btn-submit">Submit Pengajuan</button>
        </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        // $("#bform_submit_pengajuan").on("submit", function(el) {
        //     el.preventDefault();
        //     let formData = new FormData(this);
        //     var psn = confirm("Yakin data akan disimpan ?");
        //     if(psn==true)
        //     {
        //         $.ajax({
        //             headers: {
        //                 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             type: "POST",
        //             url: "{{ url('hrd/pelatihan/submitPengajuan') }}",
        //             data: formData,
        //             dataType: false,
        //             processData: false,
        //             // success: function(response) {
        //             //     console.log(response);
        //             // }
        //         }).done(function(data) {
		// 			console.log(data);
		// 		});;
        //     } else {
        //         return false;
        //     }


        // })
    });
    // function konfirm()
    // {
    //     var psn = confirm("Yakin data akan disimpan ?");
    //     if(psn==true)
    //     {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }
</script>
