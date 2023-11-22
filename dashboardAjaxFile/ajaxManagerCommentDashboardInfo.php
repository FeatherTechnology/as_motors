<?php
include('../ajaxconfig.php');
@session_start();
if(isset($_SESSION["staffid"])){
    $staffid = $_SESSION["staffid"];
}

$column = array(

    'username',
    'manager_comment',
    'managername',
    'manager_updated_date',
);
//dpr.manager_updated_status != 0 --not approove, 1 -- approve, 2 --reject.
$query = "SELECT sc.staff_name as username, dpr.manager_comment, dpr.manager_updated_date, msc.fullname as managername
FROM daily_performance_ref dpr 
LEFT JOIN daily_performance dp ON dpr.daily_performance_id = dp.daily_performance_id 
LEFT JOIN  user msc ON dpr.manager_id = msc.staff_id
LEFT JOIN staff_creation sc ON dp.emp_id = sc.staff_id 
WHERE dp.emp_id='$staffid' && dpr.manager_updated_status != 0 && dpr.manager_updated_status != 2 && dpr.manager_comment != '' && MONTH(dpr.manager_updated_date) = MONTH(CURDATE()) ";


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
    
    $sub_array[] = $row['username'];
    $sub_array[] = $row['manager_comment'];
    $sub_array[] = $row['managername'];
    $sub_array[] = $row['manager_updated_date'];

    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect)
{
    $query     = "SELECT sc.staff_name as username, dpr.manager_comment, dpr.manager_updated_date, msc.staff_name as managername
    FROM daily_performance_ref dpr 
    LEFT JOIN daily_performance dp ON dpr.daily_performance_id = dp.daily_performance_id 
    LEFT JOIN staff_creation msc ON dpr.manager_id = msc.staff_id
    LEFT JOIN staff_creation sc ON dp.emp_id = sc.staff_id 
    WHERE dpr.manager_updated_status != 0 && dpr.manager_updated_status != 2 && MONTH(dpr.manager_updated_date) = MONTH(CURDATE()) ";
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
$connect = null;
?>