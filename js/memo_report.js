$(document).ready(function(){ //Document Ready Start.

    $('#memo_report_type').change(function(){ //Onchange based on type select for report.
        var typeValue = $(this).val();

        if(typeValue == '2'){
            $('#branch_report').show();
            getBranchList()

        } else{
            $('#branch_report').hide();

        }

        clearValueforAll(); //Clear all value when change type.

    });//memo_report_type END.

    $('#view_report').click(function(){ //view report in the table.
        var reportType = $('#memo_report_type').val();

        if(reportType =='1'){//OverAll.

            $('.validate').hide();
            getOverAllReport();//OverAll report ajax.

        }else if(reportType =='2'){//Branch.
            var branch_name = $('#branch_name').val();
            // var from_date = $('#dailyKM_from_date').val();
            // var to_date   = $('#dailyKM_to_date').val();

            if(branch_name != ''){
                $('.validate').hide();
                branchBasedReports(branch_name); //To show Branch based report.
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

}); //Document Ready End.


function getBranchList() {
    $.ajax({
        url : "ajaxFetch/ajaxGetAllBranchList.php",
        type: "POST",
        dataType: 'json',
        cache: false,
        success: function(response){
            
            var len = response.length;
            $('#branch_name').empty();
            $('#branch_name').append("<option value=''>" + 'Select Branch Name' + "</option>");
            for (var i = 0; i < len; i++) {
                var branch_id = response[i]['branch_id'];
                var branch_name = response[i]['branch_name'];
                $('#branch_name').append("<option value='" + branch_id + "'>" + branch_name +"</option>");
            }
            {//To Order ag_group Alphabetically
                var firstOption = $('#branch_name'+" option:first-child");
                $('#branch_name').html($('#branch_name'+" option:not(:first-child)").sort(function (a, b) {
                    return a.text == b.text ? 0 : a.text < b.text ? -1 : 1;
                }));
                $('#branch_name').prepend(firstOption);
            }
        }
    })
}

function getOverAllReport(){

    $.ajax({
        type: "POST",
        data: {},
        url: "reports/memo_reports/getMemoOverallReport.php",
        cache: false,
        success: function(response){

            $("#memo_report_view_table").empty();
            $("#memo_report_view_table").html(response);
        }
    })//Report ajax END.
}

function branchBasedReports(branch_id){

    $.ajax({
        type: "POST",
        data: {"branch_id": branch_id },
        url: "reports/memo_reports/getMemoBranchBasedReport.php",
        cache: false,
        success: function(response){

            $("#memo_report_view_table").empty();
            $("#memo_report_view_table").html(response);
        }
    })//Report ajax END.
}

function tableEmpty(){
    $("#memo_report_view_table").empty(); //if validation false then table will empty.
}

//Clear value when change type.
function clearValueforAll(){
    $('.clearvalue').val('');
}