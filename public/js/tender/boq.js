$(document).ready(function(){
	console.log('BOQ!');	

	$('body').on('shown.bs.modal', '.modal', function() {
	  $(this).find('select').each(function() {
	    var dropdownParent = $(document.body);
	    if ($(this).parents('.modal.in:first').length !== 0)
	      dropdownParent = $(this).parents('.modal.in:first');
	    $(this).select2({
	      dropdownParent: dropdownParent,
	      theme: "bootstrap custom-container"
	    });
	  });
	});

  showSnackbar();

  $("#cost, #price").number(true, 0);
	var createBoqBtn =  $("#createBoqBtn"),
		startDate = $("#startDate"),
		endDate = $("#endDate");

	$("#startDate").val(moment().startOf('month').format('YYYY-MM-DD'));
    $("#endDate").val(moment().endOf('month').format('YYYY-MM-DD'));

	// hides the default search input
    $(document).on('ready', function(){
      $("#table-boq_filter").addClass('d-none');      
    });

	$("#searchFilter").on("keyup", function(){
      tableBOQ.search($(this).val()).draw();
    });

    $("#btn-filter-boq").on('click', function(e){
    	e.preventDefault();
    	tableBOQ.ajax.reload();
    });

    var tableBOQ = $("#table-boq").DataTable({
      "paging": true,
      "ordering": true,
      "info": true,
      "scrollX": true,
      "scrollY": "260px",
      "searching": true,
      "autoWidth": true,
      "pageLength": 5,// default page length
      "lengthChange": true,      
      "columnDefs":[{
          "width": "2rem",
          "targets": 0
      }],
      "dom": '<"top"f>rt<"bottom"lp><"clear">',
      createdRow: function(row, date, index){
        $(row).addClass("table-row tr-shadow")
      },
      "language":{        
        "lengthMenu": `          
          <select class="form-control" style="border-right: 10px transparent solid;border-bottom: 15px;">
            <option value='5'>5</option>
            <option value='10'>10</option>
            <option value='15'>15</option>
            <option value='-1'>All</option>
          </select>
        `,
        "emptyTable": "Tidak ada data",
        "processing": "Mohon tunggu meload data",
        "info": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
        "infoEmpty": "Menampilkan 0 s/d 0 dari 0 data",      
        "zeroRecords": "Tidak ada data ditemukan",      
        "paginate": {
          "first": "Pertama",
          "last": "Terakhir",
          "next": "Berikut",
          "previous": "Sebelumnya"
        }
      },
      "processing": true,
      "serverSide": false,
      ajax:{
        url: loadBOQUrl,
        dataSrc: "data",        
        "data": function (d) {
          return $.extend({}, d, {
            // "opsiKategori": opsiKategori.val(),
            "startDate": startDate.val(),
            "endDate": endDate.val()
          });
        },
      },
      "columns": [
        {
          data: null,
          className: "text-center pl-4",
          orderable: false,
          render: function(data, type, row){
            return `<input id="selectRow-${row.id}" data-bog-id="${row.boq ? row.boq.id : 0}" value="${row.id}" type="checkbox" name="selectRow" class="selectRow form-check-input pl-4">`;
          }
        },
        { data: "number" },
        { data: "name" },        
        { data: "created_at", className: "text-center" },        
        {          
          render: function(data, type, row){            
            if(row.boq){              
              return `<span class="pl-2">${row.boq.created_at}</span>`;
            } else {
              return '';
            }
          }
        },
        { data: "category.keterangan" },
        { data: "status.keterangan" },
        { data: "type.keterangan" }        
      ]
    });

    $("#table-boq_wrapper").find(".bottom").addClass("d-flex align-items-center justify-content-between pt-3");
    $("#table-boq_wrapper").find(".dataTables_length").addClass("d-flex w-50");

    $("#createBoqBtn").on('click', function(){
      ajaxRequest({
        url: boqCreateUrl + '/' + selectedRow,
        requestType: "GET"
      }, generateCreateBoqModal);
    });

    function generateCreateBoqModal(result) {      
      $("#create-boq-dynamic-content").html(result);
    }

    $("#action-tag-edit-boq").on('click', function(evt){
      evt.preventDefault();
      ajaxRequest({
        url: "/boq/ "+ selectedRow + "/edit",
        requestType: "GET"
      }, generateEditBoqModal);
    })

    function generateEditBoqModal(result){
     $("#edit-boq-dynamic-content").html(result); 
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

      if(qty.val().length < 1 || qty.val() == "") {
        formValidationArea(qty, "Belum mengisi Quantity");
      }

      if(target.val().length <= 0 || target.val() == "") {
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

    $(document).on('click', '.selectRow', function(){
      $('.selectRow').not($(this)).prop('checked', false);      
      if($(this).prop('checked')){        
        selectedRow = $(this).val();
        boqId = $(this).data('bogId');
        if(boqId > 0){
          $("#createBoqBtn").addClass('d-none');
          $("#action-tag-print-pdf").removeClass('d-none');
          $("#action-tag-edit-boq").removeClass('d-none');
        } else {
          $("#createBoqBtn").removeClass('d-none');
          $("#action-tag-edit-boq").addClass('d-none');
          $("#action-tag-print-pdf").addClass('d-none');
        }
        // console.log('boqId : ' , boqId)
        $("#action-tags").removeClass('d-none');
      } else {
        selectedRow = "";
        $("#action-tags").addClass('d-none');
      }
    });    

    $(document).on('click', '#action-tag-print-pdf', function(e){
      e.preventDefault();      
      cetakPDFUrl = cetakPDFUrl.replace(':projectId', selectedRow);
      window.open(cetakPDFUrl);
    });

      const uiTooltips = [{
        'selector':'#createBoqBtn',
        'title':'Create New BOQ'
      },{
        'selector':'#action-tag-edit-boq',
        'title':'Update BOQ'
      },{
        'selector':'#action-tag-print-pdf',
        'title':'print BOQ'
      },{
        'selector':'#action-tag-insert-item',
        'title': 'Tambah Item BOQ'
      }];
      
      for(const item of uiTooltips){
        $(`${item.selector}`).tooltip({          
          title: item.title
        })
      }

    // Submit BOQ
    $(document).on('click', '#btnSubmitBoq', function(e){
      e.preventDefault();
      beforeValidate();
      validateBoq();
      if (doesntHasValidationError()) {

        // $("#create-boq-form").submit();

        // $.ajax({
        //  type:'POST',
        //  url: boqCreateSubmitUrl,
        //  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        //  data:JSON.stringify({
        //   test: 'test',
        //  }),
        //  success:function(data){
        //     console.log(data);
        //     // $("#msg").html(data.msg);
        //  }
        // });

        let projectId = $("#project_id"),
          equipmentList = $("#equipment_list"),
          qty = $("#qty"),
          target = $("#target"),
          price = $("#price"),
          uraian = $("#desc"),
          cost = $("#cost");

        ajaxRequest({
          url: boqCreateSubmitUrl,
          requestType: "POST",
          data: JSON.stringify({
            "_token": $('#token').val(),
            'project_id': projectId.val(),
            'equipment_category_id': equipmentList.val(),
            'desc': uraian.val(),
            'qty': qty.val(),
            'target': target.val(),
            'price': price.val(),
            'cost': cost.val()
          })
        }, function(data){
            console.log(data);
            if(data){
              if(data.status == "1"){
                $("#msg_success").removeClass('d-none');
                $("#msg_success").html(data.message);
                resetForm();
                hideMessage("success");
              } else {
                $("#msg_error").removeClass('d-none');
                $("#msg_error").html(data.message);
                resetForm();
                hideMessage("error");
              }
            }            
        });

      }
    });

    function resetForm(){
      $("#boq_detail_id").val("");      
      $("#equipment_list").val(0).trigger('change');
      $("#qty").val("");
      $("#desc").val("");
      $("#price").val("");
      $("#target").val("");
      $("#cost").val("");
      $("#btnSubmitBoq").prop('disabled', false); 
    }

    function hideMessage(type) {
      var x = $('#msg_' + type);
      if(x.text().trim().length !== 0){        
        setTimeout(function() {
          x.toggleClass('d-none');
        }, 1000);  
      
        // setTimeout(function() {
        //     if (x.hasClass('d-none')){          
        //       x.toggleClass('d-none');
        //     }        
        // }, 5000);
      }

      $("#msg_" + type).delay(5000).fadeOut(1000);
      location.assign(boqIndexUrl);
    }


    $(document).on('click', ".absolute-close", function(){      

      $(".selectRow").each(function( index ) {
        $(this).prop('checked', false);
          $("#action-tags").toggleClass('d-none');        
      });

      selectedRow = "";
      tableBOQ.ajax.reload();
    })
  
    $("#create-boq-form").submit(function (e) {
      e.preventDefault();
    });

    $(document).on('click', '.selectBoqId', function(){            
      $('.selectBoqId').not($(this)).prop('checked', false);
      if($(this).prop('checked')){
        $("#equipment_list").val($(this).data('equipmentId')).trigger('change');        
      } else {
        selectedBoqItemId = "";
        $("#equipment_list").val(0).trigger('change');
      }      
    });

});