@extends('Tender.layouts.master')
@section('content')
<div class="row">
  <div class="col-sm-12 col-lg-12">
      <div class="navbar-breadcrumb">
          <nav aria-label="breadcrumb">
              <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Project</a></li>
              <li class="breadcrumb-item"><a href="#">Manage Project</a></li>
              <li class="breadcrumb-item active" aria-current="page">Create New Project</li>
              </ul>
          </nav>
      </div>
      <div class="iq-card">
        <div class="iq-card-header d-flex justify-content-between">
          <div class="iq-header-title">          
            <h5 class="card-title">Create Project</h5>  
          </div>
        </div>
        <div class="iq-card-body">
          @if(\Session::has('success'))          
          <div class="alert text-white bg-success" role="alert">
              <div class="iq-alert-text">
                {{ \Session::get('success') }}                
              </div>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="ri-close-line"></i></button>
           </div>
          @endif

          <div class="section">
            <h5>General Info</h5>
            <hr/>
          </div>
          
          
        <form autocomplete="off" id="form-create-project" method="POST" action="{{ route('Tender.project.save') }}">
          {{ csrf_field() }}
          <div class="form-row">
              <div class="col-sm-3">
                  <label class="label">Status Project</label>
                  <select id="status_project" name="status_project" class="form-control form-control-sm">
                    <option value="0">-</option>
                    @foreach($opsi_status_project as $key => $value)
                      <option value={{ $value->id }}>{{ $value->status}}</option>
                    @endforeach
                  </select>
              </div>              
              <div class="col-sm-3">
                <label class="label">Target Tender</label>
                <select id="tender_target" name="tender_target" class="form-control form-control-sm">
                  <option value="0">-</option>
                  @foreach($opsi_target_tender as $key => $value)
                    <option value="{{ $value->id }}">{{ $value->keterangan}}</option>
                  @endforeach
                  {{-- <option value="2">Non Tender</option> --}}
                </select>
              </div>              
              <div class="col-sm-3">
                <label class="label">Jenis</label>
                <select id="jenis" name="jenis" class="form-control form-control-sm">
                  <option value="0">-</option>
                  <option value="1">Badan Usaha</option>
                  <option value="2">Perseorangan</option>
                </select>
              </div>              
            </div>
          <div class="form-row">
              <div class="col-sm-3">
                <input type="text" id="tender_no" name="tender_no" class="form-control form-control-sm" placeholder="Tender No"/>
              </div>              
              <div class="col-sm-3">
                <input type="text" id="tender_source" name="tender_source" class="form-control form-control-sm" placeholder="Tender Source"/>
              </div>              
            </div>
            <div class="form-row">
              <div class="col-sm-6">
                <textarea name="tender_desc" class="form-control form-control-sm" rows="2" placeholder="Tender Description"></textarea>
              </div>
            </div>
                        
            <div class="form-row">
              <div class="col-sm-2">
                <label class="label">Tender Date</label>
                <input type="date" name="tender_date" class="form-control form-control-sm" />
              </div>
              <div class="col-sm-2">
                <label class="label">Tender End Date</label>
                <input type="date" name="tender_end_date" class="form-control form-control-sm" />
              </div>
            </div>

            <div class="form-row form-row-end">
              <div class="col-sm-2">
                <label class="label">Tender Value</label>
                <input type="number" name="tender_value" class="form-control form-control-sm" />
              </div>
              <div class="col-sm-4">
                <label class="label">Project Location</label>
                <input type="text" name="project_location" class="form-control form-control-sm" />
              </div>
            </div>

            
            
            <div class="section">
              <h5>Customer Info</h5>              
            </div>

            <div class="form-row" style="margin-bottom: 20px;">
              {{-- <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" name="customer_type_options" value="new" checked>
                <label class="custom-control-label">Customer Baru</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" name="customer_type_options" value="">
                <label class="custom-control-label">Existing Customer</label>
              </div> --}}
              
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="customer_type_options" id="new_customer_options" value="new" checked>
                <label class="form-check-label" for="new_customer_options">Customer Baru</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="customer_type_options" id="existing_customer_options" value="existing">
                <label class="form-check-label" for="new_customer_options">Existing Customer</label>
              </div>


            </div>            

            <div class="form-row d-flex flex-column align-items-start">
              <label class="label">Pilih Existing Customer</label>
              <div class="col-sm-3 d-flex flex-row justify-content-center">
                <input type="text" id="existing_customer_id" class="form-control form-control-sm" placeholder="Customer ID"/>
                <button id="existing_customer_lookup_button" class="btn btn-info mb-3" data-toggle="tooltip" data-placement="top" title data-original-title="lookup project id"  style="margin-top:5px;margin-left:5px;">
                  <i class="ri-search-fill"></i>
                </button>
              </div>                    
            </div>

            <div class="form-row form-row-end">
              <div class="col-sm-3">
                <label class="label">Diisi jika Customer Baru</label>
                <input type="text" id="customer_no" name="customer_no" class="form-control form-control-sm" placeholder="Customer No"/>
              </div>              
              <div class="col-sm-3">
                <label class="label">&nbsp;</label>
                <input type="text" id="customer_name" name="customer_name" class="form-control form-control-sm" placeholder="Customer Name"/>
              </div>              
            </div>
            

            <div class="section">
              <h5>Dokumen</h5>              
              <small>pilih jenis dokumen yang akan diupload</small>
            </div>


            <div class="form-row" style="margin-bottom: 20px;">              
              @foreach($opsi_upload_kategori as $key => $value)
                <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="upload_kategori{{ $value->id}}" name="upload_kategori" value="{{ $value->id }}" checked>
                  <label class="form-check-label" for="upload_kategori">{{ $value->keterangan }}</label>
                  <input type="hidden" id="max_upload" name="max_upload[{{ $value->id }}]" value="{{ $value->maximum_upload}}" />
                </div>              
              @endforeach
            </div>

            <div id="files_preview">
              <div class="form-row">
                <ul class="list-unstyled">
                  <li class="media">
                    <img 
                      id="img-preview"
                      src="{{ asset('assets/images/user/1.jpg') }}" 
                      class="rounded mr-3" style="width:36px;height:36px;"/>
                    <div class="media-body">
                      <h6 class="mt-0 mb-0">dokumen 1</h6>
                      <small>file PNG size 1 MB</small>
                    </div>
                  </li>
                </ul>
                {{-- <img src="{{ asset('assets/images/user/1.jpg') }}" class="rounded ml-3" style="width:36px;height:36px;"/> --}}
              </div>
            </div>

            <div id="files_container">
              <div class="form-row d-flex align-items-center">
                <div class="col-sm-3">
                    <input type="text" class="form-control form-control-sm file-input" placeholder="Nama Dokumen"/>
                </div>
                <div class="col-sm-3">                  
                    <input type="file" id="dok" name="dok" accept=".jpg, .jpeg, .png" class="custom-file-input" id="customFile">
                    <label class="custom-file-label" for="customFile">Pilih Dokumen</label>
                </div>
              </div>
            </div>
            <br/>            
            
            <hr/>
            <div class="form-row">
              <div class="col-sm-2">
                <button class="btn btn-success btn-block">Create Project</button>
              </div>
              {{-- <div class="col-sm-2">
                <button class="btn btn-secondary btn-block">Update Hasil Survey</button>
              </div> --}}
            </div>
          </form>
        </div>
      </div>
  </div>
</div>
<script>
$(document).ready(function(){
    
  (() => {
    // console.log('test')
    if($("input[name='customer_type_options']").val() === "new"){
      $("#existing_customer_id").attr('disabled', true);
      $("#existing_customer_lookup_button").attr('disabled', true);
    }

    $("input[name='upload_kategori']").on('change', function(selected){
      const { value: selectedUploadKategori } = selected.target;
      var max_upload = $(`input[name='max_upload[${selectedUploadKategori}]']`).val();
      $.ajax({
        type:'GET',
        url:'getMaxUploadPerKategori/' + selectedUploadKategori,
        beforeSend: () => {
          $("#files_container").empty();
        },
        success: (files) => {                    
          var numFiles = files.length > 0 ? files[0].maximum_upload : 0;
          for(var i=1; i <= numFiles; i++){
            let upload = `
            <div class="form-row d-flex align-items-center">
              <div class="col-sm-3">
                  <input type="text" class="form-control form-control-sm file-input" placeholder="Dokumen ${files[0]['keterangan']} ${i}"/>
              </div>
              <div class="col-sm-3">                  
                  <input type="file" name="${files[0]['keterangan'].replace(/\ /g,'-')}-${i}" class="custom-file-input" id="customFile">
                  <label class="custom-file-label" for="customFile">Pilih Dokumen</label>
              </div>
            </div>`;
            $("#files_container").append(upload);
          }
        }
      })
    });

    // example to display file when finish selecting files    
    $("#dok").change(function(evt){
      console.log(evt.target.name);
      var imgPreview = document.getElementById('img-preview');
      if(window.FileList && window.File && window.FileReader){
        // document.getElementByName(`preview${evt.target.name}`).src = '';
        imgPreview.src = '';
        const reader = new FileReader();
        reader.addEventListener('load', evt => {
          // document.getElementById("img-preview").src = evt.target.result;
          imgPreview.src = evt.target.result;
        });
        reader.readAsDataURL(evt.target.files[0]);
      }
    })

  })();

  $("input[name='customer_type_options']").on('change',function(selected){
    const { value: selectedCustomerType } = selected.target;    
    if(selectedCustomerType === undefined) return false;
    if(selectedCustomerType === 'new'){      
      $("#existing_customer_id").attr('disabled', true);
      $("#existing_customer_lookup_button").attr('disabled', true);
      $("#customer_no").attr('readonly', false);
      $("#customer_name").attr('readonly', false);
    } else if(selectedCustomerType === 'existing'){
      $("#existing_customer_id").attr('disabled', false);
      $("#existing_customer_id").attr('readonly', true);
      $("#existing_customer_lookup_button").attr('disabled', false);
      $("#customer_no").attr('readonly', true);
      $("#customer_name").attr('readonly', true);      
    }

    // $("input[name='upload_kategori']").on('change', function(selected){
    //   const { value: selectedUploadKategori } = selected.target;
    //   var max_upload = $(`input[name='max_upload[${selectedUploadKategori}]']`).val();
    //   $.ajax({
    //     type:'GET',
    //     url:'getMaxUploadPerKategori/' + selected.target,
    //     beforeSend: () => {

    //     },
    //     success: (data) => {
    //       console.log(data);
    //     }
    //   })
    // })

    

    
    // var customer_type = $("input[name='customer_type_options']:checked").val();    
    
  })
});
</script>
@endsection