<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
} 
if(isset($_SESSION["staffid"])){
    $sstaffid = $_SESSION["staffid"];
}
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
    $sCompanyBranchDetail = $userObj->getsCompanyBranchDetail($mysqli, $sbranch_id);
} 

$companyName = $userObj->getCompanyName($mysqli);
$departmentList = $userObj->getDepartment($mysqli); 
$designationList = $userObj->getDesignation($mysqli);

$approval_staff_idArr=array();
$approval_staff_idLength=array();
$agree_par_staff_idArr=array();
$receiving_dept_idArr=array();
$after_notified_staff_idArr=array();

if(isset($_GET['upd']))
{ 
    $idupd=$_GET['upd'];
    $approvalRequisitionApproveStaff = $userObj->getApprovalRequisitionApproveStaff($mysqli, $idupd); 
    if (sizeof($approvalRequisitionApproveStaff)>0) {   
        for($a=0;$a<sizeof($approvalRequisitionApproveStaff);$a++) {	
            $approval_line_id                    = $approvalRequisitionApproveStaff['approval_line_id'];
            $company_id                	         = $approvalRequisitionApproveStaff['company_id'];
            $staff_id                	         = $approvalRequisitionApproveStaff['staff_id'];
            $approval_staff_id                   = $approvalRequisitionApproveStaff['approval_staff_id'];
            $agree_par_staff_id		             = $approvalRequisitionApproveStaff['agree_par_staff_id'];
            $after_notified_staff_id		     = $approvalRequisitionApproveStaff['after_notified_staff_id'];
            $receiving_dept_id		             = $approvalRequisitionApproveStaff['receiving_dept_id'];
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
    } ?>

    <script language='javascript'> 
        window.onload=getEmployeeDetails;
        // Get Employee Details
        function getEmployeeDetails(){ 
            
            $.ajax({
                url: 'businesscomFile/getemployee.php',
                type: 'post',
                data: {},
                dataType: 'json',
                success: function(response){ 
                    $("#drafter_name").val(response["staff_name"]);
                    $("#drafter_nameApp").val(response["staff_name"]);
                    $("#drafter_department").val(response["department"]);
                }
            });
        }
    </script>

    <?php 
}

$dashupd = 0;
$parallel = 0;
$afterNotification = 0;
if(isset($_GET['dashupd']))
{   
    if(isset($_GET['parallel'])){
        $parallel=$_GET['parallel'];
    } 
    if(isset($_GET['afterNotification'])){
        $afterNotification=$_GET['afterNotification'];
    } 

    $dashupd=$_GET['dashupd'];
    $approvalRequisitionApproveStaff = $userObj->getApprovalRequisitionApproveStaff($mysqli, $dashupd); 
    if (sizeof($approvalRequisitionApproveStaff)>0) {   
        for($a=0;$a<sizeof($approvalRequisitionApproveStaff);$a++) {	
            $approval_line_id                    = $approvalRequisitionApproveStaff['approval_line_id'];
            $company_id                	         = $approvalRequisitionApproveStaff['company_id'];
            $staff_id                	         = $approvalRequisitionApproveStaff['staff_id']; 
            $approval_staff_id                   = $approvalRequisitionApproveStaff['approval_staff_id'];
            $agree_par_staff_id		             = $approvalRequisitionApproveStaff['agree_par_staff_id'];
            $after_notified_staff_id		     = $approvalRequisitionApproveStaff['after_notified_staff_id'];
            $receiving_dept_id		             = $approvalRequisitionApproveStaff['receiving_dept_id'];
            $drafter_approval_date		         = $approvalRequisitionApproveStaff['created_date'];
            $checker_approval_date		         = $approvalRequisitionApproveStaff['checker_approval_date'];
            $reviewer_approval_date		         = $approvalRequisitionApproveStaff['reviewer_approval_date'];
            $final_approval_date		         = $approvalRequisitionApproveStaff['final_approval_date'];
            $checker_approval		             = $approvalRequisitionApproveStaff['checker_approval'];
            $reviewer_approval		             = $approvalRequisitionApproveStaff['reviewer_approval'];
            $final_approval		                 = $approvalRequisitionApproveStaff['final_approval'];   
        }

        // get approval requisition 
        $getqry = "SELECT * FROM approval_requisition WHERE approval_line_id ='".strip_tags($approval_line_id)."' and status = 0"; 
        $res = $mysqli->query($getqry) or die("Error in Get All Records".$mysqli->error);
        while($row = $res->fetch_assoc())
        {
           $comments = $row["comments"];        
           $doc_no = $row["doc_no"];        
           $auto_generation_date = $row["auto_generation_date"];        
           $title = $row["title"];       
           $file = $row["file"];       
        }

        // approval staff
        $approval_staff_idArr = array_map('intval', explode(',', $approval_staff_id));
        $approval_staff_idLength = sizeof($approval_staff_idArr);

        // parallel staff
        $agree_par_staff_idArr = array_map('intval', explode(',', $agree_par_staff_id));

        // receiving dept 
        $receiving_dept_idArr = array_map('intval', explode(',', $receiving_dept_id));

        // after notified staff 
        $after_notified_staff_idArr = array_map('intval', explode(',', $after_notified_staff_id));
    } 
}

$id=0;
if(isset($_POST['MeetingMinutesSubmit']) && $_POST['MeetingMinutesSubmit'] != '')
{
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
        // $updatekraCreation = $userObj->updatekraCreation($mysqli,$id,$userid);  
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_kra_creation&msc=2';</script> 
    <?php }
    else {   
        $addMeetingMinutes = $userObj->addMeetingMinutes($mysqli,$userid);   
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>meeting_minutes';</script>
        <?php
    }
}   

$parallel = 0;
if(isset($_GET['parallel'])){
    $parallel=$_GET['parallel'];
} 
if(isset($_POST['agreeBtn']) && $_POST['agreeBtn'] != '')
{
    if($parallel > 0){
        $parallelAgreeApprovalRequisition = $userObj->parallelAgreeApprovalRequisition($mysqli, $userid);   
    }else{
        $agreeApprovalRequisition = $userObj->agreeApprovalRequisition($mysqli, $userid);   
    }
    ?>
    <script>location.href='<?php echo $HOSTPATH; ?>dashboard';</script>
    <?php
}   
if(isset($_POST['disagreeBtn']) && $_POST['disagreeBtn'] != '')
{
    if($parallel > 0){
        $parallelDisagreeApprovalRequisition = $userObj->parallelDisagreeApprovalRequisition($mysqli, $userid);     
    }else{
        $disagreeApprovalRequisition = $userObj->disagreeApprovalRequisition($mysqli, $userid);    
    }
     
    ?>
    <script>location.href='<?php echo $HOSTPATH; ?>dashboard';</script>
    <?php
}   

function getStaffName($mysqli, $staff_id){
    $staff_name='';
    $getqry = "SELECT staff_name FROM staff_creation WHERE staff_id ='".strip_tags($staff_id)."' and status = 0";
    $res = $mysqli->query($getqry) or die("Error in Get All Records".$mysqli->error);
    while($row = $res->fetch_assoc())
    {
       $staff_name = $row["staff_name"];        
    }

    return $staff_name;
}

function getDeptName($mysqli, $department_id){
    $department_name='';
    $getqry = "SELECT department_name FROM department_creation WHERE department_id ='".strip_tags($department_id)."' and status = 0";
    $res = $mysqli->query($getqry) or die("Error in Get All Records".$mysqli->error);
    while($row = $res->fetch_assoc())
    {
       $department_name = $row["department_name"];        
    }

    return $department_name;
}

?> 
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
   
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Meeting Minutes</li>
    </ol>
    <!-- <a href="edit_meeting_minutes_approval_line">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    </a> -->
</div>
<!-- Page header end -->

<!-- Main container start -->
<?php if($dashupd > 0){ ?>
    <div class="main-container">
        <!-- form start -->
        <form id="customer" name="customer" action="" method="post" enctype="multipart/form-data">	
            <input type="hidden" class="form-control" value="<?php if(isset($dashupd)) echo $dashupd; ?>" id="idupd" name="idupd" aria-describedby="id" placeholder="Enter id">
            <input type="hidden" class="form-control" value="<?php if(isset($approval_line_id)) echo $approval_line_id; ?>" id="approval_line_id" name="approval_line_id" aria-describedby="id" placeholder="Enter id">
           
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6"></div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <!-- <div class="card-header">Room Scheduling</div> -->
                            <!-- <div class="text-left">
                                <a href="approval_line"><button type="button" id="downloadpdf" name="downloadpdf" class="btn btn-primary"> Approval Line</button></a>
                                <button type="button" id="downloadpdf" name="downloadpdf" class="btn btn-primary" onclick="printTable()"> Save Temp</button>
                                <button type="button" id="downloadpdf" name="downloadpdf" class="btn btn-primary" onclick="printTable()"> Preview</button>
                                <button type="button" id="downloadpdf" name="downloadpdf" class="btn btn-primary" onclick="printTable()"><span class="icon-print"></span> PDF</button>
                            </div> -->
                            <br>   
                            <?php if($afterNotification <= 0){ ?> 
                                <div class="text-left" >
                                    <?php if($sstaffid != $staff_id ){ ?>
                                        <button type="submit" id="agreeBtn" name="agreeBtn" class="btn btn-primary" value="Submit" > Agree</button>
                                        <button type="submit" id="disagreeBtn" name="disagreeBtn" class="btn btn-primary" value="Submit" > Disagree</button>
                                    <?php } ?>
                                    <button type="button" id="downloadpdf" name="downloadpdf" class="btn btn-primary"><span class="icon-print"></span> PDF</button>
                                </div>
                            <?php } ?>
                            <br>
                            <div class="text-left">
                                <table border="1" style="width: 100%">
                                    <tr>
                                        <th rowspan="3">Approve</th>
                                        <th style="width: 20%; height: 30px;">Drafter</th>
                                        <th style="width: 20%; height: 30px;">Checker</th>
                                        <th style="width: 20%; height: 30px;">Review</th>
                                        <th style="width: 20%; height: 30px;">Approval</th>
                                    </tr>
                                    <tr>
                                        <?php if($approval_staff_idLength == '2'){ ?>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="drafter_nameApp" name="drafter_nameApp" value="<?php if($dashupd>0){ echo getStaffName($mysqli, $staff_id); } ?>" class="form-control"> </td>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="checker_nameApp" name="checker_nameApp" value="<?php if($dashupd>0){ echo getStaffName($mysqli, $approval_staff_idArr[0]); } ?>" class="form-control"> </td>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="reviewer_nameApp" name="reviewer_nameApp" value="" class="form-control"> </td>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="approvar_nameApp" name="approvar_nameApp" value="<?php if($dashupd>0){ echo getStaffName($mysqli, $approval_staff_idArr[1]); } ?>" class="form-control"> </td>
                                            <tr>
                                                <td style="width: 20%; height: 30px;"> <input readonly type="text" id="drafter_dateApp" name="drafter_dateApp" value="<?php if($dashupd>0){ if($drafter_approval_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($drafter_approval_date)); } ?>" class="form-control"> </td>

                                                <?php 
                                                if($dashupd>0){
                                                    if($checker_approval === '0'){
                                                        $status ="";
                                                    }elseif ($checker_approval === '1'){
                                                        $status = date('d-m-Y',strtotime($checker_approval_date));
                                                        $color = "green";
                                                    } elseif ($checker_approval === '2') {
                                                        $status = date('d-m-Y',strtotime($checker_approval_date));
                                                        $color = "red";
                                                    } 

                                                    if($final_approval === '0'){
                                                        $status1 ="";
                                                    }elseif ($final_approval === '1'){
                                                        $status1 = date('d-m-Y',strtotime($final_approval_date));
                                                        $color1 = "green";
                                                    } elseif ($final_approval === '2') {
                                                        $status1 = date('d-m-Y',strtotime($final_approval_date));
                                                        $color1 = "red";
                                                    } 

                                                    if($reviewer_approval === '0'){
                                                        $status2 ="";
                                                    }elseif ($reviewer_approval === '1'){
                                                        $status2 = date('d-m-Y',strtotime($reviewer_approval_date));
                                                        $color2 = "green";
                                                    } elseif ($reviewer_approval === '2') {
                                                        $status2 = date('d-m-Y',strtotime($reviewer_approval_date));
                                                        $color2 = "red";
                                                    } 
                                                }
                                                ?>

                                                <!-- approvaed rejected if condition -->                                                                                        
                                                <td style="width: 20%; height: 30px;"> <input style="color: <?php echo $color; ?>" readonly type="text" id="checker_dateApp" name="checker_dateApp" value="<?php echo $status; ?>" class="form-control"> </td>
                                                <!-- <td style="width: 20%; height: 30px;"> <input readonly type="text" id="checker_dateApp" name="checker_dateApp" value="<?php if($dashupd>0){ if($checker_approval_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($checker_approval_date)); } ?>" class="form-control"> </td> -->
                                                <td style="width: 20%; height: 30px;"> <input style="color: <?php echo $color2; ?>" readonly type="text" id="reviewer_dateApp" name="reviewer_dateApp" value="<?php echo $status2; ?>" class="form-control"> </td>
                                                <td style="width: 20%; height: 30px;"> <input style="color: <?php echo $color1; ?>" readonly type="text" id="approvar_dateApp" name="approvar_dateApp" value="<?php echo $status1; ?>" class="form-control"> </td>

                                            </tr>
                                            <?php } else if($approval_staff_idLength == '3'){ ?>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="drafter_nameApp" name="drafter_nameApp"value="<?php if($dashupd>0){ echo getStaffName($mysqli, $staff_id); } ?>" class="form-control"> </td>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="checker_nameApp" name="checker_nameApp" value="<?php if($dashupd>0){ echo getStaffName($mysqli, $approval_staff_idArr[0]); } ?>" class="form-control"> </td>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="reviewer_nameApp" name="reviewer_nameApp" value="<?php if($dashupd>0){ echo getStaffName($mysqli, $approval_staff_idArr[1]); } ?>" class="form-control"> </td>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="approvar_nameApp" name="approvar_nameApp" value="<?php if($dashupd>0){ echo getStaffName($mysqli, $approval_staff_idArr[2]); } ?>" class="form-control"> </td>
                                            <tr>
                                                <td style="width: 20%; height: 30px;"> <input readonly type="text" id="drafter_dateApp" name="drafter_dateApp" value="<?php if($dashupd>0){ if($drafter_approval_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($drafter_approval_date)); } ?>" class="form-control"> </td>
                                                <td style="width: 20%; height: 30px;"> <input readonly type="text" id="checker_dateApp" name="checker_dateApp" value="<?php if($dashupd>0){ if($checker_approval_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($checker_approval_date)); } ?>" class="form-control"> </td>
                                                <td style="width: 20%; height: 30px;"> <input readonly type="text" id="reviewer_dateApp" name="reviewer_dateApp" value="<?php if($dashupd>0){ if($reviewer_approval_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($reviewer_approval_date)); } ?>" class="form-control"> </td>
                                                <td style="width: 20%; height: 30px;"> <input readonly type="text" id="approvar_dateApp" name="approvar_dateApp" value="<?php if($dashupd>0){ if($final_approval_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($final_approval_date)); } ?>" class="form-control"> </td>
                                            </tr>
                                            <?php } ?>
                                    </tr>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">  
                        <div class="row">
                            <table border="1" style="width: 100%">
                                <tr>
                                    <th style="width: 15%; height: 30px;" rowspan="5">Parellel Agreement</th>
                                </tr>
                                <tr>
                                    <?php for($j=0;$j<count($agree_par_staff_idArr);$j++) { ?>
                                        <td style="width: 10%; height: 30px;"> <input  readonly type="text" id="agreeParallel_nameArr" name="agreeParallel_nameArr[]" value="<?php if($dashupd>0){ echo getStaffName($mysqli, $agree_par_staff_idArr[$j]); } ?>" class="form-control">  </td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <?php for($j=0;$j<count($agree_par_staff_idArr);$j++) { 

                                        $agree_disagree='';
                                        $agree_disagree_date='';
                                        $getqry = "SELECT agree_disagree, agree_disagree_date FROM approval_requisition_parallel_agree_disagree 
                                        WHERE agree_disagree_staff_id ='".strip_tags($agree_par_staff_idArr[$j])."' 
                                        AND status = 0";
                                        $res = $mysqli->query($getqry) or die("Error in Get All Records".$mysqli->error);
                                        while($row = $res->fetch_assoc())
                                        {
                                            $agree_disagree = $row["agree_disagree"];        
                                            $agree_disagree_date = $row["agree_disagree_date"];        
                                        }

                                        if($agree_disagree === '0'){
                                            $status ="";
                                        }elseif ($agree_disagree === '1'){
                                            $color = "green";
                                        } elseif ($agree_disagree === '2') {
                                            $color = "red";
                                        } 

                                        ?>
                                        <td style="width: 10%; height: 30px;"> <input style="color: <?php echo $color; ?>" readonly type="text" id="agreeParallel_dateArr" name="agreeParallel_dateArr[]" value="<?php if($dashupd>0){ if($agree_disagree_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($agree_disagree_date)); } ?>" class="form-control"> </td>
                                    <?php } ?>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <br>
                    <br>
                    <br>

                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="inputReadOnly">Reference</label>
                                <div style="border: 2px solid black; height:200px;">
                                    <table class="border-collapse:collapse">
                                        <?php  
                                        if(isset($after_notified_staff_idArr)){
                                            for($o=0; $o<=sizeof($after_notified_staff_idArr)-1; $o++){ ?>
                                                <tbody>
                                                    <span style="border-style : hidden!important;"><input readonly type="text" style="border: 0; outline:none; background-color: #f7f8fa;" class="form-control" value="<?php if($dashupd>0){ echo getStaffName($mysqli, $after_notified_staff_idArr[$o]); } ?>" name="after_notified_staff_idArr[]" id="after_notified_staff_idArr"></span>
                                                </tbody>
                                                <?php 
                                            }
                                        } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="inputReadOnly">Receiving Department</label>
                                <div style="border: 2px solid black; height:200px;">
                                <table class="border-collapse:collapse">
                                    <?php  
                                    if(isset($receiving_dept_idArr)){
                                        for($o=0; $o<=sizeof($receiving_dept_idArr)-1; $o++){ ?>
                                            <tbody>
                                                <span style="border-style : hidden!important;"><input readonly type="text" style="border: 0; outline:none; background-color: #f7f8fa;" class="form-control" value="<?php if($dashupd>0){ echo getDeptName($mysqli, $receiving_dept_idArr[$o]); } ?>" name="receiving_dept_idArr[]" id="receiving_dept_idArr"></span>
                                            </tbody>
                                            <?php 
                                        }
                                    } ?>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>
                    <br>
                    <br>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">  
                        <div class="row">
                            <table border="1" style="width: 100%">
                                <tr>
                                    <th style="width: 25%; height: 30px;">Drafter</th>
                                    <th style="width: 25%; height: 30px;">Drafter Dept</th>
                                    <th style="width: 25%; height: 30px;">Doc No</th>
                                    <th style="width: 25%; height: 30px;">Auto Generation</th>
                                </tr>
                                <tr>
                                    <input type="hidden" name="staffid" id="staffid" value="<?php echo $sstaffid; ?>" class="form-control">
                                    <td style="width: 25%; height: 30px;"><input readonly type="text" id="drafter_name" name="drafter_name" value="<?php if($dashupd>0){ echo getStaffName($mysqli, $staff_id); } ?>" class="form-control"></td>
                                    <td style="width: 25%; height: 30px;"><input readonly type="text" id="drafter_department" name="drafter_department" value="<?php if($dashupd>0){ echo getDeptName($mysqli, $staff_id); } ?>" class="form-control"></td>
                                    <td style="width: 25%; height: 30px;"><input readonly type="text" id="doc_no" name="doc_no" class="form-control" value="<?php if(isset($doc_no)) echo $doc_no; ?>"></td>
                                    <td style="width: 25%; height: 30px;"><input readonly type="text" id="auto_generation_date" name="auto_generation_date" class="form-control" value="<?php if(isset($auto_generation_date)) echo $auto_generation_date; ?>" ></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <!-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"> -->
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label for="inputReadOnly">Title</label>
                                <input readonly type="text" class="form-control" id="title" name="title" value="<?php if(isset($title)) echo $title; ?>">
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12"></div>
                
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="label">Comments</label>
                                <textarea disabled tabindex="1" id="comments" name="comments" class="form-control" placeholder="Enter Comments" rows="4" cols="50" value="<?php if(isset($comments)) echo $comments; ?>"><?php if(isset($comments)) echo $comments; ?></textarea>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="form-group">
                                <label class="label">Attachment</label>
                                <input class="form-control" type="file" multiple name="file[]" id="file" onchange="javascript:updateList()" />
                            </div>
                        </div>
                        
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12"></div>
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12">
                            <div class="form-group">
                                <label for="inputReadOnly">List Of Attached File</label>
                                    <div style="border: 2px solid black; height:auto;padding:20px;" id="fileList">
                                    <?php
                                        $s_array = explode(",",$file); 
                                        foreach($s_array as $file)
                                    { ?>
                                    <a href="uploads/approval_requisition/<?php echo $approval_line_id; ?>/<?php echo $file; ?>" download><li><?php echo $file; ?></li></a>
							        <?php } ?>
                                </div>  
                            </div>
                        </div>
                    </div>
                        

                </div>
            </div>
        </form>
    </div>

    <div style="display: none;" id="printApprovalRequisition"></div>

<?php } else { ?>
    <div class="main-container">
    <!-- form start -->
    <form id="customer" name="customer" action="" method="post" enctype="multipart/form-data">	
        <?php
        if($idupd>0)
        { ?>
            <input type="hidden" class="form-control" value="<?php if(isset($idupd)) echo $idupd; ?>"  id="idupd" name="idupd" aria-describedby="id" placeholder="Enter id">
        <?php }
        ?>
        <input type="hidden" class="form-control" value="<?php if(isset($approval_line_id)) echo $approval_line_id; ?>" id="approval_line_id" name="approval_line_id" aria-describedby="id" placeholder="Enter id">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6"></div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                        <?php if($idupd<=0) { ?>
                            <div class="text-left">
                                <a href="meeting_minutes_approval_line"><button type="button" id="downloadpdf" name="downloadpdf" class="btn btn-primary"> Approval Line</button></a>
                                <!-- <button type="button" id="downloadpdf" name="downloadpdf" class="btn btn-primary" onclick="printTable()"> Save Temp</button>
                                <button type="button" id="downloadpdf" name="downloadpdf" class="btn btn-primary" onclick="printTable()"> Preview</button>
                                <button type="button" id="downloadpdf" name="downloadpdf" class="btn btn-primary" onclick="printTable()"><span class="icon-print"></span> PDF</button> -->
                            </div>
                        <?php } ?>
                        <br>    
                        <!-- <div class="text-left" >
                            <button type="button" id="downloadpdf" name="downloadpdf" class="btn btn-primary" onclick="printTable()"> Agree</button>
                            <button type="button" id="downloadpdf" name="downloadpdf" class="btn btn-primary" onclick="printTable()"> Disagree</button>
                        </div> -->
                        <br>
                        <div class="text-left">
                            <table border="1" style="width: 100%">
                                <tr>
                                    <th rowspan="3">Approve</th>
                                    <th style="width: 20%; height: 30px;">Drafter</th>
                                    <th style="width: 20%; height: 30px;">Checker</th>
                                    <th style="width: 20%; height: 30px;">Review</th>
                                    <th style="width: 20%; height: 30px;">Approval</th>
                                </tr>
                                <tr>
                                    <?php
                                    if($idupd>0){
                                        if($approval_staff_idLength == '2'){ ?>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="drafter_nameApp" name="drafter_nameApp" value="" class="form-control"> </td>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="checker_nameApp" name="checker_nameApp" value="<?php if($idupd>0){ echo getStaffName($mysqli, $approval_staff_idArr[0]); } ?>" class="form-control"> </td>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="reviewer_nameApp" name="reviewer_nameApp" value="" class="form-control"> </td>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="approvar_nameApp" name="approvar_nameApp" value="<?php if($idupd>0){ echo getStaffName($mysqli, $approval_staff_idArr[1]); } ?>" class="form-control"> </td>
                                            <tr>
                                                <td style="width: 20%; height: 30px;"></td>
                                                <td style="width: 20%; height: 30px;"></td>
                                                <td style="width: 20%; height: 30px;"></td>
                                                <td style="width: 20%; height: 30px;"></td>
                                            </tr>
                                        <?php } else if($approval_staff_idLength == '3'){ ?>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="drafter_nameApp" name="drafter_nameApp" value="" class="form-control"> </td>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="checker_nameApp" name="checker_nameApp" value="<?php if($idupd>0){ echo getStaffName($mysqli, $approval_staff_idArr[0]); } ?>" class="form-control"> </td>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="reviewer_nameApp" name="reviewer_nameApp" value="<?php if($idupd>0){ echo getStaffName($mysqli, $approval_staff_idArr[1]); } ?>" class="form-control"> </td>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="approvar_nameApp" name="approvar_nameApp" value="<?php if($idupd>0){ echo getStaffName($mysqli, $approval_staff_idArr[2]); } ?>" class="form-control"> </td>
                                            <tr>
                                                <td style="width: 20%; height: 30px;"></td>
                                                <td style="width: 20%; height: 30px;"></td>
                                                <td style="width: 20%; height: 30px;"></td>
                                                <td style="width: 20%; height: 30px;"></td>
                                            </tr>
                                    <?php } } else { ?>
                                        <td style="width: 20%; height: 30px;"></td>
                                        <td style="width: 20%; height: 30px;"></td>
                                        <td style="width: 20%; height: 30px;"></td>
                                        <td style="width: 20%; height: 30px;"></td>
                                        <tr>
                                            <td style="width: 20%; height: 30px;"></td>
                                            <td style="width: 20%; height: 30px;"></td>
                                            <td style="width: 20%; height: 30px;"></td>
                                            <td style="width: 20%; height: 30px;"></td>
                                        </tr>
                                    <?php } ?>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <br>
                <br>
                <br>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">  
                    <div class="row">
                        <table border="1" style="width: 100%">
                            <tr>
                                <th style="width: 15%; height: 30px;" rowspan="5">Parellel Agreement</th>
                            </tr>
                            <tr>
                                <?php
                                if($idupd>0){
                                    for($j=0;$j<count($agree_par_staff_idArr);$j++) { ?>
                                        <td style="width: 10%; height: 30px;"> <input readonly type="text" id="agreeParallel_nameArr" name="agreeParallel_nameArr[]" value="<?php if($idupd>0){ echo getStaffName($mysqli, $agree_par_staff_idArr[$j]); } ?>" class="form-control">  </td>
                                    <?php } 
                                } else { ?>
                                    <td style="width: 10%; height: 30px;"> <input readonly type="text" id="agreeParallel_nameArr" name="agreeParallel_nameArr[]" value="<?php if($idupd>0){ echo getStaffName($mysqli, $agree_par_staff_idArr[$j]); } ?>" class="form-control">  </td>
                                    <td style="width: 10%; height: 30px;"> <input readonly type="text" id="agreeParallel_nameArr" name="agreeParallel_nameArr[]" value="<?php if($idupd>0){ echo getStaffName($mysqli, $agree_par_staff_idArr[$j]); } ?>" class="form-control">  </td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <?php
                                if($idupd>0){
                                for($j=0;$j<count($agree_par_staff_idArr);$j++) { ?>
                                    <td style="width: 10%; height: 30px;"> <input readonly type="text" id="agreeParallel_dateArr" name="agreeParallel_dateArr[]" value="<?php // if($idupd>0){ echo getStaffName($mysqli, $agree_par_staff_idArr[$j]); } ?>" class="form-control"> </td>
                                <?php } 
                                 } else { ?>
                                     <td style="width: 10%; height: 30px;"> <input readonly type="text" id="agreeParallel_dateArr" name="agreeParallel_dateArr[]" value="<?php // if($idupd>0){ echo getStaffName($mysqli, $agree_par_staff_idArr[$j]); } ?>" class="form-control"> </td>
                                     <td style="width: 10%; height: 30px;"> <input readonly type="text" id="agreeParallel_dateArr" name="agreeParallel_dateArr[]" value="<?php // if($idupd>0){ echo getStaffName($mysqli, $agree_par_staff_idArr[$j]); } ?>" class="form-control"> </td>
                                <?php } ?>
                            </tr>
                        </table>
                    </div>
                </div>

                <br>
                <br>
                <br>

                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="inputReadOnly">Reference</label>
                            <div style="border: 2px solid black; height:200px;">
                                <table class="border-collapse:collapse">
                                    <?php  
                                    if(isset($after_notified_staff_idArr)){
                                        for($o=0; $o<=sizeof($after_notified_staff_idArr)-1; $o++){ ?>
                                            <tbody>
                                                <span style="border-style : hidden!important;"><input readonly type="text" style="border: 0; outline:none; background-color: #f7f8fa;" class="form-control" value="<?php if($idupd>0){ echo getStaffName($mysqli, $after_notified_staff_idArr[$o]); } ?>" name="after_notified_staff_idArr[]" id="after_notified_staff_idArr"></span>
                                            </tbody>
                                            <?php 
                                        }
                                    } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="inputReadOnly">Receiving Department</label>
                            <div style="border: 2px solid black; height:200px;">
                            <table class="border-collapse:collapse">
                                <?php  
                                if(isset($receiving_dept_idArr)){
                                    for($o=0; $o<=sizeof($receiving_dept_idArr)-1; $o++){ ?>
                                        <tbody>
                                            <span style="border-style : hidden!important;"><input readonly type="text" style="border: 0; outline:none; background-color: #f7f8fa;" class="form-control" value="<?php if($idupd>0){ echo getDeptName($mysqli, $receiving_dept_idArr[$o]); } ?>" name="receiving_dept_idArr[]" id="receiving_dept_idArr"></span>
                                        </tbody>
                                        <?php 
                                    }
                                } ?>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>

                <br>
                <br>
                <br>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">  
                    <div class="row">
                        <table border="1" style="width: 100%">
                            <tr>
                                <th style="width: 25%; height: 30px;">Drafter</th>
                                <th style="width: 25%; height: 30px;">Drafter Dept</th>
                                <th style="width: 25%; height: 30px;">Doc No</th>
                                <th style="width: 25%; height: 30px;">Auto Generation</th>
                            </tr>
                            <tr>
                                <input type="hidden" name="staffid" id="staffid" value="<?php echo $sstaffid; ?>" class="form-control">
                                <td style="width: 25%; height: 30px;"><input readonly type="text" id="drafter_name" name="drafter_name" value="" class="form-control"></td>
                                <td style="width: 25%; height: 30px;"><input readonly type="text" id="drafter_department" name="drafter_department" class="form-control"></td>
                                <td style="width: 25%; height: 30px;"><input readonly type="text" id="doc_no" name="doc_no" class="form-control"></td>
                                <td style="width: 25%; height: 30px;"><input readonly type="text" id="auto_generation_date" name="auto_generation_date" class="form-control" value="<?php date_default_timezone_set('Asia/Kolkata');  echo date('d-m-Y'); ?>"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <br>
                <br>
                <br>
                <!-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"> -->
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label for="inputReadOnly">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?php if(isset($title)) echo $title; ?>">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12"></div>
            
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <label class="label">Comments</label>
                            <textarea tabindex="1" id="comments" name="comments" class="form-control" placeholder="Enter Comments" rows="4" cols="50" value="<?php if(isset($message)) echo $message; ?>"><?php if(isset($message)) echo $message; ?></textarea>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                        <div class="form-group">
                            <label class="label">Attachment</label>
                            <input class="form-control" type="file" multiple name="file[]" id="file" onchange="javascript:updateList()" />
                        </div>
                    </div>
                    
                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12"></div>
                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12">
                        <div class="form-group">
                            <label for="inputReadOnly">List Of Attached File</label>
                                <div style="border: 2px solid black; height:auto;padding:20px;" id="fileList"></div>  
                        </div>
                    </div>
                </div>
                    
                <!-- </div> -->
                <?php 
                if($idupd > 0 && $sstaffid == $staff_id)
                { ?>
                    <div class="col-md-12">
                        <br><br>
                        <div class="text-right">
                            <!-- <button type="submit" name="approvalRequisitionPrint" id="approvalRequisitionPrint" class="btn btn-outline-secondary" value="Submit" tabindex="4">Print</button> -->
                            <button type="submit" name="MeetingMinutesSubmit" id="MeetingMinutesSubmit" class="btn btn-primary" value="Submit" tabindex="4">Submit</button>
                            <!-- <button type="reset" class="btn btn-outline-secondary" tabindex="5" id='reset'>Cancel</button> -->
                        </div>
                        <br><br>
                    </div>
                <?php }
                ?>
                </div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script type="text/javascript">
        $('#comments').summernote({
            tabsize: 2,
            height: 120,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    </script>

<?php } ?>



