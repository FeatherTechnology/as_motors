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
// $getBusinessComLine = $userObj->getBusinessComLine($mysqli); 

$approval_staff_idArr=array();
$approval_staff_idLength=array();
$agree_par_staff_idArr=array();
$recipient_idArr=array();
$after_notified_staff_idArr=array();

 if(isset($_GET['upd']))
    { 
    $idupd=$_GET['upd'];

    $getBusinessComLine = $userObj->getBusinessComLine($mysqli, $idupd); 

    if (sizeof($getBusinessComLine)>0) {   
        for($a=0;$a<sizeof($getBusinessComLine);$a++) {	

            $business_com_line_id                = $getBusinessComLine['business_com_line_id'];
            $company_id                	         = $getBusinessComLine['company_id'];
            $staff_id                	         = $getBusinessComLine['staff_id'];
            $approval_staff_id                   = $getBusinessComLine['approval_staff_id'];
            $agree_par_staff_id		             = $getBusinessComLine['agree_par_staff_id'];
            $after_notified_staff_id		     = $getBusinessComLine['after_notified_staff_id'];
            $recipient_id		                 = $getBusinessComLine['recipient_id'];
        }
        // approval staff
        $approval_staff_idArr = array_map('intval', explode(',', $approval_staff_id));
        $approval_staff_idLength = sizeof($approval_staff_idArr);

        // parallel staff
        $agree_par_staff_idArr = array_map('intval', explode(',', $agree_par_staff_id));

        // receiving dept 
        $recipient_idArr = array_map('intval', explode(',', $recipient_id));

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
if(isset($_GET['dashupd']))
{   
    if(isset($_GET['parallel'])){
        $parallel=$_GET['parallel'];
    } 

    $dashupd=$_GET['dashupd'];
    $getBusinessComLine = $userObj->getBusinessComLine($mysqli, $dashupd); 
    if (sizeof($getBusinessComLine)>0) {   
        for($a=0;$a<sizeof($getBusinessComLine);$a++) {	
            $business_com_line_id	             = $getBusinessComLine['business_com_line_id'];
            $company_id                	         = $getBusinessComLine['company_id'];
            $staff_id                	         = $getBusinessComLine['staff_id'];
            $approval_staff_id                   = $getBusinessComLine['approval_staff_id'];
            $agree_par_staff_id		             = $getBusinessComLine['agree_par_staff_id'];
            $after_notified_staff_id		     = $getBusinessComLine['after_notified_staff_id'];
            $recipient_id		                 = $getBusinessComLine['recipient_id'];
            $drafter_approval_date		         = $getBusinessComLine['created_date'];
            $checker_approval_date		         = $getBusinessComLine['checker_approval_date'];
            $reviewer_approval_date		         = $getBusinessComLine['reviewer_approval_date'];
            $final_approval_date		         = $getBusinessComLine['final_approval_date'];
            $checker_approval		             = $getBusinessComLine['checker_approval'];
            $reviewer_approval		             = $getBusinessComLine['reviewer_approval'];
            $final_approval		                 = $getBusinessComLine['final_approval'];


            //  approval requisition
            //  $comments                  = getComments($mysqli, $getBusinessComLine['business_com_line_id	']);
            //  $doc_no                    = getDocNo($mysqli, $getBusinessComLine['business_com_line_id	']);
            //  $auto_generation_date      = getAutoGenDate($mysqli, $getBusinessComLine['business_com_line_id	']);
            //  $title                     = getTitle($mysqli, $getBusinessComLine['business_com_line_id	']);
            //  $drafterDate               = getDrafterDate($mysqli, $getBusinessComLine['business_com_line_id	']);
            //  $checkerDate               = getCheckerDate($mysqli, $getBusinessComLine['business_com_line_id	']);
            //  $reviewerDate              = getReviewerDate($mysqli, $getBusinessComLine['business_com_line_id	']);
            //  $finalApproverDate         = getFinalApproverDate($mysqli, $getBusinessComLine['business_com_line_id	']);
        }

        // get approval requisition 
        $getqry = "SELECT * FROM business_com_out WHERE business_approval_line_id ='".strip_tags($business_com_line_id)."' and status = 0";
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
        $recipient_idArr = array_map('intval', explode(',', $recipient_id));

        // after notified staff 
        $after_notified_staff_idArr = array_map('intval', explode(',', $after_notified_staff_id));
    } 
}

$id=0;
if(isset($_POST['approvalRequisitionSubmit']) && $_POST['approvalRequisitionSubmit'] != '')
{
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
        $updatekraCreation = $userObj->updatekraCreation($mysqli,$id,$userid);  
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_kra_creation&msc=2';</script> 
    <?php }
    else {   
        $addapprovalRequisition = $userObj->addapprovalRequisition($mysqli,$userid);   
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>approval_requisition';</script>
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
        $agreeApprovalRequisition = $userObj->parallelAgreeApprovalRequisition($mysqli, $userid);   
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
        $disagreeApprovalRequisition = $userObj->parallelDisagreeApprovalRequisition($mysqli, $userid);     
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
        <li class="breadcrumb-item">AS - Business Communication (Outgoing) </li>
    </ol>

    <!-- <a href="edit_kra_creation">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    </a> -->
</div>
<!-- Page header end -->
<?php if($dashupd > 0){ ?>
<!-- Main container start -->
<div class="main-container">
    <!-- form start -->
    <form id="customer" name="customer" action="" method="post" enctype="multipart/form-data">	
        <input type="hidden" class="form-control" value="<?php if(isset($dashupd)) echo $dashupd; ?>" id="idupd" name="idupd" aria-describedby="id" placeholder="Enter id">
        <input type="hidden" class="form-control" value="<?php if(isset($business_com_line_id)) echo $business_com_line_id; ?>" id="business_com_line_id" name="business_com_line_id" aria-describedby="id" placeholder="Enter id">
            					
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6"></div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                        <!-- <div class="card-header">Room Scheduling</div> -->
                        <!-- <div class="text-left">
                            <a href="business_com_approval_line"><button type="button" id="downloadpdf" name="downloadpdf" class="btn btn-primary"> Approval Line</button></a>
                            <button type="button" id="downloadpdf" name="downloadpdf" class="btn btn-primary" onclick="printTable()"> Save Temp</button>
                            <button type="button" id="downloadpdf" name="downloadpdf" class="btn btn-primary" onclick="printTable()"> Preview</button>
                            <button type="button" id="downloadpdf" name="downloadpdf" class="btn btn-primary" onclick="printTable()"><span class="icon-print"></span> PDF</button>
                        </div> -->
                        <br>    
                        <div class="text-left" >
                            <button type="button" id="downloadpdf" name="downloadpdf" class="btn btn-primary" onclick="printTable()"> Agree</button>
                            <button type="button" id="downloadpdf" name="downloadpdf" class="btn btn-primary" onclick="printTable()"> Disagree</button>
                        </div>
                        <br>
                        <!-- <div class="text-left">
                            <table border="1" style="width: 100%">
                                <tr>
                                    <th rowspan="3">Receive</th>
                                    <th style="width: 20%; height: 30px;">Drafter</th>
                                    <th style="width: 20%; height: 30px;">Checker</th>
                                    <th style="width: 20%; height: 30px;">Review</th>
                                    <th style="width: 20%; height: 30px;">Approval</th>
                                </tr>
                                <tr>
                                <?php if($recipient_idLength == '2'){ ?>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="drafter_nameApp" name="drafter_nameApp" value="<?php if($dashupd>0){ echo getStaffName($mysqli, $staff_id); } ?>" class="form-control"> </td>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="checker_nameApp" name="checker_nameApp" value="<?php if($dashupd>0){ echo getStaffName($mysqli, $recipient_idArr[0]); } ?>" class="form-control"> </td>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="reviewer_nameApp" name="reviewer_nameApp" value="" class="form-control"> </td>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="approvar_nameApp" name="approvar_nameApp" value="<?php if($dashupd>0){ echo getStaffName($mysqli, $recipient_idArr[1]); } ?>" class="form-control"> </td>
                                            <tr> -->
                                                <td style="width: 20%; height: 30px;"> <input readonly type="text" id="drafter_dateApp" name="drafter_dateApp" value="<?php if($dashupd>0){ if($drafter_approval_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($drafter_approval_date)); } ?>" class="form-control"> </td>

                                                <!-- approvaed rejected if condition -->
                                                <!-- <td style="width: 20%; height: 30px;"> <input readonly type="text" id="checker_dateApp" name="checker_dateApp" value="<?php if($dashupd>0){ if($checker_approval_date == ''){ echo ""; } else if($checker_approval == '1') { echo date('d-m-Y',strtotime($checker_approval_date))." (Approved)"; } else if($checker_approval == '2'){ echo date('d-m-Y',strtotime($checker_approval_date))." (Rejected)"; } } ?>" class="form-control"> </td> -->


                                                <!-- <td style="width: 20%; height: 30px;"> <input readonly type="text" id="checker_dateApp" name="checker_dateApp" value="<?php if($dashupd>0){ if($checker_approval_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($checker_approval_date)); } ?>" class="form-control"> </td>
                                                <td style="width: 20%; height: 30px;"> <input readonly type="text" id="reviewer_dateApp" name="reviewer_dateApp" value="<?php // if($dashupd>0){ echo date('d-m-Y',strtotime($reviewer_approval_date)); } ?>" class="form-control"> </td>
                                                <td style="width: 20%; height: 30px;"> <input readonly type="text" id="approvar_dateApp" name="approvar_dateApp" value="<?php if($dashupd>0){ if($final_approval_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($final_approval_date)); } ?>" class="form-control"> </td>
                                            </tr>
                                            <?php } else if($recipient_idLength == '3'){ ?>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="drafter_nameApp" name="drafter_nameApp" value="" class="form-control"> </td>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="checker_nameApp" name="checker_nameApp" value="<?php if($dashupd>0){ echo getStaffName($mysqli, $recipient_idArr[0]); } ?>" class="form-control"> </td>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="reviewer_nameApp" name="reviewer_nameApp" value="<?php if($dashupd>0){ echo getStaffName($mysqli, $recipient_idArr[1]); } ?>" class="form-control"> </td>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="approvar_nameApp" name="approvar_nameApp" value="<?php if($dashupd>0){ echo getStaffName($mysqli, $recipient_idArr[2]); } ?>" class="form-control"> </td>
                                            <tr>
                                                <td style="width: 20%; height: 30px;"> <input readonly type="text" id="drafter_dateApp" name="drafter_dateApp" value="<?php if($dashupd>0){ if($drafter_approval_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($drafter_approval_date)); } ?>" class="form-control"> </td>
                                                <td style="width: 20%; height: 30px;"> <input readonly type="text" id="checker_dateApp" name="checker_dateApp" value="<?php if($dashupd>0){ if($checker_approval_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($checker_approval_date)); } ?>" class="form-control"> </td>
                                                <td style="width: 20%; height: 30px;"> <input readonly type="text" id="reviewer_dateApp" name="reviewer_dateApp" value="<?php if($dashupd>0){ if($reviewer_approval_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($reviewer_approval_date)); } ?>" class="form-control"> </td>
                                                <td style="width: 20%; height: 30px;"> <input readonly type="text" id="approvar_dateApp" name="approvar_dateApp" value="<?php if($dashupd>0){ if($final_approval_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($final_approval_date)); } ?>" class="form-control"> </td>
                                            </tr>
                                            <?php } ?>
                                </tr>

                            </table>
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
                                        <?php if($approval_staff_idLength == '2'){ ?>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="drafter_nameApp" name="drafter_nameApp" value="<?php if($dashupd>0){ echo getStaffName($mysqli, $staff_id); } ?>" class="form-control"> </td>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="checker_nameApp" name="checker_nameApp" value="<?php if($dashupd>0){ echo getStaffName($mysqli, $approval_staff_idArr[0]); } ?>" class="form-control"> </td>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="reviewer_nameApp" name="reviewer_nameApp" value="" class="form-control"> </td>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="approvar_nameApp" name="approvar_nameApp" value="<?php if($dashupd>0){ echo getStaffName($mysqli, $approval_staff_idArr[1]); } ?>" class="form-control"> </td>
                                            <tr>
                                                <td style="width: 20%; height: 30px;"> <input readonly type="text" id="drafter_dateApp" name="drafter_dateApp" value="<?php if($dashupd>0){ if($drafter_approval_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($drafter_approval_date)); } ?>" class="form-control"> </td>

                                                <!-- approvaed rejected if condition -->
                                                <!-- <td style="width: 20%; height: 30px;"> <input readonly type="text" id="checker_dateApp" name="checker_dateApp" value="<?php if($dashupd>0){ if($checker_approval_date == ''){ echo ""; } else if($checker_approval == '1') { echo date('d-m-Y',strtotime($checker_approval_date))." (Approved)"; } else if($checker_approval == '2'){ echo date('d-m-Y',strtotime($checker_approval_date))." (Rejected)"; } } ?>" class="form-control"> </td> -->


                                                <td style="width: 20%; height: 30px;"> <input readonly type="text" id="checker_dateApp" name="checker_dateApp" value="<?php if($dashupd>0){ if($checker_approval_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($checker_approval_date)); } ?>" class="form-control"> </td>
                                                <td style="width: 20%; height: 30px;"> <input readonly type="text" id="reviewer_dateApp" name="reviewer_dateApp" value="<?php // if($dashupd>0){ echo date('d-m-Y',strtotime($reviewer_approval_date)); } ?>" class="form-control"> </td>
                                                <td style="width: 20%; height: 30px;"> <input readonly type="text" id="approvar_dateApp" name="approvar_dateApp" value="<?php if($dashupd>0){ if($final_approval_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($final_approval_date)); } ?>" class="form-control"> </td>
                                            </tr>
                                            <?php } else if($approval_staff_idLength == '3'){ ?>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="drafter_nameApp" name="drafter_nameApp" value="" class="form-control"> </td>
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
                                        <td style="width: 10%; height: 30px;"> <input readonly type="text" id="agreeParallel_nameArr" name="agreeParallel_nameArr[]" value="<?php if($dashupd>0){ echo getStaffName($mysqli, $agree_par_staff_idArr[$j]); } ?>" class="form-control">  </td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <?php for($j=0;$j<count($agree_par_staff_idArr);$j++) { ?>
                                        <td style="width: 10%; height: 30px;"> <input readonly type="text" id="agreeParallel_dateArr" name="agreeParallel_dateArr[]" value="<?php // if($dashupd>0){ echo getStaffName($mysqli, $agree_par_staff_idArr[$j]); } ?>" class="form-control"> </td>
                                    <?php } ?>
                                </tr>
                            </table>
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
                                    <td style="width: 25%; height: 30px;"><input readonly type="date" id="doc_no" name="doc_no" class="form-control" value="<?php if(isset($doc_no)) echo $doc_no; ?>"></td>
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
                                    <a href="uploads/approval_requisition/<?php echo  $business_com_line_id; ?>/<?php echo  $file; ?>" download><li><?php echo  $file; ?></li></a>
							        <?php }?>
                                </div>  
                            </div>
                        </div>
                    </div>
                        
                    <!-- </div> -->
                    <?php 
                    if($dashupd > 0 && $sstaffid == $staff_id)
                    { ?>
                        <div class="col-md-12">
                            <br><br>
                            <div class="text-right">
                                <!-- <button type="submit" name="approvalRequisitionPrint" id="approvalRequisitionPrint" class="btn btn-outline-secondary" value="Submit" tabindex="4">Print</button> -->
                                <!-- <button type="submit" name="approvalRequisitionSubmit" id="approvalRequisitionSubmit" class="btn btn-primary" value="Submit" tabindex="4">Submit</button> -->
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
    <?php } else { ?>
        <!-- Main container start -->
<div class="main-container">
    <!-- form start -->
    <form id="customer" name="customer" action="" method="post" enctype="multipart/form-data">	
        <?php
        if($idupd>0)
        { ?>
            <input type="hidden" class="form-control" value="<?php if(isset($idupd)) echo $idupd; ?>"  id="idupd" name="idupd" aria-describedby="id" placeholder="Enter id">
        <?php }
        ?>
        <input type="hidden" class="form-control" value="<?php if(isset($business_com_line_id)) echo $business_com_line_id; ?>"  id="business_com_line_id" name="business_com_line_id" aria-describedby="id" placeholder="Enter id">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6"></div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                        <!-- <div class="card-header">Room Scheduling</div> -->
                        <div class="text-left">
                            <a href="business_com_approval_line"><button type="button" id="downloadpdf" name="downloadpdf" class="btn btn-primary"> Approval Line</button></a>
                            <button type="button" id="downloadpdf" name="downloadpdf" class="btn btn-primary" onclick="printTable()"> Save Temp</button>
                            <button type="button" id="downloadpdf" name="downloadpdf" class="btn btn-primary" onclick="printTable()"> Preview</button>
                            <button type="button" id="downloadpdf" name="downloadpdf" class="btn btn-primary" onclick="printTable()"><span class="icon-print"></span> PDF</button>
                        </div>
                        <br>    
                        <!-- <div class="text-left" >
                            <button type="button" id="downloadpdf" name="downloadpdf" class="btn btn-primary" onclick="printTable()"> Agree</button>
                            <button type="button" id="downloadpdf" name="downloadpdf" class="btn btn-primary" onclick="printTable()"> Disagree</button>
                        </div> -->
                        <!-- <div class="text-left">
                            <table border="1" style="width: 100%"> -->
                                <!-- <tr>
                                    <th rowspan="3">Receive</th>
                                    <th style="width: 20%; height: 30px;">Drafter</th>
                                    <th style="width: 20%; height: 30px;">Checker</th>
                                    <th style="width: 20%; height: 30px;">Review</th>
                                    <th style="width: 20%; height: 30px;">Approval</th>
                                </tr>
                                <tr>
                                <?php if($recipient_idLength == '2'){ ?>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="drafter_nameApp" name="drafter_nameApp" value="<?php if($dashupd>0){ echo getStaffName($mysqli, $staff_id); } ?>" class="form-control"> </td>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="checker_nameApp" name="checker_nameApp" value="<?php if($dashupd>0){ echo getStaffName($mysqli, $recipient_idArr[0]); } ?>" class="form-control"> </td>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="reviewer_nameApp" name="reviewer_nameApp" value="" class="form-control"> </td>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="approvar_nameApp" name="approvar_nameApp" value="<?php if($dashupd>0){ echo getStaffName($mysqli, $recipient_idArr[1]); } ?>" class="form-control"> </td>
                                            <tr>
                                                <td style="width: 20%; height: 30px;"> <input readonly type="text" id="drafter_dateApp" name="drafter_dateApp" value="<?php if($dashupd>0){ if($drafter_approval_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($drafter_approval_date)); } ?>" class="form-control"> </td> -->

                                                <!-- approvaed rejected if condition -->
                                                <!-- <td style="width: 20%; height: 30px;"> <input readonly type="text" id="checker_dateApp" name="checker_dateApp" value="<?php if($dashupd>0){ if($checker_approval_date == ''){ echo ""; } else if($checker_approval == '1') { echo date('d-m-Y',strtotime($checker_approval_date))." (Approved)"; } else if($checker_approval == '2'){ echo date('d-m-Y',strtotime($checker_approval_date))." (Rejected)"; } } ?>" class="form-control"> </td> -->


                                                <!-- <td style="width: 20%; height: 30px;"> <input readonly type="text" id="checker_dateApp" name="checker_dateApp" value="<?php if($dashupd>0){ if($checker_approval_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($checker_approval_date)); } ?>" class="form-control"> </td>
                                                <td style="width: 20%; height: 30px;"> <input readonly type="text" id="reviewer_dateApp" name="reviewer_dateApp" value="<?php // if($dashupd>0){ echo date('d-m-Y',strtotime($reviewer_approval_date)); } ?>" class="form-control"> </td>
                                                <td style="width: 20%; height: 30px;"> <input readonly type="text" id="approvar_dateApp" name="approvar_dateApp" value="<?php if($dashupd>0){ if($final_approval_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($final_approval_date)); } ?>" class="form-control"> </td>
                                            </tr>
                                            <?php } else if($recipient_idLength == '3'){ ?>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="drafter_nameApp" name="drafter_nameApp" value="" class="form-control"> </td>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="checker_nameApp" name="checker_nameApp" value="<?php if($dashupd>0){ echo getStaffName($mysqli, $recipient_idArr[0]); } ?>" class="form-control"> </td>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="reviewer_nameApp" name="reviewer_nameApp" value="<?php if($dashupd>0){ echo getStaffName($mysqli, $recipient_idArr[1]); } ?>" class="form-control"> </td>
                                            <td style="width: 20%; height: 50px;"> <input readonly type="text" id="approvar_nameApp" name="approvar_nameApp" value="<?php if($dashupd>0){ echo getStaffName($mysqli, $recipient_idArr[2]); } ?>" class="form-control"> </td>
                                            <tr>
                                                <td style="width: 20%; height: 30px;"> <input readonly type="text" id="drafter_dateApp" name="drafter_dateApp" value="<?php if($dashupd>0){ if($drafter_approval_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($drafter_approval_date)); } ?>" class="form-control"> </td>
                                                <td style="width: 20%; height: 30px;"> <input readonly type="text" id="checker_dateApp" name="checker_dateApp" value="<?php if($dashupd>0){ if($checker_approval_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($checker_approval_date)); } ?>" class="form-control"> </td>
                                                <td style="width: 20%; height: 30px;"> <input readonly type="text" id="reviewer_dateApp" name="reviewer_dateApp" value="<?php if($dashupd>0){ if($reviewer_approval_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($reviewer_approval_date)); } ?>" class="form-control"> </td>
                                                <td style="width: 20%; height: 30px;"> <input readonly type="text" id="approvar_dateApp" name="approvar_dateApp" value="<?php if($dashupd>0){ if($final_approval_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($final_approval_date)); } ?>" class="form-control"> </td>
                                            </tr>
                                            <?php } ?>
                                </tr> -->
                            <!-- </table>
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
                                <td style="width: 25%; height: 30px;"><input readonly type="date" id="doc_no" name="doc_no" class="form-control"></td>
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
                            <button type="submit" name="approvalRequisitionSubmit" id="approvalRequisitionSubmit" class="btn btn-primary" value="Submit" tabindex="4">Submit</button>
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
      var date = new Date();

var day = date.getDate();
var month = date.getMonth() + 1;
var year = date.getFullYear();

if (month < 10) month = "0" + month;
if (day < 10) day = "0" + day;

var today = year + "-" + month + "-" + day;


document.getElementById('theDate').value = today;
</script>


<?php } ?>