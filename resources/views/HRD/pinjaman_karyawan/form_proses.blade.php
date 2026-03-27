<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Proses Pembayaran Pinjaman Karyawan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <div class="iq-card-body" style="width:100%; height:auto">
        <div class="iq-card">
            <div class="row">
                <div class="col-sm-6 col-lg-6">
                    <ul class="list-group">
                        <li class="list-group-item disabled" aria-disabled="true">NIK : <b>{{ $data->getKaryawan->nik }}</b></li>
                        <li class="list-group-item">Nama Karyawan : <b>{{ $data->getKaryawan->nm_lengkap }}</b></li>
                        <li class="list-group-item">Jabatan : <b>{{ $data->getKaryawan->get_jabatan->nm_jabatan }}</b></li>
                        <li class="list-group-item">Departemen : <b>{{ $data->getKaryawan->get_departemen->nm_dept }}</b></li>
                    </ul>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <ul class="list-group">
                        <li class="list-group-item disabled" aria-disabled="true">Kategori Pinjaman : <b>{{ ($data->kategori==1) ? "Panjar Gaji" : "Pinjaman Kesejahteraan Karyawan (PKK)" }}</b></li>
                        <li class="list-group-item">Jumlah Pinjaman : <b>Rp. {{ number_format($data->nominal_apply, 0) }}</b></li>
                        <li class="list-group-item">Tenor : <b>{{ $data->tenor_apply }} Bulan</b></li>
                        <li class="list-group-item">Alasan Pengajuan : <b>{{ $data->alasan_pengajuan }}</b></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="iq-card">
            <div class="row">
                <div class="col-sm-6 col-lg-6">
                    <ul class="list-group">
                        <li class="list-group-item active">Riwayat Pembayaran</li>
                    </ul>
                    <table class="table" style="width: 100%">
                    <thead>
                        <th style="width: 5%">No.</th>
                        <th style="width: 20%">Tgl.Bayar</th>
                        <th style="width: 30%; text-align: right">Angsuran</th>
                        <th style="width: 30%; text-align: right">Oustanding</th>
                    </thead>
                    <tbody>
                        @php
                            $nom=1;
                            $sisa = $data->nominal_apply;
                        @endphp
                        @foreach ($list_pembayaran as $row)
                            @php $sisa-=$row->nominal @endphp
                            <tr>
                                <td>{{ $nom }}</td>
                                <td>{{ date('d-m-Y', strtotime($row->tanggal)) }}</td>
                                <td style="text-align: right">{{ number_format($row->nominal, 0) }}</td>
                                <td style="text-align: right">{{ number_format($sisa, 0) }}</td>
                            </tr>
                            @php $nom++; @endphp
                        @endforeach
                    </tbody>
                    </table>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <ul class="list-group">
                        <li class="list-group-item bg-dark" style="color: white">Form Pembayaran</li>
                    </ul>
                    <form action="{{ url('hrd/pinjaman_karyawan/prosesPembayaranStore') }}" method="post" enctype="multipart/form-data" onsubmit="return konfirm()">
                    {{ csrf_field() }}
                    <ul class="list-group">
                        <li class="list-group-item">
                            <input type="hidden" name="id_mutasi" id="id_mutasi">
                            <input type="hidden" name="id_head" id="id_head" value="{{ $data->id }}">
                            <input type="hidden" name="tmp_outstanding" id="tmp_outstanding" value="{{ $outstanding }}">
                            <div class="form-group row">
                                <label class="col-sm-6">Pembayaran Ke-</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="inpPembayaranKe" id="inpPembayaranKe" value="{{ $pembayaran_ke }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-6">Tanggal Bayar</label>
                                <div class="col-sm-6">
                                    <input type="date" class="form-control" name="inpTanggalBayar" id="inpTanggalBayar" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-6">Jumlah Bayar</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control angka" name="inpJumlahBayar" id="inpJumlahBayar" style="text-align: right" value="0" oninput="validasiOutstanding(this)" onblur="changeToNull(this)">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inpFileImage">Upload Bukti Pembayaran (* Jika Ada)</label>
                                <input type="file" class="form-control" name="inpFileImage" id="inpFileImage">
                            </div>
                        </li>
                    </ul>
                    <div class="row">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup Form</button>
                            <button type="submit" class="btn btn-primary" name="btn-submit" id="btn-submit" disabled>Simpan Pembayaran</button>
                        </div>
                    </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function()
    {
        $(".angka").number(true, 0);
    });

    // var getBayar = function(el)
    // {
    //     var id_mutasi = el.id;
    //     aktif(true);
    //     $.ajax({
    //         url: "{{ url('hrd/pinjaman_karyawan/getDataPembayaran')}}",
    //         type : 'post',
    //         headers : {
    //             'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
    //         },
    //         data : {id_mutasi:id_mutasi},
    //         success : function(res)
    //         {
    //             $("#inpJumlahBayar").val(res.nominal);
    //             $("#id_mutasi").val(res.id_data);
    //             aktif(false);
    //         }
    //     });
    // }

    var changeToNull = function(el)
    {

        if($(el).val()=="")
        {
            $(el).val("0");
        }
    }

    var validasiOutstanding = function(el)
    {
        var outs = $("#tmp_outstanding").val();
        var byr = $(el).val();
        $("#btn-submit").attr("disabled", false);
        if(parseFloat(byr)==0 || byr=="")
        {
            $("#btn-submit").attr("disabled", true);
            return false;
        }
        if( (parseFloat(byr)) > (parseFloat(outs)) ) {
            $("#btn-submit").attr("disabled", true);
            return false;
        }
    }

    function aktif(tf)
    {
        $("#inpTanggalBayar").attr("disabled", tf)
        $("#inpFileImage").attr("disabled", tf)
        $("#btn-submit").attr("disabled", tf)
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
