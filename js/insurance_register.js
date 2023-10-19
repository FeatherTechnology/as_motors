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

    // Get branch based on Department
    $("#branch_id").change(function(){
        var company_id = $("#branch_id").val();
        getDeptName(company_id);
        
        // if(company_id.length==''){
        //     $("#branch_id").val('');
        // }else{
        //     $.ajax({
        //         url: 'StaffFile/ajaxStaffDepartmentDetails.php',
        //         type: 'post',
        //         data: { "company_id":company_id },
        //         dataType: 'json',
        //         success:function(response){ 

        //         $('#department').empty();
        //         $('#department').prepend("<option value=''>" + 'Select Department Name' + "</option>");
        //         var r = 0;
        //         for (r = 0; r <= response.department_id.length - 1; r++) { 
        //             $('#department').append("<option value='" + response['department_id'][r] + "'>" + response['department_name'][r] + "</option>");
        //         }
        //         }
        //     });
        // }
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
    // $("#designation").change(function(){ 

    //     var company_id = $("#branch_id").val();
    //     var department_id = $("#department").val();
    //     var designation_id = $("#designation").val();

    //     if(designation_id.length==''){ 
    //         $("#designation").val('');
    //     }else{
    //         $.ajax({
    //             url: 'insuranceFile/ajaxGetDesignationBasedStaff.php',
    //             type: 'post',
    //             data: { "company_id":company_id, "department_id":department_id, "designation_id":designation_id },
    //             dataType: 'json',
    //             success:function(response){
                
    //                 $('#staff_name').empty();
    //                 $('#staff_name').prepend("<option value=''>" + 'Select Staff Name' + "</option>");
    //                 var i = 0;
    //                 for (i = 0; i <= response.staff_id.length - 1; i++) { 
    //                     $('#staff_name').append("<option value='" + response['staff_id'][i] + "'>" + response['staff_name'][i] + "</option>");
    //                 }

    //             }
    //         });
    //     }
    // });
    
    // Modal Submission for Insurance Name
    $("#insurancenameCheck").hide();
    $(document).on("click", "#submiInsurancetBtn", function () {
        var insurance_id=$("#insurance_id").val();
        var insurance_name=$("#insurance_name").val();
        var company_id=$("#branch_id").val();
        if(insurance_name!=""){
            $.ajax({
                url: 'insuranceFile/ajaxInsertinsurance.php',
                type: 'POST',
                data: {"insurance_name":insurance_name,"insurance_id":insurance_id,"company_id":company_id},
                cache: false,
                success:function(response){
                    var insresult = response.includes("Exists");
                    var updresult = response.includes("Updated");
                    if(insresult){
                        $('#insuranceInsertNotOk').show(); 
                        setTimeout(function() {
                            $('#insuranceInsertNotOk').fadeOut('fast');
                        }, 2000);
                    }else if(updresult){
                        $('#insuranceUpdateOk').show();  
                        setTimeout(function() {
                            $('#insuranceUpdateOk').fadeOut('fast');
                        }, 2000);
                        $("#insuranceTable").remove();
                        resetinsuranceTable(company_id);
                        $("#insurance_name").val('');
                        $("#insurance_id").val('');
                    }
                    else{
                        $('#insuranceInsertOk').show();  
                        setTimeout(function() {
                            $('#insuranceInsertOk').fadeOut('fast');
                        }, 2000);
                        $("#insuranceTable").remove();
                        resetinsuranceTable(company_id);
                        $("#insurance_name").val('');
                        $("#insurance_id").val('');
                    }
                }
            });
        }
        else{
        $("#insurancenameCheck").show();
        }
    });

    
    //edit insurance from Modal
    $("body").on("click","#edit_insurance",function(){

        var insurance_id=$(this).attr('value');
        $("#insurance_id").val(insurance_id);
        $.ajax({
                url: 'insuranceFile/ajaxEditinsurance.php',
                type: 'POST',
                data: {"insurance_id":insurance_id},
                cache: false,
                success:function(response){
                $("#insurance_name").val(response);
            }
        });
    });

    //delete insurance from Modal
    $("body").on("click","#delete_insurance", function(){

        var isok=confirm("Do you want delete insurance?");
        if(isok==false){
        return false;
        }else{
            var insurance_id=$(this).attr('value');
            // alert(insurance_id);
            var c_obj = $(this).parents("tr");
            $.ajax({
                url: 'insuranceFile/ajaxDeleteinsurance.php',
                type: 'POST',
                data: {"insurance_id":insurance_id},
                cache: false,
                success:function(response){
                    var delresult = response.includes("Rights");
                    if(delresult){
                    $('#insuranceDeleteNotOk').show(); 
                    setTimeout(function() {
                    $('#insuranceDeleteNotOk').fadeOut('fast');
                    }, 2000);
                    }
                    else{
                    c_obj.remove();
                    $('#insuranceDeleteOk').show();
                    setTimeout(function() {
                        $('#insuranceDeleteOk').fadeOut('fast');
                    }, 2000);
                    
                    }
                }
            });
        }
    });

    //check company if add button clicked
    $(document).on("click", "#add_insuranceDetails", function () {
        if($('#branch_id_session').val() != 'Overall'){
            var company_id = $('#branch_id').val();
        }else{
            var company_id = $('#branch_id :selected').val();
        }
        if(company_id > 0){
            resetinsuranceTable(company_id);
            return true;
        }else{
            alert("Please select company name");
            return false;
        }
   });


    $(document).on('change','#branch_id', function(){
        var company_id = $('#branch_id :selected').val();
        var company_name = $('#branch_id :selected').text();
        var department_upd,insurance_upd ='';
        if(company_id != 0){
            $('#add_insuranceDetails').attr({"data-toggle":"modal" ,"data-target":".add_insuranceModal"});
            resetinsuranceTable(company_id);
            DropDownInsurance(company_id,insurance_upd);
            DropDownDepartment(company_id,department_upd);
        }else{
            $('#add_insuranceDetails').removeAttr({"data-toggle":"modal" ,"data-target":".add_insuranceModal"});
        }
    });

    // enable and disable calendar
    $(document).on("change",".calendar",function(){ 
        var calendar1 = $(this).children(":selected").text();
        var calendar = calendar1.trim();
        if(calendar == 'Yes'){ 
            $('#from_date').attr("readonly",false);
            $('#to_date').attr("readonly",false);
        } else if(calendar == 'No'){ 
            $('#from_date').attr("readonly",true);
            $('#to_date').attr("readonly",true);
            $('#from_date').val('');
            $('#to_date').val('');
        }
    });

    // enable and disable frequency
    $(document).on("change",".frequency",function(){ 
        var frequency1 = $(this).children(":selected").text();
        var frequency = frequency1.trim(); 
        if(frequency == 'Half Yearly'){ 
            $('#frequency_applicable').attr("disabled",false);
        } else  if(frequency == 'Yearly'){ 
            $('#frequency_applicable').prop('checked', false);
            $('#frequency_applicable').attr("disabled",true);
        }
    });


});//document ready End

//auto call function for edit
$(function(){

    DropDownPolicyCompany();
    resetPolicyCompany();
    
    // manager login
    resetinsuranceTableLoad();
    DropDownInsuranceLoad();
    DropDownDepartmentLoad();

    var company_id = $("#branch_id").val();
    // getDeptName(company_id);

    // super admin login

    if($('#branch_id_session').val() != 'Overall'){
        var idupd = $('#branch_id').val();
    }else{
        var idupd = $("#branch_id :selected").val(); 
    }

    $('#add_insuranceDetails').attr({"data-toggle":"modal" ,"data-target":".add_insuranceModal"})
    var upd_name = $("#branch_id :selected").text();
    if(idupd > 0 ){ 
        
        var department_upd = $('#dept_id_upd').val(); 
        // $('#add_insuranceDetails').attr({"data-toggle":"modal" ,"data-target":".add_insuranceModal"})
        
        resetinsuranceTable(idupd);
        DropDownInsurance();
        DropDownDepartment(idupd,department_upd);
    }else{
        // $('#add_insuranceDetails').removeAttr({"data-toggle":"modal" ,"data-target":".add_insuranceModal"});
    }
});

// reset department modal table
function resetinsuranceTable(company_id){
       
    $.ajax({
        url: 'insuranceFile/ajaxResetInsuranceTable.php',
        type: 'POST',
        data: {'company_id':company_id},
        cache: false,
        success:function(html){
            $("#updatedinsuranceTable").empty();
            $("#updatedinsuranceTable").html(html);
        }
    });
}

//Dropdown for insurance
function DropDownInsurance(){
    var company_id = $("#branch_id").val(); 
    var insurance_upd = $('#insurance_id_upd').val();
    $.ajax({
        url: 'insuranceFile/ajaxgetinsurancedropdown.php',
        type: 'post',
        data: {"company_id":company_id},
        dataType: 'json',
        success:function(response){

            var len = response.length;
            $("#ins_name").empty();
            $("#ins_name").append("<option value=''disabled selected>"+'Select Insurance Name'+"</option>");
            for(var i = 0; i<len; i++){
                var insurance_id = response[i]['insurance_id'];
                var insurance_name = response[i]['insurance_name'];
                var selected = "";
                if(insurance_upd == insurance_id){
                    selected = "selected";
                }
                $("#ins_name").append("<option value='"+insurance_id+"' "+selected+">"+insurance_name+"</option>");
            }
        }
    });
}

//Dropdown for Department
function DropDownDepartment(company_id,department_upd){  
    $.ajax({
        url: 'departmentFile/ajaxgetdepartmentdropdown.php',
        type: 'post',
        data: {'company_id': company_id},
        dataType: 'json',
        success:function(response){

            var len = response.length;
            $("#dept").empty();
            $("#dept").append("<option value=''disabled selected>"+'Select Department Name'+"</option>");
            for(var i = 0; i<len; i++){
                var department_id = response[i]['department_id'];
                var department_name = response[i]['department_name'];
                var selected = "";
                if(department_upd == department_id){
                    selected = "selected";
                }
                $("#dept").append("<option value='"+department_id+"' "+selected+" >"+department_name+"</option>");
            }
        }
    });
}

//Dropdown for insurance
function DropDownInsuranceEdit(company_id, insurance_upd){
    var company_id = company_id; 
    var insurance_upd = insurance_upd;
    $.ajax({
        url: 'insuranceFile/ajaxgetinsurancedropdown.php',
        type: 'post',
        data: {"company_id":company_id},
        dataType: 'json',
        success:function(response){

            var len = response.length;

            $("#ins_name").empty();
            $("#ins_name").append("<option value=''disabled selected>"+'Select Insurance Name'+"</option>");
            for(var i = 0; i<len; i++){
                var insurance_id = response[i]['insurance_id'];
                var insurance_name = response[i]['insurance_name'];
                var selected = "";
                if(insurance_upd == insurance_id){
                    selected = "selected";
                }
                $("#ins_name").append("<option value='"+insurance_id+"' "+selected+">"+insurance_name+"</option>");
            }
        }
    });
}

//Dropdown for Department
function DropDownDepartmentEdit(company_id,department_upd){  
    $.ajax({
        url: 'departmentFile/ajaxgetdepartmentdropdown.php',
        type: 'post',
        data: {'company_id': company_id},
        dataType: 'json',
        success:function(response){

            var len = response.length;
            $("#dept").empty();
            $("#dept").append("<option value=''disabled selected>"+'Select Department Name'+"</option>");
            for(var i = 0; i<len; i++){
                var department_id = response[i]['department_id'];
                var department_name = response[i]['department_name']; 
                var selected = "";
                if(department_upd == department_id){ 
                    selected = "selected";
                }
                $("#dept").append("<option value='"+department_id+"' "+selected+" >"+department_name+"</option>");
            }
        }
    });
}

// reset department modal table
function resetinsuranceTableLoad(){
    $.ajax({
        url: 'insuranceFile/ajaxResetInsuranceTableLoad.php',
        type: 'POST',
        data: {},
        cache: false,
        success:function(html){
            $("#updatedinsuranceTable").empty();
            $("#updatedinsuranceTable").html(html);
        }
    });
}

//Dropdown for insurance
function DropDownInsuranceLoad(){ 
    var insurance_upd = $('#insurance_id_upd').val();
    $.ajax({
        url: 'insuranceFile/ajaxgetinsurancedropdownLoad.php',
        type: 'post',
        data: {},
        dataType: 'json',
        success:function(response){

            var len = response.length;
            $("#ins_name").empty();
            $("#ins_name").append("<option value='' disabled selected>"+'Select Insurance Name'+"</option>");
            for(var i = 0; i<len; i++){
                var insurance_id = response[i]['insurance_id'];
                var insurance_name = response[i]['insurance_name'];
                var selected = "";
                if(insurance_upd == insurance_id){
                    selected = "selected";
                }
                $("#ins_name").append("<option value='"+insurance_id+"' "+selected+">"+insurance_name+"</option>");
            }
        }
    });
}

// Dropdown for Department
function DropDownDepartmentLoad(){  
    var insurance_upd = $('#insurance_id_upd').val();
    $.ajax({
        url: 'departmentFile/ajaxgetdepartmentdropdownLoad.php',
        type: 'post',
        data: {},
        dataType: 'json',
        success:function(response){ 

            var len = response.length;
            $("#dept").empty();
            $("#dept").append("<option value='' disabled selected>"+'Select Department Name'+"</option>");
            for(var i = 0; i<len; i++){ 
                var department_id = response[i]['department_id']; 
                var department_name = response[i]['department_name']; 
                var selected = "";
                if(insurance_upd == department_id){
                    selected = "selected";
                } 
                $("#dept").append("<option value='"+department_id+"' "+selected+" >"+department_name+"</option>");
            }
        }
    });
}

function getDeptName(company_id){
    if(company_id.length==''){
        $("#branch_id").val('');
    }else{
        $.ajax({
            url: 'StaffFile/ajaxStaffDepartmentDetails.php',
            type: 'post',
            data: { "company_id":company_id },
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
    }
}



// ///////////////////////////  Policy Company Modal //////////////////////////////

//Policy Company submit button action
$('#submitPolicyCompanyModal').click(function(){
    let policy_com = $("#policy_com").val();
    let policy_com_id = $("#policy_com_id").val();

    if (policy_com !='' ) { 

        $.ajax({
            url:'insuranceFile/policyCompanyInsert.php', 
            data:{'policy_com': policy_com, 'policy_com_id': policy_com_id },
            dataType:'json',
            type:'POST',
            cache: false,
            success:function(response){
                
                var insresult = response.includes("Added");
                var updresult = response.includes("Updated");
                if (insresult) {
                    $('#policyInsertOk').show();
                    setTimeout(function () {
                        $('#policyInsertOk').fadeOut('fast');
                    }, 2000);
                }
                else if (updresult) {
                    $('#policyUpdateOk').show();
                    setTimeout(function () {
                        $('#policyUpdateOk').fadeOut('fast');
                    }, 2000);
                }
                else {
                    $('#policyDeleteNotOk').show();
                    setTimeout(function () {
                        $('#policyDeleteNotOk').fadeOut('fast');
                    }, 2000);
                }

                DropDownPolicyCompany();
                resetPolicyCompany();
            }
        })
    }else{
        $('#companynameCheck').show();
    }
})

$("body").on("click", "#policy_company_edit", function () {
    let id = $(this).attr('value');
    $.ajax({
        url: 'insuranceFile/getPolicyCompanyEdit.php',
        type: 'POST',
        data: { "id": id },
        cache: false,
        success: function(response){
            $("#policy_com_id").val(id);
            $("#policy_com").val(response);
        }
    });
});

$("body").on("click", "#policy_company_delete", function () {
    var isok = confirm("Do you want delete this Policy Company?");
    if (isok == false) {
        return false;
    } else {
        var id = $(this).attr('value');

        $.ajax({
            url: 'insuranceFile/getPolicyCompanyDelete.php',
            type: 'POST',
            data: { "id": id },
            cache: false,
            success: function (response) {
                var delresult = response.includes("Inactivated");
                if (delresult) {
                    $('#policyDeleteOk').show();
                    setTimeout(function () {
                        $('#policyDeleteOk').fadeOut('fast');
                    }, 2000);
                }
                else {

                    $('#policyDeleteNotOk').show();
                    setTimeout(function () {
                        $('#policyDeleteNotOk').fadeOut('fast');
                    }, 2000);
                }

                DropDownPolicyCompany();
                resetPolicyCompany();
            }
        });
    }
});
//Policy Company List Modal Table
function resetPolicyCompany() {
    $.ajax({
        url: 'insuranceFile/policyCompanyReset.php',
        type: 'POST',
        data: { },
        cache: false,
        success: function (html) {
            $("#PolicyCompanyDiv").empty();
            $("#PolicyCompanyDiv").html(html);

            $("#policy_com").val('');
        }
    });
}

//Dropdown for insurance
function DropDownPolicyCompany(){
    $.ajax({
        url: 'insuranceFile/getPolicyCompanyDropDown.php',
        type: 'post',
        data: {},
        dataType: 'json',
        success:function(response){

            var len = response.length;
            $("#policy_company").empty();
            $("#policy_company").append("<option value=''disabled selected>"+'Select Policy Company'+"</option>");

            var policy_company_upd = $('#policy_company_upd').val();
            for(var i = 0; i<len; i++){
                var selected = '';
                if(policy_company_upd == response[i]['policy_company_id']){
                    selected = 'selected';
                }
                $("#policy_company").append("<option value='"+response[i]['policy_company_id']+"' "+selected+" >"+response[i]['policy_company']+"</option>");
            }
        }
    });
}
/////////////////////////////  Policy Company Modal END //////////////////////////////