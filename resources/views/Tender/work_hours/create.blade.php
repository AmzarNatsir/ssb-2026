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
          <span class="ri-chat-check-line pr-2"></span>Entry Jam Kerja
        </h4>
      </div>
      <div class="col-sm-4 text-right"></div>
    </div>
    <div class="row mt-4 ml-4 mb-0 d-flex">
      <form id="form-work-hour" name="form-work-hour" method="post" enctype="multipart/form-data" autocomplete="off" action="{{ route('lho.save') }}">
       @csrf       
        <div class="form-row">
          <div class="form-group pr-2 with-validation">
            <label class="font-weight-bold">Project</label>
            <select id="project" name="project" class="form-control mb-0" style="border-right: 15px transparent solid;border-bottom: 15px;">
              @if(isset($activeProjects))
                <option value=""></option>
                @foreach ($activeProjects as $project)
                  <option value="{{ $project->id }}">{{ $project->number." ( ".$project->name." )" }} </option>                  
                @endforeach
              @endif
            </select>
            <div class="invalid-feedback"></div>                    
          </div>
        </div>
        <div class="row mt-0 ml-0 d-flex">
          <div class="form-group pr-2">
            <label class="font-weight-bold">Equipment</label>
            <hr/>
          </div>
        </div>
        <div class="row mt-0 ml-0 d-flex">
          <div class="form-group pr-2">
            <label class="font-weight-bold">Kategori</label>
            <select id="equipment_category" name="equipment_category" class="form-control mb-0" style="border-right: 15px transparent solid;border-bottom: 15px;">
              @if(isset($equipmentCategory))
                <option value=""></option>
                @foreach ($equipmentCategory as $category)
                  <option value="{{ $category->id }}">{{ strtoupper($category->name) }}</option>                  
                @endforeach
              @endif
            </select>                    
          </div>
          <div class="form-group pr-2 with-validation">            
            <label class="font-weight-bold">Equipment</label>
            <select id="equipment" name="equipment" class="form-control mb-0" style="border-right: 15px transparent solid;border-bottom: 15px;">
              <option value=""></option>
            </select>
            <div class="invalid-feedback"></div>
          </div>
        </div>      
    </div>
    <div class="row mt-0 ml-4 d-flex">
      <div class="form-group pr-2">
        <label class="font-weight-bold">Operator/Driver</label>
        <hr/>
      </div>
    </div>
    <div class="row mt-0 ml-4 mb-4 d-flex">
      {{-- <div class="form-group pr-2">
        <label class="font-weight-bold">Jabatan</label>
        <select id="jabatan" name="jabatan" class="form-control mb-0" style="border-right: 15px transparent solid;border-bottom: 15px;">
          <option value=""></option>
          @if(isset($jabatan))
            @foreach ($jabatan as $value)
              <option value="{{ $value->id }}">{{ strtoupper($value->nm_jabatan) }}</option>                  
            @endforeach
          @endif
        </select>
      </div>       --}}
      <div class="form-group pr-2 with-validation">
        <label class="font-weight-bold">karyawan</label>
        <select id="operator" name="operator" class="form-control mb-0" style="border-right: 15px transparent solid;border-bottom: 15px;">
          <option value=""></option>
        </select>
        <div class="invalid-feedback"></div>
      </div>
      <div class="form-group pr-2">
        <label class="font-weight-bold">NIK</label>
        <input id="nik" name="nik" class="form-control mb-0" readonly />        
      </div>
    </div>
    <div class="row mt-0 ml-4 d-flex">
      <div class="form-group pr-2">
        <label class="font-weight-bold">Jam operasional</label>
        <hr/>
      </div>
    </div>
    <div class="row mt-0 ml-4 d-flex">
      <div class="form-group pr-2 with-validation">
        <label class="font-weight-bold">Shift</label>
        <input type="number" id="shift" name="shift" class="form-control mb-0" />
        <div class="invalid-feedback"></div>
      </div>
    </div>
    <div class="row mt-0 ml-4 d-flex">
      <div class="form-group pr-2 with-validation">
        <label class="font-weight-bold">Mulai</label>
        <input type="time" id="operating_hour_start" name="operating_hour_start" class="form-control mb-0" />
        <div class="invalid-feedback"></div>
      </div>
      <div class="form-group pr-2 with-validation">
        <label class="font-weight-bold">Akhir</label>
        <input type="time" id="operating_hour_end" name="operating_hour_end" class="form-control mb-0" />
        <div class="invalid-feedback"></div>
      </div>
    </div>
    <div class="row mt-0 ml-4 d-flex">
      <div class="form-group pr-2">
        <label class="font-weight-bold">Istirahat Mulai</label>
        <input type="time" id="break_hour_start" name="break_hour_start" class="form-control mb-0" min="08:00" max="17:00" />
      </div>
      <div class="form-group pr-2">
        <label class="font-weight-bold">Istirahat Akhir</label>
        <input type="time" id="break_hour_end" name="break_hour_end" class="form-control mb-0" min="08:00" max="17:00" />
      </div>
    </div>
    <div class="row mt-0 ml-4 d-flex">
      <div class="form-group pr-2 with-validation">
        <label class="font-weight-bold">HM Mulai</label>
        <input type="number" id="hm_start" name="hm_start" class="form-control mb-0" />
        <div class="invalid-feedback"></div>
      </div>
      <div class="form-group pr-2 with-validation">
        <label class="font-weight-bold">HM Akhir</label>
        <input type="number" id="hm_end" name="hm_end" class="form-control mb-0" />
        <div class="invalid-feedback"></div>
      </div>
    </div>
    <div class="row mt-0 ml-2 d-flex">
      <div class="col-4">
      <div class="form-group pr-2">
        <label class="font-weight-bold">Keterangan</label>
        <textarea id="keterangan" name="keterangan" class="form-control mb-0"></textarea>
      </div>
      </div>
    </div>
    <hr/>
    <div class="row mt-0 ml-2 d-flex border-top-1">
      <div class="col-4">
        <div class="form-group pr-2">
          <button id='btn-save-workhour' name='btn-save-workhour' type='button' class='btn btn-lg btn-block btn-primary'>Simpan</button>
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
    var project = $("#project"),
        equipment_category = $("#equipment_category"),
        equipment = $("#equipment"),
        jabatan = $("#jabatan"),
        operator = $("#operator"),
        nik = $("#nik"),
        shift = $("#shift"),
        operating_hour_start = $("#operating_hour_start"),
        operating_hour_end = $("#operating_hour_end"),
        break_hour_start = $("#break_hour_start"),
        break_hour_end = $("#break_hour_end"),
        hm_start = $("#hm_start"),
        chosenNik = "",
        loadEquipmentsUrl = "{{ route('lho.loadEquipments', ['equipmentCategory' => ':equipmentCategory' ]) }}",
        loadEmployeesUrl = "{{ route('lho.loadEmployees', ['jabatan' => ':jabatan' ]) }}",
        loadEquipmentCategoryByProject = "{{ route('lho.loadEquipmentCategory', ['projectId' => ':projectId' ]) }}",
        loadOperatorDriverUrl = "{{ route('lho.loadOperatorDriver', ['projectId' => ':projectId']) }}",
        loadLastHmByEquipmentUrl = "{{ route('lho.loadLastHmByEquipment', ['projectId' => ':projectId','equipmentId' => ':equipmentId']) }}";

        project.on('change', function(e){
          if(e.target.value){
            let urlWithParam = loadEquipmentCategoryByProject.replace(':projectId', e.target.value);
            let urlOperatorDriverWithParam = loadOperatorDriverUrl.replace(':projectId', e.target.value);
            ajaxRequest({
              url: urlWithParam,
              requestType: "GET"
              }, populateEquipmentCategory)
            
            ajaxRequest({
              url: urlOperatorDriverWithParam,
              requestType: "GET"
              }, populateOperatorDriver)
          }
        });

        equipment_category.on('change', function(e){      
          if(e.target.value)
          {
            let urlWithParam = loadEquipmentsUrl.replace(':equipmentCategory', e.target.value);
            ajaxRequest({
              url: urlWithParam,
              requestType: "GET"
              }, populateEquipments)
          }
        });

        $("#project, #equipment").on('change', function(e){
          console.log(e.target.name)
          let projectId = e.target.name == "project" ? e.target.value : project.val();
          let equipmentId = e.target.name == "equipment" ? e.target.value : equipment.val();
          if(equipmentId && projectId)
          {
            let replaceProjectParam = loadLastHmByEquipmentUrl.replace(':projectId', projectId);
            let urlWithParams = replaceProjectParam.replace(':equipmentId', equipmentId);
            ajaxRequest({
              url: urlWithParams,
              requestType:"GET",
            }, populateLastHM)

          }
        })

        function populateLastHM(response){
          console.log(response);
          if(response)
          {
            let hm_end = response[0].hm_end;
            hm_start.val(hm_end);
          }
        }

        function populateOperatorDriver(response)
        {
          operator.empty();
          if(response)
          {
            operator.append(`<option value=''></option>`);
            response.forEach(option=>{
              operator.append(`<option value=${option.id}>${option.employee.nik.toUpperCase()} - ${option.employee.nm_lengkap.toUpperCase()}</option>`)
            })
          }
        }

        function populateEquipmentCategory(response)
        {
          equipment_category.empty();
          if(response)
          {
            equipment_category.append(`<option value=''></option>`);
            response.forEach(option=>{
              equipment_category.append(`<option value=${option.id}>${option.name.toUpperCase()}</option>`);
            })
          }
        }

        function populateEquipments(response)
        {
          equipment.empty();
          if(response)
          {
            equipment.append(`<option value=''></option>`);
            response.forEach(option=>{
              equipment.append(`<option value=${option.id}>${option.code} - ${option.name}</option>`);
            })
          }
        }


        // SET DEFAULT SHIFT 1
        shift.val(1);
        operating_hour_start.val("08:00:00")
        operating_hour_end.val("12:00:00")
        break_hour_start.val("12:00:00")
        break_hour_end.val("13:00:00")

        shift.on('change', function(e){
          if(e.target.value){
            populateWorkHourAndBreakTime(e.target.value)
          }
        })

        function populateWorkHourAndBreakTime(shift){
          if(shift == "1")
          {
            operating_hour_start.val("08:00:00")
            operating_hour_end.val("12:00:00")
          } else if(shift == "2")
          {
            operating_hour_start.val("13:00:00")
            operating_hour_end.val("17:00:00")
          }
        }

        // jabatan.on('change', function(e){      
        //   if(e.target.value)
        //   {
        //     let urlWithParam = loadEmployeesUrl.replace(':jabatan', e.target.value);
        //     ajaxRequest({
        //       url: urlWithParam,
        //       requestType: "GET"
        //       }, populateEmployees)
        //   }
        // });

        // function populateEmployees(response)
        // {
        //   operator.empty();
        //   if(response)
        //   {
        //     operator.append(`<option value=''></option>`);
        //     response.forEach(option=>{
        //       operator.append(`<option value=${option.id}>${option.nik} - ${option.nm_lengkap}</option>`);
        //     })
        //   }
        // }

        operator.on('change', function(e){
          let selected = $(this).find('option:selected').text();
          selectedArr = selected.split("-");
          nik.val(selectedArr[0].trim());
        });
        
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
              equipment = $("#equipment"),
              operator = $("#operator"),
              shift = $("#shift"),
              jamKerjaAwal = $("#operating_hour_start"),
              jamKerjaAkhir = $("#operating_hour_end"),
              hmStart = $("#hm_start"),
              hmEnd = $("#hm_end");
          
              if(project.val().length < 1){
                formValidationArea(project, "belum memilih project");
              }
              
              if(equipment.val() == ""){
                formValidationArea(equipment, "belum memilih equipment");
              }

              if(operator.val() == ""){
                formValidationArea(operator, "belum memilih operator");
              }

              if(shift.val().length < 1){
                formValidationArea(shift, "belum mengisi shift kerja");
              }

              if(jamKerjaAwal.val().length < 1){
                formValidationArea(jamKerjaAwal, "belum mengisi jam kerja awal");
              }

              if(jamKerjaAkhir.val().length < 1){
                formValidationArea(jamKerjaAkhir, "belum mengisi jam kerja akhir");
              }

              if(hmStart.val().length < 1){
                formValidationArea(hmStart, "belum mengisi HM awal");
              }

              if(hmEnd.val().length < 1){
                formValidationArea(hmEnd, "belum mengisi HM akhir");
              }
        }
        // End Validations        

        $(document).on('click', "#btn-save-workhour", function(evt){
          evt.preventDefault();
          beforeValidate();
          validateForm();
          if (doesntHasValidationError()) {            
            $("#form-work-hour").submit();
          }
          // $("#project_id").val(project.val());
        });
  
  })
</script>