$(document).ready(function(){
	console.log('preanalys ready!');

  $(document).tooltip({ selector: '[data-toggle="tooltip"]' });
  $(document).on('click', '[data-toggle="tooltip"]', function(){
    var $this = $(this);
    $this.tooltip("dispose");
  });

  const uiTooltips = [{
    'selector':'#action-tag-submit-preanalyst',
    'title':'Form Rekomendasi'
  },{
    'selector':'#action-tag-view-preanalyst',
    'title':'Lihat Hasil Rekomendasi'
  }];

  for(const item of uiTooltips){
    $(`${item.selector}`).tooltip({          
      title: item.title
    })  
  }

	// initialize page variables
	var opsiStatus = $("#opsiStatus"),
			startDate = $("#startDate"),
			endDate = $("#endDate");

  // using current month as default values
  // $("#startDate, #endDate").val(moment().format('YYYY-MM-DD'));
  // $("#startDate, #endDate").attr("max", moment().format('YYYY-MM-DD'));
  $("#startDate").val(moment().startOf('month').format('YYYY-MM-DD'));
  $("#endDate").val(moment().endOf('month').format('YYYY-MM-DD'));

	// handle snackbar
	showSnackbar();

	var tablePreAnalystApproval = $("#table-preanalyst-approval").DataTable({
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
        url: loadPreAnalystApprovalUrl,
        dataSrc: "data",        
        "data": function (d) {
          return $.extend({}, d, {
            "startDate": startDate.val(),
            "endDate": endDate.val(),
            "opsiStatus": opsiStatus.val()
          });
        },               
    },
    "columns": [
      {
        data: null,
        className: "text-center pl-4",
        orderable: false,
        render: function(data, type, row){
          // console.log(row.is_approve)
          return `<input id="selectRow-${row.id}" data-completed="${row.is_approve}" value="${row.id}" type="checkbox" name="selectRow" class="selectRow form-check-input pl-4">`;
        }
      },
      { data: "name" },
      { data: "source", className: "text-center" },
      { data: "value", render: $.fn.dataTable.render.number(','), className: "text-right" },
      { data: "created_at", className: "text-center" },
      { data: "location", className: "text-center" },      
      {
        render: function(data, type, row){          
          if(row.is_approve){
            let isApprove;
            if(row.is_approve == 1){
              isApprove = "Disetujui"
            } else if(row.is_approve == 0){
              isApprove = "DiTolak"
            }
            return isApprove;
          } else {
            return '';
          }
        }
      }      
    ]

	});


	// custom style datatable
	$("#table-preanalyst-approval_wrapper").find(".bottom").addClass("d-flex align-items-center justify-content-between pt-3");
  $("#table-preanalyst-approval_wrapper").find(".dataTables_length").addClass("d-flex w-50");
  $("#table-preanalyst-approval_filter").addClass('d-none');

  // handle Text Search filtering
  $("#searchFilter").on("keyup", function(){
    tablePreAnalystApproval.search($(this).val()).draw();
  });

  // handle Button Filtering
  $("#btn-filter-project").on('click', function(e){
    e.preventDefault();
    tablePreAnalystApproval.ajax.reload();    
  });

  // handle checkbox
  $(document).on('click', '.selectRow', function(){
    $('.selectRow').not($(this)).prop('checked', false);      
    if($(this).prop('checked')){        
      selectedRow = $(this).val()      
      $("#action-tags").removeClass('d-none');

      let completed = $(this).data('completed');      
      if(completed === null){
        $("#action-tag-submit-preanalyst").removeClass('d-none');
        $("#action-tag-view-preanalyst").addClass('d-none');        
      } else {      
        $("#action-tag-submit-preanalyst").addClass('d-none');
        $("#action-tag-view-preanalyst").removeClass('d-none');
      }

    } else {
      selectedRow = "";
      $("#project_id").val(selectedRow);
      $("#action-tags").addClass('d-none');
    }
  });

  // $("#preAnalystModal").on('shown.bs.modal',function(){        
  //   $('input:hidden[name=project_id]').val(selectedRow);    
  // });

  $(document).on('show.bs.modal','#preAnalystModal',function(){        
    
    $("#create-preanalyst-form input:hidden[name=project_id]").val(selectedRow);
    // $('input:hidden[name=project_id]').val(selectedRow);    
  });

  $("#action-tag-submit-preanalyst").on('click', function(){
    ajaxRequest({
      url: submitPreanalystUrl + '/' + selectedRow,
      requestType: 'GET',
    }, generateSubmitPreanalystModal);
  });

  function generateSubmitPreanalystModal(result){        
    $("#view-preanalyst-dynamic-content").html();
    $("#preanalyst-dynamic-content").html(result)
  }


  $("#action-tag-view-preanalyst").on('click', function(){
    ajaxRequest({
      url: "/preanalyst/edit/" + selectedRow,
      requestType: 'GET',
    }, generateViewPreanalystModal);
  });

  function generateViewPreanalystModal(result){        
    $("#preanalyst-dynamic-content").html()
    $("#view-preanalyst-dynamic-content").html(result);
  }


  function validatePreAnalystForm(){

    let rekomendasi = $("#rekomendasi");
    
    if(rekomendasi.val() == ""){
      formValidationArea(rekomendasi, "Rekomendasi wajib dipilih");
    }

    // if(surveySummaryNote.val().length > 0 && surveySummaryNote.val().length < 10){
    //   formValidationArea(surveySummaryNote, "Ringkasan Hasil survey minimal 10 karakter");
    // }

    // if($("#survey-locations").children("[id^='location-']").length == 0){
    //   formValidationArea(surveyLocationsDomElem, "minimal satu lokasi survey wajib diisi")
    // }
  }

  $(document).on('click', "#create-preanalyst-form #btn-submit-preanalyst", function(evt){
    evt.preventDefault();
    beforeValidate();
    validatePreAnalystForm();
    if (doesntHasValidationError()) {
      $("#create-preanalyst-form").submit();
    }
  });

  $("#create-preanalyst-form").submit(function (e) {
    e.preventDefault();  
    $("#btn-submit-preanalyst")
      .attr("disabled", "true")
      .text("Processing...");        
      this.submit();
  });

})