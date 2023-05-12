// choices css for multi select:
const company = new Choices('#company_id', {
	removeItemButton: true,
});
const branch = new Choices('#branch_id', {
	removeItemButton: true,
});

$(document).ready(function () {

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

});

// get details on edit
$(function(){
    // manager login
    getdepartmentLoad();
});

// get department details
function getdepartmentLoad(){ 
    $.ajax({
        url: 'tagFile/ajaxStaffDepartmentDetailsLoad.php',
        type: 'post',
        data: {},
        dataType: 'json',
        success:function(response){  

            $('#department_id').empty();
            $('#department_id').prepend("<option value=''>" + 'Select Department Name' + "</option>");
            var r = 0;
            for (r = 0; r <= response.department_id.length - 1; r++) { 
                $('#department_id').append("<option value='" + response['department_id'][r] + "'>" + response['department_name'][r] + "</option>");
            }
        }
    });
}

// Get branch based on Department
$("#branch_id").change(function(){

    var company_ids = branch.getValue();
    var company_id = '';
    for(var i=0;i<company_ids.length;i++){
        if (i > 0) {
            company_id += ',';
        }
        company_id += company_ids[i].value; 
    }

    if(company_id.length==''){
        $("#branch_id").val('');
    }else{
    
        $.ajax({
            url: 'tagFile/ajaxSelectMultipleDepartmentDetails.php',
            type: 'post',
            data: { "company_id":company_id },
            dataType: 'json',
            success:function(response){ 

                $('#department_id').empty();
                $('#department_id').prepend("<option value=''>" + 'Select Department Name' + "</option>");
                var r = 0;
                for (r = 0; r <= response.department_id.length - 1; r++) {  
                    $('#department_id').append("<option value='" + response['department_id'][r] + "'>" + response['department_name'][r]+' - '+ response['branch_name'][r] + "</option>");
                }
            }
        });
    }
});

function editCompanyBasedBranch(branch_id){  

    var branchIdEdit = $('#branchIdEdit').val().split(','); 

    $.ajax({
        url: 'tagFile/ajaxEditMultipleCompanyBasedBranch.php',
        type:'post',
        data: { 'branch_id': branch_id },
        dataType: 'json',
        success: function(response){

            branch.clearStore();
            for (var r = 0; r <= response.branch_id.length - 1; r++) {     
                var branch_id = response['branch_id'][r];  
                var branch_name = response['branch_name'][r];  

                var selected = '';
                if(branchIdEdit != ''){
                    for(var i=0;i<branchIdEdit.length;i++){
                        if(branchIdEdit[i] == branch_id){  
                            selected = 'selected';
                        }
                    }
                }
            
                var items = [
                    {
                    value: branch_id,
                    label: branch_name,
                    selected: selected,
                    }
                ];
                
                branch.setChoices(items);
                branch.init();
            }
        }
    });
}