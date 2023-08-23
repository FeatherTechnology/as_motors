<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
} 
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
    $sCompanyBranchDetail = $userObj->getsCompanyBranchDetail($mysqli, $sbranch_id);
} 

$companyName = $userObj->getCompanyName($mysqli);
$departmentList = $userObj->getDepartment($mysqli); 
$companyList = $userObj->getCompanyName($mysqli);

$id=0;
if(isset($_POST['submittag_creation']) && $_POST['submittag_creation'] != '')
{
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
        $updatePermissionOnDuty = $userObj->updatePermissionOnDuty($mysqli,$id,$userid);  
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_permission_or_on_duty&msc=2';</script> 
    <?php }
    else{   
        $addPermissionOnDuty = $userObj->addPermissionOnDuty($mysqli,$userid);   
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_permission_or_on_duty&msc=1';</script>
        <?php
    }
}   

$del=0;
if(isset($_GET['del']))
{
$del=$_GET['del'];
}
if($del>0)
{
	$deletePermissionOnDuty = $userObj->deletePermissionOnDuty($mysqli,$del,$userid); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_permission_or_on_duty&msc=3';</script>
<?php	
}

if(isset($_GET['upd']))
{
    $idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{ 
	$getPermissionOnDuty = $userObj->getPermissionOnDuty($mysqli,$idupd); 
	
	if (sizeof($getPermissionOnDuty)>0) {
        for($itag=0;$itag<sizeof($getPermissionOnDuty);$itag++)  {

            $permission_on_duty_id                  = $getPermissionOnDuty['permission_on_duty_id']; 
            $company_id                	     = $getPermissionOnDuty['company_id'];
			$department                	 = $getPermissionOnDuty['department_id'];
			$staff_id    	     = $getPermissionOnDuty['staff_id'];
			$staff_code    	     = $getPermissionOnDuty['staff_code'];
			$reporting    	     = $getPermissionOnDuty['reporting'];
			$reporting_name    	     = $getPermissionOnDuty['reporting_name'];
			$reason    	     = $getPermissionOnDuty['reason'];
			$permission_from_time    	     = $getPermissionOnDuty['permission_from_time'];
			$permission_to_time    	     = $getPermissionOnDuty['permission_to_time'];
			$permission_date    	     = $getPermissionOnDuty['permission_date'];
			$on_duty_place    	     = $getPermissionOnDuty['on_duty_place'];
			$leave_date    	     = $getPermissionOnDuty['leave_date'];
			$leave_reason    	     = $getPermissionOnDuty['leave_reason'];
		}
	} 
    $sCompanyBranchDetailEdit = $userObj->getsBranchBasedCompanyName($mysqli, $company_id);
    ?>

    <input type="text" id="branchIdEdit" name="branchIdEdit" value="<?php print_r($company_id); ?>" >
    <input type="text" id="departmentEdit" name="departmentEdit" value="<?php print_r($department); ?>" >
    <input type="text" id="staffIdEdit" name="staffIdEdit" value="<?php print_r($staff_id); ?>" >
    <input type="text" id="reasonEdit" name="reasonEdit" value="<?php print_r($reason); ?>" >

    <script language='javascript'>
        window.onload=editBranchBasedDept;
        function editBranchBasedDept(){ 
            // edit department name
            var branch_id = $("#branchIdEdit").val();
            var departmentEdit = $("#departmentEdit").val(); 

            $.ajax({
                url: 'tagFile/getDepartmentDetails.php',
                type: 'post',
                data: { "branch_id":branch_id },
                dataType: 'json',
                success: function(response){ 

                    $('#department_id').empty();
                    $('#department_id').prepend("<option value=''>" + 'Select Department' + "</option>");
                    var i = 0;
                    for (i = 0; i <= response.departmentId.length - 1; i++) {
                        var selected = "";
                        if(response['departmentId'][i] == departmentEdit)
                        {
                            selected = "selected";
                        }
                        $('#department_id').append("<option value='" + response['departmentId'][i] + "' "+selected+">" + response['departmentName'][i] + "</option>");
                    }
                }
            });
            
            editCompanyBasedBranch(branch_id);
            editDepartmentBasedStaff(branch_id, departmentEdit);
        }

        function editCompanyBasedBranch(branch_id){  
            $.ajax({
                url: 'R&RFile/ajaxEditCompanyBasedBranch.php',
                type:'post',
                data: {'branch_id': branch_id},
                dataType: 'json',
                success: function(response){
                    
                    $("#branch_id").empty();
                    $("#branch_id").prepend("<option value='' disabled selected>"+'Select Branch Name'+"</option>");
                    var r = 0;
                    for (r = 0; r <= response.branch_id.length - 1; r++) { 
                        var selected = "";
                        if(response['branch_id'][r] == branch_id)
                        {
                            selected = "selected";
                        }
                        $('#branch_id').append("<option value='" + response['branch_id'][r] + "' "+selected+">" + 
                        response['branch_name'][r] + "</option>");
                    }
                }
            });
        }

        function editDepartmentBasedStaff(company_id, department_id){  

            var staffIdEdit = $("#staffIdEdit").val(); 
            $.ajax({
                url: 'StaffFile/ajaxGetDeptBasedStaff.php',
                type:'post',
                data: { "company_id":company_id, "department_id":department_id },
                dataType: 'json',
                success: function(response){
                    
                    $("#staff_name").empty();
                    $("#staff_name").prepend("<option value='' disabled selected>"+'Select Staff Name'+"</option>");
                    var r = 0;
                    for (r = 0; r <= response.staff_id.length - 1; r++) { 
                        var selected = "";
                        if(response['staff_id'][r] == staffIdEdit)
                        {
                            selected = "selected";
                        }
                        $('#staff_name').append("<option value='" + response['staff_id'][r] + "' "+selected+">" + 
                        response['staff_name'][r] + "</option>");
                    }
                }
            });

            var reason = $("#reasonEdit").val(); 
            if(reason == "Permission"){
                $(".permissionCls").css("display", "block");
                $(".staffreason").css("display", "block");
                $(".on_dutyCls").css("display", "none");
                $(".leaveCls").css("display", "none");
            }else if(reason == "On Duty"){
                $(".permissionCls").css("display", "none");
                $(".on_dutyCls").css("display", "block");
                $(".leaveCls").css("display", "none");
                $(".staffreason").css("display", "none");
            }else if(reason == "Leave"){
                $(".permissionCls").css("display", "none");
                $(".on_dutyCls").css("display", "none");
                $(".leaveCls").css("display", "block");
                $(".staffreason").css("display", "block");
            }else if(reason == ""){
                $(".permissionCls").css("display", "none");
                $(".on_dutyCls").css("display", "none");
                $(".leaveCls").css("display", "none");
                $(".staffreason").css("display", "none");
            }
        }

    </script>

<?php
}
?>
   
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Regularisation </li>
    </ol>

    <a href="edit_permission_or_on_duty">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    </a>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
<!--------form start-->
    <form id = "permission_or_on_duty" name="permission_or_on_duty" action="" method="post" enctype="multipart/form-data"> 
    <input type="hidden" class="form-control" value="<?php if(isset($permission_on_duty_id)) echo $permission_on_duty_id ?>" id="id" name="id" aria-describedby="id" placeholder="Enter id">
 		<!-- Row start -->
         <div class="row gutters">

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
					<div class="card-header">
						<!-- <div class="card-title">General Info</div> -->
					</div>
                    <div class="card-body">

                    	 <div class="row ">
                            <!--Fields -->
                           <div class="col-md-12 "> 
                              <div class="row">
                            
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Regularisation Number</label>
                                            <input type="text" name="reg_auto_gen_no" id="reg_auto_gen_no" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Company Name</label>
                                            <?php if($sbranch_id == 'Overall'){ ?>
                                                <select tabindex="1" type="text" class="form-control" id="company_id" name="company_id" >
                                                    <option value="">Select Company Name</option>   
                                                        <?php if (sizeof($companyName)>0) { 
                                                        for($j=0;$j<count($companyName);$j++) { ?>
                                                        <option <?php if(isset($sCompanyBranchDetailEdit['company_id'])) { 
                                                            if($companyName[$j]['company_id'] == $sCompanyBranchDetailEdit['company_id']) echo 'selected'; } ?> 
                                                            value="<?php echo $companyName[$j]['company_id']; ?>">
                                                        <?php echo $companyName[$j]['company_name'];?></option>
                                                        <?php }} ?>  
                                                </select>  
                                            <?php } else if($sbranch_id != 'Overall'){ ?>
                                                <select disabled tabindex="1" type="text" class="form-control" id="company_id" name="company_id"  >
                                                    <option value="<?php echo $sbranch_id; ?>"><?php echo $sCompanyBranchDetail['company_name']; ?></option> 
                                                </select> 
                                            <?php } ?>
                                        </div>
                                    </div>
                                    
                                   <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Branch Name</label>
                                            <?php if($sbranch_id == 'Overall'){ ?>
                                                <select tabindex="2" type="text" class="form-control" id="branch_id" name="branch_id" >
                                                    <option value="" disabled selected>Select Branch Name</option> 
                                                </select> 
                                            <?php } else if($sbranch_id != 'Overall'){ ?>
                                                <input type="hidden" name="branch_id" id="branch_id" class="form-control" value="<?php echo $sbranch_id; ?>" >
                                                <select disabled tabindex="2" type="text" class="form-control" id="branch_id1" name="branch_id1" >
                                                    <option value="<?php echo $sbranch_id; ?>"><?php echo $sCompanyBranchDetail['branch_name']; ?></option> 
                                                </select> 
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <?php if($idupd<=0){ ?>

                                        <script language='javascript'> 
                                            window.onload=getdepartmentLoad;
                                            
                                            function getdepartmentLoad(){ 
                                                var company_id = $("#branch_id").val();
                                                if(company_id.length==''){
                                                    $("#branch_id").val('');
                                                }else{
                                                    $.ajax({
                                                        url: 'StaffFile/ajaxStaffDepartmentDetails.php',
                                                        type: 'post',
                                                        data: { "company_id":company_id },
                                                        dataType: 'json',
                                                        success:function(response){ 

                                                        $('#department').empty();
                                                        $('#department').prepend("<option value=''>" + 'Select Department Name' + "</option>");
                                                        var r = 0;
                                                        for (r = 0; r <= response.department_id.length - 1; r++) { 
                                                            $('#department').append("<option value='" + response['department_id'][r] + "'>" + response['department_name'][r] + "</option>");
                                                        }
                                                        }
                                                    });
                                                }
                                            }
                                        </script>


                                         <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Department</label>
                                                <select tabindex="3" type="text" class="form-control" id="department" name="department" >
                                                    <option value="">Select Department</option>   
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if($idupd>0){ ?>
                                         <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Department</label>
                                                <select tabindex="3" type="text" class="form-control" id="department" name="department" >
                                                    <option value="">Select Department</option>
                                                    <?php if (sizeof($departmentList)>0) { 
                                                    for($j=0;$j<count($departmentList);$j++) { ?>
                                                    <option <?php if(isset($department)) { if($departmentList[$j]['department_id'] == $department)  echo 'selected'; }  ?>
                                                    value="<?php echo $departmentList[$j]['department_id']; ?>">
                                                    <?php echo $departmentList[$j]['department_name'];?></option>
                                                    <?php }} ?> 
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Staff Name</label>
                                            <select id="staff_name" name="staff_name" class="form-control" tabindex="4">
                                                <option value="">Select Staff Name</option>
                                            </select>   
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Staff Code</label>
                                            <input type="text" readonly id="staff_code" name="staff_code" class="form-control" value="<?php if(isset($staff_code)) echo $staff_code; ?>" placeholder="Enter Staff Code">
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Reporting</label>
                                            <input type="hidden" readonly id="reporting" name="reporting" class="form-control" value="<?php if(isset($reporting)) echo $reporting; ?>">  
                                            <input type="text" readonly id="reporting_name" name="reporting_name" class="form-control" value="<?php if(isset($reporting_name)) echo $reporting_name; ?>" placeholder="Enter Reporting Staff">  
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                              
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Type</label>
                                            <select tabindex="3" type="text" class="form-control" id="reason" name="reason" >
                                                <option value="">Select Type</option>   
                                                <option <?php if(isset($reason)) { if('Permission' == $reason) echo 'selected'; ?> value="<?php echo 'Permission' ?>">
                                                <?php echo 'Permission'; }else{ ?> <option value="Permission">Permission</option> <?php } ?></option>
                                                <option <?php if(isset($reason)) { if('On Duty' == $reason) echo 'selected';  ?> value="<?php echo 'On Duty' ?>">
                                                <?php echo 'On Duty'; }else{ ?> <option value="On Duty">On Duty</option> <?php } ?></option> 
                                                <option <?php if(isset($reason)) { if('Leave' == $reason) echo 'selected';  ?> value="<?php echo 'Leave' ?>">
                                                <?php echo 'Leave'; }else{ ?> <option value="Leave">Leave</option> <?php } ?></option> 
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 permissionCls" style="display: none;" >
                                        <div class="form-group">
                                            <label for="permission_from_time">Start Time & End Time</label> 
                                            <div class="form-inline">
                                                <input type="time" tabindex = "8" name="permission_from_time" id="permission_from_time" class="form-control" value="<?php if (isset($permission_from_time)) echo $permission_from_time;?>">&nbsp;&nbsp;
                                                <span>To</span>&nbsp;&nbsp;<input type="time" tabindex = "9" name="permission_to_time" id="permission_to_time" class="form-control"  value="<?php if (isset($permission_to_time)) echo $permission_to_time;?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 permissionCls" style="display: none;" >
                                        <div class="form-group">
                                            <label for="permission_date">Permission Date</label> 
                                            <input type="date" tabindex = "8" name="permission_date" id="permission_date" class="form-control"  value="<?php if (isset($permission_date)) echo $permission_date;?>">
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 on_dutyCls" style="display: none;" >
                                        <div class="form-group">
                                            <label for="place">Place</label> 
                                            <input type="text" id="on_duty_place" name="on_duty_place" class="form-control" value="<?php if(isset($on_duty_place)) echo $on_duty_place; ?>" placeholder="Enter On Duty Place">  
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 leaveCls" style="display: none;" >
                                        <div class="form-group">
                                            <label for="leave_date">Leave Date</label> 
                                            <input type="date" tabindex = "8" name="leave_date" id="leave_date" class="form-control"  value="<?php if (isset($leave_date)) echo $leave_date;?>">
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 staffreason" style="display: none;" >
                                        <div class="form-group">
                                            <label for="place">Reason</label> 
                                            <textarea tabindex="1" id="leave_reason" name="leave_reason" class="form-control" placeholder="Enter Reason" rows="4" cols="50" value="<?php if(isset($leave_reason)) echo $leave_reason; ?>"><?php if(isset($leave_reason)) echo $leave_reason; ?></textarea>
                                        </div>
                                    </div>

                                </div>
                                <br>
                                
                            </div>
                        </div>

                        <div class="col-md-12">
                            <br><br>
                            <div class="text-right">
                                <button type="submit" name="submittag_creation" id="submittag_creation" class="btn btn-primary" value="Submit" tabindex="11">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary" tabindex="12">Cancel</button>
                            </div>
                        </div>

                    </div>
                    
                </div>
            </div>
        </div>
    </form>

</div>

