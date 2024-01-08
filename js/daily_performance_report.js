$(document).ready(function(){ //Document Ready Start.

    var userrole = $('#user_role').val();

    $('#report_type').change(function(){ //Onchange based on type select for report.
        var typeValue = $(this).val();

        if(typeValue == '1'){
            $('#staff_report').show();
            $('#dept_report').hide();
            $('#overall_report').hide();

            if(userrole == 3){
                var deptid = $('#user_dept_id').val();
                getDeptStaffNameList(deptid, 'staff_name');
            }else{
                getStaffList();//To show staff List.
            }

        }else if(typeValue == '2'){
            $('#staff_report').hide();
            $('#dept_report').show();
            $('#overall_report').hide();

            setTimeout(() => {
                if(userrole == 3){
                    $('#dept_type').val('1');
                    $('#dept_type').attr('disabled', true);
                    $('#dept_name_report').show();
                    $('#dept_staff_report').hide();
                    
                    getDepartmentList('dept_name');//To show Department List.
                    $('#dept_name').attr('disabled', true);
                }
                
            }, 500);

        }else if(typeValue == '3'){
            $('#staff_report').hide();
            $('#dept_report').hide();
            $('#overall_report').show();

        }else{
            $('#staff_report').hide();
            $('#dept_report').hide();
            $('#overall_report').hide();

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
        getDeptStaffNameList(dep_id, 'dept_staff_name');

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
            var staff_monthwise = $('#staff_monthwise').val();
            var staff_from_date = $('#staff_from_date').val();
            var staff_to_date = $('#staff_to_date').val();

            if(staffid != '' && (staff_monthwise != '' || (staff_from_date != '' && staff_to_date != '')) ){ //validation if all field enter then only call ajax.
                getStaffNameReport(staffid,staff_monthwise,staff_from_date,staff_to_date);//staffname based report ajax.
                $('.validate').hide();
            }else{
                $('.validate').show();
                tableEmpty();
            }

        }else if(reportType =='2'){//department.

            if(departmentType =='1'){ //department only.
                var dept_name = $('#dept_name').val();
                var dept_monthwise = $('#dept_monthwise').val();
                var dept_from_date = $('#dept_from_date').val();
                var dept_to_date = $('#dept_to_date').val();

                if(dept_name != '' && (dept_monthwise != '' || (dept_from_date != '' && dept_to_date != '')) ){ //validation if all field enter then only call ajax.
                    departmentBasedReports(dept_name,dept_monthwise,dept_from_date,dept_to_date); //To show department based report.
                    $('.validate').hide();
                }else{
                    $('.validate').show();
                    tableEmpty();
                }

            }else if(departmentType =='2'){//department staff.
                var dep_name = $('#dep_name').val();
                var dept_staff_id = $('#dept_staff_name').val();
                var dept_staff_monthwise = $('#dept_staff_monthwise').val();
                var dept_staff_from_date = $('#dept_staff_from_date').val();
                var dept_staff_to_date = $('#dept_staff_to_date').val();
                
                if(dep_name != '' && dept_staff_id != '' && (dept_staff_monthwise != '' || (dept_staff_from_date != '' && dept_staff_to_date != '')) ){ //validation if all field enter then only call ajax.
                    getStaffNameReport(dept_staff_id,dept_staff_monthwise,dept_staff_from_date,dept_staff_to_date);//staffname based report ajax.
                    $('.validate').hide();
                }else{
                    $('.validate').show();
                    tableEmpty();
                }
                
            }

        }else if(reportType =='3'){ //Overall.
            var monthwise = $('#monthwise').val();
            var overall_from_date = $('#overall_from_date').val();
            var overall_to_date = $('#overall_to_date').val();

            if((monthwise != '') || (overall_from_date != '' && overall_to_date != '' ) ){ //validation if all field enter then only call ajax.
                getTaskReport(monthwise,overall_from_date,overall_to_date);//Overall based report ajax.
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

    $('.clearMonth').change(function(){ //when change Month then empty from and to date.
        dateEmpty('0');
    });
    $('.clearFrom, .clearTo').change(function(){ //when change from, to date then empty month.
        dateEmpty('1');
    });

}); //Document Ready End.

//On Load Function
$(function(){

    var role = $('#user_role').val();

    if(role == 4){
        $('#report_type').val('1');
        $('#report_type').attr('disabled', true);
        $('#staff_report').show();
        $('#dept_report').hide();
        $('#overall_report').hide();

        getStaffList();//To show staff List.
        $('#staff_name').attr('disabled', true);
    }

    if(role == 3){
        $('#report_type option:last').prop('disabled', true);
        $('#dept_type option:last').prop('disabled', true);
    }
});

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
            var userStaffId = $('#user_staff_id').val();
            for (var i = 0; i < len; i++) {
                var staff_name = result['staff_name'][i];
                var staff_id = result['staff_id'][i];
                var emp_code = result['emp_code'][i];
                var designation_name = result['designation_name'][i];
                var selected = '';
                if(userStaffId == staff_id){
                    selected = 'selected';
                }
                $("#staff_name").append("<option value='" + staff_id + "' "+ selected + ">" + staff_name +" -  ("+ designation_name + ")"+ "</option>");
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
                var branch_name = response[i]['branch_name'];

                var selected = '';
                var userDepartmentId = $('#user_dept_id').val();
                if(userDepartmentId == department_id){
                    selected = 'selected';
                }
                $('#'+id).append("<option value='" + department_id + "' " +selected+ ">" + department_name +' -  ('+branch_name + ')' +"</option>");
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

function getStaffNameReport(staffid,staff_monthwise,staff_from_date,staff_to_date){

    $.ajax({
        type: "POST",
        data: {"staffid": staffid, "staff_monthwise": staff_monthwise,"staff_from_date": staff_from_date, "staff_to_date": staff_to_date},
        url: "workStatusReportFiles/getstaffnameReport.php",
        cache: false,
        success: function(response){

            $("#report_view_table").empty();
            $("#report_view_table").html(response);
        }
    })//Report ajax END.
}

function departmentBasedReports(dept_name,dept_monthwise,dept_from_date,dept_to_date){

    $.ajax({
        type: "POST",
        data: {"dept_name": dept_name, "dept_monthwise": dept_monthwise, "dept_from_date": dept_from_date, "dept_to_date": dept_to_date},
        url: "workStatusReportFiles/getDepartmentBasedReport.php",
        cache: false,
        success: function(response){

            $("#report_view_table").empty();
            $("#report_view_table").html(response);
        }
    })//Report ajax END.
}

function getTaskReport(monthwise,overall_from_date,overall_to_date){
    
    $.ajax({
        type: "POST",
        data: {"monthwise": monthwise, "overall_from_date": overall_from_date, "overall_to_date": overall_to_date},
        url: "workStatusReportFiles/getOverallReport.php",
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

function dateEmpty(v){
    if(v == '0'){
        $('.clearFrom').val('');
        $('.clearTo').val('');

    }else if(v == '1'){
        $('.clearMonth').val('');

    }
}

function getDeptStaffNameList(dep_id, id){
    $.ajax({
        type: "POST",
        data: {"department_id": dep_id},
        url: "StaffFile/getDeptBasedStaffDetails.php",
        dataType: "json",
        cache: false,
        success: function(response){

            $("#"+id).empty();
            $("#"+id).append("<option value=''>" + 'Select Staff Name' + "</option>");
            var len = response.length;
            for (var i = 0; i < len; i++) {
                var staff_id = response[i]['staff_id'];
                var staff_name = response[i]['staff_name'];
                var emp_code = response[i]['emp_code'];
                var designation_name = response[i]['designation_name'];
                $("#"+id).append("<option value='" + staff_id + "'>" + staff_name + " - ("+ designation_name +")" +"</option>");
            }
            {//To Order staffName Alphabetically
                var firstOption = $("#"+id+" option:first-child");
                $("#"+id).html($("#"+id+" option:not(:first-child)").sort(function (a, b) {
                    return a.text == b.text ? 0 : a.text < b.text ? -1 : 1;
                }));
                $("#"+id).prepend(firstOption);
            }
        }
    })//ajax END.
}