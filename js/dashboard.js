$(document).ready(function(){




});//document ready end

$(function(){ //Onload Function
    var userRole = $('#user_role').val();
    if(userRole == '3' || userRole == '4'){ // 3- Manager, 4 -Staff.
        $('.staff_manager_login').show();
        getTableValues(); //To show TODO List.
    }else{
        $('.staff_manager_login').hide();
    }


});// Onload Function END.

function approve(rgp_id){
    var dlt = confirm("Are you sure to want to Approve this RGP?");
    if(dlt){
        $.ajax({
            url: 'RGP_ajax/ajaxapprovergp.php',
            cache: false,
            type: 'POST',
            data: {'rgp_id':rgp_id},
            success: function(response){
                location.href ='dashboard&msc=1';
            }
        });
        }else{
            return false;
        }
}

function reject(rgp_id){
    var dlt = confirm("Are you sure to want to Reject this RGP?");
    if(dlt){
        $.ajax({
            url: 'RGP_ajax/ajaxrejectrgp.php',
            cache: false,
            type: 'POST',
            data: {'rgp_id':rgp_id},
            success: function(response){
                location.href ='dashboard&msc=2';
            }
        });
        }else{
            return false;
        }
}

function getTableValues(){
    var staff_id = $('#id').val();
    $.ajax({
        type: 'POST',
        data: {'staff_id': staff_id},
        url: 'dashboardAjaxFile/ajaxToDoDashboard.php',
        success: function(response){
            $('#todo_infoDashboard').empty();
            $('#todo_infoDashboard').html(response);
        }
    })
}