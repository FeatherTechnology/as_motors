<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
	$userid = $_SESSION["userid"];
}
if(isset($_SESSION["branch_id"])){
	$branch_id = $_SESSION["branch_id"];
}

function getPreviousKM($con, $vehicle_number){
    
    $previous_km='';
    $getPreviousKM = $con->query("SELECT * FROM daily_km_ref WHERE vehicle_number = '".strip_tags($vehicle_number)."' ");
    while($row = $getPreviousKM->fetch_assoc()){
        $previous_km 	= $row["start_km"];
    } 
    return $previous_km;
}

?>

<div class="card" id="stockinformation">
    <div class="card-header">All Vehicle List</div>
    <div class="card-body ">
    <br> 
        <div style="overflow-x: auto; white-space: nowrap;" >
            <?php
            $vehicle_details_id = array();          
            $vehicle_numberArr = array();         
            $daily_km_id = array();         
            $vehicle_numberArr2 = array();         
        
            $selectAllVehicle = $con->query("SELECT * FROM vehicle_details WHERE 1 AND status = '0' ");
            while($row = $selectAllVehicle->fetch_assoc()){

                $vehicle_details_id[] 	= $row["vehicle_details_id"];
                $vehicle_numberArr[]	= $row["vehicle_number"];
            } 

            $selectDailyKM = $con->query("SELECT * FROM daily_km WHERE 1 AND status = '0' ");
            while($row1 = $selectDailyKM->fetch_assoc()){
                $daily_km_id[] 	= $row1["daily_km_id"];
            } 

            foreach($daily_km_id as $daily_km){
                $selectDailyKMRef = $con->query("SELECT * FROM daily_km_ref WHERE daily_km_id = '".strip_tags($daily_km)."' ");
                while($row2 = $selectDailyKMRef->fetch_assoc()){
                    $vehicle_numberArr2[] 	= $row2["vehicle_number"];
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
                </tr>
                <?php
                $sno = 1;   
                if(isset($vehicle_details_id)){
                    for($o=0; $o<=sizeof($vehicle_details_id)-1; $o++){ ?>
                        <tbody>
                            <tr>
                                <td><?php echo $sno; ?></td>
                                <td><input tabindex="4" type="checkbox" name="vehicle_details_id[]" id="vehicle_details_id" class="vehicle_details_id" value="<?php echo $vehicle_details_id[$o]; ?>" /></td>
                                <td><input type="text" readonly class="form-control" value="<?php echo $vehicle_numberArr[$o]; ?>" name="vehicle_number[]" id="vehicle_number" ></td>
                                <?php if(!in_array($vehicle_numberArr[$o], $vehicle_numberArr2)){ ?>
                                    <td><input tabindex="5" readonly type="number" class="form-control" name="start_km[]" id="start_km" placeholder="Enter Start KM" ></td>
                                <?php }else{ ?>
                                    <td><input tabindex="5" readonly type="number" class="form-control" name="start_km[]" id="start_km" value="<?php echo getPreviousKM($con, $vehicle_numberArr[$o]); ?>" ></td>
                                <?php } ?>
                                <td><input tabindex="6" readonly type="number" class="form-control" name="end_km[]" id="end_km" placeholder="Enter End KM" ></td>
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
        var startKM = $(this).parents('tr').find('td #start_km').val();
        if (checkbox) { 
            if(startKM == ''){
                $(this).parents('tr').find('td #start_km').attr("readonly",false);
            }
            $(this).parents('tr').find('td #end_km').attr("readonly",false);
        } else { 
            $(this).parents('tr').find('td #start_km').attr("readonly",true);
            $(this).parents('tr').find('td #end_km').attr("readonly",true);
        }
    });
</script>