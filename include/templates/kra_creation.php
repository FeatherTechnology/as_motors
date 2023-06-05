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
$designationList = $userObj->getDesignation($mysqli);
$id=0;

if(isset($_POST['submitKraCreation']) && $_POST['submitKraCreation'] != '')
{
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
        $updatekraCreation = $userObj->updatekraCreation($mysqli,$id,$userid);  
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_kra_creation&msc=2';</script> 
    <?php }
    else {   
        $addkraCreation = $userObj->addkraCreation($mysqli,$userid);   
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_kra_creation&msc=1';</script>
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
	<script>location.href='<?php echo $HOSTPATH; ?>edit_kra_creation&msc=3';</script>
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
    for($i=0;$i<sizeof($weightage);$i++){
        $test = array_map('intval',$weightage);
        $totalweight = $totalweight + $test[$i];
    }

    $sCompanyBranchDetailEdit = $userObj->getsCompanyBranchDetail($mysqli, $company_id);
?>

    <input type="hidden" id="company_nameEdit" name="company_nameEdit" value="<?php print_r($company_id); ?>" >
    <input type="hidden" id="departmentEdit" name="departmentEdit" value="<?php print_r($department); ?>" >
    <script>
        window.onload=editBranchBasedDepartment;

        function editBranchBasedDepartment(){  
            var company_id = $('#company_nameEdit').val(); 
            var department = $('#departmentEdit').val();  
            $.ajax({
                url: 'R&RFile/ajaxGetCompanyBasedDeptDetails.php',
                type:'post',
                data: {'company_id': company_id},
                dataType: 'json',
                success: function(response){
            
                    $('#department').empty();
                    $('#department').prepend("<option value=''>" + 'Select Department Name' + "</option>");
                    var r = 0;
                    for (r = 0; r <= response.department_id.length - 1; r++) { 
                        var selected = "";
                        if(response['department_id'][r] == department)
                        {
                            selected = "selected";
                        }
                        $('#department').append("<option value='" + response['department_id'][r] + "' "+selected+">" + response['department_name'][r] + "</option>");
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
        <li class="breadcrumb-item">AS - KRA Creation </li>
    </ol>

    <a href="edit_kra_creation">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    </a>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
    <!-- form start -->
    <form id = "staff_creation" name="staff_creation" action="" method="post" enctype="multipart/form-data"> 
        <input type="hidden" class="form-control" value="<?php if(isset($kra_id)) echo $kra_id; ?>" id="id" name="id" aria-describedby="id" placeholder="Enter id">
        <input type="hidden" class="form-control" value="<?php if(isset($totalweight)) echo $totalweight; ?>" id="updweight" name="updweight" aria-describedby="id" >
        <input type="hidden" class="form-control" value="<?php if(isset($department)) echo $department; ?>" id="department_upd" name="department_upd" aria-describedby="id" >
        <input type="hidden" class="form-control" value="<?php if(isset($designation)) echo $designation; ?>" id="designation_upd" name="designation_upd" aria-describedby="id" >

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

                                    <?php if($idupd<=0){ ?>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Department</label>
                                                <select tabindex="3" type="text" class="form-control" id="department" name="department" >
                                                    <option value="">Select Department</option>   
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if($idupd>0){ ?>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
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
                                    
                                    <?php if($idupd<=0){ ?>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="disabledInput">Designation</label>
                                                <select tabindex="4" type="text" class="form-control" id="designation" name="designation" >
                                                    <option value="">Select Designation</option>   
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if($idupd>0){ ?>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
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

                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">KRA Category</label>
                                            <input type="text" tabindex="5" id="kra_category" name="kra_category" class="form-control"  value="" placeholder="Enter KRA Category">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Weightage</label>
                                            <input type="number" tabindex="6" id="weightage" name="weightage" class="form-control"  value="" 
                                            placeholder="Enter Weightage">
                                        </div>
                                    </div>

                                    
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-right" style="margin-top: 20px;">
                                        <div class="form-group">
                                        <label class="label" style="visibility: hidden;">Add</label>
                                        <button type="button" tabindex="7" class="btn btn-primary" id="add_kraDetails" name="add_kraDetails" style="padding: 7px 35px;">Add</button>
                                        </div>
                                    </div>
                                    
                                 </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="row">
                            <div class="col-md-12">
                                <label><span class="text-danger" id="kraTableCheck">Enter Atleast One Year</span></label>
                                <table id="kraTable" class="table custom-table">
                                    <thead>
                                        <tr>
                                            <th>KRA Category</th>
                                            <th>Weightage</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($idupd > 0){ 
                                        
                                            if(isset($kra_creation_ref_id)){ 

                                                for($tab=0; $tab<=sizeof($kra_creation_ref_id)-1; $tab++){ 
                                                    
                                                    if($kra_creation_ref_id[$tab] != ''){ ?>
                                                    <tr>
                                                            <td>
                                                                <input type="text" readonly name="kra_category[]" id="kra_category" class="form-control" value="<?php echo $kra_category[$tab]; ?>" >
                                                            </td>
                                                            <td>
                                                                <input type="text" readonly name="weightage[]" id="weightage"  class="form-control weightage" value="<?php echo $weightage[$tab]; ?>" >
                                                            </td>
                                                            <td>
                                                                <span onclick='onDelete(this);' class='icon-trash-2'></span>
                                                            </td>
                                                        </tr>
                                                    <?php }
                                                } 
                                            } 
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <br><br>
                            <div class="text-right">
                                <button type="submit" name="submitKraCreation" id="submitKraCreation" class="btn btn-primary" value="Submit" tabindex="8">Submit</button>
                                <!-- <button type="reset" class="btn btn-outline-secondary" tabindex="9">Cancel</button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form> 
</div>


