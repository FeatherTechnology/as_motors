<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_POST["company_id"])){
	$company_id = $_POST["company_id"];
}

function getCompanyName($con, $company_id){
    $branch_name = '';
    $getname = $con->query("SELECT branch_name FROM branch_creation WHERE branch_id = '".$company_id."' ");
    while ($row = $getname->fetch_assoc()) {
        $branch_name = $row["branch_name"];
    }
    return $branch_name;
}

// convert string to array
$companyId = array_map('intval', explode(',', $company_id));

$department_id = array();
$department_name = array();
// get department id
foreach($companyId as $key => $val){ 
    $getInstName=$con->query("SELECT department FROM basic_creation WHERE status = 0 AND FIND_IN_SET($val, company_id) > 0 ");
    while($row=$getInstName->fetch_assoc()){
        $department_id[]    = $row["department"];
    } 
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
    $getqry = $con->query("SELECT company_id, department_name FROM department_creation WHERE department_id ='".strip_tags($department[$i])."' and status = 0");
    while($row1 = $getqry->fetch_assoc())
    {      
        $branch_id[] = $row1["company_id"];          
        $branch_name[] = getCompanyName($con, $row1["company_id"]);          
        $department_name[] = $row1["department_name"];          
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
                    <td style="border-style : hidden!important; display: none;"><input tabindex="3" type="text" name="branch_id[]" id="branch_id" class="branch_id" value="<?php echo $branch_id[$o]; ?>" /></td>
                    <td style="border-style : hidden!important;"><input readonly type="text" style="border: 0; outline:none; background-color: #f7f8fa;" class="form-control" value="<?php echo $department_name[$o].' - '.$branch_name[$o]; ?>" name="department_name[]" id="department_name"></td>
                </tbody>
                <?php 
            }
        } ?>
    </table>
</div>

<script>
    // Get Department based staff
	$(".checkedid").click(function(){ 
        
        // var company_ids = branch.getValue();
        // var company_id = '';
        // for(var i=0;i<company_ids.length;i++){
		// 	if (i > 0) {
		// 		company_id += ',';
        //     }
        //     company_id += company_ids[i].value; 
        // }

        var department_id = [];
        var company_id = [];
        $(':checkbox:checked').each(function(i){
            department_id[i] = $(this).val(); 
            company_id[i] = $(this).parents('tr').find('td #branch_id').val();
        });

        if(department_id.length > 0){
            $.ajax({
                url: 'businesscomFile/ajaxGetDeptBasedStaff.php',
                type: 'post',
                data: { "company_id":company_id, "department_id":department_id},
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