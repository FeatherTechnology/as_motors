<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
} 
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
}

$sCompanyBranchDetail = $userObj->getsCompanyBranchDetail($mysqli, $sbranch_id);
$departmentList1 = $userObj->getDepartment1($mysqli,$sbranch_id);

$compnayNameBranchBased = $userObj->getCompnayNameBranchBased($mysqli);
$departmentList = $userObj->getDepartment($mysqli); 
$designationList = $userObj->getDesignation($mysqli); 
$designationListSession = $userObj->getDesignationSession($mysqli, $sbranch_id);

$id=0;
if(isset($_POST['submitaudit_creation']) && $_POST['submitaudit_creation'] != '')
{
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
    $updateAuditAreaCreationmaster = $userObj->updateAuditAreaCreation($mysqli,$id,$userid);  
    ?>
    <script>location.href='<?php echo $HOSTPATH; ?>edit_audit_area_creation&msc=2';</script> 
    <?php	}
    else{   
		$addAuditAreaCreation = $userObj->addAuditAreaCreation($mysqli,$userid);   
        ?>
    <script>location.href='<?php echo $HOSTPATH; ?>edit_audit_area_creation&msc=1';</script>
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
	$deleteAuditAreaCreation = $userObj->deleteAuditAreaCreation($mysqli,$del,$userid); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_audit_area_creation&msc=3';</script>
<?php	
}

if(isset($_GET['upd']))
{
    $idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{
	$getAuditAreaCreation = $userObj->getAuditAreaCreation($mysqli,$idupd); 
	if (sizeof($getAuditAreaCreation)>0) {
        for($audit=0;$audit<sizeof($getAuditAreaCreation);$audit++)  {

            $audit_area_id                  = $getAuditAreaCreation['audit_area_id']; 
			$audit_area    	                = $getAuditAreaCreation['audit_area'];
			$department_id                	 = $getAuditAreaCreation['department_id'];
            $calendar                	     = $getAuditAreaCreation['calendar'];
            $from_date    	                     = date('Y-m-d',strtotime($getAuditAreaCreation['from_date'])); 
			$to_date    	                     = date('Y-m-d',strtotime($getAuditAreaCreation['to_date'])); 
            $role1                	     = $getAuditAreaCreation['role1'];
			$role2    	                = $getAuditAreaCreation['role2'];
			$frequency    	                = $getAuditAreaCreation['frequency'];
			$check_list    	                = $getAuditAreaCreation['check_list'];
			$frequency_applicable    	                = $getAuditAreaCreation['frequency_applicable'];
		}
	}

    $req_array = '';
    $req_array = explode(',',$department_id);
    ?>

    <input type="hidden" id="calendarEdit" name="calendarEdit" value="<?php print_r($calendar); ?>" >
    <input type="hidden" id="frequencyEdit" name="frequencyEdit" value="<?php print_r($frequency); ?>" >
    <script>
        // enable disable calendar
        window.onload=editCompanyBasedBranch;
        function editCompanyBasedBranch(){  
            
            var calendar = $('#calendarEdit').val();
            if(calendar == 'Yes'){ 
                $('#from_date').attr("readonly",false);
                $('#to_date').attr("readonly",false);
            } else if(calendar == 'No'){ 
                $('#from_date').attr("readonly",true);
                $('#to_date').attr("readonly",true);
                $('#from_date').val('');
                $('#to_date').val('');
            }

            // enable and disable frequency
            var frequency = $('#frequencyEdit').val(); 
            if(frequency == 'Fortnightly' || frequency == 'Monthly' || frequency == 'Quaterly' || frequency == 'Half Yearly' ){
                $('#frequency_applicable').attr("disabled",false);
            } else  if(frequency == 'Daily Task' || frequency == 'Yearly'){ 
                $('#frequency_applicable').prop('checked', false);
                $('#frequency_applicable').attr("disabled",true);
            }
        }
    </script>
<?php } ?>

<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Audit Area - Scope</li>
    </ol>

    <a href="edit_audit_area_creation">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    </a>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
<!--------form start-->
    <form id = "audit_area_creation" name="audit_area_creation" action="" method="post" enctype="multipart/form-data"> 
        <input type="hidden" class="form-control" value="<?php if(isset($audit_area_id)) echo $audit_area_id ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id">
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
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Audit Area</label>
                                            <input type="text" class="form-control" tabindex="1" id="audit_area" name="audit_area" 
                                            value="<?php if(isset($audit_area)) echo $audit_area; ?>" placeholder="Enter Audit Area">                                
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Department Name</label>
                                            <?php if($sbranch_id == 'Overall'){ ?>
                                                <select tabindex="3" type="text" class="form-control" id="department_id" name="department_id[]" multiple >
                                                    <?php if (sizeof($departmentList)>0) { 
                                                        for($j=0;$j<count($departmentList);$j++) { ?>
                                                        <option <?php if(isset($req_array)) { for ($i=0; $i < count($req_array); $i++){
                                                                    if($departmentList[$j]['department_id'] == $req_array[$i] ) echo "selected"; } }  ?>
                                                            value="<?php echo $departmentList[$j]['department_id']; ?>">
                                                        <?php echo $departmentList[$j]['department_name'] . ' - ' ;
                                                        for($k=0;$k<count($compnayNameBranchBased);$k++){
                                                            if($departmentList[$j]['company_id'] == $compnayNameBranchBased[$k]['branch_id']){
                                                                echo $compnayNameBranchBased[$k]['company_name'];
                                                            }
                                                        }
                                                        ?></option>
                                                    <?php } } ?> 
                                            </select> 
                                            <?php } else if($sbranch_id != 'Overall'){ ?>
                                                <select tabindex="3" type="text" class="form-control" id="department_id" name="department_id[]" multiple >
                                                <?php if (sizeof($departmentList1)>0) { 
                                                for($j=0;$j<count($departmentList1);$j++) { ?>
                                                <option <?php if(isset($req_array)) { for ($i=0; $i < count($req_array); $i++){
                                                            if($departmentList1[$j]['department_id'] == $req_array[$i] ) echo "selected";   }}  ?>
                                                    value="<?php echo $departmentList1[$j]['department_id']; ?>">
                                                <?php echo $departmentList1[$j]['department_name']; ?></option>
                                                <?php }} ?> 
                                            </select> 
                                            <?php } ?>
                                        </div>
                                    </div>      
                                                          
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Frequency</label>
                                            <select type="text" class="form-control frequency" id="frequency" name="frequency" tabindex="4" >
                                                <option value="">Select Frequency</option> 
                                                <option <?php if(isset($frequency)) { if('Fortnightly' == $frequency) echo 'selected';  ?> value="<?php echo 'Fortnightly' ?>">
                                                <?php echo 'Fortnightly'; }else{ ?> <option value="Fortnightly">Fortnightly</option>   <?php } ?></option>
                                                <option <?php if(isset($frequency)) { if('Monthly' == $frequency) echo 'selected';  ?> value="<?php echo 'Monthly' ?>">
                                                <?php echo 'Monthly'; }else{ ?> <option value="Monthly">Monthly</option> <?php } ?></option> 
                                                <option <?php if(isset($frequency)) { if('Quaterly' == $frequency) echo 'selected';  ?> value="<?php echo 'Quaterly' ?>">
                                                <?php echo 'Quaterly'; }else{ ?> <option value="Quaterly">Quaterly</option> <?php } ?></option> 
                                                <option <?php if(isset($frequency)) { if('Half Yearly' == $frequency) echo 'selected';  ?> value="<?php echo 'Half Yearly' ?>">
                                                <?php echo 'Half Yearly'; }else{ ?> <option value="Half Yearly">Half Yearly</option> <?php } ?></option> 
                                                <option <?php if(isset($frequency)) { if('Yearly' == $frequency) echo 'selected';  ?> value="<?php echo 'Yearly' ?>">
                                                <?php echo 'Yearly'; }else{ ?> <option value="Yearly">Yearly</option> <?php } ?></option> 
                                                <option <?php if(isset($frequency)) { if('Daily Task' == $frequency) echo 'selected';  ?> value="<?php echo 'Daily Task' ?>">
                                                <?php echo 'Daily Task'; }else{ ?> <option value="Daily Task">Daily Task</option> <?php } ?></option>  
                                            </select> 
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 mt-3" >
										<div class="form-group">
                                            <input disabled type="checkbox" tabindex="7" name="frequency_applicable" id="frequency_applicable" value="frequency_applicable" <?php if($idupd > 0){ if($frequency_applicable== 'frequency_applicable'){ echo'checked'; }} ?>> &nbsp;&nbsp; <label for="frequency_applicable">Is it applicable for all months</label>
										</div>
									</div>

                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Calendar</label>
                                             <select tabindex="9" type="text" class="form-control calendar" id="calendar" name="calendar" >
                                                <option value=''>Select Calendar</option>
                                                <option <?php if(isset($calendar)) { if('Yes' == $calendar) echo 'selected';  ?> value="<?php echo 'Yes' ?>">
                                                <?php echo 'Yes'; } else { ?> <option value="Yes">Yes</option>   <?php } ?></option>
                                                <option <?php if(isset($calendar)) { if('No' == $calendar) echo 'selected';  ?> value="<?php echo 'No' ?>">
                                                <?php echo 'No'; } else { ?> <option value="No">No</option> <?php } ?></option> 
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="from_date">Start Date & End Date</label>
                                            <div class="form-inline">
                                                <input readonly type="date" tabindex="8" name="from_date" id="from_date" placeholder="From" class="form-control" value="<?php if(isset($from_date)) { if($calendar == 'Yes') { echo $from_date; } else { echo ""; } } ?>" >&nbsp;&nbsp;
                                                <span>To</span>&nbsp;&nbsp;<input readonly type="date" tabindex = "9" name="to_date" id="to_date" placeholder="To" class="form-control" value="<?php if(isset($to_date)) { if($calendar == 'Yes') { echo $to_date; } else { echo ""; } } ?>" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                        <label for="disabledInput">Role 1</label> <span style="color:green;font-weight: bold;">* Who is doing the audit </span>
                                            <?php if($sbranch_id == 'Overall'){ ?>
                                            <select tabindex="2" type="text" class="form-control" id="role1" name="role1" tabindex="1" >
                                                <option value="">Select Role 1</option>     
                                                <?php if (sizeof($designationList)>0) { 
                                                    for($j=0;$j<count($designationList);$j++) { ?>
                                                        <option <?php if(isset($role1)) { 
                                                            if($designationList[$j]['designation_id'] == $role1 ) echo "selected"; } ?> 
                                                            value="<?php echo $designationList[$j]['designation_id']; ?>">
                                                            <?php echo $designationList[$j]['designation_name'] . ' - ' ;
                                                            for($k=0;$k<count($compnayNameBranchBased);$k++){
                                                                if($designationList[$j]['company_id'] == $compnayNameBranchBased[$k]['branch_id']){
                                                                    echo $compnayNameBranchBased[$k]['company_name'];
                                                                }
                                                            }
                                                        ?></option>
                                                    <?php } } ?> 
                                            </select>
                                            <?php } else if($sbranch_id != 'Overall'){ ?>
                                                <select tabindex="2" type="text" class="form-control" id="role1" name="role1" tabindex="1" >
                                                    <option value="">Select Role 1</option>     
                                                    <?php if (sizeof($designationListSession)>0) { 
                                                    for($j=0;$j<count($designationListSession);$j++) { ?>
                                                    <option <?php if(isset($role1)) { if($designationListSession[$j]['designation_id'] == $role1 )  echo 'selected'; }  ?>
                                                    value="<?php echo $designationListSession[$j]['designation_id']; ?>">
                                                    <?php echo $designationListSession[$j]['designation_name'];?></option>
                                                    <?php }} ?>
                                                </select>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Role 2</label> <span style="color:green;font-weight: bold;">* Who is giving the response </span>
                                            <?php if($sbranch_id == 'Overall'){ ?>
                                                <select tabindex="2" type="text" class="form-control" id="role2" name="role2" tabindex="1" >
                                                    <option value="">Select Role 1</option>     
                                                    <?php if (sizeof($designationList)>0) { 
                                                        for($j=0;$j<count($designationList);$j++) { ?>
                                                            <option <?php if(isset($role2)) { 
                                                                if($designationList[$j]['designation_id'] == $role2 ) echo "selected"; } ?> 
                                                                value="<?php echo $designationList[$j]['designation_id']; ?>">
                                                                <?php echo $designationList[$j]['designation_name'] . ' - ' ;
                                                                for($k=0;$k<count($compnayNameBranchBased);$k++){
                                                                    if($designationList[$j]['company_id'] == $compnayNameBranchBased[$k]['branch_id']){
                                                                        echo $compnayNameBranchBased[$k]['company_name'];
                                                                    }
                                                                }
                                                            ?></option>
                                                        <?php } } ?> 
                                                </select>
                                            <?php } else if($sbranch_id != 'Overall'){ ?>
                                                <select tabindex="2" type="text" class="form-control" id="role2" name="role2" tabindex="1" >
                                                    <option value="">Select Role 1</option>     
                                                    <?php if (sizeof($designationListSession)>0) { 
                                                    for($j=0;$j<count($designationListSession);$j++) { ?>
                                                    <option <?php if(isset($role2)) { if($designationListSession[$j]['designation_id'] == $role2 )  echo 'selected'; }  ?>
                                                    value="<?php echo $designationListSession[$j]['designation_id']; ?>">
                                                    <?php echo $designationListSession[$j]['designation_name'];?></option>
                                                    <?php }} ?>
                                                </select>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mt-4">
                                        <div class="form-group">
                                            <label for="disabledInput">Check List </label> &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input  type="radio" tabindex="7" checked name="check_list" id="yes" value="Yes" <?php if(isset($check_list ))
                                            echo ($check_list =='Yes')?'checked':'' ?>> &nbsp;&nbsp; <label for="yes">Yes </label> &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input  type="radio" tabindex="8" name="check_list" id="no"  value="No" <?php if(isset($check_list ))
                                            echo ($check_list =='No')?'checked':'' ?>> &nbsp;&nbsp; <label for="no">No</label>
                                        </div>
                                    </div> 
                                </div>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <br><br>
                            <div class="text-right">
                                <button type="submit" name="submitaudit_creation" id="submitaudit_creation" class="btn btn-primary" value="Submit" tabindex="9">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary" tabindex="10">Cancel</button>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>



