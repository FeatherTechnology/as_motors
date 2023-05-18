<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_POST["company_name"])){
	$company_name = $_POST["company_name"];
}
if(isset($_POST["goal_year"])){
	$goal_year = $_POST["goal_year"];
}
if(isset($_POST["no_of_months"])){
	$no_of_months = $_POST["no_of_months"];
}

?>

<div class="card" id="stockinformation">
    <div class="card-header">Goal Setting Details</div>
    <div class="card-body">
    <br> 
        <div style="overflow-x: auto; white-space: nowrap;" >
            <?php
            $goal_setting_ref_id = array();          
            $assertion = array();         
            $target = array();         
            $vehicle_numberArr2 = array();         
        
            // get goal setting details
            $selectGoalSettingDetails = $con->query("SELECT goal_setting_ref.goal_setting_ref_id, goal_setting_ref.assertion, goal_setting_ref.target FROM goal_setting_ref 
            LEFT JOIN goal_setting ON goal_setting_ref.goal_setting_id = goal_setting.goal_setting_id WHERE goal_setting.goal_setting_id = '".$goal_year."' 
            AND goal_setting.status = 0 ");
            while($row = $selectGoalSettingDetails->fetch_assoc()){
                $goal_setting_ref_id[] 	= $row["goal_setting_ref_id"];
                $assertion[]	= $row["assertion"];
                $target[]	= $row["target"];
            }

            // get kra cetails
            $selectKraDetails = $con->query("SELECT kra_creation_ref.kra_creation_ref_id, kra_creation_ref.kra_category FROM kra_creation_ref LEFT JOIN kra_creation 
            ON kra_creation_ref.kra_id = kra_creation.kra_id WHERE kra_creation.kra_id = '".$goal_year."' AND kra_creation.status = 0 ");
            while($row1 = $selectKraDetails->fetch_assoc()){
                $kra_creation_ref_id[] 	= $row1["kra_creation_ref_id"].""."_kra";  
                $kra_category[]	= $row1["kra_category"];
            } 

            $ids = array_merge($goal_setting_ref_id, $kra_creation_ref_id); 
            $assertions = array_merge($assertion, $kra_category);
            ?>

            <table class="table custom-table" id="sstable">
                <tr>
                    <th>S. No.</th>
                    <th>Assertion</th>
                    <th>Target</th>
                    <th>Action</th>
                    <th>New Assertion</th>
                    <th>New Target</th>
                    <th>Applicability</th>
                    <th>Deleted Date</th>
                    <th>Deleted Remarks</th>
                </tr>
                <?php
                $sno = 1;   
                if(isset($ids)){
                    for($o=0; $o<=sizeof($ids)-1; $o++){ 
                        $subString = "_kra";
                        ?>
                        <tbody>
                            <tr>
                                <td><?php echo $sno; ?></td>
                                <td style="display: none;" ><input type="text" readonly class="form-control" value="<?php echo $ids[$o]; ?>" name="id[]" id="id" ></td>
                                <td><input readonly type="text" class="form-control" value="<?php echo $assertions[$o]; ?>"  name="assertion[]" id="assertion" ></td>
                                <?php 
                                if (strpos($ids[$o], $subString) !== false) { ?>
                                    <td><input type="number" class="form-control" value="<?php echo $target[$o]; ?>"  name="target[]" id="target" ></td>
                                <?php } else { ?>
                                    <td><input readonly type="number" class="form-control" value="<?php echo round($target[$o]/$no_of_months); ?>"  name="target[]" id="target" ></td>
                                <?php } ?>
                                <td>
                                <span class='icon-border_color' id="edit_assertion" name="edit_assertion" data-toggle="modal" data-target=".addProjectModal"></span>&nbsp;&nbsp; 
                                <span class='icon-trash-2' id="delete_assertion" name="delete_assertion" data-toggle="modal" data-target=".addProjectModal1"></span>
                                </td>
                                <td><input readonly type="number" class="form-control" value=""  name="new_assertion[]" id="new_assertion" ></td>
                                <td><input readonly type="number" class="form-control" value=""  name="new_target[]" id="new_target" ></td>
                                <td><input readonly type="number" class="form-control" value=""  name="applicability[]" id="applicability" ></td>
                                <td><input readonly type="number" class="form-control" value=""  name="deleted_date[]" id="deleted_date" ></td>
                                <td><textarea readonly id="deleted_remarks" name="deleted_remarks" class="form-control" rows="2" cols="40" ></textarea></td>
                            </tr>
                        </tbody>
                    <?php $sno = $sno + 1; }
                } ?>
            </table>
        </div>
    </div>
</div>
    