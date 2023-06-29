// Document is ready
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
  
    $('#city').change(function() {
        $('#state').val($('#city option:selected').data('id'));
        console.log($('#city option:selected').data('id'));
    })

    // Get branch based on Department
    $("#branch_id").change(function(){
        var branch_id = $("#branch_id").val(); //Branch id
        if(branch_id.length==''){
            $("#branch_id").val('');
        }else{
            $.ajax({
                url: 'StaffFile/ajaxStaffDepartmentDetails.php',
                type: 'post',
                data: { "company_id":branch_id },
                dataType: 'json',
                success:function(response){ 

                    $('#department').empty();
                    $('#department').prepend("<option value=''>" + 'Select Department Name' + "</option>");
                    var r = 0;
                    for (r = 0; r <= response.department_id.length - 1; r++) { 
                    $('#department').append("<option value='" + response['department_id'][r] + "'>" + response['department_name'][r] + "</option>");
                    }
                }
            });

            getTransferLocation(branch_id);
        }
    });
 
});

$(function(){
    var transfered_branch_id = $('#id').val();
    if(transfered_branch_id != undefined && transfered_branch_id != ''){
        var branch_id = $("#branchIdEdit").val();
        getTransferLocation(branch_id);
    }
    
    var checkID = $('#checkID').val();
    if(checkID != 'Overall' && checkID != ''){
        getTransferLocation(checkID);
    }
    

})

// Get Department based on designation
$("#department").change(function(){ 

    var company_id = $("#branch_id").val();
    var department_id = $("#department").val();
    if(department_id.length==''){ 
        $("#department").val('');
    }else{
        $.ajax({
            url: 'StaffFile/ajaxStaffDesignationDetails.php',
            type: 'post',
            data: { "company_id":company_id, "department_id":department_id },
            dataType: 'json',
            success:function(response){
            
                $('#designation').empty();
                $('#designation').prepend("<option value=''>" + 'Select Designation' + "</option>");
                var i = 0;
                for (i = 0; i <= response.designation_id.length - 1; i++) { 
                    $('#designation').append("<option value='" + response['designation_id'][i] + "'>" + response['designation_name'][i] + "</option>");
                }
            }
        });
    }
});

// Get Department based reporting person
$("#department").change(function(){ 

    var company_id = $("#branch_id").val();
    var department_id = $("#department").val();

    if(department_id.length==''){ 
        $("#department").val('');
    }else{
        $.ajax({
            url: 'StaffFile/ajaxGetDeptBasedStaff.php',
            type: 'post',
            data: { "company_id":company_id, "department_id":department_id },
            dataType: 'json',
            success:function(response){
                $('#staff_code').empty();
                $('#staff_code').prepend("<option value=''>" + 'Select Staff Code' + "</option>");
                var i = 0;
                for (i = 0; i <= response.staff_id.length - 1; i++) { 
                    $('#staff_code').append("<option value='" + response['staff_id'][i] + "'>" + response['emp_code'][i] + "</option>");
                }

            }
        });
    }
});

// Get staff code 
$("#staff_code").change(function(){ 

    var company_id = $("#branch_id").val();
    var department_id = $("#department").val();
    var staff_name = $("#staff_code").val();

    if(staff_name.length==''){ 
        $("#staff_name").val('');
    }else{
        $.ajax({
            url: 'StaffFile/ajaxGetStaffBasedStaffCode.php',
            type: 'post',
            data: { "company_id":company_id, "department_id":department_id, "staff_name":staff_name  },
            dataType: 'json',
            success:function(response){
                $('#staff_name').val(response.staff_name);
            }
        });
    }
});


$("#place").keyup(function(){ 

    var place = $("#place").val();
    if(place.length != ''){
        $("#personal_reason").attr("disabled",true);
        $("#leave").attr("disabled",true);
    }else if(place.length == ''){
        $("#personal_reason").attr("disabled",false);
        $("#leave").attr("disabled",false);
    }
});


$("input[name='reason']").click(function(){ 

    var reason = $('input[name="reason"]:checked').val();
    if(reason.length != ''){
        $("#place").attr("disabled",true);
    }else if(reason.length == ''){
        $("#place").attr("disabled",false);
    }
});

// print functionality
function print_transfer_location(id){
    $.ajax({
        url: 'transferLocationFile/printTransferLocation.php',
        cache: false,
        type: 'POST',
        data: { 'id':id },
        success: function(html){
            $("#printTransferLocation").html(html);
        }
    });
}

//Get Transfer Location Based on Branch , Except Selected branch has to show in list.
function getTransferLocation(branch_id){
    var transfered_branch_id = $('#id').val();
    $.ajax({
        type: 'POST',
        data: {"branch_id": branch_id},
        cache: false,
        url: 'transferLocationFile/getTransferLocation.php',
        dataType: 'json',
        success: function(response){
            $('#transfer_location').empty();
            $('#transfer_location').append('<option value=""> Select Transfer Location </option>');
            for(var i=0; i<response.length; i++){
                var selected ='';
                if(response[i]['branch_id'] == transfered_branch_id){
                    selected = 'Selected';
                }
                $('#transfer_location').append('<option value="'+response[i]['branch_id'] +'" '+selected+'>'+ response[i]['branch_name'] +'</option>')
            }
        }
    })
}
