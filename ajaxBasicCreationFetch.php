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

    'basic_creation_id',
    'department',
    'company_id',
    'designation',
    // 'department_code',
    // 'designation_code',
    'type',
    'report_to',
    'status'
);

$query = "SELECT * FROM basic_creation WHERE 1";
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
                OR basic_creation_id LIKE '%".$_POST['search']."%'
                OR company_id LIKE '%".$_POST['search']."%'
                OR designation LIKE '%".$_POST['search']."%'
                OR department LIKE  '%".$_POST['search']."%'
                OR type LIKE '%".$_POST['search']."%'
                OR report_to LIKE '%".$_POST['search']."%'
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
    $company_name = array();  
    $designation_name = array();  
  
    if($sno!="")
    {
        $sub_array[] = $sno;
    }

    $company_name='';
    $qry = "SELECT * FROM branch_creation WHERE branch_id = '".$row['company_id']."' AND status=0 ORDER BY branch_id DESC"; 
    $res = $con->query($qry);
    while($row5 = $res->fetch_assoc())
    {
        $branch_name = $row5['branch_name'];
        $getname = "SELECT company_name FROM company_creation WHERE company_id = '".$row5['company_id']."' ";
        $res1 = $con->query($getname) ;
        while ($row52 = $res1->fetch_assoc()) {
            $company_name = $row52['company_name'];
        }
    }

    $department_name='';
    $getDepartmentName = $row['department'];   
    $getqry = "SELECT department_name FROM department_creation WHERE department_id ='".strip_tags($getDepartmentName)."' and status = 0";
    $res12 = $con->query($getqry);
    while($row12 = $res12->fetch_assoc())
    {
       $department_name = $row12["department_name"];        
    }

    $designationName1 = explode(",", $row['designation']);
    foreach($designationName1 as $designationName) {
        $designationName = trim($designationName);
        $getqry1 = "SELECT designation_name FROM designation_creation WHERE designation_id ='".strip_tags($designationName)."' and status = 0";
        $res14 = $con->query($getqry1);
        while($row14 = $res14->fetch_assoc())
        {
           $designation_name[] = $row14["designation_name"];      
        }
    }
    
    $reportName = $row['report_to'];
    if ($reportName != 0) {

        $getqry1 = "SELECT designation_name FROM designation_creation WHERE designation_id ='" . strip_tags($reportName) . "' and status = 0";
        $res15 = $con->query($getqry1);
        $row15 = $res15->fetch_assoc();
        $report_to_name = $row15["designation_name"];
    }else{
        $report_to_name = '';
    }
        
    // $sub_array[] = $row['type'];
    $sub_array[] = $company_name;
    $sub_array[] = $branch_name;
    $sub_array[] = $department_name;
    $sub_array[] = $designation_name;
    // $sub_array[] = $row['department_code'];
    // $sub_array[] = $row['designation_code'];
    $sub_array[] = $report_to_name;
    $status      = $row['status'];
    if($status == 1)
	{
	$sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span></span>";
	}
	else
	{
    $sub_array[] = "<span style='width: 144px;'><span class='kt-badge  kt-badge--success kt-badge--inline kt-badge--pill'>Active</span></span>";
	}
	$id   = $row['basic_creation_id'];
	
	$action="<a href='basic_creation&upd=$id' title='Edit details'><span class='icon-border_color'></span></a>&nbsp;&nbsp; 
	<a href='basic_creation&del=$id' title='Delete details' class='delete_basic_creation'><span class='icon-trash-2'></span></a>";

	$sub_array[] = $action;
    $data[]      = $sub_array;
    $sno = $sno + 1;
}

function count_all_data($connect)
{
    $query     = "SELECT * FROM basic_creation";
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