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

    $('#submit_daily_task_update').click(function(e){
        // Select rows where the work_status select element has an empty value
        var removerows = $('#taskTable tbody tr td select.work_status').filter(function() {
            return $(this).val() == '';
        });
        // Remove the parent row of each selected element
        removerows.closest('tr').remove();
    });

}); //Document END.

//Function On Load.
$(function(){
    var staffid = $('#staffid').val();
    var branch_id = $('#branch_id').val();
    if(staffid !='Overall'){ // For Staff Login.
        $('#dailytask_update').hide();
        setalltoReadonly();
        getStaffLoad(branch_id);

        setTimeout(() => {
            $('#dailytask_update').click();
            
        }, 1000);

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
        $('#employee').append("<option value='" + response['staff_id'][r] + "'"+selected+" data-value='"+ response['designation'][r] +"'>" + response['staff_name'][r] +' - (' + response['designationName'][r] +')'+ "</option>");
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
    var current_date = $('#current_date').val();
    $.ajax({
        url: 'dailyTaskUpdateFile/getDailyTaskUpdate.php',
        type: 'post',
        data: {'desgn_id':desgn_id, 'staffid': staffid, 'current_date': current_date},
        success:function(response){ 
        $('#dailyTaskTable').empty();
        if(response == 0){
            $('#dailyTaskTable').html("<tr><td colspan='4'>No Record Found!</td></tr>");

        }else{
            $('#dailyTaskTable').html(response);

        }
        }
    });
}

