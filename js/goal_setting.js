// Document is ready
$(document).ready(function (){

// Add new row
$(document).on('click','#add_row',(function(){
    //var lenz = parseInt($('#rowcnt').val()) + 1;//rowcnt is using for group by the value when get data bcuz the data has duplicate value(if type select daily means then insert for all days in the month except holidays.) so using like this to get single data.
    var sno = $('#snocnt').val();
    var lastRow = $(this).closest('table').find('tr').last();
    // Do something with the last row (for example, get the value of the hidden input with id 'rowcnt')
    var lenz = parseInt(lastRow.find('#rowcnt').val()) + 1;

    var lencnt;
    if(sno > lenz ){
        lencnt = sno;
    }else{
        lencnt = lenz;
    }
    
    var appendTxt = "<tr><td><input tabindex='4' type='text' class='form-control' id='assertion' placeholder='Enter Assertion' name='assertion[]'><input type='hidden' class='form-control' id='rowcnt' name='rowcnt[]' value='"+lencnt+"'></td>"+"<td><input tabindex='6' type='number' class='form-control' id='target' name='target[]' placeholder='Enter Target'></td>"+"<td><input type='month' tabindex='11' class='form-control' id='goal_month' name='goal_month[]'></td><td><select tabindex='11' class='form-control' id='monthly_conversion' name='monthly_conversion[]'><option value=''>Select Type</option><option value='0'>Month</option><option value='1'>Daily</option></select></td>"+"<td> <button type='button' tabindex='9' id='add_row' name='add_row' value='Submit' class='btn btn-primary add_row'>Add</button></td>" + "<td> <span class='icon-trash-2' tabindex='10' id='delete_row'></span></td></tr>";
    $('#moduleTable').find('tbody').append(appendTxt);

}));

// Delete unwanted Rows
$(document).on("click", '#delete_row', function () {

     // Check the number of rows in the table or container
    var numRows = $(this).closest('table').find('tr').length;

    // If there is only one row, prevent removal
    if (numRows <= 2) {
        alert("Cannot remove the last row.");
        return; // Exit the function to prevent further execution
    }

    // If there are more than one rows, proceed with the removal
    $(this).parent().parent().remove();
    
});

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

$('#dept').change(function() { 
    var department_id =$('#dept').val();
    var designation_id ='';
    getDesignationList(department_id,designation_id);
});


}); // Document END////

$(function(){

    var idupd = $('#goal_setting_id').val();
    if(parseInt(idupd) > 0){ // Edit page value getting.
        var com_id_upd = $('#company_id_upd').val();
        getCompanyNameList(com_id_upd); //Company List.

        var userbranch = $('#branch_id_upd').val();
        getBranchList(com_id_upd, userbranch); //Branch name.

        var branch_id_upd = $('#branch_id_upd').val();
        var dept_id_upd = $('#dept_id_upd').val();
        getDepartmentList(branch_id_upd, dept_id_upd);

        var role_id_up = $('#role_id_up').val();
        getDesignationList(dept_id_upd, role_id_up);

        getgoalsettingsdetails(idupd); //if edit page means the details will be show in table.

    }else{

        var role = $('#user_role').val();
        if(role != '1'){ //if staff or manager login then the details will come automatically.
            var company_id = $('#user_company').val(); 
            var userbranch = $('#user_branch').val();
            getBranchList(company_id, userbranch); //Branch name append auto except for super admin.
    
            var branchid = $('#user_branch').val();
            var dept_id = $('#user_department').val();
            getDepartmentList(branchid, dept_id);
            
            var user_designation = $('#user_designation').val();
            getDesignationList(dept_id, user_designation);

            var userComid = $('#user_company').val();
            getCompanyNameList(userComid); //Company List.
        }else{
            var com = '';
            getCompanyNameList(com); //Company List.
        }
    }

    var userRole = $('#user_role').val();
    if(userRole == '4'){
        $('#submit_goal_settings').hide();
    }

})


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

function getDesignationList(department_id, role_id_up){

    $.ajax({
        url: 'R&RFile/ajaxR&RDesignationDetails.php',
        type: 'post',
        data: { "department_id":department_id },
        dataType: 'json',
        success:function(response){
            
            $('#designation').text('');
            $('#designation').val('');
            var option = $('<option></option>').val('').text('Select Designation Name');
            $('#designation').append(option);
            var i = 0;
            for (i = 0; i <= response.designation_id.length - 1; i++) { 
            var selected = "";
            if(role_id_up == response['designation_id'][i]){
                selected = "selected";
            }
            $('#designation').append("<option value='" + response['designation_id'][i] + "' "+selected+" >" + response['designation_name'][i] + "</option>");
            }
        }
        }); 
}

function getgoalsettingsdetails(idupd){ //edit screen details.
    $.ajax({
        url: 'targetFixingFile/ajaxGoalSettingsDetails.php',
        data: {'goal_setting_ref': idupd },
        cache: false,
        type:'post',
        success: function(response){
            $('#goalsettingInfo').empty(); 
            $('#goalsettingInfo').html(response); 
        }
    });
}