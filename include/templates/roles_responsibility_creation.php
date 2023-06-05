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
            // $frequency             = $getRolesResponsibilityCreation['frequency'];
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

    <script>
        // window.onload=editCompanyBasedBranch;
        // function editCompanyBasedBranch(){
        //     var branch_id = $('#company_nameEdit').val();
        //     $.ajax({
        //         url: 'R&RFile/ajaxEditCompanyBasedBranch.php',
        //         type:'post',
        //         data: {'branch_id': branch_id},
        //         dataType: 'json',
        //         success: function(response){
                    
        //             $("#branch_id").empty();
        //             $("#branch_id").prepend("<option value='' disabled selected>"+'Select Branch Name'+"</option>");
        //             var r = 0;

        //             for (r = 0; r <= response.branch_id.length - 1; r++) { 
        //                 var selected = "";
        //                 if(response['branch_id'][r] == branch_id)
        //                 {
        //                     selected = "selected";
        //                 }
        //                 $('#branch_id').append("<option value='" + response['branch_id'][r] + "' "+selected+">" +  response['branch_name'][r] + "</option>");
        //             }

        //         }
        //     });

        //     // editBranchBasedDepartment();
        // }

        // function editBranchBasedDepartment(){  
        //     var company_id = $('#company_nameEdit').val(); 
        //     var department = $('#departmentEdit').val();  
        //     $.ajax({
        //         url: 'R&RFile/ajaxR&RDepartmentDetails.php',
        //         type:'post',
        //         data: {'company_id': company_id},
        //         dataType: 'json',
        //         success: function(response){
            
        //             $('#department').empty();
        //             $('#department').prepend("<option value=''>" + 'Select Department Name' + "</option>");
        //             var r = 0;
        //             for (r = 0; r <= response.department_id.length - 1; r++) { 
        //                 var selected = "";
        //                 if(response['department_id'][r] == department)
        //                 {
        //                     selected = "selected";
        //                 }
        //                 $('#department').append("<option value='" + response['department_id'][r] + "' "+selected+">" + 
        //                 response['department_name'][r] + "</option>");
        //             }

        //         }
        //     });
        // }

    </script>
    
<?php }
?>

<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Roles & Responsibility</li>
    </ol>

    <a href="edit_roles_responsibility">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    <!-- <button type="button" class="btn btn-primary"><span class="icon-border_color"></span>&nbsp Edit Employee Master</button> -->
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
 		<!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12">
                <div class="card">
					<div class="card-header">
						<!-- <div class="card-title">General Info</div> -->
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

                                <!-- <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
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
                                </div> -->
                                
                            </div>

                        <br><br>

                        <div class="row">
                            <div class="col-md-12">
                                <table id="moduleTable" class="table custom-table">
                                    <thead>
                                        <tr>
                                            <th>Department</th>
                                            <th>R & R</th>
                                            <!-- <th>Applicability</th> -->
                                            <th>Designation</th>
                                            <!-- <th>Frequency</th> -->
                                            <!-- <th>Code Ref</th> -->
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
                                                <!-- <td>
                                                    <select tabindex="5" type="text" class="form-control applicability" id="applicability" name="applicability[]" >
                                                        <option value="">Select Applicability</option>
                                                        <option value="Common">Common</option>
                                                        <option value="Specific">Specific</option>
                                                    </select> 
                                                </td> -->
                                                <td>
                                                    <select tabindex="6" type="text" class="form-control designation" id="designation" name="designation[]" >
                                                        <option value="">Select designation</option>
                                                    </select> 
                                                </td>
                                                <!-- <td>
                                                    <select tabindex="9" type="text" class="form-control frequency" id="frequency" name="frequency[]" >
                                                        <option value=''>Select Frequency</option>
                                                        <option value='Fortnightly'>Fortnightly</option>
                                                        <option value='Monthly'>Monthly</option>
                                                        <option value='Quaterly'>Quaterly</option>
                                                        <option value='Half Yearly'>Half Yearly</option>
                                                        <option value='yearly'>Yearly</option>
                                                        <option value='Event Driven'>Event Driven</option>
                                                    </select>
                                                </td> -->
                                                
                                                <!-- <td>
                                                    <input type="text" tabindex="8" name="code_ref[]" id="code_ref" class="form-control" value="">
                                                </td> -->
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
                                                        <input type="hidden" name="rr_ref_id[]" id="rr_ref_id" value="<?php if(isset($rr_ref_id)){ echo $rr_ref_id[$i]; } ?>">
                                                            <td>
                                                                <select tabindex="3" type="text" class="form-control department" id="department" name="department[]" >
                                                                    <option value="">Select Department</option>   

                                                                    <?php if (sizeof($editDepartment)>0) { 
                                                                    for($j=0;$j<count($editDepartment);$j++) { ?>
                                                                    <option <?php if(isset($department)) { if($editDepartment[$j]['department_id'] == $department[$i])  echo 'selected'; }  ?> value="<?php echo $editDepartment[$j]['department_id']; ?>">
                                                                    <?php echo $editDepartment[$j]['department_name'];?></option>
                                                                    <?php }} ?> 

                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" tabindex="4" name="rr[]" id="rr" class="form-control" value="<?php if(isset($rr)){ echo $rr[$i]; } ?>">
                                                            </td>
                                                            <!-- <td>
                                                                <select tabindex="5" type="text" class="form-control" id="applicability" name="applicability[]" >

                                                                    <option <?php if(isset($applicability)) { if('Common' == $applicability[$i]) echo 'selected';  ?> value="<?php echo 'Common' ?>">
                                                                    <?php echo 'Common'; }else{ ?> <option value="Common">Common</option>   <?php } ?></option>

                                                                    <option <?php if(isset($applicability)) { if('Specific' == $applicability[$i]) echo 'selected';  ?> value="<?php echo 'Specific' ?>">
                                                                    <?php echo 'Specific'; }else{ ?> <option value="Specific">Specific</option> <?php } ?></option> 

                                                                </select> 
                                                            </td> -->
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
                                                            <!-- <td>
                                                                <select tabindex="9" type="text" class="form-control" id="frequency" name="frequency[]" >
                                                                <option <?php if(isset($frequency)) { if('Fortnightly' == $frequency[$i]) echo 'selected';  ?> value="<?php echo 'Fortnightly' ?>">
                                                                <?php echo 'Fortnightly'; }else{ ?> <option value="Fortnightly">Fortnightly</option>   <?php } ?></option>
                                                                <option <?php if(isset($frequency)) { if('Monthly' == $frequency[$i]) echo 'selected';  ?> value="<?php echo 'Monthly' ?>">
                                                                <?php echo 'Monthly'; }else{ ?> <option value="Monthly">Monthly</option> <?php } ?></option> 
                                                                <option <?php if(isset($frequency)) { if('Quaterly' == $frequency[$i]) echo 'selected';  ?> value="<?php echo 'Quaterly' ?>">
                                                                <?php echo 'Quaterly'; }else{ ?> <option value="Quaterly">Quaterly</option> <?php } ?></option> 
                                                                <option <?php if(isset($frequency)) { if('Half Yearly' == $frequency[$i]) echo 'selected';  ?> value="<?php echo 'Half Yearly' ?>">
                                                                <?php echo 'Half Yearly'; }else{ ?> <option value="Half Yearly">Half Yearly</option> <?php } ?></option> 
                                                                <option <?php if(isset($frequency)) { if('yearly' == $frequency[$i]) echo 'selected';  ?> value="<?php echo 'yearly' ?>">
                                                                <?php echo 'yearly'; }else{ ?> <option value="yearly">yearly</option> <?php } ?></option> 
                                                                <option <?php if(isset($frequency)) { if('Event Driven' == $frequency[$i]) echo 'selected';  ?> value="<?php echo 'Event Driven' ?>">
                                                                <?php echo 'Event Driven'; }else{ ?> <option value="Event Driven">Event Driven</option> <?php } ?></option> 
                                                                </select>
                                                            </td> -->
                                                            <!-- <td>
                                                                <input type="text" tabindex="8" name="code_ref[]" id="code_ref" class="form-control" value="<?php if(isset($code_ref)){ echo $code_ref[$i]; } ?>">
                                                            </td> -->
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
                        <!-- <button type="reset"  tabindex="12"  id="cancelbtn" name="cancelbtn" class="btn btn-outline-secondary">Cancel</button><br /><br /> -->
                    </div>
                </div>       
            </div>
        </div>
    </div>
</div>      
</form>
</div>
