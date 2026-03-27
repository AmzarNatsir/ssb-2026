$(function(){

  $(document).tooltip({ selector: '[data-toggle="tooltip"]' });
  $(document).on('click', '[data-toggle="tooltip"]', function(){
    var $this = $(this);
    $this.tooltip("dispose");
  });

  // click checkbox event & save survey Id as hidden input
  $("#action-tag-survey-result").on('click', function(){
    $("#survey-form #survey_id").val(selectedRow);
  });

  // Survey Table Options
  var dateOption = $("#dateOption"),
      startDate = $("#startDate"),
      endDate = $("#endDate"),
      deletedDocumentId,
      deletedFileName,
      deletedDocumentIds = [],
      deletedDocumentNames = [];

    // using current month as default values
    $("#startDate").val(moment().startOf('month').format('YYYY-MM-DD'));
    $("#endDate").val(moment().endOf('month').format('YYYY-MM-DD'));
    $("#startDate, #endDate").attr("max", moment().format('YYYY-MM-DD'));

    // using last month values
    // $("#startDate").val(moment().subtract(1,'months').startOf('month').format('YYYY-MM-DD'));
    // $("#endDate").val(moment().subtract(1,'months').endOf('month').format('YYYY-MM-DD'));

    showSnackbar();

    $("#btn-filter-survey").on('click', function(e){
      e.preventDefault();
      tableSurvey.ajax.reload();
    });

  // https://stackoverflow.com/questions/5990386/datatables-search-box-outside-datatable

  // hides default Filter/search input
  $(document).on('ready', function(){
    $("#table-surveys_filter").addClass('d-none');
  });

  $("#searchFilter").on("keyup", function(){
    tableSurvey.search($(this).val()).draw();
  });

  var tableSurvey = $("#table-surveys").DataTable({
    "paging": true,
    "ordering": true,
    "info": true,
    "scrollX": true,
    "scrollY": 160,
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
      "processing": "<span class='fa-stack fa-lg'>\n\
                            <i class='fa fa-spinner fa-spin fa-stack-1x fa-fw'></i>\n\
                       </span>&emsp;Mohon tunggu meload data",
      "info": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
      "infoEmpty": "Menampilkan 0 s/d 0 dari 0 data",
      // "search": "Cari data:",
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
      url: loadSurveyUrl,
      dataSrc: "data",
      "data": function (d) {
        return $.extend({}, d, {
          "dateOption": dateOption.val(),
          "startDate": startDate.val(),
          "endDate": endDate.val()
        });
      },
    },
    "columns": [
        {
          data: null,
          className:"text-center pl-4",
          orderable:false,
          render: function(data, type, row){
            return `<input id="selectRow-${row.id}" data-completed-by="${row.completed_by}" data-surveyor-id="${row.surveyor_id}" data-surveyor-group-id="${row.surveyor_group}" value="${row.id}" type="checkbox" name="selectRow" class="selectRow form-check-input pl-4">`;
          }
        },
        { data: 'project.name' },
        { data: 'project.date', className:"text-center" },
        { data: 'created_at', className:"text-center" },
        { data: 'assign_by.karyawan.nm_lengkap', className: "text-center", defaultContent: "" },
        {
          render: function(data, type, row){
            if(row.results.length > 0){
              return `<span class="pl-2">${row.results[0].created_at}</span>`;
            } else {
              return '';
            }
          }
        },
        { data: 'completed_by.karyawan.nm_lengkap', className: "text-center", defaultContent: "" },
        { data: 'project.customer.company_name' },
        { data: 'project.status.keterangan' },
      ]
  });

  $("#table-surveys_wrapper").find(".bottom").addClass("d-flex align-items-center justify-content-between pt-3");
  $("#table-surveys_wrapper").find(".dataTables_length").addClass("d-flex w-50");
  $("#table-surveys_filter").addClass('d-none');

  // survey table action tags checkbox
    $(document).on('click', '.selectRow', function () {

    $('.selectRow').not($(this)).prop('checked', false);
    if($(this).prop('checked')){
      selectedRow = $(this).val()
      $("#action-tags").removeClass('d-none');

      let completedBy = $(this).data('completedBy'),
          surveyorId = $(this).data('surveyorId'),
          surveyorGroupId = $(this).data('surveyorGroupId');

        // console.log("completedBy is null ? : ", completedBy === null)
        // console.log(surveyorGroupId)
        // console.log(surveyorGroupId.split(","));
        // console.log("currentUserId", currentUserId)
        // console.log("currentUser", currentUser)

        let surveyorIsInArray = surveyorGroupId.split(",").findIndex(elem => elem == currentUser)
        // console.log("surveyorIsInArray", surveyorIsInArray);
        if(completedBy === null && surveyorIsInArray !== -1)
        {

          $("#action-tag-create-survey").removeClass('d-none');
          $("#action-tag-edit-survey").addClass('d-none');

        } else if(completedBy === null && surveyorIsInArray < 0)
        {

          $("#action-tag-create-survey").addClass('d-none');
          $("#action-tag-edit-survey").addClass('d-none');

        } else if(completedBy !== null && surveyorIsInArray !== -1)
        {

          $("#action-tag-create-survey").addClass('d-none');
          $("#action-tag-edit-survey").removeClass('d-none');

        } else if(completedBy !== null && surveyorIsInArray < 0)
        {

          $("#action-tag-create-survey").addClass('d-none');
          $("#action-tag-edit-survey").addClass('d-none');

        }

        // if(completedBy === null && surveyorId == currentUserId){
        //   $("#action-tag-create-survey").removeClass('d-none');
        //   $("#action-tag-edit-survey").addClass('d-none');
        // } else if(completedBy === null && surveyorId !== currentUserId) {
        //   $("#action-tag-create-survey").addClass('d-none');
        //   $("#action-tag-edit-survey").addClass('d-none');
        // } else if(completedBy !== null && surveyorId == currentUserId) {
        //   $("#action-tag-create-survey").addClass('d-none');
        //   $("#action-tag-edit-survey").removeClass('d-none');
        // } else if(completedBy !== null && surveyorId !== currentUserId) {
        //   $("#action-tag-create-survey").addClass('d-none');
        //   $("#action-tag-edit-survey").addClass('d-none');
        // }

    } else {
      selectedRow = "";
      $("#action-tags").addClass('d-none');
    }
  });


  // create survey
  $("#action-tag-create-survey").on('click', function(){
    ajaxRequest({
      url: createSurveyUrl + "/" + selectedRow,
      requestType: 'GET',
    }, generateCreateSurveyModal);
  });

  function generateCreateSurveyModal(result){
    $("#edit-survey-dynamic-content").html("")
    $("#create-survey-dynamic-content").html(result)
  }

  // edit survey
  $("#action-tag-edit-survey").on('click', function(){
    ajaxRequest({
      url: "/survey/edit/" + selectedRow,
      requestType: 'GET',
    }, generateEditSurveyModal);
  });

  function generateEditSurveyModal(result){
    $("#create-survey-dynamic-content").html("");
    $("#edit-survey-dynamic-content").html(result);
  }

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
      console.log($('.modal:visible').length > 0)
        if ($('.modal:visible').length > 0) {
            // restore the modal-open class to the body element, so that scrolling works
            // properly after de-stacking a modal.
            setTimeout(function() {
                $(document.body).addClass('modal-open');
            }, 0);
        }
    }
  }, '.modal');

  const uiTooltips = [{
    'selector':'#action-tag-create-survey',
    'title':'Input hasil survey'
  },{
    'selector':'#action-tag-edit-survey',
    'title':'Edit Hasil Survey'
  }];

  for(const item of uiTooltips){
    $(`${item.selector}`).tooltip({
      title: item.title
    });
  }

  // validasi Form Pengisian hasil survey
  function validateSurveyResultForm(){
    let surveySummaryNote = $("#survey_note"),
        surveyLocationsDomElem = $("h6.lokasi_survey");
    if(surveySummaryNote.val() == ""){
      formValidationArea(surveySummaryNote, "Ringkasan Hasil survey wajib diisi");
    }

    if(surveySummaryNote.val().length > 0 && surveySummaryNote.val().length < 10){
      formValidationArea(surveySummaryNote, "Ringkasan Hasil survey minimal 10 karakter");
    }

    // hide sementara validasi survet
    // if($("#survey-locations").children("[id^='location-']").length == 0){
    //   formValidationArea(surveyLocationsDomElem, "minimal satu lokasi survey wajib diisi")
    // }
  }


  // validasi Form utk penambahan lokasi survey
  function validateAddSurveyLocationForm(){

    let locationName = $("#location_name"),
        locationNote = $("#location_note");

        if(locationName.val() == "") {
          formValidationArea(
            locationName,
            "nama lokasi survey wajib diisi");
        }

        if(locationNote.val().length < 1) {
          formValidationArea(
            locationNote,
            "catatan mengenai lokasi survey wajib diisi");
        }
  }

  // clear add location form inputs
  function resetFormInput(){
    $("#add-location-form").find("#location_name").val("");
    $("#add-location-form").find("#lat").val("");
    $("#add-location-form").find("#lng").val("");
    $("#add-location-form").find("#location_note").val("");
    $("#add-location-form").find("#id-edit").val("");
    $("#add-location-form").find("#save-location-btn").text("simpan lokasi");
  }

  // handle event cancel/close location modal
  $("#closeLocationModal").on('click', function(e){
    e.preventDefault();
    resetFormInput();
  });

  $(document).on('click', "#add-location-form #save-location-btn", function(e){
    e.preventDefault();
    beforeValidate();
    validateAddSurveyLocationForm();
    if (doesntHasValidationError()) {
      console.log('simpan lokasi')
      addSurveyLocation()
      // $("#add-location-form").submit();
    }
  })

  function addSurveyLocation(){
    console.log('addSurveyLocation called')
  // $("#add-location-form").submit(function(e){
  //   e.preventDefault();

    // insert lokasi baru atau update lokasi sebelumnya
    console.log($("#id-edit").val().length)
    var locationKey, locationId;
    if($("#id-edit").val().length > 0)
    {

      // locationKey = $("#index-location").val();
      locationKey = parseInt($("#id-edit").val());
      locationId = parseInt($("#index-location").val());

      // hapus lokasi lama dari view
      // $("#survey-locations").find("#location-" + locationKey).remove();

      let koordinat = `${ ($("#lat").val() && $("#lng").val() !== "") ? `${$("#lat").val()},\ ${$("#lng").val()}` : ''}`,
          canOpenMap = $("#lat").val() && $("#lng").val() !== "" ? true : false;

      let hiddens = '<input type="hidden" name="hdn_location_name[' + locationKey + ']" value="' + $("#location_name").val() + '" /> ' +
        '<input type="hidden" name="hdn_lat['+ locationKey +']" value="'+ $("#lat").val() +'" />' +
        '<input type="hidden" name="hdn_lng['+ locationKey +']" value="'+ $("#lng").val() +'" />' +
        '<input type="hidden" name="hdn_location_note['+ locationKey +']" value="'+ $("#location_note").val() +'" />' +
        '<input type="hidden" name="hdn_survey_result_id['+ locationKey +']" value="'+ locationId +'" />' +
        '</div>';

      let elem = `<div id="location-${locationKey}" class="bg-white text-muted rounded-lg py-2 px-1 my-2" style="border:solid 1px #CCC;">
        <div class="row px-2">
          <div class="col-sm-12 text-right">

            ${koordinat ? `<a id="show-map-${locationKey}" href="https://maps.google.com/?q=${koordinat}&t=k&z=21" target="_blank" class="btn p-2 tag show-map" data-toggle="tooltip" data-placement="top" title="show-map">
                    <i class="ri-map-pin-line pl-1"></i>
                  </a>` : `<a id="show-map-${locationKey}" target="_blank" class="btn p-2 tag-disabled show-map" data-toggle="tooltip" data-placement="top" title="show-map">
                    <i class="ri-map-pin-line pl-1"></i>
                  </a>`}

            <button
              id="edit-location-${locationKey}"
              class="tag edit-location"
              data-toggle="tooltip"
              data-placement="top" title="edit">
                <i class="ri-edit-box-line"></i>
            </button>

            <button id="delete-location-${locationKey}" class="tag-danger delete-location" data-toggle="tooltip" title="hapus">
              <i class="ri-delete-bin-7-line"></i>
            </button>


          </div>
        </div>
        <div class="row px-3">
          <div class="col-sm-4">Nama Lokasi</div>
          <div class="col-sm-8">${$("#location_name").val()}</div>
        </div>
        <div class="row px-3">
          <div class="col-sm-4">Koordinat (Lat/Lng)</div>
          <div class="col-sm-8 text-wrap">${koordinat}</div>
        </div>
        <div class="row px-3">
          <div class="col-sm-4">Catatan</div>
          <div class="col-sm-8">${$("#location_note").val()}</div>
        </div>`
          .concat(hiddens);



      $("#survey-locations").find("#location-" + locationKey).replaceWith(elem);
      $("#addLocationModal").modal('hide');

    } else {

      // jika belum ada lokasi
      if( $("#survey-locations").children("[id^='location-']").length == 0){
        $("#no-location-block").addClass("d-none");
        locationKey = 0;
      } else {
        // extract key from id
        locationKey = parseInt($("#survey-locations [id^='location-']").last().attr('id').split('-')[1]) + 1;
      }

      let koordinat = `${ ($("#lat").val() && $("#lng").val() !== "") ? `${$("#lat").val()},\ ${$("#lng").val()}` : ''}`,
          canOpenMap = $("#lat").val() && $("#lng").val() !== "" ? true : false;

      let hiddens = '<input type="hidden" name="hdn_location_name[' + locationKey + ']" value="' + $("#location_name").val() + '" /> ' +
        '<input type="hidden" name="hdn_lat['+ locationKey +']" value="'+ $("#lat").val() +'" />' +
        '<input type="hidden" name="hdn_lng['+ locationKey +']" value="'+ $("#lng").val() +'" />' +
        '<input type="hidden" name="hdn_location_note['+ locationKey +']" value="'+ $("#location_note").val() +'" />' +
        '<input type="hidden" name="hdn_survey_result_id['+ locationKey +']" value="" />' +
        '</div>';

      let elem = `<div id="location-${locationKey}" class="bg-white text-muted rounded-lg py-2 px-1 my-2" style="border:solid 1px #CCC;">
        <div class="row px-2">
          <div class="col-sm-12 text-right">

            ${koordinat ? `<a id="show-map-${locationKey}" href="https://maps.google.com/?q=${koordinat}&t=k&z=21" target="_blank" class="btn p-2 tag show-map" data-toggle="tooltip" data-placement="top" title="show-map">
                    <i class="ri-map-pin-line pl-1"></i>
                  </a>` : `<a id="show-map-${locationKey}" target="_blank" class="btn p-2 tag-disabled show-map" data-toggle="tooltip" data-placement="top" title="show-map">
                    <i class="ri-map-pin-line pl-1"></i>
                  </a>`}

            <button
              id="edit-location-${locationKey}"
              class="tag edit-location"
              data-toggle="tooltip"
              data-placement="top" title="edit">
                <i class="ri-edit-box-line"></i>
            </button>

            <button id="delete-location-${locationKey}" class="tag-danger delete-location" data-toggle="tooltip" title="hapus">
              <i class="ri-delete-bin-7-line"></i>
            </button>

          </div>
        </div>
        <div class="row px-3">
          <div class="col-sm-4">Nama Lokasi</div>
          <div class="col-sm-8">${$("#location_name").val()}</div>
        </div>
        <div class="row px-3">
          <div class="col-sm-4">Koordinat (Lat/Lng)</div>
          <div class="col-sm-8 text-wrap">${koordinat}</div>
        </div>
        <div class="row px-3">
          <div class="col-sm-4">Catatan</div>
          <div class="col-sm-8">${$("#location_note").val()}</div>
        </div>`
        .concat(hiddens);

      $(elem).appendTo("#survey-locations");
      $("#addLocationModal").modal('hide');
    }

  }
  // })

  $(document).on('click', "#add-survey-location-btn", function(){
    $("#addLocationModal").on('shown.bs.modal', function(){
      console.log('btn tambah lokasi di click dan modal muncul');
      resetFormInput();
    });
  });

  // #1
  $(document).on('click', ".edit-location", function(evt){
    evt.preventDefault();
    let locationKey = $(this).attr('id').split('-')[2],
      locationId = $(this).data('locationId');

    $("#id-edit").val(locationKey);
    $("#index-location").val(locationId);
    fillLocationFormInputs(locationKey, locationId);

  });

  // #2
  function fillLocationFormInputs(locationKey, locationId){
    $("#addLocationModal").modal('show');
    $("#addLocationModal").on('shown.bs.modal', function(){
      $("#location_name").val( $("input[name^='hdn_location_name']").eq(locationKey).val())
      $("#lat").val($("input[name^='hdn_lat']").eq(locationKey).val())
      $("#lng").val($("input[name^='hdn_lng']").eq(locationKey).val())
      $("#location_note").val($("input[name^='hdn_location_note']").eq(locationKey).val())
      if(locationKey !== ""){
        $("#id-edit").val(locationKey); // kolom id dari tbl survey_result
        $("#index-location").val(locationId)
      } else {
        $("#id-edit").val("");
        $("#index-location").val("");
      }
    });
  }

  $(document).on('click', ".delete-location", function(evt){
    evt.preventDefault();
    let locationKey = $(this).attr('id').split('-')[2];
    deleteLocation(locationKey);
  })

  function deleteLocation(locationKey){
    $("#survey-locations").find("#location-" + locationKey).remove();
    if( $("#survey-locations").children("[id^='location-']").length == 0){
        $("#survey-locations").append(`<div id="no-location-block" class="py-2 px-1 mt-2 mb-2 text-center" style="border:solid 2px #EAEAEA;border-radius:6px;">
            <i class="ri-information-line pr-1"></i>belum ada lokasi survey
          </div>`)
    }
  }

  $("#addLocationModal").on('hidden.bs.modal', function(){
    resetFormInput();
  });

  $(document).on('click', "#survey-form #save-survey-result-btn", function(evt){
    evt.preventDefault();

    beforeValidate();
    validateSurveyResultForm();
    if (doesntHasValidationError()) {
      $("#survey-form").submit();
    }
  });

  $("#survey-form").submit(function (e) {
    e.preventDefault();
    $("#save-survey-result-btn")
      .attr("disabled", "true")
      .text("Processing...");
      this.submit();
  });


  // Hapus file yang telah diUpload sebelumnya
  $(document).on('click', 'button[id^="btn-delete-document_"]', function(){
    deletedDocumentId = $(this).attr('id').split('_')[1];
    deletedFileName =  $(this).data('filename');
    $("#deleteDocumentModal").modal('show');
  });

  $(document).on('click', '#deleteDocumentModal #btn-confirm-delete', function(e){
    e.preventDefault();

    deletedDocumentIds.push(deletedDocumentId);
    deletedDocumentNames.push(deletedFileName);

    $('input:hidden[name=fileIdsToBeDelete\\[\\]]').val(deletedDocumentIds);
    $('input:hidden[name=fileNamesToBeDelete\\[\\]]').val(deletedDocumentNames);

    $(`#document-${deletedDocumentId},#btn-delete-document_${deletedDocumentId}`).addClass('d-none');
    $("#deleteDocumentModal").modal('hide');

  });

  $(document).on('click', '#deleteDocumentModal #btn-cancel-delete', function(){
    // alert('tercancel')
    deletedDocumentId = "";
    $("#deleteDocumentModal").modal('hide');
  });

});
