$(document).ready(function(){

    //full name autogenerate
    $('#last_name').keyup(function(){
        var last_name = $('#last_name').val();
        $('#full_name').val('');
        if($('#first_name').val() != ''){
            var first_name = $('#first_name').val();
            $('#full_name').val(first_name +' '+last_name);
        }else{
            $('#full_name').val('');
        }
    });

    //username autocomplete
    $('#email_id').blur(function(){
        var email = $('#email_id').val();
        $('#user_name').val(email);
    });

    // admin module enable disable
    $("#administration_module").on("change", function() {
        var isChecked = $(this).is(":checked");
        $(".admin-checkbox").prop("disabled", !isChecked).prop("checked", isChecked);
    });
    
    // master module enable disable
    var masterCheckbox = document.getElementById("master_module");
    masterCheckbox.addEventListener("change", function() { 
        var disabledCheckboxes = document.getElementsByClassName("master-checkbox");
        var disabledCheckboxes1 = document.getElementsByClassName("master-sub-checkbox");
        var disabledCheckboxes2 = document.getElementsByClassName("responsibility-sub-checkbox");
        var disabledCheckboxes3 = document.getElementsByClassName("audit-sub-checkbox");
        var disabledCheckboxes4 = document.getElementsByClassName("others-sub-checkbox");
        for (var i = 0; i < disabledCheckboxes.length; i++) {
            disabledCheckboxes[i].disabled = !masterCheckbox.checked;
            if (!masterCheckbox.checked) {
                disabledCheckboxes[i].checked = false;
            }
        }
        for (var i = 0; i < disabledCheckboxes1.length; i++) {
            disabledCheckboxes1[i].disabled = !masterCheckbox.checked;
            if (!masterCheckbox.checked) {
                disabledCheckboxes1[i].checked = false;
            }
        }
        for (var i = 0; i < disabledCheckboxes2.length; i++) {
            disabledCheckboxes2[i].disabled = !masterCheckbox.checked;
            if (!masterCheckbox.checked) {
                disabledCheckboxes2[i].checked = false;
            }
        }
        for (var i = 0; i < disabledCheckboxes3.length; i++) {
            disabledCheckboxes3[i].disabled = !masterCheckbox.checked;
            if (!masterCheckbox.checked) {
                disabledCheckboxes3[i].checked = false;
            }
        }
        for (var i = 0; i < disabledCheckboxes4.length; i++) {
            disabledCheckboxes4[i].disabled = !masterCheckbox.checked;
            if (!masterCheckbox.checked) {
                disabledCheckboxes4[i].checked = false;
            }
        }
    });
    
    $("#basic_sub_module").on("change", function() {
        var isChecked = $(this).is(":checked");
        $(".master-sub-checkbox").prop("disabled", !isChecked).prop("checked", isChecked);
    });

    $("#responsibility_sub_module").on("change", function() {
        var isChecked = $(this).is(":checked");
        $(".responsibility-sub-checkbox").prop("disabled", !isChecked).prop("checked", isChecked);
    });

    $("#audit_sub_module").on("change", function() {
        var isChecked = $(this).is(":checked");
        $(".audit-sub-checkbox").prop("disabled", !isChecked).prop("checked", isChecked);
    });

    $("#others_sub_module").on("change", function() {
        var isChecked = $(this).is(":checked");
        $(".others-sub-checkbox").prop("disabled", !isChecked).prop("checked", isChecked);
    });

    // work force module enable disable
    var workForceCheckbox = document.getElementById("work_force_module");
    workForceCheckbox.addEventListener("change", function() {
        var disabledCheckboxes = document.getElementsByClassName("workforce-checkbox");
        var disabledCheckboxes1 = document.getElementsByClassName("scheduletask-sub-checkbox");
        var disabledCheckboxes2 = document.getElementsByClassName("memo-sub-checkbox");
        for (var i = 0; i < disabledCheckboxes.length; i++) {
            disabledCheckboxes[i].disabled = !workForceCheckbox.checked;
            if (!workForceCheckbox.checked) {
                disabledCheckboxes[i].checked = false;
            }
        }
        for (var i = 0; i < disabledCheckboxes1.length; i++) {
            disabledCheckboxes1[i].disabled = !workForceCheckbox.checked;
            if (!workForceCheckbox.checked) {
                disabledCheckboxes1[i].checked = false;
            }
        }
        for (var i = 0; i < disabledCheckboxes2.length; i++) {
            disabledCheckboxes2[i].disabled = !workForceCheckbox.checked;
            if (!workForceCheckbox.checked) {
                disabledCheckboxes2[i].checked = false;
            }
        }
    });
    
    $("#schedule_task_sub_module").on("change", function() {
        var isChecked = $(this).is(":checked");
        $(".scheduletask-sub-checkbox").prop("disabled", !isChecked).prop("checked", isChecked);
    });

    $("#memo_sub_module").on("change", function() {
        var isChecked = $(this).is(":checked");
        $(".memo-sub-checkbox").prop("disabled", !isChecked).prop("checked", isChecked);
    });

    // maintenance module enable disable
    $("#maintenance_module").on("change", function() {
        var isChecked = $(this).is(":checked");
        $(".maintenance-checkbox").prop("disabled", !isChecked).prop("checked", isChecked);
    });

    // audit module enable disable
    $("#audit_module").on("change", function() {
        var isChecked = $(this).is(":checked");
        $(".audit-checkbox").prop("disabled", !isChecked).prop("checked", isChecked);
    });

    // manpower module enable disable
    $("#manpower_in_out_module").on("change", function() {
        var isChecked = $(this).is(":checked");
        $(".manpower-checkbox").prop("disabled", !isChecked).prop("checked", isChecked);
    });

    // target fixing module enable disable
    $("#target_fixing_module").on("change", function() {
        var isChecked = $(this).is(":checked");
        $(".targetfixing-checkbox").prop("disabled", !isChecked).prop("checked", isChecked);
    });
    
    // vehicle management module enable disable
    $("#vehicle_management_module").on("change", function() {
        var isChecked = $(this).is(":checked");
        $(".vehicle-checkbox").prop("disabled", !isChecked).prop("checked", isChecked);
    });

    // approval mechanism module enable disable
    $("#approval_mechanism_module").on("change", function() {
        var isChecked = $(this).is(":checked");
        $(".approvalmechanism-checkbox").prop("disabled", !isChecked).prop("checked", isChecked);
    });

    // employee name
    $('#staff_name').change(function () {	
        let staff_name = $('#staff_name').val();

        $.ajax({ 
            method:"POST",
            url:'manageusersFiles/ajaxFetchEmployeeDetails.php',
            dataType: 'JSON',
            data: {staff_name:staff_name},
            success: function (data)
            { 
                $("#designation_id").val(data['desgn_id']);
                $("#designation").val(data['designation']);
                $("#email").val(data['email']);
                $("#mobilenumber").val(data['mobilenumber']);
            }
        });
    });



    // Validate first name
    // $('#firstNameCheck').hide(); 
    // let first_name_error = true;
    // $('#first_name').keyup(function () {     
    // validateFirstName();
    // });
        
    // function validateFirstName() {
    //     let firstNameValue = $('#first_name').val();  
    //     if (firstNameValue.length == '') {
    //     $('#firstNameCheck').show();
    //     first_name_error = false;
    //         return false;
    //     }
    //     else {
    //         $('#firstNameCheck').hide();
    //         first_name_error = true;   
    //     }
    // }

    // Validate last name
    // $('#lastNameCheck').hide(); 
    // let last_name_error = true;
    // $('#last_name').keyup(function () {     
    //     validateLastName();
    // });
    
    // function validateLastName() {
    //     let lastNameValue = $('#last_name').val();  
    //     if (lastNameValue.length == '') {
    //     $('#lastNameCheck').show();
    //     last_name_error = false;
    //         return false;
    //     }
    //     else {
    //         $('#lastNameCheck').hide();
    //         last_name_error = true;   
    //     }
    // }

	// Validate Email
	// $("#emailidCheck").hide();
	// let emailidError = true;
	// $("#email_id").keyup(function() {
	// 	validateEmail();
	// });
	// function validateEmail() {
	// 	var email_id = $('#email_id').val(); 
	// 	var re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
		
	// 	if(email_id.length == ''){ 
	// 		$("#emailidCheck").show();
	// 		emailidError = false;
	// 	} 
	// 	else if (!re.test(email_id)) {
	// 		$("#emailidCheck").show();
	// 		emailidError = false;
	// 		return false;
	// 	}else{
	// 		$("#emailidCheck").hide();
	// 		emailidError = true;
	// 	}
	// }

    // Validate password
    // $('#passwordcheck').hide(); 
    // let password_error = true;
    // $('#password').keyup(function () {     
    //     validatePassword();
    // });
    
    // function validatePassword() {
    //     let passwordValue = $('#password').val();  
    //     if (passwordValue.length == '') {
    //         $('#passwordcheck').show();
    //         password_error = false;
    //         return false;
    //     }
    //     else {
    //         $('#passwordcheck').hide();
    //         password_error = true;   
    //     }
    // }

    // Validate role
    // $('#roleCheck').hide(); 
    // let role_error = true;
    // $('input[name="role"]').click(function () {     
    //     validateRole();
    // });
    
    // function validateRole() {

    //     let roleValue1 = $("#man_login").prop("checked");  
    //     let roleValue2 = $("#staff_login").prop("checked");  

    //     if (roleValue1 == false && roleValue2 == false) { 
    //         $('#roleCheck').show();
    //         role_error = false;
    //         return false;
    //     } else if (roleValue1 == false && roleValue2 == true) {
    //         $('#roleCheck').hide();
    //         role_error = true; 
    //      } else if (roleValue1 == true && roleValue2 == false) {
    //         $('#roleCheck').hide();
    //         role_error = true; 
    //      }else if (roleValue1 == true || roleValue2 == true) {
    //         $('#roleCheck').hide();
    //         role_error = true; 
    //      }
    // }
    
    // Create new bidder
    // $("#submitusers").click(function(){ 

    //     validateFirstName();
    //     validateLastName();
    //     validateEmail();
    //     validatePassword();
    //     validateRole();
    
    //     if(first_name_error == true && last_name_error == true && emailidError == true && password_error == true && role_error == true ){ 
    //         return true;
    //     }else{
    //         return false;
    //     }
    // });


});//ready state end

$(function(){
    var user_id = $('#id').val();
    if(user_id > 0){
        var adminmodule = document.getElementById('adminmodule');
        var mastermodule = document.getElementById('mastermodule');
        var eventmodule = document.getElementById('eventmodule');
        var inventorymodule = document.getElementById('inventorymodule');
        var billingmodule = document.getElementById('billingmodule');
        var smsmodule = document.getElementById('smsmodule');
        var accountsmodule = document.getElementById('accountsmodule');
        var reportmodule = document.getElementById('reportmodule');
        if(adminmodule.checked){const checkboxesToEnable = document.querySelectorAll("input.admin-checkbox");var adminmodule = document.querySelector('#adminmodule');checkbox(checkboxesToEnable,adminmodule);}
        if(mastermodule.checked){const checkboxesToEnable = document.querySelectorAll("input.mastermodule");var mastermodule = document.querySelector('#mastermodule');checkbox(checkboxesToEnable,mastermodule);}
        if(eventmodule.checked){const checkboxesToEnable = document.querySelectorAll("input.eventmodule");var eventmodule = document.querySelector('#eventmodule');checkbox(checkboxesToEnable,eventmodule);}
        if(inventorymodule.checked){const checkboxesToEnable = document.querySelectorAll("input.inventorymodule");var inventorymodule = document.querySelector('#inventorymodule');checkbox(checkboxesToEnable,inventorymodule);}
        if(billingmodule.checked){const checkboxesToEnable = document.querySelectorAll("input.billingmodule");var billingmodule = document.querySelector('#billingmodule');checkbox(checkboxesToEnable,billingmodule);}
        if(smsmodule.checked){const checkboxesToEnable = document.querySelectorAll("input.smsmodule");var smsmodule = document.querySelector('#smsmodule');checkbox(checkboxesToEnable,smsmodule);}
        if(accountsmodule.checked){const checkboxesToEnable = document.querySelectorAll("input.accountsmodule");var accountsmodule = document.querySelector('#accountsmodule');checkbox(checkboxesToEnable,accountsmodule);}
        if(reportmodule.checked){const checkboxesToEnable = document.querySelectorAll("input.reportmodule");var reportmodule = document.querySelector('#reportmodule');checkbox(checkboxesToEnable,reportmodule);}
    }
});


function checkbox(checkboxesToEnable,module){
    if (module.checked) {
        checkboxesToEnable.forEach(function(checkbox) {
            checkbox.disabled = false;
        });
    } else {
        checkboxesToEnable.forEach(function(checkbox) {
            checkbox.disabled = true;
            checkbox.checked = false;
        });
    }
}