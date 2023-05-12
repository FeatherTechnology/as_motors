// Document is ready
$(document).ready(function () { 

	// remove delete option for last child
	// $('#delete_row:last').filter(':last').removeClass("deleterow");

	  // Delete unwanted Rows
	  $(document).on("click", '.deleterow', function () {
		$(this).parent().parent().remove();
	  });

	// Get read only text box
	$("#search_dropdown").change(function(){ 
		var search_dropdown = $("#search_dropdown").val(); 
	
		if(search_dropdown == ''){ 
			$('#staff_details').prop('readonly', true);
		}else if(search_dropdown == 'Id' || search_dropdown == 'Name' || search_dropdown == 'Position' || search_dropdown == 'Dept Name'){
			$('#staff_details').prop('readonly', false);
		}
	});

	// Get read only text box
	$("#branch_id").change(function(){ 
		var branch_id = $("#branch_id :selected").val(); 
	
		if(branch_id.length == ''){ 
			$('#search_dropdown').prop('disabled',true);
		}else if(branch_id != ''){
			$('#search_dropdown').prop('disabled',false);
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

	// search
	$('#submit_staff').click(function(){

        var search_dropdown = $('#search_dropdown').val();
        var staff_details = $('#staff_details').val();
        var company_id = $('#branch_id').val();

        if(submit_staff.length==''){
            $("#submit_staff").val('');
        }else if(submit_staff.length != ''){
            $.ajax({
                url: 'businesscomFile/search.php',
                type: 'post',
                data: {"company_id":company_id,"search_dropdown":search_dropdown,"staff_details":staff_details},
                success:function(html){
					$("#staff_append").append(html);
                	// $("#staff_append_search").append(html);
                }
            });
        }
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
	

	// approve btn (only append tbody )
	// $('#approvalBtn').click(function () { 

	// 	var company_id = $("#branch_id").val();
	// 	var staff_id = [];
	// 	$('input[name="staff_id[]"]:checked').each(function(i){
	// 		staff_id[i] = $(this).val(); 
	// 	}); 

	// 	if(staff_id.length > 0){
	// 		$.ajax({
	// 			url: 'approvalrequisitionFile/ajaxGetApprovalStaffDetails.php',
	// 			type: 'post',
	// 			data: { "company_id":company_id, "staff_id":staff_id },
	// 			// dataType: 'json',
	// 			success:function(html){ 

	// 				$("#approvalTableAppend").find('tbody').empty();
	// 				$("#approvalTableAppend").find('tbody').html(html);
	// 				// $("#staff_append").append(html);
	// 			}
	// 		});
	// 	}else if(staff_id.length == ''){ 
	// 		$("#approvalTableAppend").find('tbody').empty();
	// 	}
	// });


	// approve btn
	$('#approvalBtn').click(function () { 

		var company_id = $("#branch_id").val();
		var staff_id = [];
        $('input[name="staff_id[]"]:checked').each(function(i){
            staff_id[i] = $(this).val(); 
        }); 

        if(staff_id.length > 0){
            $.ajax({
                url: 'approvalrequisitionFile/ajaxGetApprovalStaffDetails.php',
                type: 'post',
                data: { "company_id":company_id, "staff_id":staff_id },
                // dataType: 'json',
                success:function(html){ 

                    $("#approvalTableAppend").empty();
                    $("#approvalTableAppend").html(html);
                    // $("#staff_append").append(html);
                }
            });
        }else if(staff_id.length == ''){ 
            $("#approvalTableAppend").empty();
        }
	});

	// agree parallel btn
	$('#aggreeParallelBtn').click(function () { 

		var company_id = $("#branch_id").val();
		var staff_id = [];
        $('input[name="staff_id[]"]:checked').each(function(i){
            staff_id[i] = $(this).val(); 
        }); 

        if(staff_id.length > 0){
            $.ajax({
                url: 'approvalrequisitionFile/ajaxGetAgreeParallelStaffDetails.php',
                type: 'post',
                data: { "company_id":company_id, "staff_id":staff_id },
                success:function(html){ 

                    $("#agreeParallelTableAppend").empty();
                    $("#agreeParallelTableAppend").html(html);
                }
            });
        }else if(staff_id.length == ''){ 
            $("#agreeParallelTableAppend").empty();
        }
	});

	// after notified btn
	$('#afterNotifiedBtn').click(function () { 

		var company_id = $("#branch_id").val();
		var staff_id = [];
        $('input[name="staff_id[]"]:checked').each(function(i){
            staff_id[i] = $(this).val(); 
        }); 

        if(staff_id.length > 0){
            $.ajax({
                url: 'approvalrequisitionFile/ajaxGetAfterNotifiedStaffDetails.php',
                type: 'post',
                data: { "company_id":company_id, "staff_id":staff_id },
                success:function(html){ 

                    $("#afterNotifiedTableAppend").empty();
                    $("#afterNotifiedTableAppend").html(html);
                }
            });
        }else if(staff_id.length == ''){ 
            $("#afterNotifiedTableAppend").empty();
        }
	});


	// receiving dept btn
	$('#receivingDeptBtn').click(function () { 

		var company_id = $("#branch_id").val();
		var department_id = [];
		$('input[name="checkedid[]"]:checked').each(function(i){
			department_id[i] = $(this).val(); 
		}); 

		if(department_id.length > 0){
			$.ajax({
				url: 'approvalrequisitionFile/ajaxGetReceivingDeptDetails.php',
				type: 'post',
				data: { "company_id":company_id, "department_id":department_id },
				success:function(html){ 

					$("#receivingDeptTableAppend").empty();
					$("#receivingDeptTableAppend").html(html);
				}
			});
		}else if(department_id.length == ''){ 
			$("#receivingDeptTableAppend").empty();
		}
	});


});

function getdepartment(company_id){
	
	$.ajax({
		url: 'approvalrequisitionFile/ajaxStaffDepartmentDetails.php',
		type: 'post',
		data: { "company_id":company_id },
		success:function(html){ 

			$("#department_append").empty();
			$("#department_append").html(html);
		}
	});
}
