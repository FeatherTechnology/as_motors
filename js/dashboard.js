//Dashboard Approval screens are:-
//RGP extended,Regularisation Approval
$(document).ready(function(){

    $('#inprogressgbtn').on('click', function(){
        
        $('#progress_label').show();
        $('#in_progress').show();
        $('#submit_progress').show();
        $('#cancel_progress').show();
        
        $('#inprogressgbtn').hide();
        $('#pendingbtn').hide();
        $('#completedbtn').hide();
        $('#remarkviewbtn').hide();
        
        $('#work_des_label').hide();
        $('#work_id').hide();
        $('#work_name').hide();    
    });
    
    $('#pendingbtn').on('click', function(){
        
        $('#pending_label').show();
        $('#pending').show();
        $('#submit_pending').show();
        $('#cancel_pending').show();
        
        $('#inprogressgbtn').hide();
        $('#pendingbtn').hide();
        $('#completedbtn').hide();
        $('#remarkviewbtn').hide();
        
        $('#work_des_label').hide();
        $('#work_id').hide();
        $('#work_name').hide();
    });

    $('#completedbtn').on('click', function(){
        
        $('#completed_label').show();
        $('#completed_file').show();
        $('#com_remark_label').show();
        $('#completed_remark').show();
        $('#submit_completed').show();
        $('#cancel_completed').show();
        
        $('#inprogressgbtn').hide();
        $('#pendingbtn').hide();
        $('#completedbtn').hide();
        $('#remarkviewbtn').hide();
        
        $('#work_des_label').hide();
        $('#work_id').hide();
        $('#work_name').hide();
    });

    $('#remarkviewbtn').on('click', function(){

        $("#completedRemark").addClass("show");
        $("#completedRemark").removeAttr("aria-hidden");
        $("#completedRemark").css("display","block");
        $("#completedRemark").css("width","500px");

    });

    $('#cancel_progress').on('click',function(event){

        event.preventDefault();
        //progress index
        $('#progress_label').hide();
        $('#in_progress').hide();
        $('#submit_progress').hide();
        $('#cancel_progress').hide();
        
        //buttons
        $('#inprogressgbtn').show();
        $('#pendingbtn').show();
        $('#completedbtn').show();
        $('#remarkviewbtn').show();
        //work descriptions
        $('#work_des_label').show();
        $('#work_id').show();
        $('#work_name').show();
    });

    $('#cancel_pending').on('click',function(event){

        event.preventDefault();
        //pending index
        $('#pending_label').hide();
        $('#pending').hide();
        $('#submit_pending').hide();
        $('#cancel_pending').hide();

        //buttons
        $('#inprogressgbtn').show();
        $('#pendingbtn').show();
        $('#completedbtn').show();
        $('#remarkviewbtn').show();
        //work descriptions
        $('#work_des_label').show();
        $('#work_id').show();
        $('#work_name').show();
    });

    $('#cancel_completed').on('click',function(event){

        event.preventDefault();
        //completed index
        $('#completed_label').hide();
        $('#completed_file').hide();
        $('#com_remark_label').hide();
        $('#completed_remark').hide();
        $('#submit_completed').hide();
        $('#cancel_completed').hide();
        
        //buttons
        $('#inprogressgbtn').show();
        $('#pendingbtn').show();
        $('#completedbtn').show();
        $('#remarkviewbtn').show();
        //work descriptions
        $('#work_des_label').show();
        $('#work_id').show();
        $('#work_name').show();
    });
    
// submit in progress
$('#submit_progress').click(function(event){

    event.preventDefault();
    var id = $('#work_id').val(); 
    var work_name = $('#work_name').val();
    var remarks = $('#in_progress').val();
    
    $.ajax({
        url: 'WorkCalendar/ajaxProgressInsert.php',
        type: 'post',
        data: {'remarks':remarks,'id':id, 'work_name':work_name},
        dataType: 'json',
        cache: false,
        success: function(response){
            
            $('#insertsuccess').show();
            setTimeout(function() {
                $('#insertsuccess').fadeOut('fast');
                // location.href='dashboard';
                getTableValues();
                }, 1000);
            // buttons
            $('#inprogressgbtn').show();
            $('#pendingbtn').show();
            $('#completedbtn').show();
            $('#remarkviewbtn').show();
            //work descriptions
            $('#work_des_label').show();
            $('#work_id').show();
            $('#work_name').show();
            
            // progress index
            $('#progress_label').hide();
            $('#in_progress').hide();
            $('#submit_progress').hide();
            $('#cancel_progress').hide();
        }
    });
});

// submit pending
$('#submit_pending').click(function(event){

    event.preventDefault();
    var id = $('#work_id').val();
    var work_name = $('#work_name').val();
    var remarks = $('#pending').val();
    
    $.ajax({
        url: 'WorkCalendar/ajaxPendingInsert.php',
        type: 'post',
        data: {'remarks':remarks,'id':id, 'work_name':work_name},
        dataType: 'json',
        cache: false,
        success: function(response){
            
            $('#insertsuccess').show();
            setTimeout(function() {
                $('#insertsuccess').fadeOut('fast');
                // location.href='dashboard';
                getTableValues();
            }, 1000);

            // buttons
            $('#inprogressgbtn').show();
            $('#pendingbtn').show();
            $('#completedbtn').show();
            $('#remarkviewbtn').show();

            // work descriptions
            $('#work_des_label').show();
            $('#work_id').show();
            $('#work_name').show();
            
            // progress index
            $('#pending_label').hide();
            $('#pending').hide();
            $('#submit_pending').hide();
            $('#cancel_pending').hide();
        }
    });
});

// submit Completed
$('#submit_completed').click(function(event){

    event.preventDefault();
    var id = $('#work_id').val();
    var work_name = $('#work_name').val();
    var completed_remark = $('#completed_remark').val();
    var completed_file = $('#completed_file')[0].files[0];

    var formData = new FormData();
    formData.append('id', id);
    formData.append('work_name', work_name);
    formData.append('completed_file', completed_file);
    formData.append('completed_remark', completed_remark);

    $.ajax({
        url: 'WorkCalendar/ajaxCompletedInsert.php',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
        cache: false,
        success: function(response){
            $('#insertsuccess').show();
            setTimeout(function() {
                $('#insertsuccess').fadeOut('fast');
                // location.href='dashboard';
                getTableValues();
            }, 1000);

            //buttons
            $('#inprogressgbtn').show();
            $('#pendingbtn').show();
            $('#completedbtn').show();
            $('#remarkviewbtn').show();
            
            //work descriptions
            $('#work_des_label').show();
            $('#work_id').show();
            $('#work_name').show();
            
            //progress index
            $('#completed_label').hide();
            $('#completed_file').hide();
            $('#com_remark_label').hide();
            $('#completed_remark').hide();
            $('#submit_completed').hide();
            $('#cancel_completed').hide();
        }
    });
});


// submit outdated
$('#submit_outdated').click(function(event){

    event.preventDefault();
    var id = $('#work_id1').val(); 
    var work_name = $('#work_name1').val();
    var outdated = $('#outdated').val();
    var completed_remark_outdated = $('#completed_remark_outdated').val();
    
    $.ajax({
        url: 'WorkCalendar/ajaxOutDatedInsert.php',
        type: 'post',
        data: {'outdated':outdated,'id':id, 'work_name':work_name, 'completed_remark_outdated': completed_remark_outdated},
        dataType: 'json',
        cache: false,
        success: function(response){
            
            $('#insertsuccess1').show();
            setTimeout(function() {
                $('#insertsuccess1').fadeOut('fast');
                // location.href='dashboard';
                getTableValues();
            }, 1000);
           
            // $('#over_due_label').show();
            // $('#outdated').show();
            // $('#submit_outdated').show();
            // $('#cancel_outdated').show();
        }
    });
});




});//document ready end

$(function(){ //Onload Function
    var userRole = $('#user_role').val();
    if(userRole == '3' || userRole == '4'){ // 3- Manager, 4 -Staff.
        $('.staff_manager_login').show();
        getTableValues(); //To show TODO List.
    }else{
        $('.staff_manager_login').hide();
    }
    //Manager Login 
    if(userRole == '3'){ // 3- Manager.
        $('.manager_login').show();
    }else{
        $('.manager_login').hide();
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

function regularisation_approve(upd){
    event.preventDefault();
    window.location.href='permission_approval&upd='+upd;
}

function callupdfunc(end_date, work_id, work_des){

    var today = moment().format('YYYY-MM-DD'); 
    if(end_date < today){
        
        $("#workStatusModal1").addClass("show");
        $("#workStatusModal1").removeAttr("aria-hidden");
        $("#workStatusModal1").css("display","block");
        $("#workStatusModal1").css("width","500px");

        $('#work_id1').val(work_id);
        $('#work_name1').val(work_des);

    } else { 
    
        $("#workStatusModal").addClass("show");
        $("#workStatusModal").removeAttr("aria-hidden");
        $("#workStatusModal").css("display","block");
        $("#workStatusModal").css("width","500px");

        $('#work_id').val(work_id);
        $('#work_name').val(work_des);
    }

    $.ajax({
        url: 'WorkCalendar/getInProgressRemark.php',
        type: 'post',
        data: {'work_id':work_id},
        cache: false,
        success: function(response){
            $("#inprogress_sts").empty();
            $("#inprogress_sts").html(response);
        }
    });
    $.ajax({
        url: 'WorkCalendar/getPendingRemark.php',
        type: 'post',
        data: {'work_id':work_id},
        cache: false,
        success: function(response){
            $("#pending_sts").empty();
            $("#pending_sts").html(response);
        }
    });
    $.ajax({
        url: 'WorkCalendar/getCompletedRemark.php',
        type: 'post',
        data: {'work_id':work_id},
        cache: false,
        success: function(response){
    
            $('#complete_sts').empty();
            $('#complete_sts').html(response);
        }
    });    

} //callupdFunc END.


// reset modal contents while close modal 
function closeStatusModal(){

    $("#workStatusModal").removeClass("show");
    $("#workStatusModal").attr("aria-hidden", "true");
    $("#workStatusModal").css("display","none");

    // buttons
    $('#inprogressgbtn').show();
    $('#pendingbtn').show();
    $('#completedbtn').show();
    $('#remarkviewbtn').show();

    // work descriptions
    $('#work_des_label').show();
    $('#work_id').show();
    $('#work_name').show();
    
    // progress index
    $('#progress_label').hide();
    $('#in_progress').hide();
    $('#submit_progress').hide();
    $('#cancel_progress').hide();

    // pending index
    $('#pending_label').hide();
    $('#pending').hide();
    $('#submit_pending').hide();
    $('#cancel_pending').hide();

    // completed index
    $('#completed_label').hide();
    $('#completed_file').hide();
    $('#com_remark_label').hide();
    $('#completed_remark').hide();
    $('#submit_completed').hide();
    $('#cancel_completed').hide();
}

// reset modal contents while close modal1
function closeStatusModal1(){

    $("#workStatusModal1").removeClass("show");
    $("#workStatusModal1").attr("aria-hidden", "true");
    $("#workStatusModal1").css("display","none");

}

function closeRemarkModal(){
    $("#completedRemark").removeClass("show");
    $("#completedRemark").attr("aria-hidden", "true");
    $("#completedRemark").css("display","none");

    $('#completed_Remark').text('');
    $('#com_file').attr('href','')
    $('#com_file').children().text('')

}