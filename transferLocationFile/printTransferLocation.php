<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_POST["id"])){
	$id=$_POST["id"];
}

$getTransferDetails=$con->query("SELECT * FROM transfer_location WHERE transfer_location_id='".strip_tags($id)."' ");
while($row = $getTransferDetails->fetch_assoc()){

    $company_name='';
    $qry = "SELECT * FROM branch_creation WHERE branch_id = '".$row['company_id']."' AND status=0 ORDER BY branch_id DESC"; 
    $res = $con->query($qry);
    while($row5 = $res->fetch_assoc())
    {
        $branch_name = $row5['branch_name'];
        $getname = "SELECT company_name FROM company_creation WHERE company_id = '".$row5['company_id']."' ";
        $res1 = $con->query($getname) ;
        while ($row52 = $res1->fetch_assoc()) {
            $company_name = $row52['company_name'];
        }
    }

    $department_name='';
    $getDepartmentName = $row['department_id'];   
    $getqry = "SELECT department_name FROM department_creation WHERE department_id ='".strip_tags($getDepartmentName)."' and status = 0";
    $res12 = $con->query($getqry);
    while($row12 = $res12->fetch_assoc())
    {
       $department_name = $row12["department_name"];        
    }

    $staffCode='';
    $getStaffCode = $row['staff_code'];   
    $getqry = "SELECT emp_code FROM staff_creation WHERE staff_id ='".strip_tags($getStaffCode)."' and status = 0"; 
    $res12 = $con->query($getqry);
    while($row12 = $res12->fetch_assoc())
    {
       $staffCode = $row12["emp_code"];        
    }

    $transfer_branch_name='';
    $qry = "SELECT * FROM branch_creation WHERE branch_id = '".$row['transfer_location']."' AND status=0 ORDER BY branch_id DESC"; 
    $res = $con->query($qry);
    while($row8 = $res->fetch_assoc())
    {
        $transfer_branch_name = $row8['branch_name'];
        $getname = "SELECT company_name FROM company_creation WHERE company_id = '".$row8['company_id']."' ";
        $res1 = $con->query($getname) ;
        while ($row10 = $res1->fetch_assoc()) {
            $transfer_company_name = $row10['company_name'];
        }
    }

	$staff_id = $row["staff_id"];
	$dot = date('d/m/Y',strtotime($row["dot"]));
	$transfer_effective_from = $row["transfer_effective_from"];
}


?>

<head>
<style type="text/css">
	th{
		text-align: center;
		font-weight: bold;
	}
</style>
</head>

<input type="hidden" name="transfer_location_id" id="transfer_location_id" value="<?php echo $transfer_location_id; ?>">

<div class="approvedtablefield">
<div id="dettable" style="border:1px solid black;width: 75%;margin: auto;">
	<table style="width: 90%;margin: auto;">
		<tr>
			<!-- <td><img src="img/logo.png" height="50px" width="150px" align="right"></td> -->
			<td style="text-align:center"><h1><?php echo $company_name; ?></h1></td>
		</tr>
		<tr>
			<td style="text-align: center">
				<?php //echo $from_comm_line1.','; ?>
				<?php //echo $from_comm_line2.','; ?>
				<?php //echo $branch_from_city; ?><br>
				<?php //echo 'Phone: '.$branch_from_phone; ?><br>
				<?php //echo 'Email: '.$branch_from_email; ?>
			</td>
		</tr>
	</table>
	<br /><br />
	<table rules="all" style="width: 90%;border-style: double;border: 1px solid black;margin: auto;">
		<tr>
			<th style="background-color: white;color: black">Branch</th>
			<th style="background-color: white;color: black">Department</th>
			<th style="background-color: white;color: black">Staff Code</th>
			<th style="background-color: white;color: black">Staff Name</th>
			<th style="background-color: white;color: black">DOT</th>
			<th style="background-color: white;color: black">Transfer Location</th>
			<th style="background-color: white;color: black">Transfer Effective From</th>
		</tr>
		<tr>
			<td style="text-align: center">
				<?php echo $branch_name; ?>
			</td>
			<td style="text-align: center">
				<?php echo $department_name; ?>
			</td>
			<td style="text-align: center">
				<?php echo $staffCode; ?>
			</td>
			<td style="text-align: center">
				<?php echo $staff_id; ?>
			</td>
			<td style="text-align: center">
				<?php echo $dot; ?>
			</td>
			<td style="text-align: center">
				<?php echo $transfer_company_name.' - '.$transfer_branch_name; ?>
			</td>
			<td style="text-align: center">
				<?php echo $transfer_effective_from; ?>
			</td>
		</tr>
	</table>
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
