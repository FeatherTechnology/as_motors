<?php 
$id=0;
$employeecodelist=$userObj->getemployeecode($mysqli);
$companyName = $userObj->getcompanyName($mysqli);
$branchName = $userObj->getBranchName($mysqli);

$user_id        = '';
$first_name     = '';
$last_name      = '';
$full_name      = '';
$title          = '';
$user_name      = '';
$email_id       = '';
$password       = '';
$confirm_password = '';
$role           = '';

$administration_module = '';
$dashboard             = '';
$company_creation      = '';
$branch_creation       = '';
$holiday_creation      = '';
$manage_users          = '';
$master_module         = '';
$basic_sub_module      = '';
$responsibility_sub_module = '';
$audit_sub_module = '';
$others_sub_module = '';
$basic_creation = '';
$tag_creation = '';
$rr_creation = '';
$kra_category = '';
$krakpi_creation  = '';
$staff_creation = '';
$audit_area_creation  = '';
$audit_area_checklist    = '';
$audit_assign = '';
$audit_follow_up = '';
$report_template  = '';
$media_master  = '';
$asset_creation = '';
$insurance_register = '';
$service_indent   = '';
$asset_details    = '';
$rgp_creation      = '';
$promotional_activities    = '';
$work_force_module  = '';
$schedule_task_sub_module        = '';
$memo_sub_module      = '';
$campaign        = '';
$assign_work = '';
$daily_task_update = '';
$todo ='';
$assigned_work    = '';
$memo_initiate        = '';
$memo_assigned        = '';
$memo_update = '';
$maintenance_module    = '';
$pm_checklist    = '';
$bm_checklist   = '';
$maintenance_checklist     = '';
$manpower_in_out_module = '';
$permission_or_onduty    = '';
$regularisation_approval    = '';
$transfer_location    = '';
$target_fixing_module  = '';
$goal_setting      = '';
// $target_fixing    = '';
$daily_performance    = '';
$appreciation_depreciation    = '';
$vehicle_management_module    = '';
$vehicle_details    = '';
$daily_km    = '';
$diesel_slip    = '';
$approval_mechanism_module    = '';
$approval_requisition    = '';
$business_communication_outgoing    = '';
$minutes_of_meeting    = '';
$report_module    = '';
$reports             = '';

if(isset($_POST['submitusers']))
{
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
        $updatecustomer = $userObj->updateuser($mysqli, $id);  
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_user&msc=2';</script> 
    <?php }
    else{
        $addcustomer = $userObj->adduser($mysqli);   
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_user&msc=1';</script> 
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
    $deleteuser = $userObj->deleteuser($mysqli,$del); 
    ?>
    <script>location.href='<?php echo $HOSTPATH; ?>edit_user&msc=3';</script>
    <?php   
}
if(isset($_GET['upd']))
{
    $idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{
	$getuser = $userObj->getmanageuser($mysqli,$idupd); 
	if (sizeof($getuser)>0) {
        for($iuser=0;$iuser<sizeof($getuser);$iuser++){

            $user_id        = $getuser['user_id'];
            // $first_name     = $getuser['firstname'];
            // $last_name      = $getuser['lastname'];
            // $full_name      = $getuser['fullname'];
            // $title          = $getuser['title'];
            $branch_id      = $getuser['branch_id'];
            $staff_id      = $getuser['staff_id'];
            $user_name      = $getuser['user_name']; 
            $designation_id       = $getuser['designation_id'];
            $designation_name       = $getuser['designation_name'];
            $mobilenumber       = $getuser['mobile_number'];
            $emailid       = $getuser['emailid'];
            $user_password       = $getuser['user_password'];
            $role           = $getuser['role'];

            $administration_module    = $getuser['administration_module'];
            $dashboard      = $getuser['dashboard'];
            $company_creation = $getuser['company_creation'];
            $branch_creation = $getuser['branch_creation'];
            $holiday_creation = $getuser['holiday_creation'];
            $manage_users   = $getuser['manage_users'];
            $master_module   = $getuser['master_module'];
            $basic_sub_module        = $getuser['basic_sub_module'];
            $responsibility_sub_module         = $getuser['responsibility_sub_module'];
            $audit_module = $getuser['audit_sub_module'];
            $others_sub_module = $getuser['others_sub_module'];
            $basic_creation = $getuser['basic_creation'];
            $tag_creation = $getuser['tag_creation'];
            $rr_creation = $getuser['rr_creation'];
            $kra_category = $getuser['kra_category'];
            $krakpi_creation  = $getuser['krakpi_creation'];
            $staff_creation = $getuser['staff_creation'];
            $audit_area_creation  = $getuser['audit_area_creation'];
            $audit_area_checklist    = $getuser['audit_area_checklist'];
            $audit_assign = $getuser['audit_assign'];
            $audit_follow_up = $getuser['audit_follow_up'];
            $report_template  = $getuser['report_template'];
            $media_master  = $getuser['media_master'];
            $asset_creation = $getuser['asset_creation'];
            $insurance_register = $getuser['insurance_register'];
            $service_indent   = $getuser['service_indent'];
            $asset_details    = $getuser['asset_details'];
            $rgp_creation      = $getuser['rgp_creation'];
            $promotional_activities    = $getuser['promotional_activities'];
            $work_force_module  = $getuser['work_force_module'];
            $schedule_task_sub_module        = $getuser['schedule_task_sub_module'];
            $memo_sub_module      = $getuser['memo_sub_module'];
            $campaign        = $getuser['campaign'];
            $assign_work = $getuser['assign_work'];
            $daily_task_update = $getuser['daily_task_update'];
            $todo = $getuser['todo'];
            $assigned_work    = $getuser['assigned_work'];
            $memo_initiate        = $getuser['memo_initiate'];
            $memo_assigned        = $getuser['memo_assigned'];
            $memo_update = $getuser['memo_update'];
            $maintenance_module    = $getuser['maintenance_module'];
            $pm_checklist    = $getuser['pm_checklist'];
            $bm_checklist   = $getuser['bm_checklist'];
            $maintenance_checklist     = $getuser['maintenance_checklist'];
            $manpower_in_out_module = $getuser['manpower_in_out_module'];
            $permission_or_onduty    = $getuser['permission_or_onduty'];
            $regularisation_approval    = $getuser['regularisation_approval'];
            $transfer_location    = $getuser['transfer_location'];
            $target_fixing_module  = $getuser['target_fixing_module'];
            $goal_setting      = $getuser['goal_setting'];
            // $target_fixing    = $getuser['target_fixing'];
            $daily_performance    = $getuser['daily_performance'];
            $appreciation_depreciation    = $getuser['appreciation_depreciation'];
            $vehicle_management_module    = $getuser['vehicle_management_module'];
            $vehicle_details    = $getuser['vehicle_details'];
            $daily_km    = $getuser['daily_km'];
            $diesel_slip    = $getuser['diesel_slip'];
            $approval_mechanism_module    = $getuser['approval_mechanism_module'];
            $approval_requisition    = $getuser['approval_requisition'];
            $business_communication_outgoing    = $getuser['business_communication_outgoing'];
            $minutes_of_meeting    = $getuser['minutes_of_meeting'];
            $report_module      = $getuser['report_module'];
            $reports      = $getuser['reports'];
		}
	}
} 

?>

<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Manage Users</li>
    </ol>

    <a href="edit_user">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    </a>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
	<!-- Row start -->
	<form action="" method="post" name="manage_users_form" id="manage_users_form" >
        <input type="hidden" name="id" id="id" class="form-control" value="<?php if(isset($user_id)) echo $user_id; ?>">
		<div class="row gutters">
            <!-- General Info -->
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">
                    <div class="card-header">
                        <!-- <div class="card-header">General Info</div> -->
					</div>
					<div class="card-body row">
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="">Employee Name</label>
                                    <select type="text" class="form-control" tabindex="11" id="staff_name" name="staff_name">
                                        <option value="">Select Employee</option>
                                        <?php if (sizeof($employeecodelist)>0) { 
                                        for($j=0;$j<count($employeecodelist);$j++) { ?>
                                            <option
                                                <?php if(isset($staff_id)) { if($employeecodelist[$j]['staff_id'] == $staff_id ) echo 'selected'; } ?> value="<?php echo $employeecodelist[$j]['staff_id']; ?>" >
                                                <?php echo $employeecodelist[$j]['staff_name']; ?>
                                                (<?php echo $employeecodelist[$j]['emp_code']; ?>)
                                            </option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for=""> Designation </label>
                                    <input type="text" readonly placeholder="Enter Designation" class="form-control" tabindex="2" name="designation" id="designation"
                                        value="<?php if($idupd > 0){ if(isset($designation_name)) echo $designation_name; }?>">
                                    <input type="hidden" class="form-control" name="designation_id" id="designation_id" value="<?php if(isset($designation_id)) echo $designation_id; ?>">
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for=""> E-Mail Id </label>
                                    <input type="text" readonly class="form-control" placeholder="Enter E-Mail Id" name="email" id="email" tabindex="6"
                                        value="<?php if($idupd > 0){  if(isset($emailid)) echo $emailid; } ?>">
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for=""> Mobile Number </label>
                                    <input type="text" readonly placeholder="Enter Mobile Number" class="form-control" tabindex="3" name="mobilenumber" id="mobilenumber"
                                        value="<?php if($idupd > 0){  if(isset($mobilenumber)) echo $mobilenumber; } ?>">
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for=""> User Name  </label>
                                    <input type="text" class="form-control" placeholder="Enter User Name" tabindex="7"
                                        value="<?php if($idupd > 0){ if(isset($user_name)) echo $user_name; } ?>" id="username" name="username">
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for=""> Password </label>
                                    <input type="password" class="form-control" tabindex="8" placeholder="Enter Password"
                                        id="password" value="<?php if($idupd > 0){ if(isset($user_password)) echo $user_password; } ?>" name="password">
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="">Branch Name</label>
                                    <select type="text" class="form-control" tabindex="11" id="branch_id" name="branch_id">
                                        <option value="">Select Branch</option>
                                        <?php if (sizeof($branchName)>0) { 
                                            for($j=0;$j<count($branchName);$j++) { ?>
                                            <option <?php if(isset($branch_id)) { if($branchName[$j]['branch_id'] == $branch_id)  echo 'selected'; } ?> 
                                                value="<?php echo $branchName[$j]['branch_id']; ?>" >
                                                <?php
                                                for($k=0;$k<count($companyName);$k++) {
                                                    if($branchName[$j]['company_id'] == $companyName[$k]['company_id']) echo $companyName[$k]['company_name']; }
                                                echo ' - ' . $branchName[$j]['branch_name']; ?>
                                            </option>
                                        <?php } } ?> 
                                    </select>
                                </div>
                            </div>

                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="inputEmail">Role</label>
                                    <div>
                                        <input tabindex="6" type="radio" name="role" id="role" value="3" <?php if(isset($role)){if($role == 3){echo "checked";}} ?>>
                                        <label for="role">Manager Login</label>&nbsp;&nbsp;
                                        <input tabindex="7" type="radio" name="role" id="staff_login" value="4" <?php if(isset($role)){if($role == 4){echo "checked";}} ?>>
                                        <label for="staff_login">Staff Login</label> <br>
                                        <!-- <span class="text-danger" id="roleCheck">Select Role</span> -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- admin module start -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Screen Access</li>
                </ol>
                <div class="card">
                    <br>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" tabindex="8" value="Yes" <?php if($idupd > 0){ if($administration_module==0){ echo'checked'; }} ?>  class="custom-control-input" id="administration_module" name="administration_module" >
                        <label class="custom-control-label" for="administration_module">
                            <h5>Administration</h5>
                        </label>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" tabindex="9" value="Yes" <?php if($idupd > 0){ if($dashboard==0){ echo'checked'; }} ?>  class="custom-control-input admin-checkbox" id="dashboard" name="dashboard" disabled>
                                <label class="custom-control-label" for="dashboard">Dashborad</label>
                            </div>
                        </div>
                        <!-- <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" tabindex="9" value="Yes" <?php if($idupd > 0){ if($reports==0){ echo'checked'; }} ?>  class="custom-control-input admin-checkbox" id="reports" name="reports" disabled>
                                <label class="custom-control-label" for="reports">Reports</label>
                            </div>
                        </div> -->
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($company_creation==0){echo'checked';}} ?> tabindex="10" class="custom-control-input admin-checkbox" id="company_creation" name="company_creation" disabled>
                                <label class="custom-control-label" for="company_creation">Company Creation</label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($branch_creation==0){ echo'checked'; }} ?> tabindex="11" class="custom-control-input admin-checkbox" id="branch_creation" name="branch_creation" disabled>
                                <label class="custom-control-label" for="branch_creation">Branch creation</label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($holiday_creation==0){ echo'checked'; }} ?> tabindex="11" class="custom-control-input admin-checkbox" id="holiday_creation" name="holiday_creation" disabled>
                                <label class="custom-control-label" for="holiday_creation">Holiday creation</label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($manage_users==0){ echo'checked'; }} ?> tabindex="12" class="custom-control-input admin-checkbox" id="manage_users" name="manage_users" disabled >
                                <label class="custom-control-label" for="manage_users">Manage Users</label>
                            </div>
                        </div>
                    </div>
                    <!-- admin module end -->
                    <hr>
                    <!-- master module start -->
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" tabindex="13" value="Yes" <?php if($idupd > 0){ if($master_module==0){ echo'checked'; }} ?>  class="custom-control-input" id="master_module" name="master_module">
                        <label class="custom-control-label" for="master_module">
                            <h5>Master</h5>
                        </label>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($basic_sub_module==0){echo'checked';}} ?> tabindex="14"class="custom-control-input master-checkbox" id="basic_sub_module" name="basic_sub_module" disabled>
                                <label class="custom-control-label" for="basic_sub_module"><h6>Basic<h6></label>
                            </div> <br>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($basic_creation==0){echo'checked';}} ?> tabindex="14"class="custom-control-input master-sub-checkbox" id="basic_creation" name="basic_creation" disabled>
                                <label class="custom-control-label" for="basic_creation">Basic Creation</label>
                            </div>
                            <!-- <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php #if($idupd > 0){ if($tag_creation==0){echo'checked';}} ?> tabindex="14"class="custom-control-input master-sub-checkbox" id="tag_creation" name="tag_creation" disabled>
                                <label class="custom-control-label" for="tag_creation">Tag Creation</label>
                            </div> -->
                        </div>

                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($responsibility_sub_module==0){echo'checked';}} ?> tabindex="15" class="custom-control-input master-checkbox" id="responsibility_sub_module" name="responsibility_sub_module" disabled>
                                <label class="custom-control-label" for="responsibility_sub_module"><h6>Responsibility<h6></label>
                            </div> <br>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($rr_creation==0){echo'checked';}} ?> tabindex="14"class="custom-control-input responsibility-sub-checkbox" id="rr_creation" name="rr_creation" disabled>
                                <label class="custom-control-label" for="rr_creation">R&R Creation</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($kra_category==0){echo'checked';}} ?> tabindex="14"class="custom-control-input responsibility-sub-checkbox" id="kra_category" name="kra_category" disabled>
                                <label class="custom-control-label" for="kra_category">KRA Category</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($krakpi_creation==0){echo'checked';}} ?> tabindex="14"class="custom-control-input responsibility-sub-checkbox" id="krakpi_creation" name="krakpi_creation" disabled>
                                <label class="custom-control-label" for="krakpi_creation">KRA & KPI Creation</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($staff_creation==0){echo'checked';}} ?> tabindex="14"class="custom-control-input responsibility-sub-checkbox" id="staff_creation" name="staff_creation" disabled>
                                <label class="custom-control-label" for="staff_creation">Staff Creation</label>
                            </div>
                        </div>

                        <!-- <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($audit_sub_module==0){echo'checked';}} ?> tabindex="14" class="custom-control-input master-checkbox" id="audit_sub_module" name="audit_sub_module" disabled>
                                <label class="custom-control-label" for="audit_sub_module"><h6>Audit<h6></label>
                            </div> <br>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($audit_area_creation==0){echo'checked';}} ?> tabindex="14"class="custom-control-input audit-sub-checkbox" id="audit_area_creation" name="audit_area_creation" disabled>
                                <label class="custom-control-label" for="audit_area_creation">Audit Area Creation</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($audit_area_checklist==0){echo'checked';}} ?> tabindex="14"class="custom-control-input audit-sub-checkbox" id="audit_area_checklist" name="audit_area_checklist" disabled>
                                <label class="custom-control-label" for="audit_area_checklist">Audit Area Checklist</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($audit_assign==0){echo'checked';}} ?> tabindex="14"class="custom-control-input audit-sub-checkbox" id="audit_assign" name="audit_assign" disabled>
                                <label class="custom-control-label" for="audit_assign">Audit Assign</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($audit_follow_up==0){echo'checked';}} ?> tabindex="14"class="custom-control-input audit-sub-checkbox" id="audit_follow_up" name="audit_follow_up" disabled>
                                <label class="custom-control-label" for="audit_follow_up">Audit Follow Up</label>
                            </div>
                        </div> -->

                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($others_sub_module==0){echo'checked';}} ?> tabindex="17" class="custom-control-input master-checkbox" id="others_sub_module" name="others_sub_module" disabled>
                                <label class="custom-control-label" for="others_sub_module"><h6>Others<h6></label>
                            </div> <br>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($report_template==0){echo'checked';}} ?> tabindex="14"class="custom-control-input others-sub-checkbox" id="report_template" name="report_template" disabled>
                                <label class="custom-control-label" for="report_template">Report Template</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($media_master==0){echo'checked';}} ?> tabindex="14"class="custom-control-input others-sub-checkbox" id="media_master" name="media_master" disabled>
                                <label class="custom-control-label" for="media_master">Media Master</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($asset_creation==0){echo'checked';}} ?> tabindex="14"class="custom-control-input others-sub-checkbox" id="asset_creation" name="asset_creation" disabled>
                                <label class="custom-control-label" for="asset_creation">Asset Creation</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($insurance_register==0){echo'checked';}} ?> tabindex="14"class="custom-control-input others-sub-checkbox" id="insurance_register" name="insurance_register" disabled>
                                <label class="custom-control-label" for="insurance_register">Insurance Register</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($service_indent==0){echo'checked';}} ?> tabindex="14"class="custom-control-input others-sub-checkbox" id="service_indent" name="service_indent" disabled>
                                <label class="custom-control-label" for="service_indent">Service Indent</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($asset_details==0){echo'checked';}} ?> tabindex="14"class="custom-control-input others-sub-checkbox" id="asset_details" name="asset_details" disabled>
                                <label class="custom-control-label" for="asset_details">Asset Details</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($rgp_creation==0){echo'checked';}} ?> tabindex="14"class="custom-control-input others-sub-checkbox" id="rgp_creation" name="rgp_creation" disabled>
                                <label class="custom-control-label" for="rgp_creation">RGP Creation</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($promotional_activities==0){echo'checked';}} ?> tabindex="14"class="custom-control-input others-sub-checkbox" id="promotional_activities" name="promotional_activities" disabled>
                                <label class="custom-control-label" for="promotional_activities">Promotional Activities</label>
                            </div>
                        </div>
                    </div>
                <!-- master module end -->
                    <hr>

                    <!-- audit module start -->
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" tabindex="36" value="Yes" <?php if($idupd > 0){ if($audit_module==0){ echo'checked'; }} ?>  class="custom-control-input" id="audit_module" name="audit_module">
                        <label class="custom-control-label" for="audit_module">
                            <h5>Audit</h5>
                        </label>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($audit_area_creation==0){echo'checked';}} ?> tabindex="14"class="custom-control-input audit-checkbox" id="audit_area_creation" name="audit_area_creation" disabled>
                                <label class="custom-control-label" for="audit_area_creation">Audit Area Creation</label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($audit_area_checklist==0){echo'checked';}} ?> tabindex="14"class="custom-control-input audit-checkbox" id="audit_area_checklist" name="audit_area_checklist" disabled>
                                <label class="custom-control-label" for="audit_area_checklist">Audit Area Checklist</label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($audit_assign==0){echo'checked';}} ?> tabindex="14"class="custom-control-input audit-checkbox" id="audit_assign" name="audit_assign" disabled>
                                <label class="custom-control-label" for="audit_assign">Audit Assign</label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($audit_follow_up==0){echo'checked';}} ?> tabindex="14"class="custom-control-input audit-checkbox" id="audit_follow_up" name="audit_follow_up" disabled>
                                <label class="custom-control-label" for="audit_follow_up">Audit Follow Up</label>
                            </div>
                        </div>
                    </div>
                    <!-- audit module end -->
                    <hr>
                <!-- work force module start -->
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" tabindex="25" value="Yes" <?php if($idupd > 0){ if($work_force_module==0){ echo'checked'; }} ?>   class="custom-control-input" id="work_force_module" name="work_force_module">
                        <label class="custom-control-label" for="work_force_module">
                            <h5>Work Force</h5>
                        </label>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($schedule_task_sub_module==0){echo'checked';}} ?> tabindex="14"class="custom-control-input workforce-checkbox" id="schedule_task_sub_module" name="schedule_task_sub_module" disabled>
                                <label class="custom-control-label" for="schedule_task_sub_module"><h6>Schedule Task<h6></label>
                            </div> <br>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($campaign==0){echo'checked';}} ?> tabindex="14"class="custom-control-input scheduletask-sub-checkbox" id="campaign" name="campaign" disabled>
                                <label class="custom-control-label" for="campaign">Campaign</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($assign_work==0){echo'checked';}} ?> tabindex="14"class="custom-control-input scheduletask-sub-checkbox" id="assign_work" name="assign_work" disabled>
                                <label class="custom-control-label" for="assign_work">Assign Work</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($daily_task_update==0){echo'checked';}} ?> tabindex="14"class="custom-control-input scheduletask-sub-checkbox" id="daily_task_update" name="daily_task_update" disabled>
                                <label class="custom-control-label" for="daily_task_update">Daily Task Update</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($todo==0){echo'checked';}} ?> tabindex="14"class="custom-control-input scheduletask-sub-checkbox" id="todo" name="todo" disabled>
                                <label class="custom-control-label" for="todo">To Do</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($assigned_work==0){echo'checked';}} ?> tabindex="14"class="custom-control-input scheduletask-sub-checkbox" id="assigned_work" name="assigned_work" disabled>
                                <label class="custom-control-label" for="assigned_work">Assigned Work</label>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($memo_sub_module==0){echo'checked';}} ?> tabindex="15" class="custom-control-input workforce-checkbox" id="memo_sub_module" name="memo_sub_module" disabled>
                                <label class="custom-control-label" for="memo_sub_module"><h6>Memo<h6></label>
                            </div> <br>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($memo_initiate==0){echo'checked';}} ?> tabindex="14"class="custom-control-input memo-sub-checkbox" id="memo_initiate" name="memo_initiate" disabled>
                                <label class="custom-control-label" for="memo_initiate">Memo Initiate</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($memo_assigned==0){echo'checked';}} ?> tabindex="14"class="custom-control-input memo-sub-checkbox" id="memo_assigned" name="memo_assigned" disabled>
                                <label class="custom-control-label" for="memo_assigned">Memo Assigned</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($memo_update==0){echo'checked';}} ?> tabindex="14"class="custom-control-input memo-sub-checkbox" id="memo_update" name="memo_update" disabled>
                                <label class="custom-control-label" for="memo_update">Memo Update</label>
                            </div>
                        </div>
                    </div>
                    <!-- work force module end -->
                    <hr>
                    <!-- maintenance module end -->
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" tabindex="30" value="Yes" <?php if($idupd > 0){ if($maintenance_module==0){ echo'checked'; }} ?>  class="custom-control-input" id="maintenance_module" name="maintenance_module">
                        <label class="custom-control-label" for="maintenance_module">
                            <h5>Maintenance</h5>
                        </label>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($pm_checklist==0){echo'checked'; }}?> tabindex="31" class="custom-control-input maintenance-checkbox" id="pm_checklist" name="pm_checklist" disabled>
                                <label class="custom-control-label" for="pm_checklist">PM Checklist</label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($bm_checklist==0){echo'checked';}} ?>  tabindex="32" class="custom-control-input maintenance-checkbox" id="bm_checklist" name="bm_checklist" disabled>
                                <label class="custom-control-label" for="bm_checklist">BM Checklist</label>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($maintenance_checklist==0){echo'checked';}} ?>  tabindex="33" class="custom-control-input maintenance-checkbox" id="maintenance_checklist" name="maintenance_checklist" disabled>
                                <label class="custom-control-label" for="maintenance_checklist">Maintenance Checklist</label>
                            </div>
                        </div>
                    </div>
                    <!-- maintenance module end -->
                    <hr>
                    <!-- manpower in&out module start -->
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" tabindex="36" value="Yes" <?php if($idupd > 0){ if($manpower_in_out_module==0){ echo'checked'; }} ?>  class="custom-control-input" id="manpower_in_out_module" name="manpower_in_out_module">
                        <label class="custom-control-label" for="manpower_in_out_module">
                            <h5>Manpower In & Out</h5>
                        </label>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($permission_or_onduty==0){echo'checked';}} ?> tabindex="37" class="custom-control-input manpower-checkbox" id="permission_or_onduty" name="permission_or_onduty" disabled>
                                <label class="custom-control-label" for="permission_or_onduty">Regularisation</label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($regularisation_approval==0){echo'checked';}} ?> tabindex="37" class="custom-control-input manpower-checkbox" id="regularisation_approval" name="regularisation_approval" disabled>
                                <label class="custom-control-label" for="regularisation_approval">Regularisation Approval</label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($transfer_location==0){echo'checked';}} ?> tabindex="37" class="custom-control-input manpower-checkbox" id="transfer_location" name="transfer_location" disabled>
                                <label class="custom-control-label" for="transfer_location">Transfer Location</label>
                            </div>
                        </div>
                    </div>
                    <!-- manpower in&out module end -->
                    <hr>
                    <!-- target fixing module start -->
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" tabindex="38" value="Yes" <?php if($idupd > 0){ if($target_fixing_module==0){ echo'checked'; }} ?>  class="custom-control-input" id="target_fixing_module" name="target_fixing_module">
                        <label class="custom-control-label" for="target_fixing_module">
                            <h5>Target Fixing</h5>
                        </label>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($goal_setting==0){echo'checked';}} ?> tabindex="39" class="custom-control-input targetfixing-checkbox" id="goal_setting"  name="goal_setting" disabled>
                                <label class="custom-control-label" for="goal_setting">Goal Setting</label>
                            </div>
                        </div>
                        <!-- <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($target_fixing==0){echo'checked';}} ?> tabindex="40" class="custom-control-input targetfixing-checkbox" id="target_fixing" name="target_fixing" disabled>
                                <label class="custom-control-label" for="target_fixing">Target Fixing</label>
                            </div>
                        </div> -->
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($daily_performance==0){echo'checked';}} ?> tabindex="40" class="custom-control-input targetfixing-checkbox" id="daily_performance" name="daily_performance" disabled>
                                <label class="custom-control-label" for="daily_performance">Daily Performance</label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($appreciation_depreciation==0){echo'checked';}} ?> tabindex="40" class="custom-control-input targetfixing-checkbox" id="appreciation_depreciation" name="appreciation_depreciation" disabled>
                                <label class="custom-control-label" for="appreciation_depreciation">Appreciation VS Depreciation</label>
                            </div>
                        </div>
                    </div>
                    <!-- target fixing module end -->
                    <hr>
                    <!-- vehicle management module start -->
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" tabindex="41" value="Yes" <?php if($idupd > 0){ if($vehicle_management_module==0){ echo'checked'; }} ?>  class="custom-control-input" id="vehicle_management_module" name="vehicle_management_module">
                        <label class="custom-control-label" for="vehicle_management_module">
                            <h5>Vehicle Management</h5>
                        </label>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($vehicle_details==0){echo'checked';}} ?> tabindex="42" class="custom-control-input vehicle-checkbox" id="vehicle_details" name="vehicle_details" disabled>
                                <label class="custom-control-label" for="vehicle_details">Vehicle Details</label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($daily_km==0){echo'checked';}} ?> tabindex="43" class="custom-control-input vehicle-checkbox" id="daily_km" name="daily_km" disabled>
                                <label class="custom-control-label" for="daily_km">Daily KM</label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($diesel_slip==0){echo'checked';}} ?> tabindex="44" class="custom-control-input vehicle-checkbox" id="diesel_slip" name="diesel_slip" disabled>
                                <label class="custom-control-label" for="diesel_slip">Diesel Slip</label>
                            </div>
                        </div>
                    </div>
                    <!-- vehicle management module end -->
                    <hr>
                    <!-- approval machanism module start -->
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" tabindex="47" value="Yes" <?php if($idupd > 0){ if($approval_mechanism_module==0){ echo'checked'; }} ?>  class="custom-control-input" id="approval_mechanism_module" name="approval_mechanism_module">
                        <label class="custom-control-label" for="approval_mechanism_module">
                            <h5>Approval Mechanism</h5>
                        </label>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($approval_requisition==0){echo'checked';}}?> tabindex="48" class="custom-control-input approvalmechanism-checkbox" id="approval_requisition" name="approval_requisition" disabled>
                                <label class="custom-control-label" for="approval_requisition">Approval Requisition</label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($business_communication_outgoing==0){echo'checked';}}?> tabindex="49" class="custom-control-input approvalmechanism-checkbox" id="business_communication_outgoing" name="business_communication_outgoing" disabled>
                                <label class="custom-control-label" for="business_communication_outgoing">Business Communication - Outgoing</label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="Yes" <?php if($idupd > 0){ if($minutes_of_meeting==0){echo'checked';}}?> tabindex="50" class="custom-control-input approvalmechanism-checkbox" id="minutes_of_meeting" name="minutes_of_meeting" disabled>
                                <label class="custom-control-label" for="minutes_of_meeting">Minutes Of Meeting</label>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <!-- approval machanism module end -->
                    
                    <!-- Report Module Start -->
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" tabindex="8" value="Yes" <?php if($idupd > 0){ if($report_module==0){ echo'checked'; }} ?>  class="custom-control-input" id="report_module" name="report_module" >
                        <label class="custom-control-label" for="report_module">
                            <h5>Reporting</h5>
                        </label>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" tabindex="9" value="Yes" <?php if($idupd > 0){ if($reports==0){ echo'checked'; }} ?>  class="custom-control-input report-checkbox" id="reports" name="reports" disabled>
                                <label class="custom-control-label" for="reports">Reports</label>
                            </div>
                        </div>
                    </div>
                    <!-- Report module end -->
                    <hr>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-4">
                    <div class="text-right">
                        <div>
                            <button type="submit"  tabindex="55" name="submitusers" id="submitusers"  class="btn btn-primary">Submit</button>&nbsp;&nbsp;&nbsp;
                            <button type="reset"  tabindex="56" class="btn btn-outline-secondary">Cancel</button> 
                        </div>
                    </div>
                </div>
		</div>
	</form>
</div>



<script>
    
</script>