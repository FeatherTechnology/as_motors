<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
} 
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
    $sCompanyBranchDetail = $userObj->getsCompanyBranchDetail($mysqli, $sbranch_id);
    $audit_area_list1 = $userObj->getAuditAreaTable1($mysqli, $sbranch_id);
}
$companyName = $userObj->getCompanyName($mysqli);
$goalYear = $userObj->getGoalYear($mysqli);

	$viewAppDep = $userObj->viewAppDep($mysqli); 
	if (sizeof($viewAppDep)>0) {
        for($i=0;$i<sizeof($viewAppDep);$i++)  {

            $appreciation_depreciation_id                  = $viewAppDep['appreciation_depreciation_id']; 
            $review                  = $viewAppDep['review']; 
            $company_id                  = $viewAppDep['company_id']; 
            $department                  = $viewAppDep['department']; 
            $designation                  = $viewAppDep['designation']; 
            $emp_id                  = $viewAppDep['emp_id']; 
            $year_id                  = $viewAppDep['year_id']; 
            $month                  = $viewAppDep['month']; 
            $overall_performance                  = $viewAppDep['overall_performance']; 
            $not_done                  = $viewAppDep['not_done']; 
            $carry_forward                  = $viewAppDep['carry_forward']; 
            $strength                  = $viewAppDep['strength']; 
            $weakness                  = $viewAppDep['weakness']; 
            $need_for_improvement                  = $viewAppDep['need_for_improvement']; 
            $overall_rating                  = $viewAppDep['overall_rating']; 

            $appreciation_depreciation_ref_id                  = $viewAppDep['appreciation_depreciation_ref_id']; 
            $daily_performance_ref_id                  = $viewAppDep['daily_performance_ref_id']; 
            $assertion                  = $viewAppDep['assertion']; 
            $target                  = $viewAppDep['target']; 
            $achievement                  = $viewAppDep['achievement']; 
            $employee_rating                  = $viewAppDep['employee_rating']; 
	    }
    }

    $sCompanyBranchDetailEdit = $userObj->getsCompanyBranchDetail($mysqli, $company_id);
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
                url: 'KRA&KPIFile/ajaxKra&KpiFetchDepartmentDetails.php',
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



?>
   
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Appreciation and Depreciatione - Midterm Review</li>
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
        <input type="hidden" class="form-control" value="<?php if(isset($idupd)) echo $idupd; ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id">
        <input type="hidden" class="form-control" value="<?php if(isset($appreciation_depreciation_id)) echo $appreciation_depreciation_id ?>"  id="appreciation_depreciation_id" name="appreciation_depreciation_id" aria-describedby="id" placeholder="Enter id">
 		<!-- Row start -->
         <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
					<div class="card-header">
					</div>
                    <div class="card-body">

                        <!-- <div class="form-group">
							<center><table>
								<tr>
									<td><input type="radio" checked name="review" id="midterm_review" value="midterm_review" <?php if(isset($review)) echo ($review=='midterm_review')?'checked':'' ?>></td>
									<td><label for="midterm_review">Midterm Review</label></td>
									<td><input type="radio" name="review" id="final_review" value="final_review" <?php if(isset($review)) echo ($review=='final_review')?'checked':'' ?> ></td>
									<td><label for="final_review">Final Review</label></td>
								</tr>
							</table></center>
						</div><hr> -->

                    	 <div class="row midtermDiv">
                           <div class="col-md-12 "> 
                              <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">   
                                        <label for="disabledInput">Company</label>   
                                        <?php if($sbranch_id == 'Overall'){ ?>
                                            <select disabled tabindex="1" type="text" class="form-control" id="company_name" name="company_name" >
                                                <option value="">Select Company</option>   
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
                                        <select disabled tabindex="3" type="text" class="form-control" id="department" name="department" >
                                            <option value="">Select Department</option>   
                                        </select>
                                    </div>
                                </div>
                
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="disabledInput">Designation</label>
                                        <select disabled tabindex="4" type="text" class="form-control" id="designation" name="designation" >
                                                <option value="">Select Designation</option>   
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="disabledInput">Staff Name</label>
                                        <select disabled tabindex="4" type="text" class="form-control" id="staff_id" name="staff_id" >
                                            <option value="">Select Staff</option>  
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="disabledInput">Year</label>
                                        <select disabled tabindex="4" type="text" class="form-control" id="goal_year" name="goal_year" >
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
                                        <label for="disabledInput">Month</label>
                                        <select disabled tabindex="4" type="text" class="form-control" id="month" name="month" >
                                            <option value="">Select Month</option>  
                                            <option value="1" <?php if(isset($month )){if($month == "1") echo "selected";} ?>>January</option>
                                            <option value="2" <?php if(isset($month )){if($month == "2") echo "selected";} ?>>February</option>
                                            <option value="3" <?php if(isset($month )){if($month == "3") echo "selected";} ?>>March</option>
                                            <option value="4" <?php if(isset($month )){if($month == "4") echo "selected";} ?>>April</option>
                                            <option value="5" <?php if(isset($month )){if($month == "5") echo "selected";} ?>>May</option>
                                            <option value="6" <?php if(isset($month )){if($month == "6") echo "selected";} ?>>June</option>
                                            <option value="7" <?php if(isset($month )){if($month == "7") echo "selected";} ?>>July</option>
                                            <option value="8" <?php if(isset($month )){if($month == "8") echo "selected";} ?>>August</option>
                                            <option value="9" <?php if(isset($month )){if($month == "9") echo "selected";} ?>>September</option>
                                            <option value="10" <?php if(isset($month )){if($month == "10") echo "selected";} ?>>October</option>
                                            <option value="11" <?php if(isset($month )){if($month == "11") echo "selected";} ?>>November</option>
                                            <option value="12" <?php if(isset($month )){if($month == "12") echo "selected";} ?>>December</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12"></div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12"></div>
                            
                            </div>
                                
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div id="dailyPerformanceDetailsAppend"></div>
                                </div>
                            </div>
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
                                                                <td><input readonly type="text" class="form-control" name="achievement[]" id="achievement" value="<?php echo $achievement[$o]; ?>" placeholder="Enter new achievement" ></td>
                                                                <td>
                                                                    <select readonly tabindex="4" type="text" class="form-control" id="employee_rating" name="employee_rating[]" >
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

                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="disabledInput">Strength</label>
                                        <textarea readonly id="strength" name="strength" class="form-control" rows="4" cols="40" ><?php if (isset($strength)) echo $strength; ?></textarea>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="disabledInput">Weakness</label>
                                        <textarea readonly id="weakness" name="weakness" class="form-control" rows="4" cols="40" ><?php if (isset($weakness)) echo $weakness; ?></textarea>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="disabledInput">Need For Improvement</label>
                                        <textarea readonly id="need_for_improvement" name="need_for_improvement" class="form-control" rows="4" cols="40" ><?php if (isset($need_for_improvement)) echo $need_for_improvement; ?></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    </div>
                    
                    <div class="col-md-12 midtermDiv2"> 
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="inputReadOnly"id="audit_err" >Overall Rating</label>
                                    <select disabled tabindex="4" type="text" class="form-control" id="overall_rating" name="overall_rating" >
                                        <option value="">Select Overall Rating</option>  
                                        <option value="1" <?php if(isset($month )) { if($month == "1") echo "selected"; } ?>>Poor Performance</option>
                                        <option value="2" <?php if(isset($month )) { if($month == "2") echo "selected"; } ?>>Below Expectation</option>
                                        <option value="3" <?php if(isset($month )) { if($month == "3") echo "selected"; } ?>>More Expectation</option>
                                        <option value="4" <?php if(isset($month )) { if($month == "4") echo "selected"; } ?>>Exceeding Expectation</option>
                                        <option value="5" <?php if(isset($month )) { if($month == "5") echo "selected"; } ?>>Far Exceeding Expectation</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>



