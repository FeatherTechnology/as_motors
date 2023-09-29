<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_POST["month"])){
	$yearmonth = $_POST["month"]; //format('yyyy-mm'); // we want month only so split month here.
	// $yearmonthsplit = explode('-',$_POST["month"]); //format('yyyy-mm'); // we want month only so split month here.
    // $month = intval($yearmonthsplit[1]);
    $month = $yearmonth.'-01';

}
if(isset($_POST["designation"])){
	$designation_id = $_POST["designation"];
}
if(isset($_POST["staff_id"])){
	$staff_id = $_POST["staff_id"];
}

//if the staff is transfered then check the transfer effective date is greater than curdate if true then take old designation from the staff_creation_history, if false means the designation will not be overwrite 
$getdesgnDetails = $con->query("SELECT tl.transfer_effective_from, sch.designation FROM `transfer_location` tl LEFT JOIN staff_creation_history sch ON tl.transfer_location_id = sch.transfer_location_id WHERE tl.staff_code = '$staff_id' order by tl.transfer_location_id DESC LIMIT 1");
        
if(mysqli_num_rows($getdesgnDetails)>0){
    $dsgnInfo = $getdesgnDetails->fetch_assoc();
    $transfer_effective_from = date('Y-m-d',strtotime($dsgnInfo['transfer_effective_from'])); 
    $curdates = date('Y-m-d');

    if($transfer_effective_from > $curdates){
        $designation_id = $dsgnInfo['designation']; //Old Designation.
        
    }
}
?>

<div class="card" id="stockinformation">
    <div class="card-header">Daily Performance Details</div>
    <div class="card-body">
    <br> 
        <div style="overflow-x: auto; white-space: nowrap;" >
            <?php
            $daily_performance_id = array();          
            $assertion = array();         
            $target = array();         
            $actual_achieved = array();         
            $vehicle_numberArr2 = array();         
        
            // get Daily Performance details
            $selectGoalSettingDetails = $con->query("SELECT dpr.daily_performance_id, dpr.daily_performance_ref_id, dpr.assertion, 
            dpr.target,dpr.assertion_table_sno FROM daily_performance_ref dpr LEFT JOIN daily_performance dp ON dpr.daily_performance_id = dp.daily_performance_id 
            WHERE dp.emp_id = '".$staff_id."' AND dp.month = '".$month."' AND dp.status = 0  group by dpr.assertion ");
            while($row = $selectGoalSettingDetails->fetch_assoc()){
                $daily_performance_id[] 	= $row["daily_performance_id"];
                $daily_performance_ref_id[] 	= $row["daily_performance_ref_id"];
                $assertion[]	= $row["assertion"];
                // $target[]	= $row["target"];
                $assertion_table_sno	= $row["assertion_table_sno"];

                $goaltargetQry = $mysqli->query(" SELECT gsr.target as total_target
                FROM goal_setting_ref gsr 
                LEFT JOIN  goal_setting gs ON gsr.goal_setting_id = gs.goal_setting_id
                WHERE gsr.monthly_conversion_required = '1'
                AND gsr.assertion_table_sno = '$assertion_table_sno' "); 
                $goal_target = $goaltargetQry->fetch_assoc();
                $target[] = $goal_target['total_target'];

                $actualAchieveDetials = $mysqli->query("SELECT sum(target) as target, sum(actual_achieve) as actual_achieve FROM `daily_performance_ref` WHERE assertion_table_sno = '$assertion_table_sno' ");
                $actualAchieveinfo = $actualAchieveDetials->fetch_assoc();
                $actual_achieved[] = $actualAchieveinfo['actual_achieve'];

            }

            // get satisfied count
            $selectstatisfiedDetails = $con->query("SELECT COUNT(dpr.status) AS statusCount FROM daily_performance_ref dpr LEFT JOIN daily_performance dp
            ON dpr.daily_performance_id = dp.daily_performance_id WHERE dp.emp_id = '".$staff_id."' 
            AND dp.month = '".$month."' AND dp.status = 0 AND dpr.status = '1' ");
            while($statisfiedinfo = $selectstatisfiedDetails->fetch_assoc()){
                $statisfiedCount	= $statisfiedinfo["statusCount"];
            }

            // get not done and carry farward count
            $selectnotdoneDetails = $con->query("SELECT (dpr.status) AS statusCount, dpr.target, dpr.actual_achieve FROM daily_performance_ref dpr LEFT JOIN daily_performance dp 
            ON dpr.daily_performance_id = dp.daily_performance_id WHERE dp.emp_id = '".$staff_id."' 
            AND dp.month = '".$month."' AND dp.status = 0 AND dpr.status = '2' ");
            $notdone_target_total =0;
            while($notdoneinfo = $selectnotdoneDetails->fetch_assoc()){
                $not_doneCount	= $notdoneinfo["statusCount"];
                $notdone_target	= $notdoneinfo["target"] - $notdoneinfo["actual_achieve"];
                $notdone_target_total	= $notdone_target + $notdone_target_total;
            }

            // get not done and carry farward count
            $selectcarryforwardDetails = $con->query("SELECT (dpr.status) AS statusCount, dpr.target, dpr.actual_achieve FROM daily_performance_ref dpr LEFT JOIN daily_performance dp 
            ON dpr.daily_performance_id = dp.daily_performance_id WHERE dp.emp_id = '".$staff_id."' 
            AND dp.month = '".$month."' AND dp.status = 0 AND dpr.status = '3' ");
            $carryforward_target_total =0;
            while($carryforwardinfo = $selectcarryforwardDetails->fetch_assoc()){
                $carry_forwardCount	= $carryforwardinfo["statusCount"];
                $carry_forward_target	= $carryforwardinfo["target"] - $carryforwardinfo["actual_achieve"];
                $carryforward_target_total	= $carry_forward_target + $carryforward_target_total;
            }

            ?>

            <table class="table custom-table" id="sstable">
                <tr>
                    <th>S. No.</th>
                    <th>Assertion</th>
                    <th>Target</th>
                    <!-- <th>Overall Performance</th> -->
                    <th>Achievement</th>
                    <th>Employee Rating</th>
                    <!-- <th>Not Done / Carry Forward</th> -->
                </tr>
                <?php
                $sno = 1;   
                if(isset($daily_performance_ref_id)){
                    $total_achieved = 0;
                    for($o=0; $o<=sizeof($daily_performance_ref_id)-1; $o++){ 
                        ?>
                        <tbody>
                            <tr>
                                <td><?php echo $sno; ?>
                                <input type="hidden" class="form-control" value="1" name="review[]" id="review" ></td> <!-- 1=Daily Task -->
                                <td style="display: none;" ><input type="text" readonly class="form-control" value="<?php echo $daily_performance_ref_id[$o]; ?>" name="daily_performance_ref_id[]" id="daily_performance_ref_id" ></td>
                                <td><input readonly type="text" class="form-control" value="<?php echo $assertion[$o]; ?>" name="assertion[]" id="assertion" ></td>
                                <td><input readonly type="number" class="form-control" value="<?php echo $target[$o]; ?>" name="target[]" id="target" ></td>
                                <td><input type="text" class="form-control" name="achievement[]" id="achievement" placeholder="Enter new achievement" value="<?php echo $actual_achieved[$o]; ?>" readonly></td>
                                <td>
                                    <select tabindex="4" type="text" class="form-control" id="employee_rating" name="employee_rating[]" >
                                        <option value="">Select Employee Rating</option>  
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>   
                                </td>
                            </tr>
                        </tbody>
                    <?php $sno = $sno + 1; 
                    $total_achieved = $actual_achieved[$o] + $total_achieved;
                    } ?>

                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><input readonly type="text" class="form-control" value="<?php echo "Total Satisfied - ".$total_achieved; ?>" name="overall_performance" id="overall_performance" placeholder="Enter new assertion" ></td>
                            <td>
                                <input readonly type="text" class="form-control" value="<?php echo "Total Not Done - ".$notdone_target_total; ?>" name="not_done" id="not_done" >
                                <input readonly type="text" class="form-control" value="<?php echo "Total Carry Forward - ".$carryforward_target_total; ?>" name="carry_forward" id="carry_forward"  >
                            </td> 
                        </tr>
                    </tbody>

                <?php } ?>
            </table>
            <!-- Daily achievement END -->
            
            <!-- Monthly achievement START -->
            <h5>Monthly Goal Details</h5>
            <table class="table custom-table" id="sstable">
                <tr>
                    <th>S. No.</th>
                    <th>Assertion</th>
                    <th>Target</th>
                    <th>Achievement</th>
                    <th>Employee Rating</th>
                </tr>
                <?php
                //(gsr.monthly_conversion_required = 0- Monthly, 1-Daily)
                //if month conversion is Daily means then the target is divided by working days, if not means target is shown as it is.
                $goalSettingQry = " SELECT gsr.assertion_table_sno, gsr.assertion, gsr.target, gs.goal_setting_id, gsr.goal_setting_ref_id, gsr.goal_month as cdate 
                FROM goal_setting_ref gsr 
                LEFT JOIN  goal_setting gs ON gsr.goal_setting_id = gs.goal_setting_id
                WHERE gs.role = '$designation_id' 
                AND gsr.monthly_conversion_required = '0' 
                AND gsr.goal_month = '$yearmonth' ";

                $goalsettingDetails = $mysqli->query($goalSettingQry) or die("Error in Get All Records".$mysqli->error);
                if(mysqli_num_rows($goalsettingDetails) > 0){
                $sno = 1;
                while($goalsettinginfo = $goalsettingDetails->fetch_object()){
                ?>
                <tbody>
                    <tr>
                        <td><?php echo $sno; ?>
                        <input type="hidden" class="form-control" value="0" name="review[]" id="review" ></td> <!-- 0=Monthly Task -->
                        <td><input readonly type="text" class="form-control" value="<?php echo $goalsettinginfo->assertion; ?>" name="assertion[]" id="assertion" ></td>
                        <td><input readonly type="number" class="form-control" value="<?php echo $goalsettinginfo->target; ?>" name="target[]" id="target" ></td>
                        <td><input type="text" class="form-control" name="achievement[]" id="achievement" placeholder="Enter new achievement" ></td>
                        <td>
                            <select tabindex="4" type="text" class="form-control" id="employee_rating" name="employee_rating[]" >
                                <option value="">Select Employee Rating</option>  
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>   
                        </td>
                    </tr>
                </tbody>
                    <?php $sno = $sno + 1; 
                    } } ?>
            </table>
            <!-- Monthly achievement END -->

        </div>
    </div>
</div>

   <br><br><br>
   
<script>
    // set enable and disable condition
    $(".edit_assertion").on('click', function() { 
        var checkbox = $(this).parents('tr').find('td #edit_assertion').is(":checked");
        if (checkbox) { 
            $(this).parents('tr').find('td #overall_performance').attr("readonly",false);
            $(this).parents('tr').find('td #achievement').attr("readonly",false);
            $(this).parents('tr').find('td #employee_rating').attr("readonly",false);
        } else { 
            $(this).parents('tr').find('td #overall_performance').val('').attr("readonly",true);
            $(this).parents('tr').find('td #achievement').val('').attr("readonly",true);
            $(this).parents('tr').find('td #employee_rating').val('').attr("readonly",true);
        }
    });

    $(".delete_assertion").on('click', function() { 
        var checkbox = $(this).parents('tr').find('td #delete_assertion').is(":checked");
        if (checkbox) { 

            var currentDate = new Date($.now());
            var formattedDate = currentDate.toLocaleDateString();  

            $(this).parents('tr').find('td #deleted_date').val(formattedDate);
            $(this).parents('tr').find('td #deleted_remarks').attr("readonly",false);
        } else { 
            $(this).parents('tr').find('td #deleted_date').val('');
            $(this).parents('tr').find('td #deleted_remarks').val('').attr("readonly",true);
        }
    });
</script>
