$(document).ready(function(){ //Document Ready Start.

    var userrole = $('#user_role').val();

    $('#krakpi_report_type').change(function(){ //Onchange based on type select for report.
        var typeValue = $(this).val();

        if(typeValue == '2'){
            $('#department_report').hide();
            $('#designation_report').show();
            getDepartmentList('dept_name') //Get All Department list.
            
        } else{
            $('#department_report').show();
            $('#designation_report').hide();
            getDepartmentList('department_name') //Get All Department list.
            
        }

        if(userrole == 3){
         $('#department_name').attr('disabled', true);   
         $('#dept_name').attr('disabled', true);
         
         setTimeout(() => {
            var userDeptID = $('#user_dept_id').val();
            getDesignationDetails(userDeptID);
         }, 1000);
        }
        
        clearValueforAll(); //Clear all value when change type.

    });//krakpi_report_type END.

    $('#view_report').click(function(){ //view report in the table.
        var reportType = $('#krakpi_report_type').val();

        if(reportType =='1'){//Department.

            var department_name = $('#department_name').val();

            if(department_name != ''){
                $('.validate').hide();
                getOverAllReport(department_name);//OverAll Department report ajax.
            }else{
                $('.validate').show();
                tableEmpty();
            }

        }else if(reportType =='2'){//Designation.
            var designation_name = $('#designation_name').val();

            if(designation_name != ''){
                $('.validate').hide();
                designationBasedReports(designation_name); //To show Designation based report.
            }else{
                $('.validate').show();
                tableEmpty();
            }
        }else{
            $('.validate').show();
            tableEmpty();
        }
    }); //view_report END.

    $('.clearvalue, .emptyTable').change(function(){ //when change any value then empty the table.
        tableEmpty();
    });

    //set To date is greater than from date
    $('.validateToDate').change(function(){
        $('.setvaltodate').val('');
        var fromdate = $(this).val();
        // Set Minimum date
        $('.setvaltodate').attr("min", fromdate);
    });
    
    $('#dept_name').change(function(){
        var deptName = $(this).val(); 
        getDesignationDetails(deptName);
    })

}); //Document Ready End.

//On Load Function
$(function(){
    var role = $('#user_role').val();

    if(role == 4){
        $('#krakpi_report_type').val('2');
        $('#krakpi_report_type').attr('disabled', true);
        $('#department_report').hide();
        $('#designation_report').show();
        getDepartmentList('dept_name') //Get All Department list.
        $('#dept_name').attr('disabled', true);
        var userDepartmenttId = $('#user_dept_id').val();
        getDesignationDetails(userDepartmenttId)
        $('#designation_name').attr('disabled', true);

        setTimeout(() => {
            $('#view_report').click();
        }, 1000);
    }
});

function getDepartmentList(id) {
        $.ajax({
            url : "departmentFile/getAllDepartmentDetails.php",
            type: "POST",
            dataType: 'json',
            cache: false,
            success: function(response){
                
                var len = response.length;
                $('#'+id).empty();
                $('#'+id).append("<option value=''>" + 'Select Department' + "</option>");

                var userDeptId = $('#user_dept_id').val();
                for (var i = 0; i < len; i++) {
                    var department_name = response[i]['department_name'];
                    var department_id = response[i]['department_id'];
                    var branch_name = response[i]['branch_name'];
                    var selected = '';
                    if(userDeptId == department_id){
                        selected = 'selected';
                    }
                    $('#'+id).append("<option value='" + department_id + "' "+ selected +">" + department_name +' -  ('+branch_name +")" +"</option>");
                }
                {//To Order ag_group Alphabetically
                    var firstOption = $('#'+id+" option:first-child");
                    $('#'+id).html($('#'+id+" option:not(:first-child)").sort(function (a, b) {
                        return a.text == b.text ? 0 : a.text < b.text ? -1 : 1;
                    }));
                    $('#'+id).prepend(firstOption);
                }
            }
        })
    }

function getOverAllReport(department_id){

    $.ajax({
        type: "POST",
        data: {"department_id": department_id },
        url: "reports/krakpi_designation_reports/getOverallKRAKPIReport.php",
        cache: false,
        success: function(response){

            $("#krakpi_report_view_table").empty();
            $("#krakpi_report_view_table").html(response);
        }
    })//Report ajax END.
}

function designationBasedReports(designation_id){

    $.ajax({
        type: "POST",
        data: {"designation_id": designation_id },
        url: "reports/krakpi_designation_reports/designationBasedKRAKPIReport.php",
        cache: false,
        success: function(response){

            $("#krakpi_report_view_table").empty();
            $("#krakpi_report_view_table").html(response);
        }
    })//Report ajax END.
}

function tableEmpty(){
    $("#krakpi_report_view_table").empty(); //if validation false then table will empty.
}

//Clear value when change type.
function clearValueforAll(){
    $('.clearvalue').val('');
}

//get Designation Details
function getDesignationDetails(deptName){
    $.ajax({
        url : "R&RFile/ajaxR&RDesignationDetails.php",
        type: "POST",
        data:{'department_id': deptName},
        dataType: 'json',
        cache: false,
        success: function(response){
            
            $('#designation_name').empty();
            $('#designation_name').prepend("<option value=''>" + 'Select Designation' + "</option>");
            var userDesignationId = $('#user_designation_id').val();
            for (i = 0; i <= response.designation_id.length - 1; i++) { 
                var selected = '';
                if(userDesignationId == response['designation_id'][i]){
                    selected = 'selected';
                }
                $('#designation_name').append("<option value='" + response['designation_id'][i] + "' "+ selected +">" + response['designation_name'][i] + "</option>");
            }
            {//To Order ag_group Alphabetically
                var firstOption = $('#designation_name'+" option:first-child");
                $('#designation_name').html($('#designation_name'+" option:not(:first-child)").sort(function (a, b) {
                    return a.text == b.text ? 0 : a.text < b.text ? -1 : 1;
                }));
                $('#designation_name').prepend(firstOption);
            }
        }
    })
}