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

	/* On mouse-over */
	.sidenav a:hover, .dropdown-btn1:hover {
	color: #5090c0;
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
					<li class="sidebar-dropdown">
						<a href="javascript:void(0)">
							<i class="icon-user"></i>
							<span class="menu-text">Administration</span>
						</a>
						<div class="sidebar-submenu">
							<ul>				
								<li>									
									<a href="dashboard"><i class="icon-devices_other"></i>Dashboard</a>
								</li>
								<li>									
									<a href="edit_company_creation"><i class="icon-store_mall_directory"></i>Company Creation</a>
								</li>
								<li>									
									<a href="edit_branch_creation"><i class="icon-git-branch"></i>Branch Creation</a>
								</li>
								<li>									
									<a href="edit_holiday_creation"><i class="icon-aperture"></i>Holiday Creation</a>
								</li>
								<!-- <li>									
									<a href="manage_users"><i class="icon-users"></i>Manage Users</a>
								</li> -->
							</ul>
						</div>
					</li>

					<li class="sidebar-dropdown">
						<a href="javascript:void(0)">
							<i class="icon-layers2"></i>
							<span class="menu-text">Master</span>
						</a>
						<div class="sidebar-submenu">
							<ul>
								<li class="sidebar-dropdown1">
									<a href="javascript:void(0)">
										<i class="icon-dehaze"></i>
										<span class="menu-text" >Basic</span>
									</a>
									<div class="sidebar-submenu1">
										<ul>
											<li>
												<a href="edit_basic_creation"><i class="icon-playlist_add"></i>Basic Creation</a>
											</li>
											<li>
												<a href="edit_tag_creation"><i class="icon-price-tag"></i>Tag Creation</a>
											</li>	
											<!-- <li>
												<a href="edit_hierarchy_creation"><i class="icon-tonality"></i>Hierarcy Creation</a>	
											</li> -->
										</ul>
									</div>	
								</li>
								<li class="sidebar-dropdown1">
									<a href="javascript:void(0)">
										<i class="icon-thumb_up"></i>
										<span class="menu-text" >Responsibility</span>
									</a>
									<div class="sidebar-submenu1">
										<ul>
											<li>
												<a href="edit_roles_responsibility"><i class="icon-briefcase"></i>R & R Creation</a>	
											</li>
											<li>
												<a href="edit_kra_creation"><i class="icon-git-merge"></i>KRA Category</a>	
											</li>
											<li>
												<a href="edit_krakpi_creation"><i class="icon-git-pull-request"></i>KRA & KPI Creation</a>	
											</li>
											<li>
												<a href="edit_staff_creation"><i class="icon-user-plus"></i>Staff Creation</a>
											</li>
										</ul>
									</div>	
								</li>
								<li class="sidebar-dropdown1">
									<a href="javascript:void(0)">
										<i class="icon-rate_review"></i>
										<span class="menu-text" >Audit</span>
									</a>
									<div class="sidebar-submenu1">
										<ul>
											<li>
												<a href="edit_audit_area_creation"><i class="icon-codepen"></i>Audit Area Creation</a>	
											</li>
											<li>
												<a href="edit_audit_area_checklist"><i class="icon-compass"></i>Audit Area Check List</a>	
											</li>
											<li>
												<a href="edit_audit_assign"><i class="icon-compass"></i>Audit Assign</a>	
											</li>
											<!-- <li>
												<a href="auditee_response"><i class="icon-compass"></i>Auditee Response</a>	
											</li> -->
											<li>
												<a href="audit_followup"><i class="icon-compass"></i>Audit Follow Up</a>	
											</li>
										</ul>
									</div>	
								</li>
								<li class="sidebar-dropdown1">
									<a href="javascript:void(0)">
										<i class="icon-devices_other"></i>
										<span class="menu-text" >Others</span>
									</a>
									<div class="sidebar-submenu1">
										<ul>
											<li>
												<a href="report_template"><i class="icon-signal_cellular_4_bar"></i>Report Template</a>
											</li>
											<li>
												<a href="edit_media_master"><i class="icon-film"></i>Media Master</a>
											</li>
											<li>
												<a href="asset_register"><i class="icon-map2"></i>Asset Creation</a>
											</li>
											<li>
												<a href="edit_insurance_register"><i class="icon-offline_pin"></i>Insurance register</a>
											</li>
											<li>
												<a href="edit_service_indent"><i class="icon-slack"></i>Service Indent</a>
											</li>
											<li>
												<a href="edit_asset_details"><i class="icon-signal_cellular_4_bar"></i>Asset Details</a>
											</li>
											<li>
												<a href="edit_rgp_creation"><i class="icon-pie_chart"></i>RGP Creation</a>
											</li>
											<li>
												<a href="edit_promotional_activities"><i class="icon-pie_chart"></i>Promotional Activities</a>
											</li>
										</ul>
									</div>	
								</li>
							</ul>
						</div>
					</li>
					<!-- Workforce Menu -->
					<li class="sidebar-dropdown">
						<a href="javascript:void(0)">
							<i class="icon-target"></i>
							<span class="menu-text">Work Force</span>
						</a>
						<div class="sidebar-submenu">
							<ul>
								<li class="sidebar-dropdown1">
									<a href="javascript:void(0)">
										<i class="icon-file"></i>
										<span class="menu-text" >Schedule Task</span>
									</a>
									<div class="sidebar-submenu1">
										<ul>
											<li>
												<a href="edit_campaign"><i class="icon-archive"></i>Campaign</a>
											</li>
											<li>
												<a href="edit_assign_work"><i class="icon-archive"></i>Assign Work</a>
											</li>
											<li>
												<a href="edit_todo"><i class="icon-today"></i>To Do</a>
											</li>
											<li>
												<a href="assigned_work"><i class="icon-calendar"></i>Assigned Work</a>
											</li>
										</ul>
									</div>		
								</li>
								<li class="sidebar-dropdown1">
									<a href="javascript:void(0)">
										<i class="icon-ring_volume"></i>
										<span class="menu-text">Memo</span>
									</a>
									<div class="sidebar-submenu1">
										<ul>
											<li>
												<a href="edit_memo"><i class="icon-ring_volume"></i>Memo Initiate</a>
											</li>
											<li>
												<a href="edit_memo_assigned"><i class="icon-ring_volume"></i>Memo Assigned</a>
											</li>
											<li>
												<a href="edit_memo_update"><i class="icon-ring_volume"></i>Memo Update</a>
											</li>
											<!-- <li>
												<a href="org_chart"><i class="icon-pie-chart"></i>Organization Chart</a>
											</li> -->
										</ul>
									</div>		
								</li>
							</ul>
						</div>
					</li>

					<!-- Maintenance -->
					<li class="sidebar-dropdown1">
						<a href="javascript:void(0)">
							<i class="icon-file-text"></i>
							<span class="menu-text" >Maintenance</span>
						</a>
						<div class="sidebar-submenu1">
							<ul>
								<li>
									<a href="edit_pm_checklist"><i class="icon-menu1"></i>PM Checklist</a>	
								</li>
								<li>
									<a href="edit_bm_checklist"><i class="icon-menu1"></i>BM Checklist</a>	
								</li>
								<li>
									<a href="edit_maintenance_checklist"><i class="icon-list2"></i>Maintenance Checklist</a>	
								</li>
								<!-- <li>
									<a href="edit_periodic_level"><i class="icon-list2"></i>Periodic Level</a>	
								</li> -->
							</ul>
						</div>	
					</li>

					<!-- approval mechanism -->
					<li class="sidebar-dropdown1">
						<a href="javascript:void(0)">
							<i class="icon-people_outline"></i>
							<span class="menu-text" >Manpower In & Out</span>
						</a>
						<div class="sidebar-submenu1">
							<ul>
								<li>
									<a href="edit_permission_or_on_duty"><i class="icon-receipt"></i>Permission / On duty</a>	
								</li>
								<li>
									<a href="edit_transfer_location"><i class="icon-recent_actors"></i>Transfer Location</a>	
								</li>
							</ul>
						</div>	
					</li>


					<!-- Target Fixing -->
					<li class="sidebar-dropdown1">
											<a href="javascript:void(0)">
												<i class="icon-target"></i>
												<span class="menu-text" >Target Fixing</span>
											</a>
											<div class="sidebar-submenu1">
												<ul>
													<li>
														<a href="edit_goal_setting"><i class="icon-receipt"></i>Goal Setting</a>	
													</li>
													<li>
														<a href="target_fixing"><i class="icon-recent_actors"></i>Target Fixing</a>	
													</li>
													<li>
														<a href="daily_performance"><i class="icon-file"></i>Daily Performance</a>	
													</li>
													<li>
														<a href="appreciation_depreciation"><i class="icon-thumb_up"></i>Appreciation And Depreciation</a>	
													</li>
												</ul>
											</div>	
										</li>


					<!-- vehicle management -->
					<li class="sidebar-dropdown1">
						<a href="javascript:void(0)">
							<i class="icon-directions_bus"></i>
							<span class="menu-text" >Vehicle Management</span>
						</a>
						<div class="sidebar-submenu1">
							<ul>
								<li>
									<a href="edit_vehicle_details"><i class="icon-time_to_leave"></i>Vehicle Details</a>	
								</li>
								<li>
									<a href="edit_daily_km"><i class="icon-local_car_wash"></i>Daily KM </a>	
								</li>
								<li>
									<a href="diesel_slip"><i class="icon-local_car_wash"></i>Diesel Slip </a>	
								</li>
							</ul>
						</div>	
					</li>

					<!-- approval mechanism -->
					<li class="sidebar-dropdown1">
						<a href="javascript:void(0)">
							<i class="icon-center_focus_strong"></i>
							<span class="menu-text" >Approval Mechanism</span>
						</a>
						<div class="sidebar-submenu1">
							<ul>
								<li>
									<a href="edit_approval_requisition"><i class="icon-card_travel"></i>Approval Requisition</a>	
								</li>
								<li>
									<a href="edit_business_com_out"><i class="icon-redeem"></i>Business Communication - Outgoing</a>	
								</li>
								<li>
									<a href="edit_meeting_minutes"><i class="icon-redeem"></i>Minutes Of Meeting</a>	
								</li>
							</ul>
						</div>	
					</li>

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
