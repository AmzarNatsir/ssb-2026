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
            <div class="form-group">
              <label for="colFormLabel">Nama Lokasi</label>
              <input type="text" id="location" name="location" class="form-control" placeholder="">              
            </div>
            <div class="form-group">
              <label for="colFormLabel">Koordinat</label>
              <input type="text" id="coordinate" name="coordinate" class="form-control" placeholder="">              
            </div>
            <div class="row">
              <div class="col-sm-12">
                <button type="button" id="save-location-btn" class="btn btn-lg btn-next-step btn-block btn-primary">Simpan Lokasi</button>
              </div>
            </div>
          </form>
        </div>
     </div>
  </div>
</div>