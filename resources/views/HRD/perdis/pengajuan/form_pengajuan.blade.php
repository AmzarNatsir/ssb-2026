<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Pengajuan Perjalanan Dinas</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<form action="{{ url('hrd/perjalanandinas/storepengajuan') }}" method="post" id="myForm">
{{ csrf_field() }}
<div class="modal-body">
    <div class="iq-card iq-card-block iq-card-stretch">
        <div class="iq-card-body">
            <div class=" row align-items-center">
                <div class="form-group col-sm-12">
                    <label for="pil_karyawan">Pilih karyawan yang akan diperintahkan melakukan perjalanan dinas : <span class="text-danger">*</span></label>
                    <select class="form-control select2" id="pil_karyawan" name="pil_karyawan" style="width: 100%;" data-placeholder="Pilih Karyawan" required>
                        <option value=""></option>
                        @foreach($list_karyawan as $list)
                        <option value="{{ $list->id }}">{{ $list->nik." - ".$list->nm_lengkap }} ({{ $list->get_jabatan->nm_jabatan }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Tujuan/Lokasi</label>
                <div class="col-sm-8">
                    <input type="text" name="inp_tujuan" id="inp_tujuan" class="form-control" maxlength="200" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Alasan</label>
                <div class="col-sm-8">
                    <textarea class="form-control" name="inp_maksud_tujuan" id="inp_maksud_tujuan" required></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Tanggal Pelaksanaan</label>
                <div class="col-sm-8">
                    <input type="text" name="tgl_berangkat" id="tgl_berangkat" class="form-control datepicker" required>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Submit</button>
</div>
</form>
<script type="text/javascript">
    $(document).ready(function()
    {
        $(".select2").select2({
            allowClear: true
        });
        // $(".datepicker").datepicker({
        //     format: 'dd/mm/yyyy',
        //     orientation : "button right",
        //     todayHighlight: true
        // });

        $('#tgl_berangkat').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY',
            },
            startDate: "{{ date('d/m/Y') }}",
            endDate: "{{ date('d/m/Y') }}"
        }, function(start, end, label) {
            console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
        });

    });
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
