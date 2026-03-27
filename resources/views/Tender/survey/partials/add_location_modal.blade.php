<div class="modal fade" id="addLocationModal" tabindex="-1" role="dialog" aria-labelledby="addLocationModal" aria-modal="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">lokasi</h5>
        <button type="button" id="closeLocationModal" data-dismiss="modal" aria-label="Close">            
          <i class="ri-close-line"></i>
        </button>        
      </div>        
        <div class="modal-body">          
          <form id="add-location-form" method="POST" action="{{ route('project.store') }}" enctype="multipart/form-data" autocomplete="off">
            @csrf
            <div class="form-group with-validation">
              <label for="colFormLabel">Nama Lokasi<span class="ri-information-line pl-1" data-toggle="tooltip" title="nama atau deskripsi dari titik/lokasi survey mis. jalan utama, lokasi project, dll"></span></label>
              <input type="text" id="location_name" name="location_name" class="form-control" placeholder="">
              <div class="invalid-feedback"></div>              
            </div>
            <div class="form-group">
              <label for="colFormLabel">Latitude<span class="ri-information-line pl-1" data-toggle="tooltip" title="data latitude mis. -5.183249872179954"></span></label>
              <input type="text" id="lat" name="lat" value="" class="form-control">
              {{-- placeholder="-5.183249872179954" --}}
            </div>
            <div class="form-group">
              <label for="colFormLabel">Longitude<span class="ri-information-line pl-1" data-toggle="tooltip" title="data latitude mis. 112.25301748676536"></span></label>
              <input type="text" id="lng" name="lng" value="" class="form-control">
              {{-- placeholder="112.25301748676536" --}}
            </div>
            <div class="form-group with-validation">
              <label for="colFormLabel">Notes</label>
              <textarea id="location_note" name="location_note" class="form-control" style="line-height:1.5rem;"></textarea>
              <div class="invalid-feedback"></div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <input type="hidden" id="id-edit" name="id-edit" />
                <input type="hidden" id="index-location" name="index-location" />
                <button type="button" id="save-location-btn" class="btn btn-lg btn-next-step btn-block btn-primary">Simpan Lokasi</button>
              </div>
            </div>
          </form>
        </div>
     </div>
  </div>
</div>