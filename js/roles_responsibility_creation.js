$(document).ready(function () {

  // remove delete option for last child
  $('#delete_row:last').filter(':last').removeClass("deleterow");

// get company based branch name
// $('#company_name').on('change',function(){
//   var company_id = $('#company_name :selected').val();
//   $.ajax({
//       url: 'basicFile/ajaxFetchBranchDetails.php',
//       type:'post',
//       data: {'company_id': company_id},
//       dataType: 'json',
//       success: function(response){
          
//           $("#branch_id").empty();
//           $("#branch_id").prepend("<option value='' disabled selected>"+'Select Branch Name'+"</option>");
//           var r = 0;
//           for (r = 0; r <= response.branch_id.length - 1; r++) { 
//               $('#branch_id').append("<option value='" + response['branch_id'][r] + "'>" + response['branch_name'][r] + "</option>");
//           }
//       }
//   });
// });

  // Get Company based on Department
  $("#company_name").change(function(){
    
    var company_id = $("#company_name").val();
    if(company_id.length==''){
      $("#company_name").val('');
    }else{
      $.ajax({
        url: 'R&RFile/ajaxGetCompanyBasedDepartment.php',
        type: 'post',
        data: { "company_id":company_id },
        dataType: 'json',
        success:function(response){ 
  
          $('.department').empty();
          $('.department').prepend("<option value=''>" + 'Select Department Name' + "</option>");
          var r = 0;
          for (r = 0; r <= response.department_id.length - 1; r++) { 
            $('.department').append("<option value='" + response['department_id'][r] + "'>" + response['department_name'][r] + "</option>");
          }
        }
      });
    }
  });

    
 // Get modules based on product
  // $(".department").change(function(){ 
  $(document).on('change', '.department', function (e) {

    var currentrow = $(this).closest('tr');
    var department_id = $(this).val();
    // var department_id = $("#department").val();

    if(department_id.length==''){ 
      $("#department").val('');
    }else{
    
      $.ajax({
        url: 'R&RFile/ajaxR&RDesignationDetails.php',
        type: 'post',
        data: { "department_id":department_id },
        dataType: 'json',
        success:function(response){

          currentrow.find(".designation").empty();
          currentrow.find(".designation").prepend("<option value=''>" + 'Select Designation' + "</option>");
          
          // $('#designation').empty();
          // $('#designation').prepend("<option value=''>" + 'Select Designation' + "</option>");
          var i = 0;
          for (i = 0; i <= response.designation_id.length - 1; i++) { 
            currentrow.find(".designation").append("<option value='" + response['designation_id'][i] + "'>" + response['designation_name'][i] + "</option>");
          }
        }
      });
    }
  });

    // add module 
    var markup1 = "<option value=''>Select Department</option>";
    $(document).on("click", '.add_product', function () { 
   
        // var Add = validateItems();
        var company_id = $("#company_name").val(); 
  
        // if(Add == true){
          if(company_id.length==''){ 
            $("#department").val('');
            $("#designation").val('');
          }else{
            $.ajax({
              url: 'R&RFile/ajaxGetCompanyBasedDepartment.php',
              data: {"company_id":company_id},
              cache: false,
              type: "post",
              dataType: "json",
              success: function (data) { 

                var r=0;
                for (r = 0; r <= data["department_id"].length - 1; r++) { 
                  markup1 += "<option value="+data["department_id"][r]+">"+data["department_name"][r]+"</option>";
                }

                var appendTxt = "<tr><input type='hidden' class='rrrefid' name='rr_ref_id[]' id='rr_ref_id' value=''><td><select id='department' tabindex='11' name='department[]' class='department chosen-select form-control'>" + markup1 + "</select></td>" +
                "<td><input type='text' tabindex='13' class='chosen-select form-control rr' id='rr' name='rr[]' /></td>" +
                "<td><select id='designation' tabindex='11' name='designation[]' class='designation chosen-select form-control'></select></td>" +
                "<td><button type='button' tabindex='26' id='add_product' name='add_product' value='Submit' class='btn btn-primary add_product'>Add</button></td>" +
                "<td><span class='deleterow icon-trash-2' tabindex='18'></span></td>"+
                "</tr>";
      
                $('#moduleTable').find('tbody').append(appendTxt);
                markup1="<option value=''>Select Department</option>";
              }
            });
          }
        // }else{
        //   $("#itemCheck").show();
        //   itemcheckError = false;
        // }
      // }
    });

  // Delete unwanted Rows
  $(document).on("click", '.deleterow', function () {
    var cellValue = $(this).parent().parent().find('.rrrefid').val();
    var rowval = $(this).parent().parent();

    $.ajax({
      url: 'ajaxFetch/ajaxDeleteValidateForKRARR.php',
      type: 'post',
      data: { "cellValue":cellValue, "cellKey": 'rr' },
      dataType: 'json',
      success:function(response){ 
        if(response == 1 && confirm('This RR is already mapped in KRA&KPI creation, Do you want delete this?')){ // if the KRA Category Map with KRA&KPI creation ask permission to delete.
          rowDelete(cellValue,rowval);
        }else if(response == 0){
          rowDelete(cellValue,rowval);
        }
        
      }
    });

  });

});

function rowDelete(cellValue,rowval){
    rowval.remove();
    // Assuming you want to store the cellValue in an array
    var dataArray = [];
    var rrid = $('#rr_ref_id_deleted').val();
    if(rrid != ''){ //get kra_ref_id which delete and store that particular id in seperate hidden input, to use delete that particular id and update remaining by using using id. 
      dataArray.push(rrid);
    }
      dataArray.push(cellValue);

    // Set the array value to the input field
    $('#rr_ref_id_deleted').val(dataArray);
    
}