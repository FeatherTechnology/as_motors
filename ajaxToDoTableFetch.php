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

    'todo_id',
    // 'company_id',
    'work_des',
    // 'tag_id',
    'priority',
    'assign_to',
    'from_date',
    'to_date',
    'status'
);

$query = "SELECT * FROM todo_creation WHERE 1";
if($sbranch_id == 'Overall'){
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

                OR todo_id LIKE '%".$_POST['search']."%'
                OR work_des LIKE  '%".$_POST['search']."%'
                OR priority LIKE  '%".$_POST['search']."%'
                OR assign_to LIKE  '%".$_POST['search']."%'
                OR from_date LIKE  '%".$_POST['search']."%'
                OR to_date LIKE  '%".$_POST['search']."%'
                OR status LIKE '%".$_POST['search']."%' ";
                // OR company_id LIKE  '%".$_POST['search']."%'
            }
        }
    }
}else{
    $query .=" and created_id= '".$userid."' ";
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

    // $company_name='';
    // $qry = "SELECT * FROM branch_creation WHERE branch_id = '".$row['company_id']."' AND status=0 ORDER BY branch_id DESC"; 
    // $res = $con->query($qry);
    // while($row5 = $res->fetch_assoc())
    // {
    //     $getname = "SELECT company_name FROM company_creation WHERE company_id = '".$row5['company_id']."' ";
    //     $res1 = $con->query($getname) ;
    //     while ($row52 = $res1->fetch_assoc()) {
    //         $company_name = $row52['company_name'];
    //     }
    // }

    //get department
    // $department_name='';
    // $getDepartmentName = $row['department_id'];   
    // $getqry = "SELECT department_name,company_id FROM department_creation WHERE department_id ='".strip_tags($getDepartmentName)."' and status = 0";
    // $res12 = $con->query($getqry);
    // while($row12 = $res12->fetch_assoc())
    // {
    //    $department_name = $row12["department_name"];        
    // }
    
    //get tag classification
    // $tagClassification='';
    // $tag_id = $row['tag_id'];   
    // $getqry = "SELECT * FROM tag_creation WHERE tag_id ='".strip_tags($tag_id)."' and status = 0";
    // $res2 = $con->query($getqry);
    // while($row2 = $res2->fetch_assoc())
    // {
    //    $tagClassification = $row2["tag_classification"];        
    // }

    // assign to
    $staffName = array();
    $staffIdArr = explode(",", $row['assign_to']);
    foreach ($staffIdArr as $staff_id) {

        $getqry = "SELECT * FROM staff_creation WHERE staff_id ='".strip_tags($staff_id)."' and status = 0";
        $res3 = $con->query($getqry);
        while($row3 = $res3->fetch_assoc())
        {
            $staffName[] = $row3["staff_name"];        
        }
    }
    
    // $sub_array[] = $company_name;
    // $sub_array[] = $department_name;
    $sub_array[] = $row['work_des'];
    // $sub_array[] = $tagClassification;
    
    //check priority
    if($row['priority'] == '1'){$sub_array[] = 'High';}
    elseif($row['priority'] == '2'){$sub_array[] = 'Medium';}
    else{$sub_array[] = 'Low';}

    $sub_array[] = $staffName;
    $sub_array[] = date('d-m-Y',strtotime($row['from_date']));
    $sub_array[] = date('d-m-Y',strtotime($row['to_date']));

    $status      = $row['status'];
    if($status == 1)
	{
	    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	}
	else
	{
        $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	}
	$id   = $row['todo_id'];
	
	$action="<a href='todo&upd=$id' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp; 
	<a href='todo&del=$id' title='Delete details' class='delete_todo'><span class='icon-trash-2'></span></a>";

	$sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM todo_creation";
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