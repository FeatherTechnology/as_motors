<!-- Page header start -->
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item">Vehicle Details</li>
	</ol>
	<a href="vehicle_details">
		<button type="button" tabindex="1" class="btn btn-primary"><span class="icon-add"></span>&nbsp Vehicle Details</button>
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
                            <div class="alert-text">Vehicle Details Added Successfully!</div>
                        </div> 
                        <?php
                        }
                        if($mscid==2)
                        {?>
                            <div class="alert alert-success" role="alert">
                            <div class="alert-text">Vehicle Details Updated Successfully!</div>
                        </div>
                        <?php
                        }
                        if($mscid==3)
                        {?>
                        <div class="alert alert-danger" role="alert">
                            <div class="alert-text">Vehicle Details Inactive Successfully!</div>
                        </div>
                        <?php
                        }
					}
					?>
					<table id="vehicleDetails_info" class="table custom-table">
						<thead>
							<tr>
								<th>S. No.</th>
								<th>Company Name</th>
								<th>Branch Name</th>
								<th>Vehicle Code</th>
								<th>Vehicle Name</th>
								<th>Vehicle Number</th>
								<th>Date Of Purchase</th>
								<th>Fitment Upto</th>
								<th>Insurance Upto</th>
								<th>Asset Value</th>
								<th>Book Value As On</th>
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

