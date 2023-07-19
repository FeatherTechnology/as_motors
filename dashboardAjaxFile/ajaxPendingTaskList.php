<?php
include('../ajaxconfig.php');
@session_start();

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
} 
$column = array(
    
    'tb',
    'title',
    'end_date'
);

$query = "SELECT 'Assign work' as tb, work_des_text as title, to_date as end_date, designation_id as assign FROM assign_work_ref WHERE work_status != 3 AND status = 0 AND
(
    `to_date` >= CURDATE()
    AND
    `to_date` <= CURDATE() + INTERVAL 10 DAY
)
UNION 
SELECT 'ToDo' as tb, work_des as title, to_date as end_date, assign_to as assign FROM todo_creation WHERE work_status != 3 AND status = 0 AND
(
    `to_date` >= CURDATE()
    AND
    `to_date` <= CURDATE() + INTERVAL 10 DAY
)
UNION
SELECT 'Campaign' as tb, activity_involved as title, end_date as end_date, employee_name as assign FROM campaign_ref WHERE work_status != 3 AND 
(
    `end_date` >= CURDATE()
    AND
    `end_date` <= CURDATE() + INTERVAL 10 DAY
)";


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
    $sub_array   = array();

    if($sno!="")
    {
        $sub_array[] = $sno;
    }

    $sub_array[] = $row['tb'];
    $sub_array[] = $row['title'];
    $sub_array[] = date('d-m-Y',strtotime($row['end_date']));

    $desgn_id = $row['assign'];
    $assign = '';
    if($row['tb'] == 'Assign work'){ //we using 3 database table to get record and show in one html table, in this assign_work_ref table assign task against designation but todo_creation, campaign_ref are against staff so split by condition and based on it show designation and staff name.
        $getDesignation = $mysqli->query("SELECT designation_name FROM designation_creation where designation_id = '".$desgn_id."' ");
        $designationList = $getDesignation->fetch_assoc();
        $assign = $designationList['designation_name'];
    }
    else if($row['tb'] == 'ToDo' || $row['tb'] == 'Campaign'){
        $getStaff = $mysqli->query("SELECT staff_name FROM staff_creation where FIND_IN_SET(staff_id, '".$desgn_id."') ");
        while($staffList = $getStaff->fetch_assoc()){
            $assign .= $staffList['staff_name'].', ';
        }
    }

    $sub_array[] = $assign;

    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect)
{
    $query     = "SELECT 'assign_work_ref' as tb, work_des_text as title, to_date as end_date, designation_id as assign FROM assign_work_ref 
    UNION 
    SELECT 'todo' as tb, work_des as title, to_date as end_date, assign_to as assign FROM todo_creation
    UNION
    SELECT 'camp' as tb, activity_involved as title, end_date as end_date, employee_name as assign FROM campaign_ref";
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