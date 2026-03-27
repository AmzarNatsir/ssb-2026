{{-- Step 1 - Project description --}}
<h5 class="modal-title mb-4" id="exampleModalLabel">Project Info</h5>
<div class="row">
  <div class="col-sm-7">
    <div class="form-group with-validation">
      <label for="colFormLabel">Nama project</label>
      <input type="text" id="project_name" name="project_name" value="{{ isset($project) ? $project->name : '' }}" class="form-control is-loading" placeholder="">
      <div class="invalid-feedback"></div>
    </div>
  </div>
  <div class="col-sm-5">
    <div class="form-group with-validation">
      <label for="colFormLabel">Kategori</label>
      <select id="project_category" name="project_category" class="form-control mb-0" style="border-right: 15px transparent solid;border-bottom: 15px;">
        <option selected="" value=""></option>
        @foreach ($opsiKategoriProject as $item)
           @if(isset($project->category_id) && $project->category_id == $item->id)
             <option selected="" value="{{ $item->id}}">{{ $item->keterangan }}</option>
           @else
           <option value="{{ $item->id }}">{{ $item->keterangan }}</option>            
           @endif
        @endforeach
     </select>
     <div class="invalid-feedback"></div>
    </div>
  </div>
</div>
<div class="form-group">
  <label for="colFormLabel">Nomor Project</label>  
  <input type="text" id="project_number" name="project_number" value="{{ isset($project) ? $project->number : $projectNumber }}" readonly="true" class="form-control" placeholder="">
</div>
<div class="form-group">
  <label for="colFormLabel">Keterangan</label>
  <input type="text" id="project_desc" name="project_desc" value="{{ isset($project) ? $project->desc : '' }}" class="form-control" placeholder="">
</div>
<div class="row">
  <div class="col-sm-6">
    <div class="form-group with-validation">
      <label for="colFormLabel">Tipe Project</label>
      <select id="project_type" name="project_type" class="form-control mb-0" style="border-right: 15px transparent solid;border-bottom: 15px;">
         <option selected="" value=""></option>
         @foreach ($opsiTipeProject as $item)
            @if(isset($project->tipe_id) && $project->tipe_id == $item->id)
              <option selected="" value="{{ $item->id}}">{{ $item->keterangan }}</option>
            @else
            <option value="{{ $item->id }}">{{ $item->keterangan }}</option>            
            @endif
         @endforeach
      </select>
      <div class="invalid-feedback"></div>
    </div>
  </div>
  <div class="col-sm-6">    
    <div class="form-group">
      <label for="colFormLabel">Lokasi</label>      
        <div class="row">
          <div class="col">
              <div class="input-group">
                  <input class="form-control py-2 border-right-0" type="text" id="project_location" name="project_location">
                  <span class="input-group-append">
                      <div class="input-group-text">
                        {{-- <a id="add_location" data-toggle="modal" data-backdrop="static" data-target="#addLocationModal">
                          <i class="ri-map-2-line" data-toggle="tooltip" title="Tambah Koordinat (opsional)"></i>
                        </a> --}}
                      </div>
                  </span>
              </div>
          </div>
        </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-6">
    <div class="form-group with-validation">
      <label for="colFormLabel">Sumber informasi project</label>
      <input type="text" id="project_source" name="project_source" value="{{ isset($project) ? $project->source : '' }}" class="form-control is-loading" placeholder="">
      <div class="invalid-feedback"></div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group">
      <label for="colFormLabel">Estimasi nilai project</label>
      <input type="text" id="tender_value" name="tender_value" value="{{ isset($project) ? number_format($project->value) : '' }}" class="form-control is-loading number-separator " style="text-align:right;" placeholder="">
    </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-6">
    <div class="form-group with-validation">
      <label for="colFormLabel">Target Tender</label>      
      <select id="project_target" name="project_target" class="form-control mb-0" style="border-right: 15px transparent solid;border-bottom: 15px;">                  
          <option selected="" value=""></option>
          @foreach ($opsiTargetTender as $key => $val)
            @if(isset($project->target_tender_id) && $project->target_tender_id == $key)
              <option selected="" value="{{ $key }}">{{ $val }}</option>
            @else
              <option value="{{ $key }}">{{ $val }}</option>
            @endif
          @endforeach
      </select>
      <div class="invalid-feedback"></div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group with-validation">
      <label for="colFormLabel">Jenis Project</label>      
      <select id="project_jenis" name="project_jenis" class="form-control mb-0" style="border-right: 15px transparent solid;border-bottom: 15px;">                  
        <option selected="" value=""></option>
          @foreach ($opsiJenisProject as $key => $val)
          @if(isset($project->jenis_project_id) && $project->jenis_project_id == $key)
          <option selected="" value="{{ $key }}">{{ $val }}</option>
        @else
          <option value="{{ $key }}">{{ $val }}</option>
        @endif
          @endforeach
      </select>
      <div class="invalid-feedback"></div>
    </div>
  </div>
</div>

{{-- Tanggal Mulas & akhir pengerjaan --}}
{{-- 
<div class="row">
  <div class="col-sm-6">
     <div class="form-group with-validation">
        <label for="colFormLabel">Tanggal Mulai Pengerjaan</label>
        <input type="date" id="project_start_date" name="project_start_date" min="" max="" value="{{ isset($project->start_date) ? $project->start_date : '' }}" class="form-control" placeholder="">
        <div class="invalid-feedback"></div>
     </div>
  </div>
  <div class="col-sm-6">
     <div class="form-group with-validation">
        <label for="colFormLabel">Tanggal Selesai Pengerjaan</label>
        <input type="date" id="project_end_date" name="project_end_date" value="{{ isset($project->end_date) ? $project->end_date : '' }}" class="form-control" placeholder="">
        <div class="invalid-feedback"></div>
     </div>
  </div>
</div>
--}}
<div class="row">
  <div class="col-sm-12">
    <button type="button" data-next="2" class="btn btn-lg btn-next-step btn-block btn-primary">Next</button>
  </div>
</div>