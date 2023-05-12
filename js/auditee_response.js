$(document).ready(function () {

    // auto generate vehicle code
    // $.ajax({
    //     url: "auditFile/ajaxGetVehicleCode.php",
    //     data: {},
    //     cache: false,
    //     type: "post",
    //     dataType: "json",
    //     success: function (data) {
    //         $("#vehicle_code").val(data);
    //     }
    // });


    // insert and update
    $("#submitAudittResponseBtn").click(function(){

        var totalCheckboxCount = $(':checkbox:checked').length;
        if(totalCheckboxCount > 0 ){
            
            var audit_assign_id = $("#id").val();
            
            var audit_assign_ref_id = [];
            var auditee_response = [];
            var action_plan = [];
            var target_date = [];

            $(':checkbox:checked').each(function(i){

                audit_assign_ref_id[i] = $(this).val(); 
                auditee_response[i] = $(this).parents('tr').find('td #auditee_response').val();   
                action_plan[i] = $(this).parents('tr').find('td #action_plan').val();   
                target_date[i] = $(this).parents('tr').find('td #target_date').val();   
            });
            
            var updid = $("#id").val(); 
            if(updid>0){
                
                $.ajax({
                    type: "POST",
                    url: 'auditFile/updateAuditeeResponse.php',
                    data: { "audit_assign_id":audit_assign_id, "audit_assign_ref_id":audit_assign_ref_id, "auditee_response":auditee_response, "action_plan":action_plan, 
                    "target_date":target_date },
                    success:function(response){
                        window.location.href = "dashboard";
                    }
                });
            } 
        
        }else{
            alert('Select any one checkbox to submit')
            return false;
        }

    });

});
