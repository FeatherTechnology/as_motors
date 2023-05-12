<!-- Page header start -->
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item">Audit Area List</li>
	</ol>
	<a href="audit_area_creation">
		<button type="button" tabindex="1"  class="btn btn-primary"><span class="icon-add"></span>&nbsp Add Audit Area Creation</button>
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
						<div class="alert-text">Audit Area Added Successfully!</div>
					</div> 
					<?php
					}
					if($mscid==2)
					{?>
						<div class="alert alert-success" role="alert">
						<div class="alert-text">Audit Area Updated Successfully!</div>
					</div>
					<?php
					}
					if($mscid==3)
					{?>
					<div class="alert alert-danger" role="alert">
						<div class="alert-text">Audit Area Inactive Successfully!</div>
					</div>
					<?php
					}
					}
					?>
					<table id="auditareaCreation_info" class="table custom-table">
						<thead>
							<tr>
								<th>S. No.</th>
								<th>Audit Area</th>
								<th>Department Name</th>
								<th>Frequency</th>
								<th>Calendar</th>
								<th>From Date</th>
								<th>To Date</th>
								<th>Role 1</th>
								<th>Role 2</th>
								<th>Check List</th>
								<th>Status</th>
								<th>Action</th>
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

