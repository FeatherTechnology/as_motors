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
if(isset($_POST['submitRolesResponsibilityCreation']) && $_POST['submitRolesResponsibilityCreation'] != '')
{
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){     
        $id = $_POST['id'];     
        $updateRolesResponsibilityCreation = $userObj->updateRolesResponsibilityCreation($mysqli,$id,$userid);  
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_roles_responsibility&msc=2';</script> 
        <?php   
    }
    else{   
        $addRolesResponsibilityCreation = $userObj->addRolesResponsibilityCreation($mysqli,$userid);   
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_roles_responsibility&msc=1';</script>
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
    $deleteRolesResponsibilityCreation = $userObj->deleteRolesResponsibilityCreation($mysqli,$del,$userid); 
    ?>
    <script>location.href='<?php echo $HOSTPATH; ?>edit_roles_responsibility&msc=3';</script>
    <?php   
}
if(isset($_GET['upd']))
{
    $idupd=$_GET['upd'];
}

if($idupd>0)
{
    $getRolesResponsibilityCreation = $userObj->getRolesResponsibilityCreation($mysqli,$idupd); 
    
    if(sizeof($getRolesResponsibilityCreation)>0) {
        for($ibranch=0;$ibranch<sizeof($getRolesResponsibilityCreation);$ibranch++)  {  
            $rr_id                = $getRolesResponsibilityCreation['rr_id'];
            $company_name         = $getRolesResponsibilityCreation['company_name'];
            $rr_ref_id            = $getRolesResponsibilityCreation['rr_ref_id']; 
            $department           = $getRolesResponsibilityCreation['department'];  
            $designation	       = $getRolesResponsibilityCreation['designation'];
            $rr                   = $getRolesResponsibilityCreation['rr'];	
        }
    } 

    $sCompanyBranchDetailEdit = $userObj->getsCompanyBranchDetail($mysqli, $company_name);
    if(sizeof($sCompanyBranchDetailEdit)>0) {
        for($ibranch=0;$ibranch<sizeof($sCompanyBranchDetailEdit);$ibranch++)  {  
            $branch_id                = $sCompanyBranchDetailEdit['branch_id'];
        }
    } 

    $editDepartment = $userObj->getEditDepartment($mysqli, $company_name);
    $editDesignation = $userObj->getEditDesignation($mysqli, $department);

    foreach($department as $dept)
    ?>

    <input type="hidden" id="company_nameEdit" name="company_nameEdit" value="<?php print_r($company_name); ?>" >
    <input type="hidden" id="departmentEdit" name="departmentEdit" value="<?php print_r($dept); ?>" >
    
<?php }
?>

<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Roles & Responsibility</li>
    </ol>

    <a href="edit_roles_responsibility">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    </a>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
            <!--------form start-->
    <form id = "create_ticket" name="create_ticket" action="" method="post" enctype="multipart/form-data"> 
        <input type="hidden" class="form-control" value="<?php if(isset($rr_id)) echo $rr_id; ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id" >
        <input type="hidden" class="form-control" value="<?php if(isset($company_name)) echo $company_name; ?>" id="company_id_upd" name="company_id_upd"  >
        <input type="hidden" class="form-control" value="<?php if(isset($department))  echo (implode(',',$department)); ?>"  id="department_id_upd" name="department_id_upd"  >
        <input type="hidden" class="form-control" value="<?php if(isset($designation)) echo (implode(',',$designation)); ?>"  id="designation_id_upd" name="designation_id_upd"  >
        <input type="hidden" name="branch_id" id="branch_id" class="form-control" value="<?php echo $sbranch_id; ?>" >

        <input type="hidden" name="rr_ref_id_deleted[]" id="rr_ref_id_deleted">

 		<!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12">
                <div class="card">
					<div class="card-header">
					</div>
                    <div class="card-header">Roles Responsibility Info<span class="required">*</span></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">   
                                        <label for="disabledInput">Company</label> 

                                        <?php if($sbranch_id == 'Overall'){ ?>
                                            <select tabindex="1" type="text" class="form-control" id="company_name" name="company_name"  >
                                                <option value="" disabled selected>Select Company Name</option>   
                                                <?php if(sizeof($companyName)>0) { 
                                                for($j=0;$j<count($companyName);$j++) { ?>
                                                <option <?php if(isset($company_name)) { if($companyName[$j]['company_id'] == $company_name)  echo 'selected'; }  ?> value="<?php echo $companyName[$j]['company_id']; ?>">
                                                <?php echo $companyName[$j]['company_name'];?></option>
                                                <?php }} ?>  
                                            </select>  
                                        <?php } else if($sbranch_id != 'Overall'){ ?>
                                            <input type="hidden" id="company_name" name="company_name" value="<?php echo $sCompanyBranchDetail['company_id']; ?>">
                                            <input type="text" class="form-control" id="company" name="company" value="<?php echo $sCompanyBranchDetail['company_name']; ?>" readonly>
                                        <?php } ?>

                                    </div>
                                </div>
                                
                            </div>

                        <br><br>

                        <div class="row">
                            <div class="col-md-12">
                                <table id="moduleTable" class="table custom-table">
                                    <thead>
                                        <tr>
                                            <th>Department</th>
                                            <th>R & R</th>
                                            <th>Designation</th>
                                            <th></th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <?php if($idupd<=0){ ?>

                                        <script language='javascript'> 
                                            window.onload=getdepartmentLoad;
                                            
                                            function getdepartmentLoad(){  
                                                var company_id = $("#branch_id").val(); 
                                                $.ajax({
                                                    url: 'R&RFile/ajaxR&RDepartmentDetails.php',
                                                    type: 'post',
                                                    data: { "company_id":company_id }, // Branch id passing but variable name company id.
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
                                        </script>

                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select tabindex="3" type="text" class="form-control department" id="department" name="department[]" >
                                                        <option value="">Select Department</option>
                                                    </select> 
                                                </td>
                                                <td>
                                                    <input type="text" tabindex="4" name="rr[]" id="rr" class="form-control" value="">
                                                </td>
                                                <td>
                                                    <select tabindex="6" type="text" class="form-control designation" id="designation" name="designation[]" >
                                                        <option value="">Select designation</option>
                                                    </select> 
                                                </td>
                                                <td>
                                                    <button type="button" tabindex="9" id="add_product" name="add_product" value="Submit" class="btn btn-primary add_product">Add</button> 
                                                </td>
                                                <td><span class='icon-trash-2' tabindex="10"></span></td>
                                            </tr>
                                        </tbody>
                                    <?php } if($idupd>0){ 
                                            if(isset($department)){ ?>
                                                <tbody>
                                                    <?php for($i=0; $i<=sizeof($department)-1; $i++) {      ?>
                                                        <tr>
                                                        <input type="hidden" class="rrrefid" name="rr_ref_id[]" id="rr_ref_id" value="<?php if(isset($rr_ref_id)){ echo $rr_ref_id[$i]; } ?>">
                                                            <td>
                                                                <select tabindex="3" type="text" class="form-control department" id="department" name="department[]" >
                                                                    <option value="">Select Department</option>   

                                                                    <?php if (sizeof($departmentList)>0) { 
                                                                    for($j=0;$j<count($departmentList);$j++) { ?>
                                                                    <option <?php if(isset($department)) { if($departmentList[$j]['department_id'] == $department[$i])  echo 'selected'; }  ?> value="<?php echo $departmentList[$j]['department_id']; ?>">
                                                                    <?php echo $departmentList[$j]['department_name'];?></option>
                                                                    <?php }} ?> 

                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" tabindex="4" name="rr[]" id="rr" class="form-control" value="<?php if(isset($rr)){ echo $rr[$i]; } ?>">
                                                            </td>
                                                            <td>
                                                            <select tabindex="6" type="text" class="form-control designation" id="designation" name="designation[]" >
                                                                <option value="">Select Designation</option> 

                                                                <?php if (sizeof($editDesignation)>0) { 
                                                                    for($j=0;$j<count($editDesignation);$j++) { ?>
                                                                    <option <?php if(isset($designation)) { if($editDesignation[$j]['designation_id'] == $designation[$i])  echo 'selected'; }  ?> value="<?php echo $editDesignation[$j]['designation_id']; ?>">
                                                                    <?php echo $editDesignation[$j]['designation_name'];?></option>
                                                                <?php }} ?> 

                                                            </select>
                                                            </td>
                                                            <td>
                                                                <button type="button" tabindex="9" id="add_product" name="add_product" value="Submit" class="btn btn-primary add_product">Add</button> 
                                                            </td>
                                                            <td><span class='deleterow icon-trash-2' tabindex="10" id="delete_row"></span></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            <?php }
                                        } ?>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="text-right">
                        <button type="submit"  tabindex="11"  id="submitRolesResponsibilityCreation" name="submitRolesResponsibilityCreation" value="Submit" class="btn btn-primary">Save</button>
                    </div>
                </div>       
            </div>
        </div>
    </div>
</div>      
</form>
</div>
