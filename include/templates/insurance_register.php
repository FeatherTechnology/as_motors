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
$insuranceName = $userObj->getInsuranceName($mysqli);
$id=0;
 if(isset($_POST['submitInsurance_register']) && $_POST['submitInsurance_register'] != '')
 {
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
        $updateAssetRegister = $userObj->updateInsuranceRegister($mysqli,$id);  
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_insurance_register&msc=2';</script> 
    <?php }
    else{   
		$addAssetRegister = $userObj->addInsuranceRegister($mysqli);   
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_insurance_register&msc=1';</script>
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
	$deleteAssetRegister = $userObj->deleteInsuranceRegister($mysqli,$del); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_insurance_register&msc=3';</script>
<?php	
}
$idupd=0;
if(isset($_GET['upd']))
{
$idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{
	$getInsuranceRegisterList = $userObj->getInsuranceRegisterTable($mysqli,$idupd); 
	if (sizeof($getInsuranceRegisterList)>0) { 
        for($i=0;$i<sizeof($getInsuranceRegisterList);$i++)  {	
            $ins_reg_id                      = $getInsuranceRegisterList[$i]['ins_reg_id'];
			$company_id              	 = $getInsuranceRegisterList[$i]['company_id'];
			$insurance_id          		 = $getInsuranceRegisterList[$i]['insurance_id'];
			$policy_company          		 = $getInsuranceRegisterList[$i]['policy_company'];
			$policy_number          		 = $getInsuranceRegisterList[$i]['policy_number'];
			$policy_upload          		 = $getInsuranceRegisterList[$i]['policy_upload'];
			$dept_id      			             = $getInsuranceRegisterList[$i]['dept_id'];
			$freq_id		             = $getInsuranceRegisterList[$i]['freq_id'];
			$department_id		             = $getInsuranceRegisterList[$i]['department_id'];
			$designation_id		             = $getInsuranceRegisterList[$i]['designation_id'];
			$staff_id		             = $getInsuranceRegisterList[$i]['staff_id'];
			$calendar		             = $getInsuranceRegisterList[$i]['calendar'];
			$from_date		             = date('Y-m-d',strtotime($getInsuranceRegisterList[$i]['from_date'])); 
			$to_date		             = date('Y-m-d',strtotime($getInsuranceRegisterList[$i]['to_date']));  
			$frequency_applicable		 = $getInsuranceRegisterList[$i]['frequency_applicable'];
		}
	}

    $sCompanyBranchDetailEdit = $userObj->getsBranchBasedCompanyName($mysqli, $company_id);
    ?>

    <input type="hidden" id="company_nameEdit" name="company_nameEdit" value="<?php print_r($company_id); ?>" >
    <input type="hidden" id="insuranceEdit" name="insuranceEdit" value="<?php print_r($insurance_id); ?>" >
    <input type="hidden" id="deptEdit" name="deptEdit" value="<?php print_r($dept_id); ?>" >
    <input type="hidden" id="departmentEdit" name="departmentEdit" value="<?php print_r($department_id); ?>" >
    <input type="hidden" id="designationEdit" name="designationEdit" value="<?php print_r($designation_id); ?>" >
    <input type="hidden" id="staffEdit" name="staffEdit" value="<?php print_r($staff_id); ?>" >
    <input type="hidden" id="calendarEdit" name="calendarEdit" value="<?php print_r($calendar); ?>" >
    <input type="hidden" id="freq_idEdit" name="freq_idEdit" value="<?php print_r($freq_id); ?>" >
   
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

            var branch_id = $('#company_nameEdit').val();
            var insurance_upd = $('#insuranceEdit').val();
            var department_upd = $('#deptEdit').val();
            
            var departmentEdit = $('#departmentEdit').val();
            var designationEdit = $('#designationEdit').val(); 
            var staffEdit = $('#staffEdit').val();

            // enable disable calendar
            var calendar = $('#calendarEdit').val();
            if(calendar == 'Yes'){ 
                $('#from_date').attr("readonly",false);
                $('#to_date').attr("readonly",false);
            } else if(calendar == 'No'){ 
                $('#from_date').attr("readonly",true);
                $('#to_date').attr("readonly",true);
                $('#from_date').val('');
                $('#to_date').val('');
            }

            // enable and disable frequency
            var frequency = $('#freq_idEdit').val(); 
            if(frequency == '1'){ 
                $('#frequency_applicable').attr("disabled",false);
            } else  if(frequency == '2'){ 
                $('#frequency_applicable').prop('checked', false);
                $('#frequency_applicable').attr("disabled",true);
            }
    
            resetinsuranceTable(branch_id);
            DropDownInsuranceEdit(branch_id, insurance_upd);
            DropDownDepartmentEdit(branch_id, department_upd);

            getBranchBasedDepartmentEdit(branch_id, departmentEdit);
            getDepartmentBasedDesignationEdit(branch_id, departmentEdit, designationEdit);
            getDesignationBasedStaffEdit(branch_id, departmentEdit, designationEdit, staffEdit);
        }

        function getBranchBasedDepartmentEdit(branch_id, departmentEdit){ 

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

        function getDepartmentBasedDesignationEdit(company_id, department_id, designationEdit){  

            $.ajax({
                url: 'StaffFile/ajaxStaffDesignationDetails.php',
                type: 'post',
                data: { "company_id":company_id, "department_id":department_id },
                dataType: 'json',
                success:function(response){
                
                    $('#designation').empty();
                    $('#designation').prepend("<option value=''>" + 'Select Designation' + "</option>");
                    var i = 0;
                    for (i = 0; i <= response.designation_id.length - 1; i++) { 
                        var selected = "";
                        if(response['designation_id'][i] == designationEdit) 
                        { 
                            selected = "selected";
                        }
                        $('#designation').append("<option value='" + response['designation_id'][i] + "' "+selected+">" + response['designation_name'][i] + "</option>");
                    }
                }
            });
        }

        // function getDesignationBasedStaffEdit(company_id, department_id, designation_id, staffEdit){  

        //     $.ajax({
        //         url: 'insuranceFile/ajaxGetDesignationBasedStaff.php',
        //         type: 'post',
        //         data: { "company_id":company_id, "department_id":department_id, "designation_id":designation_id },
        //         dataType: 'json',
        //         success:function(response){
                
        //             $('#staff_name').empty();
        //             $('#staff_name').prepend("<option value=''>" + 'Select Staff Name' + "</option>");
        //             var i = 0;
        //             for (i = 0; i <= response.staff_id.length - 1; i++) { 
        //                 var selected = "";
        //                 if(response['staff_id'][i] == staffEdit) 
        //                 { 
        //                     selected = "selected";
        //                 }
        //                 $('#staff_name').append("<option value='" + response['staff_id'][i] + "' "+selected+">" + response['staff_name'][i] + "</option>");
        //             }
        //         }
        //     });
        // }
    </script>

 <?php 
}
?>
   
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Insurance Register </li>
    </ol>
    <a href="edit_insurance_register">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    </a>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
    <!--form start-->
    <form id = "insurance_register" name="insurance_register" action="" method="post" enctype="multipart/form-data"> 
        <input type="hidden" name="branch_id_session" id="branch_id_session" class="form-control" value="<?php if(isset($sbranch_id)) echo $sbranch_id; ?>">
        <input type="hidden" class="form-control" value="<?php if(isset($ins_reg_id)) echo $ins_reg_id; ?>" id="id" name="id" aria-describedby="id" placeholder="Enter id">
        <input type="hidden" class="form-control" value="<?php if(isset($company_id)) echo $company_id; ?>" id="company_id_upd" name="company_id_upd" aria-describedby="id" placeholder="Enter id">
        <input type="hidden" class="form-control" value="<?php if(isset($insurance_id)) echo $insurance_id; ?>" id="insurance_id_upd" name="insurance_id_upd" aria-describedby="id" placeholder="Enter id">
        <input type="hidden" class="form-control" value="<?php if(isset($policy_company)) echo $policy_company; ?>" id="policy_company_upd" name="policy_company_upd" >
        <input type="hidden" class="form-control" value="<?php if(isset($dept_id)) echo $dept_id; ?>"  id="dept_id_upd" name="dept_id_upd" aria-describedby="id" placeholder="Enter id">
        <input type="hidden" class="form-control" value="<?php if(isset($freq_id)) echo $freq_id; ?>"  id="freq_id_upd" name="freq_id_upd" aria-describedby="id" placeholder="Enter id">

    <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <!-- <div class="card-title">General Info</div> -->
                    </div>
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-md-12 "> 
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Company Name</label>
                                            <?php if($sbranch_id == 'Overall'){ ?>
                                                <select tabindex="1" type="text" class="form-control" id="company_id" name="company_id">
                                                    <option value="">Select Company Name</option>   
                                                        <?php if (sizeof($companyName)>0) { 
                                                        for($j=0;$j<count($companyName);$j++) { ?>
                                                        <option <?php if(isset($sCompanyBranchDetailEdit['company_id'])) { if($companyName[$j]['company_id'] == $sCompanyBranchDetailEdit['company_id'])  echo 'selected'; }  ?> value="<?php echo $companyName[$j]['company_id']; ?>">
                                                        <?php echo $companyName[$j]['company_name'];?></option>
                                                        <?php }} ?>  
                                                </select>  
                                            <?php } else if($sbranch_id != 'Overall'){ ?>
                                                <select disabled tabindex="1" type="text" class="form-control" id="company_id" name="company_id" >
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

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Designation</label>
                                            <select tabindex="4" type="text" class="form-control" id="designation" name="designation" >
                                                    <option value="">Select Designation</option>   
                                            </select>
                                        </div>
                                    </div>

                                    <!-- <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Staff Name</label>
                                            <select id="staff_name" name="staff_name" class="form-control" tabindex="5">
                                                <option value="">Select Staff Name</option>
                                            </select>   
                                        </div>
                                    </div> -->

                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Insurance Name</label>
                                            <select tabindex="6" type="text" class="form-control" name="ins_name" id="ins_name">
                                                <option value="" disabled selected>Select Insurance Name</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-1 col-lg-1 col-md-4 col-sm-4 col-12" style="margin-top: 20px">
                                        <div class="form-group">
                                            <button type="button"  tabindex="7" class="btn btn-primary" id="add_insuranceDetails" name="add_insuranceDetails"  style="padding: 5px 30px;" >
                                                <span class="icon-add"></span>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label for="policy_company">Policy Company</label>
                                            <select tabindex="6" type="text" class="form-control" name="policy_company" id="policy_company">
                                                <option value="" disabled selected>Select Policy Company</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-1 col-lg-1 col-md-4 col-sm-4 col-12" style="margin-top: 20px">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary" id="add_policy_company" name="add_policy_company" data-toggle="modal" data-target=".addPolicyCompany" style="padding: 5px 30px;"><span class="icon-add"></span></button>
                                        </div>
                                    </div>

                                    <!-- <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Policy Company</label>
                                            <input tabindex="8" type="text" class="form-control" name="policy_company" id="policy_company" placeholder="Enter Policy Company" value="<?php #if(isset($policy_company)) echo $policy_company; ?>">
                                        </div>
                                    </div> -->

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Policy Number</label>
                                            <input tabindex="9" type="text" class="form-control" name="policy_number" id="policy_number" placeholder="Enter Policy Number" onkeydown="return /^[0-9\W_]+$/.test(event.key) || event.key === 'Backspace'" value="<?php if(isset($policy_number)) echo $policy_number; ?>">
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Policy Upload</label>
                                            <input tabindex="10" type="file" class="form-control" name="policy_upload" id="policy_upload">
                                            <?php if(isset($policy_upload)){ ?>
                                            <a href='uploads/insurance_policy/<?php if(isset($policy_upload)) echo $policy_upload; ?>' download><li><?php if(isset($policy_upload)) echo $policy_upload; ?></li></a>
                                            <?php } ?>
                                            <input type="hidden" class="form-control" name="policy_upload_upd" id="policy_upload_upd" value="<?php if(isset($policy_upload)) echo $policy_upload; ?>">
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Responsibile Department</label>
                                            <select tabindex="11" type="text" class="form-control" name="dept" id="dept">
                                                <option value="" disabled selected>Select Department Name</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Frequency</label>
                                            <select tabindex="12" type="text" class="form-control frequency" name="frequency" id="frequency">
                                                <option value="" >Select Frequency</option>
                                                <option value="1" <?php if(isset($freq_id )){if($freq_id == "1") echo "selected";} ?>>Half Yearly</option>
                                                <option value="2" <?php if(isset($freq_id )){if($freq_id == "2") echo "selected"; }?>>Yearly</option>  
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 mt-4" >
										<div class="form-group">
                                            <input disabled type="checkbox" tabindex="13" name="frequency_applicable" id="frequency_applicable" value="frequency_applicable" <?php if($idupd > 0){ if($frequency_applicable== 'frequency_applicable'){ echo'checked'; }} ?>> &nbsp;&nbsp; <label for="frequency_applicable">Is it applicable for next 6 months</label>
										</div>
									</div>

                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Calendar</label>
                                            <select tabindex="14" type="text" class="form-control calendar" id="calendar" name="calendar" >
                                                <option value=''>Select Calendar</option>
                                                <option <?php if(isset($calendar)) { if('Yes' == $calendar) echo 'selected';  ?> value="<?php echo 'Yes' ?>">
                                                <?php echo 'Yes'; } else { ?> <option value="Yes">Yes</option> <?php } ?></option>
                                                <option <?php if(isset($calendar)) { if('No' == $calendar) echo 'selected';  ?> value="<?php echo 'No' ?>">
                                                <?php echo 'No'; } else { ?> <option value="No">No</option> <?php } ?></option> 
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="from_date">Start Date & End Date</label>
                                            <div class="form-inline">
                                                <input readonly type="date" tabindex = "15" name="from_date" id="from_date" placeholder="From" class="form-control"  value="<?php if (isset($from_date)) echo $from_date; ?>">&nbsp;&nbsp;
                                                <span>To</span>&nbsp;&nbsp;<input readonly type="date" tabindex = "16" name="to_date" id="to_date" placeholder="To" class="form-control"  value="<?php if (isset($to_date)) echo $to_date; ?>">
                                            </div>
                                        </div>
                                    </div>
                                                                        
                                </div>  
                            </div>
                            
                            <div class="col-md-12">
                                <div class="text-right">
                                    <button type="submit" name="submitInsurance_register" id="submitInsurance_register" class="btn btn-primary" value="Submit" tabindex="17">Submit</button>
                                    <button type="reset" class="btn btn-outline-secondary" tabindex="18" id='reset'>Cancel</button>
                                </div>
                                <br><br>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </form> 
        </div>   

        <!-- Add Insurance Modal -->
        <div class="modal fade add_insuranceModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="background-color: white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myLargeModalLabel">Add Insurance</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="DropDownInsurance()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- alert messages -->
                        <div id="insuranceInsertNotOk" class="unsuccessalert">Insurance Already Exists, Please Enter a Different Name!
                        <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                        </div>

                        <div id="insuranceInsertOk" class="successalert">Insurance Added Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                        </div>

                        <div id="insuranceUpdateOk" class="successalert">Insurance Updated Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                        </div>

                        <div id="insuranceDeleteNotOk" class="unsuccessalert">You Don't Have Rights To Delete This Insurance!
                        <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                        </div>

                        <div id="insuranceDeleteOk" class="successalert">Insurance Has been Inactivated!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12"></div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label class="label">Enter Insurance Name</label>
                                    <input type="hidden" name="insurance_id" id="insurance_id">
                                    <input type="text" name="insurance_name" id="insurance_name" class="form-control" placeholder="Enter Insurance">
                                    <span class="text-danger" tabindex="1" id="insurancenameCheck">Enter Insurance</span>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-4 col-12">
                                    <label class="label" style="visibility: hidden;">Insurance</label>
                                <button type="button" tabindex="2" name="submiInsurancetBtn" id="submiInsurancetBtn" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        <div id="updatedinsuranceTable"> 
                            <table class="table custom-table" id="insuranceTable1"> 
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Insurance</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="DropDownInsurance()">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Course Policy Company Modal -->
<div class="modal fade addPolicyCompany" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color: white">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Add Policy Company</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="resetPolicyCompany();DropDownPolicyCompany();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- alert messages -->
                <div id="policyInsertNotOk" class="unsuccessalert">Policy Company Already Exists, Please Enter a Different Name!
                <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <div id="policyInsertOk" class="successalert">Policy Company Added Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <div id="policyUpdateOk" class="successalert">Policy Company Updated Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <div id="policyDeleteNotOk" class="unsuccessalert">Process Failed!
                <span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <div id="policyDeleteOk" class="unsuccessalert">Policy Company Has been Inactivated!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                </div>

                <br />
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12"></div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label class="label">Enter Policy Company</label>
                            <input type="hidden" name="policy_com_id" id="policy_com_id">
                            <input type="text" name="policy_com" id="policy_com" class="form-control" placeholder="Enter Policy Company">
                            <span class="text-danger" id="companynameCheck" style="display: none;">Enter Policy Company</span>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-4 col-12">
                            <label class="label" style="visibility: hidden;">Policy</label>
                        <button type="button" name="submitPolicyCompanyModal" id="submitPolicyCompanyModal" class="btn btn-primary">Submit</button>
                    </div>
                </div>

                <div id="PolicyCompanyDiv"> 
                    <table class="table custom-table" id="policyTable"> 
                        <thead>
                            <tr>
                                <th>S. No</th>
                                <th>Policy Company</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td class="col-md-2 col-xl-2"></td>
                                    <td></td>
                                    <td>
                                        <a id="edit_policy_com" value=""><span class="icon-border_color"></span></a> &nbsp
                                        <a id="delete_policy_com" value=""><span class='icon-trash-2'></span></a>
                                    </td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="resetPolicyCompany();DropDownPolicyCompany();">Close</button>
            </div>

        </div>
    </div>
</div>


<script>
	setTimeout(function() {
		$('.alert').fadeOut('slow');
	}, 2000);
</script>