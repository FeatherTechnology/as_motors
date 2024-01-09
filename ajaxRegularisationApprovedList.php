<?php
include('ajaxconfig.php');
@session_start();
if(isset($_SESSION["curdateFromIndexPage"])){
    $curdate = $_SESSION["curdateFromIndexPage"];
}

$column = array(

    'leavePerson',
    'responsiblePerson',
    'leave_date'
);

$query = "SELECT b.staff_name as leavePerson ,c.staff_name as responsiblePerson, a.permission_date, a.leave_date, a.reason FROM permission_or_on_duty a LEFT JOIN staff_creation b ON a.staff_id = b.staff_id LEFT JOIN staff_creation c ON a.responsible_staff = c.staff_id WHERE a.leave_status = '1' AND ('$curdate' <= a.leave_date || '$curdate' <= a.permission_date) ";


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
    
    $sub_array[] = $row['leavePerson'];
    $sub_array[] = $row['responsiblePerson'];
    $sub_array[] = $row['reason'];

    $reason = $row['reason'];
    if($reason == 'Leave'){
        $leave_permission_date = $row['leave_date'];
    }elseif($reason == 'Permission'){
        $leave_permission_date = $row['permission_date'];
    }else{
        $leave_permission_date = '';

    }
    $sub_array[] = $leave_permission_date;

    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM permission_or_on_duty";
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