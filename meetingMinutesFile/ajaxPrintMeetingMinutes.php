<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_POST["id"])){
	$id=$_POST["id"];
}

$getTransferDetails=$con->query("SELECT * FROM meeting_minutes_approval_line WHERE meeting_minutes_approval_line_id='".strip_tags($id)."' "); 
while($row = $getTransferDetails->fetch_assoc()){

    $company_name='';
    $qry = "SELECT * FROM branch_creation WHERE branch_id = '".$row['company_id']."' AND status=0 ORDER BY branch_id DESC"; 
    $res1 = $con->query($qry);
    while($row1 = $res1->fetch_assoc())
    {
        $branch_name = $row1['branch_name'];
        $getname = "SELECT company_name FROM company_creation WHERE company_id = '".$row1['company_id']."' ";
        $res1 = $con->query($getname) ;
        while ($row52 = $res1->fetch_assoc()) {
            $company_name = $row52['company_name'];
        }
    }
}

$approvalLineSelect = "SELECT * FROM meeting_minutes_approval_line WHERE meeting_minutes_approval_line_id = '".strip_tags($id)."' AND status=0 ORDER BY meeting_minutes_approval_line_id DESC";
$res2 = $con->query($approvalLineSelect);
while($row2 = $res2->fetch_assoc())
{
	$meeting_minutes_approval_line_id      	   = $row2['meeting_minutes_approval_line_id'];
	$company_id                = $row2['company_id'];
	$staff_id                  = $row2['staff_id'];
	$approval_staff_id         = $row2['approval_staff_id'];
	$agree_par_staff_id        = $row2['agree_par_staff_id'];
	$after_notified_staff_id   = $row2['after_notified_staff_id'];
	$receiving_dept_id         = $row2['receiving_dept_id'];
	$drafter_approval_date	   = $row2['created_date'];
	$checker_approval          = $row2['checker_approval'];
	$reviewer_approval         = $row2['reviewer_approval'];
	$final_approval            = $row2['final_approval'];
	$created_date              = $row2['created_date'];
	$checker_approval_date     = $row2['checker_approval_date'];
	$reviewer_approval_date    = $row2['reviewer_approval_date'];
	$final_approval_date       = $row2['final_approval_date'];

	
	// get approval requisition 
	$getqry = "SELECT * FROM meeting_minutes WHERE meeting_minutes_approval_line_id ='".strip_tags($meeting_minutes_approval_line_id)."' and status = 0"; 
	$res = $con->query($getqry);
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

	// receiving dept 
	$after_notified_staff_idArr = array_map('intval', explode(',', $after_notified_staff_id));
}

function getStaffName($con, $staff_id){
    $staff_name='';
    $getqry = "SELECT staff_name FROM staff_creation WHERE staff_id ='".strip_tags($staff_id)."' and status = 0";
    $res = $con->query($getqry);
    while($row = $res->fetch_assoc())
    {
       $staff_name = $row["staff_name"];        
    }
    return $staff_name;
}

function getDeptName($con, $department_id){
    $department_name='';
    $getqry = "SELECT department_name FROM department_creation WHERE department_id ='".strip_tags($department_id)."' and status = 0";
    $res = $con->query($getqry);
    while($row = $res->fetch_assoc())
    {
       $department_name = $row["department_name"];        
    }
    return $department_name;
}
?>

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

<head>
<style type="text/css">
	th{
		text-align: center;
		font-weight: bold;
	}
</style>
</head>
<div class="approvedtablefield">
<div id="dettable" style="border:1px solid black;width: 75%;margin: auto;">
	<table style="width: 90%;margin: auto;">
		<tr>
			<td style="text-align:center"><h1><?php echo $company_name; ?></h1></td>
		</tr>
	</table>
	<br /><br />

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
				<td style="width: 20%; height: 50px;"> <input style="border: 0;"  readonly type="text" id="drafter_nameApp" name="drafter_nameApp" value="<?php  echo getStaffName($con, $staff_id); ?>" class="form-control"> </td>
				<td style="width: 20%; height: 50px;"> <input style="border: 0;" readonly type="text" id="checker_nameApp" name="checker_nameApp" value="<?php  echo getStaffName($con, $approval_staff_idArr[0]); ?>" class="form-control"> </td>
				<td style="width: 20%; height: 50px;"> <input style="border: 0;" readonly type="text" id="reviewer_nameApp" name="reviewer_nameApp" value="" class="form-control"> </td>
				<td style="width: 20%; height: 50px;"> <input style="border: 0;" readonly type="text" id="approvar_nameApp" name="approvar_nameApp" value="<?php  echo getStaffName($con, $approval_staff_idArr[1]); ?>" class="form-control"> </td>
				<tr>
					<td style="width: 20%; height: 30px;"> <input style="border: 0;" readonly type="text" id="drafter_dateApp" name="drafter_dateApp" value="<?php  if($drafter_approval_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($drafter_approval_date)); ?>" class="form-control"> </td>

					<?php 
					
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
					?>

					<!-- approvaed rejected if condition -->                                                                                        
					<td style="width: 20%; height: 30px;"> <input style="border: 0;" style="color: <?php echo $color; ?>" readonly type="text" id="checker_dateApp" name="checker_dateApp" value="<?php echo $status; ?>" class="form-control"> </td>
					<td style="width: 20%; height: 30px;"> <input style="border: 0;" style="color: <?php echo $color2; ?>" readonly type="text" id="reviewer_dateApp" name="reviewer_dateApp" value="<?php echo $status2; ?>" class="form-control"> </td>
					<td style="width: 20%; height: 30px;"> <input style="border: 0;" style="color: <?php echo $color1; ?>" readonly type="text" id="approvar_dateApp" name="approvar_dateApp" value="<?php echo $status1; ?>" class="form-control"> </td>
				</tr>
				<?php } else if($approval_staff_idLength == '3'){ ?>
				<td style="width: 20%; height: 50px;"> <input style="border: 0;" readonly type="text" id="drafter_nameApp" name="drafter_nameApp"value="<?php echo getStaffName($con, $staff_id);  ?>" class="form-control"> </td>
				<td style="width: 20%; height: 50px;"> <input style="border: 0;" readonly type="text" id="checker_nameApp" name="checker_nameApp" value="<?php echo getStaffName($con, $approval_staff_idArr[0]);  ?>" class="form-control"> </td>
				<td style="width: 20%; height: 50px;"> <input style="border: 0;" readonly type="text" id="reviewer_nameApp" name="reviewer_nameApp" value="<?php echo getStaffName($con, $approval_staff_idArr[1]);  ?>" class="form-control"> </td>
				<td style="width: 20%; height: 50px;"> <input style="border: 0;" readonly type="text" id="approvar_nameApp" name="approvar_nameApp" value="<?php echo getStaffName($con, $approval_staff_idArr[2]); ?>" class="form-control"> </td>
				<tr>
					<td style="width: 20%; height: 30px;"> <input style="border: 0;" readonly type="text" id="drafter_dateApp" name="drafter_dateApp" value="<?php if($drafter_approval_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($drafter_approval_date)); ?>" class="form-control"> </td>
					<td style="width: 20%; height: 30px;"> <input style="border: 0;" readonly type="text" id="checker_dateApp" name="checker_dateApp" value="<?php if($checker_approval_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($checker_approval_date)); ?>" class="form-control"> </td>
					<td style="width: 20%; height: 30px;"> <input style="border: 0;" readonly type="text" id="reviewer_dateApp" name="reviewer_dateApp" value="<?php if($reviewer_approval_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($reviewer_approval_date)); ?>" class="form-control"> </td>
					<td style="width: 20%; height: 30px;"> <input style="border: 0;" readonly type="text" id="approvar_dateApp" name="approvar_dateApp" value="<?php if($final_approval_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($final_approval_date)); ?>" class="form-control"> </td>
				</tr>
				<?php } ?>
		</tr>
		
	</table>

	<br /><br />

	<table border="1" style="width: 100%">
		<tr>
			<th style="width: 15%; height: 30px;" rowspan="5">Parellel Agreement</th>
		</tr>
		<tr>
			<?php for($j=0;$j<count($agree_par_staff_idArr);$j++) { ?>
				<td style="width: 10%; height: 30px;"> <input style="border: 0;" readonly type="text" id="agreeParallel_nameArr" name="agreeParallel_nameArr[]" value="<?php echo getStaffName($con, $agree_par_staff_idArr[$j]); ?>" class="form-control">  </td>
			<?php } ?>
		</tr>
		<tr>
			<?php for($j=0;$j<count($agree_par_staff_idArr);$j++) { 

				$agree_disagree='';
				$agree_disagree_date='';
				$getqry = "SELECT agree_disagree, agree_disagree_date FROM meeting_minutes_parallel_agree_disagree 
				WHERE agree_disagree_staff_id ='".strip_tags($agree_par_staff_idArr[$j])."' 
				AND status = 0";
				$res = $con->query($getqry);
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
				<td style="width: 10%; height: 30px;"> <input style="border: 0; color: <?php echo $color; ?>" readonly type="text" id="agreeParallel_dateArr" name="agreeParallel_dateArr[]" value="<?php if($agree_disagree_date == ''){ echo ""; } else echo date('d-m-Y',strtotime($agree_disagree_date)); ?>" class="form-control"> </td>
			<?php } ?>
		</tr>
	</table>

	<br /><br />
	
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <label for="inputReadOnly">Reference</label>
                <div style="border: 2px solid black; height:auto;padding:20px;">
                    <table class="border-collapse:collapse">
                        <?php  
                        if(isset($after_notified_staff_idArr)){
                            for($o=0; $o<=sizeof($after_notified_staff_idArr)-1; $o++){ ?>
                                <tbody>
                                    <span style="border-style : hidden!important;"><input readonly type="text" style="border: 0; outline:none; background-color: #f7f8fa;" class="form-control" value="<?php echo getStaffName($mysqli, $after_notified_staff_idArr[$o]); ?>" name="after_notified_staff_idArr[]" id="after_notified_staff_idArr"></span>
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
                <div style="border: 2px solid black; height:auto;padding:20px;">
                    <table class="border-collapse:collapse">
                        <?php  
                        if(isset($receiving_dept_idArr)){
                            for($o=0; $o<=sizeof($receiving_dept_idArr)-1; $o++){ ?>
                                <tbody>
                                    <span style="border-style : hidden!important;"><input readonly type="text" style="border: 0; outline:none; background-color: #f7f8fa;" class="form-control" value="<?php echo getDeptName($mysqli, $receiving_dept_idArr[$o]); ?>" name="receiving_dept_idArr[]" id="receiving_dept_idArr"></span>
                                </tbody>
                                <?php 
                            }
                        } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

	<br /><br />

	<div class="row">
		<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
			<div class="form-group">
				<label for="inputReadOnly">Title</label>
				<input readonly type="text" class="form-control" id="title" name="title" value="<?php if(isset($title)) echo $title; ?>">
			</div>
		</div>
		<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12"></div>
		<br>
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="form-group">
				<label class="inputReadOnly">Comments</label>
				<textarea disabled tabindex="1" id="comments" name="comments" class="form-control" placeholder="Enter Comments" rows="4" cols="50" value="<?php if(isset($comments)) echo $comments; ?>"><?php if(isset($comments)) echo $comments; ?></textarea>
			</div>
		</div>
		<br>
		<div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12"></div>
		<div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12">
			<div class="form-group">
				<label for="inputReadOnly">List Of Attached File</label>
					<div style="border: 2px solid black; height:auto;padding:20px;" id="fileList">
					<?php
						$s_array = explode(",",$file); 
						foreach($s_array as $file)
					{ ?>
					<a href="uploads/meeting_minutes/<?php echo $meeting_minutes_approval_line_id; ?>/<?php echo  $file; ?>" download><li><?php echo  $file; ?></li></a>
					<?php }?>
				</div>  
			</div>
		</div>
	</div>

	<br/><br /><br /><br/><br />
	<div style="border-top: 1px solid black;margin-left: 10%;margin-right: 10%">
	<br/>
	<b><p style="float: left;">Authorized by</p></b>
	<b><p align="right"><?php echo 'Date: '.date("d/m/Y"); ?></p></b>
	</div>
</div>
				
<button type="button" name="printpurchase" onclick="poprint()" id="printpurchase" class="btn btn-primary">Print</button>

<script type="text/javascript">

function poprint(){
	var Bill = document.getElementById("dettable").innerHTML;
	var printWindow = window.open('', '', 'height=400,width=800');
	printWindow.document.write(Bill);
	printWindow.document.close();
	printWindow.print();
	printWindow.close();
 }
 document.getElementById("printpurchase").click();
 
</script>
