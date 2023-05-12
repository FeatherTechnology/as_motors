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
            
            // check if all auditee_response and action_plan fields are filled
            var allFieldsFilled = true;
            $(':checkbox:checked').each(function(i){
                if(auditee_response[i].trim() == '' || action_plan[i].trim() == ''){
                    allFieldsFilled = false;
                }
            });
            if(!allFieldsFilled){
                alert('Please fill all auditee response and action plan fields.');
                return false;
            }
            
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


    // $("#submitAudittResponseBtn").click(function(){
            
    //     var audit_assign_id = $("#id").val();
        
    //     var audit_assign_ref_id = [];
    //     var auditee_response = [];
    //     var action_plan = [];
    //     var target_date = [];

    //     document.querySelectorAll('td').forEach(function(td, i) {
    //         if (td.querySelector('#auditee_response') && td.querySelector('#action_plan') && td.querySelector('#target_date')) {

    //             audit_assign_ref_id[i] = td.parentNode.querySelector('input[type="hidden"]').value;
    //             auditee_response[i] = td.querySelector('#auditee_response').value;
    //             action_plan[i] = td.querySelector('#action_plan').value;
    //             target_date[i] = td.querySelector('#target_date').value;
    //         }
    //     });
        
    //     // Check if all the fields are filled up
    //     var isValid = true;
    //     var fields = document.querySelectorAll('#sstable input[id="auditee_response"], #sstable input[id="action_plan"]');
    //     for (var i = 0; i < fields.length; i++) {
    //         if (fields[i].value.trim() === '') {
    //             isValid = false;
    //             break;
    //         }
    //     }
     
    //     if (isValid) {
    //         var updid = $("#id").val(); 
    //         if(updid>0){
    //             $.ajax({
    //                 type: "POST",
    //                 url: 'auditFile/updateAuditeeResponse.php',
    //                 data: { "audit_assign_id":audit_assign_id, "audit_assign_ref_id":audit_assign_ref_id, "auditee_response":auditee_response, "action_plan":action_plan, 
    //                 "target_date":target_date },
    //                 success:function(response){
    //                     window.location.href = "dashboard";
    //                 }
    //             });
    //         } 
    //     } else {
    //         // Display an error message
    //         alert('Please fill up all the fields');
    //     }
       
    // });

});
