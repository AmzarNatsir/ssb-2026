@extends('HRD.layouts.master')
@section('content')
<style>
    .select2-container .select2-selection--single {
        height: 40px !important; /* Adjust the height */
        display: flex;
        align-items: center; /* Center text vertically */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 38px !important; /* Match line-height to height for alignment */
    }

    .select2-container--default .select2-selection--multiple {
        min-height: 40px !important; /* For multi-select dropdowns */
    }
</style>
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item" aria-current="page">Setup</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/setup/matriks_persetujuan') }}">Matriks Persetujuan</a></li>
        <li class="breadcrumb-item active">Pengaturan Matriks Persetujuan</li>
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
    <div class="col-sm-12 col-lg-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Pengaturan Matriks Persetujuan</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <form id="formAdd" method="post">
                @csrf
                <input type="hidden" name="id_group" id="id_group" value="{{ $group->id }}">
                <div class=" row align-items-center">
                    <div class="form-group col-sm-6">
                        <label for="inp_group">Group Persetujuan</label>
                        <input type="text" class="form-control" id="inp_group" name="inp_group" value="{{ $group->ref_group }}" readonly>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="inp_group">Pilih Departemen</label>
                        <select class="select2 form-control mb-3" id="pil_departemen" name="pil_departemen" onchange="getFormAdd(this)" required>
                            <option selected="" disabled="" value="">Pilihan...</option>
                            @foreach($list_departemen as $r)
                            <option value="{{ $r->id }}">{{ $r->nm_dept }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="iq-card-body">
                    <div class=" row align-items-center" id="view_form_add"></div>
                </div>
                </form>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $(".select2").select2({
            width: '100%',
            placeholder: "Pilihan",
            allowClear: true,
        });
    });
    var getFormAdd = function(el)
    {
        let id_group = $("#id_group").val();
        let id_departemen = $(el).val();
        $("#view_form_add").load("{{ url('hrd/setup/matriks_persetujuan_setup_load_form') }}/"+id_group+"/"+id_departemen, function(){
            $(".select2").select2({
                width: '100%',
                placeholder: "Pilihan",
                allowClear: true,
            });
        });
    }
    var addButton = function(el)
    {
        // el.preventDefault();
        let id_group = $("#id_group").val();
        let level = $("#inpLevel").val();
        let id_pejabat = $("#pil_pejabat").val();
        let id_departemen = $("#pil_departemen").val();
        let token   = $("meta[name='csrf-token']").attr("content");
        if(id_departemen==null)
        {
            Swal.fire("Warning", "Kolom pilihan departemen masih kosong!", "warning");
            return false;
        } else if(id_pejabat==null) {
            Swal.fire("Warning", "Kolom pilihan pejabat masih kosong!", "warning");
            return false;
        } else {
            $.ajax({
                url: `{{ url('hrd/setup/matriks_persetujuan_setup_store') }}`,
                type: "POST",
                cache: false,
                headers : {
                    'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
                },
                data: {
                    "id_group": id_group,
                    "level": level,
                    "id_pejabat": id_pejabat,
                    "id_departemen": id_departemen,
                    "_token": token
                },
                success:function(response){
                    //show success message
                    if (response.success==true) {
                        Swal.fire({
                            type: 'success',
                            icon: 'success',
                            title: `${response.message}`,
                            showConfirmButton: false,
                            timer: 3000
                        });
                        location.replace("{{ url('hrd/setup/matriks_persetujuan_setup') }}/"+id_group);
                    } else {
                        Swal.fire({
                            type: 'error',
                            icon: 'error',
                            title: `${response.message}`,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                },
                error:function(error){
                    console.log(error.responseText); // Debugging errors
                    Swal.fire("It's danger", "Something went wrong!", "error");
                }
            });
        }
    }

   var goDelete = function(el)
   {
        let id_group = $("#id_group").val();
        var psn = confirm("Yakin akan menghapus data ?")
        if(psn==true)
        {
            $.ajax({
                    url: "{{ url('hrd/setup/matriks_persetujuan_setup_delete') }}/"+$(el).val(),
                    type: "GET",
                    success:function(response){
                        if(response.success==true) {
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000
                            });
                            location.replace("{{ url('hrd/setup/matriks_persetujuan_setup') }}/"+id_group);
                        } else {
                            Swal.fire(response.message, {
                                icon: 'warning',
                            });
                        }
                    }
                });
            return true;
        } else {
            return false;
        }
   }

</script>
@endsection
