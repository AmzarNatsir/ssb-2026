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
          <span class="ri-chat-check-line pr-2"></span>Create Unit Fulfillment
        </h4>
      </div>
      <div class="col-sm-4 text-right">        
      </div>
    </div>

    <div class="row mt-4 ml-4 mb-4 d-flex">
      <form id="filter-daftar-p2h" name="filter-daftar-p2h" method="post" enctype="multipart/form-data" autocomplete="off" action="{{ route('Project.loadDataTable') }}">
       @csrf       
        <div class="form-row">
          <div class="form-group pr-2">
            <label class="font-weight-bold">Pick a Project</label>
            <select id="project" name="project" class="form-control mb-0" style="border-right: 15px transparent solid;border-bottom: 15px;">
              @if(isset($activeProjects))
                <option value=""></option>
                @foreach ($activeProjects as $project)
                  <option value="{{ $project->id }}">{{ $project->number}}</option>                  
                @endforeach
              @endif
            </select>                    
          </div>
        </div>
      </form>
    </div>

    <div class="row mt-4 ml-4 mb-4 d-flex">
      <div class="form-group pr-2">
        <h4 class="font-weight-bold">Equipment</h4>
      </div>
    </div>
        
    <div class="row mt-4 ml-4 mb-4 d-flex">
      <form id="fulfillment-unit-form" 
        method="post" 
        action="{{ route('fulfillment.save') }}"
        enctype="multipart/form-data" 
        autocomplete="off">            
        @csrf
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
        <input type="hidden" name="project_id" id="project_id">
        <div id="fulfillment-table" class="col-12 mt-2"></div>
      </form>
    </div>

      
    </div>
  </div>
</div>
@endsection
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script type="text/javascript">
  $(function(){
    var project = $("#project"),
        loadEquipmentCategoriesUrl = "{{ route('fulfillment.loadEquipmentCategoriesFromBoq', ['project' => ':project' ]) }}",
        equipments = [], 
        tables = "";

    // loadEquipmentCategoriesUrl = "/project/fulfillment/loadEquipmentCategoriesFromBoq";

    project.on('change', function(e){      
      if(e.target.value){
        let urlWithParam = loadEquipmentCategoriesUrl.replace(':project', e.target.value);
        ajaxRequest({
          url: urlWithParam,
          requestType: "GET"
          }, displayEquipments)
      }
    });

    function displayEquipments(records)
    {
      equipments.length = 0;
      equipments = records;            
      if(equipments.length > 0){
        equipments.map(item => {
          tables +=`<table class='table table-data nowrap w-100'>
            <thead>
              <tr class='tr-shadow'>                
                <th colspan='2'>${item.name}</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <thead>
              <tr class='tr-shadow'>                
                <th></th>
                <th>Code</th>
                <th>Name</th>
                <th>YOP</th>
                <th>Chassis No</th>
                <th>Engine No</th>
                <th>HM</th>
                <th>KM</th>
              </tr>
            </thead>
            <tbody>            
            ${item.equipments.length > 0 && item.equipments.map(elem=> 
              "<tr class='tr-shadow'>" +
                "<td><input id='checked-unit["+elem.id+"]' name='checked-unit["+elem.id+"]' type='checkbox' /></td>" +
                "<td>" + elem.code + "</td>" +
                "<td>" + elem.name + "</td>" +
                "<td>" + elem.yop + "</td>" +
                "<td>" + elem.chassis_no + "</td>" +
                "<td>" + elem.engine_no + "</td>" +
                "<td>" + elem.hm + "</td>" +
                "<td>" + elem.km + "</td>" +
                "</tr>"
            )}
            </tbody>`;                    
        });
      }
      
      tables +=`<tfoot>
              <tr>
                <td colspan='8' class='text-right'>
                  <button id='save-fulfillment' name='save-fulfillment' type='button' class='btn btn-lg btn-block btn-primary'>Simpan</button>                  
                </td>
              </tr>
            </tfoot>
          </tbody>
        </table>`;
      $("#fulfillment-table").html(tables.replace(/,/g, ''));      
    }

    $(document).on('click', "#save-fulfillment", function(evt){
      evt.preventDefault();
      $("#project_id").val(project.val());      
      $("#fulfillment-unit-form").submit();
      
      // ajaxRequest({
      //   url: "{{ route('fulfillment.save')}}",
      //   requestType: "POST",
      //   data: JSON.stringify({          
      //     project,
      //     data: $('#fulfillment-unit-form').serializeArray(),
      //   })
      //   // data: JSON.stringify({
      //     // "_token": $('#token').val(),
      //     // "checked-unit": $("#checked-unit").val(),
      //     //data: $('#fulfillment-unit-form').serializeArray()
      //     //  })
      //   }, function(cb){
      //     console.log(cb);
      //   });

    });        

    $(document).on('submit', "#fulfillment-unit-form", function(e){
      e.preventDefault();      
      this.submit();
    });


  })
</script>