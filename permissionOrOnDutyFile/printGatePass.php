<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_POST["id"])){
	$id=$_POST["id"];
}

$getRgp=$con->query("SELECT cc.company_name, bc.branch_name, bc.address1, bc.address2, bc.city, bc.office_number, bc.email_id, dc.department_name, sc.staff_name, scr.staff_name as reportingStaff, pod.* FROM `permission_or_on_duty` pod LEFT JOIN branch_creation bc ON pod.company_id = bc.branch_id LEFT JOIN company_creation cc ON bc.company_id = cc.company_id LEFT JOIN department_creation dc ON pod.department_id = dc.department_id LEFT JOIN staff_creation sc ON pod.staff_id = sc.staff_id LEFT JOIN staff_creation scr ON pod.reporting = scr.staff_id WHERE pod.permission_on_duty_id ='".strip_tags($id)."' ");
$row=$getRgp->fetch_object();

if($row->leave_status == 0)
{
    $leave_sts = "Requested";
}
elseif($row->leave_status == 1)
{
    $leave_sts = "Approved";
}
elseif($row->leave_status == 2)
{
    $leave_sts = "Rejected";
}

if($row->reason == 'Leave')
{
    $regularisation_date = date('d-m-Y', strtotime($row->leave_date)).' - '.date('d-m-Y', strtotime($row->leave_to_date));
}
elseif($row->reason == 'Permission')
{
    $regularisation_date = date('d-m-Y',strtotime($row->permission_date));
}
elseif($row->reason == 'On Duty')
{
    $regularisation_date = date('d-m-Y',strtotime($row->created_date));
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

<input type="hidden" name="permission_on_duty_id" id="permission_on_duty_id" value="<?php echo $row->permission_on_duty_id; ?>">

<div class="approvedtablefield">
<div id="dettable" style="border:1px solid black;width: 75%;margin: auto;">
	<table style="width: 90%;margin: auto;">
		<tr>
			<!-- <td><img src="img/logo.png" height="50px" width="150px" align="right"></td> -->
			<td style="text-align:center"><h1><?php echo $row->company_name; ?></h1></td>
		</tr>
		<tr>
			<td style="text-align: center">
				<?php echo $row->address1.','; ?>
				<?php echo $row->address2.','; ?>
				<?php echo $row->city; ?><br>
				<?php echo 'Phone: '.$row->office_number; ?><br>
				<?php echo 'Email: '.$row->email_id; ?>
			</td>
		</tr>
	</table>
	<br /><br />
	<table rules="all" style="width: 90%;border-style: double;border: 1px solid black;margin: auto;">
		<tr>
			<th style="background-color: white;color: black">Regularisation Number</th>
			<th style="background-color: white;color: black">Branch Address</th>
			<th style="background-color: white;color: black">Department</th>
			<th style="background-color: white;color: black">Staff Name</th>
			<th style="background-color: white;color: black">Reporting To</th>
			<th style="background-color: white;color: black">Reason</th>
			<th style="background-color: white;color: black">Leave Status</th>
			<th style="background-color: white;color: black">Regularisation Date</th>
		</tr>
		<tr>
			<td style="text-align: center">
				<?php echo $row->regularisation_id; ?>
			</td>
			<td style="margin-left: 5px;padding-left: 30px;text-align: left;">
				<?php
				echo $row->company_name .' - '. $row->branch_name.' Branch,';?><br>
				<?php
				echo $row->address1.',';?><br>
				<?php
				echo $row->address2.',';?><br>
				<?php
				echo $row->city. '.';
				?>
			</td>
			<td style="text-align: center">
				<?php echo $row->department_name; ?>
			</td>
			<td style="text-align: center">
				<?php echo $row->staff_name; ?>
			</td>
			<td style="text-align: center">
				<?php echo $row->reportingStaff; ?>
			</td>
			<td style="text-align: center">
				<?php echo $row->reason; ?>
			</td>
			<td style="text-align: center">
				<?php echo $leave_sts; ?>
			</td>
			<td style="text-align: center">
				<?php echo $regularisation_date; ?>
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
