<?php
include('../ajaxconfig.php');

if(isset($_POST['department_id'])){
    $department_id = $_POST['department_id'];
}
if(isset($_POST['user_staff_id'])){
    $user_staff_id = $_POST['user_staff_id'];
}

$dailyperformanceQry = "SELECT dpr.daily_performance_ref_id, dpr.assertion,gsr.target, gsr.per_day_target, dpr.target, dpr.actual_achieve, dpr.system_date, dpr.goal_setting_id, dpr.goal_setting_ref_id, dpr.status, sc.staff_name 
FROM daily_performance_ref dpr 
LEFT JOIN daily_performance dp ON dpr.daily_performance_id = dp.daily_performance_id 
LEFT JOIN goal_setting_ref gsr ON dpr.goal_setting_ref_id = gsr.goal_setting_ref_id 
LEFT JOIN staff_creation sc ON dp.emp_id = sc.staff_id 
WHERE dp.department_id='$department_id' && sc.reporting = '$user_staff_id' && dpr.system_date = '2023-09-28' && dpr.manager_updated_status != 1 order by dpr.system_date ASC "; //GROUP BY sc.staff_id CURDATE()


$qryInfo = $mysqli->query($dailyperformanceQry) or die("Error in Get All Records".$mysqli->error);
$dailyperform_list1 = array();
$i=0;

if ($mysqli->affected_rows>0)
{
    $target = 0;
    $actualAchieve = 0;
    $balancetodo = 0;
    $average = 0;
    while($qryDetails = $qryInfo->fetch_object()){
        $status    = $qryDetails->status;
        $target = intVal($target) + intVal($qryDetails->target);
        $actualAchieve = intVal($actualAchieve) + intVal($qryDetails->actual_achieve);
        $balance = $qryDetails->target - $qryDetails->actual_achieve;
        $balancetodo = intVal($balancetodo) + intVal($balance);
        $average = intVal($average) + intVal($qryDetails->per_day_target);
?>

    <tr>
        <td><input type='text' class='form-control' id='staff_name' name='staff_name[]' value="<?php echo $qryDetails->staff_name; ?>" readonly></td>
        <td>
        <input tabindex="9" type="text" class="form-control" id="assertion" name="assertion[]" value="<?php echo $qryDetails->assertion; ?>" readonly>
        <input type='hidden' class='form-control' id='goal_setting_id' name='goal_setting_id[]' value="<?php echo $qryDetails->goal_setting_id; ?>">
        <input type='hidden' class='form-control' id='goal_setting_ref_id' name='goal_setting_ref_id[]' value="<?php echo $qryDetails->goal_setting_ref_id; ?>">
        <input  type="hidden" class="form-control" id="daily_ref_id" name="daily_ref_id[]" value="<?php echo $qryDetails->daily_performance_ref_id; ?>">

        </td>
        <td >
            <input tabindex="10" type="text" class="form-control target" id="target" name="target[]" value="<?php echo $qryDetails->target; ?>" readonly>
            </input> 
        </td>
        <td >
            <input tabindex="11" type="number" class="form-control actual_achieve" id="actual_achieve" name="actual_achieve[]" value="<?php echo $qryDetails->actual_achieve; ?>" readonly>
            </input> 
        </td>
        <td >
            <input tabindex="11" type="number" class="form-control" id="balance_to_do" name="balance_to_do[]" value="<?php echo $qryDetails->target - $qryDetails->actual_achieve; ?>" readonly>
            </input> 
        </td>
        <td >
            <input tabindex="11" type="number" class="form-control" id="per_day_target" name="per_day_target[]" value="<?php echo $qryDetails->per_day_target; ?>" readonly>
            </input> 
        </td>
        <td>
            <input tabindex="12" type="date" class="form-control" id="sdate" name="sdate[]" value="<?php echo $qryDetails->system_date; ?>" readonly></input> 
        </td>
        <td>
            <select  class="form-control wstatus" id="wstatus" name="wstatus[]" tabindex="13" disabled>
                <option value=" ">Select Work Status</option>
                <option value="1" <?php if($status == '1') { echo 'selected';} ?> >Statisfied</option>
                <option value="2" <?php if($status == '2') { echo 'selected';} ?> >Not Done</option>
                <option value="3" <?php if($status == '3') { echo 'selected';} ?> >Carry Forward</option>
            </select>
        </td>                                                            
        <td>
            <textarea  class="form-control manager_comment" id="manager_comment" name="manager_comment[]" tabindex="13"></textarea>
        </td>                                                            
        <td><input type="button" name="review_submit" id="review_submit" class="btn btn-primary review_submit" value="Submit" data-id="<?php echo $qryDetails->daily_performance_ref_id; ?>" ></td>                                                            
    </tr>

<?php $i++; }  ?>
    <tr style="font-weight: bold;">
        <td> Overall </td>
        <td> </td>
        <td> <?php echo $target;?> </td>
        <td> <?php echo $actualAchieve;?> </td>
        <td> <?php echo $balancetodo;?> </td>
        <td> <?php echo $average;?> </td>
        <td> </td>
        <td> </td>                                                            
        <td> </td>                                                            
        <td> </td>                                                            
    </tr>
<?php } ?>