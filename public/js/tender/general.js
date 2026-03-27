function ajaxRequest(
  params, 
  callback, 
  callbackError, 
  disableMultiRequest = false, 
  requestFrom = 'default'
){
  var url = typeof params.url !== typeof undefined ? params.url : "",
     data = typeof params.data !== typeof undefined ? params.data : "",
     requestType = typeof params.requestType !== typeof undefined ? params.requestType : "POST",
     contentType = typeof params.contentType !== typeof undefined ? params.contentType : "application/json",
     currentRequest = [];

     currentRequest[requestFrom] = $.ajax({
       url:url,
       type:requestType,
       contentType: contentType,
       headers: {
         "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: data,
        beforeSend: function(){
          if (disableMultiRequest) {
              if (currentRequest[requestFrom] != null) {
                  currentRequest[requestFrom].abort();
              }
          }
        }
     }).done(function(data){
        callback(data);
     }).fail(function(err){
       // console.log(err);
        if (typeof callbackError !== typeof undefined) {
            callbackError(error);
        } else {
            if (error["responseJSON"]) {
                if (error["responseJSON"]["message"] === "Unauthenticated.")
                    location.reload();
            }
        }
     });
}


function showNotification(oldType, newType, message) {
  $("#snackbar")
    .removeClass(oldType)
    .addClass(newType);
  $("#snackbar_message").html(message);
  showSnackbar();
}

function showSnackbar() {
  var x = $('#snackbar'),
      snackBarMessage = $('#snackbar_message');

  if(snackBarMessage.text().trim().length !== 0){
    // x.css('z-index', '999999998');
    setTimeout(function() {
      x.toggleClass('d-none');
    }, 1000);  
  
    setTimeout(function() {
        if (x.hasClass('d-none')){          
          x.toggleClass('d-none');
        }        
    }, 5000);
  }

  $("#snackbar").delay(5000).fadeOut(1000);
}

// Validation 
function beforeValidate() {
  $("input, select, textarea, h6").removeClass("is-invalid");
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

function doesntHasValidationError() {
  return (
      !$("input").hasClass("is-invalid") && !$("div").hasClass("is-invalid") && !$("select").hasClass("is-invalid") && !$("textarea").hasClass("is-invalid") && !$("div").hasClass("is-invalid") && !$("h6").hasClass("is-invalid")
  );
}