$(document).ready(function () {

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

    // get department based on company
    $('#branch_id').on('change',function(){

        var company_id = $('#branch_id :selected').val();
        $.ajax({
            url: 'R&RFile/ajaxR&RDepartmentDetails.php',
            type:'post',
            data: {'company_id': company_id},
            dataType: 'json',
            success: function(response){
                
                $("#from_department").empty();
                $("#from_department").prepend("<option value=''>"+'From Department'+"</option>");
                var r = 0;
                for (r = 0; r <= response.department_id.length - 1; r++) { 
                    $('#from_department').append("<option value='" + response['department_id'][r] + "'>" + response['department_name'][r] + "</option>");
                }
                
                $("#to_department").empty();
                $("#to_department").prepend("<option value=''>"+'To Department'+"</option>");
                var i = 0;
                for (i = 0; i <= response.department_id.length - 1; i++) { 
                    $('#to_department').append("<option value='" + response['department_id'][i] + "'>" + response['department_name'][i] + "</option>");
                }
            }
        });
    });

    // get staff based on department
    $('#to_department').on('change',function(){

        var to_department = $('#to_department :selected').val();
        $.ajax({
            url: 'memoFile/ajaxFetchEmployee.php',
            type:'post',
            data: {'to_department': to_department},
            dataType: 'json',
            success: function(response){
                
                $("#assign_employee").empty();
                $("#assign_employee").prepend("<option value=''>"+'Assign Employee'+"</option>");
                var r = 0;
                for (r = 0; r <= response.staff_id.length - 1; r++) { 
                    $('#assign_employee').append("<option value='" + response['staff_id'][r] + "'>" + response['staff_name'][r] + "</option>");
                }
            }
        });
    });

    // get initial phase based on staff
    $('#assign_employee').on('change',function(){

        var assign_employee = $('#assign_employee :selected').val();
        $.ajax({
            url: 'memoFile/ajaxFetchInitialPhase.php',
            type:'post',
            data: {'assign_employee': assign_employee},
            dataType: 'json',
            success: function(response){

                if(response['reporting'] != ''){
                    $("#initial_phase").empty();
                    $("#initial_phase").prepend("<option value=''>"+'Assign Employee'+"</option>");
                    var r = 0;
                    for (r = 0; r <= response.staff_id.length - 1; r++) { 
                        $('#initial_phase').append("<option value='" + response['staff_id'][r] + "'>" + response['reporting'][r] + "</option>");
                    }
                }

            }
        });
    });
 
    // get final phase based on staff
    $('#initial_phase').on('change',function(){

        var initial_phase = $('#initial_phase :selected').val();
        $.ajax({
            url: 'memoFile/ajaxFetchFinalPhase.php',
            type:'post',
            data: {'initial_phase': initial_phase},
            dataType: 'json',
            success: function(response){
                
                $("#final_phase").empty();
                $("#final_phase").prepend("<option value=''>"+'Assign Employee'+"</option>");
                var r = 0;
                for (r = 0; r <= response.staff_id.length - 1; r++) { 
                    $('#final_phase').append("<option value='" + response['staff_id'][r] + "'>" + response['reporting'][r] + "</option>");
                }
            }
        });
    });

});

$(function(){
    
    var idupd = $('#idupd').val();
    if(idupd>0 && idupd !=''){
        editCompanyBasedBranch();
    }else{
        var branch_id = $('#branch_id').val();
        getdepartmentLoad(branch_id);
    }

});

function editCompanyBasedBranch(){  
    var branch_id = $('#company_nameEdit').val();
    $.ajax({
        url: 'R&RFile/ajaxEditCompanyBasedBranch.php',
        type:'post',
        data: {'branch_id': branch_id},
        dataType: 'json',
        success: function(response){
            
            $("#branch_id").empty();
            $("#branch_id").prepend("<option value='' disabled selected>"+'Select Branch Name'+"</option>");
            var r = 0;
            for (r = 0; r <= response.branch_id.length - 1; r++) { 
                var selected = "";
                if(response['branch_id'][r] == branch_id)
                {
                    selected = "selected";
                }
                $('#branch_id').append("<option value='" + response['branch_id'][r] + "' "+selected+">" + response['branch_name'][r] + "</option>");
            }
        }
    });

    getdepartmentLoad(branch_id);
}

// get department details
function getdepartmentLoad(branch_id){ 

    var to_dept = $('#to_deptEdit').val(); 
    $.ajax({
        url: 'memoFile/ajaxR&RDepartmentDetailsLoad.php',
        type: 'post',
        data: {'branch_id': branch_id},
        dataType: 'json',
        success:function(response){     
            
            $("#to_department").empty();
            $("#to_department").prepend("<option value=''>"+'To Department'+"</option>");
            var i = 0; 
            for (i = 0; i <= response.department_id.length - 1; i++) {   
                var selected = "";
                if(to_dept == response['department_id'][i]){  
                    selected = "selected";
                }
                $('#to_department').append("<option value='" + response['department_id'][i] + "' "+selected+">" + response['department_name'][i] + "</option>");
            }
        }
    });
};