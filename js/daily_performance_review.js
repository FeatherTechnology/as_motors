// Document is ready
$(document).ready(function () {

    $('#company_name').change(function(){ // To Get Branch Name based on company//
        var company_id = $('#company_name').val(); 
        var userbranch = '';
        getBranchList(company_id, userbranch);
    });
    
    $('#branch_name').change(function(){ // To get Department Name.
        var branchid = $('#branch_name').val();
        var dept_id = '';
        getDepartmentList(branchid, dept_id);
    })

    $('#review_date').change(function(){
        var reviewDate = $(this).val();
        var dept_id = $('#dept').val();
        var user_staff_id = $('#user_staff_id').val();
        daily_performance_review_table(dept_id,user_staff_id,reviewDate);
    });

});  // Document END///

$(function(){

    var role = $('#user_role').val();
    if(role != '1'){ //if staff or manager login then the details will come automatically.
        $('select').attr('disabled',true);
        var company_id = $('#user_company').val(); 
        var userbranch = $('#user_branch').val();
        getCompanyNameList(company_id); //Company List.
        getBranchList(company_id, userbranch); //Branch name append auto except for super admin.

        var branchid = $('#user_branch').val();
        var dept_id = $('#user_department').val();
        getDepartmentList(branchid, dept_id);

    }else{
        var com = '';
        getCompanyNameList(com); //Company List.
    }

}); //Function OnLoad END///


function getCompanyNameList(comid){

    $.ajax({
        type: 'POST',
        data:{},
        url: 'ajaxFetch/ajaxgetcompanyList.php',
        dataType: 'json',
        cache: false,
        success: function(response){
    
            $('#company_name').empty();
            $("#company_name").append("<option value=''> Select Company Name </option>");
            for(var i=0; i < response.length; i++){
                
                var companyid = response[i]['companyId'];
                var companyname = response[i]['companyName'];
                var selected ='';
                if(comid == companyid){
                    selected = 'selected';
                }
    
                $('#company_name').append("<option value='"+companyid+"'"+selected+">"+companyname+"</option>");
            }
            {//To Order staffName Alphabetically
                var firstOption = $("#company_name option:first-child");
                $("#company_name").html($("#company_name option:not(:first-child)").sort(function (a, b) {
                    return a.text == b.text ? 0 : a.text < b.text ? -1 : 1;
                }));
                $("#company_name").prepend(firstOption);
            }
        }
    })
    }
    
function getBranchList(company_id, userbranch){

    $.ajax({
        type: 'POST',
        data:{"company_id": company_id},
        url: 'RGP_ajax/ajaxgetBranchName.php',
        dataType: 'json',
        cache: false,
        success: function(response){
    
            $('#branch_name').empty();
            $("#branch_name").append("<option value=''> Select Branch Name </option>");
            for(var i=0; i < response.length; i++){
                var branchid = response[i]['branch_id'];
                var branchname = response[i]['branch_name'];
                var selected = '';
                if(userbranch == branchid){
                    selected ='selected' ;
                }
                $('#branch_name').append("<option value='"+branchid+"'"+selected+">"+branchname+"</option>");
            }
            {//To Order staffName Alphabetically
                var firstOption = $("#branch_name option:first-child");
                $("#branch_name").html($("#branch_name option:not(:first-child)").sort(function (a, b) {
                    return a.text == b.text ? 0 : a.text < b.text ? -1 : 1;
                }));
                $("#branch_name").prepend(firstOption);
            }
        }
    })
}

function getDepartmentList(branchid, dept_id){
    $.ajax({
        url: 'getgoalsettings.php',
        data: {'branchid': branchid },
        cache: false,
        type:'post',
        dataType: 'json',
        success: function(data){
            $('#dept').empty();            
            $('#dept').append("<option value=''>Select Department Name</option>");
            for(var a = 0; a < data.length; a++){
                var selected = '';
                if(dept_id == data[a]['department_id']){
                    selected = 'selected';
                }
                $('#dept').append("<option value='"+data[a]['department_id']+"'"+selected+">"+data[a]['department_name']+"</option>");
            }
        }
    });
}


function callFunctionAfterSuccess(){

    $('.actual_achieve').keyup(function(){
        var target = parseInt($(this).parent().parent().find('.target').val());
        var actual = parseInt($(this).val()) || 0;
    
        if(actual >= target){
            $(this).parent().parent().find('.wstatus').val('1')
        }else{
            $(this).parent().parent().find('.wstatus').val('2')
        }

        var totalval = target - actual;
        // Ensure totalval is not negative
        totalval = (totalval < 0) ? 0 : totalval;

        // Now totalval will be 0 if it was negative
        $(this).parent().parent().find('.balance_to_do').val(totalval); 


    // Calculate the sum of all actual values
    var sum = 0;
    $('.actual_achieve').each(function() {
        var value = parseInt($(this).val()) || 0;
        sum += value;
    });

    $('#totalAchieves').text(sum);

    var bal = 0;
    $('.balance_to_do').each(function() {
        var balvalue = parseInt($(this).val()) || 0;
        bal += balvalue;
    });

    $('#totalbal').text(bal);

    });
    
}

// daily performance review table
function daily_performance_review_table(dept_id,user_staff_id,reviewDate){ //edit screen details.
    $.ajax({
        url: 'targetFixingFile/ajaxDailyPerformanceReviewTable.php',
        data: {'department_id': dept_id, 'user_staff_id': user_staff_id, 'reviewDate': reviewDate },
        cache: false,
        type:'post',
        success: function(response){
            $('#reviewTable').empty(); 
            if(response == 0){
                $('#reviewTable').html("<tr><td colspan='10'>No Record Found!</td></tr>"); 
                
            }else{
                $('#reviewTable').html(response); 
            }
            callFunctionAfterSuccess();
        }
    }).then(function(){

        $('.review_submit').click(function(){
            var daily_ref_id = $(this).data('id');
            var actualachieve =  $(this).parent().parent().find('.actual_achieve').val();
            var sdate =  $(this).parent().parent().find('.sdate').val();
            var wstatus =  $(this).parent().parent().find('.wstatus').val();
            var managercomment =  $(this).parent().parent().find('.manager_comment').val();
            var goal_setting_ref_id =  $(this).parent().parent().find('.goal_setting_ref_id').val();
            var assertion_table_sno =  $(this).parent().parent().find('.assertion_table_sno').val();
            $.ajax({
                type: 'POST',
                data:{'daily_ref_id':daily_ref_id, 'actualachieve': actualachieve, 'sdate': sdate, 'wstatus': wstatus, 'manager_comment': managercomment, 'goal_setting_ref_id': goal_setting_ref_id, 'assertion_table_sno': assertion_table_sno },
                url: 'targetFixingFile/ajaxDailyPerformanceManagerUpdate.php',
                dataType: 'json',
                cache: false,
                success: function(response){
                    if(response == 1){
                        alert('Updated Successfully');
                    }else{
                        alert('Update Failed');
                    }

                    daily_performance_review_table(dept_id, user_staff_id, reviewDate)
                }
            })
    
        });

        $('.reject_review').click(function(){
            var dlt = confirm("Do you want to Reject this Review?");
            if(dlt){

            var daily_ref_id = $(this).data('id');
            $.ajax({
                type: 'POST',
                data:{'daily_ref_id':daily_ref_id },
                url: 'targetFixingFile/ajaxDailyPerformanceManagerReject.php',
                dataType: 'json',
                cache: false,
                success: function(response){
                    if(response == 1){
                        alert('Review Rejected!');
                    }else{
                        alert('Review Reject Failed');
                    }

                    daily_performance_review_table(dept_id, user_staff_id, reviewDate)
                }
            })

        }else{
            return false;    
        }
    
        });
    })
}