$(document).ready(function(){ //Document Ready Start.

    $('#report_type').change(function(){ //Onchange based on type select for report.
        var typeValue = $(this).val();

        if(typeValue == '1'){
            $('#staff_report').show();
            $('#dept_report').hide();
            $('#task_report').hide();
            $('#work_sts_report').hide();

            getStaffList();//To show staff List.

        }else if(typeValue == '2'){
            $('#staff_report').hide();
            $('#dept_report').show();
            $('#task_report').hide();
            $('#work_sts_report').hide();

        }else if(typeValue == '3'){
            $('#staff_report').hide();
            $('#dept_report').hide();
            $('#task_report').show();
            $('#work_sts_report').hide();

        }else if(typeValue == '4'){
            $('#staff_report').hide();
            $('#dept_report').hide();
            $('#task_report').hide();
            $('#work_sts_report').show();

            getDepartmentList('wrk_dept_name');//To show Department List.

        }else{
            $('#staff_report').hide();
            $('#dept_report').hide();
            $('#task_report').hide();
            $('#work_sts_report').hide();

        }

        clearValueforAll(); //Clear all value when change type.

    });//report_type END.

    $('#dept_type').change(function(){
        var deptType = $(this).val();

        if(deptType == '1'){
            $('#dept_name_report').show();
            $('#dept_staff_report').hide();

            getDepartmentList('dept_name');//To show Department List.
            
        }else if(deptType == '2'){
            $('#dept_name_report').hide();
            $('#dept_staff_report').show();
            
            getDepartmentList('dep_name');//To show Department List.

        }else{
            $('#dept_name_report').hide();
            $('#dept_staff_report').hide();

        }

    });//dept_type END.

    $('#dep_name').change(function(){
        var dep_id = $(this).val();
        $.ajax({
            type: "POST",
            data: {"department_id": dep_id},
            url: "StaffFile/getDeptBasedStaffDetails.php",
            dataType: "json",
            cache: false,
            success: function(response){

                $("#dept_staff_name").empty();
                $("#dept_staff_name").append("<option value=''>" + 'Select Staff Name' + "</option>");
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    var staff_id = response[i]['staff_id'];
                    var staff_name = response[i]['staff_name'];
                    var emp_code = response[i]['emp_code'];
                    $("#dept_staff_name").append("<option value='" + staff_id + "'>" + staff_name + " - "+ emp_code +"</option>");
                }
                {//To Order staffName Alphabetically
                    var firstOption = $("#dept_staff_name option:first-child");
                    $("#dept_staff_name").html($("#dept_staff_name option:not(:first-child)").sort(function (a, b) {
                        return a.text == b.text ? 0 : a.text < b.text ? -1 : 1;
                    }));
                    $("#dept_staff_name").prepend(firstOption);
                }
            }
        })//ajax END.

    });//staff list based on dep_name END. 

    //set To date is greater than from date
    $('.validateToDate').change(function(){
        var fromdate = $(this).val();
        // Set Minimum date
        $('.setvaltodate').attr("min", fromdate);
    });

    $('#view_report').click(function(){ //view report in the table.
        var reportType = $('#report_type').val();
        var departmentType = $('#dept_type').val();

        if(reportType =='1'){//staff.
            var staffid = $('#staff_name').val();
            var staff_from_date = $('#staff_from_date').val();
            var staff_to_date = $('#staff_to_date').val();

            if(staffid != '' && staff_from_date != '' && staff_to_date != ''){ //validation if all field enter then only call ajax.
                getStaffNameReport(staffid,staff_from_date,staff_to_date);//staffname based report ajax.
                $('.validate').hide();
            }else{
                $('.validate').show();
                tableEmpty();
            }

        }else if(reportType =='2'){//department.

            if(departmentType =='1'){ //department only.
                var dept_name = $('#dept_name').val();
                var dept_from_date = $('#dept_from_date').val();
                var dept_to_date = $('#dept_to_date').val();

                if(dept_name != '' && dept_from_date != '' && dept_to_date != ''){ //validation if all field enter then only call ajax.
                    departmentBasedReports(dept_name,dept_from_date,dept_to_date); //To show department based report.
                    $('.validate').hide();
                }else{
                    $('.validate').show();
                    tableEmpty();
                }

            }else if(departmentType =='2'){//department staff.
                var dep_name = $('#dep_name').val();
                var dept_staff_id = $('#dept_staff_name').val();
                var dept_staff_from_date = $('#dept_staff_from_date').val();
                var dept_staff_to_date = $('#dept_staff_to_date').val();
                
                if(dep_name != '' && dept_staff_id != '' && dept_staff_from_date != '' && dept_staff_to_date != ''){ //validation if all field enter then only call ajax.
                    getStaffNameReport(dept_staff_id,dept_staff_from_date,dept_staff_to_date);//staffname based report ajax.
                    $('.validate').hide();
                }else{
                    $('.validate').show();
                    tableEmpty();
                }
                
            }

        }else if(reportType =='3'){ //Task.
            var task_name = $('#task_name').val();

            if(task_name != ''){ //validation if all field enter then only call ajax.
                getTaskReport(task_name);//Task based report ajax.
                $('.validate').hide();
            }else{
                $('.validate').show();
                tableEmpty();
            }

        }else if(reportType =='4'){//Work status.
            var work_status = $('#work_status').val();
            var wrk_dept_id = $('#wrk_dept_name').val();
            var work_from_date = $('#work_from_date').val();
            var work_to_date = $('#work_to_date').val();
            
            if(work_status != '' && wrk_dept_id != '' && work_from_date != '' && work_to_date != ''){ //validation if all field enter then only call ajax.
                getWorkStatusDeptReport(work_status,wrk_dept_id,work_from_date,work_to_date);//work status, department based report ajax.
                $('.validate').hide();
            }else{
                $('.validate').show();
                tableEmpty();
            }

        }
    }); //view_report END.

    $('.clearvalue, .emptyTable').change(function(){ //when change any value then empty the table.
        tableEmpty();
    });

}); //Document Ready End.


function getStaffList() {

    $.ajax({
        type: "POST",
        url : "permissionOrOnDutyFile/getAllStaffList.php",
        dataType: 'json',
        cache: false,
        success: function(result){
            
            $("#staff_name").empty();
            $("#staff_name").append("<option value=''>" + 'Select Staff Name' + "</option>");
            var len = result['staff_name'].length;
            for (var i = 0; i < len; i++) {
                var staff_name = result['staff_name'][i];
                var staff_id = result['staff_id'][i];
                var emp_code = result['emp_code'][i];
                $("#staff_name").append("<option value='" + staff_id + "'>" + staff_name +" - "+ emp_code + "</option>");
            }
            {//To Order staffName Alphabetically
                var firstOption = $("#staff_name option:first-child");
                $("#staff_name").html($("#staff_name option:not(:first-child)").sort(function (a, b) {
                    return a.text == b.text ? 0 : a.text < b.text ? -1 : 1;
                }));
                $("#staff_name").prepend(firstOption);
            }
        }
    })
}

function getDepartmentList(id) {
//id  -is selectbox field id, becuz multiple field want all department list so passing id from. 
    $.ajax({
        url : "departmentFile/getAllDepartmentDetails.php",
        type: "POST",
        dataType: 'json',
        cache: false,
        success: function(response){
            
            var len = response.length;
            $('#'+id).empty();
            $('#'+id).append("<option value=''>" + 'Select Department' + "</option>");
            for (var i = 0; i < len; i++) {
                var department_name = response[i]['department_name'];
                var department_id = response[i]['department_id'];
                $('#'+id).append("<option value='" + department_id + "'>" + department_name + "</option>");
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

function getStaffNameReport(staffid,staff_from_date,staff_to_date){

    $.ajax({
        type: "POST",
        data: {"staffid": staffid, "staff_from_date": staff_from_date, "staff_to_date": staff_to_date},
        url: "workStatusReportFiles/staffNameReport.php",
        cache: false,
        success: function(response){

            $("#report_view_table").empty();
            $("#report_view_table").html(response);
        }
    })//Report ajax END.
}

function departmentBasedReports(dept_name,dept_from_date,dept_to_date){

    $.ajax({
        type: "POST",
        data: {"dept_name": dept_name, "dept_from_date": dept_from_date, "dept_to_date": dept_to_date},
        url: "workStatusReportFiles/departmentBasedReport.php",
        cache: false,
        success: function(response){

            $("#report_view_table").empty();
            $("#report_view_table").html(response);
        }
    })//Report ajax END.
}

function getTaskReport(task_name){
    
    $.ajax({
        type: "POST",
        data: {"task_name": task_name},
        url: "workStatusReportFiles/taskNameReport.php",
        cache: false,
        success: function(response){
            
            $("#report_view_table").empty();
            $("#report_view_table").html(response);
        }
    })//Report ajax END.
}

function getWorkStatusDeptReport(work_status,wrk_dept_id,work_from_date,work_to_date){

    $.ajax({
        type: "POST",
        data: {"work_status": work_status, "wrk_dept_id": wrk_dept_id, "work_from_date": work_from_date, "work_to_date": work_to_date},
        url: "workStatusReportFiles/workStatusDeptReport.php",
        cache: false,
        success: function(response){

            $("#report_view_table").empty();
            $("#report_view_table").html(response);
        }
    })//Report ajax END.
}

function tableEmpty(){
    $("#report_view_table").empty(); //if validation false then table will empty.
}

//Clear value when change type.
function clearValueforAll(){
    $('.clearvalue').val('');
}