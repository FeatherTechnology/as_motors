$(document).ready(function () {

  // remove delete option for last child
  $('#delete_row:last').filter(':last').removeClass("deleterow");

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

  // add module 
  var markup1 = "<option value=''>Select KRA Category</option>";
  var markup2 = "<option value=''>Select Roles & Responsibility</option><option value='New'>New</option>";
  var markup3 = "<option value=''>Select Project</option>";
    $(document).on("click", '.add_product', function () {
      var company_id = $("#company_name").val();
      var designation = $('#designation').val();
      $.ajax({
        url: "ajaxRNRFetchingDetails.php",
        data: {'company_id':company_id, "designation":designation},
        cache: false,
        type: "post",
        dataType: "json",
        success: function (data) {
          for(i=0; i<=data["kra_creation_ref_id"].length-1; i++){
            markup1 += "<option value="+data["kra_creation_ref_id"][i] +">"+data["kra_category"][i] +"</option>";
          }
          for(i=0; i<=data["rr_ref_id"].length-1; i++){
            markup2 += "<option value="+data["rr_ref_id"][i] +">"+data["rr"][i] +"</option>";
          }
          for(i=0; i<=data["project_id"].length-1; i++){
            markup3 += "<option value="+data["project_id"][i] +">"+data["project_name"][i] +"</option>";
          }
          var appendTxt = "<tr><td><select id='kra_category' tabindex='11' name='kra_category[]' class='kra_category chosen-select form-control'>" + markup1 + "</select></td>" +
          "<td><select id='rr' tabindex='11' name='rr[]' class='rr chosen-select form-control'>" + markup2 + "</select></td>" +
          "<td><input type='text' readonly tabindex='11' class='chosen-select form-control kpi' id='kpi' name='kpi[]' /></td>" +
          "<td><select id='criteria' tabindex='11' name='criteria[]' class='criteria chosen-select form-control'><option value=''>Select Criteria</option><option value='Event'>Event</option><option value='Project'>Project</option></select></td>" +
          "<td style='display: flex; margin-top: 25px;'><select readonly tabindex='11' id='project' name='project[]' class='project chosen-select form-control'>" + markup3 + "</select> &nbsp;&nbsp;&nbsp; <button disabled type='button' tabindex='4' class='btn btn-primary' id='add_CategoryDetails' name='add_CategoryDetails' data-toggle='modal' data-target='.addProjectModal'><span class='icon-add'></span></button> </td>" +
          "<td><select id='frequency' tabindex='11' name='frequency[]' class='frequency chosen-select form-control'><option value=''>Select Frequency</option><option value='Fortnightly'>Fortnightly</option><option value='Monthly'>Monthly</option><option value='Quaterly'>Quaterly</option><option value='Half Yearly'>Half Yearly</option><option value='yearly'>yearly</option><option value='Event Driven'>Event Driven</option></select></td>" +
          "<td><select tabindex='9' type='text' class='form-control calendar' id='calendar' name='calendar[]' ><option value=''>Select Calendar</option><option value='Yes'>Yes</option><option value='No'>No</option></select></td>" +
          "<td><input readonly type='date' tabindex='8' name='from_date[]' id='from_date' class='form-control' >&nbsp;&nbsp; <span>To</span>&nbsp;&nbsp;<input readonly type='date' tabindex='9' name='to_date[]' id='to_date' class='form-control' ></td>" +
          "<td><button type='button' tabindex='11' id='add_product' name='add_product' value='Submit' class='btn btn-primary add_product'>Add</button></td>" +
          "<td><span class='deleterow icon-trash-2' tabindex='11'></span></td>"+
          "</tr>";
          $('#moduleTable').find('tbody').append(appendTxt);

          markup1 = "<option value=''>Select KRA Category</option>";
          markup2 = "<option value=''>Select Roles & Responsibility</option><option value='New'>New</option>";
          markup3 = "<option value=''>Select Project</option>";
        }
      });
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
          
              $('#staff_name').empty();
              $('#staff_name').prepend("<option value=''>" + 'Select Staff Name' + "</option>");
              var i = 0;
              for (i = 0; i <= response.staff_id.length - 1; i++) { 
                  $('#staff_name').append("<option value='" + response['staff_id'][i] + "'>" + response['staff_name'][i] + "</option>");
              }

          }
      });
    }
  });

});


// execute target
$("#executeGoalSettingDetails").click(function(){

  var company_name = $('#company_name :selected').val();
  var goal_year = $('#goal_year :selected').val();
  var no_of_months = $('#no_of_months').val();
  $.ajax({
      url:"targetFixingFile/ajaxGetGoalDetails.php",
      method:"post",
      data: {'company_name': company_name, 'goal_year': goal_year, 'no_of_months': no_of_months},
      success:function(html){
          $("#goadSettingDetailsAppend").empty();
          $("#goadSettingDetailsAppend").html(html);
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
		// getkradropdown(idupd);
    // getrrdropdown(idupd);
	}else{
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
      $('#department').prepend("<option value=''>" + 'Select Department Name' + "</option>");
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