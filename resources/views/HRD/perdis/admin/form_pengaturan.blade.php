<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Pengaturan Perjalanan Dinas</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<form action="{{ url('hrd/perjalanandinas/pengaturanPerdisStore') }}" method="post" id="myForm">
{{ csrf_field() }}
<input type="hidden" name="id_perdis" value="{{ $profil->id }}">
<div class="modal-body">
    <div class="iq-card">
        <div class="row">
            <div class="col-sm-6 col-lg-6">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                       <h4 class="card-title">Profil Karyawan</h4>
                    </div>
                 </div>
                 <div class="iq-card-body">
                    <ul class="list-group">
                       <li class="list-group-item disabled" aria-disabled="true">NIK : {{ $profil->get_profil->nik }}</li>
                       <li class="list-group-item">Nama Karyawan : {{ $profil->get_profil->nm_lengkap }}</li>
                       <li class="list-group-item">Jabatan : {{ $profil->get_profil->get_jabatan->nm_jabatan }}</li>
                       <li class="list-group-item">Departemen : {{ $profil->get_profil->get_departemen->nm_dept }}</li>
                    </ul>
                 </div>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                       <h4 class="card-title">Data Pengajuan</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    <ul class="list-group">
                        <li class="list-group-item disabled" aria-disabled="true">Tanggal Pengajuan : {{ date_format(date_create($profil->tgl_perdis), 'd-m-Y') }}</li>
                        <li class="list-group-item">Maksud dan Tujuan : {{ $profil->maksud_tujuan }}</li>
                        <li class="list-group-item">Tanggal Berangkat : {{ date('d-m-Y', strtotime($profil->tgl_berangkat)) }} s/d {{ date('d-m-Y', strtotime($profil->tgl_kembali)) }}</li>
                        <li class="list-group-item">Tujuan : {{ $profil->tujuan }}</li>
                     </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5 col-lg-12">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                       <h4 class="card-title">Pengaturan Rincian Biaya Perjalanan Dinas</h4>
                    </div>
                 </div>
                 <div class="iq-card-body">
                    <div class="container-fluid">
                        <table class="table list_item_1" style="width: 100%; height: auto">
                            <tr>
                                <td colspan="4"><select class="form-control select2" id="pil_fasilitas" name="pil_fasilitas" style="width: 100%;" data-placeholder="- Pilihan" required>
                                    @foreach ($list_fasilitas as $fas)
                                    <option disabled selected></option>
                                    <option value="{{ $fas->id }}">{{ $fas->nm_fasilitas }}</option>
                                    @endforeach
                                </select></td>
                                <td><button onclick="addButton(this)" type="button" class="btn btn-primary btn-square waves-effect waves-light"><i class="fa fa-plus"></i></button></td>
                            </tr>
                            <tr style="background-color: rgb(72, 152, 244); color: white">
                              <td colspan="4" style="width: 95%">Rincian Biaya</td>
                              <td></td>
                            </tr>
                            <tr>
                                <td style="width: ">Item</td>
                                <td style="width: 10%; text-align:center">Hari</td>
                                <td style="width: 15%; text-align:right">Biaya</td>
                                <td style="width: 20%; text-align:right">Sub Total</td>
                                <td style="width: 5%"></td>
                            </tr>
                            @php $total=0 @endphp
                            @foreach ($fasilitas as $list)
                            <tr>
                                <td><input type='hidden' name="id_data[]" id='id_data' value='{{ $list->id }}'><input type='hidden' name="id_fasilitas[]" id='id_fasilitas' value='{{ $list->id_fasilitas }}'>- {{ $list->get_master_fasilitas_perdis->nm_fasilitas }}</td>
                                <td><input type='text' class='form-control angka' name='inp_hari[]' id='inp_hari[]' value='{{ $list->hari }}' style='text-align:center' maxlength='3' onkeyup="hitungSubTotal(this)" onblur="changeToNull(this)"></td>
                                <td><input type='text' class='form-control angka' name='inp_biaya[]' id='inp_biaya[]' value='{{ $list->biaya }}' style='text-align:right' onkeyup="hitungSubTotal(this)" onblur="changeToNull(this)"></td>
                                <td><input type='text' class='form-control angka' name='inp_sub_total[]' id='inp_sub_total[]' value='{{ $list->sub_total }}' style='text-align:right' readonly></td>
                                <td><button type="button" title="Hapus Baris" class="btn btn-danger btn-sm waves-effect waves-light" onclick="delete_item(this)"><i class="fa fa-minus"></i></button></td>
                            </tr>
                            @php $total+=$list->sub_total @endphp
                            @endforeach
                        </table>
                        <table class="table" style="width: 100%; height: auto">
                            <tr>
                                <td style="text-align:right">Total</td>
                                <td style="width: 20%"><input type="text" id="inp_total" name="inp_total" value="{{ $total }}" class="form-control angka" style="text-align: right; font-size: 13pt" readonly></td>
                                <td style="width: 5%"></td>
                            </tr>
                        </table>
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
        $(".select2").select2({
            allowClear: true,
        });
        $(".angka").number(true, 0);
    });
    var addButton = function(){
        let id_select = $("#pil_fasilitas").val();
        let item_select = $("#pil_fasilitas option:selected").text();
       if(id_select != null) {
        let content = `<tr>
                <td><input type='hidden' name="id_data[]" id='id_data[]' value='0'><input type='hidden' name="id_fasilitas[]" id='id_fasilitas' value='`+id_select+`'>- `+item_select+`</td>
                <td><input type='text' class='form-control angka' name='inp_hari[]' id='inp_hari[]' value='`+{{ $jumlah_hari }}+`' style='text-align:center' maxlength='3' onkeyup="hitungSubTotal(this)" onblur="changeToNull(this)"></td>
                <td><input type='text' class='form-control angka' name='inp_biaya[]' id='inp_biaya[]' value='0' style='text-align:right' onkeyup="hitungSubTotal(this)" onblur="changeToNull(this)"></td>
                <td><input type='text' class='form-control angka' name='inp_sub_total[]' id='inp_sub_total[]' value='0' style='text-align:right' readonly></td>
                <td><button type="button" title="Hapus Baris" class="btn btn-danger btn-sm waves-effect waves-light" onclick="delete_item(this)"><i class="fa fa-minus"></i></button></td>
            </tr>`;
        $(".list_item_1").append(content);
        $(".angka").number(true, 0);
       }
    }
    var delete_item = function(el){
        var currentRow=$(el).closest("tr");
        var id_data = currentRow.find('td:eq(0) input[name="id_data[]"]').val();
        if(id_data==0)
        {
            $(el).parent().parent().slideUp(100,function(){
                $(this).remove();
                total();
            });
        } else {
            $.ajax({
                url: "{{ url('hrd/perjalanandinas/pengaturanPerdisDeleteFasilitas')}}",
                type : "post",
                headers : {
                    'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
                },
                data : {id_data:id_data},
                success : function(d)
                {
                    alert(d);
                    $(el).parent().parent().slideUp(100,function(){
                        $(this).remove();
                        total();
                    });
                }
            });
        }
    }

    var changeToNull = function(el)
    {
        if($(el).val()=="" || $(el).val()=="0")
        {
            $(el).val("1");
        }
    }

    var hitungSubTotal = function(el){
        var currentRow=$(el).closest("tr");
        var jumlah = currentRow.find('td:eq(1) input[name="inp_hari[]"]').val();
        var biaya = currentRow.find('td:eq(2) input[name="inp_biaya[]"]').val();
        var sub_total = parseFloat(biaya) * parseFloat(jumlah);
        currentRow.find('td:eq(3) input[name="inp_sub_total[]"]').val(sub_total);
        total();
    }

    var total = function(){
        var total = 0;
        var sub_total = 0;
        $.each($('input[name="inp_sub_total[]"]'),function(key, value){
            sub_total = $(value).val() ?  $(value).val() : 0;
            total += parseFloat($(value).val());
        })

        $('input[name="inp_total"]').val(total);
    }

    document.querySelector('#myForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting

        Swal.fire({
            title: 'Are you sure?',
            text: "Submit this application!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user confirms, submit the form
                this.submit();
            }
        });
    });
</script>
