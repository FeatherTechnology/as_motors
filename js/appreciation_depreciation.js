$(document).ready(function () {

  // Get modules based on product
  $("#department").change(function(){ 
    var department_id = $("#department").val();
    if(department_id.length==''){ 
      $("#department").val('');
    }else{
      getdesignation(department_id);
    }
  });
  
  // Get Company based on Department
  $("#company_name").change(function(){
    var company_id = $("#company_name").val();
    if(company_id.length==''){
      $("#company_name").val('');
    }else{
      getdepartment(company_id);
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

    if(designation_id.length==''){ 
        $("#designation").val('');
    }else{
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
                  $('#staff_id').append("<option value='" + response['staff_id'][i] + "'>" + response['staff_name'][i] + "</option>");
              }
          }
      });
    }
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

});


  // execute daily performance
  $("#executeTargetFixingDetails").click(function(){

    var company_name = $('#company_name :selected').val();
    var goal_year = $('#goal_year :selected').val();
    var month = $('#month :selected').val();

    $.ajax({
      url:"targetFixingFile/ajaxDailyPerformanceDetails.php",
      method:"post",
      data: {'company_name': company_name, 'goal_year': goal_year, 'month': month},
      success:function(html){
          $("#dailyPerformanceDetailsAppend").empty();
          $("#dailyPerformanceDetailsAppend").html(html);
      }
    });
  });

  //get details on edit
  $(function(){

    // super admin login
    var idupd = $("#company_name :selected").val();
    var department_upd = $('#department_upd').val();
    if(idupd > 0 ){

      getdepartment(idupd);
      getdesignation(department_upd);
    }
  });

// get department details
function getdepartment(company_id){ 
  var department_upd = $('#department_upd').val();
  $.ajax({
    url: 'KRA&KPIFile/ajaxKra&KpiFetchDepartmentDetails.php',
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
          selected = "selected";
        }
        $('#department').append("<option value='" + response['department_id'][r] + "' "+selected+">" + response['department_name'][r] + "</option>");
      }
    }
  });
}

//get designation details
function getdesignation(department_id){ 

  var company_id = $('#company_name').val();
  var designation_upd = $('#designation_upd').val();

  $.ajax({
    url: 'KRA&KPIFile/ajaxKra&KpiFetchDesignationDetails.php',
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
          selected = "selected";
      }
        $('#designation').append("<option value='" + response['designation_id'][i] + "' "+selected+" >" + response['designation_name'][i] + "</option>");
      }
    }
  });
}


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