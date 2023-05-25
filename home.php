<?php 
@session_start();
if(isset($_SESSION['fullname'])){
	$fullname  = $_SESSION['fullname'];
}
if(isset($_SESSION['userid'])){
	$userid  = $_SESSION['userid'];
}

$msc=0;
if(isset($_GET['msc']))
{
	$msc=$_GET['msc'];
}
$current_page = isset($_GET['page']) ? $_GET['page'] : null; 
define('iEditValid', 1);
include('api/main.php'); // Database Connection File   
?>

<!doctype html>
<html lang="en">

<!-- downlaod customer excel div -->
<div id="backup_customer" style="display:none"></div>
<div id="accountdata" style="display:none"></div>
<!-- end customer excel div -->

<!-- Important -->
<?php  if( $current_page != 'vendorcreation' and $current_page != 'auction_details' ) { ?>
<?php include "include/common/dashboardhead.php"?>
<?php  } ?>
<?php if($current_page == 'vendorcreation') { ?>
<?php include "include/common/dashboardfinancedatatablehead.php"?>
<?php } ?>
<?php if($current_page == 'auction_details') { ?>
<?php include "include/common/dashboardfinancedatatablehead.php"?>
<?php } ?>

<body>
	<!-- Page wrapper start -->
	<div class="page-wrapper">
		<?php 
		if($_SESSION['userid']=="")
		{
			echo "<script>location.href='index.php'</script>"; 
		}
		include "include/common/leftbar.php"?>

		<!-- Page content start  -->
		<div class="page-content">

			<!-- Header start -->
			<header class="header">
				<div class="toggle-btns">
					<a id="toggle-sidebar" href="#">
						<i class="icon-list"></i>
					</a>
					<a id="pin-sidebar" href="#">
						<i class="icon-list"></i>
					</a>
				</div>
				<div class="header-items">
					<!-- Custom search start -->
					<div class="custom-search">
						<input type="text" class="search-query" placeholder="Search here ..." >
						<i class="icon-search1"></i>
					</div>
					<!-- Custom search end -->

					<!-- Header actions start -->
					<ul class="header-actions">
						<li class="dropdown"></li>
						<li class="dropdown">
							<a href="#" id="notifications" data-toggle="dropdown" aria-haspopup="true">
								<i class="icon-bell"></i>
								<span
									class="count-label"><?php //echo count($notification); // count($notificationmax); ?></span>
							</a>
							<div class="dropdown-menu dropdown-menu-right lrg" aria-labelledby="notifications">
								<div class="dropdown-menu-header">
									Notifications
								</div>
								<div class="customScroll5 quickscard">
									<ul class="header-notifications"></ul>
								</div>
							</div>
						</li>
						<li class="dropdown">
							<a href="#" id="userSettings" class="user-settings" data-toggle="dropdown"
								aria-haspopup="true">
								<span class="user-name"><?php echo $fullname; ?></span>
								<span class="avatar">
									<img src="img/user22.png" alt="avatar">
									<span class="status busy"></span>
								</span>
							</a>
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userSettings">
								<div class="header-profile-actions">
									<div class="header-user-profile">
										<div class="header-user">
											<img src="img/user22.png" alt="Admin Template">
										</div>
										<h5><?php echo $fullname; ?></h5>
										<p><?php echo $fullname; ?></p>
									</div>
									<a href="#"><i class="icon-user1"></i> My Profile</a>
									<a href="logout.php"><i class="icon-log-out1"></i> Sign Out</a>
								</div>
							</div>
						</li>
					</ul>
					<!-- Header actions end -->
				</div>
			</header>
			<!-- Header end -->
			
			<!-- Dashboard -->
			<?php if($current_page == 'dashboard') { ?>
			<?php include "include/templates/dashboard.php" ?>
			<?php } ?>
			
			<!-- company Creation -->
			<?php if($current_page == 'company_creation') { ?>
			<?php include "include/templates/company_creation.php" ?>
			<?php } ?>

			<?php if($current_page == 'edit_company_creation') { ?>
			<?php include "include/templates/edit_company_creation.php" ?>
			<?php } ?>
			<!-- Branch Creation -->
			<?php if($current_page == 'branch_creation') { ?>
			<?php include "include/templates/branch_creation.php" ?>
			<?php } ?>

			<?php if($current_page == 'edit_branch_creation') { ?>
			<?php include "include/templates/edit_branch_creation.php" ?>
			<?php } ?>

			<!-- Holiday Creation -->
			<?php if($current_page == 'holiday_creation') { ?>
			<?php include "include/templates/holiday_creation.php" ?>
			<?php } ?>

			<?php if($current_page == 'edit_holiday_creation') { ?>
			<?php include "include/templates/edit_holiday_creation.php" ?>
			<?php } ?>

			<!-- Tag Creation -->
			<?php if($current_page == 'tag_creation') { ?>
			<?php include "include/templates/tag_creation.php" ?>
			<?php } ?>

			<?php if($current_page == 'edit_tag_creation') { ?>
			<?php include "include/templates/edit_tag_creation.php" ?>
			<?php } ?>

			<!-- Staff Creation -->
			<?php if($current_page == 'staff_creation') { ?>
			<?php include "include/templates/staff_creation.php" ?>
			<?php } ?>

			<?php if($current_page == 'edit_staff_creation') { ?>
			<?php include "include/templates/edit_staff_creation.php" ?>
			<?php } ?>

			<!--Hierarchy Creation -->
			<?php if($current_page == 'hierarchy_creation') { ?>
			<?php include "include/templates/hierarchy_creation.php" ?>
			<?php } ?>

			<?php if($current_page == 'edit_hierarchy_creation') { ?>
			<?php include "include/templates/edit_hierarchy_creation.php" ?>
			<?php } ?>

			<!--Basic Creation -->
			<?php if($current_page == 'basic_creation') { ?>
			<?php include "include/templates/basic_creation.php" ?>
			<?php } ?>

			<?php if($current_page == 'edit_basic_creation') { ?>
			<?php include "include/templates/edit_basic_creation.php" ?>
			<?php } ?>

			<!--Rolse Responsibility Creation -->
			<?php if($current_page == 'roles_responsibility_creation') { ?>
			<?php include "include/templates/roles_responsibility_creation.php" ?>
			<?php } ?>

			<?php if($current_page == 'edit_roles_responsibility') { ?>
			<?php include "include/templates/edit_roles_responsibility.php" ?>
			<?php } ?>

			<!--KRA & KPI Creation -->
			<?php if($current_page == 'krakpi_creation') { ?>
			<?php include "include/templates/krakpi_creation.php" ?>
			<?php } ?>

			<?php if($current_page == 'edit_krakpi_creation') { ?>
			<?php include "include/templates/edit_krakpi_creation.php" ?>
			<?php } ?>

			<!-- Audit Area Creation -->
			<?php if($current_page == 'audit_area_creation') { ?>
			<?php include "include/templates/audit_area_creation.php" ?>
			<?php } ?>

			<?php if($current_page == 'edit_audit_area_creation') { ?>
			<?php include "include/templates/edit_audit_area_creation.php" ?>
			<?php } ?>

			<!-- Audit Check List -->
			<?php if($current_page == 'audit_checklist') { ?>
			<?php include "include/templates/audit_checklist.php" ?>
			<?php } ?>

			<?php if($current_page == 'edit_audit_area_checklist') { ?>
			<?php include "include/templates/edit_audit_area_checklist.php" ?>
			<?php } ?>

			<!-- Audit Assign -->
			<?php if($current_page == 'audit_assign') { ?>
			<?php include "include/templates/audit_assign.php" ?>
			<?php } ?>

			<?php if($current_page == 'edit_audit_assign') { ?>
			<?php include "include/templates/edit_audit_assign.php" ?>
			<?php } ?>

			<!-- Report Template -->
            <?php if($current_page == 'report_template') { ?>
            <?php include "include/templates/report_template.php" ?>
            <?php } ?>
			
            <!-- Media Master -->
            <?php if($current_page == 'media_master') { ?>
            <?php include "include/templates/media_master.php" ?>
            <?php } ?>

            <?php if($current_page == 'edit_media_master') { ?>
            <?php include "include/templates/edit_media_master.php" ?>
            <?php } ?>

            <!-- KRA Creation -->
            <?php if($current_page == 'kra_creation') { ?>
            <?php include "include/templates/kra_creation.php" ?>
            <?php } ?>

            <!-- Edit KRA Creation -->
            <?php if($current_page == 'edit_kra_creation') { ?>
            <?php include "include/templates/edit_kra_creation.php" ?>
            <?php } ?>

			<!-- Assign Work -->
            <?php if($current_page == 'assign_work') { ?>
            <?php include "include/templates/assign_work.php" ?>
            <?php } ?>
			
			<!-- Assign Work List -->
            <?php if($current_page == 'edit_assign_work') { ?>
            <?php include "include/templates/edit_assign_work.php" ?>
            <?php } ?>
			
			<!-- Assigned Work Calendar view -->
            <?php if($current_page == 'assigned_work') { ?>
            <?php include "include/templates/assigned_work.php" ?>
            <?php } ?>
			
			<!-- Asset Register -->
            <?php if($current_page == 'asset_register') { ?>
            <?php include "include/templates/asset_register.php" ?>
            <?php } ?>
			
			<!-- Insurance Register -->
            <?php if($current_page == 'insurance_register') { ?>
            <?php include "include/templates/insurance_register.php" ?>
            <?php } ?>
			
            <?php if($current_page == 'edit_insurance_register') { ?>
            <?php include "include/templates/edit_insurance_register.php" ?>
            <?php } ?>
			
			<!-- Todo -->
            <?php if($current_page == 'todo') { ?>
            <?php include "include/templates/todo.php" ?>
            <?php } ?>

            <?php if($current_page == 'edit_todo') { ?>
            <?php include "include/templates/edit_todo.php" ?>
            <?php } ?>

			<!-- Memo -->
            <?php if($current_page == 'memo') { ?>
            <?php include "include/templates/memo.php" ?>
            <?php } ?>

            <?php if($current_page == 'memo_assigned') { ?>
            <?php include "include/templates/memo_assigned.php" ?>
            <?php } ?>

            <?php if($current_page == 'memo_update') { ?>
            <?php include "include/templates/memo_update.php" ?>
            <?php } ?>

            <?php if($current_page == 'edit_memo') { ?>
            <?php include "include/templates/edit_memo.php" ?>
            <?php } ?>

            <?php if($current_page == 'edit_memo_assigned') { ?>
            <?php include "include/templates/edit_memo_assigned.php" ?>
            <?php } ?>

            <?php if($current_page == 'edit_memo_update') { ?>
            <?php include "include/templates/edit_memo_update.php" ?>
            <?php } ?>

			<!-- service Indent -->
			<?php if($current_page == 'service_indent') { ?>
			<?php include "include/templates/service_indent.php" ?>
            <?php } ?>
			
            <?php if($current_page == 'edit_service_indent') { ?>
            <?php include "include/templates/edit_service_indent.php" ?>
            <?php } ?>

			<!--Memo Status -->
            <?php if($current_page == 'memo_status') { ?>
            <?php include "include/templates/memo_status.php" ?>
            <?php } ?>
			
            <?php if($current_page == 'edit_memo_status') { ?>
            <?php include "include/templates/edit_memo_status.php" ?>
			<?php } ?>
			
			<!--Audit Details -->
            <?php if($current_page == 'asset_details') { ?>
            <?php include "include/templates/asset_details.php" ?>
            <?php } ?>
			
            <?php if($current_page == 'edit_asset_details') { ?>
            <?php include "include/templates/edit_asset_details.php" ?>
            <?php } ?>
			
			<!--RGP Creation -->
            <?php if($current_page == 'rgp_creation') { ?>
            <?php include "include/templates/rgp_creation.php" ?>
            <?php } ?>
			
			<!--RGP Creation -->
            <?php if($current_page == 'edit_rgp_creation') { ?>
            <?php include "include/templates/edit_rgp_creation.php" ?>
            <?php } ?> 

			<!-- Org Chart -->
            <?php if($current_page == 'org_chart') { ?>
            <?php include "include/templates/org_chart.php" ?>
            <?php } ?>

			<!-- Permission or on duty -->
            <?php if($current_page == 'permission_or_on_duty') { ?>
            <?php include "include/templates/permission_or_on_duty.php" ?>
            <?php } ?>

            <?php if($current_page == 'edit_permission_or_on_duty') { ?>
            <?php include "include/templates/edit_permission_or_on_duty.php" ?>
            <?php } ?>

			<!-- Transfer location -->
            <?php if($current_page == 'transfer_location') { ?>
            <?php include "include/templates/transfer_location.php" ?>
            <?php } ?>

            <?php if($current_page == 'edit_transfer_location') { ?>
            <?php include "include/templates/edit_transfer_location.php" ?>
            <?php } ?>

			<!-- PM Checklist -->
            <?php if($current_page == 'pm_checklist') { ?>
            <?php include "include/templates/pm_checklist.php" ?>
            <?php } ?>

            <?php if($current_page == 'edit_pm_checklist') { ?>
            <?php include "include/templates/edit_pm_checklist.php" ?>
            <?php } ?>

			<!-- BM Checklist -->
            <?php if($current_page == 'bm_checklist') { ?>
            <?php include "include/templates/bm_checklist.php" ?>
            <?php } ?>

            <?php if($current_page == 'edit_bm_checklist') { ?>
            <?php include "include/templates/edit_bm_checklist.php" ?>
            <?php } ?>

			<!-- Business communication outgoing -->
            <?php if($current_page == 'business_com_out') { ?>
            <?php include "include/templates/business_com_out.php" ?>
            <?php } ?>

            <?php if($current_page == 'edit_business_com_out') { ?>
            <?php include "include/templates/edit_business_com_out.php" ?>
            <?php } ?>

            <?php if($current_page == 'business_com_approval_line') { ?>
            <?php include "include/templates/business_com_approval_line.php" ?>
            <?php } ?>

			<?php if($current_page == 'edit_business_com_approval_line') { ?>
            <?php include "include/templates/edit_business_com_approval_line.php" ?>
            <?php } ?>

			<!-- Approval Requisition -->
            <?php if($current_page == 'approval_requisition') { ?>
            <?php include "include/templates/approval_requisition.php" ?>
            <?php } ?>

            <?php if($current_page == 'edit_approval_requisition') { ?>
            <?php include "include/templates/edit_approval_requisition.php" ?>
            <?php } ?>

			<!-- Approval Line -->
            <?php if($current_page == 'approval_line') { ?>
            <?php include "include/templates/approval_line.php" ?>
            <?php } ?>

            <?php if($current_page == 'edit_approval_line') { ?>
            <?php include "include/templates/edit_approval_line.php" ?>
            <?php } ?>
			
			<!-- Meeting Minutes -->
            <?php if($current_page == 'meeting_minutes') { ?>
            <?php include "include/templates/meeting_minutes.php" ?>
            <?php } ?>

            <?php if($current_page == 'edit_meeting_minutes') { ?>
            <?php include "include/templates/edit_meeting_minutes.php" ?>
            <?php } ?>

			<!-- Minutes Meeting Approval Line -->
            <?php if($current_page == 'meeting_minutes_approval_line') { ?>
            <?php include "include/templates/meeting_minutes_approval_line.php" ?>
            <?php } ?>

            <?php if($current_page == 'edit_meeting_minutes_approval_line') { ?>
            <?php include "include/templates/edit_meeting_minutes_approval_line.php" ?>
            <?php } ?>

			<!-- Maintenance Checklist -->
            <?php if($current_page == 'maintenance_checklist') { ?>
            <?php include "include/templates/maintenance_checklist.php" ?>
            <?php } ?>

            <?php if($current_page == 'edit_maintenance_checklist') { ?>
            <?php include "include/templates/edit_maintenance_checklist.php" ?>
            <?php } ?>

			<!-- Periodic Level -->
            <?php if($current_page == 'periodic_level') { ?>
            <?php include "include/templates/periodic_level.php" ?>
            <?php } ?>
			
            <?php if($current_page == 'edit_periodic_level') { ?>
            <?php include "include/templates/edit_periodic_level.php" ?>
            <?php } ?>

			<!-- Vehicle Details -->
            <?php if($current_page == 'vehicle_details') { ?>
            <?php include "include/templates/vehicle_details.php" ?>
            <?php } ?>

            <?php if($current_page == 'edit_vehicle_details') { ?>
            <?php include "include/templates/edit_vehicle_details.php" ?>
            <?php } ?>

			<!-- Daily KM -->
            <?php if($current_page == 'daily_km') { ?>
            <?php include "include/templates/daily_km.php" ?>
            <?php } ?>

            <?php if($current_page == 'edit_daily_km') { ?>
            <?php include "include/templates/edit_daily_km.php" ?>
            <?php } ?>

			<!-- Diesel Slip -->
            <?php if($current_page == 'diesel_slip') { ?>
            <?php include "include/templates/diesel_slip.php" ?>
            <?php } ?>

            <?php if($current_page == 'edit_diesel_slip') { ?>
            <?php include "include/templates/edit_diesel_slip.php" ?>
            <?php } ?>

			<!-- Diesel Slip -->
            <?php if($current_page == 'auditee_response') { ?>
            <?php include "include/templates/auditee_response.php" ?>
            <?php } ?>

            <?php if($current_page == 'edit_auditee_response') { ?>
            <?php include "include/templates/edit_auditee_response.php" ?>
            <?php } ?>

			<!-- Diesel Slip -->
            <?php if($current_page == 'campaign') { ?>
            <?php include "include/templates/campaign.php" ?>
            <?php } ?>

            <?php if($current_page == 'edit_campaign') { ?>
            <?php include "include/templates/edit_campaign.php" ?>
            <?php } ?>

			<!-- Promotional Activities -->
			<?php if($current_page == 'promotional_activities') { ?>
			<?php include "include/templates/promotional_activities.php" ?>
			<?php } ?>

			<?php if($current_page == 'edit_promotional_activities') { ?>
			<?php include "include/templates/edit_promotional_activities.php" ?>
			<?php } ?>

			<!-- Audit Followup -->
			<?php if($current_page == 'audit_followup') { ?>
			<?php include "include/templates/audit_followup.php" ?>
			<?php } ?>

			<!-- Target Fixing -->
			<?php if($current_page == 'target_fixing') { ?>
			<?php include "include/templates/target_fixing.php" ?>
			<?php } ?>

			<?php if($current_page == 'edit_target_fixing') { ?>
			<?php include "include/templates/edit_target_fixing.php" ?>
			<?php } ?>

			<?php if($current_page == 'view_target_fixing') { ?>
			<?php include "include/templates/view_target_fixing.php" ?>
			<?php } ?>

			<!-- goal_setting -->
			<?php if($current_page == 'goal_setting') { ?>
			<?php include "include/templates/goal_setting.php" ?>
			<?php } ?>

			<?php if($current_page == 'edit_goal_setting') { ?>
			<?php include "include/templates/edit_goal_setting.php" ?>
			<?php } ?>

      		<!-- daily_performance -->
			<?php if($current_page == 'daily_performance') { ?>
			<?php include "include/templates/daily_performance.php" ?>
			<?php } ?>

			<?php if($current_page == 'edit_daily_performance') { ?>
			<?php include "include/templates/edit_daily_performance.php" ?>
			<?php } ?>

			<!-- appreciation_depreciation -->
			<?php if($current_page == 'appreciation_depreciation') { ?>
			<?php include "include/templates/appreciation_depreciation.php" ?>
			<?php } ?>

			<?php if($current_page == 'edit_appreciation_depreciation') { ?>
			<?php include "include/templates/edit_appreciation_depreciation.php" ?>
			<?php } ?>

			<?php if($current_page == 'view_appreciation_depreciation') { ?>
			<?php include "include/templates/view_appreciation_depreciation.php" ?>
			<?php } ?>

			<?php if($current_page == 'view_midterm_review') { ?>
			<?php include "include/templates/view_midterm_review.php" ?>
			<?php } ?>

			<!-- appreciation_depreciation -->
			<?php if($current_page == 'manage_users') { ?>
			<?php include "include/templates/manage_users.php" ?>
			<?php } ?>

			<?php if($current_page == 'edit_user') { ?>
			<?php include "include/templates/edit_user.php" ?>
			<?php } ?>
			
		</div>
		<!-- Page content end -->

	</div>
	<!-- Page wrapper end -->

	<!-- Important -->
	<!-- This the important section for download excel file and script adding with our screen -->
	<?php if( $current_page != 'vendorcreation') { ?>
	<?php include "include/common/dashboardfooter.php"?>
	<?php } ?>

	<?php
		if($current_page == 'vendorcreation') { ?>
	<?php include "include/common/dashboardfinancedatatablefooter.php" ?>
	<?php } ?>
	
	
</body>

</html>