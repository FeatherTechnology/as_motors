$(document).ready(function () {

  // remove delete option for last child
  $('#delete_row:last').filter(':last').removeClass("deleterow");

    // get company based branch name
    $('#company_name').on('change',function(){
      var company_id = $('#company_name :selected').val();
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
  $("#branch_id").change(function(){
    var company_id = $("#branch_id").val();
    if(company_id.length==''){
      $("#branch_id").val('');
    }else{
      getdepartment(company_id);
      getkradropdown(company_id);
      getrrdropdown(company_id);
      }
  });

  // add module 
  var markup1 = "<option value=''>Select KRA Category</option>";
  var markup2 = "<option value=''>Select Roles & Responsibility</option><option value='New'>New</option>";
  // $(".add_product").click(function() {
  $(document).on("click", '.add_product', function () { 

    var company_id = $("#branch_id").val();
    $.ajax({
      url: "ajaxRNRFetchingDetails.php",
      data: {'company_id':company_id},
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

        var appendTxt = "<tr><td><select id='kra_category' tabindex='11' name='kra_category[]' class='kra_category chosen-select form-control'>" + markup1 + "</select></td>" +               
        "<td><select id='rr' tabindex='11' name='rr[]' class='rr chosen-select form-control'>" + markup2 + "</select></td>" +
        "<td><input type='text' readonly tabindex='11' class='chosen-select form-control kpi' id='kpi' name='kpi[]' /></td>" +
        "<td><select id='applicability' tabindex='11' name='applicability[]' class='applicability chosen-select form-control'><option value=''>Select Applicability</option><option value='Common'>Common</option><option value='Specific'>Specific</option></select></td>" +
        "<td><select id='frequency' tabindex='11' name='frequency[]' class='frequency chosen-select form-control'><option value=''>Select Frequency</option><option value='Fortnightly'>Fortnightly</option><option value='Monthly'>Monthly</option><option value='Quaterly'>Quaterly</option><option value='Half Yearly'>Half Yearly</option><option value='yearly'>yearly</option><option value='Event Driven'>Event Driven</option></select></td>" +
        "<td><input type='text' tabindex='11' class='chosen-select form-control code_ref' id='code_ref' name='code_ref[]' /></td>" +
        "<td><button type='button' tabindex='11' id='add_product' name='add_product' value='Submit' class='btn btn-primary add_product'>Add</button></td>" +
        "<td><span class='deleterow icon-trash-2' tabindex='11'></span></td>"+
        "</tr>";

        $('#moduleTable').find('tbody').append(appendTxt);
        markup1="<option value=''>Select Roles & Responsibility</option>";
      }
    });
  });

  // Delete unwanted Rows
  $(document).on("click", '.deleterow', function () {
    $(this).parent().parent().remove();
  });

  // Get read only text box
  $(document).on("change",".rr",function(){ 

    var rr = $(this).children(":selected").text();  
    // var rr = $("#rr").val(); 

    if(rr == 'New'){ 
      $(this).closest("tr").find('td:eq(2) #kpi').prop('readonly',false);
    } else {
      $(this).closest("tr").find('td:eq(2) #kpi').prop('readonly',true);
      $(this).closest("tr").find('td:eq(2) #kpi').val('');
    }
  });


});


//get details on edit
$(function(){

  // super admin login
	var idupd = $("#branch_id :selected").val();
	var upd_name = $("#branch_id :selected").text();
	var department_upd = $('#department_upd').val();
	if(idupd > 0 ){
		
		getdepartment(idupd);
		getdesignation(department_upd);
		getkradropdown(idupd);
    getrrdropdown(idupd);
	}else{
	}
});

// get kra dropdown based on company name
// function getkradropdownLoad(){  
//   var kra_id_upd = $('#kra_id_upd').val(); 
  
//   $.ajax({
//     url: 'KRA&KPIFile/ajaxKraDetailsLoad.php',
//     type: 'post',
//     data: {},
//     dataType: 'json',
//     success:function(response){
      
//       $('#kra_category').empty();
//       $('#kra_category').prepend("<option value=''>" + 'Select KRA Category' + "</option>");
//       var i = 0;
//       for (i = 0; i <= response.kra_creation_ref_id.length - 1; i++) { 
//         var selected = "";
//         if(kra_id_upd == response['kra_creation_ref_id'][i]){
//           selected = "selected";
//         }
//         $('#kra_category').append("<option value='" + response['kra_creation_ref_id'][i] + "' "+selected+" >" + response['kra_category'][i] + "</option>");
//       }

//     }
//   });
// }

// get department details
function getdepartment(company_id){ 
  var department_upd = $('#department_upd').val();
  $.ajax({
    url: 'KRA&KPIFile/ajaxKra&KpiDepartmentDetails.php',
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
  var designation_upd = $('#designation_upd').val();
  $.ajax({
    url: 'KRA&KPIFile/ajaxKra&KpiDesignationDetails.php',
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
        $('#designation').append("<option value='" + response['designation_id'][i] + "' "+selected+" >" + response['designation_name'][i] + "</option>");
      }
    }
  });
}

//get kra dropdown based on company name
function getkradropdown(company_id_upd){  
  var kra_id_upd = $('#kra_id_upd').val(); 
  
  $.ajax({
    url: 'KRA&KPIFile/ajaxKraDetails.php',
    type: 'post',
    data: { "company_id_upd":company_id_upd },
    dataType: 'json',
    success:function(response){
      
      $('#kra_category').empty();
      $('#kra_category').prepend("<option value=''>" + 'Select KRA Category' + "</option>");
      var i = 0;
      for (i = 0; i <= response.kra_creation_ref_id.length - 1; i++) { 
        var selected = "";
        if(kra_id_upd == response['kra_creation_ref_id'][i]){
          selected = "selected";
        }
        $('#kra_category').append("<option value='" + response['kra_creation_ref_id'][i] + "' "+selected+" >" + response['kra_category'][i] + "</option>");
      }

    }
  });
}

//get rr dropdown based on company name
function getrrdropdown(company_id_upd){
  var rr_id_upd = $('#rr_id_upd').val();
  
  $.ajax({
    url: 'KRA&KPIFile/ajaxRRDetails.php',
    type: 'post',
    data: { "company_id_upd":company_id_upd },
    dataType: 'json',
    success:function(response){
      
      $('#rr').empty();
      $('#rr').prepend("<option value=''>" + 'Select Roles & Responsibility' + "</option>");
      $('#rr').append("<option value='New'>" + 'New' + "</option>");
      var i = 0;
      for (i = 0; i <= response.rr_ref_id.length - 1; i++) { 
        var selected = "";
        if(rr_id_upd == response['rr_ref_id'][i]){
          selected = "selected";
      }
        $('#rr').append("<option value='" + response['rr_ref_id'][i] + "' "+selected+" >" + response['rr'][i] + "</option>");
      }

    }
  });
}


function getkradropdownEdit(company_id_upd){  

  var kra_id_upd = $('#kra_id_Edit').val(); 
  $.ajax({
      url: 'KRA&KPIFile/ajaxKraDetails.php',
      type: 'post',
      data: { "company_id_upd":company_id_upd },
      dataType: 'json',
      success:function(response){
      
      $('#kra_category').empty();
      $('#kra_category').prepend("<option value=''>" + 'Select KRA Category' + "</option>");
      var i = 0;
      for (i = 0; i <= response.kra_creation_ref_id.length - 1; i++) { 
          var selected = "";
          if(kra_id_upd == response['kra_creation_ref_id'][i]){
          selected = "selected";
          }
          $('#kra_category').append("<option value='" + response['kra_creation_ref_id'][i] + "' "+selected+" >" + response['kra_category'][i] + "</option>");
      }

      }
  });
}

function getrrdropdownEdit(company_id_upd){  
  var rr_id_upd = $('#rr_id_Edit').val();

  $.ajax({
      url: 'KRA&KPIFile/ajaxRRDetails.php',
      type: 'post',
      data: { "company_id_upd":company_id_upd },
      dataType: 'json',
      success:function(response){ 
      
          $('#rr').empty();
          $('#rr').prepend("<option value=''>" + 'Select Roles & Responsibility' + "</option>");
          $('#rr').append("<option value='New'>" + 'New' + "</option>");
          var i = 0;
          for (i = 0; i <= response.rr_ref_id.length - 1; i++) { 
              var selected = "";
              if(rr_id_upd == response['rr_ref_id'][i]){
                  selected = "selected";
              }
              $('#rr').append("<option value='" + response['rr_ref_id'][i] + "' "+selected+" >" + response['rr'][i] + "</option>");
          }
      }
  });
}