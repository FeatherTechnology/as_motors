<?php
@session_start();
include '../ajaxconfig.php';

if(isset($_POST["id"])){
	$id=$_POST["id"];
}

$getTransferDetails=$con->query("SELECT * FROM diesel_slip WHERE diesel_slip_id='".strip_tags($id)."' ");
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

    $vehicle_number='';
    $getqry = "SELECT vehicle_number FROM vehicle_details WHERE vehicle_details_id ='".strip_tags($row["vehicle_number"])."' and status = 0";
    $res12 = $con->query($getqry);
    while($row12 = $res12->fetch_assoc())
    {
        $vehicle_number = $row12["vehicle_number"];
    }

    $staff_name='';
    $staffqry = "SELECT staff_name FROM staff_creation WHERE staff_id ='".strip_tags($row["staff_id"])."' and status = 0";
    $staffDetails = $con->query($staffqry);
    while($staffinfo = $staffDetails->fetch_assoc())
    {
        $staff_name = $staffinfo["staff_name"];
    }

	$previous_km = $row["previous_km"];
	$previous_km_date = $row["previous_km_date"];
	$present_km = $row["present_km"];
	$present_km_date = $row["present_km_date"];
	$total_km_run = $row["total_km_run"];
	$diesel_amount = $row["diesel_amount"];
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

<input type="hidden" name="diesel_slip_id" id="diesel_slip_id" value="<?php echo $diesel_slip_id; ?>">

<div class="approvedtablefield">
    <div id="dieselSlipDiv" style="border:1px solid black;width: 75%;margin: auto;">
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
                <th style="background-color: white;color: black">Vehicle Number</th>
                <th style="background-color: white;color: black">Previous KM</th>
                <th style="background-color: white;color: black">Previous KM Date</th>
                <th style="background-color: white;color: black">Present KM</th>
                <th style="background-color: white;color: black">Present KM Date</th>
                <th style="background-color: white;color: black">Total KM</th>
                <th style="background-color: white;color: black">Diesel Litre</th>
                <th style="background-color: white;color: black">Staff Name</th>
            </tr>
            <tr>
                <td style="text-align: center">
                    <?php echo $branch_name; ?>
                </td>
                <td style="text-align: center">
                    <?php echo $vehicle_number; ?>
                </td>
                <td style="text-align: center">
                    <?php echo $previous_km; ?>
                </td>
                <td style="text-align: center">
                    <?php echo $previous_km_date; ?>
                </td>
                <td style="text-align: center">
                    <?php echo $present_km; ?>
                </td>
                <td style="text-align: center">
                    <?php echo $present_km_date; ?>
                </td>
                <td style="text-align: center">
                    <?php echo $total_km_run; ?>
                </td>
                <td style="text-align: center">
                    <?php echo $diesel_amount; ?>
                </td>
                <td style="text-align: center">
                    <?php echo $staff_name; ?>
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
</div>
				
<button type="button" name="dieselSlip" onclick="poprint()" id="dieselSlip" class="btn btn-primary">Print</button>

<script type="text/javascript">
    function poprint(){
        var Bill = document.getElementById("dieselSlipDiv").innerHTML;
        var printWindow = window.open('', '', 'height=400,width=800');
        printWindow.document.write(Bill);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    }
    document.getElementById("dieselSlip").click();
</script>
