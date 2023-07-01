<?php
include('ajaxconfig.php');
@session_start();

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
} 
$column = array(
    
    'vehicle_details_id',
    'vehicle_number',
    'fitment_upto',
    'insurance_upto'
);

$query = "SELECT `vehicle_details_id`,`vehicle_type`,`vehicle_name`,`vehicle_number`,`fitment_upto`,`insurance_upto` FROM vehicle_details  WHERE 
(
    `fitment_upto` >= CURDATE()
    AND `fitment_upto` <= CURDATE() + INTERVAL 30 DAY
)
OR
(
    `insurance_upto` >= CURDATE()
    AND `insurance_upto` <= CURDATE() + INTERVAL 30 DAY
)";
if($sbranch_id == 'Overall'){
    $query .= '';
    if($_POST['search']!="");
    {
        if (isset($_POST['search'])) {
            
            if($_POST['search']=="Active")
            {
                $query .=" and status=0 "; 
            }
            else if($_POST['search']=="Inactive")
            {
                $query .=" and status=1 ";
            }
            
            else{	
                
                $query .= "
                OR vehicle_details_id LIKE '%".$_POST['search']."%'
                OR vehicle_number LIKE '%".$_POST['search']."%'
                OR fitment_upto LIKE '%".$_POST['search']."%'
                OR insurance_upto LIKE '%".$_POST['search']."%' ";
            }
        }
    }
    
}else{
    $query .=" and company_id= '".$sbranch_id."' ";
}

if (isset($_POST['order'])) {
    $query .= 'ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= ' ';
}

$query1 = '';

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
    $sub_array   = array();
  
    if($sno!="")
    {
        $sub_array[] = $sno;
    }

    $vehicle_type = $row['vehicle_type'];
    if($vehicle_type == '1'){
        $v_type = 'Own Vehicle';
    }elseif($vehicle_type == '2'){
        $v_type = 'Rental Vehicle';
    }else{
        $v_type = '';
    }
    $sub_array[] = $v_type;
    $sub_array[] = $row['vehicle_number'];
    $sub_array[] = $row['fitment_upto'];
    $sub_array[] = $row['insurance_upto'];

	$id   = $row['vehicle_details_id'];
	
    $assign_employee_details = $con->query("SELECT vehicle_details_id FROM `fc_insurance_renew` WHERE `vehicle_details_id` = '$id' ");
    if(mysqli_num_rows($assign_employee_details)>0){
        $action="<button class='btn btn-success'><a href='vehicle_fc_insurance&upd=$id' style='color: #ffffff;'>Employee Assigned</a</button>&nbsp;&nbsp;";
    }else{
        $action="<button class='btn btn-primary'><a href='vehicle_fc_insurance&upd=$id' style='color: #ffffff;'>Assign Employee</a</button>&nbsp;&nbsp;";
    }

	$sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM vehicle_details";
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
?>