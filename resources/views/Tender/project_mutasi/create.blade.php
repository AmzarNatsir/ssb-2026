@extends('Tender.layouts.master')
@section('content')
<div class="row">
  <x-reusable.breadcrumb :list="$breadcrumb" />
</div>
<div class="iq-card">
  <div class="iq-card-body" style="padding:1.5rem 3rem;">
    <div class="row">
      <div class="col-sm-8">
        <h4 class="card-title text-primary">
          <span class="ri-chat-check-line pr-2"></span>Form Pengajuan Mutasi
        </h4>
      </div>
      <div class="col-sm-4 text-right"></div>
    </div>
    <hr/>
    {{-- Toast --}}
      <div id="snackbar" class="alert text-white d-none {{ (\Session::has('danger') ? 'bg-danger' : 'bg-success') }}" role="alert" style="position:absolute;top:5%;right:25;z-index:2000;">
        <div id="snackbar_message" class="iq-alert-text">
          @if (\Session::has('danger'))
          {{ trim(\Session::get('danger')) }}
          @elseif(\Session::has('success'))
          {{ trim(\Session::get('success')) }}
          @endif
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <i class="ri-close-line"></i>
        </button>
      </div>
     {{-- end Toast --}}
    <form id="form-pengajuan-mutasi" name="form-pengajuan-mutasi" method="post" enctype="multipart/form-data" autocomplete="off" action="{{ route('project.mutasi.save') }}">
      @csrf
      <div class="row mt-4 ml-2 mb-4 d-flex">
        <div class="col-3">
          <div class="form-group pr-2 with-validation">
            <label class="font-weight-bold">Pilih Project</label>
            <select id="project" name="project" class="form-control mb-0" style="border-right: 15px transparent solid;border-bottom: 15px;">
              <option value=""></option>
              @if(isset($activeProjects))
                @foreach ($activeProjects as $project)
                <option value="{{ $project->id }}">{{ $project->number." ( ".$project->name." )" }} </option>
                @endforeach
              @endif
            </select>
            <div class="invalid-feedback"></div>
          </div>
        </div>
      </div>
      <div class="row mt-4 ml-2 mb-4 d-flex">
        <div class="col-3">
          <div class="form-group pr-2 with-validation">
            <label class="font-weight-bold">Pilih Karyawan</label>
            <select id="employee" name="employee" class="form-control mb-0" style="border-right: 15px transparent solid;border-bottom: 15px;">
              <option value=""></option>
              @if(isset($employees))
                @foreach ($employees as $value)
                  <option value="{{ $value->id }}">{{ strtoupper($value->nik)." - ".strtoupper($value->nm_lengkap) }}</option>
                @endforeach
              @endif
            </select>
            <div class="invalid-feedback"></div>
          </div>
        </div>
      </div>
      <div class="row mt-0 ml-2 mb-4 d-flex">
        <div class="col-3">
          <div class="form-group pr-2 with-validation">
            <label class="font-weight-bold">Departemen Baru</label>
            <select id="department" name="department" class="form-control mb-0" style="border-right: 15px transparent solid;border-bottom: 15px;">
              <option value=""></option>
              @if(isset($department))
                @foreach ($department as $value)
                  <option value="{{ $value->id }}">{{ strtoupper($value->nm_dept) }}</option>
                @endforeach
              @endif
            </select>
            <div class="invalid-feedback"></div>
          </div>
        </div>
      </div>
      <div class="row mt-0 ml-2 mb-4 d-flex">
        <div class="col-3">
          <div class="form-group pr-2 with-validation">
            <label class="font-weight-bold">Jabatan Baru</label>
            <select id="jabatan" name="jabatan" class="form-control mb-0" style="border-right: 15px transparent solid;border-bottom: 15px;">
              <option value=""></option>
              @if(isset($jabatan))
                @foreach ($jabatan as $value)
                  <option value="{{ $value->id }}">{{ strtoupper($value->nm_jabatan) }}</option>
                @endforeach
              @endif
            </select>
            <div class="invalid-feedback"></div>
          </div>
        </div>
      </div>
      <div class="row mt-0 ml-2 mb-4 d-flex">
        <div class="col-3">
          <div class="form-group pr-2 with-validation">
            <label class="font-weight-bold">Tanggal Efektif</label>
            <input type="date" id="eff_date" name="eff_date" class="form-control" />
            <div class="invalid-feedback"></div>
          </div>
        </div>
      </div>

      <div class="row mt-0 ml-2 mb-4 d-flex">
        <div class="col-4">
          <div class="form-group pr-2">
            <label class="font-weight-bold">Keterangan</label>
            <textarea id="ketera" name="ketera" class="form-control"></textarea>
          </div>
        </div>
      </div>

      <div class="row mt-0 ml-2 mb-4 d-flex">
        <div class="col-4">
          <div class="form-group pr-2">
            <button id='btn-save-form' name='btn-save-form' type='button' class='btn btn-lg btn-block btn-primary'>Simpan</button>
          </div>
        </div>
      </div>

    </form>

  </div>
</div>
@endsection
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script type="text/javascript">
  $(function(){

    $("#eff_date").val(moment().format('YYYY-MM-DD'));
    $("#eff_date").attr("min", moment().format('YYYY-MM-DD'));

    // Validations
    function formValidationArea(selector, message) {
          selector.addClass("is-invalid");
          selector
              .closest("div.with-validation")
              .find(".invalid-feedback")
              .html(message);
        }

        function beforeValidate() {
          $("input, select").removeClass("is-invalid");
          $("div").removeClass("is-invalid");
          $("div").find(".invalid-feedback").empty();
        }

        function doesntHasValidationError() {
          return (
              !$("input").hasClass("is-invalid") && !$("div").hasClass("is-invalid") && !$("select").hasClass("is-invalid")
          );
        }

        function validateForm()
        {
          let project = $("#project"),
              employee = $("#employee"),
              department = $("#department"),
              jabatan = $("#jabatan"),
              eff_date = $("#eff_date");

              if(project.val() == ""){
                formValidationArea(project, "belum memilih project");
              }

              if(employee.val() == ""){
                formValidationArea(employee, "belum memilih karyawan");
              }

              if(department.val().length < 1){
                formValidationArea(department, "belum memilih departemen baru");
              }

              if(jabatan.val() == ""){
                formValidationArea(jabatan, "belum memilih jabatan baru");
              }

              if(eff_date.val() == ""){
                formValidationArea(eff_date, "belum memilih Tanggal Efektif mutasi");
              }
        }
        // End Validations

        $(document).on('click', "#btn-save-form", function(evt){
          evt.preventDefault();
          beforeValidate();
          validateForm();
          if (doesntHasValidationError()) {
            $("#form-pengajuan-mutasi").submit();
          }
        });


  })
</script>
