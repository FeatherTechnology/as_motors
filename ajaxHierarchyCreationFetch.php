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
    
    'hierarchy_id',
    'company_id',
    'department_id',
    'top_hierarchy',
    'sub_ordinate',
    'status'
);

$query = "SELECT * FROM hierarchy_creation where 1";
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
                
                OR hierarchy_id LIKE '%".$_POST['search']."%'
                OR company_id LIKE  '%".$_POST['search']."%'
                OR department_id LIKE '%".$_POST['search']."%'
                OR top_hierarchy LIKE '%".$_POST['search']."%'
                OR sub_ordinate LIKE  '%".$_POST['search']."%'
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
    
    $top_hierarchy = array();  
    $sub_ordinate = array();  
  
    if($sno!="")
    {
        $sub_array[] = $sno;
    }

    $company_name='';
    $qry = "SELECT * FROM branch_creation WHERE branch_id = '".$row['company_id']."' AND status=0 ORDER BY branch_id DESC"; 
    $res = $con->query($qry);
    while($row5 = $res->fetch_assoc())
    {
        $getname = "SELECT company_name FROM company_creation WHERE company_id = '".$row5['company_id']."' ";
        $res1 = $con->query($getname) ;
        while ($row52 = $res1->fetch_assoc()) {
            $company_name = $row52['company_name'];
        }
    }
    
    $department_name='';
    $departmentId = $row['department_id'];   
    $getqry = "SELECT department_name FROM department_creation WHERE department_id ='".strip_tags($departmentId)."' and status = 0";
    $res13 = $con->query($getqry);
    while($row13 = $res13->fetch_assoc())
    {
       $department_name = $row13["department_name"];        
    }

    $topHierarchy1 = explode(",", $row['top_hierarchy']);
    foreach($topHierarchy1 as $topHierarchy) {
        $topHierarchy = trim($topHierarchy);
        $getTopHierarchy = "SELECT designation_name FROM designation_creation WHERE designation_id ='".strip_tags($topHierarchy)."' and status = 0";
        $res14 = $con->query($getTopHierarchy);
        while($row14 = $res14->fetch_assoc())
        {
           $top_hierarchy[] = $row14["designation_name"];      
        }
    }

    $subOrdinate1 = explode(",", $row['sub_ordinate']);
    foreach($subOrdinate1 as $subOrdinate) {
        $subOrdinate = trim($subOrdinate);
        $getTopHierarchy = "SELECT designation_name FROM designation_creation WHERE designation_id ='".strip_tags($subOrdinate)."' and status = 0";
        $res15 = $con->query($getTopHierarchy);
        while($row15 = $res15->fetch_assoc())
        {
           $sub_ordinate[] = $row15["designation_name"];      
        }
    }
    
    // $sub_array[] = $row['type'];
    $sub_array[] = $company_name;
    $sub_array[] = $department_name;
    $sub_array[] = $top_hierarchy;
    $sub_array[] = $sub_ordinate;
    $status      = $row['status'];
    if($status == 1)
	{
	$sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	}
	else
	{
    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	}
	$id   = $row['hierarchy_id'];
	
	$action="<a href='hierarchy_creation&upd=$id' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp; 
	<a href='hierarchy_creation&del=$id' title='Delete details' class='delete_hierarchy_creation'><span class='icon-trash-2'></span></a>";

	$sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM hierarchy_creation";
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