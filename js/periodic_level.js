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


    // Get asset details
    $("#branch_id").change(function(){
        var company_id = $("#branch_id").val();
        if(company_id.length==''){
            $("#branch_id").val('');
        }else{
            $.ajax({
                url: 'maintenanceChecklistFile/ajaxGetStaffDepartment.php',
                type: 'post',
                data: { "company_id":company_id },
                dataType: 'json',
                success:function(response){ 
                    
                    $('#asset_details').empty();
                    $('#asset_details').prepend("<option value=''>" + 'Select Asset Details' + "</option>");
                    var r = 0;
                    for (r = 0; r <= response.asset_id.length - 1; r++) { 
                        $('#asset_details').append("<option value='" + response['asset_id'][r] + "'>" + response['asset_name'][r]+' - '+response['asset_classification'][r] + "</option>");
                    }
                }
            });
        }
    });


});
