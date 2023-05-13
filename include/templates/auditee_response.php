<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
} 
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
    $sCompanyBranchDetail = $userObj->getsCompanyBranchDetail($mysqli, $sbranch_id);
} 
$companyName = $userObj->getCompanyName($mysqli);

// auditee dashboard
$dashboard_upd=0;
if(isset($_GET['dashboard_upd']))
{
    $dashboard_upd=$_GET['dashboard_upd'];
}
$status =0;
if($dashboard_upd>0)
{ 
	$getAuditAssignDetails = $userObj->getAuditAssignDetails($mysqli, $dashboard_upd); 
	if (sizeof($getAuditAssignDetails)>0) {
        for($itag=0;$itag<sizeof($getAuditAssignDetails);$itag++) {
            $audit_assign_id            = $getAuditAssignDetails['audit_assign_id']; 
            $date_of_audit              = $getAuditAssignDetails['date_of_audit'];
			$department_name            = $getAuditAssignDetails['department_name'];
			$role1    	                = $getAuditAssignDetails['role1'];
			$role2    	                = $getAuditAssignDetails['role2'];
            $checklist    	            = $getAuditAssignDetails['audit_area']; 
		}
	} 
?>

<input type="hidden" id="auditAssignEdit" name="auditAssignEdit" value="<?php print_r($audit_assign_id); ?>" >
<script language='javascript'>
    // get branch name
    window.onload=updateAuditeeResponse;
    function updateAuditeeResponse(){  
        
        var audit_assign_id = $('#auditAssignEdit').val();
        $.ajax({
            url:"auditFile/ajaxGetAuditAssignDetails.php",
            method:"post",
            data:{ 'audit_assign_id': audit_assign_id },
            success:function(html){
                $("#auditAssignDetailsAppend").empty();
                $("#auditAssignDetailsAppend").html(html);
            }
        });
    }
</script>

<?php
}


// auditor dashboard
$dashboard_view=0;
if(isset($_GET['dashboard_view']))
{
    $dashboard_view=$_GET['dashboard_view'];
}
$status =0;
if($dashboard_view>0)
{ 
	$getAuditAssignDetails = $userObj->getAuditAssignDetails($mysqli, $dashboard_view); 
	if (sizeof($getAuditAssignDetails)>0) {
        for($itag=0;$itag<sizeof($getAuditAssignDetails);$itag++) {
            $audit_assign_id            = $getAuditAssignDetails['audit_assign_id']; 
            $date_of_audit              = $getAuditAssignDetails['date_of_audit'];
			$department_name            = $getAuditAssignDetails['department_name'];
			$role1    	                = $getAuditAssignDetails['role1'];
			$role2    	                = $getAuditAssignDetails['role2'];
            $checklist    	            = $getAuditAssignDetails['audit_area']; 
		}
	} 
    ?>

    <input type="hidden" id="auditAssignEdit" name="auditAssignEdit" value="<?php print_r($audit_assign_id); ?>" >

    <script language='javascript'>
        // get branch name
        window.onload=viewAuditeeResponse;
        function viewAuditeeResponse(){  
            
            var audit_assign_id = $('#auditAssignEdit').val();
            $.ajax({
                url:"auditFile/ajaxGetAuditeeResponseDetails.php",
                method:"post",
                data:{ 'audit_assign_id': audit_assign_id },
                success:function(html){
                    $("#auditAssignDetailsAppend").empty();
                    $("#auditAssignDetailsAppend").html(html);
                }
            });
        }
    </script>

<?php
}
?>
   
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Auditee Response</li>
    </ol>
    <!-- <a href="edit_daily_km">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    </a> -->
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
<!-- form start -->
    <form id = "daily_km" name="daily_km" action="" method="post" enctype="multipart/form-data"> 
    <input type="hidden" class="form-control" value="<?php if(isset($audit_assign_id)) echo $audit_assign_id ?>" id="id" name="id" aria-describedby="id" placeholder="Enter id">
 		<!-- Row start -->
         <div class="row gutters">

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
					<div class="card-header">
						<!-- <div class="card-title">General Info</div> -->
					</div>
                    <div class="card-body">

                    	 <div class="row ">
                            <!--Fields -->
                           <div class="col-md-12 "> 
                                <div class="row">
                            
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Chceklist </label>
                                            <input readonly type="text" class="form-control" id="checklist" name="checklist" value="<?php if(isset($checklist)) echo $checklist; ?>" >
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Department </label>
                                            <input readonly type="text" class="form-control" id="dept" name="dept" value="<?php if(isset($department_name)) echo $department_name; ?>" >
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Role 1</label>
                                            <input readonly type="text" class="form-control" id="role1" name="role1" value="<?php if(isset($role1)) echo $role1; ?>" >                           
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="inputReadOnly">Role 2</label>
                                            <input readonly type="text" class="form-control" id="role2" name="role2" value="<?php if(isset($role2)) echo $role2; ?>">                             
                                        </div>
                                    </div>

                                    <!-- <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12" style="margin-top: 19px;">
                                        <div class="form-group">
                                            <button tabindex="3" type="button" class="btn btn-primary" id="displayAuditAssignBtn" name="displayAuditAssignBtn" data-toggle="modal" style="padding: 5px 35px;">Execute</button>
                                        </div>
                                    </div> -->

                                </div>
                            </div>
                        </div>

                        <div id="auditAssignDetailsAppend"></div>

                        <?php if($dashboard_upd>0){ ?>
                            <div class="col-md-12">
                                <div class="text-right">
                                    <button type="button" name="submitAudittResponseBtn" id="submitAudittResponseBtn" class="btn btn-primary" value="Submit" tabindex="7">Submit</button>
                                    <button type="reset" class="btn btn-outline-secondary" tabindex="8">Cancel</button>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
