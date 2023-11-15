$(document).ready(function(){ //Document Ready Start.

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
        
        clearValueforAll(); //Clear all value when change type.

    });//krakpi_report_type END.

    $('#view_report').click(function(){ //view report in the table.
        var reportType = $('#krakpi_report_type').val();

        if(reportType =='1'){//OverAll.

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
        $.ajax({
            url : "R&RFile/ajaxR&RDesignationDetails.php",
            type: "POST",
            data:{'department_id': deptName},
            dataType: 'json',
            cache: false,
            success: function(response){
                
                $('#designation_name').empty();
                $('#designation_name').prepend("<option value=''>" + 'Select Designation' + "</option>");
                for (i = 0; i <= response.designation_id.length - 1; i++) { 
                    $('#designation_name').append("<option value='" + response['designation_id'][i] + "' >" + response['designation_name'][i] + "</option>");
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
        
    })

}); //Document Ready End.


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
                for (var i = 0; i < len; i++) {
                    var department_name = response[i]['department_name'];
                    var department_id = response[i]['department_id'];
                    var branch_name = response[i]['branch_name'];
                    $('#'+id).append("<option value='" + department_id + "'>" + department_name +' -  '+branch_name +"</option>");
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