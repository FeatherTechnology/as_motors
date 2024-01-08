<?php
include '../ajaxconfig.php';
?>

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
        $dailyperform1 = "SELECT dpr.assertion, dpr.target, dpr.actual_achieve, dpr.system_date, dpr.assertion_table_sno FROM daily_performance_ref dpr LEFT JOIN daily_performance dp ON dpr.daily_performance_id = dp.daily_performance_id WHERE dp.emp_id ='$staffid' AND $where AND dpr.manager_updated_status = '1' GROUP BY dpr.assertion order by dpr.system_date ASC";

        $res1 = $mysqli->query($dailyperform1) or die("Error in Get All Records" . $mysqli->error);
        $dailyperform_list1 = array();

        if ($mysqli->affected_rows > 0) {
            echo '<table class="table custom-table" id="dpr_staff_report">';
            echo '<thead>';
            echo '<tr>';
            echo '<th colspan="4">'.date('F',strtotime($monthname)).'</th>';
            echo '</tr>';
            echo '</thead>';
            // echo '<thead>';
            echo '<tr>';
            echo '<th>Date</th>';
            echo '<th>Assertion</th>';
            echo '<th>Target</th>';
            echo '<th>Achieve</th>';
            echo '</tr>';
            // echo '</thead>';
            echo '<tbody>';
            
            while ($row1 = $res1->fetch_object()) {
                $actual = 0;
                $fixedtarget = 0;

                $dailyperformQry = "SELECT dpr.assertion, dpr.target, dpr.actual_achieve, dpr.system_date, dpr.assertion_table_sno FROM daily_performance_ref dpr LEFT JOIN daily_performance dp ON dpr.daily_performance_id = dp.daily_performance_id WHERE dp.emp_id ='$staffid' AND $where AND dpr.manager_updated_status = '1' AND dpr.assertion = '$row1->assertion' order by dpr.system_date ASC ";
                $dprFetchingData = $mysqli->query($dailyperformQry) or die("Error in Get All Records" . $mysqli->error);
                while($dpr_row = $dprFetchingData->fetch_object()){
                echo '<tr>';
                echo '<td>' . $dpr_row->system_date . '</td>';
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
            echo '<td><b>Total</b></td>';
            echo '<td><b>' . $fixedtarget . '</b></td>';
            echo '<td><b>' . $actual . '</b></td>';
            echo '</tr>';
            echo '<tr class="balance">';
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

            echo '<table class="table custom-table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th colspan="4">'.date('F',strtotime($monthname)).'</th>';
            echo '</tr>';
            echo '</thead>';
            // echo '<thead>';
            echo '<tr>';
            echo '<th>Date</th>';
            echo '<th>Assertion</th>';
            echo '<th>Target</th>';
            echo '<th>Achieve</th>';
            echo '</tr>';
            // echo '</thead>';
            echo '<tbody>';
            echo '<tr>';
            echo '<td></td>';
            echo '<td><b>Total</b></td>';
            echo '<td><b> 0 </b></td>';
            echo '<td><b> 0 </b></td>';
            echo '</tr>';
            echo '<tr class="balance">';
            echo '<td></td>';
            echo '<td><b>Balance To Do</b></td>';
            echo '<td colspan="2"> 0 </td>';
            echo '</tr>';
            echo '</tbody>';
            echo '</table>';
            echo '</br></br>';
        }
    }
?>

<script type="text/javascript">
    $(function() {
        // Remove colspans
    //   $('#dpr_staff_report tr').each(function() {
    //       var cols = $(this).find('td[colspan]');
    //       if (cols.length > 0) {
    //           var colspan = cols.attr('colspan');
    //           cols.removeAttr('colspan');
    //           for (var i = 1; i < colspan; i++) {
    //               cols.eq(0).clone().insertAfter(cols.eq(0));
    //             }
    //         }
    //     });

      // Initialize DataTable
        $('#dpr_staff_report').DataTable({
            'processing': true,
            'iDisplayLength': 20,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3 ]
                    }
                }
            ],
        });
    });
</script>
