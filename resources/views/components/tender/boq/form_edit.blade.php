{{-- {{ dd($boq) }} --}}
<form id="edit-boq-form" method="POST" action="{{ route('boq.update') }}" enctype="multipart/form-data" autocomplete="off">
  @csrf
  <div class="modal-content">
    <div class="modal-body">
    	<button type="button" class="absolute-close" data-dismiss="modal" aria-label="Close">
    		<i class="ri-close-line"></i>
    	</button>
    	<div class="row flex-row align-items-center mb-3">
    		<h6 class="font-weight-bold">
    			<span class="ri-file-text-line pr-2"></span>UPDATE BILL OF QUANTITY
    		</h6>
        <div class="d-flex flex-grow-1"></div>
        <div id="boq-action-tags" class="d-flex align-items-center d-none">
          <button id="action-tag-delete-item" type="button" class="tag tag-danger p-2 mr-2">
            <i class="las la-trash-alt"></i>
          </button>
        </div>
            {{-- <p>{{ Config::get('constants.alat_berat')[1] }}</p> --}}
    	</div>

      <div id="msg_success" class="alert alert-success d-none" role="alert"></div>
      <div id="msg_error" class="alert alert-danger d-none" role="alert"></div>

      <div class="row mb-3 table-boq-container">
            <table class="table table-xs table-boq">
                <thead>
                    <tr>
                        <th></th>
                        <th style="width:1%;">NO.</th>
                        <th>URAIAN</th>
                        <th>EQUIPMENT</th>
                        <th>QTY</th>
                        <th>TARGET</th>
                        <th>HARGA</th>
                        <th>BIAYA</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($boq as $boq)
                        @if($boq->detail->count())
                            @foreach($boq->detail as $item)
                                <tr style="line-height:.5rem;">
                                    <td>
                                        <input type="checkbox" class="selectBoqId" value="{{ $item->id }}" data-equipment-id="{{ $item->equipment->id }}" />
                                    </td>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $item->desc }}</td>
                                    <td>{{ strtoupper($item->equipment->name) }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>{{ $item->target }}</td>
                                    <td>{{ number_format($item->price) }}</td>
                                    <td>{{ number_format($item->cost) }}</td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                </tbody>
            </table>
            <hr/>
        </div>
    	<div class="form-group">
    		<label for="colFormLabel" class="font-weight-bold">Nama Project</label>
        <p class="pl-3 py-1 font-weight-bold">{{ $project->name }}</p>
    	</div>
    	<div class="row">
    		<div class="col-sm-9">
	    		<div class="form-group with-validation">
	    			<label for="colFormLabel" class="font-weight-bold">Equipment</label>
		    		<select id="equipment_list" name="equipment_list" class="form-control" style="border-right: 8px transparent solid;border-bottom: 15px;">
		    			<option value=""></option>
		    			@foreach($equipmentCategory as $key => $value)
                <option value="{{ $value->id }}">{{ strtoupper($value->name) }}</option>
              @endforeach
		    		</select>
		    		<div class="invalid-feedback"></div>
	    		</div>
    		</div>
    		<div class="col-sm-3">
    			<div class="form-group with-validation">
	    			<label for="colFormLabel" class="font-weight-bold">Quantity</label>
		    		<input type="number" id="qty" name="qty" min="1" class="form-control" />
		    		<div class="invalid-feedback"></div>
	    		</div>
    		</div>
    	</div>

    	<div class="row">
    		<div class="col-sm-6">
	    		<div class="form-group with-validation">
	    			<label for="colFormLabel" class="font-weight-bold">Target (HM)</label>
	    			<input type="number" id="target" name="target" min="1" class="form-control" />
	    			<div class="invalid-feedback"></div>
	    		</div>
    		</div>
    		<div class="col-sm-6">
    			<div class="form-group with-validation">
	    			<label for="colFormLabel" class="font-weight-bold">Harga (Rp/HM)</label>
		    		<input type="text" id="price" name="price" min="1" class="form-control" />
		    		<div class="invalid-feedback"></div>
	    		</div>
    		</div>
    	</div>

      <div class="form-group with-validation">
        <label for="colFormLabel" class="font-weight-bold">Biaya</label>
        <input type="text" id="cost" name="cost" class="form-control" />
        <div class="invalid-feedback"></div>
      </div>

    	<div class="form-group with-validation">
    		<label for="colFormLabel" class="font-weight-bold">Uraian</label>
    		<textarea id="desc" name="desc" rows="2" class="form-control"></textarea>
    		<div class="invalid-feedback"></div>
    	</div>

    	<div class="form-group">
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
        <input type="hidden" id="boq_id" name="boq_id" value="{{ $boq->id }}" />
        <input type="hidden" id="boq_detail_id" name="boq_detail_id" value=""/>
        <input type="hidden" id="project_id" name="project_id" value="{{ $projectId }}" />
    		<button type="button" id="btnSubmitItemBoq" class="btn btn-lg btn-block btn-primary">Submit</button>
    	</div>

    </div>
  </div>
</form>
<script type="text/javascript">
    $(document).ready(function(){

        $("#cost, #price").number(true, 0);
        showSnackbar();
        // $("#btnSubmitBoq").prop('disabled', true);
        var boqDetail = @json($boq->detail);

        const uiTooltips = [{
          'selector':'#action-tag-delete-item',
          'title': 'Hapus Item BOQ'
        }];

        for(const item of uiTooltips){
          $(`${item.selector}`).tooltip({
            title: item.title
          })
        }

        $(document).on('click', '.selectBoqId', function(){
          $('.selectBoqId').not($(this)).prop('checked', false);
          if($(this).prop('checked')){
            selectedBoqItemId = $(this).data('equipmentId');
            selectedBoqDetailId = $(this).val();
            fillFormEdit($(this).val());
            $("#boq-action-tags").removeClass('d-none');
          } else {
            selectedBoqItemId = "";
            selectedBoqDetailId = "";
            resetForm();
            $("#boq-action-tags").addClass('d-none');
          }
        });

        function fillFormEdit(bogDetailId){
          let elem = boqDetail.find(function(elem){
            return elem.id == bogDetailId;
          });

          $("#boq_detail_id").val(bogDetailId);
          $("#equipment_list").val(elem.equipment_id);
          $("#qty").val(elem.qty);
          $("#desc").val(elem.desc);
          $("#price").val(elem.price);
          $("#target").val(elem.target);
          $("#cost").val(elem.cost);
          $("#btnSubmitBoq").prop('disabled', false);
        }

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

        function validateBoq(){
          let equipmentList = $("#equipment_list"),
              qty = $("#qty"),
              target = $("#target"),
              price = $("#price"),
              uraian = $("#desc"),
              cost = $("#cost");

              if(equipmentList.val() == "" || equipmentList.val() == "0") {
                formValidationArea(equipmentList, "Belum memilih Equipment!");
              }

              let elem = boqDetail.find(function(elem){
                return elem.equipment_category_id == equipmentList.val();
              });

              if(elem && !selectedBoqDetailId){
                formValidationArea(equipmentList, "Equipment Sudah ada sebelumnya!");
              }

              if(qty.val().length < 1 || qty.val() == "") {
                formValidationArea(qty, "Belum mengisi Quantity");
              }

              if(target.val().length < 1  || target.val() < 1 || target.val() == "") {
                formValidationArea(target, "Belum mengisi Target");
              }

              if(price.val().length < 1 || price.val() == "") {
                formValidationArea(price, "Belum mengisi Harga");
              }

              if(uraian.val().length < 1 || uraian.val() == "") {
                formValidationArea(uraian, "Belum mengisi Uraian");
              }

              if(cost.val().length < 1 || cost.val() == "") {
                formValidationArea(cost, "Belum mengisi Biaya");
              }

              if(cost.val() < 1) {
                formValidationArea(cost, "Belum mengisi Biaya atau Biaya Kosong");
              }
        }

        $(document).on('click', '.selectBoqId', function(){
          $('.selectBoqId').not($(this)).prop('checked', false);
          if($(this).prop('checked')){
            $("#equipment_list").val($(this).data('equipmentId')).trigger('change');
          } else {
            $("#equipment_list").val(0).trigger('change');
          }
        });

        $(document).on('click', '#btnSubmitItemBoq', function(){
          beforeValidate();
          validateBoq();
          if (doesntHasValidationError()) {
            $("#edit-boq-form").submit();
          }
        })

        $("#edit-boq-form").submit(function (e) {
            e.preventDefault();
            $("#btnSubmitItemBoq")
              .attr("disabled", "true")
              .text("Processing...");
              this.submit();
          });

        $("#action-tag-delete-item").on('click', function(evt){
          evt.preventDefault();
          ajaxRequest({
            url: boqDeleteItemUrl,
            requestType:"POST",
            data: JSON.stringify({
              "_token": $('#token').val(),
              "boq_detail_id": $("#boq_detail_id").val()
            })
          }, function(data){
            if(data.status == "1"){
              $("#msg_success").removeClass('d-none');
              $("#msg_success").html(data.message);
              hideMessage("success");
            } else {
              $("#msg_error").removeClass('d-none');
              $("#msg_error").html(data.message);
              hideMessage("error");
            }
          })
        });

        function redirect(url){
          location.assign(url);
        }

        function hideMessage(type) {
          var x = $('#msg_' + type);
          if(x.text().trim().length !== 0){
            setTimeout(function() {
              x.toggleClass('d-none');
            }, 1000);
          }

          $("#msg_" + type).delay(5000).fadeOut(1000);
          location.assign(boqIndexUrl);
        }

        $(document).on('click', '.absolute-close', function(){
            resetForm();
        });
});
</script>
