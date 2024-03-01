<?php
include('ajaxconfig.php');
@session_start();

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}

$column = array(
    'user_id', 
    'staff_id',
    'user_name',
    'role'
);

$query = "SELECT * FROM user WHERE user_id != 1 ";
if($_POST['search']!="")
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
            OR user_id LIKE  '%".$_POST['search']."%'
            OR staff_id LIKE '%".$_POST['search']."%'
            OR user_name LIKE '%".$_POST['search']."%'
            OR role LIKE '%".$_POST['search']."%' ";
        }
    }
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
    $sub_array   = array();
    
    if($sno!="")
    {
        $sub_array[] = $sno;
    }
    
    $staffId = $row['staff_id'];
    $staff_name=''; 
    $getqry = "SELECT staff_name FROM staff_creation WHERE staff_id ='".strip_tags($staffId)."' ";
    $res12 = $con->query($getqry);
    while($row12 = $res12->fetch_assoc())
    {
       $staff_name = $row12["staff_name"];        
    }

    $sub_array[] = $staff_name;
    $sub_array[] = $row['user_name'];
    $role = $row['role'];
    if($role == 3){$sub_array[] = 'Manager';}
    elseif($role == 4){$sub_array[] = 'Staff';}
    else{$sub_array[] = '';}
    
    
    $status      = $row['status'];
    if($status==1)
	{
	$sub_array[]="<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	}
	else
	{
    $sub_array[]="<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	}
	$id = $row['user_id'];
	
	$action="<a href='manage_users&upd=$id' title='Edit user'><span class='icon-border_color'></span></a>&nbsp;&nbsp; 
	<a href='manage_users&del=$id' title='Edit user' class='delete_user'><span class='icon-trash-2'></span></a>";

	$sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM user";
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