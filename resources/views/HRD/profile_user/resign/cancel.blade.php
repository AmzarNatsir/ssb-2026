<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Detail Pengajuan Resign</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <form action="{{ url('hrd/dataku/pengajuanResignCancel/'.$data->id) }}" method="post" id="myForm">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="iq-card-body">
        <div class="form-group">
            <label for="inp_alasan">Alasan pengajuan pengunduran diri anda</label>
            <textarea class="form-control" name="inp_alasan" id="inp_alasan" readonly>{{ $data->alasan_resign }}</textarea>
        </div>
        <div class="form-group">
            <div class="alert text-white bg-danger" role="alert">
                <div class="iq-alert-icon"><i class="ri-alert-line"></i></div>
                <div class="id-alert-text">Pengajuan pengunduran diri dibuat 30 hari sebelum pengunduran diri</div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger btn-save">Batalkan Pengajuan</button>
    </div>
    </form>
</div>

<script type="text/javascript">
    document.querySelector('#myForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting

        Swal.fire({
            title: 'Are you sure?',
            text: "Cancel this application!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, cancel it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user confirms, submit the form
                this.submit();
            }
        });
    });
</script>
