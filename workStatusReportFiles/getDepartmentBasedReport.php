<?php
include '../ajaxconfig.php';
?>

<script src="vendor\ultimate-export\libs\FileSaver\FileSaver.min.js"></script>
<script src="vendor\ultimate-export\libs\js-xlsx\xlsx.core.min.js"></script>
<!-- For IE11 support include polyfills.umd.js before you include jspdf.umd.min.js and html2canvas.min.js -->
<script src="vendor\ultimate-export\libs\jsPDF\polyfills.umd.min.js"></script>
<script src="vendor\ultimate-export\libs\jsPDF\jspdf.umd.min.js"></script>
<script src="vendor\ultimate-export\libs\html2canvas\html2canvas.min.js"></script>

<script src="vendor\ultimate-export\tableExport.min.js"></script>

<style>
    .balance {
        font-weight: bold;
        color: red;
    }

    .recordspn{
        font-weight: bold;
        font-size: 18px;
        color: red;
        text-align: center;
    }
</style>

<button type="button" class="btn btn-danger" id="export_btn" name="export_btn" >Export</button>
<input type="button" name="page_print" id="page_print" class="btn btn-primary print-page " data-id="dpr_staff_report" value="PRINT">

<?php
if(isset($_POST["dept_name"])){
    $dept_name = $_POST["dept_name"];
}
if(isset($_POST["dept_monthwise"])){
    $dept_monthwise = $_POST["dept_monthwise"].'-01';
}
if(isset($_POST["dept_from_date"])){
    $dept_from_date = date('Y-m-d',strtotime($_POST["dept_from_date"]));
}
if(isset($_POST["dept_to_date"])){
    $dept_to_date = date('Y-m-d',strtotime($_POST["dept_to_date"]));
}
    
    // Calculate the number of months between the from and to dates
    $from = new DateTime($dept_from_date);
    $to = new DateTime($dept_to_date);
    $interval = DateInterval::createFromDateString('1 month');
    $period = new DatePeriod($from, $interval, $to);
    if($dept_monthwise != '-01'){
        $where = " dp.month = '$dept_monthwise' ";
        printTable($mysqli, $dept_name, $where, $dept_monthwise);
    }else{
        // Loop through each month
        foreach ($period as $month) {
            $startOfMonth = $month->format('Y-m-01');
            $endOfMonth = $month->format('Y-m-t');
            $where = " (dpr.system_date >= ('$startOfMonth') AND dpr.system_date <= ('$endOfMonth') ) ";
            printTable($mysqli, $dept_name, $where, $startOfMonth);
        }
    }

    function printTable($mysqli, $dept_name, $where, $monthname ){
        $dailyperform1 = "SELECT dpr.assertion, dpr.system_date FROM daily_performance_ref dpr LEFT JOIN daily_performance dp ON dpr.daily_performance_id = dp.daily_performance_id LEFT JOIN staff_creation sc ON dpr.staff_id = sc.staff_id WHERE dp.department_id ='$dept_name' AND $where AND dpr.manager_updated_status = '1' AND sc.status = '0' GROUP BY dpr.assertion order by dpr.system_date ASC ";

        $res1 = $mysqli->query($dailyperform1) or die("Error in Get dailyperform1 Records" . $mysqli->error);

        if ($mysqli->affected_rows > 0) {
            echo '<table class="table custom-table dpr_staff_report" id="dpr_staff_report">';
            echo '<thead>';
            echo '<tr>';
            echo '<th colspan="6">'.date('F',strtotime($monthname)).'</th>';
            echo '</tr>';
            echo '<tr>';
            echo '<th>Date</th>';
            echo '<th>Staff Name</th>';
            echo '<th>Designation</th>';
            echo '<th>Assertion</th>';
            echo '<th>Target</th>';
            echo '<th>Achieve</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row1 = $res1->fetch_object()) {
                $staffidArr = array();
                $actual = 0;

                $dailyperformQry = "SELECT sc.staff_id, sc.staff_name, dc.designation_name, dpr.assertion, dpr.target, GROUP_CONCAT(dpr.actual_achieve) AS actual_achieve_list, SUM(dpr.actual_achieve) AS actual_achieve, dpr.system_date FROM daily_performance_ref dpr LEFT JOIN daily_performance dp ON dpr.daily_performance_id = dp.daily_performance_id LEFT JOIN staff_creation sc ON dpr.staff_id = sc.staff_id JOIN designation_creation dc ON sc.designation = dc.designation_id WHERE dp.department_id ='$dept_name' AND $where AND dpr.manager_updated_status = '1' AND sc.status = '0' AND dpr.assertion = '$row1->assertion' GROUP BY sc.staff_id order by dpr.daily_performance_ref_id ASC ";
                $dprFetchingData = $mysqli->query($dailyperformQry) or die("Error in Get All Records" . $mysqli->error);
                while($dpr_row = $dprFetchingData->fetch_object()){
                    $staffidArr[]= $dpr_row->staff_id;
                    echo '<tr>';
                    echo '<input type="hidden" id="staffid" class="rowstaffid" value="'.$dpr_row->staff_id.'"/>';
                    echo '<td>' . date('d-Y',strtotime($monthname)).'</td>';
                    echo '<td>' . $dpr_row->staff_name . '</td>';
                    echo '<td>' . $dpr_row->designation_name . '</td>';
                    echo '<td>' . $dpr_row->assertion . '</td>';
                    echo '<td>' . $dpr_row->target . '</td>';
                    echo '<td>' . $dpr_row->actual_achieve . '</td>';
                    echo '</tr>';

//To show staff detailed record.
$staffdailyperformQry = "SELECT dpr.system_date, sc.staff_name, dc.designation_name, dpr.assertion, dpr.target, dpr.actual_achieve 
FROM daily_performance_ref dpr 
LEFT JOIN daily_performance dp ON dpr.daily_performance_id = dp.daily_performance_id 
LEFT JOIN staff_creation sc ON dpr.staff_id = sc.staff_id 
JOIN designation_creation dc ON sc.designation = dc.designation_id 
WHERE dp.emp_id ='$dpr_row->staff_id' 
AND dp.month = '$monthname' 
AND dpr.manager_updated_status = '1' 
AND sc.status = '0' 
AND dpr.assertion = '$row1->assertion' 
ORDER BY dpr.daily_performance_ref_id ASC ";

$staffdprFetchingData = $mysqli->query($staffdailyperformQry) or die("Error in Get All Records" . $mysqli->error);

while($staffdpr_row = $staffdprFetchingData->fetch_object()){
    echo '<tr class="hiddenRow_'.$dpr_row->staff_id.'" style="display:none;">';
    echo '<td>' . date('d-m-Y',strtotime($staffdpr_row->system_date)) . '</td>';
    echo '<td>' . $staffdpr_row->staff_name . '</td>';
    echo '<td>' . $staffdpr_row->designation_name . '</td>';
    echo '<td>' . $staffdpr_row->assertion . '</td>';
    echo '<td>' . $staffdpr_row->target . '</td>';
    echo '<td>' . $staffdpr_row->actual_achieve . '</td>';
    echo '</tr>';
}//Third while loop//

$staffgsrFetchingData = $mysqli->query("SELECT (gsr.target / (LENGTH(gsr.staffname) - LENGTH(REPLACE(gsr.staffname, ',', '')) + 1) ) AS perStaffTarget FROM goal_setting_ref gsr WHERE FIND_IN_SET('$dpr_row->staff_id', gsr.staffname) AND gsr.assertion ='$row1->assertion' AND (YEAR(gsr.goal_month) = YEAR('$dpr_row->system_date') AND MONTH(gsr.goal_month) = MONTH('$dpr_row->system_date')) GROUP BY gsr.assertion_table_sno ") or die("Error in Get staffgsrFetchingData Records" . $mysqli->error);
$stafftotal_target_cnt = 0;
while($staffgsr_row = $staffgsrFetchingData->fetch_object()){
$stafftotal_target_cnt = $stafftotal_target_cnt + $staffgsr_row->perStaffTarget;
}

$staffdprActualFetchingData = $mysqli->query("SELECT sum(dpr.actual_achieve) as actual FROM daily_performance_ref dpr LEFT JOIN daily_performance dp ON dpr.daily_performance_id = dp.daily_performance_id WHERE dp.emp_id ='$dpr_row->staff_id' AND dp.month = '$monthname' AND dpr.manager_updated_status = '1' AND dpr.assertion = '$row1->assertion' ORDER BY dpr.system_date ASC ") or die("Error in Get staffdprActualFetchingData Records" . $mysqli->error);
$staffdpr_actualachieve_row = $staffdprActualFetchingData->fetch_object();
$staffactual = $staffdpr_actualachieve_row->actual;

$staffsumvalue = $stafftotal_target_cnt - $staffactual;
$staffbal = ($staffsumvalue < 0) ? "0" : $staffsumvalue;

echo '<tr class="hiddenRow_'.$dpr_row->staff_id.'" style="display:none;">';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '<td><b>Total Target of '. $dpr_row->staff_name.' </b></td>';
echo '<td colspan="2"><b>' . $stafftotal_target_cnt . '</b></td>';
echo '</tr>';
echo '<tr class="hiddenRow_'.$dpr_row->staff_id.'" style="display:none;">';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '<td><b>Total Achieve of '. $dpr_row->staff_name.' </b></td>';
echo '<td colspan="2"><b>' . $staffactual . '</b></td>';
echo '</tr>';
echo '<tr class="balance tdcheck hiddenRow_'.$dpr_row->staff_id.'" style="display:none;">';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '<td><b>Balance To Do by '. $dpr_row->staff_name.' </b></td>';
echo '<td colspan="2"><b>' . $staffbal . '<b></td>';
echo '</tr>';
//To show staff detailed record END.

                }//Second while Loop END.

                $uniquestaffid = array_unique($staffidArr);
                $staffIDArrList = implode(',', $uniquestaffid);
                $gsrFetchingData = $mysqli->query("SELECT * from goal_setting_ref gsr WHERE gsr.staffname IN($staffIDArrList) AND gsr.assertion ='$row1->assertion' AND (YEAR(gsr.goal_month) = YEAR('$row1->system_date') AND MONTH(gsr.goal_month) = MONTH('$row1->system_date')) GROUP BY gsr.assertion_table_sno ") or die("Error in Get gsrFetchingData Records" . $mysqli->error);
                $total_target_cnt = 0;
                while($gsr_row = $gsrFetchingData->fetch_object()){
                    $total_target_cnt = $total_target_cnt + $gsr_row->target;
                }
                
                $dprActualFetchingData = $mysqli->query("SELECT sum(dpr.actual_achieve) as actual FROM daily_performance_ref dpr LEFT JOIN daily_performance dp ON dpr.daily_performance_id = dp.daily_performance_id WHERE dp.department_id ='$dept_name' AND dp.month = '$monthname' AND dpr.manager_updated_status = '1' AND dpr.assertion = '$row1->assertion' order by dpr.system_date ASC ") or die("Error in Get dprActualFetchingData Records" . $mysqli->error);
                $dpr_actualachieve_row = $dprActualFetchingData->fetch_object();
                $actual = $dpr_actualachieve_row->actual;

                $sumvalue = $total_target_cnt - $actual;
                $bal = ($sumvalue < 0) ? "0" : $sumvalue;

                echo '<tr>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td><b>Total Target</b></td>';
                echo '<td colspan="2"><b>' . $total_target_cnt . '</b></td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td><b>Total Achieve</b></td>';
                echo '<td colspan="2"><b>' . $actual . '</b></td>';
                echo '</tr>';
                echo '<tr class="balance">';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td><b>Balance To Do</b></td>';
                echo '<td colspan="2"><b>' . $bal . '</b></td>';
                echo '</tr>';
            }//first while loop end.            

            echo '</tbody>';
            echo '</table>';
            echo '</br></br>';
        }else{

            echo '<center><span class="recordspn">No Record Found!</span></center>';

            echo '<table class="table custom-table dpr_staff_report1">';
            echo '<thead>';
            echo '<tr>';
            echo '<th colspan="6">'.date('F',strtotime($monthname)).'</th>';
            echo '</tr>';
            echo '<tr>';
            echo '<th>Date</th>';
            echo '<th>Staff Name</th>';
            echo '<th>Designation</th>';
            echo '<th>Assertion</th>';
            echo '<th>Target</th>';
            echo '<th>Achieve</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            echo '<tr>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '</tr>';
            echo '</tbody>';
            echo '</table>';
            echo '</br></br>';
        }
    }
?>

<script type="text/javascript">
$('#export_btn').click(function () {
    // Create a new hidden table for export
    var exportTable = $('<table class="export-table"></table>').appendTo('body').hide();
    
    // Clone the header row
    $('.dpr_staff_report thead').clone().appendTo(exportTable);
    
    // Clone each visible row (excluding rows with "display: none")
    $('.dpr_staff_report tbody tr:visible').each(function () {
        $(this).clone().appendTo(exportTable);
    });

    // Apply the tableExport to the hidden table
    exportTable.tableExport();
    
    // Remove the hidden table
    exportTable.remove();
});

// $('#export_btn').click(function(){
//     // To CSV
//     $('.dpr_staff_report').tableExport();
// });

$('.dpr_staff_report tbody tr').click(function(){
    var staffID = $(this).find('.rowstaffid').val();

    if($('.hiddenRow_'+staffID).css('display') == 'none'){
        $('.hiddenRow_'+staffID).show();
        // $('.hiddenTHTD').show();
        
    }else{
        $('.hiddenRow_'+staffID).hide();
    }
    
    // // Count the visible elements with class 'hiddenTHTD'
    // var visibleCount = $('.tdcheck:visible').length;
    // // If the visible count is greater than 0, show all elements with class 'hiddenTHTD'
    // if (visibleCount > 0) {
    //     $('.hiddenTHTD').show();
    // } else {
    //     // Otherwise, hide all elements with class 'hiddenTHTD'
    //     $('.hiddenTHTD').hide();
    // }
});

$('.print-page').click(function (e){
    e.preventDefault();

    const tableId = $(this).data('id');
    const table = document.getElementById(tableId);

    if (table) {
            title = 'Daily Performance Report';

        // Clone the table to avoid modifying the original table
        const tableClone = table.cloneNode(true);
    
        // Create a new window to print the modified table
        const newWindow = window.open('', '_blank');
        newWindow.document.write('<html><head><title>Print Table</title></head><body>');
        newWindow.document.write('<h4> '+ title + '</h4>');
        newWindow.document.write('<style>');
        newWindow.document.write('  table { border-collapse: collapse; width: 100%; }');
        newWindow.document.write('  td, th { border: 1px solid black; padding: 8px; }');
        newWindow.document.write('  @page { margin: 0.5in; }'); // Adjust the margin as needed
        newWindow.document.write('</style>');
        // newWindow.document.write('<style>table { border-collapse: collapse; } td, th { border: 1px solid black; padding: 8px; }</style>');
        newWindow.document.write(tableClone.outerHTML);
        newWindow.document.write('</body></html>');
        newWindow.document.close();
    
        // Wait for a small delay to allow the table to be rendered in the new window
        setTimeout(function() {
        newWindow.print();
        newWindow.close();
        }, 1000); // Adjust the delay time as needed
    } else {
        console.error('Table not found.');
    }
}); //Print END///

</script>
