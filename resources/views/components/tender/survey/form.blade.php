<form id="survey-form" action="{{ $action == 'edit' ? route('survey.update', $survey->id) : route('survey.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
    @if ($action == 'edit')
    @method('PATCH')
    @endif
    @csrf
    @php
    $isSurveyOfficerAndPreanalystNotCompleted = !auth()->user()->can('update', $survey) ? "true" : "false";
    @endphp
    <div class="modal-content">
        <div class="modal-body">
            <button type="button" class="absolute-close" data-dismiss="modal" aria-label="Close">
                <i class="ri-close-line"></i>
            </button>
            <div class="form-group with-validation">

                <div class="row">
                    <div class="col-10">
                        <h6 class="font-weight-bold lokasi_survey">Lokasi Survey</h6>
                        <br />
                        {{-- @cannot('update', $survey)
              <h3>user tidak bisa update survey</h3>
              {{ $isSurveyOfficerAndPreanalystNotCompleted }}
                        @endcannot --}}
                        <div class="invalid-feedback"></div>
                    </div>
                    {{-- Hide Lokasi sementara --}}
                    {{-- <div class="col-2">
            <a
              id="add-survey-location-btn"
              href="#"
              data-toggle="modal"
              data-target="#addLocationModal"
              class="btn tag-add-location p-2"
              data-backdrop="false"
              {{ $isSurveyOfficerAndPreanalystNotCompleted ?  '' : 'disabled' }}>
                    <i class="ri-map-2-line pl-1"></i>
                    </a>
                </div> --}}
            </div>
        </div>
        {{-- Hide Lokasi sementara --}}
        {{-- <div id="survey-locations" class="form-group mb-4 pl-0 pr-3" style="max-height:500px; overflow-y:scroll;overflow-x:hidden;">
            @if(isset($surveyResult))
            @foreach($surveyResult as $key => $currentSurvey)
            <div id="location-{{ $key }}" class="bg-white text-muted rounded-lg py-2 px-1 my-2" style="border:solid 1px #CCC;">
        <div class="row px-2">
            <div class="col-sm-12 text-right">
                @if(!empty($currentSurvey->lat && $currentSurvey->lng))
                <a id="show-map-{{ $key }}" href="https://maps.google.com/?q={{ $currentSurvey->lat.",".$currentSurvey->lng }}&t=k&z=21" target="_blank" class="btn p-2 tag show-map" data-toggle="tooltip" data-placement="top" title="show-map">
                    <i class="ri-map-pin-line pl-1"></i>
                </a>
                @else
                <a id="show-map-{{ $key }}" target="_blank" class="btn p-2 tag-disabled show-map" data-toggle="tooltip" data-placement="top" title="show-map">
                    <i class="ri-map-pin-line pl-1"></i>
                </a>
                @endif

                <button id="edit-location-{{ $key }}" data-location-id="{{ $currentSurvey->id }}" class="tag edit-location" data-toggle="tooltip" data-placement="top" title="edit" {{ $isSurveyOfficerAndPreanalystNotCompleted ?  '' : 'disabled' }}>
                    <i class="ri-edit-box-line"></i>
                </button>

                <button id="delete-location-{{ $key }}" class="tag-danger delete-location" data-toggle="tooltip" title="hapus" {{ $isSurveyOfficerAndPreanalystNotCompleted ?  '' : 'disabled' }}>
                    <i class="ri-delete-bin-7-line"></i>
                </button>

            </div>
        </div>
        <div class="row px-3">
            <div class="col-sm-4">Lokasi</div>
            <div class="col-sm-8">{{ $currentSurvey->segment }}</div>
        </div>
        <div class="row px-3">
            <div class="col-sm-4">Koordinat (Lat,Lng)</div>
            <div class="col-sm-8 text-wrap">{{ $currentSurvey->lat.",".$currentSurvey->lng }}</div>
        </div>
        <div class="row px-3">
            <div class="col-sm-4">Catatan</div>
            <div class="col-sm-8">{{ $currentSurvey->note }}</div>
        </div>
        <input type="hidden" name='hdn_location_name[{{ $key }}]' value="{{ $currentSurvey->segment }}" />
        <input type="hidden" name='hdn_lat[{{ $key }}]' value="{{ $currentSurvey->lat }}" />
        <input type="hidden" name='hdn_lng[{{ $key }}]' value="{{ $currentSurvey->lng }}" />
        <input type="hidden" name='hdn_location_note[{{ $key }}]' value="{{ $currentSurvey->note }}" />
        <input type="hidden" name='hdn_survey_result_id[{{ $key }}]' value="{{ $currentSurvey->id }}" />
    </div>
    @endforeach
    @else
    <div id="no-location-block" class="py-2 px-1 mt-2 mb-2 text-center" style="border:solid 2px #EAEAEA;border-radius:6px;">
        <i class="ri-information-line pr-1"></i>belum ada lokasi survey
    </div>
    @endif
    </div> --}}

    {{-- END HIDDEN LOKASI SURVEY --}}

    <div class="form-group with-validation">
        <label class="font-weight-bold" for="colFormLabel">Ringkasan Hasil survey</label>
        <textarea id="survey_note" name="survey_note" class="form-control" rows="2" {{ $isSurveyOfficerAndPreanalystNotCompleted ?  '' : 'disabled' }}>{{ isset($survey->summary_notes) ? $survey->summary_notes : '' }}</textarea>
        <div class="invalid-feedback"></div>
    </div>

    @if(isset($survey->files))
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="colFormLabel" class="font-weight-bold">Dokumen Hasil Survey</label>
            </div>
        </div>
    </div>
    <div class="row mt-0 mb-3 px-3" style="max-height:300px;overflow-x:scroll;overflow-y:hidden;">

        <div class="images-wrapper flex-row mb-3">

            @foreach ($survey->files as $file)
            {{-- cek jika ekstensi file selain gambar --}}
            @if(!in_array(pathinfo("storage/survey".$file->name, PATHINFO_EXTENSION), ['pdf','xls','xlsx','doc','docx']))
            <a id="document-{{ $file->id }}" href="{{ url("storage/survey/".$file->name) }}" data-lightbox="documents" data-title="{{ url("storage/survey/".$file->name) }}" class="bg-light p-2 rounded-lg mr-2">

                <div class="d-flex flex-column mx-0 align-items-center">
                    <p class="badge badge-pill badge-light my-1">{{ $file->filetype->name }}</p>
                    <img data-id="{{ $file->id }}" src="{{ url("storage/survey/".$file->name) }}" class="rounded mb-0" width="90px" height="70px" style="object-fit: contain;" data-toggle="tooltip" title="{{ $file->filetype->name }}">
                </div>
            </a>

            <button id="btn-delete-document_{{ $file->id }}" data-filename="{{ $file->name }}" type="button" class="btn-circular-delete mr-2" data-toggle="tooltip" title="hapus dokumen" {{ $isSurveyOfficerAndPreanalystNotCompleted ?  '' : 'disabled' }}>
                <i class="ri-delete-bin-line h6"></i>
            </button>

            @else

            <a id="document-{{ $file->id }}" href="{{ url("storage/survey/".$file->name) }}" target="_blank" class="bg-light p-2 rounded-lg mr-2">
                <div class="d-flex flex-column mx-0 align-items-center">
                    <p class="badge badge-pill badge-light my-1">{{ $file->filetype->name }}</p>
                    <div class="d-flex justify-content-center align-items-center rounded mb-0 mr-2" style="width:100px;height:80px;">
                        <i class="fa fa-file-pdf-o" style="font-size:2rem;" aria-hidden="true"></i>
                    </div>
                </div>
            </a>

            <button id="btn-delete-document_{{ $file->id }}" data-filename="{{ $file->name }}" type="button" class="btn-circular-delete mr-2" data-toggle="tooltip" title="hapus dokumen" {{ $isSurveyOfficerAndPreanalystNotCompleted ?  '' : 'disabled' }}>
                <i class="ri-delete-bin-line h6"></i>
            </button>

            @endif

            @endforeach
        </div>
    </div>

    @endif

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="colFormLabel" class="font-weight-bold">Upload Dokumen</label>
            </div>
        </div>
        {{-- <div class="col-sm-6">
          <div class="form-group">
            <label for="colFormLabel" class="font-weight-bold">file</label>
          </div>
        </div> --}}
    </div>

    <div id="wrap">
        <div id="upload_field_1" class="row upload">
            <div class="col-sm-6 d-none">
                <div class="form-group mb-3">
                    <select id="file_type" name="file_type[]" class="form-control mb-0" style="border-right: 15px transparent solid;border-bottom: 15px;">
                        {{-- <option selected="" value=""></option> --}}
                        @foreach ($fileTypes as $fileType)
                        @if($fileType->name == "laporan survey lokasi")
                        <option value="{{ $fileType->id }}">{{ $fileType->name }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-5">
                <input name="filename[]" type="file" class="test-upload" multiple accept="image/png, image/jpeg, image/jpg, application/pdf" {{ $isSurveyOfficerAndPreanalystNotCompleted ?  '' : 'disabled' }}>
                <input name="fileIdsToBeDelete[]" type="hidden">
                <input name="fileNamesToBeDelete[]" type="hidden">
            </div>
            <div class="col-sm-1">
                <button id="btn-delete-field-upload_1" type="button" class="btn-circular-delete mr-2 d-none" data-toggle="tooltip" title="hapus field upload">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>



    <div class="row mt-4">
        <div class="col-sm-12">
            <input type="hidden" id="survey_id" name="survey_id" value="{{ isset($survey->id) ? $survey->id : '' }}" />
            <button type="button" id="save-survey-result-btn" class="btn btn-lg btn-block btn-primary" {{ $isSurveyOfficerAndPreanalystNotCompleted ?  '' : 'disabled' }}>
                Simpan Hasil Survey
            </button>
        </div>
    </div>
    </div>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function() {
        var url = "{{ asset('/js/tender/survey-' . $action . '.js') }}"
            , generalScriptUrl = "{{ asset('/js/tender/general.js') }}";

        // https://stackoverflow.com/questions/11803215/how-to-include-multiple-js-files-using-jquery-getscript-method
        $.when(
            $.getScript(url)
            , $.getScript(generalScriptUrl)
            , $.Deferred(function(deferred) {
                $(deferred.resolve);
            })
        ).done(function() {
            console.log("Promises scripts are Loaded.");
        });

    })

</script>
