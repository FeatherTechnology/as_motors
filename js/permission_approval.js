$(document).ready(function(){

    $('#approve_or_reject').change(function(){
        var type = $(this).val();

        if(type == '1'){
            
            $('.rejectReason').hide();

            var reason = $('#reason').val();

            // if(reason == 'Permission' || reason =='Leave'){
            //     $('.reponsibleStaff').show();
            //     $.ajax({ //Get All Staff List , the ajax page using in other page, it return all staff list without any condition except active or inactive. 
            //         type:'POST',
            //         data:{},
            //         dataType: 'json',
            //         url:"permissionOrOnDutyFile/getAllStaffList.php",
            //         success:function(response){
            //             $("#res_staff_name").empty();
            //             $("#res_staff_name").prepend("<option value='' disabled selected>"+'Select Staff Name'+"</option>");
            //             var r = 0;
            //             var staffid = $('#staff_name').val();
            //             for (r = 0; r < response.staff_id.length; r++) { 
            //                 if(staffid != response['staff_id'][r]){
            //                     $('#res_staff_name').append("<option value='" + response['staff_id'][r] + "'>" + response['staff_name'][r] +"   (" + response['designation_name'][r] + ") </option>");
            //                 }
            //             }
    
            //         }
            //     });
            // }

        }else if(type == '2'){
            // $('.reponsibleStaff').hide();
            $('.rejectReason').show();
        }else{
            // $('.reponsibleStaff').hide();
            $('.rejectReason').hide();
        }
    });

    $('#res_staff_id').change(function(){
        var resstaffname = $('#res_staff_id :selected').text();
        var extractedName = resstaffname.replace(/\s*\(.*?\)\s*/, '');
        $('#res_staff_name').val(extractedName);
    });

});

$(function(){
    setTimeout(() => {
        getResponsibleStaffList();
        
    }, 1000);
});

function getResponsibleStaffList(){
    var branch_id = $('#branch_id').val();
    $.ajax({ //Get All Staff List , the ajax page using in other page, it return all staff list based on branch and active or inactive. 
        type:'POST',
        data:{'branch_id': branch_id},
        dataType: 'json',
        url:"vehicledetailsFile/getBranchStaffList.php",
        success:function(response){
            $("#res_staff_id").empty();
            $("#res_staff_id").prepend("<option value='' disabled selected>"+'Select Staff Name'+"</option>");
            var r = 0;
            var staffid = $('#staff_name').val();
            for (r = 0; r < response.staff_id.length; r++) { 
                if(staffid != response['staff_id'][r]){
                    var selected = '';
                    if($('#responsible_staff').val() == response['staff_id'][r]){
                        $('#res_staff_name').val(response['staff_name'][r]);
                        selected = 'selected';
                    }
                    $('#res_staff_id').append("<option value='" + response['staff_id'][r] + "'" +selected+ ">" + response['staff_name'][r] +"   (" + response['designation_name'][r] + ") </option>");
                }
            }

        }
    });
}



