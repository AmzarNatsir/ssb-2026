<form 
    id="add-document-form" 
    method="POST" 
    action="{{ $action == 'edit' ?  route('document.update', $document->id) : route('document.store') }}" 
    enctype="multipart/form-data" autocomplete="off">
  @if ($action == 'edit')
      @method('PATCH')
    @endif
  @csrf
  <div class="modal-content">        
    <div class="modal-body">
      <button 
        type="button" 
        class="absolute-close" 
        data-dismiss="modal" 
        aria-label="Close">
        <i class="ri-close-line"></i>
      </button>
      
      <h5 class="modal-title" id="exampleModalLabel">Create Report Safety Induction</h5>
      <small>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis, nulla!</small>
      <hr/>
     
      
      <!-- {{-- <div class="custom-switch custom-switch-label-yesno custom-switch-xs pl-0 d-flex align-items-center my-3">
        <small class="my-2 pr-2 text-right">File ini adalah Dokumen Template ?</small>
        <input class="custom-switch-input" id="is_template_check" type="checkbox">
        <label class="custom-switch-btn" for="is_template_check"></label>
      </div> --}} -->
      
      <div class="form-group with-validation">
        <label for="colFormLabel" class="font-weight-bold">Nama</label>
        <input id="name" name="name" type="text" class="form-control" />
        <div class="invalid-feedback"></div>
      </div>

      <div class="form-group with-validation">
        <label for="colFormLabel" class="font-weight-bold">Pilih Karyawan</label>
        <select id="employee_id" name="employee_id" class="form-control" style="border-right: 15px transparent solid;border-bottom: 15px;">
          <option value="0"></option>
          <option value="1">karyo</option>          
        </select>
        <div class="invalid-feedback"></div>
      </div>

      <div class="form-group with-validation">
        <label for="colFormLabel" class="font-weight-bold">Jenis</label>
        <select id="file_types" name="file_types" class="form-control" style="border-right: 15px transparent solid;border-bottom: 15px;">          
          <option value="1">Surat pengantar</option>
          <option value="2">Form Safety Induction</option>
          <option value="3">Form Test pemahaman Safety Induction</option>
        </select>
        <div class="invalid-feedback"></div>
      </div>

      <div class="form-group">
        <label for="colFormLabel" class="w-100 font-weight-bold">Upload</label>
        <input id="upload" name="upload" type="file" class="test-upload" multiple accept="image/png, image/jpeg, image/jpg, application/pdf" style="cursor: pointer;" />
      </div>

      <div id="button_wrapper" class="row mt-4">      
          <div class="col-12">
            <button id="btnSubmitAddDocument" type="button" class="btn btn-lg btn-block btn-primary font-weight-bold">Upload Dokumen</button>
          </div>        
      </div>

    </div>
  </div>
</form>