<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
} 
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
    $sCompanyBranchDetail = $userObj->getCompanyBranchDetail($mysqli, $sbranch_id);
} 

$companyName = $userObj->getcompanyName($mysqli);
$branchName = $userObj->getBranchName($mysqli);
$departmentList = $userObj->getDepartment($mysqli); 
$companyList = $userObj->getCompanyName($mysqli);

$id=0;
if(isset($_POST['submitTransferLocation']) && $_POST['submitTransferLocation'] != '')
{
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
        $updateTransferLocation = $userObj->updateTransferLocation($mysqli,$id,$userid);  
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_transfer_location&msc=2';</script> 
    <?php }
    else{   
        $addTransferLocation = $userObj->addTransferLocation($mysqli,$userid);   
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_transfer_location&msc=1';</script>
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
	$deleteTransferLocation = $userObj->deleteTransferLocation($mysqli,$del,$userid); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_transfer_location&msc=3';</script>
<?php	
}

if(isset($_GET['upd']))
{
    $idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{ 
	$getTransferLocation = $userObj->getTransferLocation($mysqli,$idupd); 
	
	if (sizeof($getTransferLocation)>0) {
        for($itag=0;$itag<sizeof($getTransferLocation);$itag++)  {

            $transfer_location_id                  = $getTransferLocation['transfer_location_id']; 
            $company_id                	     = $getTransferLocation['company_id'];
			$department                	 = $getTransferLocation['department_id'];
			$staff_id    	     = $getTransferLocation['staff_id']; 
			$staff_code    	     = $getTransferLocation['staff_code'];
			$dot    	     = $getTransferLocation['dot'];
			$transfer_location    	     = $getTransferLocation['transfer_location'];
			$tef    	     = $getTransferLocation['transfer_effective_from'];
			$file    	     = $getTransferLocation['file'];
		}
	} 
    $sCompanyBranchDetailEdit = $userObj->getsBranchBasedCompanyName($mysqli, $company_id);
    ?>

    <input type="text" id="branchIdEdit" name="branchIdEdit" value="<?php print_r($company_id); ?>" >
    <input type="text" id="departmentEdit" name="departmentEdit" value="<?php print_r($department); ?>" >
    <input type="text" id="staffIdEdit" name="staffIdEdit" value="<?php print_r($staff_code); ?>" >
    <input type="text" id="reasonEdit" name="reasonEdit" value="<?php if(isset($reason))print_r($reason); ?>" >

    <script language='javascript'>
        window.onload=editPermissionOnDuty;
        function editPermissionOnDuty(){ 
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
            editDepartmentBasedStaffCode(branch_id, departmentEdit);
            // editEnableDisable();
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

        function editDepartmentBasedStaffCode(company_id, department_id){  

            var staffIdEdit = $("#staffIdEdit").val(); 
            $.ajax({
                url: 'StaffFile/ajaxGetDeptBasedStaff.php',
                type:'post',
                data: { "company_id":company_id, "department_id":department_id },
                dataType: 'json',
                success: function(response){
                    
                    $("#staff_code").empty();
                    $("#staff_code").prepend("<option value='' disabled selected>"+'Select Branch Name'+"</option>");
                    var r = 0;
                    for (r = 0; r <= response.staff_id.length - 1; r++) { 
                        var selected = "";
                        if(response['staff_id'][r] == staffIdEdit)
                        {
                            selected = "selected";
                        }
                        $('#staff_code').append("<option value='" + response['staff_id'][r] + "' "+selected+">" + 
                        response['emp_code'][r] + "</option>");
                    }
                }
            });
        }

    </script>

<?php
}
?>
   
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Transfer Location </li>
    </ol>

    <a href="edit_transfer_location">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    </a>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
<!--------form start-->
    <form id = "permission_or_on_duty" name="permission_or_on_duty" action="" method="post" enctype="multipart/form-data"> 
    <input type="hidden" class="form-control" value="<?php if(isset($transfer_location_id)) echo $transfer_location_id ?>" id="id" name="id" aria-describedby="id" placeholder="Enter id">
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
                                                    <option value="<?php echo $sCompanyBranchDetail['branch_id']; ?>"><?php echo $sCompanyBranchDetail['branch_name']; ?></option> 
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
                                            <label for="disabledInput">Staff Code</label>
                                            <select id="staff_code" name="staff_code" class="form-control" tabindex="4">
                                                <option value="">Select Staff Code</option>
                                            </select> 
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Staff Name</label>
                                            <input type="text" readonly id="staff_name" name="staff_name" class="form-control" value="<?php if(isset($staff_id)) echo $staff_id; ?>" placeholder="Enter Staff Name">
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">DOT</label>
                                            <input type="date" tabindex="5" name="dot" id="dot" placeholder="From" class="form-control"  value="<?php if (isset($dot)) echo $dot;?>">
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Transfer Location</label>
                                            <select id="transfer_location" name="transfer_location" class="form-control" tabindex="6">
                                                <option value="">Select Transfer Location</option>
                                            </select> 
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Transfer Effective From</label>
                                            <input type="date" tabindex="7" name="tef" id="tef" class="form-control" value="<?php if (isset($tef)) echo $tef;?>">
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Upload</label>
                                            <?php if(!isset($file) && $idupd <= 0){ ?>
                                                <input type="file" tabindex="8" class="form-control" id="file" name="file" ></input>
                                            <?php } else { ?>
                                                <input type="file" tabindex="8" class="form-control" id="file" name="file" ></input>   
                                                <input type="hidden" name="edit_file" id="edit_file" value="<?php echo $file; ?>" >
                                            <?php } ?>     
                                        </div>
                                    </div>

                                </div>
                                
                            </div>
                        </div>

                        <div class="col-md-12">
                        <br><br>
                        <div class="text-right">
                            <button type="submit" name="submitTransferLocation" id="submitTransferLocation" class="btn btn-primary" value="Submit" tabindex="9">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary" tabindex="10">Cancel</button>
                        </div>
                    </div>

                    </div>
                    
                    </div>
                </div>
            </div>
    </form>

</div>

