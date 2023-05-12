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

$department_idArr = array();
$department_nameArr = array();

foreach($department_id as $key => $val){
    $getqry = $con->query("SELECT * FROM department_creation WHERE department_id ='".$val."' and status = 0");
    while($row12 = $getqry->fetch_assoc())
    {      
        $department_idArr[] = $row12["department_id"];          
        $department_nameArr[] = $row12["department_name"];          
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
            if(isset($department_id)){
                for($o=0; $o<=sizeof($department_id)-1; $o++){ ?>
                <tr>
                    <input type="hidden" id="receivingDeptId" name="receivingDeptId[]" value="<?php echo $department_idArr[$o]; ?>" >
                    <td><?php echo $sno; ?></td>
                    <td><?php echo $department_nameArr[$o]; ?></td>
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