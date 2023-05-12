// choices css for multi select:
const company = new Choices('#company_id', {
	removeItemButton: true,
});
const branch = new Choices('#branch_id', {
	removeItemButton: true,
});

// Document is ready
$(document).ready(function () { 

      // remove delete option for last child
  $('#delete_row:last').filter(':last').removeClass("deleterow");

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

		var branch_ids = branch.getValue(); 
        var branch_id = '';
        for(var i=0;i<branch_ids.length;i++){
			if (i > 0) {
				branch_id += ',';
            }
            branch_id += branch_ids[i].value; 
        }
	
		if(branch_id.length == ''){ 
			$('#search_dropdown').prop('disabled',true);
		}else if(branch_id != ''){ 
			$('#search_dropdown').prop('disabled',false);
		}
	});

	// get company based branch name
	$('#company_id').on('change', function(){

		var company_ids = company.getValue();
        var company_id = '';
        for(var i=0;i<company_ids.length;i++){
            if (i > 0) {
                company_id += ',';
            }
            company_id += company_ids[i].value; 
        }

		$.ajax({
			url: 'businesscomFile/ajaxFetchMultipleBranchDetails.php',
			type:'post',
			data: {'company_id': company_id},
			dataType: 'json',
			success: function(response){

				branch.clearStore();
				for (r = 0; r <= response.branch_id.length - 1; r++) { 

					var branch_id = response['branch_id'][r];  
					var branch_name = response['branch_name'][r]; 
					var items = [
						{
							value: branch_id,
							label: branch_name,
						}
					];
					branch.setChoices(items);
					branch.init();
				}
				$("#branch_id").val('');
				$("#branch_name").val('');
			}
		});
	});

	// search
	$('#submit_staff').click(function(){

        var search_dropdown = $('#search_dropdown').val();
        var staff_details = $('#staff_details').val();

		var company_ids = branch.getValue();
        var company_id = '';
        for(var i=0;i<company_ids.length;i++){
			if (i > 0) {
				company_id += ',';
            }
            company_id += company_ids[i].value; 
        }

        if(submit_staff.length==''){
            $("#submit_staff").val('');
        }else if(submit_staff.length != ''){
            $.ajax({
                url: 'businesscomFile/search.php',
                type: 'post',
                data: {"company_id":company_id,"search_dropdown":search_dropdown,"staff_details":staff_details},
                success:function(html){
                $("#staff_append").append(html);
                }
            });
        }
    });
    
	// Get Company based on Department
	$("#branch_id").change(function(){
	
		var branch_ids = branch.getValue();
        var branch_id = '';
        for(var i=0;i<branch_ids.length;i++){
			if (i > 0) {
				branch_id += ',';
            }
            branch_id += branch_ids[i].value; 
        }
		
		// var branch_id = $("#branch_id").val();
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
	// 			url: 'businesscomFile/ajaxGetApprovalStaffDetails.php',
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

		// var company_id = $("#branch_id").val();
		var staff_id = [];
		var company_id = [];
        $('input[name="staff_id[]"]:checked').each(function(i){
            staff_id[i] = $(this).val(); 
			company_id[i] = $(this).parents('tr').find('td #branch_id').val();
        }); 

        if(staff_id.length > 0){
            $.ajax({
                url: 'businesscomFile/ajaxGetApprovalStaffDetails.php',
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

		// var company_id = $("#branch_id").val();

		var staff_id = [];
		var company_id = [];
        $('input[name="staff_id[]"]:checked').each(function(i){
            staff_id[i] = $(this).val(); 
			company_id[i] = $(this).parents('tr').find('td #branch_id').val();
        }); 

        if(staff_id.length > 0){
            $.ajax({
                url: 'businesscomFile/ajaxGetAgreeParallelStaffDetails.php',
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

		// var company_id = $("#branch_id").val();

		var staff_id = [];
		var company_id = [];
        $('input[name="staff_id[]"]:checked').each(function(i){
            staff_id[i] = $(this).val(); 
			company_id[i] = $(this).parents('tr').find('td #branch_id').val();
        }); 

        if(staff_id.length > 0){
            $.ajax({
                url: 'businesscomFile/ajaxGetAfterNotifiedStaffDetails.php',
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

		// var company_id = $("#branch_id").val();

		var department_id = [];
		var company_id = [];
        $('input[name="checkedid[]"]:checked').each(function(i){
            department_id[i] = $(this).val(); 
			company_id[i] = $(this).parents('tr').find('td #branch_id').val();
        }); 

        if(department_id.length > 0){
            $.ajax({
                url: 'businesscomFile/ajaxGetReceivingDeptDetails.php',
                type: 'post',
                data: { "company_id":company_id, "department_id":department_id },
                // dataType: 'json',
                success:function(html){ 

                    $("#receivingDeptTableAppend").empty();
                    $("#receivingDeptTableAppend").html(html);
                    // $("#staff_append").append(html);
                }
            });
        }else if(department_id.length == ''){ 
            $("#receivingDeptTableAppend").empty();
        }
	});
	

});

	
function getdepartment(company_id){
	
	$.ajax({
		url: 'businesscomFile/ajaxMultipleDepartmentDetails.php',
		type: 'post',
		data: { "company_id":company_id },
		success:function(html){ 

			$("#department_append").empty();
			$("#department_append").html(html);
		}
	});
}

