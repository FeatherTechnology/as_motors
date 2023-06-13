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
// $companyNameFromBranch = $userObj->getCompanyNameFromBranch($mysqli);
$departmentList = $userObj->getDepartment($mysqli); 
$designationList = $userObj->getDesignation($mysqli);

$id=0;
if(isset($_POST['submitBasicCreation']) && $_POST['submitBasicCreation'] != '')
{    
	if(isset($_POST['id']) && $_POST['id'] >0 ){		
		$id = $_POST['id']; 	
		$updateBasicCreation = $userObj->updateBasicCreation($mysqli,$id, $userid);  
		?>
		<script>location.href='<?php echo $HOSTPATH;  ?>edit_basic_creation&msc=2';</script>
	<?php }
	else{   
		$addBasicCreation = $userObj->addBasicCreation($mysqli, $userid);
		?>
		<script>location.href='<?php echo $HOSTPATH;  ?>edit_basic_creation&msc=1';</script> 
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
	<script>location.href='<?php echo $HOSTPATH;  ?>edit_basic_creation&msc=3';</script>
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
			$company_id          		 = $getBasicCreation['company_id']; 
			$department      			 = $getBasicCreation['department'];
			$designation      	 = $getBasicCreation['designation'];
			$department_code       	     = $getBasicCreation['department_code'];
			$designation_code                	 = $getBasicCreation['designation_code'];
			$report_to       		    	 = $getBasicCreation['report_to'];
		}
        
	} 

    $companyArr = explode(",", $company_id);
    // $departmentArr = explode(",", $department);
    // $designationArr = explode(",", $designation);

    $sCompanyBranchDetailEdit = $userObj->getsBranchBasedCompanyName($mysqli, $company_id);
    ?>

    <input type="hidden" id="basic_creation_idEdit" name="basic_creation_idEdit" value="<?php echo ($basic_creation_id); ?>" >
    <input type="hidden" id="company_nameEdit" name="company_nameEdit" value="<?php echo ($company_id); ?>" >
    <input type="hidden" id="departmentEdit" name="departmentEdit" value="<?php echo ($department); ?>" >
    <input type="hidden" id="designationEdit" name="designationEdit" value="<?php echo $designation; ?>" >
    <input type="hidden" id="reportingtoEdit" name="reportingtoEdit" value="<?php echo ($report_to); ?>" >

    <script>
        window.onload=editCompanyBasedBranch;
        function editCompanyBasedBranch(){  
            var branch_id = $('#company_nameEdit').val();
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

            editBranchBasedDepartment();
            editBranchBasedDesignation();
            editResetreportingdropdown();
        }   

        // get department details
        function editBranchBasedDepartment(){ 

            var branch_id = $('#company_nameEdit').val(); 
            var department_upd = $('#departmentEdit').val();

            $.ajax({
                url: 'tagFile/getDepartmentDetails.php',
                type: 'post',
                data: { "branch_id":branch_id },
                dataType: 'json',
                success:function(response){ 

                    $('#department').empty();
                    $('#department').prepend("<option value=''>" + 'Select Department Name' + "</option>");
                    var r = 0;
                    for (r = 0; r <= response.departmentId.length - 1; r++) { 
                        var selected = "";
                        if(department_upd == response['departmentId'][r]){
                            selected = "selected";
                        }
                        $('#department').append("<option value='" + response['departmentId'][r] + "' "+selected+">" + response['departmentName'][r] + "</option>");
                    }
                }
            });
        };

        // report Dropdown
        function editResetreportingdropdown(branch_id){ 

            var branch_id = $('#company_nameEdit').val(); 
            var report_to_upd = $('#reportingtoEdit').val();

            $.ajax({
                url: 'ajaxResetReportingDropdown.php',
                type: 'POST',
                data: {"branch_id":branch_id},
                cache: false,
                dataType: 'json',
                success:function(response){ 
                    
                    $("#report_to").empty();
                    $("#report_to").append("<option value=''>"+'Select Reporting Person'+"</option>");
                    for(var i = 0; i<response.designation_id.length; i++){ 
                        var selected = "";
                        if(report_to_upd == response['designation_id'][i]) {
                            selected = "selected";
                        }                
         
                        $("#report_to").append("<option value='"+response['designation_id'][i]+"' "+selected+">"+response['designation_name'][i]+"</option>");
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
        <li class="breadcrumb-BasicCreation">AS- Basic Creation</li>
    </ol>

    <a href="edit_basic_creation">
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
                        <div class="card-header">Basic Info  <span class="required" style="font-size: 12px;"> *Note: To be Created from the top Hierarchy </span></div>
                            <div class="card-body">
                            <input type="hidden" name="branch_id_session" id="branch_id_session" class="form-control" value="<?php if(isset($sbranch_id)) echo $sbranch_id; ?>">
                            <input type="hidden" name="id" id="id" class="form-control" value="<?php if(isset($basic_creation_id)) echo $basic_creation_id; ?>">
                            <input type="hidden" name="company_id_upd" id="company_id_upd" class="form-control" value="<?php if(isset($company_id)) echo $company_id; ?>">
                            <input type="hidden" name="department_upd" id="department_upd" class="form-control" value="<?php if(isset($department)) echo $department; ?>">
                            <input type="hidden" name="designation_upd" id="designation_upd" class="form-control" value="<?php if(isset($designation)) echo $designation; ?>">
                            <input type="hidden" name="department_code_upd" id="department_code_upd" class="form-control" value="<?php if(isset($department_code)) echo $department_code; ?>">
                            <input type="hidden" name="designation_code_upd" id="designation_code_upd" class="form-control" value="<?php if(isset($designation_code)) echo $designation_code; ?>">
                            <input type="hidden" name="report_to_upd" id="report_to_upd" class="form-control" value="<?php if(isset($report_to)) echo $report_to; ?>">
                                    <div class="row gutters">

                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Company Name</label>
                                                <?php if($sbranch_id == 'Overall'){ ?>
                                                    <select tabindex="1" type="text" class="form-control" id="company_id" name="company_id" >
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

                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Branch Name</label>
                                                <?php if($sbranch_id == 'Overall'){ ?>
                                                    <select tabindex="2" type="text" class="form-control" id="branch_id" name="branch_id" >
                                                        <option value="" disabled selected>Select Branch Name</option> 
                                                    </select> 
                                                <?php } else if($sbranch_id != 'Overall'){ ?>
                                                    <input type="hidden" name="branch_id" id="branch_id" class="form-control" value="<?php echo $sbranch_id; ?>">
                                                    <select disabled tabindex="2" type="text" class="form-control" id="branch_id1" name="branch_id1" >
                                                        <option value="<?php echo $sbranch_id; ?>"><?php echo $sCompanyBranchDetail['branch_name']; ?></option> 
                                                    </select> 
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12"></div>

                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label class="label">Department Code</label>
                                                <input type="text" readonly name="department_code" id="department_code" class="form-control" value="<?php if(isset($department_code)) echo $department_code ; ?>">
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
											<div class="form-group">
												<label class="label">Department Name</label>
                                                <select tabindex="3" type="text" class="form-control" id="department" name="department" >
                                                    <option value="" disabled selected>Select Department</option> 
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-1 col-lg-1 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label class="label" style="visibility: hidden;">Add Department</label>
                                                <button type="button" tabindex="4" class="btn btn-primary" id="add_departmentDetails" name="add_departmentDetails"  style="padding: 5px 35px;"><span class="icon-add"></span></button>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label class="label">Designation Code</label>
                                                <input type="text" readonly name="designation_code" id="designation_code" class="form-control" value="<?php if(isset($designation_code)) echo $designation_code ; ?>">
                                            </div>
                                        </div>
                                    
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
											<div class="form-group" id='designation_div'>
                                                <label class="label">Designation Name</label>
                                                <select type="text" class="form-control" id="designation" name="designation[]" multiple ></select>
                                            </div>
                                        </div>
                                        <div class="col-xl-1 col-lg-1 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label class="label" style="visibility: hidden;">Add Designation</label>
                                                <button type="button" tabindex="6" class="btn btn-primary" id="add_designationDetails" name="add_designationDetails"  style="padding: 5px 35px;"><span class="icon-add"></span></button>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label class="label">Reporting To</label>
                                                <select tabindex="7" type="text" class="form-control" id="report_to" name="report_to"  data-actions-box="true" >
                                                <option value="">Select Reporting Person</option>
                                                </select>
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
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="DropDownStock()">Close</button>
                                                </div>
                                            </div>
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
                                                                <th>S.No</th>
                                                                <th>Designation</th>
                                                                <th>ACTION</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                           
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="DropDownDesignation()">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12">
                            <div class="text-right" id="end_buttons">
                                <button tabindex="8"  type="submit" value="submit" id="submitBasicCreation" name="submitBasicCreation" class="btn btn-primary" >Submit</button>
                                <button tabindex="9" type="reset" id="cancelbtn" name="cancelbtn" class="btn btn-outline-secondary" class="text-right">Cancel</button>
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
	<!-- <div class="row gutters">
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
								<th>Company Name</th>
								<th>Branch Name</th>
								<th>Department Name</th>
								<th>Designation Name</th>
								<th>Department Code</th>
								<th>Designation Code</th>
								<th>Reporting To</th>
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
	</div> -->
	<!-- Row end -->
</div>

<style>
    div.multiselect, select#meal, button {
  margin: 5px;
}

.multiselect {
  width: 100%;
}

.selectBox {
  position: relative;
}

.selectBox select {
  width: 100%;
  font-weight: bold;
}

.overSelect {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
}

#checkboxes {
  display: none;
  border: 1px #dadada solid;
}

#checkboxes label {
  display: block;
}

#checkboxes label:hover {
  background-color: #1e90ff;
}
</style>
<script>
      var expanded = false;
      //show dropdown
      function showCheckboxes() {
        var checkboxes = document.getElementById("checkboxes");
        if (!expanded) {
          checkboxes.style.display = "block";
          expanded = true;
        } else {
          checkboxes.style.display = "none";
          expanded = false;
        }
      }
      //showing checked options 
      function checkOptions() {
        els = document.getElementsByClassName('categories');
        // des_id = document.getElementsByClassName('designation_id').value;
        // console.log(des_id);
        var selectedChecks = "", qtChecks = 0;
        for (i = 0; i < els.length; i++) {
            if (els[i].checked) {
            if (qtChecks > 0) selectedChecks += ", "
            selectedChecks += els[i].value;
            qtChecks++;
        }
    }
    
    if(selectedChecks != "") {
        document.getElementById("defaultCategory").innerText = selectedChecks;
        document.getElementById("defaultCategory").value = selectedChecks;
        // document.getElementById("defaultCategory").value = des_id;
        
    } else {
        document.getElementById("defaultCategory").innerText = "Select an Department";
        document.getElementById("defaultCategory").value = "";
        // document.getElementById("defaultCategory").value = '';
        }
      }


	setTimeout(function() {
		$('.alert').fadeOut('slow');
	}, 2000);

</script>
