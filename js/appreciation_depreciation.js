$(document).ready(function () {

  // Get modules based on product
  $("#department").change(function(){ 
    var department_id = $("#department").val();
    if(department_id.length==''){ 
      $("#department").val('');
    }else{
      var designation_upd = $('#designation_upd').val();
      getdesignation(department_id, designation_upd);
    }
  });
  
  // Get Company based on Department
  $("#company_name").change(function(){
    var company_id = $("#company_name").val();
    if(company_id.length==''){
      $("#company_name").val('');
    }else{
      var department_upd = $('#department_upd').val();
      getdepartment(company_id, department_upd);
    }
  });

  // Delete unwanted Rows
  $(document).on("click", '.deleterow', function () {
    $(this).parent().parent().remove();
  });

  // Get Department based reporting person
  $("#designation").change(function(){  
    var company_id = $("#company_name").val();
    var department_id = $("#department").val();
    var designation_id = $("#designation").val();
    getStaffListName(company_id, department_id, designation_id);
  });

  $("#overall_rating").change(function(){

    var overallRating = $('#overall_rating').val();
    if(overallRating == '1' || overallRating == '2'){
      $("#memoBtn").prop('disabled',false);
      $("#memoBtn").prop('disabled',false);
    }else{
      $("#memoBtn").prop('disabled',true);
      $("#memoBtn").prop('disabled',true);
    }
  });

  // execute daily performance
  $("#executeTargetFixingDetails").click(function(){
  
    var month = $('#month').val();
    var designation = $('#designation').val();
    var staff_id = $('#staff_id :selected').val();
  
    $.ajax({
      url:"targetFixingFile/ajaxDailyPerformanceDetails.php",
      method:"post",
      data: { 'month': month, 'designation': designation, 'staff_id': staff_id },
      success:function(html){
        $("#dailyPerformanceDetailsAppend").empty();
        $("#dailyPerformanceDetailsAppend").html(html);
  
        getReportingPerson(staff_id);
  
      }
    });
  });

  $(".edit_assertion").on('click', function() { 
    var checkbox = $(this).parents('tr').find('td #edit_assertion').is(":checked");
    if (checkbox) { 
        $(this).parents('tr').find('td #new_assertion').attr("readonly",false);
        $(this).parents('tr').find('td #new_target').attr("readonly",false);
        $(this).parents('tr').find('td #applicability').attr("readonly",false);
    } else { 
        $(this).parents('tr').find('td #new_assertion').val('').attr("readonly",true);
        $(this).parents('tr').find('td #new_target').val('').attr("readonly",true);
        $(this).parents('tr').find('td #applicability').val('').attr("readonly",true);
    }
  });
  
  $(".delete_assertion").on('click', function() { 
    
    var checkbox = $(this).parents('tr').find('td #delete_assertion').is(":checked");
    if (checkbox) { 
  
      var currentDate = new Date($.now());
      var formattedDate = currentDate.toLocaleDateString();  
  
      $(this).parents('tr').find('td #deleted_date').val(formattedDate);
      $(this).parents('tr').find('td #deleted_remarks').attr("readonly",false);
    } else { 
      $(this).parents('tr').find('td #deleted_date').val('').attr("readonly",true);
      $(this).parents('tr').find('td #deleted_remarks').val('').attr("readonly",true);
    }
  });

  $('.achievement').keyup(function(){
    console.log('aaaa')
    // Calculate the sum of all actual values
    var sum = 0;
    $('.achievement').each(function() {
        var value = parseInt($(this).val()) || 0;
        sum += value;
    });

    $('#overall_performance').val('Total Satisfied - '+ sum);

});


});



  //get details on edit
  $(function(){

    // super admin login
    var id = $("#id").val();
    var idupd = $("#company_name").val();
    // var department_upd = $('#department_upd').val();
    // var staff_id = $('#empEdit').val();
    var userDeptId = $('#userDeptId').val();
    var userDesignationId = $('#userDesignationId').val();
    var userStaffId = $('#staffid').val();
    var userRole = $('#userRole').val();
    if(id <= '0' && idupd > 0 ){

      getdepartment(idupd, userDeptId);
      getdesignation(userDeptId, userDesignationId);
      getStaffListName(idupd, userDeptId, userDesignationId);
    }

    if(id > 0){
      setTimeout(() => {
        var staff_id = $('#staff_id :selected').val();
        getReportingPerson(staff_id);
        
      }, 500);

    }

    // if(idupd <= '0' && userRole != '1'){
    //     getDeptList(userDeptId);
    //     getStaffList(userStaffId, userDeptId);
    //     getReportingPerson(userDeptId, userStaffId)    
    // }
    if(userRole != '1'){
        $('#department').attr('disabled', true);
    }
    if(userRole == '4'){
        $('#designation').attr('disabled', true);
        $('#staff_id').attr('disabled', true);
    }

  });

// get department details
function getdepartment(company_id, department_upd){ 
  
  $.ajax({
    url: 'R&RFile/ajaxGetCompanyBasedDepartment.php',
    type: 'post',
    data: { "company_id":company_id },
    dataType: 'json',
    success:function(response){ 

      $('#department').empty();
      $('#department').prepend("<option value=''>" + 'Select Department' + "</option>");
      var r = 0;
      for (r = 0; r <= response.department_id.length - 1; r++) { 
        var selected = "";
        if(department_upd == response['department_id'][r]){
          $('#mySelectedDeptName').val(response['department_id'][r]);
          selected = "selected";
        }
        $('#department').append("<option value='" + response['department_id'][r] + "' "+selected+">" + response['department_name'][r] + "</option>");
      }
    }
  });
}

//get designation details
function getdesignation(department_id, designation_upd){ 
  var company_id = $('#company_name').val();
  $('#mySelectedDeptName').val(department_id);
  $.ajax({
    url: 'R&RFile/ajaxR&RDesignationDetails.php',
    type: 'post',
    data: { "company_id":company_id, "department_id":department_id },
    dataType: 'json',
    success:function(response){
      
      $('#designation').empty();
      $('#designation').prepend("<option value=''>" + 'Select Designation' + "</option>");
      var i = 0;
      for (i = 0; i <= response.designation_id.length - 1; i++) { 
        var selected = "";
        if(designation_upd == response['designation_id'][i]){
          $('#mySelectedDesgnName').val(response['designation_id'][i]);
          selected = "selected";
      }
        $('#designation').append("<option value='" + response['designation_id'][i] + "' "+selected+" >" + response['designation_name'][i] + "</option>");
      }
    }
  });
}

function getReportingPerson(staff_id){
  // Nested AJAX call to getreportingPersonDetails.php
  $.ajax({
    url: "targetFixingFile/getreportingPersonDetails.php",
    method: "post",
    data: { 'staff_id': staff_id },
    dataType: 'json',
    success: function(result){
      var user_staff_id = $('#staffid').val();
      if(result['reporting_id'] == user_staff_id || user_staff_id == 'Overall'){
        $(".reporting_person_view").show()
      }
      // else{
      //   $(".reporting_person_view").hide()
      // }
    }
  });
}

function getStaffListName(company_id, department_id, designation_id){
  if(designation_id.length==''){ 
      $("#designation").val('');
  }else{
    $('#mySelectedDesgnName').val(designation_id);
    $.ajax({
        url: 'insuranceFile/ajaxGetDesignationBasedStaff.php',
        type: 'post',
        data: { "company_id":company_id, "department_id":department_id, "designation_id":designation_id },
        dataType: 'json',
        success:function(response){
        
            $('#staff_id').empty();
            $('#staff_id').prepend("<option value=''>" + 'Select Staff' + "</option>");
            var i = 0;
            for (i = 0; i <= response.staff_id.length - 1; i++) { 
                $('#mySelectedStaffName').val(response['staff_id'][i]);
                $('#staff_id').append("<option value='" + response['staff_id'][i] + "' selected>" + response['staff_name'][i] + "</option>");
            }
        }
    });
  }

}