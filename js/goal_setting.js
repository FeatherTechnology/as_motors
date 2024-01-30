// Initialize Choices.js for the new multi-select dropdown
// choices js for multi select dropdown:
const staffname = new Choices('#staff_name0', {
	removeItemButton: true,
    allowHTML: true, // Set allowHTML to true
});

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

    var totalRows = $('#goalsettingInfo tr').length;

    // Create a unique ID for the select element in the new row
    var selectId = 'staff_name' + totalRows;
    var selectAssertion = 'assertion' + totalRows;
    
    var appendTxt = '<tr><td><select tabindex="5" class="form-control assertion_names" id="'+selectAssertion+'" name="assertion[]"><option value="">Select Assertion </option></select><input type="hidden" class="form-control" id="rowcnt" name="rowcnt[]" value="'+lencnt+'"></td><td><input tabindex="6" type="number" class="form-control" id="target" name="target[]" placeholder="Enter Target"></td><td><input type="month" tabindex="7" class="form-control" id="goal_month" name="goal_month[]"></td><td><select tabindex="8" class="form-control" id="monthly_conversion" name="monthly_conversion[]"><option value="">Select Type</option><option value="0">Month</option><option value="1">Daily</option></select></td><td><select tabindex="9" class="form-control" id="entry_date_type" name="entry_date_type[]"><option value="">Select Type</option><option value="0">Current date</option><option value="1">Previous date</option></select></td><td><select tabindex="10" class="form-control" id="'+selectId+'" name="staff_name'+totalRows+'[]" multiple><option value="">Select Staff Name</option></select></td><td><button type="button" tabindex="11" id="add_row" name="add_row" value="Submit" class="btn btn-primary add_row">Add</button></td><td><span class="icon-trash-2" tabindex="12" id="delete_row"></span></td></tr>';
    $('#moduleTable').find('tbody').append(appendTxt);

    // Initialize Choices.js for the new multi-select dropdown
    var newChoiceVarName = new Choices('#' + selectId, {
        removeItemButton: true,
        allowHTML: true, // Set allowHTML to true
    });

    var dept_id = $('#dept').val(); 
    staffNameListBasedOnDept(dept_id,newChoiceVarName)

    DropDownAssertion('#'+selectAssertion,'');//Get Assertion dropdown for each row append//
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
    $('#companyid').val(company_id);
    var userbranch = '';
    getBranchList(company_id, userbranch);
});

$('#branch_name').change(function(){ // To get Department Name.
    var branchid = $('#branch_name').val();
    $('#branchid').val(branchid);
    var dept_id = '';
    getDepartmentList(branchid, dept_id);
})

$('#dept').change(function() { 
    var department_id =$('#dept').val();
    $('#deptid').val(department_id);
    // var designation_id ='';
    // getDesignationList(department_id,designation_id);
    staffNameListBasedOnDept(department_id,staffname);
    DropDownAssertion('#assertion0','');//Get Assertion dropdown//
});

//Modal Box for Assertion Name
$('#add_responsibilityDetails').click(function(){
    resetAssertionTable()
});

$('#submitAssertionBtn').click(function(){
    var branch_id = $('#branch_name :selected').val();
    var dept = $('#dept :selected').val();
    var assertion_id=$("#assertion_id").val();
    var assertion_name=$("#assertion_name").val();

        if(assertion_name!=""){
            $.ajax({
                url: 'targetFixingFile/ajaxInsertAssertion.php',
                type: 'POST',
                data: {"assertion":assertion_name, "assertion_id":assertion_id, "branch_id": branch_id, "dept_id": dept},
                cache: false,
                success:function(response){
                    var insresult = response.includes("Exists");
                    var updresult = response.includes("Updated");
                    if(insresult){
                        $('#assertionInsertNotOk').show(); 
                        setTimeout(function() {
                            $('#assertionInsertNotOk').fadeOut('fast');
                        }, 2000);
                    }else if(updresult){
                        $('#assertionUpdateOk').show();  
                        setTimeout(function() {
                            $('#assertionUpdateOk').fadeOut('fast');
                        }, 2000);
                        resetAssertionTable();
                        $("#assertion_id").val('');
                        $("#assertion_name").val('');
                    }
                    else{
                        $('#assertionInsertOk').show();  
                        setTimeout(function() {
                            $('#assertionInsertOk').fadeOut('fast');
                        }, 2000);
                        resetAssertionTable();
                        $("#assertion_id").val('');
                        $("#assertion_name").val('');
                    }
                }
            });
        }
        else{
        $("#assertionnameCheck").show();
        }
    });

    $("#assertion_name").keyup(function(){
        var resval = $("#assertion_name").val();
        if(resval.length == ''){
        $("#assertionnameCheck").show();
        return false;
        }else{
        $("#assertionnameCheck").hide();
        }
    });

    $("body").on("click","#edit_assertion",function(){
        var assertion_id = $(this).attr('value');
        $("#assertion_id").val(assertion_id);
        $.ajax({
            url: 'targetFixingFile/ajaxEditAssertion.php',
            type: 'POST',
            data: {"assertion_id":assertion_id},
            cache: false,
            success:function(response){
            $("#assertion_name").val(response);
            }
        });
    });

    $("body").on("click","#delete_assertion", function(){
    var isok=confirm("Do you want Delete Assertion?");
    if(isok==false){
    return false;
    }else{
        var assertion_id=$(this).attr('value');
        var c_obj = $(this).parents("tr");
        $.ajax({
            url: 'targetFixingFile/ajaxDeleteAssertion.php',
            type: 'POST',
            data: {"assertion_id":assertion_id},
            cache: false,
            success:function(response){
                var delresult = response.includes("Rights");
                if(delresult){
                $('#assertionDeleteNotOk').show(); 
                setTimeout(function() {
                $('#assertionDeleteNotOk').fadeOut('fast');
                }, 2000);
                }
                else{
                c_obj.remove();
                $('#assertionDeleteOk').show();  
                setTimeout(function() {
                $('#assertionDeleteOk').fadeOut('fast');
                }, 2000);
                }
            }
        });
    }
    });
//Modal Box for Assertion Name END

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

        // var role_id_up = $('#role_id_up').val();
        // getDesignationList(dept_id_upd, role_id_up);

        getgoalsettingsdetails(idupd,dept_id_upd); //if edit page means the details will be show in table.

    }else{

        var role = $('#user_role').val();
        if(role != '1'){ //if staff or manager login then the details will come automatically.
            var company_id = $('#user_company').val(); 
            var userbranch = $('#user_branch').val();
            getBranchList(company_id, userbranch); //Branch name append auto except for super admin.
    
            var branchid = $('#user_branch').val();
            var dept_id = $('#user_department').val();
            getDepartmentList(branchid, dept_id);
            staffNameListBasedOnDept(dept_id,staffname)
            
            var user_designation = $('#user_designation').val();
            // getDesignationList(dept_id, user_designation);

            var userComid = $('#user_company').val();
            getCompanyNameList(userComid); //Company List.
            
            setTimeout(() => {
                DropDownAssertion('#assertion0','');//Get Assertion dropdown//
            }, 1000);

        }else{
            var com = '';
            getCompanyNameList(com); //Company List.
        }

    }

    var userRole = $('#user_role').val();
    if(userRole == '4'){
        $('#submit_goal_settings').hide();
    }

    if(userRole != '1'){
        $('.managerlogindisable').attr('disabled', true);
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
                $('#companyid').val(companyid);
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
                    $('#branchid').val(branchid);
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
                    $('#deptid').val(data[a]['department_id']);
                }
                $('#dept').append("<option value='"+data[a]['department_id']+"'"+selected+">"+data[a]['department_name']+"</option>");
            }
        }
    });
}

// function getDesignationList(department_id, role_id_up){
//     $.ajax({
//         url: 'R&RFile/ajaxR&RDesignationDetails.php',
//         type: 'post',
//         data: { "department_id":department_id },
//         dataType: 'json',
//         success:function(response){
//             $('#designation').text('');
//             $('#designation').val('');
//             var option = $('<option></option>').val('').text('Select Designation Name');
//             $('#designation').append(option);
//             var i = 0;
//             for (i = 0; i <= response.designation_id.length - 1; i++) { 
//             var selected = "";
//             if(role_id_up == response['designation_id'][i]){
//                 selected = "selected";
//             }
//             $('#designation').append("<option value='" + response['designation_id'][i] + "' "+selected+" >" + response['designation_name'][i] + "</option>");
//             }
//         }
//         }); 
// }

function getgoalsettingsdetails(idupd,dept_id_upd){ //edit screen details.
    $.ajax({
        url: 'targetFixingFile/ajaxGoalSettingsDetails.php',
        data: {'goal_setting_ref': idupd, 'department_id': dept_id_upd },
        cache: false,
        type:'post',
        success: function(response){
            $('#goalsettingInfo').empty(); 
            $('#goalsettingInfo').html(response); 
        }
    });
}

//staff Name List
function staffNameListBasedOnDept(department_id,multiSelectId){ 
    $.ajax({
        url: 'targetFixingFile/ajaxGetDepartmentBasedStaffs.php',
        type: 'post',
        data: { "department_id":department_id },
        dataType: 'json',
        success:function(response){  

            $('#dept_strength').val(response.staff_id.length);

            multiSelectId.clearStore();
            for (r = 0; r < response.staff_id.length; r++) { 

                var staff_id = response['staff_id'][r];  
                var staff_name = response['staff_name'][r]; 
                var designation_name = response['designation_name'][r]; 

                var selected = '';
                    // for(var i=0;i<staff_id.length;i++){ 
                    //     if(staff_id[i] == staff_id){  
                    //         selected = 'selected';
                    //     }
                    // }

                var items = [
                    {
                        value: staff_id,
                        label: staff_name +'- ('+ designation_name +')',
                        selected: selected,
                    }
                ];
                multiSelectId.setChoices(items);
                multiSelectId.init();
            }

        }
    });
};

//Assertion Modal START

//reset Assertion modal table
function resetAssertionTable(){
    var dept_id = $('#dept').val();
    $.ajax({
        url: 'targetFixingFile/ajaxResetAssertionTable.php',
        type: 'POST',
        data: {"dept_id":dept_id},
        cache: false,
        success:function(html){
            $("#updatedAssertionTable").empty();
            $("#updatedAssertionTable").html(html);
        }
    });
}

function getSelectAssertion(){
    var assertionValue = {};
    $('.assertion_names').each(function(){
        var id = $(this).attr('id');
        var value = $(this).val();
        assertionValue[id] = value;
    })
    return assertionValue;
}

function DropDownAssertion(id, editvalue){ // when onload & row append passing id, when modal close passing class.
    var branch_id = $('#branch_id :selected').val();
    var dept = $('#dept :selected').val();
    var temporaryAssertion = getSelectAssertion(); //To store assertion value temporary.
    
    $.ajax({
        url: 'targetFixingFile/ajaxGetAssertionDropDown.php',
        type: 'post',
        data: {'branch_id': branch_id, "dept": dept},
        dataType: 'json',
        success:function(response){
            $(id).empty();            
            $(id).append("<option value=''>Select Assertion</option>");
            for(var a = 0; a < response.length; a++){
                var selected = '';
                if(editvalue.trim().toLowerCase() == response[a]['assertion'].trim().toLowerCase()){
                    selected = 'selected';
                }
                $(id).append("<option value='"+response[a]['assertion']+"'"+selected+">"+response[a]['assertion']+"</option>");
            }

            if(editvalue ==''){ //in edit page value initially set so restrict this function, if this function run it affect edit option value.
                $.each(temporaryAssertion, function(key, value) {
                    $('#' + key).val(value);
                });
            }

        }
            
    });     
}
//Assertion Modal END