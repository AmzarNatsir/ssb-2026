$(document).ready(function(){
	console.log('survey edit script active')	
	// tooltips
	const uiTooltips = [{
    'selector':'#add-survey-location-btn',
    'title': 'Tambah Lokasi Survey'
  }];
  
  for(const item of uiTooltips){
    $(`${item.selector}`).tooltip({          
      title: item.title
    });
  }  

  // validasi Form Pengisian hasil survey
  // function validateSurveyResultForm(){
  //   let surveySummaryNote = $("#survey_note"),
  //       surveyLocationsDomElem = $("h6.lokasi_survey");
  //   if(surveySummaryNote.val() == ""){
  //     formValidationArea(surveySummaryNote, "Ringkasan Hasil survey wajib diisi");
  //   }

  //   if(surveySummaryNote.val().length > 0 && surveySummaryNote.val().length < 10){
  //     formValidationArea(surveySummaryNote, "Ringkasan Hasil survey minimal 10 karakter");
  //   }

  //   if($("#survey-locations").children("[id^='location-']").length == 0){
  //     formValidationArea(surveyLocationsDomElem, "minimal satu lokasi survey wajib diisi")
  //   }
  // }
	
	// var existingSurveyLocations = @json($surveyResult);
	// console.log(existingSurveyLocations);
	// // fileTypes = @json($fileTypes),
	// $("#add-survey-location-btn").on('click', function(e){
	// 	e.preventDefault();

	// });

	// $(document).on('click',"#save-survey-result-btn", function(){	    
	//     beforeValidate();
	//     validateSurveyResultForm();
	//     if (doesntHasValidationError()) {
	//       $("#survey-form").submit();
	//     }
	//   });

 //  $("#survey-form").submit(function (e) {
 //    e.preventDefault();  
 //    $("#save-survey-result-btn")
 //      .attr("disabled", "true")
 //      .text("Processing...");        
 //      this.submit();
 //  });	
})