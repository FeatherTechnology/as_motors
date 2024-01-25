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
if(isset($_POST["staffid"])){
    $staffid = $_POST["staffid"];
}
if(isset($_POST["staff_monthwise"])){
    $staff_monthwise = $_POST["staff_monthwise"].'-01';
}
if(isset($_POST["staff_from_date"])){
    $staff_from_date = date('Y-m-d',strtotime($_POST["staff_from_date"]));
}
if(isset($_POST["staff_to_date"])){
    $staff_to_date = date('Y-m-d',strtotime($_POST["staff_to_date"]));
}
    
    // Calculate the number of months between the from and to dates
    $from = new DateTime($staff_from_date);
    $to = new DateTime($staff_to_date);
    $interval = DateInterval::createFromDateString('1 month');
    $period = new DatePeriod($from, $interval, $to);
    if($staff_monthwise != '-01'){
        $where = " dp.month = '$staff_monthwise' ";
        printTable($mysqli, $staffid, $where, $staff_monthwise);
    }else{
        // Loop through each month
        foreach ($period as $month) {
            $startOfMonth = $month->format('Y-m-01');
            $endOfMonth = $month->format('Y-m-t');
            $where = " (dpr.system_date >= ('$startOfMonth') AND dpr.system_date <= ('$endOfMonth') ) ";
            printTable($mysqli, $staffid, $where, $startOfMonth);
        }
    }

function printTable($mysqli, $staffid, $where, $monthname ){
        $dailyperform1 = "SELECT dpr.assertion, dpr.system_date FROM daily_performance_ref dpr LEFT JOIN daily_performance dp ON dpr.daily_performance_id = dp.daily_performance_id WHERE dp.emp_id ='$staffid' AND $where AND dpr.manager_updated_status = '1' GROUP BY dpr.assertion order by dpr.system_date ASC";

        $res1 = $mysqli->query($dailyperform1) or die("Error in Get All Records" . $mysqli->error);

        if ($mysqli->affected_rows > 0) {
            echo '<table class="table custom-table dpr_staff_report" id="dpr_staff_report">';
            echo '<thead>';
            echo '<tr>';
            echo '<th colspan="5">'.date('F',strtotime($monthname)).'</th>';
            echo '</tr>';
            echo '<tr>';
            echo '<th>Date</th>';
            echo '<th>Staff Name</th>';
            echo '<th>Assertion</th>';
            echo '<th>Target</th>';
            echo '<th>Achieve</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            
            while ($row1 = $res1->fetch_object()) {
                $actual = 0;

                $dailyperformQry = "SELECT sc.staff_name, dpr.assertion, dpr.target, dpr.actual_achieve, dpr.system_date, dpr.assertion_table_sno FROM daily_performance_ref dpr LEFT JOIN daily_performance dp ON dpr.daily_performance_id = dp.daily_performance_id LEFT JOIN staff_creation sc ON dpr.staff_id = sc.staff_id WHERE dp.emp_id ='$staffid' AND $where AND dpr.manager_updated_status = '1' AND dpr.assertion = '$row1->assertion' order by dpr.system_date ASC ";
                $dprFetchingData = $mysqli->query($dailyperformQry) or die("Error in Get All Records" . $mysqli->error);
                while($dpr_row = $dprFetchingData->fetch_object()){
                echo '<tr>';
                echo '<td>' . $dpr_row->system_date . '</td>';
                echo '<td>' . $dpr_row->staff_name . '</td>';
                echo '<td>' . $dpr_row->assertion . '</td>';
                echo '<td>' . $dpr_row->target . '</td>';
                echo '<td>' . $dpr_row->actual_achieve . '</td>';
                echo '</tr>';
            
                $actual = $actual + $dpr_row->actual_achieve;
            } //Second while loop//

            $gsrFetchingData = $mysqli->query("SELECT (gsr.target / (LENGTH(gsr.staffname) - LENGTH(REPLACE(gsr.staffname,',','')) + 1) ) as target from goal_setting_ref gsr WHERE FIND_IN_SET('$staffid', gsr.staffname) AND gsr.assertion ='$row1->assertion' AND (YEAR(gsr.goal_month) = YEAR('$row1->system_date') AND MONTH(gsr.goal_month) = MONTH('$row1->system_date')) GROUP BY gsr.assertion_table_sno ") or die("Error in Get gsrFetchingData Records" . $mysqli->error);
            $total_target_cnt = 0;
            while($gsr_row = $gsrFetchingData->fetch_object()){
                $total_target_cnt = $total_target_cnt + $gsr_row->target;
            }//Getting total target while loop///

            $sumvalue = $total_target_cnt - $actual;
            $bal = ($sumvalue < 0) ? "0" : $sumvalue;

            echo '<tr>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td><b>Total Target</b></td>';
            echo '<td colspan="2"><b>' . $total_target_cnt . '</b></td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td><b>Total Achieve</b></td>';
            echo '<td colspan="2"><b>' . $actual . '</b></td>';
            echo '</tr>';
            echo '<tr class="balance">';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td><b>Balance To Do</b></td>';
            echo '<td colspan="2"><b>' . $bal . '</b></td>';
            echo '</tr>';

        } //First Loop///

            echo '</tbody>';
            echo '</table>';
            echo '</br></br>';
        }else{

            echo '<center><span class="recordspn">No Record Found!</span></center>';

            echo '<table class="table custom-table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th colspan="5">'.date('F',strtotime($monthname)).'</th>';
            echo '</tr>';
            echo '<tr>';
            echo '<th>Date</th>';
            echo '<th>Staff Name</th>';
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
            echo '</tr>';
            echo '</tbody>';
            echo '</table>';
            echo '</br></br>';
        }
    }
?>

<script type="text/javascript">

    $('#export_btn').click(function(){
        // To CSV
        $('.dpr_staff_report').tableExport();
    });

    $('.print-page').click(function (e) {
    e.preventDefault();

    const tableClass = $(this).data('id');
    const tables = document.getElementsByClassName(tableClass);

    if (tables.length > 0) {
        title = 'Daily Performance Report';

        // Create a new window to print the modified tables
        const newWindow = window.open('', '_blank');
        newWindow.document.write('<html><head><title>Print Tables</title></head><body>');
        newWindow.document.write('<h4>' + title + '</h4>');
        newWindow.document.write('<style>');
        newWindow.document.write('  table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }');
        newWindow.document.write('  td, th { border: 1px solid black; padding: 8px; }');
        newWindow.document.write('  @page { margin: 0.5in; }'); // Adjust the margin as needed
        newWindow.document.write('</style>');

        // Loop through each table and clone it for printing
        for (let i = 0; i < tables.length; i++) {
            const tableClone = tables[i].cloneNode(true);
            newWindow.document.write(tableClone.outerHTML);
        }

        newWindow.document.write('</body></html>');
        newWindow.document.close();

        // Wait for a small delay to allow the tables to be rendered in the new window
        setTimeout(function () {
            newWindow.print();
            newWindow.close();
        }, 1000); // Adjust the delay time as needed
    } else {
        console.error('Tables not found.');
    }
    });

</script>
