// choices js for multi select dropdown:
const top_hierarchy = new Choices('#top_hierarchy', {
	removeItemButton: true,
});
const sub_ordinate = new Choices('#sub_ordinate', {
	removeItemButton: true,
});

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

  // Get department based on compnay
  $("#branch_id").change(function(){
  var company_id = $("#branch_id").val();
  if(company_id.length==''){
  $("#branch_id").val('');
  }else{
    getdepartment(company_id);
    // getBranch(company_id);
  }
  });

  // Get designation based on department
  $("#department").change(function(){
  var department_id = $("#department").val();
  if(department_id.length==''){
    $("#department").val('');
  }else{
      getdesignation(department_id);
    }
  });

  // $("#company_id").chosen();
});

//auto call function for edit
$(function(){

  // manager login
  getdepartmentLoad();

  var idupd = $("#branch_id :selected").val();
  var upd_name = $("#branch_id :selected").text();
  var department_upd = $('#dept_id_upd').val()
  if(idupd > 0 ){
      getdepartment(idupd);
      // getdesignation(department_upd);
      getBranch(idupd);
  }else{
    
  }
});

// get department details
function getdepartmentLoad(){ 
  $.ajax({
      url: 'tagFile/ajaxStaffDepartmentDetailsLoad.php',
      type: 'post',
      data: {},
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

function getdepartment(company_id){
  var department_upd = $('#dept_id_upd').val()
  $.ajax({
    url: 'StaffFile/ajaxStaffDepartmentDetails.php',
    type: 'post',
    data: { "company_id":company_id },
    dataType: 'json',
    success:function(response){ 

      $('#department').empty();
      $('#department').prepend("<option value=''>" + 'Select Department Name' + "</option>");
      var r = 0;
      var selected = "";
      for (r = 0; r <= response.department_id.length - 1; r++) { 
        if(department_upd == response['department_id'][r]){
          selected = "selected";
        }
        $('#department').append("<option value='" + response['department_id'][r] + "'  "+selected+" >" + response['department_name'][r] + "</option>");
      }
    }
  });
}


function getdesignation(department_id){

  var company_id = $("#branch_id").val();
  $.ajax({
    url: 'StaffFile/ajaxStaffDesignationDetails.php',
    type: 'post',
    data: { "company_id":company_id, "department_id":department_id },
    dataType: 'json', 
    success:function(response){ 

      // designation append
      $('#designation').empty();
      for (var r = 0; r <= response.designation_id.length - 1; r++) {
        var selected = "";
        if(department_id == response['designation_id'][r]){
          selected = "selected";
        }
        $('#designation').append("<option value='" + response['designation_id'][r] + "' "+selected+" >" + response['designation_name'][r] + "</option>");
      }

      // top hierarchy and sub ordinate append
      top_hierarchy.clearStore();
      sub_ordinate.clearStore();
      for (var r = 0; r <= response.designation_id.length - 1; r++) {     
          var designation_id = response['designation_id'][r];  
          var designation_name = response['designation_name'][r]; 
          var items = [
              {
                  value: designation_id,
                  label: designation_name,
                  selected: selected,
              }
          ];
          top_hierarchy.setChoices(items);
          top_hierarchy.init();
          sub_ordinate.setChoices(items);
          sub_ordinate.init();
      }
      
    }
  });
}


function editGetDesignationList(){

  var company_id = $('#company_nameEdit').val(); 
  var department_id = $('#departmentEdit').val(); 
  var top_hierarchyEdit = $('#top_hierarchyEdit').val().split(',');  
  var sub_ordinateEdit = $('#sub_ordinateEdit').val().split(',');  

  $.ajax({
      url: 'StaffFile/ajaxStaffDesignationDetails.php',
      type: 'post',
      data: { "company_id":company_id, "department_id":department_id },
      dataType: 'json', 
      success:function(response){ 

          $('#designation').empty();
          for (var r = 0; r <= response.designation_id.length - 1; r++) {
              var selected = "";
              if(department_id == response['designation_id'][r]){
              selected = "selected";
              }
              $('#designation').append("<option value='" + response['designation_id'][r] + "' "+selected+" >" + response['designation_name'][r] + "</option>"); 
          }

          top_hierarchy.clearStore();
          sub_ordinate.clearStore();
          for (var r = 0; r <= response.designation_id.length - 1; r++) {     
              var designation_id = response['designation_id'][r];  
              var designation_name = response['designation_name'][r]; 

              var selected = '';
              if(top_hierarchyEdit != ''){
                for(var i=0;i<top_hierarchyEdit.length;i++){
                  if(top_hierarchyEdit[i] == designation_id){ 
                      selected = 'selected';
                  }
                }
              }
              var selected1 = '';
              if(sub_ordinateEdit != ''){
                for(var i=0;i<sub_ordinateEdit.length;i++){
                  if(sub_ordinateEdit[i] == designation_id){ 
                      selected1 = 'selected';
                  }
                }
              }

              var items = [
                {
                  value: designation_id,
                  label: designation_name,
                  selected: selected,
                }
              ];
              var items1 = [
                {
                  value: designation_id,
                  label: designation_name,
                  selected: selected1,
                }
              ];
              top_hierarchy.setChoices(items);
              top_hierarchy.init();
              sub_ordinate.setChoices(items1);
              sub_ordinate.init();
          }
          
      }
  });
}

function getBranch(company_id){
  var branch_id_upd = $('#branch_id_upd').val();
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
              var selected = "";
              if(branch_id_upd == response['branch_id'][r]){
                selected = "selected";
              } 
                $('#branch_id').append("<option value='" + response['branch_id'][r] +"' "+ selected +" >" + response['branch_name'][r] + "</option>");
            }
        }
    });
}

function multiselectAppend(designation_name,dropdown){
  
  // console.log(dropdown);
  // alert(designation_name);
    // Add the new options
    var li = document.createElement("li");
    var option = document.createElement("a");
    option.setAttribute("role", "option");
    option.setAttribute("class", "dropdown-item");
    option.setAttribute("aria-disabled", "false");
    option.setAttribute("tabindex", "0");
    option.setAttribute("aria-selected", "false");
    
    var checkmark = document.createElement("span");
    checkmark.setAttribute("class", "bs-ok-default check-mark");
    
    var optionText = document.createElement("span");
    optionText.setAttribute("class", "text");
    optionText.textContent =designation_name;
    
    option.appendChild(checkmark);
    option.appendChild(optionText);
    
    li.appendChild(option);
    dropdown.appendChild(li);
  
}