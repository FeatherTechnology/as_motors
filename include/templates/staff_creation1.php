<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
} 
$companyName = $userObj->getCompanyName($mysqli);
$departmentList = $userObj->getDepartment($mysqli); 
$designationList = $userObj->getDesignation($mysqli);
$kpacompanyList = $userObj->getkpacompnay($mysqli);
$staffList = $userObj->getStaff($mysqli); 


$id=0;
 if(isset($_POST['submitstaff_creation']) && $_POST['submitstaff_creation'] != '')
 {
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
    $updateStaffCreationmaster = $userObj->updateStaffCreation($mysqli,$id,$userid);  
    ?>
   <script>location.href='<?php echo $HOSTPATH; ?>edit_staff_creation&msc=2';</script> 
    <?php	}
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
        for($istaff=0;$istaff<sizeof($getStaffCreation);$istaff++)  {	
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
                           <div class="col-md-8 "> 
                              <div class="row">
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Company Name</label>
                                            <select tabindex="1" type="text" class="form-control" id="company_id" name="company_id" tabindex="1" >
                                                <option value="">Select Company Name</option>   
                                                    <?php if (sizeof($companyName)>0) { 
                                                    for($j=0;$j<count($companyName);$j++) { ?>
                                                    <option <?php if(isset($company_id)) { if($companyName[$j]['company_id'] == $company_id)  echo 'selected'; }  ?> value="<?php echo $companyName[$j]['company_id']; ?>">
                                                    <?php echo $companyName[$j]['company_name'];?></option>
                                                    <?php }} ?>  
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Department</label>
                                                <select tabindex="2" type="text" class="form-control" id="department" name="department" >
                                                    <option value="">Select Department</option>   
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Designation</label>
                                            <select tabindex="2" type="text" class="form-control" id="designation" name="designation" tabindex="1" >
                                                    <option value="">Select Designation</option>   
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Staff Name</label>
                                            <input type="text" tabindex="5" id="staff_name" name="staff_name" class="form-control"  value="<?php if(isset($staff_name)) echo $staff_name; ?>" 
                                            placeholder="Enter Staff Name">
                                            
                                        </div>
                                    </div>
                    
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Reporting To</label>
                                            <select id="reporting" name="reporting" class="form-control" >
                                            <option value="">Select Reporting Person</option>   
                                                    <?php if (sizeof($staffList)>0) { 
                                                    for($j=0;$j<count($staffList);$j++) { ?>
                                                    <option <?php if(isset($reporting)) { if($staffList[$j]['staff_id'] == $reporting)  echo 'selected'; }  ?> value="<?php echo $staffList[$j]['staff_id']; ?>">
                                                    <?php echo $staffList[$j]['staff_name'];?></option>
                                                    <?php }} ?>  
                                            </select>   
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Emp Code</label>
                                            <input type="text" id="emp_code" name="emp_code"
                                            value="<?php if(isset($emp_code)) echo $emp_code; ?>"  class="form-control" placeholder="Enter Emp Code">
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="label">Date Of Joining</label>
                                            <input tabindex="8" type="date" 
                                            name="doj" id="doj" class="form-control" value="<?php if(isset($doj )) 
                                            echo $doj ; ?>">
                                             
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">KRA & KPI Mapping</label>
                                            <select tabindex="1" type="text" class="form-control" id="krikpi" name="krikpi">
                                                <option value="">Select KRA & KPI</option>   
                                                    <?php if (sizeof($kpacompanyList)>0) { 
                                                    for($j=0;$j<count($kpacompanyList);$j++) { ?>
                                                    <option <?php if(isset($company_id)) { if($kpacompanyList[$j]['company_name'] == $company_id)  echo 'selected'; }  ?> value="<?php echo $kpacompanyList[$j]['company_name']; ?>">
                                                    <?php echo $kpacompanyList[$j]['company_name'];?></option>
                                                    <?php }} ?>  
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="label">Date Of Birth</label>
                                            <input tabindex="8" type="date" 
                                            name="dob" id="dob" class="form-control" value="<?php if(isset($dob )) 
                                            echo $dob ;?>">
                                             
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Key Skills</label>
                                            <input class="form-control" tabindex="10" id="key_skills" name="key_skills" type="text" value="<?php if(isset($key_skills)) echo $key_skills; ?>" placeholder="Enter Website">
                                             
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="label">Contact Number</label>
                                            <input tabindex="8" type="number" 
                                            name="contact_number" id="contact_number" pattern="[0-9]{3}[0-9]{3}[0-9]{7}"
                                            class="form-control" placeholder="8956235689" oninput="javascript: if (this.value.length > this.maxLength)
                                             this.value = this.value.slice(0, this.maxLength);"  maxlength = "10"  value="<?php if(isset($contact_number )) 
                                            echo $contact_number ; ?>">
                                             
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Email Id</label>
                                            <input class="form-control" tabindex="10" id="email_id" name="email_id" 
                                            type="email" value="<?php if(isset($email_id)) echo $email_id; ?>" 
                                            placeholder="Enter Email Id">
                                             
                                        </div>
                                    </div>
                                 </div>
                            </div>
                        </div>
                            <div class="col-md-12">
                            <br><br>
                            <div class="text-right">
                                <button type="submit" name="submitstaff_creation" id="submitstaff_creation" class="btn btn-primary" value="Submit" tabindex="14">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary" tabindex="15">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>



