<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_POST["project_id"])){
	$project_id = $_POST["project_id"];
}
if(isset($_POST["actual_start_date"])){
	$actual_start_date = $_POST["actual_start_date"];
}
?>

<br><br><br>
<div class="card" id="stockinformation">
    <div class="card-header">Promotional Activity Details</div>
    <div class="card-body ">
    <br> 
        <div style="overflow-x: auto; white-space: nowrap;" >
            <?php
            $promotional_activities_ref_id = array();         
            $activity_involved = array();         
            $time_frame_start = array();         
            $duration = array();         
        
            $selectDetails = $con->query("SELECT * FROM promotional_activities_ref WHERE promotional_activities_id = '".strip_tags($project_id)."' ");
            while($row = $selectDetails->fetch_assoc()){
                $promotional_activities_ref_id[] 	= $row["promotional_activities_ref_id"];
                $activity_involved[] 	= $row["activity_involved"];
                $time_frame_start[] 	= $row["time_frame_start"];
                $duration[] 	= $row["duration"];
            } 
            
            ?>

            <table class="table custom-table" id="sstable">
                <tr>
                    <th>S. No.</th>
                    <th>Activity</th>
                    <th>Time Frame</th>
                    <th>Duration</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Employee Name</th>
                </tr>
                <?php
                $sno = 1;   
                if(isset($promotional_activities_ref_id)){
                    for($o=0; $o<=sizeof($promotional_activities_ref_id)-1; $o++){ 
        
                        $start_date = date('Y-m-d', strtotime('-'.$time_frame_start[$o].' day', strtotime($actual_start_date)));
                        $end_date = date('Y-m-d', strtotime('-'.$duration[$o].' day', strtotime($actual_start_date)));
                        
                        ?>
                        <tbody>
                            <tr>
                                <td><?php echo $sno; ?></td>
                                <td style="display: none;"><input tabindex="4" name="promotional_activities_ref_id[]" id="promotional_activities_ref_id" class="promotional_activities_ref_id" value="<?php echo $promotional_activities_ref_id[$o]; ?>" /></td>
                                <td><input type="text" readonly class="form-control" name="activity_involved[]" id="activity_involved" value="<?php echo $activity_involved[$o]; ?>" ></td>
                                <td><input type="text" readonly class="form-control" name="time_frame_start[]" id="time_frame_start" value="<?php echo $time_frame_start[$o]; ?>" ></td>
                                <td><input type="text" readonly class="form-control" name="duration[]" id="duration" value="<?php echo $duration[$o]; ?>" ></td>
                                <td><input type="date" class="form-control" name="start_date[]" id="start_date" value="<?php echo $start_date; ?>" ></td>
                                <td><input type="date" class="form-control" name="end_date[]" id="end_date" value="<?php echo $end_date; ?>" ></td>
                                <td>
                                    <select tabindex="4" type="text" class="form-control employee_name" id="employee_name" name="employee_name[]" >
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    <?php $sno = $sno + 1; }
                } ?>
            </table>
        </div>
    </div>
</div>
    
<script>
    $(function(){
        $.ajax({
            url: 'campaignlFile/ajaxGetAllStaff.php',
            type: 'post',
            data: {},
            dataType: 'json',
            success:function(response){
            
            $('.employee_name').empty();
            $('.employee_name').prepend("<option value=''>" + 'Select Employee Name' + "</option>");
            var i = 0;
            for (i = 0; i <= response.staff_id.length - 1; i++) { 
                $('.employee_name').append("<option value='" + response['staff_id'][i] + "'>" + response['staff_name'][i] + "</option>");
            }
            }
        });
    });
</script>