<button type="button" class="btn-prev-step" data-prev="1" data-toggle="tooltip" title="step sebelumnya">
  <i class="ri-arrow-left-line"></i>
</button>
<h5 class="modal-title mb-4" id="exampleModalLabel">Upload Dokumen</h5>

{{-- Fixed Dokumen Header --}}
<div class="row align-items-center">
  <div class="col-6">
    <div class="form-group mb-0 pb-0">
      <label class="font-weight-bold">Fixed Dokumen</label>
    </div>
  </div>
  <div class="flex-grow-1"></div>
  <div class="col-3">
    <button id="addFixedDocumentRow" class="btn btn-block rounded btn-success font-weight-bold">
      <span class="ri-add-circle-line h6 pr-1"></span>add
    </button>
  </div>
</div>
<hr/>

{{-- Fixed Dokumen Rows --}}
<div id="fixedDokumenRowWrapper">
  <div id="fixed_1" class="row" style="position: relative;">
    <div class="col-6">
      <div class="form-group with-validation">
        <select id="fixed_file_type" name="fixed_file_type[]" class="form-control mb-0" style="border-right: 15px transparent solid;border-bottom: 15px;">
          <option selected="" value=""></option>
          @foreach ($fixedfileTypes as $fileType)
            <option value="{{ $fileType->id }}">{{ $fileType->name }}</option>
          @endforeach
        </select>
        <div class="invalid-feedback"></div>
      </div>
    </div>
    <div class="col-6">
      <div class="form-group with-validation">
        <select id="fixed_file" name="fixed_file[]" class="form-control mb-0 fixed_file" style="border-right: 15px transparent solid;border-bottom: 15px;">
          <option selected="" value=""></option>
          @foreach ($fixedFile as $row)
            <option value="{{ $row->id }}">{{ $row->desc }}</option>
          @endforeach
        </select>
        <div class="invalid-feedback"></div>
      </div>
    </div>
    <div class="remove_fixed_row d-none" style="position: absolute;right:-25;top:8;">
      <a class="btn">
        <span class="ri-close-line text-danger h6"></span>
      </a>
    </div>
  </div>
</div>

@if(isset($project->files))
  <div class="row mt-3 mb-3 px-3" style="max-height:300px;overflow-x:scroll;overflow-y:hidden;">
    <div class="images-wrapper flex-row mb-3">

      {{-- jika file upload ada --}}
      @foreach ($project->files as $file)
        {{-- @if(file_exists(url("storage/project/".$file->name))) --}}
        @if(\Illuminate\Support\Facades\Storage::disk('public')->exists('/project/'.$file->name))

            {{-- jika file tipe gambar --}}
            @if(!in_array(pathinfo("storage/project".$file->name, PATHINFO_EXTENSION), ['pdf','xls','xlsx','doc','docx']))

              <a
                id="document-{{ $file->id }}"
                href="{{ url("storage/project/".$file->name) }}"
                data-lightbox="documents"
                data-title="{{ url("storage/project/".$file->name) }}"
                class="bg-light p-2 rounded-lg mr-2">

                <div class="d-flex flex-column mx-0 align-items-center">
                  <p class="badge badge-pill badge-light my-1">{{ $file->filetype->name }}</p>
                  <img
                      data-id="{{ $file->id }}"
                      src="{{ url("storage/project/".$file->name) }}"
                      class="rounded mb-0" width="90px" height="70px" style="object-fit: contain;"
                      data-toggle="tooltip"
                      title="{{ $file->filetype->name }}">
                </div>
              </a>

              <button
                id="btn-delete-document_{{ $file->id }}"
                data-filename="{{ $file->name }}"
                type="button"
                class="btn-circular-delete mr-2"
                data-toggle="tooltip"
                title="hapus dokumen">
                <i class="ri-delete-bin-line h6"></i>
              </button>

            @else

              <a id="document-{{ $file->id }}" href="{{ url("storage/project/".$file->name) }}" target="_blank" class="bg-light p-2 rounded-lg mr-2">
                <div class="d-flex flex-column mx-0 align-items-center">
                  <p class="badge badge-pill badge-light my-1">{{ $file->filetype->name }}</p>
                  <div class="d-flex justify-content-center align-items-center rounded mb-0 mr-2" style="width:100px;height:80px;">
                    <i class="fa fa-file-pdf-o" style="font-size:2rem;" aria-hidden="true"></i>
                  </div>
                </div>
              </a>

              <button
                id="btn-delete-document_{{ $file->id }}"
                data-filename="{{ $file->name }}"
                type="button"
                class="btn-circular-delete mr-2"
                data-toggle="tooltip"
                title="hapus dokumen">
                <i class="ri-delete-bin-line h6"></i>
              </button>

            @endif

        @else

        <div class="d-flex flex-column mx-0 align-items-center mr-2">
          <p class="badge badge-pill badge-light my-1">{{ $file->filetype->name }}</p>
          <div class="d-flex justify-content-center align-items-center rounded mb-0 mr-2" style="width:100px;height:80px;">
            <i class="ri-file-damage-fill" style="font-size:2rem;"></i>
          </div>
        </div>

        @endif

      @endforeach
    </div>
  </div>
@endif

<div class="row mt-2">
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
      <div class="col-sm-6">
        <div class="form-group mb-3">
          <select id="file_type" name="file_type[]" class="form-control mb-0" style="border-right: 15px transparent solid;border-bottom: 15px;">
            <option selected="" value=""></option>
            @foreach ($fileTypes as $fileType)
              <option value="{{ $fileType->id }}">{{ $fileType->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-sm-5">
        <input name="filename[]" type="file" class="test-upload" style="width:250px;text-overflow:clip;" multiple accept="image/png, image/jpeg, image/jpg, application/pdf">
        <input name="fileIdsToBeDelete[]" type="hidden">
        <input name="fileNamesToBeDelete[]" type="hidden">
      </div>
      <div class="col-sm-1">
        <button
            id="btn-delete-field-upload_1"
            type="button"
            class="btn-circular-delete mr-2 d-none"
            data-toggle="tooltip"
            title="hapus field upload">
            <i class="fa fa-times" aria-hidden="true"></i>
        </button>
      </div>
    </div>
  </div>

  <div id="upload_template"></div>
  <div class="row">
    <div class="col-sm-12">
      <button id="tambah_upload" class="btn btn-block btn-success">
        <i class="ri-add-circle-line h6 pr-1"></i>tambah dokumen upload
      </button>
    </div>
  </div>


<div class="row">
  <div class="col-sm-12 mt-2">
    <button type="button" data-next="3" class="btn btn-lg btn-next-step btn-block btn-primary">Next</button>
  </div>
</div>
