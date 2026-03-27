<form id="create-boq-form" method="POST" action="{{ route('boq.store') }}" enctype="multipart/form-data" autocomplete="off">
  @csrf
  <div class="modal-content">
    <div class="modal-body">
    	<button type="button" class="absolute-close" data-dismiss="modal" aria-label="Close">
    		<i class="ri-close-line"></i>
    	</button>
    	<div class="row mb-3">
    		<h6 class="font-weight-bold">
    			<span class="ri-file-text-line pr-2"></span>NEW BILL OF QUANTITY
    		</h6>
    	</div>

        <div id="msg_success" class="alert alert-success d-none" role="alert"></div>
        <div id="msg_error" class="alert alert-danger d-none" role="alert"></div>

    	<div class="form-group mt-4">
    		<label for="colFormLabel" class="font-weight-bold">Nama Project</label>
            <p class="pl-3 py-1 font-weight-bold">{{ $project->name }}</p>
    	</div>
    	<div class="row">
    		<div class="col-sm-9">
	    		<div class="form-group with-validation">
	    			<label for="colFormLabel" class="font-weight-bold">Equipment</label>
                    {{-- {{ dd($equipmentCategory) }} --}}
		    		<select id="equipment_list" name="equipment_list" class="form-control" style="border-right: 8px transparent solid;border-bottom: 15px;">
		    			<option value=""></option>
		    			@foreach($equipmentCategory as $key => $value)
		    				<option value="{{ $value->id }}">{{ $value->name }}</option>
		    			@endforeach
		    		</select>
		    		<div class="invalid-feedback"></div>
	    		</div>
    		</div>
    		<div class="col-sm-3">
    			<div class="form-group with-validation">
	    			<label for="colFormLabel" class="font-weight-bold">Quantity</label>
		    		<input type="number" id="qty" name="qty" class="form-control" />
		    		<div class="invalid-feedback"></div>
	    		</div>
    		</div>
    	</div>

    	<div class="row">
    		<div class="col-sm-6">
	    		<div class="form-group with-validation">
	    			<label for="colFormLabel" class="font-weight-bold">Target (HM)</label>
	    			<input type="number" id="target" name="target" class="form-control" />
	    			<div class="invalid-feedback"></div>
	    		</div>
    		</div>
    		<div class="col-sm-6">
    			<div class="form-group with-validation">
	    			<label for="colFormLabel" class="font-weight-bold">Harga (Rp/HM)</label>
		    		<input type="text" id="price" name="price" class="form-control" />
		    		<div class="invalid-feedback"></div>
	    		</div>
    		</div>
    	</div>

        <div class="form-group with-validation">
            <label for="colFormLabel" class="font-weight-bold">Biaya</label>
            <input type="text" id="cost" name="cost" class="form-control" readonly/>
            <div class="invalid-feedback"></div>
        </div>

    	<div class="form-group with-validation">
    		<label for="colFormLabel" class="font-weight-bold">Uraian</label>
    		<textarea id="desc" name="desc" rows="2" class="form-control"></textarea>
    		<div class="invalid-feedback"></div>
    	</div>

    	<div class="form-group">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <input type="hidden" id="project_id" name="project_id" value="{{ $projectId }}" />
    		<button type="button" id="btnSubmitBoq" class="btn btn-lg btn-block btn-primary">Submit</button>
    	</div>

    </div>
  </div>
</form>
<script type="text/javascript">
$(document).ready(function(){

    $(document).on('change', '#qty, #target, #price', function(){
        let qty = $("#qty").val()
        let target = $("#target").val()
        let price = $("#price").val()
        $("#cost").val(qty*target*price)
    });

    function resetForm(){
        $("#boq_detail_id").val("");
        $("#equipment_list").val("");
        $("#qty").val("");
        $("#desc").val("");
        $("#price").val("");
        $("#target").val("");
        $("#cost").val("");
        $("#btnSubmitBoq").prop('disabled', false);
    }

    $(document).on('click', '.absolute-close', function(){
        resetForm();
    });

})
</script>
