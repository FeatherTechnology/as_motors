<?php
include '../ajaxconfig.php';
?>

<style>
    .balance{
        font-weight: bold;
        color: red;
    }
</style>
<table class="table custom-table" id="dpr_staff_report">
    <thead>
        <tr>
            <th>Date</th>
            <th>Assertion</th>
            <th>Target</th>
            <th>Achieve</th>
        </tr>
    </thead>
    <tbody>

<?php
if(isset($_POST["monthwise"])){
    $monthwise = $_POST["monthwise"];
}
if(isset($_POST["overall_from_date"])){
    $overall_from_date = date('Y-m-d',strtotime($_POST["overall_from_date"]));
}
if(isset($_POST["overall_to_date"])){
    $overall_to_date = date('Y-m-d',strtotime($_POST["overall_to_date"]));
}

if($monthwise != ''){
    $dailyperform1 = "SELECT dpr.assertion, dpr.target, dpr.actual_achieve, dpr.system_date, dpr.assertion_table_sno FROM daily_performance_ref dpr LEFT JOIN daily_performance dp ON dpr.daily_performance_id = dp.daily_performance_id WHERE dp.month = '$monthwise' order by dpr.system_date ASC";

}else{
    $dailyperform1 = "SELECT dpr.assertion, dpr.target, dpr.actual_achieve, dpr.system_date, dpr.assertion_table_sno FROM daily_performance_ref dpr LEFT JOIN daily_performance dp ON dpr.daily_performance_id = dp.daily_performance_id WHERE (dpr.system_date >= ('$overall_from_date') AND dpr.system_date <= ('$overall_to_date') ) order by dpr.system_date ASC";

}

$res1 = $mysqli->query($dailyperform1) or die("Error in Get All Records".$mysqli->error);
$dailyperform_list1 = array();
$i=0;

$actual = 0;
$fixedtarget = 0;
if ($mysqli->affected_rows>0)
{
    $assertionArry = array();
    while($row1 = $res1->fetch_object()){		
        if(!in_array($row1->assertion_table_sno, $assertionArry)){ //to find total target of the month by sum target in goal_setting_ref table using assertion_table_sno. Duplicate row are append so using array to check and avoid duplicate.
            $qrydetails = $mysqli->query("SELECT  sum(gsr.target) as fixtarget FROM  goal_setting_ref gsr WHERE assertion_table_sno = '$row1->assertion_table_sno' ");
            $qryinfo = $qrydetails->fetch_object();	
            $fixtarget = $qryinfo->fixtarget;			
            array_push($assertionArry, $row1->assertion_table_sno);
        }else{
            $fixtarget = 0;
        }		
?>    

    <tr>
        <td><?php echo $row1->system_date; ?></td>
        <td><?php echo $row1->assertion; ?></td>
        <td><?php echo $row1->target; ?></td>
        <td><?php echo $row1->actual_achieve; ?></td>
    </tr>

<?php $i++; 
$actual = $actual + $row1->actual_achieve;
$fixedtarget = $fixedtarget + $fixtarget;
}  } ?>
    </tbody>

    <tr>
        <td></td>
        <td><b>Total</b></td>
        <td><b><?php echo $fixedtarget; ?></b></td>
        <td><b><?php echo $actual; ?></b></td>
    </tr>
    <tr class='balance'>
        <td></td>
        <td><b>Balance To Do</b></td>
        <td colspan="2"><?php echo $fixedtarget - $actual; ?></td>
    </tr>
</table>


<script type="text/javascript">
    $(function() {
        $('#dpr_staff_report').DataTable({
            'processing': true,
            'iDisplayLength': 20,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            // "createdRow": function(row, data, dataIndex) {
            //     $(row).find('td:first').html(dataIndex + 1);
            // },
            // "drawCallback": function(settings) {
            //     this.api().column(0).nodes().each(function(cell, i) {
            //         cell.innerHTML = i + 1;
            //     });
            // },
        });
    });
</script>