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
$topHierarchy = $userObj->getDesignation($mysqli);
$subOrdinate = $userObj->getDesignation($mysqli);

$id=0;
 if(isset($_POST['submitHierarchyCreation']) && $_POST['submitHierarchyCreation'] != '')
 {
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
        $updateHierarchyCreation = $userObj->updateHierarchyCreation($mysqli,$id,$userid);  
        ?>
    <script>location.href='<?php echo $HOSTPATH; ?>edit_hierarchy_creation&msc=2';</script> 
    <?php	}
    else{   
		$addHierarchyCreation = $userObj->addHierarchyCreation($mysqli,$userid);   
        ?>
     <script>location.href='<?php echo $HOSTPATH; ?>edit_hierarchy_creation&msc=1';</script>
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
	$deleteHierarchyCreation = $userObj->deleteHierarchyCreation($mysqli,$del,$userid); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_hierarchy_creation&msc=3';</script>
<?php	
}

if(isset($_GET['upd']))
{
$idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{
	$getHierarchyCreation = $userObj->getHierarchyCreation($mysqli,$idupd); 
	
	if (sizeof($getHierarchyCreation)>0) {
        for($itag=0;$itag<sizeof($getHierarchyCreation);$itag++)  {

            $hierarchy_id                      = $getHierarchyCreation['hierarchy_id']; 
            $company_id                	 = $getHierarchyCreation['company_id'];
            $branch_id                	 = $getHierarchyCreation['branch_id'];
			$department_id               = $getHierarchyCreation['department_id'];
			$top_hierarchy    	     = $getHierarchyCreation['top_hierarchy'];
			$sub_ordinate    	     = $getHierarchyCreation['sub_ordinate'];
	
		}
	}

    $departmentArr = explode(",", $department_id);
    $topHierarchyArr = explode(",", $top_hierarchy);
    $subOrdinateArr = explode(",", $sub_ordinate);

    $sCompanyBranchDetailEdit = $userObj->getsCompanyBranchDetail($mysqli, $branch_id);
    ?>
    
        <input type="hidden" id="company_nameEdit" name="company_nameEdit" value="<?php print_r($branch_id); ?>" >
        <input type="hidden" id="departmentEdit" name="departmentEdit" value="<?php print_r($department_id); ?>" >
        <input type="hidden" id="top_hierarchyEdit" name="top_hierarchyEdit" value="<?php echo $top_hierarchy; ?>" >
        <input type="hidden" id="sub_ordinateEdit" name="sub_ordinateEdit" value="<?php echo $sub_ordinate; ?>" >

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

                editGetDepartment();
                editGetDesignationList();
            }

            function editGetDepartment(){
                var branch_id = $('#company_nameEdit').val(); 
                var departmentEdit = $('#departmentEdit').val(); 

                $.ajax({
                    url: 'tagFile/getDepartmentDetails.php',
                    type: 'post',
                    data: { "branch_id":branch_id },
                    dataType: 'json',
                    success: function(response){ 

                        $('#department').empty();
                        $('#department').prepend("<option value=''>" + 'Select Department' + "</option>");
                        var i = 0;
                        for (i = 0; i <= response.departmentId.length - 1; i++) {
                            var selected = "";
                            if(response['departmentId'][i] == departmentEdit)
                            {
                                selected = "selected";
                            }
                            $('#department').append("<option value='" + response['departmentId'][i] + "' "+selected+">" + response['departmentName'][i] + "</option>");
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
        <li class="breadcrumb-item">AS - Hierarchy Creation </li>
    </ol>

    <a href="edit_hierarchy_creation">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    <!-- <button type="button" class="btn btn-primary"><span class="icon-border_color"></span>&nbsp Edit Employee Master</button> -->
    </a>
</div>
				<!-- Page header end -->

				<!-- Main container start -->
<div class="main-container">
<!--------form start-->
<form id = "tag_creation" name="tag_creation" action="" method="post" enctype="multipart/form-data"> 
    <input type="hidden" class="form-control" value="<?php if(isset($hierarchy_id)) echo $hierarchy_id ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id">
    <input type="hidden" class="form-control" value="<?php if(isset($department_id)) echo $department_id ?>"  id="dept_id_upd" name="dept_id_upd" aria-describedby="id" placeholder="Enter id">
    <input type="hidden" class="form-control" value="<?php if(isset($branch_id)) echo $branch_id ?>"  id="branch_id_upd" name="branch_id_upd" aria-describedby="id" placeholder="Enter id">
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
                           <div class="col-md-12"> 
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
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
                                                <select disabled tabindex="1" type="text" class="form-control" id="company_id" name="company_id"  >
                                                    <option value="<?php echo $sbranch_id; ?>"><?php echo $sCompanyBranchDetail['company_name']; ?></option> 
                                                </select> 
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
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

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                        <label for="disabledInput">Department</label>
                                        <select tabindex="3" type="text" class="form-control" id="department" name="department" >
                                            <option value="">Select Department</option>
                                        </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Designation</label>
                                            <select readonly type="text" class="form-control" id="designation" name="designation[]" multiple style="height:300px;" >   
                                            </select> 
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Top Hierarchy </label>
                                            <select tabindex="4" type="text" class="form-control" id="top_hierarchy" name="top_hierarchy[]" multiple >
                                            </select> 
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Sub Ordinate</label>
                                            <select tabindex="5" type="text" class="form-control" id="sub_ordinate" name="sub_ordinate[]" multiple >
                                            </select> 
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <br><br>
                            <div class="text-right">
                                <button type="submit" name="submitHierarchyCreation" id="submitHierarchyCreation" class="btn btn-primary" value="Submit" tabindex="6">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary" tabindex="7">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>



