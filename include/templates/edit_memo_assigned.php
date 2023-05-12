<!-- Page header start -->
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item">Memo Assigned List</li>
	</ol>
	<!-- <a href="memo_assigned">
		<button type="button" tabindex="1"  class="btn btn-primary"><span class="icon-add"></span>&nbsp Update Memo Assigned</button>
	</a> -->
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
						<div class="alert-text">Memo Assigned Added Successfully!</div>
					</div> 
					<?php
					}
					if($mscid==2)
					{?>
						<div class="alert alert-success" role="alert">
						<div class="alert-text">Memo Assigned Updated Successfully!</div>
					</div>
					<?php
					}
					if($mscid==3)
					{?>
					<div class="alert alert-danger" role="alert">
						<div class="alert-text">Memo Assigned Inactive Successfully!</div>
					</div>
					<?php
					}
					}
					?>
					<table id="memo_assigned_info" class="table custom-table">
						<thead>
							<tr>
								<th>S. No.</th>
								<th>Company Name</th>
								<th>To Department</th>
								<th>Assign Employee</th>
								<th>Priority</th>
								<th>Inquiry</th>
								<th>Suggestion</th>
								<th>Attachment</th>
								<th>Target Date For Completion</th>
								<th>Initial Phase</th>
								<th>Final Phase</th>
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

