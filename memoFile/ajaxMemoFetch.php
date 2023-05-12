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

    'memo_id',
    'company_id',
    'to_department',
    'inquiry',
    'suggestion',
    'attachment',
    'status'
);

$query = "SELECT * FROM memo WHERE 1";
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
                OR company_id LIKE '%".$_POST['search']."%'
                OR to_department LIKE  '%".$_POST['search']."%'
                OR inquiry LIKE '%".$_POST['search']."%'
                OR suggestion LIKE '%".$_POST['search']."%'
                OR attachment LIKE '%".$_POST['search']."%'
                OR status LIKE '%".$_POST['search']."%' ";
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

    $sub_array = array();
    if($sno!="")
    {
        $sub_array[] = $sno;
    }

     //get company Name
    $company_name='';
    $qry = "SELECT * FROM branch_creation WHERE branch_id = '".$row['company_id']."' AND status=0 ORDER BY branch_id DESC"; 
    $res = $con->query($qry);
    while($row5 = $res->fetch_assoc())
    {
        $getname = "SELECT company_name FROM company_creation WHERE company_id = '".$row5['company_id']."' ";
        $res1 = $con->query($getname);
        while ($row52 = $res1->fetch_assoc()) {
            $company_name = $row52['company_name'];
        }
    }

    //get to department name
    $toDepartmentName=''; 
    $getqry3 = "SELECT * FROM department_creation WHERE department_id ='".strip_tags($row['to_department'])."' and status = 0";
    $res3 = $con->query($getqry3);
    while($row3 = $res3->fetch_assoc())
    {
        $toDepartmentName = $row3["department_name"];          
    }

    $sub_array[] = $company_name;
    $sub_array[] = $toDepartmentName;
    $sub_array[] = $row['inquiry']; 
    $sub_array[] = $row['suggestion'];  
    $sub_array[] = $row['attachment'];  
    
    $status      = $row['status'];
    if($status == 1)
	{
	    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	}
	else
	{
        $sub_array[] = "<span style='width: 144px;'><span class='kt-badge kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	}
	$id   = $row['memo_id'];
	
    // View option is commented
	// $action="<a href='memo_status&memoid=$id' title='Memo Status'><span class='icon-eye'></span></a>&nbsp;&nbsp;
    // <a href='memo&upd=$id' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp; 
	// <a href='memo&del=$id' title='Delete details' class='delete_memo'><span class='icon-trash-2'></span></a>";

    if($row['assign_employee'] == ''){
        $action="<a href='memo&upd=$id' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp;
        <a href='memo&del=$id' title='Delete details' class='delete_memo'><span class='icon-trash-2'></span></a>";
    }
    else if($row['assign_employee'] != '' && $row['date_of_completion'] == ''){
        $action="<button type='button' title='Memo Assign' class='btn btn-success'><span class=''> Assigned</span></button>";
    }
    else if($row['date_of_completion'] != ''){
        $action="<button type='button' title='Memo Update' class='btn btn-success'><span class=''> Updated</span></button>";
    }

	$sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM memo";
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