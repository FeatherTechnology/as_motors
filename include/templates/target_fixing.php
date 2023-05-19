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
$projectCreationList = $userObj->getProjectCreationList($mysqli);
$goalYear = $userObj->getGoalYear($mysqli);

$id=0;
if(isset($_POST['submitTargetFixing']) && $_POST['submitTargetFixing'] != '')
{
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){     
        $id = $_POST['id'];     
        $updateKraKpiCreation = $userObj->updateKraKpiCreation($mysqli,$id,$userid);  
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_krakpi_creation&msc=2';</script> 
        <?php   
    }
    else{   
        $addKraKpiCreation = $userObj->addKraKpiCreation($mysqli,$userid);   
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_krakpi_creation&msc=1';</script>
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
    $deleteKraKpiCreation = $userObj->deleteKraKpiCreation($mysqli,$del,$userid); 
    ?>
    <script>location.href='<?php echo $HOSTPATH; ?>edit_krakpi_creation&msc=3';</script>
    <?php   
}
if(isset($_GET['upd']))
{
    $idupd=$_GET['upd'];
}

if($idupd>0)
{
    $getKraKpiCreation = $userObj->getKraKpiCreation($mysqli,$idupd); 
    
    if(sizeof($getKraKpiCreation)>0) {
        for($ibranch=0;$ibranch<sizeof($getKraKpiCreation);$ibranch++)  {  

            $krakpi_id                = $getKraKpiCreation['krakpi_id'];
            $company_name         = $getKraKpiCreation['company_name'];
            $department           = $getKraKpiCreation['department']; 
			$designation	      = $getKraKpiCreation['designation']; 

            $krakpi_ref_id            = $getKraKpiCreation['krakpi_ref_id'];
			$rr                   = $getKraKpiCreation['rr'];	
			$frequency            = $getKraKpiCreation['frequency'];
			$calendar            = $getKraKpiCreation['calendar'];
			$from_date            = $getKraKpiCreation['from_date'];
			$to_date            = $getKraKpiCreation['to_date'];
            $criteria        = $getKraKpiCreation['criteria']; 
            $project_id        = $getKraKpiCreation['project_id']; 
            $kra_category             = $getKraKpiCreation['kra_category']; 
            $kpi             = $getKraKpiCreation['kpi']; 
        }
    }

    $sCompanyBranchDetailEdit = $userObj->getsCompanyBranchDetail($mysqli, $company_name);
    $kraCategory = $userObj->kraCategoryDepartmentBased($mysqli, $company_name, $department);
    $rrList = $userObj->getRNRDepartmentBased($mysqli, $company_name, $department);

    $editDepartment = $userObj->getEditDepartment($mysqli, $company_name);
    $editDesignation = $userObj->getEditDesignationKRAKPI($mysqli, $department);
    ?>

    <input type="hidden" id="designationEdit" name="designationEdit" value="<?php print_r($designation); ?>" >
    <input type="hidden" id="company_nameEdit" name="company_nameEdit" value="<?php print_r($company_name); ?>" >
    <input type="hidden" id="kra_id_Edit" name="kra_id_Edit" class="form-control" value="<?php if(isset($kra_category)) echo (implode(',',$kra_category)); ?>" >
    <input type="hidden" id="rr_id_Edit" name="rr_id_Edit" class="form-control" value="<?php if(isset($rr)) echo (implode(',',$rr)); ?>" >
    
<?php
}
?>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Target Fixing</li>
    </ol>

    <a href="edit_krakpi_creation">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    </a>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
            <!--form start-->
    <form id = "create_ticket" name="create_ticket" action="" method="post" enctype="multipart/form-data"> 
        <input type="hidden" class="form-control" value="<?php if(isset($krakpi_id)) echo $krakpi_id; ?>"  id="id" name="id" placeholder="Enter id" >
        <input type="hidden" class="form-control" value="<?php if(isset($company_name)) echo $company_name; ?>"  id="company_id_upd" name="company_id_upd" placeholder="Enter id" >
        <input type="hidden" class="form-control" value="<?php if(isset($department)) echo $department; ?>"  id="department_upd" name="department_upd" >
        <input type="hidden" class="form-control" value="<?php if(isset($designation)) echo $designation; ?>"  id="designation_upd" name="designation_upd" >
        <input type="hidden" class="form-control" value="<?php if(isset($kra_category)) echo (implode(',',$kra_category)); ?>"  id="kra_id_upd" name="kra_id_upd" >
        <input type="hidden" class="form-control" value="<?php if(isset($rr)) echo (implode(',',$rr)); ?>"  id="rr_id_upd" name="rr_id_upd" >
 		<!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12">
                <div class="card">
					<div class="card-header">
					</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">   
                                    <label for="disabledInput">Company</label>   
                                    <?php if($sbranch_id == 'Overall'){ ?>
                                        <select tabindex="1" type="text" class="form-control" id="company_name" name="company_name" >
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

                                <script language='javascript'> 
                                    window.onload=getdepartmentLoad; 
                                    
                                    // get department details
                                    function getdepartmentLoad(){ 
                                      var department_upd = $('#department_upd').val();
                                      $.ajax({
                                        url: 'KRA&KPIFile/ajaxKra&KpiDepartmentDetailsLoad.php',
                                        type: 'post',
                                        data: {},
                                        dataType: 'json',
                                        success:function(response){ 

                                          $('#department').empty();
                                          $('#department').prepend("<option value=''>" + 'Select Department Name' + "</option>");
                                          var r = 0;
                                          for (r = 0; r <= response.department_id.length - 1; r++) { 
                                            var selected = "";
                                            if(department_upd == response['department_id'][r]){
                                              selected = "selected";
                                            }
                                            $('#department').append("<option value='" + response['department_id'][r] + "' "+selected+">" + response['department_name'][r] + "</option>");
                                          }
                                        }
                                      });
                                      
                                    //   getrrdropdownLoad();
                                    }
                                </script>
                                
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
                                            <?php if (sizeof($editDepartment)>0) { 
                                            for($j=0;$j<count($editDepartment);$j++) { ?>
                                            <option <?php if(isset($department)) { if($editDepartment[$j]['department_id'] == $department)  echo 'selected'; }  ?>
                                            value="<?php echo $editDepartment[$j]['department_id']; ?>">
                                            <?php echo $editDepartment[$j]['department_name'];?></option>
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
                                            <?php if (sizeof($editDesignation)>0) { 
                                                for($j=0;$j<count($editDesignation);$j++) { ?>
                                                <option <?php if(isset($designation)) { if($editDesignation[$j]['designation_id'] == $designation) echo 'selected'; } ?>
                                                value="<?php echo $editDesignation[$j]['designation_id']; ?>">
                                                <?php echo $editDesignation[$j]['designation_name'];?></option>
                                            <?php }} ?>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="disabledInput">Staff Name</label>
                                    <select tabindex="4" type="text" class="form-control" id="staff_name" name="staff_name" >
                                        <option value="">Select Staff Name</option>  
                                    </select>
                                </div>
                            </div>
         
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="disabledInput">Year</label>
                                    <select tabindex="4" type="text" class="form-control" id="goal_year" name="goal_year" >
                                        <option value="">Select Year</option>    
                                            <?php if (sizeof($goalYear)>0) { 
                                            for($j=0;$j<count($goalYear);$j++) { ?>
                                            <option <?php if(isset($designation)) { if($goalYear[$j]['goal_setting_id'] == $designation) echo 'selected'; } ?>
                                            value="<?php echo $goalYear[$j]['goal_setting_id']; ?>">
                                            <?php echo $goalYear[$j]['year'];?></option>
                                            <?php }} ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="disabledInput">No. of Months</label>
                                    <input type="number" tabindex = "8" name="no_of_months" id="no_of_months" class="form-control" value="<?php if (isset($no_of_months)) echo $no_of_months; ?>">
                                </div>
                            </div>

                            <?php if($idupd<=0){ ?>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12" style="margin-top: 19px;">
                                    <div class="form-group">
                                        <button tabindex="3" type="button" class="btn btn-primary" id="executeGoalSettingDetails" name="executeGoalSettingDetails" data-toggle="modal" style="padding: 5px 35px;">Execute</button>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                    <br><br>
                    </div>
                    </div>
                

                    <div id="goadSettingDetailsAppend"></div>

                    <div class="col-md-12">
                        <div class="text-right">
                            <button type="submit" tabindex="13" id="submitTargetFixing" name="submitTargetFixing" value="Submit" class="btn btn-primary">Submit</button>
                            <button type="reset" tabindex="14" id="cancelbtn" name="cancelbtn" class="btn btn-outline-secondary">Cancel</button><br /><br />
                        </div>
                    </div>  
                
            </div>     
        </div>
    </form>
</div>


<!-- Add Course Project Modal -->
<div class="modal fade addProjectModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color: white">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Add New Assertion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="DropDownCourse()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="categoryInsertNotOk" class="unsuccessalert">Assertion Already Exists, Please Enter a Different Name!
                <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <div id="categoryInsertOk" class="successalert">Assertion Added Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <div id="categoryUpdateOk" class="successalert">Assertion Updated Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <div id="categoryDeleteNotOk" class="unsuccessalert">You Don't Have Rights To Delete This Assertion!
                <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <div id="categoryDeleteOk" class="successalert">Assertion Has been Inactivated!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <br />
                <div class="row">

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                        <label >Old Assertion<span class="text-danger">*</span></label>
                        <input type="text" readonly class="form-control" id="new_assertion" name="new_assertion">
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                        <label >New Assertion<span class="text-danger">*</span></label>
                        <input type="text"  class="form-control" id="new_assertion" name="new_assertion" placeholder="Enter New Assertion">
                        <!-- <span id="customernamecheckNew" class="text-danger">Enter New Assertion</span> -->
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label class="label">New Target<span class="text-danger">*</span></label>
                            <input  type="number" tabindex="46" name="new_target" id="new_target" class="form-control" placeholder='Enter New Target'>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                        <label >Applicability<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="new_assertion" name="new_assertion" placeholder="Enter Applicability">
                        <!-- <span id="customernamecheckNew" class="text-danger">Enter New Assertion</span> -->
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="addCustSubmit">Submit</button>
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closemodal">Cancel</button> -->
                </div>

                <div id="updatedprojectTable"> 
                    <table class="table custom-table" id="projectTable"> 
                        <thead>
                            <tr>
                                <th>S. NO</th>
                                <th>NEW ASSERTION</th>
                                <th>NEW TARGET</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (sizeof($projectCreationList)>0) { 
                                for($j=0;$j<count($projectCreationList);$j++) { ?>
                                <tr>
                                    <td class="col-md-2 col-xl-2"><?php echo $j+1; ?></td>
                                    <td><?php echo $projectCreationList[$j]['project_name']; ?></td>
                                    <td><?php echo $projectCreationList[$j]['project_name']; ?></td>
                                    <td>
                                        <a id="edit_project" value="<?php echo $projectCreationList[$j]['project_id'] ?>"><span class="icon-border_color"></span></a> &nbsp
                                        <a id="delete_project" value="<?php echo $projectCreationList[$j]['project_id'] ?>"><span class='icon-trash-2'></span></a>
                                    </td>
                                </tr>
                            <?php } } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="DropDownCourse()">Close</button>
            </div>

        </div>
    </div>
</div>

