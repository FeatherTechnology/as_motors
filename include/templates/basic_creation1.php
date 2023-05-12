<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
$companyName = $userObj->getCompanyName($mysqli);
$departmentList = $userObj->getDepartment($mysqli); 
$designationList = $userObj->getDesignation($mysqli);

$id=0;
if(isset($_POST['submitBasicCreation']) && $_POST['submitBasicCreation'] != '')
{    
	if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
		$id = $_POST['id']; 	
		$updateBasicCreation = $userObj->updateBasicCreation($mysqli,$id, $userid);  
		?>
		<script>location.href='<?php echo $HOSTPATH;  ?>basic_creation&msc=2';</script>
	<?php }
	else{   
		$addBasicCreation = $userObj->addBasicCreation($mysqli, $userid);
		?>
		<script>location.href='<?php echo $HOSTPATH;  ?>basic_creation&msc=1';</script> 
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
	$deleteBasicCreation = $userObj->deleteBasicCreation($mysqli,$del,$userid); 
	?>
	<script>location.href='<?php echo $HOSTPATH;  ?>basic_creation&msc=3';</script>
<?php	
}

if(isset($_GET['upd']))
{
$idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{
	$getBasicCreation = $userObj->getBasicCreation($mysqli,$idupd); 
	
	if (sizeof($getBasicCreation)>0) {
        for($iBasicCreation=0;$iBasicCreation<sizeof($getBasicCreation);$iBasicCreation++)  {			
			$basic_creation_id                	 = $getBasicCreation['basic_creation_id'];
			$company_id1          		 = $getBasicCreation['company_id']; 
			$department      			 = $getBasicCreation['department'];
			$designation      	 = $getBasicCreation['designation'];
			$department_code       	     = $getBasicCreation['department_code'];
			$designation_code                	 = $getBasicCreation['designation_code'];
			$type       		    	 = $getBasicCreation['type'];
		}
	}
}

$arr = explode(",", $company_id1);

?>
<!-- Page header start -->
	<div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-BasicCreation">AS- Basic Creation</li>
        </ol>
        <a href="basic_creation">
            <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
        </a>
	</div>
<!-- Page header end -->
<!-- Main container start -->
    <div class = "main-container">
    <!-- Row start -->
        <form action="" method="post" name="basic_info" id="basic_info">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header">Basic Info</div>
                            <div class="card-body">
                                <input type="hidden" name="id" id="id" class="form-control" value="<?php if(isset($basic_creation_id)) echo $basic_creation_id; ?>">
                                    <div class="row gutters">
                                        <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">                                           
                                                <input type="radio" tabindex="13" checked name="type" id="common" value="Common" <?php if(isset($type))
                                                echo ($type =='Common')?'checked':'' ?>> &nbsp;&nbsp; <label for="common">Common </label> &nbsp;&nbsp;&nbsp;&nbsp;

                                                <input type="radio" tabindex="14" name="type" id="specific" value="Specific" <?php if(isset($type))
                                                echo ($type =='Specific')?'checked':'' ?>> &nbsp;&nbsp; <label for="specific">Specific</label>
                                            </div>
                                        </div> 

                                        <div class="col-xl-1 col-lg-1 col-md-1 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Company Name</label>
                                            </div>
                                        </div>

                                        <?php if($idupd <= 0) { ?>
                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 specific" style="display: none;">
                                                <div class="form-group">
                                                    <select tabindex="1" type="text" class="form-control selectpicker" id="company_id" name="company_id[]" multiple data-actions-box="true">
                                                        <?php if (sizeof($companyName)>0) { 
                                                        for($j=0;$j<count($companyName);$j++) { ?>
                                                            <option <?php if(isset($company_id)) { if($companyName[$j]['company_id'] == $company_id)  echo 'selected'; } ?> value="<?php echo $companyName[$j]['company_id']; ?>">
                                                            <?php echo $companyName[$j]['company_name']; ?></option>
                                                        <?php }} ?>  
                                                    </select> 
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 common">
                                                <div class="form-group">
                                                    <select tabindex="1" type="text" class="form-control" id="company_id_all" name="company_id_all" >
                                                        <option value="All">All</option>   
                                                    </select> 
                                                </div>
                                            </div>
                                        <?php } if($idupd > 0) { ?>
                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <select tabindex="1" type="text" class="form-control selectpicker" id="company_id" name="company_id[]" multiple data-actions-box="true">
                                                            <?php if (sizeof($companyName)>0) { 
                                                            for($j=0;$j<count($companyName);$j++) { ?>
                                                                <option <?php  
                                                                    if (isset($arr)) {
                                                                        for ($i=0; $i < count($arr); $i++){
                                                                            if($companyName[$j]['company_id'] == $arr[$i] ) echo "selected"; 
                                                                        }
                                                                    }
                                                                    ?> value="<?php echo $companyName[$j]['company_id']; ?>"> <?php echo $companyName[$j]['company_name']; ?>
                                                                </option>
                                                            <?php }} ?> 
                                                    </select> 
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <?php if($idupd <= 0) { ?>
                                        <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label class="label">Department Code</label>
                                                <input type="text" readonly tabindex="1" name="department_code" id="department_code" class="form-control" value="">
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <?php if(isset($department_code)) { ?>
                                        <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label class="label">Department Code</label>
                                                    <input type="text" readonly tabindex="1" name="department_codeEdit" id="department_codeEdit" class="form-control" 
                                                    value="<?php if(isset($department_code)) echo $department_code ; ?>">
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
											<div class="form-group">
												<label class="label">Department Name</label><span class="text-danger">*</span>
                                                <select tabindex="2" type="text" class="form-control" id="department" name="department" >
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
                                        <div class="col-xl-1 col-lg-1 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                            <label class="label" style="visibility: hidden;">Add Designationt</label>
                                                <button type="button"  tabindex="3" class="btn btn-primary" id="add_departmentDetails" name="add_departmentDetails" data-toggle="modal" data-target=".addDepartmentModal" style="padding: 5px 35px;"><span class="icon-add"></span></button>
                                            </div>
                                        </div>
									<!-- Add Course Category Modal -->
                                    <div class="modal fade addDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content" style="background-color: white">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myLargeModalLabel">Add Department</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="DropDownStock()">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- alert messages -->
                                                    <div id="departmentInsertNotOk" class="unsuccessalert">Department Already Exists, Please Enter a Different Name!
                                                    <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                                    </div>

                                                    <div id="departmentInsertOk" class="successalert">Department Added Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                                    </div>

                                                    <div id="departmentUpdateOk" class="successalert">Department Updated Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                                    </div>

                                                    <div id="departmentDeleteNotOk" class="unsuccessalert">You Don't Have Rights To Delete This Department!
                                                    <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                                    </div>

                                                    <div id="departmentDeleteOk" class="successalert">Department Has been Inactivated!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                                    </div>

                                                    <br />
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12"></div>
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                        <div class="form-group">
                                                            <label class="label">Enter Department</label>
                                                            <input type="hidden" name="department_id" id="department_id">
                                                            <input type="text" name="department_name" id="department_name" class="form-control" placeholder="Enter Department">
                                                            <span class="text-danger" tabindex="1" id="departmentnameCheck">Enter Department</span>
                                                        </div>
                                                    </div>
                                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-4 col-12">
                                                        <label class="label" style="visibility: hidden;">Department</label>
                                                    <button type="button" tabindex="2" name="submitDepartmentBtn" id="submitDepartmentBtn" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                            <div id="updateddepartmentTable"> 
                                                <table class="table custom-table" id="departmentTable"> 
                                                    <thead>
                                                        <tr>
                                                            <th>S. No</th>
                                                            <th>Department</th>
                                                            <th>ACTION</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (sizeof($departmentList)>0) { 
                                                            for($j=0;$j<count($departmentList);$j++) { ?>
                                                            <tr>
                                                                <td class="col-md-2 col-xl-2"><?php echo $j+1; ?></td>
                                                                <td><?php  echo $departmentList[$j]['department_name']; ?></td>
                                                                <td>
                                                                    <a id="edit_department" value="<?php echo $departmentList[$j]['department_id'] ?>"><span class="icon-border_color"></span></a> &nbsp
                                                                    <a id="delete_department" value="<?php echo $departmentList[$j]['department_id'] ?>"><span class='icon-trash-2'></span>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php } } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="DropDownDesig()">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <?php //if($idupd <= 0) { ?>
                                <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label class="label">Designation Code</label>
                                        <input type="text" readonly tabindex="1" name="designation_code" id="designation_code" class="form-control" value="">
                                    </div>
                                </div>
                                    <?php //} ?>
                                    <?php //if(isset($designation_code)) { ?>
                                        <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="label">Designation Code</label>
                                                <input type="text" readonly tabindex="1" name="designation_codeEdit" id="designation_codeEdit" class="form-control" 
                                                value="<?php //if(isset($designation_code)) echo $designation_code ; ?>">
                                        </div>
                                    </div>
                                    <?php //} ?>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
											<div class="form-group">
												<label class="label">Designation Name</label><span class="text-danger">*</span>
                                                <select tabindex="2" type="text" class="form-control" id="designation" name="designation" tabindex="1" >
                                                    <option value="">Select Designation</option>   
                                                    <?php if (sizeof($designationList)>0) { 
                                                    for($j=0;$j<count($designationList);$j++) { ?>
                                                    <option <?php if(isset($designation)) { if($designationList[$j]['designation_id'] == $designation )  echo 'selected'; }  ?>
                                                    value="<?php echo $designationList[$j]['designation_id']; ?>">
                                                    <?php echo $designationList[$j]['designation_name'];?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-1 col-lg-1 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                            <label class="label" style="visibility: hidden;">Add Designation</label>
                                                <button type="button"  tabindex="3" class="btn btn-primary" id="add_designationDetails" name="add_designationDetails" data-toggle="modal" data-target=".addDesignationModal" style="padding: 5px 35px;"><span class="icon-add"></span></button>
                                            </div>
                                        </div>
									<!-- Add Course Category Modal -->
                                    <div class="modal fade addDesignationModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content" style="background-color: white">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myLargeModalLabel">Add Designation</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="DropDownDesignation()">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- alert messages -->
                                                    <div id="designationInsertNotOk" class="unsuccessalert">Designation Already Exists, Please Enter a Different Name!
                                                    <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                                    </div>

                                                    <div id="designationInsertOk" class="successalert">Designation Added Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                                    </div>

                                                    <div id="designationUpdateOk" class="successalert">Designation Updated Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                                    </div>

                                                    <div id="designationDeleteNotOk" class="unsuccessalert">You Don't Have Rights To Delete This Designation!
                                                    <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                                    </div>

                                                    <div id="designationDeleteOk" class="successalert">Designation Has been Inactivated!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                                                    </div>

                                                    <br />
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12"></div>
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                        <div class="form-group">
                                                            <label class="label">Enter Designation</label>
                                                            <input type="hidden" name="designation_id" id="designation_id">
                                                            <input type="text" name="designation_name" id="designation_name" class="form-control" placeholder="Enter designation">
                                                            <span class="text-danger" tabindex="1" id="designationnameCheck">Enter Designation</span>
                                                        </div>
                                                    </div>
                                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-4 col-12">
                                                        <label class="label" style="visibility: hidden;">Designation</label>
                                                    <button type="button" tabindex="2" name="submitDesignationBtn" id="submitDesignationBtn" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                            <div id="updateddesignationTable"> 
                                                <table class="table custom-table" id="designationTable"> 
                                                    <thead>
                                                        <tr>
                                                            <th>S. No</th>
                                                            <th>Designation</th>
                                                            <th>ACTION</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (sizeof($designationList)>0) { 
                                                            for($j=0;$j<count($designationList);$j++) { ?>
                                                            <tr>
                                                                <td class="col-md-2 col-xl-2"><?php echo $j+1; ?></td>
                                                                <td><?php  echo $designationList[$j]['designation_name']; ?></td>
                                                                <td>
                                                                    <a id="edit_designation" value="<?php echo $designationList[$j]['designation_id'] ?>"><span class="icon-border_color"></span></a> &nbsp
                                                                    <a id="delete_designation" value="<?php echo $designationList[$j]['designation_id'] ?>"><span class='icon-trash-2'></span>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php } } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="DropDownDesig()">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12">
                            <div class="text-right">
                                <button tabindex="31"  type="submit" value="submit" id="submitBasicCreation" name="submitBasicCreation" class="btn btn-primary" >Submit</button>
                                <button tabindex="32" type="reset" id="cancelbtn" name="cancelbtn" class="btn btn-outline-secondary" class="text-right">Cancel</button>
                                <br /><br />
                            </div>
                        </div>		
                    </div>
                </div>
            </div>
		<!-- Row end -->
	</form>
	<!-- Form end -->

	<!-- Main container end -->
    <!-- Row start -->
	<div class="row gutters">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="table-container">

				<div class="table-responsive">
					<?php
					$mscid=0;
					if(isset($_GET['msc']))
					{
					$mscid=$_GET['msc'];
					if($mscid==1)
					{?>
					<div class="alert alert-success" role="alert">
						<div class="alert-text">Basic Added Successfully!</div>
					</div> 
					<?php
					}
					if($mscid==2)
					{?>
						<div class="alert alert-success" role="alert">
						<div class="alert-text">Basic Updated Successfully!</div>
					</div>
					<?php
					}
					if($mscid==3)
					{?>
					<div class="alert alert-danger" role="alert">
						<div class="alert-text">Basic Inactive Successfully!</div>
					</div>
					<?php
					}
					}
					?>
					<table id="basicCreation_info" class="table custom-table">
						<thead>
							<tr>
								<th>S. No.</th>
								<th>Type</th>
								<th>Company Name</th>
								<th>Department Name</th>
								<th>Designation Name</th>
								<th>Department Code</th>
								<th>Designation Code</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- Row end -->
</div>

<script>
	setTimeout(function() {
		$('.alert').fadeOut('slow');
	}, 2000);
</script>