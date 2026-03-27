<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Pengajuan Pelatihan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <form action="{{ url('hrd/pelatihan/simpandiklat') }}" method="post" id="myForm">
    {{ csrf_field() }}
    <div class="iq-card-body" style="width:100%; height:auto">
        <div class="iq-card">
            <div class="card-body">
                <div class="row" style="text-align: center">
                    {{-- <div class="col-lg-12 d-flex justify-content-md-between"> --}}
                        <div class="btn-group ml-2 bg-white" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-outline-success active px-5" onclick="goInternal()">Internal</button>
                            <button type="button" class="btn btn-outline-primary active px-5" onclick="goEkternal()">Eksternal</button>
                        </div>
                    {{-- </div> --}}
                </div>
            </div>
        </div>
        <div class="form-pengajuan">
            <div id="spinner-div-add" class="pt-5 justify-content-center spinner-div" style="text-align: center">
                <div class="spinner-border text-primary" role="status"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup Form</button>
        <button type="submit" class="btn btn-primary" name="btn-submit" id="btn-submit">Simpan Pengajuan</button>
    </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#spinner-div-add').hide();
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".select2").select2();
        $(".jamClass").mask("99:99");
    });
    var goInternal = function()
    {
        $('#spinner-div-add').show();
        $(".form-pengajuan").load("{{ url('hrd/pelatihan/goFormInternal')}}", function(){
            $('#spinner-div-add').hide();
            $('.dateRangePicker').daterangepicker({
                "startDate": "{{ date('d-m-Y')}}",
                "locale": {
                    "format": 'DD/MM/YYYY'
                }
            });
            $(".angka").number(true, 0);
            $(".select2").select2();
        });
    }
    var goEkternal = function()
    {
        $('#spinner-div-add').show();
        $(".form-pengajuan").load("{{ url('hrd/pelatihan/goFormEksternal')}}", function(){
            $('#spinner-div-add').hide();
            $('.dateRangePicker').daterangepicker({
                "startDate": "{{ date('d-m-Y')}}",
                "locale": {
                    "format": 'DD/MM/YYYY'
                }
            });
            $(".angka").number(true, 0);
        });
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
