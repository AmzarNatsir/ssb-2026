@extends('HRD.layouts.master')
@section('content')
<style>
    .spinner-div {
    position: absolute;
    display: none;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    text-align: center;
    background-color: rgba(255, 255, 255, 0.8);
    z-index: 2;
    }
</style>
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Setup | Norma Psikotest</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/setup/norma_psikotest') }}">Refresh (F5)</a></li>
        </ul>
    </nav>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-12">
        @if(\Session::has('konfirm'))
            <div class="alert text-white bg-success" role="alert" id="success-alert">
                <div class="iq-alert-icon">
                    <i class="ri-alert-line"></i>
                </div>
                <div class="iq-alert-text">{{ \Session::get('konfirm') }}</div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="ri-close-line"></i>
                </button>
            </div>
        @endif
    </div>
</div>
<div class="row">
    <div class="col-lg-5">
        <div class="iq-card" id="page_view">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Input Data Baru</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <form action="{{ url('hrd/setup/norma_psikotest/simpan') }}" method="post" id="myForm">
                {{ csrf_field() }}
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label>Skor Min</label>
                            <input type="text" name="inp_skor_min" id="inp_skor_min" class="form-control angka" required>
                        </div>
                        <div class="col-sm-3">
                            <label>Skor Maks</label>
                            <input type="text" name="inp_skor_maks" id="inp_skor_maks" class="form-control angka" required>
                        </div>
                        <div class="col-sm-6">
                            <label>Hasil Tes</label>
                            <input type="text" name="inp_hasil" id="inp_hasil" class="form-control" maxlength="20" required>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" id="tbl_simpan" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-7">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Daftar Norma Psikotest</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <table class="table" style="width: 100%;">
                    <thead>
                        <th style="width: 5%;">No.</th>
                        <th style="width: 20%;">Total Skor</th>
                        <th>Hasil Tes</th>
                        <th style="width: 20%;">Aksi</th>
                    </thead>
                    <tbody>
                        @php($nom=1)
                        @foreach ($list_norma as $list)
                        <tr>
                            <td>{{ $nom }}</td>
                            <td>{{ $list->skor_min }} - {{ $list->skor_maks }}</td>
                            <td>{{ $list->hasil }}</td>
                            <td>
                                <button type="button" class="btn btn-primary mb-2 btn_edit" id="{{ $list->id }}"><i class="ri-edit-fill pr-0"></i></button>
                                <a href="{{ url('hrd/setup/norma_psikotest/hapus/'.$list->id) }}" class="btn btn-danger mb-2" onClick="return hapusKonfirm()"><i class="ri-delete-bin-line pr-0"></i></a>
                            </td>
                        </tr>
                        @php($nom++)
                        @endforeach
                    </tbody>
                    </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#spinner-div').hide();
        $(".angka").number(true, 1);
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        $(".btn_edit").on("click", function()
        {
            var id_data = this.id;
            $("#page_view").load("{{ url('hrd/setup/norma_psikotest/edit') }}/"+id_data, function(){
                $(".angka").number(true, 1);
            });
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
    function hapusKonfirm()
    {
        var psn = confirm("Yakin akan menghapus data ?")
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
</script>
@endsection
