<style>
    .dataTables_length {
        display: none;
    }
    .dataTables_filter {
        display: none;
    }
    .dataTables_info {
        display: none;
    }
    .dataTables_paginate {
        display: none;
    }
</style>

<?php
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
} 
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
    $sCompanyBranchDetail = $userObj->getsCompanyBranchDetail($mysqli, $sbranch_id);
}
if(isset($_SESSION["staffid"])){
    $sstaffid = $_SESSION["staffid"];
}else{
    $sstaffid = 0;
}
if(isset($_SESSION["designation_id"])){
    $designationID = $_SESSION["designation_id"];
}else{
    $designationID = 0;
}

//Work Force
$outdateList = $userObj->getOverDueTask($mysqli);
$outdateList1 = $userObj->getOverDueTask1($mysqli);
$staffList = $userObj->getStaff($mysqli);

//RGP
$expiredRGPList = $userObj->getexpiredRGP($mysqli);

// approval requisition
$approval_line_id='';
$company_id='';
$approval_staff_id='';
$agree_par_staff_id='';
$after_notified_staff_id='';
$receiving_dept_id='';
$checker_approval='';
$reviewer_approval='';
$final_approval='';

$approval_staff_idArr=array();
$approval_staff_idLength=array();
$agree_par_staff_idArr=array();
$receiving_dept_idArr=array();
$after_notified_staff_idArr=array();

$approvalRequisitionApproveStaff = $userObj->getApprovalRequisitionApproveStaffDashboard($mysqli); 
if (sizeof($approvalRequisitionApproveStaff)>0) {   
    for($a=0;$a<sizeof($approvalRequisitionApproveStaff);$a++) {	
        $approval_line_id                    = $approvalRequisitionApproveStaff['approval_line_id'];
        $company_id                	         = $approvalRequisitionApproveStaff['company_id'];
        $approval_staff_id                   = $approvalRequisitionApproveStaff['approval_staff_id'];
        $agree_par_staff_id		             = $approvalRequisitionApproveStaff['agree_par_staff_id'];
        $after_notified_staff_id		     = $approvalRequisitionApproveStaff['after_notified_staff_id'];
        $receiving_dept_id		             = $approvalRequisitionApproveStaff['receiving_dept_id'];
        $checker_approval		             = $approvalRequisitionApproveStaff['checker_approval'];
        $reviewer_approval		             = $approvalRequisitionApproveStaff['reviewer_approval'];
        $final_approval		                 = $approvalRequisitionApproveStaff['final_approval'];
    }
    
    // approval staff
    $approval_staff_idArr = array_map('intval', explode(',', $approval_staff_id));
    $approval_staff_idLength = sizeof($approval_staff_idArr);

    // parallel staff
    $agree_par_staff_idArr = array_map('intval', explode(',', $agree_par_staff_id));

    // receiving dept 
    $receiving_dept_idArr = array_map('intval', explode(',', $receiving_dept_id));

    // receiving dept 
    $after_notified_staff_idArr = array_map('intval', explode(',', $after_notified_staff_id));
}

 // fetch parallel staff on dashboard
 $approvalRequisitionParallelAgreement = $userObj->getApprovalRequisitionParallelAgreement($mysqli, $sstaffid, $approval_line_id);
 $agree_disagree_staff_id = 0;
 if(sizeof($approvalRequisitionParallelAgreement) > 0){
     $agree_disagree_staff_id          = $approvalRequisitionParallelAgreement['agree_disagree_staff_id'];
 }

$approvalRequisitionAfterNotification = $userObj->getApprovalRequisitionAfterNotification($mysqli, $sstaffid, $approval_line_id);
$approve_requisition_after_notification_staff_id = '';
$approve_requisition_after_notification_staff_status = '';
if(sizeof($approvalRequisitionAfterNotification) > 0){
    $approve_requisition_after_notification_staff_id  = $approvalRequisitionAfterNotification['after_notified_staff_id'];
    $approve_requisition_after_notification_staff_status  = $approvalRequisitionAfterNotification['status'];
}

// business com out
$business_com_out_approval_staff_idArr=array();
$business_com_out_approval_staff_idLength=array();
$business_com_out_agree_par_staff_idArr=array();
$business_com_out_receiving_dept_idArr=array();
$business_com_out_after_notified_staff_idArr=array();

$BCOapproval_line_id='';
$company_id='';
$BCOapproval_staff_id='';
$BCOagree_par_staff_id='';
$BCOafter_notified_staff_id='';
$BCOreceiving_dept_id='';
$BCOchecker_approval='';
$BCOreviewer_approval='';
$BCOfinal_approval='';

$businessComOutApproveStaff = $userObj->getBusinessComOutApproveStaffDashboard($mysqli); 
if (sizeof($businessComOutApproveStaff)>0) {   
    for($a=0;$a<sizeof($businessComOutApproveStaff);$a++) {	
        $BCOapproval_line_id                    = $businessComOutApproveStaff['business_com_line_id'];
        $company_id                	         = $businessComOutApproveStaff['company_id'];
        $BCOapproval_staff_id                   = $businessComOutApproveStaff['approval_staff_id'];
        $BCOagree_par_staff_id		             = $businessComOutApproveStaff['agree_par_staff_id'];
        $BCOafter_notified_staff_id		     = $businessComOutApproveStaff['after_notified_staff_id'];
        $BCOreceiving_dept_id		             = $businessComOutApproveStaff['recipient_id'];
        $BCOchecker_approval		             = $businessComOutApproveStaff['checker_approval'];
        $BCOreviewer_approval		             = $businessComOutApproveStaff['reviewer_approval'];
        $BCOfinal_approval		                 = $businessComOutApproveStaff['final_approval'];
    }
    
    // approval staff business com out
    $business_com_out_approval_staff_idArr = array_map('intval', explode(',', $BCOapproval_staff_id));
    $business_com_out_approval_staff_idLength = sizeof($business_com_out_approval_staff_idArr);

    // parallel staff business com out
    $business_com_out_agree_par_staff_idArr = array_map('intval', explode(',', $BCOagree_par_staff_id));

    // receiving dept business com out
    $business_com_out_receiving_dept_idArr = array_map('intval', explode(',', $BCOreceiving_dept_id));

    // receiving dept business com out
    $business_com_out_after_notified_staff_idArr = array_map('intval', explode(',', $BCOafter_notified_staff_id));
}

// fetch parallel staff on dashboard business com out
$businessComOutParallelAgreement = $userObj->getBusinessComOutParallelAgreement($mysqli, $sstaffid, $BCOapproval_line_id);
$business_com_out_agree_disagree_staff_id = 0;
if(sizeof($businessComOutParallelAgreement) > 0){
    $business_com_out_agree_disagree_staff_id  = $businessComOutParallelAgreement['agree_disagree_staff_id'];
}

$businessComOutAfterNotification = $userObj->getBusinessComOutAfterNotification($mysqli, $sstaffid, $BCOapproval_line_id);
$business_com_out_after_notification_staff_id = '';
$business_com_out_after_notification_staff_status = '';
if(sizeof($businessComOutAfterNotification) > 0){
    $business_com_out_after_notification_staff_id  = $businessComOutAfterNotification['after_notified_staff_id'];
    $business_com_out_after_notification_staff_status  = $businessComOutAfterNotification['status'];
}

// Receiving branch approve (checker, reviewer, approver) - Business Communicatin (Outgoing)
$businessComOutReceivingBrachStaffApprove = $userObj->getBusinessComOutReceivingBrachStaffApprove($mysqli, $sstaffid, $BCOapproval_line_id);
$business_com_out_receiving_branch_staff_id = '';
if(sizeof($businessComOutReceivingBrachStaffApprove) > 0){
    $business_com_out_receiving_branch_staff_id  = $businessComOutReceivingBrachStaffApprove['staff_id'];
}

// Maintenance Checklist
$maintenanceChecklistResponder = $userObj->getMaintenanceChecklistResponder($mysqli, $sstaffid);

// periodic level
$periodicLevelDashboard = $userObj->getPeriodicLevelDashboard($mysqli, $sstaffid);

// memo initiate
$memoInitiateDashboard = $userObj->getMemoInitiateDashboard($mysqli, $sstaffid);

// memo assigned
$memoAssignDashboard = $userObj->getMemoAssignDashboard($mysqli, $sstaffid);

// audit assign
$auditAssignDashboard = $userObj->getAuditAssignDashboard($mysqli, $designationID);

// auditee response
$auditeeResponseDashboard = $userObj->getAuditeeResponseDashboard($mysqli, $designationID);

$mm_approval_line_id='';
$mm_company_id='';
$mm_approval_staff_id='';
$mm_agree_par_staff_id='';
$mm_after_notified_staff_id='';
$mm_receiving_dept_id='';
$mm_checker_approval='';
$mm_reviewer_approval='';
$mm_final_approval='';

// Meeting Minutes
$mm_approval_staff_idArr=array();
$mm_approval_staff_idLength=array();
$mm_agree_par_staff_idArr=array();
$mm_receiving_dept_idArr=array();
$mm_after_notified_staff_idArr=array();

$approvalRequisitionApproveStaff = $userObj->getMeetingMinutesApproveStaffDashboard($mysqli); 
if (sizeof($approvalRequisitionApproveStaff)>0) {   
    for($a=0;$a<sizeof($approvalRequisitionApproveStaff);$a++) {	
        $mm_approval_line_id                   = $approvalRequisitionApproveStaff['meeting_minutes_approval_line_id'];
        $mm_company_id                	         = $approvalRequisitionApproveStaff['company_id'];
        $mm_approval_staff_id                   = $approvalRequisitionApproveStaff['approval_staff_id'];
        $mm_agree_par_staff_id		             = $approvalRequisitionApproveStaff['agree_par_staff_id'];
        $mm_after_notified_staff_id		       = $approvalRequisitionApproveStaff['after_notified_staff_id'];
        $mm_receiving_dept_id		             = $approvalRequisitionApproveStaff['receiving_dept_id'];
        $mm_checker_approval		             = $approvalRequisitionApproveStaff['checker_approval'];
        $mm_reviewer_approval		             = $approvalRequisitionApproveStaff['reviewer_approval'];
        $mm_final_approval		                 = $approvalRequisitionApproveStaff['final_approval'];
    }
    
    // approval staff
    $mm_approval_staff_idArr = array_map('intval', explode(',', $approval_staff_id));
    $mm_approval_staff_idLength = sizeof($mm_approval_staff_idArr);

    // parallel staff
    $mm_agree_par_staff_idArr = array_map('intval', explode(',', $agree_par_staff_id));

    // receiving dept 
    $mm_receiving_dept_idArr = array_map('intval', explode(',', $receiving_dept_id));

    // receiving dept 
    $mm_after_notified_staff_idArr = array_map('intval', explode(',', $after_notified_staff_id));
}

 // fetch parallel staff on dashboard
 $mm_approvalRequisitionParallelAgreement = $userObj->getMeetingMinutesParallelAgreement($mysqli, $sstaffid, $mm_approval_line_id);
 $mm_agree_disagree_staff_id = 0;
 if(sizeof($mm_approvalRequisitionParallelAgreement) > 0){
     $mm_agree_disagree_staff_id          = $mm_approvalRequisitionParallelAgreement['agree_disagree_staff_id'];
 }

$mm_approvalRequisitionAfterNotification = $userObj->getMeetingMinutesAfterNotification($mysqli, $sstaffid, $mm_approval_line_id);
$mm_approve_requisition_after_notification_staff_id = '';
$mm_approve_requisition_after_notification_staff_status = '';
if(sizeof($mm_approvalRequisitionAfterNotification) > 0){
    $mm_approve_requisition_after_notification_staff_id  = $mm_approvalRequisitionAfterNotification['after_notified_staff_id'];
    $mm_approve_requisition_after_notification_staff_status  = $mm_approvalRequisitionAfterNotification['status'];
}
?>

<style>
.overduebox {
    width: 100%;
    height: auto;
    /* border: 1px solid;
    border-radius: 3px; */
}

.overduehead {
  background-color: #1b6aaa;
  color: white;
  font-weight: bold;
  font-size: large;
  font-family: "Lato", sans-serif;
  padding: 10px;
  text-align: center;
  /* border: 2px solid #1b6aaa;
  border-radius: 3px; */
}

.overduebody {
  padding: 10px;
  color: black;
  font-family:  sans-serif;
}

</style>


<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Dashboard </li>
    </ol>

</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
<!--------form start-->
    <form id = "dashboard" name="dashboard" action="" method="post" enctype="multipart/form-data"> 
        <input type="hidden" class="form-control" value="<?php if(isset($staff_id)) echo $staff_id; ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id">
 		<!-- Row start -->
         <div class="row gutters">

         <?php  if ($sbranch_id == 'Overall') { ?>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">RGP Date Extended Requests</div>
                    </div>
                    <div class="card-body">
                        <div class="customScroll5">
                            <ul class="project-activity">
                                <div class="col-md-12 "> 
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group" >
                                                <!-- <div class="table-responsive"> -->
                                                    <?php
                                                    $mscid=0;
                                                    if(isset($_GET['msc']))
                                                    {
                                                    $mscid=$_GET['msc'];
                                                    if($mscid==1)
                                                    {?>
                                                    <div class="alert alert-success" role="alert">
                                                        <div class="alert-text">RGP Extention Approved Successfully!</div>
                                                    </div> 
                                                    <?php
                                                    }
                                                    if($mscid==2)
                                                    {?>
                                                        <div class="alert alert-danger" role="alert">
                                                        <div class="alert-text">RGP Extention Rejected Successfully!</div>
                                                    </div>
                                                    <?php
                                                    }
                                                    }
                                                    ?>
                                                    <table id="rgpExtendedTable" class="table custom-table">
                                                        <thead>
                                                            <tr>
                                                                <th>S.No</th>
                                                                <th>Branch From</th>
                                                                <th>Branch To</th>
                                                                <th>Asset Name</th>
                                                                <!-- <th>Old Return Date</th>
                                                                <th>Extended Date</th>
                                                                <th>Extended Reason</th> -->
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                <!-- </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">RGP Expired and Not Inwarded</div>
                    </div>
                    <div class="card-body">
                        <div class="customScroll5">
                            <ul class="project-activity">
                                <div class="col-md-12 "> 
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group" >
                                                <div class="table">
                                                    <table id="rgpExtendedTable" class="table custom-table">
                                                        <thead>
                                                            <tr>
                                                                <th>S.No</th>
                                                                <th>Branch From</th>
                                                                <th>Branch To</th>
                                                                <th>Asset Name</th>
                                                                <th>Old Return Date</th>
                                                                <th>Extended Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if ($sbranch_id == 'Overall') {
                                                                if (sizeof($expiredRGPList)) {
                                                                    for ($i = 0; $i < count($expiredRGPList); $i++) {
                                                                        $j = $i + 1; ?>
                                                            <tr>
                                                                <td>
                                                                    <?php echo $j; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $expiredRGPList[$i]['company_from_name'] . ' - ' . $expiredRGPList[$i]['branch_from_name']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $expiredRGPList[$i]['company_to_name'] . ' - ' . $expiredRGPList[$i]['branch_to_name']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $expiredRGPList[$i]['asset_name']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $expiredRGPList[$i]['return_date']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $expiredRGPList[$i]['extended_date']; ?>
                                                                </td>
                                                            </tr>
                                                            <?php }
                                                                }
                                                            }else{
                                                                if (sizeof($expiredRGPList)) {
                                                                    $j = 0;
                                                                    for ($i = 0; $i < count($expiredRGPList); $i++) {
                                                                        if ($sbranch_id == $expiredRGPList[$i]['branch_from_id']) {
                                                                            $j = $j+1;
                                                                            ?>
                                                                        <tr>
                                                                            <td>
                                                                                <?php echo $j; ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php echo $expiredRGPList[$i]['company_from_name'] . ' - ' . $expiredRGPList[$i]['branch_from_name']; ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php echo $expiredRGPList[$i]['company_to_name'] . ' - ' . $expiredRGPList[$i]['branch_to_name']; ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php echo $expiredRGPList[$i]['asset_name']; ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php echo $expiredRGPList[$i]['return_date']; ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php echo $expiredRGPList[$i]['extended_date']; ?>
                                                                            </td>
                                                                        </tr>
                                                            <?php       }
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Out Dated Tasks</div>
                    </div>
                    <div class="card-body">
                        <div class="customScroll5">
                            <ul class="project-activity">
                                <div class="col-md-12 "> 
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group" >
                                                <div class="table">
                                                    <table class="table custom-table">
                                                        <th>S.No</th>
                                                        <th>Task</th>
                                                        <th>Expire Date</th>
                                                        <th>Staff Name</th>
                                                        <?php 
                                                        if ($sbranch_id == 'Overall') {
                                                        if (sizeof($outdateList) > 0) {
                                                            for ($i = 0; $i < count($outdateList); $i++) {$j=$i+1; ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $j;?>
                                                            </td>
                                                            <td>
                                                                <span style="display: none;"> <?php echo $outdateList[$i]['work_id'] ?></span>
                                                                <span> <?php echo $outdateList[$i]['work_des_text'] ;
                                                                ?></span>
                                                            </td>
                                                            <td>
                                                                <?php echo $outdateList[$i]['to_date'];?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                        if (isset($staffList)) {
                                                                            for($k = 0; $k < count($staffList); $k++){
                                                                                if($staffList[$k]['staff_id'] == $outdateList[$i]['assign_to']){
                                                                                    echo $staffList[$k]['staff_name'];
                                                                                }
                                                                            }
                                                                        }?>
                                                                    </td>
                                                                </tr>
                                                            <?php }
                                                            }
                                                            ?>

                                                        <?php if (sizeof($outdateList1) > 0) {
                                                            for ($i = 0; $i < count($outdateList1); $i++) {$j=$j+1; ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $j;?>
                                                            </td>
                                                            <td>
                                                                <span style="display: none;"> <?php echo $outdateList1[$i]['todo_id'] ?></span>
                                                                <span> <?php echo $outdateList1[$i]['work_des'] ;
                                                                ?></span>
                                                            </td>
                                                            <td>
                                                                <?php echo $outdateList1[$i]['to_date'];?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                        if (isset($staffList)) {
                                                                            for($k = 0; $k < count($staffList); $k++){
                                                                                if($staffList[$k]['staff_id'] == $outdateList1[$i]['assign_to']){
                                                                                    echo $staffList[$k]['staff_name'];
                                                                                }
                                                                            }
                                                                        }?>
                                                            </td>
                                                        </tr>
                                                        <?php }
                                                        }
                                                        } else { ?>
                                                        <?php if (sizeof($outdateList) > 0) {
                                                            $j = 0;
                                                            for ($i = 0; $i < count($outdateList); $i++) {
                                                                if ($outdateList[$i]['branch_id'] == $sbranch_id) {
                                                                    $j = $j + 1; ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $j; ?>
                                                            </td>
                                                            <td>
                                                                <span style="display: none;"> <?php echo $outdateList[$i]['work_id'] ?></span>
                                                                <span> <?php echo $outdateList[$i]['work_des_text'];
                                                                ?></span>
                                                            </td>
                                                            <td>
                                                                <?php echo $outdateList[$i]['to_date']; ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if (isset($staffList)) {
                                                                    for ($k = 0; $k < count($staffList); $k++) {
                                                                        if ($staffList[$k]['staff_id'] == $outdateList[$i]['assign_to']) {
                                                                            echo $staffList[$k]['staff_name'];
                                                                        }
                                                                    }
                                                                } ?>
                                                            </td>
                                                        </tr>
                                                            <?php }
                                                            }
                                                        }
                                                        ?>

                                                        <?php if (sizeof($outdateList1) > 0) {
                                                            for ($i = 0; $i < count($outdateList1); $i++) {
                                                                if ($outdateList1[$i]['branch_id'] == $sbranch_id) {
                                                                    $j = $j + 1; ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $j; ?>
                                                            </td>
                                                            <td>
                                                                <span style="display: none;"> <?php echo $outdateList1[$i]['todo_id'] ?></span>
                                                                <span> <?php echo $outdateList1[$i]['work_des'];
                                                                ?></span>
                                                            </td>
                                                            <td>
                                                                <?php echo $outdateList1[$i]['to_date']; ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if (isset($staffList)) {
                                                                    for ($k = 0; $k < count($staffList); $k++) {
                                                                        if ($staffList[$k]['staff_id'] == $outdateList1[$i]['assign_to']) {
                                                                            echo $staffList[$k]['staff_name'];
                                                                        }
                                                                    }
                                                                } ?>
                                                            </td>
                                                        </tr>
                                                        <?php }
                                                            }
                                                        }
                                                        }?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PM, BM checklist -->
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">PM Checklist</div>
                    </div>
                    <div class="card-body">
                        <div class="customScroll5">
                            <ul class="project-activity">
                                <div class="col-md-12 "> 
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group" >
                                                <div class="table">
                                                    <table id="pmChecklist_dashboard" class="table custom-table">
                                                        <thead>
                                                            <tr>
                                                                <th>S. No.</th>
                                                                <!-- <th>Company Name</th>
                                                                <th>Branch Name</th> -->
                                                                <th>Category</th>
                                                                <th>Checklist</th>
                                                                <!-- <th>Type Of Checklist</th>
                                                                <th>Frequency</th> -->
                                                                <th>Rating</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">BM Checklist</div>
                    </div>
                    <div class="card-body">
                        <div class="customScroll5">
                            <ul class="project-activity">
                                <div class="col-md-12 "> 
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group" >
                                                <div class="table">
                                                <table id="bmChecklist_dashboard" class="table custom-table">
                                                    <thead>
                                                        <tr>
                                                        <th>S. No.</th>
                                                        <!-- <th>Company Name</th>
                                                        <th>Branch Name</th> -->
                                                        <th>Category</th>
                                                        <th>Checklist</th>
                                                        <th>Rating</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>

                <!-- approval requisition -->
                <?php 
                if($approval_staff_idLength == '2'){    
                    if($checker_approval == 0){  
                        if($sstaffid == $approval_staff_idArr[0]) { ?>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">Approval Requisition</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Fields -->
                                            <div class="col-md-12 "> 
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group" >
                                                            <div class="table">
                                                            <table id="approvalLine_info_dashboard" class="table custom-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>S. No.</th>
                                                                        <th>Company Name</th>
                                                                        <th>Branch Name</th>
                                                                        <th>Date</th>
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php  
                        } 
                    } 

                    if($checker_approval == 1 && $final_approval == 0){
                        if($sstaffid == $approval_staff_idArr[1]) { ?>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">Approval Requisition</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Fields -->
                                            <div class="col-md-12 "> 
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group" >
                                                            <div class="table">
                                                            <table id="approvalLine_info_dashboard" class="table custom-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>S. No.</th>
                                                                        <th>Company Name</th>
                                                                        <th>Branch Name</th>
                                                                        <th>Date</th>
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php  
                        }
                    }

                } else if($approval_staff_idLength == '3'){

                    if($checker_approval == 0){
                        if($sstaffid == $approval_staff_idArr[0]) { ?>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">Approval Requisition</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Fields -->
                                            <div class="col-md-12 "> 
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group" >
                                                            <div class="table">
                                                            <table id="approvalLine_info_dashboard" class="table custom-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>S. No.</th>
                                                                        <th>Company Name</th>
                                                                        <th>Branch Name</th>
                                                                        <th>Date</th>
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php  
                        } 
                    } 

                    if($checker_approval == 1 && $reviewer_approval == 0){
                        if($sstaffid == $approval_staff_idArr[1]) { ?>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">Approval Requisition</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Fields -->
                                            <div class="col-md-12 "> 
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group" >
                                                            <div class="table">
                                                            <table id="approvalLine_info_dashboard" class="table custom-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>S. No.</th>
                                                                        <th>Company Name</th>
                                                                        <th>Branch Name</th>
                                                                        <th>Date</th>
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php  
                        }
                    }

                    if($checker_approval == 1 && $reviewer_approval == 1 && $final_approval == 0){
                        if($sstaffid == $approval_staff_idArr[2]) { ?>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">Approval Requisition</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 "> 
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group" >
                                                            <div class="table">
                                                            <table id="approvalLine_info_dashboard" class="table custom-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>S. No.</th>
                                                                        <th>Company Name</th>
                                                                        <th>Branch Name</th>
                                                                        <th>Date</th>
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php  
                        }
                    }

                } ?>
                
                <!-- approval requisition parallel Approval Requisition -->
                <?php 
                if($agree_disagree_staff_id == $sstaffid && $sbranch_id != 'Overall'){ ?>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Parallel Agreement - Approval Requisition</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 "> 
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group" >
                                                    <div class="table">
                                                        <table id="parallelAgreement_info_dashboard" class="table custom-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>S. No.</th>
                                                                    <th>Company Name</th>
                                                                    <th>Branch Name</th>
                                                                    <th>Date</th>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <!-- after notified staff Approval Requisition -->
                <?php 
                if($approve_requisition_after_notification_staff_id == $sstaffid && $approve_requisition_after_notification_staff_status == 1){ ?>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">After Notification - Approval Requisition</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 "> 
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group" >
                                                    <div class="table">
                                                        <table id="afterNotification_info_dashboard" class="table custom-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>S. No.</th>
                                                                    <th>Company Name</th>
                                                                    <th>Branch Name</th>
                                                                    <th>Date</th>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>


                <!-- business com out -->
                <?php 
                if($business_com_out_approval_staff_idLength == '2' && $sbranch_id != 'Overall'){

                    if($BCOchecker_approval == 0){  
                        if($sstaffid == $business_com_out_approval_staff_idArr[0]) { ?>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">Business Communication (Outgoing)</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 "> 
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group" >
                                                            <div class="table">
                                                            <table id="business_com_out_approvalLine_info_dashboard" class="table custom-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>S. No.</th>
                                                                        <th>Company Name</th>
                                                                        <th>Branch Name</th>
                                                                        <th>Date</th>
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php  
                        } 
                    } 
                
                    if($BCOchecker_approval == 1 && $BCOfinal_approval == 0){
                
                        if($sstaffid == $business_com_out_approval_staff_idArr[1]) { ?>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">Business Communication (Outgoing)</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Fields -->
                                            <div class="col-md-12 "> 
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group" >
                                                            <div class="table">
                                                            <table id="business_com_out_approvalLine_info_dashboard" class="table custom-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>S. No.</th>
                                                                        <th>Company Name</th>
                                                                        <th>Branch Name</th>
                                                                        <th>Date</th>
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php  
                        }
                    }
                
                } else if($business_com_out_approval_staff_idLength == '3'){
                
                    if($BCOchecker_approval == 0){
                        if($sstaffid == $business_com_out_approval_staff_idArr[0]) { ?>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">Business Communication (Outgoing)</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 "> 
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group" >
                                                            <div class="table">
                                                            <table id="business_com_out_approvalLine_info_dashboard" class="table custom-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>S. No.</th>
                                                                        <th>Company Name</th>
                                                                        <th>Branch Name</th>
                                                                        <th>Date</th>
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php  
                        } 
                    } 
                
                    if($BCOchecker_approval == 1 && $BCOreviewer_approval == 0){
                
                        if($sstaffid == $business_com_out_approval_staff_idArr[1]) { ?>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">Business Communication (Outgoing)</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Fields -->
                                            <div class="col-md-12 "> 
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group" >
                                                            <div class="table">
                                                            <table id="business_com_out_approvalLine_info_dashboard" class="table custom-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>S. No.</th>
                                                                        <th>Company Name</th>
                                                                        <th>Branch Name</th>
                                                                        <th>Date</th>
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php  
                        }
                    }
                
                    if($BCOchecker_approval == 1 && $BCOreviewer_approval == 1 && $BCOfinal_approval == 0){
                
                        if($sstaffid == $business_com_out_approval_staff_idArr[2]) { ?>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">Business Communication (Outgoing)</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Fields -->
                                            <div class="col-md-12 "> 
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group" >
                                                            <div class="table">
                                                            <table id="business_com_out_approvalLine_info_dashboard" class="table custom-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>S. No.</th>
                                                                        <th>Company Name</th>
                                                                        <th>Branch Name</th>
                                                                        <th>Date</th>
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php  
                        }
                    }
                
                } ?>


                <!-- parallel approve reject Business Communication (Outgoing) -->
                <?php 
                if($business_com_out_agree_disagree_staff_id == $sstaffid && $sbranch_id != 'Overall'){ ?>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Parallel Agreement - Business Communication (Outgoing)</div>
                            </div>
                            <div class="card-body">
                                <div class="customScroll5">
                                    <ul class="project-activity">
                                        <div class="col-md-12 "> 
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group" >
                                                        <div class="table">
                                                            <table id="business_com_out_parallelAgreement_info_dashboard" class="table custom-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>S. No.</th>
                                                                        <th>Company Name</th>
                                                                        <th>Branch Name</th>
                                                                        <th>Date</th>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <!-- after notified staff Business Communication (Outgoing) -->
                <?php 
                 if($business_com_out_after_notification_staff_id == $sstaffid && $business_com_out_after_notification_staff_status == 1){ ?>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">After Notification - Business Communication (Outgoing)</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Fields -->
                                    <div class="col-md-12 "> 
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group" >
                                                    <div class="table">
                                                        <table id="business_com_out_afterNotification_info_dashboard" class="table custom-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>S. No.</th>
                                                                    <th>Company Name</th>
                                                                    <th>Branch Name</th>
                                                                    <th>Date</th>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <!-- receiving branch's dept agree reject in Business Communication (Outgoing) -->
                <?php 
                if($business_com_out_receiving_branch_staff_id == $sstaffid){ ?>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Receiving Branch - Business Communication (Outgoing) </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Fields -->
                                    <div class="col-md-12 "> 
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group" >
                                                    <div class="table">
                                                        <table id="business_com_out_receivingBranch_info_dashboard" class="table custom-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>S. No.</th>
                                                                    <th>Company Name</th>
                                                                    <th>Branch Name</th>
                                                                    <th>Date</th>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <!-- Maintenance Checklist -->
                <?php 
                if(sizeof($maintenanceChecklistResponder) > 0){ ?>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Maintenance Checklist </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Fields -->
                                    <div class="col-md-12 "> 
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group" >
                                                    <div class="table">
                                                        <table id="maintenanceChecklist_infoDashboard" class="table custom-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>S. No.</th>
                                                                    <!-- <th>Company Name</th>
                                                                    <th>Branch Name</th> -->
                                                                    <th>Category</th>
                                                                    <th>Checklist</th>
                                                                    <th>Type Of Checklist</th>
                                                                    <th>Frequency</th>
                                                                    <th>Rating</th>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>


                <!-- Periodic Level -->
                <?php 
                if($periodicLevelDashboard > 0){ ?>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Periodic Level </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Fields -->
                                    <div class="col-md-12 "> 
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group" >
                                                    <div class="table">
                                                        <table id="periodicLevel_infoDashboard" class="table custom-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>S. No.</th>
                                                                    <th>Company Name</th>
                                                                    <th>Branch Name</th>
                                                                    <th>Periodic Date</th>
                                                                    <th>Asset Details</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <!-- memo Initiate -->
                <?php 
                if($memoInitiateDashboard > 0){ ?>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Memo Initiate</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Fields -->
                                    <div class="col-md-12 "> 
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group" >
                                                    <div class="table">
                                                        <table id="memo_infoDashboard" class="table custom-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>S. No.</th>
                                                                    <th>Company Name</th>
                                                                    <th>To Department</th>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <!-- memo Assigned -->
                <?php 
                if($memoAssignDashboard > 0){ ?>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Memo Assigned</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Fields -->
                                    <div class="col-md-12 "> 
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group" >
                                                    <div class="table">
                                                        <table id="memo_assigned_infoDashboard" class="table custom-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>S. No.</th>
                                                                    <th>Company Name</th>
                                                                    <th>To Department</th>
                                                                    <th>Assign Employee</th>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>


                <!-- audit assign -->
                <?php 
                if($auditAssignDashboard > 0){ ?>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Audit Assign</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Fields -->
                                    <div class="col-md-12 "> 
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group" >
                                                    <div class="table">
                                                        <table id="audit_assign_infoDashboard" class="table custom-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>S. No.</th>
                                                                    <th>Date Of Audit</th>
                                                                    <th>Department</th>
                                                                    <th>Role 1</th>
                                                                    <th>Role 2</th>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <!-- auditee response -->
                <?php 
                if($auditeeResponseDashboard > 0){ ?>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Auditee Response</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Fields -->
                                    <div class="col-md-12 "> 
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group" >
                                                    <div class="table">
                                                        <table id="auditee_response_infoDashboard" class="table custom-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>S. No.</th>
                                                                    <th>Date Of Audit</th>
                                                                    <th>Department</th>
                                                                    <th>Role 1</th>
                                                                    <th>Role 2</th>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <!-- meeting minutes -->
                <?php 
                if($mm_approval_staff_idLength == '2'){    
                    if($mm_checker_approval == 0){  
                        if($sstaffid == $mm_approval_staff_idArr[0]) { ?>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">Meeting Minutes</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 "> 
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group" >
                                                            <div class="table">
                                                            <table id="meetingMinutesApprovalLine_info_dashboard" class="table custom-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>S. No.</th>
                                                                        <th>Company Name</th>
                                                                        <th>Branch Name</th>
                                                                        <th>Date</th>
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php  
                        } 
                    } 

                    if($mm_checker_approval == 1 && $mm_final_approval == 0){
                        if($sstaffid == $mm_approval_staff_idArr[1]) { ?>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">Meeting Minutes</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 "> 
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group" >
                                                            <div class="table">
                                                            <table id="meetingMinutesApprovalLine_info_dashboard" class="table custom-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>S. No.</th>
                                                                        <th>Company Name</th>
                                                                        <th>Branch Name</th>
                                                                        <th>Date</th>
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php  
                        }
                    }

                } else if($mm_approval_staff_idLength == '3'){

                    if($mm_checker_approval == 0){
                        if($sstaffid == $mm_approval_staff_idArr[0]) { ?>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">Meeting Minutes</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 "> 
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group" >
                                                            <div class="table">
                                                            <table id="meetingMinutesApprovalLine_info_dashboard" class="table custom-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>S. No.</th>
                                                                        <th>Company Name</th>
                                                                        <th>Branch Name</th>
                                                                        <th>Date</th>
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php  
                        } 
                    } 

                    if($mm_checker_approval == 1 && $mm_reviewer_approval == 0){
                        if($sstaffid == $mm_approval_staff_idArr[1]) { ?>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">Meeting Minutes</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Fields -->
                                            <div class="col-md-12 "> 
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group" >
                                                            <div class="table">
                                                            <table id="meetingMinutesApprovalLine_info_dashboard" class="table custom-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>S. No.</th>
                                                                        <th>Company Name</th>
                                                                        <th>Branch Name</th>
                                                                        <th>Date</th>
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php  
                        }
                    }

                    if($mm_checker_approval == 1 && $mm_reviewer_approval == 1 && $mm_final_approval == 0){
                        if($sstaffid == $mm_approval_staff_idArr[2]) { ?>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">Meeting Minutes</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 "> 
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group" >
                                                            <div class="table">
                                                            <table id="meetingMinutesApprovalLine_info_dashboard" class="table custom-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>S. No.</th>
                                                                        <th>Company Name</th>
                                                                        <th>Branch Name</th>
                                                                        <th>Date</th>
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php  
                        }
                    }
                } ?>
                
                <!-- Parallel Meeting Minutes -->
                <?php 
                if($mm_agree_disagree_staff_id == $sstaffid && $sbranch_id != 'Overall'){ ?>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Parallel Agreement - Meeting Minutes</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 "> 
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group" >
                                                    <div class="table">
                                                        <table id="meetingMinutesParallelAgreement_info_dashboard" class="table custom-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>S. No.</th>
                                                                    <th>Company Name</th>
                                                                    <th>Branch Name</th>
                                                                    <th>Date</th>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <!-- after notified staff Meeting Minutes -->
                <?php 
                if($mm_approve_requisition_after_notification_staff_id == $sstaffid && $mm_approve_requisition_after_notification_staff_status == 1){ ?>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">After Notification - Meeting Minutes</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 "> 
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group" >
                                                    <div class="table">
                                                        <table id="afterMeetingMinutesNotification_info_dashboard" class="table custom-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>S. No.</th>
                                                                    <th>Company Name</th>
                                                                    <th>Branch Name</th>
                                                                    <th>Date</th>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

             </div>
        </div>
    </form>
</div>


<script>
	setTimeout(function() {
		$('.alert').fadeOut('slow');
	}, 2000);
</script>