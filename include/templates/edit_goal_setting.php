<!-- Page header start -->
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item">Goal Setting List</li>
	</ol>
	<a href="goal_setting">
		<button type="button" tabindex="1"  class="btn btn-primary"><span class="icon-add"></span>&nbsp Goal Setting Creation</button>
	</a>
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
						<div class="alert-text">Audit Assign Added Successfully!</div>
					</div> 
					<?php
					}
					if($mscid==2)
					{?>
						<div class="alert alert-success" role="alert">
						<div class="alert-text">Audit Assign Updated Successfully!</div>
					</div>
					<?php
					}
					if($mscid==3)
					{?>
					<div class="alert alert-danger" role="alert">
						<div class="alert-text">Audit Assign Inactive Successfully!</div>
					</div>
					<?php
					}
					}
					?>
					<table id="goal_setting_infoDashboard" class="table custom-table">
						<thead>
							<tr>
								<th>S. No.</th>
								<th>Company Name</th>
								<th>Department Name</th>
								 <th>Role</th>
								<th>year</th>
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

