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

    if(isset($_POST['upd_id']) && $_POST['upd_id'] >0 ){  
        $upd_id = $_POST['upd_id'];     
        $updateTargetFixing = $userObj->updateTargetFixing($mysqli,$upd_id,$userid);  
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_target_fixing&msc=2';</script> 
        <?php   
    }
    else{   
        $addTargetFixing = $userObj->addTargetFixing($mysqli,$userid);   
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_target_fixing&msc=1';</script>
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
    $deleteTargetFixing = $userObj->deleteTargetFixing($mysqli,$del,$userid); 
    ?>
    <script>location.href='<?php echo $HOSTPATH; ?>edit_target_fixing&msc=3';</script>
    <?php   
}
if(isset($_GET['upd']))
{
    $idupd=$_GET['upd'];
}

if($idupd>0)
{
    $getTargetFixing = $userObj->getTargetFixing($mysqli,$idupd); 
    
    if(sizeof($getTargetFixing)>0) {
        for($ibranch=0;$ibranch<sizeof($getTargetFixing);$ibranch++)  {  

            $target_fixing_id                = $getTargetFixing['target_fixing_id'];  
            $company_name         = $getTargetFixing['company_id'];
            $department           = $getTargetFixing['department']; 
			$designation	      = $getTargetFixing['designation']; 
			$emp_id	      = $getTargetFixing['emp_id']; 
			$year_id	      = $getTargetFixing['year_id']; 
			$no_of_months	      = $getTargetFixing['no_of_months']; 

            $target_fixing_ref_id            = $getTargetFixing['target_fixing_ref_id'];
			$goal_setting_and_kra_id                   = $getTargetFixing['goal_setting_and_kra_id'];	
			$assertion            = $getTargetFixing['assertion'];
			$target            = $getTargetFixing['target'];
			$new_assertion            = $getTargetFixing['new_assertion'];
			$new_target            = $getTargetFixing['new_target'];
            $applicability        = $getTargetFixing['applicability']; 
            $deleted_date        = $getTargetFixing['deleted_date']; 
            $deleted_remarks             = $getTargetFixing['deleted_remarks']; 
        }
    } 
    $sCompanyBranchDetailEdit = $userObj->getsCompanyBranchDetail($mysqli, $company_name);
    ?>

    <input type="hidden" id="company_nameEdit" name="company_nameEdit" value="<?php print_r($company_name); ?>" >
    <input type="hidden" id="departmentEdit" name="departmentEdit" value="<?php print_r($department); ?>" >
    <input type="hidden" id="designationEdit" name="designationEdit" value="<?php print_r($designation); ?>" >
    <input type="hidden" id="empEdit" name="empEdit" value="<?php print_r($emp_id); ?>" >
    
    <script>
        window.onload=editDepartment;
        function editDepartment(){  

            var company_id = $('#company_nameEdit').val();
            var department_upd = $('#departmentEdit').val();
            $.ajax({
                url: 'KRA&KPIFile/ajaxKra&KpiFetchDepartmentDetails.php',
                type: 'post',
                data: { "company_id":company_id },
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

            editDesignation();
            editStaff();
        }   

        // get reporting details
        function editDesignation(){ 
            var company_id = $('#company_nameEdit').val();
            var department_id = $('#departmentEdit').val();
            var designation_upd = $('#designationEdit').val();

            $.ajax({
                url: 'KRA&KPIFile/ajaxKra&KpiFetchDesignationDetails.php',
                type: 'post',
                data: { "company_id":company_id, "department_id":department_id },
                dataType: 'json',
                success:function(response){
                
                    $('#designation').empty();
                    $('#designation').prepend("<option value=''>" + 'Select Designation' + "</option>");
                    var i = 0;
                    for (i = 0; i <= response.designation_id.length - 1; i++) { 
                        var selected = "";
                        if(designation_upd == response['designation_id'][i]){
                            selected = "selected";
                        }
                        $('#designation').append("<option value='" + response['designation_id'][i] + "' "+selected+" >" + response['designation_name'][i] + "</option>");
                    }
                }
            });
        };

        function editStaff(){ 
            var company_id = $("#company_nameEdit").val();
            var department_id = $("#departmentEdit").val();
            var designation_id = $("#designationEdit").val();
            var emp_upd = $("#empEdit").val();

            if(designation_id.length==''){ 
                $("#designation").val('');
            }else{
            $.ajax({
                url: 'insuranceFile/ajaxGetDesignationBasedStaff.php',
                type: 'post',
                data: { "company_id":company_id, "department_id":department_id, "designation_id":designation_id },
                dataType: 'json',
                success:function(response){
                
                    $('#staff_name').empty();
                    $('#staff_name').prepend("<option value=''>" + 'Select Staff Name' + "</option>");
                    var i = 0;
                    for (i = 0; i <= response.staff_id.length - 1; i++) { 
                        var selected = "";
                        if(emp_upd == response['staff_id'][i]){
                            selected = "selected";
                        }
                        $('#staff_name').append("<option value='" + response['staff_id'][i] + "' "+selected+" >" + response['staff_name'][i] + "</option>");
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
        <li class="breadcrumb-item">AS - Target Fixing</li>
    </ol>

    <a href="edit_target_fixing">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    </a>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
            <!--form start-->
    <form id = "create_ticket" name="create_ticket" action="" method="post" enctype="multipart/form-data"> 
        <input type="hidden" class="form-control" value="<?php if(isset($target_fixing_id)) echo $target_fixing_id; ?>"  id="upd_id" name="upd_id" placeholder="Enter id" >
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
                                
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="disabledInput">Department</label>
                                    <select tabindex="3" type="text" class="form-control" id="department" name="department" >
                                        <option value="">Select Department</option>   
                                    </select>
                                </div>
                            </div>
             
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="disabledInput">Designation</label>
                                    <select tabindex="4" type="text" class="form-control" id="designation" name="designation" >
                                            <option value="">Select Designation</option>   
                                    </select>
                                </div>
                            </div>

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
                                        <option <?php if(isset($year_id)) { if($goalYear[$j]['goal_setting_id'] == $year_id) echo 'selected'; } ?>
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

                    <?php if($idupd>0){ ?>

                        <div class="card" id="stockinformation">
                            <div class="card-header">Goal Setting Details</div>
                            <div class="card-body">
                            <br> 
                                <div style="overflow-x: auto; white-space: nowrap;" >

                                    <table class="table custom-table" id="sstable">
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Assertion</th>
                                            <th>Target</th>
                                            <th>Action</th>
                                            <th>New Assertion</th>
                                            <th>New Target</th>
                                            <th>Applicability</th>
                                            <th>Deleted Date</th>
                                            <th>Deleted Remarks</th>
                                        </tr>
                                        <?php
                                        $sno = 1;   
                                        if(isset($goal_setting_and_kra_id)){ 
                                            for($o=0; $o<=sizeof($goal_setting_and_kra_id)-1; $o++){ 
                                                $subString = "_kra";
                                                ?>
                                                <tbody>
                                                    <tr>
                                                        <td><?php echo $sno; ?></td>
                                                        <td style="display: none;" ><input type="text" readonly class="form-control" value="<?php echo $target_fixing_ref_id[$o]; ?>" name="target_fixing_ref_id[]" id="target_fixing_ref_id" ></td>
                                                        <td style="display: none;" ><input type="text" readonly class="form-control" value="<?php echo $goal_setting_and_kra_id[$o]; ?>" name="id[]" id="id" ></td>
                                                        <td><input readonly type="text" class="form-control" value="<?php echo $assertion[$o]; ?>" name="assertion[]" id="assertion" ></td>
                                                        <?php 
                                                        if (strpos($goal_setting_and_kra_id[$o], $subString) !== false) { ?>
                                                            <td><input type="number" class="form-control" value="<?php echo $target[$o]; ?>" name="target[]" id="target" ></td>
                                                        <?php } else { ?>
                                                            <td><input readonly type="number" class="form-control" value="<?php echo $target[$o]; ?>" name="target[]" id="target" ></td>
                                                        <?php } ?>
                                                        <td>
                                                            <?php if($new_assertion[$o] != ''){ ?>
                                                                <input type="checkbox" checked id="edit_assertion" name="edit_assertion[]" class="edit_assertion" value="edit">
                                                                <label for="edit_assertion"> EDIT</label> &nbsp;&nbsp;
                                                            <?php } else { ?>
                                                                <input type="checkbox" id="edit_assertion" name="edit_assertion[]" class="edit_assertion" value="edit">
                                                                <label for="edit_assertion"> EDIT</label> &nbsp;&nbsp;
                                                            <?php } ?>
                                                            <?php if($deleted_date[$o] != ''){ ?>
                                                                <input type="checkbox" checked id="delete_assertion" name="delete_assertion[]" class="delete_assertion" value="delete">
                                                                <label for="delete_assertion"> DELETE</label><br>
                                                            <?php } else { ?>
                                                                <input type="checkbox" id="delete_assertion" name="delete_assertion[]" class="delete_assertion" value="delete">
                                                                <label for="delete_assertion"> DELETE</label><br>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if($new_assertion[$o] != ''){ ?>
                                                                <input type="text" class="form-control" name="new_assertion[]" id="new_assertion" value="<?php echo $new_assertion[$o]; ?>" >
                                                            <?php } else { ?>
                                                                <input readonly type="text" class="form-control" name="new_assertion[]" id="new_assertion" value="<?php echo $new_assertion[$o]; ?>" >
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if($new_assertion[$o] != ''){ ?>
                                                                <input type="number" class="form-control" name="new_target[]" id="new_target" value="<?php echo $new_target[$o]; ?>" >
                                                            <?php } else { ?>
                                                                <input readonly type="number" class="form-control" name="new_target[]" id="new_target" value="<?php echo $new_target[$o]; ?>" >
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if($new_assertion[$o] != ''){ ?>
                                                                <input type="text" class="form-control" name="applicability[]" id="applicability" value="<?php echo $applicability[$o]; ?>" >
                                                            <?php } else { ?>
                                                                <input readonly type="text" class="form-control" name="applicability[]" id="applicability" value="<?php echo $applicability[$o]; ?>" >
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if($deleted_date[$o] != ''){ ?>
                                                                <input  type="text" class="form-control" name="deleted_date[]" id="deleted_date" value="<?php echo $deleted_date[$o]; ?>" >
                                                            <?php } else { ?>
                                                                <input readonly type="text" class="form-control" name="deleted_date[]" id="deleted_date" value="<?php echo $deleted_date[$o]; ?>" >
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if($deleted_date[$o] != ''){ ?>
                                                                <textarea id="deleted_remarks" name="deleted_remarks[]" class="form-control" rows="2" cols="40" ><?php echo $deleted_remarks[$o]; ?></textarea>
                                                            <?php } else { ?>
                                                                <textarea readonly id="deleted_remarks" name="deleted_remarks[]" class="form-control" rows="2" cols="40" ><?php echo $deleted_remarks[$o]; ?></textarea>
                                                            <?php } ?>
                                                            
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            <?php $sno = $sno + 1; }
                                        } ?>
                                    </table>
                                </div>
                            </div>
                        </div>

                    <?php } ?>

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
<!-- <button type="button" id="callAssertion" style="display: none" data-toggle="modal" data-target=".addProjectModal"></button>
<div class="modal fade addProjectModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" >
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
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="addCustSubmit">Submit</button>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="DropDownCourse()">Close</button>
            </div>

        </div>
    </div>
</div> -->

