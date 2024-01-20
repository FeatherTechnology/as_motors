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
    // $dailyperform1 = "SELECT sc.emp_code, sc.staff_name, dpr.assertion, dpr.target, dpr.actual_achieve, dpr.system_date, dpr.assertion_table_sno FROM daily_performance_ref dpr LEFT JOIN daily_performance dp ON dpr.daily_performance_id = dp.daily_performance_id LEFT JOIN staff_creation sc ON dpr.staff_id = sc.staff_id WHERE dp.department_id ='$dept_name' AND $where AND dpr.manager_updated_status = '1' AND sc.status = '0' order by dpr.system_date ASC";
        $dailyperform1 = "SELECT sc.emp_code, sc.staff_name, dpr.assertion, dpr.target, dpr.actual_achieve, dpr.system_date, dpr.assertion_table_sno FROM daily_performance_ref dpr LEFT JOIN daily_performance dp ON dpr.daily_performance_id = dp.daily_performance_id LEFT JOIN staff_creation sc ON dpr.staff_id = sc.staff_id WHERE dp.department_id ='$dept_name' AND $where AND dpr.manager_updated_status = '1' AND sc.status = '0' GROUP BY dpr.assertion order by dpr.system_date ASC ";

        $res1 = $mysqli->query($dailyperform1) or die("Error in Get All Records" . $mysqli->error);
        $dailyperform_list1 = array();
        $i = 0;

        $actual = 0;
        $fixedtarget = 0;

        if ($mysqli->affected_rows > 0) {
            echo '<table class="table custom-table dpr_staff_report">';
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
                $actual = 0;
                $fixedtarget = 0;

                $dailyperformQry = "SELECT sc.emp_code, sc.staff_name, dc.designation_name, dpr.assertion, dpr.target, dpr.actual_achieve, dpr.system_date, dpr.assertion_table_sno FROM daily_performance_ref dpr LEFT JOIN daily_performance dp ON dpr.daily_performance_id = dp.daily_performance_id LEFT JOIN staff_creation sc ON dpr.staff_id = sc.staff_id JOIN designation_creation dc ON sc.designation = dc.designation_id WHERE dp.department_id ='$dept_name' AND $where AND dpr.manager_updated_status = '1' AND sc.status = '0' AND dpr.assertion = '$row1->assertion' order by dpr.system_date ASC ";
                $dprFetchingData = $mysqli->query($dailyperformQry) or die("Error in Get All Records" . $mysqli->error);
                while($dpr_row = $dprFetchingData->fetch_object()){
                    echo '<tr>';
                    echo '<td>' . $dpr_row->system_date . '</td>';
                    echo '<td>' . $dpr_row->staff_name . '</td>';
                    echo '<td>' . $dpr_row->designation_name . '</td>';
                    echo '<td>' . $dpr_row->assertion . '</td>';
                    echo '<td>' . $dpr_row->target . '</td>';
                    echo '<td>' . $dpr_row->actual_achieve . '</td>';
                    echo '</tr>';
                    
                    $actual = $actual + $dpr_row->actual_achieve;
                    $fixedtarget = $fixedtarget + $dpr_row->target;
                }
                $sumvalue = $fixedtarget - $actual;
                $bal = ($sumvalue < 0) ? "0" : $sumvalue;

                echo '<tr>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td><b>Total</b></td>';
                echo '<td><b>' . $fixedtarget . '</b></td>';
                echo '<td><b>' . $actual . '</b></td>';
                echo '</tr>';
                echo '<tr class="balance">';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td><b>Balance To Do</b></td>';
                echo '<td colspan="2">' . $bal . '</td>';
                echo '</tr>';
   
            }            

            echo '</tbody>';
            echo '</table>';
            echo '</br></br>';
        }else{
            // $sumvalue = $fixedtarget - $actual;
            // $bal = ($sumvalue < 0) ? "0" : $sumvalue;

            echo '<center><span class="recordspn">No Record Found!</span></center>';

            echo '<table class="table custom-table dpr_staff_report">';
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
            echo '</tbody>';
            echo '<tr>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td><b>Total</b></td>';
            echo '<td><b> 0 </b></td>';
            echo '<td><b> 0 </b></td>';
            echo '</tr>';
            echo '<tr class="balance">';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td><b>Balance To Do</b></td>';
            echo '<td colspan="2"> 0 </td>';
            echo '</tr>';
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



    // $(function() {
    //     $('.dpr_staff_report').DataTable({
    //         'processing': true,
    //         'iDisplayLength': 20,
    //         "lengthMenu": [
    //             [10, 25, 50, -1],
    //             [10, 25, 50, "All"]
    //         ],
    //     });
    // });
</script>
