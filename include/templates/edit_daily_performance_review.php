<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];

$CompanyroleDetail = $userObj->getsroleDetail($mysqli, $userid);
for($j=0;$j<count($CompanyroleDetail);$j++) {
		$logrole            = $CompanyroleDetail['role'];
		$logtitle           = $CompanyroleDetail['title'];
		$company_id         = $CompanyroleDetail['company_id'];
		$company_name         = $CompanyroleDetail['company_name'];
}
} ?>
<input type="hidden" id="logrole" class="logrole" value="<?php 	echo $logrole;       ?>" >
<input type="hidden" id="logtitle" class="logtitle" value="<?php 	echo $logtitle;      ?>" >
<input type="hidden" id="company_id" class="company_id" value="<?php 	echo $company_id;    ?>" >
<input type="hidden" id="company_name" class="company_name" value="<?php echo $company_name;    ?>" >
<!-- Page header start -->
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item">Daily Performance Review List</li>
	</ol>
	<?php #if($logrole == '1' || $logrole == '3'){ ?>
		<a href="daily_performance_review">
		<button type="button" tabindex="1"  class="btn btn-primary backb"><span class="icon-add"></span>&nbsp Daily Performance Review</button>
	</a>
	<?php 
	// }

	if($logrole == '1' || $logrole == '3' ){ 
		echo '<style>.View_goal_setting { display: none; }</style>'; 
		
	}else{
		echo '<style>.edpage { display: none; }</style>'; 
		echo '<style>.icon-trash-2 { display: none; }</style>'; 
	} ?>
	
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
	<!-- Row start -->
	<div class="row gutters">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="table-container">

				<div class="table-responsive">
					<?php
					$mscid=0;
					if(isset($_GET['msc']))
					{
					$mscid=$_GET['msc'];
					if($mscid==1)
					{?>
					<div class="alert alert-success" role="alert">
						<div class="alert-text">Daily Performance Added Successfully!</div>
					</div> 
					<?php
					}
					if($mscid==2)
					{?>
						<div class="alert alert-success" role="alert">
						<div class="alert-text">Daily Performance Updated Successfully!</div>
					</div>
					<?php
					}
					if($mscid==3)
					{?>
					<div class="alert alert-danger" role="alert">
						<div class="alert-text">Daily Performance Inactive Successfully!</div>
					</div>
					<?php
					}
					}
					?>
					<table id="daily_performance_review_fetch" class="table custom-table">
						<thead>
							<tr>
								<th>S. No.</th>
								<th>Company Name</th>
								<th>Department Name</th>
								<th>Role</th>
								<th>Employee Name</th>
								<th>Month</th>
								<th>Status</th>
								<th colspan="1">Action</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- Row end -->
</div>
<!-- Main container end -->

<script>
	setTimeout(function() {
		$('.alert').fadeOut('slow');
	}, 2000);


    
</script>

