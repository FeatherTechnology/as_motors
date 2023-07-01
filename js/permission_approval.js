$(document).ready(function(){

    $('#approve_or_reject').change(function(){
        var type = $(this).val();

        if(type == '1'){
            
            $('.rejectReason').hide();

            var reason = $('#reason').val();

            if(reason == 'Permission' || reason =='Leave'){
                $('.reponsibleStaff').show();
                $.ajax({ //Get All Staff List , the ajax page using in other page, it return all staff list without any condition except active or inactive. 
                    type:'POST',
                    data:{},
                    dataType: 'json',
                    url:"permissionOrOnDutyFile/getAllStaffList.php",
                    success:function(response){
                        $("#res_staff_name").empty();
                        $("#res_staff_name").prepend("<option value='' disabled selected>"+'Select Staff Name'+"</option>");
                        var r = 0;
                        for (r = 0; r < response.staff_id.length; r++) { 
                            $('#res_staff_name').append("<option value='" + response['staff_id'][r] + "'>" + response['staff_name'][r] +"   (" + response['designation_name'][r] + ") </option>");
                        }
    
                    }
                });
            }

        }else if(type == '2'){
            $('.reponsibleStaff').hide();
            $('.rejectReason').show();
        }else{
            $('.reponsibleStaff').hide();
            $('.rejectReason').hide();
        }
    });

});




