$(document).ready(function(){

  var btnNextStep = $('.btn-next-step'),
      btnPrevStep = $('.btn-prev-step'),
      projectStartDate = $('#project_start_date'),
      projectEndDate = $('#project_end_date'),
      companyName = $('#company_name'),
      companyAddress = $('#company_address'),
      customerCP = $('#contact_person_name'),
      customerCPNumber = $('#contact_person_number'),
      hiddenCustomerId = $('#hidden_customer_id'),
      filesArray = [],
      selectedFileType,
      deletedDocumentId,
      deletedFileName,
      deletedDocumentIds = [],
      deletedDocumentNames = [],
      isDirty = false;

  $(document).on('change', '#existing_customer_opt', function(){
    let customerId = $(this).val();
    if(customerId !== "") {
      ajaxRequest(
        {
            url: customerUrl + '/' + customerId,
            requestType: 'GET'
        },
        getExistingCustomer
      );
    }

  });

  function getExistingCustomer(data){
    let customer = data.customer;
    const capitalize1stLetter = (str) => str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
    if(customer){
      companyName.val(capitalize1stLetter(customer.company_name));
      companyAddress.val(capitalize1stLetter(customer.company_address));
      customerCP.val(capitalize1stLetter(customer.contact_person_name));
      customerCPNumber.val(customer.contact_person_number);
    }
  }

  $(document).on('click', '#btn-save-project', function(){
    beforeValidate();
    validateStepThree();
    if (doesntHasValidationError()) {
      $("#create-project-form").submit();
    }
  });

  $("#create-project-form").submit(function (e) {
    e.preventDefault();
    $("#btn-save-project")
      .attr("disabled", "true")
      .text("Processing...");
    this.submit();
  });

  $('[data-step="#1"]').addClass("active");

  // init image galleries
  lightbox.option({
    'resizeDuration': 100,
    'wrapAround': false,
    'showImageNumberLabel': true,
    'fitImagesInViewport': true,
    'albumLabel': 'Dokumen %1/%2'
  });

  function setSection(step){
    $('[id^=sectionStep]').hide();
    $("#sectionStep" + step).show();
    $('[data-step^="#"]').removeClass("active");
    for (let i = 1; i <= step; i++)
      $('[data-step="#' + i + '"]').addClass("active");
  }

  function doesntHasValidationError() {
    return (
        !$("input").hasClass("is-invalid") && !$("div").hasClass("is-invalid") && !$("select").hasClass("is-invalid")
    );
  }

  function validateStepOne(){
    let project_name = $('input[name="project_name"]'),
        project_category = $('#project_category'),
        project_type = $('#project_type'),
        project_source = $('#project_source'),
        project_target = $('#project_target'),
        project_jenis = $('#project_jenis'),
        project_status = $('#project_status'),
        project_start_date = $('input[name="project_start_date"]'),
        project_end_date = $('input[name="project_end_date"]');

      if(project_name.val().length < 1) {
        formValidationArea(
          project_name,
          "nama projek tidak boleh kosong");
      } else if (project_name.val().length > 0 && project_name.val().length < 10){
        formValidationArea(
          project_name,
          "nama projek minimal 10 karakter");
      }

      if(project_category.val() == "") {
        formValidationArea(
          project_category,
          "kategori projek tidak boleh kosong");
      }

      if(project_type.val() == "") {
        formValidationArea(
          project_type,
          "Tipe projek tidak boleh kosong");
      }

      if(project_source.val() == "") {
        formValidationArea(
          project_source,
          "Sumber projek tidak boleh kosong");
      }

      if(project_target.val() == "") {
        formValidationArea(
          project_target,
          "Target tender tidak boleh kosong");
      }

      if(project_jenis.val() == "") {
        formValidationArea(
          project_jenis,
          "Jenis Project tidak boleh kosong");
      }

      if(project_status.val() == "") {
        formValidationArea(
          project_status,
          "status projek tidak boleh kosong");
      }

      // if(project_start_date.val().length < 1) {
      //   formValidationArea(
      //     project_start_date,
      //     "tanggal mulai projek tidak boleh kosong");
      // }

      // if(project_end_date.val().length < 1) {
      //   formValidationArea(
      //     project_end_date,
      //     "tanggal akhir projek tidak boleh kosong");
      // }

      // if(moment(projectEndDate.val()).diff(projectStartDate.val(), 'days') < 0){
      //   formValidationArea(
      //     project_end_date,
      //     "tanggal akhir projek tidak valid");
      // }
  }

  function validateStepTwo(){}

  function validateStepThree(){
    if(companyName.val().length < 1) {
      formValidationArea(
        companyName,
        "Nama Company Customer tidak boleh kosong");
    } else if(companyName.val().length > 0 && companyName.val().length < 4) {
      formValidationArea(
        companyName,
        "Nama Company Customer tidak boleh kurang dari 4");
    } else if(companyAddress.val().length < 1) {
      formValidationArea(
        companyAddress,
        "Alamat Perusahaan Customer tidak boleh kosong");
    }

    // else if (companyAddress.val().length > 0 && companyAddress.val().length < 8) {
    //   formValidationArea(
    //     companyAddress,
    //     "Alamat Perusahaan Customer tidak boleh kurang dari 8");
    // }

    else if (customerCP.val().length < 1) {
      formValidationArea(
        customerCP,
        "Nama Kontak Person tidak boleh kosong");
    }

    // else if (customerCP.val().length > 0 && customerCP.val().length < 4) {
    //   formValidationArea(
    //     customerCP,
    //     "Nama Kontak Person tidak boleh kurang dari 4");
    // }

    else if (customerCPNumber.val().length < 1) {
      formValidationArea(
        customerCPNumber,
        "Nomor Kontak Person tidak boleh kosong");
    }

    // else if (customerCPNumber.val().length > 0 && customerCPNumber.val().length < 11) {
    //   formValidationArea(
    //     customerCPNumber,
    //     "Nomor Kontak Person Tidak boleh kurang dari 11 karakter");
    // }
  }

  function formValidationArea(selector, message) {
    selector.addClass("is-invalid");
    selector
        .closest("div.with-validation")
        .find(".invalid-feedback")
        .html(message);
  }

  function beforeValidate() {
    $("input, select").removeClass("is-invalid");
    $("div").removeClass("is-invalid");
    $("div").find(".invalid-feedback").empty();
  }

  btnNextStep.click(function(evt){
    evt.preventDefault();
    let step = $(this).data("next");
    beforeValidate();
    if(step == 2) validateStepOne();
    if(step == 3) validateStepTwo();
    if(doesntHasValidationError())
    setSection(step);
  })

  btnPrevStep.click(function(evt){
    evt.preventDefault();
    let step = $(this).data("prev");
    setSection(step);
  });

  // Tambah input upload
  $(document).on('click', '#tambah_upload', function(evt){
    evt.preventDefault();

    var $uploadFieldDiv = $('div[id^="upload_field_"]:last');
    var num = parseInt( $uploadFieldDiv.prop("id").match(/\d+/g), 10 ) +1;
    var $clonedDivField = $uploadFieldDiv
                            .clone()
                            .prop('id', 'upload_field_' + num);

    $clonedDivField
      .find('button[id^="btn-delete-field-upload_"]')
      .prop('id', 'btn-delete-field-upload_' + num)
      .removeClass('d-none');

    $uploadFieldDiv.after($clonedDivField);

  });

  // tambah row fixed document
  $("#addFixedDocumentRow").on('click', function(evt){
    evt.preventDefault();

    $("#fixedDokumenRowWrapper").find('select[name^="fixed_file_type"]')
      .each(function(){
        if($(this).val() == ""){
          isDirty = true;
          formValidationArea($(this), "Belum memilih Jenis Fixed Dokumen");
        }
      })

    $("#fixedDokumenRowWrapper").find('select[name^="fixed_file"]')
      .each(function(){
        if($(this).val() == "" || $(this).val() == null){
          isDirty = true;
          formValidationArea($(this), "Belum memilih Fixed Dokumen");
        }
      });

    let counter = $("#fixedDokumenRowWrapper").children('.row').length;

    if(!isDirty){
      $("#fixedDokumenRowWrapper").append(
        $("#fixedDokumenRowWrapper > div")
        .first()
        .clone()
        .attr("id", "fixed_" +  (counter+1))
      );

      if(counter > 0) {
        $("#fixed_" + (counter+1) ).find('.remove_fixed_row').removeClass('d-none');
      }
    }

    // TODO
    // jangan tambah klo option yang sama sdh terpilih

  });


  // var isEmpty = true;
  $(document).on('change', 'select[name^="fixed_file_type"]', function(){
    if($(this).val() !== ""){
      isDirty = false;
      beforeValidate();
    }

    let elem = $(this).parent().parent().parent().find('#fixed_file');
    ajaxRequest({
      url:`dokumen/getfixedDocumentByType/${$(this).val()}`,
      requestType: 'GET'
    }, function generateOptionList(response){
      elem.empty();
      let data = response.data;
        data.forEach(option => {
          elem.append('<option value="'+ option.id +'">' + option.desc + '</option>');
        })
    });
  });

  $(document).on('change', 'select[name^="fixed_file"]', function(){
    if($(this).val() !== ""){
      isDirty = false;
      beforeValidate();
    }
  });

  // remove fixed row event
  $(document).on('click', '.remove_fixed_row', function(){
    let stringId = $(this).parent().attr('id'),
        id = stringId.split('_').pop();
    isDirty = false;
    $("#fixed_" + id).remove();
  })

  // Hapus input upload
  $(document).on('click',  'button[id^="btn-delete-field-upload_"]', function(){
    let deleteId = $(this).attr('id').split('_')[1];
    $("#upload_field_" + deleteId). remove();
  })

  $(document).on("change", "#file_type", function(){
    selectedFileType = $(this).val();
    if(filesArray.indexOf(selectedFileType) == -1 && selectedFileType !== ""){
      filesArray.push(selectedFileType);
    }
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

  $(document).on('change', '#use_existing_customer', function(){
    if($(this).is(":checked")) {

      $("#existing_customer_opt")
          .closest('div.form-group')
          .removeClass("d-none")
          .slideDown();

      $("#sectionStep3 input[type=text]:not(#existing_customer_opt)").attr('readonly', true);

    } else {

      $("#existing_customer_opt")
          .closest('div.form-group')
          .fadeTo()
          .slideUp();

      $("#existing_customer_opt").val(0);
      companyName.val('');
      companyAddress.val('');
      customerCP.val('');
      customerCPNumber.val('');
      hiddenCustomerId.val(0);

      $("#sectionStep3 input[type=text]").attr('readonly', false);
    }
  });

})
