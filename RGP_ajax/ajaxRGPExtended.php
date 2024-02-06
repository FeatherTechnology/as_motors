<?php
include('..\ajaxconfig.php');
@session_start();

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_SESSION["curdateFromIndexPage"])){
    $curdate = $_SESSION["curdateFromIndexPage"];
}
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
} 
if(isset($_SESSION["staffid"])){
    $staffid = $_SESSION["staffid"];
}else{
    $staffid = 0;
}

if($sbranch_id != 'Overall'){
//if the staff is transfered then check the transfer effective date is greater than curdate if true then take old designation from the staff_creation_history, if false means the designation will not be overwrite 
$getdesgnDetails = $con->query("SELECT tl.transfer_effective_from, sch.company_id, sch.designation FROM `transfer_location` tl LEFT JOIN staff_creation_history sch ON tl.transfer_location_id = sch.transfer_location_id WHERE tl.staff_code = '$staffid' order by tl.transfer_location_id DESC LIMIT 1");
        
if(mysqli_num_rows($getdesgnDetails)>0){
    $dsgnInfo = $getdesgnDetails->fetch_assoc();
    $transfer_effective_from = date('Y-m-d',strtotime($dsgnInfo['transfer_effective_from'])); 
    $curdates = date('Y-m-d');

    if($transfer_effective_from > $curdates){
        $sbranch_id = $dsgnInfo['company_id']; //Old Designation.
        
    }
}
}


$column = array(

    'return_date',
    'branch_from',
    'branch_to',
    'asset_name_id',
    'extended_date',
    'extend_reason'
);

// $curdate = date('Y-m-d');
$enddate = date('Y-m-d',strtotime($curdate.'+5 days'));

$query = "SELECT * FROM rgp_creation WHERE 1 ";

if ($sbranch_id == 'Overall') {
    $query .= '';
    if($_POST['search']!="");
    {
        if (isset($_POST['search'])) {

            if($_POST['search']=="Active")
            {
                $query .="and status=0 "; 
            }
            else if($_POST['search']=="Inactive")
            {
                $query .="and status=1 ";
            }

            else{	
                $query .= "
                OR return_date LIKE  '%".$_POST['search']."%'
                OR branch_from LIKE  '%".$_POST['search']."%'
                OR branch_to LIKE  '%".$_POST['search']."%'
                OR asset_name_id LIKE  '%".$_POST['search']."%'
                OR extended_date LIKE '%".$_POST['search']."%'
                OR extend_reason LIKE '%".$_POST['search']."%' ";
            }
        }
    }
}else{
    $query .= " and branch_from = '".$sbranch_id."'";
}


if (isset($_POST['order'])) {
    $query .= 'ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= ' ';
}

$query1 = '';

if ($_POST['length'] != -1) {
    $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connect->prepare($query);
$statement->execute();
$number_filter_row = $statement->rowCount();
$statement = $connect->prepare($query . $query1);
$statement->execute();
$result = $statement->fetchAll();
$data = array();

$sno = 1;
foreach ($result as $row) {
    $checkqry = "SELECT * FROM rgp_creation WHERE rgp_id= '".$row['rgp_id']."' ";
    $checkrun = $con->query($checkqry);
    $checkrow = $checkrun->fetch_assoc();
    $checkdate = $checkrow['updated_date'];
    $checkstatus = $checkrow['extend_status'];
    if($checkdate <= $enddate or ($checkstatus == '' and $checkstatus == null) ){

    


        if($row['extended_date'] != ''){

            $sub_array   = array();

            if($sno!="")
            {
                $sub_array[] = $sno;
            }
            
            $branch_from='';
            $getBranchName = $row['branch_from'];   
            $getqry2 = "SELECT * FROM branch_creation WHERE branch_id ='".strip_tags($getBranchName)."' and status = 0";
            $res2 = $con->query($getqry2);
            while($row2 = $res2->fetch_assoc())
            {
            $branch_from = $row2["branch_name"];        
            $company_id_from = $row2["company_id"];        
            }
            
            $company_name_from='';
            $getqry = "SELECT * FROM company_creation WHERE company_id ='".strip_tags($company_id_from)."' and status = 0";
            $res3 = $con->query($getqry);
            while($row3 = $res3->fetch_assoc())
            {
            $company_name_from = $row3["company_name"];        
            }

            $branch_to='';
            $getBranchName = $row['branch_to'];   
            $getqry4 = "SELECT * FROM branch_creation WHERE branch_id ='".strip_tags($getBranchName)."' and status = 0";
            $res4 = $con->query($getqry4);
            while($row4 = $res4->fetch_assoc())
            {
            $branch_to = $row4["branch_name"];        
            $company_id_to = $row4["company_id"];        
            }

            $company_name_to='';
            $getqry = "SELECT * FROM company_creation WHERE company_id ='".strip_tags($company_id_to)."' and status = 0";
            $res5 = $con->query($getqry);
            while($row5 = $res5->fetch_assoc())
            {
            $company_name_to = $row5["company_name"];        
            }
            
            $asset_name='';
            $getAssetName = $row['asset_name_id'];   
            $getqry6 = "SELECT * FROM asset_register WHERE asset_id ='".strip_tags($getAssetName)."' and status = 0";
            $res6 = $con->query($getqry6);
            while($row6 = $res6->fetch_assoc())
            {
            $asset_name = $row6["asset_name"];        
            }

            $rgp_date = date('d-m-Y',strtotime($row['rgp_date']));
            $extended_date = $row['extended_date']; 
            $return_date = $row['return_date'];

            // $sub_array[] = $company_name;
            $sub_array[] = $branch_from .' - '. $company_name_from;
            $sub_array[] = $branch_to .' - '. $company_name_to ;
            $sub_array[] = $asset_name;
            // $sub_array[] = $return_date;
            // $sub_array[] = $extended_date;
            // $sub_array[] = $row['extend_reason'];
            $id   = $row['rgp_id'];
            $extend_status = $row['extend_status'];
            $action = "
                <button onclick = 'approve($id)' title='Approve RGP' class='btn btn-success' style='padding: 5px 5px'><span class='icon-done'> Approve</span></button>&nbsp;&nbsp;
                <button onclick = 'reject($id)' title='Reject RGP' class='btn btn-danger' style='padding: 5px 5px'><span class='icon-cancel'> Reject</span></button>";
            if($extend_status == 'Approved'){
                $action = "
                <button type='button' title='Approve RGP' class='btn btn-success disabled' style='padding: 5px 5px'><span class=''> Approved</span></button>";
            }
            elseif($extend_status == 'Rejected'){
                $action = "
                <button type='button' title='Reject RGP' class='btn btn-danger disabled' style='padding: 5px 5px'><span class=''> Rejected</span></button>";
            }
            
            $sub_array[] = $action;
            $data[]      = $sub_array;
            $sno = $sno + 1;
        }
    }
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM rgp_creation";
    $statement = $connect->prepare($query);
    $statement->execute();
    return $statement->rowCount();
}

$output = array(
    'draw' => intval($_POST['draw']),
    'recordsTotal' => count_all_data($connect),
    'recordsFiltered' => $number_filter_row,
    'data' => $data
);

echo json_encode($output);

// Close the database connection
$mysqli->close();
$connect = null;
?>