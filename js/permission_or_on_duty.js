// Document is ready
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
  
    $('#city').change(function() {
        $('#state').val($('#city option:selected').data('id'));
        console.log($('#city option:selected').data('id'));
    })

    // Get branch based on Department
    $("#branch_id").change(function(){
        var company_id = $("#branch_id").val();
        if(company_id.length==''){
            $("#branch_id").val('');
        }else{
            $.ajax({
                url: 'StaffFile/ajaxStaffDepartmentDetails.php',
                type: 'post',
                data: { "company_id":company_id },
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
    });

    // Hide and show reason
    $("#reason").change(function() {

        var reason = $("#reason").val(); 

        if(reason == "Permission"){
            $(".permissionCls").css("display", "block");
            $(".on_dutyCls").css("display", "none");
            $(".leaveCls").css("display", "none");
        }else if(reason == "On Duty"){
            $(".permissionCls").css("display", "none");
            $(".on_dutyCls").css("display", "block");
            $(".leaveCls").css("display", "none");
        }else if(reason == "Leave"){
            $(".permissionCls").css("display", "none");
            $(".on_dutyCls").css("display", "none");
            $(".leaveCls").css("display", "block");
        }else if(reason == ""){
            $(".permissionCls").css("display", "none");
            $(".on_dutyCls").css("display", "none");
            $(".leaveCls").css("display", "none");
        }
    });


});

// Get Department based on designation
$("#department").change(function(){ 

    var company_id = $("#branch_id").val();
    var department_id = $("#department").val();
    if(department_id.length==''){ 
        $("#department").val('');
    }else{
        $.ajax({
            url: 'StaffFile/ajaxStaffDesignationDetails.php',
            type: 'post',
            data: { "company_id":company_id, "department_id":department_id },
            dataType: 'json',
            success:function(response){
            
                $('#designation').empty();
                $('#designation').prepend("<option value=''>" + 'Select Designation' + "</option>");
                var i = 0;
                for (i = 0; i <= response.designation_id.length - 1; i++) { 
                    $('#designation').append("<option value='" + response['designation_id'][i] + "'>" + response['designation_name'][i] + "</option>");
                }
            }
        });
    }
});

// Get Department based reporting person
$("#department").change(function(){ 

    var company_id = $("#branch_id").val();
    var department_id = $("#department").val();

    if(department_id.length==''){ 
        $("#department").val('');
    }else{
        $.ajax({
            url: 'StaffFile/ajaxGetDeptBasedStaff.php',
            type: 'post',
            data: { "company_id":company_id, "department_id":department_id },
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

// Get staff code 
$("#staff_name").change(function(){ 

    var company_id = $("#branch_id").val();
    var department_id = $("#department").val();
    var staff_name = $("#staff_name").val();

    if(staff_name.length==''){ 
        $("#staff_name").val('');
    }else{
        $.ajax({
            url: 'StaffFile/ajaxGetStaffBasedStaffCode.php',
            type: 'post',
            data: { "company_id":company_id, "department_id":department_id, "staff_name":staff_name  },
            dataType: 'json',
            success:function(response){
            
                $('#staff_code').val(response.emp_code);
                $('#reporting').val(response.reporting);
            }
        });
    }
});


$("#place").keyup(function(){ 

    var place = $("#place").val();
    if(place.length != ''){
        $("#personal_reason").attr("disabled",true);
        $("#leave").attr("disabled",true);
    }else if(place.length == ''){
        $("#personal_reason").attr("disabled",false);
        $("#leave").attr("disabled",false);
    }
});


$("input[name='reason']").click(function(){ 

    var reason = $('input[name="reason"]:checked').val();
    if(reason.length != ''){
        $("#place").attr("disabled",true);
    }else if(reason.length == ''){
        $("#place").attr("disabled",false);
    }
});


