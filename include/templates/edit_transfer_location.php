<!-- Page header start -->
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item">Transfer Location List</li>
	</ol>
	<a href="transfer_location">
		<button type="button" tabindex="1"  class="btn btn-primary"><span class="icon-add"></span>&nbsp; Transfer Location List</button>
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
						<div class="alert-text">Transfer Location Added Successfully!</div>
					</div> 
					<?php
					}
					if($mscid==2)
					{?>
						<div class="alert alert-success" role="alert">
						<div class="alert-text">Transfer Location Updated Successfully!</div>
					</div>
					<?php
					}
					if($mscid==3)
					{?>
					<div class="alert alert-danger" role="alert">
						<div class="alert-text">Transfer Location Inactive Successfully!</div>
					</div>
					<?php
					}
					}
					?>
					<table id="transfer_location_info" class="table custom-table">
						<thead>
							<tr>
								<th>S. No.</th>
								<th>Company Name</th>
								<th>Branch Name</th>
								<th>Department</th>
								<th>Staff Code</th>
								<th>Staff Name</th>
								<th>DOT</th>
								<th>Transfer Location</th>
								<th>Transfer Effective From</th>
								<th>File</th>
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

<div id="printTransferLocation" style="display: none"></div>

<script>
	setTimeout(function() {
		$('.alert').fadeOut('slow');
	}, 2000);
</script>

	

