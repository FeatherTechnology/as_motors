<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["company_id"])){
	$company_id = $_POST["company_id"];
}
if(isset($_POST["department_id"])){
	$department_id = $_POST["department_id"]; 
}

$staff_id = array();
$staff_name = array();
$emp_code = array();

for($i=0; $i<=sizeof($department_id)-1; $i++){
    $getInstName=$con->query("SELECT * FROM staff_creation WHERE department = '".strip_tags($department_id[$i])."' AND FIND_IN_SET($company_id[$i], company_id) > 0 AND status = 0");
    while($row2=$getInstName->fetch_assoc()){
        $branch_id[]    = $row2["company_id"];
        $staff_id[]    = $row2["staff_id"];
        $staff_name[]    = $row2["staff_name"];
        $emp_code[]    = $row2["emp_code"];
    } 
} 
?>

<div class="ml-2">
    <table class="border-collapse:collapse">
        <?php  
        if(isset($staff_id)){
            for($o=0; $o<=sizeof($staff_id)-1; $o++){ ?>
                <tbody>
                    <td style="border-style : hidden!important;"><input tabindex="3" type="checkbox" name="staff_id[]" id="staff_id" class="staffIdCheckbox staff_id" value="<?php echo $staff_id[$o]; ?>" /></td>
                    <td style="border-style : hidden!important; display: none;"><input tabindex="3" type="text" name="branch_id[]" id="branch_id" class="branch_id" value="<?php echo $branch_id[$o]; ?>" /></td>
                    <td style="border-style : hidden!important;"><input readonly type="text" style="border: 0; outline:none; background-color: #f7f8fa;" class="form-control" value="<?php echo $staff_name[$o].' - '.$emp_code[$o]; ?>" name="staff_name[]" id="staff_name"></td>
                </tbody>
                <?php 
            }
        } ?>
    </table>
</div>
