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
	});
    
  $('#city').change(function() {
    $('#state').val($('#city option:selected').data('id'));
    console.log($('#city option:selected').data('id'));
  })

  // Get branch based on Department
  $("#branch_id").change(function(){
    var company_id = $("#branch_id").val();
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
  });

$('#submitstaff_creation').click(function(e){
  e.preventDefault();
    var idupd = $('#idupd').val();
    var designationEdit = $('#designationEdit').val();

    $.ajax({
      type: 'post',
      data: { "idupd":idupd, "designationEdit":designationEdit },
      url: 'StaffFile/getdesignationValidation.php',
      dataType: 'json',
      success:function(response){ 
        if(response == '1'){
          e.preventDefault();
          alert('The same designation has already been inserted. Please note that only one staff member can be assigned to each designation.');
        }else{

          var FormData = $("form").serialize();
          $.ajax({
            type: 'post',
            data:  FormData,
            url: 'StaffFile/staffSubmit.php',
            dataType: 'json',
            success:function(response){ 

              if(response =='0'){ //insert
                window.location.href = 'edit_staff_creation&msc=1';
              }else if(response =='1'){ //Update
                window.location.href='edit_staff_creation&msc=2'; 
              }

            }
          });

        }

      }
    });

});

}); //Document END

// Get Department based on designation
$("#department").change(function(){ 

  var company_id = $("#branch_id").val();
  var department_id = $("#department").val();
  if(department_id.length==''){ 
    $("#department").val('');
  }else{
    getDesignationList();//designation List.
    
  }
});

// Get Department based reporting person
$("#designation").change(function(){ 

  var company_id = $("#branch_id").val();
  var desgn_id = $("#designation").val();

  if(desgn_id.length==''){ 
    $("#designation").val('');
  }else{
    $.ajax({
      url: 'StaffFile/ajaxGetDeptBasedForStaff.php',
      type: 'post',
      data: { "company_id":company_id, "desgn_id":desgn_id },
      dataType: 'json',
      success:function(response){
        
        $('#reporting').empty();
        $('#reporting').prepend("<option value=''>" + 'Select Reporting Person' + "</option>");
        var i = 0;
        for (i = 0; i <= response.staff_id.length - 1; i++) { 
          $('#reporting').append("<option value='" + response['staff_id'][i] + "'>" + response['staff_name'][i] + "</option>");
        }
      }
    });
  }
});

  // Download button
  $('#downloadstaff').click(function () { 
    $.ajax({
        url: 'ajaxStaffBulkUpload.php',
        catch: false,
        success: function(){
        
        window.location.href='uploads/downloadfiles/staffbulksample.xlsx';
        }
    });
});

  $("#insertsuccess").hide();
  $("#notinsertsuccess").hide();
  //bulk upload
  $("#submitstaffbulkbtn").click(function(){
  
      var file_data = $('#file').prop('files')[0];   
      var staff = new FormData();                  
      staff.append('file', file_data);

      if(file.files.length == 0 ){
          alert("Please Select File");
          return false;
      }
      $.ajax({
          url: 'StaffFile/ajaxStaffUpload.php',
          type: 'POST',
          data: staff,
          // dataType: 'json',
          contentType: false,
          cache: false,
          processData:false,
          beforeSend: function(){
              $('#file').attr("disabled",  true);
              $('#submitstaffbulkbtn').attr("disabled", true);
          },
          success: function(data){
              // console.log(data)
              if(data == 0){
                  $("#notinsertsuccess").hide();
                  $("#insertsuccess").show();
                  $("#file").val('');
              }else if(data == 1){
                  $("#insertsuccess").hide();
                  $("#notinsertsuccess").show();
                  $("#file").val('');
              }
          },
          complete: function(){
              $('#file').attr("disabled",  false);
              $('#submitstaffbulkbtn').attr("disabled", false);         
          }
      });
  });

  $(function(){
    var idupd = $('#idupd').val();
    // console.log(idupd)
    if(idupd > '0' ){
      setTimeout(function(){
        getDesignationList();
      }, 1000);

    }
  });

  function getDesignationList(){
    var company_id = $("#branch_id").val();
    var department_id = $("#department").val();
    var designationEdit = $("#designationEdit").val();
    
    $.ajax({
      url: 'StaffFile/getStaffDesignationValidation.php',
      type: 'post',
      data: { "company_id":company_id, "department_id":department_id, "designationEdit":designationEdit },
      dataType: 'json',
      success:function(response){
        
        $('#designation').empty();
        $('#designation').prepend("<option value=''>" + 'Select Designation' + "</option>");
        var i = 0;
        for (i = 0; i <= response.designation_id.length - 1; i++) { 
          var selected = '';
          if(designationEdit == response['designation_id'][i]){
            selected='selected';
          }
          $('#designation').append("<option value='" + response['designation_id'][i] + "' "+selected+">" + response['designation_name'][i] + "</option>");
        }

      }
    });

  }