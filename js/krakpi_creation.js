// choices js for multi select dropdown:
// const assign_to = new Choices('#assign_to', {
// 	removeItemButton: true,
// });

$(document).ready(function () {

  // remove delete option for last child
  $('#delete_row:last').filter(':last').removeClass("deleterow");

    // get company based branch name
    // $('#company_name').on('change',function(){
    //   var company_id = $('#company_name :selected').val();
    //   $.ajax({
    //     url: 'basicFile/ajaxFetchBranchDetails.php',
    //     type:'post',
    //     data: {'company_id': company_id},
    //     dataType: 'json',
    //     success: function(response){
          
    //       $("#branch_id").empty();
    //       $("#branch_id").prepend("<option value='' disabled selected>"+'Select Branch Name'+"</option>");
    //       var r = 0;
    //       for (r = 0; r <= response.branch_id.length - 1; r++) { 
    //         $('#branch_id').append("<option value='" + response['branch_id'][r] + "'>" + response['branch_name'][r] + "</option>");
    //       }
    //     }
    //   });
    // });

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

  $('#designation').change(function(){  // KRA category dropdown show based on designation.
    var designation_id = $(this).val();
    if(designation_id.length !=''){
      getkradropdown(designation_id);
      getrrdropdown(designation_id);

      $('.kpi').val('');
      $('.project').val('');
      $('.frequency').val('');
      $('.frequency_applicable').prop('checked', false);
      $('.calendar').val('');
      $('.from_date').val('');
      $('.to_date').val('');
    }
  });

  setTimeout(() => {
    getFrequencyApplicable();
  }, 1000);
  
  // add module 
  var markup1 = "<option value=''>Select KRA Category</option>";
  var markup2 = "<option value=''>Select Roles & Responsibility</option><option value='New'>New</option>";
  var markup3 = "<option value=''>Select Project</option>";
    // var forChoice = 1;
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
          "<td><select id='frequency' tabindex='11' name='frequency[]' class='frequency chosen-select form-control'><option value=''>Select Frequency</option><option value='Weekly'>Weekly</option><option value='Fortnightly'>Fortnightly</option><option value='Monthly'>Monthly</option><option value='Quaterly'>Quaterly</option><option value='Half Yearly'>Half Yearly</option><option value='Yearly'>Yearly</option><option value='Daily Task'>Daily Task</option></select></td>" +
          "<td><input disabled type='checkbox' tabindex='7' name='frequency_applicable[]' id='frequency_applicable' value='frequency_applicable' class='frequency_applicable'> </td>" +
          "<td><select tabindex='9' type='text' class='form-control calendar' id='calendar' name='calendar[]' ><option value=''>Select Calendar</option><option value='Yes'>Yes</option><option value='No'>No</option></select></td>" +
          "<td><input readonly type='date' tabindex='8' name='from_date[]' id='from_date' class='form-control' >&nbsp;&nbsp; <span>To</span>&nbsp;&nbsp;<input readonly type='date' tabindex='9' name='to_date[]' id='to_date' class='form-control' ></td>" +
          "<td><button type='button' tabindex='11' id='add_product' name='add_product' value='Submit' class='btn btn-primary add_product'>Add</button></td>" +
          "<td><span class='deleterow icon-trash-2' tabindex='11'></span></td>"+
          "</tr>";
          $('#moduleTable').find('tbody').append(appendTxt);

          markup1 = "<option value=''>Select KRA Category</option>";
          markup2 = "<option value=''>Select Roles & Responsibility</option><option value='New'>New</option>";
          markup3 = "<option value=''>Select Project</option>";
          
          // Initialize the plugin on the new assign_to dropdown
          // var cc = new Choices('.assign_to'+forChoice, {
          //   removeItemButton: true,
          // });

          // for(i=0; i<=data["staff_id"].length-1; i++){
          //   var items =[ {
          //     value: data['staff_id'][i],
          //     label:data['staff_name'][i]
          //   } ]
          //   cc.setChoices(items);
          //   cc.init();
          // }
          
          // markup1="<option value=''>Select Roles & Responsibility</option>";

        }
      }).then(function(){
        getFrequencyApplicable();
      });
      // forChoice++;
    });

  // Delete unwanted Rows
  $(document).on("click", '.deleterow', function () {
    $(this).parent().parent().remove();
  });

  // Get read only text box
  $(document).on("change",".rr",function(){ 
    var rr = $(this).children(":selected").text();  
    if(rr == 'New'){ 
      $(this).closest("tr").find('td:eq(2) #kpi').prop('readonly',false);
    } else {
      $(this).closest("tr").find('td:eq(2) #kpi').prop('readonly',true);
      $(this).closest("tr").find('td:eq(2) #kpi').val('');
    }
  });

  // enable and disable calendar
  $(document).on("change",".calendar",function(){  
    var calendar1 = $(this).children(":selected").text();
    var calendar = calendar1.trim();
    if(calendar == 'Yes'){ 
      $(this).parents('tr').find('td #from_date').attr("readonly",false);
      $(this).parents('tr').find('td #to_date').attr("readonly",false);
    } else if(calendar == 'No'){ 
      $(this).parents('tr').find('td #from_date').attr("readonly",true);
      $(this).parents('tr').find('td #to_date').attr("readonly",true);
      $(this).parents('tr').find('td #from_date').val('');
      $(this).parents('tr').find('td #to_date').val('');
    }
  });

    // enable and disable project
    $(document).on("change",".criteria",function(){  
      var criteria1 = $(this).children(":selected").text();
      var criteria = criteria1.trim();
      if(criteria == 'Event'){ 
        $(this).parents('tr').find('td #project_id').attr("readonly",true);
        $(this).parents('tr').find('td #add_CategoryDetails').attr("disabled",true);
      } else if(criteria == 'Project'){ 
        $(this).parents('tr').find('td #project_id').attr("readonly",false);
        $(this).parents('tr').find('td #add_CategoryDetails').attr("disabled",false);
        // $(this).parents('tr').find('td #project_id').val('');
        // $(this).parents('tr').find('td #add_CategoryDetails').val('');
      }
    });

    // enable and disable frequency
    $(document).on("change",".frequency",function(){ 
      var frequency1 = $(this).children(":selected").text();
      var frequency = frequency1.trim(); 
      if(frequency == 'Weekly' || frequency == 'Fortnightly' || frequency == 'Monthly' || frequency == 'Quaterly' || frequency == 'Half Yearly' ){ 
        $(this).parents('tr').find('td #frequency_applicable').attr("disabled",false);
      } else  if(frequency == 'Daily Task' || frequency == 'Yearly'){ 
        $(this).parents('tr').find('td #frequency_applicable').prop('checked', false);
        $(this).parents('tr').find('td #frequency_applicable').attr("disabled",true);
      }
    });

  // get department details
  // $('#designation').change(function(){
  //   getAssignToStaff();
  // });


  // Modal Box for Project Name
  $("#projectnameCheck").hide();
  $(document).on("click", "#submitProjectModal", function () {
      var project_id=$("#project_id").val();
      var project_name=$("#project_name").val();
      if(project_name!=""){
          $.ajax({
              url: 'KRA&KPIFile/ajaxInsertProject.php',
              type: 'POST',
              data: {"project_name":project_name,"project_id":project_id},
              cache: false,
              success:function(response){
                  var insresult = response.includes("Exists");
                  var updresult = response.includes("Updated");
                  if(insresult){
                      $('#categoryInsertNotOk').show(); 
                      setTimeout(function() {
                          $('#categoryInsertNotOk').fadeOut('fast');
                      }, 2000);
                  }else if(updresult){
                      $('#categoryUpdateOk').show();  
                      setTimeout(function() {
                          $('#categoryUpdateOk').fadeOut('fast');
                      }, 2000);
                      $("#coursecategoryTable").remove();
                      resetloancategoryTable();
                      $("#project_name").val('');
                      $("#project_id").val('');
                  }
                  else{
                      $('#categoryInsertOk').show();  
                      setTimeout(function() {
                          $('#categoryInsertOk').fadeOut('fast');
                      }, 2000);
                      $("#coursecategoryTable").remove();
                      resetloancategoryTable();
                      $("#project_name").val('');
                      $("#project_id").val('');
                  }
              }
          });
      }
      else{
      $("#projectnameCheck").show();
      }
  });

  function resetloancategoryTable(){
      $.ajax({
          url: 'KRA&KPIFile/ajaxResetProjectTable.php',
          type: 'POST',
          data: {},
          cache: false,
          success:function(html){
              $("#updatedprojectTable").empty();
              $("#updatedprojectTable").html(html);
          }
      });
  }

  $("#project_name").keyup(function(){
      var CTval = $("#project_name").val();
      if(CTval.length == ''){
      $("#projectnameCheck").show();
      return false;
      }else{
      $("#projectnameCheck").hide();
      }
  });

  $("body").on("click","#edit_project",function(){
      var project_id=$(this).attr('value');
      $("#project_id").val(project_id);
      $.ajax({
              url: 'KRA&KPIFile/ajaxEditProject.php',
              type: 'POST',
              data: {"project_id":project_id},
              cache: false,
              success:function(response){
              $("#project_name").val(response);
          }
      });
  });

  $("body").on("click","#delete_project", function(){
      var isok=confirm("Do you want delete course project?");
      if(isok==false){
          return false;
      }else{
          var project_id=$(this).attr('value');
          var c_obj = $(this).parents("tr");
          $.ajax({
              url: 'KRA&KPIFile/ajaxDeleteProject.php',
              type: 'POST',
              data: {"project_id":project_id},
              cache: false,
              success:function(response){
                  var delresult = response.includes("Rights");
                  if(delresult){
                  $('#categoryDeleteNotOk').show(); 
                  setTimeout(function() {
                  $('#categoryDeleteNotOk').fadeOut('fast');
                  }, 2000);
                  }
                  else{
                  c_obj.remove();
                  $('#categoryDeleteOk').show();  
                  setTimeout(function() {
                  $('#categoryDeleteOk').fadeOut('fast');
                  }, 2000);
                  }
              }
          });
      }
  });

  $(function(){
      $('#projectTable').DataTable({
          'iDisplayLength': 5,
          "language": {
          "lengthMenu": "Display _MENU_ Records Per Page",
          "info": "Showing Page _PAGE_ of _PAGES_",
          }
      });
  });

});


function DropDownCourse(){
  $.ajax({
      url: 'KRA&KPIFile/ajaxGetProject.php',
      type: 'post',
      data: {},
      dataType: 'json',
      context: this,
      success:function(response){

        var i = 0;
        var arr = [];
        $('.project').each(function(){
          arr[i] = $(this).val();
          i++;
        });

        var len = response.length;
        $(".project").empty();
        $(".project").append("<option value=''>"+'Select Project'+"</option>");

        var k = 0;
        $('.project').each(function(){
          var selVal = arr[k];
         
          for(var j = 0; j<len; j++){
            var project_id = response[j]['project_id'];
            var project_name = response[j]['project_name'];
            
            var selected = '';
            if(selVal == project_id){ 
              selected = 'selected';
            }
            $(this).append("<option value='"+project_id+"' "+selected+">"+project_name+"</option>");
          }
          k++;
        });

      }
  });
}


//get details on edit
$(function(){

  // super admin login
	var idupd = $("#company_name").val();
	var department_upd = $('#department_upd').val();
	if(idupd > 0 ){
		
		getdepartment(idupd);
		getdesignation(department_upd);
	}else{
	}
});

// get department details
function getdepartment(company_id){ 
  var department_upd = $('#department_upd').val();
  $.ajax({
    url: 'R&RFile/ajaxGetCompanyBasedDepartment.php',
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
          selected = "selected";
      }
        $('#designation').append("<option value='" + response['designation_id'][i] + "' "+selected+" >" + response['designation_name'][i] + "</option>");
      }
    }
  });
}

//get kra dropdown based on company name
function getkradropdown(designation_id){ 
  var id = $('#id').val();
  if(id > 0){
    var kra_id_upd = $('#kra_id_upd').val().split(',');  //KRA&KPI creation id using in edit option.
  }else{
    var kra_id_upd = ''; //passing null When add new KRA&KPI creation. 

  } 
  
  $.ajax({
    url: 'KRA&KPIFile/ajaxKraDetails.php',
    type: 'post',
    data: { "designation_id":designation_id },
    dataType: 'json',
    success:function(response){
      
      $('.kra_category').empty();
      $('.kra_category').prepend("<option value=''>" + 'Select KRA Category' + "</option>");
      var i = 0;
      for (i = 0; i <= response.kra_creation_ref_id.length - 1; i++) {

        var selected = "";
        if(kra_id_upd != ''){
          for(var j=0;j<kra_id_upd.length;j++){
              if(kra_id_upd[j] == response['kra_creation_ref_id'][i]){  
                  selected = 'selected';
              }
          }
        }
        $('.kra_category').append("<option value='" + response['kra_creation_ref_id'][i] + "' "+selected+" >" + response['kra_category'][i] + "</option>");
      }

    }
  });
}

//get rr dropdown based on company name
function getrrdropdown(designation_id){
  var rr_id_upd = $('#rr_id_upd').val().split(','); 
  
  $.ajax({
    url: 'KRA&KPIFile/ajaxRRDetails.php',
    type: 'post',
    data: { "designation_id":designation_id },
    dataType: 'json',
    success:function(response){
      
      $('.rr').empty();
      $('.rr').prepend("<option value=''>" + 'Select Roles & Responsibility' + "</option>");
      $('.rr').append("<option value='New'>" + 'New' + "</option>");
      var i = 0;
      for (i = 0; i <= response.rr_ref_id.length - 1; i++) { 
        var selected = "";
        if(rr_id_upd != ''){
          for(var j=0;j<rr_id_upd.length;j++){ 
              if(rr_id_upd[j] == response['rr_ref_id'][i]){  
                  selected = 'selected';
              }
          }
        }
        $('.rr').append("<option value='" + response['rr_ref_id'][i] + "' "+selected+" >" + response['rr'][i] + "</option>");
      }

    }
  });
}


function getkradropdownEdit(company_id_upd){  

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

function getFrequencyApplicable(){
  $('.frequency_applicable').off().change(function(){
    console.log('aaaa')
    let boxes= [];let x=0;let y=' ';
    $('.frequency_applicable').each(function(){
      
      if($(this).prop('checked')){
        boxes.push(x)
      }else{
        boxes.push(y);
      }
      x++;
    })
    boxes = boxes.join(',');
    $('#freq_check').empty().val(boxes);
  })
}