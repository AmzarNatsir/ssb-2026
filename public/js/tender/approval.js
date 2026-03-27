$(function(){

  // tooltips
  $(document).tooltip({ selector: '[data-toggle="tooltip"]' });
  $(document).on('click', '[data-toggle="tooltip"]', function(){
    var $this = $(this);
    $this.tooltip("dispose");
  });    

 var dateOption = $("#dateOption"),
      startDate = $("#startDate"),
      endDate = $("#endDate");

 //  $("#startDate, #endDate").val(moment().format('YYYY-MM-DD'))  
 //  $("#startDate, #endDate").attr("max", moment().format('YYYY-MM-DD'))

 showSnackbar();
 
 $("#startDate").val(moment().startOf('month').format('YYYY-MM-DD'));
 $("#endDate").val(moment().endOf('month').format('YYYY-MM-DD'));

 // hides default Filter/search input
  $(document).on('ready', function(){
    $("#table-approval_filter").addClass('d-none');  
  });

  $("#searchFilter").on("keyup", function(){
    tableApproval.search($(this).val()).draw();
  });

  $("#btn-filter-project").on('click', function(e){
    e.preventDefault();
    tableApproval.ajax.reload();    
  });

  // datatable baru
  var tableApproval = $("#table-approval").DataTable({
    "paging": true,
    "ordering": true,
    "info": true,
    "scrollX": true,
    "scrollY": 200,
    "searching": true,
    "autoWidth": true,
    "pageLength": 5, // default page length
    "lengthChange": true,
    "columnDefs":[
    {
        "width": "2rem",
        "targets": 0
    }],
    "dom": '<"top"f>rt<"bottom"lp><"clear">',
    createdRow: function(row, data, index){      
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
    ajax: {
      url: loadApprovalTableUrl,
      dataSrc: "data",
      data: function(d){
        return $.extend({}, d, {
          "dateOption": dateOption.val(),
          "startDate": startDate.val(),
          "endDate": endDate.val()
        });
      }      
    },
    "columns": [
      {
        data: null,
        className:"text-center pl-4",            
        orderable:false,
        render: function(data, type, row){              
          return `<input id="selectRow-${row.id}" value="${row.id}" type="checkbox" name="selectRow" class="selectRow form-check-input pl-4">`;
        }
      },
      { data: 'project_name' },
      { data: 'project_date', className:"text-center" },
      { data: 'survey_completed_by', className:"text-center" },      
      {          
        render: function(data, type, row){
          
            if(row.survey_completed_by){              
              return `<span class="pl-2">${row.survey_completed_on}</span>`;
            } else {
              return '-';
            }          
        },        
      },
      {
        render: function(data, type, row){
          
            if(row.pm_approval !== null){              
              return `<span class="pl-2">${row.pm_approval === 1 ? "setuju" : "tolak" }</span>`;
            } else {
              return '-';
            }          
        },        
      },
      {
        render: function(data, type, row){
            console.log(row)
            if(row.manops_approval !== null){              
              return `<span class="pl-2">${row.manops_approval === 1 ? "setuju" : "tolak" }</span>`;
            } else {
              return '-';
            }          
        },        
      },
      {
        render: function(data, type, row){
          
            if(row.direktur_approval !== null){              
              return `<span class="pl-2">${row.direktur_approval === 1 ? "setuju" : "tolak" }</span>`;
            } else {
              return '-';
            }          
        },        
      },
    ]
  });

  $("#table-approval_wrapper").find(".bottom").addClass("d-flex align-items-center justify-content-between pt-3");
  $("#table-approval_wrapper").find(".dataTables_length").addClass("d-flex w-50");
  $("#table-approval_filter").addClass('d-none');

  // project approve tags tooltips
  // $(document).on('ready', function(){
      const uiTooltips = [{
        'selector':'#action-tag-approve-project',
        'title': 'Approve Project'
      },{
        'selector':'#action-tag-cetak-approval',
        'title': 'Cetak Hasil Approval'
      }];

      for(const item of uiTooltips){
        $(`${item.selector}`).tooltip({
          title: item.title
        })  
      }
  // });

    // show or hide project approve tags
    $(document).on('click', '.selectRow', function(){
      $('.selectRow').not($(this)).prop('checked', false);      
      if($(this).prop('checked')){
        selectedRow = $(this).val();
        $("#project-approve-tags").removeClass('d-none');
        $("#project_id").val(selectedRow);
      } else {
        selectedRow = "";
        $("#project-approve-tags").addClass('d-none');
        $("#project_id").val();
      }
    });

    $(document).on('click', '#action-tag-cetak-approval', function(e){
      e.preventDefault();      
      cetakPDFUrl = cetakPDFUrl.replace(':projectId', selectedRow);
      window.open(cetakPDFUrl);
    });

    // load approval modal
    // edit survey
  $("#action-tag-approve-project").on('click', function(){
    ajaxRequest({
      url: "/project/load/approval/" + selectedRow,      
      requestType: 'GET',
    }, generateFormApprovalForm);
  });

  function generateFormApprovalForm(result){      
    $("#form-approval-dynamic-content").html(result);    
  }

    // slide form persetujuan
    // '#show_form',  
    $(document).on('change', 'input[name^="show_form-"]', function(){
      // console.log($(this).attr('name'))      
      if($(this).is(":checked")) {    
        $("#project-approval-form").removeClass("d-none").slideDown();
      } else {
        $("#project-approval-form").fadeTo().slideUp();
      }
    });


    function beforeValidate() {
      $("input, select").removeClass("is-invalid");
      $("div").removeClass("is-invalid");
      $("div").find(".invalid-feedback").empty();
    }

    function formValidationArea(selector, message) {
      selector.addClass("is-invalid");
      selector
          .closest("div.with-validation")
          .find(".invalid-feedback")
          .html(message);
    }

    function validateApprovalForm(){
      
      let hasil = $("#hasil"),
          note = $("#note");          
      
          if(hasil.val() == "") {
            formValidationArea(
              hasil, 
              "belum memilih persetujuan");
          }

          if(note.val().length < 1) {
            formValidationArea(
              note, 
              "belum mengisi catatan approval");
          }
    }

    function doesntHasValidationError() {
      return (
          !$("input").hasClass("is-invalid") && !$("div").hasClass("is-invalid") && !$("select").hasClass("is-invalid") && !$("textarea").hasClass("is-invalid")
      );
    }


    // $(document).on('click', '#save-survey-assignment-btn', function(){
    //   beforeValidate();
    //   validateSurveyForm();
    //   if (doesntHasValidationError()) {
    //     $("#survey-assignment-form").submit();
    //   }
    // });
  
    // $("#survey-assignment-form").submit(function (e) {
    //   e.preventDefault();  
    //   $("#save-survey-assignment-btn")
    //     .attr("disabled", "true")
    //     .text("Processing...");        
    //     this.submit();
    // });



    // save approval
    $(document).on('click', '#btn-save-approval', function(){
      beforeValidate();
      validateApprovalForm();
      if (doesntHasValidationError()) {
        $("#project-approval-form").submit();
      }
    });

    $("#project-approval-form").submit(function(e){
      e.preventDefault();
      $("#btn-save-approval").attr("disabled", "true").text("Mohon tunggu...");
      this.submit();
    });

});