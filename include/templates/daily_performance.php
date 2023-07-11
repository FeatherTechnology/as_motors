<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
} 
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
    // $sCompanyBranchDetail = $userObj->getsCompanyBranchDetail($mysqli, $sbranch_id);
  
  
}
$get_company = $userObj->get_daily_performance($mysqli);
$get_dept = $userObj->get_dept_performance($mysqli);
$get_role = $userObj->get_role_performance($mysqli);
$CompanyroleDetail = $userObj->getsroleDetail($mysqli, $userid);
for($j=0;$j<count($CompanyroleDetail);$j++) {
    $logrole = $CompanyroleDetail['role'];
    $user_company_id         = $CompanyroleDetail['company_id'];
    $user_company_name         = $CompanyroleDetail['company_name'];
}
$id=0;
$idupd=0;
 if(isset($_POST['submit_audit_checklist']) && $_POST['submit_audit_checklist'] != '')
 {
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
        $audit_area_id = $_POST['daily_performance_id'];
        $updateAuditAreaCreationmaster = $userObj->adddailyperformance($mysqli,$id,$audit_area_id);  
    ?>
   <script>location.href='<?php echo $HOSTPATH; ?>edit_daily_performance&msc=2';</script> 
    <?php	}
    else{   
        $addAuditAreaCreation = $userObj->adddailyperformance($mysqli,$userid);   
        ?>
     <script>location.href='<?php echo $HOSTPATH; ?>edit_daily_performance&msc=1';</script>
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
	$deleteAuditAreaCreation = $userObj->deletedailyperformance($mysqli,$del); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_daily_performance&msc=3';</script>
<?php	
}

if(isset($_GET['upd']))
{
$idupd=$_GET['upd'];
}

if($idupd>0)
{
	$getAuditAreaChecklist = $userObj->getdailyperformance($mysqli,$idupd); 
    // print_r($getAuditAreaChecklist);
	if (sizeof($getAuditAreaChecklist)>0) {
        for($i=0;$i<sizeof($getAuditAreaChecklist);$i++)  {
            $header_table              = $getAuditAreaChecklist['departments'];
            $ref_table                 = $getAuditAreaChecklist['designations'];
          
            // $audit_area_name                  = $getAuditAreaChecklist['area_name']; 
			// $dept                	 = $getAuditAreaChecklist['department'];
            // $dept                  = $getAuditAreaChecklist['department'];
            // $auditor                	     = $getAuditAreaChecklist['auditor'];
            // $auditor_name                	     = $getAuditAreaChecklist['auditor_name'];
			// $auditee    	                = $getAuditAreaChecklist['auditee'];
			// $auditee_name    	                = $getAuditAreaChecklist['auditee_name'];
		}
	}
 
    for($i=0;$i<sizeof($header_table);$i++)  {
       
        $daily_performance_id                  = $header_table[$i]['daily_performance_id'];  
        $company_id                  = $header_table[$i]['company_id']; 
        $company_name                  = $header_table[$i]['company_name']; 
        $department_id                  = $header_table[$i]['department_id']; 
        $department_name                  = $header_table[$i]['department_name']; 
        $role_id                  = $header_table[$i]['role_id']; 
        $designation_name                  = $header_table[$i]['designation_name']; 
        $emp_id                  = $header_table[$i]['emp_id']; 
        $month                  = $header_table[$i]['month']; 
        $designation_name                  = $header_table[$i]['designation_name']; 
    }
     
   
}
?>
   
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Daily Performance</li>
    </ol>

    <a href="edit_daily_performance">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
   </a>
</div>
				<!-- Page header end -->

				<!-- Main container start -->
<div class="main-container">
<!--------form start-->
<form id = "audit_checklist" name="audit_checklist" action="" method="post" enctype="multipart/form-data"> 
<input type="hidden" class="form-control" value="<?php if(isset($idupd)) echo $idupd; ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id">
<input type="hidden" class="form-control" value="<?php if(isset($daily_performance_id)) echo $daily_performance_id ?>"  id="audit_area_id" name="daily_performance_id" aria-describedby="id" placeholder="Enter id">
<input type="hidden" class="form-control" value="<?php if(isset($company_id)) echo $company_id; ?>"  id="company_id_upd" name="company_id_upd">
<input type="hidden" class="form-control" value="<?php if(isset($company_name)) echo $company_name; ?>"  id="company_name_upd" name="company_name_upd">
      <input type="hidden" class="form-control" value="<?php if(isset($department_id)) echo $department_id; ?>"  id="dept_id_upd" name="dept_id_upd">
      <input type="hidden" class="form-control" value="<?php if(isset($role_id)) echo $role_id; ?>"  id="role_id_up" name="role_id_up">
      <input type="hidden" class="form-control" value="<?php if(isset($emp_id)) echo $emp_id; ?>"  id="emp_idup" name="emp_idup">
      <input type="hidden" class="form-control" value="<?php if(isset($logrole)) echo $logrole; ?>"  id="logrole" name="logrole">
      <input type="hidden" class="form-control" value="<?php if(isset($user_company_id)) echo $user_company_id; ?>"  id="logcomp" name="logcomp">
      <input type="hidden" class="form-control" value="<?php if(isset($user_company_name)) echo $user_company_name; ?>"  id="logcname" name="logcname">
        
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
                           <div class="col-md-12 "> 
                              <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="inputReadOnly"id="audit_err" >Company Name</label>
                                                <select tabindex="1" type="text" class="form-control" name="company_id" id="company">
                                                    <option value="">Select Company</option>
                                                   
                                                   <?php if (sizeof($get_company)>0) { 
                                                    for($j=0;$j<count($get_company);$j++) { #print_r($get_company); ?>

                                                    <option <?php if(isset($company_id) and $company_id == $get_company[$j]['company_id']){ echo "selected";  } ?>
                                                    value="<?php echo $get_company[$j]['company_id']; ?>">


                                                    <?php echo $get_company[$j]['company_name'];?></option>
                                                    <?php } } ?>


                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="inputReadOnly"id="audit_err" >Department</label>
                                                <select tabindex="2" type="text" class="form-control" name="department_id" id="department_id">
                                                   
                                                
                                                </select>
                                            
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="inputReadOnly"id="audit_err" >Designation</label>
                                               
                                                <select tabindex="3" type="text" class="form-control" name="designation_id" id="designation_id">
                                                   
                                                    </select>
                                           
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="inputReadOnly"id="audit_err" >Emp Name</label>
                                                
                                                <select tabindex="4" type="text" class="form-control" name="staff_id" id="staff_id">
                                                    
                                                </select>
                                            
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="inputReadOnly"id="audit_err" >Month</label>

                                                <?php if($idupd == '0'){ ?>
                                                    
                                                    <input readonly tabindex="5" type="text" class="form-control" id="month" name="month" value="<?php $currentMonth = date("F"); echo $currentMonth; ?>">
                                                    <input readonly tabindex="5" type="hidden" class="form-control" id="nmonth" name="nmonth" value="<?php $currentMonth = date("m"); echo $currentMonth;  ?>" >
                                                    <input readonly tabindex="5" type="hidden" class="form-control" id="ffixedid" name="ffixedid" value="" > 
                                                    <input readonly tabindex="5" type="hidden" class="form-control" id="ffixedrefid" name="ffixedrefid" value="" >
                                                    <input readonly tabindex="5" type="hidden" class="form-control" id="" name="ffixedid" value="" > 
                                                    <input readonly tabindex="5" type="hidden" class="form-control" id="_target" name="ffixedrefid" value="" >
                                                    <input readonly tabindex="5" type="hidden" class="form-control" id="tday" name="tday" value="<?php   $currentMonth = date("F"); if($currentMonth == 'February'){ echo "22";}else{echo "26";}  ?>" >
                                               
                                                <?php } else { ?> 

                                                    <input readonly tabindex="5" type="text" class="form-control" id="month" name="month" value="<?php if($month == '0'){  }else{$months = date("F", mktime(0, 0, 0, $month, 1));   echo $months; }  ?>">
                                                    <input tabindex="5" type="hidden" class="form-control" id="nmonth" name="nmonth" value="<?php echo $month;  ?>" >
                                                    <input tabindex="5" type="hidden" class="form-control" id="tday" name="tday" value="<?php  $months = date("F", mktime(0, 0, 0, $month, 1)); if($months == 'February'){ echo "22";}else{echo "26";}  ?>" >
                                               
                                                <?php } ?>
                                                
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mt-3">
                                            <div class="form-group">
                                            <input  type="button" class="btn btn-primary" id="execute" name="execute[]" value="Execute" tabindex="6"></input> 
                                            </div>
                                        </div>

                                        

                        <!-- <div class="row" > -->
                            <div class="col-md-12" >
                                <table id="moduleTable" class="table custom-table" >
                                    <thead>
                                        <tr>
                                            <th>Assertion</th>
                                            <th>Target</th>
                                            <th>System Date</th>
                                            <th>Work Status</th>
                                            <th>Status</th>
                                            
                                        </tr>
                                    </thead>
                                    <?php if($idupd<=0){ ?>
                                        <tbody>
                                            <tr>
                                               
                                                <td>
                                                    <input tabindex="7" type="text" class="form-control" id="assertion" name="assertion[]"  readonly>
                                                    </input> 
                                                </td>
                                                <td >
                                                    <input tabindex="8" type="text" class="form-control" id="target" name="target[]" readonly>
                                                    </input> 
                                                </td>
                                                <td>
                                                    <input tabindex="9" type="date" class="form-control" id="sdate" name="sdate[]" value=""  readonly></input> 
                                                </td>
                                                <td>
                                                    <!-- <input  type="text" class="form-control" id="wstatus" name="wstatus[]" ></input>  -->
                                                    <select  class="form-control wstatus" id="wstatus" name="wstatus[]" tabindex="10">
                                                        <option value=" ">Select Work Status</option>
                                                        <option value="statisfied">Statisfied</option>
                                                        <option value="not_done">Not Done</option>
                                                        <option value="carry_forward">Carry Forward</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input  type="text" class="form-control" id="status" name="status[]" tabindex="11"></input> 
                                                </td>
                                                
                                                
                                            </tr>
                                        </tbody>
                                    <?php } if($idupd>0){
                                            if(isset($daily_performance_id)){ ?>
                                                <tbody>
                                                    
                                                <?php    for($i=0;$i<sizeof($ref_table);$i++)  {
                                                        $daily_performance_ref_id                  = $ref_table[$i]['daily_performance_ref_id']; 
                                                        $assertion                  = $ref_table[$i]['assertion']; 
                                                        $target                  = $ref_table[$i]['target'];  
                                                        $system_date            =$ref_table[$i]['system_date'];
                                                        $old_target                   = $ref_table[$i]['old_target'];
                                                        $target_fixing_id                   = $ref_table[$i]['target_fixing_id'];
                                                        $target_fixing_ref_id                   = $ref_table[$i]['target_fixing_ref_id'];
                                                        $status            =$ref_table[$i]['status'];
                                                ?>
                                                        <tr>
                                                            <td>
                                                            <input tabindex="7" type="text" class="form-control" id="assertion" name="assertion[]" value="<?php echo $assertion; ?>" readonly>
                                                            <input type='hidden' class='form-control' id='old_target' name='old_target[]' value="<?php echo $old_target; ?>" >
                                                            <input type='hidden' class='form-control' id='target_fixing_id' name='target_fixing_id[]' value="<?php echo $target_fixing_id; ?>">
                                                            <input type='hidden' class='form-control' id='target_fixing_ref_id' name='target_fixing_ref_id[]' value="<?php echo $target_fixing_ref_id; ?>">
                                                            <input  type="hidden" class="form-control" id="sub" name="sub[]" value="<?php echo  $daily_performance_ref_id; ?>">
                                                            
                                                            </td>
                                                            <td >
                                                                <input tabindex="8" type="text" class="form-control" id="target" name="target[]" value="<?php echo $target ?>" readonly>
                                                                </input> 
                                                            </td>
                                                            <td>
                                                                <input tabindex="9" type="date" class="form-control" id="sdate" name="sdate[]" value="<?php echo $system_date; ?>" readonly></input> 
                                                            </td>
                                                            <td>
                                                           
                                                                <select  class="form-control wstatus" id="wstatus" name="wstatus[]"  value="<?php echo $status ?>" tabindex="10">
                                                                    <?php if($status == 'statisfied') { ?>
                                                                        <option value="statisfied">Statisfied</option>
                                                                        <option value=" ">Select Work Status</option>
                                                                        <option value="not_done">Not Done</option>
                                                                        <option value="carry_forward">Carry Forward</option>
                                                                    <?php }else if($status == 'not_done'){ ?>
                                                                        <option value="not_done">Not Done</option>
                                                                        <option value=" ">Select Work Status</option>
                                                                        <option value="statisfied">Statisfied</option>
                                                                        <option value="carry_forward">Carry Forward</option>
                                                                    <?php }else if($status == 'carry_forward'){ ?>
                                                                        <option value="carry_forward">Carry Forward</option>
                                                                        <option value=" ">Select Work Status</option>
                                                                        <option value="statisfied">Statisfied</option>
                                                                        <option value="not_done">Not Done</option>
                                                                    <?php } ?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                    <?php if($status == 'statisfied') { ?>
                                                                        <input type="text" class="form-control" id="status" name="status[]" style="background-color: green;" tabindex="11">
                                                                        <?php }else if($status == 'not_done'){ ?>
                                                                            <input type="text" class="form-control" id="status" name="status[]" style="background-color: red;" tabindex="11">
                                                                        <?php }else if($status == 'carry_forward'){ ?>
                                                                        
                                                                            <input type="text" class="form-control" id="status" name="status[]" style="background-color: blue;" tabindex="11">
                                                                        <?php }else{ ?>
                                                                            <input type="text" class="form-control" id="status" name="status[]" tabindex="11">
                                                                        <?php } ?>
                                                            </td>
                                                            
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            <?php }
                                        } ?>
                                    </table>
                                </div>
                            <!-- </div> -->
                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="col-md-12">
                            <br><br>
                            <div class="text-right">
                                <!-- <button type="button" class="btn btn-outline-secondary" tabindex="15">Save</button> -->
                                <button type="submit" name="submit_audit_checklist" id="submit_audit_checklist" class="btn btn-primary" value="Submit" tabindex="12">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>



