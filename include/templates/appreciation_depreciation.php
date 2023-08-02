<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
} 
if(isset($_SESSION["staffid"])){
    $staffid = $_SESSION["staffid"];
} 
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
    $sCompanyBranchDetail = $userObj->getsCompanyBranchDetail($mysqli, $sbranch_id);
    $audit_area_list1 = $userObj->getAuditAreaTable1($mysqli, $sbranch_id);
}
$companyName = $userObj->getCompanyName($mysqli);
$goalYear = $userObj->getGoalYear($mysqli);
$midtermReview = $userObj->getmidtermReview($mysqli);

$id=0;
$idupd=0;
if(isset($_POST['submitAppDep']) && $_POST['submitAppDep'] != '')
{
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	    
        $updateAppDep = $userObj->updateAppDep($mysqli,$id,$userid);   
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_appreciation_depreciation&msc=2';</script> 
    <?php }
    else {   
        $addAppDep = $userObj->addAppDep($mysqli, $userid);   
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_appreciation_depreciation&msc=1';</script>
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
	$deleteAuditAreaCreation = $userObj->deleteAppDep($mysqli,$del, $userid); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_appreciation_depreciation&msc=3';</script>
    <?php	
}

if(isset($_GET['upd']))
{
$idupd=$_GET['upd'];
}

if($idupd>0)
{
	$getAppDep = $userObj->getAppDep($mysqli,$idupd); 
	
	if (sizeof($getAppDep)>0) {
        for($i=0;$i<sizeof($getAppDep);$i++)  {

            $appreciation_depreciation_id                  = $getAppDep['appreciation_depreciation_id']; 
            $review                                        = $getAppDep['review']; 
            $company_id                                    = $getAppDep['company_id']; 
            $department                                    = $getAppDep['department']; 
            $designation                                   = $getAppDep['designation']; 
            $emp_id                                        = $getAppDep['emp_id']; 
            $year_id                                       = $getAppDep['year_id']; 
            $month                                         = $getAppDep['month']; 
            $overall_performance                           = $getAppDep['overall_performance']; 
            $not_done                                      = $getAppDep['not_done']; 
            $carry_forward                                 = $getAppDep['carry_forward']; 
            $strength                                      = $getAppDep['strength']; 
            $weakness                                      = $getAppDep['weakness']; 
            $need_for_improvement                          = $getAppDep['need_for_improvement']; 
            $overall_rating                                = $getAppDep['overall_rating']; 
            $update_login_id                                = $getAppDep['update_login_id']; 

            $appreciation_depreciation_ref_id              = $getAppDep['appreciation_depreciation_ref_id']; 
            $daily_performance_ref_id                      = $getAppDep['daily_performance_ref_id']; 
            $assertion                                     = $getAppDep['assertion']; 
            $target                                        = $getAppDep['target']; 
            $achievement                                   = $getAppDep['achievement']; 
            $employee_rating                               = $getAppDep['employee_rating']; 

            $num_padded = sprintf("%02d", $month);
            $yearmonth                                     = $year_id.'-'.$num_padded;
	    }
    }

    $sCompanyBranchDetailEdit = $userObj->getsBranchBasedCompanyName($mysqli, $company_id);
    ?>

    <input type="hidden" id="company_nameEdit" name="company_nameEdit" value="<?php print_r($company_id); ?>" >
    <input type="hidden" id="departmentEdit" name="departmentEdit" value="<?php print_r($department); ?>" >
    <input type="hidden" id="designationEdit" name="designationEdit" value="<?php print_r($designation); ?>" >
    <input type="hidden" id="empEdit" name="empEdit" value="<?php print_r($emp_id); ?>" >
    
    <script>
        window.onload=editDepartment;
        function editDepartment(){  

            var company_id = $('#company_nameEdit').val();
            var department_upd = $('#departmentEdit').val();
            $.ajax({
                url: 'R&RFile/ajaxGetCompanyBasedDepartment.php',
                type: 'post',
                data: { "company_id":company_id },
                dataType: 'json',
                success:function(response){ 

                $('#department').empty();
                $('#department').prepend("<option value=''>" + 'Select Department' + "</option>");
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
                url: 'R&RFile/ajaxR&RDesignationDetails.php',
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
                
                    $('#staff_id').empty();
                    $('#staff_id').prepend("<option value=''>" + 'Select Staff Name' + "</option>");
                    var i = 0;
                    for (i = 0; i <= response.staff_id.length - 1; i++) { 
                        var selected = "";
                        if(emp_upd == response['staff_id'][i]){
                            selected = "selected";
                        }
                        $('#staff_id').append("<option value='" + response['staff_id'][i] + "' "+selected+" >" + response['staff_name'][i] + "</option>");
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
        <li class="breadcrumb-item">AS - Appreciation Vs Depreciation</li>
    </ol>

    <a href="edit_appreciation_depreciation">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
   </a>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
<!--------form start-->
    <form id = "appreciation_depreciation" name="appreciation_depreciation" action="" method="post" enctype="multipart/form-data"> 
        <input type="hidden" class="form-control" value="<?php if(isset($staffid)) echo $staffid; ?>"  id="staffid" name="staffid" >
        <input type="hidden" class="form-control" value="<?php if(isset($idupd)) echo $idupd; ?>"  id="id" name="id" >
        <input type="hidden" class="form-control" value="<?php if(isset($appreciation_depreciation_id)) echo $appreciation_depreciation_id ?>"  id="appreciation_depreciation_id" name="appreciation_depreciation_id" >
 		<!-- Row start -->
         <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
					<div class="card-header">
					</div>
                    <div class="card-body">

                    	 <div class="row midtermDiv">
                           <div class="col-md-12 "> 
                              <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">   
                                        <label for="disabledInput">Company</label>   
                                        <?php if($sbranch_id == 'Overall'){ ?>
                                            <select tabindex="1" type="text" class="form-control" id="company_name" name="company_name" >
                                                <option value="">Select Company</option>   
                                                    <?php if (sizeof($companyName)>0) { 
                                                    for($j=0;$j<count($companyName);$j++) { ?>
                                                    <option <?php if(isset($sCompanyBranchDetailEdit['company_id'])) { if($companyName[$j]['company_id'] == $sCompanyBranchDetailEdit['company_id'])  echo 'selected'; }  ?> value="<?php echo $companyName[$j]['company_id']; ?>">
                                                    <?php echo $companyName[$j]['company_name'];?></option>
                                                    <?php }} ?>  
                                            </select>  
                                        <?php } else if($sbranch_id != 'Overall'){ ?>
                                            <input type="hidden" class="form-control" id="company_name" name="company_name" value="<?php echo $sCompanyBranchDetail['company_id']; ?>" >
                                            <select disabled tabindex="1" type="text" class="form-control" id="company" name="company"  >
                                                <option value="<?php echo $sCompanyBranchDetail['company_id']; ?>"><?php echo $sCompanyBranchDetail['company_name']; ?></option> 
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
                                        <select tabindex="4" type="text" class="form-control" id="staff_id" name="staff_id" >
                                            <option value="">Select Staff</option>  
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="disabledInput">Month</label>
                                        <input tabindex="4" type="month" class="form-control" id="month" name="month" value="<?php if(isset($yearmonth)) echo $yearmonth; ?>">
                                    </div>
                                </div>
                                
                                <?php if($idupd<=0){ ?>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12" style="margin-top: 19px;">
                                        <div class="form-group">
                                            <button tabindex="3" type="button" class="btn btn-primary" id="executeTargetFixingDetails" name="executeTargetFixingDetails" data-toggle="modal" style="padding: 5px 35px;">Execute</button>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12"></div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12"></div>
                            
                            </div>
                                
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div id="dailyPerformanceDetailsAppend"></div>
                                </div>
                            </div>

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
                                                    <th>Achievement</th>
                                                    <th>Employee Rating</th>
                                                </tr>
                                                <?php
                                                $sno = 1;   
                                                if(isset($appreciation_depreciation_ref_id)){ 
                                                    for($o=0; $o<=sizeof($appreciation_depreciation_ref_id)-1; $o++){ 
                                                        ?>
                                                        <tbody>
                                                            <tr>
                                                                <td><?php echo $sno; ?></td>
                                                                <td style="display: none;" ><input type="text" readonly class="form-control" value="<?php echo $appreciation_depreciation_ref_id[$o]; ?>" name="appreciation_depreciation_ref_id[]" id="appreciation_depreciation_ref_id" ></td>
                                                                <td style="display: none;" ><input type="text" readonly class="form-control" value="<?php echo $daily_performance_ref_id[$o]; ?>" name="daily_performance_ref_id[]" id="daily_performance_ref_id" ></td>
                                                                <td><input readonly type="text" class="form-control" value="<?php echo $assertion[$o]; ?>" name="assertion[]" id="assertion" ></td>
                                                                <td><input readonly type="number" class="form-control" value="<?php echo $target[$o]; ?>" name="target[]" id="target" ></td>
                                                                <td><input type="text" class="form-control" name="achievement[]" id="achievement" value="<?php echo $achievement[$o]; ?>" placeholder="Enter new achievement" ></td>
                                                                <td>
                                                                    <select tabindex="4" type="text" class="form-control" id="employee_rating" name="employee_rating[]" >
                                                                        <option value="">Select Employee Rating</option>
                                                                        <option value="1" <?php if(isset($employee_rating )){if($employee_rating[$o] == "1") echo "selected";} ?>>1</option>
                                                                        <option value="2" <?php if(isset($employee_rating )){if($employee_rating[$o] == "2") echo "selected";} ?>>2</option>
                                                                        <option value="3" <?php if(isset($employee_rating )){if($employee_rating[$o] == "3") echo "selected";} ?>>3</option>
                                                                        <option value="4" <?php if(isset($employee_rating )){if($employee_rating[$o] == "4") echo "selected";} ?>>4</option>
                                                                        <option value="5" <?php if(isset($employee_rating )){if($employee_rating[$o] == "5") echo "selected";} ?>>5</option>
                                                                    </select>   
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    <?php $sno = $sno + 1; } ?>

                                                        <tbody>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td><input readonly type="text" class="form-control" value="<?php echo "Total Satisfied - ".$overall_performance; ?>" name="overall_performance" id="overall_performance" placeholder="Enter new assertion" ></td>
                                                                <td>
                                                                    <input readonly type="text" class="form-control" value="<?php echo "Total Not Done - ".$not_done; ?>" name="not_done" id="not_done" >
                                                                    <input readonly type="text" class="form-control" value="<?php echo "Total Carry Forward - ".$carry_forward; ?>" name="carry_forward" id="carry_forward"  >
                                                                </td> 
                                                            </tr>
                                                        </tbody>
                                                <?php } ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    </div>
                    
                    <div class="col-md-12 reporting_person_view" <?php if(isset($update_login_id) && $update_login_id == ''){ echo 'style="display: none;"' ;} ?> > 

                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="disabledInput">Strength</label>
                                    <textarea id="strength" name="strength" class="form-control" rows="4" cols="40" ><?php if (isset($strength)) echo $strength; ?></textarea>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="disabledInput">Weakness</label>
                                    <textarea id="weakness" name="weakness" class="form-control" rows="4" cols="40" ><?php if (isset($weakness)) echo $weakness; ?></textarea>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="disabledInput">Need For Improvement</label>
                                    <textarea id="need_for_improvement" name="need_for_improvement" class="form-control" rows="4" cols="40" ><?php if (isset($need_for_improvement)) echo $need_for_improvement; ?></textarea>
                                </div>
                            </div>    
                        </div>

                        <div class="row">

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="inputReadOnly">Overall Rating</label>
                                    <select tabindex="4" type="text" class="form-control" id="overall_rating" name="overall_rating" >
                                        <option value="">Select Overall Rating</option>  
                                        <option value="1" <?php if(isset($overall_rating )) { if($overall_rating == "1") echo "selected"; } ?>>Poor Performance</option>
                                        <option value="2" <?php if(isset($overall_rating )) { if($overall_rating == "2") echo "selected"; } ?>>Below Expectation</option>
                                        <option value="3" <?php if(isset($overall_rating )) { if($overall_rating == "3") echo "selected"; } ?>>More Expectation</option>
                                        <option value="4" <?php if(isset($overall_rating )) { if($overall_rating == "4") echo "selected"; } ?>>Exceeding Expectation</option>
                                        <option value="5" <?php if(isset($overall_rating )) { if($overall_rating == "5") echo "selected"; } ?>>Far Exceeding Expectation</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="inputReadOnly">Memo If Required</label> <br>
                                    <a href="memo"> <button disabled type="button" name="memoBtn" id="memoBtn" class="btn btn-outline-secondary" value="Submit" tabindex="10">Go to memo</button></a>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                </div>
                <div class="col-md-12">
                    <br><br>
                    <div class="text-right">
                        <button type="submit" name="submitAppDep" id="submitAppDep" class="btn btn-primary" value="Submit" tabindex="10">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>



