<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["company_id"])){
	$company_id = $_POST["company_id"];
}
if(isset($_POST["staff_id"])){
	$staff_id = $_POST["staff_id"]; 
}

$staff_idArr = array();
$staff_nameArr = array();
$emp_codeArr = array();

foreach($staff_id as $key => $val){

    $getInstName=$con->query("SELECT * FROM staff_creation WHERE FIND_IN_SET($company_id, company_id) > 0 AND staff_id ='".$val."' AND status = 0");
    while($row2=$getInstName->fetch_assoc()){
        $staff_idArr[]    = $row2["staff_id"];
        $staff_nameArr[]    = $row2["staff_name"];
        $emp_codeArr[]    = $row2["emp_code"];
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
                        <th>Emp Code</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sno = 1;   
                if(isset($staff_id)){
                    for($o=0; $o<=sizeof($staff_id)-1; $o++){ ?>
                    <tr>
                        <input type="hidden" id="afterNotifiedStaffId" name="afterNotifiedStaffId[]" value="<?php echo $staff_idArr[$o]; ?>" >
                        <td><?php echo $sno; ?></td>
                        <td><?php echo $staff_nameArr[$o]; ?></td>
                        <td><?php echo $emp_codeArr[$o]; ?></td>
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