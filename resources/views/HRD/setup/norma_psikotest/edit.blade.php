<div class="iq-card-header d-flex justify-content-between">
    <div class="iq-header-title">
        <h4 class="card-title">Edit Data</h4>
    </div>
</div>
<div class="iq-card-body" style="width:100%; height:auto">
    <form action="{{ url('hrd/setup/norma_psikotest/update/'.$data->id) }}" method="post" id="myForm">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
        <div class="form-group row">
            <div class="col-sm-3">
                <label>Skor Min</label>
                <input type="text" name="inp_skor_min" id="inp_skor_min" class="form-control angka" value="{{ $data->skor_min }}" required>
            </div>
            <div class="col-sm-3">
                <label>Skor Maks</label>
                <input type="text" name="inp_skor_maks" id="inp_skor_maks" class="form-control angka" value="{{ $data->skor_maks }}" required>
            </div>
            <div class="col-sm-6">
                <label>Hasil Tes</label>
                <input type="text" name="inp_hasil" id="inp_hasil" class="form-control" value="{{ $data->hasil }}" maxlength="20" required>
            </div>
        </div>
        <hr>
        <button type="submit" id="tbl_simpan" class="btn btn-primary">Submit</button>
        <hr>
    </form>
</div>
<script type="text/javascript">
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
