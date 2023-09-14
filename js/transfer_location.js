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
        
        calltocompanylist();
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

            // getTransferLocation(branch_id);
        }
    });

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

    callKraKpiList(staff_name,'','2');
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

 //To Branch based on to_company
$('#to_company_id').change(function(){
    var to_company_id = $('#to_company_id :selected').val();
    calltobranchList(to_company_id);
})

 //To Department based on to_branch
$('#to_branch_id').change(function(){
    var to_branch_id = Array.from($('#to_branch_id').val()); // we using common page to get branch based department so send data as in the page.
    var branch_id = $('#branch_id :selected').val();
    calltodeptList(to_branch_id, branch_id,'');
})

 //To Designation based on to_department
$('#to_department').change(function(){

    var to_department_id = $(this).val(); 
    calltoDesignationList(to_department_id,'','2');

})

});

$(function(){
    var transfered_branch_id = $('#id').val();
    if(transfered_branch_id != undefined && transfered_branch_id != ''){
        var branch_id = $("#branchIdEdit").val();
        // getTransferLocation(branch_id);
        calltocompanylist();
        var to_company = $('#to_company').val();
        calltobranchList(to_company);

        var to_branch = Array.from($('#to_branch').val());
        var to_dept = $('#to_dept').val();
        calltodeptList(to_branch, branch_id,to_dept);

        var to_dept = $('#to_dept').val();
        var to_desgn = $('#to_desgn').val();
        calltoDesignationList(to_dept,to_desgn,'1');

        var staffIdEdit = $("#staffIdEdit").val(); 
        var krikpiEdit = $("#krikpiEdit").val(); 
        callKraKpiList(staffIdEdit,krikpiEdit,'1')
    }
    
    var checkID = $('#checkID').val();
    if(checkID != 'Overall' && checkID != ''){
        // getTransferLocation(checkID);
    }
})

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
// function getTransferLocation(branch_id){
//     var transfered_branch_id = $('#id').val();
//     $.ajax({
//         type: 'POST',
//         data: {"branch_id": branch_id},
//         cache: false,
//         url: 'transferLocationFile/getTransferLocation.php',
//         dataType: 'json',
//         success: function(response){
//             $('#transfer_location').empty();
//             $('#transfer_location').append('<option value=""> Select Transfer Location </option>');
//             for(var i=0; i<response.length; i++){
//                 var selected ='';
//                 if(response[i]['branch_id'] == transfered_branch_id){
//                     selected = 'Selected';
//                 }
//                 $('#transfer_location').append('<option value="'+response[i]['branch_id'] +'" '+selected+'>'+ response[i]['branch_name'] +'</option>')
//             }
//         }
//     })
// }


function calltocompanylist(){
    var toCompany = $('#to_company').val();
    $.ajax({
        url: 'ajaxFetch/ajaxgetcompanyList.php',
        type:'post',
        data: {},
        dataType: 'json',
        success: function(response){
            
            $("#to_company_id").empty();
            $("#to_company_id").prepend("<option value=''>"+'Select To Company Name'+"</option>");
            var r = 0;
            for (r = 0; r < response.length; r++) { 
                var selected = ''
                if(toCompany == response[r]['companyId'] ){
                    selected = 'selected';
                }
                    $('#to_company_id').append("<option value='" + response[r]['companyId'] + "'"+selected+">" + response[r]['companyName'] + "</option>");
            }
        }
    });
}

function calltobranchList(to_company_id){
    var toBranch = $('#to_branch').val();
    // var to_company_id = $('#to_company_id :selected').val();
        $.ajax({
            url: 'basicFile/ajaxFetchBranchDetails.php',
            type:'post',
            data: {'company_id': to_company_id},
            dataType: 'json',
            success: function(response){
                
                $("#to_branch_id").empty();
                $("#to_branch_id").prepend("<option value='' disabled selected>"+'Select To Branch Name'+"</option>");
                var r = 0;
                for (r = 0; r <= response.branch_id.length - 1; r++) { 
                    var selected = ''
                if(toBranch == response['branch_id'][r] ){
                    selected = 'selected';
                }
                    $('#to_branch_id').append("<option value='" + response['branch_id'][r] + "'"+selected+">" + response['branch_name'][r] + "</option>");
                }
            }
        });
}

function calltodeptList(to_branch_id, branch_id, toDept){

    if(to_branch_id == branch_id || branch_id == ''){
        alert('Transfer not allowed for same branch or no branch.')
        $('#to_branch_id').val('');
    }else{
        $.ajax({
            url: 'ajaxFetch/ajaxGetBranchBasedDept.php',
            type:'post',
            data: {'branchId': to_branch_id},
            dataType: 'json',
            success: function(response){
                
                $("#to_department").empty();
                $("#to_department").prepend("<option value=''>"+'Select To Department Name'+"</option>");
                var r = 0;
                for (r = 0; r <= response.length - 1; r++) { 
                    var selected = ''
                if(toDept == response[r]['department_id'] ){
                    selected = 'selected';
                }
                    $('#to_department').append("<option value='" + response[r]['department_id'] + "'"+selected+">" + response[r]['department_name'] + "</option>");
                }
            }
        });
    }
}

function calltoDesignationList(to_department_id,todesgn,edit_ins){
    $.ajax({
        url: 'ajaxFetch/ajaxGetDesignationWithValidation.php',
        type:'post',
        data: {'department_id': to_department_id, 'edit_ins': edit_ins},
        dataType: 'json',
        success: function(response){
            
            $("#to_designation").empty();
            $("#to_designation").prepend("<option value=''>"+'Select To Designation Name'+"</option>");
            var r = 0;
            for (r = 0; r < response.designation_id.length; r++) { 
                var selected = ''
                if(todesgn == response['designation_id'][r] ){
                    selected = 'selected';
                }
                $('#to_designation').append("<option value='" + response['designation_id'][r] + "'"+selected+">" + response['designation_name'][r] + "</option>");
            }
        }
    });
}

function callKraKpiList(staffcode,krakpiid,editInsert){
    $.ajax({
        url: 'ajaxFetch/ajaxGetkrakpibasedondesignation.php',
        type:'post',
        data: {'staffcode': staffcode, 'editInsert': editInsert},
        dataType: 'json',
        success: function(response){
            
            $("#krikpi").empty();
            $("#krikpi").prepend("<option value=''>"+'Select KRA & KPI'+"</option>");
            var r = 0;
            for (r = 0; r < response.length; r++) { 
                var selected = ''
                if(krakpiid == response[r]['krakpi_id'] ){
                    selected = 'selected';
                }
                $('#krikpi').append("<option value='" + response[r]['krakpi_id'] + "'"+selected+">" + response[r]['designation_name'] + "</option>");
            }
        }
    });
}