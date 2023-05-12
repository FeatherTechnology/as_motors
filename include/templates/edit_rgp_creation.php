<!-- Page header start -->
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item">RGP List</li>
	</ol>
	<a href="rgp_creation">
		<button type="button" tabindex="1"  class="btn btn-primary"><span class="icon-add"></span>&nbsp; Add RGP</button>
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
						<div class="alert-text">RGP Added Successfully!</div>
					</div> 
					<?php
					}
					if($mscid==2)
					{?>
						<div class="alert alert-success" role="alert">
						<div class="alert-text">RGP Updated Successfully!</div>
					</div>
					<?php
					}
					if($mscid==3)
					{?>
					<div class="alert alert-danger" role="alert">
						<div class="alert-text" >RGP Inactive Successfully!</div>
					</div>
					<?php
					}
					if($mscid==4)
					{?>
					<div class="alert alert-success" role="alert">
						<div class="alert-text" >RGP Inwarded Successfully!</div>
					</div>
					<?php
					}
					}
					?>
					<table id="rgp_table" class="table custom-table">
						<thead>
							<tr>
								<th width='5%'>S. No.</th>
								<th width='6%'>Asset Classification</th>
								<th width='8%'>From Branch</th>
								<th width='8%'>To Branch</th>
								<th width='6%'>RGP Date</th>
								<th width='6%'>Return Date</th>
								<th width='4%'>Asset Name</th>
								<th width='4%'>Asset Value</th>
								<th>Reason for RGP</th>
								<th width='4%'>Extended Date</th>
								<th>Extended Reason</th>
								<th width='4%'>Extend Status</th>
								<th width='5%'>Status</th>
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
<div id="printrgp" style="display: none"></div>

<script>
	setTimeout(function() {
		$('.alert').fadeOut('slow');
	}, 2000);
</script>
