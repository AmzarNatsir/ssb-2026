<div class="modal fade" id="deleteDocumentModal" tabindex="-1" role="dialog" aria-labelledby="deleteDocumentModal" aria-modal="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content">
     	<div class="modal-header d-flex justify-content-center">
     		<h5 class="modal-title">Apakah anda ingin menghapus dokumen ini ?</h5>
     	</div>        
        <div class="modal-body text-center">
            {{-- <form method="post" enctype="multipart/form-data">
                @csrf --}}
                <input type="hidden" name="my_hidden_deletedIds" />
            	<button id="btn-confirm-delete" class="btn btn-lg btn-confirm-delete">
            		<i class="fa fa-check pr-1" aria-hidden="true"></i>Ya
            	</button>
            	<button id="btn-cancel-delete" class="btn btn-lg btn-cancel-delete">
            		<i class="fa fa-times pr-1" aria-hidden="true"></i>tidak
            	</button>
            {{-- </form> --}}
        </div>
     </div>
  </div>
</div>