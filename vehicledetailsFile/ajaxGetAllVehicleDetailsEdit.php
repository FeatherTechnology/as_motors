<?php
@session_start();
include '../ajaxconfig.php';
include("../api/main.php");

if(isset($_SESSION["userid"])){
	$userid = $_SESSION["userid"];
}
if(isset($_SESSION["branch_id"])){
	$branch_id = $_SESSION["branch_id"];
}
if(isset($_POST["daily_km_id"])){
	$daily_km_id = $_POST["daily_km_id"];
}

$staffNameList = $userObj->getemployeecode($mysqli); //All Staff List with Active Status. 

?>

<div class="card" id="stockinformation">
    <div class="card-header">All Vehicle List</div>
    <span class="required" style="font-size: 12px;">* Select checkbox if you want to enter KM of vehicle</span>
    <div class="card-body">
    <br> 
        <div style="overflow-x: auto; white-space: nowrap;" >
            <?php
            $vehicle_details_id = array();          
            $vehicle_number = array();  

            $daily_km_idArr = array();  
            $daily_km_ref_idArr = array();  
            $vehicle_details_idArr = array();  
            $start_kmArr = array();  
            $end_kmArr = array();  
            $employee_nameArr = array();  
            
            $getPMChecklistId = $con->query("SELECT * FROM daily_km_ref WHERE daily_km_id = '".strip_tags($daily_km_id)."' ");
            while($row1 = $getPMChecklistId->fetch_assoc()){
                $daily_km_idArr[] 	= $row1["daily_km_id"];
                $daily_km_ref_idArr[] 	= $row1["daily_km_ref_id"];
                $vehicle_details_idArr[] 	= $row1["vehicle_details_id"];
                $start_kmArr[] 	= $row1["start_km"];
                $end_kmArr[] 	= $row1["end_km"];
                $employee_nameArr[] 	= $row1["employee_name"];
            }
        
            for($i=0; $i<=sizeof($vehicle_details_idArr)-1; $i++){  
                $selectAllVehicle = $con->query("SELECT * FROM vehicle_details WHERE vehicle_details_id = '".strip_tags($vehicle_details_idArr[$i])."' AND status = '0' ");
                while($row = $selectAllVehicle->fetch_assoc()){
                    $vehicle_details_id[] 	= $row["vehicle_details_id"];
                    $vehicle_number[]	    = $row["vehicle_number"];
                } 
            } 
            ?>

            <table class="table custom-table" id="sstable">
                <tr>
                    <th>S. No.</th>
                    <th></th>
                    <th>Vehicle Number</th>
                    <th>Start KM</th>
                    <th>End KM</th>
                    <th>Employee Name</th>
                </tr>
                <?php
                $sno = 1;   
                if(isset($vehicle_details_id)){
                    for($o=0; $o<=sizeof($vehicle_details_id)-1; $o++){ ?>
                        <tbody>
                            <tr>
                                <input type="hidden" name="empArr" id="empArr" value="<?php echo $employee_nameArr[$o]; ?>" />
                                <input type="hidden" name="branch_id" id="branch_id" value="<?php if(isset($branch_id))echo $branch_id; ?>" />
                                <input type="hidden" name="dailyKMId" id="dailyKMId" value="<?php echo $daily_km_idArr[$o]; ?>" />
                                <td style="display: none;"><input type="text" readonly class="form-control" name="dailyKMRefId[]" id="dailyKMRefId" value="<?php echo $daily_km_ref_idArr[$o]; ?>" ></td>
                                <td><?php echo $sno; ?></td>
                                <td><input tabindex="3" type="checkbox" name="vehicle_details_id[]" id="vehicle_details_id" class="vehicle_details_id" value="<?php echo $vehicle_details_id[$o]; ?>" /></td>
                                <td><input type="text" readonly class="form-control" value="<?php echo $vehicle_number[$o]; ?>" name="vehicle_number[]" id="vehicle_number" ></td>
                                <td><input readonly type="number" readonly class="form-control validate_start_km" name="start_km[]" id="start_km" value="<?php echo $start_kmArr[$o]; ?>" data-id="<?php echo $start_kmArr[$o]; ?>" placeholder="Enter Start KM" ></td>
                                <td><input readonly type="number" readonly class="form-control validate_end_km" name="end_km[]" id="end_km" value="<?php echo $end_kmArr[$o]; ?>" placeholder="Enter End KM" ></td>
                                <td>
                                    <select tabindex="4" type="text" class="form-control employee_name" id="employee_name" name="employee_name[]" >
                                        <option value="">Select Staff Name</option>   
                                        <?php if (sizeof($staffNameList)>0) { 
                                            for($j=0;$j<count($staffNameList);$j++) { ?>
                                            <option <?php if(isset($employee_nameArr)) { if($staffNameList[$j]['staff_id'] == $employee_nameArr[$o]) echo 'selected'; } ?>
                                            value="<?php echo $staffNameList[$j]['staff_id']; ?>">
                                            <?php echo $staffNameList[$j]['staff_name'] .' - '. $staffNameList[$j]['emp_code'];?></option>
                                        <?php }} ?>
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
    // set enable and disable condition
    $(".vehicle_details_id").on('click', function() { 
        var checkbox = $(this).parents('tr').find('td #vehicle_details_id').is(":checked");
        if (checkbox) { 
            $(this).parents('tr').find('td #start_km').attr("readonly",false);
            $(this).parents('tr').find('td #end_km').attr("readonly",false);
        } else { 
            $(this).parents('tr').find('td #start_km').attr("readonly",true);
            $(this).parents('tr').find('td #end_km').attr("readonly",true);
            // $(this).parents('tr').find('td #start_km').val('');
            // $(this).parents('tr').find('td #end_km').val('');
            var branch_id = $("#branchIdEdit").val();
            editVehicleKM(branch_id)
        }
    });

</script>