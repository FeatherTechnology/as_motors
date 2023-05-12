<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
} 

if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
    $sCompanyBranchDetail = $userObj->getsCompanyBranchDetail($mysqli, $sbranch_id);
} 

$id=0;
if(isset($_POST['submitMemoStatusBtn']) && $_POST['submitMemoStatusBtn'] != '')
{
if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
    $id = $_POST['id']; 	
$updateMemoStatus = $userObj->updateMemoStatus($mysqli,$id,$userid);  
?>
<script>location.href='<?php echo $HOSTPATH; ?>memo_status&msc=2';</script> 
<?php	}
else{   
    $addMemoStatus = $userObj->addMemoStatus($mysqli,$userid);   
    ?>
    <script>location.href='<?php echo $HOSTPATH; ?>memo_status&msc=1';</script>
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
	$deleteMemoStatus = $userObj->deleteMemoStatus($mysqli,$del,$userid); 
	?>
	<script>location.href='<?php echo $HOSTPATH; ?>memo_status&msc=3';</script>
<?php	
}
//Get Memo Id
$memoid=0;
if(isset($_GET['memoid']))
{
    $memoid=$_GET['memoid']; 
}
if($memoid>0)
{ 
	$GetMemoId = $userObj->GetMemoId($mysqli,$memoid);   
}
if(isset($_GET['upd']))
{
    $idupd=$_GET['upd'];
}
$status =0;
if($idupd>0)
{ 
	$getMemoStatus = $userObj->getMemoStatus($mysqli,$idupd); 
	if (sizeof($getMemoStatus)>0) {
        for($itag=0;$itag<sizeof($getMemoStatus);$itag++) {

            $memo_status_id                 = $getMemoStatus['memo_status_id']; 
			$date_of_completion              = $getMemoStatus['date_of_completion'];
            $work_update              = $getMemoStatus['work_update'];
			$highlighted      = $getMemoStatus['highlighted'];
			$attachment      = $getMemoStatus['attachment'];
		}
	} 
}
?>
   
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Memo Status </li>
    </ol>
    <?php
    if($idupd>0)
    { ?>
    <a href="memo_status">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    </a>
    <?php } ?>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
<!--------form start-->
    <form id = "edit_memo_status" name="edit_memo_status" action="" method="post" enctype="multipart/form-data"> 
    <input type="hidden" class="form-control" value="<?php if(isset($memo_status_id)) echo $memo_status_id ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id">
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
                           <div class="col-md-8 "> 
                              <div class="row">

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Date Of Completion</label>
                                            <input type="date" name="date_of_completion" id="date_of_completion" class="form-control" value="<?php if(isset($date_of_completion)) echo $date_of_completion ; ?>">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Work Update</label>
                                            <input type="text" name="work_update" id="work_update" placeholder="Work Update" class="form-control" value="<?php if(isset($work_update)) echo $work_update ; ?>">
                                        </div>
                                    </div><div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="disabledInput">Attachment</label>
                                            <?php if(!isset($attachment) && $idupd<=0){ ?>
                                                <input type="file" tabindex="3" class="form-control" id="attachment" name="attachment" ></input>   
                                            <?php } else { ?>
                                                <input type="file" tabindex="3" class="form-control" id="attachment" name="attachment" ></input>   
                                                <input type="hidden" name="edit_attachment" id="edit_attachment" value="<?php echo $attachment; ?>" >
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="label">Highlighted</label>
                                            <select tabindex="1" type="text" class="form-control" id="highlighted" name="highlighted" >
                                                <option value="">Select To Department</option>   
                                                <?php if (sizeof($GetMemoId)>0) { 
                                                for($j=0;$j<count($GetMemoId);$j++) { ?>
                                                <option <?php if(isset($highlighted)) { if($GetMemoId[$j]['staff_id'] == $highlighted)  echo 'selected'; }  ?> value="<?php echo $GetMemoId[$j]['staff_id']; ?>">
                                                <?php echo $GetMemoId[$j]['staff_name'];?></option>
                                                <?php }} ?> 
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>   
                        </div>
                    </div>
                    <div class="col-md-12">
                        <br><br>
                        <div class="text-right">
                            <button type="submit" name="submitMemoStatusBtn" id="submitMemoStatusBtn" class="btn btn-primary" value="Submit" tabindex="4">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary" tabindex="5">Cancel</button>
                        </div>
                        <br><br>
                    </div>
                        <!-- Page header start -->
                    <div class="page-header">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Memo Status List</li>
                        </ol>
                        <a href="memo_status">
                            <button type="button" tabindex="1"  class="btn btn-primary"><span class="icon-add"></span>&nbsp Add Memo Status</button>
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
                                            <div class="alert-text">Memo Status Added Successfully!</div>
                                        </div> 
                                        <?php
                                        }
                                        if($mscid==2)
                                        {?>
                                            <div class="alert alert-success" role="alert">
                                            <div class="alert-text">Memo Status Updated Successfully!</div>
                                        </div>
                                        <?php
                                        }
                                        if($mscid==3)
                                        {?>
                                        <div class="alert alert-danger" role="alert">
                                            <div class="alert-text">Memo Status Inactive Successfully!</div>
                                        </div>
                                        <?php
                                        }
                                        }
                                        ?>
                                        <table id="memo_status_info" class="table custom-table">
                                            <thead>
                                                <tr>
                                                    <th>S. No.</th>
                                                    <th>Date Of Completion</th>
                                                    <th>Work Update</th>
                                                    <th>Attachment</th>
                                                    <th>Highlighted</th>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

<script>
	setTimeout(function() {
		$('.alert').fadeOut('slow');
	}, 2000);
</script>