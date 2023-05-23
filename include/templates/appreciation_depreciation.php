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
// $dailyPerformanceMonth = $userObj->getDailyPerformanceMonth($mysqli);

$id=0;
$idupd=0;
 if(isset($_POST['submitAppDep']) && $_POST['submitAppDep'] != '')
 {
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
        $audit_area_id = $_POST['audit_area_id'];
        $updateAppDep = $userObj->updateAppDep($mysqli,$id,$audit_area_id);  
    ?>
   <script>location.href='<?php echo $HOSTPATH; ?>edit_appreciation_depreciatione&msc=2';</script> 
    <?php	}
    else{   
        $addAppDep = $userObj->addAppDep($mysqli);   
        ?>
     <script>location.href='<?php echo $HOSTPATH; ?>edit_appreciation_depreciatione&msc=1';</script>
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
	$deleteAuditAreaCreation = $userObj->deleteAppDep($mysqli,$del); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_appreciation_depreciatione&msc=3';</script>
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

            $audit_area_id                  = $getAppDep['area_id']; 
            $audit_area_name                  = $getAppDep['area_name']; 
			$dept                	 = $getAppDep['department'];
            $dept                  = $getAppDep['department'];
            $departid = explode(",", $dept);
            $department_name   = array();

            $dept_name                 = $department_name;
            $deptname = implode(', ', $dept_name);
            $auditor                	     = $getAppDep['auditor'];
            $auditor_name                	     = $getAppDep['auditor_name'];
			$auditee    	                = $getAppDep['auditee'];
			$auditee_name    	                = $getAppDep['auditee_name'];
		}
	}
}
?>
   
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Appreciation and Depreciatione</li>
    </ol>

    <a href="edit_appreciation_depreciatione">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
   </a>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
<!--------form start-->
    <form id = "audit_checklist" name="audit_checklist" action="" method="post" enctype="multipart/form-data"> 
        <input type="hidden" class="form-control" value="<?php if(isset($idupd)) echo $idupd; ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id">
        <input type="hidden" class="form-control" value="<?php if(isset($audit_area_id)) echo $audit_area_id ?>"  id="audit_area_id" name="audit_area_id" aria-describedby="id" placeholder="Enter id">
 		<!-- Row start -->
         <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
					<div class="card-header">
					</div>
                    <div class="card-body">

                        <div class="form-group">
							<center><table>
								<tr>
									<td><input type="radio" checked name="review" id="midterm_review" value="midterm_review"></td>
									<td><label for="midterm_review">Midterm Review</label></td>
									<td><input type="radio" name="review" id="final_review" value="final_review"></td>
									<td><label for="final_review">Final Review</label></td>
								</tr>
							</table></center>
						</div><hr>

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
                                            <option value="">Select Staff</option>  
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
                                        <label for="disabledInput">Month</label>
                                        <select tabindex="4" type="text" class="form-control" id="month" name="month" >
                                            <option value="">Select Month</option>  
                                            <option value="1">January</option>
                                            <option value="2">February</option>
                                            <option value="3">March</option>
                                            <option value="4">April</option>
                                            <option value="5">May</option>
                                            <option value="6">June</option>
                                            <option value="7">July</option>
                                            <option value="8">August</option>
                                            <option value="9">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
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

                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="disabledInput">Strength</label>
                                        <textarea id="strength" name="strength" class="form-control" rows="4" cols="40" ><?php if (isset($strength)) echo $strength[$o]; ?></textarea>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="disabledInput">Weakness</label>
                                        <textarea id="weakness" name="weakness" class="form-control" rows="4" cols="40" ><?php if (isset($weakness)) echo $weakness[$o]; ?></textarea>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="disabledInput">Need For Improvement</label>
                                        <textarea id="need_for_improvement" name="need_for_improvement" class="form-control" rows="4" cols="40" ><?php if (isset($need_for_improvement)) echo $need_for_improvement[$o]; ?></textarea>
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
                                    <select tabindex="4" type="text" class="form-control" id="overall_rating" name="overall_rating" >
                                            <option value="">Select Overall Rating</option>  
                                            <option value="1">Poor Performance</option>
                                            <option value="2">Below Expectation</option>
                                            <option value="3">More Expectation</option>
                                            <option value="4">Exceeding Expectation</option>
                                            <option value="5">Far Exceeding Expectation</option>
                                        </select>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="inputReadOnly"id="audit_err" >Memo If Required</label> <br>
                                    <a href="memo"> <button type="button" name="memoBtn" id="memoBtn" class="btn btn-outline-secondary" value="Submit" tabindex="10">Go to memo</button></a>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="inputReadOnly"id="audit_err" >Midterm Review</label> <br>
                                    <button type="button" name="memoBtn" id="memoBtn" class="btn btn-outline-secondary" value="Submit" tabindex="10">View</button>
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



