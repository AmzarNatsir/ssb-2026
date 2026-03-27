{{-- {{ dd($preAnalystApproval) }} --}}
<form id="create-preanalyst-form" method="POST" action="{{ $action == 'edit' ?  route('preanalyst.update', $preAnalystApproval->id) : route('preanalyst.store') }}" enctype="multipart/form-data" autocomplete="off">
    @if ($action == 'edit')
    @method('PATCH')
    @endif
    @csrf
    <div class="modal-content">
        <div class="modal-body">

            <button type="button" class="absolute-close" data-dismiss="modal" aria-label="Close">
                <i class="ri-close-line"></i>
            </button>

            <div class="row mb-3">
                <h5 class="font-weight-bold lokasi_survey">Preanalyst, Scoring & Rekomendasi Project</h5>
            </div>

            <div class="form-group with-validation">
                <label class="font-weight-bold">Rekomendasi Project</label>
                {{-- <select id="rekomendasi" name="rekomendasi" class="form-control mb-0" style="border-right: 15px transparent solid;border-bottom: 15px;" {{ isset($preAnalystApproval->id) ? 'disabled' : '' }}>
                <option selected="" value=""></option>
                @foreach ($opsiRekomendasi as $key => $item)
                @if(isset($preAnalystApproval->is_approve) && ($preAnalystApproval->is_approve == $key) )
                <option selected="" value="{{ $key }}">{{ $item }}</option>
                @else
                <option value="{{ $key }}">{{ $item }}</option>
                @endif
                @endforeach
                </select> --}}
                {{-- Radio Group --}}
                {{-- {{ print_r($preAnalystApproval) }} --}}

                <div style="display:block;">
                    @foreach ($opsiRekomendasi as $key => $item)
                    <div {{-- class="custom-control custom-radio custom-control-inline" --}}>
                        <input type="radio" name="rekomendasi" value="{{ $key }}" {{ isset($preAnalystApproval->is_approve) && ($preAnalystApproval->is_approve == $key) ? 'checked' : '' }} {{ isset($preAnalystApproval->id) ? 'disabled' : '' }}>
                        <label for="rekomendasi">{{ $item }}</label>
                    </div>
                    @endforeach
                </div>
                {{-- checked --}}
                <div class="invalid-feedback"></div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="colFormLabel" class="font-weight-bold">Preview Dokumen</label>
                        {{-- {{ dd($opsiRekomendasi) }} --}}
                    </div>
                </div>
            </div>
            <div class="row mt-0 mb-3 px-3" style="max-height:300px;overflow-x:scroll;overflow-y:hidden;">
                <div class="images-wrapper flex-row mb-3">
                    @if(isset($preAnalystApproval->files))
                    @foreach ($preAnalystApproval->files as $file)
                    @if(!in_array(pathinfo("storage/preanalyst".$file->name, PATHINFO_EXTENSION), ['pdf','xls','xlsx','doc','docx']))
                    <a id="document-{{ $file->id }}" href="{{ url("storage/preanalyst/".$file->name) }}" data-lightbox="documents" data-title="{{ url("storage/preanalyst/".$file->name) }}" class="bg-light p-2 rounded-lg mr-2">

                        <div class="d-flex flex-column mx-0 align-items-center">
                            <p class="badge badge-pill badge-light my-1">{{ $file->filetype->name }}</p>
                            <img data-id="{{ $file->id }}" src="{{ url("storage/preanalyst/".$file->name) }}" class="rounded mb-0" width="90px" height="70px" style="object-fit: contain;" data-toggle="tooltip" title="{{ $file->filetype->name }}">
                        </div>
                    </a>

                    <button id="btn-delete-document_{{ $file->id }}" data-filename="{{ $file->name }}" type="button" class="btn-circular-delete mr-2" data-toggle="tooltip" title="hapus dokumen" {{ isset($preAnalystApproval->id) ? 'disabled' : '' }}>
                        <i class="ri-delete-bin-line h6"></i>
                    </button>


                    @else

                    <a id="document-{{ $file->id }}" href="{{ url("storage/preanalyst/".$file->name) }}" target="_blank" class="bg-light p-2 rounded-lg mr-2">
                        <div class="d-flex flex-column mx-0 align-items-center">
                            <p class="badge badge-pill badge-light my-1">{{ $file->filetype->name }}</p>
                            <div class="d-flex justify-content-center align-items-center rounded mb-0 mr-2" style="width:100px;height:80px;">
                                <i class="fa fa-file-pdf-o" style="font-size:2rem;" aria-hidden="true"></i>
                            </div>
                        </div>
                    </a>

                    <button id="btn-delete-document_{{ $file->id }}" data-filename="{{ $file->name }}" type="button" class="btn-circular-delete mr-2" data-toggle="tooltip" title="hapus dokumen" {{ isset($preAnalystApproval->id) ? 'disabled' : '' }}>
                        <i class="ri-delete-bin-line h6"></i>
                    </button>

                    @endif
                    @endforeach
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="colFormLabel" class="font-weight-bold">Jenis Dokumen</label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="colFormLabel" class="font-weight-bold">file</label>
                    </div>
                </div>
            </div>
            <div id="wrap">
                <div id="upload_field_1" class="row upload">
                    @foreach ($fileTypes as $fileType)
                    <div class="col-sm-6">
                        <div class="form-group mb-0">
                            {{--
                  <select id="file_type" name="file_type[]" class="form-control mb-0" style="border-right: 15px transparent solid;border-bottom: 15px;" {{ isset($preAnalystApproval->id) ? 'disabled' : '' }}>
                            <option selected="" value=""></option>
                            @foreach ($fileTypes as $fileType)
                            @if($fileType->name == "pre-analyst")
                            <option selected="" value="{{ $fileType->id }}">{{ $fileType->name }}</option>
                            @else
                            <option value="{{ $fileType->id }}">{{ $fileType->name }}</option>
                            @endif
                            @endforeach
                            </select>
                            --}}

                            {{-- tampilkan file upload satu-satu berurutan bukan list --}}

                            @if($fileType->name == "pre-analyst" || $fileType->name == "scoring")
                            <select id="file_type" name="file_type[]" class="form-control mb-2" style="border-right: 15px transparent solid;border-bottom: 15px;">
                                {{-- {{ isset($preAnalystApproval->id) ? 'disabled' : '' }} --}}
                                <option selected="" value="{{ $fileType->id }}">{{ $fileType->name }}</option>
                            </select>
                            {{-- @else --}}
                            {{-- <select id="file_type" name="file_type[]" class="form-control mb-0" style="border-right: 15px transparent solid;border-bottom: 15px;">
                    {{ isset($preAnalystApproval->id) ? 'disabled' : '' }}
                            <option value="{{ $fileType->id }}">{{ $fileType->name }}</option>
                            </select> --}}
                            {{-- <option value="{{ $fileType->id }}">{{ $fileType->name }}</option> --}}
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-5">
                        @if($fileType->name == "pre-analyst" || $fileType->name == "scoring")
                        <input name="filename[]" type="file" class="test-upload" multiple accept="image/png, image/jpeg, image/jpg, application/pdf" {{ isset($preAnalystApproval->id) ? 'disabled' : '' }} />
                        @endif
                    </div>
                    @endforeach
                    {{-- <div class="col-sm-5">
              <input name="filename[]" type="file" class="test-upload" multiple accept="image/png, image/jpeg, image/jpg, application/pdf"
              {{ isset($preAnalystApproval->id) ? 'disabled' : '' }} />
                </div> --}}
                <input name="fileIdsToBeDelete[]" type="hidden">
                <input name="fileNamesToBeDelete[]" type="hidden">
                <div class="col-sm-1">
                    <button id="btn-delete-field-upload_1" type="button" class="btn-circular-delete mr-2 d-none" data-toggle="tooltip" title="hapus field upload">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="form-group with-validation mt-3">
            <label for="colFormLabel" class="font-weight-bold">Catatan</label>
            <textarea id="note" name="note" class="form-control" {{ isset($preAnalystApproval->id) ? 'disabled' : '' }}>{{ isset($preAnalystApproval->note) ? $preAnalystApproval->note : ''}}</textarea>
            <div class="invalid-feedback"></div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <input type="hidden" id="project_id" name="project_id" value="{{ $projectId }}">
                <button id="btn-submit-preanalyst" type="button" data-next="2" class="btn btn-lg btn-next-step btn-block btn-primary" {{ isset($preAnalystApproval->id) ? 'disabled' : '' }}>
                    Submit
                </button>
            </div>
        </div>
    </div>
    </div>
</form>
