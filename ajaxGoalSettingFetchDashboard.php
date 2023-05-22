<?php
include('ajaxconfig.php');
@session_start();

if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
}

$column = array(
    'c.company_name',
    'department_name',
    'designation_name',
    'year',
    'status'
);

$query = "SELECT  gs.goal_setting_id,gs.company_name,c.company_name,gs.department,dc.department_name,gs.role,ds.designation_name,gs.year,y.year,gs.status FROM goal_setting gs 
LEFT JOIN company_creation c ON c.company_id=gs.company_name 
LEFT JOIN department_creation dc ON dc.department_id=gs.department 
LEFT JOIN designation_creation ds ON ds.designation_id=gs.role 
LEFT JOIN year_creation y ON y.year_id=gs.year
 WHERE 1";

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
            
            OR c.company_name LIKE  '%".$_POST['search']."%'
            OR dc.department_name LIKE '%".$_POST['search']."%'
            OR ds.designation_name LIKE '%".$_POST['search']."%'
            OR y.year LIKE '%".$_POST['search']."%'
            OR gs.status LIKE '%".$_POST['search']."%'";
           
        }
    }
}

if (isset($_POST['order'])) {
    $query .= ' ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
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
    $sub_array[] = $row['department_name'];
    $sub_array[] = $row['designation_name'];
    $sub_array[] = $row['year'];
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
    $query     = "SELECT  gs.goal_setting_id,gs.company_name,c.company_name,gs.department,dc.department_name,gs.role,ds.designation_name,gs.year,y.year,gs.status FROM goal_setting gs 
    LEFT JOIN company_creation c ON c.company_id=gs.company_name 
    LEFT JOIN department_creation dc ON dc.department_id=gs.department 
    LEFT JOIN designation_creation ds ON ds.designation_id=gs.role 
    LEFT JOIN year_creation y ON y.year_id=gs.year";
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





