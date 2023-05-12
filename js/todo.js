const assign_to = new Choices('#assign_to', {
	removeItemButton: true,
});

$(document).ready(function(){

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

    // Get branch based on Department
    $("#branch_id").change(function(){
        var company_id = $("#branch_id").val();
        if(company_id.length==''){
            $("#branch_id").val('');
        }else{
        
            $.ajax({
                url: 'todoFile/ajaxFetchTagAssignTo.php',
                type: 'post',
                data: { "company_id":company_id },
                dataType: 'json',
                success:function(response){ 
    
                    // tag classification
                    $('#tag_id').empty();
                    $('#tag_id').prepend("<option value=''>" + 'Select Tag Classification' + "</option>");
                    var r = 0;
                    for (r = 0; r <= response.tag_id.length - 1; r++) {  
                        $('#tag_id').append("<option value='" + response['tag_id'][r] + "'>" + response['tag_classification'][r] + "</option>");
                    }

                    assign_to.clearStore();
                    for (r = 0; r <= response.staff_id.length - 1; r++) { 

                        var staff_id = response['staff_id'][r];  
                        var staff_name = response['staff_name'][r]; 
                        var items = [
                            {
                                value: staff_id,
                                label: staff_name,
                            }
                        ];
                        assign_to.setChoices(items);
                        assign_to.init();
                    }
                    $("#staff_id").val('');
                    $("#staff_name").val('');
                }
            });
        }
    });

    // enable and disable project
    $(document).on("change",".criteria",function(){  
        var criteria1 = $(this).children(":selected").text();
        var criteria = criteria1.trim();
        if(criteria == 'Event'){ 
            $('#project_id').attr("readonly",true);
            $('#add_CategoryDetails').attr("disabled",true);
        } else if(criteria == 'Project'){ 
            $('#project_id').attr("readonly",false);
            $('#add_CategoryDetails').attr("disabled",false);
        }
    });


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


});//document ready end

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
  

// get details on edit
$(function(){
    // manager login
    getdepartmentLoad();
});

// get department details
function getdepartmentLoad(){ 
    var department_upd = $('#department_upd').val();
    $.ajax({
        url: 'KRA&KPIFile/ajaxKra&KpiDepartmentDetailsLoad.php',
        type: 'post',
        data: {},
        dataType: 'json',
        success:function(response){ 

        $('#department_id').empty();
        $('#department_id').prepend("<option value=''>" + 'Select Department Name' + "</option>");
        var r = 0;
        for (r = 0; r <= response.department_id.length - 1; r++) { 
            var selected = "";
            if(department_upd == response['department_id'][r]){
            selected = "selected";
            }
            $('#department_id').append("<option value='" + response['department_id'][r] + "' "+selected+">" + response['department_name'][r] + "</option>");
        }
        }
    });
}


// edit tag, assign to details
function editBranchBasedTagAssignTo(company_id, tagEdit, staffEdit){ 

    $.ajax({
        url: 'todoFile/ajaxFetchTagAssignTo.php',
        type: 'post',
        data: { "company_id":company_id },
        dataType: 'json',
        success:function(response){  

            // tag classification
            $('#tag_id').empty();
            $('#tag_id').prepend("<option value=''>" + 'Select Tag Classification' + "</option>");
            var r = 0;
            for (r = 0; r <= response.tag_id.length - 1; r++) { 
                var selected = "";
                if(tagEdit == response['tag_id'][r]){
                    selected = "selected";
                }
                $('#tag_id').append("<option value='" + response['tag_id'][r] + "' "+selected+">" + response['tag_classification'][r] + "</option>");
            }

            assign_to.clearStore();
            for (r = 0; r <= response.staff_id.length - 1; r++) { 

                var staff_id = response['staff_id'][r];  
                var staff_name = response['staff_name'][r]; 

                var selected = '';
                if(staffEdit != ''){
                    for(var i=0;i<staffEdit.length;i++){ 
                        if(staffEdit[i] == staff_id){  
                            selected = 'selected';
                        }
                    }
                }

                var items = [
                    {
                        value: staff_id,
                        label: staff_name,
                        selected: selected,
                    }
                ];
                assign_to.setChoices(items);
                assign_to.init();
            }

            // $("#staff_id").val('');
            // $("#staff_name").val('');
        }
    });
};