<?php
include('ajaxconfig.php');
@session_start();

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}
if(isset($_SESSION["role"])){
    $role = $_SESSION["role"];
}
if(isset($_SESSION["staffid"])){
    $staffid = $_SESSION["staffid"];

    $staffDetails = $con->query("SELECT `department` FROM `staff_creation` WHERE `staff_id` = '$staffid' ");
    if(mysqli_num_rows($staffDetails)>0){
        $staffinfo = $staffDetails->fetch_assoc();
        $user_dept_id = $staffinfo['department'];
    }
}

$column = array(
    'company_name',
    'department_name',
    'designation_name',
    'staff_name',
    'month',
    'status'
);

$query = "SELECT dp.daily_performance_id,c.company_name,dc.department_name,dsc.designation_name,s.staff_name,DATE_FORMAT(CONCAT('2023-', LPAD(dp.month, 2, '0'), '-01'), '%M') AS month,dp.status FROM
daily_performance dp
LEFT JOIN
company_creation c ON c.company_id = dp.company_id
LEFT JOIN
department_creation dc ON dc.department_id = dp.department_id
LEFT JOIN
designation_creation dsc ON dsc.designation_id = dp.role_id
LEFT JOIN
staff_creation s ON s.staff_id = dp.emp_id
WHERE ";

if ($staffid != 'Overall'){
    if($role == '3'){
        $query .= "dp.department_id = '$user_dept_id' ";
        
    }else if($role == '4'){
        $query .= "dp.emp_id = '$staffid' ";
    }
}else{
    $query.= "1";
}

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
            // $query .= "
            
            // OR c.company_name LIKE  '%".$_POST['search']."%'
            // OR dc.department_name LIKE '%".$_POST['search']."%'
            // OR dsc.designation_name LIKE '%".$_POST['search']."%'
            // OR s.staff_name LIKE '%".$_POST['search']."%'
            // OR dp.month LIKE '%".$_POST['search']."%'
            // OR dp.status LIKE '%".$_POST['search']."%'";
        }
    }
}

if (isset($_POST['order'])) {
    $query .= ' GROUP BY dp.emp_id,dp.month ORDER BY dp.daily_performance_id DESC ';
} else {
    $query .= ' ';
}
// echo $query;
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
// print_r($data);
$sno = 1;
foreach ($result as $row) {
    $sub_array   = array();
    
    if($sno!="")
    {
        $sub_array[] = $sno;
    }
                        
    $sub_array[] = $row['company_name'];
    $sub_array[] = $row['department_name'];
    $sub_array[] = $row['designation_name'];
    $sub_array[] = $row['staff_name'];
    $sub_array[] = $row['month'];
    $status    = $row['status'];
    
    
   
    if($status == 1)
	{
	$sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	}
	else
	{
    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	}
	$id   = $row['daily_performance_id'];
	
	// $action="<a href='daily_performance&upd=$id' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp; 
	// <a href='daily_performance&del=$id' title='Delete details' class='delete_daily_performance'><span class='icon-trash-2'></span></a>";
    $action="<a href='daily_performance&upd=$id' class='edpage' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp; 
	<a href='daily_performance&del=$id' title='Delete details' class='delete_goal_setting'><span class='icon-trash-2'></span></a>
    <a href='daily_performance&upd=$id' title='View details' class='View_goal_setting'><span class='icon-eye'></span></a>";

	$sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
  
}

function count_all_data($connect)
{
    $query     = "SELECT dp.daily_performance_id,c.company_name,dc.department_name,dsc.designation_name,s.staff_name,DATE_FORMAT(CONCAT('2023-', LPAD(dp.month, 2, '0'), '-01'), '%M') AS month,dp.status FROM
    daily_performance dp
  LEFT JOIN
    company_creation c ON c.company_id = dp.company_id
  LEFT JOIN
    department_creation dc ON dc.department_id = dp.department_id
  LEFT JOIN
    designation_creation dsc ON dsc.designation_id = dp.role_id
  LEFT JOIN
    staff_creation s ON s.staff_id = dp.emp_id";
    $statement = $connect->prepare($query);
    $statement->execute();
    return $statement->rowCount();
}




$output = array(
    'draw' => intval($_POST['draw']),
    'recordsTotal' => count_all_data($connect),
    'recordsFiltered' => $number_filter_row,
    'data' => $data
    // 'deptname' => $deptname
);


echo json_encode($output);
?>





