$(document).ready(function(){

});

$(function(){
    $('input').attr('readonly', true);
    $('select').attr('disabled', true);

    var fc_insurance_renew_id = $('#fc_insurance_renew_id').val();

    if(fc_insurance_renew_id == '' || fc_insurance_renew_id == undefined){
        $('select#assign_staff_name').removeAttr('disabled');
        $('input#from_date').removeAttr('readonly');
        $('input#to_date').removeAttr('readonly');
    }else{
        $('textarea').attr('readonly', true);
        $('#submitfcinsurancerenew').hide();
    }

    getAllstaffList();
});

function getAllstaffList(){
    var assign_staff = $('#assign_staff').val();
    
    $.ajax({ //Get All Staff List , the ajax page using in other page, it return all staff list without any condition except active or inactive. 
    type:'POST',
    data:{},
    dataType: 'json',
    url:"permissionOrOnDutyFile/getAllStaffList.php",
    success:function(response){
        $("#assign_staff_name").empty();
        $("#assign_staff_name").prepend("<option value='' disabled selected>"+'Select Staff Name'+"</option>");
        var r = 0;
        for (r = 0; r < response.staff_id.length; r++) { 
            var selected ='';
            if(assign_staff == response['staff_id'][r]){
                selected='selected';
            }
            $('#assign_staff_name').append("<option value='" + response['staff_id'][r] + "'"+ selected + ">" + response['staff_name'][r] +"   (" + response['designation_name'][r] + ") </option>");
        }

    }
});
}