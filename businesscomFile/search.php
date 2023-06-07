<?php
include('../ajaxconfig.php');

if(isset($_POST["staff_details"])){
    $sstaff_details = $_POST["staff_details"]; 
} 
if(isset($_POST["search_dropdown"])){
    $search_dropdown = $_POST["search_dropdown"];  
} 
if(isset($_POST["company_id"])){
    $company_id1 = $_POST["company_id"];
    $company_ids = explode(" ",$company_id1); 
}

$StaffDetails= array();
$emp_code    = array();
$staff_name  = array();
$designation = array();
$department  = array();


if($search_dropdown == "Id") { 

    foreach($company_ids as $company_id) {
        $company_id = trim($company_id);
        $query = "SELECT * FROM staff_creation WHERE emp_code = '".$sstaff_details."' AND FIND_IN_SET($company_id, company_id) > 0";
        $getposmember = $con->query($query);
        if ($getposmember) {
            if ($getposmember->num_rows > 0) {
                while ($row = $getposmember->fetch_assoc()) { 
                    $emp_code[] = $row["emp_code"];   
                    $staff_name[] = $row["staff_name"];   
                    $staff_id[] = $row["staff_id"];   
                }
            }
        }
    }

}else if($search_dropdown == "Name") { 

    foreach($company_ids as $company_id) {
        $company_id = trim($company_id);
        $getposmember= "SELECT * FROM staff_creation WHERE staff_name = '".$sstaff_details."' AND FIND_IN_SET($company_id, company_id) > 0 "; 
        $getposmember = $con->query($getposmember);
        if ($getposmember) {
            if ($getposmember->num_rows > 0) {
                while($row=$getposmember->fetch_assoc()){ 
                    $emp_code[]=$row["emp_code"];   
                    $staff_name[]=$row["staff_name"]; 
                    $staff_id[]=$row["staff_id"];   
                }
            }
        }
    }
}else if($search_dropdown == "Position") { 

    foreach($company_ids as $company_id) {
        $company_id = trim($company_id);
        $getposmember= "SELECT * FROM designation_creation WHERE designation_name = '".$sstaff_details."' AND FIND_IN_SET($company_id, company_id) > 0 "; 
        $getposmember = $con->query($getposmember);
        if ($getposmember) {
            if($getposmember->num_rows>0){
                while($row=$getposmember->fetch_assoc()){ 
                    $designation_id=$row["designation_id"];   
                    $designation_name=$row["designation_name"];   
                }
            } 
        } 
    } 

    foreach($company_ids as $company_id) {
        $company_id = trim($company_id);
        $getposmember= "SELECT * FROM staff_creation WHERE designation = '".$designation_id."' AND FIND_IN_SET($company_id, company_id) > 0 "; 
        $getposmember = $con->query($getposmember);
        if ($getposmember) {
            if($getposmember->num_rows>0){
                while($row=$getposmember->fetch_assoc()){ 
                    $emp_code[]=$row["emp_code"];   
                    $staff_name[]=$row["staff_name"]; 
                    $staff_id[]=$row["staff_id"];   
                }
            } 
        } 
    } 
}else if($search_dropdown == "Dept Name") { 

    foreach($company_ids as $company_id) {
        $company_id = trim($company_id);
        $getposmember= "SELECT * FROM department_creation WHERE department_name = '".$sstaff_details."' AND FIND_IN_SET($company_id, company_id) > 0 "; 
        $getposmember = $con->query($getposmember);
        if ($getposmember) {
            if($getposmember->num_rows>0){
                while($row=$getposmember->fetch_assoc()){ 
                    $department_id=$row["department_id"];   
                    $department_name=$row["department_name"];   
                }
            } 
        } 
    } 

    foreach($company_ids as $company_id) {
        $company_id = trim($company_id);
        $getposmember= "SELECT * FROM staff_creation WHERE department = '".$department_id."' AND FIND_IN_SET($company_id, company_id) > 0 "; 
        $getposmember = $con->query($getposmember);
        if ($getposmember) {
            if($getposmember->num_rows>0){
                while($row=$getposmember->fetch_assoc()){ 
                    $emp_code[]=$row["emp_code"];   
                    $staff_name[]=$row["staff_name"]; 
                    $staff_id[]=$row["staff_id"];   
                }
            } 
        } 
    } 
} 

?>
<div class="ml-2">
    <table class="border-collapse:collapse">
        <?php
        // $sno = 1;
        if(isset($staff_id)){
            for($o=0; $o<=sizeof($staff_id)-1; $o++){ ?>
                <tbody>
                    <!-- <td><?php echo $sno; ?></td> -->
                    <td style="border-style : hidden!important;"><input tabindex="3" type="checkbox" name="staff_id[]" id="staff_id" class="departmentIdCheckboxCheckbox staff_id" value="<?php echo $staff_id[$o]; ?>" /></td>
                    <td style="border-style : hidden!important;"><input readonly type="text" style="border: 0; outline:none; background-color: #F7F8FA;" class="form-control" value="<?php echo $staff_name[$o].' - '.$emp_code[$o]; ?>" name="staff_name[]" id="staff_name"></td>
                </tbody>
                <?php // $sno = $sno + 1;
            }
        } ?>
    </table>
</div>
