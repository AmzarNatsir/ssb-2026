{{-- TODO : if update route('projects.update') else route('projects.store') --}}
<form id="create-project-form" method="POST"
  action="{{ $action == 'edit' ?  route('project.update', $project->id) : route('project.store') }}"
  enctype="multipart/form-data" autocomplete="off">
  @if ($action == 'edit')
      @method('PATCH')
    @endif
  @csrf
  <div class="modal-content">
    <div class="modal-body">
        {{--form indicator  --}}
        <div class="row mb-4">
          <div class="col-4">
              <div class="indicator-step" data-step="#1"></div>
          </div>
          <div class="col-4">
              <div class="indicator-step" data-step="#2"></div>
          </div>
          <div class="col-4">
              <div class="indicator-step" data-step="#3"></div>
          </div>
        </div>
        <button type="button" class="absolute-close" data-dismiss="modal" aria-label="Close">
          <i class="ri-close-line"></i>
        </button>

          {{-- load blade component --}}
          <div id="sectionStep1">
              <x-tender.project.step_1
                :action="$action"
                :project="$project ?? null"
                :opsiKategoriProject="$opsiKategoriProject"
                :opsiStatusProject="$opsiStatusProject"
                :opsiTipeProject="$opsiTipeProject"
                :opsiTargetTender="$opsiTargetTender"
                :opsiJenisProject="$opsiJenisProject"
                :projectNumber="$projectNumber ?? null" />
          </div>
          <div id="sectionStep2" style="display:none;">
              <x-tender.project.step_2
                :project="$project ?? null"
                :fileTypes="$fileTypes"
                :fixedfileTypes="$fixedfileTypes"
                :fixedFile="$fixedFile" />
          </div>
          <div id="sectionStep3" style="display:none;">
              <x-tender.project.step_3
                :project="$project ?? null"
                :customers="$customers" />
          </div>
          {{--
              <div id="formLoader">
                <div class="d-flex align-items-center form-loading mb-24">
                    <span>Loading...</span>
                    <div class="spinner-border text-success spinner-border-md ml-auto" aria-hidden="true"></div>
                </div>
              </div>
          --}}
    </div>
  </div>
</form>
<script type="text/javascript">
$(document).ready(function(){
    var url = "{{ asset('/js/tender/' . $action . '.js') }}",
        fileTypes = @json($fileTypes),
        fixedFile = @json($fixedFile);
    $.getScript(url, function(data, textStatus, jqxhr){
      console.log( "Loaded.", url );
    });
})

</script>
