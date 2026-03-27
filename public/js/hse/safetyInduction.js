var createSafetyInductionReportBtn = $("#createSafetyInductionReportBtn");
$(document).on('ready', function(){
    // alert(2)
    // console.log('wohooo')
    $(document).on('click', createSafetyInductionReportBtn, function(){
        ajaxRequest({
            url:"/safetyInduction/create",
            requestType: "GET",
        }, generateCreateSafetyInductionModal)
    })
    
    function generateCreateSafetyInductionModal(result){
        $("#create-safety-induction-dynamic-content").html(result);
    }
})