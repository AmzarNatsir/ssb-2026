<div class="modal fade" id="surveyAssignmentModal" tabindex="-1" role="dialog" aria-labelledby="surveyAssignmentModal" aria-modal="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Perintah Survey</h5>
        <button type="button" id="closeLocationModal" data-dismiss="modal" aria-label="Close">            
          <i class="ri-close-line"></i>
        </button>        
      </div>        
        <div class="modal-body">          
          <form name="survey-assignment-form" id="survey-assignment-form" method="POST" action="{{ route('Survey.assignment') }}" enctype="multipart/form-data" autocomplete="off">
            @csrf
            {{-- <div class="form-group with-validation">
              <label for="colFormLabel">Pilih surveyor</label>              
              <select id="surveyor" name="surveyor" class="form-control mb-0" style="border-right: 15px transparent solid;border-bottom: 15px;">
                <option selected="" value=""></option>
                @foreach ($surveyors as $surveyor)
                   <option value="{{ $surveyor->karyawan->id }}">{{ $surveyor->karyawan->nik.' '.$surveyor->karyawan->nm_lengkap }}</option>                               
                @endforeach
             </select>
             <div class="invalid-feedback"></div>
            </div> --}}
            <div class="form-group with-validation">
              <label for="colFormLabel">Pilih Tim surveyor</label>
              {{-- <br/> --}}
              <select id="surveyorGroup" name="surveyorGroup" multiple class="form-control mb-0" style="border-right: 15px transparent solid;border-bottom: 15px;display:inline-block;">
                @foreach ($surveyorGroup as $surveyor)
                   <option value="{{ $surveyor->karyawan->id }}">{{ $surveyor->karyawan->nik.' - '.$surveyor->karyawan->nm_lengkap }}</option>                               
                @endforeach
             </select>
             <div class="invalid-feedback"></div>
            </div>
            <div class="form-group with-validation">              
              <label for="colFormLabel">Tanggal survey</label>
              <input type="date" id="survey_date" name="survey_date" min="" max="" value="" class="form-control" placeholder="">
              <div class="invalid-feedback"></div>
            </div>
            <div class="form-group with-validation">
              <label for="colFormLabel">Catatan</label>
              <textarea id="survey_notes" name="survey_notes" class="form-control"></textarea>
              <div class="invalid-feedback"></div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <input type="hidden" id="survey_task_project_id" name="survey_task_project_id" value="{{ request()->route('projectId') }}" />
                <input type="hidden" id="hdnSurveyorGroup" name="hdnSurveyorGroup" />
                <button type="button" id="save-survey-assignment-btn" class="btn btn-lg btn-next-step btn-block btn-primary">Simpan</button>
              </div>
            </div>
          </form>
        </div>
     </div>
  </div>
</div>
{{-- <link rel="stylesheet" href="{{ asset('css/bootstrap-multiselect.min.css') }}" /> --}}
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<style>
  .btnClass {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }
</style>
<script type="text/javascript">
$(function(){
  
  $(document).on('show.bs.modal', function (e) {    
    let selectedSurveyGroup = [];
    $('#surveyorGroup').multiselect({
      // enableHTML:false,
      buttonContainer:'<div class="btn-group btnClass" />',
      inheritClass:true,
      selectedClass: null,
      widthSynchronizationMode: 'always',
      onChange: function(element, checked) {      	
        let currIndex = selectedSurveyGroup.indexOf(element.val());        
        if(currIndex === -1){
          selectedSurveyGroup.push(element.val())          
        } else {
          selectedSurveyGroup.splice(currIndex, 1);
        }
        $("#hdnSurveyorGroup").val(selectedSurveyGroup.join())
      },
      // selectAllText: false,
      // selectAllNumber:false,
      // selectAllJustVisible:true,
      // allSelectedText: '',
      // nSelectedText: '',
      // buttonClass:'btnClass',
      // buttonWidth:'auto'
    });
  })
})
</script>