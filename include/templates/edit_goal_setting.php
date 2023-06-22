<?php if(isset($_SESSION["branch_id"])){

$sbranch_id = $_SESSION["branch_id"];
// $sCompanyBranchDetail = $userObj->getsCompanyBranchDetail($mysqli, $sbranch_id);
$CompanyroleDetail = $userObj->getsroleDetail($mysqli, $sbranch_id);
for($j=0;$j<count($CompanyroleDetail);$j++) {
		$logrole            = $CompanyroleDetail['role'];
		$logtitle           = $CompanyroleDetail['title'];
		$company_id         = $CompanyroleDetail['company_id'];
	  $company_name         = $CompanyroleDetail['company_name'];
}
} 
// if(logtitle == 'Super Admin'){

// }else{
// $('.backb').css('display', 'none');
// if(logrole == '4'){
   
// 	var idupd = $('#id').val();

// 	if(idupd == '0'){ 
	   
// 		$('#prev').prop('disabled', true);
// 		var prev_company = $('#prev').val();
// 		insertData(prev_company);
	
// 	}else{
// 		// $('#prev').prop('disabled', true);
// 		// $('#dept').prop('disabled', true);
// 		// $('#designation').prop('disabled', true);
// 		// $('#dept').prop('disabled', true);
// 		// $('#syear').prop('disabled', true);
// 		$('#add_row_0').prop('disabled', true);
// 		$('#yes').prop('disabled', true);
// 		$('.form-control').prop('disabled', true);
// 		$('.add_row').prop('disabled', true);
// 		$('.icon-trash-2').prop('disabled', true);
// 		$('#execute').css('display', 'none');
// 		 $('#submit_audit_checklist').css('display', 'none');
		
		
// 	}
// }else{
	
//  }
// }  
?> 
<input type="hidden" id="logrole" class="logrole" value="<?php 	echo $logrole;       ?>" >
<input type="hidden" id="logtitle" class="logtitle" value="<?php 	echo $logtitle;      ?>" >
<input type="hidden" id="company_id" class="company_id" value="<?php 	echo $company_id;    ?>" >
<input type="hidden" id="company_name" class="company_name" value="<?php echo $company_name;    ?>" >
<!-- Page header start -->
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item">Goal Setting List</li>
	</ol>
<?php if($logtitle == 'Super Admin'){ ?>
	<a href="goal_setting">
		<button type="button" tabindex="1"  class="btn btn-primary backb"><span class="icon-add"></span>&nbsp Goal Setting Creation</button>
    </a>
	<?php echo '<style>.View_goal_setting { display: none; }</style>'; ?>
	<?php }else{ ?>
<?php echo '<style>.edpage { display: none; }</style>'; echo '<style>.icon-trash-2 { display: none; }</style>'; ?>

		<?php } ?>
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

// 	$(document).ready(function () {
//     var logrole = $('#logrole').val();
//     var logtitle= $('#logtitle').val();
//     if(logtitle == 'Super Admin'){
// 		console.log("qqqqqqqqqqqqqqqqq");
//     }else{
//     console.log("fgzfdgfzxgzxdfgzsfxgz");
    
//     }       
    
// });
// class='edpage'
    
</script>

