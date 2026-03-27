<form 
  id="aktivasi-project-form" 
  method="POST"    
  enctype="multipart/form-data" 
  autocomplete="off"
  action="{{ route('project.activation') }}">
	@csrf
  <div class="modal-content">        
    <div class="modal-body">
  		<button type="button" class="absolute-close" data-dismiss="modal" aria-label="Close">
  			<i class="ri-close-line"></i>
  		</button>
    	
  		<div class="row">
  			<h5 class="modal-title mb-4" id="exampleModalLabel">Aktivasi Project</h5>
  		</div>
  		
	    <div class="form-group with-validation">
	      <label for="colFormLabel">Nomor Project</label>
	      <input type="text" id="project_number" name="project_number" class="form-control">
	      <div class="invalid-feedback"></div>
	    </div>

      <div class="form-group with-validation">
        <label for="colFormLabel">Nomor Surat Pemenang Lelang</label>
        <input type="text" id="auction_pass_letter_no" name="auction_pass_letter_no" class="form-control">
        <div class="invalid-feedback"></div>
      </div>

      <div class="form-group with-validation">
        <label for="colFormLabel">Tanggal Surat Pemenang Lelang</label>
        <input type="date" id="auction_pass_letter_date" name="auction_pass_letter_date" class="form-control">
        <div class="invalid-feedback"></div>
      </div>

      <div class="form-group">
        <label for="colFormLabel">Tanggal Kickoff Meeting</label>
        <input type="date" id="kickoff_meeting_date" name="kickoff_date" class="form-control">
        <div class="invalid-feedback"></div>
      </div>

      <div class="form-group">
        <label for="colFormLabel">Keterangan Kickoff Meeting</label>
        <input type="text" id="kickoff_meeting_note" name="kickoff_note" class="form-control">
        <div class="invalid-feedback"></div>
      </div>

      {{-- Readonly --}}

      {{-- {{ dd($workAssignment) }} --}}
      <div class="form-group">
        <label for="colFormLabel">No Surat Penunjukkan /</label>
        <input type="text" id="assignment_number" name="assignment_number" readonly="true" value="{{ isset($workAssignment) ? $workAssignment->assignment_number : '' }}" class="form-control">
      </div>

      <div class="form-group">
        <label for="colFormLabel">Tanggal Surat Penunjukkan /</label>
        <input type="text" id="assignment_date" name="assignment_date" readonly="true" value="{{ isset($workAssignment) ? $workAssignment->assignment_date : '' }}" class="form-control">
      </div>

      {{-- Kontrak --}}
      
      <div class="form-group with-validation">
        <label for="colFormLabel">Nomor Kontrak</label>
        <input type="text" id="contract_no" name="contract_no" value="" class="form-control">
        <div class="invalid-feedback"></div>
      </div>

      <div class="form-group with-validation">
        <label for="colFormLabel">Tanggal Kontrak</label>
        <input type="date" id="contract_date" name="contract_date" value="" class="form-control">
        <div class="invalid-feedback"></div>
      </div>

      <div class="form-group mb-0">
        <label for="colFormLabel" class="font-weight-500">Tanggal Pengerjaan</label>
      </div>
      <div class="row">
        <div class="col-6">
         <div class="form-group">                   
           <input type="date" id="work_start_date" name="work_start_date" class="form-control" 
            value="{{ $bond->bond_start_date ?? '' }}">
         </div>
        </div>
        <div class="col-6">
         <div class="form-group">                   
           <input type="date" id="work_end_date" name="work_end_date" class="form-control" 
            value="{{ $bond->bond_end_date ?? '' }}">
         </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12">
          <input type="hidden" id="project_id" name="project_id" value="{{ $project->id ?? '' }}">
          <button 
            type="button" 
            id="btn-project-activate" 
            name="btn-project-activate" 
            class="btn btn-lg btn-next-step btn-block btn-primary font-weight-bold">
            Submit
          </button>
        </div>
      </div>

    </div>
  </div>
</form>