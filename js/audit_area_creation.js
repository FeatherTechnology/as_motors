// choices js for multi select dropdown:
const department_id = new Choices('#department_id', {
	removeItemButton: true,
});

$(document).ready(function(){

    $("#role2").change(function(){
        var role2 = $("#role2").val();
        var role1   = $("#role1").val();

        if(role2 == role1){
            alert("role1 and role2 shold not be same");
            $("#role2").val('');
            return false;
        }
    });

    $("#role1").change(function(){
        var role2 = $("#role2").val();
        var role1   = $("#role1").val();

        if(role2 == role1){
            alert("role1 and role2 shold not be same");
            $("#role1").val('');
            return false;
        }
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

  // enable and disable calendar
  $(document).on("change",".calendar",function(){ 
    var calendar1 = $(this).children(":selected").text();
    var calendar = calendar1.trim();
    if(calendar == 'Yes'){ 
      $('#from_date').attr("readonly",false);
      $('#to_date').attr("readonly",false);
    } else if(calendar == 'No'){ 
      $('#from_date').attr("readonly",true);
      $('#to_date').attr("readonly",true);
      $('#from_date').val('');
      $('#to_date').val('');
    }
  });

  // enable and disable frequency
  $(document).on("change",".frequency",function(){ 
    var frequency1 = $(this).children(":selected").text();
    var frequency = frequency1.trim(); 
    if(frequency == 'Fortnightly' || frequency == 'Monthly' || frequency == 'Quaterly' || frequency == 'Half Yearly' ){ 
      $('#frequency_applicable').attr("disabled",false);
    } else  if(frequency == 'Daily Task' || frequency == 'Yearly'){ 
      $('#frequency_applicable').prop('checked', false);
      $('#frequency_applicable').attr("disabled",true);
    }
  });

}); 


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