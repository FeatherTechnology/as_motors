<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_POST["company_name"])){
	$company_name = $_POST["company_name"];
}
if(isset($_POST["designation"])){
	$designation = $_POST["designation"];
}
if(isset($_POST["department"])){
	$department = $_POST["department"];
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
            $monthly_conversion = array();         
            $vehicle_numberArr2 = array();         
            $kra_creation_ref_id = array();         
            $kra_category = array();         
        
            // get goal setting details
            $selectGoalSettingDetails = $con->query("SELECT goal_setting_ref.goal_setting_ref_id, goal_setting_ref.assertion, goal_setting_ref.target, goal_setting_ref.monthly_conversion_required FROM goal_setting_ref 
            LEFT JOIN goal_setting ON goal_setting_ref.goal_setting_id = goal_setting.goal_setting_id WHERE goal_setting.year = '".$goal_year."' 
            AND goal_setting.company_name = '".$company_name."' AND goal_setting.department = '".$department."' AND goal_setting.role = '".$designation."' 
            AND goal_setting.status = 0 ");
            while($row = $selectGoalSettingDetails->fetch_assoc()){
                $goal_setting_ref_id[] 	= $row["goal_setting_ref_id"];
                $assertion[]	= $row["assertion"];
                $target[]	= $row["target"];
                $monthly_conversion[]	= $row["monthly_conversion_required"];
            }

            // get kra cetails
            $selectKraDetails = $con->query("SELECT kra_creation_ref.kra_creation_ref_id, kra_creation_ref.kra_category FROM kra_creation_ref LEFT JOIN kra_creation 
            ON kra_creation_ref.kra_id = kra_creation.kra_id WHERE kra_creation.kra_id = '".$goal_year."' AND kra_creation.company_id = '".$company_name."' 
           AND kra_creation.department_id = '".$department."' AND kra_creation.designation_id = '".$designation."' AND kra_creation.status = 0 ");
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
                                <td><input readonly type="text" class="form-control" value="<?php echo $assertions[$o]; ?>" name="assertion[]" id="assertion" ></td>
                                <?php 
                                if (strpos($ids[$o], $subString) !== false || $monthly_conversion[$o] == '1') { ?>
                                    <td><input type="number" class="form-control" value="<?php echo $target[$o]; ?>" name="target[]" id="target" ></td>
                                <?php } else { ?>
                                    <td><input readonly type="number" class="form-control" value="<?php echo round($target[$o]/$no_of_months); ?>" name="target[]" id="target" ></td>
                                <?php } ?>
                                <td>
                                    <input type="checkbox" id="edit_assertion" name="edit_assertion[]" class="edit_assertion" value="edit">
                                    <label for="edit_assertion"> EDIT</label> &nbsp;&nbsp;
                                    <input type="checkbox" id="delete_assertion" name="delete_assertion[]" class="delete_assertion" value="delete">
                                    <label for="delete_assertion"> DELETE</label><br>
                                </td>
                                <td><input readonly type="text" class="form-control" value="" name="new_assertion[]" id="new_assertion" placeholder="Enter new assertion" ></td>
                                <td><input readonly type="number" class="form-control" value="" name="new_target[]" id="new_target" placeholder="Enter new target" ></td>
                                <td><input readonly type="text" class="form-control" value="" name="applicability[]" id="applicability" placeholder="Enter applicability" ></td>
                                <td><input readonly type="text" class="form-control" value="" name="deleted_date[]" id="deleted_date" ></td>
                                <td><textarea readonly id="deleted_remarks" name="deleted_remarks[]" class="form-control" rows="2" cols="40" placeholder="Enter remarks" ></textarea></td>
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
    $(".edit_assertion").on('click', function() { 
        var checkbox = $(this).parents('tr').find('td #edit_assertion').is(":checked");
        if (checkbox) { 
            $(this).parents('tr').find('td #new_assertion').attr("readonly",false);
            $(this).parents('tr').find('td #new_target').attr("readonly",false);
            $(this).parents('tr').find('td #applicability').attr("readonly",false);
        } else { 
            $(this).parents('tr').find('td #new_assertion').val('').attr("readonly",true);
            $(this).parents('tr').find('td #new_target').val('').attr("readonly",true);
            $(this).parents('tr').find('td #applicability').val('').attr("readonly",true);
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
