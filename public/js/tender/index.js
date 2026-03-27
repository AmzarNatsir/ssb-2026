var createProjectBtn = $('#createProjectBtn'),
      btnNextStep = $('.btn-next-step'),
      btnPrevStep = $('.btn-prev-step'),
      uploadDialog = $('#upload-dialog'),
      documentInput = $('#dokumen_lelang'),
      projectStartDate = $('#project_start_date'),
      projectEndDate = $('#project_end_date'),
      docs = [],
      imagesWrapper = $('.images-wrapper'),
      existingCustomersOpt = $('#existing_customer_opt'),
      companyName = $('#company_name'),
      companyAddress = $('#company_address'),
      customerCP = $('#contact_person_name'),
      customerCPNumber = $('#contact_person_number'),
      hiddenCustomerId = $('#hidden_customer_id'),
      addLocationBtn = $("#add_location");

  createProjectBtn.click(function(evt){
    evt.preventDefault();
  });

  $(function(){


    // $(document).tooltip({ selector: '[data-toggle="tooltip"]' });
    $(document).on('click', '[data-toggle="tooltip"]', function(){
      var $this = $(this);
      $this.tooltip("dispose");
    });

    // $('[data-toggle="tooltip"]').on('shown.bs.tooltip', function () {
    //     $('.tooltip').addClass('animated slideInDown');
    // })



    // showNotification('danger','success', 'A simple success alert—check it out!');
    showSnackbar();

    function updateProjectsTable(rows){
      if($('#tableProjectContainer .table-row').hasClass('show-loading')){
        $.each(rows, function(key,val){
          $('.row-' + val).children('div,span').show();
        });
        $('#tableProjectContainer .table-row').toggleClass('show-loading');
      } else {
        $.each(rows, function(key,val){
          $('.row-' + val).children('div,span').hide();
        });
        $('#tableProjectContainer .table-row').toggleClass('show-loading');
      }
    }

    if (typeof hiddenTableRows !== 'undefined'){
      updateProjectsTable(hiddenTableRows);

      setTimeout(function(){
        updateProjectsTable(hiddenTableRows)
      }, 1000);
    }

    var opsiKategori = $("#opsiKategori"),
      opsiTipe = $("#opsiTipe"),
      opsiStatus = $("#opsiStatus");

  $("#btn-filter-project").on('click', function(e){
    e.preventDefault();
    tableProjects.ajax.reload();
  });

    // hides the default search input
    $(document).on('ready', function(){
      $("#table-projects_filter").addClass('d-none');
    });

    $("#searchFilter").on("keyup", function(){
      tableProjects.search($(this).val()).draw();
    });

    var tableProjects = $("#table-projects").DataTable({
      "paging": true,
      "ordering": true,
      "info": true,
      "scrollX": true,
      "scrollY": "260px",
      "searching": true,
      "autoWidth": true,
      "pageLength": 5,// default page length
      "lengthChange": true,
      // "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]],
      "columnDefs":[{
          "width": "2rem",
          "targets": 0
      }],
      "dom": '<"top"f>rt<"bottom"lp><"clear">',
      createdRow: function(row, date, index){
        $(row).addClass("table-row tr-shadow")
      },
      "language":{
        // "lengthMenu": "Tampilkan _MENU_",
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
        url: loadProjectsUrl,
        dataSrc: "data",
        "data": function (d) {
          return $.extend({}, d, {
            "opsiKategori": opsiKategori.val(),
            "opsiTipe": opsiTipe.val(),
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
            return `<input id="selectRow-${row.id}" value="${row.id}" type="checkbox" name="selectRow" data-status="${row.status.id}" class="selectRow form-check-input pl-4">`;
          }
        },
        { data: "number" },
        { data: "name" },
        { data: "source" },
        { data: "created_at", className: "text-center" },
        { data: "value", render: $.fn.dataTable.render.number(','), className: "text-right" },
        // { data: "start_date", className: "text-center" },
        // { data: "end_date", className: "text-center" },
        { data: "category.keterangan" },
        { data: "status.keterangan" },
        { data: "type.keterangan" },
        { data: "location" },
        { data: "customer.company_name" },
      ]
    });

    // $('#table-projects')
    //   .addClass('table-condensed');

    // custom page length
    $("#table-projects_wrapper").find(".bottom").addClass("d-flex align-items-center justify-content-between pt-3");
    $("#table-projects_wrapper").find(".dataTables_length").addClass("d-flex w-50");
    $("#table-projects_filter").addClass('d-none');

    // projects table checkbox
    $(document).on('click', '.selectRow', function(){
      $('.selectRow').not($(this)).prop('checked', false);
      if($(this).prop('checked')){
        selectedRow = $(this).val()
        $("#action-tags").removeClass('d-none');
        let projectStatus = $(this).data('status');

        if(projectStatus == "5"){
          $("#action-tag-aktivasi-project").addClass("d-none");
        } else {
          $("#action-tag-aktivasi-project").removeClass("d-none");
        }

      } else {
        selectedRow = "";
        $("#action-tags").addClass('d-none');
      }
    });

    // create project
    $("#createProjectBtn").on('click', function(){
      ajaxRequest({
        url:"/project/create",
        requestType: "GET"
      }, generateCreateProjectModal);
    });

    function generateCreateProjectModal(result) {
      $("#edit-project-dynamic-content").html("");
      $("#create-project-dynamic-content").html(result);
    }

    // update project
    $("#action-tag-update").on('click', function(){
      ajaxRequest({
        url:"/project/" + selectedRow + "/edit",
        requestType: "GET"
      }, generateEditProjectModal);
    });

    // perintah survey
    $("#action-tag-assign-survey").on('click', function(){
      $("#surveyAssignmentModal").modal('show');
      $("#survey_task_project_id").val(selectedRow);
    });

    function generateEditProjectModal(result) {
      $("#create-project-dynamic-content").html("");
      $("#edit-project-dynamic-content").html(result);
    }

    // activation
    $("#action-tag-aktivasi-project").on('click', function(){
      ajaxRequest({
        url:"/project/" + selectedRow + "/aktivasi",
        requestType: "GET"
      }, generateAktivasiProjectModal)
    });

    // pre survey approval
      $("#action-tag-approve-survey-request").on('click', function () {
          ajaxRequest({
              url: "project/" + selectedRow + "/surveyRequestApproval",
              requestType: "GET"
        }, loadFormSurveyRequestApproval)
      });

      function loadFormSurveyRequestApproval(result) {
        // $("#edit-project-dynamic-content").html("");
        $("#form-survey-request-approval").html(result);
      }

    function generateAktivasiProjectModal(result){
      $("#aktivasi-project-dynamic-content").html(result);
    }

    $(document).on('click', '#btn-project-activate', function(evt){
      evt.preventDefault();
      $("#aktivasi-project-form").submit();
    });

    $("#aktivasi-project-form").submit(function (e) {
      e.preventDefault();
      $("#btn-project-activate")
        .attr("disabled", "true")
        .text("Processing...");
        this.submit();
    });


    // handle stacked modals
    $(document).on({
      'show.bs.modal': function () {
          var zIndex = 1040 + (10 * $('.modal:visible').length);
          $(this).css('z-index', zIndex);
          setTimeout(function() {
              $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
          }, 0);
      },
      'hidden.bs.modal': function() {
          if ($('.modal:visible').length > 0) {
              // restore the modal-open class to the body element, so that scrolling works
              // properly after de-stacking a modal.
              setTimeout(function() {
                  $(document.body).addClass('modal-open');
              }, 0);
          }
      }
    }, '.modal');

    // $(document).on('ready', function(){

      const uiTooltips = [
        {
          selector: "#action-tag-update",
          title: "update project"
        },
        {
          selector: "#lokasi",
          title: "opsional. dapat terisi otomatis dari lokasi utama lap survey"
        },
        {
          selector: "#action-tag-assign-survey",
          title: "perintah survey"
        },
        {
          selector: "#action-tag-survey-result",
          title: "Entry hasil survey"
        },
        {
          selector: "#action-tag-approve-project",
          title: "approve project"
        },
        {
          selector: "#action-tag-aktivasi-project",
          title: "aktivasi project"
        },
        {
          selector: "#action-tag-view",
          title: "Project Breakdown"
        },
        {
          selector: "#action-tag-approve-survey-request",
          title: "Approve Survey Request"
        }
      ];

      for(const item of uiTooltips){
        $(`${item.selector}`).tooltip({
          container:'body',
          title: item.title,
          animation: true,
          html: true,
          trigger:'manual'
        }).on('mouseenter', function(){
          var _this = this;
          $(this).tooltip('show');
          $('.tooltip').on("mouseleave", function(){
            $(_this).tooltip('hide')
          });
        }).on('mouseleave', function(){
          var _this = this;
          if(!$(".tooltip:hover").length){
            $(_this).tooltip("hide")
          }
        })
      }
    // })

    $(document).on('click', '#action-tag-view', function(evt){
      evt.preventDefault();
      console.log(viewProjectUrl);
      console.log(viewProjectUrl.replace(':projectId', selectedRow));
      location.assign(viewProjectUrl.replace(':projectId', selectedRow));
      // console.log(selectedRow);
      // cetakPDFUrl = cetakPDFUrl.replace(':projectId', selectedRow);
      // window.open(cetakPDFUrl);

    })

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

    function validateSurveyForm(){

      let surveyor = $("#surveyor"),
          surveyDate = $("#survey_date"),
          surveyorGroup = $("#hdnSurveyorGroup");

          if(surveyorGroup.val().length < 1) {
            formValidationArea(
              $('.multiselect-native-select'),
              "Tim surveyor wajib diisi");
          }

          if(surveyDate.val().length < 1) {
            formValidationArea(
              surveyDate,
              "tanggal survey wajib diisi");
          }
    }

    function doesntHasValidationError() {
      return (
          !$("input").hasClass("is-invalid") && !$("div").hasClass("is-invalid") && !$("select").hasClass("is-invalid")
      );
    }

    $(document).on('click', '#save-survey-assignment-btn', function(){
      beforeValidate();
      validateSurveyForm();
      if (doesntHasValidationError()) {
        $("#survey-assignment-form").submit();
      }
    });



    $("#survey-assignment-form").submit(function (e) {
      e.preventDefault();
      $("#save-survey-assignment-btn")
        .attr("disabled", "true")
        .text("Processing...");
        this.submit();
    });


    $("#start_date").datetimepicker({format: 'yyyy-mm-dd'});
    $("#end_date").datetimepicker({format: 'yyyy-mm-dd'});



    $(document).on('click', "#progressbar li", function(){
      console.log($(this).data('id'));
    })
  // Survey

    // PDF UPLOAD
    // documentInput.on('change', function(e){
    //   e.preventDefault();
    //   // user selected PDF
    //   let file = this.files[0],
    //       mime_types = [ 'image/png', 'image/jpeg', 'image/jpg' ];

    //   // validate whether PDF
    //   if(mime_types.indexOf(file.type) == -1) {
    //       alert('Error : Incorrect file type');
    //       return;
    //   }

    //   // validate file size
    //   if(file.size > 2*1024*1024) {
    //       alert('Error : Exceeded size 10MB');
    //       return;
    //   }

    // function previewImage(files) {
    //     let fileReader = new FileReader();
    //     fileReader.readAsDataURL(files.files[0]);

    //     fileReader.onload = function (readerEvent) {
    //         $("#mainImage").attr("src", readerEvent.target.result);
    //         $("#mainImage").attr("width", "150px");
    //     };
    // }

  })
