<div class="modal fade" id="addKomiteModal" tabindex="-1" role="dialog" aria-labelledby="addKomiteModal" aria-modal="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Anggota Komite</h5>
        <button type="button" id="closeAddKomiteModal" data-dismiss="modal" aria-label="Close">            
          <i class="ri-close-line"></i>
        </button>        
      </div>        
        <div class="modal-body">          
          <form id="add-komite-form" method="POST" action="{{ route('Komite.save') }}" enctype="multipart/form-data" autocomplete="off">
            @csrf
            <div class="form-group with-validation">
              <label for="colFormLabel">Filter Departemen</label>
              <select id="filter_dept" name="filter_dept" class="form-control mb-0" style="border-right: 15px transparent solid;border-bottom: 15px;">
                <option selected="" value="">Non Departemen</option>
                @foreach ($opsiDepartemen as $item)                   
                   <option value="{{ $item->id }}">{{ $item->nm_dept }}</option>
                @endforeach
              </select>
              <div class="invalid-feedback"></div>
            </div>
            <div class="form-group with-validation">
              <label for="colFormLabel">Filter Jabatan</label>              
              <select id="filter_jabt" name="filter_jabt" class="form-control mb-0" style="border-right: 15px transparent solid;border-bottom: 15px;">
                <option selected="" value=""></option>
                @foreach ($opsiJabatan as $item)                   
                   <option value="{{ $item->id }}">{{ $item->nm_jabatan }}</option>
                @endforeach
              </select>
              <div class="invalid-feedback"></div>
            </div>
            <div class="form-group with-validation">
              <label for="colFormLabel">Daftar Karyawan</label>
              <select id="daftar_kary" name="daftar_kary" class="form-control mb-0" style="border-right: 15px transparent solid;border-bottom: 15px;">
                <option selected="" value=""></option>                
                @foreach ($opsiKaryawan as $item)                   
                   <option value="{{ $item->id }}">{{ ucfirst($item->nm_lengkap) }}</option>
                @endforeach
              </select>
              <div class="invalid-feedback"></div>
            </div>            
            {{-- <div class="form-group with-validation">
              <label for="colFormLabel">Urutan Approve</label>
              <select id="order" name="order" class="form-control mb-0" style="border-right: 15px transparent solid;border-bottom: 15px;">
                <option selected="" value=""></option>
                @for ($i = 1; $i <= 10; $i++)
                  <option value="{{ $i }}">{{ $i }}</option>
                @endfor
              </select>
              <div class="invalid-feedback"></div>
            </div> --}}            
            <div class="row">
              <div class="col-sm-12">
                <button type="button" id="save-komite-btn" class="btn btn-lg btn-next-step btn-block btn-primary">Simpan</button>
              </div>
            </div>
          </form>
        </div>
     </div>
  </div>
</div>