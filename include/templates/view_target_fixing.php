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
$goalYear = $userObj->getGoalYear($mysqli);

if(isset($_GET['view']))
{
    $viewId=$_GET['view'];
}

if($viewId>0)
{
    $getTargetFixing = $userObj->getTargetFixing($mysqli,$viewId); 
    
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
        <li class="breadcrumb-item">AS - View Target Fixing</li>
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
                                    <select disabled tabindex="4" type="text" class="form-control" id="staff_name" name="staff_name" >
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
                                    <label for="disabledInput">No. of Months</label>
                                    <input readonly type="number" tabindex = "8" name="no_of_months" id="no_of_months" class="form-control" value="<?php if (isset($no_of_months)) echo $no_of_months; ?>">
                                </div>
                            </div>
                          
                        </div>

                    <br><br>
                    </div>
                </div>

                <div id="goadSettingDetailsAppend"></div>

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
                                                <td><input readonly type="number" class="form-control" value="<?php echo $target[$o]; ?>" name="target[]" id="target" ></td>
                                                <td>
                                                    <input readonly type="text" class="form-control" name="new_assertion[]" id="new_assertion" value="<?php echo $new_assertion[$o]; ?>" >
                                                </td>
                                                <td>
                                                    <input readonly type="number" class="form-control" name="new_target[]" id="new_target" value="<?php echo $new_target[$o]; ?>" >
                                                </td>
                                                <td>
                                                    <input readonly type="text" class="form-control" name="applicability[]" id="applicability" value="<?php echo $applicability[$o]; ?>" >
                                                </td>
                                                <td>
                                                    <input readonly type="text" class="form-control" name="deleted_date[]" id="deleted_date" value="<?php echo $deleted_date[$o]; ?>" >
                                                </td>
                                                <td>
                                                    <textarea readonly id="deleted_remarks" name="deleted_remarks[]" class="form-control" rows="2" cols="40" ><?php echo $deleted_remarks[$o]; ?></textarea>
                                                </td>
                                            </tr>
                                        </tbody>
                                    <?php $sno = $sno + 1; }
                                } ?>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>     
        </div>
    </form>
</div>

