<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_POST["id"])){
	$id=$_POST["id"];
}

$getRgp=$con->query("SELECT * FROM rgp_creation WHERE rgp_id='".strip_tags($id)."' ");
while($row=$getRgp->fetch_assoc()){
	$rgp_id=$row["rgp_id"];
	$rgp_date=date('d/m/Y',strtotime($row["rgp_date"]));
	$return_date=date('d/m/Y',strtotime($row["return_date"]));
	$asset_class=$row["asset_class"];
	$company_id=$row["company_id"];
	$branch_from=$row["branch_from"];
	$branch_to=$row["branch_to"];
	$from_comm_line1=$row["from_comm_line1"];
	$from_comm_line2=$row["from_comm_line2"];
	$to_comm_line1=$row["to_comm_line1"];
	$to_comm_line2=$row["to_comm_line2"];
	$asset_name_id=$row["asset_name_id"];
	$rgp_staff_id=$row["rgp_staff_id"];
	$asset_value=$row["asset_value"];
	$reason_rgp=$row["reason_rgp"];
}

$getbranch=$con->query("SELECT * FROM branch_creation WHERE branch_id='".$branch_from."' ");
while ($data=$getbranch->fetch_assoc()){
	$branch_from_name=$data["branch_name"];
	$branch_from_city=$data["city"];
	$branch_from_email=$data["email_id"];
	$branch_from_phone=$data["office_number"];
	$company_from_id=$data["company_id"];
		
	$getcompany=$con->query("SELECT * FROM company_creation WHERE company_id='".$company_from_id."' ");
	$data1 = $getcompany->fetch_assoc();
	$company_from_name = $data1['company_name'];
}

$getbranch1=$con->query("SELECT * FROM branch_creation WHERE branch_id='".$branch_to."' ");
while ($data=$getbranch1->fetch_assoc()){
	$branch_to_name=$data["branch_name"];
	$branch_to_city=$data["city"];
	$company_to_id=$data["company_id"];
		
	$getcompany1=$con->query("SELECT * FROM company_creation WHERE company_id='".$company_to_id."' ");
	$data1 = $getcompany1->fetch_assoc();
	$company_to_name = $data1['company_name'];
}

$getasset=$con->query("SELECT * FROM asset_register WHERE asset_id='".$asset_name_id."' ");
while ($assetRow = $getasset->fetch_assoc()) {
	$asset_name = $assetRow["asset_name"];
}


$staffqry = "SELECT staff_name FROM staff_creation WHERE staff_id ='".strip_tags($rgp_staff_id)."' and status = 0";
$staffdetails = $con->query($staffqry);
while($staffinfo = $staffdetails->fetch_assoc())
{
	$staff_name = $staffinfo["staff_name"];        
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

<input type="hidden" name="rgp_id" id="rgp_id" value="<?php echo $rgp_id; ?>">

<div class="approvedtablefield">
<div id="dettable" style="border:1px solid black;width: 75%;margin: auto;">
	<table style="width: 90%;margin: auto;">
		<tr>
			<!-- <td><img src="img/logo.png" height="50px" width="150px" align="right"></td> -->
			<td style="text-align:center"><h1><?php echo $company_from_name; ?></h1></td>
		</tr>
		<tr>
			<td style="text-align: center">
				<?php echo $from_comm_line1.','; ?>
				<?php echo $from_comm_line2.','; ?>
				<?php echo $branch_from_city; ?><br>
				<?php echo 'Phone: '.$branch_from_phone; ?><br>
				<?php echo 'Email: '.$branch_from_email; ?>
			</td>
		</tr>
	</table>
	<br /><br />
	<table rules="all" style="width: 90%;border-style: double;border: 1px solid black;margin: auto;">
		<tr>
			<th style="background-color: white;color: black">Date of RGP</th>
			<th style="background-color: white;color: black">Branch [Sending] Address</th>
			<th style="background-color: white;color: black">Branh [To] Address</th>
			<th style="background-color: white;color: black">Staff Name</th>
			<th style="background-color: white;color: black">Asset Name</th>
			<th style="background-color: white;color: black">Asset Value</th>
			<th style="background-color: white;color: black">Reason for RGP</th>
			<th style="background-color: white;color: black">Retrun Date</th>
		</tr>
		<tr>
			<td style="text-align: center">
				<?php echo $rgp_date; ?>
			</td>
			<td style="margin-left: 5px;padding-left: 30px;text-align: left;">
				<?php
				echo $company_from_name .' - '. $branch_from_name.' Branch,';?><br>
				<?php
				echo $from_comm_line1.',';?><br>
				<?php
				echo $from_comm_line2.',';?><br>
				<?php
				echo $branch_from_city. '.';
				?>
			</td>
			<td style="margin-left: 5px;padding: 30px;text-align: left;">
				<?php
				echo $company_to_name .' - '. $branch_to_name.' Branch,';?><br>
				<?php
				echo $to_comm_line1.',';?><br>
				<?php
				echo $to_comm_line2.',';?><br>
				<?php
				echo $branch_to_city. '.';
				?>
			</td>
			<td style="text-align: center">
				<?php echo $staff_name; ?>
			</td>
			<td style="text-align: center">
				<?php echo $asset_name; ?>
			</td>
			<td style="text-align: center">
				<?php echo $asset_value; ?>
			</td>
			<td style="text-align: center">
				<?php echo $reason_rgp; ?>
			</td>
			<td style="text-align: center">
				<?php echo $return_date; ?>
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
