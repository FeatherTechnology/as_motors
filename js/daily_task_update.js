$(document).ready(function(){

    // get company based branch name
    $('#company_id').on('change', function(){
        var company_id = $('#company_id :selected').val();
        $.ajax({
            url: 'basicFile/ajaxFetchBranchDetails.php',
            type:'post',
            data: {'company_id': company_id},
            dataType: 'json',
            success: function(response){
                
                $("#branch_id").empty();
                $("#branch_id").prepend("<option value='' disabled selected>"+'Select Branch Name'+"</option>");
                var r = 0;
                for (r = 0; r <= response.branch_id.length - 1; r++) { 
                    $('#branch_id').append("<option value='" + response['branch_id'][r] + "'>" + response['branch_name'][r] + "</option>");
                }
            }
        });
    });
    
    // get Staff details
    $('#branch_id').change(function(){
        var branch_id = $(this).val();
        getStaffLoad(branch_id);
    });
    

    $('#dailytask_update').click(function(){ //View Daily Task Update.
        getDailyTaskUpdate();
    });

    $('#submit_daily_task_update').click(function(){ //Update Work_status.
        event.preventDefault();

        var workid = $('#daily_task :selected').data('value');
        var daily_task =$('#daily_task').val();
        var id = workid+daily_task;
        var work_name =$('#daily_task :selected').text();
        var work_status =$('#work_status').val();
        var remarks = $('#work_remark').val();
        var status_file = $('#status_file').val();

        var status_file = $("#status_file")[0];
        var file = status_file.files[0];
    
    
        var formdata = new FormData();
        formdata.append('id', id)
        formdata.append('work_name', work_name)
        formdata.append('work_status', work_status)
        formdata.append('remarks', remarks)
        formdata.append('status_file', file)

        $.ajax({
            url: 'dailyTaskUpdateFile/dailyTasksubmit.php',
            type: 'POST',
            data: formdata,
            processData: false,
            contentType: false,
            cache: false,
            success: function (response) {
                $('#insertsuccess').show();
                setTimeout(function() {
                    $('#insertsuccess').fadeOut('fast');
                    location.href='daily_task_update';
                }, 1000);
    
            }
        });

    })

}); //Document END.

//Function On Load.
$(function(){
    var staffid = $('#staffid').val();
    var branch_id = $('#branch_id').val();
    if(staffid !='Overall'){ // For Staff Login.
        setalltoReadonly();
        getStaffLoad(branch_id);
    }
});

// get staff details
function getStaffLoad(branch_id){ 
$.ajax({
    url: 'todoFile/getStaffNamebasedBranch.php',
    type: 'post',
    data: {'branch_id':branch_id},
    dataType: 'json',
    success:function(response){ 
    var staffid = $('#staffid').val();

    $('#employee').empty();
    $('#employee').prepend("<option value=''>" + 'Select Employee' + "</option>");
    var r = 0;
    for (r = 0; r <= response.staff_id.length - 1; r++) { 
        var selected ='';
        if(staffid == response['staff_id'][r]){
            selected ='selected';
        }
        $('#employee').append("<option value='" + response['staff_id'][r] + "'"+selected+" data-value='"+ response['designation'][r] +"'>" + response['staff_name'][r] + "</option>");
    }
    }
});
}

//Set Readonly all Field if user is staff.
function setalltoReadonly(){
    $('#company_id').attr('readonly',true);
    $('#branch_id').attr('readonly',true);
    $("#employee").attr('disabled',true);
}

//Get Daily task List.
function getDailyTaskUpdate(){
    var desgn_id = $('#employee :selected').data('value');
    var staffid = $('#employee :selected').val();
    $.ajax({
        url: 'dailyTaskUpdateFile/getDailyTaskUpdate.php',
        type: 'post',
        data: {'desgn_id':desgn_id, 'staffid': staffid},
        // dataType: 'json',
        success:function(response){ 
        $('#dailyTaskTable').empty();
        $('#dailyTaskTable').html(response);
        }
    });
}

