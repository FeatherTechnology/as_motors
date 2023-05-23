<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_POST["company_name"])){
	$company_name = $_POST["company_name"];
}
if(isset($_POST["goal_year"])){
	$goal_year = $_POST["goal_year"];
}
if(isset($_POST["month"])){
	$month = $_POST["month"];
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
            $vehicle_numberArr2 = array();         
        
            // get Daily Performance details
            $selectGoalSettingDetails = $con->query("SELECT daily_performance_ref.daily_performance_id, daily_performance_ref.daily_performance_ref_id, daily_performance_ref.assertion, 
            daily_performance_ref.target FROM daily_performance_ref LEFT JOIN daily_performance ON daily_performance_ref.daily_performance_id = daily_performance.daily_performance_id 
            WHERE daily_performance.daily_performance_id = '".$goal_year."' AND daily_performance.month = '".$month."' AND daily_performance.status = 0 ");
            while($row = $selectGoalSettingDetails->fetch_assoc()){
                $daily_performance_id[] 	= $row["daily_performance_id"];
                $daily_performance_ref_id[] 	= $row["daily_performance_ref_id"];
                $assertion[]	= $row["assertion"];
                $target[]	= $row["target"];
            }

            // get satisfied count
            $selectGoalSettingDetails1 = $con->query("SELECT COUNT(daily_performance_ref.status) AS statusCount FROM daily_performance_ref LEFT JOIN daily_performance 
            ON daily_performance_ref.daily_performance_id = daily_performance.daily_performance_id WHERE daily_performance.daily_performance_id = '".$goal_year."' 
            AND daily_performance.month = '".$month."' AND daily_performance.status = 0 AND daily_performance_ref.status = 'statisfied' ");
            while($row1 = $selectGoalSettingDetails1->fetch_assoc()){
                $statisfiedCount	= $row1["statusCount"];
            }

            // get not done and carry farward count
            $selectGoalSettingDetails1 = $con->query("SELECT COUNT(daily_performance_ref.status) AS statusCount FROM daily_performance_ref LEFT JOIN daily_performance 
            ON daily_performance_ref.daily_performance_id = daily_performance.daily_performance_id WHERE daily_performance.daily_performance_id = '".$goal_year."' 
            AND daily_performance.month = '".$month."' AND daily_performance.status = 0 AND daily_performance_ref.status = 'not_done' ");
            while($row1 = $selectGoalSettingDetails1->fetch_assoc()){
                $not_doneCount	= $row1["statusCount"];
            }

            // get not done and carry farward count
            $selectGoalSettingDetails2 = $con->query("SELECT COUNT(daily_performance_ref.status) AS statusCount FROM daily_performance_ref LEFT JOIN daily_performance 
            ON daily_performance_ref.daily_performance_id = daily_performance.daily_performance_id WHERE daily_performance.daily_performance_id = '".$goal_year."' 
            AND daily_performance.month = '".$month."' AND daily_performance.status = 0 AND daily_performance_ref.status = 'carry_forward' ");
            while($row2 = $selectGoalSettingDetails2->fetch_assoc()){
                $carry_forwardCount	= $row2["statusCount"];
            }

            ?>

            <table class="table custom-table" id="sstable">
                <tr>
                    <th>S. No.</th>
                    <th>Assertion</th>
                    <th>Target</th>
                    <th>Overall Performance</th>
                    <th>Achievement</th>
                    <th>Employee Rating</th>
                    <th>Not Done / Carry Forward</th>
                </tr>
                <?php
                $sno = 1;   
                if(isset($daily_performance_ref_id)){
                    for($o=0; $o<=sizeof($daily_performance_ref_id)-1; $o++){ 
                        ?>
                        <tbody>
                            <tr>
                                <td><?php echo $sno; ?></td>
                                <td style="display: none;" ><input type="text" readonly class="form-control" value="<?php echo $daily_performance_id[$o]; ?>" name="daily_performance_id[]" id="daily_performance_id" ></td>
                                <td style="display: none;" ><input type="text" readonly class="form-control" value="<?php echo $daily_performance_ref_id[$o]; ?>" name="daily_performance_ref_id[]" id="daily_performance_ref_id" ></td>
                                <td><input readonly type="text" class="form-control" value="<?php echo $assertion[$o]; ?>" name="assertion[]" id="assertion" ></td>
                                <td><input readonly type="number" class="form-control" value="<?php echo round($target[$o]); ?>" name="target[]" id="target" ></td>
                                <td><input readonly type="text" class="form-control" value="<?php echo "Total Satisfied - ".$statisfiedCount; ?>" name="overall_performance[]" id="overall_performance" placeholder="Enter new assertion" ></td>
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
                                <td>
                                    <input readonly type="text" class="form-control" value="<?php echo "Total Not Done - ".$not_doneCount; ?>" name="not_done" id="not_done" >
                                    <input readonly type="text" class="form-control" value="<?php echo "Total Carry Forward - ".$carry_forwardCount; ?>" name="carry_forward" id="carry_forward"  >
                                </td> 
                            </tr>
                        </tbody>
                    <?php $sno = $sno + 1; }
                } ?>
            </table>
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
