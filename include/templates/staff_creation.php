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
$designationList = $userObj->getDesignation($mysqli);
$krakpicompanyList = $userObj->getkrakpicompany($mysqli, $sbranch_id);
$staffList = $userObj->getStaff($mysqli); 

$id=0;
 if(isset($_POST['submitstaff_creation']) && $_POST['submitstaff_creation'] != '')
 {
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
    $updateStaffCreationmaster = $userObj->updateStaffCreation($mysqli,$id,$userid);  
    ?>
   <script>location.href='<?php echo $HOSTPATH; ?>edit_staff_creation&msc=2';</script> 
    <?php }
    else{   
		$addStaffCreation = $userObj->addStaffCreation($mysqli,$userid);   
        ?>
     <script>location.href='<?php echo $HOSTPATH; ?>edit_staff_creation&msc=1';</script>
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
	$deleteStaffCreation = $userObj->deleteStaffCreation($mysqli,$del,$userid); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_staff_creation&msc=3';</script>
    <?php	
}

if(isset($_GET['upd']))
{
$idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{
	$getStaffCreation = $userObj->getStaffCreation($mysqli,$idupd); 
	
	if (sizeof($getStaffCreation)>0) {
        for($istaff=0;$istaff<sizeof($getStaffCreation);$istaff++) {	
            $staff_id                       = $getStaffCreation['staff_id'];
            $staff_name                     = $getStaffCreation['staff_name'];
			$company_id                	     = $getStaffCreation['company_id'];
			$designation		             = $getStaffCreation['designation'];
			$reporting    			         = $getStaffCreation['reporting'];
			$emp_code                	     = $getStaffCreation['emp_code'];
            $department                            = $getStaffCreation['department'];
			$doj       		             = $getStaffCreation['doj'];
			$krikpi     			         = $getStaffCreation['krikpi'];
			$dob     		             = $getStaffCreation['dob'];
			$key_skills     			     = $getStaffCreation['key_skills'];
			$contact_number     			         = $getStaffCreation['contact_number'];
            $email_id     			     = $getStaffCreation['email_id'];
		}
	}

    $sCompanyBranchDetailEdit = $userObj->getsCompanyBranchDetail($mysqli, $company_id);
    ?>

    <input type="hidden" id="company_nameEdit" name="company_nameEdit" value="<?php print_r($company_id); ?>" >
    <input type="hidden" id="departmentEdit" name="departmentEdit" value="<?php print_r($department); ?>" >
    <input type="hidden" id="reportingEdit" name="reportingEdit" value="<?php print_r($reporting); ?>" >

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
            editDepartmentBasedReporting();
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

        // get reporting details
        function editDepartmentBasedReporting(){ 

            var company_id = $('#company_nameEdit').val(); 
            var department_id = $('#departmentEdit').val();
            var reporting = $('#reportingEdit').val();

            if(department_id.length==''){ 
                $("#department").val('');
            }else{
                $.ajax({
                    url: 'StaffFile/ajaxGetDeptBasedStaff.php',
                    type: 'post',
                    data: { "company_id":company_id, "department_id":department_id },
                    dataType: 'json',
                    success:function(response){
                        
                        $('#reporting').empty();
                        $('#reporting').prepend("<option value=''>" + 'Select Reporting Person' + "</option>");
                        var i = 0;
                        
                        for (i = 0; i <= response.staff_id.length - 1; i++) { 
                            
                            var selected = "";
                            if(reporting == response['staff_id'][i]){
                                selected = "selected";
                            }
                            $('#reporting').append("<option value='" + response['staff_id'][i] + "' "+selected+">" + response['staff_name'][i] + "</option>");
                        }

                    }
                });
            }
        };
    </script>

<?php
}
?>
   
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Staff Creation </li>
    </ol>

    <a href="edit_staff_creation">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    <!-- <button type="button" class="btn btn-primary"><span class="icon-border_color"></span>&nbsp Edit Employee Master</button> -->
    </a>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
<!--------form start-->
<form id = "staff_creation" name="staff_creation" action="" method="post" enctype="multipart/form-data"> 
<input type="hidden" class="form-control" value="<?php if(isset($staff_id)) echo $staff_id; ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id">
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

                                    
                                   <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Department</label>
                                            <select tabindex="3" type="text" class="form-control" id="department" name="department" >
                                                <option value="">Select Department</option>   
                                            </select>
                                        </div>
                                    </div>

                                    <?php if($idupd<=0){ ?>
                                       <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Designation</label>
                                                <select tabindex="4" type="text" class="form-control" id="designation" name="designation" >
                                                        <option value="">Select Designation</option>   
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if($idupd>0){ ?>
                                       <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Designation</label>
                                                <select tabindex="4" type="text" class="form-control" id="designation" name="designation" >
                                                    <option value="">Select Designation</option>   
                                                    <?php if (sizeof($designationList)>0) { 
                                                    for($j=0;$j<count($designationList);$j++) { ?>
                                                    <option <?php if(isset($designation)) { if($designationList[$j]['designation_id'] == $designation) echo 'selected'; } ?>
                                                    value="<?php echo $designationList[$j]['designation_id']; ?>">
                                                    <?php echo $designationList[$j]['designation_name'];?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>

                                   <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Staff Name</label>
                                            <input type="text" tabindex="5" id="staff_name" name="staff_name" class="form-control"  value="<?php if(isset($staff_name)) echo $staff_name; ?>" 
                                            placeholder="Enter Staff Name">
                                        </div>
                                    </div>
                    
                                   <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Reporting To</label>
                                            <select id="reporting" name="reporting" class="form-control" tabindex="6">
                                            <option value="">Select Reporting Person</option>   
                                                <!-- <?php if (sizeof($staffList)>0) { 
                                                for($j=0;$j<count($staffList);$j++) { ?>
                                                <option <?php if(isset($reporting)) { if($staffList[$j]['staff_id'] == $reporting)  echo 'selected'; }  ?> value="<?php echo $staffList[$j]['staff_id']; ?>">
                                                <?php echo $staffList[$j]['staff_name'];?></option>
                                                <?php }} ?>   -->
                                            </select>   
                                        </div>
                                    </div>

                                   <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Emp Code</label>
                                            <input type="text" id="emp_code" name="emp_code" tabindex="7"
                                            value="<?php if(isset($emp_code)) echo $emp_code; ?>"  class="form-control" placeholder="Enter Emp Code">
                                        </div>
                                    </div>
                                    
                                   <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label class="label">Date Of Joining</label>
                                            <input tabindex="8" type="date" 
                                            name="doj" id="doj" class="form-control" value="<?php if(isset($doj )) 
                                            echo $doj; ?>">
                                        </div>
                                    </div>
                                   <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">KRA & KPI Mapping</label>
                                            <select tabindex="9" type="text" class="form-control" id="krikpi" name="krikpi">
                                                <option value="">Select KRA & KPI</option>   
                                                <?php if (sizeof($krakpicompanyList)>0) { 
                                                    for($j=0;$j<count($krakpicompanyList);$j++) { ?>
                                                    <option <?php if (isset($company_id)) {
                                                        // print_r($krikpi);
                                                         if($krakpicompanyList[$j]['krakpi'] == $krikpi)  echo 'selected'; }  ?> 
                                                    value="<?php echo $krakpicompanyList[$j]['krakpi']; ?>">
                                                    <?php echo $krakpicompanyList[$j]['designation_name']; ?></option>
                                                    <?php }} ?>  
                                            </select> 
                                        </div>
                                    </div>
                                   <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label class="label">Date Of Birth</label>
                                            <input tabindex="10" type="date" 
                                            name="dob" id="dob" class="form-control" value="<?php if(isset($dob )) 
                                            echo $dob ;?>">
                                        </div>
                                    </div>
                                   <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Key Skills</label>
                                            <input class="form-control" tabindex="11" id="key_skills" name="key_skills" type="text" value="<?php if(isset($key_skills)) echo $key_skills; ?>" placeholder="Enter Key Skills">
                                        </div>
                                    </div>
                                   <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label class="label">Contact Number</label>
                                            <input tabindex="12" type="number" 
                                            name="contact_number" id="contact_number" pattern="[0-9]{3}[0-9]{3}[0-9]{7}"
                                            class="form-control" placeholder="Enter Contact Number" oninput="javascript: if (this.value.length > this.maxLength)
                                             this.value = this.value.slice(0, this.maxLength);"  maxlength = "10"  value="<?php if(isset($contact_number )) 
                                            echo $contact_number ; ?>">
                                        </div>
                                    </div>
                                   <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Email Id</label>
                                            <input class="form-control" tabindex="13" id="email_id" name="email_id" 
                                            type="email" value="<?php if(isset($email_id)) echo $email_id; ?>" 
                                            placeholder="Enter Email Id">
                                             
                                        </div>
                                    </div>
                                 </div>
                            </div>
                        </div>

                        <br>
                        <div class="col-md-12" style="display: flex; justify-content: space-between;">
                            <div>
                                <button type="button" tabindex="14"  id="downloadstaff" name="downloadstaff" class="btn btn-primary"><span class="icon-download"></span>Download</button>
                                <button type="button" data-toggle="modal" data-target="#staffBulkModal" tabindex="15"  id="uploadstaff" name="uploadstaff"  class="btn btn-primary"><span class="icon-upload"></span>Upload</button>		
                            </div>
                            <div>
                                <button type="submit" name="submitstaff_creation" id="submitstaff_creation" class="btn btn-primary" value="Submit" tabindex="16">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary" tabindex="17">Cancel</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="modal fade" id="staffBulkModal" tabindex="-1" role="dialog" aria-labelledby="vCenterModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="background-color: white">
            <div class="modal-header">
                <h5 class="modal-title" id="vCenterModalTitle">Staff Bulk Upload</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data" name="staffbulk" id="staffbulk">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12"></div>
                        <div class="col-xl-6 col-lg-6 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                        <div id="insertsuccess" style="color: green; font-weight: bold;">Excel Data Added Successfully</div>
                        <!-- <div id="notinsertsuccess" style="color: red; font-weight: bold;">Problem Importing Excel Data or Duplicate Entry found</div> -->
                        <label class="label">Select Excel</label>
                        <input type="file" name="file" id="file" class="form-control">
                        </div>
                        </div> 
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="submitstaffbulkbtn" name="submitstaffbulkbtn">Upload</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>   
</div>



