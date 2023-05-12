<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
} 
if(isset($_SESSION["staffid"])){
    $sstaffid = $_SESSION["staffid"];
}
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
    $sCompanyBranchDetail = $userObj->getsCompanyBranchDetail($mysqli, $sbranch_id);
} 

$companyName = $userObj->getCompanyName($mysqli);
$departmentList = $userObj->getDepartment($mysqli); 
$designationList = $userObj->getDesignation($mysqli);

$id=0;
if(isset($_POST['submitBusiness_line']) && $_POST['submitBusiness_line'] != '')
{
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
        $updatekraCreation = $userObj->updatekraCreation($mysqli,$id,$userid);  
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_business_com_approval_line&msc=2';</script> 
    <?php }
    else {   
        $addBusinessComLine = $userObj->addBusinessComLine($mysqli,$userid);   
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_business_com_approval_line&msc=1';</script>
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
	$deleteKraCreation = $userObj->deleteKraCreation($mysqli,$del,$userid); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_business_com_approval_line&msc=3';</script>
    <?php	
}

if(isset($_GET['upd']))
{
    $idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{
	$getkraCreation = $userObj->getkraCreation($mysqli,$idupd); 
	$totalweight = 0;
	if (sizeof($getkraCreation)>0) {
        for($isKra=0;$isKra<sizeof($getkraCreation);$isKra++)  {	
            $kra_id                          = $getkraCreation['kra_id'];
			$company_id                	     = $getkraCreation['company_id'];
            $department                      = $getkraCreation['department'];
			$designation		             = $getkraCreation['designation'];

			$kra_creation_ref_id		     = $getkraCreation['kra_creation_ref_id'];
			$kra_category		             = $getkraCreation['kra_category'];
			$weightage		                 = $getkraCreation['weightage'];
		}
	}

} 
?> 
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Approval Line - Business Communication (Outgoing) </li>
    </ol>

    <a href="edit_business_com_approval_line">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    </a>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
    <!-- form start -->
    <form id = "staff_creation" name="staff_creation" action="" method="post" enctype="multipart/form-data"> 
    <input type="hidden" class="form-control" value="<?php if(isset($sstaffid)) echo $sstaffid; ?>" id="sstaffid" name="sstaffid" aria-describedby="id" placeholder="Enter id">
    <input type="hidden" class="form-control" value="<?php if(isset($sbranch_id)) echo $sbranch_id; ?>" id="sbranch_id" name="sbranch_id" aria-describedby="id" placeholder="Enter id">
       
 		<!-- Row start -->
         <div class="row gutters">

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
					<div class="card-header">
						<!-- <div class="card-title">General Info</div> -->
					</div>
                    <div class="card-body">
                    	 <div class="row">
                            <!--Fields -->
                           <div class="col-md-12"> 
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Company Name</label>
                                            <?php if($sbranch_id == 'Overall'){ ?>
                                                <select tabindex="1" type="text" class="form-control" id="company_id" name="company_id[]" multiple >
                                                <!-- <select tabindex="1" type="text" class="form-control" id="company_id" name="company_id" tabindex="1" > -->
                                                    <option value="">Select Company Name</option>   
                                                        <?php if (sizeof($companyName)>0) { 
                                                        for($j=0;$j<count($companyName);$j++) { ?>
                                                        <option <?php if(isset($sCompanyBranchDetailEdit['company_id'])) { if($companyName[$j]['company_id'] == $sCompanyBranchDetailEdit['company_id'])  echo 'selected'; }  ?> value="<?php echo $companyName[$j]['company_id']; ?>">
                                                        <?php echo $companyName[$j]['company_name'];?></option>
                                                        <?php }} ?>  
                                                </select>  
                                            <?php } else if($sbranch_id != 'Overall'){ ?>
                                                <select disabled tabindex="1" type="text" class="form-control" id="company_name" name="company_name"  >
                                                    <option value="<?php echo $sbranch_id; ?>"><?php echo $sCompanyBranchDetail['company_name']; ?></option> 
                                                </select> 
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Branch Name</label>
                                            <?php if($sbranch_id == 'Overall'){ ?>
                                                <select tabindex="1" type="text" class="form-control" id="branch_id" name="branch_id[]" multiple >
                                                <!-- <select tabindex="2" type="text" class="form-control" id="branch_id" name="branch_id" > -->
                                                    <option value="">Select Branch Name</option> 
                                                </select> 
                                            <?php } else if($sbranch_id != 'Overall'){ ?>
                                                <input type="hidden" name="branch_id" id="branch_id" class="form-control" value="<?php echo $sbranch_id; ?>" >
                                                <select disabled tabindex="1" type="text" class="form-control" id="branch_id1" name="branch_id1" >
                                                    <option value="<?php echo $sbranch_id; ?>"><?php echo $sCompanyBranchDetail['branch_name']; ?></option> 
                                                </select> 
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput" style="visibility: hidden;" >Branch Name</label>
                                            <?php if($sbranch_id == 'Overall'){ ?>
                                            <select tabindex="1" disabled="true" type="text" class="form-control" id="search_dropdown" name="search_dropdown" >
                                                <option value="">Select</option>
                                                <option <?php if(isset($frequency)) { if('Id' == $frequency) echo 'selected';  ?> value="<?php echo 'Id' ?>">
                                                <?php echo 'Id'; }else{ ?> <option value="Id">Id</option>   <?php } ?></option>
                                                <option <?php if(isset($frequency)) { if('Name' == $frequency) echo 'selected';  ?> value="<?php echo 'Name' ?>">
                                                <?php echo 'Name'; }else{ ?> <option value="Name">Name</option> <?php } ?></option>
                                                <option <?php if(isset($frequency)) { if('Position' == $frequency) echo 'selected';  ?> value="<?php echo 'Position' ?>">
                                                <?php echo 'Position'; }else{ ?> <option value="Position">Position</option> <?php } ?></option>
                                                <option <?php if(isset($frequency)) { if('Dept Name' == $frequency) echo 'selected';  ?> value="<?php echo 'Dept Name' ?>">
                                                <?php echo 'Dept Name'; }else{ ?> <option value="Dept Name">Dept Name</option> <?php } ?></option>
                                            </select>
                                            <?php } else if($sbranch_id != 'Overall'){ ?>
                                                <script language='javascript'>
                                                    window.onload=getdepartment;
                                                    function getdepartment(){
                                                        var company_id = $("#branch_id").val();
                                                        $.ajax({
                                                            url: 'approvalrequisitionFile/ajaxStaffDepartmentDetails.php',
                                                            type: 'post',
                                                            data: { "company_id":company_id },
                                                            success:function(html){
                                                                $("#department_append").empty();
                                                                $("#department_append").html(html);
                                                            }
                                                        });
                                                    }
                                                </script>
                                                <select tabindex="1" type="text" class="form-control" id="search_dropdown" name="search_dropdown" >
                                                    <option value="">Select</option>
                                                    <option <?php if(isset($frequency)) { if('Id' == $frequency) echo 'selected';  ?> value="<?php echo 'Id' ?>">
                                                    <?php echo 'Id'; }else{ ?> <option value="Id">Id</option>   <?php } ?></option>
                                                    <option <?php if(isset($frequency)) { if('Name' == $frequency) echo 'selected';  ?> value="<?php echo 'Name' ?>">
                                                    <?php echo 'Name'; }else{ ?> <option value="Name">Name</option> <?php } ?></option>
                                                    <option <?php if(isset($frequency)) { if('Position' == $frequency) echo 'selected';  ?> value="<?php echo 'Position' ?>">
                                                    <?php echo 'Position'; }else{ ?> <option value="Position">Position</option> <?php } ?></option>
                                                    <option <?php if(isset($frequency)) { if('Dept Name' == $frequency) echo 'selected';  ?> value="<?php echo 'Dept Name' ?>">
                                                    <?php echo 'Dept Name'; }else{ ?> <option value="Dept Name">Dept Name</option> <?php } ?></option>
                                                </select>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput" style="visibility: hidden;" >Branch Name</label>
                                            <div id="staff_detail" tabindex="11">
                                                <input readonly type="text" id="staff_details" name="staff_details" class="form-control" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput" style="visibility: hidden;" >Branch Name</label>
                                            <div id="staff_detail" tabindex="11">
                                                <button type="button" tabindex="19" name="submit_staff" id="submit_staff" class="btn btn-primary" value="submit" tabindex="10">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br><br>

                        <div class="row">
                            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12">
                                <div class="form-group">
                                    <label for="inputReadOnly">Team</label>
                                    <div style="border: 2px solid black; height:300px;">
                                    <div id="department_append"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12" style="text-align:center">
                                <button style="margin-top:110px;text-align:center" type="button" name="approvalBtn" id="approvalBtn" class="btn btn-primary" value="Submit" tabindex="9">Approve</button>
                                <br><br>
                                <button style="text-align:center" type="button" name="aggreeParallelBtn" id="aggreeParallelBtn" class="btn btn-primary" value="Submit" tabindex="9">Aggree(Parallel)</button>
                            </div>
                            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12">
                                <div class="form-group">
                                    <div style="border: 2px solid black; height:300px;">
                                    
                                        <label for="inputReadOnly">Approval</label>

                                        <!-- <div class="ml-2">
                                            <div class="table-container">
                                                <div class="table-responsive">
                                                    <table class="table" id="approvalTableAppend">
                                                        <thead>
                                                            <tr>
                                                                <th>S. No.</th>
                                                                <th>Name</th>
                                                                <th>Emp Code</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>       
                                        </div> -->
                                        <div style="height:auto; padding:20px;">
                                            <div id="approvalTableAppend"></div>
                                            <div id="agreeParallelTableAppend"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br><br>

                        <div class="row">
                            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12">
                                <div class="form-group">
                                    <label for="inputReadOnly">Team Member</label>
                                    <div id="staff_append" style="border: 2px solid black; height:500px;">

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12" style="text-align:center">
                            <button style="margin-top:110px;text-align:center" type="button" name="afterNotifiedBtn" id="afterNotifiedBtn" class="btn btn-primary" value="Submit" tabindex="9">After Notified</button>
                                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                                <button style="text-align:center" type="button" name="receivingDeptBtn" id="receivingDeptBtn" class="btn btn-primary" value="Submit" tabindex="9">Recipient</button>
                            </div>
                            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12">
                                <div class="form-group">
                                    <div style="border: 2px solid black; height:250px;">
                                        <label for="inputReadOnly">Notified List</label>
                                        <div style="height:auto; padding:20px;">
                                            <div id="afterNotifiedTableAppend"></div>
                                        </div>      
                                    </div>
<br>
                                    <div style="border: 2px solid black; height:250px;">
                                        <label for="inputReadOnly"> List Of Recipient</label>
                                        <div style="height:auto; padding:20px;">
                                            <div id="receivingDeptTableAppend"></div>      
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br><br>

                        <!-- <div class="row">
                            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12">
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12" style="text-align:center">
                              
                            </div>
                            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12">
                                <div class="form-group">
                                    <label for="inputReadOnly">Receiving Department</label>
                                    <div style="border: 2px solid black; height:300px;">
                                                
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <div class="col-md-12">
                            <br><br><br><br>
                            <div class="text-right">
                                <button type="submit" name="submitBusiness_line" id="submitBusiness_line" class="btn btn-primary" value="Submit" tabindex="9">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary" tabindex="10">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form> 
</div>


