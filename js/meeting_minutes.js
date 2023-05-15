// Document is ready
$(document).ready(function () { 

	// auto generate doc no
	$.ajax({
		url: "meetingMinutesFile/ajaxGetDocNo.php",
		data: {},
		cache: false,
		type: "post",
		dataType: "json",
		success: function (data) {
			$("#doc_no").val(data);
		}
	});

	// Get Filename Before Uploading
	updateList = function() {
		var input = document.getElementById('file');
		var output = document.getElementById('fileList');
		var children = "";
		for (var i = 0; i < input.files.length; ++i) {
			children += '<li>' + input.files.item(i).name + '</li>';
		}
		output.innerHTML = '<ul>'+children+'</ul>';
	}

	// Get Employee Details
	$.ajax({
		url: 'businesscomFile/getemployee.php',
		type: 'post',
		data: {},
		dataType: 'json',
		success: function(response){ 
			$("#department").val(response["department"]);
			$("#staff_name").val(response["staff_name"]);
		}
	});
		
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
    
	// Get Company based on Department
	$("#branch_id").change(function(){
		var branch_id = $("#branch_id").val();
		if(branch_id.length==''){
			$("#branch_id").val('');
		}else{
			getdepartment(branch_id);
		}
	});

	// Get Department based on designation
	$("#department").change(function(){ 
		var department_id = $("#department").val();
		if(department_id.length==''){ 
			$("#department").val('');
		}else{
			getdesignation(department_id);
		}
	});

	
	// print
	$('#downloadpdf').on('click', function(){ 

		var id = $('#approval_line_id').val();
		$.ajax({
		    url: 'meetingMinutesFile/ajaxPrintApprovalRequisition.php',
		    cache: false,
		    type: 'POST',
		    data: { 'id':id },
		    success: function(html){
		        $("#printApprovalRequisition").html(html);
		    }
		});
	});


});

	
function getdepartment(company_id){
	var department_upd = $('#department_upd').val();
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
				var selected = "";
					if(department_upd == response['department_id'][r]){
						selected = "selected";
					}
				$('#department').append("<option value='" + response['department_id'][r] + "'"+selected+">" + response['department_name'][r] + "</option>");
			}
		}
	});
}

function getdesignation(department_id){
	var designation_upd = $('#designation_upd').val();
	$.ajax({
		url: 'StaffFile/ajaxStaffDesignationDetails.php',
		type: 'post',
		data: { "department_id":department_id },
		dataType: 'json',
		success:function(response){
		
			$('#designation').empty();
			$('#designation').prepend("<option value=''>" + 'Select Designation' + "</option>");
			var i = 0;
			for (i = 0; i <= response.designation_id.length - 1; i++) { 
				var selected = "";
					if(designation_upd == response['designation_id'][i]){
						selected = "selected";
					}
				$('#designation').append("<option value='" + response['designation_id'][i] + "'"+selected+" >" + response['designation_name'][i] + "</option>");
			}
		}
	});
}
