<?php
if(isset($_SESSION["userid"])){
	$userid = $_SESSION["userid"];
} 
// $user_id        = '';
// $first_name     = '';
// $last_name      = '';
// $full_name      = '';
// $title          = '';
// $user_name      = '';
// $email_id       = '';
// $password       = '';
// $confirm_password = '';
// $role           = '';

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
$target_fixing    = '';
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

$getuser = $userObj->getmanageuser($mysqli,$userid); 
if (sizeof($getuser)>0) {
	for($iuser=0;$iuser<sizeof($getuser);$iuser++){

		// $user_id        = $getuser['user_id'];
		// $first_name     = $getuser['firstname'];
		// $last_name      = $getuser['lastname'];
		// $full_name      = $getuser['fullname'];
		// $title          = $getuser['title'];
		// $user_name      = $getuser['user_name'];
		// $email_id       = $getuser['emailid'];
		// $password       = $getuser['user_password'];
		// $confirm_password       = $getuser['user_password'];
		// $role           = $getuser['role'];

		$administration_module    = $getuser['administration_module']; 
		$dashboard      = $getuser['dashboard']; 
		$company_creation = $getuser['company_creation']; 
		$branch_creation = $getuser['branch_creation'];
		$holiday_creation = $getuser['holiday_creation'];
		$manage_users   = $getuser['manage_users'];
		$master_module   = $getuser['master_module']; 
		$basic_sub_module        = $getuser['basic_sub_module'];
		$responsibility_sub_module         = $getuser['responsibility_sub_module'];
		$audit_sub_module = $getuser['audit_sub_module'];
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
		$target_fixing    = $getuser['target_fixing'];
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
	}
}

?>

<style>
	body {
		font-family: "Lato", sans-serif;
	}

	/* Fixed sidenav, full height */
	.sidenav {
		height: 100%;
		width: 200px;
		position: fixed;
		z-index: 1;
		top: 0;
		left: 0;
		background-color: #111;
		overflow-x: hidden;
		padding-top: 20px;
	}

	/* Style the sidenav links and the dropdown button */
	.sidenav a, .dropdown-btn1 {
		padding: 6px 8px 6px 16px;
		text-decoration: none;
		
		color: #818181;
		display: block;
		border: none;
		background: none;
		width: 100%;
		text-align: left;
		cursor: pointer;
		outline: none;
	}

	.sidenav a, .dropdown-btn {
		padding: 6px 8px 6px 16px;
		text-decoration: none;
		
		color: #818181;
		display: block;
		border: none;
		background: none;
		width: 100%;
		text-align: left;
		cursor: pointer;
		outline: none;
	}

	/* On mouse-over */
	.sidenav a:hover, .dropdown-btn:hover {
		color: #5090c0;
	}

	/* On mouse-over */
	.sidenav a:hover, .dropdown-btn1:hover {
		color: #5090c0;
	}
	/* Main content */
	.main {
		margin-left: 200px; /* Same as the width of the sidenav */
		padding: 0px 10px;
	}

	/* Add an active class to the active dropdown button */
	.active {
		color: white;
	}

	/* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
	.dropdown-container {
		display: none;
		padding-left: 8px;
	}

	.dropdown-container1 {
		display: none;
		padding-left: 8px;
	}
	/* Optional: Style the caret down icon */
	.fa-caret-down {
		float: right;
		padding-right: 8px;
	}

	/* Some media queries for responsiveness */
	@media screen and (max-height: 450px) {
		.sidenav {padding-top: 15px;}
		.sidenav a {font-size: 18px;}
	}
</style>

<!-- Sidebar wrapper start -->
<nav id="sidebar" class="sidebar-wrapper sidenav" style="background-color:#1b6aaa;">
	
	<!-- Sidebar brand start  -->
	<div class="sidebar-brand" style="background-color: #1b6aaa">
		<a href="javascript:void(0)" class="logo">
			<h3 class="ml-4" style="color: white">AS MOTORS</h3>
			<!-- <img src="img/logo.png" alt="Auction Dashboard" /> -->
		</a>
	</div>

	<div class="sidebar-content">

	<!-- sidebar menu start -->
		<div class="sidebar-menu">
			<ul>
				<?php if($administration_module == 0 && $administration_module != '' && $administration_module != NULL){ ?>	
					<li class="sidebar-dropdown">
						<a href="javascript:void(0)">
							<i class="icon-user"></i>
							<span class="menu-text">Administration</span>
						</a>
						<div class="sidebar-submenu">
							<ul>	
								<?php if($dashboard == 0 && $dashboard != '' && $dashboard != NULL){ ?>				
									<li>									
										<a href="dashboard"><i class="icon-devices_other"></i>Dashboard</a>
									</li>
								<?php } ?>
								<?php if($company_creation == 0 && $company_creation != '' && $company_creation != NULL) { ?>
									<li>									
										<a href="edit_company_creation"><i class="icon-store_mall_directory"></i>Company Creation</a>
									</li>
								<?php } ?>
								<?php if($branch_creation == 0 && $branch_creation != '' && $branch_creation != NULL) { ?>
									<li>									
										<a href="edit_branch_creation"><i class="icon-git-branch"></i>Branch Creation</a>
									</li>
								<?php } ?>
								<?php if($holiday_creation == 0 && $holiday_creation != '' && $holiday_creation != NULL) { ?>
									<li>									
										<a href="edit_holiday_creation"><i class="icon-aperture"></i>Holiday Creation</a>
									</li>
								<?php } ?>
								<?php if($manage_users == 0 && $manage_users != '' && $manage_users != NULL) { ?>
									<li>									
										<a href="edit_user"><i class="icon-users"></i>Manage Users</a>
									</li>
								<?php } ?>
							</ul>
						</div>
					</li>
				<?php } ?>
				<?php if($master_module == 0 && $master_module != '' && $master_module != NULL) { ?>
					<li class="sidebar-dropdown">
						<a href="javascript:void(0)">
							<i class="icon-layers2"></i>
							<span class="menu-text">Master</span>
						</a>
						<div class="sidebar-submenu">
							<ul>
								<?php if($basic_sub_module == 0 && $basic_sub_module != '' && $basic_sub_module != NULL) { ?>
									<li class="sidebar-dropdown1">
										<a href="javascript:void(0)">
											<i class="icon-dehaze"></i>
											<span class="menu-text" >Basic</span>
										</a>
										<div class="sidebar-submenu1">
											<ul>
												<?php if($basic_creation == 0 && $basic_creation != '' && $basic_creation != NULL) { ?>
													<li>
														<a href="edit_basic_creation"><i class="icon-playlist_add"></i>Basic Creation</a>
													</li>
												<?php } ?>
												<?php #if($tag_creation == 0 && $tag_creation != '' && $tag_creation != NULL) { ?>
													<!-- <li>
														<a href="edit_tag_creation"><i class="icon-price-tag"></i>Tag Creation</a>
													</li> -->
												<?php #} ?>	
											</ul>
										</div>	
									</li>
								<?php } ?>	
								<?php if($responsibility_sub_module == 0 && $responsibility_sub_module != '' && $responsibility_sub_module != NULL) { ?>
									<li class="sidebar-dropdown1">
										<a href="javascript:void(0)">
											<i class="icon-thumb_up"></i>
											<span class="menu-text" >Responsibility</span>
										</a>
										<div class="sidebar-submenu1">
											<ul>
												<?php if($rr_creation == 0 && $rr_creation != '' && $rr_creation != NULL) { ?>
													<li>
														<a href="edit_roles_responsibility"><i class="icon-briefcase"></i>R & R Creation</a>	
													</li>
												<?php } ?>
												<?php if($kra_category == 0 && $kra_category != '' && $kra_category != NULL) { ?>
													<li>
														<a href="edit_kra_creation"><i class="icon-git-merge"></i>KRA Category</a>	
													</li>
												<?php } ?>
												<?php if($krakpi_creation == 0 && $krakpi_creation != '' && $krakpi_creation != NULL) { ?>
													<li>
														<a href="edit_krakpi_creation"><i class="icon-git-pull-request"></i>KRA & KPI Creation</a>	
													</li>
												<?php } ?>
												<?php if($staff_creation == 0 && $staff_creation != '' && $staff_creation != NULL) { ?>
													<li>
														<a href="edit_staff_creation"><i class="icon-user-plus"></i>Staff Creation</a>
													</li>
												<?php } ?>
											</ul>
										</div>	
									</li>
								<?php } ?>	
								<?php if($others_sub_module == 0 && $others_sub_module != '' && $others_sub_module != NULL) { ?>
									<li class="sidebar-dropdown1">
										<a href="javascript:void(0)">
											<i class="icon-devices_other"></i>
											<span class="menu-text" >Others</span>
										</a>
										<div class="sidebar-submenu1">
											<ul>
												<?php if($report_template == 0 && $report_template != '' && $report_template != NULL) { ?>
													<li>
														<a href="report_template"><i class="icon-signal_cellular_4_bar"></i>Report Template</a>
													</li>
												<?php } ?>
												<?php if($media_master == 0 && $media_master != '' && $media_master != NULL) { ?>
													<li>
														<a href="edit_media_master"><i class="icon-film"></i>Media Master</a>
													</li>
												<?php } ?>
												<?php if($asset_creation == 0 && $asset_creation != '' && $asset_creation != NULL) { ?>
													<li>
														<a href="asset_register"><i class="icon-map2"></i>Asset Creation</a>
													</li>
												<?php } ?>
												<?php if($insurance_register == 0 && $insurance_register != '' && $insurance_register != NULL) { ?>
													<li>
														<a href="edit_insurance_register"><i class="icon-offline_pin"></i>Insurance Register</a>
													</li>
												<?php } ?>
												<?php if($service_indent == 0 && $service_indent != '' && $service_indent != NULL) { ?>
													<li>
														<a href="edit_service_indent"><i class="icon-slack"></i>Service Indent</a>
													</li>
												<?php } ?>
												<?php if($asset_details == 0 && $asset_details != '' && $asset_details != NULL) { ?>
													<li>
														<a href="edit_asset_details"><i class="icon-signal_cellular_4_bar"></i>Asset Details</a>
													</li>
												<?php } ?>
												<?php if($rgp_creation == 0 && $rgp_creation != '' && $rgp_creation != NULL) { ?>
													<li>
														<a href="edit_rgp_creation"><i class="icon-pie_chart"></i>RGP Creation</a>
													</li>
												<?php } ?>
												<?php if($promotional_activities == 0 && $promotional_activities != '' && $promotional_activities != NULL) { ?>
													<li>
														<a href="edit_promotional_activities"><i class="icon-pie_chart"></i>Promotional Activities</a>
													</li>
												<?php } ?>
											</ul>
										</div>	
									</li>
								<?php } ?>
							</ul>
						</div>
					</li>
				<?php } ?>

				<?php if($audit_sub_module == 0 && $audit_sub_module != '' && $audit_sub_module != NULL) { ?>
					<li class="sidebar-dropdown">
						<a href="javascript:void(0)">
							<i class="icon-file-text"></i>
							<span class="menu-text" >Audit</span>
						</a>
						<div class="sidebar-submenu">
							<ul>
								<?php if($audit_area_creation == 0 && $audit_area_creation != '' && $audit_area_creation != NULL) { ?>
									<li>
										<a href="edit_audit_area_creation"><i class="icon-codepen"></i>Audit Area Creation</a>	
									</li>
								<?php } ?>
								<?php if($audit_area_checklist == 0 && $audit_area_checklist != '' && $audit_area_checklist != NULL) { ?>
									<li>
										<a href="edit_audit_area_checklist"><i class="icon-assignment_turned_in"></i>Audit Area Check List</a>	
									</li>
								<?php } ?>
								<?php if($audit_assign == 0 && $audit_assign != '' && $audit_assign != NULL) { ?>
									<li>
										<a href="edit_audit_assign"><i class="icon-check-circle"></i>Audit Assign</a>	
									</li>
								<?php } ?>
								<?php if($audit_follow_up == 0 && $audit_follow_up != '' && $audit_follow_up != NULL) { ?>
									<li>
										<a href="audit_followup"><i class="icon-compass"></i>Audit Follow Up</a>	
									</li>
								<?php } ?>
							</ul>
						</div>	
					</li>
				<?php } ?>

				<?php if($work_force_module == 0 && $work_force_module != '' && $work_force_module != NULL) { ?>
					<!-- Workforce Menu -->
					<li class="sidebar-dropdown">
						<a href="javascript:void(0)">
							<i class="icon-target"></i>
							<span class="menu-text">Work Force</span>
						</a>
						<div class="sidebar-submenu">
							<ul>
								<?php if($schedule_task_sub_module == 0 && $schedule_task_sub_module != '' && $schedule_task_sub_module != NULL) { ?>
									<li class="sidebar-dropdown1">
										<a href="javascript:void(0)">
											<i class="icon-file"></i>
											<span class="menu-text" >Schedule Task</span>
										</a>
										<div class="sidebar-submenu1">
											<ul>
												<?php if($campaign == 0 && $campaign != '' && $campaign != NULL) { ?>
													<li>
														<a href="edit_campaign"><i class="icon-rss_feed"></i>Campaign</a>
													</li>
												<?php } ?>
												<?php if($assign_work == 0 && $assign_work != '' && $assign_work != NULL) { ?>
													<li>
														<a href="edit_assign_work"><i class="icon-archive"></i>Assign Work</a>
													</li>
												<?php } ?>
												<?php if($todo == 0 && $todo != '' && $todo != NULL) { ?>
													<li>
														<a href="edit_todo"><i class="icon-today"></i>To Do</a>
													</li>
												<?php } ?>
												<?php if($assigned_work == 0 && $assigned_work != '' && $assigned_work != NULL) { ?>
													<li>
														<a href="assigned_work"><i class="icon-calendar"></i>Assigned Work</a>
													</li>
												<?php } ?>
											</ul>
										</div>		
									</li>
								<?php } ?>
								<?php if($memo_sub_module == 0 && $memo_sub_module != '' && $memo_sub_module != NULL) { ?>
									<li class="sidebar-dropdown1">
										<a href="javascript:void(0)">
											<i class="icon-ring_volume"></i>
											<span class="menu-text">Memo</span>
										</a>
										<div class="sidebar-submenu1">
											<ul>
												<?php if($memo_initiate == 0 && $memo_initiate != '' && $memo_initiate != NULL) { ?>
													<li>
														<a href="edit_memo"><i class="icon-reply_all"></i>Memo Initiate</a>
													</li>
												<?php } ?>
												<?php if($memo_assigned == 0 && $memo_assigned != '' && $memo_assigned != NULL) { ?>
													<li>
														<a href="edit_memo_assigned"><i class="icon-view_carousel"></i>Memo Assigned</a>
													</li>
												<?php } ?>
												<?php if($memo_update == 0 && $memo_update != '' && $memo_update != NULL) { ?>
													<li>
														<a href="edit_memo_update"><i class="icon-upload-cloud"></i>Memo Update</a>
													</li>
												<?php } ?>
											</ul>
										</div>		
									</li>
								<?php } ?>
							</ul>
						</div>
					</li>
				<?php } ?>
				<?php if($maintenance_module == 0 && $maintenance_module != '' && $maintenance_module != NULL) { ?>
					<!-- Maintenance -->
					<li class="sidebar-dropdown1">
						<a href="javascript:void(0)">
							<i class="icon-file-text"></i>
							<span class="menu-text" >Maintenance</span>
						</a>
						<div class="sidebar-submenu1">
							<ul>
								<?php if($pm_checklist == 0 && $pm_checklist != '' && $pm_checklist != NULL) { ?>
									<li>
										<a href="edit_pm_checklist"><i class="icon-card_membership"></i>PM Checklist</a>	
									</li>
								<?php } ?>
								<?php if($bm_checklist == 0 && $bm_checklist != '' && $bm_checklist != NULL) { ?>
									<li>
										<a href="edit_bm_checklist"><i class="icon-business_center"></i>BM Checklist</a>	
									</li>
								<?php } ?>
								<?php if($maintenance_checklist == 0 && $maintenance_checklist != '' && $maintenance_checklist != NULL) { ?>
									<li>
										<a href="edit_maintenance_checklist"><i class="icon-call_split"></i>Maintenance Checklist</a>	
									</li>
								<?php } ?>
							</ul>
						</div>	
					</li>
				<?php } ?>
				<?php if($manpower_in_out_module == 0 && $manpower_in_out_module != '' && $manpower_in_out_module != NULL) { ?>
					<!-- approval mechanism -->
					<li class="sidebar-dropdown1">
						<a href="javascript:void(0)">
							<i class="icon-people_outline"></i>
							<span class="menu-text" >Manpower In & Out</span>
						</a>
						<div class="sidebar-submenu1">
							<ul>
								<?php if($permission_or_onduty == 0 && $permission_or_onduty != '' && $permission_or_onduty != NULL) { ?>
									<li>
										<a href="edit_permission_or_on_duty"><i class="icon-receipt"></i>Regularisation</a>	
									</li>
								<?php } ?>
								<?php if($regularisation_approval == 0 && $regularisation_approval != '' && $regularisation_approval != NULL) { ?>
									<li>
										<a href="edit_permission_approval"><i class="icon-receipt"></i>Regularisation Approval</a>	
									</li>
								<?php } ?>
								<?php if($transfer_location == 0 && $transfer_location != '' && $transfer_location != NULL) { ?>
									<li>
										<a href="edit_transfer_location"><i class="icon-recent_actors"></i>Transfer Location</a>	
									</li>
								<?php } ?>
							</ul>
						</div>	
					</li>
				<?php } ?>
				<?php if($target_fixing_module == 0 && $target_fixing_module != '' && $target_fixing_module != NULL) { ?>
					<!-- Target Fixing -->
					<li class="sidebar-dropdown1">
						<a href="javascript:void(0)">
							<i class="icon-target"></i>
							<span class="menu-text" >Target Fixing</span>
						</a>
						<div class="sidebar-submenu1">
							<ul>
								<?php if($goal_setting == 0 && $goal_setting != '' && $goal_setting != NULL) { ?>
									<li>
										<a href="edit_goal_setting"><i class="icon-receipt"></i>Goal Setting</a>	
									</li>
								<?php } ?>
								<?php if($target_fixing == 0 && $target_fixing != '' && $target_fixing != NULL) { ?>
									<li>
										<a href="edit_target_fixing"><i class="icon-recent_actors"></i>Target Fixing</a>	
									</li>
								<?php } ?>
								<?php if($daily_performance == 0 && $daily_performance != '' && $daily_performance != NULL) { ?>
									<li>
										<a href="edit_daily_performance"><i class="icon-file"></i>Daily Performance</a>	
									</li>
								<?php } ?>
								<?php if($appreciation_depreciation == 0 && $appreciation_depreciation != '' && $appreciation_depreciation != NULL) { ?>
									<li>
										<a href="edit_appreciation_depreciation"><i class="icon-thumb_up"></i>Appreciation VS Depreciation</a>	
									</li>
								<?php } ?>
							</ul>
						</div>	
					</li>
				<?php } ?>
				<?php if($vehicle_management_module == 0 && $vehicle_management_module != '' && $vehicle_management_module != NULL) { ?>
					<!-- vehicle management -->
					<li class="sidebar-dropdown1">
						<a href="javascript:void(0)">
							<i class="icon-directions_bus"></i>
							<span class="menu-text" >Vehicle Management</span>
						</a>
						<div class="sidebar-submenu1">
							<ul>
								<?php if($vehicle_details == 0 && $vehicle_details != '' && $vehicle_details != NULL) { ?>
									<li>
										<a href="edit_vehicle_details"><i class="icon-time_to_leave"></i>Vehicle Details</a>	
									</li>
								<?php } ?>
								<?php if($daily_km == 0 && $daily_km != '' && $daily_km != NULL) { ?>
									<li>
										<a href="edit_daily_km"><i class="icon-local_car_wash"></i>Daily KM </a>	
									</li>
								<?php } ?>
								<?php if($diesel_slip == 0 && $diesel_slip != '' && $diesel_slip != NULL) { ?>
									<li>
										<a href="edit_diesel_slip"><i class="icon-location_searching"></i>Diesel Slip </a>	
									</li>
								<?php } ?>
							</ul>
						</div>	
					</li>
				<?php } ?>
				<?php if($approval_mechanism_module == 0 && $approval_mechanism_module != '' && $approval_mechanism_module != NULL) { ?>
					<!-- approval mechanism -->
					<li class="sidebar-dropdown1">
						<a href="javascript:void(0)">
							<i class="icon-center_focus_strong"></i>
							<span class="menu-text" >Approval Mechanism</span>
						</a>
						<div class="sidebar-submenu1">
							<ul>
								<?php if($approval_requisition == 0 && $approval_requisition != '' && $approval_requisition != NULL) { ?>
									<li>
										<a href="edit_approval_requisition"><i class="icon-card_travel"></i>Approval Requisition</a>	
									</li>
								<?php } ?>
								<?php if($business_communication_outgoing == 0 && $business_communication_outgoing != '' && $business_communication_outgoing != NULL) { ?>
									<li>
										<a href="edit_business_com_out"><i class="icon-redeem"></i>Business Communication - Outgoing</a>	
									</li>
								<?php } ?>
								<?php if($minutes_of_meeting == 0 && $minutes_of_meeting != '' && $minutes_of_meeting != NULL) { ?>
									<li>
										<a href="edit_meeting_minutes"><i class="icon-redeem"></i>Minutes Of Meeting</a>	
									</li>
								<?php } ?>
							</ul>
						</div>	
					</li>
				<?php } ?>
			</ul>
			<!-- sidebar menu end -->
		</div>
	</div>
</nav>
<!-- Sidebar wrapper end -->



	
<script>
/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
  this.classList.toggle("active");
  var dropdownContent = this.nextElementSibling;
  if (dropdownContent.style.display === "block") {
  	dropdownContent.style.display = "none";
  } else {
  	dropdownContent.style.display = "block";
  }
  });
}

var dropdown1 = document.getElementsByClassName("dropdown-btn1");
var i;

for (i = 0; i < dropdown1.length; i++) {
  dropdown1[i].addEventListener("click", function() {
	this.classList.toggle("active");
	var dropdownContent = this.nextElementSibling;
	if (dropdownContent.style.display === "block") {
		dropdownContent.style.display = "none";
	} else {
		dropdownContent.style.display = "block";
	}
  });
}
</script>
