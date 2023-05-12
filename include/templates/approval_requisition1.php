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
$departmentList = $userObj->getDepartment($mysqli); 
$designationList = $userObj->getDesignation($mysqli);

$approvalRequisitionApproveStaff = $userObj->getApprovalRequisitionApproveStaff($mysqli); 
if (sizeof($approvalRequisitionApproveStaff)>0) {   
    for($a=0;$a<sizeof($approvalRequisitionApproveStaff);$a++) {	
        $approval_line_id                    = $approvalRequisitionApproveStaff['approval_line_id'];
        $company_id                	         = $approvalRequisitionApproveStaff['company_id'];
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
    // $agree_par_staff_idLength = sizeof($agree_par_staff_idArr);
}

// $approvalRequisitionParallelStaff = $userObj->getApprovalRequisitionParallelStaff($mysqli); 

$id=0;
if(isset($_POST['submitKraCreation']) && $_POST['submitKraCreation'] != '')
{
    if(isset($_POST['id']) && $_POST['id'] >0 && is_numeric($_POST['id'])){		
        $id = $_POST['id']; 	
        $updatekraCreation = $userObj->updatekraCreation($mysqli,$id,$userid);  
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_kra_creation&msc=2';</script> 
    <?php }
    else {   
        $addkraCreation = $userObj->addkraCreation($mysqli,$userid);   
        ?>
        <script>location.href='<?php echo $HOSTPATH; ?>edit_kra_creation&msc=1';</script>
        <?php
    }
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


?> 
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
   
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Approval Requisition </li>
    </ol>

    <a href="edit_kra_creation">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
    </a>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
    <!-- form start -->
    <form id="customer" name="customer" action="" method="post" enctype="multipart/form-data">						
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6"></div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                        <!-- <div class="card-header">Room Scheduling</div> -->
                        <div class="text-left">
                            <a href="approval_line"><button type="button" id="downloadpdf" name="downloadpdf" class="btn btn-primary"> Approval Line</button></a>
                            <button type="button" id="downloadpdf" name="downloadpdf" class="btn btn-primary" onclick="printTable()"> Save Temp</button>
                            <button type="button" id="downloadpdf" name="downloadpdf" class="btn btn-primary" onclick="printTable()"> Preview</button>
                            <button type="button" id="downloadpdf" name="downloadpdf" class="btn btn-primary" onclick="printTable()"><span class="icon-print"></span> PDF</button>
                        </div>
                        <br>    
                        <div class="text-left" >
                            <button type="button" id="downloadpdf" name="downloadpdf" class="btn btn-primary" onclick="printTable()"> Agree</button>
                            <button type="button" id="downloadpdf" name="downloadpdf" class="btn btn-primary" onclick="printTable()"> Disagree</button>
                        </div>
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
                                        <td style="width: 20%; height: 50px;"> <input type="text" id="drafter_nameApp" name="drafter_nameApp" value="" class="form-control"> </td>
                                        <td style="width: 20%; height: 50px;"> <input type="text" id="checker_nameApp" name="checker_nameApp" value="<?php echo getStaffName($mysqli, $approval_staff_idArr[0]); ?>" class="form-control"> </td>
                                        <td style="width: 20%; height: 50px;"> <input type="text" id="reviewer_nameApp" name="reviewer_nameApp" value="" class="form-control"> </td>
                                        <td style="width: 20%; height: 50px;"> <input type="text" id="approvar_nameApp" name="approvar_nameApp" value="<?php echo getStaffName($mysqli, $approval_staff_idArr[1]); ?>" class="form-control"> </td>
                                    <?php } else if($approval_staff_idLength == '3'){ ?>
                                        <td style="width: 20%; height: 50px;"> <input type="text" id="drafter_nameApp" name="drafter_nameApp" value="" class="form-control"> </td>
                                        <td style="width: 20%; height: 50px;"> <input type="text" id="checker_nameApp" name="checker_nameApp" value="<?php echo getStaffName($mysqli, $approval_staff_idArr[0]); ?>" class="form-control"> </td>
                                        <td style="width: 20%; height: 50px;"> <input type="text" id="reviewer_nameApp" name="reviewer_nameApp" value="<?php echo getStaffName($mysqli, $approval_staff_idArr[1]); ?>" class="form-control"> </td>
                                        <td style="width: 20%; height: 50px;"> <input type="text" id="approvar_nameApp" name="approvar_nameApp" value="<?php echo getStaffName($mysqli, $approval_staff_idArr[2]); ?>" class="form-control"> </td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td style="width: 20%; height: 30px;"></td>
                                    <td style="width: 20%; height: 30px;"></td>
                                    <td style="width: 20%; height: 30px;"></td>
                                    <td style="width: 20%; height: 30px;"></td>
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
                                    <td style="width: 10%; height: 30px;"> <?php echo getStaffName($mysqli, $agree_par_staff_idArr[$j]); ?> </td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <?php for($j=0;$j<count($agree_par_staff_idArr);$j++) { ?>
                                    <td style="width: 10%; height: 30px;"></td>
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
                            <textarea tabindex="1" id="reference" name="reference" class="form-control" rows="6" cols="50" value="<?php if(isset($message)) echo $message; ?>"><?php if(isset($message)) echo $message; ?></textarea>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="inputReadOnly">Receiving Department</label>
                            <textarea tabindex="1" id="receiving_dept" name="receiving_dept" class="form-control" rows="6" cols="50" value="<?php if(isset($message)) echo $message; ?>"><?php if(isset($message)) echo $message; ?></textarea>
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
                                <input type="hidden" name="emp_code" id="emp_code" value="<?php echo $_SESSION['emp_code']; ?>" class="form-control">
                                <td style="width: 25%; height: 30px;"><input type="text" id="drafter_name" name="drafter_name" value="" class="form-control"></td>
                                <td style="width: 25%; height: 30px;"><input type="text" id="drafter_department" name="drafter_department" class="form-control"></td>
                                <td style="width: 25%; height: 30px;"><input type="date" id="doc_no" name="doc_no" class="form-control"></td>
                                <td style="width: 25%; height: 30px;"><input type="text" id="auto_generation_date" name="auto_generation_date" class="form-control" value="<?php date_default_timezone_set('Asia/Kolkata');  echo date('d-m-Y'); ?>"></td>
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
                            <input class="form-control" type="file" multiple name="file" id="file"  onchange="javascript:updateList()" />
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

                <div class="col-md-12">
                    <br><br>
                    <div class="text-right">
                        <button type="submit" name="submitreport_template" id="submitreport_template" class="btn btn-outline-secondary" value="Submit" tabindex="4">Print</button>
                        <button type="submit" name="submitreport_template" id="submitreport_template" class="btn btn-primary" value="Submit" tabindex="4">Submit</button>
                        <!-- <button type="reset" class="btn btn-outline-secondary" tabindex="5" id='reset'>Cancel</button> -->
                    </div>
                    <br><br>
                </div>

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

