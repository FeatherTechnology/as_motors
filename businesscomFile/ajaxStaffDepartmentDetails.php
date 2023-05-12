<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["company_id"])){
	$company_id = $_POST["company_id"];
}

$department_id = array();
$department_name = array();

// get department_id and Designation_id based on
$getInstName=$con->query("SELECT department FROM basic_creation WHERE status = 0 AND FIND_IN_SET($company_id, company_id) > 0 ");
while($row2=$getInstName->fetch_assoc()){
    $department_id[]    = $row2["department"];
} 

// remove array duplicates without affect array index
$department=$department_id;
$duplicated=array();

foreach($department as $k=>$v) {

if( ($kt=array_search($v,$department))!==false and $k!=$kt )
{ unset($department[$kt]);  $duplicated[]=$v; }

}
sort($department); // optional
// end here

for($i=0; $i<=sizeof($department)-1; $i++){
    $getqry = "SELECT department_name FROM department_creation WHERE department_id ='".strip_tags($department[$i])."' and status = 0";
    $res12 = $con->query($getqry);
    while($row12 = $res12->fetch_assoc())
    {      
        $department_name[] = $row12["department_name"];          
    }
} 

?>

<div class="ml-2">
    <table class="border-collapse:collapse">
        <?php  
        if(isset($department)){
            for($o=0; $o<=sizeof($department)-1; $o++){ ?>
                <tbody>
                    <td style="border-style : hidden!important;"><input tabindex="3" type="checkbox" name="checkedid[]" id="checkedid" class="departmentIdCheckboxCheckbox checkedid" value="<?php echo $department[$o]; ?>" /></td>
                    <td style="border-style : hidden!important;"><input readonly type="text" style="border: 0; outline:none; background-color: #f7f8fa;" class="form-control" value="<?php echo $department_name[$o]; ?>" name="department_name[]" id="department_name"></td>
                </tbody>
                <?php 
            }
        } ?>
    </table>
</div>

<script>
    // Get Department based staff
	$(".checkedid").click(function(){ 

        var company_id = $("#branch_id").val();
        var department_id = [];
        $(':checkbox:checked').each(function(i){
            department_id[i] = $(this).val(); 
        });

        if(department_id.length > 0){
            $.ajax({
                url: 'approvalrequisitionFile/ajaxGetDeptBasedStaff.php',
                type: 'post',
                data: { "company_id":company_id, "department_id":department_id },
                success:function(html){ 

                    $("#staff_append").empty();
                    $("#staff_append").html(html);
                    // $("#staff_append").append(html);
                }
            });
        }else if(department_id.length == ''){ 
            $("#staff_append").empty();
        }
	});
</script>