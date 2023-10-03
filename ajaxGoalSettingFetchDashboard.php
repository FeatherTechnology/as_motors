<?php
include('ajaxconfig.php');
@session_start();

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
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
    'c.company_name',
    'department_name',
    'status'
);

$query = "SELECT  gs.goal_setting_id,gs.company_name,c.company_name,bc.branch_name,gs.department,dc.department_name,gs.status FROM goal_setting gs 
LEFT JOIN company_creation c ON c.company_id=gs.company_name 
LEFT JOIN branch_creation bc ON gs.branch_id = bc.branch_id 
LEFT JOIN department_creation dc ON dc.department_id=gs.department
WHERE ( gs.created_date <= CURDATE() + INTERVAL 30 DAY ) AND ";

if ($staffid != 'Overall'){
    $query .= "gs.department = '$user_dept_id' ";
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
            // OR gs.status LIKE '%".$_POST['search']."%'";
        }
    }
}

if (isset($_POST['order'])) {
    $query .= ' ORDER BY gs.goal_setting_id desc ';
} else {
    $query .= ' ';
}
// print_r($query);
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
    $sub_array[] = $row['branch_name'];
    $sub_array[] = $row['department_name'];
    $status    = $row['status'];
    
    
   
    if($status == 1)
	{
	$sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	}
	else
	{
    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	}
	$id   = $row['goal_setting_id'];
	
	$action="<a href='goal_setting&upd=$id' class='edpage' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp; 
	<a href='goal_setting&del=$id' title='Delete details' class='delete_goal_setting'><span class='icon-trash-2'></span></a>
    <a href='goal_setting&upd=$id' title='View details' class='View_goal_setting'><span class='icon-eye'></span></a>";

	$sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
  
}

function count_all_data($connect)
{
    $query     = "SELECT  gs.goal_setting_id,gs.company_name,c.company_name,gs.department,dc.department_name,gs.status FROM goal_setting gs 
    LEFT JOIN company_creation c ON c.company_id=gs.company_name 
    LEFT JOIN department_creation dc ON dc.department_id=gs.department";
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





