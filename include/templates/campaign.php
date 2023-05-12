<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
} 
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
    $sCompanyBranchDetail = $userObj->getsCompanyBranchDetail($mysqli, $sbranch_id);
} 
$promotionalProjectName = $userObj->getPromotionalProjectName($mysqli);
$promotionalProjectNameUpdate = $userObj->getPromotionalProjectNameUpdate($mysqli);
$staffList = $userObj->getStaff($mysqli); 

$id=0;
if(isset($_POST['submitCampaignBtn']) && $_POST['submitCampaignBtn'] != '')
{ 
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){     
        $id = $_POST['id'];  
        $updateAuditAreaCreationmaster = $userObj->updateCampaign($mysqli, $id, $userid);    
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_campaign&msc=2';</script> 
        <?php }
    else {   
        
        $addAuditAreaCreation = $userObj->addCampaign($mysqli, $userid);   
        ?>
     <script>location.href='<?php echo $HOSTPATH; ?>edit_campaign&msc=1';</script>
        <?php
    }
}  

$del=0;
if(isset($_GET['del']))
{
    $del=$_GET['del'];
}
if($del>0)
{
	$deleteDailyKM = $userObj->deleteCampaign($mysqli,$del,$userid); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>edit_campaign&msc=3';</script>
    <?php	
}

if(isset($_GET['upd']))
{
    $idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{ 
	$getCampaign = $userObj->getCampaign($mysqli,$idupd); 
	if (sizeof($getCampaign)>0) {
        for($itag=0;$itag<sizeof($getCampaign);$itag++) {
            $campaign_id                    = $getCampaign['campaign_id']; 
            $promotional_activities_id      = $getCampaign['promotional_activities_id'];
            $promotional_activities_ref_id      = $getCampaign['promotional_activities_ref_id'];
			$actual_start_date        	    = $getCampaign['actual_start_date'];
			$activity_involved        	    = $getCampaign['activity_involved'];
			$time_frame_start        	    = $getCampaign['time_frame_start'];
			$duration        	    = $getCampaign['duration'];
			$campaign_ref_id        	    = $getCampaign['campaign_ref_id'];
			$start_date        	    = $getCampaign['start_date'];
			$end_date        	    = $getCampaign['end_date'];
			$staff_name        	    = $getCampaign['staff_name'];
		}
	} 
    ?>

    <input type="hidden" id="campaignIdEdit" name="campaignIdEdit" value="<?php print_r($company_id); ?>" >
    <input type="hidden" id="promotionalActivityIdEdit" name="promotionalActivityIdEdit" value="<?php print_r($promotional_activities_id); ?>" >

    <!-- <script language='javascript'>
        window.onload=editCampaignRef;
        function editCampaignRef(){  

            var campaign_id = $('#campaignIdEdit').val();
            var promotional_activities_id = $('#promotionalActivityIdEdit').val();
            $.ajax({
                url:"campaignlFile/ajaxGetPromotionalActivityUpdateDetails.php",
                method:"post",
                data: {'campaign_id': campaign_id, 'promotional_activities_id': promotional_activities_id},
                success:function(html){
                    $("#projectDetailsAppend").empty();
                    $("#projectDetailsAppend").html(html);
                }
            });
        }
    </script> -->

<?php
}
?>
   
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Campaign</li>
    </ol>
    <a href="edit_campaign">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    </a>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
<!--------form start-->
    <form id = "campaign" name="campaign" action="" method="post" enctype="multipart/form-data"> 
    <input type="hidden" class="form-control" value="<?php if(isset($campaign_id)) echo $campaign_id ?>" id="id" name="id" aria-describedby="id" placeholder="Enter id">
    <input type="hidden" id="old_project_id" name="old_project_id" value="<?php print_r($promotional_activities_id); ?>" >
    <input type="hidden" id="old_promotional_activity_ref_id" name="old_promotional_activity_ref_id" value="<?php print_r($promotional_activities_ref_id); ?>" >
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
                            
                                <?php if($idupd<=0){ ?>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Project Name</label>
                                            <select tabindex="1" type="text" class="form-control" id="project_id" name="project_id" >
                                                <option value="">Select Project Name</option>   
                                                <?php if (sizeof($promotionalProjectName)>0) { 
                                                for($j=0;$j<count($promotionalProjectName);$j++) { ?>
                                                <option <?php if(isset($promotional_activities_id)) { if($promotionalProjectName[$j]['promotional_activities_id'] == $promotional_activities_id) echo 'selected'; } ?>
                                                value="<?php echo $promotionalProjectName[$j]['promotional_activities_id']; ?>">
                                                <?php echo $promotionalProjectName[$j]['project'];?></option>
                                                <?php }} ?>
                                            </select>  
                                        </div>
                                    </div>
                                <?php } else if($idupd>0){ ?>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Project Name</label>
                                            <select readonly tabindex="1" type="text" class="form-control" id="project_id" name="project_id" >
                                                <option value="">Select Project Name</option>   
                                                <?php if (sizeof($promotionalProjectNameUpdate)>0) { 
                                                for($j=0;$j<count($promotionalProjectNameUpdate);$j++) { ?>
                                                <option <?php if(isset($promotional_activities_id)) { if($promotionalProjectNameUpdate[$j]['promotional_activities_id'] == $promotional_activities_id) echo 'selected'; } ?>
                                                value="<?php echo $promotionalProjectNameUpdate[$j]['promotional_activities_id']; ?>">
                                                <?php echo $promotionalProjectNameUpdate[$j]['project'];?></option>
                                                <?php }} ?>
                                            </select>  
                                        </div>
                                    </div>
                                <?php } ?>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Actual Start Date</label>
                                            <input type="date" name="actual_start_date" id="actual_start_date" class="form-control" value="<?php if(isset($actual_start_date)) echo $actual_start_date; ?>" >
                                        </div>
                                    </div>

                                    <?php if($idupd<=0){ ?>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12" style="margin-top: 19px;">
                                            <div class="form-group">
                                                <button tabindex="3" type="button" class="btn btn-primary" id="viewBtn" name="viewBtn" data-toggle="modal" style="padding: 5px 35px;">View</button>
                                            </div>
                                        </div>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>

                        <?php if($idupd<=0){ ?>
                            <div id="projectDetailsAppend"></div>
                        <?php } ?>

                        <?php if($idupd>0){ ?>

                            <div class="card" id="stockinformation">
                                <div class="card-header">Promotional Activity Details</div>
                                <div class="card-body ">
                                <br> 
                                    <div style="overflow-x: auto; white-space: nowrap;" >
                                       
                                        <table class="table custom-table" id="sstable">
                                            <tr>
                                                <th>S. No.</th>
                                                <th>Activity</th>
                                                <th>Time Frame</th>
                                                <th>Duration</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Employee Name</th>
                                            </tr>
                                            <?php
                                            $sno = 1;   
                                            if(isset($promotional_activities_ref_id)){ 
                                                for($o=0; $o<=sizeof($promotional_activities_ref_id)-1; $o++){ ?>
                                                    <tbody>
                                                        <tr>
                                                            <td width="5%;"><?php echo $sno; ?></td>
                                                            <td style="display: none;"><input tabindex="4" name="promotional_activities_ref_id[]" id="promotional_activities_ref_id" class="promotional_activities_ref_id" value="<?php echo $promotional_activities_ref_id[$o]; ?>" /></td>
                                                            <td width="10%;"><input type="text" readonly class="form-control" name="activity_involved[]" id="activity_involved" value="<?php echo $activity_involved[$o]; ?>" ></td>
                                                            <td width="10%;"><input type="text" readonly class="form-control" name="time_frame_start[]" id="time_frame_start" value="<?php echo $time_frame_start[$o]; ?>" ></td>
                                                            <td width="10%;"><input type="text" readonly class="form-control" name="duration[]" id="duration" value="<?php echo $duration[$o]; ?>" ></td>
                                                            <td width="10%;"><input type="date" class="form-control" name="start_date[]" id="start_date" value="<?php echo $start_date[$o]; ?>" ></td>
                                                            <td width="10%;"><input type="date" class="form-control" name="end_date[]" id="end_date" value="<?php echo $end_date[$o]; ?>" ></td>
                                                            <td width="10%;">
                                                                <select tabindex="4" type="text" class="form-control employee_name" id="employee_name" name="employee_name[]" >
                                                                <option value="">Select Employee Name</option>   
                                                                    <?php if (sizeof($staffList)>0) { 
                                                                    for($j=0;$j<count($staffList);$j++) { ?>
                                                                    <option <?php if(isset($staff_name)) { if($staffList[$j]['staff_id'] == $staff_name[$o])  echo 'selected'; }  ?> value="<?php echo $staffList[$j]['staff_id']; ?>">
                                                                    <?php echo $staffList[$j]['staff_name'];?></option>
                                                                    <?php }} ?>   
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                <?php $sno = $sno + 1; }
                                            } ?>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>

                        <div class="col-md-12">
                            <div class="text-right">
                                <button type="submit" name="submitCampaignBtn" id="submitCampaignBtn" class="btn btn-primary" value="Submit" tabindex="7">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary" tabindex="8">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
