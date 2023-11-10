$(document).ready(function(){ //Document Ready Start.

    $('#krakpi_report_type').change(function(){ //Onchange based on type select for report.
        var typeValue = $(this).val();

        if(typeValue == '2'){
            $('#designation_report').show();
            getDepartmentList()

        } else{
            $('#designation_report').hide();

        }

        clearValueforAll(); //Clear all value when change type.

    });//krakpi_report_type END.

    $('#view_report').click(function(){ //view report in the table.
        var reportType = $('#krakpi_report_type').val();

        if(reportType =='1'){//OverAll.

            $('.validate').hide();
            getOverAllReport();//OverAll report ajax.

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


function getDepartmentList() {
        $.ajax({
            url : "departmentFile/getAllDepartmentDetails.php",
            type: "POST",
            dataType: 'json',
            cache: false,
            success: function(response){
                
                var len = response.length;
                $('#dept_name').empty();
                $('#dept_name').append("<option value=''>" + 'Select Department' + "</option>");
                for (var i = 0; i < len; i++) {
                    var department_name = response[i]['department_name'];
                    var department_id = response[i]['department_id'];
                    var branch_name = response[i]['branch_name'];
                    $('#dept_name').append("<option value='" + department_id + "'>" + department_name +' -  '+branch_name +"</option>");
                }
                {//To Order ag_group Alphabetically
                    var firstOption = $('#dept_name'+" option:first-child");
                    $('#dept_name').html($('#dept_name'+" option:not(:first-child)").sort(function (a, b) {
                        return a.text == b.text ? 0 : a.text < b.text ? -1 : 1;
                    }));
                    $('#dept_name').prepend(firstOption);
                }
            }
        })
    }

function getOverAllReport(){

    $.ajax({
        type: "POST",
        data: {},
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