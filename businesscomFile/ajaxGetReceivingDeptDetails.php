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
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
}

function getCompanyName($con, $company_id){
    $branch_name = '';
    $getname = $con->query("SELECT branch_name FROM branch_creation WHERE branch_id = '".$company_id."' ");
    while ($row = $getname->fetch_assoc()) {
        $branch_name = $row["branch_name"];
    }
    return $branch_name;
}

$department_idArr = array();
$department_nameArr = array();

for($i=0; $i<=sizeof($department_id)-1; $i++){
    if($sbranch_id != $company_id[$i]){
        $getqry = $con->query("SELECT * FROM department_creation WHERE department_id ='".$department_id[$i]."' AND FIND_IN_SET($company_id[$i], company_id) > 0 AND status = 0");
        while($row12 = $getqry->fetch_assoc())
        {      
            $company_idArr[] = $row12["company_id"];          
            $company_NameArr[] = getCompanyName($con, $row12["company_id"]);          
            $department_idArr[] = $row12["department_id"];          
            $department_nameArr[] = $row12["department_name"];          
        }
    }
}
?>
<style>
    .table td {
    border-top: 1px solid #d3d9e0;
    vertical-align: middle;
    padding: 0.2rem 1rem;
}
.table th {
    padding: 0.2rem 1rem;
    font-weight: 600;
    border-bottom: 2px solid #d3d9e0;
}
</style>
<div class="ml-2">
    <div class="table-responsive" style="height:120px;">
        <table class="table">
            <thead>
                <tr>
                    <th>S. No.</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sno = 1;   
            if(isset($department_idArr)){
                for($o=0; $o<=sizeof($department_idArr)-1; $o++){ ?>
                <tr>
                    <input type="hidden" id="receivingDeptId" name="receivingDeptId[]" value="<?php echo $department_idArr[$o]; ?>" >
                    <input type="hidden" id="receivingCompanyId" name="receivingCompanyId[]" value="<?php echo $company_idArr[$o]; ?>" >
                    <td><?php echo $sno; ?></td>
                    <td><?php echo $department_nameArr[$o]." - ".$company_NameArr[$o]; ?></td>
                    <td><span class="deleterow icon-trash-2" tabindex="2"></span></td>
                </tr>
                <?php 
                $sno = $sno + 1; 
                }
            } ?>
            </tbody>
        </table>
    </div>
</div> 