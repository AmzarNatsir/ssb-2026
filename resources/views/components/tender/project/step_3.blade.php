<button type="button" class="btn-prev-step" data-prev="2" data-toggle="tooltip" title="step sebelumnya">
  <i class="ri-arrow-left-line"></i>
</button>

<div class="row d-flex align-items-center justify-content-center mb-4">
  <div class="col-sm-6 d-flex align-item-center">
    <h5 class="modal-title" id="customer-info">Customer</h5>
  </div>
  <div class="col-sm-6 d-flex justify-content-end align-item-center">
    <div class="custom-switch custom-switch-label-yesno custom-switch-xs pl-0 d-flex align-items-center">
      <small class="my-2 pr-2 text-right">data customer sdh ada sebelumnya</small>
      <input class="custom-switch-input" id="use_existing_customer" type="checkbox">
      <label class="custom-switch-btn" for="use_existing_customer"></label>
    </div>
  </div>
</div>
<div class="form-group d-none">
  <label for="colFormLabel">Pilih Customer</label>
  <select id="existing_customer_opt" name="existing_customer_opt" class="form-control mb-0" style="border-right: 15px transparent solid;border-bottom: 15px;">
    <option selected="" value=""></option>
    {{-- @if(isset($project->customer_id)) --}}
      @foreach ($customers as $item)
        @if(isset($project->customer_id) && $project->customer_id == $item->id)
            <option selected="" value="{{ $item->id }}">{{ $item->company_name }}</option>
        @else
            <option value="{{ $item->id }}">{{ $item->company_name }}</option>
        @endif
      @endforeach
    {{-- @endif --}}
 </select>
</div>
<div class="form-group with-validation">
  <label for="colFormLabel">Nama Customer<span id="tooltip_company_name" class="ri-information-line pl-1"></span></label>
  <input type="text" id="company_name" name="company_name" class="form-control" placeholder="" value="{{ isset($project->customer_id) ? $project->customer->company_name : '' }}">
  <div class="invalid-feedback"></div>
</div>
<div class="form-group with-validation">
  <label for="colFormLabel">Alamat</label>
  <input type="text" id="company_address" name="company_address" class="form-control" placeholder="" value="{{ isset($project->customer_id) ? $project->customer->company_address : '' }}">
  <div class="invalid-feedback"></div>
</div>
<div class="row mb-4">
  <div class="col-sm-6">
    <div class="form-group with-validation">
      <label for="colFormLabel">Nama CP</label>
      <input type="text" id="contact_person_name" name="contact_person_name" class="form-control" placeholder="" value="{{ isset($project->customer_id) ? $project->customer->contact_person_name : '' }}">
      <div class="invalid-feedback"></div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group with-validation">
      <label for="colFormLabel">No Telp/Handphone CP</label>
      <input type="text" id="contact_person_number" name="contact_person_number" class="form-control" placeholder="" value="{{ isset($project->customer_id) ? $project->customer->contact_person_number : '' }}">
      <div class="invalid-feedback"></div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <button id="btn-save-project" type="button" class="btn btn-lg btn-block btn-primary btn-save-project"><strong>Simpan Project</strong></button>
  </div>
</div>
