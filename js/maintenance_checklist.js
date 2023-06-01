// Document is ready
$(document).ready(function () { 

    $("#role1").change(function(){
        var role1 = $("#role1").val();
        var role2   = $("#role2").val();

        if(role1 == role2){
            alert("Role 1 and role2 shold not be same");
            $("#role1").val('');
            return false;
        }
    });

    $("#role2").change(function(){
        var role1 = $("#role1").val();
        var role2   = $("#role2").val();
        
        if(role1 == role2){
            alert("role2 and Role 1 shold not be same");
            $("#role2").val('');
            return false;
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
        // console.log($('#city option:selected').data('id'));
    })

    // Get staff and department based on branch
    $("#branch_id").change(function(){
        var company_id = $("#branch_id").val();
        if(company_id.length==''){
            $("#branch_id").val('');
        }else{
            $.ajax({
                url: 'maintenanceChecklistFile/ajaxGetDesignationDepartment.php',
                type: 'post',
                data: { "company_id":company_id },
                dataType: 'json',
                success:function(response){ 

                    $('#role1').empty();
                    $('#role1').prepend("<option value=''>" + 'Select Role 1' + "</option>");
                    var r = 0;
                    for (r = 0; r <= response.designation_id.length - 1; r++) { 
                        $('#role1').append("<option value='" + response['designation_id'][r] + "'>" + response['designation_name'][r]+ "</option>");
                    }

                    $('#role2').empty();
                    $('#role2').prepend("<option value=''>" + 'Select Role 2' + "</option>");
                    var r = 0;
                    for (r = 0; r <= response.designation_id.length - 1; r++) { 
                        $('#role2').append("<option value='" + response['designation_id'][r] + "'>" + response['designation_name'][r]+ "</option>");
                    }

                    $('#asset_details').empty();
                    $('#asset_details').prepend("<option value=''>" + 'Select Asset Details' + "</option>");
                    var r = 0;
                    for (r = 0; r <= response.asset_id.length - 1; r++) { 
                        $('#asset_details').append("<option value='" + response['asset_id'][r] + "'>" + response['asset_name'][r]+' - '+response['asset_classification'][r] + "</option>");
                    }
                }
            });
        }
    });
 
});

$("#executeBtn").click(function(){
    
    var checklist = $("#checklist").val();
    if(checklist.length != ''){
        $.ajax({
            url:"maintenanceChecklistFile/ajaxGetPMBMChecklistDetails.php",
            method:"post",
            data:{"checklist":checklist},
            success:function(html){
                $("#checklistAppend").empty();
                $("#checklistAppend").html(html);
            }
        });
    }
});

// insert and update
$("#submitMaintenanceChecklistBtn").click(function(){

    var totalCheckboxCount = $(':checkbox:checked').length;
    if(totalCheckboxCount > 0 ){
        
        var company_id = $("#branch_id").val();
        var doi = $("#doi").val(); 
        var asset_details = $("#asset_details").val(); 
        var checklist = $("#checklist").val(); 
        var calendar = $("#calendar").val(); 
        var from_date = $("#from_date").val(); 
        var to_date = $("#to_date").val(); 
        var role1 = $("#role1").val(); 
        var role2 = $("#role2").val(); 
        var checklist_textarea = $("#checklist_textarea").val(); 

        formData = new FormData();     
        var checkedid = [];
        var frequency = [];          
        var frequency_applicable = [];          
        var remarks = [];          
        var maintenanceChceklistRefId = [];  
        var file = [];
        var checklist_textarea = [];

        $(':checkbox:checked').each(function(i){
            checkedid[i] = $(this).val(); 
            checklist_textarea[i] = $(this).parents('tr').find('td #checklist_textarea').val();   
            frequency[i] = $(this).parents('tr').find('td #frequency').val();   
            frequency_applicable[i] = $(this).parents('tr').find('td #frequency_applicable').val();   
            remarks[i] = $(this).parents('tr').find('td #remarks').val();   
            maintenanceChceklistRefId[i] = $(this).parents('tr').find('td #maintenanceChceklistRefId').val(); 
            file[i] = $(this).closest('tr').find('input[type="file"]').prop('files')[0];
            formData.append('file[]', file[i]);
        });
       
        formData.append('company_id', company_id);
        formData.append('doi', doi);
        formData.append('asset_details', asset_details);
        formData.append('checklist', checklist);
        formData.append('calendar', calendar);
        formData.append('from_date', from_date);
        formData.append('to_date', to_date);
        formData.append('role1', role1);
        formData.append('role2', role2);
        formData.append('checkedid[]', checkedid);
        formData.append('frequency[]', frequency);
        formData.append('frequency_applicable[]', frequency_applicable);
        formData.append('remarks[]', remarks);
        formData.append('checklist_textarea[]', checklist_textarea);
       
        var updid = $("#id").val(); 
        if(updid>0){
            
            var maintenanceChceklistId = $("#maintenanceChceklistId").val(); 
            formData.append('maintenanceChceklistId', maintenanceChceklistId);
            formData.append('maintenanceChceklistRefId[]', maintenanceChceklistRefId);
    
            $.ajax({
                type: "POST",
                url: 'maintenanceChecklistFile/updateMaintenanceChecklist.php',
                data: formData,
                contentType: false,
                processData: false,
                success:function(response){
                    window.location.href = "edit_maintenance_checklist&msc=2";
                }
            });
    
        }else{
            $.ajax({
                type: "POST",
                url: 'maintenanceChecklistFile/insertMaintenanceChecklist.php',
                data: formData,
                contentType: false,
                processData: false,
                success:function(response){
                    window.location.href = "edit_maintenance_checklist&msc=1";
                }
            });
        }

    }else{
        alert('Select any one checkbox to submit')
        return false;
    }
});

// dashboard update
$("#submitMaintenanceChecklisDashboardtBtn").click(function(){

    var totalCheckboxCount = $(':checkbox:checked').length;
    if(totalCheckboxCount > 0 ){
        
        var maintenanceChceklistId = $("#maintenanceChceklistId").val(); 
        var checkedid = [];
        var maintenanceChceklistRefId = [];
        var reason = [];
        $(':checkbox:checked').each(function(i){ 
            checkedid[i] = $(this).val();
            maintenanceChceklistRefId[i] = $(this).parents('tr').find('td #maintenanceChceklistRefId').val(); 
            reason[i] = $(this).parents('tr').find('td #reason').val(); 
        });

        $.ajax({
            type: "POST",
            url: 'maintenanceChecklistFile/updateMaintenanceChecklistDashboard.php',
            data: { "maintenanceChceklistId":maintenanceChceklistId, "maintenanceChceklistRefId":maintenanceChceklistRefId, "checkedid":checkedid, "reason":reason },
            dataType: 'json',
            success:function(response){
                window.location.href = "dashboard";
            }
        });
    
    }else{
        alert('Select any one checkbox to submit')
        return false;
    }
});

// Get Department based reporting person
// $("#department").change(function(){ 

//     var company_id = $("#branch_id").val();
//     var department_id = $("#department").val();

//     if(department_id.length==''){ 
//         $("#department").val('');
//     }else{
//         $.ajax({
//             url: 'StaffFile/ajaxGetDeptBasedStaff.php',
//             type: 'post',
//             data: { "company_id":company_id, "department_id":department_id },
//             dataType: 'json',
//             success:function(response){
//                 $('#staff_code').empty();
//                 $('#staff_code').prepend("<option value=''>" + 'Select Staff Name' + "</option>");
//                 var i = 0;
//                 for (i = 0; i <= response.staff_id.length - 1; i++) { 
//                     $('#staff_code').append("<option value='" + response['staff_id'][i] + "'>" + response['emp_code'][i] + "</option>");
//                 }

//             }
//         });
//     }
// });

// Get staff code 
// $("#staff_code").change(function(){ 

//     var company_id = $("#branch_id").val();
//     var department_id = $("#department").val();
//     var staff_name = $("#staff_code").val();

//     if(staff_name.length==''){ 
//         $("#staff_name").val('');
//     }else{
//         $.ajax({
//             url: 'StaffFile/ajaxGetStaffBasedStaffCode.php',
//             type: 'post',
//             data: { "company_id":company_id, "department_id":department_id, "staff_name":staff_name  },
//             dataType: 'json',
//             success:function(response){
//                 $('#staff_name').val(response.staff_name);
//             }
//         });
//     }
// });


// $("#place").keyup(function(){ 

//     var place = $("#place").val();
//     if(place.length != ''){
//         $("#personal_reason").attr("disabled",true);
//         $("#leave").attr("disabled",true);
//     }else if(place.length == ''){
//         $("#personal_reason").attr("disabled",false);
//         $("#leave").attr("disabled",false);
//     }
// });

$("input[name='reason']").click(function(){ 

    var reason = $('input[name="reason"]:checked').val();
    if(reason.length != ''){
        $("#place").attr("disabled",true);
    }else if(reason.length == ''){
        $("#place").attr("disabled",false);
    }
});

// print functionality
// function print_transfer_location(id){
//     $.ajax({
//         url: 'transferLocationFile/printTransferLocation.php',
//         cache: false,
//         type: 'POST',
//         data: { 'id':id },
//         success: function(html){
//             $("#printTransferLocation").html(html);
//         }
//     });
// }
